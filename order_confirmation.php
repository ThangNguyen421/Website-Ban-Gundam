<?php

session_start();


if (!isset($_SESSION['cart']) || empty($_SESSION['cart']) || !isset($_SESSION['order_data'])) {
    header('Location: index.php'); 
    exit;
}

$order_data = $_SESSION['order_data'];
$cart_items = $_SESSION['cart'];


$rootPath = __DIR__ . '/..';
require_once $rootPath . '/core/public/database.php';
require_once $rootPath . '/models/OrderModel.php';

$orderModel = new OrderModel($pdo);
$MaDonHangMoi = false;
$success = false;

try {
    $pdo->beginTransaction(); 

    $TongGia = $order_data['TongGia']; 
    
    $MaDonHangMoi = $orderModel->createOrder($order_data, $TongGia);

    if ($MaDonHangMoi) {
        
        $detailsSuccess = $orderModel->createOrderDetails($MaDonHangMoi, $cart_items);

        if ($detailsSuccess) {
            $pdo->commit();
            $success = true;
        } else {
 
            $pdo->rollBack();
            $error_message = 'Lỗi: Không thể lưu chi tiết sản phẩm.';
        }

    } else {
 
        $pdo->rollBack();
        $error_message = 'Lỗi: Không thể tạo đơn hàng chính.';
    }

} catch (Exception $e) {
    $pdo->rollBack();
    $error_message = 'Lỗi hệ thống: ' . $e->getMessage();
}

if ($success) {
    unset($_SESSION['cart']); 
    unset($_SESSION['order_data']);
    header('Location: thank_you.php?order_id=' . $MaDonHangMoi);
    exit;
} else {
    header('Location: checkout.php?error=' . urlencode($error_message));
    exit;

}
