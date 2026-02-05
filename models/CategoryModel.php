<?php
class CategoryModel
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Lấy danh sách tất cả danh mục
    public function getAllCategories()
    {
        $sql = "SELECT MaDanhMuc, TenDanhMuc FROM DanhMuc ORDER BY TenDanhMuc ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    //Lấy thông tin một danh mục theo ID
    public function getCategoryById(int $categoryId)
    {
        $sql = "SELECT MaDanhMuc, TenDanhMuc FROM DanhMuc WHERE MaDanhMuc = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetch();
    }
}

