<?php

require_once "./config_session.php";
require_once "./includes/dbh.inc.php";

ini_set('display_errors', 0); // disable display
ini_set('log_errors', 1);     // enable logging
error_reporting(E_ALL);



header('Content-Type: application/json');

$logFile =  __DIR__ . "/logs/payment_errors.log";
if (!file_exists(dirname($logFile))) {
    mkdir(dirname($logFile), 0755, true);
}

function logError($errorMgs, $context = [])
{
    $time = date("Y-m-d H:i:s");
    $userId = $context['user_id'] ?? ($_SESSION['user_id'] ?? 'guest');
    $cart = isset($context['cart']) ? json_encode($context['cart']) : 'N/A';

    $logEntry = "[$time] [Payment Error] User: $userId | Cart: $cart | Error: $errorMgs" . PHP_EOL;

    // Write to separate log file
    $logFile = __DIR__ . '/logs/payment_errors.log';
    error_log($logEntry, 3, $logFile);
}

function sendError($errorMgs, $context = [])
{
    if (ob_get_length()) ob_clean();

    // Log the error with optional context
    logError($errorMgs, $context);

    // Send JSON response
    $message = ["success" => false, "message" => $errorMgs];
    echo json_encode($message);
    exit;
}

function sendSuccess($data)
{
    if (ob_get_length()) ob_clean();

    $message = array_merge(["success" => true], $data);
    echo json_encode($message);
    exit;
}

if ($_SERVER['HTTP_HOST'] !== 'localhost' && (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on')) {
    $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirect");
    exit();
}



if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (is_logged_in()) {

        if ($_SESSION["otp_verified"] === true) {
            $input = json_decode(file_get_contents("php://input"), true);

            $cart = $input["cart"] ?? [];

            // Example inside your try/catch or validations:
            if (!is_array($cart) || empty($cart)) {
                sendError("Cart is empty", ['user_id' => $_SESSION['user_id'] ?? null, 'cart' => $cart]);
            }


            $totalAmount = 0.0;


            try {
                $pdo->beginTransaction();

                // 1. create user order
                $userId =  $_SESSION['user_id'];
                $orderQuery = "INSERT INTO orders (user_id, total_amount, status, paystack_ref, created_at, updated_at) 
            VALUES (:user_id, 0, 'pending', NULL, NOW(), NULL)";



                $orderStmt = $pdo->prepare($orderQuery);
                $orderStmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                $orderStmt->execute();
                $orderId = $pdo->lastInsertId();


                // 2. Loop through cart
                foreach ($cart as $item) {
                    $productName = $item['name'] ?? null;
                    $slug = $item['slug'] ?? null;
                    $qty  = intval($item['quantity'] ?? 0);
                    $attributeValueId = isset($item['attribute_value_id']) ? intval($item['attribute_value_id']) : null;
                    if (!isset($item['slug']) || !is_string($item['slug']) || trim($item['slug']) === '') {
                        sendError(
                            "Invalid product slug in cart",
                            [
                                'user_id' => $_SESSION['user_id'] ?? null,
                                'cart_item' => $item
                            ]
                        );
                    }

                    if ($qty <= 0) {
                        sendError(
                            "Invalid quantity for product: " . $productName,
                            [
                                'user_id' => $_SESSION['user_id'] ?? null,
                                'cart_item' => $item
                            ]
                        );
                    }

                    if (!isset($item['quantity']) || !is_numeric($item['quantity']) || intval($item['quantity']) <= 0) {
                        sendError(
                            "Invalid quantity for product: " . $productName,
                            [
                                'user_id' => $_SESSION['user_id'] ?? null,
                                'cart_item' => $item
                            ]
                        );
                    }



                    // Fetch product
                    $fetchQuery = "SELECT id, price FROM products WHERE slug = :slug";
                    $fetchStmt = $pdo->prepare($fetchQuery);
                    $fetchStmt->bindParam(":slug", $slug);
                    $fetchStmt->execute();
                    $product  = $fetchStmt->fetch(PDO::FETCH_ASSOC);

                    if (!$product) continue;

                    $productId = $product['id'];
                    $price = $product['price'];
                    $subtotal = $qty * $price;
                    $totalAmount += $subtotal;

                    $stmt = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, qty, price, subtotal)
            VALUES (:order_id, :product_id, :qty, :price, :subtotal)
        ");

                    $stmt->execute([
                        ':order_id' => $orderId,
                        ':product_id' => $productId,
                        ':qty' => $qty,
                        ':price' => $price,
                        ':subtotal' => $subtotal
                    ]);
                    $orderItemId = $pdo->lastInsertId();


                    if (!empty($attributeValueId)) {
                        // Validate variation belongs to product
                        $stmt = $pdo->prepare("SELECT 1 FROM product_attribute_values WHERE product_slug  = :product_slug  AND attribute_value_id = :attribute_value_id ");
                        $stmt->bindParam(":product_slug", $slug);
                        $stmt->bindParam(":attribute_value_id", $attributeValueId);
                        $stmt->execute();

                        // Insert into order_item_attributes
                        if ($stmt->fetch()) {
                            $stmt = $pdo->prepare("INSERT INTO order_item_attributes (order_item_id, attribute_value_id) VALUES (:order_item_id, :attribute_value_id)");
                            $stmt->bindParam(":order_item_id", $orderItemId);
                            $stmt->bindParam(":attribute_value_id", $attributeValueId);
                            $stmt->execute();
                        }
                    }
                } // ends foreach loop


                // 3. Update order total
                $stmt = $pdo->prepare("UPDATE orders SET total_amount = :total_amount, updated_at = NOW() WHERE id = :order_id");
                $stmt->execute([":total_amount" => $totalAmount, ":order_id" => $orderId]);



                // 4. Initialize Payment
                $paystackRef = uniqid("order_" . $orderId . "_");
                $paystackSecret = PAYSTACK_SECRET_KEY;
              #  $callbackUrl = "https://" . $_SERVER["HTTP_HOST"] . "/api/verify_payment.php";
                $callbackUrl = "https://usman_clothing_servicehttps://abaprice.rf.gd/?i=1/api/verify_payment.php";
                $userEmail = $_SESSION["user_email"];

                $postData = [
                    "email" => $userEmail,
                    "amount" => intval($totalAmount * 100),
                    "reference" => $paystackRef,
                    "callback_url" => $callbackUrl
                ];

                $maxRetries = 3;
                $attempt = 0;
                $success = false;
                $response = null;
                $errorNo = 0;
                $errorMsg = '';

                while ($attempt < $maxRetries && !$success) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/initialize");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        "Authorization: Bearer $paystackSecret",
                        "Content-Type: application/json"
                    ]);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

                    $response = curl_exec($ch);
                    $errorNo  = curl_errno($ch);
                    $errorMsg = curl_error($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    if ($response !== false && $httpCode === 200) {
                        $result = json_decode($response, true);
                        if ($result && isset($result["status"]) && $result["status"] === true && isset($result['data']['authorization_url'])) {
                            $success = true; // Success, exit loop
                            break;
                        } else {
                            // Fail safely, do not rollback here
                            $attempt++;
                            if ($attempt >= $maxRetries) {
                                $pdo->rollBack();
                                sendError(
                                    "Paystack initialization failed",
                                    ['user_id' => $_SESSION['user_id'] ?? null, 'cart' => $cart ?? null, 'response' => $response]
                                );
                            }
                            sleep(1); // small wait before retry
                        }
                    } elseif ($errorNo === CURLE_OPERATION_TIMEDOUT) {
                        $attempt++;
                        if ($attempt >= $maxRetries) {
                            $pdo->rollBack();
                            sendError(
                                "Paystack request timed out after $maxRetries attempts",
                                ['user_id' => $_SESSION['user_id'] ?? null, 'cart' => $cart ?? null]
                            );
                        }
                        sleep(1); // small wait before retry
                    } else {
                        // Fatal cURL error, stop retries
                        $pdo->rollBack();
                        sendError(
                            "Paystack cURL error: $errorMsg (code: $errorNo)",
                            ['user_id' => $_SESSION['user_id'] ?? null, 'cart' => $cart ?? null]
                        );
                    }
                }

                // After loop, $result should be valid
                if (!$success) {
                    $pdo->rollBack();
                    sendError(
                        "Paystack initialization failed after $maxRetries attempts",
                        ['user_id' => $_SESSION['user_id'] ?? null, 'cart' => $cart ?? null]
                    );
                }


                // Save paystack_ref to order
                $stmt = $pdo->prepare("UPDATE orders SET paystack_ref = :ref, payment_status = 'pending', updated_at = NOW() WHERE id = :order_id");
                $stmt->execute([
                    ':ref' => $paystackRef,
                    ':order_id' => $orderId
                ]);


                $pdo->commit();

                // 5. Return success with Paystack payment URL
                sendSuccess([
                    "order_id" => $orderId,
                    "total_amount" => $totalAmount,
                    "payment_url" => $result["data"]["authorization_url"],
                    "paystack_ref" => $paystackRef
                ]);
            } catch (Exception  $e) {
                $pdo->rollBack();
                sendError(
                    "Error: " . $e->getMessage(),
                    ['user_id' => $_SESSION['user_id'] ?? null, 'cart' => $cart ?? null]
                );
            }
        } else {
            sendError(
                "OTP not verified",
                ['user_id' => $_SESSION['user_id'] ?? null]
            );
        }
    } else {
        http_response_code(401);
        echo json_encode(["success" => false, "message" => "User not logged in"]);
        exit;
    }
} else {


    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        // AJAX request → JSON response
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "Method not allowed"]);
    } else {
        // Normal request → redirect to homepage
        http_response_code(302); // temporary redirect
        header("Location: ../index.php");
    }



    exit;
}
