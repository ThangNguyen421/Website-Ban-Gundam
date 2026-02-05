<?php
session_start();
$page_title = "Giỏ hàng của bạn";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

foreach ($_SESSION['cart'] as $product_id => $item) {
    if (!is_numeric($product_id) || (int)$product_id <= 0) {
        unset($_SESSION['cart'][$product_id]);
    }
}

$cart_items = $_SESSION['cart'];
$total_amount = 0;

if (isset($_POST['update_qty'])) {
    $id = $_POST['product_id'];
    $qty = max(1, (int)$_POST['quantity']);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] = $qty;
    }
    header("Location: cart.php");
    exit;
}

if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $page_title; ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f6f7fb; }
.cart-box {
    background:#fff;
    border-radius:18px;
    box-shadow:0 10px 28px rgba(0,0,0,.08);
    padding:25px;
}
.cart-img {
    width:70px;
    border-radius:12px;
}
.qty-box {
    display:flex;
    align-items:center;
    justify-content:flex-end;
}
.qty-box input {
    width:60px;
    text-align:center;
    border-radius:10px;
    border:1px solid #ddd;
    margin:0 6px;
}
.qty-box button {
    width:34px;
    height:34px;
    border-radius:8px;
    border:1px solid #ddd;
    background:#f1f3f5;
    font-weight:bold;
}
.total-box {
    font-size:24px;
    font-weight:700;
    color:#e63946;
}
</style>
</head>

<body>

<div class="container py-5">
<h3 class="mb-4">🛒 Giỏ hàng của bạn</h3>

<?php if (empty($cart_items)): ?>
    <div class="alert alert-info text-center">
        Giỏ hàng của bạn đang trống.<br><br>
        <a href="index.php" class="btn btn-primary">Tiếp tục mua sắm</a>
    </div>

<?php else: ?>

<div class="cart-box">

<div class="table-responsive">
<table class="table align-middle">
<thead class="table-light">
<tr>
    <th>Sản phẩm</th>
    <th class="text-end">Giá</th>
    <th class="text-end">Số lượng</th>
    <th class="text-end">Thành tiền</th>
    <th class="text-center">Xóa</th>
</tr>
</thead>
<tbody>

<?php foreach ($cart_items as $product_id => $item): 
    $subtotal = $item['price'] * $item['quantity'];
    $total_amount += $subtotal;
?>

<tr>
<td>
    <div class="d-flex align-items-center gap-3">
        <img src="<?php echo htmlspecialchars($item['image']); ?>" class="cart-img">
        <div>
            <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
            <small class="text-muted">ID: <?php echo $product_id; ?></small>
        </div>
    </div>
</td>

<td class="text-end"><?php echo number_format($item['price']); ?> đ</td>

<td class="text-end">
<form method="post" class="qty-box">
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    <button type="button" onclick="changeQty(this,-1)">−</button>
    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
    <button type="button" onclick="changeQty(this,1)">+</button>
    <button name="update_qty" class="btn btn-sm btn-outline-primary ms-2">OK</button>
</form>
</td>

<td class="text-end fw-bold text-danger">
    <?php echo number_format($subtotal); ?> đ
</td>

<td class="text-center">
    <a href="?remove=<?php echo $product_id; ?>" class="btn btn-sm btn-outline-danger">✕</a>
</td>
</tr>

<?php endforeach; ?>

</tbody>
</table>
</div>

<hr>

<div class="d-flex justify-content-between align-items-center">
    <h4>Tổng cộng:</h4>
    <div class="total-box"><?php echo number_format($total_amount); ?> đ</div>
</div>

<div class="text-end mt-4">
    <a href="index.php" class="btn btn-secondary">Tiếp tục mua</a>
    <a href="checkout.php" class="btn btn-danger px-4">Thanh toán</a>
</div>

</div>
<?php endif; ?>
</div>

<script>
function changeQty(btn, step){
    let input = btn.parentElement.querySelector("input[name='quantity']");
    let val = parseInt(input.value) || 1;
    val += step;
    if(val < 1) val = 1;
    input.value = val;
}
</script>

</body>
</html>

