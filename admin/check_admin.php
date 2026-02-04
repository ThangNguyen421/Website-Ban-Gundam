<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
 ĐIỀU KIỆN ĐỂ ĐƯỢC VÀO ADMIN:
 1. Đã đăng nhập (có user_id)
 2. Có tồn tại user_role
 3. user_role = admin
*/

if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['user_role'])
) {
    header("Location: ../views/auth/login.php");
    exit();
}

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: ../public/index.php");
    exit();
}
