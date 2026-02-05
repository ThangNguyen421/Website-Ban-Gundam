<?php
$rootPath = __DIR__ . '/../..'; 
require_once __DIR__ . '/../check_admin.php'; 
require_once $rootPath . '/core/database.php';
require_once $rootPath . '/core/functions.php';
require_once $rootPath . '/models/ProductModel.php';

$productModel = new ProductModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $productId = (int)$_POST['id'];
    $productToDelete = $productModel->deleteProduct($productId);

    if ($productToDelete) {
        $mainImagePath = $productToDelete['URLAnhChinh'];
        if (file_exists($mainImagePath) && !empty($productToDelete['URLAnhChinh'])) {
            unlink($mainImagePath);
        }
        $msg = "Xóa sản phẩm ID $productId thành công.";
        $messageType = 'success';
    } else {
        $msg = "Lỗi: Không thể xóa sản phẩm ID $productId hoặc sản phẩm không tồn tại.";
        $messageType = 'danger';
    }
} else {
    $msg = "Yêu cầu xóa không hợp lệ.";
    $messageType = 'danger';
}

header('Location: list.php?msg=' . urlencode($msg) . '&type=' . $messageType);
exit();

?>
