<?php
class ProductModel
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    //Lấy tất cả danh mục
    public function getAllCategories()
    {
        $sql = "SELECT * FROM DanhMuc ORDER BY TenDanhMuc ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    //Thêm Danh mục mới
    public function addCategory($name, $description = null)
    {
        $sql = "INSERT INTO DanhMuc (TenDanhMuc, MoTa) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $description]);
    }

    //Lấy tất cả sản phẩm (dùng cho admin/products/list.php)
    public function getAllProducts()
    {
        $sql = "SELECT p.*, d.TenDanhMuc 
                FROM SanPham p
                JOIN DanhMuc d ON p.MaDanhMuc = d.MaDanhMuc 
                ORDER BY p.NgayTao DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    //Thêm sản phẩm mới
    public function addProduct($data, $extraImageUrls = [])
    {
        $this->pdo->beginTransaction();
        try {
            $sql = "INSERT INTO SanPham (MaDanhMuc, TenSanPham, MoTa, GiaBan, TonKho, URLAnhChinh, TrangThai) 
                    VALUES (:ma_dm, :ten_sp, :mo_ta, :gia_ban, :ton_kho, :url_chinh, :trang_thai)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'ma_dm'     => $data['MaDanhMuc'],
                'ten_sp'    => $data['TenSanPham'],
                'mo_ta'     => $data['MoTa'],
                'gia_ban'   => $data['GiaBan'],
                'ton_kho'   => $data['TonKho'],
                'url_chinh' => $data['URLAnhChinh'],
                'trang_thai' => $data['TrangThai'] ?? 'active'
            ]);

            $newProductId = $this->pdo->lastInsertId();

            if ($newProductId && !empty($extraImageUrls)) {
                $this->addExtraImages($newProductId, $extraImageUrls);
            }

            $this->pdo->commit();
            return $newProductId;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
    
    //Thêm các URL ảnh phụ vào bảng AnhSanPham
    public function addExtraImages(int $productId, array $urls)
    {
        if (empty($urls)) {
            return true;
        }

        $sqlImages = "INSERT INTO AnhSanPham (MaSanPham, URLAnh) VALUES (?, ?)";
        $stmtImages = $this->pdo->prepare($sqlImages);

        foreach ($urls as $url) {
            if (!$stmtImages->execute([$productId, $url])) {
                return false;
            }
        }
        return true;
    }


    //Xóa sản phẩm theo MaSanPham
    public function deleteProduct(int $productId)
    {
        $this->pdo->beginTransaction();

        try {
            $sqlSelect = "SELECT URLAnhChinh FROM SanPham WHERE MaSanPham = ?";
            $stmtSelect = $this->pdo->prepare($sqlSelect);
            $stmtSelect->execute([$productId]);
            $productInfo = $stmtSelect->fetch();

            if (!$productInfo) {
                $this->pdo->rollBack();
                return false;
            }

            $sqlDeleteImages = "DELETE FROM AnhSanPham WHERE MaSanPham = ?";
            $stmtDeleteImages = $this->pdo->prepare($sqlDeleteImages);
            $stmtDeleteImages->execute([$productId]);

            $sqlDeleteProduct = "DELETE FROM SanPham WHERE MaSanPham = ?";
            $stmtDeleteProduct = $this->pdo->prepare($sqlDeleteProduct);
            $stmtDeleteProduct->execute([$productId]);

            $this->pdo->commit();
            return $productInfo;

        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }


    //Lấy thông tin chi tiết của một sản phẩm dựa trên ID.
    public function getProductById(int $productId)
    {
        $sql = "SELECT s.*, d.TenDanhMuc FROM SanPham s 
            JOIN DanhMuc d ON s.MaDanhMuc = d.MaDanhMuc
            WHERE s.MaSanPham = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetch();
    }


    //Cập nhật thông tin sản phẩm.
    public function updateProduct(int $id, array $data)
    {
        $fields = ['MaDanhMuc', 'TenSanPham', 'GiaBan', 'MoTa', 'TonKho', 'URLAnhChinh', 'TrangThai'];
        $setClauses = [];
        $values = [];

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $setClauses[] = "$field = ?";
                $values[] = $data[$field];
            }
        }

        if (empty($setClauses)) {
            return false;
        }

        $sql = "UPDATE SanPham SET " . implode(', ', $setClauses) . " WHERE MaSanPham = ?";
        $values[] = $id;


        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    //Lấy sản phẩm để hiển thị trên trang chủ
    public function getProductsForHomepage(int $limit)
    {
        $sql = "SELECT MaSanPham, TenSanPham, GiaBan, TonKho, TrangThai, URLAnhChinh 
                FROM SanPham 
                WHERE TrangThai = 'active' 
                ORDER BY NgayTao DESC 
                LIMIT ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Lấy danh sách sản phẩm (có thể lọc theo danh mục)
    public function getActiveProducts(?int $categoryId = null)
    {
        $sql = "SELECT MaSanPham, TenSanPham, GiaBan, URLAnhChinh, TonKho, TrangThai
            FROM SanPham 
            WHERE TrangThai = 'active'";
        $params = [];

        if ($categoryId) {
            $sql .= " AND MaDanhMuc = ?";
            $params[] = $categoryId;
        }

        $sql .= " ORDER BY NgayTao DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    //Lấy tất cả thông tin chi tiết của một sản phẩm theo ID
    public function getProductDetails(int $productId)
    {
        $sql = "SELECT sp.*, dm.TenDanhMuc 
            FROM SanPham sp
            JOIN DanhMuc dm ON sp.MaDanhMuc = dm.MaDanhMuc
            WHERE sp.MaSanPham = ? AND sp.TrangThai = 'active'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$productId]);

        return $stmt->fetch();
    }

    public function getProductImages(int $productId)
    {
        $sql = "SELECT URLAnh FROM AnhSanPham WHERE MaSanPham = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function decreaseStock($productId, $quantity)
    {
        $sql = "UPDATE sanpham SET TonKho = TonKho - :quantity WHERE MaSanPham = :id AND TonKho >= :quantity";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

//Tìm kiếm sản phẩm
public function searchProducts($keyword)
{
    $sql = "SELECT *
            FROM sanpham
            WHERE TrangThai = 'active'
              AND TenSanPham LIKE :keyword";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        ':keyword' => '%' . $keyword . '%'
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function incrementViewCount($product_id)
    {
        $sql = "UPDATE SanPham SET LuotXem = LuotXem + 1 WHERE MaSanPham = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$product_id]);
    }

    public function getBestSellingProducts($limit = 8)
    {
        $sql = "SELECT p.*, SUM(ct.SoLuong) as total_sold
            FROM SanPham p
            LEFT JOIN ChiTietDonHang ct ON p.MaSanPham = ct.MaSanPham
            LEFT JOIN DonHang dh ON ct.MaDonHang = dh.MaDonHang
            WHERE p.TrangThai = 'active'
            GROUP BY p.MaSanPham
            ORDER BY total_sold DESC, p.NgayTao DESC
            LIMIT ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    
    
}

