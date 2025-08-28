<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
require_once "./includes/dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(['error' => "Method not allowed"]);
    exit;
}

if (!isset($_GET["category"])) {
    http_response_code(400);
    echo json_encode(['error' => "Missing category"]);
    exit;
}

$category = trim($_GET["category"]);
$sortOpt = trim($_GET["sort"] ?? "popularity");
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
$page_limit = 40;
$offset = ($page - 1) * $page_limit;

// Sorting options
$allowedSorts = [
    "popularity" => "products.views DESC",
    "new_arrival" => "products.created_at DESC",
    "lowToHigh" => "products.price ASC",
    "highToLow" => "products.price DESC",
    "product_rating" => "products.rating DESC"
];
$orderBy = $allowedSorts[$sortOpt] ?? $allowedSorts['popularity'];

try {
    // Check how many products have views > 0
    $checkViewsStmt = $pdo->prepare("
        SELECT COUNT(*) FROM products
        JOIN subCategories ON products.subcategory_id = subCategories.id
        JOIN categories ON subCategories.category_id = categories.id
        WHERE categories.slug = :category AND products.visibility = 1 AND products.views > 0
    ");
    $checkViewsStmt->bindParam(":category", $category);
    $checkViewsStmt->execute();
    $productsWithViews = $checkViewsStmt->fetchColumn();
    $useFallBack = $productsWithViews == 0;
    $viewFilter = $useFallBack ? "" : "AND products.views > 0";

    // Count all visible products
    $countStmt = $pdo->prepare("
        SELECT COUNT(*) FROM products
        JOIN subCategories ON products.subcategory_id = subCategories.id
        JOIN categories ON subCategories.category_id = categories.id
        WHERE categories.slug = :category AND products.visibility = 1 $viewFilter
    ");
    $countStmt->bindParam(':category', $category, PDO::PARAM_STR);
    $countStmt->execute();
    $totalProducts = $countStmt->fetchColumn();
    $totalPages = ceil($totalProducts / $page_limit);

    // Fetch product list
    $productQuery = "
        SELECT products.id, products.slug, products.name, products.price, products.old_price,
               products.rating, products.image, products.views,
               EXISTS (
                   SELECT 1 FROM product_attribute_values
                   WHERE product_attribute_values.product_slug = products.slug
                   LIMIT 1
               ) AS has_variation
        FROM products
        JOIN subCategories ON products.subcategory_id = subCategories.id
        JOIN categories ON subCategories.category_id = categories.id
        WHERE categories.slug = :category AND products.visibility = 1
    ";
    if (!$useFallBack) $productQuery .= " AND products.views > 0";
    $productQuery .= " ORDER BY $orderBy LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($productQuery);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->bindParam(':limit', $page_limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "products" => $products,
        "pagination" => [
            "currentPage" => $page,
            "totalPages" => $totalPages,
            "totalProducts" => $totalProducts
        ],
        "fallback" => $useFallBack,
        "success" => true,
    ]);
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => "Database error: " . $e->getMessage()]);
    exit;
}
