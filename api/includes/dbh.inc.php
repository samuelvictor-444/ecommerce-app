<?php


$host = "localhost";
$dbname = "Online_Store";
$dbuser = "root";
$dbpassword = "";

header("Content-Type: application/json");

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $dbuser,
        $dbpassword
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "DB Connection failed: " . $e->getMessage()
    ]);
    exit;
}


