<?php

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    require_once "./includes/dbh.inc.php";

    $cart = json_decode(file_get_contents("php://input"), true);

    if (!$cart || count($cart) === 0) {
        echo json_encode([]);
        exit;
    }

    $results = [];

    // loop through the cart
    foreach ($cart as $item) {
        $slug = $item['slug'];
        $attrId = $item['attribute_value_id'] ?? null;
        $qty = (int) ($item['quantity']) ?? 1;
        $key = $item['key'] ?? null;

        if (!$slug)
            continue;

        // get product details

        $query = "SELECT id, name, price, old_price, image FROM products WHERE slug = :slug";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":slug", $slug);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // If variation is selected
            if (!empty($attrId)) {
                $queryVar = " SELECT av.value, a.name AS attribute_name
    FROM product_attribute_values pav
    JOIN attribute_values av ON pav.attribute_value_id = av.id
    JOIN attributes a ON av.attribute_id = a.id
    WHERE pav.attribute_value_id = :attribute_value_id 
      AND pav.product_slug = :product_slug
";

                $stmtVar = $pdo->prepare($queryVar);
                $stmtVar->bindParam(":attribute_value_id", $attrId);
                $stmtVar->bindParam(":product_slug", $slug);

                $stmtVar->execute();

                $var = $stmtVar->fetch(PDO::FETCH_ASSOC);


                if ($var) {
                    $product['variation'] = $var['value'];
                    $product['variation_name'] = $var['attribute_name'];
                }

            }


            $results[] = [
                "key" => $key,
                "id" => $product["id"],
                "attrId" => $attrId,
                "slug" => $slug,
                "name" => $product['name'],
                "image" => $product['image'],
                "price" => (float) $product['price'],
                "oldPrice" => (float) $product['old_price'],
                "variationName" => $product['variation_name'] ?? null,
                "variation" => $product['variation'] ?? null,
                "quantity" => $qty
            ];
        }
    }

    echo json_encode($results);
    exit;


} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "method not allowed"]);
    exit;
}


