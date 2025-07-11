-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th6 29, 2022 lúc 02:49 AM
-- Phiên bản máy phục vụ: 5.7.33
-- Phiên bản PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `jelly_boutique`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `banners`
--

INSERT INTO `banners` (`id`, `title`, `slug`, `photo`, `description`, `status`, `created_at`, `updated_at`) VALUES
(2, '.', 'lorem-ipsum', '/storage/photos/33/Banner/Screenshot 2022-05-21 230011.jpg', '<h2><span style=\"font-weight: bold; color: rgb(99, 99, 99);\">Giảm tới 30%</span></h2>', 'active', '2020-08-14 01:50:23', '2022-05-21 09:01:16'),
(4, '.', 'banner', '/storage/photos/33/Banner/Screenshot 2022-05-21 225925.jpg', '<blockquote><h2><span style=\"font-weight: bold; color: rgb(99, 99, 99);\">Miễn phí giao hàng cho đơn trên 1.000.000đ</span></h2><h6><span style=\"font-family: &quot;Arial Black&quot;;\">﻿</span></h6></blockquote><h2><span style=\"color: rgb(156, 0, 255);\"></span></h2>', 'active', '2020-08-17 20:46:59', '2022-05-21 09:01:03'),
(5, 'Công sở lịch lãm', 'banner-test', '/storage/photos/33/Banner/Vest.jpg', '<h2><span style=\"font-weight: bold; color: rgb(99, 99, 99);\">Giảm tới 10%</span></h2>', 'active', '2022-04-10 09:30:00', '2022-04-28 01:37:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `title`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Adidas', 'adidas', 'active', '2020-08-14 04:23:00', '2020-08-14 04:23:00'),
(2, 'Nike', 'nike', 'active', '2020-08-14 04:23:08', '2020-08-14 04:23:08'),
(3, 'Kappa', 'kappa', 'active', '2020-08-14 04:23:48', '2020-08-14 04:23:48'),
(4, 'Prada', 'prada', 'active', '2020-08-14 04:24:08', '2020-08-14 04:24:08'),
(7, 'Việt Tiến', 'viet-tien', 'active', '2022-04-25 11:12:56', '2022-04-25 11:12:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  `status` enum('new','progress','delivered','cancel') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `quantity` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `product_id`, `order_id`, `user_id`, `price`, `status`, `quantity`, `amount`, `created_at`, `updated_at`) VALUES
(19, 11, 10, 35, 1600000.00, 'new', 1, 2000000.00, '2022-04-25 10:38:42', '2022-04-25 10:39:55'),
(20, 11, 11, 35, 1600000.00, 'new', 2, 3600000.00, '2022-04-27 00:53:45', '2022-04-27 00:57:49'),
(21, 14, 11, 35, 180000.00, 'new', 1, 180000.00, '2022-04-27 00:55:46', '2022-04-27 00:57:49'),
(22, 18, 12, 35, 382500.00, 'new', 100, 38250000.00, '2022-04-28 11:38:34', '2022-05-09 09:35:18'),
(23, 16, 12, 35, 180000.00, 'new', 1, 180000.00, '2022-04-28 11:38:44', '2022-05-09 09:35:18'),
(24, 17, 12, 35, 360000.00, 'new', 1, 360000.00, '2022-04-29 00:44:54', '2022-05-09 09:35:18'),
(25, 12, 12, 35, 540000.00, 'new', 1, 540000.00, '2022-05-09 09:33:57', '2022-05-09 09:35:18'),
(26, 17, 13, 34, 360000.00, 'new', 1, 360000.00, '2022-05-09 09:41:16', '2022-05-09 09:47:04'),
(27, 16, 15, 34, 180000.00, 'new', 2, 360000.00, '2022-05-09 10:47:54', '2022-05-19 11:34:05'),
(29, 17, 14, 37, 360000.00, 'new', 1, 360000.00, '2022-05-11 10:54:55', '2022-05-11 11:00:53'),
(31, 11, 15, 34, 1600000.00, 'new', 12, 19200000.00, '2022-05-19 11:32:16', '2022-05-19 11:34:05'),
(32, 17, 16, 34, 360000.00, 'new', 1, 360000.00, '2022-05-21 07:18:37', '2022-05-21 07:29:08'),
(33, 18, NULL, 34, 382500.00, 'new', 1, 382500.00, '2022-05-21 07:29:29', '2022-05-21 07:29:29'),
(34, 18, 17, 38, 382500.00, 'new', 1, 382500.00, '2022-05-21 09:08:52', '2022-05-21 09:09:45'),
(35, 19, 18, 38, 171000.00, 'new', 1, 190000.00, '2022-05-21 18:26:37', '2022-05-21 18:28:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_parent` tinyint(1) NOT NULL DEFAULT '1',
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `summary`, `photo`, `is_parent`, `parent_id`, `added_by`, `status`, `created_at`, `updated_at`) VALUES
(9, 'Đồ công sở nam', 'vest-cong-so-nam', '<p>Vest công sở nam</p>', '/storage/photos/33/Banner/mini-banner1.jpg', 1, NULL, NULL, 'active', '2022-04-25 09:27:30', '2022-04-25 10:19:50'),
(10, 'Đồng hồ nam', 'dong-ho-nam', '<p>Đồng hồ nam</p>', NULL, 0, 9, NULL, 'active', '2022-04-25 09:27:48', '2022-04-25 09:30:18'),
(11, 'Đồ công sở nữ', 'dam-cong-so-nu', '<p>Đầm công sở nữ</p>', '/storage/photos/33/Banner/mini-banner1.jpg', 1, NULL, NULL, 'active', '2022-04-25 09:28:07', '2022-04-25 10:19:20'),
(14, 'Áo sơ mi nam', 'ao-so-mi-nam', '<p>Áo sơ mi nam</p>', '/storage/photos/33/Product/aa423-mpd012t.jpg', 0, 9, NULL, 'active', '2022-04-25 09:29:11', '2022-04-28 10:33:45'),
(15, 'Quần âu', 'quan-au', '<p>Quần âu</p>', '/storage/photos/33/Product/6cb7c-pmo002b.jpg', 0, 9, NULL, 'active', '2022-04-25 09:32:55', '2022-04-28 10:34:05'),
(17, 'Đầm công sở nữ', 'dam-cong-so-nu-2204253440-907', '<p>Đầm công sở nữ<br></p>', '/storage/photos/33/Product/0122b-wsd000t.jpg', 0, 11, NULL, 'active', '2022-04-25 09:34:40', '2022-04-28 10:34:17'),
(18, 'Đồ thể thao nam', 'do-the-thao-nam', '<p>Đồ thể thao nam</p>', '/storage/photos/33/Banner/mini-banner1.jpg', 1, NULL, NULL, 'active', '2022-04-25 09:39:45', '2022-04-25 10:19:36'),
(19, 'Đồ thể thao nữ', 'do-the-thao-nu', '<p>Đồ thể thao nữ<br></p>', '/storage/photos/33/Banner/mini-banner1.jpg', 1, NULL, NULL, 'active', '2022-04-25 09:39:54', '2022-04-28 10:35:31'),
(22, 'Áo Vest nam', 'ao-vest-nam', '<p>Áo Vest nam<br></p>', '/storage/photos/33/Product/3a815-pmo002a.jpg', 0, 9, NULL, 'active', '2022-04-25 10:24:10', '2022-04-28 10:35:45'),
(23, 'Áo phông', 'ao-phong', '<p>Áo phông<br></p>', '/storage/photos/33/Product/c2ae6-n1.jpg', 0, 18, NULL, 'active', '2022-04-25 11:04:33', '2022-04-28 10:35:56'),
(24, 'Áo chạy bộ nữ', 'ao-chay-bo-nu', '<p>Áo chạy bộ nữ<br></p>', '/storage/photos/33/Product/d3fdb-image2xxl-4-.jpg', 0, 19, NULL, 'active', '2022-04-25 11:06:50', '2022-04-28 10:36:06'),
(25, 'Áo thể thao', 'ao-the-thao', '<p>Áo thể thao</p>', '/storage/photos/33/Product/bo_the_thao_tap_gym.jpg', 0, 18, NULL, 'active', '2022-04-28 02:06:45', '2022-04-28 10:36:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('fixed','percent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `value` decimal(20,2) NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `status`, `created_at`, `updated_at`) VALUES
(6, 'GIAMGIAT4', 'percent', '11.00', 'active', '2022-04-25 11:42:51', '2022-04-25 11:43:59'),
(7, 'LOVE-JELLY', 'percent', '20.00', 'active', '2022-04-25 11:43:49', '2022-04-25 11:43:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_07_10_021010_create_brands_table', 1),
(5, '2020_07_10_025334_create_banners_table', 1),
(6, '2020_07_10_112147_create_categories_table', 1),
(7, '2020_07_11_063857_create_products_table', 1),
(8, '2020_07_12_073132_create_post_categories_table', 1),
(9, '2020_07_12_073701_create_post_tags_table', 1),
(10, '2020_07_12_083638_create_posts_table', 1),
(11, '2020_07_13_151329_create_messages_table', 1),
(12, '2020_07_14_023748_create_shippings_table', 1),
(13, '2020_07_15_054356_create_orders_table', 1),
(14, '2020_07_15_102626_create_carts_table', 1),
(15, '2020_07_16_041623_create_notifications_table', 1),
(16, '2020_07_16_053240_create_coupons_table', 1),
(17, '2020_07_23_143757_create_wishlists_table', 1),
(18, '2020_07_24_074930_create_product_reviews_table', 1),
(19, '2020_07_24_131727_create_post_comments_table', 1),
(20, '2020_08_01_143408_create_settings_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('150cdcf5-c912-4383-a96d-5538d878448c', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/5\",\"fas\":\"fa-file-alt\"}', NULL, '2022-04-10 08:56:44', '2022-04-10 08:56:44'),
('2145a8e3-687d-444a-8873-b3b2fb77a342', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New Comment created\",\"actionURL\":\"http:\\/\\/e-shop.loc\\/blog-detail\\/where-can-i-get-some\",\"fas\":\"fas fa-comment\"}', NULL, '2020-08-15 07:31:21', '2020-08-15 07:31:21'),
('33fbcd3a-160e-417c-b742-c46af5288b2f', 'App\\Notifications\\StatusNotification', 'App\\User', 33, '{\"title\":\"C\\u00f3 \\u0111\\u01a1n h\\u00e0ng m\\u1edbi\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/11\",\"fas\":\"fa-file-alt\"}', '2022-05-19 11:30:41', '2022-04-27 00:57:49', '2022-05-19 11:30:41'),
('3762a12a-e923-4815-8054-e7ca59d9e605', 'App\\Notifications\\StatusNotification', 'App\\User', 33, '{\"title\":\"C\\u00f3 \\u0111\\u01a1n h\\u00e0ng m\\u1edbi\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/17\",\"fas\":\"fa-file-alt\"}', NULL, '2022-05-21 09:09:44', '2022-05-21 09:09:44'),
('3af39f84-cab4-4152-9202-d448435c67de', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/localhost:8000\\/admin\\/order\\/4\",\"fas\":\"fa-file-alt\"}', NULL, '2020-08-15 07:54:52', '2020-08-15 07:54:52'),
('3c496f77-eaac-468c-b202-afd69c7445e7', 'App\\Notifications\\StatusNotification', 'App\\User', 33, '{\"title\":\"C\\u00f3 \\u0111\\u01a1n h\\u00e0ng m\\u1edbi\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/16\",\"fas\":\"fa-file-alt\"}', NULL, '2022-05-21 07:29:07', '2022-05-21 07:29:07'),
('49e28d05-dc44-4650-b427-20e9136c6bfd', 'App\\Notifications\\StatusNotification', 'App\\User', 33, '{\"title\":\"B\\u00ecnh lu\\u1eadn m\\u1edbi \\u0111\\u01b0\\u1ee3c t\\u1ea1o\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/blog-detail\\/mua-quan-ao-online-lieu-co-thuc-su-tot\",\"fas\":\"fas fa-comment\"}', '2022-04-25 11:44:37', '2022-04-25 11:32:08', '2022-04-25 11:44:37'),
('4a0afdb0-71ad-4ce6-bc70-c92ef491a525', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New Comment created\",\"actionURL\":\"http:\\/\\/localhost:8000\\/blog-detail\\/the-standard-lorem-ipsum-passage-used-since-the-1500s\",\"fas\":\"fas fa-comment\"}', NULL, '2020-08-17 21:13:51', '2020-08-17 21:13:51'),
('540ca3e9-0ff9-4e2e-9db3-6b5abc823422', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New Comment created\",\"actionURL\":\"http:\\/\\/e-shop.loc\\/blog-detail\\/where-can-i-get-some\",\"fas\":\"fas fa-comment\"}', '2020-08-15 07:30:44', '2020-08-14 07:12:28', '2020-08-15 07:30:44'),
('598c4988-99ff-44c6-8bee-a8c692b573c0', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/6\",\"fas\":\"fa-file-alt\"}', NULL, '2022-04-11 08:26:33', '2022-04-11 08:26:33'),
('5c589337-cb66-4e08-b4bb-dfacb2e6a682', 'App\\Notifications\\StatusNotification', 'App\\User', 33, '{\"title\":\"C\\u00f3 \\u0111\\u01a1n h\\u00e0ng m\\u1edbi\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/12\",\"fas\":\"fa-file-alt\"}', '2022-05-19 11:30:46', '2022-04-29 00:56:30', '2022-05-19 11:30:46'),
('5d8b5057-0447-4c06-817e-e3dbdd424170', 'App\\Notifications\\StatusNotification', 'App\\User', 33, '{\"title\":\"C\\u00f3 \\u0111\\u00e1nh gi\\u00e1 s\\u1ea3n ph\\u1ea9m m\\u1edbi!\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/product-detail\\/bo-tap-gym-nu\",\"fas\":\"fa-star\"}', '2022-05-19 11:30:49', '2022-04-28 09:59:54', '2022-05-19 11:30:49'),
('5da09dd1-3ffc-43b0-aba2-a4260ba4cc76', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New Comment created\",\"actionURL\":\"http:\\/\\/localhost:8000\\/blog-detail\\/the-standard-lorem-ipsum-passage\",\"fas\":\"fas fa-comment\"}', NULL, '2020-08-15 07:51:02', '2020-08-15 07:51:02'),
('5e91e603-024e-45c5-b22f-36931fef0d90', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New Product Rating!\",\"actionURL\":\"http:\\/\\/localhost:8000\\/product-detail\\/white-sports-casual-t\",\"fas\":\"fa-star\"}', NULL, '2020-08-15 07:44:07', '2020-08-15 07:44:07'),
('73a3b51a-416a-4e7d-8ca2-53b216d9ad8e', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New Comment created\",\"actionURL\":\"http:\\/\\/e-shop.loc\\/blog-detail\\/where-can-i-get-some\",\"fas\":\"fas fa-comment\"}', NULL, '2020-08-14 07:11:03', '2020-08-14 07:11:03'),
('754c75a1-ccc0-4200-b6df-95f85fd8813e', 'App\\Notifications\\StatusNotification', 'App\\User', 33, '{\"title\":\"C\\u00f3 \\u0111\\u01a1n h\\u00e0ng m\\u1edbi\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/18\",\"fas\":\"fa-file-alt\"}', NULL, '2022-05-21 18:28:12', '2022-05-21 18:28:12'),
('81942209-edba-4829-b459-24de3fcc621b', 'App\\Notifications\\StatusNotification', 'App\\User', 33, '{\"title\":\"C\\u00f3 \\u0111\\u01a1n h\\u00e0ng m\\u1edbi\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/12\",\"fas\":\"fa-file-alt\"}', '2022-05-09 09:36:53', '2022-05-09 09:35:18', '2022-05-09 09:36:53'),
('8605db5d-1462-496e-8b5f-8b923d88912c', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/e-shop.loc\\/admin\\/order\\/1\",\"fas\":\"fa-file-alt\"}', NULL, '2020-08-14 07:20:44', '2020-08-14 07:20:44'),
('86cc4893-9589-4508-8f2c-7b8fe3d6868c', 'App\\Notifications\\StatusNotification', 'App\\User', 33, '{\"title\":\"C\\u00f3 \\u0111\\u01a1n h\\u00e0ng m\\u1edbi\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/14\",\"fas\":\"fa-file-alt\"}', '2022-05-19 11:30:24', '2022-05-11 11:00:52', '2022-05-19 11:30:24'),
('97542d15-92d0-441a-8db2-2e6fd6ac8ea9', 'App\\Notifications\\StatusNotification', 'App\\User', 33, '{\"title\":\"C\\u00f3 \\u0111\\u01a1n h\\u00e0ng m\\u1edbi\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/15\",\"fas\":\"fa-file-alt\"}', '2022-05-19 11:34:35', '2022-05-19 11:34:04', '2022-05-19 11:34:35'),
('9a44d5e2-0e99-4f56-b514-e18d619834eb', 'App\\Notifications\\StatusNotification', 'App\\User', 33, '{\"title\":\"C\\u00f3 \\u0111\\u01a1n h\\u00e0ng m\\u1edbi\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/13\",\"fas\":\"fa-file-alt\"}', '2022-05-19 11:30:38', '2022-05-09 09:47:04', '2022-05-19 11:30:38'),
('a6ec5643-748c-4128-92e2-9a9f293f53b5', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/localhost:8000\\/admin\\/order\\/5\",\"fas\":\"fa-file-alt\"}', NULL, '2020-08-17 21:17:03', '2020-08-17 21:17:03'),
('a8e2cdc0-722b-47d6-a410-45eafdea38b7', 'App\\Notifications\\StatusNotification', 'App\\User', 33, '{\"title\":\"B\\u00ecnh lu\\u1eadn m\\u1edbi \\u0111\\u01b0\\u1ee3c t\\u1ea1o\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/blog-detail\\/mua-quan-ao-online-lieu-co-thuc-su-tot\",\"fas\":\"fas fa-comment\"}', '2022-04-25 11:39:30', '2022-04-25 11:32:29', '2022-04-25 11:39:30'),
('aab7f84a-357c-4b07-b5ae-92e6a4f06681', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/8\",\"fas\":\"fa-file-alt\"}', NULL, '2022-04-11 09:23:01', '2022-04-11 09:23:01'),
('b186a883-42f2-4a05-8fc5-f0d3e10309ff', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/e-shop.loc\\/admin\\/order\\/2\",\"fas\":\"fa-file-alt\"}', '2020-08-15 04:17:24', '2020-08-14 22:14:55', '2020-08-15 04:17:24'),
('d2fd7c33-b0fe-47d6-8bc6-f377d404080d', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New Comment created\",\"actionURL\":\"http:\\/\\/e-shop.loc\\/blog-detail\\/where-can-i-get-some\",\"fas\":\"fas fa-comment\"}', NULL, '2020-08-14 07:08:50', '2020-08-14 07:08:50'),
('d5578f59-dd6b-4b66-b033-42503d720fec', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/9\",\"fas\":\"fa-file-alt\"}', NULL, '2022-04-11 09:28:24', '2022-04-11 09:28:24'),
('dff78b90-85c8-42ee-a5b1-de8ad0b21be4', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/e-shop.loc\\/admin\\/order\\/3\",\"fas\":\"fa-file-alt\"}', NULL, '2020-08-15 06:40:54', '2020-08-15 06:40:54'),
('e28b0a73-4819-4016-b915-0e525d4148f5', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New Product Rating!\",\"actionURL\":\"http:\\/\\/localhost:8000\\/product-detail\\/lorem-ipsum-is-simply\",\"fas\":\"fa-star\"}', NULL, '2020-08-17 21:08:16', '2020-08-17 21:08:16'),
('e2c9c58b-a066-4bee-ae6e-48c191dc1d39', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New order created\",\"actionURL\":\"http:\\/\\/jellyboutique.vtest:85\\/admin\\/order\\/7\",\"fas\":\"fa-file-alt\"}', NULL, '2022-04-11 08:37:28', '2022-04-11 08:37:28'),
('ffffa177-c54e-4dfe-ba43-27c466ff1f4b', 'App\\Notifications\\StatusNotification', 'App\\User', 1, '{\"title\":\"New Comment created\",\"actionURL\":\"http:\\/\\/localhost:8000\\/blog-detail\\/the-standard-lorem-ipsum-passage-used-since-the-1500s\",\"fas\":\"fas fa-comment\"}', NULL, '2020-08-17 21:13:29', '2020-08-17 21:13:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_total` double(10,2) NOT NULL,
  `shipping_id` bigint(20) UNSIGNED DEFAULT NULL,
  `coupon` double(10,2) DEFAULT NULL,
  `total_amount` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `payment_method` enum('cod','paypal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cod',
  `payment_status` enum('paid','unpaid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `status` enum('new','process','delivered','cancel') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `sub_total`, `shipping_id`, `coupon`, `total_amount`, `quantity`, `payment_method`, `payment_status`, `status`, `first_name`, `last_name`, `email`, `phone`, `country`, `post_code`, `address1`, `address2`, `created_at`, `updated_at`) VALUES
(6, 'ORD-T0HFZM7VQ0', NULL, 730.00, 4, NULL, 1130.00, 3, 'cod', 'unpaid', 'cancel', 'Nguyễn', 'Thịnh', 'thinhphuongxa1@gmail.com', '0398314279', 'NP', '1313', 'http://giathinh.phanmemnhathuoc.vn', NULL, '2022-04-11 08:26:32', '2022-05-19 10:34:56'),
(9, 'ORD-00FKLQNRYA', NULL, 380.00, 4, 250.00, 530.00, 2, 'cod', 'unpaid', 'delivered', 'Nguyễn', 'Thịnh', 'thinhphuongxa1@gmail.com', '0398314279', 'VN', '1234', 'http://giathinh.phanmemnhathuoc.vn', 'Hai Ba Trung', '2022-04-11 09:28:24', '2022-05-19 11:29:11'),
(10, 'ORD-YJMQSPUTSB', 35, 2000000.00, 4, NULL, 2000400.00, 1, 'cod', 'unpaid', 'delivered', 'Thịnh', 'Nguyễn', 'thinhphuongxa1@gmail.com', '0398314279', 'NP', NULL, 'http://giathinh.phanmemnhathuoc.vn', NULL, '2022-04-25 10:39:53', '2022-04-25 11:40:54'),
(11, 'ORD-4A4A0TVRNJ', 35, 3780000.00, 2, NULL, 3810000.00, 3, 'cod', 'unpaid', 'new', 'Nguyễn', 'Thịnh', 'thinhphuongxa1@gmail.com', '0398314279', 'VN', NULL, 'Quảng Cáo Hội Hồng - Xã Minh Tân - Huyện Cẩm Khê - Tỉnh Phú Thọ', NULL, '2022-04-27 00:57:49', '2022-04-27 00:57:49'),
(12, 'ORD-HZKZWEM4TO', 35, 39330000.00, 4, NULL, 39365000.00, 103, 'cod', 'unpaid', 'delivered', 'Nguyễn', 'Thịnh', 'thinhphuongxa1@gmail.com', '0398314279', 'VN', NULL, 'http://giathinh.phanmemnhathuoc.vn', NULL, '2022-05-09 09:35:16', '2022-05-09 09:37:12'),
(13, 'ORD-IQ8EYKIKJ8', 34, 360000.00, 4, NULL, 395000.00, 1, 'cod', 'unpaid', 'delivered', 'Linh', 'Cao', 'linh@gmail.com', '0999888777', 'VN', NULL, 'Ninh Bình', NULL, '2022-05-09 09:47:03', '2022-05-19 10:59:25'),
(14, 'ORD-CSQ2VJHIXP', 37, 360000.00, 4, NULL, 395000.00, 1, 'cod', 'unpaid', 'delivered', 'user1', 'user1', 'user1@gmail.com', '0987987897', 'VN', NULL, 'Ninh Bình', NULL, '2022-05-11 11:00:51', '2022-05-19 11:29:42'),
(15, 'ORD-SO8RKE0GGO', 34, 19560000.00, 1, NULL, 19600000.00, 14, 'cod', 'unpaid', 'delivered', 'Linh', 'Cao', 'linh@gmail.com', '0987897987', 'VN', NULL, 'Hà Nội', 'Hà Nội', '2022-04-19 11:34:04', '2022-04-19 11:35:17'),
(16, 'ORD-PQZ1FVKRJT', 34, 360000.00, 4, 39600.00, 355400.00, 1, 'cod', 'unpaid', 'delivered', 'Nguyễn', 'Thịnh', 'thinhphuongxa1@gmail.com', '0999888999', 'VN', NULL, 'Hà Nội', NULL, '2022-05-21 07:29:06', '2022-05-21 07:31:45'),
(17, 'ORD-M3EMSW3DPN', 38, 382500.00, 2, NULL, 412500.00, 1, 'cod', 'unpaid', 'delivered', 'user2', 'user2', 'user2@gmail.com', '0987654123', 'VN', NULL, 'Hà Nội', NULL, '2022-05-21 09:09:42', '2022-05-21 09:10:06'),
(18, 'ORD-CVYRXPXVDE', 38, 190000.00, 3, 18810.00, 211190.00, 1, 'cod', 'unpaid', 'delivered', 'Thịnh', 'Nguyễn', 'thinhphuongxa1@gmail.com', '0398314279', 'VN', NULL, 'Hà Nội', NULL, '2022-05-21 18:28:09', '2022-05-21 18:29:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('thinhtest222@gmail.com', '$2y$10$UpffYw4dpalbkPbK4U.G0eESzAPNL51Z4mMMKJa7Isx5h5Z/owehy', '2022-04-21 07:10:03'),
('thinhtest111@gmail.com', '$2y$10$Bs7ZIpjeJxaXkcZJVQsA2OdoPec6PNN6Co7CWD4OwEGeKnldJqgg2', '2022-04-21 07:15:47'),
('thinhphuongxa1@gmail.com', '$2y$10$zrt0Y16waKaRz4oX1sYgteMUFa2PGL9.ubqeQwA1f9nObdcg4MvXO', '2022-05-19 09:44:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `quote` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_cat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `post_tag_id` bigint(20) UNSIGNED DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `summary`, `description`, `quote`, `photo`, `tags`, `post_cat_id`, `post_tag_id`, `added_by`, `status`, `created_at`, `updated_at`) VALUES
(7, 'Đồ công sở, màu nào phù hợp với bạn ?', 'do-cong-so-mau-nao-phu-hop-voi-ban', '<p>Đồ công sở, màu nào phù hợp với bạn ?<br></p>', '<p>Đồ công sở, màu nào phù hợp với bạn ?<br></p>', '<p>Đồ công sở, màu nào phù hợp với bạn ?<br></p>', '/storage/photos/33/Blog/blog1.jpg', '', 7, NULL, 35, 'active', '2022-04-25 11:24:08', '2022-04-25 11:24:08'),
(9, 'Chọn quần áo sao cho phù hợp ?', 'chon-quan-ao-sao-cho-phu-hop', '<p>Chọn quần áo sao cho phù hợp ?<br></p>', '<p>Chọn quần áo sao cho phù hợp ?<br></p>', '<p>Chọn quần áo sao cho phù hợp ?<br></p>', '/storage/photos/33/Blog/blog2.jpg', '', 9, NULL, 35, 'active', '2022-04-25 11:28:27', '2022-04-25 11:28:27'),
(10, 'Mua quần áo Online, liệu có thực sự tốt ?', 'mua-quan-ao-online-lieu-co-thuc-su-tot', '<p>Mua quần áo Online, liệu có thực sự tốt ?<br></p>', '<p>Mua quần áo Online, liệu có thực sự tốt ?<br></p>', '<p>Mua quần áo Online, liệu có thực sự tốt ?<br></p>', '/storage/photos/33/Blog/blog3.jpg', '', 9, NULL, 34, 'active', '2022-04-25 11:31:35', '2022-04-25 11:31:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_categories`
--

CREATE TABLE `post_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `post_categories`
--

INSERT INTO `post_categories` (`id`, `title`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Thể thao', 'the-thao', 'active', '2022-04-25 11:20:11', '2022-04-25 11:20:11'),
(7, 'Công sở', 'cong-so', 'active', '2022-04-25 11:20:18', '2022-04-25 11:20:18'),
(8, 'Bảo quản quần áo', 'bao-quan-quan-ao', 'active', '2022-04-25 11:20:27', '2022-04-25 11:20:27'),
(9, 'Cách chọn quần áo', 'cach-chon-quan-ao', 'active', '2022-04-25 11:27:59', '2022-04-25 11:27:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_comments`
--

CREATE TABLE `post_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `post_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `replied_comment` text COLLATE utf8mb4_unicode_ci,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `post_comments`
--

INSERT INTO `post_comments` (`id`, `user_id`, `post_id`, `comment`, `status`, `replied_comment`, `parent_id`, `created_at`, `updated_at`) VALUES
(8, 33, 10, 'Có khả năng', 'active', NULL, NULL, '2022-04-25 11:32:08', '2022-04-27 01:59:30'),
(9, 33, 10, 'Tớ tự rep comment của tớ nè', 'inactive', NULL, 8, '2022-04-25 11:32:29', '2022-04-27 01:59:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_tags`
--

CREATE TABLE `post_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `post_tags`
--

INSERT INTO `post_tags` (`id`, `title`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Công sở', 'cong-so', 'active', '2022-04-25 11:34:58', '2022-04-25 11:34:58'),
(6, 'Thể thao', 'the-thao', 'active', '2022-04-25 11:35:05', '2022-04-25 11:35:05'),
(7, 'Bảo quản quần áo', 'bao-quan-quan-ao', 'active', '2022-04-25 11:35:17', '2022-04-25 11:35:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `photo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL DEFAULT '1',
  `size` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'M',
  `condition` enum('default','new','hot') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `price` double(20,2) NOT NULL,
  `discount` double(10,2) NOT NULL,
  `is_featured` tinyint(1) NOT NULL,
  `cat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `child_cat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `summary`, `description`, `photo`, `stock`, `size`, `condition`, `status`, `price`, `discount`, `is_featured`, `cat_id`, `child_cat_id`, `brand_id`, `created_at`, `updated_at`) VALUES
(11, 'Áo Vest', 'ao-vest', '<p>Áo Vest<br></p>', '<p>Áo Vest<br></p>', '/storage/photos/33/Product/3a815-pmo002a.jpg', 17, 'L,XL', 'new', 'active', 2000000.00, 20.00, 0, 9, 22, 4, '2022-04-25 10:28:25', '2022-05-19 11:35:17'),
(12, 'Đầm công sở nữ', 'dam-cong-so-nu', '<p>Đầm công sở nữ<br></p>', '<p>Đầm công sở nữ<br></p>', '/storage/photos/33/Product/0122b-wsd000t.jpg', 19, 'S,M,L', 'hot', 'active', 600000.00, 10.00, 1, 11, 17, 4, '2022-04-25 10:51:20', '2022-05-09 09:37:12'),
(13, 'Áo sơ mi nam', 'ao-so-mi-nam', '<p>Áo sơ mi nam<br></p>', '<p>Áo sơ mi nam<br></p>', '/storage/photos/33/Product/aa423-mpd012t.jpg', 40, 'M,L,XL', 'hot', 'active', 400000.00, 12.00, 1, 9, 14, 2, '2022-04-25 10:59:53', '2022-04-25 10:59:53'),
(14, 'Áo phông Kappa', 'ao-phong-kappa', '<p>Áo phông Kappa<br></p>', '<p>Áo phông Kappa<br></p>', '/storage/photos/33/Product/c2ae6-n1.jpg', 50, 'M,L,XL', 'hot', 'active', 200000.00, 10.00, 0, 18, 23, 3, '2022-04-25 11:06:08', '2022-04-25 11:06:08'),
(15, 'Áo chạy bộ nữ Prada', 'ao-chay-bo-nu-prada', '<p>Áo chạy bộ nữ Prada<br></p>', '<p>Áo chạy bộ nữ Prada<br></p>', '/storage/photos/33/Product/d3fdb-image2xxl-4-.jpg', 30, 'S,M,L', 'new', 'active', 150000.00, 10.00, 0, 19, 24, 4, '2022-04-25 11:07:53', '2022-04-25 11:07:53'),
(16, 'Áo Tee Tank', 'ao-tee-tank', '<p>Áo Tee Tank<br></p>', '<p>Áo Tee Tank<br></p>', '/storage/photos/33/Product/ao_tee_tank.jpg', 27, 'M,L,XL', 'hot', 'active', 200000.00, 10.00, 1, 18, 23, 4, '2022-04-28 02:05:09', '2022-05-19 11:35:17'),
(17, 'Bộ đồ tập Gym', 'bo-do-tap-gym', '<p>Bộ đồ tập Gym&nbsp;<br></p>', '<p>Bộ đồ tập Gym&nbsp;<br></p>', '/storage/photos/33/Product/bo_the_thao_tap_gym.jpg', 36, 'M,L,XL', 'hot', 'active', 400000.00, 10.00, 1, 18, 25, 4, '2022-04-28 02:10:00', '2022-05-21 07:31:45'),
(18, 'Bộ tập Gym nữ', 'bo-tap-gym-nu', 'Bộ tập Gym nữ', '<p>Bộ tập Gym nữ<br></p>', '/storage/photos/33/Product/bo_tap_gym_nu.jpg', 49, 'S,M,L,XL', 'default', 'active', 450000.00, 15.00, 1, 19, NULL, 3, '2022-04-28 02:13:47', '2022-05-21 09:10:06'),
(19, 'Áo đen', 'ao-den', '<p>Áo đen</p>', '<p>Áo đen siêu đẹp</p>', '/storage/photos/33/Product/ao_tee_tank.jpg', 69, '', 'new', 'active', 190000.00, 10.00, 0, 18, NULL, 3, '2022-05-21 07:27:08', '2022-05-21 18:29:26'),
(20, 'Áo đen thể thao', 'ao-den-the-thao', '<p>áo đẹp</p>', '<p>áo siêu đẹp</p>', '/storage/photos/33/Product/ao_tee_tank.jpg', 20, 'S,M,L,XL', 'new', 'active', 290000.00, 6.00, 1, 18, 25, 4, '2022-05-21 18:30:58', '2022-05-21 18:30:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rate` tinyint(4) NOT NULL DEFAULT '0',
  `review` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `user_id`, `product_id`, `rate`, `review`, `status`, `created_at`, `updated_at`) VALUES
(1, 35, 15, 5, 'Đánh giá ngày 27/4', 'active', '2022-04-27 00:59:36', '2022-04-27 00:59:36'),
(2, 35, 15, 5, 'Đánh giá tiếp theo', 'active', '2022-04-27 01:02:12', '2022-04-27 01:02:12'),
(3, 35, 18, 5, 'Đánh giá thử lại 1 lần', 'active', '2022-04-28 09:59:52', '2022-04-28 09:59:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_des` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `description`, `short_des`, `logo`, `photo`, `address`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Mong muốn đáp ứng nhu cầu của khách hàng.', 'Mong muốn đáp ứng nhu cầu của khách hàng.', '/storage/photos/33/LOGO_1.jpg', '/storage/photos/1/LOGO_1.jpg', 'Phố Nhổn - Hà Nội', '+(84) 398 314 279', 'jellyboutique@gmail.com', NULL, '2022-05-17 01:44:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shippings`
--

CREATE TABLE `shippings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `shippings`
--

INSERT INTO `shippings` (`id`, `type`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hà Nội', '40000.00', 'active', '2020-08-14 04:22:17', '2022-04-25 11:14:54'),
(2, 'Phú Thọ', '30000.00', 'active', '2020-08-14 04:22:41', '2022-04-25 11:15:11'),
(3, 'Vĩnh Phúc', '40000.00', 'active', '2020-08-15 06:54:04', '2022-04-25 11:15:27'),
(4, 'Ninh Bình', '35000.00', 'active', '2020-08-17 20:50:48', '2022-04-25 11:15:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8 NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `role`, `provider`, `provider_id`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(33, 'Admin', 'admin@gmail.com', NULL, '$2y$10$An0KdWoqcI1JK8Fj7Db2burUfxtf2xbNSnLDr.4mbsUqvlR7E954.', '/storage/photos/31/User/42195889_2218845655070033_5061281232172613632_n.jpg', 'admin', NULL, NULL, 'active', 'dyUHoyu1HmJEUogFVZ836TPQ4HmqDQpii7fjDtWRFXp7bUuNJy68KKPo7XxO', NULL, NULL),
(34, 'Linh', 'user@gmail.com', NULL, '$2y$10$An0KdWoqcI1JK8Fj7Db2burUfxtf2xbNSnLDr.4mbsUqvlR7E954.', '/storage/photos/33/User/4-ceo-viet-tuoi-suu-tai-gioi-dang-dieu-hanh-doanh-nghiep-nao.jpg', 'user', NULL, NULL, 'active', NULL, '2022-04-25 09:04:15', '2022-04-25 09:05:00'),
(35, 'Thịnh', 'thinhphuongxa1@gmail.com', NULL, '$2y$10$W8jNnJgUSG5zfXjWPW6KTeaM9uI2U0jOxozG/N0Ody6rf1.X/bssO', '/storage/photos/33/User/logo-comics-food-bar-hd-png.png', 'user', NULL, NULL, 'active', NULL, '2022-04-25 09:04:15', '2022-04-25 09:04:15'),
(36, 'Minh', 'minh@gmail.com', NULL, '$2y$10$AtPfHsxPzg7P8vooZEQBPeIc1mEpWh.sIOG1LNoAWBf9MytBDp5Dm', '/storage/photos/33/User/4-ceo-viet-tuoi-suu-tai-gioi-dang-dieu-hanh-doanh-nghiep-nao.jpg', 'user', NULL, NULL, 'active', NULL, '2022-04-27 02:05:54', '2022-04-28 11:11:36'),
(37, 'user1', 'user1@gmail.com', NULL, '$2y$10$kxkc4NscWvCxh0t/7nYIqOCOSJPwfrMLmawfwmxnJlCAFcbLvZWfC', NULL, 'user', NULL, NULL, 'active', NULL, '2022-05-11 10:04:16', '2022-05-11 10:04:16'),
(38, 'user2', 'user2@gmail.com', NULL, '$2y$10$RwduGWnyr96mK.DqvYi5Cex7ZujywKNJQ9lTfR9tuds36mUvc7Jie', NULL, 'user', NULL, NULL, 'active', NULL, '2022-05-19 08:11:39', '2022-05-19 08:11:39'),
(39, 'user3', 'user3@gmail.com', NULL, '$2y$10$DCyzfOKCmgt2njr8D7Z.ZeZ2pFVly/chBrJeqJFwYBjXipliyPs26', NULL, 'user', NULL, NULL, 'active', NULL, '2022-05-20 08:12:05', '2022-05-20 08:12:05'),
(40, 'user4', 'user4@gmail.com', NULL, '$2y$10$IbppthaqLsoS9QOEH3gWtu7cPiEzhY.lUeEFEz4EGVXBivJL8kN8y', NULL, 'user', NULL, NULL, 'active', NULL, '2022-05-21 08:12:28', '2022-05-21 08:12:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlists`
--

INSERT INTO `wishlists` (`id`, `product_id`, `cart_id`, `user_id`, `price`, `quantity`, `amount`, `created_at`, `updated_at`) VALUES
(3, 16, 31, 34, 180000.00, 1, 180000.00, '2022-05-09 10:57:25', '2022-05-19 11:32:16'),
(4, 15, 31, 34, 135000.00, 1, 135000.00, '2022-05-09 10:58:10', '2022-05-19 11:32:16'),
(5, 17, 32, 34, 360000.00, 1, 360000.00, '2022-05-21 07:18:25', '2022-05-21 07:18:37');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `banners_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`),
  ADD KEY `categories_added_by_foreign` (`added_by`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_shipping_id_foreign` (`shipping_id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_post_cat_id_foreign` (`post_cat_id`),
  ADD KEY `posts_post_tag_id_foreign` (`post_tag_id`),
  ADD KEY `posts_added_by_foreign` (`added_by`);

--
-- Chỉ mục cho bảng `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_comments_user_id_foreign` (`user_id`),
  ADD KEY `post_comments_post_id_foreign` (`post_id`);

--
-- Chỉ mục cho bảng `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_tags_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_cat_id_foreign` (`cat_id`),
  ADD KEY `products_child_cat_id_foreign` (`child_cat_id`);

--
-- Chỉ mục cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_user_id_foreign` (`user_id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_cart_id_foreign` (`cart_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_shipping_id_foreign` FOREIGN KEY (`shipping_id`) REFERENCES `shippings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `posts_post_cat_id_foreign` FOREIGN KEY (`post_cat_id`) REFERENCES `post_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `posts_post_tag_id_foreign` FOREIGN KEY (`post_tag_id`) REFERENCES `post_tags` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `post_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_child_cat_id_foreign` FOREIGN KEY (`child_cat_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
