-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 08 Nov 2023 pada 14.21
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyek2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alamat`
--

CREATE TABLE `alamat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cities_id` int(11) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_primary` int(10) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `primary` int(11) NOT NULL DEFAULT 0,
  `penerima` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `alamat`
--

INSERT INTO `alamat` (`id`, `cities_id`, `detail`, `user_id`, `is_primary`, `created_at`, `updated_at`, `primary`, `penerima`) VALUES
(1, 4, 'Jalan Jakarta 4', 24, 0, '2023-03-01 05:44:51', '2023-03-12 02:03:06', 1, '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `alamat_toko`
--

CREATE TABLE `alamat_toko` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city_id` int(11) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `alamat_toko`
--

INSERT INTO `alamat_toko` (`id`, `city_id`, `detail`, `created_at`, `updated_at`) VALUES
(1, 133, 'Jalan raya Menganti no.158 Hulaan , Kec. menganti', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `banners`
--

INSERT INTO `banners` (`id`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Diskon Produk Mirae', 'Diskon Produk Mirae', 'imagebanner/bi79RQ5yG7equyT3JoCW5k4jfvEK7DNXKDGfrQ0w.png', '2023-03-11 22:47:05', '2023-03-11 22:47:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Beras', '2023-03-02 04:18:51', '2023-03-02 04:18:51'),
(2, 'Minyak Goreng', '2023-03-02 04:18:59', '2023-03-02 04:18:59'),
(3, 'Susu', '2023-03-02 04:19:05', '2023-03-02 04:19:05'),
(4, 'Kopi', '2023-03-02 04:19:12', '2023-03-02 04:19:12'),
(5, 'Alat Kebersihan', '2023-03-02 04:19:27', '2023-03-02 04:19:27'),
(6, 'Alat Pencukur', '2023-03-02 04:19:35', '2023-03-02 04:19:35'),
(7, 'Gula', '2023-03-02 04:19:45', '2023-03-02 04:19:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `province_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cities`
--

INSERT INTO `cities` (`id`, `province_id`, `city_id`, `title`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Jakarta Utara', NULL, NULL),
(2, 1, 2, 'Jakarta Selatan', NULL, NULL),
(3, 1, 3, 'Jakarta Barat', NULL, NULL),
(4, 1, 4, 'Jakarta Timur', NULL, NULL),
(5, 1, 5, 'Bogor', NULL, NULL),
(6, 1, 6, 'Depok', NULL, NULL),
(7, 1, 7, 'Tangerang', NULL, NULL),
(8, 1, 8, 'Tangerang Selatan', NULL, NULL),
(9, 1, 9, 'Bekasi', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('mendrn4q8omvgjukvma8aaega0b6j4ca', '::1', 1664877674, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343837373637343b5573657249447c733a313a2231223b557365727c733a31323a22526f62696e2049726177616e223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b),
('kh81goanleaosmdmdmlpuvceis93opo0', '::1', 1664877988, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343837373938383b5573657249447c733a313a2231223b557365727c733a31323a22526f62696e2049726177616e223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b636172745f636f6e74656e74737c613a333a7b733a31303a22636172745f746f74616c223b643a313030303030303b733a31313a22746f74616c5f6974656d73223b643a31303b733a33323a223832303861333463383730656331636464623162303932663436346233333932223b613a363a7b733a323a226964223b733a343a2250303032223b733a333a22717479223b643a31303b733a353a227072696365223b643a3130303030303b733a343a226e616d65223b733a373a225072696e746572223b733a353a22726f776964223b733a33323a223832303861333463383730656331636464623162303932663436346233333932223b733a383a22737562746f74616c223b643a313030303030303b7d7d),
('63gvfo34i2ru3kmdr7irjq6kffnln19q', '::1', 1664878305, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343837383330353b5573657249447c733a313a2231223b557365727c733a31323a22526f62696e2049726177616e223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b),
('vjtrv4p0t15jts5683g0sq9j73qfeke3', '::1', 1664878606, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343837383630363b5573657249447c733a313a2231223b557365727c733a31323a22526f62696e2049726177616e223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b),
('4skfm0fpd3vjmq7r78kimlq8otceort0', '::1', 1664878945, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343837383934353b5573657249447c733a313a2231223b557365727c733a31323a22526f62696e2049726177616e223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b),
('a5nghe1t9rdiki23h0idupsb9dfsnj9o', '::1', 1664879364, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343837393336343b),
('n7q59sam7lvov25qkggdq3d0053vva5t', '::1', 1664879687, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343837393638373b),
('ucj6am645ss5pt9fti0ukabi3g3ct0g7', '::1', 1664886748, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343838363734383b),
('u7p3crjc9kum2caaopek3p8bq5eqqt23', '::1', 1664887063, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343838373036333b5573657249447c733a313a2231223b557365727c733a31323a22526f62696e2049726177616e223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b),
('f9j4neifatp1tj8qmpr540t6qk82nl4u', '::1', 1664887390, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343838373339303b5573657249447c733a313a2231223b557365727c733a31323a22526f62696e2049726177616e223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b),
('jjb4pn0ncp9q0omsd8kenoknk1alsjir', '::1', 1664887713, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343838373731333b5573657249447c733a313a2231223b557365727c733a31323a22526f62696e2049726177616e223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b),
('i8lr4qktssdcfhahltq5k6m2gm8alqdh', '::1', 1664888075, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343838383037353b5573657249447c733a313a2231223b557365727c733a31323a22526f62696e2049726177616e223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b),
('36u8lrmgqnl0glsu8lj6f47v6b1g8h70', '::1', 1664888263, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343838383236333b),
('03q39asdebqifgb25c5s4jt4c80rd5dp', '::1', 1664945390, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343934353339303b5573657249447c733a313a2231223b557365727c733a31323a22526f62696e2049726177616e223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b),
('krlvdip03i6fvfjepoi1iabijhnjqo9v', '::1', 1664945707, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343934353730373b5573657249447c733a313a2231223b557365727c733a31323a22526f62696e2049726177616e223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b),
('5f908k8keekq4ersga9hr8ge8c2o24as', '::1', 1664946046, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636343934363034363b),
('l9ep4anfjqamdg6adj6dllvjdaf0kuta', '::1', 1665755261, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636353735353236313b5573657249447c733a313a2231223b557365727c733a31323a22526f62696e2049726177616e223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b737563636573737c733a32383a2250726f66696c20626572686173696c20646970657262617275692e2e223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('hqtce4h0i106ua130ce74hettftpn0pa', '::1', 1665755511, 0x5f5f63695f6c6173745f726567656e65726174657c693a313636353735353236313b5573657249447c733a313a2231223b557365727c733a31323a226b6576696e20616469747961223b6c6576656c7c733a353a2261646d696e223b666f746f7c733a31383a22666f746f313635323639323537332e706e67223b737563636573737c733a32383a2250726f66696c20626572686173696c20646970657262617275692e2e223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d);

-- --------------------------------------------------------

--
-- Struktur dari tabel `couriers`
--

CREATE TABLE `couriers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_order`
--

CREATE TABLE `detail_order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_order`
--

INSERT INTO `detail_order` (`id`, `order_id`, `product_id`, `qty`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, '2023-03-12 02:50:50', '2023-03-12 02:50:50'),
(2, 1, 3, 1, '2023-03-12 02:50:50', '2023-03-12 02:50:50'),
(3, 2, 3, 1, '2023-03-12 02:51:28', '2023-03-12 02:51:28'),
(4, 3, 3, 1, '2023-03-12 02:53:22', '2023-03-12 02:53:22'),
(5, 4, 1, 1, '2023-03-12 03:06:28', '2023-03-12 03:06:28'),
(6, 5, 1, 1, '2023-03-12 03:09:30', '2023-03-12 03:09:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `fish`
--

CREATE TABLE `fish` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `fish`
--

INSERT INTO `fish` (`id`, `name`, `created_at`, `updated_at`) VALUES
(4, 'BT', '2023-10-12 00:58:56', '2023-10-12 00:58:56'),
(5, 'CK', '2023-10-12 00:59:04', '2023-10-12 00:59:04'),
(6, 'DH', '2023-10-12 00:59:16', '2023-10-12 00:59:16'),
(7, 'MB', '2023-10-12 01:00:52', '2023-10-12 01:00:52'),
(8, 'MS', '2023-10-12 01:01:11', '2023-10-12 01:01:11'),
(9, 'Tuna', '2023-10-12 01:02:17', '2023-10-12 01:02:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `grade`
--

CREATE TABLE `grade` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `grade`
--

INSERT INTO `grade` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'A', '2023-10-09 04:19:51', '2023-10-09 04:20:45'),
(2, 'L', '2023-10-09 07:15:58', '2023-10-09 07:15:58'),
(3, 'PP', '2023-10-12 01:23:01', '2023-10-12 01:23:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kedatangan`
--

CREATE TABLE `kedatangan` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `date` date NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `urutan` varchar(11) NOT NULL,
  `fish_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `kontainer` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kedatangan`
--

INSERT INTO `kedatangan` (`id`, `code`, `date`, `warehouse_id`, `supplier_id`, `urutan`, `fish_id`, `size_id`, `grade_id`, `qty`, `kontainer`, `created_at`, `updated_at`) VALUES
(17, '3/1/D3/SUP4/10122023', '2023-10-12', 3, 4, '1', 5, 1, 1, 98, 3, '2023-10-12 06:04:08', '2023-10-12 06:04:08'),
(18, '1/1/BG/SUP3/10122023', '2023-10-12', 1, 3, '1', 5, 5, 1, 98, 1, '2023-10-12 06:09:49', '2023-10-12 06:09:49'),
(19, '1/2/BG/SUP3/10122023', '2023-10-12', 1, 3, '2', 4, 1, 1, 91, 1, '2023-10-12 06:12:20', '2023-10-12 06:12:20'),
(20, '1/3/BG/SUP3/10122023', '2023-10-12', 1, 3, '3', 6, 7, 2, 98, 1, '2023-10-12 06:13:06', '2023-10-12 06:13:06'),
(21, '2/1/AK/SUP4/10122023', '2023-10-12', 2, 4, '1', 4, 6, 1, 98, 2, '2023-10-12 06:14:08', '2023-10-12 06:14:08'),
(22, '2/2/AK/SUP4/10122023', '2023-10-12', 2, 4, '2', 6, 6, 2, 98, 2, '2023-10-12 06:14:46', '2023-10-12 06:14:46'),
(23, '2/3/AK/SUP4/10122023', '2023-10-12', 2, 4, '3', 7, 6, 2, 98, 2, '2023-10-12 06:15:32', '2023-10-12 06:15:32'),
(24, '3/2/D3/SUP4/10122023', '2023-10-12', 3, 4, '2', 6, 7, 1, 98, 3, '2023-10-12 06:17:01', '2023-10-12 06:17:01'),
(25, '1/1/D1/SUP3/10102023', '2023-10-10', 1, 3, '1', 4, 1, 1, 84, 1, '2023-10-12 06:19:28', '2023-10-12 06:19:28'),
(26, '1/2/D1/SUP3/10102023', '2023-10-10', 1, 3, '2', 4, 7, 1, 98, 1, '2023-10-12 06:20:46', '2023-10-12 06:20:46'),
(27, '1/3/D1/SUP3/10102023', '2023-10-10', 1, 3, '3', 6, 6, 1, 98, 1, '2023-10-12 06:21:22', '2023-10-12 06:21:22'),
(28, '1/1/D1/SUP3/07102023', '2023-10-07', 1, 3, '1', 4, 6, 1, 98, 1, '2023-10-12 06:26:38', '2023-10-12 06:26:38'),
(29, '1/1/D1/SUP3/14102023', '2023-10-14', 1, 3, '1', 6, 5, 1, 98, 1, '2023-10-13 23:51:42', '2023-10-13 23:51:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kedatangan_rack`
--

CREATE TABLE `kedatangan_rack` (
  `id` int(11) NOT NULL,
  `rack_id` int(11) NOT NULL,
  `kedatangan_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kedatangan_rack`
--

INSERT INTO `kedatangan_rack` (`id`, `rack_id`, `kedatangan_id`, `created_at`, `updated_at`) VALUES
(1, 1, 17, '2023-10-29 21:18:58', '2023-10-29 21:18:58'),
(2, 2, 25, '2023-11-08 05:55:40', '2023-11-08 05:55:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `products_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id`, `user_id`, `products_id`, `qty`, `created_at`, `updated_at`) VALUES
(13, 25, 3, 3, '2023-03-16 07:04:28', '2023-03-26 21:08:39'),
(14, 25, 4, 4, '2023-03-16 07:07:37', '2023-03-26 21:08:54'),
(15, 25, 1, 5, '2023-03-26 20:56:03', '2023-03-26 21:08:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_03_22_020309_create_provinces_table', 1),
(5, '2020_03_22_020319_create_cities_table', 1),
(6, '2020_03_22_020330_create_couriers_table', 1),
(7, '2020_03_22_074903_create_categories_tables', 1),
(8, '2020_03_22_074918_create_products_tables', 1),
(9, '2020_03_22_132305_create_alamat_tables', 1),
(10, '2020_03_22_132559_create_order_table', 1),
(11, '2020_03_22_132659_create_detail_order', 1),
(12, '2020_03_22_134342_create_status_order_table', 1),
(13, '2020_03_22_143238_add_stok_to_product', 2),
(14, '2020_03_22_150047_create_rekening_table', 3),
(15, '2020_03_22_150145_add_biaya_cod_to_order', 3),
(16, '2020_03_23_101813_add_keterangan_to_order', 4),
(17, '2020_03_23_101848_create_keranjang_table', 4),
(18, '2020_03_24_071526_add_bukti_telepon_to_order', 5),
(19, '2020_03_24_072038_add_pesan_to_order', 6),
(20, '2020_03_26_131136_create_alamat_toko_table', 7),
(21, '2023_02_19_083238_create_banners_table', 8),
(22, '2023_02_24_232345_create_ongkir_tables', 9),
(23, '2023_02_27_043106_add_primary_to_alamat', 10),
(24, '2023_03_01_203206_add_penerima_to_alamat', 11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ongkir`
--

CREATE TABLE `ongkir` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cities_id` int(11) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ongkir`
--

INSERT INTO `ongkir` (`id`, `cities_id`, `ongkir`, `created_at`, `updated_at`) VALUES
(1, 1, 50000, NULL, NULL),
(2, 2, 45000, NULL, NULL),
(3, 3, 40000, NULL, NULL),
(4, 4, 50000, NULL, NULL),
(5, 5, 50000, NULL, NULL),
(6, 6, 50000, NULL, NULL),
(7, 7, 50000, NULL, NULL),
(8, 8, 50000, NULL, NULL),
(9, 9, 50000, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `order`
--

CREATE TABLE `order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subtotal` bigint(20) NOT NULL,
  `no_resi` varchar(255) DEFAULT NULL,
  `status_order_id` bigint(20) UNSIGNED NOT NULL,
  `metode_pembayaran` varchar(255) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `biaya_cod` int(11) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `pesan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order`
--

INSERT INTO `order` (`id`, `invoice`, `user_id`, `subtotal`, `no_resi`, `status_order_id`, `metode_pembayaran`, `ongkir`, `created_at`, `updated_at`, `biaya_cod`, `no_hp`, `bukti_pembayaran`, `pesan`) VALUES
(1, 'ALV202303120946', 24, 266500, NULL, 1, 'Transfer', 50000, '2023-03-12 02:50:50', '2023-03-12 02:50:50', 0, '085895533051', NULL, NULL),
(2, 'ALV202303120951', 24, 34500, NULL, 1, 'Transfer', 50000, '2023-03-12 02:51:28', '2023-03-12 02:51:28', 0, '085895533051', NULL, NULL),
(3, 'ALV202303120953', 24, 34500, NULL, 1, 'Transfer', 50000, '2023-03-12 02:53:22', '2023-03-12 02:53:22', 0, '085895533051', NULL, NULL),
(4, 'ALV202303121006', 24, 58000, NULL, 1, 'Transfer', 50000, '2023-03-12 03:06:28', '2023-03-12 03:06:28', 0, '085895533051', NULL, NULL),
(5, 'ALV202303121009', 24, 58000, NULL, 1, 'Transfer', 50000, '2023-03-12 03:09:30', '2023-03-12 03:09:30', 0, '085895533051', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `price` int(11) NOT NULL,
  `weigth` int(11) NOT NULL,
  `panjang` int(100) NOT NULL,
  `lebar` int(100) NOT NULL,
  `isi` int(100) NOT NULL,
  `categories_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `weigth`, `panjang`, `lebar`, `isi`, `categories_id`, `created_at`, `updated_at`, `stok`) VALUES
(1, 'Beras Eunak', 'Beras yang menghasilkan nasi dengan rasa yang enak, pulen dan gurih yang dihasilkan oleh petani Jawa Barat. Dikemas dengan teknolohi modern serta pengeringan yang optimal, menjadikan beras ini lebih tahan lama dan tanpa campuran bahan pengawet.', 'imageproduct/jX3NysxlahOao9KL66yozQ0ib5NGCvqwblK4eLLu.jpg', 58000, 5000, 0, 0, 0, 1, '2023-03-06 20:24:54', '2023-03-06 20:48:10', 0),
(3, 'Minyak Goreng Filma 2L', 'Filma Minyak Goreng merupakan minyak goreng yang terbuat dari kelapa sawit segar pilihan dengan teknologi penyulingan terbaru. Mengingat minyak goreng adalah bahan penting dalam proses memasak, membuat Anda harus selektif dalam pemilihan minyak goreng.', 'imageproduct/oZWfVfvq9iSoKCNMDvcRgwtKk4MRMKD8evslg06H.jpg', 35850, 2000, 0, 0, 0, 2, '2023-03-06 20:33:15', '2023-03-12 21:16:28', 0),
(4, 'Minyak Goreng Mitra 2L', 'Mitra Minyak Goreng Pouch 2 L merupakan minyak goreng yang dihasilkan dari kelapa sawit pilihan dan diproses dengan tekhnologi yang mutakhir dengan pemilihan bahan baku dan diproses secara higeinis sehingga, mampu mempertahankan kandungan zat-zat yang bermanfaat bagi kesehatan.', 'imageproduct/ECfK9cjJBLDZKQ2soK1sqGWx9JDCek5KW8LkvZAb.jpg', 33200, 2000, 0, 0, 0, 2, '2023-03-06 20:44:05', '2023-03-12 21:16:51', 0),
(5, 'Susu Diamond Full Cream 1L', 'Diamond UHT Full Cream mengemas susu segar tanpa penambahan bahan pengawet yang diproses secara Ultra High Temperature (UHT) atau pemanasan pada suhu yang sangat tinggi dan dalam waktu singkat sehingga susu bebas dari bakteri yang mengganggu nutrisi serta kandungan.', 'imageproduct/oWhB8LuHzi5xqjwRm8DgejnpmxKFC9grg6fxxMjE.jpg', 16275, 1000, 0, 0, 0, 3, '2023-03-06 23:04:15', '2023-03-07 01:00:16', 200),
(6, 'Gula Rosebrand Hijau 1kg', 'Berasal dari gula tebu pilihan dan berkualitas yang diproses dengan menggunakan mesin berteknologi modern untuk menghasilkan gula yang putih higienis dan berkualitas', 'imageproduct/xpCzqBlUUAeSdhLFB1fT0MfXWXvoh8iY8erxUQFy.jpg', 13350, 1000, 0, 0, 0, 7, '2023-03-06 23:05:44', '2023-03-07 00:50:14', 0),
(7, 'Kopi Kapal Api Special Mix', 'Kopi Kapal Api terbuat dari biji kopi pilihan dan diproses dengan mesin yang paling modern yang menghasilkan kopi berkualitas tinggi dengan Aroma terbaik dan Rasa yang enak.\r\nKapal Api Special Mix Dibuat dari Biji kopi pilihan yang diolah dengan mesin yang paling modern dan campuran gula murni.', 'imageproduct/n6d9aqv6ic0Ou8krEyZwRgMmnfs3qYKt3YKTCo5K.jpg', 11500, 24, 0, 0, 0, 4, '2023-03-06 23:07:53', '2023-03-07 00:56:02', 0),
(8, 'Starke Confidence Twin Blade (Pink)', 'Pouch isi 5pcs\r\n• Inner Box isi 20 Pouch\r\n• Karton isi 16 Inner Box', 'imageproduct/9sW5kd3LpPMfWtYoTCkpucCkc2GYeKd5JXRFE10u.jpg', 15500, 100, 0, 0, 0, 6, '2023-03-10 06:06:06', '2023-03-10 06:06:06', 0),
(9, 'Starke Premium Long Handle', '• Pouch isi 5pcs\r\n• Inner Box isi 20 Pouch\r\n• Karton isi 16 inner Box', 'imageproduct/J3TvayuXTFFrIDOCoIUNwfaNLVy2yTrLxT6Ll3vN.jpg', 22000, 100, 0, 0, 0, 6, '2023-03-10 06:07:47', '2023-03-10 06:07:47', 0),
(10, 'Starke Premium Twin Blade Non Lubra (Black)', '• Pouch isi 5pcs\r\n• Inner Box isi 20 Pouch\r\n• Karton isi 16 inner Box', 'imageproduct/gyLNSg0nW7tba6SUfKXTg8Uk3oJ9aywZi6mYUUfr.jpg', 12500, 100, 0, 0, 0, 6, '2023-03-10 06:09:39', '2023-03-10 06:09:39', 0),
(11, 'Starke Premium Twin Blade With Lubra (Blue)', '• Pouch isi 5pcs\r\n• Inner Box isi 20 Pouch\r\n• Karton isi 16 inner Box', 'imageproduct/tIGx4Yes6ANHEikNnLQsY29IU7YXgYIZdOWFQZtU.jpg', 15500, 100, 0, 0, 0, 6, '2023-03-10 06:10:49', '2023-03-10 06:10:49', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `provinces`
--

CREATE TABLE `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `province_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `provinces`
--

INSERT INTO `provinces` (`id`, `province_id`, `title`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jabodetabek', '2020-03-22 07:06:12', '2020-03-22 07:06:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `code` varchar(11) NOT NULL,
  `fish_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rack`
--

CREATE TABLE `rack` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rack`
--

INSERT INTO `rack` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'A1', '2023-10-28 16:29:55', '2023-10-28 16:29:55'),
(2, 'A1.1', '2023-10-30 09:08:58', '2023-10-30 09:08:58'),
(3, 'A1.1.1', '2023-11-08 06:06:50', '2023-11-08 06:06:50'),
(4, 'A1.1.2', '2023-11-08 06:07:10', '2023-11-08 06:07:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening`
--

CREATE TABLE `rekening` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `atas_nama` varchar(255) NOT NULL,
  `no_rekening` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rekening`
--

INSERT INTO `rekening` (`id`, `bank_name`, `atas_nama`, `no_rekening`, `created_at`, `updated_at`) VALUES
(4, 'BCA', 'MIRAE DISTRIBUSI INDO PT', '2771784099', '2020-03-24 17:22:37', '2023-03-06 20:35:31'),
(5, 'MANDIRI', 'PT MIRAE', '9999888899999', '2020-03-24 17:23:12', '2020-03-24 17:23:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `size`
--

INSERT INTO `size` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '6 - 10', '2023-10-09 04:25:30', '2023-10-09 04:25:30'),
(4, '11-20', '2023-10-12 01:24:17', '2023-10-12 01:24:17'),
(5, '21-30', '2023-10-12 01:24:26', '2023-10-12 01:24:26'),
(6, '31-40', '2023-10-12 01:25:13', '2023-10-12 01:25:13'),
(7, '41-60', '2023-10-12 01:25:49', '2023-10-12 01:25:49'),
(8, '61-80', '2023-10-12 01:25:59', '2023-10-12 01:25:59'),
(9, '81-100', '2023-10-12 01:26:12', '2023-10-12 01:26:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_order`
--

CREATE TABLE `status_order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `status_order`
--

INSERT INTO `status_order` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Belum Bayar', NULL, NULL),
(2, 'Perlu Di Cek', NULL, NULL),
(3, 'Telah Di Bayar', NULL, NULL),
(4, 'Barang Di Kirim', NULL, NULL),
(5, 'Barang Telah Sampai', NULL, NULL),
(6, 'Pesanan Di Batalkan', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `created_at`, `updated_at`) VALUES
(3, 'KB', '2023-10-12 01:27:02', '2023-10-12 01:27:02'),
(4, 'AK', '2023-10-12 01:27:13', '2023-10-12 01:27:13'),
(5, 'DN1', '2023-10-12 01:27:26', '2023-10-12 01:27:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `kode_barang` varchar(6) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `harga` double NOT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_barang`
--

INSERT INTO `tbl_barang` (`kode_barang`, `nama_barang`, `brand`, `stok`, `harga`, `active`) VALUES
('ADNAPS', 'Advan NASA Plus', 'Advan', 10, 770000, 'Y'),
('AG5ELE', 'Advan G5 Elite', 'Advan', 10, 882000, 'Y'),
('EVM6A', 'Evercoss M6A', 'Evercoss', 10, 935000, 'Y'),
('ITVN1', 'Itel Vision 1', 'Vision', 10, 975000, 'Y'),
('NKC120', 'Nokia C1 2020', 'Nokia', 10, 765000, 'Y'),
('SGA01C', 'Samsung Galaxy A01 Core', 'Samsung', 10, 970000, 'Y'),
('XIAR5A', 'Xiaomi Redmi 5A', 'Xiaomi', 10, 680000, 'Y'),
('XRN216', 'Xiaomi Redmi Note 2 16GB', 'Xiaomi', 10, 725000, 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_detail_pembelian`
--

CREATE TABLE `tbl_detail_pembelian` (
  `id_pembelian` varchar(20) NOT NULL,
  `id_barang` varchar(6) NOT NULL,
  `qty` smallint(6) NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `tbl_detail_pembelian`
--
DELIMITER $$
CREATE TRIGGER `pembelian_barang` AFTER INSERT ON `tbl_detail_pembelian` FOR EACH ROW BEGIN
	UPDATE tbl_barang b SET b.stok = b.stok + new.qty
    WHERE b.kode_barang = new.id_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_pembelian` AFTER DELETE ON `tbl_detail_pembelian` FOR EACH ROW BEGIN
	UPDATE tbl_barang b SET b.stok = b.stok - old.qty
    WHERE b.kode_barang = old.id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_detail_penjualan`
--

CREATE TABLE `tbl_detail_penjualan` (
  `id_penjualan` varchar(20) NOT NULL,
  `id_barang` varchar(6) NOT NULL,
  `qty` smallint(6) NOT NULL,
  `harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `tbl_detail_penjualan`
--
DELIMITER $$
CREATE TRIGGER `penjualan_barang` AFTER INSERT ON `tbl_detail_penjualan` FOR EACH ROW BEGIN
	UPDATE tbl_barang b SET b.stok = b.stok - new.qty
    WHERE b.kode_barang = new.id_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_penjualan` AFTER DELETE ON `tbl_detail_penjualan` FOR EACH ROW BEGIN
	UPDATE tbl_barang b SET b.stok = b.stok + old.qty
    WHERE b.kode_barang = old.id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pembelian`
--

CREATE TABLE `tbl_pembelian` (
  `id_pembelian` varchar(20) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `id_supplier` varchar(15) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penjualan`
--

CREATE TABLE `tbl_penjualan` (
  `id_penjualan` varchar(20) NOT NULL,
  `nama_pembeli` varchar(30) NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id_supplier` varchar(15) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `foto` varchar(50) NOT NULL DEFAULT 'default.jpg',
  `level` enum('admin','pegawai') NOT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `fullname`, `password`, `alamat`, `hp`, `foto`, `level`, `active`, `last_login`) VALUES
(1, 'kevin', 'kevin aditya', '$2y$08$BO41OJFfhPPPzjKdWw2I6OyUElK1mkD43UVt1ss6J1xrVUExC1lRy', 'Pulau Sabira', '082114504970', 'foto1652692573.png', 'admin', 'Y', '2022-10-05 12:00:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` varchar(30) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$mhz55nqA1Q9VZO.rH3GSkOuO.MO2JqEfnp7g.qKYm5lhls4g/Rmpy', NULL, 'admin', NULL, NULL, NULL),
(24, 'Naufal R', 'nopalakhmad1234@gmail.com', NULL, '$2y$10$Ox35LncfP3q4a9.vH8C6SOQUjdE06wXtM.4Az6EpwfLsyu7ELB.Cm', '085895533051', 'customer', NULL, '2023-03-01 05:44:31', '2023-03-01 05:44:31'),
(25, 'Akhmad Naufal Refandi', 'nopalakhmad@gmail.com', NULL, '$2y$10$J9/0D19vjo3KtPv1QW96MuOodBxu2Ue5gxPfOuvH5WYLXXJlqiZ.y', '085895533053', 'customer', NULL, '2023-03-14 00:38:10', '2023-03-14 00:38:10'),
(26, 'Dev Muson', 'dev@muson.id', NULL, '$2y$10$xtYvGmZyU5h4I7PLCiH/B.A3is.uDmTeSjyKx/yUr60GgRS1zVluK', '08979998040', 'customer', NULL, '2023-03-31 23:16:24', '2023-03-31 23:16:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `warehouse`
--

CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `warehouse`
--

INSERT INTO `warehouse` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'D1', '2023-10-09 04:35:04', '2023-10-12 06:18:26'),
(2, 'D2', '2023-10-09 07:15:05', '2023-10-12 06:18:36'),
(3, 'D3', '2023-10-09 07:15:15', '2023-10-09 07:15:15');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `alamat_toko`
--
ALTER TABLE `alamat_toko`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indeks untuk tabel `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_order`
--
ALTER TABLE `detail_order`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `fish`
--
ALTER TABLE `fish`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kedatangan`
--
ALTER TABLE `kedatangan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kedatangan_rack`
--
ALTER TABLE `kedatangan_rack`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ongkir`
--
ALTER TABLE `ongkir`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rack`
--
ALTER TABLE `rack`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `status_order`
--
ALTER TABLE `status_order`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`kode_barang`);

--
-- Indeks untuk tabel `tbl_pembelian`
--
ALTER TABLE `tbl_pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indeks untuk tabel `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `alamat_toko`
--
ALTER TABLE `alamat_toko`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_order`
--
ALTER TABLE `detail_order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `fish`
--
ALTER TABLE `fish`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kedatangan`
--
ALTER TABLE `kedatangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `kedatangan_rack`
--
ALTER TABLE `kedatangan_rack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `ongkir`
--
ALTER TABLE `ongkir`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `order`
--
ALTER TABLE `order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rack`
--
ALTER TABLE `rack`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `status_order`
--
ALTER TABLE `status_order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
