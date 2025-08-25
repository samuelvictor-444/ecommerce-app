<?php

header( "Content-Type: application/json");

require_once "./includes/dbh.inc.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    if (isset($_GET["category"])) {
        $category = $_GET["category"];

        try {

            $query = "SELECT ca.attribute_id, a.name AS attribute_name , a.slug AS attribute_slug 
            FROM category_attributes ca
            JOIN attributes a ON ca.attribute_id = a.id
            WHERE ca.category_slug = :slug";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":slug", $category);
            $stmt->execute();

            $attributes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $results = [];

            foreach ($attributes as $attribute) {
                $attributeId = $attribute["attribute_id"];

                // Get all values for this attribute
                $valueStmt = $pdo->prepare("
                SELECT id, value 
                FROM attribute_values 
                WHERE attribute_id = :attrId
            ");
                $valueStmt->bindParam(":attrId", $attributeId);
                $valueStmt->execute();
                $values = $valueStmt->fetchAll(PDO::FETCH_ASSOC);

                $results[] = [
                    "attribute_name" => $attribute["attribute_name"],
                    "attribute_slug" => $attribute["attribute_slug"],
                    "values" => $values
                ];
            }

            echo json_encode($results);
            exit;

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }



} else {
    http_response_code(405);
    echo json_encode(['error' => "Method not allowed"]);
    exit;
}