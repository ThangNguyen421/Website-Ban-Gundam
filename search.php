<?php
session_start();

require_once "core/database.php";
require_once "models/ProductModel.php";

$productModel = new ProductModel($pdo);

$keyword = trim($_GET['q'] ?? '');

$results = [];
if ($keyword !== '') {
    $results = $productModel->searchProducts($keyword);
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Kết quả tìm kiếm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <h3 class="mb-3">Kết quả tìm kiếm cho:
        <span class="text-primary"><?php echo htmlspecialchars($keyword); ?></span>
    </h3>

    <?php if (empty($results)): ?>
        <div class="alert alert-warning">Không tìm thấy sản phẩm nào phù hợp.</div>
    <?php else: ?>

        <div class="row">

            <?php foreach ($results as $sp): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">

                        <img src="<?php echo htmlspecialchars($sp['URLAnhChinh']); ?>"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover;">

                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($sp['TenSanPham']); ?>
                            </h5>

                            <p class="text-danger fw-bold">
                                <?php echo number_format($sp['GiaBan'], 0, ',', '.'); ?> đ
                            </p>

                            <a href="product.php?id=<?php echo $sp['MaSanPham']; ?>"
                               class="btn btn-primary w-100">
                                Xem chi tiết
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

</body>
</html>
