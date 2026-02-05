<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? null;
$product_id = $_GET['product_id'] ?? null;

if (!$product_id) {
    header('Location: cart.php');
    exit;
}

if ($action === 'remove') {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        $message = "Đã xóa sản phẩm ID: " . htmlspecialchars($product_id) . " khỏi giỏ hàng.";
    } else {
        $message = "Sản phẩm không có trong giỏ hàng.";
    }
} 

$_SESSION['message'] = $message ?? 'Không có thao tác nào được thực hiện.';

header('Location: cart.php');
exit;

?>
