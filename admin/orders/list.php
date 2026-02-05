<?php
$rootPath = __DIR__ . '/../..';
require_once __DIR__ . '/../check_admin.php';
require_once $rootPath . '/core/database.php';
require_once $rootPath . '/models/OrderModel.php';
require_once $rootPath . '/core/functions.php'; 

$orderModel = new OrderModel($pdo);
$orders = $orderModel->getAllOrders();

$message = $_GET['msg'] ?? null;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <a href="../index.php" class="btn btn-warning mb-3">
            <i class="fas fa-arrow-left"></i> Quay lại Dashboard Admin
        </a>
        <h2>Danh sách Đơn hàng</h2>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <table class="table table-striped table-hover mt-4">
            <thead>
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <th>Tên Khách</th>
                    <th>Email Khách</th>
                    <th>Tổng Giá</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Đặt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Chưa có đơn hàng nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order):
                        $customerName = !empty($order['TenKhachHang']) ? $order['TenKhachHang'] : ($order['HoTen'] ?? 'N/A');
                        $customerEmail = !empty($order['EmailKhachHang']) ? $order['EmailKhachHang'] : ($order['EmailNguoiDung'] ?? 'N/A');
                    ?>
                        <tr>
                            <td><?php echo $order['MaDonHang']; ?></td>
                            <td>
                                <?php echo htmlspecialchars($customerName); ?>
                                <?php if (empty($order['MaNguoiDung'])): ?>
                                    <span class="badge bg-secondary">Guest</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($customerEmail); ?></td>
                            <td><?php echo number_format($order['TongGia'], 0, ',', '.'); ?> đ</td>
                            <td>
                                <span class="badge 
                                    <?php
                                    $status = strtolower($order['TrangThai']);
                                    if ($status === 'completed') echo 'bg-success';
                                    elseif ($status === 'processing') echo 'bg-info';
                                    elseif ($status === 'cancelled') echo 'bg-danger';
                                    else echo 'bg-warning';
                                    ?>">
                                    <?php echo htmlspecialchars(ucfirst($status)); ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($order['NgayTao'])); ?></td>
                            <td>
                                <a href="detail.php?id=<?php echo $order['MaDonHang']; ?>" class="btn btn-sm btn-info">Xem chi tiết</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>


</html>
