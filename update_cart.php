<?php
// update_cart.php - Xử lý thao tác cập nhật/xóa giỏ hàng
session_start();

// Kiểm tra xem giỏ hàng đã tồn tại chưa
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? null;
$product_id = $_GET['product_id'] ?? null;

// Chuyển hướng nếu không có ID sản phẩm
if (!$product_id) {
    header('Location: cart.php');
    exit;
}

// 1. Xử lý hành động XÓA (remove)
if ($action === 'remove') {
    // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng không
    if (isset($_SESSION['cart'][$product_id])) {
        // Xóa sản phẩm khỏi mảng giỏ hàng
        unset($_SESSION['cart'][$product_id]);
        $message = "Đã xóa sản phẩm ID: " . htmlspecialchars($product_id) . " khỏi giỏ hàng.";
    } else {
        $message = "Sản phẩm không có trong giỏ hàng.";
    }
} 
// (Bạn có thể thêm logic cho hành động 'update' số lượng tại đây)

// Thiết lập thông báo (tùy chọn) và chuyển hướng người dùng trở lại trang giỏ hàng
$_SESSION['message'] = $message ?? 'Không có thao tác nào được thực hiện.';

header('Location: cart.php');
exit;
?>