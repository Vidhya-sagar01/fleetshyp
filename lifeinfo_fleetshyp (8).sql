-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 17, 2026 at 01:41 PM
-- Server version: 10.6.26-MariaDB
-- PHP Version: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lifeinfo_fleetshyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `agreements`
--

CREATE TABLE `agreements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_name` varchar(255) NOT NULL DEFAULT 'Seller Agreement',
  `version` varchar(255) NOT NULL,
  `change_description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `published_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `uploaded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agreements`
--

INSERT INTO `agreements` (`id`, `section_name`, `version`, `change_description`, `file_path`, `file_name`, `published_at`, `status`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(1, 'Seller Agreement', '1', 'joi', 'agreements/1774271170_EC90_LIS_communication_1.pdf', '1774271170_EC90_LIS_communication_1.pdf', '2026-03-23 07:36:11', 'pending', 9, '2026-03-23 07:36:11', '2026-03-23 07:36:11'),
(2, 'Seller Agreement', '1.0', 'Seller Agreement', 'agreements/1777634699_AGREEMENT.pdf', '1777634699_AGREEMENT.pdf', '2026-05-01 11:24:59', 'pending', 9, '2026-05-01 11:24:59', '2026-05-01 11:24:59');

-- --------------------------------------------------------

--
-- Table structure for table `agreement_acceptances`
--

CREATE TABLE `agreement_acceptances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agreement_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `accepted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agreement_acceptances`
--

INSERT INTO `agreement_acceptances` (`id`, `agreement_id`, `user_id`, `accepted_at`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(6, 2, 36, '2026-05-05 12:58:22', '223.181.31.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-05-05 12:58:22', '2026-05-05 12:58:22'),
(7, 2, 39, '2026-05-11 02:50:58', '223.181.31.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '2026-05-11 02:50:58', '2026-05-11 02:50:58');

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `beneficiary_name` varchar(255) NOT NULL,
  `account_type` enum('saving','current') NOT NULL,
  `account_number` text NOT NULL,
  `ifsc_code` varchar(255) NOT NULL,
  `cheque_image` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_details`
--

INSERT INTO `bank_details` (`id`, `user_id`, `beneficiary_name`, `account_type`, `account_number`, `ifsc_code`, `cheque_image`, `status`, `verified_by`, `verified_at`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(6, 36, 'Nikunj Gogadani', 'current', 'eyJpdiI6IkZqQlorRTEwMHhmd2pwbXAxaG1tV1E9PSIsInZhbHVlIjoiUXQ3QkxRQW9SY2JoWURPM2wvR3J2QT09IiwibWFjIjoiMjk4MWMyYzEzZjI1ZTU1M2ExM2U3MzI3NDZlY2UyNTVmNWUwMjMwOGMxYmVkNTI0NzcxZjYzZGE3NDg2YWNiNyIsInRhZyI6IiJ9', 'UTIB0003488', 'bank_cheques/Fr68wbev0qRAyYcQBKKUZcfGmiXocpFsek1n9yUy.jpg', 'approved', 9, '2026-05-05 13:01:17', NULL, '2026-05-05 12:58:59', '2026-05-05 13:01:17'),
(7, 39, 'shivam kumar', 'saving', 'eyJpdiI6IkJmMGlhc3FCL1NYU0x3L3kzV0EydGc9PSIsInZhbHVlIjoieVNIRHNZemkwQmhDZW1LS2g0VHZMUT09IiwibWFjIjoiOWY3MGM2ZTNjZWNjNDRkZDNkOGE2ZjdlZTY5MTk0M2JhMWM2NTAyYWJlMzE1OWUzZTk5MDg3NTIyZWE3Y2QzYSIsInRhZyI6IiJ9', 'CNRB0002520', 'bank_cheques/6YFPmCy6P51WWWWxLpgPwidG7manbbludXZjp97n.jpg', 'approved', 9, '2026-05-11 02:55:02', NULL, '2026-05-11 02:54:48', '2026-05-11 02:55:02');

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
-- Table structure for table `cod_remittance_payments`
--

CREATE TABLE `cod_remittance_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `waybill` varchar(255) DEFAULT NULL COMMENT 'Waybill/AWB number for reference',
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remitted_amount` decimal(15,2) NOT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `convenience_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_date` date NOT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account` varchar(255) DEFAULT NULL,
  `status` enum('pending','processed','paid','cancelled') NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cod_remittance_payments`
--

INSERT INTO `cod_remittance_payments` (`id`, `user_id`, `order_id`, `waybill`, `admin_id`, `remitted_amount`, `payment_reference`, `convenience_fee`, `payment_date`, `payment_mode`, `bank_name`, `bank_account`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 39, 154, '77790204741', 9, 0.00, '9090909090', 90.00, '2026-05-11', 'Cash', 'bob', '45554756545', 'paid', 'payment done', '2026-05-11 10:18:02', '2026-05-11 10:18:02'),
(2, 36, 148, '77789693752', 9, 900.00, 'PUNBX26133544512', 0.00, '2026-05-13', 'NEFT', 'axis bank', '919020063995560', 'paid', 'Amount Paid', '2026-05-13 10:42:53', '2026-05-13 10:42:53'),
(3, 36, 149, '77789693446', 9, 900.00, 'PUNBX26134909353', 0.00, '2026-05-14', 'NEFT', 'axis bank', '919020063995560', 'paid', 'Amount Paid', '2026-05-14 12:51:40', '2026-05-14 12:51:40'),
(4, 36, 161, '77790728540', 9, 900.00, 'PUNBX26134909763', 0.00, '2026-05-14', 'NEFT', 'axis bank', '919020063995560', 'paid', 'Amount Paid', '2026-05-14 12:52:27', '2026-05-14 12:52:27'),
(5, 36, 181, '77791996936', 9, 1000.00, 'PUNBX26134910147', 0.00, '2026-05-14', 'NEFT', 'axis bank', '919020063995560', 'paid', 'Amount Paid', '2026-05-14 12:53:16', '2026-05-14 12:53:16'),
(6, 36, 176, '77792023982', 9, 800.00, 'PUNBX26135947404', 0.00, '2026-05-15', 'NEFT', 'axis bank', '919020063995560', 'paid', 'Amount Paid', '2026-05-15 02:38:56', '2026-05-15 02:38:56'),
(7, 36, 178, '37355837604522', 9, 1000.00, 'PUNBX26135947570', 0.00, '2026-05-15', 'NEFT', 'axis bank', '919020063995560', 'paid', 'Amount Paid', '2026-05-15 02:41:23', '2026-05-15 02:41:23'),
(8, 36, 196, '37355837634062', 9, 900.00, 'PUNBX26135947713', 0.00, '2026-05-15', 'NEFT', 'axis bank', '919020063995560', 'paid', 'Amount Paid', '2026-05-15 02:43:21', '2026-05-15 02:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `company_profiles`
--

CREATE TABLE `company_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `company_code` varchar(4) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `customer_care_email` varchar(255) DEFAULT NULL,
  `customer_care_mobile` varchar(255) DEFAULT NULL,
  `has_gst` tinyint(1) NOT NULL DEFAULT 0,
  `enable_state_gst` tinyint(1) NOT NULL DEFAULT 0,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_profiles`
--

INSERT INTO `company_profiles` (`id`, `seller_id`, `company_code`, `company_name`, `brand_name`, `website`, `email`, `customer_care_email`, `customer_care_mobile`, `has_gst`, `enable_state_gst`, `logo`, `created_at`, `updated_at`) VALUES
(6, 36, '1427', 'Ayura Health Cares Nikunj Gogadani', 'Ayura Health Cares', 'https://ayurahealthcares.com/', 'Ayurahealthcares@gmail.com', 'info@ayurahealthcares.com', '7284879486', 0, 0, 'companies/logos/1777985827_69f9e92383f64.png', '2026-05-05 12:57:07', '2026-05-05 12:57:07'),
(7, 39, '8824', 'glowriwellness', 'Glowriwellness', NULL, 'glowriwellness@gmail.com', NULL, '9060454764', 0, 0, 'companies/logos/1778467689_6a014369edcda.png', '2026-05-11 02:48:10', '2026-05-11 02:48:10');

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fship_courier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `logo_url` text DEFAULT NULL,
  `rating_pickup` decimal(2,1) NOT NULL DEFAULT 0.0,
  `rating_delivery` decimal(2,1) NOT NULL DEFAULT 0.0,
  `rating_ndr` decimal(2,1) NOT NULL DEFAULT 0.0,
  `rating_weight` decimal(2,1) NOT NULL DEFAULT 0.0,
  `rating_tat` decimal(2,1) NOT NULL DEFAULT 0.0,
  `expected_pickup` varchar(255) DEFAULT NULL,
  `estimated_delivery` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `fship_courier_id`, `name`, `logo`, `logo_url`, `rating_pickup`, `rating_delivery`, `rating_ndr`, `rating_weight`, `rating_tat`, `expected_pickup`, `estimated_delivery`, `is_active`, `created_at`, `updated_at`) VALUES
(20, 88, 'Bluedart Surface 500 Gm', NULL, 'https://app.fship.in/upload/provider_logo/Bluedart.png', 4.7, 4.6, 4.8, 4.6, 4.4, 'today', '5', 1, '2026-05-01 02:43:16', '2026-05-05 06:24:42'),
(26, 34, 'Xpressbees 1 Kg', NULL, 'https://app.fship.in/upload/provider_logo/xpressbees.png', 5.0, 5.0, 5.0, 5.0, 5.0, 'today', '5', 1, '2026-05-04 09:30:33', '2026-05-04 09:30:33'),
(27, 60, 'Ekart Surface 500 gm', NULL, 'https://app.fship.in/upload/provider_logo/ekart.png', 5.0, 5.0, 5.0, 5.0, 5.0, 'today', '5', 1, '2026-05-04 09:30:59', '2026-05-04 09:30:59'),
(28, 64, 'Amazon New', NULL, 'https://app.fship.in/upload/provider_logo/amazon_logo.jpeg', 5.0, 5.0, 5.0, 5.0, 5.0, 'today', '5', 1, '2026-05-04 09:31:23', '2026-05-04 09:31:23'),
(29, 65, 'Delhivery Surface (Brand)', NULL, 'https://app.fship.in/upload/provider_logo/delhivery.png', 4.7, 4.7, 4.5, 4.1, 5.0, 'today', '5', 1, '2026-05-04 09:31:44', '2026-05-05 06:24:56'),
(30, 70, 'Delhivery Lite', NULL, 'https://app.fship.in/upload/provider_logo/delhivery.png', 5.0, 5.0, 5.0, 5.0, 5.0, 'today', '5', 1, '2026-05-04 09:32:09', '2026-05-04 09:32:09'),
(31, 82, 'Ekart Surface 1 Kg', NULL, 'https://app.fship.in/upload/provider_logo/ekart.png', 5.0, 5.0, 5.0, 5.0, 5.0, 'today', '5', 1, '2026-05-04 09:32:27', '2026-05-04 09:32:27'),
(32, 97, 'Amazon Surface 1 Kg', NULL, 'https://app.fship.in/upload/provider_logo/amazon_logo.jpeg', 5.0, 5.0, 5.0, 5.0, 5.0, 'today', '5', 1, '2026-05-04 09:33:49', '2026-05-04 09:33:49'),
(33, 59, 'Xpressbees New 500 gm', NULL, 'https://app.fship.in/upload/provider_logo/xpressbees.png', 4.5, 4.2, 4.1, 4.2, 4.0, 'today', '5', 1, '2026-05-05 06:29:16', '2026-05-05 06:29:16'),
(34, 18, 'Xpressbees Surface 5 Kg', NULL, 'https://app1.fship.in/upload/provider_logo/xpressbees.png', 4.3, 4.2, 4.5, 4.0, 4.1, 'today', '2-3 days', 1, '2026-05-14 01:36:23', '2026-05-14 01:36:23');

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
-- Table structure for table `fship_orders`
--

CREATE TABLE `fship_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `fship_api_order_id` varchar(255) DEFAULT NULL COMMENT 'apiorderid from fship',
  `pickup_order_id` varchar(255) DEFAULT NULL,
  `waybill` varchar(255) DEFAULT NULL COMMENT 'Unique tracking number',
  `merchant_order_id` varchar(255) NOT NULL COMMENT 'Internal Order ID from your form',
  `order_type` varchar(255) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `buyer_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `alt_phone_number` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `complete_address` text NOT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `customer_Address_Type` varchar(255) NOT NULL DEFAULT 'Home',
  `pincode` varchar(6) NOT NULL,
  `source_pincode` varchar(255) DEFAULT NULL,
  `destination_pincode` varchar(6) DEFAULT NULL,
  `source_destination` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zone` varchar(255) DEFAULT NULL COMMENT 'Regional, Metro, etc.',
  `is_pickup_available` varchar(5) NOT NULL DEFAULT 'No',
  `is_delivery_available` varchar(5) NOT NULL DEFAULT 'No',
  `is_cod_available` varchar(5) NOT NULL DEFAULT 'No',
  `is_prepaid_available` varchar(5) NOT NULL DEFAULT 'No',
  `company_name` varchar(255) DEFAULT NULL,
  `gstin_number` varchar(255) DEFAULT NULL,
  `weight` decimal(8,3) NOT NULL COMMENT 'Weight in Kgs (max 0.500 for 500g)',
  `volumetric_weight` decimal(8,3) DEFAULT NULL,
  `length` decimal(8,2) NOT NULL,
  `width` decimal(8,2) NOT NULL,
  `height` decimal(8,2) NOT NULL,
  `pick_address_ID` int(11) NOT NULL,
  `reseller_name` varchar(255) DEFAULT NULL,
  `payment_mode` int(11) NOT NULL COMMENT '1=COD, 2=Prepaid',
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `product_subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `wallet_deduction_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `forward_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cod_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `courier_name` varchar(255) DEFAULT NULL,
  `courier_id` bigint(20) DEFAULT NULL,
  `service_mode` varchar(255) DEFAULT NULL,
  `booked_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Booked',
  `tags` text DEFAULT NULL,
  `has_reverse_order` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Is 1 if a reverse/return order is initiated for this forward order',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_refunded` tinyint(1) DEFAULT 0,
  `is_remitted` tinyint(1) NOT NULL DEFAULT 0,
  `remitted_at` timestamp NULL DEFAULT NULL,
  `rto_processed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fship_orders`
--

INSERT INTO `fship_orders` (`id`, `user_id`, `fship_api_order_id`, `pickup_order_id`, `waybill`, `merchant_order_id`, `order_type`, `order_date`, `buyer_name`, `phone_number`, `alt_phone_number`, `email_id`, `complete_address`, `landmark`, `customer_Address_Type`, `pincode`, `source_pincode`, `destination_pincode`, `source_destination`, `city`, `state`, `zone`, `is_pickup_available`, `is_delivery_available`, `is_cod_available`, `is_prepaid_available`, `company_name`, `gstin_number`, `weight`, `volumetric_weight`, `length`, `width`, `height`, `pick_address_ID`, `reseller_name`, `payment_mode`, `total_amount`, `product_subtotal`, `wallet_deduction_amount`, `forward_charge`, `cod_charge`, `courier_name`, `courier_id`, `service_mode`, `booked_at`, `status`, `tags`, `has_reverse_order`, `created_at`, `updated_at`, `is_refunded`, `is_remitted`, `remitted_at`, `rto_processed`) VALUES
(141, 36, NULL, NULL, NULL, '20260505122942', 'Essential', '2026-05-05 12:29:00', 'demio', '8235196825', NULL, NULL, 'rgn gdfgeg', NULL, 'Home', '110059', NULL, NULL, NULL, 'West Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 'cancelled', NULL, 0, '2026-05-05 12:30:10', '2026-05-13 13:59:14', 1, 0, NULL, 0),
(142, 36, '1778044424', '1740837', '37355837525212', '20260505130759', 'Essential', '2026-05-05 13:07:00', 'Aariya ali Qureshi', '9078091551', NULL, NULL, 'Near By Shri Baba Shyam Mandir,  Town- Bhatli , Dist - Bargarh ,Bargarh (Odisha)', NULL, 'Home', '768030', NULL, NULL, NULL, 'Bargarh', 'Odisha', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 750.00, 750.00, 114.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-05 13:29:07', '2026-05-17 10:15:06', 0, 0, NULL, 1),
(143, 36, '1778044268', '1740806', '77789707774', '20260505132915', 'Essential', '2026-05-05 13:29:00', 'Guddu Kumar', '7989337146', NULL, NULL, 'Near - Shiv mandir , Vill  - Pothiya , Dist- Banka , Bihar', NULL, 'Home', '813109', NULL, NULL, NULL, 'Banka', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 117.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-05 13:32:39', '2026-05-11 12:00:19', 0, 0, NULL, 0),
(144, 36, '1778044281', '1740808', '77789710132', '20260505133242', 'Essential', '2026-05-05 13:32:00', 'Neha', '7269068887', NULL, NULL, 'Near - Dooda colony , Para narpat kheda , Lucknow , uttar pradesh', NULL, 'Home', '226011', NULL, NULL, NULL, 'Lucknow', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1050.00, 117.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-05 13:46:18', '2026-05-12 06:25:07', 0, 0, NULL, 0),
(145, 36, '1778044256', '1740805', '77789705976', '20260505134621', 'Essential', '2026-05-05 13:46:00', 'Harish', '9917241696', NULL, NULL, 'Near - Chamunda devi mandir  , Rudrapur shiv nagar , Udham Singh Nagar ,Uttarakhand', NULL, 'Home', '263153', NULL, NULL, NULL, 'Udham Singh Nagar', 'Uttarakhand', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 117.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'rto_delivered', NULL, 0, '2026-05-05 13:52:27', '2026-05-17 10:15:06', 0, 0, NULL, 1),
(146, 36, '1778044066', '1740756', '77789694006', '20260505135231', 'Essential', '2026-05-05 13:52:00', 'Prince Chaudhary', '9634194346', NULL, NULL, 'village -  bhurri gannour road ,  sonipat , haryana', NULL, 'Home', '131001', NULL, NULL, NULL, 'Sonipat', 'Haryana', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 117.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-05 13:54:27', '2026-05-08 06:40:07', 0, 0, NULL, 0),
(147, 36, '1778044077', '1740759', '77789694566', '20260505135458', 'Essential', '2026-05-05 13:54:00', 'monika pandey', '9125511634', NULL, NULL, 'Near - chirkut baba mandir , Rajender Nagar V-Mart , gorakhpur , uttar pradesh', NULL, 'Home', '273015', NULL, NULL, NULL, 'Gorakhpur', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 900.00, 117.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'out_for_delivery', NULL, 0, '2026-05-05 14:19:16', '2026-05-11 12:20:15', 0, 0, NULL, 0),
(148, 36, '1778044054', '1740753', '77789693752', '20260505141919', 'Essential', '2026-05-05 14:19:00', 'Saba Khatun', '8853067441', NULL, NULL, 'Near  - Chandra Parkekh , Centre Bakery , Surat , Gujarat', 'Near Limbayat Madina Masjid', 'Home', '394210', NULL, NULL, NULL, 'Surat', 'Gujarat', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 900.00, 900.00, 117.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'delivered', NULL, 0, '2026-05-05 14:21:28', '2026-05-13 10:42:53', 0, 1, '2026-05-13 10:42:53', 0),
(149, 36, '1778044042', '1740748', '77789693446', '20260505145048', 'Essential', '2026-05-05 14:50:00', 'jyoti', '8218570210', NULL, NULL, 'Shri Ram Dairy ,  near - Mahata garden sadar , thana - sharanpur , uttar pradesh', NULL, 'Home', '247001', NULL, NULL, NULL, 'Saharanpur', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 900.00, 117.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'delivered', NULL, 0, '2026-05-05 14:53:41', '2026-05-14 12:51:40', 0, 1, '2026-05-14 12:51:40', 0),
(150, 36, NULL, NULL, '77789758056', '20260506051637', 'Essential', '2026-05-06 05:16:00', 'boby', '8235196825', NULL, NULL, 'sfsvvv', NULL, 'Home', '110049', NULL, NULL, NULL, 'South Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'order_cancelled', NULL, 0, '2026-05-06 05:17:33', '2026-05-08 06:45:09', 0, 0, NULL, 0),
(151, 36, NULL, NULL, NULL, '677675665645', 'Non Essential', '2025-02-27 19:16:00', 'boby', '9089878989', '9098789098', 'bozubeso@mailinator.com', 'Totam iste ad et dol', 'Consequatur nesciun', 'Home', '110059', NULL, NULL, NULL, 'West Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.014, 6.00, 3.00, 4.00, 54, NULL, 2, 0.00, 44.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 'cancelled', NULL, 0, '2026-05-06 05:33:06', '2026-05-13 13:59:14', 1, 0, NULL, 0),
(152, 39, '1778059000', '1744686', '77790205054', '20260506091002', 'Essential', '2026-05-06 09:10:00', 'Hari bhai 0.500 gm', '9060454764', NULL, NULL, 'Star Fashion shop , near mota bhai saree wala kai samnai , kali mandir road , patna , bihar', NULL, 'Home', '800020', NULL, NULL, NULL, 'Patna', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 55, NULL, 1, 0.00, 100.00, 139.18, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-06 09:11:38', '2026-05-17 10:15:06', 0, 0, NULL, 1),
(153, 39, '1778059050', '1744695', '76964125173', '20260506091144', 'Essential', '2026-05-06 09:11:00', 'Hari bhai 0.500 gm', '9060454764', '8235196825', NULL, 'Star fashion , mota bhai saree wala kai samnai , kali mandir road , hanuman nagar,patna', NULL, 'Home', '800020', NULL, NULL, NULL, 'Patna', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 55, NULL, 2, 0.00, 100.00, 119.18, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'delivered', NULL, 0, '2026-05-06 09:13:33', '2026-05-07 10:00:09', 0, 0, NULL, 0),
(154, 39, '1778058989', '1744685', '77790204741', '20260506091343', 'Essential', '2026-05-06 09:13:00', 'Hari bhai 1 kg', '9060454764', NULL, NULL, 'Star fashion , Hanuman Nagar, patna , bihar', 'Mota Bhai kai samnai wlaa', 'Home', '800020', NULL, NULL, NULL, 'Patna', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.900, 0.900, 20.00, 15.00, 15.00, 55, NULL, 1, 0.00, 100.00, 200.54, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'delivered', NULL, 0, '2026-05-06 09:16:14', '2026-05-11 10:18:02', 0, 1, '2026-05-11 10:18:02', 0),
(155, 39, '1778059174', '1744732', '76964129410', '20260506091754', 'Essential', '2026-05-06 09:17:00', 'Hari bhai Rto', '9060454764', NULL, NULL, 'Star Fashion, Hanuman Nagar, kali mandir road , mota bhai saree wala kai samnai, patna', NULL, 'Home', '800020', NULL, NULL, NULL, 'Patnapatna', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.000, 1.00, 1.00, 1.00, 55, NULL, 2, 0.00, 1000.00, 119.18, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'delivered', NULL, 0, '2026-05-06 09:19:10', '2026-05-08 06:25:09', 0, 0, NULL, 0),
(156, 41, '1778070856', '1756763', '77790449796', '1092993824437', 'Essential', '1999-10-08 09:19:00', 'Idona Sutton', '8978987878', '9089878767', 'zaryjixan@mailinator.com', 'Eveniet laborum Ve', 'Dolores aut cillum q', 'Home', '110059', NULL, NULL, NULL, 'West Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.006, 2.00, 4.00, 4.00, 56, NULL, 1, 490.00, 490.00, 138.00, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'cancelled', NULL, 0, '2026-05-06 12:29:12', '2026-05-06 12:46:33', 0, 0, NULL, 0),
(157, 41, '1778071729', '1756894', '77790462772', '5678678668676', 'Non Essential', '2024-05-03 00:32:00', 'Kelsey Williams', '6775678778', '9979789789', 'puqitoha@mailinator.com', 'Incididunt ducimus', 'Incididunt quia ea a', 'Home', '110059', NULL, NULL, NULL, 'West Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.013, 2.00, 4.00, 8.00, 56, NULL, 1, 2196.00, 2196.00, 138.00, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'cancelled', NULL, 0, '2026-05-06 12:47:57', '2026-05-06 12:51:23', 0, 0, NULL, 0),
(158, 36, NULL, NULL, NULL, '20260506151010', 'Essential', '2026-05-06 15:10:00', 'Priya pandit', '8532079547', NULL, NULL, 'Near -Sudheer nursing home ,  Badaun , krishna puri  ,  Mathura , uttar pradesh', NULL, 'Home', '243601', NULL, NULL, NULL, 'Budaun', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 1000.00, 1000.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 'cancelled', NULL, 0, '2026-05-06 15:22:01', '2026-05-13 13:59:14', 1, 0, NULL, 0),
(159, 36, '1778083445', '1757735', '77790553190', '20260506152244', 'Essential', '2026-05-06 15:22:00', 'Priya pandit', '8532079547', NULL, NULL, 'Near - Sudheer nursing home , Badaun , krishna puri , Mathura , uttar pradesh', NULL, 'Home', '243601', NULL, NULL, NULL, 'Budaun', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-06 15:24:18', '2026-05-17 10:15:06', 0, 0, NULL, 1),
(160, 36, '1778125233', '1758236', '77790728702', '20260506152430', 'Essential', '2026-05-06 15:24:00', 'Saikh afsana sameer', '9023377852', NULL, NULL, 'H-5 405 A-6, Ews awas kosad amroli  , Town kosad , district Surat , gujrat', NULL, 'Home', '394107', NULL, NULL, NULL, 'Surat', 'Gujarat', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-06 15:25:38', '2026-05-11 09:25:09', 0, 0, NULL, 0),
(161, 36, '1778125222', '1758233', '77790728540', '20260506152555', 'Essential', '2026-05-06 15:25:00', 'Savana', '9967955842', NULL, NULL, 'N.F Heritage Barkat Ali Virani Marg Mastan Talab Nagpada Mumbai , Mumbai , 31/Nawab building 1st Floor Room No.26', 'Mumbai , 31/Nawab building 1st Floor Room No.26', 'Home', '400008', NULL, NULL, NULL, 'Mumbai', 'Maharashtra', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 900.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'delivered', NULL, 0, '2026-05-06 15:28:14', '2026-05-14 12:52:27', 0, 1, '2026-05-14 12:52:27', 0),
(162, 36, '1778125202', '1758227', '77790728153', '20260506152819', 'Essential', '2026-05-06 15:28:00', 'Sandhya', '9389904213', '8630442567', NULL, 'Near - mandir ,  bhardwaj chauk , Dehradun bhardwaj chauk', NULL, 'Home', '248001', NULL, NULL, NULL, 'Dehradun', 'Uttarakhand', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-06 15:37:01', '2026-05-15 14:25:08', 0, 0, NULL, 0),
(163, 36, '1778125187', '1758224', '77790727980', '20260506153708', 'Essential', '2026-05-06 15:37:00', 'Sonam', '7988344149', NULL, NULL, 'Near -Tej Colony ,  Pahadii Mohhala   , Rohtak , Haryana', 'Samshan ghat', 'Home', '124001', NULL, NULL, NULL, 'Rohtak', 'Haryana', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-06 15:39:53', '2026-05-11 12:25:10', 0, 0, NULL, 0),
(164, 36, '1778125176', '1758218', '77790727840', '20260506153959', 'Essential', '2026-05-06 15:39:00', 'Saikh Rafiq', '7039233375', NULL, NULL, 'Near - vithal mandir , Ganga Nagar, Pimprichinchwad, Akurdi, Pune-411035, Maharashtra', NULL, 'Home', '411035', NULL, NULL, NULL, 'Pune', 'Maharashtra', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-06 15:43:19', '2026-05-15 08:30:09', 0, 0, NULL, 0),
(165, 36, '1778125164', '1758216', '77790727663', '20260506154355', 'Essential', '2026-05-06 15:43:00', 'Sameer', '9870619521', NULL, NULL, 'Near - Kirana store  ,  Bijnor ,  Dhampur  ,  Uttar Pradesh 246761', NULL, 'Home', '246761', NULL, NULL, NULL, 'Bijnor', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'out_for_delivery', NULL, 0, '2026-05-06 15:47:32', '2026-05-17 04:50:09', 0, 0, NULL, 0),
(166, 36, '1778125154', '1758215', '77790727556', '20260506154803', 'Essential', '2026-05-06 15:48:00', 'Manoj Kumar', '9664154105', NULL, NULL, 'Near - Bus stand , Pilibanga , Hanumangarh ,Rajasthan', NULL, 'Home', '335803', NULL, NULL, NULL, 'Hanumangarh', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-06 15:50:37', '2026-05-17 10:15:06', 0, 0, NULL, 1),
(167, 36, NULL, NULL, NULL, '20260506155957', 'Essential', '2026-05-06 15:59:00', 'Mukesh Kumar', '6287913558', NULL, NULL, 'ward no 4 ,  Malmaliya Fruit Market , Basantpur Road, Malmaliya, Siwan-841406, Bihar', 'Ward No 4, Bhagwanpur Hat, Siwan, Bihar 841406', 'Home', '841404', NULL, NULL, NULL, 'Siwan', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 1000.00, 1000.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 'cancelled', NULL, 0, '2026-05-06 16:03:05', '2026-05-13 13:59:14', 1, 0, NULL, 0),
(169, 36, '1778126314', '1758313', '77790752771', '20260507035650', 'Essential', '2026-05-07 03:56:00', 'muskan', '9006207756', NULL, NULL, 'H.no 26 Nagar parisad road , haridwar kabir dham ashram , dehradun', NULL, 'Home', '249411', NULL, NULL, NULL, 'Haridwar', 'Uttarakhand', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'out_for_delivery', NULL, 0, '2026-05-07 03:58:23', '2026-05-17 07:25:08', 0, 0, NULL, 0),
(170, 36, '1778126430', '1758317', '37355837556093', '20260507035951', 'Essential', '2026-05-07 03:59:00', 'dummy', '8235196825', NULL, NULL, 'fvbb', NULL, 'Home', '110049', NULL, NULL, NULL, 'South Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 2, 0.00, 1000.00, 94.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'order_cancelled', NULL, 0, '2026-05-07 04:00:21', '2026-05-08 06:45:09', 0, 0, NULL, 0),
(171, 36, NULL, NULL, NULL, '20260507155936', 'Essential', '2026-05-07 15:59:00', 'Khushbu', '6203499441', NULL, NULL, 'Near - st.joseph school  ,Telhiya Pokhar ,  Begusarai ,bihar', NULL, 'Home', '851101', NULL, NULL, NULL, 'Begusarai', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 'cancelled', NULL, 0, '2026-05-07 16:01:04', '2026-05-13 13:59:14', 1, 0, NULL, 0),
(172, 36, NULL, NULL, NULL, '20260507160108', 'Essential', '2026-05-07 16:01:00', 'Rajdeev rao', '6363254962', NULL, NULL, 'Bus stand, Taj hotel , Shivaji nagar , benglore ,  Karnataka \"', NULL, 'Home', '560001', NULL, NULL, NULL, 'Bangalore', 'Karnataka', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 1000.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 'cancelled', NULL, 0, '2026-05-07 16:02:25', '2026-05-13 13:59:14', 1, 0, NULL, 0),
(173, 36, NULL, NULL, NULL, '20260507160239', 'Essential', '2026-05-07 16:02:00', 'Muhruddin', '7568199861', NULL, NULL, 'Sunrise academy , clothing store  , Jhunjhunu Rajasthan', NULL, 'Home', '333001', NULL, NULL, NULL, 'Jhujhunu', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 54, NULL, 1, 0.00, 800.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 'cancelled', NULL, 0, '2026-05-07 16:03:44', '2026-05-13 13:59:14', 1, 0, NULL, 0),
(174, 36, '1778214086', '1775683', '77792076213', '20260507160645', 'Essential', '2026-05-07 16:06:00', 'Khushbu', '6203499441', NULL, NULL, 'Near - st.joseph school  , Teliya Pokhar , Begusarai , Bihar', NULL, 'Home', '851101', NULL, NULL, NULL, 'Begusarai', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-07 16:08:14', '2026-05-17 10:15:07', 0, 0, NULL, 1),
(175, 36, '1778213109', '1775605', '77792021101', '20260507160832', 'Essential', '2026-05-07 16:08:00', 'Rajdeev rao', '6363254962', NULL, NULL, 'Bus stand,Taj hotel \r\nShivaji nagar benglore Karnataka \"', NULL, 'Home', '560001', NULL, NULL, NULL, 'Bangalore', 'Karnataka', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-07 16:09:27', '2026-05-15 08:55:14', 0, 0, NULL, 0),
(176, 36, '1778213135', '1775609', '77792023982', '20260507160951', 'Essential', '2026-05-07 16:09:00', 'Muhruddin', '7568199861', NULL, NULL, 'Sunrise academy , clothing store  , Jhunjhunu  , Rajasthan', NULL, 'Home', '333001', NULL, NULL, NULL, 'Jhujhunu', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 800.00, 800.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'delivered', NULL, 0, '2026-05-07 16:10:38', '2026-05-15 02:38:56', 0, 1, '2026-05-15 02:38:56', 0),
(177, 36, '1778213095', '1775603', '77792019911', '20260507161118', 'Essential', '2026-05-07 16:11:00', 'Rahul', '9876939593', NULL, NULL, 'Guru nanak avenue , firozpur , punjab', 'Prachin Shri Shivala temple', 'Home', '152001', NULL, NULL, NULL, 'Firozpur', 'Punjab', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 500.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-07 16:12:13', '2026-05-17 10:15:07', 0, 0, NULL, 1),
(178, 36, '1778214065', '1775682', '37355837604522', '20260507161216', 'Essential', '2026-05-07 16:12:00', 'Nikki', '9888060548', NULL, NULL, 'Sacha Sauda Road, Malout, Sri Muktsar Sahib \nCity Name : Malout\nDistrict : Muktsar\nState : Punjab', NULL, 'Home', '152107', NULL, NULL, NULL, 'Muktsar', 'Punjab', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 1000.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'delivered', NULL, 0, '2026-05-07 16:14:54', '2026-05-15 02:41:23', 0, 1, '2026-05-15 02:41:23', 0),
(179, 36, '1778213016', '1775592', '77792017903', '20260507161500', 'Essential', '2026-05-07 16:15:00', 'Pradeep', '6378095124', NULL, NULL, 'Rahul Medical Store ,  hanumaan garh  , Rajasthan', NULL, 'Home', '335513', NULL, NULL, NULL, 'Hanumangarh', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 999.99, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-07 16:16:12', '2026-05-17 11:00:12', 0, 0, NULL, 0),
(180, 36, '1778221714', '1777395', '37355837616293', '20260507161616', 'Essential', '2026-05-07 16:16:00', 'Pushpendra chauhan', '8459781150', NULL, NULL, 'Lohar ka ghar  , Jalana , Daha , Belora road , maharastra', NULL, 'Home', '431202', NULL, NULL, NULL, 'Jalna', 'Maharashtra', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 1000.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-07 16:20:02', '2026-05-09 09:10:07', 0, 0, NULL, 0),
(181, 36, '1778212155', '1775441', '77791996936', '20260507162331', 'Essential', '2026-05-07 16:23:00', 'uday prakash', '7505060143', NULL, NULL, 'Vill - Jasmor ,  near -  Sanjay Quality Farm , Saharanpur , uttar pradesh', 'Behat Road', 'Home', '247121', NULL, NULL, NULL, 'Saharanpur', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'delivered', NULL, 0, '2026-05-07 16:26:13', '2026-05-14 12:53:16', 0, 1, '2026-05-14 12:53:16', 0),
(182, 36, '1778216327', '1776094', '37355837612535', '20260508045808', 'Essential', '2026-05-08 04:58:00', 'bygygb', '9060454764', NULL, 'fleetshyp@gmail.com', 'Glowriwellness , shop no 7/20 , h.no 4 , Kh , chachal park , NAgloi , new delhi', NULL, 'Home', '110041', NULL, NULL, NULL, 'West Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'order_cancelled', NULL, 0, '2026-05-08 04:58:36', '2026-05-12 11:50:17', 0, 0, NULL, 0),
(183, 39, '1778224962', '1778148', '77792554302', '20260508061420', 'Essential', '2026-05-08 06:14:00', 'rahul', '8909890989', '8989898989', 'n@gmail.com', 'uttam nagar new delhi', 'bjkbjh', 'Home', '110059', NULL, NULL, NULL, 'West Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.346, 12.00, 12.00, 12.00, 55, NULL, 1, 0.00, 3852.00, 140.36, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'order_cancelled', NULL, 0, '2026-05-08 06:15:24', '2026-05-12 11:50:17', 0, 0, NULL, 0),
(186, 39, '1778243865', '1781024', '77793014036', '20260508123436', 'Essential', '2026-05-08 12:34:00', 'demo', '8989898989', NULL, 'vidya4538@gmail.com', 'Qui qui rem eu ut ex', NULL, 'Home', '110059', NULL, NULL, NULL, 'West Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 55, NULL, 1, 0.00, 102.00, 140.36, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'manifested', NULL, 0, '2026-05-08 12:35:53', '2026-05-14 04:57:27', 0, 0, NULL, 0),
(187, 36, '1778256605', '1782260', '77793104675', '20260508144436', 'Essential', '2026-05-08 14:44:00', 'manoj yadav', '9199686095', NULL, NULL, 'Village - Kaptanganj , dist - kushinagar , state - uttar pradesh', NULL, 'Home', '274403', NULL, NULL, NULL, 'Kushinagar', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-08 14:46:17', '2026-05-17 09:40:12', 0, 0, NULL, 0),
(188, 36, '1778256595', '1782259', '77793104476', '20260508144621', 'Essential', '2026-05-08 14:46:00', 'Rubi', '7678416621', NULL, NULL, 'Near - Pani tanki , Gali No- B1 ,  Gulawati , bulandshahr ,', NULL, 'Home', '203408', NULL, NULL, NULL, 'Bulandshahr', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-08 14:48:00', '2026-05-17 09:40:12', 0, 0, NULL, 0),
(189, 36, '1778256579', '1782258', '37355837634121', '20260508144928', 'Essential', '2026-05-08 14:49:00', 'Nirmal Shrama', '9779853697', '9942524869', NULL, 'near - Middle School , Village - Naila , Saharsa , Bihar', NULL, 'Home', '852139', NULL, NULL, NULL, 'Supaul', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 900.00, 900.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-08 14:51:25', '2026-05-17 10:15:07', 0, 0, NULL, 1),
(190, 36, '1778256493', '1782257', '37355837634110', '20260508145201', 'Essential', '2026-05-08 14:52:00', 'chandani', '9942524869', NULL, NULL, 'Near - Hardiya Chawk , Samastipur , bihar', NULL, 'Home', '848132', NULL, NULL, NULL, 'Samastipur', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 1000.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-08 14:53:08', '2026-05-17 10:15:07', 0, 0, NULL, 1),
(191, 36, '1778256430', '1782255', '37355837634106', '20260508145403', 'Essential', '2026-05-08 14:54:00', 'ram kumar', '9673976220', NULL, NULL, 'Shiva Chowk in Nanded, Maharashtra , 431602', NULL, 'Home', '431602', NULL, NULL, NULL, 'Nanded', 'Maharashtra', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'out_for_delivery', NULL, 0, '2026-05-08 14:56:40', '2026-05-17 06:35:11', 0, 0, NULL, 0),
(192, 36, '1778256419', '1782254', '37355837634095', '20260508145654', 'Essential', '2026-05-08 14:56:00', 'saif', '7617807287', NULL, NULL, 'Zubair Chauraha in Tanda,Sakarwal ,  Ambedkar Nagar, Uttar Pradesh, is 224190', NULL, 'Home', '224190', NULL, NULL, NULL, 'Ambedkar Nagar', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-08 14:58:49', '2026-05-16 03:20:07', 0, 0, NULL, 0),
(193, 36, '1778256407', '1782253', '37355837634084', '20260508145700', 'Essential', '2026-05-08 14:57:00', 'vishal sharma', '9780902485', '9872719218', NULL, 'Hari Govind nagar , pathan cot By bass , Jalandhar , punjab 144012', NULL, 'Home', '144012', NULL, NULL, NULL, 'Jalandhar', 'Punjab', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-08 15:00:54', '2026-05-17 06:35:11', 0, 0, NULL, 0),
(194, 36, '1778256393', '1782252', '369197820427', '20260508150102', 'Essential', '2026-05-08 15:01:00', 'lokesh kumar', '8824330054', NULL, NULL, 'Near - government school , Albar , Kilpur , Kheda nagar  , 301409', NULL, 'Home', '301409', NULL, NULL, NULL, 'Alwar', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 92.60, 0.00, 0.00, 'Amazon New', 64, NULL, NULL, 'undelivered', NULL, 0, '2026-05-08 15:02:23', '2026-05-16 07:00:08', 0, 0, NULL, 0),
(195, 36, '1778256369', '1782250', '77793103662', '20260508150229', 'Essential', '2026-05-08 15:02:00', 'harish', '7975154163', NULL, NULL, 'chaar minar kai pass , Hyderabad', NULL, 'Home', '500002', NULL, NULL, NULL, 'Hyderabad', 'Telangana', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-08 15:04:47', '2026-05-13 12:10:09', 0, 0, NULL, 0),
(196, 36, '1778256354', '1782249', '37355837634062', '20260508152329', 'Essential', '2026-05-08 15:23:00', 'moh anas', '9368484829', NULL, NULL, 'near deria masjid , jaspur  , uddam singh nagar ,uttrakhand', NULL, 'Home', '244712', NULL, NULL, NULL, 'Udham Singh Nagar', 'Uttarakhand', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'delivered', NULL, 0, '2026-05-08 15:26:07', '2026-05-15 02:43:21', 0, 1, '2026-05-15 02:43:21', 0),
(197, 36, '1778256231', '1782247', '77793103006', '20260508152611', 'Essential', '2026-05-08 15:26:00', 'anjana kanti', '9395048618', NULL, NULL, 'Near Prathmik Vidayala , Kanti Pathar , Jaipur , Dibrujagadh , rajasthan', NULL, 'Home', '302006', NULL, NULL, NULL, 'Jaipur', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-08 15:28:23', '2026-05-12 11:50:18', 0, 0, NULL, 0),
(198, 36, '1778256148', '1782244', '77793102612', '20260508152826', 'Essential', '2026-05-08 15:28:00', 'rahul', '9693057017', NULL, NULL, 'Bhagwan Talkies, Indra Puri, Civil Lines, MG Road, Agra, Uttar Pradesh', NULL, 'Home', '281122', NULL, NULL, NULL, 'Mathura', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-08 15:30:27', '2026-05-17 12:40:10', 0, 0, NULL, 0),
(199, 36, '1778256129', '1782243', '37355837634014', '20260508153029', 'Essential', '2026-05-08 15:30:00', 'seema', '8404805992', NULL, NULL, 'near Veersa Nagar Purbish Jamshedpur jharkhand 831019', NULL, 'Home', '831019', NULL, NULL, NULL, 'East Singhbhum', 'Jharkhand', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-08 15:32:56', '2026-05-17 10:15:07', 0, 0, NULL, 1),
(200, 36, '1778256211', '1782246', '77793102936', '20260508153300', 'Essential', '2026-05-08 15:33:00', 'Rahul Patel Pooja patel', '7326093765', NULL, NULL, 'Near  Jitali medical store  , GIDC , Ankleshwar , Room  no 123 , gujarat', NULL, 'Home', '393002', NULL, NULL, NULL, 'Vadodara', 'Gujarat', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-08 15:37:20', '2026-05-17 10:30:14', 0, 0, NULL, 0),
(201, 36, '1778256342', '1782248', '37355837634051', '20260508153730', 'Essential', '2026-05-08 15:37:00', 'liley devi', '8798155570', NULL, NULL, 'near - 82 miles bazar ujjain dudhpur , unakoti , trupura', NULL, 'Home', '799266', NULL, NULL, NULL, 'Agartala', 'Tripura', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 1000.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-08 15:39:22', '2026-05-17 10:15:07', 0, 0, NULL, 1),
(202, 36, '1778255920', '1782236', '37355837633970', '20260508153929', 'Essential', '2026-05-08 15:39:00', 'nurulla', '7860818583', NULL, NULL, 'bhushii , chauraha , gonda ,uttar pradesh', NULL, 'Home', '271312', NULL, NULL, NULL, 'Gonda', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-08 15:41:39', '2026-05-16 12:35:22', 0, 0, NULL, 0),
(203, 36, '1778255908', '1782235', '37355837633966', '20260508154256', 'Essential', '2026-05-08 15:42:00', 'ritika', '9872410156', NULL, NULL, 'Near Verma Market, Ghanaur, ghanaur , 140702 , punjab', NULL, 'Home', '140702', NULL, NULL, NULL, 'Patiala', 'Punjab', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-08 15:44:52', '2026-05-16 09:05:14', 0, 0, NULL, 0),
(204, 36, '1778255896', '1782234', '77793101691', '20260508154454', 'Essential', '2026-05-08 15:44:00', 'savita kumari', '9149764308', NULL, NULL, 'gomti nagar , lucknow , uttar pradesh', NULL, 'Home', '226010', NULL, NULL, NULL, 'Lucknow', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-08 15:46:51', '2026-05-13 08:55:11', 0, 0, NULL, 0),
(205, 36, '1778255885', '1782233', '77793101665', '20260508154656', 'Essential', '2026-05-08 15:46:00', 'ramkesh', '8740869458', NULL, NULL, 'near government   hospital , udaipur . rajasthan', NULL, 'Home', '313001', NULL, NULL, NULL, 'Udaipur', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-08 15:48:36', '2026-05-12 11:50:18', 0, 0, NULL, 0),
(206, 36, '1778255866', '1782232', '77793101595', '20260508154841', 'Essential', '2026-05-08 15:48:00', 'arun', '7983417081', NULL, NULL, 'near trimurti chauraha , sanjay nagar , Breilley , uttar pradesh', NULL, 'Home', '243005', NULL, NULL, NULL, 'Bareilly', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-08 15:50:29', '2026-05-14 12:15:13', 0, 0, NULL, 0),
(207, 36, '1778255852', '1782230', '77793101562', '20260508155035', 'Essential', '2026-05-08 15:50:00', 'aman patel', '9058481657', NULL, NULL, 'mudiya chaudhary near kirnaa store bareilli , uttar pradesh', NULL, 'Home', '262406', NULL, NULL, NULL, 'Bareilly', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-08 15:56:25', '2026-05-17 10:15:07', 0, 0, NULL, 1),
(208, 36, '1778296041', '1782816', '77793260204', '20260509030321', 'Essential', '2026-05-09 03:03:00', 'Bariya ukabhai bhagvanbhai', '9714510114', NULL, NULL, 'mitiyala , amreli , gujarat', NULL, 'Home', '365540', NULL, NULL, NULL, 'Amreli', 'Gujarat', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'order_cancelled', NULL, 0, '2026-05-09 03:06:11', '2026-05-12 11:50:18', 0, 0, NULL, 0),
(209, 36, '1778339077', '1798993', '77794326411', '20260509140126', 'Essential', '2026-05-09 14:01:00', 'Anisha', '7447090000', NULL, NULL, 'jarord k pass jain mandir rajasthan', NULL, 'Home', '343022', NULL, NULL, NULL, 'Jalor', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 500.00, 500.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-09 14:03:57', '2026-05-12 11:50:18', 0, 0, NULL, 0),
(210, 36, '1778339066', '1798992', '77794326374', '20260509140400', 'Essential', '2026-05-09 14:04:00', 'anajli', '9216495167', NULL, NULL, 'near - government secondary school  ,karauli , keep ka purr , rajasthan', NULL, 'Home', '322241', NULL, NULL, NULL, 'Karauli', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-09 14:10:56', '2026-05-12 11:50:18', 0, 0, NULL, 0),
(211, 36, '1778339055', '1798991', '77794326330', '20260509141429', 'Essential', '2026-05-09 14:14:00', 'rohit mishra', '9926134314', NULL, NULL, 'mata kai mandir kai pass , tilak road khargone , jila khargone , madhya pradesh', NULL, 'Home', '451001', NULL, NULL, NULL, 'West Nimar', 'Madhya Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-09 14:16:23', '2026-05-12 11:50:18', 0, 0, NULL, 0),
(212, 36, '1778339042', '1798990', '77794325626', '20260509142253', 'Essential', '2026-05-09 14:22:00', 'rohit sharma', '9926134314', NULL, NULL, 'Near - Mata kai mandir kai pass , Tilak Road Khargone , madhya pradesh', NULL, 'Home', '451001', NULL, NULL, NULL, 'West Nimar', 'Madhya Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'out_for_delivery', NULL, 0, '2026-05-09 14:24:43', '2026-05-17 04:45:08', 0, 0, NULL, 0),
(213, 36, '1778339030', '1798989', '37355837674426', '20260509142445', 'Essential', '2026-05-09 14:24:00', 'Megha', '7535822260', NULL, NULL, 'Agarwal dharamsala bada bazar , mata wali gali , city - Shikhoabad ,dist - firozabad , uttar pradesh ,   283135 ,', NULL, 'Home', '283135', NULL, NULL, NULL, 'Firozabad', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 1000.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-09 14:33:11', '2026-05-17 06:40:08', 0, 0, NULL, 0),
(214, 36, '1778339007', '1798987', '77794325556', '20260509143456', 'Essential', '2026-05-09 14:34:00', 'megha', '7535822260', NULL, NULL, 'Agarwal dharamsala bada bazar , mata wali gali , city - Shikhoabad ,dist - firozabad , uttar pradesh ,   283135 ,', NULL, 'Home', '283135', NULL, NULL, NULL, 'Firozabad', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 1000.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-09 14:36:33', '2026-05-17 11:40:12', 0, 0, NULL, 0),
(215, 36, '1778339017', '1798988', '77794325571', '20260509143641', 'Essential', '2026-05-09 14:36:00', 'megha', '7535822260', NULL, NULL, 'Agarwal dharamsala bada bazar , mata wali gali , city - Shikhoabad ,dist - firozabad , uttar pradesh ,   283135 ,', NULL, 'Home', '283135', NULL, NULL, NULL, 'Firozabad', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 1000.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-09 14:37:35', '2026-05-17 11:40:12', 0, 0, NULL, 0),
(216, 36, '1778338998', '1798986', '77794325545', '20260509144759', 'Essential', '2026-05-09 14:47:00', 'Sangeeta', '9634194346', NULL, NULL, 'Village bichoda mathura road eklaas bazaar post bheswa jila aligarh', 'Near by sarkari school', 'Home', '202145', NULL, NULL, NULL, 'Aligarh', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 750.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-09 14:54:43', '2026-05-16 07:05:15', 0, 0, NULL, 0),
(217, 36, '1778338975', '1798985', '37355837674415', '20260509145453', 'Essential', '2026-05-09 14:54:00', 'Anjali', '7015203362', NULL, NULL, 'D 94 gali no. 11 nihar vihar shivram park nangloi new delhi', NULL, 'Home', '110041', NULL, NULL, NULL, 'West Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-09 14:56:47', '2026-05-17 09:40:12', 0, 0, NULL, 0),
(218, 36, '1778338947', '1798980', '37355837674404', '20260509145653', 'Essential', '2026-05-09 14:56:00', 'Manju yadav', '8871952693', NULL, NULL, 'Ward no. 4 jila ujain tehsil khachod gram batdaudi Madhya Pradesh', 'Near by harsaddi mandir', 'Home', '456224', NULL, NULL, NULL, 'Ujjain', 'Madhya Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 700.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-09 14:57:52', '2026-05-17 12:10:11', 0, 0, NULL, 0),
(219, 36, '1778338964', '1798982', '77794325232', '20260509145803', 'Essential', '2026-05-09 14:58:00', 'Rajesh singh', '8539046356', NULL, NULL, 'Ward no. 3 hauzpur village post hauzpur distic vaishali', 'Kalyaanpur school', 'Home', '844111', NULL, NULL, NULL, 'Vaishali', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1500.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-09 14:59:22', '2026-05-17 10:15:08', 0, 0, NULL, 1),
(220, 36, '1778338934', '1798977', '37355837674393', '20260509145932', 'Essential', '2026-05-09 14:59:00', 'Janhvi', '7414058644', NULL, NULL, 'Sindi camp bus stand golde  spa centre jaipur bus stand Rajasthan 302016', 'Jaipur bus stand', 'Home', '302016', NULL, NULL, NULL, 'Jaipur', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 700.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-09 15:00:33', '2026-05-17 08:40:12', 0, 0, NULL, 0),
(221, 36, '1778338923', '1798976', '37355837674382', '20260509150046', 'Essential', '2026-05-09 15:00:00', 'Rakhi', '9770324930', NULL, NULL, 'W/o sandeep kol gram badi dih post purwa Tahasil semariya puraa distic Rewa madhyapradesh', NULL, 'Home', '486445', NULL, NULL, NULL, 'Rewa', 'Madhya Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'out_for_delivery', NULL, 0, '2026-05-09 15:01:40', '2026-05-17 05:35:12', 0, 0, NULL, 0),
(222, 36, NULL, NULL, NULL, '20260510010343', 'Essential', '2026-05-10 01:03:00', 'boby', '8235196825', NULL, NULL, 'ghjhvv nbnbnmb,', NULL, 'Home', '110059', NULL, NULL, NULL, 'West Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 999.99, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 'cancelled', NULL, 0, '2026-05-10 01:04:21', '2026-05-13 13:59:14', 1, 0, NULL, 0),
(223, 36, '1778425263', '1800824', '77795001966', '20260510141118', 'Essential', '2026-05-10 14:11:00', 'rahul', '7326093765', NULL, NULL, 'ankleshwar cit GIDC Jitali medicaldical store Room no 123', NULL, 'Home', '393001', NULL, NULL, NULL, 'Bharuch', 'Gujarat', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-10 14:17:48', '2026-05-17 10:30:15', 0, 0, NULL, 0),
(224, 36, '1778425239', '1800823', '37355837687796', '20260510141750', 'Essential', '2026-05-10 14:17:00', 'rakesh', '9250154635', NULL, NULL, 'near by bus stand , kanpur dehat  ,uttar pradesh ,  208001', NULL, 'Home', '208001', NULL, NULL, NULL, 'Kanpur Dehat', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 800.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-10 14:20:24', '2026-05-12 11:50:19', 0, 0, NULL, 0),
(225, 36, '1778425216', '1800822', '37355837687785', '20260510142225', 'Essential', '2026-05-10 14:22:00', 'arman', '6303701012', NULL, NULL, 'near - alfa hotel , sikandara bad , hyderbad . telangana', NULL, 'Home', '500003', NULL, NULL, NULL, 'Hyderabad', 'Telangana', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-10 14:23:21', '2026-05-12 11:50:19', 0, 0, NULL, 0),
(226, 36, '1778425205', '1800821', '37355837687774', '20260510142029', 'Essential', '2026-05-10 14:20:00', 'arman', '6303701012', NULL, NULL, 'near - alfa hotel , sikandara bad , hyderbad . telangana', NULL, 'Home', '500003', NULL, NULL, NULL, 'Hyderabad', 'Telangana', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-10 14:23:50', '2026-05-12 11:50:19', 0, 0, NULL, 0),
(227, 36, '1778425194', '1800816', '37355837687763', '20260510142353', 'Essential', '2026-05-10 14:23:00', 'suneel', '9016397551', NULL, NULL, 'near by sheri , gondal , rajkot', NULL, 'Home', '360311', NULL, NULL, NULL, 'Rajkot', 'Gujarat', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-10 14:25:44', '2026-05-12 11:50:19', 0, 0, NULL, 0),
(228, 36, '1778425184', '1800815', '37355837687752', '20260510142549', 'Essential', '2026-05-10 14:25:00', 'nitesh', '8368014681', NULL, NULL, 'rajeev colony , faridabad ,Ballabhgarh Haryana', NULL, 'Home', '121004', NULL, NULL, NULL, 'Faridabad', 'Haryana', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 800.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-10 14:28:24', '2026-05-17 07:45:09', 0, 0, NULL, 0),
(229, 36, '1778425166', '1800814', '37355837687741', '20260510142837', 'Essential', '2026-05-10 14:28:00', 'sonu', '7668152082', NULL, NULL, 'Near by Gangotra medical indira puram delhi', NULL, 'Home', '201014', NULL, NULL, NULL, 'Ghaziabad', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 800.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-10 14:32:06', '2026-05-12 11:50:19', 0, 0, NULL, 0),
(230, 36, '1778425153', '1800813', '37355837687730', '20260510143211', 'Essential', '2026-05-10 14:32:00', 'Varsha', '7541872751', NULL, NULL, 'dehariya , Pratap nagar , Katihar bihar', NULL, 'Home', '854101', NULL, NULL, NULL, 'Katihar', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 800.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-10 14:37:06', '2026-05-17 10:15:08', 0, 0, NULL, 1),
(231, 36, '1778425332', '1800825', '37355837687800', '20260510143712', 'Essential', '2026-05-10 14:37:00', 'sammer', '8082049986', NULL, NULL, 'Teh- bani\nDist- khatua \nPost-  bani\nNear by degree College bani\n184206', NULL, 'Home', '184205', NULL, NULL, NULL, 'Kathua', 'Jammu and Kashmir', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 800.00, 800.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-10 14:38:01', '2026-05-12 11:50:19', 0, 0, NULL, 0),
(232, 36, '1778425114', '1800811', '37355837687726', '20260510143851', 'Essential', '2026-05-10 14:38:00', 'Shittal', '7990283897', NULL, NULL, 'Village moyad distic sabar khantha tapratij Gujarat', 'Near by primary school', 'Home', '383120', NULL, NULL, NULL, 'Sabarkantha', 'Gujarat', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 600.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-10 14:39:45', '2026-05-12 11:50:19', 0, 0, NULL, 0),
(233, 36, '1778425103', '1800810', '37355837687715', '20260510143950', 'Essential', '2026-05-10 14:39:00', 'Suraj ashok', '8380876814', NULL, NULL, 'Village pusad distic yavatmal Umer Khand road sai nagri pusad Maharashtra', 'Near by Sai baba mandir', 'Home', '445204', NULL, NULL, NULL, 'Yavatmal', 'Maharashtra', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 1350.00, 1350.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-10 14:40:37', '2026-05-17 07:35:10', 0, 0, NULL, 0),
(234, 36, '1778425092', '1800809', '37355837687704', '20260510144040', 'Essential', '2026-05-10 14:40:00', 'Rahul', '9872472254', NULL, NULL, 'Ward no. 4 soni market purniya jila bihar', 'Near by government school', 'Home', '854315', NULL, NULL, NULL, 'Purnia', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-10 14:41:30', '2026-05-17 06:25:11', 0, 0, NULL, 0),
(235, 36, '1778425080', '1800808', '77795001314', '20260510144134', 'Essential', '2026-05-10 14:41:00', 'Sumararam', '9352689228', NULL, NULL, '\"697k pushra marg ward no. 25 jaisalmer tehsil jaisalmer distic jaisalmer Rajasthan\r\n\"', 'Near by sabzi bazar', 'Home', '345001', NULL, NULL, NULL, 'Jaisalmer', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1250.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-10 14:42:38', '2026-05-17 05:10:07', 0, 0, NULL, 0);
INSERT INTO `fship_orders` (`id`, `user_id`, `fship_api_order_id`, `pickup_order_id`, `waybill`, `merchant_order_id`, `order_type`, `order_date`, `buyer_name`, `phone_number`, `alt_phone_number`, `email_id`, `complete_address`, `landmark`, `customer_Address_Type`, `pincode`, `source_pincode`, `destination_pincode`, `source_destination`, `city`, `state`, `zone`, `is_pickup_available`, `is_delivery_available`, `is_cod_available`, `is_prepaid_available`, `company_name`, `gstin_number`, `weight`, `volumetric_weight`, `length`, `width`, `height`, `pick_address_ID`, `reseller_name`, `payment_mode`, `total_amount`, `product_subtotal`, `wallet_deduction_amount`, `forward_charge`, `cod_charge`, `courier_name`, `courier_id`, `service_mode`, `booked_at`, `status`, `tags`, `has_reverse_order`, `created_at`, `updated_at`, `is_refunded`, `is_remitted`, `remitted_at`, `rto_processed`) VALUES
(236, 36, '1778425067', '1800807', '37355837687693', '20260510144247', 'Essential', '2026-05-10 14:42:00', 'Sadhana agarwal', '8799733968', NULL, NULL, 'Nw 185 vishnu garden gali no. 17 new Delhi', 'Near by pawan store', 'Home', '110018', NULL, NULL, NULL, 'West Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 700.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-10 14:43:28', '2026-05-17 10:05:13', 0, 0, NULL, 0),
(237, 36, '1778425057', '1800805', '37355837687682', '20260510144449', 'Essential', '2026-05-10 14:44:00', 'Neelam', '8875448767', NULL, NULL, 'Bhiiwadi khehrani MTI chowk Rajasthan', 'Jay Samsung\'s company', 'Home', '301019', NULL, NULL, NULL, 'Alwar', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-10 14:45:49', '2026-05-16 04:50:20', 0, 0, NULL, 0),
(238, 36, '1778425038', '1800804', '37355837687671', '20260510144609', 'Essential', '2026-05-10 14:46:00', 'Jasveer kour', '9877681485', NULL, NULL, 'Anandpur mohalla gali no. 5 fazilka Punjab', 'Near by gurudwara', 'Home', '152123', NULL, NULL, NULL, 'Firozpur', 'Punjab', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1300.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-10 14:47:06', '2026-05-17 07:50:13', 0, 0, NULL, 0),
(239, 36, '1778425027', '1800803', '37355837687660', '20260510144752', 'Essential', '2026-05-10 14:47:00', 'Sonia', '9509402843', NULL, NULL, 'ward no 5 , pani ki tanki rajputana ka mohalla ,city - surajgarh , jila jhunjhuna ,rajasthan', NULL, 'Home', '333029', NULL, NULL, NULL, 'Jhujhunu', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1500.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-10 14:49:27', '2026-05-12 11:50:19', 0, 0, NULL, 0),
(240, 36, '1778425015', '1800802', '37355837687634', '20260510145006', 'Essential', '2026-05-10 14:50:00', 'Sana khan', '9432857329', NULL, NULL, 'Hooghly village panchlok Morpukur rishta west Bengal', '712250', 'Home', '712250', NULL, NULL, NULL, 'Hooghly', 'West Bengal', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 1350.00, 1350.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-10 14:50:52', '2026-05-17 10:15:08', 0, 0, NULL, 1),
(241, 36, '1778425006', '1800801', '37355837687623', '20260510145113', 'Essential', '2026-05-10 14:51:00', 'Meenakshi devi', '7889799737', NULL, NULL, 'Main Barota main chowk barota bazar jammu kashmir', 'Near by radha krishna mandir', 'Home', '184203', NULL, NULL, NULL, 'Kathua', 'Jammu & Kashmir', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1200.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-10 14:52:05', '2026-05-17 12:30:14', 0, 0, NULL, 0),
(242, 36, '1778424995', '1800800', '77795000846', '20260510145510', 'Essential', '2026-05-10 14:55:00', 'Rajni', '9634194346', NULL, NULL, 'Jila aligarh post beshwa tehsil eklaas village kadli eklaas bazar mathura Road', 'Near by shiv mandir', 'Home', '202145', NULL, NULL, NULL, 'Aligarh', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 999.99, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-10 14:56:22', '2026-05-16 08:50:21', 0, 0, NULL, 0),
(243, 36, '1778514812', '1810453', '37355837750774', '20260511152754', 'Essential', '2026-05-11 15:27:00', 'Nikhil Kumar', '9470209433', NULL, NULL, 'Near- shiv mandir , barmasia ,   katihar  , Bihar', NULL, 'Home', '854105', NULL, NULL, NULL, 'Katihar', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-11 15:29:21', '2026-05-16 10:20:10', 0, 0, NULL, 0),
(244, 36, '1778514802', '1810452', '37355837750763', '20260511152923', 'Essential', '2026-05-11 15:29:00', 'Manoj yadav', '9670317049', NULL, NULL, 'Tower ke pass  , nagwa khas , Jila Deoria , UTTAR PRADESH', NULL, 'Home', '274208', NULL, NULL, NULL, 'Deoria', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 900.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'delivered', NULL, 0, '2026-05-11 15:32:13', '2026-05-15 13:05:09', 0, 0, NULL, 0),
(245, 36, '1778514793', '1810451', '37355837750752', '20260511153222', 'Essential', '2026-05-11 15:32:00', 'Pooja', '8829969810', NULL, NULL, 'Kailash Nagar, Thergaon, Pune, Maharashtra, India.Pincode: 411033.', NULL, 'Home', '411033', NULL, NULL, NULL, 'Pune', 'Maharashtra', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-11 15:33:43', '2026-05-12 11:50:19', 0, 0, NULL, 0),
(246, 36, '1778514779', '1810450', '77796752084', '20260511153345', 'Essential', '2026-05-11 15:33:00', 'DEEPAK', '8708105264', NULL, NULL, '351jghadri road colony azad nagar,ambala, haryana, 134003', NULL, 'Home', '134003', NULL, NULL, NULL, 'Ambala', 'Haryana', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'delivered', NULL, 0, '2026-05-11 15:34:31', '2026-05-15 09:55:10', 0, 0, NULL, 0),
(247, 36, '1778514767', '1810449', '37355837750704', '20260511153433', 'Essential', '2026-05-11 15:34:00', 'Pankaj', '9399759657', NULL, NULL, 'Near Teen Batti Chowk/Badrakali Chowk.District: Devbhumi Dwarka.State: Gujarat.PIN Code:', NULL, 'Home', '360515', NULL, NULL, NULL, 'Jamnagar', 'Gujarat', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1100.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-11 15:37:29', '2026-05-12 11:50:19', 0, 0, NULL, 0),
(248, 36, '1778514754', '1810448', '37355837750693', '20260511153803', 'Essential', '2026-05-11 15:38:00', 'Soni', '6307983479', NULL, NULL, 'Arju nagar mandoi thana sita puri road lucknow uttar pardesh', 'Near by Nancy nursing home', 'Home', '226021', NULL, NULL, NULL, 'Lucknow', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1500.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-11 15:38:46', '2026-05-17 10:25:12', 0, 0, NULL, 0),
(249, 36, '1778514742', '1810447', '77796751922', '20260511153849', 'Essential', '2026-05-11 15:38:00', 'Indal haran', '8928597242', NULL, NULL, 'Arunodya wing A kamla nagar village parle west mumbai', 'Near by shiv mandir', 'Home', '400056', NULL, NULL, NULL, 'Mumbai', 'Maharashtra', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'out_for_delivery', NULL, 0, '2026-05-11 15:39:51', '2026-05-16 10:50:12', 0, 0, NULL, 0),
(250, 36, '1778514732', '1810445', '77796751874', '20260511153954', 'Essential', '2026-05-11 15:39:00', 'Suman singh', '6283164203', NULL, NULL, 'Badi dhandari kalan sanskari school ki gali  ludhiana Punjab', 'Near by sunday bazaar', 'Home', '141014', NULL, NULL, NULL, 'Ludhiana', 'Punjab', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1200.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-11 15:40:47', '2026-05-17 08:10:10', 0, 0, NULL, 0),
(251, 36, '1778514647', '1810443', '37355837750671', '20260511154050', 'Essential', '2026-05-11 15:40:00', 'Guddi bishnoi', '8824455702', NULL, NULL, 'Khara daya sagar phalodi jodhpur phalodi Rajasthan', 'Near by udani market', 'Home', '345023', NULL, NULL, NULL, 'Jaisalmer', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1500.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-11 15:41:44', '2026-05-12 11:50:20', 0, 0, NULL, 0),
(252, 36, '1778514635', '1810442', '77796751502', '20260511154203', 'Essential', '2026-05-11 15:42:00', 'Aasih parveen', '8240424647', NULL, NULL, 'Hathiyara sharif khayal purva para distic parganas west Bengal', NULL, 'Home', '700157', NULL, NULL, NULL, 'North 24 Parganas', 'West Bengal', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1200.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-11 15:42:38', '2026-05-17 10:35:15', 0, 0, NULL, 0),
(253, 36, '1778514622', '1810441', '37355837750660', '20260511154246', 'Essential', '2026-05-11 15:42:00', 'Arjun kumar', '7500046225', NULL, NULL, 'Village chandenamal shamli jalalabad muzaffarnagar uttar pardesh', 'Near by prathmik vidhalay', 'Home', '247772', NULL, NULL, NULL, 'Muzaffarnagar', 'Uttar Pradesh', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1350.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'undelivered', NULL, 0, '2026-05-11 15:43:38', '2026-05-17 09:10:12', 0, 0, NULL, 0),
(254, 36, '1778514597', '1810439', '37355837750656', '20260511154354', 'Essential', '2026-05-11 15:43:00', 'Sakshi', '6005626679', NULL, NULL, 'Satyam institute of management ram tirath road amritsar Punjab', NULL, 'Home', '143105', NULL, NULL, NULL, 'Amritsar', 'Punjab', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1200.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-11 15:45:00', '2026-05-12 11:50:20', 0, 0, NULL, 0),
(255, 36, '1778514585', '1810438', '37355837750634', '20260511154545', 'Essential', '2026-05-11 15:45:00', 'ANAND', '9319876498', NULL, NULL, 'Near by santoshi mata mandir , Rana ji enclave Najafgarh new delhi', NULL, 'Home', '110043', NULL, NULL, NULL, 'South West Delhi', 'Delhi', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 800.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'rto_in_transit', NULL, 0, '2026-05-11 15:49:31', '2026-05-17 10:15:08', 0, 0, NULL, 1),
(256, 36, '1778605273', '1818165', '77798022735', '20260512153357', 'Essential', '2026-05-12 15:33:00', '-shrawan ram', '8882330478', NULL, NULL, 'Gandwala Bikaner , government senior secondary school\r\nPincode:334001', NULL, 'Home', '334001', NULL, NULL, NULL, 'Bikaner', 'Rajasthan', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-12 15:36:04', '2026-05-14 11:20:12', 0, 0, NULL, 0),
(257, 36, '1778605261', '1818164', '77798022702', '20260512153607', 'Essential', '2026-05-12 15:36:00', 'Raj Shaikh', '9177579077', NULL, NULL, 'Dimna basti hayat nagar, near Laal building, jamshedpur Jharkhand \r\nPincode- 831012', NULL, 'Home', '831012', NULL, NULL, NULL, 'East Singhbhum', 'Jharkhand', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1200.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-12 15:38:49', '2026-05-17 10:00:30', 0, 0, NULL, 0),
(258, 36, '1778605249', '1818163', '77798022676', '20260512153851', 'Essential', '2026-05-12 15:38:00', 'Shabana banu maniyar', '6361005821', NULL, NULL, 'Near minakshi chowk desai chawl near vasudev hospital , vijaypur district \r\nPincode- 586101', NULL, 'Home', '586101', NULL, NULL, NULL, 'Bijapur(KAR)', 'Karnataka', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-12 15:39:36', '2026-05-14 11:20:12', 0, 0, NULL, 0),
(259, 36, '1778605236', '1818162', '37355837789996', '20260512153938', 'Essential', '2026-05-12 15:39:00', 'asma', '9353441795', NULL, NULL, ',2ndmainroadshadabnagar,djhalli,Bangalore north,Bangalore,Karnataka 560045', NULL, 'Home', '560045', NULL, NULL, NULL, 'Bangalore', 'Karnataka', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-12 15:40:31', '2026-05-13 13:10:10', 0, 0, NULL, 0),
(260, 36, '1778605217', '1818161', '37355837789985', '20260512154033', 'Essential', '2026-05-12 15:40:00', 'aamina nabi', '6005500310', NULL, NULL, 'Safapora [Sub Office]District: GanderbalTaluk/Block: Sumbal , jammu kashmir', NULL, 'Home', '191131', NULL, NULL, NULL, 'Srinagar', 'Jammu & Kashmir', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-12 15:41:46', '2026-05-13 13:05:13', 0, 0, NULL, 0),
(261, 36, '1778605185', '1818160', '77798022503', '20260512154148', 'Essential', '2026-05-12 15:41:00', 'Salma Moulali Akshimani', '8431816591', NULL, NULL, '49 halmaddi alur uttara kannada karnataka 581325', 'Hallal road Halmaddi', 'Home', '581325', NULL, NULL, NULL, 'Uttara Kannada', 'Karnataka', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1200.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-12 15:43:36', '2026-05-14 11:20:13', 0, 0, NULL, 0),
(262, 36, '1778605173', '1818159', '77798022433', '20260512154640', 'Essential', '2026-05-12 15:46:00', 'Samim alam', '9065075754', NULL, NULL, 'Patliputra Station Rd, shivaji Nagar Patna, Bihar 800014', NULL, 'Home', '800014', NULL, NULL, NULL, 'Patna', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 3000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-12 15:48:51', '2026-05-16 11:20:09', 0, 0, NULL, 0),
(263, 36, '1778605161', '1818158', '77798022363', '20260512154857', 'Essential', '2026-05-12 15:48:00', 'Samim alam', '9065075754', NULL, NULL, 'Patliputra Station Rd, shivaji Nagar Patna, Bihar 800014', 'Shivaji Nagar', 'Home', '800014', NULL, NULL, NULL, 'Patna', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 3000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-12 15:50:03', '2026-05-16 11:20:09', 0, 0, NULL, 0),
(264, 36, '1778605149', '1818157', '77798022330', '20260512155006', 'Essential', '2026-05-12 15:50:00', 'Samim alam', '9065075754', NULL, NULL, 'Patliputra Station Rd, shivaji Nagar Patna, Bihar 800014', 'Shivaji Nagar', 'Home', '800014', NULL, NULL, NULL, 'Patna', 'Bihar', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 750.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-12 15:51:05', '2026-05-16 11:20:09', 0, 0, NULL, 0),
(265, 36, '1778605138', '1818156', '77798022256', '20260512155110', 'Essential', '2026-05-12 15:51:00', 'Manju', '9886542152', NULL, NULL, '1st gate 75, 75, Gokul Rd, 1st gate, Industrial Estate, Hubballi, Karnataka 580030', 'Hubballi', 'Home', '580030', NULL, NULL, NULL, 'Dharwad', 'Karnataka', 'a', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1100.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-12 15:52:08', '2026-05-14 11:20:13', 0, 0, NULL, 0),
(266, 39, '1778654695', '1821079', '77798601215', '20260513064335', 'Essential', '2026-05-13 06:43:00', 'rahul', '8989898989', NULL, 'vidya4538@gmail.com', 'Qui qui rem eu ut ex', NULL, 'Home', '110059', NULL, NULL, NULL, 'West Delhi', 'Delhi', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.500, 0.346, 12.00, 12.00, 12.00, 55, NULL, 1, 0.00, 2541.00, 140.36, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'order_cancelled', NULL, 0, '2026-05-13 06:44:40', '2026-05-13 13:00:12', 1, 0, NULL, 0),
(267, 36, '1778680686', '1825641', '37355837833002', '20260513110837', 'Essential', '2026-05-13 11:08:00', 'Sunat singh', '9682139807', NULL, NULL, 'Ward no. 6 village punchari udhampur Jammu kashmir', 'Near by high school', 'Home', '182125', NULL, NULL, NULL, 'Udhampur', 'Jammu & Kashmir', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1500.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-13 11:09:35', '2026-05-14 11:40:12', 0, 0, NULL, 0),
(268, 36, '1778680673', '1825640', '77799148604', '20260513110943', 'Essential', '2026-05-13 11:09:00', 'Avadhesh kumar', '7488632041', NULL, NULL, 'Avadhesh kumar telhara naland bihar', 'Near by thada mandir', 'Home', '801306', NULL, NULL, NULL, 'Nalanda', 'Bihar', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1350.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-13 11:10:30', '2026-05-15 07:20:13', 0, 0, NULL, 0),
(269, 36, '1778680664', '1825639', '37355837832991', '20260513111033', 'Essential', '2026-05-13 11:10:00', 'Devki pal', '6268562232', NULL, NULL, 'Nanon gaon chanderi piprai ashok nagar madhya pardesh', '473446Near by hanuman mandir', 'Home', '473446', NULL, NULL, NULL, 'Ashok Nagar', 'Madhya Pradesh', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-13 11:11:33', '2026-05-14 11:40:13', 0, 0, NULL, 0),
(270, 36, '1778680653', '1825638', '77799148350', '20260513111144', 'Essential', '2026-05-13 11:11:00', 'Poonam', '8434261491', NULL, NULL, '70 feet road pakri anishabad patna', 'Near by radha krishna mandir', 'Home', '800002', NULL, NULL, NULL, 'Patna', 'Bihar', 'b', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1350.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-13 11:12:27', '2026-05-15 08:45:18', 0, 0, NULL, 0),
(271, 36, '1778680643', '1825636', '37355837832980', '20260513111230', 'Essential', '2026-05-13 11:12:00', 'sangam', '7897887625', NULL, NULL, 'Shahganj bazar Mukimpur urf pahadpur faizabad uttar pradesh', 'Near by kumar medical store', 'Home', '224284', NULL, NULL, NULL, 'Ambedkar Nagar', 'Uttar Pradesh', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-13 11:13:20', '2026-05-14 11:40:13', 0, 0, NULL, 0),
(272, 36, '1778680634', '1825634', '37355837832976', '20260513111339', 'Essential', '2026-05-13 11:13:00', 'Mukesh', '9978718572', '9979518603', NULL, 'Limkheda shastri chowk limkheda dist dahod Gujarat', 'Near by Ami photo studio', 'Home', '389140', NULL, NULL, NULL, 'Dahod', 'Gujarat', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-13 11:14:23', '2026-05-14 11:40:13', 0, 0, NULL, 0),
(273, 36, '1778680623', '1825633', '37355837832965', '20260513111436', 'Essential', '2026-05-13 11:14:00', 'Kousar', '8650632252', NULL, NULL, 'Rudrapur kheda udham singh badi masjid Uttrakhand', 'Near by agra mithai wala', 'Home', '263153', NULL, NULL, NULL, 'Udham Singh Nagar', 'Uttarakhand', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1200.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-13 11:15:28', '2026-05-14 11:40:13', 0, 0, NULL, 0),
(274, 36, '1778680613', '1825632', '37355837832954', '20260513111531', 'Essential', '2026-05-13 11:15:00', 'Avantika jhariya', '8815909813', NULL, NULL, 'Kabir chowk anjaniya madla madhya pardesh', 'Near by gas agency', 'Home', '481998', NULL, NULL, NULL, 'Mandla', 'Madhya Pradesh', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-13 11:16:12', '2026-05-14 11:40:13', 0, 0, NULL, 0),
(275, 36, '1778680599', '1825630', '77799147904', '20260513111617', 'Essential', '2026-05-13 11:16:00', 'Soniya', '9205357531', NULL, NULL, 'Duryai khachoda gb nagar bhagat singh chowk uttar pradesh', 'Near by city post', 'Home', '203207', NULL, NULL, NULL, 'Gautam Buddha Nagar', 'Uttar Pradesh', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1499.98, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-13 11:17:25', '2026-05-16 13:45:19', 0, 0, NULL, 0),
(276, 36, '1778680590', '1825629', '77799147650', '20260513111811', 'Essential', '2026-05-13 11:18:00', 'Manisha desai', '9265790271', NULL, NULL, 'Katargam ved road dabholi gurukul surat Gujarat', 'Near by D mart', 'Home', '395004', NULL, NULL, NULL, 'Surat', 'Gujarat', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-13 11:19:11', '2026-05-14 11:20:13', 0, 0, NULL, 0),
(277, 36, '1778680579', '1825628', '77799147576', '20260513112004', 'Essential', '2026-05-13 11:20:00', 'Manisha desai', '9265790271', NULL, NULL, 'Katargam ved road dabholi gurukul surat Gujarat', 'Near by D mart', 'Home', '395004', NULL, NULL, NULL, 'Surat', 'Gujarat', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-13 11:20:55', '2026-05-14 11:20:13', 0, 0, NULL, 0),
(278, 36, '1778680566', '1825627', '37355837832932', '20260513112058', 'Essential', '2026-05-13 11:20:00', 'Rakhi', '9770324930', NULL, NULL, 'W/o sandeep kol gram badi dih post purwa Tahasil semariya puraa distic Rewa madhyapradesh', '486445Near by besaman mama bazar', 'Home', '486445', NULL, NULL, NULL, 'Rewa', 'Madhya Pradesh', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 2000.00, 2000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-13 11:21:51', '2026-05-14 11:40:13', 0, 0, NULL, 0),
(279, 36, '1778680544', '1825624', '77799147226', '20260513112212', 'Essential', '2026-05-13 11:22:00', 'Dilip gupta', '8887921511', NULL, NULL, 'Punjabi colony sultanpur Rajasthan mithai wali gali uttar pardesh', NULL, 'Home', '228001', NULL, NULL, NULL, 'Sultanpur', 'Uttar Pradesh', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'in_transit', NULL, 0, '2026-05-13 11:22:49', '2026-05-14 11:20:13', 0, 0, NULL, 0),
(280, 36, '1778680552', '1825626', '77799147300', '20260513112310', 'Essential', '2026-05-13 11:23:00', 'Rajesh singh', '8539046356', NULL, NULL, 'Ward no. 3 hauzpur village post hauzpur distic vaishali', 'Kalyaanpur school', 'Home', '844111', NULL, NULL, NULL, 'Vaishali', 'Bihar', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 107.94, 0.00, 0.00, 'Bluedart Surface 500 Gm', 88, NULL, NULL, 'undelivered', NULL, 0, '2026-05-13 11:24:49', '2026-05-16 08:10:10', 0, 0, NULL, 0),
(281, 36, '1778680517', '1825623', '37355837832910', '20260513112509', 'Essential', '2026-05-13 11:25:00', 'Anjali', '7015203362', NULL, NULL, 'D 94 gali no. 11 nihar vihar shivram park nangloi new delhi', 'Near by kalu caterers', 'Home', '110041', NULL, NULL, NULL, 'West Delhi', 'Delhi', 'c', 'No', 'No', 'No', 'No', NULL, NULL, 0.200, 0.200, 10.00, 10.00, 10.00, 57, NULL, 1, 0.00, 1000.00, 104.40, 0.00, 0.00, 'Delhivery Surface (Brand)', 65, NULL, NULL, 'in_transit', NULL, 0, '2026-05-13 11:27:50', '2026-05-14 11:40:13', 0, 0, NULL, 0),
(282, 39, NULL, NULL, NULL, '20260513120712', 'Essential', '2026-05-13 12:07:00', 'test', '8989898989', NULL, 'test@gmail.com', 'Qui qui rem eu ut ex', NULL, 'Home', '110059', NULL, NULL, NULL, 'West Delhi', 'Delhi', NULL, 'No', 'No', 'No', 'No', NULL, NULL, 20.000, 18.225, 45.00, 45.00, 45.00, 55, NULL, 1, 0.00, 4000.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 'new', NULL, 0, '2026-05-13 12:08:58', '2026-05-13 13:54:22', 0, 0, NULL, 0),
(283, 39, NULL, NULL, NULL, '20260513135356', 'Essential', '2026-05-13 13:53:00', 'booby', '8235196825', NULL, NULL, 'ssfb', NULL, 'Home', '847451', NULL, NULL, NULL, 'Supaul', 'Bihar', NULL, 'No', 'No', 'No', 'No', NULL, NULL, 5.000, 0.300, 15.00, 10.00, 10.00, 55, NULL, 1, 1000.00, 1000.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 'NEW', NULL, 0, '2026-05-13 13:54:37', '2026-05-14 02:19:16', 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fship_order_items`
--

CREATE TABLE `fship_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fship_order_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `shipping_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gift_wrap_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `transaction_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sku` varchar(255) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `product_image_url` text DEFAULT NULL,
  `qc_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`qc_json`)),
  `hsn_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fship_order_items`
--

INSERT INTO `fship_order_items` (`id`, `fship_order_id`, `product_name`, `quantity`, `unit_price`, `shipping_charge`, `gift_wrap_charge`, `transaction_fee`, `order_discount`, `sku`, `brand_name`, `product_image_url`, `qc_json`, `hsn_code`, `created_at`, `updated_at`) VALUES
(161, 141, 'healthcare', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-05 12:30:10', '2026-05-05 12:30:10'),
(162, 142, 'Medicine capsule', 1, 750.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-05 13:29:07', '2026-05-05 14:36:35'),
(163, 143, 'Medicine oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-05 13:32:39', '2026-05-05 13:32:39'),
(164, 144, 'Medicine Oil And Capsule', 1, 1050.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-05 13:46:18', '2026-05-05 13:46:18'),
(165, 145, 'medicine oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-05 13:52:27', '2026-05-05 13:52:27'),
(166, 146, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-05 13:54:27', '2026-05-05 13:54:27'),
(167, 147, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-05 14:19:16', '2026-05-05 14:19:16'),
(168, 148, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-05 14:21:28', '2026-05-05 15:31:43'),
(169, 149, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-05 14:53:41', '2026-05-05 14:53:41'),
(170, 150, 'healthcare', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 05:17:33', '2026-05-06 05:17:33'),
(171, 151, 'Sloane Good', 1, 4.00, 36.00, 52.00, 86.00, 84.00, 'Ipsa numquam libero', NULL, NULL, NULL, 'Veritatis tempore m', '2026-05-06 05:33:06', '2026-05-06 05:33:06'),
(172, 152, 'Healthcare', 1, 100.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 09:11:38', '2026-05-06 09:11:38'),
(173, 153, 'Healthcare', 1, 100.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 09:13:33', '2026-05-06 09:13:33'),
(174, 154, 'Healthcare', 1, 100.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 09:16:14', '2026-05-06 09:16:14'),
(175, 155, 'Healthcare', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 09:19:10', '2026-05-06 09:19:10'),
(176, 156, 'Francesca Shepard', 14, 35.00, 0.00, 0.00, 0.00, 0.00, 'jgjjf', NULL, NULL, NULL, 'hjgjfg', '2026-05-06 12:29:12', '2026-05-06 12:34:05'),
(177, 157, 'Colleen Reynolds', 9, 244.00, 0.00, 0.00, 0.00, 0.00, 'ghgf', NULL, NULL, NULL, 'higyu', '2026-05-06 12:47:57', '2026-05-06 12:48:38'),
(178, 158, 'Medicine Oil And Capsule', 1, 1.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 15:22:01', '2026-05-06 15:22:23'),
(179, 159, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 15:24:18', '2026-05-06 15:24:18'),
(180, 160, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 15:25:38', '2026-05-06 15:25:38'),
(181, 161, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 15:28:14', '2026-05-06 15:28:14'),
(182, 162, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 15:37:01', '2026-05-06 15:37:01'),
(183, 163, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 15:39:53', '2026-05-06 15:39:53'),
(184, 164, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 15:43:19', '2026-05-06 15:43:19'),
(185, 165, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 15:47:33', '2026-05-06 15:47:33'),
(186, 166, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 15:50:37', '2026-05-06 15:50:37'),
(187, 167, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-06 16:03:05', '2026-05-07 03:50:36'),
(189, 169, 'oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 03:58:23', '2026-05-07 03:58:23'),
(190, 170, 'healthcare', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 04:00:21', '2026-05-07 04:00:21'),
(191, 171, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 16:01:04', '2026-05-07 16:01:04'),
(192, 172, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 16:02:25', '2026-05-07 16:02:25'),
(193, 173, 'Medicine Oil And Capsule', 1, 800.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 16:03:44', '2026-05-07 16:03:44'),
(194, 174, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 16:08:14', '2026-05-07 16:08:14'),
(195, 175, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 16:09:27', '2026-05-07 16:09:27'),
(196, 176, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 16:10:38', '2026-05-07 16:11:07'),
(197, 177, 'Medicine Oil And Capsule', 1, 500.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 16:12:13', '2026-05-07 16:12:13'),
(198, 178, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 16:14:54', '2026-05-08 04:08:53'),
(199, 179, 'Medicine Oil And Capsule', 1, 999.99, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 16:16:12', '2026-05-07 16:16:12'),
(200, 180, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 16:20:02', '2026-05-08 06:28:23'),
(201, 181, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-07 16:26:13', '2026-05-07 16:26:13'),
(202, 182, 'nhnionji', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 04:58:36', '2026-05-08 04:58:36'),
(203, 183, 'gg', 12, 321.00, 0.00, 0.00, 0.00, 0.00, 'iuy', NULL, NULL, NULL, '87', '2026-05-08 06:15:24', '2026-05-08 06:15:24'),
(206, 186, 'hj', 3, 34.00, 0.00, 0.00, 0.00, 0.00, '545', NULL, NULL, NULL, 'hj', '2026-05-08 12:35:53', '2026-05-08 12:35:53'),
(207, 187, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 14:46:17', '2026-05-08 14:46:17'),
(208, 188, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 14:48:00', '2026-05-08 14:48:00'),
(209, 189, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 14:51:25', '2026-05-08 16:09:30'),
(210, 190, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 14:53:08', '2026-05-08 16:08:02'),
(211, 191, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 14:56:40', '2026-05-08 14:56:40'),
(212, 192, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 14:58:49', '2026-05-08 14:58:49'),
(213, 193, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:00:54', '2026-05-08 15:00:54'),
(214, 194, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:02:23', '2026-05-08 15:02:23'),
(215, 195, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:04:47', '2026-05-08 15:04:47'),
(216, 196, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:26:07', '2026-05-08 15:26:07'),
(217, 197, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:28:23', '2026-05-08 15:28:23'),
(218, 198, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:30:27', '2026-05-08 15:30:27'),
(219, 199, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:32:56', '2026-05-08 15:32:56'),
(220, 200, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:37:20', '2026-05-08 15:37:20'),
(221, 201, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:39:22', '2026-05-08 16:05:34'),
(222, 202, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:41:40', '2026-05-08 15:41:40'),
(223, 203, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:44:52', '2026-05-08 15:44:52'),
(224, 204, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:46:51', '2026-05-08 15:46:51'),
(225, 205, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:48:36', '2026-05-08 15:48:36'),
(226, 206, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:50:29', '2026-05-08 15:50:29'),
(227, 207, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-08 15:56:25', '2026-05-08 15:56:25'),
(228, 208, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 03:06:11', '2026-05-09 03:06:11'),
(229, 209, 'Medicine Oil And Capsule', 1, 500.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 14:03:57', '2026-05-09 14:41:34'),
(230, 210, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 14:10:56', '2026-05-09 14:10:56'),
(231, 211, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 14:16:23', '2026-05-09 14:16:23'),
(232, 212, 'Mens  Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 14:24:43', '2026-05-09 14:24:43'),
(233, 213, 'Boomax medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 14:33:11', '2026-05-09 14:46:48'),
(234, 214, 'V tigh Medicne  Oil', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 14:36:33', '2026-05-09 14:47:21'),
(235, 215, 'Mens Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 14:37:35', '2026-05-09 14:47:12'),
(236, 216, 'Breast wellness oil and capsule', 1, 750.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 14:54:43', '2026-05-09 14:54:43'),
(237, 217, 'breast oil and capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 14:56:47', '2026-05-09 14:56:47'),
(238, 218, 'breast oil and capsule', 1, 700.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 14:57:52', '2026-05-09 14:57:52'),
(239, 219, 'Medicine Oil And Capsule', 1, 1500.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 14:59:22', '2026-05-09 14:59:22'),
(240, 220, 'breast oil and capsule', 1, 700.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 15:00:33', '2026-05-09 15:00:33'),
(241, 221, 'breast  Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-09 15:01:40', '2026-05-09 15:01:40'),
(242, 222, 'healthcare', 1, 999.99, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 01:04:21', '2026-05-10 01:04:21'),
(243, 223, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:17:48', '2026-05-10 14:17:48'),
(244, 224, 'Medicine Oil And Capsule', 1, 800.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:20:24', '2026-05-10 14:20:24'),
(245, 225, 'mens wellness', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:23:21', '2026-05-10 14:23:21'),
(246, 226, 'medicine  Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:23:50', '2026-05-10 14:23:50'),
(247, 227, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:25:44', '2026-05-10 14:25:44'),
(248, 228, 'Medicine Oil And Capsule', 1, 800.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:28:24', '2026-05-10 14:28:24'),
(249, 229, 'Medicine Oil And Capsule', 1, 800.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:32:06', '2026-05-10 14:32:06'),
(250, 230, 'Medicine Oil And Capsule', 1, 800.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:37:06', '2026-05-10 14:37:06'),
(251, 231, 'Medicine Oil And Capsule', 1, 800.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:38:01', '2026-05-10 15:02:03'),
(252, 232, 'Medicine Oil And Capsule', 1, 600.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:39:45', '2026-05-10 14:39:45'),
(253, 233, 'Medicine Oil And Capsule', 1, 750.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:40:37', '2026-05-10 14:47:21'),
(254, 234, 'breast oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:41:30', '2026-05-10 14:41:30'),
(255, 235, 'Medicine Oil And Capsule', 1, 1250.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:42:38', '2026-05-10 14:42:38'),
(256, 236, 'oil and capsule', 1, 700.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:43:28', '2026-05-10 14:43:28'),
(257, 237, 'breast oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:45:49', '2026-05-10 14:45:49'),
(258, 238, 'breast oil and capsule', 1, 1300.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:47:06', '2026-05-10 14:47:06'),
(259, 239, 'breast oil and capsule', 1, 1500.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:49:27', '2026-05-10 14:49:27'),
(260, 240, 'breast oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:50:52', '2026-05-10 14:51:06'),
(261, 241, 'breast oil and capsule', 1, 1200.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:52:05', '2026-05-10 14:52:05'),
(262, 242, 'breast oil and capsule', 1, 999.99, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-10 14:56:22', '2026-05-10 14:56:22'),
(263, 243, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:29:21', '2026-05-11 15:29:21'),
(264, 244, 'Medicine Oil And Capsule', 1, 900.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:32:13', '2026-05-11 15:32:13'),
(265, 245, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:33:43', '2026-05-11 15:33:43'),
(266, 246, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:34:31', '2026-05-11 15:34:31'),
(267, 247, 'Medicine Oil And Capsule', 1, 1100.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:37:29', '2026-05-11 15:37:29'),
(268, 248, 'Medicine Oil And Capsule', 1, 1500.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:38:46', '2026-05-11 15:38:46'),
(269, 249, 'breast oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:39:51', '2026-05-11 15:39:51'),
(270, 250, 'breast oil and capsule', 1, 1200.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:40:47', '2026-05-11 15:40:47'),
(271, 251, 'breast oil and capsule', 1, 1500.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:41:44', '2026-05-11 15:41:44'),
(272, 252, 'Medicine Oil And Capsule', 1, 1200.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:42:38', '2026-05-11 15:42:38'),
(273, 253, 'breast oil and capsule', 1, 1350.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:43:38', '2026-05-11 15:43:38'),
(274, 254, 'breast oil and capsule', 1, 1200.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:45:00', '2026-05-11 15:45:00'),
(275, 255, 'Medicine Oil And Capsule', 1, 800.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-11 15:49:31', '2026-05-11 15:49:31'),
(276, 256, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-12 15:36:04', '2026-05-12 15:36:04'),
(277, 257, 'Medicine Oil And Capsule', 1, 1200.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-12 15:38:49', '2026-05-12 15:38:49'),
(278, 258, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-12 15:39:36', '2026-05-12 15:39:36'),
(279, 259, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-12 15:40:31', '2026-05-12 15:40:31'),
(280, 260, 'Medicine Oil And Capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-12 15:41:46', '2026-05-12 15:41:46'),
(281, 261, 'Medicine Oil And Capsule', 1, 1200.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-12 15:43:36', '2026-05-12 15:43:36'),
(282, 262, 'Medicine Oil And Capsule', 3, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-12 15:48:51', '2026-05-12 15:48:51'),
(283, 263, 'mens wellness', 3, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-12 15:50:03', '2026-05-12 15:50:03'),
(284, 264, 'shilajit', 1, 750.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-12 15:51:05', '2026-05-12 15:51:05'),
(285, 265, 'Medicine Oil And Capsule', 1, 1100.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-12 15:52:08', '2026-05-12 15:52:08'),
(286, 266, 'g', 121, 21.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 06:44:40', '2026-05-13 06:44:40'),
(287, 267, 'breast oil and capsule', 1, 1500.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:09:35', '2026-05-13 11:09:35'),
(288, 268, 'breast oil and capsule', 1, 1350.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:10:30', '2026-05-13 11:10:30'),
(289, 269, 'breast oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:11:33', '2026-05-13 11:11:33'),
(290, 270, 'breast oil and capsule', 1, 1350.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:12:27', '2026-05-13 11:12:27'),
(291, 271, 'breast oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:13:20', '2026-05-13 11:13:20'),
(292, 272, 'breast oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:14:23', '2026-05-13 11:14:23'),
(293, 273, 'breast oil and capsule', 1, 1200.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:15:28', '2026-05-13 11:15:28'),
(294, 274, 'breast oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:16:12', '2026-05-13 11:16:12'),
(295, 275, 'breast oil and capsule', 1, 1499.98, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:17:25', '2026-05-13 11:17:25'),
(296, 276, 'breast oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:19:11', '2026-05-13 11:19:11'),
(297, 277, 'weight gain capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:20:55', '2026-05-13 11:20:55'),
(298, 278, 'breast oil and capsule', 2, 2000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:21:51', '2026-05-13 11:22:02'),
(299, 279, 'breast oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:22:49', '2026-05-13 11:22:49'),
(300, 280, 'breast oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:24:49', '2026-05-13 11:24:49'),
(301, 281, 'breast oil and capsule', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 11:27:50', '2026-05-13 11:27:50'),
(302, 282, 'pen', 1, 4000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 12:08:58', '2026-05-13 12:08:58'),
(303, 283, 'gh', 1, 1000.00, 0.00, 0.00, 0.00, 0.00, 'NA', NULL, NULL, NULL, 'NA', '2026-05-13 13:54:37', '2026-05-14 02:19:16');

-- --------------------------------------------------------

--
-- Table structure for table `fship_reverse_orders`
--

CREATE TABLE `fship_reverse_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `forward_order_id` varchar(255) DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `consignee_name` varchar(255) NOT NULL,
  `original_waybill` varchar(255) NOT NULL,
  `reverse_waybill` varchar(255) DEFAULT NULL,
  `fship_api_order_id` varchar(255) DEFAULT NULL,
  `is_qc_required` tinyint(1) NOT NULL DEFAULT 0,
  `return_reason` varchar(255) DEFAULT NULL,
  `return_type` int(11) NOT NULL DEFAULT 0,
  `courier_name` varchar(255) DEFAULT NULL,
  `courier_id` int(11) DEFAULT NULL,
  `route_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Initiated',
  `tracking_number` varchar(255) DEFAULT NULL,
  `reverse_order_created_at` timestamp NULL DEFAULT NULL,
  `reverse_order_updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `consignee_phone` varchar(255) NOT NULL,
  `consignee_email` varchar(255) DEFAULT NULL,
  `pickup_address` text NOT NULL,
  `pickup_landmark` varchar(255) DEFAULT NULL,
  `pickup_address_type` varchar(255) NOT NULL DEFAULT 'Home',
  `pickup_pincode` varchar(10) NOT NULL,
  `pickup_city` varchar(255) NOT NULL,
  `pickup_state` varchar(255) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `order_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `extra_charges` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(15,2) NOT NULL,
  `cod_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_mode` varchar(255) NOT NULL DEFAULT 'COD',
  `shipment_weight` decimal(10,2) NOT NULL,
  `shipment_length` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipment_width` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipment_height` decimal(10,2) NOT NULL DEFAULT 0.00,
  `volumetric_weight` decimal(10,2) DEFAULT NULL,
  `picked_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancellation_reason` varchar(255) DEFAULT NULL,
  `api_request` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`api_request`)),
  `api_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`api_response`)),
  `is_valid` tinyint(1) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fship_reverse_order_items`
--

CREATE TABLE `fship_reverse_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reverse_order_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `product_category` varchar(255) DEFAULT NULL,
  `hsn_code` varchar(255) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `ean_no` varchar(255) DEFAULT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `imei` varchar(255) DEFAULT NULL,
  `is_fragile` tinyint(1) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `return_reason` varchar(255) DEFAULT NULL,
  `return_type` tinyint(4) NOT NULL DEFAULT 0,
  `qc_parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`qc_parameters`)),
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `kyc_details`
--

CREATE TABLE `kyc_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `verification_method` varchar(255) NOT NULL DEFAULT 'Express KYC',
  `status` enum('PENDING','VERIFIED','REJECTED') NOT NULL DEFAULT 'VERIFIED',
  `business_type` varchar(255) NOT NULL DEFAULT 'Individual',
  `pan_number` varchar(255) DEFAULT NULL,
  `aadhaar_number` varchar(255) NOT NULL,
  `user_photo` varchar(255) DEFAULT NULL,
  `pan_card_image` varchar(255) DEFAULT NULL,
  `aadhaar_card_image` varchar(255) DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kyc_details`
--

INSERT INTO `kyc_details` (`id`, `user_id`, `verification_method`, `status`, `business_type`, `pan_number`, `aadhaar_number`, `user_photo`, `pan_card_image`, `aadhaar_card_image`, `verified_at`) VALUES
(8, 36, 'Express KYC', 'VERIFIED', 'Individual', NULL, '3020 3350 6098', 'kyc/user_photos/vKioQCbjz0dJh8nwle9rdxq5WbEWJ2t1Yh8H2qBp.jpg', NULL, 'kyc/aadhaar_cards/ucL8qFrmUhuqQnYHb8eXtlUXvBr5gJKHBwpgSuNq.pdf', '2026-05-05 13:01:12'),
(9, 39, 'Express KYC', 'VERIFIED', 'Individual', 'HZBPK6987H', '5486 7827 0676', 'kyc/user_photos/SZnkdrzYTtuF20AMfOKSlRy3lBDSL7UAlU6UFU39.jpg', 'kyc/pan_cards/PcARJzYDF6lvy1D4VU89UcxoXFKFOScvtkMygYLw.jpg', 'kyc/aadhaar_cards/8cxuXi78i3ujlKTvt9uFxLYRr2hDb9SuM4X27npy.jpg', '2026-05-11 02:53:36');

-- --------------------------------------------------------

--
-- Table structure for table `label_settings`
--

CREATE TABLE `label_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `printer` varchar(255) NOT NULL DEFAULT 'A4 Size',
  `template` varchar(255) NOT NULL DEFAULT 'Standard A4',
  `show_signature` tinyint(1) NOT NULL DEFAULT 0,
  `template_settings` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `label_settings`
--

INSERT INTO `label_settings` (`id`, `user_id`, `display_name`, `printer`, `template`, `show_signature`, `template_settings`, `created_at`, `updated_at`) VALUES
(3, 36, 'Nikunj Gogadani', 'A4 Size', 'Thermal 4x4', 0, '{\"consignee\":true,\"products\":true,\"return_address\":false,\"warehouse_contact\":false,\"seller_contact\":false,\"gst\":false,\"gst_breakup\":false,\"order_id\":true,\"sku\":true,\"amount\":true,\"product_name\":true}', '2026-05-05 13:02:01', '2026-05-13 04:43:10'),
(4, 41, NULL, 'A4 Size', 'Standard A4', 0, '{\"consignee\":true,\"products\":true,\"return_address\":true,\"warehouse_contact\":true,\"seller_contact\":true,\"gst\":true,\"gst_breakup\":true,\"order_id\":true,\"sku\":true,\"amount\":true,\"product_name\":true}', '2026-05-06 12:35:21', '2026-05-06 12:35:21');

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
(4, '2026_03_10_080315_create_wallets_table', 2),
(5, '2026_03_11_045646_company_profile', 3),
(6, '2026_03_11_110243_create_kyc_details_table', 4),
(7, '2026_03_12_044755_create_seller_agreement_acceptances_table', 5),
(8, '2026_03_12_064600_add_suspended_at_to_users_table', 6),
(9, '2026_03_14_055532_create_agreements_table', 7),
(10, '2026_03_14_063331_add_accepted_by_ip_to_agreements_table', 7),
(11, '2026_03_14_075029_update_agreements_table_add_acceptance_columns', 7),
(12, '2026_03_14_080958_make_uploaded_by_nullable_in_agreements_table', 7),
(13, '2026_03_14_102157_remove_acceptance_columns_from_agreements_table', 7),
(14, '2026_03_14_103622_create_agreement_acceptances_table', 7),
(15, '2026_03_14_121100_create_bank_details_table', 7),
(16, '2026_03_16_071202_create_pickup_addresses_table', 7),
(17, '2026_03_16_111905_create_vendor_addresses_table', 7),
(18, '2026_03_16_112003_create_rto_addresses_table', 7),
(19, '2026_03_17_044747_create_fship_orders_tables', 7),
(20, '2026_03_17_045418_create_fship_order_items_table', 7),
(21, '2026_03_17_045606_create_fship_order_tracking_logs_table', 7),
(22, '2026_03_23_125744_rename_fship_warehouse_id_to_pick_address_id_in_pickup_addresses_table', 8),
(23, '2026_03_24_043132_update_fship_orders_table_for_api_compatibility', 9),
(24, '2026_03_24_065504_add_customer_address_type_to_fship_orders_table', 10),
(25, '2026_03_24_095028_add_missing_fields_to_fship_orders', 11),
(26, '2026_03_24_095828_add_charges_to_fship_order_items', 11),
(27, '2026_03_24_125856_add_fship_serviceability_fields_to_fship_orders', 12),
(28, '2026_03_25_050856_update_pickup_addresses_table_for_fship', 13),
(29, '2026_03_25_061504_add_missing_columns_to_rto_addresses_table', 14),
(30, '2026_03_25_061849_add_missing_columns_to_vendor_addresses_table', 15),
(31, '2026_03_25_062233_add_missing_columns_to_rto_addresses_table', 16),
(32, '2026_03_25_100915_add_pincode_details_to_fship_orders_table', 17),
(33, '2026_03_25_114839_create_fship_order_statuses_table', 18),
(34, '2026_03_26_102720_create_shipping_rates_mini_table', 19),
(35, '2026_03_27_173218_create_shipping_rates_mini_table', 20),
(36, '2026_03_27_203137_add_deleted_at_to_shipping_rates_mini_table', 21),
(37, '2026_03_28_045706_add_weight_2kg_to_shipping_rates_mini_table', 22),
(38, '2026_03_28_045850_add_weight__to_shipping_rates_mini_table', 23),
(39, '2026_03_31_080040_create_shipping_labels_table', 24),
(40, '2026_03_31_094648_add_create_shipping_labels_table', 25),
(41, '2026_04_02_074953_add_courier_logo_url_to_shipping_rates_mini_table', 26),
(42, '2026_04_02_081010_change_courier_logo_url_to_longtext_in_shipping_rates_mini_table', 27),
(43, '2026_04_02_113425_update_shipping_rates_remove_courier_columns', 28),
(44, '2026_04_02_113536_add_foreign_key_to_shipping_rates', 29),
(45, '2026_04_02_113621_create_couriers_table', 29),
(46, '2026_04_02_115016_add_fk_to_shipping_rates_mini', 30),
(47, '2026_04_02_115333_final_optimize_shipping_rates_table', 31),
(48, '2026_04_03_113247_change_logo_url_to_text_in_couriers_table', 32),
(49, '2026_04_04_103834_change_logo_url_to_text_in_couriers_table', 33),
(50, '2026_04_05_152004_create_wallet_transactions_table', 34),
(51, '2026_04_05_154039_add_wallet_tracking_to_fship_orders', 34),
(52, '2026_04_06_111919_create_label_settings_table', 35),
(53, '2026_04_07_093312_add_booking_columns_to_fship_orders_table', 36),
(54, '2026_04_07_095727_add_billing_and_booking_columns_to_fship_orders_table', 37),
(55, '2026_04_07_100234_fix_fship_orders_schema_columns', 38),
(56, '2026_04_09_045358_shipment_documents', 39),
(57, '2026_04_10_133823_create_tickets_table', 40),
(58, '2026_04_10_181051_add_dashboard_fields_to_shipment_documents', 41),
(59, '2026_04_12_004517_fship_reverse_orders', 42),
(60, '2026_04_12_011212_add_brand_name_and_qc_fields_to_fship_order_items', 43),
(61, '2026_04_12_011449_add_reverse_flag_to_fship_orders', 44),
(62, '2026_04_12_110248_add_missing_fields_to_fship_reverse_orders', 45),
(63, '2026_04_12_110328_create_fship_reverse_order_items_table', 46),
(64, '2026_04_13_130117_create_wallet_recharges_table', 47),
(65, '2026_04_14_073714__add_profile_fields_to_users_table', 48),
(66, '2026_04_14_095312_create_ndr_management_table', 49),
(67, '2026_04_14_095417_creat_ndr_product_details_table', 49),
(68, '2026_04_14_095556_create_ndr_tracking_history_logs_table', 49),
(69, '2026_04_16_102330_add_tags_to_fship_orders_table', 50),
(72, '2026_04_18_063536_create_rapidshyp_rto_addresses_table', 53),
(76, '2026_04_18_065412_create_rapidshyp_warehouses_table', 54),
(80, '2026_04_20_055825_create_rapidshyp_b2c_orders_table', 55),
(81, '2024_04_20_000000_create_rapidshyp_serviceability_logs_table', 56),
(82, '2026_04_22_104013_create_rapidshyp_b2c_order_items_table', 56),
(83, '2026_04_22_105621_add_rapidshyp_shield_to_b2c_orders_table', 57),
(84, '2026_04_23_090000_add_rto_location_name_to_rapidshyp_warehouses_table', 58),
(85, '2026_04_27_105315_increase_serviceability_columns_length_in_fship_orders', 59),
(86, '2026_04_28_101404_add_expected_delivery_date_to_fship_orders', 60),
(87, '2026_04_28_200500_add_source_to_wallet_transactions', 61),
(88, '2026_04_29_080003_add_pickup_fields_to_shipment_documents', 61),
(89, '2026_04_30_131336_make_pan_fields_nullable_in_kyc_table', 61),
(90, '2026_05_01_074951_add_fship_courier_id_to_couriers_table', 62),
(91, '2026_05_01_090357_add_failure_reason_to_wallet_recharges_table', 63),
(92, '2026_05_05_110604_create_rapidshyp_rates_table', 64),
(93, '2026_05_06_070756_make_fship_order_id_nullable', 64),
(94, '2026_05_06_071435_fix_shipping_labels_nullable', 64),
(95, '2026_05_09_082912_create_cod_remittance_payments_table', 64),
(96, '2026_05_09_083148_add_remittance_fields_to_fship_orders_table', 64),
(97, '2026_05_11_061608_add_bank_fields_to_cod_remittance_payments_table', 64),
(98, '2026_05_11_063349_add_waybill_to_cod_remittance_payments_table', 64),
(99, '2026_05_11_095640_create_ndr_logs_table', 65),
(100, '2026_05_11_100341_add_order_id_to_ndr_logs_table', 66),
(101, '2026_05_15_075314_add_user_code_to_users_table', 67);

-- --------------------------------------------------------

--
-- Table structure for table `ndr_logs`
--

CREATE TABLE `ndr_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ndr_management`
--

CREATE TABLE `ndr_management` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `api_order_id` bigint(20) UNSIGNED NOT NULL,
  `waybill_number` varchar(255) DEFAULT NULL,
  `last_action_taken` enum('re-attempt','change-address','change-phone','rto') DEFAULT NULL,
  `reattempt_date` datetime DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `mobilenumber` varchar(255) DEFAULT NULL,
  `complete_address` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `api_request_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`api_request_payload`)),
  `api_response_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`api_response_data`)),
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ndr_management`
--

INSERT INTO `ndr_management` (`id`, `api_order_id`, `waybill_number`, `last_action_taken`, `reattempt_date`, `contact_name`, `mobilenumber`, `complete_address`, `remarks`, `api_request_payload`, `api_response_data`, `status`, `created_at`, `updated_at`) VALUES
(1, 1778044268, '77789707774', 're-attempt', '2026-05-09 00:00:00', 'Guddu Kumar', '7989337146', 'Near - Shiv mandir , Vill  - Pothiya , Dist- Banka , Bihar', 're attepmt', '{\"apiorderid\":1778044268,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-09\",\"contact_name\":\"Guddu Kumar\",\"complete_address\":\"Near - Shiv mandir , Vill  - Pothiya , Dist- Banka , Bihar\",\"landmark\":\"\",\"mobilenumber\":\"7989337146\",\"remarks\":\"re attepmt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-09 12:01:50', '2026-05-09 12:01:50'),
(2, 1778083445, '77790553190', 're-attempt', '2026-05-12 00:00:00', 'Priya pandit', '8532079547', 'Near - Sudheer nursing home , Badaun , krishna puri , Mathura , uttar pradesh', 'Please deliver', '{\"apiorderid\":1778083445,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-12\",\"contact_name\":\"Priya pandit\",\"complete_address\":\"Near - Sudheer nursing home , Badaun , krishna puri , Mathura , uttar pradesh\",\"landmark\":\"\",\"mobilenumber\":\"8532079547\",\"remarks\":\"Please deliver\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-11 09:08:22', '2026-05-11 09:08:22'),
(3, 1778214086, '77792076213', 're-attempt', '2026-05-12 00:00:00', 'Khushbu', '6203499441', 'Near - st.joseph school  , Teliya Pokhar , Begusarai , Bihar', 'Reattempt', '{\"apiorderid\":1778214086,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-12\",\"contact_name\":\"Khushbu\",\"complete_address\":\"Near - st.joseph school  , Teliya Pokhar , Begusarai , Bihar\",\"landmark\":\"\",\"mobilenumber\":\"6203499441\",\"remarks\":\"Reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-11 09:09:01', '2026-05-11 09:09:01'),
(4, 1778125164, '77790727663', 're-attempt', '2026-05-11 00:00:00', 'Sameer', '9870619521', 'Near - Kirana store  ,  Bijnor ,  Dhampur  ,  Uttar Pradesh 246761', 'Near - Kirana store', '{\"apiorderid\":1778125164,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-11\",\"contact_name\":\"Sameer\",\"complete_address\":\"Near - Kirana store  ,  Bijnor ,  Dhampur  ,  Uttar Pradesh 246761\",\"landmark\":\"\",\"mobilenumber\":\"9870619521\",\"remarks\":\"Near - Kirana store\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-11 12:22:03', '2026-05-11 12:22:03'),
(5, 1778125154, '77790727556', 're-attempt', '2026-05-12 00:00:00', 'Manoj Kumar', '9664154105', 'Near - Bus stand , Pilibanga , Hanumangarh ,Rajasthan', 'Reattempt', '{\"apiorderid\":1778125154,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-12\",\"contact_name\":\"Manoj Kumar\",\"complete_address\":\"Near - Bus stand , Pilibanga , Hanumangarh ,Rajasthan\",\"landmark\":\"\",\"mobilenumber\":\"9664154105\",\"remarks\":\"Reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-11 12:25:15', '2026-05-11 12:25:15'),
(6, 1778125187, '77790727980', 're-attempt', '2026-05-12 00:00:00', 'Sonam', '7988344149', 'Near -Tej Colony ,  Pahadii Mohhala   , Rohtak , Haryana', 're attemept', '{\"apiorderid\":1778125187,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-12\",\"contact_name\":\"Sonam\",\"complete_address\":\"Near -Tej Colony ,  Pahadii Mohhala   , Rohtak , Haryana\",\"landmark\":\"Samshan ghat\",\"mobilenumber\":\"7988344149\",\"remarks\":\"re attemept\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-11 13:19:34', '2026-05-11 13:19:34'),
(7, 1778125233, '77790728702', 're-attempt', '2026-05-13 00:00:00', 'Saikh afsana sameer', '9023377852', 'H-5 405 A-6, Ews awas kosad amroli  , Town kosad , district Surat , gujrat', 'reattempt', '{\"apiorderid\":1778125233,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-13\",\"contact_name\":\"Saikh afsana sameer\",\"complete_address\":\"H-5 405 A-6, Ews awas kosad amroli  , Town kosad , district Surat , gujrat\",\"landmark\":\"\",\"mobilenumber\":\"9023377852\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-11 13:19:50', '2026-05-11 13:19:50'),
(8, 1778044256, '77789705976', 're-attempt', '2026-05-13 00:00:00', 'Harish', '9917241696', 'Near - Chamunda devi mandir  , Rudrapur shiv nagar , Udham Singh Nagar ,Uttarakhand', 're attempt', '{\"apiorderid\":1778044256,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-13\",\"contact_name\":\"Harish\",\"complete_address\":\"Near - Chamunda devi mandir  , Rudrapur shiv nagar , Udham Singh Nagar ,Uttarakhand\",\"landmark\":\"\",\"mobilenumber\":\"9917241696\",\"remarks\":\"re attempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-11 13:20:03', '2026-05-11 13:20:03'),
(9, 1778125176, '77790727840', 're-attempt', '2026-05-12 00:00:00', 'Saikh Rafiq', '7039233375', 'Near - vithal mandir , Ganga Nagar, Pimprichinchwad, Akurdi, Pune-411035, Maharashtra', 'Reattempt', '{\"apiorderid\":1778125176,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-12\",\"contact_name\":\"Saikh Rafiq\",\"complete_address\":\"Near - vithal mandir , Ganga Nagar, Pimprichinchwad, Akurdi, Pune-411035, Maharashtra\",\"landmark\":\"\",\"mobilenumber\":\"7039233375\",\"remarks\":\"Reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-11 16:25:21', '2026-05-11 16:25:21'),
(10, 1778213095, '77792019911', 're-attempt', '2026-05-13 00:00:00', 'Rahul', '9876939593', 'Guru nanak avenue , firozpur , punjab', 'delivery boy not calling', '{\"apiorderid\":1778213095,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-13\",\"contact_name\":\"Rahul\",\"complete_address\":\"Guru nanak avenue , firozpur , punjab\",\"landmark\":\"Prachin Shri Shivala temple\",\"mobilenumber\":\"9876939593\",\"remarks\":\"delivery boy not calling\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-12 06:52:50', '2026-05-12 06:52:50'),
(11, 1778255852, '77793101562', 're-attempt', '2026-05-13 00:00:00', 'aman patel', '9058481657', 'mudiya chaudhary near kirnaa store bareilli , uttar pradesh', 'please reattempt this order delivery boy not calling customer', '{\"apiorderid\":1778255852,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-13\",\"contact_name\":\"aman patel\",\"complete_address\":\"mudiya chaudhary near kirnaa store bareilli , uttar pradesh\",\"landmark\":\"\",\"mobilenumber\":\"9058481657\",\"remarks\":\"please reattempt this order delivery boy not calling customer\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-12 07:25:10', '2026-05-12 07:25:10'),
(12, 1778044281, '77789710132', 're-attempt', '2026-05-13 00:00:00', 'Neha', '7269068887', 'Near - Dooda colony , Para narpat kheda , Lucknow , uttar pradesh', 'please reattempt this order . this order is  completetely unprofessional', '{\"apiorderid\":1778044281,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-13\",\"contact_name\":\"Neha\",\"complete_address\":\"Near - Dooda colony , Para narpat kheda , Lucknow , uttar pradesh\",\"landmark\":\"\",\"mobilenumber\":\"7269068887\",\"remarks\":\"please reattempt this order . this order is  completetely unprofessional\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-12 12:00:36', '2026-05-12 12:00:36'),
(13, 1778126314, '77790752771', 're-attempt', '2026-05-13 00:00:00', 'muskan', '9006207756', 'H.no 26 Nagar parisad road , haridwar kabir dham ashram , dehradun', 'please reattempt this order . this order is  completetely unprofessional', '{\"apiorderid\":1778126314,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-13\",\"contact_name\":\"muskan\",\"complete_address\":\"H.no 26 Nagar parisad road , haridwar kabir dham ashram , dehradun\",\"landmark\":\"\",\"mobilenumber\":\"9006207756\",\"remarks\":\"please reattempt this order . this order is  completetely unprofessional\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-12 12:00:50', '2026-05-12 12:00:50'),
(14, 1778213016, '77792017903', 're-attempt', '2026-05-13 00:00:00', 'Pradeep', '6378095124', 'Rahul Medical Store ,  hanumaan garh  , Rajasthan', 'please reattempt this order . this order is  completetely unprofessional', '{\"apiorderid\":1778213016,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-13\",\"contact_name\":\"Pradeep\",\"complete_address\":\"Rahul Medical Store ,  hanumaan garh  , Rajasthan\",\"landmark\":\"\",\"mobilenumber\":\"6378095124\",\"remarks\":\"please reattempt this order . this order is  completetely unprofessional\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-12 12:01:05', '2026-05-12 12:01:05'),
(15, 1778255866, '77793101595', 're-attempt', '2026-05-13 00:00:00', 'arun', '7983417081', 'near trimurti chauraha , sanjay nagar , Breilley , uttar pradesh', 'please reattempt this order . this order is  completetely unprofessional', '{\"apiorderid\":1778255866,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-13\",\"contact_name\":\"arun\",\"complete_address\":\"near trimurti chauraha , sanjay nagar , Breilley , uttar pradesh\",\"landmark\":\"\",\"mobilenumber\":\"7983417081\",\"remarks\":\"please reattempt this order . this order is  completetely unprofessional\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-12 12:01:16', '2026-05-12 12:01:16'),
(16, 1778255896, '77793101691', 're-attempt', '2026-05-13 00:00:00', 'savita kumari', '9149764308', 'gomti nagar , lucknow , uttar pradesh', 'please reattempt this order . this order is  completetely unprofessional', '{\"apiorderid\":1778255896,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-13\",\"contact_name\":\"savita kumari\",\"complete_address\":\"gomti nagar , lucknow , uttar pradesh\",\"landmark\":\"\",\"mobilenumber\":\"9149764308\",\"remarks\":\"please reattempt this order . this order is  completetely unprofessional\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-12 12:01:27', '2026-05-12 12:01:27'),
(17, 1778256579, '37355837634121', 're-attempt', '2026-05-13 00:00:00', 'Nirmal Shrama', '9779853697', 'near - Middle School , Village - Naila , Saharsa , Bihar', 'please reattempt this order . this order is  completetely unprofessional', '{\"apiorderid\":1778256579,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-13\",\"contact_name\":\"Nirmal Shrama\",\"complete_address\":\"near - Middle School , Village - Naila , Saharsa , Bihar\",\"landmark\":\"\",\"mobilenumber\":\"9779853697\",\"remarks\":\"please reattempt this order . this order is  completetely unprofessional\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-12 12:01:37', '2026-05-12 12:01:37'),
(18, 1778256129, '37355837634014', 're-attempt', '2026-05-14 00:00:00', 'seema', '8404805992', 'near Veersa Nagar Purbish Jamshedpur jharkhand 831019', 'reattempt this order', '{\"apiorderid\":1778256129,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-14\",\"contact_name\":\"seema\",\"complete_address\":\"near Veersa Nagar Purbish Jamshedpur jharkhand 831019\",\"landmark\":\"\",\"mobilenumber\":\"8404805992\",\"remarks\":\"reattempt this order\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-13 04:50:06', '2026-05-13 04:50:06'),
(19, 1778256595, '77793104476', 're-attempt', '2026-05-14 00:00:00', 'Rubi', '7678416621', 'Near - Pani tanki , Gali No- B1 ,  Gulawati , bulandshahr ,', 'reattempt', '{\"apiorderid\":1778256595,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-14\",\"contact_name\":\"Rubi\",\"complete_address\":\"Near - Pani tanki , Gali No- B1 ,  Gulawati , bulandshahr ,\",\"landmark\":\"\",\"mobilenumber\":\"7678416621\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-14 01:27:45', '2026-05-14 01:27:45'),
(20, 1778125202, '77790728153', 're-attempt', '2026-05-15 00:00:00', 'Sandhya', '9389904213', 'Near - mandir ,  bhardwaj chauk , Dehradun bhardwaj chauk', 'reattempt', '{\"apiorderid\":1778125202,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-15\",\"contact_name\":\"Sandhya\",\"complete_address\":\"Near - mandir ,  bhardwaj chauk , Dehradun bhardwaj chauk\",\"landmark\":\"\",\"mobilenumber\":\"9389904213\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-14 01:28:20', '2026-05-14 01:28:20'),
(21, 1778044424, '37355837525212', 're-attempt', '2026-05-15 00:00:00', 'Aariya ali Qureshi', '9078091551', 'Near By Shri Baba Shyam Mandir,  Town- Bhatli , Dist - Bargarh ,Bargarh (Odisha)', 'reattempt', '{\"apiorderid\":1778044424,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-15\",\"contact_name\":\"Aariya ali Qureshi\",\"complete_address\":\"Near By Shri Baba Shyam Mandir,  Town- Bhatli , Dist - Bargarh ,Bargarh (Odisha)\",\"landmark\":\"\",\"mobilenumber\":\"9078091551\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-14 01:28:48', '2026-05-14 01:28:48'),
(22, 1778256369, '77793103662', 're-attempt', '2026-05-15 00:00:00', 'harish', '7975154163', 'chaar minar kai pass , Hyderabad', 'reattempt', '{\"apiorderid\":1778256369,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-15\",\"contact_name\":\"harish\",\"complete_address\":\"chaar minar kai pass , Hyderabad\",\"landmark\":\"\",\"mobilenumber\":\"7975154163\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-14 01:29:23', '2026-05-14 01:29:23'),
(23, 1778256605, '77793104675', 're-attempt', '2026-05-15 00:00:00', 'manoj yadav', '9199686095', 'Village - Kaptanganj , dist - kushinagar , state - uttar pradesh', 'reattempt', '{\"apiorderid\":1778256605,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-15\",\"contact_name\":\"manoj yadav\",\"complete_address\":\"Village - Kaptanganj , dist - kushinagar , state - uttar pradesh\",\"landmark\":\"\",\"mobilenumber\":\"9199686095\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-14 01:29:34', '2026-05-14 01:29:34'),
(24, 1778338964, '77794325232', 're-attempt', '2026-05-15 00:00:00', 'Rajesh singh', '8539046356', 'Ward no. 3 hauzpur village post hauzpur distic vaishali', 'reattempt', '{\"apiorderid\":1778338964,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-15\",\"contact_name\":\"Rajesh singh\",\"complete_address\":\"Ward no. 3 hauzpur village post hauzpur distic vaishali\",\"landmark\":\"Kalyaanpur school\",\"mobilenumber\":\"8539046356\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-14 01:29:45', '2026-05-14 01:29:45'),
(25, 1778425153, '37355837687730', 're-attempt', '2026-05-15 00:00:00', 'Varsha', '7541872751', 'dehariya , Pratap nagar , Katihar bihar', 'uiy', '{\"apiorderid\":1778425153,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-15\",\"contact_name\":\"Varsha\",\"complete_address\":\"dehariya , Pratap nagar , Katihar bihar\",\"landmark\":\"\",\"mobilenumber\":\"7541872751\",\"remarks\":\"uiy\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 07:04:44', '2026-05-15 07:04:44'),
(26, 1778680673, '77799148604', 're-attempt', '2026-05-15 00:00:00', 'Avadhesh kumar', '7488632041', 'Avadhesh kumar telhara naland bihar', 'vxvx', '{\"apiorderid\":1778680673,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-15\",\"contact_name\":\"Avadhesh kumar\",\"complete_address\":\"Avadhesh kumar telhara naland bihar\",\"landmark\":\"Near by thada mandir\",\"mobilenumber\":\"7488632041\",\"remarks\":\"vxvx\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 07:22:45', '2026-05-15 07:22:45'),
(27, 1778256393, '369197820427', 're-attempt', '2026-05-16 00:00:00', 'lokesh kumar', '8824330054', 'Near - government school , Albar , Kilpur , Kheda nagar  , 301409', 'reattempt', '{\"apiorderid\":1778256393,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"lokesh kumar\",\"complete_address\":\"Near - government school , Albar , Kilpur , Kheda nagar  , 301409\",\"landmark\":\"\",\"mobilenumber\":\"8824330054\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 08:39:55', '2026-05-15 08:39:55'),
(28, 1778256419, '37355837634095', 're-attempt', '2026-05-16 00:00:00', 'saif', '7617807287', 'Zubair Chauraha in Tanda,Sakarwal ,  Ambedkar Nagar, Uttar Pradesh, is 224190', 'reattempt', '{\"apiorderid\":1778256419,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"saif\",\"complete_address\":\"Zubair Chauraha in Tanda,Sakarwal ,  Ambedkar Nagar, Uttar Pradesh, is 224190\",\"landmark\":\"\",\"mobilenumber\":\"7617807287\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:12:01', '2026-05-15 13:12:01'),
(29, 1778255920, '37355837633970', 're-attempt', '2026-05-16 00:00:00', 'nurulla', '7860818583', 'bhushii , chauraha , gonda ,uttar pradesh', 'reattempt', '{\"apiorderid\":1778255920,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"nurulla\",\"complete_address\":\"bhushii , chauraha , gonda ,uttar pradesh\",\"landmark\":\"\",\"mobilenumber\":\"7860818583\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:12:14', '2026-05-15 13:12:14'),
(30, 1778339017, '77794325571', 're-attempt', '2026-05-16 00:00:00', 'megha', '7535822260', 'Agarwal dharamsala bada bazar , mata wali gali , city - Shikhoabad ,dist - firozabad , uttar pradesh ,   283135 ,', 'reattempt', '{\"apiorderid\":1778339017,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"megha\",\"complete_address\":\"Agarwal dharamsala bada bazar , mata wali gali , city - Shikhoabad ,dist - firozabad , uttar pradesh ,   283135 ,\",\"landmark\":\"\",\"mobilenumber\":\"7535822260\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:12:28', '2026-05-15 13:12:28'),
(31, 1778339007, '77794325556', 're-attempt', '2026-05-16 00:00:00', 'megha', '7535822260', 'Agarwal dharamsala bada bazar , mata wali gali , city - Shikhoabad ,dist - firozabad , uttar pradesh ,   283135 ,', 'reattempt', '{\"apiorderid\":1778339007,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"megha\",\"complete_address\":\"Agarwal dharamsala bada bazar , mata wali gali , city - Shikhoabad ,dist - firozabad , uttar pradesh ,   283135 ,\",\"landmark\":\"\",\"mobilenumber\":\"7535822260\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:12:40', '2026-05-15 13:12:40'),
(32, 1778680653, '77799148350', 're-attempt', '2026-05-16 00:00:00', 'Poonam', '8434261491', '70 feet road pakri anishabad patna', 'reattempt', '{\"apiorderid\":1778680653,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"Poonam\",\"complete_address\":\"70 feet road pakri anishabad patna\",\"landmark\":\"Near by radha krishna mandir\",\"mobilenumber\":\"8434261491\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:12:53', '2026-05-15 13:12:53'),
(33, 1778514812, '37355837750774', 're-attempt', '2026-05-16 00:00:00', 'Nikhil Kumar', '9470209433', 'Near- shiv mandir , barmasia ,   katihar  , Bihar', 'reattempt', '{\"apiorderid\":1778514812,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"Nikhil Kumar\",\"complete_address\":\"Near- shiv mandir , barmasia ,   katihar  , Bihar\",\"landmark\":\"\",\"mobilenumber\":\"9470209433\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:13:10', '2026-05-15 13:13:10'),
(34, 1778256407, '37355837634084', 're-attempt', '2026-05-16 00:00:00', 'vishal sharma', '9780902485', 'Hari Govind nagar , pathan cot By bass , Jalandhar , punjab 144012', 'reattempt', '{\"apiorderid\":1778256407,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"vishal sharma\",\"complete_address\":\"Hari Govind nagar , pathan cot By bass , Jalandhar , punjab 144012\",\"landmark\":\"\",\"mobilenumber\":\"9780902485\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:13:23', '2026-05-15 13:13:23'),
(35, 1778256211, '77793102936', 're-attempt', '2026-05-16 00:00:00', 'Rahul Patel Pooja patel', '7326093765', 'Near  Jitali medical store  , GIDC , Ankleshwar , Room  no 123 , gujarat', 'reattempt', '{\"apiorderid\":1778256211,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"Rahul Patel Pooja patel\",\"complete_address\":\"Near  Jitali medical store  , GIDC , Ankleshwar , Room  no 123 , gujarat\",\"landmark\":\"\",\"mobilenumber\":\"7326093765\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:13:36', '2026-05-15 13:13:36'),
(36, 1778255908, '37355837633966', 're-attempt', '2026-05-16 00:00:00', 'ritika', '9872410156', 'Near Verma Market, Ghanaur, ghanaur , 140702 , punjab', 'reattempt', '{\"apiorderid\":1778255908,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"ritika\",\"complete_address\":\"Near Verma Market, Ghanaur, ghanaur , 140702 , punjab\",\"landmark\":\"\",\"mobilenumber\":\"9872410156\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:13:47', '2026-05-15 13:13:47'),
(37, 1778605149, '77798022330', 're-attempt', '2026-05-16 00:00:00', 'Samim alam', '9065075754', 'Patliputra Station Rd, shivaji Nagar Patna, Bihar 800014', 'reattempt', '{\"apiorderid\":1778605149,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"Samim alam\",\"complete_address\":\"Patliputra Station Rd, shivaji Nagar Patna, Bihar 800014\",\"landmark\":\"Shivaji Nagar\",\"mobilenumber\":\"9065075754\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:14:02', '2026-05-15 13:14:02'),
(38, 1778425092, '37355837687704', 're-attempt', '2026-05-16 00:00:00', 'Rahul', '9872472254', 'Ward no. 4 soni market purniya jila bihar', 'reattempt', '{\"apiorderid\":1778425092,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"Rahul\",\"complete_address\":\"Ward no. 4 soni market purniya jila bihar\",\"landmark\":\"Near by government school\",\"mobilenumber\":\"9872472254\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:14:15', '2026-05-15 13:14:15'),
(39, 1778256148, '77793102612', 're-attempt', '2026-05-16 00:00:00', 'rahul', '9693057017', 'Bhagwan Talkies, Indra Puri, Civil Lines, MG Road, Agra, Uttar Pradesh', 'reattempt', '{\"apiorderid\":1778256148,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"rahul\",\"complete_address\":\"Bhagwan Talkies, Indra Puri, Civil Lines, MG Road, Agra, Uttar Pradesh\",\"landmark\":\"\",\"mobilenumber\":\"9693057017\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:14:30', '2026-05-15 13:14:30'),
(40, 1778605173, '77798022433', 're-attempt', '2026-05-16 00:00:00', 'Samim alam', '9065075754', 'Patliputra Station Rd, shivaji Nagar Patna, Bihar 800014', 'reattempt', '{\"apiorderid\":1778605173,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"Samim alam\",\"complete_address\":\"Patliputra Station Rd, shivaji Nagar Patna, Bihar 800014\",\"landmark\":\"\",\"mobilenumber\":\"9065075754\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:14:50', '2026-05-15 13:14:50'),
(41, 1778605161, '77798022363', 're-attempt', '2026-05-16 00:00:00', 'Samim alam', '9065075754', 'Patliputra Station Rd, shivaji Nagar Patna, Bihar 800014', 'reattempt', '{\"apiorderid\":1778605161,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-16\",\"contact_name\":\"Samim alam\",\"complete_address\":\"Patliputra Station Rd, shivaji Nagar Patna, Bihar 800014\",\"landmark\":\"Shivaji Nagar\",\"mobilenumber\":\"9065075754\",\"remarks\":\"reattempt\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-15 13:15:01', '2026-05-15 13:15:01'),
(42, 1778514635, '77796751502', 're-attempt', '2026-05-17 00:00:00', 'Aasih parveen', '8240424647', 'Hathiyara sharif khayal purva para distic parganas west Bengal', 'REATTEMPT', '{\"apiorderid\":1778514635,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-17\",\"contact_name\":\"Aasih parveen\",\"complete_address\":\"Hathiyara sharif khayal purva para distic parganas west Bengal\",\"landmark\":\"\",\"mobilenumber\":\"8240424647\",\"remarks\":\"REATTEMPT\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-16 03:58:11', '2026-05-16 03:58:11'),
(43, 1778424995, '77795000846', 're-attempt', '2026-05-17 00:00:00', 'Rajni', '9634194346', 'Jila aligarh post beshwa tehsil eklaas village kadli eklaas bazar mathura Road', 'REATTEMPT', '{\"apiorderid\":1778424995,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-17\",\"contact_name\":\"Rajni\",\"complete_address\":\"Jila aligarh post beshwa tehsil eklaas village kadli eklaas bazar mathura Road\",\"landmark\":\"Near by shiv mandir\",\"mobilenumber\":\"9634194346\",\"remarks\":\"REATTEMPT\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-16 03:58:30', '2026-05-16 03:58:30'),
(44, 1778338998, '77794325545', 're-attempt', '2026-05-17 00:00:00', 'Sangeeta', '9634194346', 'Village bichoda mathura road eklaas bazaar post bheswa jila aligarh', 'REATTEMPT', '{\"apiorderid\":1778338998,\"action\":\"re-attempt\",\"reattempt_date\":\"2026-05-17\",\"contact_name\":\"Sangeeta\",\"complete_address\":\"Village bichoda mathura road eklaas bazaar post bheswa jila aligarh\",\"landmark\":\"Near by sarkari school\",\"mobilenumber\":\"9634194346\",\"remarks\":\"REATTEMPT\"}', '{\"status\":true,\"response\":\"Request submitted successfully.\"}', 'action_taken', '2026-05-16 03:58:44', '2026-05-16 03:58:44');

-- --------------------------------------------------------

--
-- Table structure for table `ndr_product_details`
--

CREATE TABLE `ndr_product_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ndr_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ndr_tracking_history_logs`
--

CREATE TABLE `ndr_tracking_history_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `waybill_number` varchar(255) NOT NULL,
  `scan_date_time` datetime NOT NULL,
  `scan_status` varchar(255) NOT NULL,
  `scan_location` varchar(255) DEFAULT NULL,
  `scan_remark` text DEFAULT NULL,
  `shipment_journey` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ndr_tracking_history_logs`
--

INSERT INTO `ndr_tracking_history_logs` (`id`, `waybill_number`, `scan_date_time`, `scan_status`, `scan_location`, `scan_remark`, `shipment_journey`, `created_at`, `updated_at`) VALUES
(1, '77789707774', '2026-05-09 12:01:50', 'Action Taken: re-attempt', 'Banka, Bihar', 're attepmt', 0, '2026-05-09 12:01:50', '2026-05-09 12:01:50'),
(2, '77790553190', '2026-05-11 09:08:22', 'Action Taken: re-attempt', 'Budaun, Uttar Pradesh', 'Please deliver', 0, '2026-05-11 09:08:22', '2026-05-11 09:08:22'),
(3, '77792076213', '2026-05-11 09:09:01', 'Action Taken: re-attempt', 'Begusarai, Bihar', 'Reattempt', 0, '2026-05-11 09:09:01', '2026-05-11 09:09:01'),
(4, '77790727663', '2026-05-11 12:22:03', 'Action Taken: re-attempt', 'Bijnor, Uttar Pradesh', 'Near - Kirana store', 0, '2026-05-11 12:22:03', '2026-05-11 12:22:03'),
(5, '77790727556', '2026-05-11 12:25:15', 'Action Taken: re-attempt', 'Hanumangarh, Rajasthan', 'Reattempt', 0, '2026-05-11 12:25:15', '2026-05-11 12:25:15'),
(6, '77790727980', '2026-05-11 13:19:34', 'Action Taken: re-attempt', 'Rohtak, Haryana', 're attemept', 0, '2026-05-11 13:19:34', '2026-05-11 13:19:34'),
(7, '77790728702', '2026-05-11 13:19:50', 'Action Taken: re-attempt', 'Surat, Gujarat', 'reattempt', 0, '2026-05-11 13:19:50', '2026-05-11 13:19:50'),
(8, '77789705976', '2026-05-11 13:20:03', 'Action Taken: re-attempt', 'Udham Singh Nagar, Uttarakhand', 're attempt', 0, '2026-05-11 13:20:03', '2026-05-11 13:20:03'),
(9, '77790727840', '2026-05-11 16:25:21', 'Action Taken: re-attempt', 'Pune, Maharashtra', 'Reattempt', 0, '2026-05-11 16:25:21', '2026-05-11 16:25:21'),
(10, '77792019911', '2026-05-12 06:52:50', 'Action Taken: re-attempt', 'Firozpur, Punjab', 'delivery boy not calling', 0, '2026-05-12 06:52:50', '2026-05-12 06:52:50'),
(11, '77793101562', '2026-05-12 07:25:10', 'Action Taken: re-attempt', 'Bareilly, Uttar Pradesh', 'please reattempt this order delivery boy not calling customer', 0, '2026-05-12 07:25:10', '2026-05-12 07:25:10'),
(12, '77789710132', '2026-05-12 12:00:36', 'Action Taken: re-attempt', 'Lucknow, Uttar Pradesh', 'please reattempt this order . this order is  completetely unprofessional', 0, '2026-05-12 12:00:36', '2026-05-12 12:00:36'),
(13, '77790752771', '2026-05-12 12:00:50', 'Action Taken: re-attempt', 'Haridwar, Uttarakhand', 'please reattempt this order . this order is  completetely unprofessional', 0, '2026-05-12 12:00:50', '2026-05-12 12:00:50'),
(14, '77792017903', '2026-05-12 12:01:05', 'Action Taken: re-attempt', 'Hanumangarh, Rajasthan', 'please reattempt this order . this order is  completetely unprofessional', 0, '2026-05-12 12:01:05', '2026-05-12 12:01:05'),
(15, '77793101595', '2026-05-12 12:01:16', 'Action Taken: re-attempt', 'Bareilly, Uttar Pradesh', 'please reattempt this order . this order is  completetely unprofessional', 0, '2026-05-12 12:01:16', '2026-05-12 12:01:16'),
(16, '77793101691', '2026-05-12 12:01:27', 'Action Taken: re-attempt', 'Lucknow, Uttar Pradesh', 'please reattempt this order . this order is  completetely unprofessional', 0, '2026-05-12 12:01:27', '2026-05-12 12:01:27'),
(17, '37355837634121', '2026-05-12 12:01:37', 'Action Taken: re-attempt', 'Supaul, Bihar', 'please reattempt this order . this order is  completetely unprofessional', 0, '2026-05-12 12:01:37', '2026-05-12 12:01:37'),
(18, '37355837634014', '2026-05-13 04:50:06', 'Action Taken: re-attempt', 'East Singhbhum, Jharkhand', 'reattempt this order', 0, '2026-05-13 04:50:06', '2026-05-13 04:50:06'),
(19, '77793104476', '2026-05-14 01:27:45', 'Action Taken: re-attempt', 'Bulandshahr, Uttar Pradesh', 'reattempt', 0, '2026-05-14 01:27:45', '2026-05-14 01:27:45'),
(20, '77790728153', '2026-05-14 01:28:20', 'Action Taken: re-attempt', 'Dehradun, Uttarakhand', 'reattempt', 0, '2026-05-14 01:28:20', '2026-05-14 01:28:20'),
(21, '37355837525212', '2026-05-14 01:28:48', 'Action Taken: re-attempt', 'Bargarh, Odisha', 'reattempt', 0, '2026-05-14 01:28:48', '2026-05-14 01:28:48'),
(22, '77793103662', '2026-05-14 01:29:23', 'Action Taken: re-attempt', 'Hyderabad, Telangana', 'reattempt', 0, '2026-05-14 01:29:23', '2026-05-14 01:29:23'),
(23, '77793104675', '2026-05-14 01:29:34', 'Action Taken: re-attempt', 'Kushinagar, Uttar Pradesh', 'reattempt', 0, '2026-05-14 01:29:34', '2026-05-14 01:29:34'),
(24, '77794325232', '2026-05-14 01:29:45', 'Action Taken: re-attempt', 'Vaishali, Bihar', 'reattempt', 0, '2026-05-14 01:29:45', '2026-05-14 01:29:45'),
(25, '37355837687730', '2026-05-15 07:04:44', 'Action Taken: re-attempt', 'Katihar, Bihar', 'uiy', 0, '2026-05-15 07:04:44', '2026-05-15 07:04:44'),
(26, '77799148604', '2026-05-15 07:22:45', 'Action Taken: re-attempt', 'Nalanda, Bihar', 'vxvx', 0, '2026-05-15 07:22:45', '2026-05-15 07:22:45'),
(27, '369197820427', '2026-05-15 08:39:55', 'Action Taken: re-attempt', 'Alwar, Rajasthan', 'reattempt', 0, '2026-05-15 08:39:55', '2026-05-15 08:39:55'),
(28, '37355837634095', '2026-05-15 13:12:01', 'Action Taken: re-attempt', 'Ambedkar Nagar, Uttar Pradesh', 'reattempt', 0, '2026-05-15 13:12:01', '2026-05-15 13:12:01'),
(29, '37355837633970', '2026-05-15 13:12:14', 'Action Taken: re-attempt', 'Gonda, Uttar Pradesh', 'reattempt', 0, '2026-05-15 13:12:14', '2026-05-15 13:12:14'),
(30, '77794325571', '2026-05-15 13:12:28', 'Action Taken: re-attempt', 'Firozabad, Uttar Pradesh', 'reattempt', 0, '2026-05-15 13:12:28', '2026-05-15 13:12:28'),
(31, '77794325556', '2026-05-15 13:12:40', 'Action Taken: re-attempt', 'Firozabad, Uttar Pradesh', 'reattempt', 0, '2026-05-15 13:12:40', '2026-05-15 13:12:40'),
(32, '77799148350', '2026-05-15 13:12:53', 'Action Taken: re-attempt', 'Patna, Bihar', 'reattempt', 0, '2026-05-15 13:12:53', '2026-05-15 13:12:53'),
(33, '37355837750774', '2026-05-15 13:13:10', 'Action Taken: re-attempt', 'Katihar, Bihar', 'reattempt', 0, '2026-05-15 13:13:10', '2026-05-15 13:13:10'),
(34, '37355837634084', '2026-05-15 13:13:23', 'Action Taken: re-attempt', 'Jalandhar, Punjab', 'reattempt', 0, '2026-05-15 13:13:23', '2026-05-15 13:13:23'),
(35, '77793102936', '2026-05-15 13:13:36', 'Action Taken: re-attempt', 'Vadodara, Gujarat', 'reattempt', 0, '2026-05-15 13:13:36', '2026-05-15 13:13:36'),
(36, '37355837633966', '2026-05-15 13:13:47', 'Action Taken: re-attempt', 'Patiala, Punjab', 'reattempt', 0, '2026-05-15 13:13:47', '2026-05-15 13:13:47'),
(37, '77798022330', '2026-05-15 13:14:02', 'Action Taken: re-attempt', 'Patna, Bihar', 'reattempt', 0, '2026-05-15 13:14:02', '2026-05-15 13:14:02'),
(38, '37355837687704', '2026-05-15 13:14:15', 'Action Taken: re-attempt', 'Purnia, Bihar', 'reattempt', 0, '2026-05-15 13:14:15', '2026-05-15 13:14:15'),
(39, '77793102612', '2026-05-15 13:14:30', 'Action Taken: re-attempt', 'Mathura, Uttar Pradesh', 'reattempt', 0, '2026-05-15 13:14:30', '2026-05-15 13:14:30'),
(40, '77798022433', '2026-05-15 13:14:50', 'Action Taken: re-attempt', 'Patna, Bihar', 'reattempt', 0, '2026-05-15 13:14:50', '2026-05-15 13:14:50'),
(41, '77798022363', '2026-05-15 13:15:01', 'Action Taken: re-attempt', 'Patna, Bihar', 'reattempt', 0, '2026-05-15 13:15:01', '2026-05-15 13:15:01'),
(42, '77796751502', '2026-05-16 03:58:11', 'Action Taken: re-attempt', 'North 24 Parganas, West Bengal', 'REATTEMPT', 0, '2026-05-16 03:58:11', '2026-05-16 03:58:11'),
(43, '77795000846', '2026-05-16 03:58:30', 'Action Taken: re-attempt', 'Aligarh, Uttar Pradesh', 'REATTEMPT', 0, '2026-05-16 03:58:30', '2026-05-16 03:58:30'),
(44, '77794325545', '2026-05-16 03:58:44', 'Action Taken: re-attempt', 'Aligarh, Uttar Pradesh', 'REATTEMPT', 0, '2026-05-16 03:58:44', '2026-05-16 03:58:44');

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
-- Table structure for table `pickup_addresses`
--

CREATE TABLE `pickup_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_name` varchar(255) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `address_line1` text NOT NULL,
  `address_line2` text DEFAULT NULL,
  `pincode` varchar(6) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pick_address_ID` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pickup_addresses`
--

INSERT INTO `pickup_addresses` (`id`, `user_id`, `warehouse_name`, `contact_name`, `address_line1`, `address_line2`, `pincode`, `city`, `state_id`, `country_id`, `phone_number`, `email`, `pick_address_ID`, `is_default`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(54, 36, 'Nikunj Ayura Health Cares', 'Nikunj Gogadani', 'Glowriwellness Hub , behind ford hospital , khemnichak , patna , bihar', NULL, '800030', 'Patna', 4, 1, '8235196825', 'Ayurahealthcares@gmail.com', '265645', 0, 1, '2026-05-05 12:29:35', '2026-05-07 16:05:42', NULL),
(55, 39, 'Glow ri well ness ritik', 'Shivam', 'Behind Ford hospital, near pareja hospital, patna ,bihar', NULL, '800030', 'Patna', 4, 1, '9060454764', 'vedaherbalorder@gmail.com', '265895', 1, 1, '2026-05-06 09:09:56', '2026-05-06 09:09:59', NULL),
(56, 41, 'prem6', 'prem', 'Qui qui rem eu ut ex', NULL, '110059', 'delhi', 32, 1, '6878787878', 'e@gmail.co', '275952', 0, 1, '2026-05-06 12:26:58', '2026-05-06 12:26:58', NULL),
(57, 36, '1 Ayura Health Cares', 'Ayura Health 1', 'Mota Bhai saree wala kai pass , Hanuman nagar , Kali mandir road , kankarbagh , patna', NULL, '800020', 'Patna', 4, 1, '8235196825', 'Ayurahealthcares@gmail.com', '276667', 1, 1, '2026-05-07 16:05:39', '2026-05-07 16:05:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rapidshyp_b2c_orders`
--

CREATE TABLE `rapidshyp_b2c_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `store_name` varchar(255) NOT NULL DEFAULT 'DEFAULT',
  `pickup_address_name` varchar(255) DEFAULT NULL,
  `pickup_location` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pickup_location`)),
  `shipping_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`shipping_address`)),
  `billing_is_shipping` tinyint(1) NOT NULL DEFAULT 1,
  `billing_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`billing_address`)),
  `package_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`package_details`)),
  `payment_method` enum('COD','PREPAID') NOT NULL DEFAULT 'COD',
  `shipping_charges` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gift_wrap_charges` decimal(10,2) NOT NULL DEFAULT 0.00,
  `transaction_charges` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_order_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cod_charges` decimal(10,2) NOT NULL DEFAULT 0.00,
  `prepaid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `collectable_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `api_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`api_response`)),
  `api_status` varchar(255) DEFAULT NULL,
  `awb` varchar(255) DEFAULT NULL,
  `shipment_id` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) NOT NULL DEFAULT 'PENDING',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rapidshyp_b2c_order_items`
--

CREATE TABLE `rapidshyp_b2c_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rapidshyp_b2c_order_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `sku` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `units` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `tax` decimal(5,2) NOT NULL DEFAULT 0.00,
  `hsn` varchar(50) DEFAULT NULL,
  `product_length` decimal(8,2) DEFAULT NULL,
  `product_breadth` decimal(8,2) DEFAULT NULL,
  `product_height` decimal(8,2) DEFAULT NULL,
  `product_weight` decimal(8,2) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_fragile` tinyint(1) NOT NULL DEFAULT 0,
  `is_personalisable` tinyint(1) NOT NULL DEFAULT 0,
  `pickup_address_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rapidshyp_rates`
--

CREATE TABLE `rapidshyp_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('B2C','B2B') NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `forward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `rto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `add_forward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `add_rto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cod_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zcod_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rapidshyp_rto_addresses`
--

CREATE TABLE `rapidshyp_rto_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `rto_address_name` varchar(75) NOT NULL COMMENT 'API: rto_address_name (3-75 chars)',
  `rto_contact_name` varchar(100) NOT NULL COMMENT 'API: rto_contact_name (Only alphabets)',
  `rto_contact_number` varchar(15) NOT NULL COMMENT 'API: rto_contact_number (Cleaned 10-digit)',
  `rto_email` varchar(255) DEFAULT NULL COMMENT 'API: rto_email',
  `rto_address_line` varchar(100) NOT NULL COMMENT 'API: rto_address_line (3-100 chars)',
  `rto_address_line2` varchar(100) DEFAULT NULL COMMENT 'API: rto_address_line2 (3-100 chars if entered)',
  `rto_pincode` char(6) NOT NULL COMMENT 'API: rto_pincode (6 digits)',
  `rto_city` varchar(100) DEFAULT NULL COMMENT 'Auto-filled from pincode API',
  `rto_state` varchar(100) DEFAULT NULL COMMENT 'Auto-filled from pincode API',
  `rto_country` varchar(100) NOT NULL DEFAULT 'INDIA' COMMENT 'Default: INDIA',
  `rto_gstin` char(15) DEFAULT NULL COMMENT 'API: rto_gstin (Valid GSTIN: 24AAACO4716C1ZZ)',
  `rapidshyp_rto_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rapidshyp_serviceability_logs`
--

CREATE TABLE `rapidshyp_serviceability_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `pickup_pincode` varchar(6) NOT NULL,
  `delivery_pincode` varchar(6) NOT NULL,
  `is_cod` tinyint(1) NOT NULL DEFAULT 0,
  `total_order_value` decimal(12,2) NOT NULL,
  `weight` decimal(8,3) NOT NULL,
  `is_serviceable` tinyint(1) NOT NULL DEFAULT 0,
  `courier_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`courier_list`)),
  `raw_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`raw_response`)),
  `api_status` varchar(255) DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `selected_courier_code` varchar(255) DEFAULT NULL,
  `selected_courier_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rapidshyp_warehouses`
--

CREATE TABLE `rapidshyp_warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_name` varchar(75) NOT NULL COMMENT 'API: address_name (3-75 chars)',
  `contact_person` varchar(150) NOT NULL COMMENT 'API: contact_name (Only alphabets)',
  `contact_number` varchar(15) NOT NULL COMMENT 'API: contact_number (Starts 7,8,9 - 10 digits)',
  `email_id` varchar(255) NOT NULL COMMENT 'API: email',
  `address_line_1` varchar(100) NOT NULL COMMENT 'API: address_line (3-100 chars)',
  `address_line_2` varchar(100) DEFAULT NULL COMMENT 'API: address_line2 (3-100 chars if entered)',
  `pincode` char(6) NOT NULL COMMENT 'API: pincode (Exactly 6 digits)',
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) NOT NULL DEFAULT 'INDIA',
  `gstin` char(15) DEFAULT NULL COMMENT 'API: gstin (Valid 15-char GSTIN)',
  `latitude` decimal(10,8) DEFAULT NULL COMMENT 'API: latitude (-90 to 90)',
  `longitude` decimal(11,8) DEFAULT NULL COMMENT 'API: longitude (-180 to 180)',
  `warehousing_system` varchar(20) DEFAULT NULL COMMENT 'own/third_party',
  `dropship_location` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'API: dropship_location',
  `use_alt_rto_address` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'API: use_alt_rto_address',
  `rto_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rto_location_name` varchar(100) DEFAULT NULL,
  `rapidshyp_warehouse_id` varchar(50) DEFAULT NULL COMMENT 'API response: pickup_location_name',
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rto_addresses`
--

CREATE TABLE `rto_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pickup_address_id` bigint(20) UNSIGNED NOT NULL,
  `pick_address_id` varchar(255) DEFAULT NULL,
  `rto_nick_name` varchar(255) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_line1` text NOT NULL,
  `pincode` varchar(6) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `warehouse_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_agreement_acceptances`
--

CREATE TABLE `seller_agreement_acceptances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `section_name` varchar(255) NOT NULL DEFAULT 'Seller Agreement',
  `version` varchar(255) NOT NULL DEFAULT '1.0',
  `change_description` text DEFAULT NULL,
  `accepted_by` varchar(255) DEFAULT NULL,
  `acceptance_date` timestamp NULL DEFAULT NULL,
  `published_on` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `doc_link` varchar(255) DEFAULT NULL,
  `status` enum('Accepted','Pending','Rejected') NOT NULL DEFAULT 'Accepted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('J322pzhEUcg8NJHVBMJ71FScRmpWGUuSdzLgt3ac', NULL, '127.0.0.1', 'PostmanRuntime/7.51.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiamcxOWh4aFVNTEJ5Y2VQdkFrakRlc3F5WWE0YlhydDRkcFFqY2MxRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMToiYWRtaW4ubG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1773394944),
('laANU2WvfNzHfkfCccxIvk0ik2pyQoiGU07aDa3f', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid3VwTk1LNDQ4TWZMUEg0Q1RldHVUc3lsbTVKM3BRUWZjV0l2Z1ZsSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1773390336),
('qVAVM0psMpLQHrQ7D2zsiGVYWQQAme4FZ32JPh7Z', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM256Wms0SE9MdG9pcEV2SjdMRUE3RVVVMFlkMGlDVFhGVnBXVjJhTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1773390995),
('suSdW4JHZ0GDjMjHHxFEw4nVpQWUlTZCME6pkjEo', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVGhoZmFYcWY5WDA2eFZwcEV0N3A5SHdHcFVvNXRienNvYzNmZEhScCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1773393010),
('Vxn9uNZ8wwuvNrqEzswXwvr4hEo3DEmBhQvnAf6y', 9, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36 Edg/145.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTk9SRkRCcmRMcnR0YjZNSTdmckt2c001eVBXZ2hQR0NYRmxObVpUNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjk7fQ==', 1773395309);

-- --------------------------------------------------------

--
-- Table structure for table `shipment_documents`
--

CREATE TABLE `shipment_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pickup_order_id` bigint(20) NOT NULL,
  `pickup_status_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'FShip pickup status ID: 1=Initiated, 2=Confirmed, etc.',
  `manifest_url` text DEFAULT NULL,
  `invoice_url` text DEFAULT NULL,
  `label_url` text DEFAULT NULL,
  `courier_name` varchar(255) DEFAULT NULL,
  `pickup_status` varchar(255) DEFAULT 'MANIFESTED',
  `is_generated` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Whether label/invoice/manifest files are ready',
  `regenerate_date` timestamp NULL DEFAULT NULL COMMENT 'When files can be regenerated next',
  `shipment_count` int(11) NOT NULL DEFAULT 1,
  `provider_pickup_id` varchar(255) DEFAULT NULL,
  `pickup_date` datetime DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `last_regenerated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipment_documents`
--

INSERT INTO `shipment_documents` (`id`, `pickup_order_id`, `pickup_status_id`, `manifest_url`, `invoice_url`, `label_url`, `courier_name`, `pickup_status`, `is_generated`, `regenerate_date`, `shipment_count`, `provider_pickup_id`, `pickup_date`, `remark`, `last_regenerated_at`) VALUES
(3, 209979, NULL, 'https://qc-manifest.fship.in/files/manifest/manifest_209979_86ffbb455adc4c83b467f5daa3f32361.pdf', 'https://qc-manifest.fship.in/files/invoice/invoice_209979_1123f5eb5c6c4bdf88ce66ce7b8b98b6.pdf', 'https://qc-manifest.fship.in/files/label/label_209979_5d02271106004c54bacbcc03d38c53fd.pdf', 'Delhivery', 'MANIFESTED', 0, NULL, 1, NULL, '2026-04-10 18:50:26', 'Manifest generated.', '2026-04-10 13:20:26'),
(4, 209980, NULL, 'https://qc-manifest.fship.in/files/manifest/manifest_209980_b466972db2fa423b8ea6d1fb4d787ef0.pdf', 'https://qc-manifest.fship.in/files/invoice/invoice_209980_67e45a86f1ee478883607f9bc7dc7924.pdf', 'https://qc-manifest.fship.in/files/label/label_209980_2d50f49c1c544ac4a93c304d7ae507ed.pdf', 'Delhivery', 'MANIFESTED', 0, NULL, 1, NULL, '2026-04-10 21:24:08', 'Manifest generated.', '2026-04-10 15:54:08'),
(5, 209981, NULL, 'https://qc-manifest.fship.in/files/manifest/manifest_209981_b1049afc28a6456d9689d689d3da854a.pdf', 'https://qc-manifest.fship.in/files/invoice/invoice_209981_c52e579faf9546f7bde3e7725780a14c.pdf', 'https://qc-manifest.fship.in/files/label/label_209981_764476918880411ca3ec792921e4786f.pdf', 'Delhivery', 'MANIFESTED', 0, NULL, 1, '209981', '2026-04-11 07:18:38', 'Manifest generated.', '2026-04-11 01:48:38'),
(6, 209983, NULL, 'https://qc-manifest.fship.in/files/manifest/manifest_209983_ad776b79dde74694af3018fc83756a9a.pdf', 'https://qc-manifest.fship.in/files/invoice/invoice_209983_452c668102c649bdb22b5e6f08b8ed0c.pdf', 'https://qc-manifest.fship.in/files/label/label_209983_5e3ab93b6c1349b0b6edf441b9f92787.pdf', '#3432343234-CLONE-623-CLONE-935', 'MANIFESTED', 0, NULL, 1, '80149577631', '2026-04-11 07:53:21', 'Success: Manifest Generated', '2026-04-11 02:23:21'),
(7, 209984, NULL, 'https://qc-manifest.fship.in/files/manifest/manifest_209984_8864b557af714789b0e9217ea234f054.pdf', 'https://qc-manifest.fship.in/files/invoice/invoice_209984_9fe60a1386754b73af20efab6dc48e74.pdf', 'https://qc-manifest.fship.in/files/label/label_209984_09bd036c10794411b6f6e583824b07c0.pdf', '#3432343234-CLONE-623-CLONE-935', 'MANIFESTED', 0, NULL, 1, '80149577664', '2026-04-11 10:16:05', 'Success: Manifest Generated', '2026-04-11 04:46:05'),
(8, 210007, NULL, 'https://qc-manifest.fship.in/files/manifest/manifest_210007_c569f014ed3b4e529b394d3a6af19ba4.pdf', 'https://qc-manifest.fship.in/files/invoice/invoice_210007_3fbb51d84f2f4b0693771443fde65a59.pdf', 'https://qc-manifest.fship.in/files/label/label_210007_badf46947a054a778f165fd9c3f976c3.pdf', '#Ut sint saepe repell-CLONE-968-CLONE-357', 'MANIFESTED', 0, NULL, 1, '90001638263', '2026-04-14 16:41:38', 'Success: Manifest Generated', '2026-04-14 16:41:38'),
(9, 210084, NULL, 'https://qc-manifest.fship.in/files/manifest/manifest_210084_a9787c39f2fa4d06b2a3d078892ec424.pdf', 'https://qc-manifest.fship.in/files/invoice/invoice_210084_adb4a38f1d96442ebc77e1451a29ed1e.pdf', 'https://qc-manifest.fship.in/files/label/label_210084_7f90fae0b9ac4eec93396daf9f262d2f.pdf', 'Delhivery D', 'MANIFESTED', 0, NULL, 1, '80149580221', '2026-04-16 04:58:44', 'Success: Manifest Generated', '2026-04-16 04:58:44'),
(10, 1641366, NULL, 'https://manifest.fship.in/files/manifest/manifest_1641366_6eee05e1fdac42c7953889f81da5792c.pdf', 'https://manifest.fship.in/files/invoice/invoice_1641366_dc9f093bd95d4125926ce2b216c8c5d7.pdf', 'https://manifest.fship.in/files/label/label_1641366_e67c2f7d8b9444898860e67e39b14572.pdf', '#564545345454', 'MANIFESTED', 0, NULL, 1, '76947442364', '2026-04-25 05:54:51', 'Success: Manifest Generated', '2026-04-25 00:24:51'),
(11, 1641480, NULL, 'https://manifest.fship.in/files/manifest/manifest_1641480_e2327004fdf14586924b59c1d3916a0e.pdf', 'https://manifest.fship.in/files/invoice/invoice_1641480_519556079e444114b5d59cf049a73961.pdf', 'https://manifest.fship.in/files/label/label_1641480_7769101302814190aade0805789921b5.pdf', '#8978766866', 'MANIFESTED', 0, NULL, 1, '77776432646', '2026-04-25 06:00:47', 'Success: Manifest Generated', '2026-04-25 00:30:47'),
(12, 1656672, NULL, 'https://manifest.fship.in/files/manifest/manifest_1656672_c472d7664b82449c95e3c5ed5da5ec7e.pdf', 'https://manifest.fship.in/files/invoice/invoice_1656672_ba9b5c6cf9a14de39fb755c5fabff825.pdf', 'https://manifest.fship.in/files/label/label_1656672_c2237cce8a724c5dbd77f85a6617ce81.pdf', 'Ekart', 'MANIFESTED', 0, NULL, 1, '77779038750', '2026-04-27 09:32:46', 'Success: Manifest Generated', '2026-04-27 04:02:46'),
(13, 1709069, NULL, 'https://manifest.fship.in/files/manifest/manifest_1709069_7fb55fc82934445cace2912cc5b0a269.pdf', 'https://manifest.fship.in/files/invoice/invoice_1709069_64170b5b39be4a21bbe481f872110d0d.pdf', 'https://manifest.fship.in/files/label/label_1709069_154b2fa59b6e48e299c12825273e92cc.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-01 04:12:05', 1, '77784118311', '2026-05-01 09:42:05', 'Success: Manifest Generated', '2026-05-01 04:12:05'),
(14, 1709851, NULL, 'https://manifest.fship.in/files/manifest/manifest_1709851_59d434da680444c6825d9c0d8f272e75.pdf', 'https://manifest.fship.in/files/invoice/invoice_1709851_1d2839785e4941678d091470c4f30957.pdf', 'https://manifest.fship.in/files/label/label_1709851_ead4dda4688e4cd8ad23a499d3a42798.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-01 11:45:48', 1, '37355837312191', '2026-05-01 11:45:48', 'Success: Manifest Generated', '2026-05-01 11:45:48'),
(15, 1710126, NULL, 'https://manifest.fship.in/files/manifest/manifest_1710126_fb9439fcf5df4a37b096c2c5852682a8.pdf', 'https://manifest.fship.in/files/invoice/invoice_1710126_545604d49a574723919deeab7c63452a.pdf', 'https://manifest.fship.in/files/label/label_1710126_d21b685e45954446a117966b746a9333.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-01 12:24:38', 1, '37355837317522', '2026-05-01 12:24:38', 'Success: Manifest Generated', '2026-05-01 12:24:38'),
(16, 1710289, NULL, 'https://manifest.fship.in/files/manifest/manifest_1710289_d871b7ff5b2c4de4af6f469cedb4eedb.pdf', 'https://manifest.fship.in/files/invoice/invoice_1710289_3988196beeac45a28576e8c0b7f787ba.pdf', 'https://manifest.fship.in/files/label/label_1710289_fcbdcf96d52b4f13b9263c451e619c08.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-01 12:47:22', 1, '37355837317872', '2026-05-01 12:47:22', 'Success: Manifest Generated', '2026-05-01 12:47:22'),
(17, 1710919, NULL, 'https://manifest.fship.in/files/manifest/manifest_1710919_67ecb95bcfeb468998d774c233f00a5e.pdf', 'https://manifest.fship.in/files/invoice/invoice_1710919_cbad1cb26d2d4e95a1f93ad90525b5a2.pdf', 'https://manifest.fship.in/files/label/label_1710919_766cfa80b65f4ef990b5112ed5db9fb6.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-01 14:07:03', 1, '37355837319530', '2026-05-01 14:07:03', 'Success: Manifest Generated', '2026-05-01 14:07:03'),
(18, 1711510, NULL, 'https://manifest.fship.in/files/manifest/manifest_1711510_d447876d9d6b47fd8737ed5668fca5db.pdf', 'https://manifest.fship.in/files/invoice/invoice_1711510_bc04601772b84f5f86e088d6cd71be76.pdf', 'https://manifest.fship.in/files/label/label_1711510_f5135c89126341d39d5efbdac42c442a.pdf', 'Xpressbees New 500 gm', NULL, 1, '2026-05-02 03:06:55', 1, '14344961715100', '2026-05-02 03:06:55', 'Success: Manifest Generated', '2026-05-02 03:06:55'),
(19, 1711523, NULL, 'https://manifest.fship.in/files/manifest/manifest_1711523_9cb42b55af5747109727f97497cd3a1b.pdf', 'https://manifest.fship.in/files/invoice/invoice_1711523_78fb19505b3040d0a02bc30d0740b08f.pdf', 'https://manifest.fship.in/files/label/label_1711523_0afa97f625d1436dba72102710b57f55.pdf', 'Xpressbees New 500 gm', NULL, 1, '2026-05-02 03:09:48', 1, '14344961715108', '2026-05-02 03:09:48', 'Success: Manifest Generated', '2026-05-02 03:09:48'),
(20, 1717901, NULL, 'https://manifest.fship.in/files/manifest/manifest_1717901_1c040525c81a488dba7c3bc3abdc288c.pdf', 'https://manifest.fship.in/files/invoice/invoice_1717901_4a8cf6d2e7c94daba1269a7713ac841a.pdf', 'https://manifest.fship.in/files/label/label_1717901_96c75f6dfab64dfa8c99f3ef0207ddab.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-02 11:54:41', 1, '76958245081', '2026-05-02 11:54:41', 'Success: Manifest Generated', '2026-05-02 11:54:41'),
(21, 1717909, NULL, 'https://manifest.fship.in/files/manifest/manifest_1717909_2cb7cf3918f4458b89280c56b7bf8c0f.pdf', 'https://manifest.fship.in/files/invoice/invoice_1717909_f402ec5c78ff405d8e8e74af7a3220a8.pdf', 'https://manifest.fship.in/files/label/label_1717909_568fb06573d54150847efb08f7b25ab3.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-02 11:56:43', 1, '77785586270', '2026-05-02 11:56:43', 'Success: Manifest Generated', '2026-05-02 11:56:43'),
(22, 1717908, NULL, 'https://manifest.fship.in/files/manifest/manifest_1717908_bf1cf5dc115e404baed3fb209d1ee1ee.pdf', 'https://manifest.fship.in/files/invoice/invoice_1717908_a3c84acfe7a84027a01dd680c5319fdc.pdf', 'https://manifest.fship.in/files/label/label_1717908_482a713a18634e5d8ed1287b827c40fe.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-02 11:56:43', 1, '37355837370280', '2026-05-02 11:56:43', 'Success: Manifest Generated', '2026-05-02 11:56:43'),
(23, 1718107, NULL, 'https://manifest.fship.in/files/manifest/manifest_1718107_16f82150cf22428d91c58df288966408.pdf', 'https://manifest.fship.in/files/invoice/invoice_1718107_e6ab58b867ca48dfab7b98fc6fbcff38.pdf', 'https://manifest.fship.in/files/label/label_1718107_7cf3c8a2c604498aaff2f99042924166.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-02 12:26:07', 1, '77785619892', '2026-05-02 12:26:07', 'Success: Manifest Generated', '2026-05-02 12:26:07'),
(24, 1718112, NULL, 'https://manifest.fship.in/files/manifest/manifest_1718112_3b7c4e15092c4fd781c96052cc910120.pdf', 'https://manifest.fship.in/files/invoice/invoice_1718112_b1d239fddcfb45cf886ff094f6d44bd7.pdf', 'https://manifest.fship.in/files/label/label_1718112_c35f060a43864c06abd3a878fe8af92d.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-02 12:26:27', 1, '76958294722', '2026-05-02 12:26:27', 'Success: Manifest Generated', '2026-05-02 12:26:27'),
(25, 1740756, NULL, 'https://manifest.fship.in/files/manifest/manifest_1740756_07f68c17192e4a9eae0a68b5247e7bff.pdf', 'https://manifest.fship.in/files/invoice/invoice_1740756_315a00184fff4ead81dfe06424bf72b7.pdf', 'https://manifest.fship.in/files/label/label_1740756_13e2c21370324ac5aa95f96c4c343d55.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-06 05:10:11', 1, '77789694006', '2026-05-06 05:10:11', 'Success: Manifest Generated', '2026-05-06 05:10:11'),
(26, 1740759, NULL, 'https://manifest.fship.in/files/manifest/manifest_1740759_291db46394c949f2baf530c44b41bac0.pdf', 'https://manifest.fship.in/files/invoice/invoice_1740759_ef307d7edbb8436e93b8ce4314fe63fe.pdf', 'https://manifest.fship.in/files/label/label_1740759_1c45055f551e42f9bc1e820e540492c5.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-06 05:10:11', 1, '77789694566', '2026-05-06 05:10:11', 'Success: Manifest Generated', '2026-05-06 05:10:11'),
(27, 1740753, NULL, 'https://manifest.fship.in/files/manifest/manifest_1740753_fc90c674534745c593f673b9e6834a8c.pdf', 'https://manifest.fship.in/files/invoice/invoice_1740753_d9a3863dbf1349ffaf0f10263863dacc.pdf', 'https://manifest.fship.in/files/label/label_1740753_8ef456c2e6be4c5eb6866c384a21b381.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-06 05:10:11', 1, '77789693752', '2026-05-06 05:10:11', 'Success: Manifest Generated', '2026-05-06 05:10:11'),
(28, 1740748, NULL, 'https://manifest.fship.in/files/manifest/manifest_1740748_8dbf6fa0a7344335a5fc79a2aee5d082.pdf', 'https://manifest.fship.in/files/invoice/invoice_1740748_252d07620ea346f4bd865551b8443280.pdf', 'https://manifest.fship.in/files/label/label_1740748_e8362d89360040baaddc65015fce4f49.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-06 05:10:11', 1, '77789693446', '2026-05-06 05:10:11', 'Success: Manifest Generated', '2026-05-06 05:10:11'),
(29, 1740837, NULL, 'https://manifest.fship.in/files/manifest/manifest_1740837_ff2480d444f94b3e8245d0b76dd13088.pdf', 'https://manifest.fship.in/files/invoice/invoice_1740837_bedfa1977b9f459ea82fd66f2af8eb1c.pdf', 'https://manifest.fship.in/files/label/label_1740837_6666ea0992314c33b4931caca4f965da.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-06 05:14:10', 1, '37355837525212', '2026-05-06 05:14:10', 'Success: Manifest Generated', '2026-05-06 05:14:10'),
(30, 1740806, NULL, 'https://manifest.fship.in/files/manifest/manifest_1740806_915e07cf9c8343a7b35ba6a6f4cf6544.pdf', 'https://manifest.fship.in/files/invoice/invoice_1740806_41bcda6b87534846aa6c06b57654ccb2.pdf', 'https://manifest.fship.in/files/label/label_1740806_98b2b604eaa94f14848781bc87382750.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-06 05:14:10', 1, '77789707774', '2026-05-06 05:14:10', 'Success: Manifest Generated', '2026-05-06 05:14:10'),
(31, 1740808, NULL, 'https://manifest.fship.in/files/manifest/manifest_1740808_297e5e1f58bf4027ae66f6927f3a3129.pdf', 'https://manifest.fship.in/files/invoice/invoice_1740808_c7d22f2cb1994d66903c5728a09b2554.pdf', 'https://manifest.fship.in/files/label/label_1740808_da7e2de41080455baded0bd91b06835e.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-06 05:14:11', 1, '77789710132', '2026-05-06 05:14:11', 'Success: Manifest Generated', '2026-05-06 05:14:11'),
(32, 1740805, NULL, 'https://manifest.fship.in/files/manifest/manifest_1740805_ddb19e08bb4b4c66a23c1356b0029a25.pdf', 'https://manifest.fship.in/files/invoice/invoice_1740805_2ad7ca3066a2429aaa74ce7e1b6c5527.pdf', 'https://manifest.fship.in/files/label/label_1740805_e4b05ae696a34ff39f1f94c048e69102.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-06 05:14:11', 1, '77789705976', '2026-05-06 05:14:11', 'Success: Manifest Generated', '2026-05-06 05:14:11'),
(33, 1744686, NULL, 'https://manifest.fship.in/files/manifest/manifest_1744686_4a0cad30b3534b0d8fc60b60725c2b83.pdf', 'https://manifest.fship.in/files/invoice/invoice_1744686_5bb48aef33ba4f739a3d662b28df3223.pdf', 'https://manifest.fship.in/files/label/label_1744686_76a68cc969a848f4a45ec67eb8886088.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-06 09:20:07', 1, '77790205054', '2026-05-06 09:20:07', 'Success: Manifest Generated', '2026-05-06 09:20:07'),
(34, 1744695, NULL, 'https://manifest.fship.in/files/manifest/manifest_1744695_7bf0d49f12e444fdbafb36562f113c4f.pdf', 'https://manifest.fship.in/files/invoice/invoice_1744695_5cb51ad6f9644f1090b729b3c997ac70.pdf', 'https://manifest.fship.in/files/label/label_1744695_e9a3e876de224393973a6968c95d3d4a.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-06 09:20:07', 1, '76964125173', '2026-05-06 09:20:07', 'Success: Manifest Generated', '2026-05-06 09:20:07'),
(35, 1744685, NULL, 'https://manifest.fship.in/files/manifest/manifest_1744685_cf8e3868c8a14fa093bf23e7d8c12209.pdf', 'https://manifest.fship.in/files/invoice/invoice_1744685_ca76ca28f1454041a6493174c9aeaba9.pdf', 'https://manifest.fship.in/files/label/label_1744685_5d832b11a4024223b255d27cfea27de4.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-06 09:20:07', 1, '77790204741', '2026-05-06 09:20:07', 'Success: Manifest Generated', '2026-05-06 09:20:07'),
(36, 1744732, NULL, 'https://manifest.fship.in/files/manifest/manifest_1744732_15d77739aa3f48eaa63c11419b280bee.pdf', 'https://manifest.fship.in/files/invoice/invoice_1744732_46fe26879cff4375974101b64d5c0962.pdf', 'https://manifest.fship.in/files/label/label_1744732_ebf51ca7a6c94731968909f19803cf53.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-06 09:20:07', 1, '76964129410', '2026-05-06 09:20:07', 'Success: Manifest Generated', '2026-05-06 09:20:07'),
(37, 1756763, NULL, 'https://manifest.fship.in/files/manifest/manifest_1756763_23b3dbad4ce2470fb7052d4c5961171a.pdf', 'https://manifest.fship.in/files/invoice/invoice_1756763_1d7c259a3a4b45b1b5fc7c740f9a525d.pdf', 'https://manifest.fship.in/files/label/label_1756763_0bbdfd500b7042f0900c8d76d513a433.pdf', NULL, 'MANIFESTED', 0, NULL, 1, NULL, NULL, 'Generated during bulk download', '2026-05-06 12:36:29'),
(38, 1756894, NULL, 'https://manifest.fship.in/files/manifest/manifest_1756894_e82c4a38bc25458b9e3a832c15fa3b17.pdf', 'https://manifest.fship.in/files/invoice/invoice_1756894_2d9e0d9ebff5488bb6ad311b3402b5ed.pdf', 'https://manifest.fship.in/files/label/label_1756894_b3f9e41b90e744dfae9fc1211db82161.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-06 12:50:25', 1, '77790462772', '2026-05-06 12:50:26', 'Success: Manifest Generated', '2026-05-06 12:50:26'),
(39, 1757735, NULL, 'https://manifest.fship.in/files/manifest/manifest_1757735_f685f3bd0ea24eecaa43dd9893fe927a.pdf', 'https://manifest.fship.in/files/invoice/invoice_1757735_c2ac92ea70a14ded9c1f1ec1e67e18cf.pdf', 'https://manifest.fship.in/files/label/label_1757735_a6c0d8283f844f6594c08bf838a8d260.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-07 03:55:52', 1, '77790553190', '2026-05-07 03:55:52', 'Success: Manifest Generated', '2026-05-07 03:55:52'),
(40, 1758236, NULL, 'https://manifest.fship.in/files/manifest/manifest_1758236_61489af15350405b89ff462e24099414.pdf', 'https://manifest.fship.in/files/invoice/invoice_1758236_fa85194bf35d49e5b870c2c9aa65c72d.pdf', 'https://manifest.fship.in/files/label/label_1758236_ab039e3fa07c460b99a0bab0f68ddc3f.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-07 03:55:52', 1, '77790728702', '2026-05-07 03:55:52', 'Success: Manifest Generated', '2026-05-07 03:55:52'),
(41, 1758233, NULL, 'https://manifest.fship.in/files/manifest/manifest_1758233_e9e4181e37814a898d04de7aef8acf87.pdf', 'https://manifest.fship.in/files/invoice/invoice_1758233_980194919ff24e9eb91db1ff8338f382.pdf', 'https://manifest.fship.in/files/label/label_1758233_22dd1b09b376461aa6a84a595fcbfd53.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-07 03:55:52', 1, '77790728540', '2026-05-07 03:55:52', 'Success: Manifest Generated', '2026-05-07 03:55:52'),
(42, 1758227, NULL, 'https://manifest.fship.in/files/manifest/manifest_1758227_ca6dcd0327664741adb29b92dc4d1a98.pdf', 'https://manifest.fship.in/files/invoice/invoice_1758227_b098306bc48249e2b46e92fa3af7e598.pdf', 'https://manifest.fship.in/files/label/label_1758227_c6d3133801024a019ab74691e49ea5c1.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-07 03:55:52', 1, '77790728153', '2026-05-07 03:55:53', 'Success: Manifest Generated', '2026-05-07 03:55:53'),
(43, 1758224, NULL, 'https://manifest.fship.in/files/manifest/manifest_1758224_ebfd7095e4d64e0785c57d366d4f3c53.pdf', 'https://manifest.fship.in/files/invoice/invoice_1758224_b05b1f5f519045f6a4de1a70a1b01b7a.pdf', 'https://manifest.fship.in/files/label/label_1758224_52c73b4e49754404bb683b131484508e.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-07 03:55:53', 1, '77790727980', '2026-05-07 03:55:53', 'Success: Manifest Generated', '2026-05-07 03:55:53'),
(44, 1758218, NULL, 'https://manifest.fship.in/files/manifest/manifest_1758218_c902e21c594d4f9380e440dcf099bb0e.pdf', 'https://manifest.fship.in/files/invoice/invoice_1758218_75f43813d4af4e81b735f8e20b9e789b.pdf', 'https://manifest.fship.in/files/label/label_1758218_636df28677af4e648b38a820dbab618d.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-07 03:55:53', 1, '77790727840', '2026-05-07 03:55:53', 'Success: Manifest Generated', '2026-05-07 03:55:53'),
(45, 1758216, NULL, 'https://manifest.fship.in/files/manifest/manifest_1758216_b547e74375d2492eac3abd1f280d48b4.pdf', 'https://manifest.fship.in/files/invoice/invoice_1758216_6514d0b952ad402dbef5d70825cb6eec.pdf', 'https://manifest.fship.in/files/label/label_1758216_e2231047c11449959da0d8a4ad046b54.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-07 03:55:53', 1, '77790727663', '2026-05-07 03:55:53', 'Success: Manifest Generated', '2026-05-07 03:55:53'),
(46, 1758215, NULL, 'https://manifest.fship.in/files/manifest/manifest_1758215_90d485315f9b40c0a72c16201a7a5e43.pdf', 'https://manifest.fship.in/files/invoice/invoice_1758215_795d6c6713684f51b95be1cb5031a297.pdf', 'https://manifest.fship.in/files/label/label_1758215_d951887d72d443cb89e6858f8f16139e.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-07 03:55:53', 1, '77790727556', '2026-05-07 03:55:53', 'Success: Manifest Generated', '2026-05-07 03:55:53'),
(47, 1758313, NULL, 'https://manifest.fship.in/files/manifest/manifest_1758313_6245a5a71539486b8bb735f8bee3798c.pdf', 'https://manifest.fship.in/files/invoice/invoice_1758313_ca7ccba158684a23be74e8da5656aa8c.pdf', 'https://manifest.fship.in/files/label/label_1758313_7406fc2940ca47829b75f9a810d960c0.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-07 03:58:48', 1, '77790752771', '2026-05-07 03:58:48', 'Success: Manifest Generated', '2026-05-07 03:58:48'),
(48, 1758317, NULL, 'https://manifest.fship.in/files/manifest/manifest_1758317_5b2ba46e38974117aab9f357e073819f.pdf', 'https://manifest.fship.in/files/invoice/invoice_1758317_ca51cfbac9784693858b496496c0c59c.pdf', 'https://manifest.fship.in/files/label/label_1758317_ef3c5d9591a747eb8e66d3383af14898.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-07 04:00:51', 1, '37355837556093', '2026-05-07 04:00:51', 'Success: Manifest Generated', '2026-05-07 04:00:51'),
(49, 1776357, NULL, 'https://manifest.fship.in/files/manifest/manifest_1776357_89b175aba2014be08872779b1f73ec32.pdf', 'https://manifest.fship.in/files/invoice/invoice_1776357_22ccda1bd0f946918e7682c56dfc558d.pdf', 'https://manifest.fship.in/files/label/label_1776357_9bc16d02ca674a57a5893f7b8329c119.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 05:12:49', 1, '77792220984', '2026-05-08 05:12:49', 'Success: Manifest Generated', '2026-05-08 05:12:49'),
(50, 1777395, NULL, 'https://manifest.fship.in/files/manifest/manifest_1777395_ba7362c5b2e744978b75fa3043fc9663.pdf', 'https://manifest.fship.in/files/invoice/invoice_1777395_dfb687dadc304acc826988649f88a814.pdf', 'https://manifest.fship.in/files/label/label_1777395_a811e3d9e9cf4e1d85f1de7fc9cbd781.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-08 06:28:42', 1, '37355837616293', '2026-05-08 06:28:42', 'Success: Manifest Generated', '2026-05-08 06:28:42'),
(51, 1780570, NULL, 'https://manifest.fship.in/files/manifest/manifest_1780570_967cd182b1b24490a024e308ae8a04a7.pdf', 'https://manifest.fship.in/files/invoice/invoice_1780570_615148826f9a4e12b6dcaf903cdc0b04.pdf', 'https://manifest.fship.in/files/label/label_1780570_1eb68debd0cd4698a5c66dcc1626d38b.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 11:45:03', 1, '77792963964', '2026-05-08 11:45:03', 'Success: Manifest Generated', '2026-05-08 11:45:03'),
(52, 1776094, NULL, 'https://manifest.fship.in/files/manifest/manifest_1776094_7b7104113a4b4a7b8710c17254515cb7.pdf', 'https://manifest.fship.in/files/invoice/invoice_1776094_4ccb08ed781548bc84e2fb39051c999e.pdf', 'https://manifest.fship.in/files/label/label_1776094_e0a2b73780b54a558de00b0ee439d75d.pdf', NULL, 'MANIFESTED', 0, NULL, 1, NULL, NULL, 'Generated during bulk download', '2026-05-08 12:30:08'),
(53, 1775682, NULL, 'https://manifest.fship.in/files/manifest/manifest_1775682_f7a4b93b759341f58dcfd05ea82bd742.pdf', 'https://manifest.fship.in/files/invoice/invoice_1775682_b03f1b2df7e444dd8f10080782a0953e.pdf', 'https://manifest.fship.in/files/label/label_1775682_1fe4bb4034d343dd956b9a111a6d8076.pdf', NULL, 'MANIFESTED', 0, NULL, 1, NULL, NULL, 'Generated during bulk download', '2026-05-08 12:30:08'),
(54, 1781024, NULL, 'https://manifest.fship.in/files/manifest/manifest_1781024_dff35348d5034dd49117bc7752e6d668.pdf', 'https://manifest.fship.in/files/invoice/invoice_1781024_71ae53e98e6d4eef942b8cc12b645185.pdf', 'https://manifest.fship.in/files/label/label_1781024_1455e673603140da849ada5d308536c2.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 12:56:06', 1, '77793014036', '2026-05-08 12:56:06', 'Success: Manifest Generated', '2026-05-08 12:56:06'),
(55, 1782260, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782260_915df11c3305480ab05c746c90b664a0.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782260_d051351c99bd49baac172c870b6c82af.pdf', 'https://manifest.fship.in/files/label/label_1782260_4dfb21d50f2f490b9606ccf376d95a66.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 16:10:18', 1, '77793104675', '2026-05-08 16:10:18', 'Success: Manifest Generated', '2026-05-08 16:10:18'),
(56, 1782259, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782259_cf9650298a6e4505923c53fccbf2979b.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782259_fb7ee4ca16ac451287f9163545c15206.pdf', 'https://manifest.fship.in/files/label/label_1782259_bfd60c4029264bcab4648de8c5f7c1c0.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 16:10:18', 1, '77793104476', '2026-05-08 16:10:18', 'Success: Manifest Generated', '2026-05-08 16:10:18'),
(57, 1782258, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782258_49f8186872cf49ed8c431967ca6a949a.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782258_02c16e5fdeaa4abc81b8311ff664cde2.pdf', 'https://manifest.fship.in/files/label/label_1782258_ad2aeafaafd145998f33efdb9786329a.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-08 16:10:18', 1, '37355837634121', '2026-05-08 16:10:18', 'Success: Manifest Generated', '2026-05-08 16:10:18'),
(58, 1782257, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782257_311ba681a38f4e44b733383437ec6192.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782257_a4061ad838834a96b4ccb1de85dda9d9.pdf', 'https://manifest.fship.in/files/label/label_1782257_bc8c68331e1d4ee48ddf43e99d7929b6.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-08 16:10:18', 1, '37355837634110', '2026-05-08 16:10:18', 'Success: Manifest Generated', '2026-05-08 16:10:18'),
(59, 1782255, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782255_09c14e67069046648cf606a8306a12be.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782255_d7b37b90ad7a44f8b159b2272e226bd9.pdf', 'https://manifest.fship.in/files/label/label_1782255_13a1a01dbbb2412296150a29153e7854.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-08 16:10:18', 1, '37355837634106', '2026-05-08 16:10:18', 'Success: Manifest Generated', '2026-05-08 16:10:18'),
(60, 1782254, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782254_24ed9ba3e08c4f28936865814bca7627.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782254_d33d085ef89b40cc8c3e49cd5bc30655.pdf', 'https://manifest.fship.in/files/label/label_1782254_691146a698074ed7b294d5dd245ae8ed.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-08 16:10:19', 1, '37355837634095', '2026-05-08 16:10:19', 'Success: Manifest Generated', '2026-05-08 16:10:19'),
(61, 1782253, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782253_30fe75050c87476cb84c635d766efe13.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782253_063caa05e56f48caa79f33b678a412f8.pdf', 'https://manifest.fship.in/files/label/label_1782253_9f18b64060874b40b0904bc737098cd7.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-08 16:10:19', 1, '37355837634084', '2026-05-08 16:10:19', 'Success: Manifest Generated', '2026-05-08 16:10:19'),
(62, 1782252, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782252_bbd7a08135be49d691c0d470ff220616.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782252_0dc7ee0bcfa845e4b7688bc430e16bd7.pdf', 'https://manifest.fship.in/files/label/label_1782252_df8d1e9ef6394510b1d65e2fb70f5e75.pdf', 'Amazon New', NULL, 1, '2026-05-08 16:10:19', 1, '369197820427', '2026-05-08 16:10:19', 'Success: Manifest Generated', '2026-05-08 16:10:19'),
(63, 1782250, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782250_79ebe62965e14a9bb2f00522f335b394.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782250_c5256018b9e84e3f8e3ae8dccb612036.pdf', 'https://manifest.fship.in/files/label/label_1782250_29a0bda6325f4f71a7aa39a20afd569d.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 16:10:19', 1, '77793103662', '2026-05-08 16:10:19', 'Success: Manifest Generated', '2026-05-08 16:10:19'),
(64, 1782249, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782249_41e79d96405e4b3ba2100966f282b543.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782249_654762a2c7994c46aead018cedd0d1d5.pdf', 'https://manifest.fship.in/files/label/label_1782249_4f2cb7d5767c4a1db37c8de953e8a7cb.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-08 16:10:19', 1, '37355837634062', '2026-05-08 16:10:19', 'Success: Manifest Generated', '2026-05-08 16:10:19'),
(65, 1782247, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782247_bfc4c759c26c486fa79754bba7b23a55.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782247_15f434c7abc848d78c7f35a9120064f2.pdf', 'https://manifest.fship.in/files/label/label_1782247_54af4d7fb2f54811920a416e9c1d28de.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 16:10:19', 1, '77793103006', '2026-05-08 16:10:19', 'Success: Manifest Generated', '2026-05-08 16:10:19'),
(66, 1782244, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782244_01327db8c6db429ab90b2764b46228af.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782244_1cfcac3913754593b50ab3e3067134f7.pdf', 'https://manifest.fship.in/files/label/label_1782244_3ceede5392d242b3a6fa30f25256126d.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 16:10:19', 1, '77793102612', '2026-05-08 16:10:19', 'Success: Manifest Generated', '2026-05-08 16:10:19'),
(67, 1782243, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782243_f858b9bf7a6645008103666799074316.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782243_2f3e813679b8467a9ba0b84d1909d269.pdf', 'https://manifest.fship.in/files/label/label_1782243_71b1709f229044f0aaea4c450a9721e4.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-08 16:10:19', 1, '37355837634014', '2026-05-08 16:10:19', 'Success: Manifest Generated', '2026-05-08 16:10:19'),
(68, 1782246, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782246_c70fcea1f48f4998a8e1e1b015f91890.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782246_5edfba1e18734cc59af0708530069141.pdf', 'https://manifest.fship.in/files/label/label_1782246_b35a365c3c724b7ca0f248d301c1dc97.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 16:10:19', 1, '77793102936', '2026-05-08 16:10:19', 'Success: Manifest Generated', '2026-05-08 16:10:19'),
(69, 1782248, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782248_6da4b8cb1661452db2337c6fc196e0c6.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782248_f92a21f1c9744fad8963ed0786fb0db5.pdf', 'https://manifest.fship.in/files/label/label_1782248_db485afc5af74c5a85d70260a1109811.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-08 16:10:20', 1, '37355837634051', '2026-05-08 16:10:20', 'Success: Manifest Generated', '2026-05-08 16:10:20'),
(70, 1782236, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782236_172e54546f8345059b14f8f5f207127a.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782236_a0f3d2ce9e6a4e0aa46811cf82610f03.pdf', 'https://manifest.fship.in/files/label/label_1782236_1b589c200f02496c9713830421f5ab74.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-08 16:10:20', 1, '37355837633970', '2026-05-08 16:10:20', 'Success: Manifest Generated', '2026-05-08 16:10:20'),
(71, 1782235, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782235_ebde8c894d3b44cc9b8f4b965e28d4ff.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782235_cdfde7880a224425b7a83dcdaa8543eb.pdf', 'https://manifest.fship.in/files/label/label_1782235_b82b65e87ada4c048710efe6714bf4b1.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-08 16:10:20', 1, '37355837633966', '2026-05-08 16:10:20', 'Success: Manifest Generated', '2026-05-08 16:10:20'),
(72, 1782234, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782234_6925bae015e54f20a803dd720d2ae02a.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782234_dcb27cb6aab1400cae601d469911d116.pdf', 'https://manifest.fship.in/files/label/label_1782234_adfade684f5b451abebfcb6d56e9029a.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 16:10:20', 1, '77793101691', '2026-05-08 16:10:20', 'Success: Manifest Generated', '2026-05-08 16:10:20'),
(73, 1782233, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782233_4eed685f4eac44a7ae1964e54e2a48e2.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782233_fa1ed5ac03104a37b7cd8f92bb838e8c.pdf', 'https://manifest.fship.in/files/label/label_1782233_553cffca47824921bc6116d466ee8783.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 16:10:20', 1, '77793101665', '2026-05-08 16:10:20', 'Success: Manifest Generated', '2026-05-08 16:10:20'),
(74, 1782232, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782232_b61f1e7639954385a0c9338b1af9be21.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782232_d93a8e75c26c4b519e7ef8676bae2e44.pdf', 'https://manifest.fship.in/files/label/label_1782232_90bb33e2ffd144b58af88244e71ff0c5.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 16:10:20', 1, '77793101595', '2026-05-08 16:10:20', 'Success: Manifest Generated', '2026-05-08 16:10:20'),
(75, 1782230, NULL, 'https://manifest.fship.in/files/manifest/manifest_1782230_803ae8ebcd2a464ca8dd7b4f20aaafa7.pdf', 'https://manifest.fship.in/files/invoice/invoice_1782230_1811d399b91040c69aa13d5bcc01f053.pdf', 'https://manifest.fship.in/files/label/label_1782230_48ea4d6990c545969abe03f9dd9a929c.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-08 16:10:20', 1, '77793101562', '2026-05-08 16:10:20', 'Success: Manifest Generated', '2026-05-08 16:10:20'),
(76, 1798993, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798993_779702fca08846d98aa6c929ccaf7544.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798993_e3588dd6e0c841b0b6c92fb50e834a1d.pdf', 'https://manifest.fship.in/files/label/label_1798993_664848b75e4f4fe591d757a9f8eff4cb.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-09 15:04:54', 1, '77794326411', '2026-05-09 15:04:54', 'Success: Manifest Generated', '2026-05-09 15:04:54'),
(77, 1798992, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798992_e36cae2d39bd400c813b9e7e5b4140f8.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798992_db665bdc52e44bdb8a2a3ab9fd7a1a14.pdf', 'https://manifest.fship.in/files/label/label_1798992_3872d475c7354f4fb68a228fb82c34f4.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-09 15:04:54', 1, '77794326374', '2026-05-09 15:04:54', 'Success: Manifest Generated', '2026-05-09 15:04:54'),
(78, 1798991, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798991_89ff6616f0914e329f322df003699acf.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798991_184bdfe66cbc43349493d8b5b3c82577.pdf', 'https://manifest.fship.in/files/label/label_1798991_49cfcca0a85e4b2f8b305df694a04251.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-09 15:04:54', 1, '77794326330', '2026-05-09 15:04:54', 'Success: Manifest Generated', '2026-05-09 15:04:54'),
(79, 1798990, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798990_89e2e4a12f864bb283169473b32709aa.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798990_c6197684ee7d424bb5db78bb12df0772.pdf', 'https://manifest.fship.in/files/label/label_1798990_4494ea587b38423ba3ad11e82f26a966.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-09 15:04:54', 1, '77794325626', '2026-05-09 15:04:54', 'Success: Manifest Generated', '2026-05-09 15:04:54'),
(80, 1798989, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798989_95367cf848f64890ae7230412f24808d.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798989_0d45489c6d794f4ba4d3ae4c59529040.pdf', 'https://manifest.fship.in/files/label/label_1798989_5bf810f3434941e18aaf87c8683201b7.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-09 15:04:54', 1, '37355837674426', '2026-05-09 15:04:54', 'Success: Manifest Generated', '2026-05-09 15:04:54'),
(81, 1798987, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798987_f5e4c77bd90b4fc2b50d76a997131589.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798987_895e0140810540519313b996969f9927.pdf', 'https://manifest.fship.in/files/label/label_1798987_517109d3fa414af6819b8decf51c97be.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-09 15:04:54', 1, '77794325556', '2026-05-09 15:04:54', 'Success: Manifest Generated', '2026-05-09 15:04:54'),
(82, 1798988, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798988_04a7e42cbf914dbc98f7aee87a015d0e.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798988_f8e0d412bc9549e68b5f0e5820824799.pdf', 'https://manifest.fship.in/files/label/label_1798988_96c14cae07a641c1bc5186b465603856.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-09 15:04:54', 1, '77794325571', '2026-05-09 15:04:54', 'Success: Manifest Generated', '2026-05-09 15:04:54'),
(83, 1798986, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798986_71cbb3953e9d4682b6dabf662637dcaf.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798986_2106b122f06f48b686ac5e6ae40cd158.pdf', 'https://manifest.fship.in/files/label/label_1798986_35eaed7f0c5e463897ffa1b5bd2f09cd.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-09 15:04:54', 1, '77794325545', '2026-05-09 15:04:54', 'Success: Manifest Generated', '2026-05-09 15:04:54'),
(84, 1798985, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798985_a010c9f21dd240b0819029f8b88855f6.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798985_95754a56106d4b78a1cebb0c8d829b9b.pdf', 'https://manifest.fship.in/files/label/label_1798985_200fed65610e46029584b6d87c29eac5.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-09 15:04:54', 1, '37355837674415', '2026-05-09 15:04:55', 'Success: Manifest Generated', '2026-05-09 15:04:55'),
(85, 1798980, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798980_e98fc2ad891b407fbf2e501dc36ec100.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798980_6a21468d23a34c28b564365c4ff0e4c9.pdf', 'https://manifest.fship.in/files/label/label_1798980_3f969f84eb3640c99b7f4ffae5728b14.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-09 15:04:55', 1, '37355837674404', '2026-05-09 15:04:55', 'Success: Manifest Generated', '2026-05-09 15:04:55'),
(86, 1798982, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798982_6108403cdb01476fba84d2e9845b40ef.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798982_74ccdd01260f4042937fb52c94127ade.pdf', 'https://manifest.fship.in/files/label/label_1798982_7d7157efd74d4846aa19827c011e83a9.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-09 15:04:55', 1, '77794325232', '2026-05-09 15:04:55', 'Success: Manifest Generated', '2026-05-09 15:04:55'),
(87, 1798977, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798977_4759a387841545fd9c513643cd1eacb2.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798977_f81b5c0c167d4971b876ce2cc31f093a.pdf', 'https://manifest.fship.in/files/label/label_1798977_100799a32909456f8d1744751fc987ce.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-09 15:04:55', 1, '37355837674393', '2026-05-09 15:04:55', 'Success: Manifest Generated', '2026-05-09 15:04:55'),
(88, 1798976, NULL, 'https://manifest.fship.in/files/manifest/manifest_1798976_2fa06dfe927f4a809664136d52f4fe2b.pdf', 'https://manifest.fship.in/files/invoice/invoice_1798976_236d4f13a28e49c6ab7d3163470b1ab6.pdf', 'https://manifest.fship.in/files/label/label_1798976_4ab04b22d77a4da8807315b9bf9b7b69.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-09 15:04:55', 1, '37355837674382', '2026-05-09 15:04:55', 'Success: Manifest Generated', '2026-05-09 15:04:55'),
(89, 1810439, NULL, 'https://manifest.fship.in/files/manifest/manifest_1810439_c102b592e05747e2be2f670e1bc12ff1.pdf', 'https://manifest.fship.in/files/invoice/invoice_1810439_a36c2bb6236d498b93cf2538e1959a4e.pdf', 'https://manifest.fship.in/files/label/label_1810439_9e648b15cff94bacbf90a17e95096ef2.pdf', NULL, 'MANIFESTED', 0, NULL, 1, NULL, NULL, 'Generated during bulk download', '2026-05-12 07:06:16'),
(90, 1810441, NULL, 'https://manifest.fship.in/files/manifest/manifest_1810441_bda691b277894aa286c7812b234ad3e7.pdf', 'https://manifest.fship.in/files/invoice/invoice_1810441_c78d79aa43df41ff863db15644345da3.pdf', 'https://manifest.fship.in/files/label/label_1810441_76feca1556a7426c92af4414b5e7231d.pdf', NULL, 'MANIFESTED', 0, NULL, 1, NULL, NULL, 'Generated during bulk download', '2026-05-12 07:06:16'),
(91, 1818165, NULL, NULL, NULL, NULL, NULL, 'MANIFESTED', 0, NULL, 1, NULL, NULL, 'Sync Error: No manifest URL received', '2026-05-12 17:01:24'),
(92, 1818164, NULL, 'https://manifest.fship.in/files/manifest/manifest_1818164_c1fd939c3f3e4dfaa587a572a7531441.pdf', 'https://manifest.fship.in/files/invoice/invoice_1818164_65c09c6947d84970b33798ee0d52ad94.pdf', 'https://manifest.fship.in/files/label/label_1818164_e9e5372f2f8f41488649d58739ca13ac.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-12 17:01:25', 1, '77798022702', '2026-05-12 17:01:25', 'Success: Manifest Generated', '2026-05-12 17:01:25'),
(93, 1818163, NULL, 'https://manifest.fship.in/files/manifest/manifest_1818163_77fcaf8d03f841a29a48ca482a4bfe36.pdf', 'https://manifest.fship.in/files/invoice/invoice_1818163_1be007abff494897a45a30ebff27c419.pdf', 'https://manifest.fship.in/files/label/label_1818163_6aa2f6cc44c745908f7267399ab025bb.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-12 17:01:25', 1, '77798022676', '2026-05-12 17:01:25', 'Success: Manifest Generated', '2026-05-12 17:01:25'),
(94, 1818162, NULL, 'https://manifest.fship.in/files/manifest/manifest_1818162_1f1bd48598054b229b34784b044f9626.pdf', 'https://manifest.fship.in/files/invoice/invoice_1818162_3ff3eb056927411e95bb51f86f8e10c5.pdf', 'https://manifest.fship.in/files/label/label_1818162_e29a0598324543e78669164e3cf753b1.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-12 17:01:25', 1, '37355837789996', '2026-05-12 17:01:25', 'Success: Manifest Generated', '2026-05-12 17:01:25'),
(95, 1821079, NULL, 'https://manifest.fship.in/files/manifest/manifest_1821079_2f364322fb494677995ce3d486c0f115.pdf', 'https://manifest.fship.in/files/invoice/invoice_1821079_59adb08a14434627a02adb95b75284c0.pdf', 'https://manifest.fship.in/files/label/label_1821079_13fa914b1bd847a987583b05f028ade5.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-13 06:45:04', 1, '77798601215', '2026-05-13 06:45:04', 'Success: Manifest Generated', '2026-05-13 06:45:04'),
(96, 1818156, NULL, 'https://manifest.fship.in/files/manifest/manifest_1818156_38bf8b0e562c4e82acb84079206ab28c.pdf', 'https://manifest.fship.in/files/invoice/invoice_1818156_0849d8fd8dfb4e93a6af70f9c5966132.pdf', 'https://manifest.fship.in/files/label/label_1818156_0ce2d20bbefb4374bed3c8f61938bd35.pdf', NULL, 'MANIFESTED', 0, NULL, 1, NULL, NULL, 'Generated during bulk download', '2026-05-13 13:26:43'),
(97, 1825641, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825641_c8d4934ac9e2406e8896038486ff9db3.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825641_be99ff64b3044651909122ab8ae36450.pdf', 'https://manifest.fship.in/files/label/label_1825641_2501bcfee4224b1cb3f2b406f5f0a640.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-13 13:58:17', 1, '37355837833002', '2026-05-13 13:58:17', 'Success: Manifest Generated', '2026-05-13 13:58:17'),
(98, 1825640, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825640_e191f3d460b945a49004aa562211a024.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825640_51f86785031f4487a9f8e05c08f74a02.pdf', 'https://manifest.fship.in/files/label/label_1825640_00c94fbbc5ed4109b6673b109c572811.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-13 13:58:17', 1, '77799148604', '2026-05-13 13:58:17', 'Success: Manifest Generated', '2026-05-13 13:58:17'),
(99, 1825639, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825639_f415d2efbece4214a5cd64db00dca28c.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825639_a597afdb6e774574ad1d82c16d9adec9.pdf', 'https://manifest.fship.in/files/label/label_1825639_7867bc9685964cafacc0c09658d0b433.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-13 13:58:17', 1, '37355837832991', '2026-05-13 13:58:17', 'Success: Manifest Generated', '2026-05-13 13:58:17'),
(100, 1825638, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825638_75c71cf7c226407fbcd1d1ea63def8d0.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825638_79c3def8004949d3a53f3746ab33ee0d.pdf', 'https://manifest.fship.in/files/label/label_1825638_ec4cc77e4ae64851a3612f908ac7d53c.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-13 13:58:17', 1, '77799148350', '2026-05-13 13:58:17', 'Success: Manifest Generated', '2026-05-13 13:58:17'),
(101, 1825636, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825636_ad38a58e5fa5421c8552429ffd2a2bfa.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825636_bb582ca2ac8c498094024c5a11020c76.pdf', 'https://manifest.fship.in/files/label/label_1825636_c788270b469544f487c5faefce0ab084.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-13 13:58:17', 1, '37355837832980', '2026-05-13 13:58:17', 'Success: Manifest Generated', '2026-05-13 13:58:17'),
(102, 1825634, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825634_f6119a29f2704fd1b949841cf7f25f79.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825634_9e397e409cc14a25b74d832449b3a7aa.pdf', 'https://manifest.fship.in/files/label/label_1825634_58ffd9113543444e80ef9fd127b08591.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-13 13:58:17', 1, '37355837832976', '2026-05-13 13:58:17', 'Success: Manifest Generated', '2026-05-13 13:58:17'),
(103, 1825633, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825633_386740c99ad7430f9a4d15782741dff1.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825633_daed5e44ecc14caf8cad9a9fe60d3702.pdf', 'https://manifest.fship.in/files/label/label_1825633_b74b58790cd342ab8571f7cfb2b8d623.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-13 13:58:17', 1, '37355837832965', '2026-05-13 13:58:17', 'Success: Manifest Generated', '2026-05-13 13:58:17'),
(104, 1825632, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825632_4625a2c4d4e243e7b6457d04dfa21476.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825632_71617cccfb9c4ed4806e45552bf6a8ec.pdf', 'https://manifest.fship.in/files/label/label_1825632_bdffd0a13fb94736afe7f681700fe461.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-13 13:58:17', 1, '37355837832954', '2026-05-13 13:58:17', 'Success: Manifest Generated', '2026-05-13 13:58:17'),
(105, 1825630, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825630_f1ce9def024240bf9d781f5d71b757ac.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825630_cc2e645c9d494eba82864c56e8e97446.pdf', 'https://manifest.fship.in/files/label/label_1825630_02c6b888b4ca48f8bba126eec2180e38.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-13 13:58:17', 1, '77799147904', '2026-05-13 13:58:17', 'Success: Manifest Generated', '2026-05-13 13:58:17'),
(106, 1825629, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825629_a456879d57614fbfabd954e9c10a904b.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825629_58fc863dc5484b0583eb8bcf8f05cf24.pdf', 'https://manifest.fship.in/files/label/label_1825629_6d6e7c2ef6664144b80e2bba490cf715.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-13 13:58:17', 1, '77799147650', '2026-05-13 13:58:18', 'Success: Manifest Generated', '2026-05-13 13:58:18'),
(107, 1825628, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825628_bd7d5099c4204964ab92deff5bc116a6.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825628_f29e22ef950b4c35a63846bc59c862eb.pdf', 'https://manifest.fship.in/files/label/label_1825628_fba4622a855a4865b914c4c6ad15a2e4.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-13 13:58:18', 1, '77799147576', '2026-05-13 13:58:18', 'Success: Manifest Generated', '2026-05-13 13:58:18'),
(108, 1825627, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825627_4791fe6d5d6b46a19735920a7d341333.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825627_3f0e25e252324a02a5ce63a38871df95.pdf', 'https://manifest.fship.in/files/label/label_1825627_aaa74cdbe8ea4f159dc3c44991145196.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-13 13:58:18', 1, '37355837832932', '2026-05-13 13:58:18', 'Success: Manifest Generated', '2026-05-13 13:58:18'),
(109, 1825624, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825624_4fe89184f4ce4721ac5751d2222ae2ef.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825624_e4702cea837d4917bc3597d0557213f3.pdf', 'https://manifest.fship.in/files/label/label_1825624_21a0fb4b07ba450095f089d7f58ffa3a.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-13 13:58:18', 1, '77799147226', '2026-05-13 13:58:18', 'Success: Manifest Generated', '2026-05-13 13:58:18'),
(110, 1825626, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825626_7e69ca11a42342c0a5461feee34585e1.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825626_70c63803c7614441ba8eb65bf7d1a495.pdf', 'https://manifest.fship.in/files/label/label_1825626_18037c559f12464a8281436e128ca9f7.pdf', 'Bluedart Surface 500 Gm', NULL, 1, '2026-05-13 13:58:18', 1, '77799147300', '2026-05-13 13:58:18', 'Success: Manifest Generated', '2026-05-13 13:58:18'),
(111, 1825623, NULL, 'https://manifest.fship.in/files/manifest/manifest_1825623_6b10c313dcd04d4c8727cff6103323f1.pdf', 'https://manifest.fship.in/files/invoice/invoice_1825623_692886b88a7c4de79f2f7b65dea1a4e8.pdf', 'https://manifest.fship.in/files/label/label_1825623_ee3ea19570f547cb837a743021c5f4b9.pdf', 'Delhivery Surface (Brand)', NULL, 1, '2026-05-13 13:58:18', 1, '37355837832910', '2026-05-13 13:58:18', 'Success: Manifest Generated', '2026-05-13 13:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_labels`
--

CREATE TABLE `shipping_labels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fship_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `label_number` varchar(255) DEFAULT NULL,
  `barcode_path` varchar(255) DEFAULT NULL,
  `label_size` enum('4x6','A4','A6') NOT NULL DEFAULT '4x6',
  `status` enum('Generated','Printed','Cancelled') NOT NULL DEFAULT 'Generated',
  `generated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `generated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `label_display_name` varchar(255) DEFAULT NULL,
  `label_printer` varchar(255) NOT NULL DEFAULT 'A4 Size',
  `label_template` varchar(255) NOT NULL DEFAULT 'Standard A4',
  `show_signature_on_label` tinyint(1) NOT NULL DEFAULT 0,
  `template_settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`template_settings`)),
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rates_mini`
--

CREATE TABLE `shipping_rates_mini` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('mini','B2C','B2B') NOT NULL DEFAULT 'B2C',
  `plan_name` varchar(255) DEFAULT NULL,
  `courier_id` bigint(20) UNSIGNED NOT NULL,
  `mode` enum('surface','air','express') NOT NULL,
  `mode_icon` varchar(255) DEFAULT NULL,
  `weight_info` varchar(255) DEFAULT NULL,
  `add_weight` decimal(8,2) NOT NULL DEFAULT 0.00,
  `zone_a_forward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_a_rto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_a_add_forward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_a_add_rto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_a_cod_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_a_cod_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `zone_b_forward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_b_rto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_b_add_forward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_b_add_rto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_b_cod_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_b_cod_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `zone_c_forward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_c_rto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_c_add_forward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_c_add_rto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_c_cod_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_c_cod_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `zone_d_forward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_d_rto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_d_add_forward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_d_add_rto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_d_cod_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_d_cod_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `zone_e_forward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_e_rto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_e_add_forward` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_e_add_rto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_e_cod_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `zone_e_cod_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_rates_mini`
--

INSERT INTO `shipping_rates_mini` (`id`, `user_id`, `type`, `plan_name`, `courier_id`, `mode`, `mode_icon`, `weight_info`, `add_weight`, `zone_a_forward`, `zone_a_rto`, `zone_a_add_forward`, `zone_a_add_rto`, `zone_a_cod_charge`, `zone_a_cod_percent`, `zone_b_forward`, `zone_b_rto`, `zone_b_add_forward`, `zone_b_add_rto`, `zone_b_cod_charge`, `zone_b_cod_percent`, `zone_c_forward`, `zone_c_rto`, `zone_c_add_forward`, `zone_c_add_rto`, `zone_c_cod_charge`, `zone_c_cod_percent`, `zone_d_forward`, `zone_d_rto`, `zone_d_add_forward`, `zone_d_add_rto`, `zone_d_cod_charge`, `zone_d_cod_percent`, `zone_e_forward`, `zone_e_rto`, `zone_e_add_forward`, `zone_e_add_rto`, `zone_e_cod_charge`, `zone_e_cod_percent`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(64, 36, 'mini', 'Professional', 29, 'surface', NULL, '0.500', 0.50, 80.00, 9.00, 80.00, 80.00, 10.00, 1.00, 80.00, 9.00, 80.00, 80.00, 10.00, 1.00, 80.00, 9.00, 80.00, 80.00, 10.00, 1.00, 80.00, 9.00, 80.00, 80.00, 10.00, 1.00, 80.00, 9.00, 80.00, 80.00, 10.00, 1.00, 1, '2026-05-05 12:27:52', '2026-05-05 12:27:52', NULL),
(65, 36, 'mini', 'Professional', 20, 'surface', NULL, '0.500', 0.50, 83.00, 9.00, 83.00, 83.00, 10.00, 1.00, 83.00, 9.00, 83.00, 83.00, 10.00, 1.00, 83.00, 9.00, 83.00, 83.00, 10.00, 1.00, 83.00, 9.00, 83.00, 83.00, 10.00, 1.00, 83.00, 9.00, 83.00, 83.00, 10.00, 1.00, 1, '2026-05-05 12:32:13', '2026-05-05 12:32:13', NULL),
(66, 36, 'mini', 'Professional', 33, 'surface', NULL, '0.500', 0.50, 75.00, 9.00, 75.00, 75.00, 8.00, 1.00, 75.00, 9.00, 75.00, 75.00, 8.00, 1.00, 75.00, 9.00, 75.00, 75.00, 8.00, 1.00, 75.00, 9.00, 75.00, 75.00, 8.00, 1.00, 75.00, 9.00, 75.00, 75.00, 8.00, 1.00, 1, '2026-05-05 12:34:26', '2026-05-05 12:34:26', NULL),
(67, 36, 'mini', 'Professional', 28, 'surface', NULL, '0.500', 0.50, 70.00, 9.00, 70.00, 70.00, 10.00, 1.00, 70.00, 9.00, 70.00, 70.00, 10.00, 1.00, 70.00, 9.00, 70.00, 70.00, 10.00, 1.00, 70.00, 9.00, 70.00, 70.00, 10.00, 1.00, 70.00, 9.00, 70.00, 70.00, 10.00, 1.00, 1, '2026-05-05 13:00:59', '2026-05-05 13:00:59', NULL),
(68, 39, 'mini', 'Starter', 20, 'surface', NULL, '0.500', 0.50, 100.00, 42.00, 51.00, 61.00, 20.00, 1.00, 101.00, 43.00, 52.00, 62.00, 20.00, 1.00, 102.00, 45.00, 53.00, 63.00, 20.00, 1.00, 103.00, 47.00, 54.00, 64.00, 20.00, 1.00, 104.00, 42.00, 55.00, 65.00, 20.00, 1.00, 1, '2026-05-06 09:03:43', '2026-05-06 09:03:43', NULL),
(69, 41, 'mini', 'Starter', 20, 'surface', NULL, '0.5', 0.50, 100.00, 20.00, 20.00, 20.00, 20.00, 1.00, 100.00, 20.00, 20.00, 20.00, 20.00, 1.00, 100.00, 20.00, 20.00, 20.00, 20.00, 1.00, 100.00, 20.00, 20.00, 20.00, 20.00, 1.00, 100.00, 20.00, 20.00, 20.00, 20.00, 1.00, 1, '2026-05-06 12:32:16', '2026-05-06 12:32:16', NULL),
(70, 39, 'mini', 'Starter', 26, 'surface', NULL, '1', 1.00, 100.00, 2.00, 20.00, 30.00, 30.00, 1.00, 100.00, 20.00, 20.00, 30.00, 30.00, 1.00, 100.00, 20.00, 20.00, 30.00, 30.00, 1.00, 100.00, 20.00, 20.00, 30.00, 30.00, 1.00, 100.00, 20.00, 20.00, 30.00, 30.00, 1.00, 1, '2026-05-13 12:06:32', '2026-05-13 12:06:32', NULL),
(71, 39, 'mini', 'Starter', 34, 'surface', NULL, '1', 1.00, 95.00, 92.00, 15.00, 15.00, 34.00, 0.00, 105.00, 102.00, 16.00, 16.00, 34.00, 0.00, 133.00, 129.00, 18.00, 18.00, 34.00, 0.00, 152.00, 149.00, 19.00, 19.00, 34.00, 0.00, 190.00, 187.00, 25.00, 25.00, 34.00, 0.00, 1, '2026-05-14 02:13:34', '2026-05-14 02:13:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `sub_category` varchar(255) NOT NULL,
  `reference_id` varchar(255) NOT NULL,
  `remark` text DEFAULT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `status` enum('open','in_progress','resolved','closed') NOT NULL DEFAULT 'open',
  `admin_response` text DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_code` varchar(6) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','seller_admin','user') NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `remember_password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_code`, `name`, `email`, `phone`, `profile_image`, `email_verified_at`, `role`, `password`, `suspended_at`, `remember_password`, `remember_token`, `created_at`, `updated_at`) VALUES
(9, '123212', 'Admin', 'admin@admin.com', NULL, NULL, NULL, 'admin', '$2y$12$4kJzGSxlIT8Tcv1fYZc3FesBfVf/kYG6obcESlHXHbMcLl9Ws9DiW', NULL, NULL, NULL, '2026-03-13 04:11:55', '2026-03-13 04:11:55'),
(36, '675645', 'Nikunj Gogadani', 'Ayurahealthcares@gmail.com', '7284879486', 'profile_images/1778043830_69facbb63dd1c.png', NULL, 'seller_admin', '$2y$12$uYcRM46H6MHe/I8huZOCqOkX.yFYfgxCYVOGh7ZDOITpQAbAyfjsy', NULL, 'Ayura@123', 'RWcfHTP8AP5mHU16eIWDRGgVr0harRZ9XQHEvv7iShjRAZHa8gDcngDmx3Y7', '2026-05-05 12:25:40', '2026-05-06 05:03:50'),
(37, '987867', 'Sahab Hussain', 'hussainsahab69@gmail.com', '9769327359', NULL, NULL, 'seller_admin', '$2y$12$CWBrXNv2ELa4C1IQ.kDFcOJsPK2/ttfA1cF5HaAb4h4cragRZcHP6', NULL, 'Raj@1234', '658807', '2026-05-05 21:11:37', '2026-05-05 21:11:37'),
(38, '876545', 'Lucky Faizan', 'lucky@123', '9499596286', NULL, NULL, 'seller_admin', '$2y$12$0ZG6o.GvWQKUMqAWlHQEFuVU0F.UYj5hH7HZEaibNkMoNJ3SkFEgS', NULL, 'Lucky123', '318864', '2026-05-05 22:03:48', '2026-05-05 22:03:48'),
(39, '009988', 'Shivam Kumar', 'shivaminfoes@gmail.com', '9060454764', NULL, NULL, 'seller_admin', '$2y$12$L.n5W5SOfcrN61hmwDRdVu9kgtU48aK9BmuaCm.MuHVx4vcOUMnWy', NULL, 'Shivam@123', 'eDQWsZ6Jupo13FiVrbJOlkeZ0xsXdXZF9KknaIJWe0TOvAwlVGa5Q0RXv2RW', '2026-05-06 08:52:49', '2026-05-06 08:52:49'),
(40, '786756', 'Ravi Kumar', 'nikhelenterprises2022@gmail.com', '8076514828', NULL, NULL, 'seller_admin', '$2y$12$lRU6qp/bAkgc1KMn1dfx3upmlMjHef19UOC9780dOYYB6/oqdAe9a', NULL, 'Ravi@1122', 'oaVO4UXkW55WHIVGCmSGKKUk4EULkhitugbdcJ2LnMVKGWQJzKVhIb2hY3bi', '2026-05-06 11:06:15', '2026-05-06 11:06:15'),
(41, '876756', 'kumar JI', 'kumar@gmail.com', '8989898989', NULL, NULL, 'seller_admin', '$2y$12$bJrmcd9/TzFphuVSTu/LdeBdQrLfewWcydcBcX5Uq3tWK7QqMRPNC', NULL, '12345678', 'z2IgL8Aeyy8drPTnuMFaMBeBmiIcqguxRIIIGGvdkovcuCocrVyyyUgqakaj', '2026-05-06 12:26:00', '2026-05-06 12:26:00'),
(42, '098789', 'Krist Karn', 'kkarn4038@gmail.com', '918882736613', NULL, NULL, 'seller_admin', '$2y$12$ZIbrPCPu4ADQ/X2o8gkqNu4onJ1f31EMxvC.1hPtmWXxIG14Gtf0m', NULL, 'Krist@143', '152777', '2026-05-06 15:00:04', '2026-05-06 15:00:04'),
(43, '908769', 'Gaurav Mundada', 'gauravmundadansk26@gmail.com', '8600545434', NULL, NULL, 'seller_admin', '$2y$12$TJyaIS5Rk7qbGnxEc0BYseyKFSSW4pGcHl4LTL4u.BCuFodt.n1si', NULL, 'Mundada@26', '958988', '2026-05-10 05:20:33', '2026-05-10 05:20:33'),
(44, '909098', 'Rajesh panjwani', 'rajeshpanjwani164@gmail.com', '+917355260090', NULL, NULL, 'seller_admin', '$2y$12$L7x7COVUCXcgEchdxY8xKeSGGmYCkHXkwP7pv603P3oW/EXkrYY5u', NULL, 'Rajesh@123', '572394', '2026-05-10 09:47:41', '2026-05-10 09:47:41'),
(45, '987860', 'shubam shingh', 'shubham@gmail.com', '9089789878', NULL, NULL, 'seller_admin', '$2y$12$fQYkIjntAeo5jDOiIug1AeTVzLXtDPg0BH1MR0QePBPbGI7oxKRf.', NULL, 'Shubham@123', 'vwvjy9bYQQIdD7Qp7v74ihnb6oI6IpCNyPlnxh7dioiK9zGjVTdFbzbIYhHx', '2026-05-15 07:35:53', '2026-05-15 07:35:53'),
(46, '350000', 'shubam shingh', 'shubham1@gmail.com', '9089789878', NULL, NULL, 'seller_admin', '$2y$12$NwB0NEgQUEyruonkgGWJtuR6RFWDOM20QqaWe0fPViFlseC54fHxG', NULL, 'Shubham@123', NULL, '2026-05-15 08:08:43', '2026-05-15 08:08:43');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_addresses`
--

CREATE TABLE `vendor_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pickup_address_id` bigint(20) UNSIGNED NOT NULL,
  `pick_address_id` varchar(255) DEFAULT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `vendor_gstin` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES
(32, 36, 4845.00, '2026-05-05 12:25:40', '2026-05-17 03:45:10'),
(33, 37, 0.00, '2026-05-05 21:11:37', '2026-05-05 21:11:37'),
(34, 38, 0.00, '2026-05-05 22:03:48', '2026-05-05 22:03:48'),
(35, 39, 5000.00, '2026-05-06 08:52:49', '2026-05-14 05:30:15'),
(36, 40, 0.00, '2026-05-06 11:06:15', '2026-05-06 11:06:15'),
(37, 41, 500.00, '2026-05-06 12:26:00', '2026-05-06 12:51:23'),
(38, 42, 0.00, '2026-05-06 15:00:04', '2026-05-06 15:00:04'),
(39, 43, 0.00, '2026-05-10 05:20:33', '2026-05-10 05:20:33'),
(40, 44, 0.00, '2026-05-10 09:47:41', '2026-05-10 09:47:41'),
(41, 45, 0.00, '2026-05-15 07:35:53', '2026-05-15 07:35:53'),
(42, 46, 0.00, '2026-05-15 08:08:43', '2026-05-15 08:08:43');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_recharges`
--

CREATE TABLE `wallet_recharges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `razorpay_signature` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `processed_at` timestamp NULL DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `failure_reason` text DEFAULT NULL COMMENT 'Reason for payment failure',
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_recharges`
--

INSERT INTO `wallet_recharges` (`id`, `user_id`, `amount`, `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`, `status`, `processed_at`, `metadata`, `failure_reason`, `payment_method`, `created_at`, `updated_at`) VALUES
(23, 36, 100.00, 'order_Slxhx3duaHo1SA', 'pay_Slxi87x41YMvAz', '26dd0fba4675b928e0979fd5c72b48dffc8031624d0be61c390e941d3b765a9d', 'success', '2026-05-06 05:25:07', '{\"email\":null,\"contact\":null}', NULL, 'card', '2026-05-06 05:24:40', '2026-05-06 05:25:07'),
(24, 41, 500.00, 'order_Sm50Bb0t6abVzu', 'pay_Sm50QKvoFP24nz', '92edc0c22ea91ed88d4490052b6c64ac1a6c0db6d594eb3cb426c7b22b0c3837', 'success', '2026-05-06 12:33:18', '{\"email\":null,\"contact\":null}', NULL, 'card', '2026-05-06 12:32:47', '2026-05-06 12:33:18'),
(25, 36, 100.00, 'order_Sm6xGW3xBhM8xq', NULL, NULL, 'pending', NULL, NULL, NULL, NULL, '2026-05-06 14:27:24', '2026-05-06 14:27:24'),
(26, 39, 100.00, 'order_SmJMUk7VgLWMdY', NULL, NULL, 'pending', NULL, NULL, NULL, NULL, '2026-05-07 02:35:36', '2026-05-07 02:35:36'),
(27, 36, 1000.00, 'order_SmKARf6zcnlqqc', NULL, NULL, 'pending', NULL, NULL, NULL, NULL, '2026-05-07 03:22:54', '2026-05-07 03:22:54'),
(28, 40, 100.00, 'order_SmMjyuoWwudACS', NULL, NULL, 'pending', NULL, NULL, NULL, NULL, '2026-05-07 05:53:55', '2026-05-07 05:53:55'),
(29, 39, 100.00, 'order_SmOH6FxdAViPna', NULL, NULL, 'pending', NULL, NULL, NULL, NULL, '2026-05-07 07:23:58', '2026-05-07 07:23:58'),
(30, 39, 100.00, 'PP_1778153781_39', NULL, NULL, 'failed', NULL, NULL, 'Payment state: FAILED', 'phonepe', '2026-05-07 11:36:21', '2026-05-07 11:36:35'),
(31, 39, 1.00, 'PP_1778153804_39', NULL, NULL, 'success', '2026-05-07 11:37:31', NULL, NULL, 'phonepe', '2026-05-07 11:36:44', '2026-05-07 11:37:31'),
(32, 36, 100.00, 'PP_1778168482_36', NULL, NULL, 'failed', NULL, NULL, 'Payment state: FAILED', 'phonepe', '2026-05-07 15:41:22', '2026-05-07 15:41:46'),
(33, 39, 100.00, 'PP_1778168873_39', NULL, NULL, 'success', '2026-05-07 15:48:34', NULL, NULL, 'phonepe', '2026-05-07 15:47:53', '2026-05-07 15:48:34'),
(34, 36, 5000.00, 'PP_1778211723_36', NULL, NULL, 'success', '2026-05-08 03:43:29', NULL, NULL, 'phonepe', '2026-05-08 03:42:03', '2026-05-08 03:43:29'),
(35, 36, 100.00, 'PP_1778300609_36', NULL, NULL, 'failed', NULL, NULL, 'Payment state: FAILED', 'phonepe', '2026-05-09 04:23:29', '2026-05-09 04:24:32'),
(36, 36, 100.00, 'PP_1778374291_36', NULL, NULL, 'failed', NULL, NULL, 'Payment state: FAILED', 'phonepe', '2026-05-10 00:51:31', '2026-05-10 00:52:08'),
(37, 36, 1000.00, 'PP_1778375205_36', NULL, NULL, 'pending', NULL, NULL, NULL, 'phonepe', '2026-05-10 01:06:45', '2026-05-10 01:06:45'),
(38, 36, 3000.00, 'PP_1778386058_36', NULL, NULL, 'success', '2026-05-10 04:08:33', NULL, NULL, 'phonepe', '2026-05-10 04:07:38', '2026-05-10 04:08:33'),
(39, 43, 100.00, 'PP_1778390762_43', NULL, NULL, 'failed', NULL, NULL, 'Payment state: FAILED', 'phonepe', '2026-05-10 05:26:02', '2026-05-10 05:26:24'),
(40, 39, 100.00, 'PP_1778466643_39', NULL, NULL, 'failed', NULL, NULL, 'Payment state: FAILED', 'phonepe', '2026-05-11 02:30:43', '2026-05-11 02:30:54'),
(41, 39, 5.00, 'PP_1778469211_39', NULL, NULL, 'success', '2026-05-11 03:13:58', NULL, NULL, 'phonepe', '2026-05-11 03:13:31', '2026-05-11 03:13:58'),
(42, 36, 2000.00, 'PP_1778600801_36', NULL, NULL, 'success', '2026-05-12 15:47:38', NULL, NULL, 'phonepe', '2026-05-12 15:46:41', '2026-05-12 15:47:38'),
(43, 36, 5000.00, 'PP_1778676791_36', NULL, NULL, 'success', '2026-05-13 12:54:08', NULL, NULL, 'phonepe', '2026-05-13 12:53:11', '2026-05-13 12:54:08');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `fship_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('credit','debit') NOT NULL,
  `charge_type` enum('forward','cod','rto','tax','recharge','cod_refund') NOT NULL,
  `source` varchar(50) DEFAULT 'admin_manual' COMMENT 'Source: admin_manual, razorpay, fship_booking, etc.',
  `opening_balance` decimal(10,2) NOT NULL,
  `closing_balance` decimal(10,2) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_transactions`
--

INSERT INTO `wallet_transactions` (`id`, `user_id`, `fship_order_id`, `amount`, `type`, `charge_type`, `source`, `opening_balance`, `closing_balance`, `remark`, `created_at`, `updated_at`) VALUES
(124, 36, NULL, 1000.00, 'credit', 'recharge', 'admin_manual', 0.00, 1000.00, 'Net Banking', '2026-05-06 05:05:24', '2026-05-06 05:05:24'),
(125, 36, 149, 117.94, 'debit', 'forward', 'admin_manual', 1000.00, 882.06, 'Booking AWB: 77789693446', '2026-05-06 05:07:23', '2026-05-06 05:07:23'),
(126, 36, 148, 117.94, 'debit', 'forward', 'admin_manual', 882.06, 764.12, 'Booking AWB: 77789693752', '2026-05-06 05:07:34', '2026-05-06 05:07:34'),
(127, 36, 146, 117.94, 'debit', 'forward', 'admin_manual', 764.12, 646.18, 'Booking AWB: 77789694006', '2026-05-06 05:07:47', '2026-05-06 05:07:47'),
(128, 36, 147, 117.94, 'debit', 'forward', 'admin_manual', 646.18, 528.24, 'Booking AWB: 77789694566', '2026-05-06 05:07:58', '2026-05-06 05:07:58'),
(129, 36, 145, 117.94, 'debit', 'forward', 'admin_manual', 528.24, 410.30, 'Booking AWB: 77789705976', '2026-05-06 05:10:56', '2026-05-06 05:10:56'),
(130, 36, 143, 117.94, 'debit', 'forward', 'admin_manual', 410.30, 292.36, 'Booking AWB: 77789707774', '2026-05-06 05:11:08', '2026-05-06 05:11:08'),
(131, 36, 144, 117.94, 'debit', 'forward', 'admin_manual', 292.36, 174.42, 'Booking AWB: 77789710132', '2026-05-06 05:11:22', '2026-05-06 05:11:22'),
(132, 36, 142, 114.40, 'debit', 'forward', 'admin_manual', 174.42, 60.02, 'Booking AWB: 37355837525212', '2026-05-06 05:13:45', '2026-05-06 05:13:45'),
(133, 36, NULL, 100.00, 'credit', 'recharge', 'razorpay', 60.02, 160.02, 'Razorpay Recharge: pay_Slxi87x41YMvAz', '2026-05-06 05:25:07', '2026-05-06 05:25:07'),
(134, 36, 150, 107.94, 'debit', 'forward', 'admin_manual', 160.02, 52.08, 'Booking AWB: 77789758056', '2026-05-06 05:28:10', '2026-05-06 05:28:10'),
(135, 36, 150, 107.94, 'credit', '', 'order_cancellation', 52.08, 160.02, 'Refund for cancelled order #20260506051637', '2026-05-06 06:01:11', '2026-05-06 06:01:11'),
(136, 39, NULL, 200.00, 'credit', 'recharge', 'admin_manual', 0.00, 200.00, 'Sign up bonus', '2026-05-06 08:58:11', '2026-05-06 08:58:11'),
(137, 39, NULL, 500.00, 'credit', 'recharge', 'admin_manual', 200.00, 700.00, 'Sign up bonus', '2026-05-06 08:58:31', '2026-05-06 08:58:31'),
(138, 39, 154, 200.54, 'debit', 'forward', 'admin_manual', 700.00, 499.46, 'Booking AWB: 77790204741', '2026-05-06 09:16:30', '2026-05-06 09:16:30'),
(139, 39, 152, 139.18, 'debit', 'forward', 'admin_manual', 499.46, 360.28, 'Booking AWB: 77790205054', '2026-05-06 09:16:41', '2026-05-06 09:16:41'),
(140, 39, 153, 119.18, 'debit', 'forward', 'admin_manual', 360.28, 241.10, 'Booking AWB: 76964125173', '2026-05-06 09:17:30', '2026-05-06 09:17:30'),
(141, 39, 155, 119.18, 'debit', 'forward', 'admin_manual', 241.10, 121.92, 'Booking AWB: 76964129410', '2026-05-06 09:19:35', '2026-05-06 09:19:35'),
(142, 41, NULL, 500.00, 'credit', 'recharge', 'razorpay', 0.00, 500.00, 'Razorpay Recharge: pay_Sm50QKvoFP24nz', '2026-05-06 12:33:18', '2026-05-06 12:33:18'),
(143, 41, 156, 138.00, 'debit', 'forward', 'admin_manual', 500.00, 362.00, 'Booking AWB: 77790449796', '2026-05-06 12:34:18', '2026-05-06 12:34:18'),
(144, 41, 156, 138.00, 'credit', '', 'order_cancellation', 362.00, 500.00, 'Refund for cancelled order #1092993824437', '2026-05-06 12:46:33', '2026-05-06 12:46:33'),
(145, 41, 157, 138.00, 'debit', 'forward', 'admin_manual', 500.00, 362.00, 'Booking AWB: 77790462772', '2026-05-06 12:48:50', '2026-05-06 12:48:50'),
(146, 41, 157, 138.00, 'credit', '', 'order_cancellation', 362.00, 500.00, 'Refund for cancelled order #5678678668676', '2026-05-06 12:51:23', '2026-05-06 12:51:23'),
(147, 36, 159, 107.94, 'debit', 'forward', 'admin_manual', 160.02, 52.08, 'Booking AWB: 77790553190', '2026-05-06 16:04:07', '2026-05-06 16:04:07'),
(148, 36, NULL, 1000.00, 'credit', 'recharge', 'admin_manual', 52.08, 1052.08, 'Deposited by Bank Transfer', '2026-05-07 03:37:09', '2026-05-07 03:37:09'),
(149, 36, 166, 107.94, 'debit', 'forward', 'admin_manual', 1052.08, 944.14, 'Booking AWB: 77790727556', '2026-05-07 03:39:14', '2026-05-07 03:39:14'),
(150, 36, 165, 107.94, 'debit', 'forward', 'admin_manual', 944.14, 836.20, 'Booking AWB: 77790727663', '2026-05-07 03:39:25', '2026-05-07 03:39:25'),
(151, 36, 164, 107.94, 'debit', 'forward', 'admin_manual', 836.20, 728.26, 'Booking AWB: 77790727840', '2026-05-07 03:39:36', '2026-05-07 03:39:36'),
(152, 36, 163, 107.94, 'debit', 'forward', 'admin_manual', 728.26, 620.32, 'Booking AWB: 77790727980', '2026-05-07 03:39:48', '2026-05-07 03:39:48'),
(153, 36, 162, 107.94, 'debit', 'forward', 'admin_manual', 620.32, 512.38, 'Booking AWB: 77790728153', '2026-05-07 03:40:03', '2026-05-07 03:40:03'),
(154, 36, 161, 107.94, 'debit', 'forward', 'admin_manual', 512.38, 404.44, 'Booking AWB: 77790728540', '2026-05-07 03:40:22', '2026-05-07 03:40:22'),
(155, 36, 160, 107.94, 'debit', 'forward', 'admin_manual', 404.44, 296.50, 'Booking AWB: 77790728702', '2026-05-07 03:40:34', '2026-05-07 03:40:34'),
(156, 36, 169, 107.94, 'debit', 'forward', 'admin_manual', 296.50, 188.56, 'Booking AWB: 77790752771', '2026-05-07 03:58:35', '2026-05-07 03:58:35'),
(157, 36, 170, 94.40, 'debit', 'forward', 'admin_manual', 188.56, 94.16, 'Booking AWB: 37355837556093', '2026-05-07 04:00:32', '2026-05-07 04:00:32'),
(158, 36, 170, 94.40, 'credit', '', 'order_cancellation', 94.16, 188.56, 'Refund for cancelled order #20260507035951', '2026-05-07 04:02:58', '2026-05-07 04:02:58'),
(159, 39, NULL, 1.00, 'credit', 'recharge', 'phonepe', 121.92, 122.92, 'PhonePe Wallet Recharge', '2026-05-07 11:37:31', '2026-05-07 11:37:31'),
(160, 39, NULL, 100.00, 'credit', 'recharge', 'phonepe', 122.92, 222.92, 'PhonePe Wallet Recharge', '2026-05-07 15:48:34', '2026-05-07 15:48:34'),
(161, 36, NULL, 5000.00, 'credit', 'recharge', 'phonepe', 188.56, 5188.56, 'PhonePe Wallet Recharge', '2026-05-08 03:43:29', '2026-05-08 03:43:29'),
(162, 36, 181, 107.94, 'debit', 'forward', 'admin_manual', 5188.56, 5080.62, 'Booking AWB: 77791996936', '2026-05-08 03:49:16', '2026-05-08 03:49:16'),
(163, 36, 179, 107.94, 'debit', 'forward', 'admin_manual', 5080.62, 4972.68, 'Booking AWB: 77792017903', '2026-05-08 04:03:37', '2026-05-08 04:03:37'),
(164, 36, 177, 107.94, 'debit', 'forward', 'admin_manual', 4972.68, 4864.74, 'Booking AWB: 77792019911', '2026-05-08 04:04:55', '2026-05-08 04:04:55'),
(165, 36, 175, 107.94, 'debit', 'forward', 'admin_manual', 4864.74, 4756.80, 'Booking AWB: 77792021101', '2026-05-08 04:05:09', '2026-05-08 04:05:09'),
(166, 36, 176, 107.94, 'debit', 'forward', 'admin_manual', 4756.80, 4648.86, 'Booking AWB: 77792023982', '2026-05-08 04:05:36', '2026-05-08 04:05:36'),
(167, 36, 178, 104.40, 'debit', 'forward', 'admin_manual', 4648.86, 4544.46, 'Booking AWB: 37355837604522', '2026-05-08 04:21:07', '2026-05-08 04:21:07'),
(168, 36, 174, 107.94, 'debit', 'forward', 'admin_manual', 4544.46, 4436.52, 'Booking AWB: 77792076213', '2026-05-08 04:21:26', '2026-05-08 04:21:26'),
(169, 36, 182, 104.40, 'debit', 'forward', 'admin_manual', 4436.52, 4332.12, 'Booking AWB: 37355837612535', '2026-05-08 04:58:48', '2026-05-08 04:58:48'),
(171, 36, 180, 104.40, 'debit', 'forward', 'admin_manual', 4332.12, 4227.72, 'Booking AWB: 37355837616293', '2026-05-08 06:28:35', '2026-05-08 06:28:35'),
(172, 39, 183, 140.36, 'debit', 'forward', 'admin_manual', 500.00, 359.64, 'Booking AWB: 77792554302', '2026-05-08 07:22:44', '2026-05-08 07:22:44'),
(173, 39, 183, 140.36, 'credit', '', 'order_cancellation', 359.64, 500.00, 'Refund for cancelled order #20260508061420', '2026-05-08 09:59:58', '2026-05-08 09:59:58'),
(176, 39, 186, 140.36, 'debit', 'forward', 'admin_manual', 219.28, 78.92, 'Booking AWB: 77793014036', '2026-05-08 12:37:45', '2026-05-08 12:37:45'),
(177, 36, 207, 107.94, 'debit', 'forward', 'admin_manual', 4227.72, 4119.78, 'Booking AWB: 77793101562', '2026-05-08 15:57:34', '2026-05-08 15:57:34'),
(178, 36, 206, 107.94, 'debit', 'forward', 'admin_manual', 4119.78, 4011.84, 'Booking AWB: 77793101595', '2026-05-08 15:57:47', '2026-05-08 15:57:47'),
(179, 36, 205, 107.94, 'debit', 'forward', 'admin_manual', 4011.84, 3903.90, 'Booking AWB: 77793101665', '2026-05-08 15:58:06', '2026-05-08 15:58:06'),
(180, 36, 204, 107.94, 'debit', 'forward', 'admin_manual', 3903.90, 3795.96, 'Booking AWB: 77793101691', '2026-05-08 15:58:18', '2026-05-08 15:58:18'),
(181, 36, 203, 104.40, 'debit', 'forward', 'admin_manual', 3795.96, 3691.56, 'Booking AWB: 37355837633966', '2026-05-08 15:58:30', '2026-05-08 15:58:30'),
(182, 36, 202, 104.40, 'debit', 'forward', 'admin_manual', 3691.56, 3587.16, 'Booking AWB: 37355837633970', '2026-05-08 15:58:41', '2026-05-08 15:58:41'),
(183, 36, 199, 104.40, 'debit', 'forward', 'admin_manual', 3587.16, 3482.76, 'Booking AWB: 37355837634014', '2026-05-08 16:02:10', '2026-05-08 16:02:10'),
(184, 36, 198, 107.94, 'debit', 'forward', 'admin_manual', 3482.76, 3374.82, 'Booking AWB: 77793102612', '2026-05-08 16:02:29', '2026-05-08 16:02:29'),
(185, 36, 200, 107.94, 'debit', 'forward', 'admin_manual', 3374.82, 3266.88, 'Booking AWB: 77793102936', '2026-05-08 16:03:33', '2026-05-08 16:03:33'),
(186, 36, 197, 107.94, 'debit', 'forward', 'admin_manual', 3266.88, 3158.94, 'Booking AWB: 77793103006', '2026-05-08 16:03:52', '2026-05-08 16:03:52'),
(187, 36, 201, 104.40, 'debit', 'forward', 'admin_manual', 3158.94, 3054.54, 'Booking AWB: 37355837634051', '2026-05-08 16:05:44', '2026-05-08 16:05:44'),
(188, 36, 196, 104.40, 'debit', 'forward', 'admin_manual', 3054.54, 2950.14, 'Booking AWB: 37355837634062', '2026-05-08 16:05:55', '2026-05-08 16:05:55'),
(189, 36, 195, 107.94, 'debit', 'forward', 'admin_manual', 2950.14, 2842.20, 'Booking AWB: 77793103662', '2026-05-08 16:06:10', '2026-05-08 16:06:10'),
(190, 36, 194, 92.60, 'debit', 'forward', 'admin_manual', 2842.20, 2749.60, 'Booking AWB: 369197820427', '2026-05-08 16:06:34', '2026-05-08 16:06:34'),
(191, 36, 193, 104.40, 'debit', 'forward', 'admin_manual', 2749.60, 2645.20, 'Booking AWB: 37355837634084', '2026-05-08 16:06:48', '2026-05-08 16:06:48'),
(192, 36, 192, 104.40, 'debit', 'forward', 'admin_manual', 2645.20, 2540.80, 'Booking AWB: 37355837634095', '2026-05-08 16:07:00', '2026-05-08 16:07:00'),
(193, 36, 191, 104.40, 'debit', 'forward', 'admin_manual', 2540.80, 2436.40, 'Booking AWB: 37355837634106', '2026-05-08 16:07:11', '2026-05-08 16:07:11'),
(194, 36, 190, 104.40, 'debit', 'forward', 'admin_manual', 2436.40, 2332.00, 'Booking AWB: 37355837634110', '2026-05-08 16:08:14', '2026-05-08 16:08:14'),
(195, 36, 189, 104.40, 'debit', 'forward', 'admin_manual', 2332.00, 2227.60, 'Booking AWB: 37355837634121', '2026-05-08 16:09:41', '2026-05-08 16:09:41'),
(196, 36, 188, 107.94, 'debit', 'forward', 'admin_manual', 2227.60, 2119.66, 'Booking AWB: 77793104476', '2026-05-08 16:09:56', '2026-05-08 16:09:56'),
(197, 36, 187, 107.94, 'debit', 'forward', 'admin_manual', 2119.66, 2011.72, 'Booking AWB: 77793104675', '2026-05-08 16:10:06', '2026-05-08 16:10:06'),
(198, 36, 182, 104.40, 'credit', '', 'order_cancellation', 2011.72, 2116.12, 'Refund for cancelled order #20260508045808', '2026-05-09 02:07:18', '2026-05-09 02:07:18'),
(199, 36, 182, 104.40, 'credit', '', 'order_cancellation', 2116.12, 2220.52, 'Refund for cancelled order #20260508045808', '2026-05-09 02:07:21', '2026-05-09 02:07:21'),
(200, 36, 208, 107.94, 'debit', 'forward', 'admin_manual', 2220.52, 2112.58, 'Booking AWB: 77793260204', '2026-05-09 03:07:21', '2026-05-09 03:07:21'),
(201, 36, 208, 107.94, 'credit', '', 'order_cancellation', 2112.58, 2220.52, 'Refund for cancelled order #20260509030321', '2026-05-09 03:07:29', '2026-05-09 03:07:29'),
(202, 39, NULL, 500.00, 'credit', 'recharge', 'admin_manual', 78.92, 578.92, 'Admin credit: ₹500 via admin_manual', '2026-05-09 12:12:30', '2026-05-09 12:12:30'),
(203, 36, 221, 104.40, 'debit', 'forward', 'admin_manual', 2220.52, 2116.12, 'Booking AWB: 37355837674382', '2026-05-09 15:02:05', '2026-05-09 15:02:05'),
(204, 36, 220, 104.40, 'debit', 'forward', 'admin_manual', 2116.12, 2011.72, 'Booking AWB: 37355837674393', '2026-05-09 15:02:15', '2026-05-09 15:02:15'),
(205, 36, 218, 104.40, 'debit', 'forward', 'admin_manual', 2011.72, 1907.32, 'Booking AWB: 37355837674404', '2026-05-09 15:02:28', '2026-05-09 15:02:28'),
(206, 36, 219, 107.94, 'debit', 'forward', 'admin_manual', 1907.32, 1799.38, 'Booking AWB: 77794325232', '2026-05-09 15:02:45', '2026-05-09 15:02:45'),
(207, 36, 217, 104.40, 'debit', 'forward', 'admin_manual', 1799.38, 1694.98, 'Booking AWB: 37355837674415', '2026-05-09 15:02:56', '2026-05-09 15:02:56'),
(208, 36, 216, 107.94, 'debit', 'forward', 'admin_manual', 1694.98, 1587.04, 'Booking AWB: 77794325545', '2026-05-09 15:03:20', '2026-05-09 15:03:20'),
(209, 36, 214, 107.94, 'debit', 'forward', 'admin_manual', 1587.04, 1479.10, 'Booking AWB: 77794325556', '2026-05-09 15:03:28', '2026-05-09 15:03:28'),
(210, 36, 215, 107.94, 'debit', 'forward', 'admin_manual', 1479.10, 1371.16, 'Booking AWB: 77794325571', '2026-05-09 15:03:39', '2026-05-09 15:03:39'),
(211, 36, 213, 104.40, 'debit', 'forward', 'admin_manual', 1371.16, 1266.76, 'Booking AWB: 37355837674426', '2026-05-09 15:03:51', '2026-05-09 15:03:51'),
(212, 36, 212, 107.94, 'debit', 'forward', 'admin_manual', 1266.76, 1158.82, 'Booking AWB: 77794325626', '2026-05-09 15:04:04', '2026-05-09 15:04:04'),
(213, 36, 211, 107.94, 'debit', 'forward', 'admin_manual', 1158.82, 1050.88, 'Booking AWB: 77794326330', '2026-05-09 15:04:16', '2026-05-09 15:04:16'),
(214, 36, 210, 107.94, 'debit', 'forward', 'admin_manual', 1050.88, 942.94, 'Booking AWB: 77794326374', '2026-05-09 15:04:28', '2026-05-09 15:04:28'),
(215, 36, 209, 107.94, 'debit', 'forward', 'admin_manual', 942.94, 835.00, 'Booking AWB: 77794326411', '2026-05-09 15:04:38', '2026-05-09 15:04:38'),
(216, 36, NULL, 3000.00, 'credit', 'recharge', 'phonepe', 835.00, 3835.00, 'PhonePe Wallet Recharge', '2026-05-10 04:08:33', '2026-05-10 04:08:33'),
(217, 36, 242, 107.94, 'debit', 'forward', 'admin_manual', 3835.00, 3727.06, 'Booking AWB: 77795000846', '2026-05-10 14:56:36', '2026-05-10 14:56:36'),
(218, 36, 241, 104.40, 'debit', 'forward', 'admin_manual', 3727.06, 3622.66, 'Booking AWB: 37355837687623', '2026-05-10 14:56:47', '2026-05-10 14:56:47'),
(219, 36, 240, 104.40, 'debit', 'forward', 'admin_manual', 3622.66, 3518.26, 'Booking AWB: 37355837687634', '2026-05-10 14:56:56', '2026-05-10 14:56:56'),
(220, 36, 239, 104.40, 'debit', 'forward', 'admin_manual', 3518.26, 3413.86, 'Booking AWB: 37355837687660', '2026-05-10 14:57:08', '2026-05-10 14:57:08'),
(221, 36, 238, 104.40, 'debit', 'forward', 'admin_manual', 3413.86, 3309.46, 'Booking AWB: 37355837687671', '2026-05-10 14:57:19', '2026-05-10 14:57:19'),
(222, 36, 237, 104.40, 'debit', 'forward', 'admin_manual', 3309.46, 3205.06, 'Booking AWB: 37355837687682', '2026-05-10 14:57:38', '2026-05-10 14:57:38'),
(223, 36, 236, 104.40, 'debit', 'forward', 'admin_manual', 3205.06, 3100.66, 'Booking AWB: 37355837687693', '2026-05-10 14:57:48', '2026-05-10 14:57:48'),
(224, 36, 235, 107.94, 'debit', 'forward', 'admin_manual', 3100.66, 2992.72, 'Booking AWB: 77795001314', '2026-05-10 14:58:01', '2026-05-10 14:58:01'),
(225, 36, 234, 104.40, 'debit', 'forward', 'admin_manual', 2992.72, 2888.32, 'Booking AWB: 37355837687704', '2026-05-10 14:58:13', '2026-05-10 14:58:13'),
(226, 36, 233, 104.40, 'debit', 'forward', 'admin_manual', 2888.32, 2783.92, 'Booking AWB: 37355837687715', '2026-05-10 14:58:24', '2026-05-10 14:58:24'),
(227, 36, 232, 104.40, 'debit', 'forward', 'admin_manual', 2783.92, 2679.52, 'Booking AWB: 37355837687726', '2026-05-10 14:58:35', '2026-05-10 14:58:35'),
(228, 36, 230, 104.40, 'debit', 'forward', 'admin_manual', 2679.52, 2575.12, 'Booking AWB: 37355837687730', '2026-05-10 14:59:14', '2026-05-10 14:59:14'),
(229, 36, 229, 104.40, 'debit', 'forward', 'admin_manual', 2575.12, 2470.72, 'Booking AWB: 37355837687741', '2026-05-10 14:59:27', '2026-05-10 14:59:27'),
(230, 36, 228, 104.40, 'debit', 'forward', 'admin_manual', 2470.72, 2366.32, 'Booking AWB: 37355837687752', '2026-05-10 14:59:45', '2026-05-10 14:59:45'),
(231, 36, 227, 104.40, 'debit', 'forward', 'admin_manual', 2366.32, 2261.92, 'Booking AWB: 37355837687763', '2026-05-10 14:59:55', '2026-05-10 14:59:55'),
(232, 36, 226, 104.40, 'debit', 'forward', 'admin_manual', 2261.92, 2157.52, 'Booking AWB: 37355837687774', '2026-05-10 15:00:06', '2026-05-10 15:00:06'),
(233, 36, 225, 104.40, 'debit', 'forward', 'admin_manual', 2157.52, 2053.12, 'Booking AWB: 37355837687785', '2026-05-10 15:00:17', '2026-05-10 15:00:17'),
(234, 36, 224, 104.40, 'debit', 'forward', 'admin_manual', 2053.12, 1948.72, 'Booking AWB: 37355837687796', '2026-05-10 15:00:40', '2026-05-10 15:00:40'),
(235, 36, 223, 107.94, 'debit', 'forward', 'admin_manual', 1948.72, 1840.78, 'Booking AWB: 77795001966', '2026-05-10 15:01:04', '2026-05-10 15:01:04'),
(236, 36, 231, 104.40, 'debit', 'forward', 'admin_manual', 1840.78, 1736.38, 'Booking AWB: 37355837687800', '2026-05-10 15:02:13', '2026-05-10 15:02:13'),
(237, 39, NULL, 5.00, 'credit', 'recharge', 'phonepe', 578.92, 583.92, 'PhonePe Wallet Recharge', '2026-05-11 03:13:58', '2026-05-11 03:13:58'),
(238, 36, 255, 104.40, 'debit', 'forward', 'admin_manual', 1736.38, 1631.98, 'Booking AWB: 37355837750634', '2026-05-11 15:49:48', '2026-05-11 15:49:48'),
(239, 36, 254, 104.40, 'debit', 'forward', 'admin_manual', 1631.98, 1527.58, 'Booking AWB: 37355837750656', '2026-05-11 15:49:59', '2026-05-11 15:49:59'),
(240, 36, 253, 104.40, 'debit', 'forward', 'admin_manual', 1527.58, 1423.18, 'Booking AWB: 37355837750660', '2026-05-11 15:50:24', '2026-05-11 15:50:24'),
(241, 36, 252, 107.94, 'debit', 'forward', 'admin_manual', 1423.18, 1315.24, 'Booking AWB: 77796751502', '2026-05-11 15:50:37', '2026-05-11 15:50:37'),
(242, 36, 251, 104.40, 'debit', 'forward', 'admin_manual', 1315.24, 1210.84, 'Booking AWB: 37355837750671', '2026-05-11 15:50:49', '2026-05-11 15:50:49'),
(243, 36, 250, 107.94, 'debit', 'forward', 'admin_manual', 1210.84, 1102.90, 'Booking AWB: 77796751874', '2026-05-11 15:52:14', '2026-05-11 15:52:14'),
(244, 36, 249, 107.94, 'debit', 'forward', 'admin_manual', 1102.90, 994.96, 'Booking AWB: 77796751922', '2026-05-11 15:52:24', '2026-05-11 15:52:24'),
(245, 36, 248, 104.40, 'debit', 'forward', 'admin_manual', 994.96, 890.56, 'Booking AWB: 37355837750693', '2026-05-11 15:52:36', '2026-05-11 15:52:36'),
(246, 36, 247, 104.40, 'debit', 'forward', 'admin_manual', 890.56, 786.16, 'Booking AWB: 37355837750704', '2026-05-11 15:52:49', '2026-05-11 15:52:49'),
(247, 36, 246, 107.94, 'debit', 'forward', 'admin_manual', 786.16, 678.22, 'Booking AWB: 77796752084', '2026-05-11 15:53:01', '2026-05-11 15:53:01'),
(248, 36, 245, 104.40, 'debit', 'forward', 'admin_manual', 678.22, 573.82, 'Booking AWB: 37355837750752', '2026-05-11 15:53:15', '2026-05-11 15:53:15'),
(249, 36, 244, 104.40, 'debit', 'forward', 'admin_manual', 573.82, 469.42, 'Booking AWB: 37355837750763', '2026-05-11 15:53:24', '2026-05-11 15:53:24'),
(250, 36, 243, 104.40, 'debit', 'forward', 'admin_manual', 469.42, 365.02, 'Booking AWB: 37355837750774', '2026-05-11 15:53:34', '2026-05-11 15:53:34'),
(251, 36, NULL, 2000.00, 'credit', 'recharge', 'phonepe', 365.02, 2365.02, 'PhonePe Wallet Recharge', '2026-05-12 15:47:38', '2026-05-12 15:47:38'),
(252, 36, 265, 107.94, 'debit', 'forward', 'admin_manual', 2365.02, 2257.08, 'Booking AWB: 77798022256', '2026-05-12 16:59:00', '2026-05-12 16:59:00'),
(253, 36, 264, 107.94, 'debit', 'forward', 'admin_manual', 2257.08, 2149.14, 'Booking AWB: 77798022330', '2026-05-12 16:59:11', '2026-05-12 16:59:11'),
(254, 36, 263, 107.94, 'debit', 'forward', 'admin_manual', 2149.14, 2041.20, 'Booking AWB: 77798022363', '2026-05-12 16:59:23', '2026-05-12 16:59:23'),
(255, 36, 262, 107.94, 'debit', 'forward', 'admin_manual', 2041.20, 1933.26, 'Booking AWB: 77798022433', '2026-05-12 16:59:35', '2026-05-12 16:59:35'),
(256, 36, 261, 107.94, 'debit', 'forward', 'admin_manual', 1933.26, 1825.32, 'Booking AWB: 77798022503', '2026-05-12 16:59:47', '2026-05-12 16:59:47'),
(257, 36, 260, 104.40, 'debit', 'forward', 'admin_manual', 1825.32, 1720.92, 'Booking AWB: 37355837789985', '2026-05-12 17:00:19', '2026-05-12 17:00:19'),
(258, 36, 259, 104.40, 'debit', 'forward', 'admin_manual', 1720.92, 1616.52, 'Booking AWB: 37355837789996', '2026-05-12 17:00:38', '2026-05-12 17:00:38'),
(259, 36, 258, 107.94, 'debit', 'forward', 'admin_manual', 1616.52, 1508.58, 'Booking AWB: 77798022676', '2026-05-12 17:00:51', '2026-05-12 17:00:51'),
(260, 36, 257, 107.94, 'debit', 'forward', 'admin_manual', 1508.58, 1400.64, 'Booking AWB: 77798022702', '2026-05-12 17:01:03', '2026-05-12 17:01:03'),
(261, 36, 256, 107.94, 'debit', 'forward', 'admin_manual', 1400.64, 1292.70, 'Booking AWB: 77798022735', '2026-05-12 17:01:15', '2026-05-12 17:01:15'),
(262, 39, 266, 140.36, 'debit', 'forward', 'admin_manual', 583.92, 443.56, 'Booking AWB: 77798601215', '2026-05-13 06:44:56', '2026-05-13 06:44:56'),
(263, 39, 266, 140.36, 'credit', '', 'order_cancellation', 443.56, 583.92, 'Refund for cancelled order #20260513064335', '2026-05-13 06:48:28', '2026-05-13 06:48:28'),
(264, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1292.70, 1302.70, 'COD Refund AWB: 77789705976', '2026-05-13 10:15:11', '2026-05-13 10:15:11'),
(265, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1302.70, 1293.70, 'RTO Charge AWB: 77789705976', '2026-05-13 10:15:11', '2026-05-13 10:15:11'),
(266, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 583.92, 603.92, 'COD Refund AWB: 77790205054', '2026-05-13 10:15:11', '2026-05-13 10:15:11'),
(267, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 603.92, 561.92, 'RTO Charge AWB: 77790205054', '2026-05-13 10:15:11', '2026-05-13 10:15:11'),
(268, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1293.70, 1303.70, 'COD Refund AWB: 37355837634121', '2026-05-13 10:15:12', '2026-05-13 10:15:12'),
(269, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1303.70, 1294.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 10:15:12', '2026-05-13 10:15:12'),
(270, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1294.70, 1304.70, 'COD Refund AWB: 77789705976', '2026-05-13 10:20:07', '2026-05-13 10:20:07'),
(271, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1304.70, 1295.70, 'RTO Charge AWB: 77789705976', '2026-05-13 10:20:07', '2026-05-13 10:20:07'),
(272, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 561.92, 581.92, 'COD Refund AWB: 77790205054', '2026-05-13 10:20:08', '2026-05-13 10:20:08'),
(273, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 581.92, 539.92, 'RTO Charge AWB: 77790205054', '2026-05-13 10:20:08', '2026-05-13 10:20:08'),
(274, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1295.70, 1305.70, 'COD Refund AWB: 37355837634121', '2026-05-13 10:20:09', '2026-05-13 10:20:09'),
(275, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1305.70, 1296.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 10:20:09', '2026-05-13 10:20:09'),
(276, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1296.70, 1306.70, 'COD Refund AWB: 77789705976', '2026-05-13 10:25:12', '2026-05-13 10:25:12'),
(277, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1306.70, 1297.70, 'RTO Charge AWB: 77789705976', '2026-05-13 10:25:12', '2026-05-13 10:25:12'),
(278, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 539.92, 559.92, 'COD Refund AWB: 77790205054', '2026-05-13 10:25:12', '2026-05-13 10:25:12'),
(279, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 559.92, 517.92, 'RTO Charge AWB: 77790205054', '2026-05-13 10:25:12', '2026-05-13 10:25:12'),
(280, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1297.70, 1307.70, 'COD Refund AWB: 37355837634121', '2026-05-13 10:25:14', '2026-05-13 10:25:14'),
(281, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1307.70, 1298.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 10:25:14', '2026-05-13 10:25:14'),
(282, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1298.70, 1308.70, 'COD Refund AWB: 77789705976', '2026-05-13 10:30:09', '2026-05-13 10:30:09'),
(283, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1308.70, 1299.70, 'RTO Charge AWB: 77789705976', '2026-05-13 10:30:09', '2026-05-13 10:30:09'),
(284, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 517.92, 537.92, 'COD Refund AWB: 77790205054', '2026-05-13 10:30:09', '2026-05-13 10:30:09'),
(285, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 537.92, 495.92, 'RTO Charge AWB: 77790205054', '2026-05-13 10:30:09', '2026-05-13 10:30:09'),
(286, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1299.70, 1309.70, 'COD Refund AWB: 37355837634121', '2026-05-13 10:30:11', '2026-05-13 10:30:11'),
(287, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1309.70, 1300.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 10:30:11', '2026-05-13 10:30:11'),
(288, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1300.70, 1310.70, 'COD Refund AWB: 77789705976', '2026-05-13 10:35:11', '2026-05-13 10:35:11'),
(289, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1310.70, 1301.70, 'RTO Charge AWB: 77789705976', '2026-05-13 10:35:11', '2026-05-13 10:35:11'),
(290, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 495.92, 515.92, 'COD Refund AWB: 77790205054', '2026-05-13 10:35:11', '2026-05-13 10:35:11'),
(291, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 515.92, 473.92, 'RTO Charge AWB: 77790205054', '2026-05-13 10:35:11', '2026-05-13 10:35:11'),
(292, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1301.70, 1311.70, 'COD Refund AWB: 37355837634121', '2026-05-13 10:35:12', '2026-05-13 10:35:12'),
(293, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1311.70, 1302.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 10:35:12', '2026-05-13 10:35:12'),
(294, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1302.70, 1312.70, 'COD Refund AWB: 77789705976', '2026-05-13 10:40:06', '2026-05-13 10:40:06'),
(295, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1312.70, 1303.70, 'RTO Charge AWB: 77789705976', '2026-05-13 10:40:06', '2026-05-13 10:40:06'),
(296, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 473.92, 493.92, 'COD Refund AWB: 77790205054', '2026-05-13 10:40:07', '2026-05-13 10:40:07'),
(297, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 493.92, 451.92, 'RTO Charge AWB: 77790205054', '2026-05-13 10:40:07', '2026-05-13 10:40:07'),
(298, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1303.70, 1313.70, 'COD Refund AWB: 37355837634121', '2026-05-13 10:40:08', '2026-05-13 10:40:08'),
(299, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1313.70, 1304.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 10:40:08', '2026-05-13 10:40:08'),
(300, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1304.70, 1314.70, 'COD Refund AWB: 77789705976', '2026-05-13 10:45:09', '2026-05-13 10:45:09'),
(301, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1314.70, 1305.70, 'RTO Charge AWB: 77789705976', '2026-05-13 10:45:09', '2026-05-13 10:45:09'),
(302, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 451.92, 471.92, 'COD Refund AWB: 77790205054', '2026-05-13 10:45:10', '2026-05-13 10:45:10'),
(303, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 471.92, 429.92, 'RTO Charge AWB: 77790205054', '2026-05-13 10:45:10', '2026-05-13 10:45:10'),
(304, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1305.70, 1315.70, 'COD Refund AWB: 37355837634121', '2026-05-13 10:45:11', '2026-05-13 10:45:11'),
(305, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1315.70, 1306.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 10:45:11', '2026-05-13 10:45:11'),
(306, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1306.70, 1316.70, 'COD Refund AWB: 77789705976', '2026-05-13 10:50:09', '2026-05-13 10:50:09'),
(307, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1316.70, 1307.70, 'RTO Charge AWB: 77789705976', '2026-05-13 10:50:09', '2026-05-13 10:50:09'),
(308, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 429.92, 449.92, 'COD Refund AWB: 77790205054', '2026-05-13 10:50:09', '2026-05-13 10:50:09'),
(309, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 449.92, 407.92, 'RTO Charge AWB: 77790205054', '2026-05-13 10:50:09', '2026-05-13 10:50:09'),
(310, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1307.70, 1317.70, 'COD Refund AWB: 37355837634121', '2026-05-13 10:50:10', '2026-05-13 10:50:10'),
(311, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1317.70, 1308.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 10:50:10', '2026-05-13 10:50:10'),
(312, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1308.70, 1318.70, 'COD Refund AWB: 77789705976', '2026-05-13 10:55:09', '2026-05-13 10:55:09'),
(313, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1318.70, 1309.70, 'RTO Charge AWB: 77789705976', '2026-05-13 10:55:09', '2026-05-13 10:55:09'),
(314, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 407.92, 427.92, 'COD Refund AWB: 77790205054', '2026-05-13 10:55:09', '2026-05-13 10:55:09'),
(315, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 427.92, 385.92, 'RTO Charge AWB: 77790205054', '2026-05-13 10:55:09', '2026-05-13 10:55:09'),
(316, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1309.70, 1319.70, 'COD Refund AWB: 37355837634121', '2026-05-13 10:55:10', '2026-05-13 10:55:10'),
(317, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1319.70, 1310.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 10:55:10', '2026-05-13 10:55:10'),
(318, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1310.70, 1320.70, 'COD Refund AWB: 77789705976', '2026-05-13 11:00:08', '2026-05-13 11:00:08'),
(319, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1320.70, 1311.70, 'RTO Charge AWB: 77789705976', '2026-05-13 11:00:08', '2026-05-13 11:00:08'),
(320, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 385.92, 405.92, 'COD Refund AWB: 77790205054', '2026-05-13 11:00:09', '2026-05-13 11:00:09'),
(321, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 405.92, 363.92, 'RTO Charge AWB: 77790205054', '2026-05-13 11:00:09', '2026-05-13 11:00:09'),
(322, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1311.70, 1321.70, 'COD Refund AWB: 37355837634121', '2026-05-13 11:00:10', '2026-05-13 11:00:10'),
(323, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1321.70, 1312.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 11:00:10', '2026-05-13 11:00:10'),
(324, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1312.70, 1322.70, 'COD Refund AWB: 77789705976', '2026-05-13 11:05:10', '2026-05-13 11:05:10'),
(325, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1322.70, 1313.70, 'RTO Charge AWB: 77789705976', '2026-05-13 11:05:10', '2026-05-13 11:05:10'),
(326, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 363.92, 383.92, 'COD Refund AWB: 77790205054', '2026-05-13 11:05:10', '2026-05-13 11:05:10'),
(327, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 383.92, 341.92, 'RTO Charge AWB: 77790205054', '2026-05-13 11:05:10', '2026-05-13 11:05:10'),
(328, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1313.70, 1323.70, 'COD Refund AWB: 37355837634121', '2026-05-13 11:05:12', '2026-05-13 11:05:12'),
(329, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1323.70, 1314.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 11:05:12', '2026-05-13 11:05:12'),
(330, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1314.70, 1324.70, 'COD Refund AWB: 77789705976', '2026-05-13 11:10:08', '2026-05-13 11:10:08'),
(331, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1324.70, 1315.70, 'RTO Charge AWB: 77789705976', '2026-05-13 11:10:08', '2026-05-13 11:10:08'),
(332, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 341.92, 361.92, 'COD Refund AWB: 77790205054', '2026-05-13 11:10:08', '2026-05-13 11:10:08'),
(333, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 361.92, 319.92, 'RTO Charge AWB: 77790205054', '2026-05-13 11:10:08', '2026-05-13 11:10:08'),
(334, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1315.70, 1325.70, 'COD Refund AWB: 37355837634121', '2026-05-13 11:10:10', '2026-05-13 11:10:10'),
(335, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1325.70, 1316.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 11:10:10', '2026-05-13 11:10:10'),
(336, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1316.70, 1326.70, 'COD Refund AWB: 77789705976', '2026-05-13 11:15:12', '2026-05-13 11:15:12'),
(337, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1326.70, 1317.70, 'RTO Charge AWB: 77789705976', '2026-05-13 11:15:12', '2026-05-13 11:15:12'),
(338, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 319.92, 339.92, 'COD Refund AWB: 77790205054', '2026-05-13 11:15:12', '2026-05-13 11:15:12'),
(339, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 339.92, 297.92, 'RTO Charge AWB: 77790205054', '2026-05-13 11:15:12', '2026-05-13 11:15:12'),
(340, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1317.70, 1327.70, 'COD Refund AWB: 37355837634121', '2026-05-13 11:15:13', '2026-05-13 11:15:13'),
(341, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1327.70, 1318.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 11:15:13', '2026-05-13 11:15:13'),
(342, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1318.70, 1328.70, 'COD Refund AWB: 77789705976', '2026-05-13 11:20:08', '2026-05-13 11:20:08'),
(343, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1328.70, 1319.70, 'RTO Charge AWB: 77789705976', '2026-05-13 11:20:08', '2026-05-13 11:20:08'),
(344, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 297.92, 317.92, 'COD Refund AWB: 77790205054', '2026-05-13 11:20:08', '2026-05-13 11:20:08'),
(345, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 317.92, 275.92, 'RTO Charge AWB: 77790205054', '2026-05-13 11:20:08', '2026-05-13 11:20:08'),
(346, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1319.70, 1329.70, 'COD Refund AWB: 37355837634121', '2026-05-13 11:20:08', '2026-05-13 11:20:08'),
(347, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1329.70, 1320.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 11:20:08', '2026-05-13 11:20:08'),
(348, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1320.70, 1330.70, 'COD Refund AWB: 77789705976', '2026-05-13 11:25:09', '2026-05-13 11:25:09'),
(349, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1330.70, 1321.70, 'RTO Charge AWB: 77789705976', '2026-05-13 11:25:09', '2026-05-13 11:25:09'),
(350, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 275.92, 295.92, 'COD Refund AWB: 77790205054', '2026-05-13 11:25:09', '2026-05-13 11:25:09'),
(351, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 295.92, 253.92, 'RTO Charge AWB: 77790205054', '2026-05-13 11:25:09', '2026-05-13 11:25:09'),
(352, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1321.70, 1331.70, 'COD Refund AWB: 37355837634121', '2026-05-13 11:25:10', '2026-05-13 11:25:10'),
(353, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1331.70, 1322.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 11:25:10', '2026-05-13 11:25:10'),
(354, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1322.70, 1332.70, 'COD Refund AWB: 77789705976', '2026-05-13 11:30:08', '2026-05-13 11:30:08'),
(355, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1332.70, 1323.70, 'RTO Charge AWB: 77789705976', '2026-05-13 11:30:08', '2026-05-13 11:30:08'),
(356, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 253.92, 273.92, 'COD Refund AWB: 77790205054', '2026-05-13 11:30:08', '2026-05-13 11:30:08'),
(357, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 273.92, 231.92, 'RTO Charge AWB: 77790205054', '2026-05-13 11:30:08', '2026-05-13 11:30:08'),
(358, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1323.70, 1333.70, 'COD Refund AWB: 37355837634121', '2026-05-13 11:30:09', '2026-05-13 11:30:09'),
(359, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1333.70, 1324.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 11:30:09', '2026-05-13 11:30:09'),
(360, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1324.70, 1334.70, 'COD Refund AWB: 77789705976', '2026-05-13 11:35:11', '2026-05-13 11:35:11'),
(361, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1334.70, 1325.70, 'RTO Charge AWB: 77789705976', '2026-05-13 11:35:11', '2026-05-13 11:35:11'),
(362, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 231.92, 251.92, 'COD Refund AWB: 77790205054', '2026-05-13 11:35:11', '2026-05-13 11:35:11'),
(363, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 251.92, 209.92, 'RTO Charge AWB: 77790205054', '2026-05-13 11:35:11', '2026-05-13 11:35:11'),
(364, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1325.70, 1335.70, 'COD Refund AWB: 37355837634121', '2026-05-13 11:35:12', '2026-05-13 11:35:12'),
(365, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1335.70, 1326.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 11:35:12', '2026-05-13 11:35:12'),
(366, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1326.70, 1336.70, 'COD Refund AWB: 77789705976', '2026-05-13 11:40:08', '2026-05-13 11:40:08'),
(367, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1336.70, 1327.70, 'RTO Charge AWB: 77789705976', '2026-05-13 11:40:08', '2026-05-13 11:40:08'),
(368, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 209.92, 229.92, 'COD Refund AWB: 77790205054', '2026-05-13 11:40:08', '2026-05-13 11:40:08'),
(369, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 229.92, 187.92, 'RTO Charge AWB: 77790205054', '2026-05-13 11:40:08', '2026-05-13 11:40:08'),
(370, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1327.70, 1337.70, 'COD Refund AWB: 37355837634121', '2026-05-13 11:40:09', '2026-05-13 11:40:09'),
(371, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1337.70, 1328.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 11:40:09', '2026-05-13 11:40:09'),
(372, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1328.70, 1338.70, 'COD Refund AWB: 77789705976', '2026-05-13 11:45:10', '2026-05-13 11:45:10'),
(373, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1338.70, 1329.70, 'RTO Charge AWB: 77789705976', '2026-05-13 11:45:10', '2026-05-13 11:45:10'),
(374, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 187.92, 207.92, 'COD Refund AWB: 77790205054', '2026-05-13 11:45:10', '2026-05-13 11:45:10'),
(375, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 207.92, 165.92, 'RTO Charge AWB: 77790205054', '2026-05-13 11:45:10', '2026-05-13 11:45:10'),
(376, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1329.70, 1339.70, 'COD Refund AWB: 37355837634121', '2026-05-13 11:45:11', '2026-05-13 11:45:11'),
(377, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1339.70, 1330.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 11:45:11', '2026-05-13 11:45:11'),
(378, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1330.70, 1340.70, 'COD Refund AWB: 77789705976', '2026-05-13 11:50:07', '2026-05-13 11:50:07'),
(379, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1340.70, 1331.70, 'RTO Charge AWB: 77789705976', '2026-05-13 11:50:07', '2026-05-13 11:50:07'),
(380, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 165.92, 185.92, 'COD Refund AWB: 77790205054', '2026-05-13 11:50:07', '2026-05-13 11:50:07'),
(381, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 185.92, 143.92, 'RTO Charge AWB: 77790205054', '2026-05-13 11:50:07', '2026-05-13 11:50:07'),
(382, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1331.70, 1341.70, 'COD Refund AWB: 37355837634121', '2026-05-13 11:50:08', '2026-05-13 11:50:08'),
(383, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1341.70, 1332.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 11:50:08', '2026-05-13 11:50:08'),
(384, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1332.70, 1342.70, 'COD Refund AWB: 77789705976', '2026-05-13 11:55:09', '2026-05-13 11:55:09'),
(385, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1342.70, 1333.70, 'RTO Charge AWB: 77789705976', '2026-05-13 11:55:09', '2026-05-13 11:55:09'),
(386, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 143.92, 163.92, 'COD Refund AWB: 77790205054', '2026-05-13 11:55:09', '2026-05-13 11:55:09'),
(387, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 163.92, 121.92, 'RTO Charge AWB: 77790205054', '2026-05-13 11:55:09', '2026-05-13 11:55:09'),
(388, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1333.70, 1343.70, 'COD Refund AWB: 37355837634121', '2026-05-13 11:55:10', '2026-05-13 11:55:10'),
(389, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1343.70, 1334.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 11:55:10', '2026-05-13 11:55:10'),
(390, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1334.70, 1344.70, 'COD Refund AWB: 77789705976', '2026-05-13 12:00:08', '2026-05-13 12:00:08'),
(391, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1344.70, 1335.70, 'RTO Charge AWB: 77789705976', '2026-05-13 12:00:08', '2026-05-13 12:00:08'),
(392, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 121.92, 141.92, 'COD Refund AWB: 77790205054', '2026-05-13 12:00:09', '2026-05-13 12:00:09'),
(393, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 141.92, 99.92, 'RTO Charge AWB: 77790205054', '2026-05-13 12:00:09', '2026-05-13 12:00:09'),
(394, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1335.70, 1345.70, 'COD Refund AWB: 37355837634121', '2026-05-13 12:00:09', '2026-05-13 12:00:09'),
(395, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1345.70, 1336.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 12:00:09', '2026-05-13 12:00:09'),
(396, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1336.70, 1346.70, 'COD Refund AWB: 77789705976', '2026-05-13 12:05:11', '2026-05-13 12:05:11'),
(397, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1346.70, 1337.70, 'RTO Charge AWB: 77789705976', '2026-05-13 12:05:11', '2026-05-13 12:05:11'),
(398, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 99.92, 119.92, 'COD Refund AWB: 77790205054', '2026-05-13 12:05:11', '2026-05-13 12:05:11'),
(399, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 119.92, 77.92, 'RTO Charge AWB: 77790205054', '2026-05-13 12:05:11', '2026-05-13 12:05:11'),
(400, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1337.70, 1347.70, 'COD Refund AWB: 37355837634121', '2026-05-13 12:05:12', '2026-05-13 12:05:12'),
(401, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1347.70, 1338.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 12:05:12', '2026-05-13 12:05:12'),
(402, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1338.70, 1348.70, 'COD Refund AWB: 77789705976', '2026-05-13 12:10:08', '2026-05-13 12:10:08'),
(403, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1348.70, 1339.70, 'RTO Charge AWB: 77789705976', '2026-05-13 12:10:08', '2026-05-13 12:10:08'),
(404, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 77.92, 97.92, 'COD Refund AWB: 77790205054', '2026-05-13 12:10:08', '2026-05-13 12:10:08'),
(405, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 97.92, 55.92, 'RTO Charge AWB: 77790205054', '2026-05-13 12:10:08', '2026-05-13 12:10:08'),
(406, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1339.70, 1349.70, 'COD Refund AWB: 37355837634121', '2026-05-13 12:10:09', '2026-05-13 12:10:09'),
(407, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1349.70, 1340.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 12:10:09', '2026-05-13 12:10:09'),
(408, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1340.70, 1350.70, 'COD Refund AWB: 77789705976', '2026-05-13 12:15:10', '2026-05-13 12:15:10'),
(409, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1350.70, 1341.70, 'RTO Charge AWB: 77789705976', '2026-05-13 12:15:10', '2026-05-13 12:15:10'),
(410, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 55.92, 75.92, 'COD Refund AWB: 77790205054', '2026-05-13 12:15:10', '2026-05-13 12:15:10'),
(411, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 75.92, 33.92, 'RTO Charge AWB: 77790205054', '2026-05-13 12:15:10', '2026-05-13 12:15:10'),
(412, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1341.70, 1351.70, 'COD Refund AWB: 37355837634121', '2026-05-13 12:15:11', '2026-05-13 12:15:11'),
(413, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1351.70, 1342.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 12:15:11', '2026-05-13 12:15:11'),
(414, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1342.70, 1352.70, 'COD Refund AWB: 77789705976', '2026-05-13 12:20:07', '2026-05-13 12:20:07'),
(415, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1352.70, 1343.70, 'RTO Charge AWB: 77789705976', '2026-05-13 12:20:07', '2026-05-13 12:20:07'),
(416, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 33.92, 53.92, 'COD Refund AWB: 77790205054', '2026-05-13 12:20:07', '2026-05-13 12:20:07'),
(417, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 53.92, 11.92, 'RTO Charge AWB: 77790205054', '2026-05-13 12:20:07', '2026-05-13 12:20:07'),
(418, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1343.70, 1353.70, 'COD Refund AWB: 37355837634121', '2026-05-13 12:20:08', '2026-05-13 12:20:08'),
(419, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1353.70, 1344.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 12:20:08', '2026-05-13 12:20:08'),
(420, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1344.70, 1354.70, 'COD Refund AWB: 77789705976', '2026-05-13 12:25:10', '2026-05-13 12:25:10'),
(421, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1354.70, 1345.70, 'RTO Charge AWB: 77789705976', '2026-05-13 12:25:10', '2026-05-13 12:25:10'),
(422, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 11.92, 31.92, 'COD Refund AWB: 77790205054', '2026-05-13 12:25:10', '2026-05-13 12:25:10'),
(423, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 31.92, -10.08, 'RTO Charge AWB: 77790205054', '2026-05-13 12:25:10', '2026-05-13 12:25:10'),
(424, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1345.70, 1355.70, 'COD Refund AWB: 37355837634121', '2026-05-13 12:25:11', '2026-05-13 12:25:11'),
(425, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1355.70, 1346.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 12:25:11', '2026-05-13 12:25:11'),
(426, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1346.70, 1356.70, 'COD Refund AWB: 77789705976', '2026-05-13 12:30:08', '2026-05-13 12:30:08'),
(427, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1356.70, 1347.70, 'RTO Charge AWB: 77789705976', '2026-05-13 12:30:08', '2026-05-13 12:30:08'),
(428, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -10.08, 9.92, 'COD Refund AWB: 77790205054', '2026-05-13 12:30:09', '2026-05-13 12:30:09'),
(429, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 9.92, -32.08, 'RTO Charge AWB: 77790205054', '2026-05-13 12:30:09', '2026-05-13 12:30:09'),
(430, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1347.70, 1357.70, 'COD Refund AWB: 37355837634121', '2026-05-13 12:30:10', '2026-05-13 12:30:10'),
(431, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1357.70, 1348.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 12:30:10', '2026-05-13 12:30:10'),
(432, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1348.70, 1358.70, 'COD Refund AWB: 77789705976', '2026-05-13 12:35:11', '2026-05-13 12:35:11'),
(433, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1358.70, 1349.70, 'RTO Charge AWB: 77789705976', '2026-05-13 12:35:11', '2026-05-13 12:35:11'),
(434, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -32.08, -12.08, 'COD Refund AWB: 77790205054', '2026-05-13 12:35:12', '2026-05-13 12:35:12'),
(435, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -12.08, -54.08, 'RTO Charge AWB: 77790205054', '2026-05-13 12:35:12', '2026-05-13 12:35:12'),
(436, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1349.70, 1359.70, 'COD Refund AWB: 37355837634121', '2026-05-13 12:35:13', '2026-05-13 12:35:13'),
(437, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1359.70, 1350.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 12:35:13', '2026-05-13 12:35:13'),
(438, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1350.70, 1360.70, 'COD Refund AWB: 77789705976', '2026-05-13 12:40:08', '2026-05-13 12:40:08'),
(439, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1360.70, 1351.70, 'RTO Charge AWB: 77789705976', '2026-05-13 12:40:08', '2026-05-13 12:40:08'),
(440, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -54.08, -34.08, 'COD Refund AWB: 77790205054', '2026-05-13 12:40:09', '2026-05-13 12:40:09'),
(441, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -34.08, -76.08, 'RTO Charge AWB: 77790205054', '2026-05-13 12:40:09', '2026-05-13 12:40:09'),
(442, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1351.70, 1361.70, 'COD Refund AWB: 37355837634121', '2026-05-13 12:40:10', '2026-05-13 12:40:10'),
(443, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1361.70, 1352.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 12:40:10', '2026-05-13 12:40:10'),
(444, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1352.70, 1362.70, 'COD Refund AWB: 77789705976', '2026-05-13 12:45:11', '2026-05-13 12:45:11'),
(445, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1362.70, 1353.70, 'RTO Charge AWB: 77789705976', '2026-05-13 12:45:11', '2026-05-13 12:45:11'),
(446, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -76.08, -56.08, 'COD Refund AWB: 77790205054', '2026-05-13 12:45:11', '2026-05-13 12:45:11'),
(447, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -56.08, -98.08, 'RTO Charge AWB: 77790205054', '2026-05-13 12:45:11', '2026-05-13 12:45:11'),
(448, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1353.70, 1363.70, 'COD Refund AWB: 37355837634121', '2026-05-13 12:45:12', '2026-05-13 12:45:12'),
(449, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1363.70, 1354.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 12:45:12', '2026-05-13 12:45:12'),
(450, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 1354.70, 1364.70, 'COD Refund AWB: 77789705976', '2026-05-13 12:50:08', '2026-05-13 12:50:08'),
(451, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 1364.70, 1355.70, 'RTO Charge AWB: 77789705976', '2026-05-13 12:50:08', '2026-05-13 12:50:08'),
(452, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -98.08, -78.08, 'COD Refund AWB: 77790205054', '2026-05-13 12:50:09', '2026-05-13 12:50:09'),
(453, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -78.08, -120.08, 'RTO Charge AWB: 77790205054', '2026-05-13 12:50:09', '2026-05-13 12:50:09'),
(454, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 1355.70, 1365.70, 'COD Refund AWB: 37355837634121', '2026-05-13 12:50:09', '2026-05-13 12:50:09');
INSERT INTO `wallet_transactions` (`id`, `user_id`, `fship_order_id`, `amount`, `type`, `charge_type`, `source`, `opening_balance`, `closing_balance`, `remark`, `created_at`, `updated_at`) VALUES
(455, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 1365.70, 1356.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 12:50:09', '2026-05-13 12:50:09'),
(456, 36, NULL, 5000.00, 'credit', 'recharge', 'phonepe', 1356.70, 6356.70, 'PhonePe Wallet Recharge', '2026-05-13 12:54:08', '2026-05-13 12:54:08'),
(457, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6356.70, 6366.70, 'COD Refund AWB: 77789705976', '2026-05-13 12:55:11', '2026-05-13 12:55:11'),
(458, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6366.70, 6357.70, 'RTO Charge AWB: 77789705976', '2026-05-13 12:55:11', '2026-05-13 12:55:11'),
(459, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -120.08, -100.08, 'COD Refund AWB: 77790205054', '2026-05-13 12:55:11', '2026-05-13 12:55:11'),
(460, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -100.08, -142.08, 'RTO Charge AWB: 77790205054', '2026-05-13 12:55:11', '2026-05-13 12:55:11'),
(461, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6357.70, 6367.70, 'COD Refund AWB: 37355837634121', '2026-05-13 12:55:12', '2026-05-13 12:55:12'),
(462, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6367.70, 6358.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 12:55:12', '2026-05-13 12:55:12'),
(463, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6358.70, 6368.70, 'COD Refund AWB: 77789705976', '2026-05-13 13:00:08', '2026-05-13 13:00:08'),
(464, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6368.70, 6359.70, 'RTO Charge AWB: 77789705976', '2026-05-13 13:00:08', '2026-05-13 13:00:08'),
(465, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -142.08, -122.08, 'COD Refund AWB: 77790205054', '2026-05-13 13:00:08', '2026-05-13 13:00:08'),
(466, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -122.08, -164.08, 'RTO Charge AWB: 77790205054', '2026-05-13 13:00:08', '2026-05-13 13:00:08'),
(467, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6359.70, 6369.70, 'COD Refund AWB: 37355837634121', '2026-05-13 13:00:09', '2026-05-13 13:00:09'),
(468, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6369.70, 6360.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 13:00:09', '2026-05-13 13:00:09'),
(469, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6360.70, 6370.70, 'COD Refund AWB: 77789705976', '2026-05-13 13:05:11', '2026-05-13 13:05:11'),
(470, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6370.70, 6361.70, 'RTO Charge AWB: 77789705976', '2026-05-13 13:05:11', '2026-05-13 13:05:11'),
(471, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -164.08, -144.08, 'COD Refund AWB: 77790205054', '2026-05-13 13:05:11', '2026-05-13 13:05:11'),
(472, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -144.08, -186.08, 'RTO Charge AWB: 77790205054', '2026-05-13 13:05:11', '2026-05-13 13:05:11'),
(473, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6361.70, 6371.70, 'COD Refund AWB: 37355837634121', '2026-05-13 13:05:11', '2026-05-13 13:05:11'),
(474, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6371.70, 6362.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 13:05:11', '2026-05-13 13:05:11'),
(475, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6362.70, 6372.70, 'COD Refund AWB: 77789705976', '2026-05-13 13:10:07', '2026-05-13 13:10:07'),
(476, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6372.70, 6363.70, 'RTO Charge AWB: 77789705976', '2026-05-13 13:10:07', '2026-05-13 13:10:07'),
(477, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -186.08, -166.08, 'COD Refund AWB: 77790205054', '2026-05-13 13:10:08', '2026-05-13 13:10:08'),
(478, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -166.08, -208.08, 'RTO Charge AWB: 77790205054', '2026-05-13 13:10:08', '2026-05-13 13:10:08'),
(479, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6363.70, 6373.70, 'COD Refund AWB: 37355837634121', '2026-05-13 13:10:08', '2026-05-13 13:10:08'),
(480, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6373.70, 6364.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 13:10:08', '2026-05-13 13:10:08'),
(481, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6364.70, 6374.70, 'COD Refund AWB: 77789705976', '2026-05-13 13:15:09', '2026-05-13 13:15:09'),
(482, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6374.70, 6365.70, 'RTO Charge AWB: 77789705976', '2026-05-13 13:15:09', '2026-05-13 13:15:09'),
(483, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -208.08, -188.08, 'COD Refund AWB: 77790205054', '2026-05-13 13:15:09', '2026-05-13 13:15:09'),
(484, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -188.08, -230.08, 'RTO Charge AWB: 77790205054', '2026-05-13 13:15:09', '2026-05-13 13:15:09'),
(485, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6365.70, 6375.70, 'COD Refund AWB: 37355837634121', '2026-05-13 13:15:10', '2026-05-13 13:15:10'),
(486, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6375.70, 6366.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 13:15:10', '2026-05-13 13:15:10'),
(487, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6366.70, 6376.70, 'COD Refund AWB: 77789705976', '2026-05-13 13:20:08', '2026-05-13 13:20:08'),
(488, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6376.70, 6367.70, 'RTO Charge AWB: 77789705976', '2026-05-13 13:20:08', '2026-05-13 13:20:08'),
(489, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -230.08, -210.08, 'COD Refund AWB: 77790205054', '2026-05-13 13:20:08', '2026-05-13 13:20:08'),
(490, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -210.08, -252.08, 'RTO Charge AWB: 77790205054', '2026-05-13 13:20:08', '2026-05-13 13:20:08'),
(491, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6367.70, 6377.70, 'COD Refund AWB: 37355837634121', '2026-05-13 13:20:09', '2026-05-13 13:20:09'),
(492, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6377.70, 6368.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 13:20:09', '2026-05-13 13:20:09'),
(493, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6368.70, 6378.70, 'COD Refund AWB: 77789705976', '2026-05-13 13:25:09', '2026-05-13 13:25:09'),
(494, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6378.70, 6369.70, 'RTO Charge AWB: 77789705976', '2026-05-13 13:25:09', '2026-05-13 13:25:09'),
(495, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -252.08, -232.08, 'COD Refund AWB: 77790205054', '2026-05-13 13:25:09', '2026-05-13 13:25:09'),
(496, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -232.08, -274.08, 'RTO Charge AWB: 77790205054', '2026-05-13 13:25:09', '2026-05-13 13:25:09'),
(497, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6369.70, 6379.70, 'COD Refund AWB: 37355837634121', '2026-05-13 13:25:10', '2026-05-13 13:25:10'),
(498, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6379.70, 6370.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 13:25:10', '2026-05-13 13:25:10'),
(499, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6370.70, 6380.70, 'COD Refund AWB: 77789705976', '2026-05-13 13:30:15', '2026-05-13 13:30:15'),
(500, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6380.70, 6371.70, 'RTO Charge AWB: 77789705976', '2026-05-13 13:30:15', '2026-05-13 13:30:15'),
(501, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -274.08, -254.08, 'COD Refund AWB: 77790205054', '2026-05-13 13:30:15', '2026-05-13 13:30:15'),
(502, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -254.08, -296.08, 'RTO Charge AWB: 77790205054', '2026-05-13 13:30:15', '2026-05-13 13:30:15'),
(503, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6371.70, 6381.70, 'COD Refund AWB: 37355837634121', '2026-05-13 13:30:16', '2026-05-13 13:30:16'),
(504, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6381.70, 6372.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 13:30:16', '2026-05-13 13:30:16'),
(505, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6372.70, 6382.70, 'COD Refund AWB: 77789705976', '2026-05-13 13:35:06', '2026-05-13 13:35:06'),
(506, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6382.70, 6373.70, 'RTO Charge AWB: 77789705976', '2026-05-13 13:35:06', '2026-05-13 13:35:06'),
(507, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -296.08, -276.08, 'COD Refund AWB: 77790205054', '2026-05-13 13:35:06', '2026-05-13 13:35:06'),
(508, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -276.08, -318.08, 'RTO Charge AWB: 77790205054', '2026-05-13 13:35:06', '2026-05-13 13:35:06'),
(509, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6373.70, 6383.70, 'COD Refund AWB: 37355837634121', '2026-05-13 13:35:07', '2026-05-13 13:35:07'),
(510, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6383.70, 6374.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 13:35:07', '2026-05-13 13:35:07'),
(511, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6374.70, 6384.70, 'COD Refund AWB: 77789705976', '2026-05-13 13:40:11', '2026-05-13 13:40:11'),
(512, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6384.70, 6375.70, 'RTO Charge AWB: 77789705976', '2026-05-13 13:40:11', '2026-05-13 13:40:11'),
(513, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -318.08, -298.08, 'COD Refund AWB: 77790205054', '2026-05-13 13:40:11', '2026-05-13 13:40:11'),
(514, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -298.08, -340.08, 'RTO Charge AWB: 77790205054', '2026-05-13 13:40:11', '2026-05-13 13:40:11'),
(515, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6375.70, 6385.70, 'COD Refund AWB: 37355837634121', '2026-05-13 13:40:12', '2026-05-13 13:40:12'),
(516, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6385.70, 6376.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 13:40:12', '2026-05-13 13:40:12'),
(517, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6376.70, 6386.70, 'COD Refund AWB: 77789705976', '2026-05-13 13:45:07', '2026-05-13 13:45:07'),
(518, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6386.70, 6377.70, 'RTO Charge AWB: 77789705976', '2026-05-13 13:45:07', '2026-05-13 13:45:07'),
(519, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -340.08, -320.08, 'COD Refund AWB: 77790205054', '2026-05-13 13:45:07', '2026-05-13 13:45:07'),
(520, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -320.08, -362.08, 'RTO Charge AWB: 77790205054', '2026-05-13 13:45:07', '2026-05-13 13:45:07'),
(521, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6377.70, 6387.70, 'COD Refund AWB: 37355837634121', '2026-05-13 13:45:08', '2026-05-13 13:45:08'),
(522, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6387.70, 6378.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 13:45:08', '2026-05-13 13:45:08'),
(523, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6378.70, 6388.70, 'COD Refund AWB: 77789705976', '2026-05-13 13:50:11', '2026-05-13 13:50:11'),
(524, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6388.70, 6379.70, 'RTO Charge AWB: 77789705976', '2026-05-13 13:50:11', '2026-05-13 13:50:11'),
(525, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -362.08, -342.08, 'COD Refund AWB: 77790205054', '2026-05-13 13:50:11', '2026-05-13 13:50:11'),
(526, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -342.08, -384.08, 'RTO Charge AWB: 77790205054', '2026-05-13 13:50:11', '2026-05-13 13:50:11'),
(527, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6379.70, 6389.70, 'COD Refund AWB: 37355837634121', '2026-05-13 13:50:12', '2026-05-13 13:50:12'),
(528, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6389.70, 6380.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 13:50:12', '2026-05-13 13:50:12'),
(529, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 6380.70, 6390.70, 'COD Refund AWB: 77789705976', '2026-05-13 13:55:06', '2026-05-13 13:55:06'),
(530, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 6390.70, 6381.70, 'RTO Charge AWB: 77789705976', '2026-05-13 13:55:06', '2026-05-13 13:55:06'),
(531, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -384.08, -364.08, 'COD Refund AWB: 77790205054', '2026-05-13 13:55:07', '2026-05-13 13:55:07'),
(532, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -364.08, -406.08, 'RTO Charge AWB: 77790205054', '2026-05-13 13:55:07', '2026-05-13 13:55:07'),
(533, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 6381.70, 6391.70, 'COD Refund AWB: 37355837634121', '2026-05-13 13:55:07', '2026-05-13 13:55:07'),
(534, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 6391.70, 6382.70, 'RTO Charge AWB: 37355837634121', '2026-05-13 13:55:07', '2026-05-13 13:55:07'),
(535, 36, 281, 104.40, 'debit', 'forward', 'admin_manual', 6382.70, 6278.30, 'Booking AWB: 37355837832910', '2026-05-13 13:55:18', '2026-05-13 13:55:18'),
(536, 36, 279, 107.94, 'debit', 'forward', 'admin_manual', 6278.30, 6170.36, 'Booking AWB: 77799147226', '2026-05-13 13:55:45', '2026-05-13 13:55:45'),
(537, 36, 280, 107.94, 'debit', 'forward', 'admin_manual', 6170.36, 6062.42, 'Booking AWB: 77799147300', '2026-05-13 13:55:54', '2026-05-13 13:55:54'),
(538, 36, 278, 104.40, 'debit', 'forward', 'admin_manual', 6062.42, 5958.02, 'Booking AWB: 37355837832932', '2026-05-13 13:56:07', '2026-05-13 13:56:07'),
(539, 36, 277, 107.94, 'debit', 'forward', 'admin_manual', 5958.02, 5850.08, 'Booking AWB: 77799147576', '2026-05-13 13:56:21', '2026-05-13 13:56:21'),
(540, 36, 276, 107.94, 'debit', 'forward', 'admin_manual', 5850.08, 5742.14, 'Booking AWB: 77799147650', '2026-05-13 13:56:31', '2026-05-13 13:56:31'),
(541, 36, 275, 107.94, 'debit', 'forward', 'admin_manual', 5742.14, 5634.20, 'Booking AWB: 77799147904', '2026-05-13 13:56:41', '2026-05-13 13:56:41'),
(542, 36, 274, 104.40, 'debit', 'forward', 'admin_manual', 5634.20, 5529.80, 'Booking AWB: 37355837832954', '2026-05-13 13:56:55', '2026-05-13 13:56:55'),
(543, 36, 273, 104.40, 'debit', 'forward', 'admin_manual', 5529.80, 5425.40, 'Booking AWB: 37355837832965', '2026-05-13 13:57:04', '2026-05-13 13:57:04'),
(544, 36, 272, 104.40, 'debit', 'forward', 'admin_manual', 5425.40, 5321.00, 'Booking AWB: 37355837832976', '2026-05-13 13:57:15', '2026-05-13 13:57:15'),
(545, 36, 271, 104.40, 'debit', 'forward', 'admin_manual', 5321.00, 5216.60, 'Booking AWB: 37355837832980', '2026-05-13 13:57:24', '2026-05-13 13:57:24'),
(546, 36, 270, 107.94, 'debit', 'forward', 'admin_manual', 5216.60, 5108.66, 'Booking AWB: 77799148350', '2026-05-13 13:57:34', '2026-05-13 13:57:34'),
(547, 36, 269, 104.40, 'debit', 'forward', 'admin_manual', 5108.66, 5004.26, 'Booking AWB: 37355837832991', '2026-05-13 13:57:45', '2026-05-13 13:57:45'),
(548, 36, 268, 107.94, 'debit', 'forward', 'admin_manual', 5004.26, 4896.32, 'Booking AWB: 77799148604', '2026-05-13 13:57:54', '2026-05-13 13:57:54'),
(549, 36, 267, 104.40, 'debit', 'forward', 'admin_manual', 4896.32, 4791.92, 'Booking AWB: 37355837833002', '2026-05-13 13:58:07', '2026-05-13 13:58:07'),
(550, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4791.92, 4801.92, 'COD Refund AWB: 77789705976', '2026-05-13 14:00:18', '2026-05-13 14:00:18'),
(551, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4801.92, 4792.92, 'RTO Charge AWB: 77789705976', '2026-05-13 14:00:18', '2026-05-13 14:00:18'),
(552, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -406.08, -386.08, 'COD Refund AWB: 77790205054', '2026-05-13 14:00:18', '2026-05-13 14:00:18'),
(553, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -386.08, -428.08, 'RTO Charge AWB: 77790205054', '2026-05-13 14:00:18', '2026-05-13 14:00:18'),
(554, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4792.92, 4802.92, 'COD Refund AWB: 37355837634121', '2026-05-13 14:00:18', '2026-05-13 14:00:18'),
(555, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4802.92, 4793.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 14:00:18', '2026-05-13 14:00:18'),
(556, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4793.92, 4803.92, 'COD Refund AWB: 77789705976', '2026-05-13 14:05:08', '2026-05-13 14:05:08'),
(557, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4803.92, 4794.92, 'RTO Charge AWB: 77789705976', '2026-05-13 14:05:08', '2026-05-13 14:05:08'),
(558, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -428.08, -408.08, 'COD Refund AWB: 77790205054', '2026-05-13 14:05:08', '2026-05-13 14:05:08'),
(559, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -408.08, -450.08, 'RTO Charge AWB: 77790205054', '2026-05-13 14:05:08', '2026-05-13 14:05:08'),
(560, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4794.92, 4804.92, 'COD Refund AWB: 37355837634121', '2026-05-13 14:05:09', '2026-05-13 14:05:09'),
(561, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4804.92, 4795.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 14:05:09', '2026-05-13 14:05:09'),
(562, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4795.92, 4805.92, 'COD Refund AWB: 77789705976', '2026-05-13 14:10:12', '2026-05-13 14:10:12'),
(563, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4805.92, 4796.92, 'RTO Charge AWB: 77789705976', '2026-05-13 14:10:12', '2026-05-13 14:10:12'),
(564, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -450.08, -430.08, 'COD Refund AWB: 77790205054', '2026-05-13 14:10:12', '2026-05-13 14:10:12'),
(565, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -430.08, -472.08, 'RTO Charge AWB: 77790205054', '2026-05-13 14:10:12', '2026-05-13 14:10:12'),
(566, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4796.92, 4806.92, 'COD Refund AWB: 37355837634121', '2026-05-13 14:10:13', '2026-05-13 14:10:13'),
(567, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4806.92, 4797.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 14:10:13', '2026-05-13 14:10:13'),
(568, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4797.92, 4807.92, 'COD Refund AWB: 77789705976', '2026-05-13 14:15:08', '2026-05-13 14:15:08'),
(569, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4807.92, 4798.92, 'RTO Charge AWB: 77789705976', '2026-05-13 14:15:08', '2026-05-13 14:15:08'),
(570, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -472.08, -452.08, 'COD Refund AWB: 77790205054', '2026-05-13 14:15:09', '2026-05-13 14:15:09'),
(571, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -452.08, -494.08, 'RTO Charge AWB: 77790205054', '2026-05-13 14:15:09', '2026-05-13 14:15:09'),
(572, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4798.92, 4808.92, 'COD Refund AWB: 37355837634121', '2026-05-13 14:15:10', '2026-05-13 14:15:10'),
(573, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4808.92, 4799.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 14:15:10', '2026-05-13 14:15:10'),
(574, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4799.92, 4809.92, 'COD Refund AWB: 77789705976', '2026-05-13 14:20:11', '2026-05-13 14:20:11'),
(575, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4809.92, 4800.92, 'RTO Charge AWB: 77789705976', '2026-05-13 14:20:11', '2026-05-13 14:20:11'),
(576, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -494.08, -474.08, 'COD Refund AWB: 77790205054', '2026-05-13 14:20:12', '2026-05-13 14:20:12'),
(577, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -474.08, -516.08, 'RTO Charge AWB: 77790205054', '2026-05-13 14:20:12', '2026-05-13 14:20:12'),
(578, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4800.92, 4810.92, 'COD Refund AWB: 37355837634121', '2026-05-13 14:20:13', '2026-05-13 14:20:13'),
(579, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4810.92, 4801.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 14:20:13', '2026-05-13 14:20:13'),
(580, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4801.92, 4811.92, 'COD Refund AWB: 77789705976', '2026-05-13 14:25:08', '2026-05-13 14:25:08'),
(581, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4811.92, 4802.92, 'RTO Charge AWB: 77789705976', '2026-05-13 14:25:08', '2026-05-13 14:25:08'),
(582, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -516.08, -496.08, 'COD Refund AWB: 77790205054', '2026-05-13 14:25:08', '2026-05-13 14:25:08'),
(583, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -496.08, -538.08, 'RTO Charge AWB: 77790205054', '2026-05-13 14:25:08', '2026-05-13 14:25:08'),
(584, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4802.92, 4812.92, 'COD Refund AWB: 37355837634121', '2026-05-13 14:25:09', '2026-05-13 14:25:09'),
(585, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4812.92, 4803.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 14:25:09', '2026-05-13 14:25:09'),
(586, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4803.92, 4813.92, 'COD Refund AWB: 77789705976', '2026-05-13 14:30:16', '2026-05-13 14:30:16'),
(587, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4813.92, 4804.92, 'RTO Charge AWB: 77789705976', '2026-05-13 14:30:16', '2026-05-13 14:30:16'),
(588, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -538.08, -518.08, 'COD Refund AWB: 77790205054', '2026-05-13 14:30:16', '2026-05-13 14:30:16'),
(589, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -518.08, -560.08, 'RTO Charge AWB: 77790205054', '2026-05-13 14:30:16', '2026-05-13 14:30:16'),
(590, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4804.92, 4814.92, 'COD Refund AWB: 37355837634121', '2026-05-13 14:30:18', '2026-05-13 14:30:18'),
(591, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4814.92, 4805.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 14:30:18', '2026-05-13 14:30:18'),
(592, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4805.92, 4815.92, 'COD Refund AWB: 77789705976', '2026-05-13 14:35:08', '2026-05-13 14:35:08'),
(593, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4815.92, 4806.92, 'RTO Charge AWB: 77789705976', '2026-05-13 14:35:08', '2026-05-13 14:35:08'),
(594, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -560.08, -540.08, 'COD Refund AWB: 77790205054', '2026-05-13 14:35:09', '2026-05-13 14:35:09'),
(595, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -540.08, -582.08, 'RTO Charge AWB: 77790205054', '2026-05-13 14:35:09', '2026-05-13 14:35:09'),
(596, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4806.92, 4816.92, 'COD Refund AWB: 37355837634121', '2026-05-13 14:35:12', '2026-05-13 14:35:12'),
(597, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4816.92, 4807.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 14:35:12', '2026-05-13 14:35:12'),
(598, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4807.92, 4817.92, 'COD Refund AWB: 77789705976', '2026-05-13 14:40:12', '2026-05-13 14:40:12'),
(599, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4817.92, 4808.92, 'RTO Charge AWB: 77789705976', '2026-05-13 14:40:12', '2026-05-13 14:40:12'),
(600, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -582.08, -562.08, 'COD Refund AWB: 77790205054', '2026-05-13 14:40:13', '2026-05-13 14:40:13'),
(601, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -562.08, -604.08, 'RTO Charge AWB: 77790205054', '2026-05-13 14:40:13', '2026-05-13 14:40:13'),
(602, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4808.92, 4818.92, 'COD Refund AWB: 37355837634121', '2026-05-13 14:40:15', '2026-05-13 14:40:15'),
(603, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4818.92, 4809.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 14:40:15', '2026-05-13 14:40:15'),
(604, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4809.92, 4819.92, 'COD Refund AWB: 77789705976', '2026-05-13 14:45:08', '2026-05-13 14:45:08'),
(605, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4819.92, 4810.92, 'RTO Charge AWB: 77789705976', '2026-05-13 14:45:08', '2026-05-13 14:45:08'),
(606, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -604.08, -584.08, 'COD Refund AWB: 77790205054', '2026-05-13 14:45:08', '2026-05-13 14:45:08'),
(607, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -584.08, -626.08, 'RTO Charge AWB: 77790205054', '2026-05-13 14:45:08', '2026-05-13 14:45:08'),
(608, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4810.92, 4820.92, 'COD Refund AWB: 37355837634121', '2026-05-13 14:45:10', '2026-05-13 14:45:10'),
(609, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4820.92, 4811.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 14:45:10', '2026-05-13 14:45:10'),
(610, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4811.92, 4821.92, 'COD Refund AWB: 77789705976', '2026-05-13 14:50:12', '2026-05-13 14:50:12'),
(611, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4821.92, 4812.92, 'RTO Charge AWB: 77789705976', '2026-05-13 14:50:12', '2026-05-13 14:50:12'),
(612, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -626.08, -606.08, 'COD Refund AWB: 77790205054', '2026-05-13 14:50:13', '2026-05-13 14:50:13'),
(613, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -606.08, -648.08, 'RTO Charge AWB: 77790205054', '2026-05-13 14:50:13', '2026-05-13 14:50:13'),
(614, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4812.92, 4822.92, 'COD Refund AWB: 37355837634121', '2026-05-13 14:50:14', '2026-05-13 14:50:14'),
(615, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4822.92, 4813.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 14:50:14', '2026-05-13 14:50:14'),
(616, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4813.92, 4823.92, 'COD Refund AWB: 77789705976', '2026-05-13 14:55:08', '2026-05-13 14:55:08'),
(617, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4823.92, 4814.92, 'RTO Charge AWB: 77789705976', '2026-05-13 14:55:08', '2026-05-13 14:55:08'),
(618, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -648.08, -628.08, 'COD Refund AWB: 77790205054', '2026-05-13 14:55:09', '2026-05-13 14:55:09'),
(619, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -628.08, -670.08, 'RTO Charge AWB: 77790205054', '2026-05-13 14:55:09', '2026-05-13 14:55:09'),
(620, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4814.92, 4824.92, 'COD Refund AWB: 37355837634121', '2026-05-13 14:55:10', '2026-05-13 14:55:10'),
(621, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4824.92, 4815.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 14:55:10', '2026-05-13 14:55:10'),
(622, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4815.92, 4825.92, 'COD Refund AWB: 77789705976', '2026-05-13 15:00:19', '2026-05-13 15:00:19'),
(623, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4825.92, 4816.92, 'RTO Charge AWB: 77789705976', '2026-05-13 15:00:19', '2026-05-13 15:00:19'),
(624, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -670.08, -650.08, 'COD Refund AWB: 77790205054', '2026-05-13 15:00:19', '2026-05-13 15:00:19'),
(625, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -650.08, -692.08, 'RTO Charge AWB: 77790205054', '2026-05-13 15:00:19', '2026-05-13 15:00:19'),
(626, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4816.92, 4826.92, 'COD Refund AWB: 37355837634121', '2026-05-13 15:00:21', '2026-05-13 15:00:21'),
(627, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4826.92, 4817.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 15:00:21', '2026-05-13 15:00:21'),
(628, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4817.92, 4827.92, 'COD Refund AWB: 77789705976', '2026-05-13 15:05:08', '2026-05-13 15:05:08'),
(629, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4827.92, 4818.92, 'RTO Charge AWB: 77789705976', '2026-05-13 15:05:08', '2026-05-13 15:05:08'),
(630, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -692.08, -672.08, 'COD Refund AWB: 77790205054', '2026-05-13 15:05:08', '2026-05-13 15:05:08'),
(631, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -672.08, -714.08, 'RTO Charge AWB: 77790205054', '2026-05-13 15:05:08', '2026-05-13 15:05:08'),
(632, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4818.92, 4828.92, 'COD Refund AWB: 37355837634121', '2026-05-13 15:05:10', '2026-05-13 15:05:10'),
(633, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4828.92, 4819.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 15:05:10', '2026-05-13 15:05:10'),
(634, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4819.92, 4829.92, 'COD Refund AWB: 77789705976', '2026-05-13 15:10:12', '2026-05-13 15:10:12'),
(635, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4829.92, 4820.92, 'RTO Charge AWB: 77789705976', '2026-05-13 15:10:12', '2026-05-13 15:10:12'),
(636, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -714.08, -694.08, 'COD Refund AWB: 77790205054', '2026-05-13 15:10:12', '2026-05-13 15:10:12'),
(637, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -694.08, -736.08, 'RTO Charge AWB: 77790205054', '2026-05-13 15:10:12', '2026-05-13 15:10:12'),
(638, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4820.92, 4830.92, 'COD Refund AWB: 37355837634121', '2026-05-13 15:10:14', '2026-05-13 15:10:14'),
(639, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4830.92, 4821.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 15:10:14', '2026-05-13 15:10:14'),
(640, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4821.92, 4831.92, 'COD Refund AWB: 77789705976', '2026-05-13 15:15:07', '2026-05-13 15:15:07'),
(641, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4831.92, 4822.92, 'RTO Charge AWB: 77789705976', '2026-05-13 15:15:07', '2026-05-13 15:15:07'),
(642, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -736.08, -716.08, 'COD Refund AWB: 77790205054', '2026-05-13 15:15:08', '2026-05-13 15:15:08'),
(643, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -716.08, -758.08, 'RTO Charge AWB: 77790205054', '2026-05-13 15:15:08', '2026-05-13 15:15:08'),
(644, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4822.92, 4832.92, 'COD Refund AWB: 37355837634121', '2026-05-13 15:15:10', '2026-05-13 15:15:10'),
(645, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4832.92, 4823.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 15:15:10', '2026-05-13 15:15:10'),
(646, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4823.92, 4833.92, 'COD Refund AWB: 77789705976', '2026-05-13 15:20:13', '2026-05-13 15:20:13'),
(647, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4833.92, 4824.92, 'RTO Charge AWB: 77789705976', '2026-05-13 15:20:13', '2026-05-13 15:20:13'),
(648, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -758.08, -738.08, 'COD Refund AWB: 77790205054', '2026-05-13 15:20:13', '2026-05-13 15:20:13'),
(649, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -738.08, -780.08, 'RTO Charge AWB: 77790205054', '2026-05-13 15:20:13', '2026-05-13 15:20:13'),
(650, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4824.92, 4834.92, 'COD Refund AWB: 37355837634121', '2026-05-13 15:20:15', '2026-05-13 15:20:15'),
(651, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4834.92, 4825.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 15:20:15', '2026-05-13 15:20:15'),
(652, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4825.92, 4835.92, 'COD Refund AWB: 77789705976', '2026-05-13 15:25:07', '2026-05-13 15:25:07'),
(653, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4835.92, 4826.92, 'RTO Charge AWB: 77789705976', '2026-05-13 15:25:07', '2026-05-13 15:25:07'),
(654, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -780.08, -760.08, 'COD Refund AWB: 77790205054', '2026-05-13 15:25:07', '2026-05-13 15:25:07'),
(655, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -760.08, -802.08, 'RTO Charge AWB: 77790205054', '2026-05-13 15:25:07', '2026-05-13 15:25:07'),
(656, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4826.92, 4836.92, 'COD Refund AWB: 37355837634121', '2026-05-13 15:25:09', '2026-05-13 15:25:09'),
(657, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4836.92, 4827.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 15:25:09', '2026-05-13 15:25:09'),
(658, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4827.92, 4837.92, 'COD Refund AWB: 77789705976', '2026-05-13 15:30:15', '2026-05-13 15:30:15'),
(659, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4837.92, 4828.92, 'RTO Charge AWB: 77789705976', '2026-05-13 15:30:15', '2026-05-13 15:30:15'),
(660, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -802.08, -782.08, 'COD Refund AWB: 77790205054', '2026-05-13 15:30:16', '2026-05-13 15:30:16'),
(661, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -782.08, -824.08, 'RTO Charge AWB: 77790205054', '2026-05-13 15:30:16', '2026-05-13 15:30:16'),
(662, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4828.92, 4838.92, 'COD Refund AWB: 37355837634121', '2026-05-13 15:30:17', '2026-05-13 15:30:17'),
(663, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4838.92, 4829.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 15:30:17', '2026-05-13 15:30:17'),
(664, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4829.92, 4839.92, 'COD Refund AWB: 77789705976', '2026-05-13 15:35:09', '2026-05-13 15:35:09'),
(665, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4839.92, 4830.92, 'RTO Charge AWB: 77789705976', '2026-05-13 15:35:09', '2026-05-13 15:35:09'),
(666, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -824.08, -804.08, 'COD Refund AWB: 77790205054', '2026-05-13 15:35:09', '2026-05-13 15:35:09'),
(667, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -804.08, -846.08, 'RTO Charge AWB: 77790205054', '2026-05-13 15:35:09', '2026-05-13 15:35:09'),
(668, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4830.92, 4840.92, 'COD Refund AWB: 37355837634121', '2026-05-13 15:35:11', '2026-05-13 15:35:11'),
(669, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4840.92, 4831.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 15:35:11', '2026-05-13 15:35:11'),
(670, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4831.92, 4841.92, 'COD Refund AWB: 77789705976', '2026-05-13 15:40:14', '2026-05-13 15:40:14'),
(671, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4841.92, 4832.92, 'RTO Charge AWB: 77789705976', '2026-05-13 15:40:14', '2026-05-13 15:40:14'),
(672, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -846.08, -826.08, 'COD Refund AWB: 77790205054', '2026-05-13 15:40:14', '2026-05-13 15:40:14'),
(673, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -826.08, -868.08, 'RTO Charge AWB: 77790205054', '2026-05-13 15:40:14', '2026-05-13 15:40:14'),
(674, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4832.92, 4842.92, 'COD Refund AWB: 37355837634121', '2026-05-13 15:40:15', '2026-05-13 15:40:15'),
(675, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4842.92, 4833.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 15:40:15', '2026-05-13 15:40:15'),
(676, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4833.92, 4843.92, 'COD Refund AWB: 77789705976', '2026-05-13 15:45:07', '2026-05-13 15:45:07'),
(677, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4843.92, 4834.92, 'RTO Charge AWB: 77789705976', '2026-05-13 15:45:07', '2026-05-13 15:45:07'),
(678, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -868.08, -848.08, 'COD Refund AWB: 77790205054', '2026-05-13 15:45:07', '2026-05-13 15:45:07'),
(679, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -848.08, -890.08, 'RTO Charge AWB: 77790205054', '2026-05-13 15:45:07', '2026-05-13 15:45:07'),
(680, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4834.92, 4844.92, 'COD Refund AWB: 37355837634121', '2026-05-13 15:45:08', '2026-05-13 15:45:08'),
(681, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4844.92, 4835.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 15:45:08', '2026-05-13 15:45:08'),
(682, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4835.92, 4845.92, 'COD Refund AWB: 77789705976', '2026-05-13 15:50:14', '2026-05-13 15:50:14'),
(683, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4845.92, 4836.92, 'RTO Charge AWB: 77789705976', '2026-05-13 15:50:14', '2026-05-13 15:50:14'),
(684, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -890.08, -870.08, 'COD Refund AWB: 77790205054', '2026-05-13 15:50:15', '2026-05-13 15:50:15'),
(685, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -870.08, -912.08, 'RTO Charge AWB: 77790205054', '2026-05-13 15:50:15', '2026-05-13 15:50:15'),
(686, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4836.92, 4846.92, 'COD Refund AWB: 37355837634121', '2026-05-13 15:50:18', '2026-05-13 15:50:18'),
(687, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4846.92, 4837.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 15:50:18', '2026-05-13 15:50:18'),
(688, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4837.92, 4847.92, 'COD Refund AWB: 77789705976', '2026-05-13 15:55:08', '2026-05-13 15:55:08'),
(689, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4847.92, 4838.92, 'RTO Charge AWB: 77789705976', '2026-05-13 15:55:08', '2026-05-13 15:55:08'),
(690, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -912.08, -892.08, 'COD Refund AWB: 77790205054', '2026-05-13 15:55:08', '2026-05-13 15:55:08'),
(691, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -892.08, -934.08, 'RTO Charge AWB: 77790205054', '2026-05-13 15:55:08', '2026-05-13 15:55:08'),
(692, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4838.92, 4848.92, 'COD Refund AWB: 37355837634121', '2026-05-13 15:55:09', '2026-05-13 15:55:09'),
(693, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4848.92, 4839.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 15:55:09', '2026-05-13 15:55:09'),
(694, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4839.92, 4849.92, 'COD Refund AWB: 77789705976', '2026-05-13 16:00:16', '2026-05-13 16:00:16'),
(695, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4849.92, 4840.92, 'RTO Charge AWB: 77789705976', '2026-05-13 16:00:16', '2026-05-13 16:00:16'),
(696, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -934.08, -914.08, 'COD Refund AWB: 77790205054', '2026-05-13 16:00:16', '2026-05-13 16:00:16'),
(697, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -914.08, -956.08, 'RTO Charge AWB: 77790205054', '2026-05-13 16:00:16', '2026-05-13 16:00:16'),
(698, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4840.92, 4850.92, 'COD Refund AWB: 37355837634121', '2026-05-13 16:00:17', '2026-05-13 16:00:17'),
(699, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4850.92, 4841.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 16:00:17', '2026-05-13 16:00:17'),
(700, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4841.92, 4851.92, 'COD Refund AWB: 77789705976', '2026-05-13 16:05:08', '2026-05-13 16:05:08'),
(701, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4851.92, 4842.92, 'RTO Charge AWB: 77789705976', '2026-05-13 16:05:08', '2026-05-13 16:05:08'),
(702, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -956.08, -936.08, 'COD Refund AWB: 77790205054', '2026-05-13 16:05:09', '2026-05-13 16:05:09'),
(703, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -936.08, -978.08, 'RTO Charge AWB: 77790205054', '2026-05-13 16:05:09', '2026-05-13 16:05:09'),
(704, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4842.92, 4852.92, 'COD Refund AWB: 37355837634121', '2026-05-13 16:05:10', '2026-05-13 16:05:10'),
(705, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4852.92, 4843.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 16:05:10', '2026-05-13 16:05:10'),
(706, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4843.92, 4853.92, 'COD Refund AWB: 77789705976', '2026-05-13 16:10:12', '2026-05-13 16:10:12'),
(707, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4853.92, 4844.92, 'RTO Charge AWB: 77789705976', '2026-05-13 16:10:12', '2026-05-13 16:10:12'),
(708, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -978.08, -958.08, 'COD Refund AWB: 77790205054', '2026-05-13 16:10:12', '2026-05-13 16:10:12'),
(709, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -958.08, -1000.08, 'RTO Charge AWB: 77790205054', '2026-05-13 16:10:12', '2026-05-13 16:10:12'),
(710, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4844.92, 4854.92, 'COD Refund AWB: 37355837634121', '2026-05-13 16:10:13', '2026-05-13 16:10:13'),
(711, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4854.92, 4845.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 16:10:13', '2026-05-13 16:10:13'),
(712, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4845.92, 4855.92, 'COD Refund AWB: 77789705976', '2026-05-13 16:15:08', '2026-05-13 16:15:08'),
(713, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4855.92, 4846.92, 'RTO Charge AWB: 77789705976', '2026-05-13 16:15:08', '2026-05-13 16:15:08'),
(714, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1000.08, -980.08, 'COD Refund AWB: 77790205054', '2026-05-13 16:15:08', '2026-05-13 16:15:08'),
(715, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -980.08, -1022.08, 'RTO Charge AWB: 77790205054', '2026-05-13 16:15:08', '2026-05-13 16:15:08'),
(716, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4846.92, 4856.92, 'COD Refund AWB: 37355837634121', '2026-05-13 16:15:09', '2026-05-13 16:15:09'),
(717, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4856.92, 4847.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 16:15:09', '2026-05-13 16:15:09'),
(718, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4847.92, 4857.92, 'COD Refund AWB: 77789705976', '2026-05-13 16:20:10', '2026-05-13 16:20:10'),
(719, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4857.92, 4848.92, 'RTO Charge AWB: 77789705976', '2026-05-13 16:20:10', '2026-05-13 16:20:10'),
(720, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1022.08, -1002.08, 'COD Refund AWB: 77790205054', '2026-05-13 16:20:10', '2026-05-13 16:20:10'),
(721, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1002.08, -1044.08, 'RTO Charge AWB: 77790205054', '2026-05-13 16:20:10', '2026-05-13 16:20:10'),
(722, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4848.92, 4858.92, 'COD Refund AWB: 37355837634121', '2026-05-13 16:20:11', '2026-05-13 16:20:11'),
(723, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4858.92, 4849.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 16:20:11', '2026-05-13 16:20:11'),
(724, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4849.92, 4859.92, 'COD Refund AWB: 77789705976', '2026-05-13 16:25:07', '2026-05-13 16:25:07'),
(725, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4859.92, 4850.92, 'RTO Charge AWB: 77789705976', '2026-05-13 16:25:07', '2026-05-13 16:25:07'),
(726, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1044.08, -1024.08, 'COD Refund AWB: 77790205054', '2026-05-13 16:25:07', '2026-05-13 16:25:07'),
(727, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1024.08, -1066.08, 'RTO Charge AWB: 77790205054', '2026-05-13 16:25:07', '2026-05-13 16:25:07'),
(728, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4850.92, 4860.92, 'COD Refund AWB: 37355837634121', '2026-05-13 16:25:07', '2026-05-13 16:25:07'),
(729, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4860.92, 4851.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 16:25:07', '2026-05-13 16:25:07'),
(730, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4851.92, 4861.92, 'COD Refund AWB: 77789705976', '2026-05-13 16:30:13', '2026-05-13 16:30:13'),
(731, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4861.92, 4852.92, 'RTO Charge AWB: 77789705976', '2026-05-13 16:30:13', '2026-05-13 16:30:13'),
(732, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1066.08, -1046.08, 'COD Refund AWB: 77790205054', '2026-05-13 16:30:14', '2026-05-13 16:30:14'),
(733, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1046.08, -1088.08, 'RTO Charge AWB: 77790205054', '2026-05-13 16:30:14', '2026-05-13 16:30:14'),
(734, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4852.92, 4862.92, 'COD Refund AWB: 37355837634121', '2026-05-13 16:30:14', '2026-05-13 16:30:14'),
(735, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4862.92, 4853.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 16:30:14', '2026-05-13 16:30:14'),
(736, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4853.92, 4863.92, 'COD Refund AWB: 77789705976', '2026-05-13 16:35:07', '2026-05-13 16:35:07'),
(737, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4863.92, 4854.92, 'RTO Charge AWB: 77789705976', '2026-05-13 16:35:07', '2026-05-13 16:35:07'),
(738, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1088.08, -1068.08, 'COD Refund AWB: 77790205054', '2026-05-13 16:35:07', '2026-05-13 16:35:07'),
(739, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1068.08, -1110.08, 'RTO Charge AWB: 77790205054', '2026-05-13 16:35:07', '2026-05-13 16:35:07'),
(740, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4854.92, 4864.92, 'COD Refund AWB: 37355837634121', '2026-05-13 16:35:07', '2026-05-13 16:35:07'),
(741, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4864.92, 4855.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 16:35:07', '2026-05-13 16:35:07'),
(742, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4855.92, 4865.92, 'COD Refund AWB: 77789705976', '2026-05-13 16:40:11', '2026-05-13 16:40:11'),
(743, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4865.92, 4856.92, 'RTO Charge AWB: 77789705976', '2026-05-13 16:40:11', '2026-05-13 16:40:11'),
(744, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1110.08, -1090.08, 'COD Refund AWB: 77790205054', '2026-05-13 16:40:12', '2026-05-13 16:40:12'),
(745, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1090.08, -1132.08, 'RTO Charge AWB: 77790205054', '2026-05-13 16:40:12', '2026-05-13 16:40:12'),
(746, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4856.92, 4866.92, 'COD Refund AWB: 37355837634121', '2026-05-13 16:40:12', '2026-05-13 16:40:12'),
(747, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4866.92, 4857.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 16:40:12', '2026-05-13 16:40:12'),
(748, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4857.92, 4867.92, 'COD Refund AWB: 77789705976', '2026-05-13 16:45:06', '2026-05-13 16:45:06'),
(749, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4867.92, 4858.92, 'RTO Charge AWB: 77789705976', '2026-05-13 16:45:06', '2026-05-13 16:45:06'),
(750, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1132.08, -1112.08, 'COD Refund AWB: 77790205054', '2026-05-13 16:45:06', '2026-05-13 16:45:06'),
(751, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1112.08, -1154.08, 'RTO Charge AWB: 77790205054', '2026-05-13 16:45:06', '2026-05-13 16:45:06'),
(752, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4858.92, 4868.92, 'COD Refund AWB: 37355837634121', '2026-05-13 16:45:07', '2026-05-13 16:45:07'),
(753, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4868.92, 4859.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 16:45:07', '2026-05-13 16:45:07'),
(754, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4859.92, 4869.92, 'COD Refund AWB: 77789705976', '2026-05-13 16:50:11', '2026-05-13 16:50:11'),
(755, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4869.92, 4860.92, 'RTO Charge AWB: 77789705976', '2026-05-13 16:50:11', '2026-05-13 16:50:11'),
(756, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1154.08, -1134.08, 'COD Refund AWB: 77790205054', '2026-05-13 16:50:11', '2026-05-13 16:50:11'),
(757, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1134.08, -1176.08, 'RTO Charge AWB: 77790205054', '2026-05-13 16:50:11', '2026-05-13 16:50:11'),
(758, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4860.92, 4870.92, 'COD Refund AWB: 37355837634121', '2026-05-13 16:50:12', '2026-05-13 16:50:12'),
(759, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4870.92, 4861.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 16:50:12', '2026-05-13 16:50:12'),
(760, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4861.92, 4871.92, 'COD Refund AWB: 77789705976', '2026-05-13 16:55:07', '2026-05-13 16:55:07'),
(761, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4871.92, 4862.92, 'RTO Charge AWB: 77789705976', '2026-05-13 16:55:07', '2026-05-13 16:55:07'),
(762, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1176.08, -1156.08, 'COD Refund AWB: 77790205054', '2026-05-13 16:55:07', '2026-05-13 16:55:07'),
(763, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1156.08, -1198.08, 'RTO Charge AWB: 77790205054', '2026-05-13 16:55:07', '2026-05-13 16:55:07'),
(764, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4862.92, 4872.92, 'COD Refund AWB: 37355837634121', '2026-05-13 16:55:07', '2026-05-13 16:55:07'),
(765, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4872.92, 4863.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 16:55:07', '2026-05-13 16:55:07'),
(766, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4863.92, 4873.92, 'COD Refund AWB: 77789705976', '2026-05-13 17:00:17', '2026-05-13 17:00:17'),
(767, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4873.92, 4864.92, 'RTO Charge AWB: 77789705976', '2026-05-13 17:00:17', '2026-05-13 17:00:17'),
(768, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1198.08, -1178.08, 'COD Refund AWB: 77790205054', '2026-05-13 17:00:17', '2026-05-13 17:00:17'),
(769, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1178.08, -1220.08, 'RTO Charge AWB: 77790205054', '2026-05-13 17:00:17', '2026-05-13 17:00:17'),
(770, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4864.92, 4874.92, 'COD Refund AWB: 37355837634121', '2026-05-13 17:00:17', '2026-05-13 17:00:17'),
(771, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4874.92, 4865.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 17:00:17', '2026-05-13 17:00:17'),
(772, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4865.92, 4875.92, 'COD Refund AWB: 77789705976', '2026-05-13 17:05:07', '2026-05-13 17:05:07'),
(773, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4875.92, 4866.92, 'RTO Charge AWB: 77789705976', '2026-05-13 17:05:07', '2026-05-13 17:05:07'),
(774, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1220.08, -1200.08, 'COD Refund AWB: 77790205054', '2026-05-13 17:05:07', '2026-05-13 17:05:07'),
(775, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1200.08, -1242.08, 'RTO Charge AWB: 77790205054', '2026-05-13 17:05:07', '2026-05-13 17:05:07'),
(776, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4866.92, 4876.92, 'COD Refund AWB: 37355837634121', '2026-05-13 17:05:08', '2026-05-13 17:05:08'),
(777, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4876.92, 4867.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 17:05:08', '2026-05-13 17:05:08'),
(778, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4867.92, 4877.92, 'COD Refund AWB: 77789705976', '2026-05-13 17:10:10', '2026-05-13 17:10:10'),
(779, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4877.92, 4868.92, 'RTO Charge AWB: 77789705976', '2026-05-13 17:10:10', '2026-05-13 17:10:10'),
(780, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1242.08, -1222.08, 'COD Refund AWB: 77790205054', '2026-05-13 17:10:10', '2026-05-13 17:10:10');
INSERT INTO `wallet_transactions` (`id`, `user_id`, `fship_order_id`, `amount`, `type`, `charge_type`, `source`, `opening_balance`, `closing_balance`, `remark`, `created_at`, `updated_at`) VALUES
(781, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1222.08, -1264.08, 'RTO Charge AWB: 77790205054', '2026-05-13 17:10:10', '2026-05-13 17:10:10'),
(782, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4868.92, 4878.92, 'COD Refund AWB: 37355837634121', '2026-05-13 17:10:11', '2026-05-13 17:10:11'),
(783, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4878.92, 4869.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 17:10:11', '2026-05-13 17:10:11'),
(784, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4869.92, 4879.92, 'COD Refund AWB: 77789705976', '2026-05-13 17:15:06', '2026-05-13 17:15:06'),
(785, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4879.92, 4870.92, 'RTO Charge AWB: 77789705976', '2026-05-13 17:15:06', '2026-05-13 17:15:06'),
(786, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1264.08, -1244.08, 'COD Refund AWB: 77790205054', '2026-05-13 17:15:06', '2026-05-13 17:15:06'),
(787, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1244.08, -1286.08, 'RTO Charge AWB: 77790205054', '2026-05-13 17:15:06', '2026-05-13 17:15:06'),
(788, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4870.92, 4880.92, 'COD Refund AWB: 37355837634121', '2026-05-13 17:15:07', '2026-05-13 17:15:07'),
(789, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4880.92, 4871.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 17:15:07', '2026-05-13 17:15:07'),
(790, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4871.92, 4881.92, 'COD Refund AWB: 77789705976', '2026-05-13 17:20:11', '2026-05-13 17:20:11'),
(791, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4881.92, 4872.92, 'RTO Charge AWB: 77789705976', '2026-05-13 17:20:11', '2026-05-13 17:20:11'),
(792, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1286.08, -1266.08, 'COD Refund AWB: 77790205054', '2026-05-13 17:20:11', '2026-05-13 17:20:11'),
(793, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1266.08, -1308.08, 'RTO Charge AWB: 77790205054', '2026-05-13 17:20:11', '2026-05-13 17:20:11'),
(794, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4872.92, 4882.92, 'COD Refund AWB: 37355837634121', '2026-05-13 17:20:11', '2026-05-13 17:20:11'),
(795, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4882.92, 4873.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 17:20:11', '2026-05-13 17:20:11'),
(796, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4873.92, 4883.92, 'COD Refund AWB: 77789705976', '2026-05-13 17:25:07', '2026-05-13 17:25:07'),
(797, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4883.92, 4874.92, 'RTO Charge AWB: 77789705976', '2026-05-13 17:25:07', '2026-05-13 17:25:07'),
(798, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1308.08, -1288.08, 'COD Refund AWB: 77790205054', '2026-05-13 17:25:07', '2026-05-13 17:25:07'),
(799, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1288.08, -1330.08, 'RTO Charge AWB: 77790205054', '2026-05-13 17:25:07', '2026-05-13 17:25:07'),
(800, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4874.92, 4884.92, 'COD Refund AWB: 37355837634121', '2026-05-13 17:25:07', '2026-05-13 17:25:07'),
(801, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4884.92, 4875.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 17:25:07', '2026-05-13 17:25:07'),
(802, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4875.92, 4885.92, 'COD Refund AWB: 77789705976', '2026-05-13 17:30:15', '2026-05-13 17:30:15'),
(803, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4885.92, 4876.92, 'RTO Charge AWB: 77789705976', '2026-05-13 17:30:15', '2026-05-13 17:30:15'),
(804, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1330.08, -1310.08, 'COD Refund AWB: 77790205054', '2026-05-13 17:30:15', '2026-05-13 17:30:15'),
(805, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1310.08, -1352.08, 'RTO Charge AWB: 77790205054', '2026-05-13 17:30:15', '2026-05-13 17:30:15'),
(806, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4876.92, 4886.92, 'COD Refund AWB: 37355837634121', '2026-05-13 17:30:15', '2026-05-13 17:30:15'),
(807, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4886.92, 4877.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 17:30:15', '2026-05-13 17:30:15'),
(808, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4877.92, 4887.92, 'COD Refund AWB: 77789705976', '2026-05-13 17:35:07', '2026-05-13 17:35:07'),
(809, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4887.92, 4878.92, 'RTO Charge AWB: 77789705976', '2026-05-13 17:35:07', '2026-05-13 17:35:07'),
(810, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1352.08, -1332.08, 'COD Refund AWB: 77790205054', '2026-05-13 17:35:07', '2026-05-13 17:35:07'),
(811, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1332.08, -1374.08, 'RTO Charge AWB: 77790205054', '2026-05-13 17:35:07', '2026-05-13 17:35:07'),
(812, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4878.92, 4888.92, 'COD Refund AWB: 37355837634121', '2026-05-13 17:35:08', '2026-05-13 17:35:08'),
(813, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4888.92, 4879.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 17:35:08', '2026-05-13 17:35:08'),
(814, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4879.92, 4889.92, 'COD Refund AWB: 77789705976', '2026-05-13 17:40:11', '2026-05-13 17:40:11'),
(815, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4889.92, 4880.92, 'RTO Charge AWB: 77789705976', '2026-05-13 17:40:11', '2026-05-13 17:40:11'),
(816, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1374.08, -1354.08, 'COD Refund AWB: 77790205054', '2026-05-13 17:40:11', '2026-05-13 17:40:11'),
(817, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1354.08, -1396.08, 'RTO Charge AWB: 77790205054', '2026-05-13 17:40:11', '2026-05-13 17:40:11'),
(818, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4880.92, 4890.92, 'COD Refund AWB: 37355837634121', '2026-05-13 17:40:12', '2026-05-13 17:40:12'),
(819, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4890.92, 4881.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 17:40:12', '2026-05-13 17:40:12'),
(820, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4881.92, 4891.92, 'COD Refund AWB: 77789705976', '2026-05-13 17:45:07', '2026-05-13 17:45:07'),
(821, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4891.92, 4882.92, 'RTO Charge AWB: 77789705976', '2026-05-13 17:45:07', '2026-05-13 17:45:07'),
(822, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1396.08, -1376.08, 'COD Refund AWB: 77790205054', '2026-05-13 17:45:07', '2026-05-13 17:45:07'),
(823, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1376.08, -1418.08, 'RTO Charge AWB: 77790205054', '2026-05-13 17:45:07', '2026-05-13 17:45:07'),
(824, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4882.92, 4892.92, 'COD Refund AWB: 37355837634121', '2026-05-13 17:45:08', '2026-05-13 17:45:08'),
(825, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4892.92, 4883.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 17:45:08', '2026-05-13 17:45:08'),
(826, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4883.92, 4893.92, 'COD Refund AWB: 77789705976', '2026-05-13 17:50:11', '2026-05-13 17:50:11'),
(827, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4893.92, 4884.92, 'RTO Charge AWB: 77789705976', '2026-05-13 17:50:11', '2026-05-13 17:50:11'),
(828, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1418.08, -1398.08, 'COD Refund AWB: 77790205054', '2026-05-13 17:50:12', '2026-05-13 17:50:12'),
(829, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1398.08, -1440.08, 'RTO Charge AWB: 77790205054', '2026-05-13 17:50:12', '2026-05-13 17:50:12'),
(830, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4884.92, 4894.92, 'COD Refund AWB: 37355837634121', '2026-05-13 17:50:12', '2026-05-13 17:50:12'),
(831, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4894.92, 4885.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 17:50:12', '2026-05-13 17:50:12'),
(832, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4885.92, 4895.92, 'COD Refund AWB: 77789705976', '2026-05-13 17:55:07', '2026-05-13 17:55:07'),
(833, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4895.92, 4886.92, 'RTO Charge AWB: 77789705976', '2026-05-13 17:55:07', '2026-05-13 17:55:07'),
(834, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1440.08, -1420.08, 'COD Refund AWB: 77790205054', '2026-05-13 17:55:07', '2026-05-13 17:55:07'),
(835, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1420.08, -1462.08, 'RTO Charge AWB: 77790205054', '2026-05-13 17:55:07', '2026-05-13 17:55:07'),
(836, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4886.92, 4896.92, 'COD Refund AWB: 37355837634121', '2026-05-13 17:55:07', '2026-05-13 17:55:07'),
(837, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4896.92, 4887.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 17:55:07', '2026-05-13 17:55:07'),
(838, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4887.92, 4897.92, 'COD Refund AWB: 77789705976', '2026-05-13 18:00:15', '2026-05-13 18:00:15'),
(839, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4897.92, 4888.92, 'RTO Charge AWB: 77789705976', '2026-05-13 18:00:15', '2026-05-13 18:00:15'),
(840, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1462.08, -1442.08, 'COD Refund AWB: 77790205054', '2026-05-13 18:00:15', '2026-05-13 18:00:15'),
(841, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1442.08, -1484.08, 'RTO Charge AWB: 77790205054', '2026-05-13 18:00:15', '2026-05-13 18:00:15'),
(842, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4888.92, 4898.92, 'COD Refund AWB: 37355837634121', '2026-05-13 18:00:16', '2026-05-13 18:00:16'),
(843, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4898.92, 4889.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 18:00:16', '2026-05-13 18:00:16'),
(844, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4889.92, 4899.92, 'COD Refund AWB: 77789705976', '2026-05-13 18:05:06', '2026-05-13 18:05:06'),
(845, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4899.92, 4890.92, 'RTO Charge AWB: 77789705976', '2026-05-13 18:05:06', '2026-05-13 18:05:06'),
(846, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1484.08, -1464.08, 'COD Refund AWB: 77790205054', '2026-05-13 18:05:06', '2026-05-13 18:05:06'),
(847, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1464.08, -1506.08, 'RTO Charge AWB: 77790205054', '2026-05-13 18:05:06', '2026-05-13 18:05:06'),
(848, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4890.92, 4900.92, 'COD Refund AWB: 37355837634121', '2026-05-13 18:05:07', '2026-05-13 18:05:07'),
(849, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4900.92, 4891.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 18:05:07', '2026-05-13 18:05:07'),
(850, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4891.92, 4901.92, 'COD Refund AWB: 77789705976', '2026-05-13 18:10:10', '2026-05-13 18:10:10'),
(851, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4901.92, 4892.92, 'RTO Charge AWB: 77789705976', '2026-05-13 18:10:10', '2026-05-13 18:10:10'),
(852, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1506.08, -1486.08, 'COD Refund AWB: 77790205054', '2026-05-13 18:10:10', '2026-05-13 18:10:10'),
(853, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1486.08, -1528.08, 'RTO Charge AWB: 77790205054', '2026-05-13 18:10:10', '2026-05-13 18:10:10'),
(854, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4892.92, 4902.92, 'COD Refund AWB: 37355837634121', '2026-05-13 18:10:11', '2026-05-13 18:10:11'),
(855, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4902.92, 4893.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 18:10:11', '2026-05-13 18:10:11'),
(856, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4893.92, 4903.92, 'COD Refund AWB: 77789705976', '2026-05-13 18:15:06', '2026-05-13 18:15:06'),
(857, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4903.92, 4894.92, 'RTO Charge AWB: 77789705976', '2026-05-13 18:15:06', '2026-05-13 18:15:06'),
(858, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1528.08, -1508.08, 'COD Refund AWB: 77790205054', '2026-05-13 18:15:07', '2026-05-13 18:15:07'),
(859, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1508.08, -1550.08, 'RTO Charge AWB: 77790205054', '2026-05-13 18:15:07', '2026-05-13 18:15:07'),
(860, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4894.92, 4904.92, 'COD Refund AWB: 37355837634121', '2026-05-13 18:15:07', '2026-05-13 18:15:07'),
(861, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4904.92, 4895.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 18:15:07', '2026-05-13 18:15:07'),
(862, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4895.92, 4905.92, 'COD Refund AWB: 77789705976', '2026-05-13 18:20:10', '2026-05-13 18:20:10'),
(863, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4905.92, 4896.92, 'RTO Charge AWB: 77789705976', '2026-05-13 18:20:10', '2026-05-13 18:20:10'),
(864, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1550.08, -1530.08, 'COD Refund AWB: 77790205054', '2026-05-13 18:20:10', '2026-05-13 18:20:10'),
(865, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1530.08, -1572.08, 'RTO Charge AWB: 77790205054', '2026-05-13 18:20:10', '2026-05-13 18:20:10'),
(866, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4896.92, 4906.92, 'COD Refund AWB: 37355837634121', '2026-05-13 18:20:11', '2026-05-13 18:20:11'),
(867, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4906.92, 4897.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 18:20:11', '2026-05-13 18:20:11'),
(868, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4897.92, 4907.92, 'COD Refund AWB: 77789705976', '2026-05-13 18:25:06', '2026-05-13 18:25:06'),
(869, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4907.92, 4898.92, 'RTO Charge AWB: 77789705976', '2026-05-13 18:25:06', '2026-05-13 18:25:06'),
(870, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1572.08, -1552.08, 'COD Refund AWB: 77790205054', '2026-05-13 18:25:06', '2026-05-13 18:25:06'),
(871, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1552.08, -1594.08, 'RTO Charge AWB: 77790205054', '2026-05-13 18:25:06', '2026-05-13 18:25:06'),
(872, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4898.92, 4908.92, 'COD Refund AWB: 37355837634121', '2026-05-13 18:25:07', '2026-05-13 18:25:07'),
(873, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4908.92, 4899.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 18:25:07', '2026-05-13 18:25:07'),
(874, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4899.92, 4909.92, 'COD Refund AWB: 77789705976', '2026-05-13 18:30:12', '2026-05-13 18:30:12'),
(875, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4909.92, 4900.92, 'RTO Charge AWB: 77789705976', '2026-05-13 18:30:12', '2026-05-13 18:30:12'),
(876, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1594.08, -1574.08, 'COD Refund AWB: 77790205054', '2026-05-13 18:30:12', '2026-05-13 18:30:12'),
(877, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1574.08, -1616.08, 'RTO Charge AWB: 77790205054', '2026-05-13 18:30:12', '2026-05-13 18:30:12'),
(878, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4900.92, 4910.92, 'COD Refund AWB: 37355837634121', '2026-05-13 18:30:13', '2026-05-13 18:30:13'),
(879, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4910.92, 4901.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 18:30:13', '2026-05-13 18:30:13'),
(880, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4901.92, 4911.92, 'COD Refund AWB: 77789705976', '2026-05-13 18:35:06', '2026-05-13 18:35:06'),
(881, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4911.92, 4902.92, 'RTO Charge AWB: 77789705976', '2026-05-13 18:35:06', '2026-05-13 18:35:06'),
(882, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1616.08, -1596.08, 'COD Refund AWB: 77790205054', '2026-05-13 18:35:06', '2026-05-13 18:35:06'),
(883, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1596.08, -1638.08, 'RTO Charge AWB: 77790205054', '2026-05-13 18:35:06', '2026-05-13 18:35:06'),
(884, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4902.92, 4912.92, 'COD Refund AWB: 37355837634121', '2026-05-13 18:35:07', '2026-05-13 18:35:07'),
(885, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4912.92, 4903.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 18:35:07', '2026-05-13 18:35:07'),
(886, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4903.92, 4913.92, 'COD Refund AWB: 77789705976', '2026-05-13 18:40:10', '2026-05-13 18:40:10'),
(887, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4913.92, 4904.92, 'RTO Charge AWB: 77789705976', '2026-05-13 18:40:10', '2026-05-13 18:40:10'),
(888, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1638.08, -1618.08, 'COD Refund AWB: 77790205054', '2026-05-13 18:40:10', '2026-05-13 18:40:10'),
(889, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1618.08, -1660.08, 'RTO Charge AWB: 77790205054', '2026-05-13 18:40:10', '2026-05-13 18:40:10'),
(890, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4904.92, 4914.92, 'COD Refund AWB: 37355837634121', '2026-05-13 18:40:11', '2026-05-13 18:40:11'),
(891, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4914.92, 4905.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 18:40:11', '2026-05-13 18:40:11'),
(892, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4905.92, 4915.92, 'COD Refund AWB: 77789705976', '2026-05-13 18:45:06', '2026-05-13 18:45:06'),
(893, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4915.92, 4906.92, 'RTO Charge AWB: 77789705976', '2026-05-13 18:45:06', '2026-05-13 18:45:06'),
(894, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1660.08, -1640.08, 'COD Refund AWB: 77790205054', '2026-05-13 18:45:06', '2026-05-13 18:45:06'),
(895, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1640.08, -1682.08, 'RTO Charge AWB: 77790205054', '2026-05-13 18:45:06', '2026-05-13 18:45:06'),
(896, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4906.92, 4916.92, 'COD Refund AWB: 37355837634121', '2026-05-13 18:45:07', '2026-05-13 18:45:07'),
(897, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4916.92, 4907.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 18:45:07', '2026-05-13 18:45:07'),
(898, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4907.92, 4917.92, 'COD Refund AWB: 77789705976', '2026-05-13 18:50:10', '2026-05-13 18:50:10'),
(899, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4917.92, 4908.92, 'RTO Charge AWB: 77789705976', '2026-05-13 18:50:10', '2026-05-13 18:50:10'),
(900, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1682.08, -1662.08, 'COD Refund AWB: 77790205054', '2026-05-13 18:50:10', '2026-05-13 18:50:10'),
(901, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1662.08, -1704.08, 'RTO Charge AWB: 77790205054', '2026-05-13 18:50:10', '2026-05-13 18:50:10'),
(902, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4908.92, 4918.92, 'COD Refund AWB: 37355837634121', '2026-05-13 18:50:11', '2026-05-13 18:50:11'),
(903, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4918.92, 4909.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 18:50:11', '2026-05-13 18:50:11'),
(904, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4909.92, 4919.92, 'COD Refund AWB: 77789705976', '2026-05-13 18:55:07', '2026-05-13 18:55:07'),
(905, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4919.92, 4910.92, 'RTO Charge AWB: 77789705976', '2026-05-13 18:55:07', '2026-05-13 18:55:07'),
(906, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1704.08, -1684.08, 'COD Refund AWB: 77790205054', '2026-05-13 18:55:07', '2026-05-13 18:55:07'),
(907, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1684.08, -1726.08, 'RTO Charge AWB: 77790205054', '2026-05-13 18:55:07', '2026-05-13 18:55:07'),
(908, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4910.92, 4920.92, 'COD Refund AWB: 37355837634121', '2026-05-13 18:55:07', '2026-05-13 18:55:07'),
(909, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4920.92, 4911.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 18:55:07', '2026-05-13 18:55:07'),
(910, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4911.92, 4921.92, 'COD Refund AWB: 77789705976', '2026-05-13 19:00:14', '2026-05-13 19:00:14'),
(911, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4921.92, 4912.92, 'RTO Charge AWB: 77789705976', '2026-05-13 19:00:14', '2026-05-13 19:00:14'),
(912, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1726.08, -1706.08, 'COD Refund AWB: 77790205054', '2026-05-13 19:00:14', '2026-05-13 19:00:14'),
(913, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1706.08, -1748.08, 'RTO Charge AWB: 77790205054', '2026-05-13 19:00:14', '2026-05-13 19:00:14'),
(914, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4912.92, 4922.92, 'COD Refund AWB: 37355837634121', '2026-05-13 19:00:14', '2026-05-13 19:00:14'),
(915, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4922.92, 4913.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 19:00:14', '2026-05-13 19:00:14'),
(916, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4913.92, 4923.92, 'COD Refund AWB: 77789705976', '2026-05-13 19:05:05', '2026-05-13 19:05:05'),
(917, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4923.92, 4914.92, 'RTO Charge AWB: 77789705976', '2026-05-13 19:05:05', '2026-05-13 19:05:05'),
(918, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1748.08, -1728.08, 'COD Refund AWB: 77790205054', '2026-05-13 19:05:05', '2026-05-13 19:05:05'),
(919, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1728.08, -1770.08, 'RTO Charge AWB: 77790205054', '2026-05-13 19:05:05', '2026-05-13 19:05:05'),
(920, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4914.92, 4924.92, 'COD Refund AWB: 37355837634121', '2026-05-13 19:05:06', '2026-05-13 19:05:06'),
(921, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4924.92, 4915.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 19:05:06', '2026-05-13 19:05:06'),
(922, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4915.92, 4925.92, 'COD Refund AWB: 77789705976', '2026-05-13 19:10:13', '2026-05-13 19:10:13'),
(923, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4925.92, 4916.92, 'RTO Charge AWB: 77789705976', '2026-05-13 19:10:13', '2026-05-13 19:10:13'),
(924, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1770.08, -1750.08, 'COD Refund AWB: 77790205054', '2026-05-13 19:10:13', '2026-05-13 19:10:13'),
(925, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1750.08, -1792.08, 'RTO Charge AWB: 77790205054', '2026-05-13 19:10:13', '2026-05-13 19:10:13'),
(926, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4916.92, 4926.92, 'COD Refund AWB: 37355837634121', '2026-05-13 19:10:13', '2026-05-13 19:10:13'),
(927, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4926.92, 4917.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 19:10:13', '2026-05-13 19:10:13'),
(928, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4917.92, 4927.92, 'COD Refund AWB: 77789705976', '2026-05-13 19:15:08', '2026-05-13 19:15:08'),
(929, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4927.92, 4918.92, 'RTO Charge AWB: 77789705976', '2026-05-13 19:15:08', '2026-05-13 19:15:08'),
(930, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1792.08, -1772.08, 'COD Refund AWB: 77790205054', '2026-05-13 19:15:08', '2026-05-13 19:15:08'),
(931, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1772.08, -1814.08, 'RTO Charge AWB: 77790205054', '2026-05-13 19:15:08', '2026-05-13 19:15:08'),
(932, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4918.92, 4928.92, 'COD Refund AWB: 37355837634121', '2026-05-13 19:15:09', '2026-05-13 19:15:09'),
(933, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4928.92, 4919.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 19:15:09', '2026-05-13 19:15:09'),
(934, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4919.92, 4929.92, 'COD Refund AWB: 77789705976', '2026-05-13 19:20:12', '2026-05-13 19:20:12'),
(935, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4929.92, 4920.92, 'RTO Charge AWB: 77789705976', '2026-05-13 19:20:12', '2026-05-13 19:20:12'),
(936, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1814.08, -1794.08, 'COD Refund AWB: 77790205054', '2026-05-13 19:20:12', '2026-05-13 19:20:12'),
(937, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1794.08, -1836.08, 'RTO Charge AWB: 77790205054', '2026-05-13 19:20:12', '2026-05-13 19:20:12'),
(938, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4920.92, 4930.92, 'COD Refund AWB: 37355837634121', '2026-05-13 19:20:13', '2026-05-13 19:20:13'),
(939, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4930.92, 4921.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 19:20:13', '2026-05-13 19:20:13'),
(940, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4921.92, 4931.92, 'COD Refund AWB: 77789705976', '2026-05-13 19:25:08', '2026-05-13 19:25:08'),
(941, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4931.92, 4922.92, 'RTO Charge AWB: 77789705976', '2026-05-13 19:25:08', '2026-05-13 19:25:08'),
(942, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1836.08, -1816.08, 'COD Refund AWB: 77790205054', '2026-05-13 19:25:08', '2026-05-13 19:25:08'),
(943, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1816.08, -1858.08, 'RTO Charge AWB: 77790205054', '2026-05-13 19:25:08', '2026-05-13 19:25:08'),
(944, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4922.92, 4932.92, 'COD Refund AWB: 37355837634121', '2026-05-13 19:25:09', '2026-05-13 19:25:09'),
(945, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4932.92, 4923.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 19:25:09', '2026-05-13 19:25:09'),
(946, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4923.92, 4933.92, 'COD Refund AWB: 77789705976', '2026-05-13 19:30:13', '2026-05-13 19:30:13'),
(947, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4933.92, 4924.92, 'RTO Charge AWB: 77789705976', '2026-05-13 19:30:13', '2026-05-13 19:30:13'),
(948, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1858.08, -1838.08, 'COD Refund AWB: 77790205054', '2026-05-13 19:30:14', '2026-05-13 19:30:14'),
(949, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1838.08, -1880.08, 'RTO Charge AWB: 77790205054', '2026-05-13 19:30:14', '2026-05-13 19:30:14'),
(950, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4924.92, 4934.92, 'COD Refund AWB: 37355837634121', '2026-05-13 19:30:14', '2026-05-13 19:30:14'),
(951, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4934.92, 4925.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 19:30:14', '2026-05-13 19:30:14'),
(952, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4925.92, 4935.92, 'COD Refund AWB: 77789705976', '2026-05-13 19:35:06', '2026-05-13 19:35:06'),
(953, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4935.92, 4926.92, 'RTO Charge AWB: 77789705976', '2026-05-13 19:35:06', '2026-05-13 19:35:06'),
(954, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1880.08, -1860.08, 'COD Refund AWB: 77790205054', '2026-05-13 19:35:06', '2026-05-13 19:35:06'),
(955, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1860.08, -1902.08, 'RTO Charge AWB: 77790205054', '2026-05-13 19:35:06', '2026-05-13 19:35:06'),
(956, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4926.92, 4936.92, 'COD Refund AWB: 37355837634121', '2026-05-13 19:35:07', '2026-05-13 19:35:07'),
(957, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4936.92, 4927.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 19:35:07', '2026-05-13 19:35:07'),
(958, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4927.92, 4937.92, 'COD Refund AWB: 77789705976', '2026-05-13 19:40:11', '2026-05-13 19:40:11'),
(959, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4937.92, 4928.92, 'RTO Charge AWB: 77789705976', '2026-05-13 19:40:11', '2026-05-13 19:40:11'),
(960, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1902.08, -1882.08, 'COD Refund AWB: 77790205054', '2026-05-13 19:40:11', '2026-05-13 19:40:11'),
(961, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1882.08, -1924.08, 'RTO Charge AWB: 77790205054', '2026-05-13 19:40:11', '2026-05-13 19:40:11'),
(962, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4928.92, 4938.92, 'COD Refund AWB: 37355837634121', '2026-05-13 19:40:11', '2026-05-13 19:40:11'),
(963, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4938.92, 4929.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 19:40:11', '2026-05-13 19:40:11'),
(964, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4929.92, 4939.92, 'COD Refund AWB: 77789705976', '2026-05-13 19:45:07', '2026-05-13 19:45:07'),
(965, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4939.92, 4930.92, 'RTO Charge AWB: 77789705976', '2026-05-13 19:45:07', '2026-05-13 19:45:07'),
(966, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1924.08, -1904.08, 'COD Refund AWB: 77790205054', '2026-05-13 19:45:07', '2026-05-13 19:45:07'),
(967, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1904.08, -1946.08, 'RTO Charge AWB: 77790205054', '2026-05-13 19:45:07', '2026-05-13 19:45:07'),
(968, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4930.92, 4940.92, 'COD Refund AWB: 37355837634121', '2026-05-13 19:45:08', '2026-05-13 19:45:08'),
(969, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4940.92, 4931.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 19:45:08', '2026-05-13 19:45:08'),
(970, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4931.92, 4941.92, 'COD Refund AWB: 77789705976', '2026-05-13 19:50:10', '2026-05-13 19:50:10'),
(971, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4941.92, 4932.92, 'RTO Charge AWB: 77789705976', '2026-05-13 19:50:10', '2026-05-13 19:50:10'),
(972, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1946.08, -1926.08, 'COD Refund AWB: 77790205054', '2026-05-13 19:50:11', '2026-05-13 19:50:11'),
(973, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1926.08, -1968.08, 'RTO Charge AWB: 77790205054', '2026-05-13 19:50:11', '2026-05-13 19:50:11'),
(974, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4932.92, 4942.92, 'COD Refund AWB: 37355837634121', '2026-05-13 19:50:11', '2026-05-13 19:50:11'),
(975, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4942.92, 4933.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 19:50:11', '2026-05-13 19:50:11'),
(976, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4933.92, 4943.92, 'COD Refund AWB: 77789705976', '2026-05-13 19:55:07', '2026-05-13 19:55:07'),
(977, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4943.92, 4934.92, 'RTO Charge AWB: 77789705976', '2026-05-13 19:55:07', '2026-05-13 19:55:07'),
(978, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1968.08, -1948.08, 'COD Refund AWB: 77790205054', '2026-05-13 19:55:07', '2026-05-13 19:55:07'),
(979, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1948.08, -1990.08, 'RTO Charge AWB: 77790205054', '2026-05-13 19:55:07', '2026-05-13 19:55:07'),
(980, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4934.92, 4944.92, 'COD Refund AWB: 37355837634121', '2026-05-13 19:55:08', '2026-05-13 19:55:08'),
(981, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4944.92, 4935.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 19:55:08', '2026-05-13 19:55:08'),
(982, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4935.92, 4945.92, 'COD Refund AWB: 77789705976', '2026-05-13 20:00:14', '2026-05-13 20:00:14'),
(983, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4945.92, 4936.92, 'RTO Charge AWB: 77789705976', '2026-05-13 20:00:14', '2026-05-13 20:00:14'),
(984, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -1990.08, -1970.08, 'COD Refund AWB: 77790205054', '2026-05-13 20:00:14', '2026-05-13 20:00:14'),
(985, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1970.08, -2012.08, 'RTO Charge AWB: 77790205054', '2026-05-13 20:00:14', '2026-05-13 20:00:14'),
(986, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4936.92, 4946.92, 'COD Refund AWB: 37355837634121', '2026-05-13 20:00:14', '2026-05-13 20:00:14'),
(987, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4946.92, 4937.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 20:00:14', '2026-05-13 20:00:14'),
(988, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4937.92, 4947.92, 'COD Refund AWB: 77789705976', '2026-05-13 20:05:07', '2026-05-13 20:05:07'),
(989, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4947.92, 4938.92, 'RTO Charge AWB: 77789705976', '2026-05-13 20:05:07', '2026-05-13 20:05:07'),
(990, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2012.08, -1992.08, 'COD Refund AWB: 77790205054', '2026-05-13 20:05:07', '2026-05-13 20:05:07'),
(991, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -1992.08, -2034.08, 'RTO Charge AWB: 77790205054', '2026-05-13 20:05:07', '2026-05-13 20:05:07'),
(992, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4938.92, 4948.92, 'COD Refund AWB: 37355837634121', '2026-05-13 20:05:08', '2026-05-13 20:05:08'),
(993, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4948.92, 4939.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 20:05:08', '2026-05-13 20:05:08'),
(994, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4939.92, 4949.92, 'COD Refund AWB: 77789705976', '2026-05-13 20:10:12', '2026-05-13 20:10:12'),
(995, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4949.92, 4940.92, 'RTO Charge AWB: 77789705976', '2026-05-13 20:10:12', '2026-05-13 20:10:12'),
(996, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2034.08, -2014.08, 'COD Refund AWB: 77790205054', '2026-05-13 20:10:12', '2026-05-13 20:10:12'),
(997, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2014.08, -2056.08, 'RTO Charge AWB: 77790205054', '2026-05-13 20:10:12', '2026-05-13 20:10:12'),
(998, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4940.92, 4950.92, 'COD Refund AWB: 37355837634121', '2026-05-13 20:10:13', '2026-05-13 20:10:13'),
(999, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4950.92, 4941.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 20:10:13', '2026-05-13 20:10:13'),
(1000, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4941.92, 4951.92, 'COD Refund AWB: 77789705976', '2026-05-13 20:15:08', '2026-05-13 20:15:08'),
(1001, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4951.92, 4942.92, 'RTO Charge AWB: 77789705976', '2026-05-13 20:15:08', '2026-05-13 20:15:08'),
(1002, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2056.08, -2036.08, 'COD Refund AWB: 77790205054', '2026-05-13 20:15:08', '2026-05-13 20:15:08'),
(1003, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2036.08, -2078.08, 'RTO Charge AWB: 77790205054', '2026-05-13 20:15:08', '2026-05-13 20:15:08'),
(1004, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4942.92, 4952.92, 'COD Refund AWB: 37355837634121', '2026-05-13 20:15:09', '2026-05-13 20:15:09'),
(1005, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4952.92, 4943.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 20:15:09', '2026-05-13 20:15:09'),
(1006, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4943.92, 4953.92, 'COD Refund AWB: 77789705976', '2026-05-13 20:20:13', '2026-05-13 20:20:13'),
(1007, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4953.92, 4944.92, 'RTO Charge AWB: 77789705976', '2026-05-13 20:20:13', '2026-05-13 20:20:13'),
(1008, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2078.08, -2058.08, 'COD Refund AWB: 77790205054', '2026-05-13 20:20:13', '2026-05-13 20:20:13'),
(1009, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2058.08, -2100.08, 'RTO Charge AWB: 77790205054', '2026-05-13 20:20:13', '2026-05-13 20:20:13'),
(1010, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4944.92, 4954.92, 'COD Refund AWB: 37355837634121', '2026-05-13 20:20:13', '2026-05-13 20:20:13'),
(1011, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4954.92, 4945.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 20:20:13', '2026-05-13 20:20:13'),
(1012, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4945.92, 4955.92, 'COD Refund AWB: 77789705976', '2026-05-13 20:25:09', '2026-05-13 20:25:09'),
(1013, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4955.92, 4946.92, 'RTO Charge AWB: 77789705976', '2026-05-13 20:25:09', '2026-05-13 20:25:09'),
(1014, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2100.08, -2080.08, 'COD Refund AWB: 77790205054', '2026-05-13 20:25:09', '2026-05-13 20:25:09'),
(1015, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2080.08, -2122.08, 'RTO Charge AWB: 77790205054', '2026-05-13 20:25:09', '2026-05-13 20:25:09'),
(1016, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4946.92, 4956.92, 'COD Refund AWB: 37355837634121', '2026-05-13 20:25:10', '2026-05-13 20:25:10'),
(1017, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4956.92, 4947.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 20:25:10', '2026-05-13 20:25:10'),
(1018, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4947.92, 4957.92, 'COD Refund AWB: 77789705976', '2026-05-13 20:30:09', '2026-05-13 20:30:09'),
(1019, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4957.92, 4948.92, 'RTO Charge AWB: 77789705976', '2026-05-13 20:30:09', '2026-05-13 20:30:09'),
(1020, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2122.08, -2102.08, 'COD Refund AWB: 77790205054', '2026-05-13 20:30:09', '2026-05-13 20:30:09'),
(1021, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2102.08, -2144.08, 'RTO Charge AWB: 77790205054', '2026-05-13 20:30:09', '2026-05-13 20:30:09'),
(1022, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4948.92, 4958.92, 'COD Refund AWB: 37355837634121', '2026-05-13 20:30:10', '2026-05-13 20:30:10'),
(1023, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4958.92, 4949.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 20:30:10', '2026-05-13 20:30:10'),
(1024, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4949.92, 4959.92, 'COD Refund AWB: 77789705976', '2026-05-13 20:35:12', '2026-05-13 20:35:12'),
(1025, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4959.92, 4950.92, 'RTO Charge AWB: 77789705976', '2026-05-13 20:35:12', '2026-05-13 20:35:12'),
(1026, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2144.08, -2124.08, 'COD Refund AWB: 77790205054', '2026-05-13 20:35:12', '2026-05-13 20:35:12'),
(1027, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2124.08, -2166.08, 'RTO Charge AWB: 77790205054', '2026-05-13 20:35:12', '2026-05-13 20:35:12'),
(1028, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4950.92, 4960.92, 'COD Refund AWB: 37355837634121', '2026-05-13 20:35:13', '2026-05-13 20:35:13'),
(1029, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4960.92, 4951.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 20:35:13', '2026-05-13 20:35:13'),
(1030, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4951.92, 4961.92, 'COD Refund AWB: 77789705976', '2026-05-13 20:40:15', '2026-05-13 20:40:15'),
(1031, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4961.92, 4952.92, 'RTO Charge AWB: 77789705976', '2026-05-13 20:40:15', '2026-05-13 20:40:15'),
(1032, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2166.08, -2146.08, 'COD Refund AWB: 77790205054', '2026-05-13 20:40:15', '2026-05-13 20:40:15'),
(1033, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2146.08, -2188.08, 'RTO Charge AWB: 77790205054', '2026-05-13 20:40:15', '2026-05-13 20:40:15'),
(1034, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4952.92, 4962.92, 'COD Refund AWB: 37355837634121', '2026-05-13 20:40:16', '2026-05-13 20:40:16'),
(1035, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4962.92, 4953.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 20:40:16', '2026-05-13 20:40:16'),
(1036, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4953.92, 4963.92, 'COD Refund AWB: 77789705976', '2026-05-13 20:45:09', '2026-05-13 20:45:09'),
(1037, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4963.92, 4954.92, 'RTO Charge AWB: 77789705976', '2026-05-13 20:45:09', '2026-05-13 20:45:09'),
(1038, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2188.08, -2168.08, 'COD Refund AWB: 77790205054', '2026-05-13 20:45:09', '2026-05-13 20:45:09'),
(1039, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2168.08, -2210.08, 'RTO Charge AWB: 77790205054', '2026-05-13 20:45:09', '2026-05-13 20:45:09'),
(1040, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4954.92, 4964.92, 'COD Refund AWB: 37355837634121', '2026-05-13 20:45:10', '2026-05-13 20:45:10'),
(1041, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4964.92, 4955.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 20:45:10', '2026-05-13 20:45:10'),
(1042, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4955.92, 4965.92, 'COD Refund AWB: 77789705976', '2026-05-13 20:50:09', '2026-05-13 20:50:09'),
(1043, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4965.92, 4956.92, 'RTO Charge AWB: 77789705976', '2026-05-13 20:50:09', '2026-05-13 20:50:09'),
(1044, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2210.08, -2190.08, 'COD Refund AWB: 77790205054', '2026-05-13 20:50:09', '2026-05-13 20:50:09'),
(1045, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2190.08, -2232.08, 'RTO Charge AWB: 77790205054', '2026-05-13 20:50:09', '2026-05-13 20:50:09'),
(1046, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4956.92, 4966.92, 'COD Refund AWB: 37355837634121', '2026-05-13 20:50:09', '2026-05-13 20:50:09'),
(1047, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4966.92, 4957.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 20:50:09', '2026-05-13 20:50:09'),
(1048, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4957.92, 4967.92, 'COD Refund AWB: 77789705976', '2026-05-13 20:55:11', '2026-05-13 20:55:11'),
(1049, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4967.92, 4958.92, 'RTO Charge AWB: 77789705976', '2026-05-13 20:55:11', '2026-05-13 20:55:11'),
(1050, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2232.08, -2212.08, 'COD Refund AWB: 77790205054', '2026-05-13 20:55:11', '2026-05-13 20:55:11'),
(1051, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2212.08, -2254.08, 'RTO Charge AWB: 77790205054', '2026-05-13 20:55:11', '2026-05-13 20:55:11'),
(1052, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4958.92, 4968.92, 'COD Refund AWB: 37355837634121', '2026-05-13 20:55:12', '2026-05-13 20:55:12'),
(1053, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4968.92, 4959.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 20:55:12', '2026-05-13 20:55:12'),
(1054, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4959.92, 4969.92, 'COD Refund AWB: 77789705976', '2026-05-13 21:00:09', '2026-05-13 21:00:09'),
(1055, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4969.92, 4960.92, 'RTO Charge AWB: 77789705976', '2026-05-13 21:00:09', '2026-05-13 21:00:09'),
(1056, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2254.08, -2234.08, 'COD Refund AWB: 77790205054', '2026-05-13 21:00:09', '2026-05-13 21:00:09'),
(1057, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2234.08, -2276.08, 'RTO Charge AWB: 77790205054', '2026-05-13 21:00:09', '2026-05-13 21:00:09'),
(1058, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4960.92, 4970.92, 'COD Refund AWB: 37355837634121', '2026-05-13 21:00:10', '2026-05-13 21:00:10'),
(1059, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4970.92, 4961.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 21:00:10', '2026-05-13 21:00:10'),
(1060, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4961.92, 4971.92, 'COD Refund AWB: 77789705976', '2026-05-13 21:05:11', '2026-05-13 21:05:11'),
(1061, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4971.92, 4962.92, 'RTO Charge AWB: 77789705976', '2026-05-13 21:05:11', '2026-05-13 21:05:11'),
(1062, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2276.08, -2256.08, 'COD Refund AWB: 77790205054', '2026-05-13 21:05:12', '2026-05-13 21:05:12'),
(1063, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2256.08, -2298.08, 'RTO Charge AWB: 77790205054', '2026-05-13 21:05:12', '2026-05-13 21:05:12'),
(1064, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4962.92, 4972.92, 'COD Refund AWB: 37355837634121', '2026-05-13 21:05:12', '2026-05-13 21:05:12'),
(1065, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4972.92, 4963.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 21:05:12', '2026-05-13 21:05:12'),
(1066, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4963.92, 4973.92, 'COD Refund AWB: 77789705976', '2026-05-13 21:10:08', '2026-05-13 21:10:08'),
(1067, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4973.92, 4964.92, 'RTO Charge AWB: 77789705976', '2026-05-13 21:10:08', '2026-05-13 21:10:08'),
(1068, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2298.08, -2278.08, 'COD Refund AWB: 77790205054', '2026-05-13 21:10:08', '2026-05-13 21:10:08'),
(1069, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2278.08, -2320.08, 'RTO Charge AWB: 77790205054', '2026-05-13 21:10:08', '2026-05-13 21:10:08'),
(1070, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4964.92, 4974.92, 'COD Refund AWB: 37355837634121', '2026-05-13 21:10:09', '2026-05-13 21:10:09'),
(1071, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4974.92, 4965.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 21:10:09', '2026-05-13 21:10:09'),
(1072, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4965.92, 4975.92, 'COD Refund AWB: 77789705976', '2026-05-13 21:15:12', '2026-05-13 21:15:12'),
(1073, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4975.92, 4966.92, 'RTO Charge AWB: 77789705976', '2026-05-13 21:15:12', '2026-05-13 21:15:12'),
(1074, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2320.08, -2300.08, 'COD Refund AWB: 77790205054', '2026-05-13 21:15:12', '2026-05-13 21:15:12'),
(1075, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2300.08, -2342.08, 'RTO Charge AWB: 77790205054', '2026-05-13 21:15:12', '2026-05-13 21:15:12'),
(1076, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4966.92, 4976.92, 'COD Refund AWB: 37355837634121', '2026-05-13 21:15:13', '2026-05-13 21:15:13'),
(1077, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4976.92, 4967.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 21:15:13', '2026-05-13 21:15:13'),
(1078, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4967.92, 4977.92, 'COD Refund AWB: 77789705976', '2026-05-13 21:20:08', '2026-05-13 21:20:08'),
(1079, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4977.92, 4968.92, 'RTO Charge AWB: 77789705976', '2026-05-13 21:20:08', '2026-05-13 21:20:08'),
(1080, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2342.08, -2322.08, 'COD Refund AWB: 77790205054', '2026-05-13 21:20:08', '2026-05-13 21:20:08'),
(1081, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2322.08, -2364.08, 'RTO Charge AWB: 77790205054', '2026-05-13 21:20:08', '2026-05-13 21:20:08'),
(1082, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4968.92, 4978.92, 'COD Refund AWB: 37355837634121', '2026-05-13 21:20:08', '2026-05-13 21:20:08'),
(1083, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4978.92, 4969.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 21:20:08', '2026-05-13 21:20:08'),
(1084, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4969.92, 4979.92, 'COD Refund AWB: 77789705976', '2026-05-13 21:25:11', '2026-05-13 21:25:11'),
(1085, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4979.92, 4970.92, 'RTO Charge AWB: 77789705976', '2026-05-13 21:25:11', '2026-05-13 21:25:11'),
(1086, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2364.08, -2344.08, 'COD Refund AWB: 77790205054', '2026-05-13 21:25:11', '2026-05-13 21:25:11'),
(1087, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2344.08, -2386.08, 'RTO Charge AWB: 77790205054', '2026-05-13 21:25:11', '2026-05-13 21:25:11'),
(1088, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4970.92, 4980.92, 'COD Refund AWB: 37355837634121', '2026-05-13 21:25:12', '2026-05-13 21:25:12'),
(1089, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4980.92, 4971.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 21:25:12', '2026-05-13 21:25:12'),
(1090, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4971.92, 4981.92, 'COD Refund AWB: 77789705976', '2026-05-13 21:30:10', '2026-05-13 21:30:10'),
(1091, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4981.92, 4972.92, 'RTO Charge AWB: 77789705976', '2026-05-13 21:30:10', '2026-05-13 21:30:10'),
(1092, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2386.08, -2366.08, 'COD Refund AWB: 77790205054', '2026-05-13 21:30:11', '2026-05-13 21:30:11'),
(1093, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2366.08, -2408.08, 'RTO Charge AWB: 77790205054', '2026-05-13 21:30:11', '2026-05-13 21:30:11'),
(1094, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4972.92, 4982.92, 'COD Refund AWB: 37355837634121', '2026-05-13 21:30:12', '2026-05-13 21:30:12'),
(1095, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4982.92, 4973.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 21:30:12', '2026-05-13 21:30:12'),
(1096, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4973.92, 4983.92, 'COD Refund AWB: 77789705976', '2026-05-13 21:35:12', '2026-05-13 21:35:12'),
(1097, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4983.92, 4974.92, 'RTO Charge AWB: 77789705976', '2026-05-13 21:35:12', '2026-05-13 21:35:12'),
(1098, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2408.08, -2388.08, 'COD Refund AWB: 77790205054', '2026-05-13 21:35:12', '2026-05-13 21:35:12'),
(1099, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2388.08, -2430.08, 'RTO Charge AWB: 77790205054', '2026-05-13 21:35:12', '2026-05-13 21:35:12'),
(1100, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4974.92, 4984.92, 'COD Refund AWB: 37355837634121', '2026-05-13 21:35:13', '2026-05-13 21:35:13'),
(1101, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4984.92, 4975.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 21:35:13', '2026-05-13 21:35:13'),
(1102, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4975.92, 4985.92, 'COD Refund AWB: 77789705976', '2026-05-13 21:40:07', '2026-05-13 21:40:07'),
(1103, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4985.92, 4976.92, 'RTO Charge AWB: 77789705976', '2026-05-13 21:40:07', '2026-05-13 21:40:07'),
(1104, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2430.08, -2410.08, 'COD Refund AWB: 77790205054', '2026-05-13 21:40:07', '2026-05-13 21:40:07');
INSERT INTO `wallet_transactions` (`id`, `user_id`, `fship_order_id`, `amount`, `type`, `charge_type`, `source`, `opening_balance`, `closing_balance`, `remark`, `created_at`, `updated_at`) VALUES
(1105, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2410.08, -2452.08, 'RTO Charge AWB: 77790205054', '2026-05-13 21:40:07', '2026-05-13 21:40:07'),
(1106, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4976.92, 4986.92, 'COD Refund AWB: 37355837634121', '2026-05-13 21:40:08', '2026-05-13 21:40:08'),
(1107, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4986.92, 4977.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 21:40:08', '2026-05-13 21:40:08'),
(1108, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4977.92, 4987.92, 'COD Refund AWB: 77789705976', '2026-05-13 21:45:10', '2026-05-13 21:45:10'),
(1109, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4987.92, 4978.92, 'RTO Charge AWB: 77789705976', '2026-05-13 21:45:10', '2026-05-13 21:45:10'),
(1110, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2452.08, -2432.08, 'COD Refund AWB: 77790205054', '2026-05-13 21:45:10', '2026-05-13 21:45:10'),
(1111, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2432.08, -2474.08, 'RTO Charge AWB: 77790205054', '2026-05-13 21:45:10', '2026-05-13 21:45:10'),
(1112, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4978.92, 4988.92, 'COD Refund AWB: 37355837634121', '2026-05-13 21:45:11', '2026-05-13 21:45:11'),
(1113, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4988.92, 4979.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 21:45:11', '2026-05-13 21:45:11'),
(1114, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4979.92, 4989.92, 'COD Refund AWB: 77789705976', '2026-05-13 21:50:08', '2026-05-13 21:50:08'),
(1115, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4989.92, 4980.92, 'RTO Charge AWB: 77789705976', '2026-05-13 21:50:08', '2026-05-13 21:50:08'),
(1116, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2474.08, -2454.08, 'COD Refund AWB: 77790205054', '2026-05-13 21:50:08', '2026-05-13 21:50:08'),
(1117, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2454.08, -2496.08, 'RTO Charge AWB: 77790205054', '2026-05-13 21:50:08', '2026-05-13 21:50:08'),
(1118, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4980.92, 4990.92, 'COD Refund AWB: 37355837634121', '2026-05-13 21:50:08', '2026-05-13 21:50:08'),
(1119, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4990.92, 4981.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 21:50:08', '2026-05-13 21:50:08'),
(1120, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4981.92, 4991.92, 'COD Refund AWB: 77789705976', '2026-05-13 21:55:12', '2026-05-13 21:55:12'),
(1121, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4991.92, 4982.92, 'RTO Charge AWB: 77789705976', '2026-05-13 21:55:12', '2026-05-13 21:55:12'),
(1122, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2496.08, -2476.08, 'COD Refund AWB: 77790205054', '2026-05-13 21:55:12', '2026-05-13 21:55:12'),
(1123, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2476.08, -2518.08, 'RTO Charge AWB: 77790205054', '2026-05-13 21:55:12', '2026-05-13 21:55:12'),
(1124, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4982.92, 4992.92, 'COD Refund AWB: 37355837634121', '2026-05-13 21:55:13', '2026-05-13 21:55:13'),
(1125, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4992.92, 4983.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 21:55:13', '2026-05-13 21:55:13'),
(1126, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4983.92, 4993.92, 'COD Refund AWB: 77789705976', '2026-05-13 22:00:09', '2026-05-13 22:00:09'),
(1127, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4993.92, 4984.92, 'RTO Charge AWB: 77789705976', '2026-05-13 22:00:09', '2026-05-13 22:00:09'),
(1128, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2518.08, -2498.08, 'COD Refund AWB: 77790205054', '2026-05-13 22:00:09', '2026-05-13 22:00:09'),
(1129, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2498.08, -2540.08, 'RTO Charge AWB: 77790205054', '2026-05-13 22:00:09', '2026-05-13 22:00:09'),
(1130, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4984.92, 4994.92, 'COD Refund AWB: 37355837634121', '2026-05-13 22:00:10', '2026-05-13 22:00:10'),
(1131, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4994.92, 4985.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 22:00:10', '2026-05-13 22:00:10'),
(1132, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4985.92, 4995.92, 'COD Refund AWB: 77789705976', '2026-05-13 22:05:11', '2026-05-13 22:05:11'),
(1133, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4995.92, 4986.92, 'RTO Charge AWB: 77789705976', '2026-05-13 22:05:11', '2026-05-13 22:05:11'),
(1134, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2540.08, -2520.08, 'COD Refund AWB: 77790205054', '2026-05-13 22:05:12', '2026-05-13 22:05:12'),
(1135, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2520.08, -2562.08, 'RTO Charge AWB: 77790205054', '2026-05-13 22:05:12', '2026-05-13 22:05:12'),
(1136, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4986.92, 4996.92, 'COD Refund AWB: 37355837634121', '2026-05-13 22:05:13', '2026-05-13 22:05:13'),
(1137, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4996.92, 4987.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 22:05:13', '2026-05-13 22:05:13'),
(1138, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4987.92, 4997.92, 'COD Refund AWB: 77789705976', '2026-05-13 22:10:12', '2026-05-13 22:10:12'),
(1139, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4997.92, 4988.92, 'RTO Charge AWB: 77789705976', '2026-05-13 22:10:12', '2026-05-13 22:10:12'),
(1140, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2562.08, -2542.08, 'COD Refund AWB: 77790205054', '2026-05-13 22:10:12', '2026-05-13 22:10:12'),
(1141, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2542.08, -2584.08, 'RTO Charge AWB: 77790205054', '2026-05-13 22:10:12', '2026-05-13 22:10:12'),
(1142, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4988.92, 4998.92, 'COD Refund AWB: 37355837634121', '2026-05-13 22:10:12', '2026-05-13 22:10:12'),
(1143, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4998.92, 4989.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 22:10:12', '2026-05-13 22:10:12'),
(1144, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4989.92, 4999.92, 'COD Refund AWB: 77789705976', '2026-05-13 22:15:07', '2026-05-13 22:15:07'),
(1145, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4999.92, 4990.92, 'RTO Charge AWB: 77789705976', '2026-05-13 22:15:07', '2026-05-13 22:15:07'),
(1146, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2584.08, -2564.08, 'COD Refund AWB: 77790205054', '2026-05-13 22:15:07', '2026-05-13 22:15:07'),
(1147, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2564.08, -2606.08, 'RTO Charge AWB: 77790205054', '2026-05-13 22:15:07', '2026-05-13 22:15:07'),
(1148, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4990.92, 5000.92, 'COD Refund AWB: 37355837634121', '2026-05-13 22:15:08', '2026-05-13 22:15:08'),
(1149, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5000.92, 4991.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 22:15:08', '2026-05-13 22:15:08'),
(1150, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4991.92, 5001.92, 'COD Refund AWB: 77789705976', '2026-05-13 22:20:11', '2026-05-13 22:20:11'),
(1151, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5001.92, 4992.92, 'RTO Charge AWB: 77789705976', '2026-05-13 22:20:11', '2026-05-13 22:20:11'),
(1152, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2606.08, -2586.08, 'COD Refund AWB: 77790205054', '2026-05-13 22:20:11', '2026-05-13 22:20:11'),
(1153, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2586.08, -2628.08, 'RTO Charge AWB: 77790205054', '2026-05-13 22:20:11', '2026-05-13 22:20:11'),
(1154, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4992.92, 5002.92, 'COD Refund AWB: 37355837634121', '2026-05-13 22:20:12', '2026-05-13 22:20:12'),
(1155, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5002.92, 4993.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 22:20:12', '2026-05-13 22:20:12'),
(1156, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4993.92, 5003.92, 'COD Refund AWB: 77789705976', '2026-05-13 22:25:05', '2026-05-13 22:25:05'),
(1157, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5003.92, 4994.92, 'RTO Charge AWB: 77789705976', '2026-05-13 22:25:05', '2026-05-13 22:25:05'),
(1158, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2628.08, -2608.08, 'COD Refund AWB: 77790205054', '2026-05-13 22:25:05', '2026-05-13 22:25:05'),
(1159, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2608.08, -2650.08, 'RTO Charge AWB: 77790205054', '2026-05-13 22:25:05', '2026-05-13 22:25:05'),
(1160, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4994.92, 5004.92, 'COD Refund AWB: 37355837634121', '2026-05-13 22:25:06', '2026-05-13 22:25:06'),
(1161, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5004.92, 4995.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 22:25:06', '2026-05-13 22:25:06'),
(1162, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4995.92, 5005.92, 'COD Refund AWB: 77789705976', '2026-05-13 22:30:10', '2026-05-13 22:30:10'),
(1163, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5005.92, 4996.92, 'RTO Charge AWB: 77789705976', '2026-05-13 22:30:10', '2026-05-13 22:30:10'),
(1164, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2650.08, -2630.08, 'COD Refund AWB: 77790205054', '2026-05-13 22:30:10', '2026-05-13 22:30:10'),
(1165, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2630.08, -2672.08, 'RTO Charge AWB: 77790205054', '2026-05-13 22:30:10', '2026-05-13 22:30:10'),
(1166, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4996.92, 5006.92, 'COD Refund AWB: 37355837634121', '2026-05-13 22:30:11', '2026-05-13 22:30:11'),
(1167, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5006.92, 4997.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 22:30:11', '2026-05-13 22:30:11'),
(1168, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4997.92, 5007.92, 'COD Refund AWB: 77789705976', '2026-05-13 22:35:05', '2026-05-13 22:35:05'),
(1169, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5007.92, 4998.92, 'RTO Charge AWB: 77789705976', '2026-05-13 22:35:05', '2026-05-13 22:35:05'),
(1170, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2672.08, -2652.08, 'COD Refund AWB: 77790205054', '2026-05-13 22:35:05', '2026-05-13 22:35:05'),
(1171, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2652.08, -2694.08, 'RTO Charge AWB: 77790205054', '2026-05-13 22:35:05', '2026-05-13 22:35:05'),
(1172, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4998.92, 5008.92, 'COD Refund AWB: 37355837634121', '2026-05-13 22:35:06', '2026-05-13 22:35:06'),
(1173, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5008.92, 4999.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 22:35:06', '2026-05-13 22:35:06'),
(1174, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4999.92, 5009.92, 'COD Refund AWB: 77789705976', '2026-05-13 22:40:12', '2026-05-13 22:40:12'),
(1175, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5009.92, 5000.92, 'RTO Charge AWB: 77789705976', '2026-05-13 22:40:12', '2026-05-13 22:40:12'),
(1176, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2694.08, -2674.08, 'COD Refund AWB: 77790205054', '2026-05-13 22:40:12', '2026-05-13 22:40:12'),
(1177, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2674.08, -2716.08, 'RTO Charge AWB: 77790205054', '2026-05-13 22:40:12', '2026-05-13 22:40:12'),
(1178, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5000.92, 5010.92, 'COD Refund AWB: 37355837634121', '2026-05-13 22:40:13', '2026-05-13 22:40:13'),
(1179, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5010.92, 5001.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 22:40:13', '2026-05-13 22:40:13'),
(1180, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5001.92, 5011.92, 'COD Refund AWB: 77789705976', '2026-05-13 22:45:06', '2026-05-13 22:45:06'),
(1181, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5011.92, 5002.92, 'RTO Charge AWB: 77789705976', '2026-05-13 22:45:06', '2026-05-13 22:45:06'),
(1182, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2716.08, -2696.08, 'COD Refund AWB: 77790205054', '2026-05-13 22:45:06', '2026-05-13 22:45:06'),
(1183, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2696.08, -2738.08, 'RTO Charge AWB: 77790205054', '2026-05-13 22:45:06', '2026-05-13 22:45:06'),
(1184, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5002.92, 5012.92, 'COD Refund AWB: 37355837634121', '2026-05-13 22:45:07', '2026-05-13 22:45:07'),
(1185, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5012.92, 5003.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 22:45:07', '2026-05-13 22:45:07'),
(1186, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5003.92, 5013.92, 'COD Refund AWB: 77789705976', '2026-05-13 22:50:12', '2026-05-13 22:50:12'),
(1187, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5013.92, 5004.92, 'RTO Charge AWB: 77789705976', '2026-05-13 22:50:12', '2026-05-13 22:50:12'),
(1188, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2738.08, -2718.08, 'COD Refund AWB: 77790205054', '2026-05-13 22:50:12', '2026-05-13 22:50:12'),
(1189, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2718.08, -2760.08, 'RTO Charge AWB: 77790205054', '2026-05-13 22:50:12', '2026-05-13 22:50:12'),
(1190, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5004.92, 5014.92, 'COD Refund AWB: 37355837634121', '2026-05-13 22:50:12', '2026-05-13 22:50:12'),
(1191, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5014.92, 5005.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 22:50:12', '2026-05-13 22:50:12'),
(1192, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5005.92, 5015.92, 'COD Refund AWB: 77789705976', '2026-05-13 22:55:05', '2026-05-13 22:55:05'),
(1193, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5015.92, 5006.92, 'RTO Charge AWB: 77789705976', '2026-05-13 22:55:05', '2026-05-13 22:55:05'),
(1194, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2760.08, -2740.08, 'COD Refund AWB: 77790205054', '2026-05-13 22:55:05', '2026-05-13 22:55:05'),
(1195, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2740.08, -2782.08, 'RTO Charge AWB: 77790205054', '2026-05-13 22:55:05', '2026-05-13 22:55:05'),
(1196, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5006.92, 5016.92, 'COD Refund AWB: 37355837634121', '2026-05-13 22:55:06', '2026-05-13 22:55:06'),
(1197, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5016.92, 5007.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 22:55:06', '2026-05-13 22:55:06'),
(1198, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5007.92, 5017.92, 'COD Refund AWB: 77789705976', '2026-05-13 23:00:19', '2026-05-13 23:00:19'),
(1199, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5017.92, 5008.92, 'RTO Charge AWB: 77789705976', '2026-05-13 23:00:19', '2026-05-13 23:00:19'),
(1200, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2782.08, -2762.08, 'COD Refund AWB: 77790205054', '2026-05-13 23:00:19', '2026-05-13 23:00:19'),
(1201, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2762.08, -2804.08, 'RTO Charge AWB: 77790205054', '2026-05-13 23:00:19', '2026-05-13 23:00:19'),
(1202, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5008.92, 5018.92, 'COD Refund AWB: 37355837634121', '2026-05-13 23:00:20', '2026-05-13 23:00:20'),
(1203, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5018.92, 5009.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 23:00:20', '2026-05-13 23:00:20'),
(1204, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5009.92, 5019.92, 'COD Refund AWB: 77789705976', '2026-05-13 23:05:07', '2026-05-13 23:05:07'),
(1205, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5019.92, 5010.92, 'RTO Charge AWB: 77789705976', '2026-05-13 23:05:07', '2026-05-13 23:05:07'),
(1206, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2804.08, -2784.08, 'COD Refund AWB: 77790205054', '2026-05-13 23:05:07', '2026-05-13 23:05:07'),
(1207, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2784.08, -2826.08, 'RTO Charge AWB: 77790205054', '2026-05-13 23:05:07', '2026-05-13 23:05:07'),
(1208, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5010.92, 5020.92, 'COD Refund AWB: 37355837634121', '2026-05-13 23:05:08', '2026-05-13 23:05:08'),
(1209, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5020.92, 5011.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 23:05:08', '2026-05-13 23:05:08'),
(1210, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5011.92, 5021.92, 'COD Refund AWB: 77789705976', '2026-05-13 23:10:13', '2026-05-13 23:10:13'),
(1211, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5021.92, 5012.92, 'RTO Charge AWB: 77789705976', '2026-05-13 23:10:13', '2026-05-13 23:10:13'),
(1212, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2826.08, -2806.08, 'COD Refund AWB: 77790205054', '2026-05-13 23:10:14', '2026-05-13 23:10:14'),
(1213, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2806.08, -2848.08, 'RTO Charge AWB: 77790205054', '2026-05-13 23:10:14', '2026-05-13 23:10:14'),
(1214, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5012.92, 5022.92, 'COD Refund AWB: 37355837634121', '2026-05-13 23:10:14', '2026-05-13 23:10:14'),
(1215, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5022.92, 5013.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 23:10:14', '2026-05-13 23:10:14'),
(1216, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5013.92, 5023.92, 'COD Refund AWB: 77789705976', '2026-05-13 23:15:06', '2026-05-13 23:15:06'),
(1217, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5023.92, 5014.92, 'RTO Charge AWB: 77789705976', '2026-05-13 23:15:06', '2026-05-13 23:15:06'),
(1218, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2848.08, -2828.08, 'COD Refund AWB: 77790205054', '2026-05-13 23:15:06', '2026-05-13 23:15:06'),
(1219, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2828.08, -2870.08, 'RTO Charge AWB: 77790205054', '2026-05-13 23:15:06', '2026-05-13 23:15:06'),
(1220, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5014.92, 5024.92, 'COD Refund AWB: 37355837634121', '2026-05-13 23:15:06', '2026-05-13 23:15:06'),
(1221, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5024.92, 5015.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 23:15:06', '2026-05-13 23:15:06'),
(1222, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5015.92, 5025.92, 'COD Refund AWB: 77789705976', '2026-05-13 23:20:12', '2026-05-13 23:20:12'),
(1223, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5025.92, 5016.92, 'RTO Charge AWB: 77789705976', '2026-05-13 23:20:12', '2026-05-13 23:20:12'),
(1224, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2870.08, -2850.08, 'COD Refund AWB: 77790205054', '2026-05-13 23:20:12', '2026-05-13 23:20:12'),
(1225, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2850.08, -2892.08, 'RTO Charge AWB: 77790205054', '2026-05-13 23:20:12', '2026-05-13 23:20:12'),
(1226, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5016.92, 5026.92, 'COD Refund AWB: 37355837634121', '2026-05-13 23:20:12', '2026-05-13 23:20:12'),
(1227, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5026.92, 5017.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 23:20:12', '2026-05-13 23:20:12'),
(1228, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5017.92, 5027.92, 'COD Refund AWB: 77789705976', '2026-05-13 23:25:07', '2026-05-13 23:25:07'),
(1229, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5027.92, 5018.92, 'RTO Charge AWB: 77789705976', '2026-05-13 23:25:07', '2026-05-13 23:25:07'),
(1230, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2892.08, -2872.08, 'COD Refund AWB: 77790205054', '2026-05-13 23:25:07', '2026-05-13 23:25:07'),
(1231, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2872.08, -2914.08, 'RTO Charge AWB: 77790205054', '2026-05-13 23:25:07', '2026-05-13 23:25:07'),
(1232, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5018.92, 5028.92, 'COD Refund AWB: 37355837634121', '2026-05-13 23:25:08', '2026-05-13 23:25:08'),
(1233, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5028.92, 5019.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 23:25:08', '2026-05-13 23:25:08'),
(1234, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5019.92, 5029.92, 'COD Refund AWB: 77789705976', '2026-05-13 23:30:16', '2026-05-13 23:30:16'),
(1235, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5029.92, 5020.92, 'RTO Charge AWB: 77789705976', '2026-05-13 23:30:16', '2026-05-13 23:30:16'),
(1236, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2914.08, -2894.08, 'COD Refund AWB: 77790205054', '2026-05-13 23:30:16', '2026-05-13 23:30:16'),
(1237, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2894.08, -2936.08, 'RTO Charge AWB: 77790205054', '2026-05-13 23:30:16', '2026-05-13 23:30:16'),
(1238, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5020.92, 5030.92, 'COD Refund AWB: 37355837634121', '2026-05-13 23:30:16', '2026-05-13 23:30:16'),
(1239, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5030.92, 5021.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 23:30:16', '2026-05-13 23:30:16'),
(1240, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5021.92, 5031.92, 'COD Refund AWB: 77789705976', '2026-05-13 23:35:06', '2026-05-13 23:35:06'),
(1241, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5031.92, 5022.92, 'RTO Charge AWB: 77789705976', '2026-05-13 23:35:06', '2026-05-13 23:35:06'),
(1242, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2936.08, -2916.08, 'COD Refund AWB: 77790205054', '2026-05-13 23:35:06', '2026-05-13 23:35:06'),
(1243, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2916.08, -2958.08, 'RTO Charge AWB: 77790205054', '2026-05-13 23:35:06', '2026-05-13 23:35:06'),
(1244, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5022.92, 5032.92, 'COD Refund AWB: 37355837634121', '2026-05-13 23:35:06', '2026-05-13 23:35:06'),
(1245, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5032.92, 5023.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 23:35:06', '2026-05-13 23:35:06'),
(1246, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5023.92, 5033.92, 'COD Refund AWB: 77789705976', '2026-05-13 23:40:12', '2026-05-13 23:40:12'),
(1247, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5033.92, 5024.92, 'RTO Charge AWB: 77789705976', '2026-05-13 23:40:12', '2026-05-13 23:40:12'),
(1248, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2958.08, -2938.08, 'COD Refund AWB: 77790205054', '2026-05-13 23:40:12', '2026-05-13 23:40:12'),
(1249, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2938.08, -2980.08, 'RTO Charge AWB: 77790205054', '2026-05-13 23:40:12', '2026-05-13 23:40:12'),
(1250, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5024.92, 5034.92, 'COD Refund AWB: 37355837634121', '2026-05-13 23:40:12', '2026-05-13 23:40:12'),
(1251, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5034.92, 5025.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 23:40:12', '2026-05-13 23:40:12'),
(1252, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5025.92, 5035.92, 'COD Refund AWB: 77789705976', '2026-05-13 23:45:06', '2026-05-13 23:45:06'),
(1253, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5035.92, 5026.92, 'RTO Charge AWB: 77789705976', '2026-05-13 23:45:06', '2026-05-13 23:45:06'),
(1254, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -2980.08, -2960.08, 'COD Refund AWB: 77790205054', '2026-05-13 23:45:06', '2026-05-13 23:45:06'),
(1255, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2960.08, -3002.08, 'RTO Charge AWB: 77790205054', '2026-05-13 23:45:06', '2026-05-13 23:45:06'),
(1256, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5026.92, 5036.92, 'COD Refund AWB: 37355837634121', '2026-05-13 23:45:06', '2026-05-13 23:45:06'),
(1257, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5036.92, 5027.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 23:45:06', '2026-05-13 23:45:06'),
(1258, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5027.92, 5037.92, 'COD Refund AWB: 77789705976', '2026-05-13 23:50:10', '2026-05-13 23:50:10'),
(1259, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5037.92, 5028.92, 'RTO Charge AWB: 77789705976', '2026-05-13 23:50:10', '2026-05-13 23:50:10'),
(1260, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3002.08, -2982.08, 'COD Refund AWB: 77790205054', '2026-05-13 23:50:10', '2026-05-13 23:50:10'),
(1261, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -2982.08, -3024.08, 'RTO Charge AWB: 77790205054', '2026-05-13 23:50:10', '2026-05-13 23:50:10'),
(1262, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5028.92, 5038.92, 'COD Refund AWB: 37355837634121', '2026-05-13 23:50:11', '2026-05-13 23:50:11'),
(1263, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5038.92, 5029.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 23:50:11', '2026-05-13 23:50:11'),
(1264, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5029.92, 5039.92, 'COD Refund AWB: 77789705976', '2026-05-13 23:55:06', '2026-05-13 23:55:06'),
(1265, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5039.92, 5030.92, 'RTO Charge AWB: 77789705976', '2026-05-13 23:55:06', '2026-05-13 23:55:06'),
(1266, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3024.08, -3004.08, 'COD Refund AWB: 77790205054', '2026-05-13 23:55:06', '2026-05-13 23:55:06'),
(1267, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3004.08, -3046.08, 'RTO Charge AWB: 77790205054', '2026-05-13 23:55:06', '2026-05-13 23:55:06'),
(1268, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5030.92, 5040.92, 'COD Refund AWB: 37355837634121', '2026-05-13 23:55:06', '2026-05-13 23:55:06'),
(1269, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5040.92, 5031.92, 'RTO Charge AWB: 37355837634121', '2026-05-13 23:55:06', '2026-05-13 23:55:06'),
(1270, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5031.92, 5041.92, 'COD Refund AWB: 77789705976', '2026-05-14 00:00:18', '2026-05-14 00:00:18'),
(1271, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5041.92, 5032.92, 'RTO Charge AWB: 77789705976', '2026-05-14 00:00:18', '2026-05-14 00:00:18'),
(1272, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3046.08, -3026.08, 'COD Refund AWB: 77790205054', '2026-05-14 00:00:18', '2026-05-14 00:00:18'),
(1273, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3026.08, -3068.08, 'RTO Charge AWB: 77790205054', '2026-05-14 00:00:18', '2026-05-14 00:00:18'),
(1274, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5032.92, 5042.92, 'COD Refund AWB: 37355837634121', '2026-05-14 00:00:18', '2026-05-14 00:00:18'),
(1275, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5042.92, 5033.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 00:00:18', '2026-05-14 00:00:18'),
(1276, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5033.92, 5043.92, 'COD Refund AWB: 77789705976', '2026-05-14 00:05:05', '2026-05-14 00:05:05'),
(1277, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5043.92, 5034.92, 'RTO Charge AWB: 77789705976', '2026-05-14 00:05:05', '2026-05-14 00:05:05'),
(1278, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3068.08, -3048.08, 'COD Refund AWB: 77790205054', '2026-05-14 00:05:05', '2026-05-14 00:05:05'),
(1279, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3048.08, -3090.08, 'RTO Charge AWB: 77790205054', '2026-05-14 00:05:05', '2026-05-14 00:05:05'),
(1280, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5034.92, 5044.92, 'COD Refund AWB: 37355837634121', '2026-05-14 00:05:06', '2026-05-14 00:05:06'),
(1281, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5044.92, 5035.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 00:05:06', '2026-05-14 00:05:06'),
(1282, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5035.92, 5045.92, 'COD Refund AWB: 77789705976', '2026-05-14 00:10:11', '2026-05-14 00:10:11'),
(1283, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5045.92, 5036.92, 'RTO Charge AWB: 77789705976', '2026-05-14 00:10:11', '2026-05-14 00:10:11'),
(1284, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3090.08, -3070.08, 'COD Refund AWB: 77790205054', '2026-05-14 00:10:11', '2026-05-14 00:10:11'),
(1285, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3070.08, -3112.08, 'RTO Charge AWB: 77790205054', '2026-05-14 00:10:11', '2026-05-14 00:10:11'),
(1286, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5036.92, 5046.92, 'COD Refund AWB: 37355837634121', '2026-05-14 00:10:11', '2026-05-14 00:10:11'),
(1287, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5046.92, 5037.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 00:10:11', '2026-05-14 00:10:11'),
(1288, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5037.92, 5047.92, 'COD Refund AWB: 77789705976', '2026-05-14 00:15:06', '2026-05-14 00:15:06'),
(1289, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5047.92, 5038.92, 'RTO Charge AWB: 77789705976', '2026-05-14 00:15:06', '2026-05-14 00:15:06'),
(1290, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3112.08, -3092.08, 'COD Refund AWB: 77790205054', '2026-05-14 00:15:06', '2026-05-14 00:15:06'),
(1291, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3092.08, -3134.08, 'RTO Charge AWB: 77790205054', '2026-05-14 00:15:06', '2026-05-14 00:15:06'),
(1292, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5038.92, 5048.92, 'COD Refund AWB: 37355837634121', '2026-05-14 00:15:06', '2026-05-14 00:15:06'),
(1293, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5048.92, 5039.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 00:15:06', '2026-05-14 00:15:06'),
(1294, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5039.92, 5049.92, 'COD Refund AWB: 77789705976', '2026-05-14 00:20:11', '2026-05-14 00:20:11'),
(1295, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5049.92, 5040.92, 'RTO Charge AWB: 77789705976', '2026-05-14 00:20:11', '2026-05-14 00:20:11'),
(1296, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3134.08, -3114.08, 'COD Refund AWB: 77790205054', '2026-05-14 00:20:11', '2026-05-14 00:20:11'),
(1297, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3114.08, -3156.08, 'RTO Charge AWB: 77790205054', '2026-05-14 00:20:11', '2026-05-14 00:20:11'),
(1298, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5040.92, 5050.92, 'COD Refund AWB: 37355837634121', '2026-05-14 00:20:12', '2026-05-14 00:20:12'),
(1299, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5050.92, 5041.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 00:20:12', '2026-05-14 00:20:12'),
(1300, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5041.92, 5051.92, 'COD Refund AWB: 77789705976', '2026-05-14 00:25:05', '2026-05-14 00:25:05'),
(1301, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5051.92, 5042.92, 'RTO Charge AWB: 77789705976', '2026-05-14 00:25:05', '2026-05-14 00:25:05'),
(1302, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3156.08, -3136.08, 'COD Refund AWB: 77790205054', '2026-05-14 00:25:05', '2026-05-14 00:25:05'),
(1303, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3136.08, -3178.08, 'RTO Charge AWB: 77790205054', '2026-05-14 00:25:05', '2026-05-14 00:25:05'),
(1304, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5042.92, 5052.92, 'COD Refund AWB: 37355837634121', '2026-05-14 00:25:06', '2026-05-14 00:25:06'),
(1305, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5052.92, 5043.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 00:25:06', '2026-05-14 00:25:06'),
(1306, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5043.92, 5053.92, 'COD Refund AWB: 77789705976', '2026-05-14 00:30:15', '2026-05-14 00:30:15'),
(1307, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5053.92, 5044.92, 'RTO Charge AWB: 77789705976', '2026-05-14 00:30:15', '2026-05-14 00:30:15'),
(1308, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3178.08, -3158.08, 'COD Refund AWB: 77790205054', '2026-05-14 00:30:15', '2026-05-14 00:30:15'),
(1309, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3158.08, -3200.08, 'RTO Charge AWB: 77790205054', '2026-05-14 00:30:15', '2026-05-14 00:30:15'),
(1310, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5044.92, 5054.92, 'COD Refund AWB: 37355837634121', '2026-05-14 00:30:16', '2026-05-14 00:30:16'),
(1311, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5054.92, 5045.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 00:30:16', '2026-05-14 00:30:16'),
(1312, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5045.92, 5055.92, 'COD Refund AWB: 77789705976', '2026-05-14 00:35:06', '2026-05-14 00:35:06'),
(1313, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5055.92, 5046.92, 'RTO Charge AWB: 77789705976', '2026-05-14 00:35:06', '2026-05-14 00:35:06'),
(1314, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3200.08, -3180.08, 'COD Refund AWB: 77790205054', '2026-05-14 00:35:06', '2026-05-14 00:35:06'),
(1315, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3180.08, -3222.08, 'RTO Charge AWB: 77790205054', '2026-05-14 00:35:06', '2026-05-14 00:35:06'),
(1316, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5046.92, 5056.92, 'COD Refund AWB: 37355837634121', '2026-05-14 00:35:07', '2026-05-14 00:35:07'),
(1317, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5056.92, 5047.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 00:35:07', '2026-05-14 00:35:07'),
(1318, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5047.92, 5057.92, 'COD Refund AWB: 77789705976', '2026-05-14 00:40:11', '2026-05-14 00:40:11'),
(1319, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5057.92, 5048.92, 'RTO Charge AWB: 77789705976', '2026-05-14 00:40:11', '2026-05-14 00:40:11'),
(1320, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3222.08, -3202.08, 'COD Refund AWB: 77790205054', '2026-05-14 00:40:11', '2026-05-14 00:40:11'),
(1321, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3202.08, -3244.08, 'RTO Charge AWB: 77790205054', '2026-05-14 00:40:11', '2026-05-14 00:40:11'),
(1322, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5048.92, 5058.92, 'COD Refund AWB: 37355837634121', '2026-05-14 00:40:12', '2026-05-14 00:40:12'),
(1323, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5058.92, 5049.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 00:40:12', '2026-05-14 00:40:12'),
(1324, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5049.92, 5059.92, 'COD Refund AWB: 77789705976', '2026-05-14 00:45:05', '2026-05-14 00:45:05'),
(1325, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5059.92, 5050.92, 'RTO Charge AWB: 77789705976', '2026-05-14 00:45:05', '2026-05-14 00:45:05'),
(1326, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3244.08, -3224.08, 'COD Refund AWB: 77790205054', '2026-05-14 00:45:06', '2026-05-14 00:45:06'),
(1327, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3224.08, -3266.08, 'RTO Charge AWB: 77790205054', '2026-05-14 00:45:06', '2026-05-14 00:45:06'),
(1328, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5050.92, 5060.92, 'COD Refund AWB: 37355837634121', '2026-05-14 00:45:06', '2026-05-14 00:45:06'),
(1329, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5060.92, 5051.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 00:45:06', '2026-05-14 00:45:06'),
(1330, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5051.92, 5061.92, 'COD Refund AWB: 77789705976', '2026-05-14 00:50:12', '2026-05-14 00:50:12'),
(1331, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5061.92, 5052.92, 'RTO Charge AWB: 77789705976', '2026-05-14 00:50:12', '2026-05-14 00:50:12'),
(1332, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3266.08, -3246.08, 'COD Refund AWB: 77790205054', '2026-05-14 00:50:12', '2026-05-14 00:50:12'),
(1333, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3246.08, -3288.08, 'RTO Charge AWB: 77790205054', '2026-05-14 00:50:12', '2026-05-14 00:50:12'),
(1334, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5052.92, 5062.92, 'COD Refund AWB: 37355837634121', '2026-05-14 00:50:12', '2026-05-14 00:50:12'),
(1335, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5062.92, 5053.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 00:50:12', '2026-05-14 00:50:12'),
(1336, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5053.92, 5063.92, 'COD Refund AWB: 77789705976', '2026-05-14 00:55:06', '2026-05-14 00:55:06'),
(1337, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5063.92, 5054.92, 'RTO Charge AWB: 77789705976', '2026-05-14 00:55:06', '2026-05-14 00:55:06'),
(1338, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3288.08, -3268.08, 'COD Refund AWB: 77790205054', '2026-05-14 00:55:06', '2026-05-14 00:55:06'),
(1339, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3268.08, -3310.08, 'RTO Charge AWB: 77790205054', '2026-05-14 00:55:06', '2026-05-14 00:55:06'),
(1340, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5054.92, 5064.92, 'COD Refund AWB: 37355837634121', '2026-05-14 00:55:07', '2026-05-14 00:55:07'),
(1341, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5064.92, 5055.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 00:55:07', '2026-05-14 00:55:07'),
(1342, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5055.92, 5065.92, 'COD Refund AWB: 77789705976', '2026-05-14 01:00:19', '2026-05-14 01:00:19'),
(1343, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5065.92, 5056.92, 'RTO Charge AWB: 77789705976', '2026-05-14 01:00:19', '2026-05-14 01:00:19'),
(1344, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3310.08, -3290.08, 'COD Refund AWB: 77790205054', '2026-05-14 01:00:19', '2026-05-14 01:00:19'),
(1345, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3290.08, -3332.08, 'RTO Charge AWB: 77790205054', '2026-05-14 01:00:19', '2026-05-14 01:00:19'),
(1346, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5056.92, 5066.92, 'COD Refund AWB: 37355837634121', '2026-05-14 01:00:20', '2026-05-14 01:00:20'),
(1347, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5066.92, 5057.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 01:00:20', '2026-05-14 01:00:20'),
(1348, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5057.92, 5067.92, 'COD Refund AWB: 77789705976', '2026-05-14 01:05:06', '2026-05-14 01:05:06'),
(1349, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5067.92, 5058.92, 'RTO Charge AWB: 77789705976', '2026-05-14 01:05:06', '2026-05-14 01:05:06'),
(1350, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3332.08, -3312.08, 'COD Refund AWB: 77790205054', '2026-05-14 01:05:06', '2026-05-14 01:05:06'),
(1351, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3312.08, -3354.08, 'RTO Charge AWB: 77790205054', '2026-05-14 01:05:06', '2026-05-14 01:05:06'),
(1352, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5058.92, 5068.92, 'COD Refund AWB: 37355837634121', '2026-05-14 01:05:07', '2026-05-14 01:05:07'),
(1353, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5068.92, 5059.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 01:05:07', '2026-05-14 01:05:07'),
(1354, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5059.92, 5069.92, 'COD Refund AWB: 77789705976', '2026-05-14 01:10:11', '2026-05-14 01:10:11'),
(1355, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5069.92, 5060.92, 'RTO Charge AWB: 77789705976', '2026-05-14 01:10:11', '2026-05-14 01:10:11'),
(1356, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3354.08, -3334.08, 'COD Refund AWB: 77790205054', '2026-05-14 01:10:11', '2026-05-14 01:10:11'),
(1357, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3334.08, -3376.08, 'RTO Charge AWB: 77790205054', '2026-05-14 01:10:11', '2026-05-14 01:10:11'),
(1358, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5060.92, 5070.92, 'COD Refund AWB: 37355837634121', '2026-05-14 01:10:12', '2026-05-14 01:10:12'),
(1359, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5070.92, 5061.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 01:10:12', '2026-05-14 01:10:12'),
(1360, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5061.92, 5071.92, 'COD Refund AWB: 77789705976', '2026-05-14 01:15:06', '2026-05-14 01:15:06'),
(1361, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5071.92, 5062.92, 'RTO Charge AWB: 77789705976', '2026-05-14 01:15:06', '2026-05-14 01:15:06'),
(1362, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3376.08, -3356.08, 'COD Refund AWB: 77790205054', '2026-05-14 01:15:06', '2026-05-14 01:15:06'),
(1363, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3356.08, -3398.08, 'RTO Charge AWB: 77790205054', '2026-05-14 01:15:06', '2026-05-14 01:15:06'),
(1364, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5062.92, 5072.92, 'COD Refund AWB: 37355837634121', '2026-05-14 01:15:06', '2026-05-14 01:15:06'),
(1365, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5072.92, 5063.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 01:15:06', '2026-05-14 01:15:06'),
(1366, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5063.92, 5073.92, 'COD Refund AWB: 77789705976', '2026-05-14 01:20:11', '2026-05-14 01:20:11'),
(1367, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5073.92, 5064.92, 'RTO Charge AWB: 77789705976', '2026-05-14 01:20:11', '2026-05-14 01:20:11'),
(1368, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3398.08, -3378.08, 'COD Refund AWB: 77790205054', '2026-05-14 01:20:11', '2026-05-14 01:20:11'),
(1369, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3378.08, -3420.08, 'RTO Charge AWB: 77790205054', '2026-05-14 01:20:11', '2026-05-14 01:20:11'),
(1370, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5064.92, 5074.92, 'COD Refund AWB: 37355837634121', '2026-05-14 01:20:12', '2026-05-14 01:20:12'),
(1371, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5074.92, 5065.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 01:20:12', '2026-05-14 01:20:12'),
(1372, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5065.92, 5075.92, 'COD Refund AWB: 77789705976', '2026-05-14 01:25:07', '2026-05-14 01:25:07'),
(1373, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5075.92, 5066.92, 'RTO Charge AWB: 77789705976', '2026-05-14 01:25:07', '2026-05-14 01:25:07'),
(1374, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3420.08, -3400.08, 'COD Refund AWB: 77790205054', '2026-05-14 01:25:07', '2026-05-14 01:25:07'),
(1375, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3400.08, -3442.08, 'RTO Charge AWB: 77790205054', '2026-05-14 01:25:07', '2026-05-14 01:25:07'),
(1376, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5066.92, 5076.92, 'COD Refund AWB: 37355837634121', '2026-05-14 01:25:07', '2026-05-14 01:25:07'),
(1377, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5076.92, 5067.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 01:25:07', '2026-05-14 01:25:07'),
(1378, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5067.92, 5077.92, 'COD Refund AWB: 77789705976', '2026-05-14 01:30:12', '2026-05-14 01:30:12'),
(1379, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5077.92, 5068.92, 'RTO Charge AWB: 77789705976', '2026-05-14 01:30:12', '2026-05-14 01:30:12'),
(1380, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3442.08, -3422.08, 'COD Refund AWB: 77790205054', '2026-05-14 01:30:12', '2026-05-14 01:30:12'),
(1381, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3422.08, -3464.08, 'RTO Charge AWB: 77790205054', '2026-05-14 01:30:12', '2026-05-14 01:30:12'),
(1382, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5068.92, 5078.92, 'COD Refund AWB: 37355837634121', '2026-05-14 01:30:13', '2026-05-14 01:30:13'),
(1383, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5078.92, 5069.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 01:30:13', '2026-05-14 01:30:13'),
(1384, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5069.92, 5079.92, 'COD Refund AWB: 77789705976', '2026-05-14 01:35:07', '2026-05-14 01:35:07'),
(1385, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5079.92, 5070.92, 'RTO Charge AWB: 77789705976', '2026-05-14 01:35:07', '2026-05-14 01:35:07'),
(1386, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3464.08, -3444.08, 'COD Refund AWB: 77790205054', '2026-05-14 01:35:08', '2026-05-14 01:35:08'),
(1387, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3444.08, -3486.08, 'RTO Charge AWB: 77790205054', '2026-05-14 01:35:08', '2026-05-14 01:35:08'),
(1388, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5070.92, 5080.92, 'COD Refund AWB: 37355837634121', '2026-05-14 01:35:08', '2026-05-14 01:35:08'),
(1389, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5080.92, 5071.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 01:35:08', '2026-05-14 01:35:08'),
(1390, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5071.92, 5081.92, 'COD Refund AWB: 77789705976', '2026-05-14 01:40:12', '2026-05-14 01:40:12'),
(1391, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5081.92, 5072.92, 'RTO Charge AWB: 77789705976', '2026-05-14 01:40:12', '2026-05-14 01:40:12'),
(1392, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3486.08, -3466.08, 'COD Refund AWB: 77790205054', '2026-05-14 01:40:12', '2026-05-14 01:40:12'),
(1393, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3466.08, -3508.08, 'RTO Charge AWB: 77790205054', '2026-05-14 01:40:12', '2026-05-14 01:40:12'),
(1394, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5072.92, 5082.92, 'COD Refund AWB: 37355837634121', '2026-05-14 01:40:13', '2026-05-14 01:40:13'),
(1395, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5082.92, 5073.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 01:40:13', '2026-05-14 01:40:13'),
(1396, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5073.92, 5083.92, 'COD Refund AWB: 77789705976', '2026-05-14 01:45:07', '2026-05-14 01:45:07'),
(1397, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5083.92, 5074.92, 'RTO Charge AWB: 77789705976', '2026-05-14 01:45:07', '2026-05-14 01:45:07'),
(1398, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3508.08, -3488.08, 'COD Refund AWB: 77790205054', '2026-05-14 01:45:07', '2026-05-14 01:45:07'),
(1399, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3488.08, -3530.08, 'RTO Charge AWB: 77790205054', '2026-05-14 01:45:07', '2026-05-14 01:45:07'),
(1400, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5074.92, 5084.92, 'COD Refund AWB: 37355837634121', '2026-05-14 01:45:07', '2026-05-14 01:45:07'),
(1401, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5084.92, 5075.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 01:45:07', '2026-05-14 01:45:07'),
(1402, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5075.92, 5085.92, 'COD Refund AWB: 77789705976', '2026-05-14 01:50:14', '2026-05-14 01:50:14'),
(1403, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5085.92, 5076.92, 'RTO Charge AWB: 77789705976', '2026-05-14 01:50:14', '2026-05-14 01:50:14'),
(1404, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3530.08, -3510.08, 'COD Refund AWB: 77790205054', '2026-05-14 01:50:14', '2026-05-14 01:50:14'),
(1405, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3510.08, -3552.08, 'RTO Charge AWB: 77790205054', '2026-05-14 01:50:14', '2026-05-14 01:50:14'),
(1406, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5076.92, 5086.92, 'COD Refund AWB: 37355837634121', '2026-05-14 01:50:15', '2026-05-14 01:50:15'),
(1407, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5086.92, 5077.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 01:50:15', '2026-05-14 01:50:15'),
(1408, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5077.92, 5087.92, 'COD Refund AWB: 77789705976', '2026-05-14 01:55:07', '2026-05-14 01:55:07'),
(1409, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5087.92, 5078.92, 'RTO Charge AWB: 77789705976', '2026-05-14 01:55:07', '2026-05-14 01:55:07'),
(1410, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3552.08, -3532.08, 'COD Refund AWB: 77790205054', '2026-05-14 01:55:07', '2026-05-14 01:55:07'),
(1411, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3532.08, -3574.08, 'RTO Charge AWB: 77790205054', '2026-05-14 01:55:07', '2026-05-14 01:55:07'),
(1412, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5078.92, 5088.92, 'COD Refund AWB: 37355837634121', '2026-05-14 01:55:08', '2026-05-14 01:55:08'),
(1413, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5088.92, 5079.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 01:55:08', '2026-05-14 01:55:08'),
(1414, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5079.92, 5089.92, 'COD Refund AWB: 77789705976', '2026-05-14 02:00:19', '2026-05-14 02:00:19'),
(1415, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5089.92, 5080.92, 'RTO Charge AWB: 77789705976', '2026-05-14 02:00:19', '2026-05-14 02:00:19'),
(1416, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3574.08, -3554.08, 'COD Refund AWB: 77790205054', '2026-05-14 02:00:20', '2026-05-14 02:00:20'),
(1417, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3554.08, -3596.08, 'RTO Charge AWB: 77790205054', '2026-05-14 02:00:20', '2026-05-14 02:00:20'),
(1418, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5080.92, 5090.92, 'COD Refund AWB: 37355837634121', '2026-05-14 02:00:20', '2026-05-14 02:00:20'),
(1419, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5090.92, 5081.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 02:00:20', '2026-05-14 02:00:20'),
(1420, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5081.92, 5091.92, 'COD Refund AWB: 77789705976', '2026-05-14 02:05:06', '2026-05-14 02:05:06'),
(1421, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5091.92, 5082.92, 'RTO Charge AWB: 77789705976', '2026-05-14 02:05:06', '2026-05-14 02:05:06'),
(1422, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3596.08, -3576.08, 'COD Refund AWB: 77790205054', '2026-05-14 02:05:06', '2026-05-14 02:05:06'),
(1423, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3576.08, -3618.08, 'RTO Charge AWB: 77790205054', '2026-05-14 02:05:06', '2026-05-14 02:05:06'),
(1424, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5082.92, 5092.92, 'COD Refund AWB: 37355837634121', '2026-05-14 02:05:07', '2026-05-14 02:05:07'),
(1425, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5092.92, 5083.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 02:05:07', '2026-05-14 02:05:07'),
(1426, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5083.92, 5093.92, 'COD Refund AWB: 77789705976', '2026-05-14 02:10:13', '2026-05-14 02:10:13');
INSERT INTO `wallet_transactions` (`id`, `user_id`, `fship_order_id`, `amount`, `type`, `charge_type`, `source`, `opening_balance`, `closing_balance`, `remark`, `created_at`, `updated_at`) VALUES
(1427, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5093.92, 5084.92, 'RTO Charge AWB: 77789705976', '2026-05-14 02:10:13', '2026-05-14 02:10:13'),
(1428, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3618.08, -3598.08, 'COD Refund AWB: 77790205054', '2026-05-14 02:10:13', '2026-05-14 02:10:13'),
(1429, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3598.08, -3640.08, 'RTO Charge AWB: 77790205054', '2026-05-14 02:10:13', '2026-05-14 02:10:13'),
(1430, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5084.92, 5094.92, 'COD Refund AWB: 37355837634121', '2026-05-14 02:10:14', '2026-05-14 02:10:14'),
(1431, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5094.92, 5085.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 02:10:14', '2026-05-14 02:10:14'),
(1432, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5085.92, 5095.92, 'COD Refund AWB: 77789705976', '2026-05-14 02:15:06', '2026-05-14 02:15:06'),
(1433, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5095.92, 5086.92, 'RTO Charge AWB: 77789705976', '2026-05-14 02:15:06', '2026-05-14 02:15:06'),
(1434, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3640.08, -3620.08, 'COD Refund AWB: 77790205054', '2026-05-14 02:15:07', '2026-05-14 02:15:07'),
(1435, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3620.08, -3662.08, 'RTO Charge AWB: 77790205054', '2026-05-14 02:15:07', '2026-05-14 02:15:07'),
(1436, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5086.92, 5096.92, 'COD Refund AWB: 37355837634121', '2026-05-14 02:15:07', '2026-05-14 02:15:07'),
(1437, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5096.92, 5087.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 02:15:07', '2026-05-14 02:15:07'),
(1438, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5087.92, 5097.92, 'COD Refund AWB: 77789705976', '2026-05-14 02:20:12', '2026-05-14 02:20:12'),
(1439, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5097.92, 5088.92, 'RTO Charge AWB: 77789705976', '2026-05-14 02:20:12', '2026-05-14 02:20:12'),
(1440, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', -3662.08, -3642.08, 'COD Refund AWB: 77790205054', '2026-05-14 02:20:12', '2026-05-14 02:20:12'),
(1441, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', -3642.08, -3684.08, 'RTO Charge AWB: 77790205054', '2026-05-14 02:20:12', '2026-05-14 02:20:12'),
(1442, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5088.92, 5098.92, 'COD Refund AWB: 37355837634121', '2026-05-14 02:20:13', '2026-05-14 02:20:13'),
(1443, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5098.92, 5089.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 02:20:13', '2026-05-14 02:20:13'),
(1444, 39, NULL, 5000.00, 'credit', 'recharge', 'admin_manual', -3684.08, 1315.92, 'Admin credit: ₹5000 via admin_manual', '2026-05-14 02:21:06', '2026-05-14 02:21:06'),
(1445, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5089.92, 5099.92, 'COD Refund AWB: 77789705976', '2026-05-14 02:25:07', '2026-05-14 02:25:07'),
(1446, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5099.92, 5090.92, 'RTO Charge AWB: 77789705976', '2026-05-14 02:25:07', '2026-05-14 02:25:07'),
(1447, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1315.92, 1335.92, 'COD Refund AWB: 77790205054', '2026-05-14 02:25:07', '2026-05-14 02:25:07'),
(1448, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1335.92, 1293.92, 'RTO Charge AWB: 77790205054', '2026-05-14 02:25:07', '2026-05-14 02:25:07'),
(1449, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5090.92, 5100.92, 'COD Refund AWB: 37355837634121', '2026-05-14 02:25:07', '2026-05-14 02:25:07'),
(1450, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5100.92, 5091.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 02:25:07', '2026-05-14 02:25:07'),
(1451, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5091.92, 5101.92, 'COD Refund AWB: 77789705976', '2026-05-14 02:30:15', '2026-05-14 02:30:15'),
(1452, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5101.92, 5092.92, 'RTO Charge AWB: 77789705976', '2026-05-14 02:30:15', '2026-05-14 02:30:15'),
(1453, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1293.92, 1313.92, 'COD Refund AWB: 77790205054', '2026-05-14 02:30:15', '2026-05-14 02:30:15'),
(1454, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1313.92, 1271.92, 'RTO Charge AWB: 77790205054', '2026-05-14 02:30:15', '2026-05-14 02:30:15'),
(1455, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5092.92, 5102.92, 'COD Refund AWB: 37355837634121', '2026-05-14 02:30:17', '2026-05-14 02:30:17'),
(1456, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5102.92, 5093.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 02:30:17', '2026-05-14 02:30:17'),
(1457, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5093.92, 5103.92, 'COD Refund AWB: 77789705976', '2026-05-14 02:35:06', '2026-05-14 02:35:06'),
(1458, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5103.92, 5094.92, 'RTO Charge AWB: 77789705976', '2026-05-14 02:35:06', '2026-05-14 02:35:06'),
(1459, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1271.92, 1291.92, 'COD Refund AWB: 77790205054', '2026-05-14 02:35:06', '2026-05-14 02:35:06'),
(1460, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1291.92, 1249.92, 'RTO Charge AWB: 77790205054', '2026-05-14 02:35:06', '2026-05-14 02:35:06'),
(1461, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5094.92, 5104.92, 'COD Refund AWB: 37355837634121', '2026-05-14 02:35:07', '2026-05-14 02:35:07'),
(1462, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5104.92, 5095.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 02:35:07', '2026-05-14 02:35:07'),
(1463, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5095.92, 5105.92, 'COD Refund AWB: 77789705976', '2026-05-14 02:40:13', '2026-05-14 02:40:13'),
(1464, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5105.92, 5096.92, 'RTO Charge AWB: 77789705976', '2026-05-14 02:40:13', '2026-05-14 02:40:13'),
(1465, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1249.92, 1269.92, 'COD Refund AWB: 77790205054', '2026-05-14 02:40:13', '2026-05-14 02:40:13'),
(1466, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1269.92, 1227.92, 'RTO Charge AWB: 77790205054', '2026-05-14 02:40:13', '2026-05-14 02:40:13'),
(1467, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5096.92, 5106.92, 'COD Refund AWB: 37355837634121', '2026-05-14 02:40:14', '2026-05-14 02:40:14'),
(1468, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5106.92, 5097.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 02:40:14', '2026-05-14 02:40:14'),
(1469, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5097.92, 5107.92, 'COD Refund AWB: 77789705976', '2026-05-14 02:45:08', '2026-05-14 02:45:08'),
(1470, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5107.92, 5098.92, 'RTO Charge AWB: 77789705976', '2026-05-14 02:45:08', '2026-05-14 02:45:08'),
(1471, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1227.92, 1247.92, 'COD Refund AWB: 77790205054', '2026-05-14 02:45:08', '2026-05-14 02:45:08'),
(1472, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1247.92, 1205.92, 'RTO Charge AWB: 77790205054', '2026-05-14 02:45:08', '2026-05-14 02:45:08'),
(1473, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5098.92, 5108.92, 'COD Refund AWB: 37355837634121', '2026-05-14 02:45:09', '2026-05-14 02:45:09'),
(1474, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5108.92, 5099.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 02:45:09', '2026-05-14 02:45:09'),
(1475, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5099.92, 5109.92, 'COD Refund AWB: 77789705976', '2026-05-14 02:50:13', '2026-05-14 02:50:13'),
(1476, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5109.92, 5100.92, 'RTO Charge AWB: 77789705976', '2026-05-14 02:50:13', '2026-05-14 02:50:13'),
(1477, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1205.92, 1225.92, 'COD Refund AWB: 77790205054', '2026-05-14 02:50:13', '2026-05-14 02:50:13'),
(1478, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1225.92, 1183.92, 'RTO Charge AWB: 77790205054', '2026-05-14 02:50:13', '2026-05-14 02:50:13'),
(1479, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5100.92, 5110.92, 'COD Refund AWB: 37355837634121', '2026-05-14 02:50:14', '2026-05-14 02:50:14'),
(1480, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5110.92, 5101.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 02:50:14', '2026-05-14 02:50:14'),
(1481, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5101.92, 5111.92, 'COD Refund AWB: 77789705976', '2026-05-14 02:55:08', '2026-05-14 02:55:08'),
(1482, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5111.92, 5102.92, 'RTO Charge AWB: 77789705976', '2026-05-14 02:55:08', '2026-05-14 02:55:08'),
(1483, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1183.92, 1203.92, 'COD Refund AWB: 77790205054', '2026-05-14 02:55:08', '2026-05-14 02:55:08'),
(1484, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1203.92, 1161.92, 'RTO Charge AWB: 77790205054', '2026-05-14 02:55:08', '2026-05-14 02:55:08'),
(1485, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5102.92, 5112.92, 'COD Refund AWB: 37355837634121', '2026-05-14 02:55:09', '2026-05-14 02:55:09'),
(1486, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5112.92, 5103.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 02:55:09', '2026-05-14 02:55:09'),
(1487, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5103.92, 5113.92, 'COD Refund AWB: 77789705976', '2026-05-14 03:00:16', '2026-05-14 03:00:16'),
(1488, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5113.92, 5104.92, 'RTO Charge AWB: 77789705976', '2026-05-14 03:00:16', '2026-05-14 03:00:16'),
(1489, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1161.92, 1181.92, 'COD Refund AWB: 77790205054', '2026-05-14 03:00:17', '2026-05-14 03:00:17'),
(1490, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1181.92, 1139.92, 'RTO Charge AWB: 77790205054', '2026-05-14 03:00:17', '2026-05-14 03:00:17'),
(1491, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5104.92, 5114.92, 'COD Refund AWB: 37355837634121', '2026-05-14 03:00:17', '2026-05-14 03:00:17'),
(1492, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5114.92, 5105.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 03:00:17', '2026-05-14 03:00:17'),
(1493, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5105.92, 5115.92, 'COD Refund AWB: 77789705976', '2026-05-14 03:05:08', '2026-05-14 03:05:08'),
(1494, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5115.92, 5106.92, 'RTO Charge AWB: 77789705976', '2026-05-14 03:05:08', '2026-05-14 03:05:08'),
(1495, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1139.92, 1159.92, 'COD Refund AWB: 77790205054', '2026-05-14 03:05:08', '2026-05-14 03:05:08'),
(1496, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1159.92, 1117.92, 'RTO Charge AWB: 77790205054', '2026-05-14 03:05:08', '2026-05-14 03:05:08'),
(1497, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5106.92, 5116.92, 'COD Refund AWB: 37355837634121', '2026-05-14 03:05:09', '2026-05-14 03:05:09'),
(1498, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5116.92, 5107.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 03:05:09', '2026-05-14 03:05:09'),
(1499, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5107.92, 5117.92, 'COD Refund AWB: 77789705976', '2026-05-14 03:10:14', '2026-05-14 03:10:14'),
(1500, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5117.92, 5108.92, 'RTO Charge AWB: 77789705976', '2026-05-14 03:10:14', '2026-05-14 03:10:14'),
(1501, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1117.92, 1137.92, 'COD Refund AWB: 77790205054', '2026-05-14 03:10:14', '2026-05-14 03:10:14'),
(1502, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1137.92, 1095.92, 'RTO Charge AWB: 77790205054', '2026-05-14 03:10:14', '2026-05-14 03:10:14'),
(1503, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5108.92, 5118.92, 'COD Refund AWB: 37355837634121', '2026-05-14 03:10:15', '2026-05-14 03:10:15'),
(1504, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5118.92, 5109.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 03:10:15', '2026-05-14 03:10:15'),
(1505, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5109.92, 5119.92, 'COD Refund AWB: 77789705976', '2026-05-14 03:15:08', '2026-05-14 03:15:08'),
(1506, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5119.92, 5110.92, 'RTO Charge AWB: 77789705976', '2026-05-14 03:15:08', '2026-05-14 03:15:08'),
(1507, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1095.92, 1115.92, 'COD Refund AWB: 77790205054', '2026-05-14 03:15:08', '2026-05-14 03:15:08'),
(1508, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1115.92, 1073.92, 'RTO Charge AWB: 77790205054', '2026-05-14 03:15:08', '2026-05-14 03:15:08'),
(1509, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5110.92, 5120.92, 'COD Refund AWB: 37355837634121', '2026-05-14 03:15:09', '2026-05-14 03:15:09'),
(1510, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5120.92, 5111.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 03:15:09', '2026-05-14 03:15:09'),
(1511, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5111.92, 5121.92, 'COD Refund AWB: 77789705976', '2026-05-14 03:20:13', '2026-05-14 03:20:13'),
(1512, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5121.92, 5112.92, 'RTO Charge AWB: 77789705976', '2026-05-14 03:20:13', '2026-05-14 03:20:13'),
(1513, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1073.92, 1093.92, 'COD Refund AWB: 77790205054', '2026-05-14 03:20:13', '2026-05-14 03:20:13'),
(1514, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1093.92, 1051.92, 'RTO Charge AWB: 77790205054', '2026-05-14 03:20:13', '2026-05-14 03:20:13'),
(1515, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5112.92, 5122.92, 'COD Refund AWB: 37355837634121', '2026-05-14 03:20:13', '2026-05-14 03:20:13'),
(1516, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5122.92, 5113.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 03:20:13', '2026-05-14 03:20:13'),
(1517, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5113.92, 5123.92, 'COD Refund AWB: 77789705976', '2026-05-14 03:25:09', '2026-05-14 03:25:09'),
(1518, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5123.92, 5114.92, 'RTO Charge AWB: 77789705976', '2026-05-14 03:25:09', '2026-05-14 03:25:09'),
(1519, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1051.92, 1071.92, 'COD Refund AWB: 77790205054', '2026-05-14 03:25:09', '2026-05-14 03:25:09'),
(1520, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1071.92, 1029.92, 'RTO Charge AWB: 77790205054', '2026-05-14 03:25:09', '2026-05-14 03:25:09'),
(1521, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5114.92, 5124.92, 'COD Refund AWB: 37355837634121', '2026-05-14 03:25:10', '2026-05-14 03:25:10'),
(1522, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5124.92, 5115.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 03:25:10', '2026-05-14 03:25:10'),
(1523, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5115.92, 5125.92, 'COD Refund AWB: 77789705976', '2026-05-14 03:30:07', '2026-05-14 03:30:07'),
(1524, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5125.92, 5116.92, 'RTO Charge AWB: 77789705976', '2026-05-14 03:30:07', '2026-05-14 03:30:07'),
(1525, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1029.92, 1049.92, 'COD Refund AWB: 77790205054', '2026-05-14 03:30:07', '2026-05-14 03:30:07'),
(1526, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1049.92, 1007.92, 'RTO Charge AWB: 77790205054', '2026-05-14 03:30:07', '2026-05-14 03:30:07'),
(1527, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5116.92, 5126.92, 'COD Refund AWB: 37355837634121', '2026-05-14 03:30:08', '2026-05-14 03:30:08'),
(1528, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5126.92, 5117.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 03:30:08', '2026-05-14 03:30:08'),
(1529, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5117.92, 5127.92, 'COD Refund AWB: 77789705976', '2026-05-14 03:35:12', '2026-05-14 03:35:12'),
(1530, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5127.92, 5118.92, 'RTO Charge AWB: 77789705976', '2026-05-14 03:35:12', '2026-05-14 03:35:12'),
(1531, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 1007.92, 1027.92, 'COD Refund AWB: 77790205054', '2026-05-14 03:35:12', '2026-05-14 03:35:12'),
(1532, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1027.92, 985.92, 'RTO Charge AWB: 77790205054', '2026-05-14 03:35:12', '2026-05-14 03:35:12'),
(1533, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5118.92, 5128.92, 'COD Refund AWB: 37355837634121', '2026-05-14 03:35:13', '2026-05-14 03:35:13'),
(1534, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5128.92, 5119.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 03:35:13', '2026-05-14 03:35:13'),
(1535, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5119.92, 5129.92, 'COD Refund AWB: 77789705976', '2026-05-14 03:40:08', '2026-05-14 03:40:08'),
(1536, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5129.92, 5120.92, 'RTO Charge AWB: 77789705976', '2026-05-14 03:40:08', '2026-05-14 03:40:08'),
(1537, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 985.92, 1005.92, 'COD Refund AWB: 77790205054', '2026-05-14 03:40:08', '2026-05-14 03:40:08'),
(1538, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 1005.92, 963.92, 'RTO Charge AWB: 77790205054', '2026-05-14 03:40:08', '2026-05-14 03:40:08'),
(1539, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5120.92, 5130.92, 'COD Refund AWB: 37355837634121', '2026-05-14 03:40:09', '2026-05-14 03:40:09'),
(1540, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5130.92, 5121.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 03:40:09', '2026-05-14 03:40:09'),
(1541, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5121.92, 5131.92, 'COD Refund AWB: 77789705976', '2026-05-14 03:45:10', '2026-05-14 03:45:10'),
(1542, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5131.92, 5122.92, 'RTO Charge AWB: 77789705976', '2026-05-14 03:45:10', '2026-05-14 03:45:10'),
(1543, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 963.92, 983.92, 'COD Refund AWB: 77790205054', '2026-05-14 03:45:11', '2026-05-14 03:45:11'),
(1544, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 983.92, 941.92, 'RTO Charge AWB: 77790205054', '2026-05-14 03:45:11', '2026-05-14 03:45:11'),
(1545, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5122.92, 5132.92, 'COD Refund AWB: 37355837634121', '2026-05-14 03:45:13', '2026-05-14 03:45:13'),
(1546, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5132.92, 5123.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 03:45:13', '2026-05-14 03:45:13'),
(1547, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5123.92, 5133.92, 'COD Refund AWB: 77789705976', '2026-05-14 03:50:08', '2026-05-14 03:50:08'),
(1548, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5133.92, 5124.92, 'RTO Charge AWB: 77789705976', '2026-05-14 03:50:08', '2026-05-14 03:50:08'),
(1549, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 941.92, 961.92, 'COD Refund AWB: 77790205054', '2026-05-14 03:50:08', '2026-05-14 03:50:08'),
(1550, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 961.92, 919.92, 'RTO Charge AWB: 77790205054', '2026-05-14 03:50:08', '2026-05-14 03:50:08'),
(1551, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5124.92, 5134.92, 'COD Refund AWB: 37355837634121', '2026-05-14 03:50:08', '2026-05-14 03:50:08'),
(1552, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5134.92, 5125.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 03:50:08', '2026-05-14 03:50:08'),
(1553, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5125.92, 5135.92, 'COD Refund AWB: 77789705976', '2026-05-14 03:55:11', '2026-05-14 03:55:11'),
(1554, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5135.92, 5126.92, 'RTO Charge AWB: 77789705976', '2026-05-14 03:55:11', '2026-05-14 03:55:11'),
(1555, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 919.92, 939.92, 'COD Refund AWB: 77790205054', '2026-05-14 03:55:12', '2026-05-14 03:55:12'),
(1556, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 939.92, 897.92, 'RTO Charge AWB: 77790205054', '2026-05-14 03:55:12', '2026-05-14 03:55:12'),
(1557, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5126.92, 5136.92, 'COD Refund AWB: 77790553190', '2026-05-14 03:55:12', '2026-05-14 03:55:12'),
(1558, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5136.92, 5127.92, 'RTO Charge AWB: 77790553190', '2026-05-14 03:55:12', '2026-05-14 03:55:12'),
(1559, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5127.92, 5137.92, 'COD Refund AWB: 37355837634121', '2026-05-14 03:55:13', '2026-05-14 03:55:13'),
(1560, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5137.92, 5128.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 03:55:13', '2026-05-14 03:55:13'),
(1561, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5128.92, 5138.92, 'COD Refund AWB: 37355837634014', '2026-05-14 03:55:13', '2026-05-14 03:55:13'),
(1562, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5138.92, 5129.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 03:55:13', '2026-05-14 03:55:13'),
(1563, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5129.92, 5139.92, 'COD Refund AWB: 77789705976', '2026-05-14 04:00:09', '2026-05-14 04:00:09'),
(1564, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5139.92, 5130.92, 'RTO Charge AWB: 77789705976', '2026-05-14 04:00:09', '2026-05-14 04:00:09'),
(1565, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 897.92, 917.92, 'COD Refund AWB: 77790205054', '2026-05-14 04:00:09', '2026-05-14 04:00:09'),
(1566, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 917.92, 875.92, 'RTO Charge AWB: 77790205054', '2026-05-14 04:00:09', '2026-05-14 04:00:09'),
(1567, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5130.92, 5140.92, 'COD Refund AWB: 77790553190', '2026-05-14 04:00:09', '2026-05-14 04:00:09'),
(1568, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5140.92, 5131.92, 'RTO Charge AWB: 77790553190', '2026-05-14 04:00:09', '2026-05-14 04:00:09'),
(1569, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5131.92, 5141.92, 'COD Refund AWB: 37355837634121', '2026-05-14 04:00:10', '2026-05-14 04:00:10'),
(1570, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5141.92, 5132.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 04:00:10', '2026-05-14 04:00:10'),
(1571, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5132.92, 5142.92, 'COD Refund AWB: 37355837634014', '2026-05-14 04:00:11', '2026-05-14 04:00:11'),
(1572, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5142.92, 5133.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 04:00:11', '2026-05-14 04:00:11'),
(1573, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5133.92, 5143.92, 'COD Refund AWB: 77789705976', '2026-05-14 04:05:10', '2026-05-14 04:05:10'),
(1574, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5143.92, 5134.92, 'RTO Charge AWB: 77789705976', '2026-05-14 04:05:10', '2026-05-14 04:05:10'),
(1575, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 875.92, 895.92, 'COD Refund AWB: 77790205054', '2026-05-14 04:05:10', '2026-05-14 04:05:10'),
(1576, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 895.92, 853.92, 'RTO Charge AWB: 77790205054', '2026-05-14 04:05:10', '2026-05-14 04:05:10'),
(1577, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5134.92, 5144.92, 'COD Refund AWB: 77790553190', '2026-05-14 04:05:10', '2026-05-14 04:05:10'),
(1578, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5144.92, 5135.92, 'RTO Charge AWB: 77790553190', '2026-05-14 04:05:10', '2026-05-14 04:05:10'),
(1579, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5135.92, 5145.92, 'COD Refund AWB: 37355837634121', '2026-05-14 04:05:11', '2026-05-14 04:05:11'),
(1580, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5145.92, 5136.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 04:05:11', '2026-05-14 04:05:11'),
(1581, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5136.92, 5146.92, 'COD Refund AWB: 37355837634014', '2026-05-14 04:05:11', '2026-05-14 04:05:11'),
(1582, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5146.92, 5137.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 04:05:11', '2026-05-14 04:05:11'),
(1583, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5137.92, 5147.92, 'COD Refund AWB: 77789705976', '2026-05-14 04:10:09', '2026-05-14 04:10:09'),
(1584, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5147.92, 5138.92, 'RTO Charge AWB: 77789705976', '2026-05-14 04:10:09', '2026-05-14 04:10:09'),
(1585, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 853.92, 873.92, 'COD Refund AWB: 77790205054', '2026-05-14 04:10:09', '2026-05-14 04:10:09'),
(1586, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 873.92, 831.92, 'RTO Charge AWB: 77790205054', '2026-05-14 04:10:09', '2026-05-14 04:10:09'),
(1587, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5138.92, 5148.92, 'COD Refund AWB: 77790553190', '2026-05-14 04:10:09', '2026-05-14 04:10:09'),
(1588, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5148.92, 5139.92, 'RTO Charge AWB: 77790553190', '2026-05-14 04:10:09', '2026-05-14 04:10:09'),
(1589, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5139.92, 5149.92, 'COD Refund AWB: 37355837634121', '2026-05-14 04:10:10', '2026-05-14 04:10:10'),
(1590, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5149.92, 5140.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 04:10:10', '2026-05-14 04:10:10'),
(1591, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5140.92, 5150.92, 'COD Refund AWB: 37355837634014', '2026-05-14 04:10:11', '2026-05-14 04:10:11'),
(1592, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5150.92, 5141.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 04:10:11', '2026-05-14 04:10:11'),
(1593, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 5141.92, 5151.92, 'COD Refund AWB: 37355837525212', '2026-05-14 04:15:12', '2026-05-14 04:15:12'),
(1594, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 5151.92, 5142.92, 'RTO Charge AWB: 37355837525212', '2026-05-14 04:15:12', '2026-05-14 04:15:12'),
(1595, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5142.92, 5152.92, 'COD Refund AWB: 77789705976', '2026-05-14 04:15:12', '2026-05-14 04:15:12'),
(1596, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5152.92, 5143.92, 'RTO Charge AWB: 77789705976', '2026-05-14 04:15:12', '2026-05-14 04:15:12'),
(1597, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 831.92, 851.92, 'COD Refund AWB: 77790205054', '2026-05-14 04:15:12', '2026-05-14 04:15:12'),
(1598, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 851.92, 809.92, 'RTO Charge AWB: 77790205054', '2026-05-14 04:15:12', '2026-05-14 04:15:12'),
(1599, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5143.92, 5153.92, 'COD Refund AWB: 77790553190', '2026-05-14 04:15:12', '2026-05-14 04:15:12'),
(1600, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5153.92, 5144.92, 'RTO Charge AWB: 77790553190', '2026-05-14 04:15:12', '2026-05-14 04:15:12'),
(1601, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5144.92, 5154.92, 'COD Refund AWB: 37355837634121', '2026-05-14 04:15:14', '2026-05-14 04:15:14'),
(1602, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5154.92, 5145.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 04:15:14', '2026-05-14 04:15:14'),
(1603, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5145.92, 5155.92, 'COD Refund AWB: 37355837634014', '2026-05-14 04:15:14', '2026-05-14 04:15:14'),
(1604, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5155.92, 5146.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 04:15:14', '2026-05-14 04:15:14'),
(1605, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 5146.92, 5156.92, 'COD Refund AWB: 37355837525212', '2026-05-14 04:20:08', '2026-05-14 04:20:08'),
(1606, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 5156.92, 5147.92, 'RTO Charge AWB: 37355837525212', '2026-05-14 04:20:08', '2026-05-14 04:20:08'),
(1607, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5147.92, 5157.92, 'COD Refund AWB: 77789705976', '2026-05-14 04:20:08', '2026-05-14 04:20:08'),
(1608, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5157.92, 5148.92, 'RTO Charge AWB: 77789705976', '2026-05-14 04:20:08', '2026-05-14 04:20:08'),
(1609, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 809.92, 829.92, 'COD Refund AWB: 77790205054', '2026-05-14 04:20:08', '2026-05-14 04:20:08'),
(1610, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 829.92, 787.92, 'RTO Charge AWB: 77790205054', '2026-05-14 04:20:08', '2026-05-14 04:20:08'),
(1611, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5148.92, 5158.92, 'COD Refund AWB: 77790553190', '2026-05-14 04:20:08', '2026-05-14 04:20:08'),
(1612, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5158.92, 5149.92, 'RTO Charge AWB: 77790553190', '2026-05-14 04:20:08', '2026-05-14 04:20:08'),
(1613, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5149.92, 5159.92, 'COD Refund AWB: 37355837634121', '2026-05-14 04:20:09', '2026-05-14 04:20:09'),
(1614, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5159.92, 5150.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 04:20:09', '2026-05-14 04:20:09'),
(1615, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5150.92, 5160.92, 'COD Refund AWB: 37355837634014', '2026-05-14 04:20:09', '2026-05-14 04:20:09'),
(1616, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5160.92, 5151.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 04:20:09', '2026-05-14 04:20:09'),
(1617, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 5151.92, 5161.92, 'COD Refund AWB: 37355837525212', '2026-05-14 04:25:09', '2026-05-14 04:25:09'),
(1618, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 5161.92, 5152.92, 'RTO Charge AWB: 37355837525212', '2026-05-14 04:25:09', '2026-05-14 04:25:09'),
(1619, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5152.92, 5162.92, 'COD Refund AWB: 77789705976', '2026-05-14 04:25:09', '2026-05-14 04:25:09'),
(1620, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5162.92, 5153.92, 'RTO Charge AWB: 77789705976', '2026-05-14 04:25:09', '2026-05-14 04:25:09'),
(1621, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 787.92, 807.92, 'COD Refund AWB: 77790205054', '2026-05-14 04:25:10', '2026-05-14 04:25:10'),
(1622, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 807.92, 765.92, 'RTO Charge AWB: 77790205054', '2026-05-14 04:25:10', '2026-05-14 04:25:10'),
(1623, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5153.92, 5163.92, 'COD Refund AWB: 77790553190', '2026-05-14 04:25:10', '2026-05-14 04:25:10'),
(1624, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5163.92, 5154.92, 'RTO Charge AWB: 77790553190', '2026-05-14 04:25:10', '2026-05-14 04:25:10'),
(1625, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5154.92, 5164.92, 'COD Refund AWB: 37355837634121', '2026-05-14 04:25:10', '2026-05-14 04:25:10'),
(1626, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5164.92, 5155.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 04:25:10', '2026-05-14 04:25:10'),
(1627, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5155.92, 5165.92, 'COD Refund AWB: 37355837634014', '2026-05-14 04:25:11', '2026-05-14 04:25:11'),
(1628, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5165.92, 5156.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 04:25:11', '2026-05-14 04:25:11'),
(1629, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 5156.92, 5166.92, 'COD Refund AWB: 37355837525212', '2026-05-14 04:30:08', '2026-05-14 04:30:08'),
(1630, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 5166.92, 5157.92, 'RTO Charge AWB: 37355837525212', '2026-05-14 04:30:08', '2026-05-14 04:30:08'),
(1631, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5157.92, 5167.92, 'COD Refund AWB: 77789705976', '2026-05-14 04:30:08', '2026-05-14 04:30:08'),
(1632, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5167.92, 5158.92, 'RTO Charge AWB: 77789705976', '2026-05-14 04:30:08', '2026-05-14 04:30:08'),
(1633, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 765.92, 785.92, 'COD Refund AWB: 77790205054', '2026-05-14 04:30:09', '2026-05-14 04:30:09'),
(1634, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 785.92, 743.92, 'RTO Charge AWB: 77790205054', '2026-05-14 04:30:09', '2026-05-14 04:30:09'),
(1635, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5158.92, 5168.92, 'COD Refund AWB: 77790553190', '2026-05-14 04:30:09', '2026-05-14 04:30:09'),
(1636, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5168.92, 5159.92, 'RTO Charge AWB: 77790553190', '2026-05-14 04:30:09', '2026-05-14 04:30:09'),
(1637, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5159.92, 5169.92, 'COD Refund AWB: 37355837634121', '2026-05-14 04:30:09', '2026-05-14 04:30:09'),
(1638, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5169.92, 5160.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 04:30:09', '2026-05-14 04:30:09'),
(1639, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5160.92, 5170.92, 'COD Refund AWB: 37355837634014', '2026-05-14 04:30:10', '2026-05-14 04:30:10'),
(1640, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5170.92, 5161.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 04:30:10', '2026-05-14 04:30:10'),
(1641, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 5161.92, 5171.92, 'COD Refund AWB: 37355837525212', '2026-05-14 04:35:09', '2026-05-14 04:35:09'),
(1642, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 5171.92, 5162.92, 'RTO Charge AWB: 37355837525212', '2026-05-14 04:35:09', '2026-05-14 04:35:09'),
(1643, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5162.92, 5172.92, 'COD Refund AWB: 77789705976', '2026-05-14 04:35:09', '2026-05-14 04:35:09'),
(1644, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5172.92, 5163.92, 'RTO Charge AWB: 77789705976', '2026-05-14 04:35:09', '2026-05-14 04:35:09'),
(1645, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 743.92, 763.92, 'COD Refund AWB: 77790205054', '2026-05-14 04:35:10', '2026-05-14 04:35:10'),
(1646, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 763.92, 721.92, 'RTO Charge AWB: 77790205054', '2026-05-14 04:35:10', '2026-05-14 04:35:10'),
(1647, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5163.92, 5173.92, 'COD Refund AWB: 77790553190', '2026-05-14 04:35:10', '2026-05-14 04:35:10'),
(1648, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5173.92, 5164.92, 'RTO Charge AWB: 77790553190', '2026-05-14 04:35:10', '2026-05-14 04:35:10'),
(1649, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5164.92, 5174.92, 'COD Refund AWB: 37355837634121', '2026-05-14 04:35:10', '2026-05-14 04:35:10'),
(1650, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5174.92, 5165.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 04:35:10', '2026-05-14 04:35:10'),
(1651, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5165.92, 5175.92, 'COD Refund AWB: 37355837634014', '2026-05-14 04:35:10', '2026-05-14 04:35:10'),
(1652, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5175.92, 5166.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 04:35:10', '2026-05-14 04:35:10'),
(1653, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 5166.92, 5176.92, 'COD Refund AWB: 37355837525212', '2026-05-14 04:40:07', '2026-05-14 04:40:07'),
(1654, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 5176.92, 5167.92, 'RTO Charge AWB: 37355837525212', '2026-05-14 04:40:07', '2026-05-14 04:40:07'),
(1655, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5167.92, 5177.92, 'COD Refund AWB: 77789705976', '2026-05-14 04:40:07', '2026-05-14 04:40:07'),
(1656, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5177.92, 5168.92, 'RTO Charge AWB: 77789705976', '2026-05-14 04:40:07', '2026-05-14 04:40:07'),
(1657, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 721.92, 741.92, 'COD Refund AWB: 77790205054', '2026-05-14 04:40:07', '2026-05-14 04:40:07'),
(1658, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 741.92, 699.92, 'RTO Charge AWB: 77790205054', '2026-05-14 04:40:07', '2026-05-14 04:40:07'),
(1659, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5168.92, 5178.92, 'COD Refund AWB: 77790553190', '2026-05-14 04:40:07', '2026-05-14 04:40:07'),
(1660, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5178.92, 5169.92, 'RTO Charge AWB: 77790553190', '2026-05-14 04:40:07', '2026-05-14 04:40:07'),
(1661, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5169.92, 5179.92, 'COD Refund AWB: 37355837634121', '2026-05-14 04:40:08', '2026-05-14 04:40:08'),
(1662, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5179.92, 5170.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 04:40:08', '2026-05-14 04:40:08'),
(1663, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5170.92, 5180.92, 'COD Refund AWB: 37355837634014', '2026-05-14 04:40:08', '2026-05-14 04:40:08'),
(1664, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5180.92, 5171.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 04:40:08', '2026-05-14 04:40:08'),
(1665, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 5171.92, 5181.92, 'COD Refund AWB: 37355837525212', '2026-05-14 04:45:09', '2026-05-14 04:45:09'),
(1666, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 5181.92, 5172.92, 'RTO Charge AWB: 37355837525212', '2026-05-14 04:45:09', '2026-05-14 04:45:09'),
(1667, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5172.92, 5182.92, 'COD Refund AWB: 77789705976', '2026-05-14 04:45:09', '2026-05-14 04:45:09'),
(1668, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5182.92, 5173.92, 'RTO Charge AWB: 77789705976', '2026-05-14 04:45:09', '2026-05-14 04:45:09'),
(1669, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 699.92, 719.92, 'COD Refund AWB: 77790205054', '2026-05-14 04:45:09', '2026-05-14 04:45:09'),
(1670, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 719.92, 677.92, 'RTO Charge AWB: 77790205054', '2026-05-14 04:45:09', '2026-05-14 04:45:09'),
(1671, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5173.92, 5183.92, 'COD Refund AWB: 77790553190', '2026-05-14 04:45:09', '2026-05-14 04:45:09'),
(1672, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5183.92, 5174.92, 'RTO Charge AWB: 77790553190', '2026-05-14 04:45:09', '2026-05-14 04:45:09'),
(1673, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5174.92, 5184.92, 'COD Refund AWB: 37355837634121', '2026-05-14 04:45:10', '2026-05-14 04:45:10'),
(1674, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5184.92, 5175.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 04:45:10', '2026-05-14 04:45:10'),
(1675, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5175.92, 5185.92, 'COD Refund AWB: 37355837634014', '2026-05-14 04:45:10', '2026-05-14 04:45:10'),
(1676, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5185.92, 5176.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 04:45:10', '2026-05-14 04:45:10'),
(1677, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 5176.92, 5186.92, 'COD Refund AWB: 37355837525212', '2026-05-14 04:50:07', '2026-05-14 04:50:07'),
(1678, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 5186.92, 5177.92, 'RTO Charge AWB: 37355837525212', '2026-05-14 04:50:07', '2026-05-14 04:50:07'),
(1679, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5177.92, 5187.92, 'COD Refund AWB: 77789705976', '2026-05-14 04:50:08', '2026-05-14 04:50:08'),
(1680, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5187.92, 5178.92, 'RTO Charge AWB: 77789705976', '2026-05-14 04:50:08', '2026-05-14 04:50:08'),
(1681, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 677.92, 697.92, 'COD Refund AWB: 77790205054', '2026-05-14 04:50:08', '2026-05-14 04:50:08'),
(1682, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 697.92, 655.92, 'RTO Charge AWB: 77790205054', '2026-05-14 04:50:08', '2026-05-14 04:50:08'),
(1683, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5178.92, 5188.92, 'COD Refund AWB: 77790553190', '2026-05-14 04:50:08', '2026-05-14 04:50:08'),
(1684, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5188.92, 5179.92, 'RTO Charge AWB: 77790553190', '2026-05-14 04:50:08', '2026-05-14 04:50:08'),
(1685, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5179.92, 5189.92, 'COD Refund AWB: 37355837634121', '2026-05-14 04:50:09', '2026-05-14 04:50:09'),
(1686, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5189.92, 5180.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 04:50:09', '2026-05-14 04:50:09'),
(1687, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5180.92, 5190.92, 'COD Refund AWB: 37355837634014', '2026-05-14 04:50:09', '2026-05-14 04:50:09'),
(1688, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5190.92, 5181.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 04:50:09', '2026-05-14 04:50:09'),
(1689, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 5181.92, 5191.92, 'COD Refund AWB: 37355837525212', '2026-05-14 04:55:10', '2026-05-14 04:55:10'),
(1690, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 5191.92, 5182.92, 'RTO Charge AWB: 37355837525212', '2026-05-14 04:55:10', '2026-05-14 04:55:10'),
(1691, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5182.92, 5192.92, 'COD Refund AWB: 77789705976', '2026-05-14 04:55:10', '2026-05-14 04:55:10'),
(1692, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5192.92, 5183.92, 'RTO Charge AWB: 77789705976', '2026-05-14 04:55:10', '2026-05-14 04:55:10'),
(1693, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 655.92, 675.92, 'COD Refund AWB: 77790205054', '2026-05-14 04:55:10', '2026-05-14 04:55:10'),
(1694, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 675.92, 633.92, 'RTO Charge AWB: 77790205054', '2026-05-14 04:55:10', '2026-05-14 04:55:10'),
(1695, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5183.92, 5193.92, 'COD Refund AWB: 77790553190', '2026-05-14 04:55:10', '2026-05-14 04:55:10'),
(1696, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5193.92, 5184.92, 'RTO Charge AWB: 77790553190', '2026-05-14 04:55:10', '2026-05-14 04:55:10'),
(1697, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5184.92, 5194.92, 'COD Refund AWB: 37355837634121', '2026-05-14 04:55:11', '2026-05-14 04:55:11'),
(1698, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5194.92, 5185.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 04:55:11', '2026-05-14 04:55:11'),
(1699, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5185.92, 5195.92, 'COD Refund AWB: 37355837634014', '2026-05-14 04:55:11', '2026-05-14 04:55:11'),
(1700, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5195.92, 5186.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 04:55:11', '2026-05-14 04:55:11'),
(1701, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 5186.92, 5196.92, 'COD Refund AWB: 37355837525212', '2026-05-14 05:00:07', '2026-05-14 05:00:07'),
(1702, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 5196.92, 5187.92, 'RTO Charge AWB: 37355837525212', '2026-05-14 05:00:07', '2026-05-14 05:00:07'),
(1703, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5187.92, 5197.92, 'COD Refund AWB: 77789705976', '2026-05-14 05:00:07', '2026-05-14 05:00:07'),
(1704, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5197.92, 5188.92, 'RTO Charge AWB: 77789705976', '2026-05-14 05:00:07', '2026-05-14 05:00:07'),
(1705, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 633.92, 653.92, 'COD Refund AWB: 77790205054', '2026-05-14 05:00:07', '2026-05-14 05:00:07'),
(1706, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 653.92, 611.92, 'RTO Charge AWB: 77790205054', '2026-05-14 05:00:07', '2026-05-14 05:00:07'),
(1707, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5188.92, 5198.92, 'COD Refund AWB: 77790553190', '2026-05-14 05:00:07', '2026-05-14 05:00:07'),
(1708, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5198.92, 5189.92, 'RTO Charge AWB: 77790553190', '2026-05-14 05:00:07', '2026-05-14 05:00:07'),
(1709, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5189.92, 5199.92, 'COD Refund AWB: 37355837634121', '2026-05-14 05:00:08', '2026-05-14 05:00:08'),
(1710, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5199.92, 5190.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 05:00:08', '2026-05-14 05:00:08'),
(1711, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5190.92, 5200.92, 'COD Refund AWB: 37355837634014', '2026-05-14 05:00:08', '2026-05-14 05:00:08'),
(1712, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5200.92, 5191.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 05:00:08', '2026-05-14 05:00:08'),
(1713, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 5191.92, 5201.92, 'COD Refund AWB: 37355837525212', '2026-05-14 05:05:11', '2026-05-14 05:05:11'),
(1714, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 5201.92, 5192.92, 'RTO Charge AWB: 37355837525212', '2026-05-14 05:05:11', '2026-05-14 05:05:11'),
(1715, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5192.92, 5202.92, 'COD Refund AWB: 77789705976', '2026-05-14 05:05:11', '2026-05-14 05:05:11'),
(1716, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5202.92, 5193.92, 'RTO Charge AWB: 77789705976', '2026-05-14 05:05:11', '2026-05-14 05:05:11'),
(1717, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 611.92, 631.92, 'COD Refund AWB: 77790205054', '2026-05-14 05:05:11', '2026-05-14 05:05:11'),
(1718, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 631.92, 589.92, 'RTO Charge AWB: 77790205054', '2026-05-14 05:05:11', '2026-05-14 05:05:11'),
(1719, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5193.92, 5203.92, 'COD Refund AWB: 77790553190', '2026-05-14 05:05:11', '2026-05-14 05:05:11'),
(1720, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5203.92, 5194.92, 'RTO Charge AWB: 77790553190', '2026-05-14 05:05:11', '2026-05-14 05:05:11'),
(1721, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5194.92, 5204.92, 'COD Refund AWB: 37355837634121', '2026-05-14 05:05:12', '2026-05-14 05:05:12'),
(1722, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5204.92, 5195.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 05:05:12', '2026-05-14 05:05:12'),
(1723, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5195.92, 5205.92, 'COD Refund AWB: 37355837634014', '2026-05-14 05:05:12', '2026-05-14 05:05:12'),
(1724, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5205.92, 5196.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 05:05:12', '2026-05-14 05:05:12'),
(1725, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 5196.92, 5206.92, 'COD Refund AWB: 37355837525212', '2026-05-14 05:10:14', '2026-05-14 05:10:14'),
(1726, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 5206.92, 5197.92, 'RTO Charge AWB: 37355837525212', '2026-05-14 05:10:14', '2026-05-14 05:10:14'),
(1727, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 5197.92, 5207.92, 'COD Refund AWB: 77789705976', '2026-05-14 05:10:14', '2026-05-14 05:10:14'),
(1728, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 5207.92, 5198.92, 'RTO Charge AWB: 77789705976', '2026-05-14 05:10:14', '2026-05-14 05:10:14'),
(1729, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 589.92, 609.92, 'COD Refund AWB: 77790205054', '2026-05-14 05:10:14', '2026-05-14 05:10:14'),
(1730, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 609.92, 567.92, 'RTO Charge AWB: 77790205054', '2026-05-14 05:10:14', '2026-05-14 05:10:14'),
(1731, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 5198.92, 5208.92, 'COD Refund AWB: 77790553190', '2026-05-14 05:10:14', '2026-05-14 05:10:14'),
(1732, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 5208.92, 5199.92, 'RTO Charge AWB: 77790553190', '2026-05-14 05:10:14', '2026-05-14 05:10:14'),
(1733, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 5199.92, 5209.92, 'COD Refund AWB: 37355837634121', '2026-05-14 05:10:15', '2026-05-14 05:10:15'),
(1734, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 5209.92, 5200.92, 'RTO Charge AWB: 37355837634121', '2026-05-14 05:10:15', '2026-05-14 05:10:15'),
(1735, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 5200.92, 5210.92, 'COD Refund AWB: 37355837634014', '2026-05-14 05:10:15', '2026-05-14 05:10:15'),
(1736, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 5210.92, 5201.92, 'RTO Charge AWB: 37355837634014', '2026-05-14 05:10:15', '2026-05-14 05:10:15'),
(1737, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 4835.00, 4845.00, 'COD Refund AWB: 37355837525212', '2026-05-14 05:15:07', '2026-05-14 05:15:07'),
(1738, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 4845.00, 4836.00, 'RTO Charge AWB: 37355837525212', '2026-05-14 05:15:07', '2026-05-14 05:15:07'),
(1739, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4836.00, 4846.00, 'COD Refund AWB: 77789705976', '2026-05-14 05:15:07', '2026-05-14 05:15:07'),
(1740, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4846.00, 4837.00, 'RTO Charge AWB: 77789705976', '2026-05-14 05:15:07', '2026-05-14 05:15:07'),
(1741, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 567.92, 587.92, 'COD Refund AWB: 77790205054', '2026-05-14 05:15:07', '2026-05-14 05:15:07'),
(1742, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 587.92, 545.92, 'RTO Charge AWB: 77790205054', '2026-05-14 05:15:07', '2026-05-14 05:15:07'),
(1743, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 4837.00, 4847.00, 'COD Refund AWB: 77790553190', '2026-05-14 05:15:07', '2026-05-14 05:15:07'),
(1744, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 4847.00, 4838.00, 'RTO Charge AWB: 77790553190', '2026-05-14 05:15:07', '2026-05-14 05:15:07'),
(1745, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4838.00, 4848.00, 'COD Refund AWB: 37355837634121', '2026-05-14 05:15:08', '2026-05-14 05:15:08'),
(1746, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4848.00, 4839.00, 'RTO Charge AWB: 37355837634121', '2026-05-14 05:15:08', '2026-05-14 05:15:08'),
(1747, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 4839.00, 4849.00, 'COD Refund AWB: 37355837634014', '2026-05-14 05:15:08', '2026-05-14 05:15:08'),
(1748, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 4849.00, 4840.00, 'RTO Charge AWB: 37355837634014', '2026-05-14 05:15:08', '2026-05-14 05:15:08'),
(1749, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 4840.00, 4850.00, 'COD Refund AWB: 37355837525212', '2026-05-14 05:20:12', '2026-05-14 05:20:12');
INSERT INTO `wallet_transactions` (`id`, `user_id`, `fship_order_id`, `amount`, `type`, `charge_type`, `source`, `opening_balance`, `closing_balance`, `remark`, `created_at`, `updated_at`) VALUES
(1750, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 4850.00, 4841.00, 'RTO Charge AWB: 37355837525212', '2026-05-14 05:20:12', '2026-05-14 05:20:12'),
(1751, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4841.00, 4851.00, 'COD Refund AWB: 77789705976', '2026-05-14 05:20:12', '2026-05-14 05:20:12'),
(1752, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4851.00, 4842.00, 'RTO Charge AWB: 77789705976', '2026-05-14 05:20:12', '2026-05-14 05:20:12'),
(1753, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 545.92, 565.92, 'COD Refund AWB: 77790205054', '2026-05-14 05:20:13', '2026-05-14 05:20:13'),
(1754, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 565.92, 523.92, 'RTO Charge AWB: 77790205054', '2026-05-14 05:20:13', '2026-05-14 05:20:13'),
(1755, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 4842.00, 4852.00, 'COD Refund AWB: 77790553190', '2026-05-14 05:20:13', '2026-05-14 05:20:13'),
(1756, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 4852.00, 4843.00, 'RTO Charge AWB: 77790553190', '2026-05-14 05:20:13', '2026-05-14 05:20:13'),
(1757, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4843.00, 4853.00, 'COD Refund AWB: 37355837634121', '2026-05-14 05:20:13', '2026-05-14 05:20:13'),
(1758, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4853.00, 4844.00, 'RTO Charge AWB: 37355837634121', '2026-05-14 05:20:13', '2026-05-14 05:20:13'),
(1759, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 4844.00, 4854.00, 'COD Refund AWB: 37355837634014', '2026-05-14 05:20:14', '2026-05-14 05:20:14'),
(1760, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 4854.00, 4845.00, 'RTO Charge AWB: 37355837634014', '2026-05-14 05:20:14', '2026-05-14 05:20:14'),
(1761, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 4845.00, 4855.00, 'COD Refund AWB: 37355837525212', '2026-05-14 05:23:19', '2026-05-14 05:23:19'),
(1762, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 4855.00, 4846.00, 'RTO Charge AWB: 37355837525212', '2026-05-14 05:23:19', '2026-05-14 05:23:19'),
(1763, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 4846.00, 4856.00, 'COD Refund AWB: 37355837525212', '2026-05-14 05:25:07', '2026-05-14 05:25:07'),
(1764, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 4856.00, 4847.00, 'RTO Charge AWB: 37355837525212', '2026-05-14 05:25:07', '2026-05-14 05:25:07'),
(1765, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4847.00, 4857.00, 'COD Refund AWB: 77789705976', '2026-05-14 05:25:08', '2026-05-14 05:25:08'),
(1766, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4857.00, 4848.00, 'RTO Charge AWB: 77789705976', '2026-05-14 05:25:08', '2026-05-14 05:25:08'),
(1767, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 523.92, 543.92, 'COD Refund AWB: 77790205054', '2026-05-14 05:25:08', '2026-05-14 05:25:08'),
(1768, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 543.92, 501.92, 'RTO Charge AWB: 77790205054', '2026-05-14 05:25:08', '2026-05-14 05:25:08'),
(1769, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 4848.00, 4858.00, 'COD Refund AWB: 77790553190', '2026-05-14 05:25:08', '2026-05-14 05:25:08'),
(1770, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 4858.00, 4849.00, 'RTO Charge AWB: 77790553190', '2026-05-14 05:25:08', '2026-05-14 05:25:08'),
(1771, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4849.00, 4859.00, 'COD Refund AWB: 37355837634121', '2026-05-14 05:25:08', '2026-05-14 05:25:08'),
(1772, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4859.00, 4850.00, 'RTO Charge AWB: 37355837634121', '2026-05-14 05:25:08', '2026-05-14 05:25:08'),
(1773, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 4850.00, 4860.00, 'COD Refund AWB: 37355837634014', '2026-05-14 05:25:09', '2026-05-14 05:25:09'),
(1774, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 4860.00, 4851.00, 'RTO Charge AWB: 37355837634014', '2026-05-14 05:25:09', '2026-05-14 05:25:09'),
(1775, 36, 142, 10.00, 'credit', 'cod_refund', 'admin_manual', 4851.00, 4861.00, 'COD Refund AWB: 37355837525212', '2026-05-14 05:30:15', '2026-05-14 05:30:15'),
(1776, 36, 142, 9.00, 'debit', 'rto', 'admin_manual', 4861.00, 4852.00, 'RTO Charge AWB: 37355837525212', '2026-05-14 05:30:15', '2026-05-14 05:30:15'),
(1777, 36, 145, 10.00, 'credit', 'cod_refund', 'admin_manual', 4852.00, 4862.00, 'COD Refund AWB: 77789705976', '2026-05-14 05:30:15', '2026-05-14 05:30:15'),
(1778, 36, 145, 9.00, 'debit', 'rto', 'admin_manual', 4862.00, 4853.00, 'RTO Charge AWB: 77789705976', '2026-05-14 05:30:15', '2026-05-14 05:30:15'),
(1779, 39, 152, 20.00, 'credit', 'cod_refund', 'admin_manual', 501.92, 521.92, 'COD Refund AWB: 77790205054', '2026-05-14 05:30:15', '2026-05-14 05:30:15'),
(1780, 39, 152, 42.00, 'debit', 'rto', 'admin_manual', 521.92, 479.92, 'RTO Charge AWB: 77790205054', '2026-05-14 05:30:15', '2026-05-14 05:30:15'),
(1781, 36, 159, 10.00, 'credit', 'cod_refund', 'admin_manual', 4853.00, 4863.00, 'COD Refund AWB: 77790553190', '2026-05-14 05:30:15', '2026-05-14 05:30:15'),
(1782, 36, 159, 9.00, 'debit', 'rto', 'admin_manual', 4863.00, 4854.00, 'RTO Charge AWB: 77790553190', '2026-05-14 05:30:15', '2026-05-14 05:30:15'),
(1783, 36, 189, 10.00, 'credit', 'cod_refund', 'admin_manual', 4854.00, 4864.00, 'COD Refund AWB: 37355837634121', '2026-05-14 05:30:16', '2026-05-14 05:30:16'),
(1784, 36, 189, 9.00, 'debit', 'rto', 'admin_manual', 4864.00, 4855.00, 'RTO Charge AWB: 37355837634121', '2026-05-14 05:30:16', '2026-05-14 05:30:16'),
(1785, 36, 199, 10.00, 'credit', 'cod_refund', 'admin_manual', 4855.00, 4865.00, 'COD Refund AWB: 37355837634014', '2026-05-14 05:30:16', '2026-05-14 05:30:16'),
(1786, 36, 199, 9.00, 'debit', 'rto', 'admin_manual', 4865.00, 4856.00, 'RTO Charge AWB: 37355837634014', '2026-05-14 05:30:16', '2026-05-14 05:30:16'),
(1787, 36, 166, 10.00, 'credit', 'cod_refund', 'admin_manual', 4835.00, 4845.00, 'COD Refund AWB: 77790727556', '2026-05-14 06:00:14', '2026-05-14 06:00:14'),
(1788, 36, 166, 9.00, 'debit', 'rto', 'admin_manual', 4845.00, 4836.00, 'RTO Charge AWB: 77790727556', '2026-05-14 06:00:14', '2026-05-14 06:00:14'),
(1789, 36, 190, 10.00, 'credit', 'cod_refund', 'admin_manual', 4836.00, 4846.00, 'COD Refund AWB: 37355837634110', '2026-05-15 03:35:23', '2026-05-15 03:35:23'),
(1790, 36, 190, 9.00, 'debit', 'rto', 'admin_manual', 4846.00, 4837.00, 'RTO Charge AWB: 37355837634110', '2026-05-15 03:35:23', '2026-05-15 03:35:23'),
(1791, 36, 177, 10.00, 'credit', 'cod_refund', 'admin_manual', 4837.00, 4847.00, 'COD Refund AWB: 77792019911', '2026-05-15 07:55:21', '2026-05-15 07:55:21'),
(1792, 36, 177, 9.00, 'debit', 'rto', 'admin_manual', 4847.00, 4838.00, 'RTO Charge AWB: 77792019911', '2026-05-15 07:55:21', '2026-05-15 07:55:21'),
(1793, 36, 207, 10.00, 'credit', 'cod_refund', 'admin_manual', 4838.00, 4848.00, 'COD Refund AWB: 77793101562', '2026-05-15 09:30:24', '2026-05-15 09:30:24'),
(1794, 36, 207, 9.00, 'debit', 'rto', 'admin_manual', 4848.00, 4839.00, 'RTO Charge AWB: 77793101562', '2026-05-15 09:30:24', '2026-05-15 09:30:24'),
(1795, 36, 230, 10.00, 'credit', 'cod_refund', 'admin_manual', 4839.00, 4849.00, 'COD Refund AWB: 37355837687730', '2026-05-16 03:10:12', '2026-05-16 03:10:12'),
(1796, 36, 230, 9.00, 'debit', 'rto', 'admin_manual', 4849.00, 4840.00, 'RTO Charge AWB: 37355837687730', '2026-05-16 03:10:12', '2026-05-16 03:10:12'),
(1797, 36, 201, 10.00, 'credit', 'cod_refund', 'admin_manual', 4840.00, 4850.00, 'COD Refund AWB: 37355837634051', '2026-05-16 05:50:10', '2026-05-16 05:50:10'),
(1798, 36, 201, 9.00, 'debit', 'rto', 'admin_manual', 4850.00, 4841.00, 'RTO Charge AWB: 37355837634051', '2026-05-16 05:50:10', '2026-05-16 05:50:10'),
(1799, 36, 219, 10.00, 'credit', 'cod_refund', 'admin_manual', 4841.00, 4851.00, 'COD Refund AWB: 77794325232', '2026-05-16 06:05:16', '2026-05-16 06:05:16'),
(1800, 36, 219, 9.00, 'debit', 'rto', 'admin_manual', 4851.00, 4842.00, 'RTO Charge AWB: 77794325232', '2026-05-16 06:05:16', '2026-05-16 06:05:16'),
(1801, 36, 174, 10.00, 'credit', 'cod_refund', 'admin_manual', 4842.00, 4852.00, 'COD Refund AWB: 77792076213', '2026-05-16 09:15:20', '2026-05-16 09:15:20'),
(1802, 36, 174, 9.00, 'debit', 'rto', 'admin_manual', 4852.00, 4843.00, 'RTO Charge AWB: 77792076213', '2026-05-16 09:15:20', '2026-05-16 09:15:20'),
(1803, 36, 255, 10.00, 'credit', 'cod_refund', 'admin_manual', 4843.00, 4853.00, 'COD Refund AWB: 37355837750634', '2026-05-17 01:30:12', '2026-05-17 01:30:12'),
(1804, 36, 255, 9.00, 'debit', 'rto', 'admin_manual', 4853.00, 4844.00, 'RTO Charge AWB: 37355837750634', '2026-05-17 01:30:12', '2026-05-17 01:30:12'),
(1805, 36, 240, 10.00, 'credit', 'cod_refund', 'admin_manual', 4844.00, 4854.00, 'COD Refund AWB: 37355837687634', '2026-05-17 03:45:10', '2026-05-17 03:45:10'),
(1806, 36, 240, 9.00, 'debit', 'rto', 'admin_manual', 4854.00, 4845.00, 'RTO Charge AWB: 37355837687634', '2026-05-17 03:45:10', '2026-05-17 03:45:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agreements`
--
ALTER TABLE `agreements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agreements_uploaded_by_foreign` (`uploaded_by`),
  ADD KEY `agreements_version_index` (`version`),
  ADD KEY `agreements_status_index` (`status`),
  ADD KEY `agreements_section_name_index` (`section_name`);

--
-- Indexes for table `agreement_acceptances`
--
ALTER TABLE `agreement_acceptances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agreement_acceptances_agreement_id_user_id_unique` (`agreement_id`,`user_id`),
  ADD KEY `agreement_acceptances_user_id_foreign` (`user_id`);

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_details_user_id_foreign` (`user_id`),
  ADD KEY `bank_details_verified_by_foreign` (`verified_by`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cod_remittance_payments`
--
ALTER TABLE `cod_remittance_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod_remittance_payments_user_id_index` (`user_id`),
  ADD KEY `cod_remittance_payments_order_id_index` (`order_id`),
  ADD KEY `cod_remittance_payments_status_index` (`status`);

--
-- Indexes for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_profiles_company_code_unique` (`company_code`),
  ADD KEY `company_profiles_seller_id_foreign` (`seller_id`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `couriers_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fship_orders`
--
ALTER TABLE `fship_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fship_orders_merchant_order_id_unique` (`merchant_order_id`),
  ADD KEY `fship_orders_user_id_foreign` (`user_id`),
  ADD KEY `fship_orders_waybill_index` (`waybill`);

--
-- Indexes for table `fship_order_items`
--
ALTER TABLE `fship_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fship_order_items_fship_order_id_foreign` (`fship_order_id`);

--
-- Indexes for table `fship_reverse_orders`
--
ALTER TABLE `fship_reverse_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fship_reverse_orders_reverse_waybill_unique` (`reverse_waybill`),
  ADD UNIQUE KEY `fship_reverse_orders_tracking_number_unique` (`tracking_number`),
  ADD KEY `fship_reverse_orders_original_waybill_index` (`original_waybill`),
  ADD KEY `fship_reverse_orders_seller_id_status_index` (`seller_id`,`status`),
  ADD KEY `fship_reverse_orders_reverse_waybill_seller_id_index` (`reverse_waybill`,`seller_id`),
  ADD KEY `fship_reverse_orders_pickup_pincode_index` (`pickup_pincode`),
  ADD KEY `fship_reverse_orders_forward_order_id_seller_id_index` (`forward_order_id`,`seller_id`);

--
-- Indexes for table `fship_reverse_order_items`
--
ALTER TABLE `fship_reverse_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fship_reverse_order_items_reverse_order_id_sku_index` (`reverse_order_id`,`sku`);

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
-- Indexes for table `kyc_details`
--
ALTER TABLE `kyc_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kyc_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `label_settings`
--
ALTER TABLE `label_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `label_settings_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ndr_logs`
--
ALTER TABLE `ndr_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ndr_logs_order_id_index` (`order_id`);

--
-- Indexes for table `ndr_management`
--
ALTER TABLE `ndr_management`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ndr_management_api_order_id_unique` (`api_order_id`),
  ADD KEY `ndr_management_waybill_number_index` (`waybill_number`);

--
-- Indexes for table `ndr_product_details`
--
ALTER TABLE `ndr_product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ndr_product_details_ndr_id_foreign` (`ndr_id`);

--
-- Indexes for table `ndr_tracking_history_logs`
--
ALTER TABLE `ndr_tracking_history_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ndr_tracking_history_logs_waybill_number_index` (`waybill_number`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pickup_addresses`
--
ALTER TABLE `pickup_addresses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pickup_addresses_user_id_warehouse_name_unique` (`user_id`,`warehouse_name`),
  ADD UNIQUE KEY `pickup_addresses_warehouse_name_unique` (`warehouse_name`),
  ADD KEY `pickup_addresses_pick_address_id_index` (`pick_address_ID`);

--
-- Indexes for table `rapidshyp_b2c_orders`
--
ALTER TABLE `rapidshyp_b2c_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rapidshyp_b2c_orders_order_id_unique` (`order_id`),
  ADD KEY `rapidshyp_b2c_orders_seller_id_order_status_index` (`seller_id`,`order_status`),
  ADD KEY `rapidshyp_b2c_orders_awb_index` (`awb`);

--
-- Indexes for table `rapidshyp_b2c_order_items`
--
ALTER TABLE `rapidshyp_b2c_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rapidshyp_b2c_order_items_rapidshyp_b2c_order_id_foreign` (`rapidshyp_b2c_order_id`);

--
-- Indexes for table `rapidshyp_rates`
--
ALTER TABLE `rapidshyp_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rapidshyp_rates_user_id_type_is_active_index` (`user_id`,`type`,`is_active`);

--
-- Indexes for table `rapidshyp_rto_addresses`
--
ALTER TABLE `rapidshyp_rto_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_seller_pincode` (`seller_id`,`rto_pincode`),
  ADD KEY `idx_rto_name` (`rto_address_name`),
  ADD KEY `idx_api_rto_id` (`rapidshyp_rto_name`);

--
-- Indexes for table `rapidshyp_serviceability_logs`
--
ALTER TABLE `rapidshyp_serviceability_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rapidshyp_serviceability_logs_seller_id_index` (`seller_id`),
  ADD KEY `rapidshyp_serviceability_logs_order_id_index` (`order_id`),
  ADD KEY `rapidshyp_serviceability_logs_created_at_index` (`created_at`);

--
-- Indexes for table `rapidshyp_warehouses`
--
ALTER TABLE `rapidshyp_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rapidshyp_warehouses_rto_address_id_foreign` (`rto_address_id`),
  ADD KEY `idx_seller_primary` (`seller_id`,`is_primary`),
  ADD KEY `idx_pincode` (`pincode`),
  ADD KEY `idx_api_id` (`rapidshyp_warehouse_id`);

--
-- Indexes for table `rto_addresses`
--
ALTER TABLE `rto_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rto_addresses_pickup_address_id_foreign` (`pickup_address_id`);

--
-- Indexes for table `seller_agreement_acceptances`
--
ALTER TABLE `seller_agreement_acceptances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_agreement_acceptances_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shipment_documents`
--
ALTER TABLE `shipment_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipment_documents_pickup_order_id_index` (`pickup_order_id`),
  ADD KEY `idx_pickup_status_id` (`pickup_status_id`),
  ADD KEY `idx_pickup_status` (`pickup_status`);

--
-- Indexes for table `shipping_labels`
--
ALTER TABLE `shipping_labels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shipping_labels_label_number_unique` (`label_number`),
  ADD KEY `shipping_labels_fship_order_id_foreign` (`fship_order_id`),
  ADD KEY `shipping_labels_user_id_index` (`user_id`);

--
-- Indexes for table `shipping_rates_mini`
--
ALTER TABLE `shipping_rates_mini`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_courier_mode` (`user_id`,`courier_id`,`mode`),
  ADD KEY `idx_user_mode` (`user_id`,`mode`),
  ADD KEY `idx_courier` (`courier_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_ticket_number_unique` (`ticket_number`),
  ADD KEY `tickets_user_id_status_index` (`user_id`,`status`),
  ADD KEY `tickets_ticket_number_index` (`ticket_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_user_code_unique` (`user_code`);

--
-- Indexes for table `vendor_addresses`
--
ALTER TABLE `vendor_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_addresses_pickup_address_id_foreign` (`pickup_address_id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallets_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallet_recharges`
--
ALTER TABLE `wallet_recharges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_recharges_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_transactions_user_id_foreign` (`user_id`),
  ADD KEY `wallet_transactions_fship_order_id_foreign` (`fship_order_id`),
  ADD KEY `wallet_transactions_source_index` (`source`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agreements`
--
ALTER TABLE `agreements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `agreement_acceptances`
--
ALTER TABLE `agreement_acceptances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cod_remittance_payments`
--
ALTER TABLE `cod_remittance_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `company_profiles`
--
ALTER TABLE `company_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fship_orders`
--
ALTER TABLE `fship_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT for table `fship_order_items`
--
ALTER TABLE `fship_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=304;

--
-- AUTO_INCREMENT for table `fship_reverse_orders`
--
ALTER TABLE `fship_reverse_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fship_reverse_order_items`
--
ALTER TABLE `fship_reverse_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kyc_details`
--
ALTER TABLE `kyc_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `label_settings`
--
ALTER TABLE `label_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `ndr_logs`
--
ALTER TABLE `ndr_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ndr_management`
--
ALTER TABLE `ndr_management`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `ndr_product_details`
--
ALTER TABLE `ndr_product_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ndr_tracking_history_logs`
--
ALTER TABLE `ndr_tracking_history_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `pickup_addresses`
--
ALTER TABLE `pickup_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `rapidshyp_b2c_orders`
--
ALTER TABLE `rapidshyp_b2c_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rapidshyp_b2c_order_items`
--
ALTER TABLE `rapidshyp_b2c_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rapidshyp_rates`
--
ALTER TABLE `rapidshyp_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rapidshyp_rto_addresses`
--
ALTER TABLE `rapidshyp_rto_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rapidshyp_serviceability_logs`
--
ALTER TABLE `rapidshyp_serviceability_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rapidshyp_warehouses`
--
ALTER TABLE `rapidshyp_warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rto_addresses`
--
ALTER TABLE `rto_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `seller_agreement_acceptances`
--
ALTER TABLE `seller_agreement_acceptances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipment_documents`
--
ALTER TABLE `shipment_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `shipping_labels`
--
ALTER TABLE `shipping_labels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_rates_mini`
--
ALTER TABLE `shipping_rates_mini`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `vendor_addresses`
--
ALTER TABLE `vendor_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `wallet_recharges`
--
ALTER TABLE `wallet_recharges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1807;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agreements`
--
ALTER TABLE `agreements`
  ADD CONSTRAINT `agreements_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `agreement_acceptances`
--
ALTER TABLE `agreement_acceptances`
  ADD CONSTRAINT `agreement_acceptances_agreement_id_foreign` FOREIGN KEY (`agreement_id`) REFERENCES `agreements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agreement_acceptances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD CONSTRAINT `bank_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bank_details_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD CONSTRAINT `company_profiles_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fship_orders`
--
ALTER TABLE `fship_orders`
  ADD CONSTRAINT `fship_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fship_order_items`
--
ALTER TABLE `fship_order_items`
  ADD CONSTRAINT `fship_order_items_fship_order_id_foreign` FOREIGN KEY (`fship_order_id`) REFERENCES `fship_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fship_reverse_orders`
--
ALTER TABLE `fship_reverse_orders`
  ADD CONSTRAINT `fship_reverse_orders_forward_order_id_foreign` FOREIGN KEY (`forward_order_id`) REFERENCES `fship_orders` (`merchant_order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fship_reverse_orders_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fship_reverse_order_items`
--
ALTER TABLE `fship_reverse_order_items`
  ADD CONSTRAINT `fship_reverse_order_items_reverse_order_id_foreign` FOREIGN KEY (`reverse_order_id`) REFERENCES `fship_reverse_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kyc_details`
--
ALTER TABLE `kyc_details`
  ADD CONSTRAINT `kyc_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `label_settings`
--
ALTER TABLE `label_settings`
  ADD CONSTRAINT `label_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ndr_logs`
--
ALTER TABLE `ndr_logs`
  ADD CONSTRAINT `ndr_logs_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `fship_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ndr_product_details`
--
ALTER TABLE `ndr_product_details`
  ADD CONSTRAINT `ndr_product_details_ndr_id_foreign` FOREIGN KEY (`ndr_id`) REFERENCES `ndr_management` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pickup_addresses`
--
ALTER TABLE `pickup_addresses`
  ADD CONSTRAINT `pickup_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rapidshyp_b2c_orders`
--
ALTER TABLE `rapidshyp_b2c_orders`
  ADD CONSTRAINT `rapidshyp_b2c_orders_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rapidshyp_b2c_order_items`
--
ALTER TABLE `rapidshyp_b2c_order_items`
  ADD CONSTRAINT `rapidshyp_b2c_order_items_rapidshyp_b2c_order_id_foreign` FOREIGN KEY (`rapidshyp_b2c_order_id`) REFERENCES `rapidshyp_b2c_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rapidshyp_rates`
--
ALTER TABLE `rapidshyp_rates`
  ADD CONSTRAINT `rapidshyp_rates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rapidshyp_rto_addresses`
--
ALTER TABLE `rapidshyp_rto_addresses`
  ADD CONSTRAINT `rapidshyp_rto_addresses_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rapidshyp_serviceability_logs`
--
ALTER TABLE `rapidshyp_serviceability_logs`
  ADD CONSTRAINT `rapidshyp_serviceability_logs_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `rapidshyp_b2c_orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rapidshyp_serviceability_logs_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rapidshyp_warehouses`
--
ALTER TABLE `rapidshyp_warehouses`
  ADD CONSTRAINT `rapidshyp_warehouses_rto_address_id_foreign` FOREIGN KEY (`rto_address_id`) REFERENCES `rapidshyp_rto_addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `rapidshyp_warehouses_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rto_addresses`
--
ALTER TABLE `rto_addresses`
  ADD CONSTRAINT `rto_addresses_pickup_address_id_foreign` FOREIGN KEY (`pickup_address_id`) REFERENCES `pickup_addresses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seller_agreement_acceptances`
--
ALTER TABLE `seller_agreement_acceptances`
  ADD CONSTRAINT `seller_agreement_acceptances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_labels`
--
ALTER TABLE `shipping_labels`
  ADD CONSTRAINT `shipping_labels_fship_order_id_foreign` FOREIGN KEY (`fship_order_id`) REFERENCES `fship_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_rates_mini`
--
ALTER TABLE `shipping_rates_mini`
  ADD CONSTRAINT `fk_shipping_courier` FOREIGN KEY (`courier_id`) REFERENCES `couriers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shipping_rates_mini_courier_id_foreign` FOREIGN KEY (`courier_id`) REFERENCES `couriers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shipping_rates_mini_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_addresses`
--
ALTER TABLE `vendor_addresses`
  ADD CONSTRAINT `vendor_addresses_pickup_address_id_foreign` FOREIGN KEY (`pickup_address_id`) REFERENCES `pickup_addresses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_recharges`
--
ALTER TABLE `wallet_recharges`
  ADD CONSTRAINT `wallet_recharges_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_fship_order_id_foreign` FOREIGN KEY (`fship_order_id`) REFERENCES `fship_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wallet_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
