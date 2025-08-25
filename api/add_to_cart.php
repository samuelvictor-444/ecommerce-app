<?php 

header("Content-Type: application/json");

require_once "./includes/dbh.inc.php";

echo json_encode(["success" => true , "message" => "product added successfully"]);