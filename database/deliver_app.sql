-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 06:49 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deliver_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','abandoned','completed') NOT NULL DEFAULT 'active',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'abandoned', 31, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(2, 'completed', 31, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(3, 'abandoned', 36, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(4, 'abandoned', 3, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(5, 'abandoned', 16, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(6, 'abandoned', 38, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(7, 'abandoned', 40, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(8, 'completed', 36, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(9, 'active', 5, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(10, 'active', 36, '2024-12-03 10:32:56', '2024-12-03 10:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `cart_products`
--

CREATE TABLE `cart_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_products`
--

INSERT INTO `cart_products` (`id`, `quantity`, `cart_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, '2', 6, 16, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(2, '3', 5, 1, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(3, '5', 4, 12, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(4, '1', 6, 12, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(5, '4', 9, 1, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(6, '5', 6, 10, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(8, '2', 1, 20, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(9, '1', 4, 19, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(10, '4', 6, 11, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(11, '1', 6, 17, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(12, '2', 9, 2, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(13, '1', 1, 7, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(14, '1', 9, 11, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(15, '1', 3, 11, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(16, '5', 6, 6, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(17, '1', 6, 2, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(18, '5', 7, 5, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(19, '4', 4, 5, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(20, '5', 8, 9, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(21, '2', 1, 15, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(22, '4', 8, 1, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(23, '5', 10, 16, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(25, '2', 8, 2, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(26, '1', 9, 12, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(27, '5', 6, 12, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(29, '2', 6, 6, '2024-12-03 10:32:57', '2024-12-03 10:32:57'),
(30, '2', 7, 15, '2024-12-03 10:32:57', '2024-12-03 10:32:57');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_11_25_140700_create_personal_access_tokens_table', 1),
(5, '2024_12_01_150902_create_stores_table', 1),
(6, '2024_12_01_151305_create_products_table', 1),
(7, '2024_12_01_152248_create_carts_table', 1),
(8, '2024_12_01_152350_create_cart_products_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(7, 'App\\Models\\User', 42, 'deliver_app', 'eae56a4fa7341917c66b1438a80eea926b766a375929ffe79d3a2b5479a00451', '[\"*\"]', '2024-12-06 14:48:01', NULL, '2024-12-04 16:28:38', '2024-12-06 14:48:01'),
(8, 'App\\Models\\User', 42, 'deliver_app', '2bbdd1f0fa0851951749e243f2e186302972844da2dfa6f4b4b6d1f8ec16cd16', '[\"*\"]', '2024-12-04 17:10:32', NULL, '2024-12-04 17:10:20', '2024-12-04 17:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL DEFAULT '0',
  `img` text DEFAULT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity`, `img`, `store_id`, `created_at`, `updated_at`) VALUES
(1, 'quia', 'Et rerum exercitationem sequi voluptatem.', '73.71', '91', 'https://via.placeholder.com/640x480.png/0066aa?text=non', 10, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(2, 'velit', 'Iure ut laborum perspiciatis aliquam aut quas.', '75.99', '60', 'https://via.placeholder.com/640x480.png/00eebb?text=et', 4, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(3, 'quia', 'Molestiae cum eum corrupti alias dolores occaecati alias quisquam.', '22.39', '65', 'https://via.placeholder.com/640x480.png/0077ff?text=laudantium', 7, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(4, 'reprehenderit', 'Natus placeat ut et tempore vero.', '49.08', '75', 'https://via.placeholder.com/640x480.png/0022ff?text=fuga', 3, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(5, 'non', 'Laudantium recusandae omnis est vero.', '69.04', '6', 'https://via.placeholder.com/640x480.png/00aa55?text=veritatis', 10, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(6, 'recusandae', 'Magni praesentium doloribus et ea.', '14.18', '88', 'https://via.placeholder.com/640x480.png/002255?text=ratione', 4, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(7, 'sint', 'Voluptatem expedita nostrum et rem et dignissimos quibusdam dignissimos.', '35.2', '49', 'https://via.placeholder.com/640x480.png/00cc22?text=voluptatibus', 8, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(9, 'quia', 'Nihil eligendi et earum architecto.', '17.92', '75', 'https://via.placeholder.com/640x480.png/009999?text=illo', 1, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(10, 'in', 'Est libero sequi quam reprehenderit et sequi consequatur.', '56.16', '81', 'https://via.placeholder.com/640x480.png/0022cc?text=ratione', 1, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(11, 'veniam', 'Quo ea beatae cum rem qui id.', '18.58', '9', 'https://via.placeholder.com/640x480.png/00dd99?text=accusantium', 9, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(12, 'asperiores', 'Doloribus nihil quisquam fuga aperiam et ratione aut.', '10.86', '67', 'https://via.placeholder.com/640x480.png/0066cc?text=repellat', 3, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(15, 'aut', 'Sunt sed ipsam dolores sit ut ea adipisci.', '51.92', '25', 'https://via.placeholder.com/640x480.png/003300?text=quaerat', 4, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(16, 'voluptatibus', 'Error quasi enim aut laudantium voluptas soluta voluptatem.', '75.96', '64', 'https://via.placeholder.com/640x480.png/00cc33?text=qui', 2, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(17, 'dicta', 'Adipisci esse sunt magnam nemo.', '60.08', '8', 'https://via.placeholder.com/640x480.png/001133?text=enim', 2, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(18, 'officia', 'Necessitatibus sit beatae amet blanditiis dolor quos laborum reiciendis.', '95.94', '62', 'https://via.placeholder.com/640x480.png/004411?text=architecto', 1, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(19, 'alias', 'Incidunt dolore aperiam ex itaque quia voluptas.', '97.9', '56', 'https://via.placeholder.com/640x480.png/002288?text=quis', 7, '2024-12-03 10:32:56', '2024-12-03 10:32:56'),
(20, 'dolor', 'Minus doloremque sapiente quisquam vero.', '28.76', '82', 'https://via.placeholder.com/640x480.png/0066ff?text=rerum', 7, '2024-12-03 10:32:56', '2024-12-03 10:32:56');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('cxZ5EotD7jDcOmouvIrEfVU50Sv070wieCrSJTM1', NULL, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNkZ2MHQ2SDB3b0hlelFIZmZqS0YzR0dQUHVpdTVLSmhEVVVMY3ZSciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvc3RvcmUiO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL3N0b3JlIjt9fQ==', 1733337723),
('EXZsDKXakUDS3rqxA6PDIYWOkXgz7UTLkdYGe6qU', NULL, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaTBwancyVkxOMWlkd1oyMDFUQ0ZiWThHRnZwcE90YmJrNU9vUVFCbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvc3RvcmUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733336939),
('gdIrY4Sgs35aDAkgckYEjtkZMyObuJHJVK22NjrO', NULL, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicVB2Z05PTG5WOG5RR2h5NVlFUHhnSGFOR25XVVFMclRwYWlpQzlHQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvc3RvcmUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1733336885),
('S80XnGTfTbSbTe1Tbt67qF21sJJe9tg19x3bu7eA', NULL, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZzB1ZFY5VGcyb0cyQ1o4dVR3SGd3WUdqWVhPdVJDWkwwMVlNQ2YxZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvc3RvcmUiO319', 1733337247),
('TQ5cdvCfPK0zDcc04vAEkWhc45Ad0Ppezx87zF9A', NULL, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTW1CT3ZvVVlGRWxEMDFuUTdXYjRBQm5IdmtoNTlyR3J6RUpNVlZFUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvc3RvcmUiO319', 1733340513),
('Vb7gihItTzGJSFI3RBEv6BGeCNtmgC6HaRL9ky0k', 42, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZEtKU2FCalBYOUY4MGdyZWluMHNBdURQcU03UG1iQlI4VTVHckwzUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FwaS9zdG9yZS9zaG93LzUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FwaS9zdG9yZS9zaG93LzUiO319', 1733507281),
('vBFSiXNnBr70YyIKagk2csQkUl82PGze92RDItDl', 42, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmVxQW9mQTNTc09uYThJZGZZdnl3S25sVXk3bGZJdFRsMHVUTmp2cCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvc3RvcmUiO319', 1733343032),
('yRcyzrZIyeJAXb7hYrAD1QLKWv5Q0rmuRnMgexRA', 42, '127.0.0.1', 'PostmanRuntime/7.42.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNnFHbmI2ODc3TjhwamhWRFE0UXRhSURhN0ZtQjB1NklMVTlPWFRMMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvc3RvcmUiO319', 1733343007);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` text DEFAULT NULL,
  `storehead_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `location`, `storehead_id`, `created_at`, `updated_at`) VALUES
(1, 'Jacobson-Doyle', '66761 Jayda Circles\nLake Ladariusland, OH 26660-8467', 10, '2024-12-03 10:31:29', '2024-12-03 10:31:29'),
(2, 'White Inc', '2384 Etha Canyon Suite 490\nPort Lavada, OK 69581', 9, '2024-12-03 10:31:29', '2024-12-03 10:31:29'),
(3, 'Wolf, Hamill and Haley', '9225 Schroeder Crossroad Suite 025\nWest Robynshire, SC 11936-0548', 17, '2024-12-03 10:31:29', '2024-12-03 10:31:29'),
(4, 'Lueilwitz, Daugherty and Schinner', '57357 Johanna Manors\nNorth Jalenmouth, NE 74641-1477', 17, '2024-12-03 10:31:29', '2024-12-03 10:31:29'),
(6, 'Wolff Ltd', '77799 Hayes Village Suite 514\nWest Ricardo, KS 50322-1489', 33, '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(7, 'Wiza, McClure and Cartwright', '9097 Eliza Cove Suite 281\nAntoninashire, TN 99537-5356', 10, '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(8, 'Cassin-King', '5801 Lockman Hill\nDariostad, RI 40913-0864', 23, '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(9, 'Kuphal Group', '25575 Ritchie Overpass\nEast Asha, NH 04001', 17, '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(10, 'Stanton, Hegmann and Considine', '791 Dietrich Circle\nSouth Erichport, ND 73216', 4, '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(11, 'kfc', 'in almazzeh in damascus', 42, '2024-12-04 16:29:33', '2024-12-04 16:29:33'),
(12, 'kfc', 'in almazzeh in damascus', 42, '2024-12-06 13:42:24', '2024-12-06 13:42:24'),
(13, 'kfc', 'in almazzeh in damascus', 42, '2024-12-06 13:42:30', '2024-12-06 13:42:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `img` text DEFAULT NULL,
  `location` text DEFAULT NULL,
  `role` enum('admin','storehead','user') NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone`, `email`, `email_verified_at`, `img`, `location`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Shanon', 'Zulauf', '+1.818.750.4215', 'rosenbaum.linnea@example.org', '2024-12-03 10:19:36', 'https://via.placeholder.com/640x480.png/001122?text=a', '10642 Richard Key Suite 116\nWest Caseyland, MS 70616', 'admin', '$2y$12$7yhvK/Rma.3Q8t4Ah3vAuukzow.cHnkyKcn54Qb.39FVXl4Pu.M2u', 'lbuWtf08IX', '2024-12-03 10:19:39', '2024-12-03 10:19:39'),
(2, 'Fae', 'Lebsack', '551.626.5269', 'rachelle.cartwright@example.com', '2024-12-03 10:19:37', 'https://via.placeholder.com/640x480.png/007744?text=incidunt', '36919 Sage Falls\nBruenchester, OH 27710-2638', 'storehead', '$2y$12$pPPwdpZQBY/0cnOOWjRjaO5G3EMphOAaDkxrPgLasgwobo2o0yhhK', 'RLyxD2hZJ0', '2024-12-03 10:19:39', '2024-12-03 10:19:39'),
(3, 'Pete', 'Bruen', '+1 (760) 749-4586', 'aufderhar.georgianna@example.org', '2024-12-03 10:19:37', 'https://via.placeholder.com/640x480.png/003366?text=velit', '60089 Idell Groves\nPort Saulhaven, SD 50455-8711', 'storehead', '$2y$12$JxnPWZSb0sH0vAza7c6ET.M.OsVaBvYLKAlVOPXSy36VctpSB7ZGS', 'vtmX3Te95f', '2024-12-03 10:19:39', '2024-12-03 10:19:39'),
(4, 'Keanu', 'Ziemann', '(785) 999-3080', 'maryjane.kunze@example.org', '2024-12-03 10:19:37', 'https://via.placeholder.com/640x480.png/00cc66?text=itaque', '58043 Clementina Parkways\nSouth Vicenta, MD 55044', 'storehead', '$2y$12$fB29cM/2D0K1.kZkDCMZ4eOKdBYR0fp.YSUC4ycb4l8Hfhegd1FBO', 'Em0GXeL9BG', '2024-12-03 10:19:39', '2024-12-03 10:19:39'),
(5, 'Lea', 'Goyette', '+1-531-433-0040', 'stroman.adelia@example.org', '2024-12-03 10:19:37', 'https://via.placeholder.com/640x480.png/0077ff?text=ut', '54665 Anderson Springs Suite 238\nTedtown, NJ 89938-7755', 'user', '$2y$12$8Uta/zo4xpnAeHxGGx6D0eP./.8Svg6Skk7LTcd4S4VgApZWLGQo2', 'tc2Irkg2di', '2024-12-03 10:19:39', '2024-12-03 10:19:39'),
(6, 'Easter', 'Gusikowski', '+1 (972) 379-4264', 'rosanna.buckridge@example.com', '2024-12-03 10:19:38', 'https://via.placeholder.com/640x480.png/005577?text=nulla', '6399 Ida Dam\nWilfordtown, OR 21770', 'storehead', '$2y$12$1XKhE.LoQ1XhFWZ9dAoJk.Mt4lHBreUz8TQFXmTMJRRg/s3LV06hy', '4Tqz7ucvTO', '2024-12-03 10:19:39', '2024-12-03 10:19:39'),
(7, 'Jalen', 'Bahringer', '657-869-9884', 'golden.romaguera@example.org', '2024-12-03 10:19:38', 'https://via.placeholder.com/640x480.png/002255?text=voluptatem', '50913 Raynor Way Suite 219\nNorth Godfrey, MN 08824', 'user', '$2y$12$Wy1kKJ1LNCpTrpIT2d1gI.eb7LwxzZoYkronMC9ktgfBj48o5l7JW', 'u8Mltg6etF', '2024-12-03 10:19:39', '2024-12-03 10:19:39'),
(8, 'Meredith', 'Hickle', '(726) 855-1681', 'reymundo40@example.net', '2024-12-03 10:19:38', 'https://via.placeholder.com/640x480.png/0055dd?text=fugit', '88179 Braun Park\nLake Muriel, KS 60411-4901', 'user', '$2y$12$B7FdPgUSWH0YU7HmtQj9wuTfXYltSeGUrkHSWOdqQhcFiObdpyXju', 'Pqd6tcIRsQ', '2024-12-03 10:19:39', '2024-12-03 10:19:39'),
(9, 'Presley', 'Bernhard', '+1 (763) 525-4926', 'maximillian01@example.com', '2024-12-03 10:19:38', 'https://via.placeholder.com/640x480.png/00bb88?text=eos', '7818 Andreane Junctions\nWest Nils, WY 94231', 'storehead', '$2y$12$WVgHHKgTXZjV3sSQqNuQwubJ0VSxpp/S7dSqliM0vNg7/uFPpIfb6', '0vaM2b0z7x', '2024-12-03 10:19:39', '2024-12-03 10:19:39'),
(10, 'Maryjane', 'Lowe', '630-592-3387', 'lprohaska@example.org', '2024-12-03 10:19:38', 'https://via.placeholder.com/640x480.png/009944?text=sequi', '3607 Buck Avenue\nPagacmouth, MI 98627-5393', 'storehead', '$2y$12$GByWvWECM.rkJJh/O8JhWeR4GDgHnePAmtRAQvgSQmidc0h6Vs/0m', 'jGywO589nO', '2024-12-03 10:19:39', '2024-12-03 10:19:39'),
(11, 'Marcelino', 'Blick', '(915) 722-8993', 'sawayn.mariane@example.com', '2024-12-03 10:25:21', 'https://via.placeholder.com/640x480.png/007788?text=aut', '771 Turcotte Plains\nLake Reeseborough, IA 58314', 'admin', '$2y$12$Bp7fg/0T1VECto5SGNLHJeaHe7girE.UCmmPZ8hJSBA0OZvKK55Hy', 'yU1Gn8IyrM', '2024-12-03 10:25:25', '2024-12-03 10:25:25'),
(12, 'Elijah', 'Wehner', '937.543.1084', 'waters.aracely@example.net', '2024-12-03 10:25:21', 'https://via.placeholder.com/640x480.png/00ee66?text=ratione', '414 Glover Club\nMoisesview, WA 72769-1725', 'admin', '$2y$12$UfqLoTABp2bPupgyAtHMseZ15Hfzo9v3VVMOadZywroig8spZ1hES', 'VmwCEVmwRM', '2024-12-03 10:25:25', '2024-12-03 10:25:25'),
(13, 'Orpha', 'Pollich', '(786) 379-3380', 'macie.jacobi@example.net', '2024-12-03 10:25:22', 'https://via.placeholder.com/640x480.png/00bb99?text=ratione', '5267 Bahringer Courts Suite 778\nEast Katelin, LA 46049-7244', 'storehead', '$2y$12$/.Aq2hghdEUr8Qlp6KyCGO8A61mN67.EpTUQErU.Pxq3/idehXkZa', 'hPho7RfsMS', '2024-12-03 10:25:25', '2024-12-03 10:25:25'),
(14, 'Emmett', 'McCullough', '+1-279-827-7821', 'madge10@example.net', '2024-12-03 10:25:22', 'https://via.placeholder.com/640x480.png/006611?text=fuga', '235 Dicki Cove Apt. 276\nGleichnermouth, NY 91726-1840', 'admin', '$2y$12$t3uM6vBOSg9zATD1r0EY/emOt4LJgEYtvvqsi9ARyWiObM/INXSc2', 'RIbY6xpYZK', '2024-12-03 10:25:25', '2024-12-03 10:25:25'),
(15, 'Malachi', 'O\'Connell', '+1-352-459-9466', 'florencio.lakin@example.org', '2024-12-03 10:25:22', 'https://via.placeholder.com/640x480.png/0055ff?text=iure', '886 Yolanda Alley Apt. 533\nSouth Gordonberg, VA 39928-2923', 'user', '$2y$12$KMtmn.zfelOqa3e5ST2HQesM9y7829t0NGyyKlpXEVZWJep2FLNku', 'LPBqm37KbR', '2024-12-03 10:25:25', '2024-12-03 10:25:25'),
(16, 'Cielo', 'Mraz', '203.789.9047', 'halle70@example.org', '2024-12-03 10:25:23', 'https://via.placeholder.com/640x480.png/0000bb?text=ipsum', '40364 Javier Gardens Apt. 308\nDemarioshire, MS 77644', 'user', '$2y$12$z3TOM/MYnFT39QJAQzMI3uyohF5TWCHZ4idX1LJMCQWt8V7CPKSaa', 'FET9yj3GSz', '2024-12-03 10:25:25', '2024-12-03 10:25:25'),
(17, 'Melody', 'Steuber', '715.342.0318', 'dan01@example.com', '2024-12-03 10:25:23', 'https://via.placeholder.com/640x480.png/00ee33?text=reiciendis', '8291 Schuster Gateway\nFritschport, VT 20606-7447', 'storehead', '$2y$12$SCPrmpu9SW1GiF3xOquiiOFNeQWnvsdYCqXKnUMItrFfocXXKdb0y', 'APMhCB0jwe', '2024-12-03 10:25:25', '2024-12-03 10:25:25'),
(18, 'Vella', 'Ebert', '1-351-462-4990', 'cummerata.vella@example.com', '2024-12-03 10:25:24', 'https://via.placeholder.com/640x480.png/00dd77?text=consequuntur', '2180 Wilfrid Brooks Suite 003\nNorth Eino, NE 39785-2086', 'admin', '$2y$12$g8.AmuXGfnlAeJV75/7R7eMPIWuzc7gxU5ABb/YWk7hYqHyeThBL6', 'aGNKMMdgdb', '2024-12-03 10:25:25', '2024-12-03 10:25:25'),
(19, 'Flo', 'Langosh', '(719) 585-0531', 'beahan.kristian@example.net', '2024-12-03 10:25:24', 'https://via.placeholder.com/640x480.png/004499?text=iste', '669 Catherine Rapids Suite 404\nSouth Lauretta, NH 62591-0889', 'admin', '$2y$12$QIanhNpVEQQb7ZLWWF7gQucIB/B.M7C6oqFq0ogKXHEnVpxTgWHHe', 'e3Zf9iva8q', '2024-12-03 10:25:25', '2024-12-03 10:25:25'),
(20, 'Jena', 'Dare', '980-245-8736', 'ncasper@example.org', '2024-12-03 10:25:24', 'https://via.placeholder.com/640x480.png/0011aa?text=quibusdam', '17967 Llewellyn Mountains\nLake Daisy, TX 49330-9477', 'storehead', '$2y$12$pSzoZT3QnWHnIt6pJDBREed71kgn0Ys93jPh3A3LWXetDjk7fC/ei', 'LHKSKnAjOy', '2024-12-03 10:25:25', '2024-12-03 10:25:25'),
(21, 'Grover', 'Cronin', '972-256-1436', 'jkuphal@example.net', '2024-12-03 10:31:24', 'https://via.placeholder.com/640x480.png/00bb00?text=voluptatibus', '22195 Libby Junctions Apt. 298\nPort Karina, TX 70970-7365', 'admin', '$2y$12$9WPhIJLEaL8pxiSK.pzpnuVNWZP0Gd8FPuhosh.H8CCRNtasYAKLO', 'fTd8QB1zfD', '2024-12-03 10:31:28', '2024-12-03 10:31:28'),
(22, 'Allene', 'Nienow', '1-302-648-6283', 'neva.olson@example.com', '2024-12-03 10:31:25', 'https://via.placeholder.com/640x480.png/001155?text=vel', '840 O\'Keefe Place Apt. 469\nLake Adrienne, WV 23258', 'admin', '$2y$12$TAfkjuR7Def0vq9FkoeSI.Jnnr9bwMX2N5oFW9sCmuGk5bnhAyxqW', 'pV2gq2KYWt', '2024-12-03 10:31:28', '2024-12-03 10:31:28'),
(23, 'Sonya', 'Gusikowski', '+17065069713', 'daryl.wisoky@example.com', '2024-12-03 10:31:25', 'https://via.placeholder.com/640x480.png/0066bb?text=quo', '978 Minerva Crossroad Apt. 787\nSmithamtown, NJ 27696', 'storehead', '$2y$12$6FbpYJThtHOCH1vI.LIQOeFuwEI9zFQXR8Ew5sGdUWJDuHJ7Eppc.', '5hLnVuIiUg', '2024-12-03 10:31:28', '2024-12-03 10:31:28'),
(24, 'Adah', 'Buckridge', '+18083963342', 'dbartoletti@example.org', '2024-12-03 10:31:25', 'https://via.placeholder.com/640x480.png/00ee00?text=tempore', '361 Madilyn Lock Suite 724\nSouth Kenny, CT 95564', 'admin', '$2y$12$HSbCPuJJbrxVNHUaaHzfAeCjdWoWt1aZt1qFxd4bX2X9.65O8dJ/m', 'H7cvJXkGp5', '2024-12-03 10:31:28', '2024-12-03 10:31:28'),
(25, 'Ella', 'Emard', '(724) 456-0056', 'schulist.seamus@example.com', '2024-12-03 10:31:26', 'https://via.placeholder.com/640x480.png/002255?text=maiores', '904 Jordan Street\nWest Valentine, DE 60767', 'user', '$2y$12$u.BoaY.FsARPuFYqOwGmIe67bRD/q7qVG3/RxB.9lURDVoxr4FzWW', 'PLlAmMs6zF', '2024-12-03 10:31:28', '2024-12-03 10:31:28'),
(26, 'Wendell', 'Runolfsson', '425.659.8104', 'jonathan13@example.com', '2024-12-03 10:31:26', 'https://via.placeholder.com/640x480.png/0022ff?text=pariatur', '70498 Houston Row\nBergstromchester, SC 62732-2222', 'user', '$2y$12$2551XOi.4VB6xbAkYH6rU.LNrGAWDaNnn3YevYm3p3eP8NJQVS.MS', 'bGPlNyri5t', '2024-12-03 10:31:28', '2024-12-03 10:31:28'),
(27, 'Emmanuelle', 'Feil', '1-567-233-7699', 'laufderhar@example.net', '2024-12-03 10:31:27', 'https://via.placeholder.com/640x480.png/0077ee?text=aut', '7544 Felicia Drive\nLake Bernadette, MN 52013', 'admin', '$2y$12$h5SZCogpPAJ.Bk6k8ezj1um.ZKd7OT21ULTRrn1yFDS7HqyXS3nDy', 'c1oehCjeeb', '2024-12-03 10:31:28', '2024-12-03 10:31:28'),
(28, 'Ceasar', 'Ernser', '724.278.5745', 'abauch@example.org', '2024-12-03 10:31:27', 'https://via.placeholder.com/640x480.png/00dd33?text=esse', '4535 Devin Road Apt. 171\nLake Deonmouth, OK 39389', 'user', '$2y$12$MEjZisZosAZmtV3NHAKVDukApZKkW7zc1zKMjXTkOJwWfJ15Q1iEO', 'UrZ45JtWn2', '2024-12-03 10:31:28', '2024-12-03 10:31:28'),
(29, 'Aletha', 'Rutherford', '(571) 622-1931', 'guiseppe64@example.org', '2024-12-03 10:31:27', 'https://via.placeholder.com/640x480.png/005555?text=impedit', '85212 Farrell Cape Apt. 514\nLake Lorenzamouth, NV 56413-6895', 'storehead', '$2y$12$WXZ9IoctbzSFPIG0AwiXE.dQQXC/eyqqhQTl.xsrbhhkfojBwdRBu', 'Ooi6nMCNog', '2024-12-03 10:31:28', '2024-12-03 10:31:28'),
(30, 'Buddy', 'Cremin', '1-732-526-0937', 'ametz@example.org', '2024-12-03 10:31:28', 'https://via.placeholder.com/640x480.png/0011cc?text=natus', '628 Daisy Knoll Suite 498\nMarisolton, SD 05655', 'user', '$2y$12$uQPgHsDQmMPgn.e8zbXh/e2Cs3.sEXontb04pD9G/yj584qYYGw3W', 'clAHD9zmRY', '2024-12-03 10:31:28', '2024-12-03 10:31:28'),
(31, 'Cayla', 'Franecki', '504-717-8061', 'vcrona@example.org', '2024-12-03 10:32:51', 'https://via.placeholder.com/640x480.png/007755?text=porro', '95974 Alta Drive\nPrincessbury, AR 88652', 'admin', '$2y$12$fvo2pVB9zO1cuyB8SrAsAuYWD6v6yEPYuQmJg2hk1qJQISVtyCN1i', 'iprFCi6KrG', '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(32, 'Russ', 'Kuhlman', '+1.914.578.1179', 'xemmerich@example.com', '2024-12-03 10:32:52', 'https://via.placeholder.com/640x480.png/009977?text=impedit', '8583 Javier Walks\nSouth Mariantown, OK 20835', 'user', '$2y$12$xZW0Jk5Q92UhDS7AxjA3tOupjnc0LWu6AFJdSBUAq3N6UegW6oH2C', '9GOi544ND0', '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(33, 'Francis', 'Boyle', '302-689-2523', 'durgan.louisa@example.net', '2024-12-03 10:32:52', 'https://via.placeholder.com/640x480.png/00eedd?text=qui', '484 Mraz Port\nZiemannport, MD 25164-5444', 'storehead', '$2y$12$s2FFDSKhiN6x63wKUKgQXOUnGBHwmIyEoNth4OVYZNlRDdr2CjLPq', '2zCZ7Mnn3p', '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(34, 'Bertram', 'Kub', '+19203576681', 'isabell.lemke@example.net', '2024-12-03 10:32:53', 'https://via.placeholder.com/640x480.png/005522?text=quo', '206 Bernhard Spurs Apt. 991\nPort Emmet, WY 17806-1641', 'user', '$2y$12$V5fn0ek3EnMNrOsaEGAkcen7xTr2g.7C5h0gikrmK01GtksW1kOtG', 'k2OkgrJ4Nl', '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(35, 'Orpha', 'Lindgren', '346.844.8926', 'haylie61@example.org', '2024-12-03 10:32:53', 'https://via.placeholder.com/640x480.png/00ffee?text=cum', '855 Zoe Club Apt. 507\nSouth Libbie, MI 54531-3795', 'admin', '$2y$12$NMH3x3g2.FXtM43h3MlWFuMB4j.UOhc7YjtDyD0s6LP2It5LgvVLq', 'EYndKP19NC', '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(36, 'Aniya', 'Lockman', '838.947.6278', 'srussel@example.org', '2024-12-03 10:32:53', 'https://via.placeholder.com/640x480.png/00ff88?text=omnis', '64319 Little Square Suite 206\nNew Lukasborough, OH 94821', 'admin', '$2y$12$QQccl4Jswu3jJLkRjuvTruIY53FGvifBJFCz0UMnUjdD5xNJzhfUa', '4PaAV8B2jJ', '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(37, 'Armani', 'Lueilwitz', '(934) 692-9836', 'travon.stehr@example.com', '2024-12-03 10:32:54', 'https://via.placeholder.com/640x480.png/002255?text=suscipit', '6707 Ignatius Terrace Suite 556\nWest Abigail, OH 11209', 'admin', '$2y$12$mK/yFRkQBd5vBpYXjQB0Se/EvZH53Ge8SSNJ9mQCjOv9qvYstMAT2', 'QA574jeKGK', '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(38, 'Marianna', 'Armstrong', '+1.325.305.5736', 'schimmel.cristina@example.net', '2024-12-03 10:32:54', 'https://via.placeholder.com/640x480.png/00ddff?text=eius', '80575 Frida Branch Apt. 162\nUriahberg, WY 42237', 'admin', '$2y$12$tYbG5FdxXSt3dt6R1Da0P.D9.Kkfef0Yn4rnC5Qxh19r1L8qR7F76', 'XhMDKbLGtr', '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(39, 'Celestine', 'Keebler', '+1-914-962-8395', 'burley96@example.com', '2024-12-03 10:32:54', 'https://via.placeholder.com/640x480.png/00aa44?text=pariatur', '9093 Shields Brooks Suite 446\nHiltonhaven, NJ 01170', 'storehead', '$2y$12$iq0AMieopvr8LLh50nxPpOfUcKS4qt.xqlRzdT5Plx9W2VUAvOoHC', 'O2C9BUwA9D', '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(40, 'Sienna', 'Vandervort', '(859) 272-2864', 'murl18@example.org', '2024-12-03 10:32:55', 'https://via.placeholder.com/640x480.png/0033ee?text=in', '84600 Naomie Rest Suite 533\nMorissetteborough, IL 42814', 'admin', '$2y$12$xxZYKIwuUITl1UIXF8BgZuv6rUQ5w535a8VL8D3X6iuDT3phQBDum', 'ApV7auC8LR', '2024-12-03 10:32:55', '2024-12-03 10:32:55'),
(41, 'aa', 'a', '0968889511', 'bb@bbbb', NULL, NULL, NULL, 'user', '$2y$12$S0SvIgqc6VokSPkdYjcwZO71h6iRqXSI2QsmmQrtmVXG92nFyOto2', NULL, '2024-12-04 09:09:02', '2024-12-04 09:09:02'),
(42, 'aaaa', 'aa', '5434678553', 'aa@a', NULL, NULL, NULL, 'user', '$2y$12$Fz7OLxHvwZHVXfiXhrsPUukCHNt6LDLRkRMcff7Ojcg3UamOxNrPK', NULL, '2024-12-04 09:09:23', '2024-12-06 14:48:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_products`
--
ALTER TABLE `cart_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_products_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_store_id_foreign` (`store_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stores_storehead_id_foreign` (`storehead_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart_products`
--
ALTER TABLE `cart_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_products`
--
ALTER TABLE `cart_products`
  ADD CONSTRAINT `cart_products_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_storehead_id_foreign` FOREIGN KEY (`storehead_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
