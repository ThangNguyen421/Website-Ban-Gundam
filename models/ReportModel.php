<?php
class ReportModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Lấy tổng doanh thu theo khoảng thời gian
    public function getTotalRevenue($startDate = null, $endDate = null) {
        $sql = "SELECT SUM(TongGia) AS TotalRevenue
                FROM DonHang
                WHERE TrangThai = 'completed'";
        $params = [];

        if ($startDate) {
            $sql .= " AND DATE(NgayTao) >= ?";
            $params[] = $startDate;
        }
        if ($endDate) {
            $sql .= " AND DATE(NgayTao) <= ?";
            $params[] = $endDate;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();

        return (float)($result['TotalRevenue'] ?? 0);
    }

    //Lấy danh sách sản phẩm bán chạy nhất
    public function getTopSellingProducts(int $limit = 10) {
        $sql = "SELECT 
                    sp.MaSanPham,
                    sp.TenSanPham,
                    SUM(ctdh.SoLuong) AS TotalSold,
                    SUM(ctdh.SoLuong * ctdh.GiaBan) AS TotalRevenueFromProduct
                FROM ChiTietDonHang ctdh
                JOIN SanPham sp ON ctdh.MaSanPham = sp.MaSanPham
                JOIN DonHang dh ON ctdh.MaDonHang = dh.MaDonHang
                WHERE dh.TrangThai = 'completed' -- Chỉ tính đơn hàng hoàn thành
                GROUP BY sp.MaSanPham, sp.TenSanPham
                ORDER BY TotalSold DESC
                LIMIT ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}
