<?php
require_once 'check_admin.php';
require_once __DIR__ . '/../core/database.php';

$logoutPath = '../core/public/logout.php';

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f6f7fb;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 60px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .sidebar-sticky {
            position: relative;
            height: calc(100vh - 60px);
            padding-top: .5rem;
            overflow-y: auto;
        }

        .nav-link {
            font-weight: 500;
            color: #333;
        }

        .nav-link.active {
            background: linear-gradient(135deg, #0d6efd, #3b82f6);
            color: #fff !important;
            border-radius: 8px;
            margin: 0 10px;
        }

        .nav-link:hover {
            background: #e9ecef;
            border-radius: 8px;
        }

        .dashboard-box {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            padding: 40px;
        }

        .dashboard-title {
            font-weight: 800;
            margin-bottom: 10px;
        }

        .dashboard-sub {
            color: #6c757d;
            margin-bottom: 30px;
        }

        .quick-link {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            transition: .2s;
            border: 1px solid #eee;
        }

        .quick-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
            background: #fff;
        }

        .quick-link a {
            text-decoration: none;
            font-weight: 600;
            color: #0d6efd;
        }
    </style>
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="index.php">Admin Panel</a>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="<?php echo $logoutPath; ?>">Đăng xuất</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link active" href="index.php">Dashboard</a></li>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Quản lý Sản phẩm</span>
                        </h6>
                        <li class="nav-item"><a class="nav-link" href="products/list.php">Danh sách Sản phẩm</a></li>
                        <li class="nav-item"><a class="nav-link" href="products/add.php">Thêm Sản phẩm</a></li>

                        <li class="nav-item"><a class="nav-link" href="categories/add.php">Thêm Danh mục</a></li>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Quản lý Khác</span>
                        </h6>
                        <li class="nav-item"><a class="nav-link" href="orders/list.php">Quản lý Đơn hàng</a></li>
                        <li class="nav-item"><a class="nav-link" href="users/list.php">Quản tài khoản</a></li>
                        <li class="nav-item"><a class="nav-link" href="reports/sales_report.php">Báo cáo & Thống kê</a></li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Tài khoản</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li>
                        <li class="nav-item"><a class="nav-link" href="../index.php">Quay lại Trang Chủ</a></li>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $logoutPath; ?>">Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

                <div class="dashboard-box">

                    <h2 class="dashboard-title">Chào mừng đến với Hệ thống Quản trị</h2>
                    <p class="dashboard-sub">
                        Đây là khu vực quản lý website bán Gundam.
                        Bạn có thể quản lý sản phẩm, danh mục, đơn hàng, tài khoản và theo dõi báo cáo hệ thống.
                    </p>

                    <div class="row g-4 mt-3">

                        <div class="col-md-4">
                            <div class="quick-link">
                                <h5>📦 Quản lý sản phẩm</h5>
                                <p class="text-muted">Thêm, sửa, xóa, cập nhật sản phẩm Gundam</p>
                                <a href="products/list.php">Đi đến quản lý sản phẩm →</a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="quick-link">
                                <h5>🧾 Quản lý đơn hàng</h5>
                                <p class="text-muted">Theo dõi, xử lý và cập nhật trạng thái đơn hàng</p>
                                <a href="orders/list.php">Đi đến quản lý đơn hàng →</a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="quick-link">
                                <h5>📊 Báo cáo & thống kê</h5>
                                <p class="text-muted">Xem doanh thu, top sản phẩm bán chạy</p>
                                <a href="reports/sales_report.php">Xem báo cáo →</a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="quick-link">
                                <h5>📁 Quản lý danh mục</h5>
                                <p class="text-muted">Tổ chức danh mục sản phẩm</p>
                                <a href="categories/add.php">Đi đến danh mục →</a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="quick-link">
                                <h5>👤 Quản lý tài khoản</h5>
                                <p class="text-muted">Quản lý người dùng và admin</p>
                                <a href="users/list.php">Đi đến tài khoản →</a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="quick-link">
                                <h5>🏠 Trang chủ website</h5>
                                <p class="text-muted">Quay lại trang bán hàng</p>
                                <a href="../index.php">Đi đến website →</a>
                            </div>
                        </div>

                    </div>

                </div>

            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>