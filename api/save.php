<?php 

require_once './includes/dbh.inc.php';

function slugify($string) {
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9]+/i', '-', $string);
    return trim($string, '-');
}

try {
    $stmt = $pdo->query("SELECT id, name FROM products");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $slug = slugify($row['name']);
        
        // Ensure uniqueness by appending ID if needed
        $slug .= '-' . $row['id'];

        $update = $pdo->prepare("UPDATE products SET slug = :slug WHERE id = :id");
        $update->execute([
            ":slug" => $slug,
            ":id" => $row['id']
        ]);
    }

    echo "Slugs generated and saved successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
