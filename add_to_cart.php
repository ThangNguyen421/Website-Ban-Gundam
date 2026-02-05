<?php
session_start();
header('Content-Type: application/json');

require_once 'core/database.php';
require_once 'models/ProductModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$product_id = $_POST['product_id'] ?? null;
$quantity = (int)($_POST['quantity'] ?? 1); 

if (!$product_id || $quantity <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm hoặc số lượng không hợp lệ']);
    exit;
}

try {

    $productModel = new ProductModel($pdo); 
    $product = $productModel->getProductById($product_id);

    if (!$product || ($product['TrangThai'] ?? '') !== 'active' || ($product['TonKho'] ?? 0) <= 0) {
        echo json_encode(['success' => false, 'message' => 'Sản phẩm không khả dụng hoặc đã hết hàng']);
        exit;
    }

    $available_stock = $product['TonKho'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $current_quantity = $_SESSION['cart'][$product_id]['quantity'] ?? 0;
    $new_total_quantity = $current_quantity + $quantity;

    if ($new_total_quantity > $available_stock) {
        echo json_encode([
            'success' => false,
            'message' => "Chỉ còn {$available_stock} sản phẩm trong kho. Bạn đã có {$current_quantity} sản phẩm này trong giỏ."
        ]);
        exit;
    }

    $_SESSION['cart'][$product_id] = [
        'name' => $product['TenSanPham'],
        'price' => $product['GiaBan'],
        'image' => $product['URLAnhChinh'],
        'quantity' => $new_total_quantity, 
        'stock' => $available_stock
    ];

    $cart_count = count($_SESSION['cart']);

    echo json_encode([
        'success' => true,
        'message' => 'Đã thêm vào giỏ hàng thành công',
        'cart_count' => $cart_count
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    error_log("Cart Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra trong quá trình xử lý: ' . $e->getMessage()]);
}

?>
