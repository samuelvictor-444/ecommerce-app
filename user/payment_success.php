<?php
require_once "../api/config_session.php";
require_once "../api/includes/dbh.inc.php";

if (!isset($_GET['order_id'])) {
    header("Location: /");
    exit;
}



$orderId = intval($_GET['order_id']);
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :order_id LIMIT 1");
$stmt->execute([':order_id' => $orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order || $order['payment_status'] !== 'paid') {
    header("Location: /payment_failed.php?reason=unpaid_order");
    exit;
}

// Fetch order items
$stmtItems = $pdo->prepare("SELECT oi.*, p.name FROM order_items oi 
                            JOIN products p ON p.id = oi.product_id
                            WHERE order_id = :order_id");
$stmtItems->execute([':order_id' => $orderId]);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Successful</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .success-card {
      max-width: 600px;
      margin: 80px auto;
      text-align: center;
      padding: 40px;
      border-radius: 20px;
      background: #fff;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .success-icon {
      font-size: 80px;
      color: #28a745;
      animation: pop 0.6s ease;
    }
    @keyframes pop {
      0% { transform: scale(0); }
      70% { transform: scale(1.2); }
      100% { transform: scale(1); }
    }
    .order-items {
      text-align: left;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="success-card">
    <div class="success-icon">✔️</div>
    <h2 class="mt-3 text-success">Payment Successful</h2>
    <p>Your payment for <strong>Order #<?php echo htmlspecialchars($orderId); ?></strong> has been received.</p>
    <p><strong>Total Paid:</strong> ₦<?php echo number_format($order['total_amount'], 2); ?></p>
    <p><strong>Payment Reference:</strong> <?php echo htmlspecialchars($order['paystack_ref']); ?></p>

    <?php if ($items): ?>
    <div class="order-items">
      <h5>Order Items:</h5>
      <ul class="list-group">
        <?php foreach ($items as $item): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo htmlspecialchars($item['qty'] . " x " . $item['name']); ?>
            <span>₦<?php echo number_format($item['subtotal'], 2); ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

    <div class="mt-4">
      <a href="/track_order.php?order_id=<?php echo $orderId; ?>" class="btn btn-success">Track Your Order</a>
      <a href="/shop.php" class="btn btn-outline-secondary">Continue Shopping</a>
    </div>
  </div>
</body>
</html>
