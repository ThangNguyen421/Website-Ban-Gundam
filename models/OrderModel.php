<?php
class OrderModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


// Tạo đơn hàng mới trong bảng donhang.

public function createOrder($data, $total)
{
    $sql = "INSERT INTO donhang (
                MaNguoiDung, 
                TenKhachHang, 
                EmailKhachHang, 
                SDTNhanHang, 
                DiaChiGiaoHang, 
                TongGia, 
                PhuongThucThanhToan, 
                TrangThai, 
                NgayTao
            ) VALUES (
                :manguoidung, 
                :tenkhachhang, 
                :emailkhachhang, 
                :sdth, 
                :diachi, 
                :tonggia, 
                :pttt, 
                'pending', 
                NOW()
            )";

    try {
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':manguoidung', $data['MaNguoiDung'], PDO::PARAM_INT);
        $stmt->bindParam(':tenkhachhang', $data['TenKhachHang']);
        $stmt->bindParam(':emailkhachhang', $data['EmailKhachHang']);
        $stmt->bindParam(':sdth', $data['SDTNhanHang']);
        $stmt->bindParam(':diachi', $data['DiaChiGiaoHang']);
        $stmt->bindParam(':tonggia', $total);
        $stmt->bindParam(':pttt', $data['PhuongThucThanhToan']);

        $stmt->execute();

        return $this->pdo->lastInsertId();

    } catch (PDOException $e) {
        echo "<pre>Lỗi SQL: " . $e->getMessage() . "</pre>";
        return false;
    }
}


// Lưu chi tiết các mặt hàng vào bảng chitietdonhang.
    public function createOrderDetails($orderId, $cartItems)
    {
        $sql = "INSERT INTO chitietdonhang (MaDonHang, MaSanPham, SoLuong, GiaBan) 
                 VALUES (:madonhang, :masp, :soluong, :giaban)";
        $stmt = $this->pdo->prepare($sql);

        try {
            $this->pdo->beginTransaction();
            foreach ($cartItems as $item) {
                $stmt->bindParam(':madonhang', $orderId);
                $stmt->bindParam(':masp', $item['id']); 
                $stmt->bindParam(':soluong', $item['quantity']);
                $stmt->bindParam(':giaban', $item['price']); 
                $stmt->execute();
            }
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }


    // Lấy tất cả đơn hàng, bao gồm thông tin khách hàng.
    public function getAllOrders()
    {
        $sql = "SELECT 
                    d.*, 
                    n.HoTen AS HoTenNguoiDung, 
                    n.Email AS EmailNguoiDung
                FROM 
                    donhang d
                LEFT JOIN 
                    nguoidung n ON d.MaNguoiDung = n.MaNguoiDung
                ORDER BY 
                    d.NgayTao DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Lấy chi tiết đơn hàng (danh sách sản phẩm, thông tin người dùng).
    public function getOrderDetails($orderId)
    {
        $sqlOrder = "SELECT 
                        d.*,
                        n.HoTen AS HoTenNguoiDung, 
                        n.Email AS EmailNguoiDung
                     FROM 
                        donhang d
                     LEFT JOIN 
                        nguoidung n ON d.MaNguoiDung = n.MaNguoiDung
                     WHERE 
                        d.MaDonHang = :id";
        $stmtOrder = $this->pdo->prepare($sqlOrder);
        $stmtOrder->bindParam(':id', $orderId, PDO::PARAM_INT);
        $stmtOrder->execute();
        $order = $stmtOrder->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            return false;
        }
        $sqlItems = "SELECT 
                         ct.SoLuong, ct.GiaBan, 
                         sp.TenSanPham, sp.MaSanPham, sp.URLAnhChinh
                     FROM chitietdonhang ct
                     JOIN sanpham sp ON ct.MaSanPham = sp.MaSanPham
                     WHERE ct.MaDonHang = :id";
        $stmtItems = $this->pdo->prepare($sqlItems);
        $stmtItems->bindParam(':id', $orderId, PDO::PARAM_INT);
        $stmtItems->execute();
        $orderItems = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        $order['items'] = $orderItems;
        return $order;
    }

    // Cập nhật trạng thái đơn hàng.
    public function updateOrderStatus($orderId, $status)
    {
        $sql = "UPDATE donhang SET TrangThai = :status WHERE MaDonHang = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

