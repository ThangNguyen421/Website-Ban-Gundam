-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th1 09, 2026 lúc 04:36 PM
-- Phiên bản máy phục vụ: 9.1.0
-- Phiên bản PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `lamlaidoan_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdonhang`
--

DROP TABLE IF EXISTS `chitietdonhang`;
CREATE TABLE IF NOT EXISTS `chitietdonhang` (
  `MaChiTiet` int NOT NULL AUTO_INCREMENT,
  `MaDonHang` int NOT NULL,
  `MaSanPham` int NOT NULL,
  `SoLuong` int NOT NULL,
  `GiaBan` decimal(10,2) NOT NULL,
  PRIMARY KEY (`MaChiTiet`),
  KEY `MaDonHang` (`MaDonHang`),
  KEY `MaSanPham` (`MaSanPham`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdonhang`
--

INSERT INTO `chitietdonhang` (`MaChiTiet`, `MaDonHang`, `MaSanPham`, `SoLuong`, `GiaBan`) VALUES
(1, 1, 4, 2, 1000000.00),
(2, 2, 10, 2, 1000000.00),
(3, 3, 15, 1, 300000.00),
(4, 4, 13, 1, 15000.00),
(5, 4, 12, 1, 5000.00),
(6, 4, 10, 1, 1000.00),
(7, 4, 9, 1, 500000.00),
(8, 5, 17, 2, 400000.00),
(9, 5, 12, 1, 5000.00),
(10, 6, 18, 1, 700000.00),
(11, 7, 18, 1, 700000.00),
(12, 8, 18, 1, 700000.00),
(13, 9, 18, 1, 700000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

DROP TABLE IF EXISTS `danhmuc`;
CREATE TABLE IF NOT EXISTS `danhmuc` (
  `MaDanhMuc` int NOT NULL AUTO_INCREMENT,
  `TenDanhMuc` varchar(100) NOT NULL,
  `MoTa` text,
  `NgayTao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`MaDanhMuc`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`MaDanhMuc`, `TenDanhMuc`, `MoTa`, `NgayTao`) VALUES
(1, 'SM', 'abcdfghjkl', '2025-11-29 23:43:32'),
(2, 'LI', '1234', '2025-11-29 23:43:37'),
(6, 'HG', '', '2025-12-13 21:16:02'),
(7, 'MD', '', '2025-12-13 21:16:07'),
(8, 'AG', '', '2025-12-13 21:16:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

DROP TABLE IF EXISTS `donhang`;
CREATE TABLE IF NOT EXISTS `donhang` (
  `MaDonHang` int NOT NULL AUTO_INCREMENT,
  `MaNguoiDung` int DEFAULT NULL,
  `TenKhachHang` varchar(100) DEFAULT NULL,
  `EmailKhachHang` varchar(100) DEFAULT NULL,
  `TongGia` decimal(10,2) NOT NULL,
  `TrangThai` varchar(20) DEFAULT 'pending',
  `PhuongThucThanhToan` varchar(30) DEFAULT NULL,
  `DiaChiGiaoHang` varchar(255) DEFAULT NULL,
  `SDTNhanHang` varchar(20) DEFAULT NULL,
  `NgayTao` datetime DEFAULT CURRENT_TIMESTAMP,
  `NgayCapNhat` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`MaDonHang`),
  KEY `MaNguoiDung` (`MaNguoiDung`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MaDonHang`, `MaNguoiDung`, `TenKhachHang`, `EmailKhachHang`, `TongGia`, `TrangThai`, `PhuongThucThanhToan`, `DiaChiGiaoHang`, `SDTNhanHang`, `NgayTao`, `NgayCapNhat`) VALUES
(3, NULL, 'Nguyễn Quang Thắng', 'thang.nq421@gmail.com', 300000.00, 'completed', 'COD', 'Quận 7', '0349767476', '2025-12-11 23:37:20', '2025-12-12 21:44:09'),
(4, NULL, 'ABCD', 'abcd@gmail.com', 521000.00, 'completed', 'COD', 'ádasdad', '012345678', '2025-12-12 21:57:44', '2025-12-12 21:57:57'),
(5, NULL, 'Thắng Quang Nguyễn', 'thang.nq421@gmail.com', 805000.00, 'completed', 'COD', '4A, đường 28, Phường Tân Hưng', '0349767476', '2025-12-13 21:40:38', '2025-12-13 21:41:01'),
(6, NULL, 'Nguyễn Quang Thắng 12/26', 'thang.nq421@gmail.com', 700000.00, 'completed', 'COD', 'Quận 7', '0349767476', '2025-12-26 19:48:15', '2025-12-26 19:48:28'),
(7, NULL, 'Thắng Quang Nguyễn', 'thang.nq421@gmail.com', 700000.00, 'pending', 'COD', '4A, đường 28, Phường Tân Hưng', '0349767476', '2026-01-09 16:34:27', '2026-01-09 16:34:27'),
(8, NULL, 'Thắng Quang Nguyễn', 'thang.nq421@gmail.com', 700000.00, 'pending', 'COD', '4A, đường 28, Phường Tân Hưng', '0349767476', '2026-01-09 16:34:36', '2026-01-09 16:34:36'),
(9, NULL, 'Thắng Quang Nguyễn', 'thang.nq421@gmail.com', 700000.00, 'pending', 'COD', '4A, đường 28, Phường Tân Hưng', '0349767476', '2026-01-09 16:36:16', '2026-01-09 16:36:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

DROP TABLE IF EXISTS `nguoidung`;
CREATE TABLE IF NOT EXISTS `nguoidung` (
  `MaNguoiDung` int NOT NULL AUTO_INCREMENT,
  `HoTen` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MatKhauHash` varchar(255) NOT NULL,
  `VaiTro` varchar(20) NOT NULL DEFAULT 'customer',
  `LanDangNhapCuoi` datetime DEFAULT NULL,
  `NgayTao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`MaNguoiDung`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`MaNguoiDung`, `HoTen`, `Email`, `MatKhauHash`, `VaiTro`, `LanDangNhapCuoi`, `NgayTao`) VALUES
(1, 'Admin', 'testadmin@gundamshop.com', '$2y$12$JREHVtpVRQC3G5Ff0hZxn.Y5fMyFEPZN6VI3uJpoWfAOHxAuYrVTW', 'admin', '2026-01-09 23:32:17', '2025-11-29 22:22:25'),
(3, 'Nguyễn Quang Thắng', 'thang.nq421@gmail.com', '$2y$12$QU3I28N0OUejfxacVzy.7en5bSbtOWGkSC0/mMpeAX4Tp7fNboah6', 'admin', '2025-12-28 22:47:57', '2025-12-04 16:29:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `MaSanPham` int NOT NULL AUTO_INCREMENT,
  `MaDanhMuc` int NOT NULL,
  `TenSanPham` varchar(150) NOT NULL,
  `MoTa` text,
  `GiaBan` decimal(10,2) NOT NULL,
  `TonKho` int NOT NULL,
  `URLAnhChinh` varchar(255) DEFAULT NULL,
  `TrangThai` varchar(20) DEFAULT 'active',
  `LuotXem` int NOT NULL DEFAULT '0',
  `NgayTao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`MaSanPham`),
  KEY `MaDanhMuc` (`MaDanhMuc`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSanPham`, `MaDanhMuc`, `TenSanPham`, `MoTa`, `GiaBan`, `TonKho`, `URLAnhChinh`, `TrangThai`, `LuotXem`, `NgayTao`) VALUES
(28, 2, 'LI UC 1/144 MESSALA', '', 470000.00, 6, 'public/assets/images/products/gundam_696124f2a5bdd_1767974130.jpg', 'active', 0, '2026-01-09 22:55:30'),
(27, 2, 'LI 1/144 Expansion Set for RG Sinanju', '', 1000000.00, 10, 'public/assets/images/products/gundam_696124c84768c_1767974088.png', 'active', 0, '2026-01-09 22:54:48'),
(24, 6, 'HG UC 1/144 ZAKU 1', '', 390000.00, 19, 'public/assets/images/products/gundam_6961245c8d4cb_1767973980.png', 'active', 0, '2026-01-09 22:53:00'),
(25, 8, 'MGEX 1/100 Unicorn Gundam Ver Ka - Premium Unicorn Mode Box Kit', '', 400000.00, 50, 'public/assets/images/products/gundam_696124804dec2_1767974016.jpg', 'active', 0, '2026-01-09 22:53:36'),
(26, 8, 'AG 1/100 UNICORN GUNDAM 03 PHENEX - NARRATIVE VER', '', 6400000.00, 22, 'public/assets/images/products/gundam_696124a461849_1767974052.jpg', 'active', 0, '2026-01-09 22:54:12'),
(23, 6, 'HG UC 1/144 AMX-003 Gaza C - Haman Karn Custom', '', 370000.00, 25, 'public/assets/images/products/gundam_6961242228e1e_1767973922.jpg', 'active', 0, '2026-01-09 22:52:02'),
(22, 8, '1/144 RX-78F00/E Gundam EX-001 GLRSS Feather Unit', '', 1800000.00, 10, 'public/assets/images/products/gundam_6961232707bfd_1767973671.jpg', 'active', 0, '2026-01-09 22:47:51'),
(32, 1, 'IBO 1/144 Gundam Barbatos', '', 400000.00, 3, 'public/assets/images/products/gundam_696125a45a118_1767974308.jpg', 'active', 0, '2026-01-09 22:58:28'),
(29, 7, 'MD UC 1/144 RX-78 GP01Fb Gundam Zephyranthes Full Burnern', '', 500000.00, 34, 'public/assets/images/products/gundam_696125383273f_1767974200.jpg', 'active', 0, '2026-01-09 22:56:40'),
(30, 7, 'MDEX 1/100 Strike Freedom Gundam', '', 670000.00, 56, 'public/assets/images/products/gundam_6961256312577_1767974243.jpg', 'active', 0, '2026-01-09 22:57:23'),
(31, 1, 'SMSRW Super Robot Wars OG Huckebein Mk-2 Trombe', '', 590000.00, 6, 'public/assets/images/products/gundam_696125855758f_1767974277.jpg', 'active', 1, '2026-01-09 22:57:57');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
