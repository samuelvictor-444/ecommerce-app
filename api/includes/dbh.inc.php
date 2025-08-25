<?php 


$host  = "localhost";
$dbname = "Online_Store";
$dbuser = "root";
$dbpassword = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;" , $dbuser , $dbpassword );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "connection failed". $e->getMessage();
}

