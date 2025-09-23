<?php
// payment_failed.php
$reason = $_GET['reason'] ?? 'unknown';
$reasonMessages = [
    'no_reference'     => 'No payment reference provided.',
    'curl_error'       => 'There was a network error while verifying your payment.',
    'invalid_response' => 'Invalid response received from payment gateway.',
    'db_error'         => 'A database error occurred while processing your payment.',
    'no_order_id'      => 'No order ID found for this transaction.',
    'unpaid_order'     => 'This order has not been paid.',
    'unknown'          => 'Your payment could not be processed.'
];

$message = $reasonMessages[$reason] ?? 'Your payment could not be processed.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Failed</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .failed-card {
      max-width: 600px;
      margin: 80px auto;
      text-align: center;
      padding: 40px;
      border-radius: 20px;
      background: #fff;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .failed-icon {
      font-size: 80px;
      color: #dc3545;
      animation: shake 0.5s ease;
    }
    @keyframes shake {
      0% { transform: translateX(0); }
      25% { transform: translateX(-10px); }
      50% { transform: translateX(10px); }
      75% { transform: translateX(-10px); }
      100% { transform: translateX(0); }
    }
  </style>
</head>
<body>
  <div class="failed-card">
    <div class="failed-icon">❌</div>
    <h2 class="mt-3 text-danger">Payment Failed</h2>
    <p><?php echo htmlspecialchars($message); ?></p>

    <div class="mt-4">
      <a href="../index.php" class="btn btn-primary">Continue Shopping</a>
      <a href="../contact.php" class="btn btn-outline-secondary">Contact Support</a>
    </div>
  </div>
</body>
</html>
