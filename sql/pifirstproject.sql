-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2020 at 05:08 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pifirstproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `cat_courses`
--

CREATE TABLE `cat_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cat_courses`
--

INSERT INTO `cat_courses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Khóa học online', NULL, NULL),
(2, 'Khóa Học Offline\r\n', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cat_posts`
--

CREATE TABLE `cat_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT 0,
  `sort` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('show','hidden') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hidden',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cat_posts`
--

INSERT INTO `cat_posts` (`id`, `name`, `parent_id`, `sort`, `status`, `created_at`, `updated_at`) VALUES
(9, 'Sức khoẻ', 0, NULL, 'show', '2020-11-15 04:05:45', '2020-11-15 04:10:42'),
(10, 'Dinh Dưỡng', 9, NULL, 'show', '2020-11-15 04:05:58', '2020-11-15 04:09:24'),
(11, 'Đời sống', 0, NULL, 'show', '2020-11-15 04:10:58', '2020-11-15 04:10:58'),
(12, 'Bài học sống', 11, NULL, 'show', '2020-11-15 04:11:12', '2020-11-15 04:11:12');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cat_id` bigint(20) DEFAULT NULL,
  `type` enum('post','course') COLLATE utf8mb4_unicode_ci NOT NULL,
  `star` int(11) DEFAULT NULL,
  `video` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_courses`
--

CREATE TABLE `comment_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `star` int(11) DEFAULT NULL,
  `video` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('show','hidden') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment_courses`
--

INSERT INTO `comment_courses` (`id`, `content`, `user_id`, `star`, `video`, `thumbnail`, `cat_id`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Bài giảng tệ quá', 7, 3, 'video.mp4', 'thumbnail.png', 2, 0, 'show', '2020-09-15 14:04:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comment_posts`
--

CREATE TABLE `comment_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `star` int(11) DEFAULT NULL,
  `video` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('show','hidden') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment_posts`
--

INSERT INTO `comment_posts` (`id`, `content`, `user_id`, `star`, `video`, `thumbnail`, `cat_id`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
(4, 'xin lỗi', 7, NULL, NULL, NULL, 4, 0, 'show', '2020-11-11 14:22:36', NULL),
(5, NULL, 7, NULL, NULL, NULL, 4, 0, NULL, '2020-11-15 08:01:11', '2020-11-15 08:01:11'),
(6, 'kjfkajdsfsd', 7, NULL, NULL, NULL, 4, 0, NULL, '2020-11-15 08:02:45', '2020-11-15 08:02:45'),
(7, 'Bài viết hay lắm', 7, NULL, NULL, NULL, 4, 0, NULL, '2020-11-15 08:03:07', '2020-11-15 08:03:07');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT 0,
  `price` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_old` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL COMMENT 'trường này nhận biêt thuộc khóa học online hay offline',
  `time_end` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('show','hidden') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `thumbnail`, `video`, `parent_id`, `price`, `price_old`, `content`, `note`, `cat_id`, `time_end`, `sort`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Khóa học lập trinh node ', 'uploads/courses/online/preview/thumbnail/khoa-hoc-lap-trinh-node.jpg', 'uploads/courses/online/preview/video/khoa-hoc-lap-trinh-node.mp4', NULL, '2000', NULL, 'đây là nội dung bài vết', NULL, 1, NULL, NULL, 'hidden', '2020-11-10 19:35:53', '2020-11-14 22:52:06', NULL),
(2, 'khóa học với pd0 giao tiếp với database', NULL, 'uploads/courses/online/preview/video/khoa-hoc-voi-pd0-giao-tiep-voi-database.mp4', 0, '5454545', NULL, 'đayasdfs', NULL, 2, NULL, NULL, 'hidden', '2020-11-10 19:46:29', '2020-11-11 00:27:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_11_08_034017_create_users_table', 1),
(2, '2020_11_08_034049_create_roles_table', 1),
(3, '2020_11_08_034121_create_user_roles_table', 1),
(4, '2020_11_08_034142_create_cat_posts_table', 1),
(6, '2020_11_08_034217_create_sliders_table', 1),
(7, '2020_11_08_034232_create_cat_courses_table', 1),
(8, '2020_11_08_034251_create_courses_table', 1),
(9, '2020_11_08_034322_create_route_course_offlines_table', 1),
(10, '2020_11_08_034349_create_schedule_course_offlines_table', 1),
(11, '2020_11_08_034408_create_pays_table', 1),
(13, '2020_11_08_034505_create_comments_table', 1),
(14, '2014_10_12_200000_add_two_factor_columns_to_users_table', 2),
(15, '2020_11_10_153747_create_product_courses_table', 2),
(16, '2020_11_14_114559_create_comment_posts_table', 3),
(17, '2020_11_14_114624_create_comment_products_table', 4),
(18, '2020_11_14_120046_create_comment_courses_table', 5),
(19, '2020_11_08_034442_create_user_pay_courses_table', 6),
(21, '2020_11_08_034200_create_posts_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `pays`
--

CREATE TABLE `pays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('show','hidden') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pays`
--

INSERT INTO `pays` (`id`, `name`, `thumbnail`, `info`, `status`, `discount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'visa', 'uploads/pays/visa.png', 'tk:30434930\r\nChủ tài khoản: Nguyễn Hữu Khương', 'hidden', NULL, '2020-11-10 05:51:13', '2020-11-10 07:24:31', NULL),
(2, 'MO MO Backing', 'uploads/pays/MO MO Backing.png', 'tài khoản: 293232\r\nchủ tài khoản: Nguyễn Thị Thanh Thúy', 'show', 20, '2020-11-10 05:57:41', '2020-11-10 07:24:31', NULL),
(4, 'đây là nội dung argibacking', 'uploads/pays/day-la-noi-dung-argibacking.png', 'đây là nội dung argibanking', 'show', NULL, '2020-11-10 07:18:28', '2020-11-10 07:24:31', NULL),
(5, 'đây là thanh toán moca', 'uploads/pays/day-la-thanh-toan-moca.png', 'đây là nội dung thanh toán mo ca', 'show', NULL, '2020-11-10 07:19:31', '2020-11-10 07:24:31', NULL),
(6, 'zalo pay', 'uploads/pays/zalo-pay.png', 'nội dung zalo pay', 'show', NULL, '2020-11-10 07:20:28', '2020-11-10 07:24:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_id` bigint(20) UNSIGNED NOT NULL,
  `creator` bigint(20) UNSIGNED NOT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('show','hidden') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `name`, `desc`, `content`, `cat_id`, `creator`, `thumbnail`, `sort`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Công thức giúp đề kháng khỏe, tiêu hóa tốt từ NutiFood', '<p><em><strong><a title=\"C&ocirc;ng thức gi&uacute;p đề kh&aacute;ng khỏe, ti&ecirc;u h&oacute;a tốt từ NutiFood\" href=\"https://vnexpress.net/cong-thuc-giup-de-khang-khoe-tieu-hoa-tot-tu-nutifood-4185891.html\" data-medium=\"Item-2\" data-thumb=\"1\" data-itm-source=\"#vn_source=Folder&amp;vn_campaign=Stream&amp;vn_medium=Item-2&amp;vn_term=Desktop&amp;vn_thumb=1\" data-itm-added=\"1\">GrowPLUS+ được bổ sung nhiều dưỡng chất hỗ trợ n&acirc;ng cao đề kh&aacute;ng, khả năng ti&ecirc;u h&oacute;a, từ đ&oacute; gi&uacute;p b&eacute; tăng c&acirc;n, cải thiện chiều cao.&nbsp;</a></strong></em></p>', '<h1 class=\"title-detail\">C&ocirc;ng thức gi&uacute;p đề kh&aacute;ng khỏe, ti&ecirc;u h&oacute;a tốt từ NutiFood</h1>\r\n<p class=\"description\">GrowPLUS+ được bổ sung nhiều dưỡng chất hỗ trợ n&acirc;ng cao đề kh&aacute;ng, khả năng ti&ecirc;u h&oacute;a, từ đ&oacute; gi&uacute;p b&eacute; tăng c&acirc;n, cải thiện chiều cao.</p>\r\n<article class=\"fck_detail \">\r\n<div class=\"WordSection1\">\r\n<p class=\"Normal\">T&igrave;nh trạng suy dinh dưỡng thấp c&ograve;i lu&ocirc;n l&agrave; mối quan t&acirc;m h&agrave;ng đầu của c&aacute;c mẹ c&oacute; con nhỏ. Theo c&aacute;c chuy&ecirc;n gia của Viện nghi&ecirc;n cứu dinh dưỡng NutiFood, số liệu điều tra của Việt Nam năm 2010 thể hiện chiều cao trung b&igrave;nh ở nam giới l&agrave; 164,4 cm, thấp hơn trung b&igrave;nh thế giới 7 cm v&agrave; ở nữ giới l&agrave; 154 cm, thấp hơn trung b&igrave;nh thế giới l&agrave; 5 cm.</p>\r\n<p class=\"Normal\">Viện Dinh dưỡng Quốc gia cũng đ&atilde; chỉ ra rằng dinh dưỡng l&agrave; yếu tố quan trọng nhất ảnh hưởng đến sự ph&aacute;t triển của chiều cao, chiếm 32%. Những con số n&agrave;y cho thấy khi c&oacute; sự thiệt th&ograve;i về chế độ dinh dưỡng qua nhiều thế hệ sẽ dẫn đến thua k&eacute;m về nền tảng thể chất ở trẻ em Việt Nam. Như vậy, muốn cải thiện thể trạng, cần c&oacute; một chế độ dinh dưỡng đầy đủ, từ đ&oacute; x&acirc;y dựng hệ ti&ecirc;u h&oacute;a khỏe mạnh l&agrave;m nền tảng cho trẻ ph&aacute;t triển to&agrave;n diện.</p>\r\n<p class=\"Normal\">Ra đời với mong muốn giải quyết nhu cầu dinh dưỡng của cộng đồng, từ đ&oacute; g&oacute;p phần cải thiện tầm v&oacute;c thế hệ tương lai, NutiFood kh&ocirc;ng ngừng nỗ lực để đồng h&agrave;nh c&ugrave;ng trẻ em Việt Nam tr&ecirc;n h&agrave;nh tr&igrave;nh ph&aacute;t triển to&agrave;n diện thể trạng, tr&iacute; tuệ. Sau nhiều năm kh&aacute;m, tư vấn cho h&agrave;ng ngh&igrave;n trẻ em v&agrave; 20 năm nghi&ecirc;n cứu thấu hiểu nhu cầu dinh dưỡng đặc th&ugrave; của trẻ em Việt, c&aacute;c chuy&ecirc;n gia dinh dưỡng NutiFood đ&atilde; đ&uacute;c kết được rằng: muốn trẻ hấp thu tối ưu c&aacute;c dưỡng chất cần phải x&acirc;y dựng vững chắc nền tảng đề kh&aacute;ng khỏe - ti&ecirc;u h&oacute;a tốt.</p>\r\n<figure class=\"tplCaption action_thumb_added\" data-size=\"true\">\r\n<div class=\"fig-picture\"><picture><source srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/10/a-1-1604991524-3563-1604991737.png?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=ylWDov_7Yb_ElWf4ZAy3dg 1x, https://i1-suckhoe.vnecdn.net/2020/11/10/a-1-1604991524-3563-1604991737.png?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=IAWsJi4hm3cTNysuTzxkwQ 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/10/a-1-1604991524-3563-1604991737.png?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=_sZjMWHY0KLZ0xw-4gSRXA 2x\" data-srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/10/a-1-1604991524-3563-1604991737.png?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=ylWDov_7Yb_ElWf4ZAy3dg 1x, https://i1-suckhoe.vnecdn.net/2020/11/10/a-1-1604991524-3563-1604991737.png?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=IAWsJi4hm3cTNysuTzxkwQ 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/10/a-1-1604991524-3563-1604991737.png?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=_sZjMWHY0KLZ0xw-4gSRXA 2x\" /><img class=\"lazy lazied\" src=\"https://i1-suckhoe.vnecdn.net/2020/11/10/a-1-1604991524-3563-1604991737.png?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=ylWDov_7Yb_ElWf4ZAy3dg\" alt=\"NutiFood GrowPLUS+ mới với c&ocirc;ng thức đề kh&aacute;ng khỏe - ti&ecirc;u h&oacute;a tốt từ Thụy Điển. Ảnh: NutiFood.\" loading=\"lazy\" data-src=\"https://i1-suckhoe.vnecdn.net/2020/11/10/a-1-1604991524-3563-1604991737.png?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=ylWDov_7Yb_ElWf4ZAy3dg\" data-ll-status=\"loaded\" /></picture></div>\r\n<figcaption>\r\n<p class=\"Image\">NutiFood GrowPLUS+ mới với c&ocirc;ng thức đề kh&aacute;ng khỏe - ti&ecirc;u h&oacute;a tốt từ Thụy Điển. Ảnh:&nbsp;<em>NutiFood.</em></p>\r\n</figcaption>\r\n</figure>\r\n<p>NutiFood GrowPLUS+ l&agrave; sản phẩm đặc trị suy dinh dưỡng thấp c&ograve;i c&oacute; mặt tr&ecirc;n thị trường Việt Nam từ năm 2012. Trong năm 2019, NutiFood GrowPLUS+ nhận danh hiệu Nh&atilde;n hiệu đứng đầu về Doanh thu trong ph&acirc;n kh&uacute;c Sữa bột trẻ em v&agrave; Sữa bột pha sẵn cho trẻ em (chiếm 22% thị phần doanh thu theo b&aacute;o c&aacute;o thị trường của Nielsen từ th&aacute;ng 5/2019 đến 6/2020, (ngoại trừ MM Mega Market Việt Nam).</p>\r\n<p class=\"Normal\">Doanh nghiệp c&oacute; th&ecirc;m nhiều hoạt động nhằm n&acirc;ng tầm thể trạng v&agrave; tr&iacute; tuệ cho thế hệ tương lai Việt Nam. Với mong muốn mang đến những sản phẩm chất lượng quốc tế, dựa tr&ecirc;n sự thấu hiểu nhu cầu dinh dưỡng của trẻ em Việt, NutiFood GrowPLUS+ cải tiến được ra đời với c&ocirc;ng thức FDI độc quyền từ Thụy Điển. Sản phẩm l&agrave; sự kết hợp của bộ đ&ocirc;i dưỡng chất 2&rsquo;-FL HMO v&agrave; FOS gi&uacute;p trẻ x&acirc;y dựng nền tảng đề kh&aacute;ng khỏe - ti&ecirc;u h&oacute;a tốt, hỗ trợ tăng c&acirc;n, tăng chiều cao sau 3 th&aacute;ng.</p>\r\n<figure class=\"tplCaption action_thumb_added\" data-size=\"true\">\r\n<div class=\"fig-picture\"><picture><source srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/10/a-2-1604991610-7743-1604991737.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=nbLHLWsjmhQZ6VsQdS523g 1x, https://i1-suckhoe.vnecdn.net/2020/11/10/a-2-1604991610-7743-1604991737.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=pbFfxhgb1jgDKmupEqO1OA 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/10/a-2-1604991610-7743-1604991737.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=Mc3DR_UaXOZtOb-mYaLvQQ 2x\" data-srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/10/a-2-1604991610-7743-1604991737.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=nbLHLWsjmhQZ6VsQdS523g 1x, https://i1-suckhoe.vnecdn.net/2020/11/10/a-2-1604991610-7743-1604991737.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=pbFfxhgb1jgDKmupEqO1OA 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/10/a-2-1604991610-7743-1604991737.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=Mc3DR_UaXOZtOb-mYaLvQQ 2x\" /><img class=\"lazy lazied\" src=\"https://i1-suckhoe.vnecdn.net/2020/11/10/a-2-1604991610-7743-1604991737.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=nbLHLWsjmhQZ6VsQdS523g\" alt=\"NutiFood GrowPLUS+ với c&ocirc;ng thức FDI hỗ trợ trẻ tăng c&acirc;n, tăng chiều cao sau 3 th&aacute;ng.\" loading=\"lazy\" data-src=\"https://i1-suckhoe.vnecdn.net/2020/11/10/a-2-1604991610-7743-1604991737.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=nbLHLWsjmhQZ6VsQdS523g\" data-ll-status=\"loaded\" /></picture></div>\r\n<figcaption>\r\n<p class=\"Image\">NutiFood GrowPLUS+ hỗ trợ trẻ tăng c&acirc;n, tăng chiều cao sau 3 th&aacute;ng. Ảnh:&nbsp;<em>NutiFood.</em></p>\r\n</figcaption>\r\n</figure>\r\n<p class=\"Normal\">HMO (Human Milk Oligosaccharides) l&agrave; th&agrave;nh phần nhiều thứ ba trong sữa mẹ, c&oacute; cấu tr&uacute;c hoạt động tương đồng với prebiotic gi&uacute;p nu&ocirc;i dưỡng c&aacute;c vi khuẩn c&oacute; lợi trong đường ruột, hạn chế nhiễm tr&ugrave;ng v&agrave; t&igrave;nh trạng rối loạn ti&ecirc;u h&oacute;a ở trẻ. Kết hợp c&ugrave;ng FOS l&agrave; chất xơ h&ograve;a tan gi&uacute;p hấp thu tốt c&aacute;c dưỡng chất, bảo vệ b&eacute; khỏi c&aacute;c t&aacute;c nh&acirc;n g&acirc;y hại đường ruột, tăng cường sức khỏe hệ ti&ecirc;u h&oacute;a v&agrave; hệ miễn dịch.</p>\r\n<p class=\"Normal\">Theo nghi&ecirc;n cứu \"Hiệu quả của sử dụng sản phẩm GrowPLUS l&ecirc;n t&igrave;nh trạng dinh dưỡng, miễn dịch, ph&aacute;t triển t&acirc;m vận động của trẻ 1-3 tuổi suy dinh dưỡng thấp c&ograve;i tại Bắc Giang\" do Viện dinh dưỡng thực hiện, sản phẩm gi&uacute;p b&eacute; tăng c&acirc;n, tăng chiều cao sau 3 th&aacute;ng, giảm tỷ lệ biếng ăn, giảm tỷ lệ nhiễm khuẩn h&ocirc; hấp. Kh&ocirc;ng chỉ vậy, NutiFood GrowPLUS+ mới c&ograve;n tăng cường gấp 3 lần DHA gi&uacute;p hỗ trợ b&eacute; ph&aacute;t triển tr&iacute; n&atilde;o to&agrave;n diện.</p>\r\n</div>\r\n</article>', 10, 7, 'uploads/posts/cong-thuc-giup-de-khang-khoe-tieu-hoa-tot-tu-nutifood.png', NULL, 'show', '2020-11-15 04:23:42', '2020-11-15 05:40:54', NULL),
(3, 'Thúy Diễm gợi ý cách tăng dưỡng chất cho bữa ăn của con', '<p><a title=\"Th&uacute;y Diễm gợi &yacute; c&aacute;ch tăng dưỡng chất cho bữa ăn của con\" href=\"https://vnexpress.net/thuy-diem-goi-y-cach-tang-duong-chat-cho-bua-an-cua-con-4184673.html\" data-medium=\"Item-5\" data-thumb=\"1\" data-itm-source=\"#vn_source=Folder&amp;vn_campaign=Stream&amp;vn_medium=Item-5&amp;vn_term=Desktop&amp;vn_thumb=1\" data-itm-added=\"1\">Nữ diễn vi&ecirc;n phối hợp đa dạng nh&oacute;m chất, thường xuy&ecirc;n đổi m&oacute;n để con hứng th&uacute; ăn uống, bổ sung th&ecirc;m chất b&eacute;o nhằm tăng hấp thu vitamin.&nbsp;</a></p>', '<h1 class=\"title-detail\">Th&uacute;y Diễm gợi &yacute; c&aacute;ch tăng dưỡng chất cho bữa ăn của con</h1>\r\n<p class=\"description\">Nữ diễn vi&ecirc;n phối hợp đa dạng nh&oacute;m chất, thường xuy&ecirc;n đổi m&oacute;n để con hứng th&uacute; ăn uống, bổ sung th&ecirc;m chất b&eacute;o nhằm tăng hấp thu vitamin.</p>\r\n<article class=\"fck_detail \">\r\n<p class=\"Normal\">Hai năm kể từ ng&agrave;y sinh b&eacute; Bảo Bảo, Th&uacute;y Diễm t&acirc;m sự rằng c&ocirc; chưa bao giờ ngưng t&igrave;m t&ograve;i học hỏi. \"T&ocirc;i vừa học l&agrave;m mẹ, học về dinh dưỡng, học mọi thứ để chọn ra được biện ph&aacute;p dinh dưỡng đủ, đ&uacute;ng v&agrave; đặc biệt l&agrave; phải ph&ugrave; hợp với thể trạng ri&ecirc;ng của con m&igrave;nh\", nữ diễn vi&ecirc;n cho biết.</p>\r\n<p class=\"Normal\">Nhấn mạnh tầm quan trọng của dinh dưỡng, c&ocirc; n&oacute;i, d&ugrave; ở độ tuổi n&agrave;o, dinh dưỡng cũng l&agrave; yếu tố h&agrave;ng đầu. Nguy&ecirc;n nh&acirc;n bởi, sau 6 th&aacute;ng đến 3 tuổi, sữa mẹ đ&atilde; kh&ocirc;ng c&ograve;n cung cấp đủ năng lượng cho nhu cầu ph&aacute;t triển của trẻ. L&uacute;c n&agrave;y, hệ miễn dịch trở n&ecirc;n yếu hơn, khiến trẻ dễ mắc bệnh.</p>\r\n<p class=\"Normal\">Th&ecirc;m v&agrave;o đ&oacute;, nếu thực đơn thiếu c&acirc;n bằng, trẻ dễ đối mặt với nguy cơ thiếu vi chất dinh dưỡng, cản trở sự tăng trưởng v&agrave; ph&aacute;t triển to&agrave;n diện của trẻ. V&igrave; vậy, Th&uacute;y Diễm lu&ocirc;n ưu ti&ecirc;n những dưỡng chất gi&uacute;p tăng cường tr&iacute; n&atilde;o v&agrave; x&acirc;y dựng sức đề kh&aacute;ng nhằm gi&uacute;p con ph&aacute;t triển khoẻ mạnh.</p>\r\n<p class=\"Normal\">Cụ thể, khi l&ecirc;n thực đơn cho con, nữ diễn vi&ecirc;n lu&ocirc;n ưu ti&ecirc;n t&iacute;nh c&acirc;n bằng v&agrave; đa dạng thực phẩm. Mỗi bữa ăn cần đầy đủ c&aacute;c nh&oacute;m chất: tinh bột, đạm, vitamin v&agrave; kho&aacute;ng chất, chất b&eacute;o. Ngo&agrave;i 3 bữa ch&iacute;nh, c&ocirc; c&ograve;n bổ sung bữa phụ, thường xuy&ecirc;n đổi m&oacute;n ăn v&agrave; c&aacute;ch chế biến để tạo hứng th&uacute; cho b&eacute;.</p>\r\n<p class=\"Normal\">\"Trẻ từ 6 th&aacute;ng đến 3 tuổi, tốt nhất l&agrave; n&ecirc;n đảm bảo hấp thụ đủ chất qua bữa ăn h&agrave;ng ng&agrave;y, đặc biệt l&agrave; những chất b&eacute;o cần thiết g&oacute;p phần gi&uacute;p b&eacute; ph&aacute;t triển th&ocirc;ng minh v&agrave; khỏe mạnh\", c&ocirc; n&oacute;i.</p>\r\n<figure class=\"tplCaption action_thumb_added\" data-size=\"true\">\r\n<div class=\"fig-picture\"><picture><source srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/04/image001-1604484953-5473-1604485018.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=9gA6did43Fh9DO5A-h7Sdg 1x, https://i1-suckhoe.vnecdn.net/2020/11/04/image001-1604484953-5473-1604485018.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=HzgeCGChLI_qBRo52Wl5VQ 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/04/image001-1604484953-5473-1604485018.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=2z0pjS2rCV03EfIWABosWg 2x\" data-srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/04/image001-1604484953-5473-1604485018.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=9gA6did43Fh9DO5A-h7Sdg 1x, https://i1-suckhoe.vnecdn.net/2020/11/04/image001-1604484953-5473-1604485018.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=HzgeCGChLI_qBRo52Wl5VQ 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/04/image001-1604484953-5473-1604485018.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=2z0pjS2rCV03EfIWABosWg 2x\" /><img class=\"lazy lazied\" src=\"https://i1-suckhoe.vnecdn.net/2020/11/04/image001-1604484953-5473-1604485018.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=9gA6did43Fh9DO5A-h7Sdg\" alt=\"Th&uacute;y Diễm lu&ocirc;n ưu ti&ecirc;n c&aacute;c bữa ăn c&acirc;n bằng, đa dạng dưỡng chất cho con. Ảnh: Facebook nh&acirc;n vật.\" loading=\"lazy\" data-src=\"https://i1-suckhoe.vnecdn.net/2020/11/04/image001-1604484953-5473-1604485018.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=9gA6did43Fh9DO5A-h7Sdg\" data-ll-status=\"loaded\" /></picture></div>\r\n<figcaption>\r\n<p class=\"Image\">Th&uacute;y Diễm lu&ocirc;n ưu ti&ecirc;n c&aacute;c bữa ăn c&acirc;n bằng, đa dạng dưỡng chất cho con. Ảnh:<em>&nbsp;Facebook nh&acirc;n vật.</em></p>\r\n</figcaption>\r\n</figure>\r\n<div class=\"WordSection1\">\r\n<p class=\"Normal\">Theo nữ diễn vi&ecirc;n, chất b&eacute;o l&agrave; dưỡng chất kh&ocirc;ng thể thiếu trong khẩu phần mỗi ng&agrave;y. N&ecirc;n bổ sung dầu ăn cho trẻ để gi&uacute;p h&ograve;a tan c&aacute;c vitamin A, E, D, K... v&agrave; cung cấp năng lượng cho cơ thể . Trong điều kiện bận rộn, Th&uacute;y Diễm ưu ti&ecirc;n c&aacute;c thực phẩm đảm bảo t&iacute;nh tiện dụng m&agrave; vẫn đầy dưỡng chất.</p>\r\n<p class=\"Normal\">\"T&ocirc;i lựa chọn bộ ba dầu ăn dinh dưỡng d&agrave;nh cho trẻ em VIO của Tường An - một thương hiệu gắn b&oacute; từ ng&agrave;y ấu thơ\", Th&uacute;y Diễm cho biết.</p>\r\n<p class=\"Normal\">Bộ ba dầu ăn dinh dưỡng VIO gồm dầu VIO Gấc, dầu VIO Olive v&agrave; dầu VIO M&egrave;. Dầu VIO Gấc với 100% nguy&ecirc;n liệu tự nhi&ecirc;n, gồm dầu m&egrave;, dầu hạt cải v&agrave; dầu gấc, g&oacute;p phần hỗ trợ ph&aacute;t triển tr&iacute; n&atilde;o, tốt cho da, mắt v&agrave; tim. Dầu VIO Olive gi&uacute;p b&eacute; tăng cường sức đề kh&aacute;ng c&ugrave;ng khả năng hấp thụ dưỡng chất nhờ 100% olive nhập khẩu từ ch&acirc;u &Acirc;u. Với hai loại dầu n&agrave;y, Th&uacute;y Diễm thường thay phi&ecirc;n cho trực tiếp một muỗng nhỏ (5 gram) v&agrave;o ch&aacute;o hoặc s&uacute;p của b&eacute;, khoảng 2 muỗng mỗi ng&agrave;y.</p>\r\n<p class=\"Normal\">Th&uacute;y Diễm kể: \"Dầu VIO M&egrave; được Bảo Bảo th&iacute;ch m&ecirc; ly. Đ&acirc;y l&agrave; sản phẩm mới nhất của d&ograve;ng dầu ăn dinh dưỡng d&agrave;nh cho trẻ em VIO, với 100% hạt m&egrave; tự nhi&ecirc;n, gi&uacute;p g&oacute;p phần hỗ trợ ph&aacute;t triển thể chất v&agrave; củng cố hệ xương của b&eacute; th&ecirc;m cứng c&aacute;p\". C&ocirc; thường cho một muỗng nhỏ (5 gram trong một lần ăn) v&agrave;o thức ăn lo&atilde;ng của Bảo Bảo gi&uacute;p m&oacute;n ăn vừa ngon vừa bổ dưỡng.</p>\r\n<p class=\"Normal\">Với nguồn nguy&ecirc;n liệu tự nhi&ecirc;n, sản xuất tr&ecirc;n d&acirc;y chuyền hiện đại ch&acirc;u &Acirc;u, được tăng cường c&aacute;c dưỡng chất thiết yếu như DHA, EPA, c&ugrave;ng c&aacute;c vitamin A, D v&agrave; E tự nhi&ecirc;n, bộ ba dầu ăn dinh dưỡng l&agrave; một trong những b&iacute; quyết gi&uacute;p Th&uacute;y Diễm hỗ trợ bổ sung dưỡng chất cho con trong những ng&agrave;y bận rộn.</p>\r\n<figure class=\"tplCaption action_thumb_added\" data-size=\"true\">\r\n<div class=\"fig-picture\"><picture><source srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/04/image003-1604484963-8024-1604485018.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=mX1Ao3_ysNY2FNQlm6x4Xw 1x, https://i1-suckhoe.vnecdn.net/2020/11/04/image003-1604484963-8024-1604485018.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=1zDEqC68VAUo8ZXgm2ojGQ 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/04/image003-1604484963-8024-1604485018.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=zRyrqcTZfW8oByGYshXf8w 2x\" data-srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/04/image003-1604484963-8024-1604485018.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=mX1Ao3_ysNY2FNQlm6x4Xw 1x, https://i1-suckhoe.vnecdn.net/2020/11/04/image003-1604484963-8024-1604485018.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=1zDEqC68VAUo8ZXgm2ojGQ 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/04/image003-1604484963-8024-1604485018.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=zRyrqcTZfW8oByGYshXf8w 2x\" /><img class=\"lazy lazied\" src=\"https://i1-suckhoe.vnecdn.net/2020/11/04/image003-1604484963-8024-1604485018.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=mX1Ao3_ysNY2FNQlm6x4Xw\" alt=\"Bộ ba dầu ăn dinh dưỡng d&agrave;nh cho trẻ em VIO. Ảnh: Tường An.\" loading=\"lazy\" data-src=\"https://i1-suckhoe.vnecdn.net/2020/11/04/image003-1604484963-8024-1604485018.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=mX1Ao3_ysNY2FNQlm6x4Xw\" data-ll-status=\"loaded\" /></picture></div>\r\n<figcaption>\r\n<p class=\"Image\">Bộ ba dầu ăn dinh dưỡng d&agrave;nh cho trẻ em VIO. Ảnh:<em>&nbsp;Tường An.</em></p>\r\n</figcaption>\r\n</figure>\r\n</div>\r\n</article>', 10, 7, 'uploads/posts/thuy-diem-goi-y-cach-tang-duong-chat-cho-bua-an-cua-con.png', NULL, 'show', '2020-11-15 04:29:17', '2020-11-15 04:29:17', NULL),
(4, 'Giá trị dinh dưỡng của cá ngừ', '<p><a title=\"Gi&aacute; trị dinh dưỡng của c&aacute; ngừ\" href=\"https://vnexpress.net/gia-tri-dinh-duong-cua-ca-ngu-4183940.html\" data-medium=\"Item-7\" data-thumb=\"1\" data-itm-source=\"#vn_source=Folder&amp;vn_campaign=Stream&amp;vn_medium=Item-7&amp;vn_term=Desktop&amp;vn_thumb=1\" data-itm-added=\"1\">C&aacute; ngừ gi&agrave;u chất b&eacute;o c&oacute; lợi, DHA tốt cho sức khỏe tr&iacute; n&atilde;o, đ&ocirc;i mắt, ph&ugrave; hợp trong thực đơn ăn uống của người ăn ki&ecirc;ng, giữ d&aacute;ng.&nbsp;</a></p>', '<h1 class=\"title-detail\">Gi&aacute; trị dinh dưỡng của c&aacute; ngừ</h1>\r\n<p class=\"description\">C&aacute; ngừ gi&agrave;u chất b&eacute;o c&oacute; lợi, DHA tốt cho sức khỏe tr&iacute; n&atilde;o, đ&ocirc;i mắt, ph&ugrave; hợp trong thực đơn ăn uống của người ăn ki&ecirc;ng, giữ d&aacute;ng.</p>\r\n<article class=\"fck_detail \">\r\n<p class=\"Normal\"><strong>C&oacute; lợi cho tim mạch</strong></p>\r\n<p class=\"Normal\">Thịt c&aacute; ngừ c&oacute; h&agrave;m lượng axit b&eacute;o omega-3 cao, gi&uacute;p giảm axit b&eacute;o omega-6 hoặc cholesterol xấu trong động mạch v&agrave; mạch m&aacute;u. Đ&acirc;y l&agrave; loại thực phẩm th&iacute;ch hợp để thay thế thịt cho những bệnh nh&acirc;n mắc bệnh tiểu đường, b&eacute;o ph&igrave; hay tim mạch, ph&ograve;ng tr&aacute;nh nguy cơ đột quỵ.</p>\r\n<p class=\"Normal\"><strong>Chăm s&oacute;c sức khỏe đ&ocirc;i mắt</strong></p>\r\n<p class=\"Normal\">Suy giảm thị lực do tho&aacute;i h&oacute;a điểm v&agrave;ng l&agrave; nỗi &aacute;m ảnh, tr&igrave;nh trạng đi c&ugrave;ng với qu&aacute; tr&igrave;nh l&atilde;o h&oacute;a của con người. Omega-3 c&oacute; lợi cho tim mạch, hữu &iacute;ch để bổ sung dinh dưỡng cho mắt.</p>\r\n<p class=\"Normal\"><strong>K&iacute;ch th&iacute;ch ph&aacute;t triển tr&iacute; n&atilde;o</strong></p>\r\n<p class=\"Normal\">DHA l&agrave; một chất quan trọng cho sự ph&aacute;t triển của n&atilde;o bộ. Với h&agrave;m lượng DHA cao, c&aacute; ngừ c&oacute; thể th&uacute;c đẩy qu&aacute; tr&igrave;nh t&aacute;i sinh của tế b&agrave;o n&atilde;o, gi&uacute;p bạn tỉnh t&aacute;o, g&oacute;p phần ngăn chặn nguy cơ suy giảm tr&iacute; nhớ.</p>\r\n<figure class=\"tplCaption action_thumb_added\" data-size=\"true\">\r\n<div class=\"fig-picture\"><picture><source srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image001-1604374020-2852-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=bvvxdG3k9PJ51avaQzHAhw 1x, https://i1-suckhoe.vnecdn.net/2020/11/03/image001-1604374020-2852-1604375467.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=gW3y_t6wE8Xs_TIhcsGIQg 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/03/image001-1604374020-2852-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=nf5xnyZgLJDq9UKGf_JsvQ 2x\" data-srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image001-1604374020-2852-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=bvvxdG3k9PJ51avaQzHAhw 1x, https://i1-suckhoe.vnecdn.net/2020/11/03/image001-1604374020-2852-1604375467.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=gW3y_t6wE8Xs_TIhcsGIQg 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/03/image001-1604374020-2852-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=nf5xnyZgLJDq9UKGf_JsvQ 2x\" /><img class=\"lazy lazied\" src=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image001-1604374020-2852-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=bvvxdG3k9PJ51avaQzHAhw\" alt=\"C&aacute; ngừ c&oacute; nhiều gi&aacute; trị dinh dưỡng.\" loading=\"lazy\" data-src=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image001-1604374020-2852-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=bvvxdG3k9PJ51avaQzHAhw\" data-ll-status=\"loaded\" /></picture></div>\r\n<figcaption>\r\n<p class=\"Image\">C&aacute; ngừ c&oacute; nhiều gi&aacute; trị dinh dưỡng. Ảnh:&nbsp;<em>shutterstock.</em></p>\r\n</figcaption>\r\n</figure>\r\n<p class=\"Normal\"><strong>Th&iacute;ch hợp giảm c&acirc;n</strong></p>\r\n<p class=\"Normal\">Tuy c&aacute; ngừ chứa rất nhiều chất dinh dưỡng, nhưng h&agrave;m lượng chất b&eacute;o, calo lại thấp. V&igrave; vậy đ&acirc;y l&agrave; một trong c&aacute;c loại thực phẩm th&iacute;ch hợp để th&ecirc;m v&agrave;o thực đơn giảm c&acirc;n, gi&uacute;p cải thiện v&oacute;c d&aacute;ng, kh&ocirc;ng cần lo ngại về việc ăn uống bị thiếu chất, g&acirc;y suy nhược cơ thể.</p>\r\n<p class=\"Normal\"><strong>Một số m&oacute;n chế biến từ c&aacute; ngừ</strong></p>\r\n<p class=\"Normal\">Ng&agrave;y nay, m&oacute;n c&aacute; ngừ hộp phổ biến tại Việt Nam, nhất l&agrave; đối với những thực kh&aacute;ch đang trong chế độ giảm c&acirc;n. Dưới đ&acirc;y l&agrave; 2 c&ocirc;ng thức chế biến m&oacute;n ăn ngon c&ugrave;ng c&aacute; ngừ hộp Dongwon.</p>\r\n<figure class=\"tplCaption action_thumb_added\" data-size=\"true\">\r\n<div class=\"fig-picture\"><picture><source srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image004-1604374057-7588-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=JFu9VIck7grngKxlmTc2og 1x, https://i1-suckhoe.vnecdn.net/2020/11/03/image004-1604374057-7588-1604375467.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=wYAgpynv8a3LQjxXxXG7AA 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/03/image004-1604374057-7588-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=E6V1-o6oREjjn7H2uPT2sw 2x\" data-srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image004-1604374057-7588-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=JFu9VIck7grngKxlmTc2og 1x, https://i1-suckhoe.vnecdn.net/2020/11/03/image004-1604374057-7588-1604375467.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=wYAgpynv8a3LQjxXxXG7AA 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/03/image004-1604374057-7588-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=E6V1-o6oREjjn7H2uPT2sw 2x\" /><img class=\"lazy lazied\" src=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image004-1604374057-7588-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=JFu9VIck7grngKxlmTc2og\" alt=\"Sản phẩm của c&aacute; ngừ Dongwon. Ảnh: C&ocirc;ng ty Dongwon H&agrave;n Quốc.\" loading=\"lazy\" data-src=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image004-1604374057-7588-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=JFu9VIck7grngKxlmTc2og\" data-ll-status=\"loaded\" /></picture></div>\r\n<figcaption>\r\n<p class=\"Image\">Sản phẩm của c&aacute; ngừ Dongwon. Ảnh:&nbsp;<em>C&ocirc;ng ty Dongwon H&agrave;n Quốc.</em></p>\r\n</figcaption>\r\n</figure>\r\n<p class=\"Normal\"><em>Sandwich salad c&aacute; ngừ</em></p>\r\n<p class=\"Normal\">Khẩu phần: 4 người ăn</p>\r\n<p class=\"Normal\">Nguy&ecirc;n liệu:</p>\r\n<p class=\"Normal\">- C&aacute; ngừ đ&oacute;ng hộp Dongwon: 100g</p>\r\n<p class=\"Normal\">- B&aacute;nh m&igrave; sandwich nướng: 4 l&aacute;t</p>\r\n<p class=\"Normal\">- Bơ cắt l&aacute;t mỏng: 1/2 tr&aacute;i</p>\r\n<p class=\"Normal\">- Sốt mayonnaise: 1,5 muỗng canh</p>\r\n<p class=\"Normal\">- Nước tương: một muỗng canh</p>\r\n<p class=\"Normal\">- Tương ớt</p>\r\n<p class=\"Normal\">- Chanh: một quả</p>\r\n<p class=\"Normal\">- H&agrave;nh l&aacute; cắt mỏng</p>\r\n<p class=\"Normal\">- Rau m&ugrave;i</p>\r\n<p class=\"Normal\">C&aacute;ch l&agrave;m:</p>\r\n<p class=\"Normal\">Bước 1: Cho sốt mayonnaise, tương ớt, nước cốt chanh v&agrave; nước tương v&agrave;o một chiếc t&ocirc; cỡ vừa v&agrave; trộn đều</p>\r\n<p class=\"Normal\">Bước 2: Chắt nước trong hộp c&aacute; ngừ ra rồi cho phần thịt v&agrave;o t&ocirc;.</p>\r\n<p class=\"Normal\">Bước 3: Cho h&agrave;nh l&aacute; đ&atilde; được cắt mỏng v&agrave;o t&ocirc;, sau đ&oacute; trộn đều.</p>\r\n<p class=\"Normal\">Bước 4: Cho phần vừa trộn v&agrave;o tủ lạnh v&agrave; ủ trong v&ograve;ng 10 ph&uacute;t.</p>\r\n<p class=\"Normal\">Bước 5: Chia đều phần salad c&aacute; ngừ ra 2 miếng sandwich.</p>\r\n<p class=\"Normal\">Bước 6: Th&ecirc;m những l&aacute;t bơ v&agrave; rau m&ugrave;i l&ecirc;n tr&ecirc;n, sau đ&oacute; d&ugrave;ng 2 miếng sandwich c&ograve;n lại để kẹp v&agrave;o.</p>\r\n<figure class=\"tplCaption action_thumb_added\" data-size=\"true\">\r\n<div class=\"fig-picture\"><picture><source srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image006-1604374102-6064-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=hLlVDszfYm_vWhxwIxT4EA 1x, https://i1-suckhoe.vnecdn.net/2020/11/03/image006-1604374102-6064-1604375467.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=994ue-w_uYKoNEfy-JmbaA 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/03/image006-1604374102-6064-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=utqN2_OYjtkuxvlTxj-6iA 2x\" data-srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image006-1604374102-6064-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=hLlVDszfYm_vWhxwIxT4EA 1x, https://i1-suckhoe.vnecdn.net/2020/11/03/image006-1604374102-6064-1604375467.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=994ue-w_uYKoNEfy-JmbaA 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/03/image006-1604374102-6064-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=utqN2_OYjtkuxvlTxj-6iA 2x\" /><img class=\"lazy lazied\" src=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image006-1604374102-6064-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=hLlVDszfYm_vWhxwIxT4EA\" alt=\"Sandwich salad c&aacute; ngừ. Ảnh: shutterstock.\" loading=\"lazy\" data-src=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image006-1604374102-6064-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=hLlVDszfYm_vWhxwIxT4EA\" data-ll-status=\"loaded\" /></picture></div>\r\n<figcaption>\r\n<p class=\"Image\">Sandwich salad c&aacute; ngừ. Ảnh:&nbsp;<em>shutterstock.</em></p>\r\n</figcaption>\r\n</figure>\r\n<p class=\"Normal\"><em>Chamchi Bokkeumbap - Cơm chi&ecirc;n c&aacute; ngừ H&agrave;n Quốc</em></p>\r\n<p class=\"Normal\">Khẩu phần d&agrave;nh cho 4 người ăn</p>\r\n<p class=\"Normal\">Nguy&ecirc;n liệu:</p>\r\n<p class=\"Normal\">- C&aacute; ngừ hộp Dongwon loại Light Standard: 100g</p>\r\n<p class=\"Normal\">- Cơm ch&iacute;n: 200g</p>\r\n<p class=\"Normal\">- Một củ c&agrave; rốt</p>\r\n<p class=\"Normal\">- Một củ h&agrave;nh t&acirc;y</p>\r\n<p class=\"Normal\">- H&agrave;nh l&aacute;</p>\r\n<p class=\"Normal\">- Một quả trứng</p>\r\n<p class=\"Normal\">- Rong biển ăn liền</p>\r\n<p class=\"Normal\">- Dầu thực vật</p>\r\n<p class=\"Normal\">- Dầu m&egrave;</p>\r\n<p class=\"Normal\">- Ti&ecirc;u đen</p>\r\n<p class=\"Normal\">- Muối tỏi</p>\r\n<p class=\"Normal\">C&aacute;ch l&agrave;m:</p>\r\n<p class=\"Normal\">Bước 1: Cắt c&agrave; rốt, h&agrave;nh t&acirc;y v&agrave; h&agrave;nh l&aacute; th&agrave;nh k&iacute;ch cỡ ph&ugrave; hợp v&agrave; vừa ăn.</p>\r\n<p class=\"Normal\">Bước 2: Cho dầu thực vật v&agrave;o chảo n&oacute;ng, th&ecirc;m cơm v&agrave; muối tỏi v&agrave;o, sau đ&oacute; chi&ecirc;n trong v&ograve;ng 5 ph&uacute;t.</p>\r\n<p class=\"Normal\">Bước 3: D&ugrave;ng một chảo mới để &aacute;p chảo h&agrave;nh t&acirc;y v&agrave; c&agrave; rốt cho tới khi mềm, sau đ&oacute; th&ecirc;m c&aacute; ngừ v&agrave;o.</p>\r\n<p class=\"Normal\">Bước 4: Cho phần cơm chi&ecirc;n v&agrave;o một c&aacute;i t&ocirc; lớn, trộn đều với dầu m&egrave;, th&ecirc;m phần c&aacute; ngừ đ&atilde; chuẩn bị sẵn v&agrave;o t&ocirc; rồi trộn đều với nhau.</p>\r\n<p class=\"Normal\">Bước 5: Chuẩn bị th&ecirc;m một phần trứng ốp la thật đẹp mắt.</p>\r\n<p class=\"Normal\">Bước 6: Tr&igrave;nh b&agrave;y phần cơm chi&ecirc;n Chamchi Bokkeumbap l&ecirc;n một chiếc dĩa, cẩn thận đặt trứng ốp la l&ecirc;n tr&ecirc;n v&agrave; rắc th&ecirc;m một &iacute;t m&egrave; rang.</p>\r\n<figure class=\"tplCaption action_thumb_added\" data-size=\"true\">\r\n<div class=\"fig-picture\"><picture><source srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image008-3180-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=dXepWxJin2WD2PG4FjPD5w 1x, https://i1-suckhoe.vnecdn.net/2020/11/03/image008-3180-1604375467.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=peMUktWvL7MlEkSZn2BwUQ 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/03/image008-3180-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=7EZXJjRYuOUQ9mFt1imggQ 2x\" data-srcset=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image008-3180-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=dXepWxJin2WD2PG4FjPD5w 1x, https://i1-suckhoe.vnecdn.net/2020/11/03/image008-3180-1604375467.jpg?w=1020&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=peMUktWvL7MlEkSZn2BwUQ 1.5x, https://i1-suckhoe.vnecdn.net/2020/11/03/image008-3180-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=2&amp;fit=crop&amp;s=7EZXJjRYuOUQ9mFt1imggQ 2x\" /><img class=\"lazy lazied\" src=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image008-3180-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=dXepWxJin2WD2PG4FjPD5w\" alt=\"Cơm chi&ecirc;n c&aacute; ngừ H&agrave;n Quốc. Ảnh: shutterstock.\" loading=\"lazy\" data-src=\"https://i1-suckhoe.vnecdn.net/2020/11/03/image008-3180-1604375467.jpg?w=680&amp;h=0&amp;q=100&amp;dpr=1&amp;fit=crop&amp;s=dXepWxJin2WD2PG4FjPD5w\" data-ll-status=\"loaded\" /></picture></div>\r\n<figcaption>\r\n<p class=\"Image\">Cơm chi&ecirc;n c&aacute; ngừ H&agrave;n Quốc. Ảnh:&nbsp;<em>shutterstock.</em></p>\r\n</figcaption>\r\n</figure>\r\n<p class=\"Normal\">C&ocirc;ng ty Dongwon H&agrave;n Quốc chuy&ecirc;n sản xuất c&aacute;c loại thực phẩm n&ocirc;ng nghiệp, ngư nghiệp, những sản phẩm từ sữa, chăn nu&ocirc;i th&agrave;nh lập tại Việt Nam v&agrave;o th&aacute;ng 5 năm 2019. C&aacute; ngừ đ&oacute;ng hộp l&agrave; một trong những sản phẩm phổ biến của Dongwon tr&ecirc;n thị trường. C&aacute; đ&aacute;nh bắt từ s&acirc;u trong l&ograve;ng biển Th&aacute;i B&igrave;nh Dương v&agrave; Đại T&acirc;y Dương được xử l&yacute; v&agrave; vận chuyển một c&aacute;ch nhanh ch&oacute;ng. Ch&iacute;nh v&igrave; vậy, mỗi hộp c&aacute; ngừ Dong won đều đảm bảo độ săn chắc của thịt. Sản phẩm c&oacute; nhiều hương vị kh&aacute;c nhau: cay hoặc kh&ocirc;ng cay, c&agrave; ri, rau củ... để người ti&ecirc;u d&ugrave;ng lựa chọn.</p>\r\n<p class=\"Normal\">Hiện nay, những sản phẩm của c&aacute; ngừ Dongwon b&agrave;y b&aacute;n tr&ecirc;n c&aacute;c chuỗi si&ecirc;u thị lớn như BigC, VinMart, Coopmart, Aeon mall, B&aacute;ch H&oacute;a Xanh, Satra, Ministop, Lotte mart, Emart, GS25.</p>\r\n</article>', 10, 7, 'uploads/posts/gia-tri-dinh-duong-cua-ca-ngu.png', NULL, 'show', '2020-11-15 04:32:25', '2020-11-15 04:32:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_courses`
--

CREATE TABLE `product_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('show','hidden') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view` enum('pay','free') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_content` enum('vimeo','pdf') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'đây là trường bổ trợ thao tác với api.video ',
  `video_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'của upload video api\r\n',
  `player` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'đây là trường khi thao tác api.video\r\n\r\n',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_courses`
--

INSERT INTO `product_courses` (`id`, `name`, `desc`, `course_id`, `parent_id`, `status`, `view`, `type_content`, `video_id`, `player`, `thumbnail`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'làm quen php', NULL, 1, 0, 'show', NULL, NULL, NULL, NULL, '', '2020-11-11 20:30:49', '2020-11-11 20:30:49', NULL),
(2, 'Tổng quan lập trình javascriptn', NULL, 1, 0, 'show', NULL, NULL, NULL, NULL, '', '2020-11-11 20:31:52', '2020-11-11 21:05:31', NULL),
(4, 'Selector jquery ,', NULL, 1, 0, 'hidden', NULL, NULL, NULL, NULL, '', '2020-11-11 20:32:46', '2020-11-11 21:20:54', NULL),
(5, 'Các phương thức xử lý jquery', NULL, 1, 0, 'show', NULL, NULL, NULL, NULL, '', '2020-11-11 20:33:19', '2020-11-11 20:33:19', NULL),
(6, 'Hiệu ứng jquery', NULL, 1, 0, 'show', NULL, NULL, NULL, NULL, '', '2020-11-11 20:33:30', '2020-11-11 20:33:30', NULL),
(7, 'Hiệu ứng jquey', NULL, 1, 0, 'show', NULL, NULL, NULL, NULL, '', '2020-11-11 20:33:46', '2020-11-11 20:33:46', NULL),
(8, 'Tạo slider cơ bản jquery', NULL, 1, 0, 'show', NULL, NULL, NULL, NULL, '', '2020-11-11 20:34:03', '2020-11-11 20:34:03', NULL),
(21, 'Tạo server nodejs', 'đây là bài giảng tạo server node js', 1, 4, 'show', 'free', 'vimeo', 'viCZS0leK2lNMZ2quNlRaqt', 'https://embed.api.video/vod/viCZS0leK2lNMZ2quNlRaqt', 'https://cdn.api.video/vod/viCZS0leK2lNMZ2quNlRaqt/thumbnail.jpg', '2020-11-13 08:37:21', '2020-11-13 08:59:21', NULL),
(22, 'websocket io', 'ss', 1, 4, 'show', 'pay', 'vimeo', 'vi5quZanbq3YPznedu8H9P9L', 'https://embed.api.video/vod/vi5quZanbq3YPznedu8H9P9L', 'https://cdn.api.video/vod/vi5quZanbq3YPznedu8H9P9L/thumbnail.jpg', '2020-11-13 08:40:01', '2020-11-13 08:59:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'updater', NULL, NULL),
(3, 'deleter', NULL, NULL),
(4, 'addter', NULL, NULL),
(5, 'student', NULL, NULL),
(6, 'teacher', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `route_course_offlines`
--

CREATE TABLE `route_course_offlines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('show','hidden') COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `creator` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `route_course_offlines`
--

INSERT INTO `route_course_offlines` (`id`, `title`, `content`, `status`, `course_id`, `creator`, `created_at`, `updated_at`) VALUES
(1, 'phương pháp 1', 'tự học lập trình', 'show', 2, NULL, '2020-11-11 02:54:35', '2020-11-11 02:54:35'),
(3, 'insert database', 'đây là lộ trình insert database bằng pdo nha', 'show', 2, NULL, '2020-11-11 06:21:28', '2020-11-11 06:21:28'),
(4, 'update database', 'đây là lộ trình update database bằng pdo', 'show', 2, NULL, '2020-11-11 06:22:04', '2020-11-11 06:22:04'),
(5, 'delete database pdo', 'đây là nội dung bài giảng pdo', 'show', 2, NULL, '2020-11-11 06:29:42', '2020-11-11 06:29:42');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_course_offlines`
--

CREATE TABLE `schedule_course_offlines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `text_time_learn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `max_student` int(11) DEFAULT NULL,
  `now_student` int(11) DEFAULT 0,
  `status` enum('show','hidden') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedule_course_offlines`
--

INSERT INTO `schedule_course_offlines` (`id`, `title`, `date_start`, `text_time_learn`, `course_id`, `max_student`, `now_student`, `status`, `created_at`, `updated_at`, `note`) VALUES
(2, 'php-3', '2020-11-11', 'thứ 6 hàng tuần', 2, 45, NULL, 'hidden', '2020-11-11 08:13:26', '2020-11-11 08:39:50', 'mmmm');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('show','hidden') COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` bigint(20) UNSIGNED DEFAULT NULL,
  `sort` bigint(20) UNSIGNED DEFAULT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `thumbnail`, `status`, `creator`, `sort`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'uploads/sliders/1604993692.png', 'show', NULL, NULL, 'banner-1', '2020-11-10 00:34:52', '2020-11-10 02:04:37', NULL),
(5, 'uploads/sliders/1604993721.png', 'show', NULL, NULL, 'banner-2', '2020-11-10 00:35:21', '2020-11-10 02:04:37', NULL),
(7, 'uploads/sliders/1604999206.png', 'show', NULL, NULL, 'banner-3', '2020-11-10 02:06:46', '2020-11-10 02:06:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `username`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `thumbnail`, `note`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'NguyenHThienN', 'cakho@gmail.com', '0394182553', 'Thiennhan2001', '$2y$10$rSwS6kntokYJZaZcrGVfW.ay8w8fB7vIhBbeCbwWQzLCjAFgmWDae', NULL, NULL, 'uploads/users/nguyenhthienn.png', NULL, NULL, '2020-11-08 08:10:02', '2020-11-13 18:53:43', NULL),
(7, 'Nguyễn Hữu Khương', 'khuongdev2001@gmail.com', '0394182551', 'khuongdev2001', '$2y$10$7YSjA.7rHcj3FPY6rXSAm./YmlH0M1vtQc0qPq5KjLlzlp4Tw8cr6', NULL, NULL, 'uploads/users/nguyen-huu-khuong.png', NULL, NULL, '2020-11-08 09:31:14', '2020-11-13 17:04:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_pay_courses`
--

CREATE TABLE `user_pay_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pay_id` bigint(20) UNSIGNED NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `status` enum('received','pending','success','error') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_pay_courses`
--

INSERT INTO `user_pay_courses` (`id`, `code`, `course_id`, `user_id`, `pay_id`, `discount`, `status`, `sort`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'kdjfkajdkjfk', 1, 4, 2, NULL, 'pending', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(2, 4, 1, '2020-11-08 08:10:02', '2020-11-08 20:35:04'),
(5, 7, 1, '2020-11-08 09:31:14', '2020-11-13 17:04:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cat_courses`
--
ALTER TABLE `cat_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cat_posts`
--
ALTER TABLE `cat_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `comment_courses`
--
ALTER TABLE `comment_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_courses_user_id_foreign` (`user_id`),
  ADD KEY `comment_courses_cat_id_foreign` (`cat_id`);

--
-- Indexes for table `comment_posts`
--
ALTER TABLE `comment_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_posts_user_id_foreign` (`user_id`),
  ADD KEY `comment_posts_cat_id_foreign` (`cat_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_cat_id_foreign` (`cat_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_cat_id_foreign` (`cat_id`),
  ADD KEY `posts_creator_foreign` (`creator`);

--
-- Indexes for table `product_courses`
--
ALTER TABLE `product_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_courses_course_id_foreign` (`course_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `route_course_offlines`
--
ALTER TABLE `route_course_offlines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_course_offlines_course_id_foreign` (`course_id`),
  ADD KEY `route_course_offlines_creator_foreign` (`creator`);

--
-- Indexes for table `schedule_course_offlines`
--
ALTER TABLE `schedule_course_offlines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_course_offlines_course_id_foreign` (`course_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sliders_creator_foreign` (`creator`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_pay_courses`
--
ALTER TABLE `user_pay_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_pay_courses_course_id_foreign` (`course_id`),
  ADD KEY `user_pay_courses_user_id_foreign` (`user_id`),
  ADD KEY `user_pay_courses_pay_id_foreign` (`pay_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_roles_user_id_foreign` (`user_id`),
  ADD KEY `user_roles_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cat_courses`
--
ALTER TABLE `cat_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cat_posts`
--
ALTER TABLE `cat_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment_courses`
--
ALTER TABLE `comment_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comment_posts`
--
ALTER TABLE `comment_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pays`
--
ALTER TABLE `pays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_courses`
--
ALTER TABLE `product_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `route_course_offlines`
--
ALTER TABLE `route_course_offlines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schedule_course_offlines`
--
ALTER TABLE `schedule_course_offlines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_pay_courses`
--
ALTER TABLE `user_pay_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_courses`
--
ALTER TABLE `comment_courses`
  ADD CONSTRAINT `comment_courses_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_courses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_posts`
--
ALTER TABLE `comment_posts`
  ADD CONSTRAINT `comment_posts_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `cat_courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_cat_id_foreign` FOREIGN KEY (`cat_id`) REFERENCES `cat_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_creator_foreign` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_courses`
--
ALTER TABLE `product_courses`
  ADD CONSTRAINT `product_courses_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `route_course_offlines`
--
ALTER TABLE `route_course_offlines`
  ADD CONSTRAINT `route_course_offlines_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `route_course_offlines_creator_foreign` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedule_course_offlines`
--
ALTER TABLE `schedule_course_offlines`
  ADD CONSTRAINT `schedule_course_offlines_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sliders`
--
ALTER TABLE `sliders`
  ADD CONSTRAINT `sliders_creator_foreign` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_pay_courses`
--
ALTER TABLE `user_pay_courses`
  ADD CONSTRAINT `user_pay_courses_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_pay_courses_pay_id_foreign` FOREIGN KEY (`pay_id`) REFERENCES `pays` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_pay_courses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
