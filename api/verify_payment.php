<?php
require_once "./config_session.php";
require_once "./includes/dbh.inc.php";
require_once "./includes/send_email.php";

ini_set('display_errors', 0); // disable display
ini_set('log_errors', 1);     // enable logging
error_reporting(E_ALL);

// --- Check reference ---
if (!isset($_GET['reference'])) {
    header("Location: ../user/payment_failed.php?reason=no_reference");
    exit;
}

$reference      = $_GET['reference'];
$paystackSecret = PAYSTACK_SECRET_KEY;

// --- Verify payment with Paystack ---
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/verify/" . urlencode($reference));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $paystackSecret"
]);
$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if ($err) {
    header("Location: ../user/payment_failed.php?reason=curl_error");
    exit;
}

$result = json_decode($response, true);

if (!$result || !isset($result["status"]) || $result["status"] !== true) {
    header("Location: ../user/payment_failed.php?reason=invalid_response");
    exit;
}

$data = $result["data"];

if ($data["status"] !== "success") {
    header("Location: ../user/payment_failed.php?reason=" . urlencode($data["status"]));
    exit;
}

$orderId    = $data["metadata"]["order_id"] ?? null;
$userId     = $data["metadata"]["user_id"] ?? null;
$amount     = $data["amount"] / 100;
$paidAt     = $data["paid_at"];
$paystackRef = $data["reference"];

if (!$orderId || !$userId) {
    header("Location: ../user/payment_failed.php?reason=no_order_id");
    exit;
}

// --- Update database with transaction ---
try {
    $pdo->beginTransaction();

    // Update orders table
    $stmt = $pdo->prepare("
        UPDATE orders 
        SET payment_status = 'paid', status = 'paid', paystack_ref = :ref, updated_at = NOW()
        WHERE id = :order_id
    ");
    $stmt->execute([
        ":ref" => $paystackRef,
        ":order_id" => $orderId
    ]);

    // Insert into payments table
    $stmt = $pdo->prepare("
        INSERT INTO payments (order_id, paystack_ref, amount, status, paid_at, created_at) 
        VALUES (:order_id, :ref, :amount, :status, :paid_at, NOW())
        ON DUPLICATE KEY UPDATE status = VALUES(status), paid_at = VALUES(paid_at)
    ");
    $stmt->execute([
        ":order_id" => $orderId,
        ":ref"      => $paystackRef,
        ":amount"   => $amount,
        ":status"   => "success",
        ":paid_at"  => $paidAt
    ]);

    $pdo->commit();

    // --- Send order confirmation email ---
    $emailSent = sendOrderConfirmationEmail($orderId) ? 1 : 0;

    // --- Redirect to success page ---
    header("Location: ../user/payment_success.php?order_id=" . urlencode($orderId) . "&email_sent=" . (int)$emailSent);
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    error_log("DB Error: " . $e->getMessage());
    echo "Database error occurred: " . $e->getMessage();
    exit;
}

// --- Function to send order confirmation ---
function sendOrderConfirmationEmail($orderId): bool
{
    global $pdo;

    // Get order + user info
    $stmt = $pdo->prepare("
        SELECT o.*, u.email, u.firstName, u.lastName 
        FROM orders o 
        JOIN users u ON o.user_id = u.id 
        WHERE o.id = :order_id LIMIT 1
    ");
    $stmt->execute([':order_id' => $orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$order) return false;

    // Get order items
    $stmt = $pdo->prepare("
        SELECT oi.*, p.name, p.image 
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = :order_id
    ");
    $stmt->execute([':order_id' => $orderId]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $orderItemsHtml = '';
    foreach ($items as $item) {
        $imageUrl = $item['image'] ? "https://abaprice.rf.gd/" . $item['image'] : 'https://via.placeholder.com/60';
        $orderItemsHtml .= "
        <tr>
            <td><img src='" . htmlspecialchars($imageUrl) . "' width='100' style='border-radius:5px; padding:4px;'></td>
            <td style='word-wrap: break-word;'>" . htmlspecialchars($item['name']) . "</td>
            <td>{$item['qty']}</td>
            <td>₦" . number_format($item['price'], 2) . "</td>
            <td>₦" . number_format($item['subtotal'], 2) . "</td>
        </tr>";
    }


    $userName = $order['firstName'] . " " . $order['lastName'];
    $userEmail = $order['email'];

    if (empty($userEmail)) {
        error_log("Email missing for Order #$orderId");
        return false;
    }

    $templatePath = realpath("../user/order_confirmation_template.html");
    if (!$templatePath || !file_exists($templatePath)) {
        error_log("Template file not found at ../user/order_confirmation_template.html");
        return false;
    }

    $htmlContent = file_get_contents($templatePath);
    if (!$htmlContent) {
        error_log("Failed to read template content at $templatePath");
        return false;
    }

    $htmlContent = str_replace(
        ['{{CustomerName}}', '{{CustomerEmail}}', '{{OrderID}}', '{{TotalAmount}}', '{{OrderItems}}'],
        [htmlspecialchars($userName), $userEmail, $orderId, '₦' . number_format($order['total_amount'], 2), $orderItemsHtml],
        $htmlContent
    );

    $sent = sendEmail($userEmail, $userName, "Order Confirmation - Order #$orderId", $htmlContent);

    if (!$sent) {
        error_log("Failed to send order confirmation email for Order #$orderId to $userEmail");
    } else {
        error_log("Order confirmation email sent for Order #$orderId to $userEmail");
    }

    return $sent;
}
