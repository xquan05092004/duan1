-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 13, 2025 lúc 08:11 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `clothing_store`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','ordered','cancelled') DEFAULT 'active',
  `color` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `added_at`, `status`, `color`, `size`, `image`) VALUES
(42, 13, 12, 1, '2025-04-06 06:38:50', 'active', 3, 4, 'tui_deo_cheo.jpg'),
(63, 12, 19, 1, '2025-04-12 13:36:47', 'active', 1, 1, '1744381839_5d843cbb-f039-4b36-87be-b999325ae1a4.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Áo Thun'),
(2, 'Quần Jean'),
(3, 'Giày Dép'),
(4, 'Phụ Kiện');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `color_code` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `colors`
--

INSERT INTO `colors` (`id`, `color_code`) VALUES
(1, 'Đen'),
(2, 'Trắng'),
(3, 'Xám'),
(4, 'Xanh'),
(5, 'Đỏ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `product_id`, `content`, `status`, `created_at`) VALUES
(1, 10, 10, 'abc', 'approved', '2025-04-13 11:15:08'),
(9, 13, 9, 'ádu', 'pending', '2025-04-13 11:44:05'),
(10, 8, 18, 'abc', 'pending', '2025-04-13 11:54:54'),
(11, 8, 12, 'abc', 'pending', '2025-04-13 12:20:33'),
(12, 8, 12, 'aabc', 'pending', '2025-04-13 12:21:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount_codes`
--

CREATE TABLE `discount_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `discount_type` enum('tiền','phần trăm') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('chưa xác nhận','xác nhận','đang giao','hoàn thành','hủy') DEFAULT 'chưa xác nhận',
  `payment_status` enum('chưa thanh toán','đang thanh toán','đã thanh toán') NOT NULL DEFAULT 'chưa thanh toán',
  `payment_method` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `payment_status`, `payment_method`, `total_amount`, `created_at`, `address`, `phone`) VALUES
(18, 12, 'chưa xác nhận', 'chưa thanh toán', '1', 150000.00, '2025-04-10 15:22:46', '11 đức diễn, phúc diễn, bắc từ liêm, hà nội', ''),
(20, 12, 'chưa xác nhận', 'chưa thanh toán', '1', 550000.00, '2025-04-10 15:32:50', '111 đức diễn, phúc diễn, bắc từ liêm, hà nội', ''),
(29, 12, 'chưa xác nhận', 'chưa thanh toán', '1', 4180000.00, '2025-04-10 16:24:45', '11 đức diễn, phúc diễn, bắc từ liêm, hà nội', ''),
(30, 12, 'hoàn thành', 'chưa thanh toán', '1', 150000.00, '2025-04-10 16:29:40', '11 đức diễn, phúc diễn, bắc từ liêm, hà nội', ''),
(31, 12, 'hủy', 'chưa thanh toán', '1', 99999999.99, '2025-04-10 16:30:29', '11 đức diễn, phúc diễn, bắc từ liêm, hà nội', ''),
(32, 12, 'hủy', 'chưa thanh toán', '1', 680000.00, '2025-04-11 03:06:22', '11 đức diễn, phúc diễn, bắc từ liêm, hà nội', ''),
(33, 12, 'hủy', 'chưa thanh toán', '1', 60000.00, '2025-04-12 07:59:57', ', , , ', ''),
(34, 12, 'hoàn thành', 'chưa thanh toán', '1', 99999999.99, '2025-04-12 09:31:11', ', , , ', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_variant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_variant_id`, `quantity`, `price`) VALUES
(11, 18, 91, 1, 150000.00),
(13, 20, 63, 1, 550000.00),
(15, 29, 116, 11, 380000.00),
(16, 30, 91, 1, 150000.00),
(17, 31, 123, 1000, 380000.00),
(18, 32, 116, 1, 380000.00),
(19, 32, 91, 2, 150000.00),
(20, 33, 276, 6, 10000.00),
(21, 34, 226, 134, 1000000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`) VALUES
(1, 'Thanh toán khi nhận hàng'),
(2, 'Chuyển khoản ngân hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `quantity`, `category_id`, `created_at`) VALUES
(1, 'Áo Thun Basic', 'Áo thun trơn chất liệu cotton 100%', 150000.00, 'ao_thun_basic.jpg', 50, 1, '2025-04-11 14:37:48'),
(2, 'Áo Thun Logo', 'Áo thun in logo phong cách thể thao', 200000.00, 'ao_thun_logo.jpg', 35, 1, '2025-04-11 14:37:48'),
(3, 'Áo Thun Kẻ Sọc', 'Áo thun kẻ sọc nam tính', 180000.00, 'ao_thun_ke_soc.jpg', 40, 1, '2025-04-11 14:37:48'),
(4, 'Quần Jean Slim Fit', 'Quần jean ôm dáng màu xanh đậm', 350000.00, 'quan_jean_slim.jpg', 30, 2, '2025-04-11 14:37:48'),
(5, 'Quần Jean Rách', 'Quần jean rách gối thời trang', 380000.00, 'quan_jean_rach.jpg', 25, 2, '2025-04-11 14:37:48'),
(6, 'Quần Jean Baggy', 'Quần jean ống rộng phong cách đường phố', 400000.00, 'quan_jean_baggy.jpg', 20, 2, '2025-04-11 14:37:48'),
(7, 'Giày Sneaker', 'Giày thể thao năng động', 550000.00, 'giay_sneaker.jpg', 15, 3, '2025-04-11 14:37:48'),
(8, 'Dép Quai Ngang', 'Dép đi biển thoáng mát', 120000.00, 'dep_quai_ngang.jpg', 45, 3, '2025-04-11 14:37:48'),
(9, 'Giày Tây', 'Giày da công sở lịch lãm', 750000.00, 'giay_tay.jpg', 10, 3, '2025-04-11 14:37:48'),
(10, 'Nón Lưỡi Trai', 'Nón kết thời trang', 100000.00, 'non_luoi_trai.jpg', 60, 4, '2025-04-11 14:37:48'),
(11, 'Thắt Lưng Da', 'Thắt lưng da bò cao cấp', 250000.00, 'that_lung_da.jpg', 20, 4, '2025-04-11 14:37:48'),
(12, 'Túi Đeo Chéo', 'Túi đeo chéo nhỏ gọn tiện lợi', 220000.00, 'tui_deo_cheo.jpg', 25, 4, '2025-04-11 14:37:48'),
(18, 'áo thun new', 'ddđ', 1000000.00, '1744341050_5d843cbb-f039-4b36-87be-b999325ae1a4.jpg', 100, 1, '2025-04-11 14:37:48'),
(19, 'Đức1111', 'dddd', 10000.00, '1744381839_5d843cbb-f039-4b36-87be-b999325ae1a4.jpg', 1111, 1, '2025-04-11 14:37:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `size_id`, `color_id`, `created_at`) VALUES
(60, 7, 1, 2, '2025-04-11 14:29:48'),
(61, 7, 1, 5, '2025-04-11 14:29:48'),
(62, 7, 2, 2, '2025-04-11 14:29:48'),
(63, 7, 2, 5, '2025-04-11 14:29:48'),
(64, 7, 4, 2, '2025-04-11 14:29:48'),
(65, 7, 4, 5, '2025-04-11 14:29:48'),
(66, 12, 1, 1, '2025-04-11 14:29:48'),
(67, 12, 1, 2, '2025-04-11 14:29:48'),
(68, 12, 1, 3, '2025-04-11 14:29:48'),
(69, 12, 1, 4, '2025-04-11 14:29:48'),
(70, 12, 1, 5, '2025-04-11 14:29:48'),
(71, 12, 2, 1, '2025-04-11 14:29:48'),
(72, 12, 2, 2, '2025-04-11 14:29:48'),
(73, 12, 2, 3, '2025-04-11 14:29:48'),
(74, 12, 2, 4, '2025-04-11 14:29:48'),
(75, 12, 2, 5, '2025-04-11 14:29:48'),
(76, 12, 3, 1, '2025-04-11 14:29:48'),
(77, 12, 3, 2, '2025-04-11 14:29:48'),
(78, 12, 3, 3, '2025-04-11 14:29:48'),
(79, 12, 3, 4, '2025-04-11 14:29:48'),
(80, 12, 3, 5, '2025-04-11 14:29:48'),
(81, 12, 4, 1, '2025-04-11 14:29:48'),
(82, 12, 4, 2, '2025-04-11 14:29:48'),
(83, 12, 4, 3, '2025-04-11 14:29:48'),
(84, 12, 4, 4, '2025-04-11 14:29:48'),
(85, 12, 4, 5, '2025-04-11 14:29:48'),
(86, 12, 5, 1, '2025-04-11 14:29:48'),
(87, 12, 5, 2, '2025-04-11 14:29:48'),
(88, 12, 5, 3, '2025-04-11 14:29:48'),
(89, 12, 5, 4, '2025-04-11 14:29:48'),
(90, 12, 5, 5, '2025-04-11 14:29:48'),
(91, 1, 1, 1, '2025-04-11 14:29:48'),
(92, 1, 1, 2, '2025-04-11 14:29:48'),
(93, 1, 1, 3, '2025-04-11 14:29:48'),
(94, 1, 1, 4, '2025-04-11 14:29:48'),
(95, 1, 1, 5, '2025-04-11 14:29:48'),
(96, 1, 2, 1, '2025-04-11 14:29:48'),
(97, 1, 2, 2, '2025-04-11 14:29:48'),
(98, 1, 2, 3, '2025-04-11 14:29:48'),
(99, 1, 2, 4, '2025-04-11 14:29:48'),
(100, 1, 2, 5, '2025-04-11 14:29:48'),
(101, 1, 3, 1, '2025-04-11 14:29:48'),
(102, 1, 3, 2, '2025-04-11 14:29:48'),
(103, 1, 3, 3, '2025-04-11 14:29:48'),
(104, 1, 3, 4, '2025-04-11 14:29:48'),
(105, 1, 3, 5, '2025-04-11 14:29:48'),
(106, 1, 4, 1, '2025-04-11 14:29:48'),
(107, 1, 4, 2, '2025-04-11 14:29:48'),
(108, 1, 4, 3, '2025-04-11 14:29:48'),
(109, 1, 4, 4, '2025-04-11 14:29:48'),
(110, 1, 4, 5, '2025-04-11 14:29:48'),
(111, 1, 5, 1, '2025-04-11 14:29:48'),
(112, 1, 5, 2, '2025-04-11 14:29:48'),
(113, 1, 5, 3, '2025-04-11 14:29:48'),
(114, 1, 5, 4, '2025-04-11 14:29:48'),
(115, 1, 5, 5, '2025-04-11 14:29:48'),
(116, 5, 1, 1, '2025-04-11 14:29:48'),
(117, 5, 1, 2, '2025-04-11 14:29:48'),
(118, 5, 1, 3, '2025-04-11 14:29:48'),
(119, 5, 1, 4, '2025-04-11 14:29:48'),
(120, 5, 1, 5, '2025-04-11 14:29:48'),
(121, 5, 2, 1, '2025-04-11 14:29:48'),
(122, 5, 2, 2, '2025-04-11 14:29:48'),
(123, 5, 2, 3, '2025-04-11 14:29:48'),
(124, 5, 2, 4, '2025-04-11 14:29:48'),
(125, 5, 2, 5, '2025-04-11 14:29:48'),
(126, 5, 3, 1, '2025-04-11 14:29:48'),
(127, 5, 3, 2, '2025-04-11 14:29:48'),
(128, 5, 3, 3, '2025-04-11 14:29:48'),
(129, 5, 3, 4, '2025-04-11 14:29:48'),
(130, 5, 3, 5, '2025-04-11 14:29:48'),
(131, 5, 4, 1, '2025-04-11 14:29:48'),
(132, 5, 4, 2, '2025-04-11 14:29:48'),
(133, 5, 4, 3, '2025-04-11 14:29:48'),
(134, 5, 4, 4, '2025-04-11 14:29:48'),
(135, 5, 4, 5, '2025-04-11 14:29:48'),
(136, 5, 5, 1, '2025-04-11 14:29:48'),
(137, 5, 5, 2, '2025-04-11 14:29:48'),
(142, 2, 1, 1, '2025-04-11 14:29:48'),
(143, 2, 1, 2, '2025-04-11 14:29:48'),
(144, 2, 1, 3, '2025-04-11 14:29:48'),
(145, 2, 1, 4, '2025-04-11 14:29:48'),
(146, 2, 1, 5, '2025-04-11 14:29:48'),
(147, 2, 2, 1, '2025-04-11 14:29:48'),
(148, 2, 2, 2, '2025-04-11 14:29:48'),
(149, 2, 2, 3, '2025-04-11 14:29:48'),
(150, 2, 2, 4, '2025-04-11 14:29:48'),
(151, 2, 2, 5, '2025-04-11 14:29:48'),
(152, 2, 3, 1, '2025-04-11 14:29:48'),
(153, 2, 3, 2, '2025-04-11 14:29:48'),
(154, 2, 3, 3, '2025-04-11 14:29:48'),
(155, 2, 3, 4, '2025-04-11 14:29:48'),
(156, 2, 3, 5, '2025-04-11 14:29:48'),
(157, 2, 4, 1, '2025-04-11 14:29:48'),
(158, 2, 4, 2, '2025-04-11 14:29:48'),
(159, 2, 4, 3, '2025-04-11 14:29:48'),
(160, 2, 4, 4, '2025-04-11 14:29:48'),
(161, 2, 4, 5, '2025-04-11 14:29:48'),
(162, 2, 5, 1, '2025-04-11 14:29:48'),
(163, 2, 5, 2, '2025-04-11 14:29:48'),
(164, 2, 5, 3, '2025-04-11 14:29:48'),
(165, 2, 5, 4, '2025-04-11 14:29:48'),
(166, 2, 5, 5, '2025-04-11 14:29:48'),
(167, 3, 1, 1, '2025-04-11 14:29:48'),
(168, 3, 1, 2, '2025-04-11 14:29:48'),
(169, 3, 1, 3, '2025-04-11 14:29:48'),
(170, 3, 1, 4, '2025-04-11 14:29:48'),
(171, 3, 1, 5, '2025-04-11 14:29:48'),
(172, 3, 2, 1, '2025-04-11 14:29:48'),
(173, 3, 2, 2, '2025-04-11 14:29:48'),
(174, 3, 2, 3, '2025-04-11 14:29:48'),
(175, 3, 2, 4, '2025-04-11 14:29:48'),
(176, 3, 2, 5, '2025-04-11 14:29:48'),
(177, 3, 3, 1, '2025-04-11 14:29:48'),
(178, 3, 3, 2, '2025-04-11 14:29:48'),
(179, 3, 3, 3, '2025-04-11 14:29:48'),
(180, 3, 3, 4, '2025-04-11 14:29:48'),
(181, 3, 3, 5, '2025-04-11 14:29:48'),
(182, 3, 4, 1, '2025-04-11 14:29:48'),
(183, 3, 4, 2, '2025-04-11 14:29:48'),
(184, 3, 4, 3, '2025-04-11 14:29:48'),
(185, 3, 4, 4, '2025-04-11 14:29:48'),
(186, 3, 4, 5, '2025-04-11 14:29:48'),
(187, 3, 5, 1, '2025-04-11 14:29:48'),
(188, 3, 5, 2, '2025-04-11 14:29:48'),
(189, 3, 5, 3, '2025-04-11 14:29:48'),
(190, 3, 5, 4, '2025-04-11 14:29:48'),
(191, 3, 5, 5, '2025-04-11 14:29:48'),
(226, 18, 1, 1, '2025-04-11 14:29:48'),
(227, 18, 1, 2, '2025-04-11 14:29:48'),
(228, 18, 1, 3, '2025-04-11 14:29:48'),
(229, 18, 1, 4, '2025-04-11 14:29:48'),
(230, 18, 1, 5, '2025-04-11 14:29:48'),
(231, 18, 2, 1, '2025-04-11 14:29:48'),
(232, 18, 2, 2, '2025-04-11 14:29:48'),
(233, 18, 2, 3, '2025-04-11 14:29:48'),
(234, 18, 2, 4, '2025-04-11 14:29:48'),
(235, 18, 2, 5, '2025-04-11 14:29:48'),
(236, 18, 3, 1, '2025-04-11 14:29:48'),
(237, 18, 3, 2, '2025-04-11 14:29:48'),
(238, 18, 3, 3, '2025-04-11 14:29:48'),
(239, 18, 3, 4, '2025-04-11 14:29:48'),
(240, 18, 3, 5, '2025-04-11 14:29:48'),
(241, 18, 4, 1, '2025-04-11 14:29:48'),
(242, 18, 4, 2, '2025-04-11 14:29:48'),
(243, 18, 4, 3, '2025-04-11 14:29:48'),
(244, 18, 4, 4, '2025-04-11 14:29:48'),
(245, 18, 4, 5, '2025-04-11 14:29:48'),
(246, 18, 5, 1, '2025-04-11 14:29:48'),
(247, 18, 5, 2, '2025-04-11 14:29:48'),
(248, 18, 5, 3, '2025-04-11 14:29:48'),
(249, 18, 5, 4, '2025-04-11 14:29:48'),
(250, 18, 5, 5, '2025-04-11 14:29:48'),
(251, 8, 1, 1, '2025-04-11 14:38:57'),
(252, 8, 1, 2, '2025-04-11 14:38:57'),
(253, 8, 1, 3, '2025-04-11 14:38:57'),
(254, 8, 1, 4, '2025-04-11 14:38:57'),
(255, 8, 1, 5, '2025-04-11 14:38:57'),
(256, 8, 2, 1, '2025-04-11 14:38:57'),
(257, 8, 2, 2, '2025-04-11 14:38:57'),
(258, 8, 2, 3, '2025-04-11 14:38:57'),
(259, 8, 2, 4, '2025-04-11 14:38:57'),
(260, 8, 2, 5, '2025-04-11 14:38:57'),
(261, 8, 3, 1, '2025-04-11 14:38:57'),
(262, 8, 3, 2, '2025-04-11 14:38:57'),
(263, 8, 3, 3, '2025-04-11 14:38:57'),
(264, 8, 3, 4, '2025-04-11 14:38:57'),
(265, 8, 3, 5, '2025-04-11 14:38:57'),
(266, 8, 4, 1, '2025-04-11 14:38:57'),
(267, 8, 4, 2, '2025-04-11 14:38:57'),
(268, 8, 4, 3, '2025-04-11 14:38:57'),
(269, 8, 4, 4, '2025-04-11 14:38:57'),
(270, 8, 4, 5, '2025-04-11 14:38:57'),
(271, 8, 5, 1, '2025-04-11 14:38:57'),
(272, 8, 5, 2, '2025-04-11 14:38:57'),
(273, 8, 5, 3, '2025-04-11 14:38:57'),
(274, 8, 5, 4, '2025-04-11 14:38:57'),
(275, 8, 5, 5, '2025-04-11 14:38:57'),
(276, 19, 1, 1, '2025-04-11 14:58:05'),
(277, 19, 1, 2, '2025-04-11 14:58:05'),
(278, 19, 1, 3, '2025-04-11 14:58:05'),
(279, 19, 1, 4, '2025-04-11 14:58:05'),
(280, 19, 1, 5, '2025-04-11 14:58:05'),
(281, 19, 2, 1, '2025-04-11 14:58:05'),
(282, 19, 2, 2, '2025-04-11 14:58:05'),
(283, 19, 2, 3, '2025-04-11 14:58:05'),
(284, 19, 2, 4, '2025-04-11 14:58:05'),
(285, 19, 2, 5, '2025-04-11 14:58:05'),
(286, 19, 3, 1, '2025-04-11 14:58:05'),
(287, 19, 3, 2, '2025-04-11 14:58:05'),
(288, 19, 3, 3, '2025-04-11 14:58:05'),
(289, 19, 3, 4, '2025-04-11 14:58:05'),
(290, 19, 3, 5, '2025-04-11 14:58:05'),
(291, 19, 4, 1, '2025-04-11 14:58:05'),
(292, 19, 4, 2, '2025-04-11 14:58:05'),
(293, 19, 4, 3, '2025-04-11 14:58:05'),
(294, 19, 4, 4, '2025-04-11 14:58:05'),
(295, 19, 4, 5, '2025-04-11 14:58:05'),
(296, 19, 5, 1, '2025-04-11 14:58:05'),
(297, 19, 5, 2, '2025-04-11 14:58:05'),
(298, 19, 5, 3, '2025-04-11 14:58:05'),
(299, 19, 5, 4, '2025-04-11 14:58:05'),
(300, 19, 5, 5, '2025-04-11 14:58:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sizes`
--

CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sizes`
--

INSERT INTO `sizes` (`id`, `name`) VALUES
(1, 'S'),
(2, 'M'),
(3, 'L'),
(4, 'XL'),
(5, 'XXL');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `password`, `address`, `role`, `created_at`, `status`) VALUES
(1, 'Admin User', '0123456789', 'admin@example.com', 'admin123', '123 Admin St', 'admin', '2025-03-25 17:29:54', 'active'),
(2, 'Normal User 123 update1', '0987654321', 'user@example.com', 'user123', '456 User Rd', 'user', '2025-03-25 17:29:54', 'active'),
(4, 'user2', '0386181997', 'user2@example.com', '$2y$10$t0iUJNE0kCkpFMwO0laUEuh/OjjnH.6nl.Oflv2z8sRaUqpu3s9de', 'Viet nam', 'user', '2025-03-26 03:25:43', 'active'),
(8, 'Đức', '0329068288', 'ducsen12haha@gmail.com', '$2y$10$LnnNhOuLXTPaVvQtUKIMzexiljb1gEjxEkGNnHbHMOH1JqEU.mG4C', 'Viet nam', 'admin', '2025-03-29 05:23:36', 'active'),
(9, 'Trần Anh', '0989987657', 'anh271099@gmail.com', '$2y$10$J3WIRx1hZszT.JSyeLyAy.lNwJX87Y3nyVh/RtMwA0Ur9POoLQ0Iu', 'viet nam', 'user', '2025-03-30 10:18:08', 'active'),
(10, 'Anh Duc', '0975434567', 'anhducvipbro@gmail.com', '$2y$10$IjnR7KDNvp.10tyBYh0ow.ulNd..LeLi5O/YcS0dRUZ7RdxU7INV6', 'viet nam', 'user', '2025-03-30 10:19:44', 'active'),
(11, 'ducanh99', '0878986543', 'ducanh271099@gmail.com', '$2y$10$WZz3/9h7MeF4xc6Vxm3ZgO1MlVBqIzQcRy1C..EB0UYqMuO7kBMZq', 'viet nam', 'user', '2025-03-30 10:28:03', 'active'),
(12, 'ducanhtran', '0856678888', 'email27@gmail.com', '$2y$10$nGjEr0mUEsC0aaQXUn2.dOP90eyZBXktRJpGf/vpyvAXbkew2ikyO', 'viet nam', 'user', '2025-03-31 02:34:44', 'active'),
(13, 'dfdvdfđfdfcd', '0919985467', 'test2@gmail.com', '$2y$10$57fL3LJ5IZ9PNf2I9Q0Rs.BnLvHpijKFQKmf4/YTPaDGdwKmFN/my', 'ha nam', 'user', '2025-04-06 06:38:16', 'active');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `discount_codes`
--
ALTER TABLE `discount_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_variant_id` (`product_variant_id`);

--
-- Chỉ mục cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Chỉ mục cho bảng `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `discount_codes`
--
ALTER TABLE `discount_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT cho bảng `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `fk_color_id` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`),
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_size_id` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variants_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variants_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
