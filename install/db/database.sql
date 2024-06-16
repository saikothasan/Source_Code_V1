-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 27, 2023 at 08:36 AM
-- Server version: 10.6.12-MariaDB-0ubuntu0.22.10.1
-- PHP Version: 8.1.7-1ubuntu3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `installcp`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance_transfers`
--

CREATE TABLE `balance_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(10) NOT NULL,
  `type` varchar(15) NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `note` mediumtext DEFAULT NULL,
  `amount` double(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `account_no` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transfer_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `amount` double(10,2) NOT NULL DEFAULT 0.00,
  `is_main_bank` tinyint(1) NOT NULL DEFAULT 0,
  `branch_id` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks_transfers`
--

CREATE TABLE `banks_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_bank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_bank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid` double DEFAULT NULL,
  `due` double DEFAULT NULL,
  `reference_id` varchar(255) NOT NULL,
  `connect_id` varchar(255) DEFAULT NULL,
  `referance_invoice` varchar(255) NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `current_branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Pending,1=Received,2=Reject',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cash_id` bigint(20) UNSIGNED DEFAULT NULL,
  `money_transfer_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_transactions`
--

CREATE TABLE `bank_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `due_collection` tinyint(4) NOT NULL DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `date` varchar(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `amount` double(11,2) NOT NULL,
  `due` double(11,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `phone_number` longtext DEFAULT NULL,
  `is_main_branch` tinyint(1) NOT NULL DEFAULT 0,
  `weekend` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `open_time` varchar(255) DEFAULT NULL,
  `close_time` varchar(255) DEFAULT NULL,
  `working_hour` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `over_time_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_payment_methods`
--

CREATE TABLE `branch_payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_balance` double(10,2) NOT NULL DEFAULT 0.00,
  `transfer_balance` double(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_payment_method_histories`
--

CREATE TABLE `branch_payment_method_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `invoice_reference` varchar(255) DEFAULT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_exchange_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_number` varchar(255) DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `pay_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `payable_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `return_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashes`
--

CREATE TABLE `cashes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(10) NOT NULL,
  `amount` double(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `in_cacsh` varchar(255) DEFAULT NULL,
  `transfer` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `bank_id` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_drawers`
--

CREATE TABLE `cash_drawers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` double(11,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_histories`
--

CREATE TABLE `cash_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_exchange_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cash_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cost_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `current_branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cash_type` tinyint(4) DEFAULT NULL COMMENT '0=Cash In,1=Payment,2=Transfer',
  `status` tinyint(4) DEFAULT NULL COMMENT '0=Transferring,0=Receiving,1=Transfer,1=Receive,2=Reject',
  `note` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `amount` double(11,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `money_transfer_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `costs`
--

CREATE TABLE `costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cost_type` varchar(255) DEFAULT NULL,
  `cost_category` varchar(255) DEFAULT NULL,
  `amount` decimal(11,2) NOT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cost_branch_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `asset_branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Afghanistan', '+93', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(2, 'Albania', '+355', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(3, 'Algeria', '+213', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(4, 'Andorra', '+376', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(5, 'Angola', '+244', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(6, 'Antigua and Barbuda', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(7, 'Argentina', '+54', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(8, 'Armenia', '+374', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(9, 'Australia', '+61', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(10, 'Austria', '+43', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(11, 'Azerbaijan', '+994', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(12, 'Bahamas', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(13, 'Bahrain', '+973', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(14, 'Bangladesh', '+880', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(15, 'Barbados', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(16, 'Belarus', '+375', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(17, 'Belgium', '+32', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(18, 'Belize', '+501', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(19, 'Benin', '+229', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(20, 'Bhutan', '+975', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(21, 'Bolivia', '+591', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(22, 'Bosnia and Herzegovina', '+387', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(23, 'Botswana', '+267', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(24, 'Brazil', '+55', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(25, 'Brunei', '+673', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(26, 'Bulgaria', '+359', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(27, 'Burkina Faso', '+226', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(28, 'Burundi', '+257', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(29, 'Côte d\'Ivoire', '+225', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(30, 'Cabo Verde', '+238', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(31, 'Cambodia', '+855', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(32, 'Cameroon', '+237', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(33, 'Canada', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(34, 'Central African Republic', '+236', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(35, 'Chad', '+235', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(36, 'Chile', '+56', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(37, 'China', '+86', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(38, 'Colombia', '+57', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(39, 'Comoros', '+269', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(40, 'Congo (Congo-Brazzaville)', '+242', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(41, 'Costa Rica', '+506', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(42, 'Croatia', '+385', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(43, 'Cuba', '+53', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(44, 'Cyprus', '+357', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(45, 'Czechia (Czech Republic)', '+420', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(46, 'Democratic Republic of the Congo', '+243', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(47, 'Denmark', '+45', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(48, 'Djibouti', '+253', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(49, 'Dominica', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(50, 'Dominican Republic', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(51, 'Ecuador', '+593', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(52, 'Egypt', '+20', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(53, 'El Salvador', '+503', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(54, 'Equatorial Guinea', '+240', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(55, 'Eritrea', '+291', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(56, 'Estonia', '+372', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(57, 'Eswatini', '+268', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(58, 'Ethiopia', '+251', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(59, 'Fiji', '+679', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(60, 'Finland', '+358', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(61, 'France', '+33', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(62, 'Gabon', '+241', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(63, 'Gambia', '+220', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(64, 'Georgia', '+995', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(65, 'Germany', '+49', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(66, 'Ghana', '+233', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(67, 'Greece', '+30', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(68, 'Grenada', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(69, 'Guatemala', '+502', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(70, 'Guinea', '+224', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(71, 'Guinea-Bissau', '+245', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(72, 'Guyana', '+592', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(73, 'Haiti', '+509', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(74, 'Holy See', '+379', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(75, 'Honduras', '+504', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(76, 'Hungary', '+36', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(77, 'Iceland', '+354', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(78, 'India', '+91', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(79, 'Indonesia', '+62', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(80, 'Iran', '+98', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(81, 'Iraq', '+964', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(82, 'Ireland', '+353', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(83, 'Israel', '+972', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(84, 'Italy', '+39', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(85, 'Jamaica', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(86, 'Japan', '+81', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(87, 'Jordan', '+962', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(88, 'Kazakhstan', '+7', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(89, 'Kenya', '+254', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(90, 'Kiribati', '+686', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(91, 'Kuwait', '+965', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(92, 'Kyrgyzstan', '+996', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(93, 'Laos', '+856', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(94, 'Latvia', '+371', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(95, 'Lebanon', '+961', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(96, 'Lesotho', '+266', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(97, 'Liberia', '+231', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(98, 'Libya', '+218', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(99, 'Liechtenstein', '+423', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(100, 'Lithuania', '+370', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(101, 'Luxembourg', '+352', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(102, 'Madagascar', '+261', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(103, 'Malawi', '+265', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(104, 'Malaysia', '+60', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(105, 'Maldives', '+960', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(106, 'Mali', '+223', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(107, 'Malta', '+356', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(108, 'Marshall Islands', '+692', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(109, 'Mauritania', '+222', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(110, 'Mauritius', '+230', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(111, 'Mexico', '+52', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(112, 'Micronesia', '+691', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(113, 'Moldova', '+373', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(114, 'Monaco', '+377', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(115, 'Mongolia', '+976', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(116, 'Montenegro', '+382', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(117, 'Morocco', '+212', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(118, 'Mozambique', '+258', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(119, 'Myanmar (formerly Burma)', '+95', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(120, 'Namibia', '+264', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(121, 'Nauru', '+674', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(122, 'Nepal', '+977', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(123, 'Netherlands', '+31', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(124, 'New Zealand', '+64', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(125, 'Nicaragua', '+505', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(126, 'Niger', '+227', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(127, 'Nigeria', '+234', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(128, 'North Korea', '+850', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(129, 'North Macedonia', '+389', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(130, 'Norway', '+47', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(131, 'Oman', '+968', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(132, 'Pakistan', '+92', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(133, 'Palau', '+680', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(134, 'Palestine State', '+970', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(135, 'Panama', '+507', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(136, 'Papua New Guinea', '+675', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(137, 'Paraguay', '+595', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(138, 'Peru', '+51', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(139, 'Philippines', '+63', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(140, 'Poland', '+48', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(141, 'Portugal', '+351', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(142, 'Qatar', '+974', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(143, 'Romania', '+40', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(144, 'Russia', '+7', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(145, 'Rwanda', '+250', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(146, 'Saint Kitts and Nevis', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(147, 'Saint Lucia', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(148, 'Saint Vincent and the Grenadines', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(149, 'Samoa', '+685', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(150, 'San Marino', '+378', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(151, 'Sao Tome and Principe', '+239', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(152, 'Saudi Arabia', '+966', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(153, 'Senegal', '+221', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(154, 'Serbia', '+381', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(155, 'Seychelles', '+248', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(156, 'Sierra Leone', '+232', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(157, 'Singapore', '+65', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(158, 'Slovakia', '+421', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(159, 'Slovenia', '+386', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(160, 'Solomon Islands', '+677', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(161, 'Somalia', '+252', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(162, 'South Africa', '+27', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(163, 'South Korea', '+82', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(164, 'South Sudan', '+211', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(165, 'Spain', '+34', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(166, 'Sri Lanka', '+94', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(167, 'Sudan', '+249', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(168, 'Suriname', '+597', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(169, 'Sweden', '+46', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(170, 'Switzerland', '+41', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(171, 'Syria', '+963', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(172, 'Tajikistan', '+992', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(173, 'Tanzania', '+255', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(174, 'Thailand', '+66', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(175, 'Timor-Leste', '+670', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(176, 'Togo', '+228', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(177, 'Tonga', '+676', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(178, 'Trinidad and Tobago', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(179, 'Tunisia', '+216', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(180, 'Turkey', '+90', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(181, 'Turkmenistan', '+993', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(182, 'Tuvalu', '+688', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(183, 'Uganda', '+256', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(184, 'Ukraine', '+380', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(185, 'United Arab Emirates', '+971', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(186, 'United Kingdom', '+44', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(187, 'United States of America', '+1', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(188, 'Uruguay', '+598', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(189, 'Uzbekistan', '+998', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(190, 'Vanuatu', '+678', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(191, 'Venezuela', '+58', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(192, 'Vietnam', '+84', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(193, 'Yemen', '+967', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(194, 'Zambia', '+260', '2021-03-04 09:22:09', '2021-03-04 09:22:09'),
(195, 'Zimbabwe', '+263', '2021-03-04 09:22:09', '2021-03-04 09:22:09');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `area` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `credit_limit` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `card_id` bigint(20) DEFAULT NULL,
  `district_id` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `forget_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_addresses`
--

CREATE TABLE `delivery_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_men`
--

CREATE TABLE `delivery_men` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `nid` varchar(255) NOT NULL,
  `delivery_charge` int(11) NOT NULL DEFAULT 0,
  `address` longtext NOT NULL,
  `delivery_area` longtext NOT NULL,
  `photo` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `employee_tag` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `designation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `join_date` date NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nationality_id` varchar(255) DEFAULT NULL,
  `religion_id` tinyint(4) DEFAULT NULL,
  `nid_number` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `salary` int(11) NOT NULL,
  `basic_salary` double(8,2) DEFAULT NULL,
  `other_salary` double(8,2) DEFAULT NULL,
  `salary_review` int(11) DEFAULT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `guardian_phone` varchar(255) DEFAULT NULL,
  `guardian_email` varchar(255) DEFAULT NULL,
  `guardian_address` varchar(255) DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `weekend` varchar(255) NOT NULL DEFAULT 'Fri'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `invests`
--

CREATE TABLE `invests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_due_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` varchar(10) NOT NULL,
  `note` mediumtext DEFAULT NULL,
  `type` varchar(14) NOT NULL,
  `amount` double(11,2) NOT NULL,
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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_11_04_050652_create_permission_tables', 1),
(5, '2020_11_09_082625_create_products_table', 1),
(6, '2020_11_09_082728_create_categories_table', 1),
(7, '2020_11_09_082749_create_customers_table', 1),
(8, '2020_11_09_082835_create_suppliers_table', 1),
(11, '2020_11_09_083429_create_sales_table', 1),
(13, '2020_11_09_083800_create_purchase_returns_table', 1),
(15, '2020_11_09_083839_create_units_table', 1),
(16, '2020_11_09_084136_create_purchase_details_table', 1),
(17, '2020_11_09_084205_create_sale_details_table', 1),
(19, '2020_11_25_111037_create_sale_due_collections_table', 1),
(20, '2020_11_25_111102_create_purchase_due_collections_table', 1),
(21, '2020_11_26_122338_create_cashes_table', 1),
(22, '2020_11_26_122348_create_stocks_table', 1),
(24, '2020_11_27_150915_create_invests_table', 1),
(25, '2020_11_28_114112_create_owners_table', 1),
(26, '2020_12_03_134711_create_balance_transfers_table', 1),
(27, '2020_12_05_184103_create_salaries_table', 1),
(28, '2020_12_06_115818_create_product_transfers_table', 1),
(29, '2020_12_07_194643_create_product_returns_table', 1),
(30, '2020_11_09_083010_create_purchases_table', 2),
(31, '2020_11_09_083400_create_purchase_payments_table', 2),
(32, '2020_12_11_002310_create_departments_table', 3),
(33, '2020_12_11_002320_carete_employees_table', 3),
(34, '2020_12_11_003900_create_loan_advances_table', 3),
(36, '2020_12_11_010818_create_months_table', 3),
(37, '2021_02_27_145933_create_quotations_table', 4),
(38, '2021_02_27_150347_create_quotation_details_table', 4),
(39, '2022_04_10_105143_create_sizes_table', 5),
(40, '2022_04_10_112653_add_size_id_to_products_table', 5),
(41, '2022_04_13_102416_create_user_cards_table', 5),
(42, '2022_04_13_105518_add_card_id_to_customers_table', 5),
(43, '2022_06_06_145345_create_delivery_men_table', 6),
(44, '2022_06_07_005604_add_cacsh_to_cashes', 6),
(45, '2022_06_07_013648_add_delivary_to_sales_table', 6),
(46, '2022_06_07_122259_add_supplier_id_table', 6),
(47, '2022_06_07_123221_add_purchase_supplier_id_table', 6),
(48, '2022_06_07_143938_add_user_id_table', 6),
(51, '2022_07_27_103656_create_payment_methods_table', 7),
(52, '2022_06_11_161424_add_sale_payment_column', 8),
(53, '2022_06_11_161541_add_payment_reference_column', 8),
(55, '2022_06_18_101648_create_variations_table', 9),
(56, '2022_06_18_160803_create_brands_table', 9),
(57, '2022_06_21_181204_add_more_column_to_products_table', 9),
(58, '2022_06_22_113603_create_product_options_table', 9),
(59, '2022_06_22_114005_create_product_variant_sku_barcodes_table', 9),
(60, '2022_06_22_114218_create_product_variant_values_table', 9),
(169, '2022_06_30_083010_create_purchases_table', 10),
(170, '2022_06_30_083020_create_purchase_details_table', 10),
(171, '2022_06_30_083030_create_stocks_table', 10),
(172, '2022_06_30_083400_create_purchase_payments_table', 10),
(173, '2022_06_30_083800_create_purchase_returns_table', 10),
(185, '2022_06_30_111102_create_purchase_dues_table', 11),
(186, '2022_07_03_111948_add_column_to_users_table', 11),
(187, '2022_07_03_113225_create_user_branches_table', 11),
(188, '2022_07_03_154412_create_designations_table', 11),
(189, '2022_07_03_154413_create_branches_table', 11),
(190, '2022_07_03_154414_create_suppliers_table', 11),
(191, '2022_07_04_153447_create_transfer_receives_table', 11),
(192, '2022_07_04_153458_create_transfer_receive_details_table', 11),
(193, '2022_07_05_012744_create_settings_table', 11),
(195, '2022_07_05_102420_add_more_field_customer_table', 11),
(202, '2022_07_07_083429_create_sales_table', 12),
(203, '2022_07_07_083430_create_sale_details_table', 12),
(206, '2022_07_14_014130_create_sessions_table', 12),
(208, '2022_07_07_083704_create_sale_payments_table', 14),
(212, '2022_07_19_153200_create_sale_payment_histories_table', 14),
(217, '2018_08_08_100000_create_telescope_entries_table', 15),
(218, '2020_11_26_235937_create_bank_transactions_table', 15),
(219, '2022_07_16_133255_create_costs_table', 15),
(220, '2022_07_17_153624_create_banks_table', 15),
(221, '2022_07_19_083401_create_purchase_payment_invoices_table', 15),
(222, '2022_07_19_153201_create_sale_returns_table', 15),
(223, '2022_07_19_170256_create_sale_return_details_table', 15),
(224, '2022_07_19_170316_create_sale_exchanges_table', 16),
(225, '2022_07_23_132543_create_cash_drawers_table', 16),
(226, '2022_07_25_133240_create_sale_deliveries_table', 16),
(227, '2022_07_26_135815_create_cash_histories_table', 16),
(228, '2022_07_27_083400_create_purchase_payments_table', 17),
(230, '2022_07_28_091247_add_more_field_in_payment_method', 18),
(232, '2022_07_28_151404_create_money_transfers_table', 19),
(233, '2022_07_30_125433_create_branch_payment_methods_table', 19),
(234, '2022_07_30_151404_create_banks_table', 19),
(236, '2022_07_30_180207_create_branch_payment_method_histories_table', 20),
(239, '2022_08_01_164323_create_jobs_table', 22),
(240, '2022_07_30_151405_bank_transfer', 23),
(241, '2022_07_31_104600_add_more_field_on_bank_transfer', 23),
(242, '2022_08_03_100541_add_more_field_in_banks_transfers', 23),
(243, '2022_08_03_162323_add_more_field_in_bank_transfers', 23),
(244, '2022_08_03_162345_add_more_field_in_bank_transfers', 23),
(247, '2022_08_06_083800_create_purchase_returns_table', 24),
(248, '2022_08_06_122359_create_purchase_return_products_table', 24),
(249, '2022_08_07_142623_add_reciever_branch_id_in_cash_histories', 24),
(250, '2022_08_07_144229_add_current_branch_id_in_banks_transfer', 24),
(251, '2022_08_11_125633_add_field_on_cash_histories', 25),
(252, '2022_08_12_105430_add_column_to_purchases_table', 25),
(253, '2022_08_13_105544_add_supplier_to_transfer_receives_table', 25),
(254, '2022_08_14_160536_create_reports_table', 26),
(255, '2022_08_20_105151_create_sale_return_purchase_histories_table', 27),
(256, '2022_08_20_133424_add_cost_id_to_cash_histories_table', 28),
(257, '2022_08_29_131642_add_delivery_additional_field_to_sales_table', 29),
(258, '2022_08_29_131941_add_delivery_additional_field_to_sale_deliveries_table', 29),
(259, '2022_08_29_132040_add_delivery_additional_field_to_sale_exchanges_table', 29),
(260, '2022_08_30_142952_add_cost_branch_id_to_costs_table', 30),
(261, '2022_08_31_095051_add_field_to_purchase_payments_table', 31),
(262, '2022_09_01_101954_add_total_amount_to_purchase_dues_table', 32),
(263, '2022_09_01_103603_add_sell_price_to_purchase_details_table', 32),
(264, '2022_09_06_143803_add_price_to_stocks_table', 33),
(265, '2022_10_13_112457_create_product_images_table', 34),
(266, '2022_10_17_155109_add_type_to_products', 34),
(267, '2019_12_14_000001_create_personal_access_tokens_table', 35),
(268, '2022_08_27_044652_add_more_field_to_employees', 36),
(269, '2022_09_10_032233_create_leaves_table', 36),
(270, '2022_09_11_054125_create_loans_table', 36),
(271, '2022_09_27_035213_add_working_hours_in_branches', 36),
(272, '2022_09_28_113409_create_transfer_employees_table', 36),
(273, '2022_10_02_051201_create_messages_table', 36),
(274, '2022_10_10_104759_create_devices_table', 36),
(275, '2022_10_11_105207_add_branch_id_to_departments_table', 36),
(276, '2022_10_11_105249_add_department_id_to_designations_table', 36),
(277, '2022_10_11_143828_create_notices_table', 36),
(278, '2022_10_11_154408_add_employee_id_to_users_table', 36),
(279, '2022_10_20_124203_create_device_users_table', 36),
(280, '2022_10_20_165627_create_attendances_table', 36),
(281, '2022_10_31_114600_create_employee_loans_table', 37),
(282, '2022_10_31_134625_create_loan_payments_table', 37),
(283, '2022_10_31_032233_create_leave_setting_table', 38),
(284, '2022_10_31_125636_create_notice_comments_table', 38),
(286, '2022_11_05_130448_create_leave_applications_table', 39),
(287, '2022_11_05_160341_add_holidays_in_leave_setting', 39),
(288, '2022_11_06_102658_leave_document', 39),
(289, '2022_11_08_123040_add_weekend_to_employees', 40),
(291, '2022_11_08_145532_create_weekend_transfers_table', 41),
(292, '2022_10_25_145423_create_offers_table', 42),
(293, '2022_10_25_145555_create_offer_products_table', 42),
(294, '2022_10_30_161729_add_parent_id_to_category', 42),
(295, '2022_11_06_104751_create_ecommercesliders_table', 42),
(296, '2022_11_07_150548_delete_columns_from_offer', 42),
(297, '2022_11_08_130635_changes_in_offer_products_table', 42),
(298, '2022_11_09_105050_add_colums_in_offer', 42),
(299, '2022_11_09_125132_add_colums_in_offer_products', 42),
(300, '2022_11_09_145928_change_colum_in_offer', 42),
(301, '2022_11_12_084524_add_up_to_in_offer_products', 42),
(302, '2022_11_13_151652_add_combo_code_in_offers', 42),
(303, '2022_11_17_114312_add_product_type_in_offer_products', 42),
(304, '2022_11_22_100926_add_remember_token_customers', 42),
(305, '2022_11_26_132104_create_wishlists_table', 42),
(306, '2022_11_27_144810_create_frontend_settings_table', 42),
(307, '2022_11_30_120736_create_contact_us_table', 42),
(308, '2022_12_04_113944_add_forget_password_to_customers', 42),
(309, '2022_11_06_104778_create_ecommercesliders_table', 43),
(310, '2022_12_19_131759_create_news_table', 44),
(311, '2022_12_21_124917_create_notifications_table', 45),
(312, '2022_12_21_124918_create_notifications_table', 46),
(313, '2022_12_26_164951_add_column_late_time_to_attendances', 47),
(316, '2023_01_01_103716_create_shipping_addresses_table', 48),
(317, '2023_01_04_151307_create_delivery_addresses_table', 49),
(318, '2023_01_04_171046_create_orders_table', 50),
(319, '2023_01_04_171203_create_order_details_table', 50),
(320, '2023_01_07_134224_add_variation_id_in_product_images', 51),
(321, '2023_02_26_102650_add_and_change_column_in_offer', 51),
(322, '2023_02_27_163811_add_offer_column_in_stock', 51),
(323, '2023_03_02_100230_add_offer_column_in_offers', 51),
(324, '2023_03_07_160814_add_offer_column_in_offers', 51),
(325, '2023_03_08_103009_add_combo_offer_column_in_offers', 51),
(326, '2023_03_08_144732_change_columns_in_offer_details', 51),
(327, '2023_03_12_125501_add_profit_price_in_offer_products', 51),
(328, '2023_03_14_115248_chnage_buy_products_and_get_products', 51);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Model\\User', 1),
(1, 'App\\Model\\User', 8),
(1, 'App\\Model\\User', 11),
(1, 'App\\Model\\User', 12),
(1, 'App\\Model\\User', 13),
(1, 'App\\Model\\User', 14),
(1, 'App\\Model\\User', 15),
(1, 'App\\Model\\User', 16),
(1, 'App\\Model\\User', 17),
(1, 'App\\Model\\User', 19),
(1, 'App\\Model\\User', 20),
(1, 'App\\Model\\User', 21),
(1, 'App\\Model\\User', 23),
(1, 'App\\Model\\User', 24),
(1, 'App\\Model\\User', 25),
(1, 'App\\Model\\User', 27),
(1, 'App\\Model\\User', 28),
(2, 'App\\Model\\User', 7),
(2, 'App\\Model\\User', 8),
(2, 'App\\Model\\User', 11),
(2, 'App\\Model\\User', 12),
(2, 'App\\Model\\User', 13),
(2, 'App\\Model\\User', 14),
(2, 'App\\Model\\User', 15),
(2, 'App\\Model\\User', 16),
(2, 'App\\Model\\User', 17),
(2, 'App\\Model\\User', 19),
(2, 'App\\Model\\User', 20),
(2, 'App\\Model\\User', 21),
(2, 'App\\Model\\User', 23),
(2, 'App\\Model\\User', 24),
(2, 'App\\Model\\User', 25),
(2, 'App\\Model\\User', 27),
(2, 'App\\Model\\User', 28),
(2, 'App\\Model\\User', 39),
(3, 'App\\Model\\User', 7),
(4, 'App\\Model\\User', 8),
(4, 'App\\Model\\User', 11),
(4, 'App\\Model\\User', 16),
(4, 'App\\Model\\User', 17),
(4, 'App\\Model\\User', 27),
(7, 'App\\Model\\User', 8),
(7, 'App\\Model\\User', 16),
(7, 'App\\Model\\User', 17),
(8, 'App\\Model\\User', 8),
(8, 'App\\Model\\User', 11),
(8, 'App\\Model\\User', 16),
(8, 'App\\Model\\User', 27),
(8, 'App\\Model\\User', 28),
(9, 'App\\Model\\User', 8),
(9, 'App\\Model\\User', 11),
(9, 'App\\Model\\User', 16),
(9, 'App\\Model\\User', 17),
(9, 'App\\Model\\User', 19),
(9, 'App\\Model\\User', 20),
(9, 'App\\Model\\User', 21),
(9, 'App\\Model\\User', 23),
(9, 'App\\Model\\User', 24),
(9, 'App\\Model\\User', 25),
(9, 'App\\Model\\User', 27),
(9, 'App\\Model\\User', 28),
(10, 'App\\Model\\User', 28),
(12, 'App\\Model\\User', 8),
(12, 'App\\Model\\User', 11),
(12, 'App\\Model\\User', 23),
(12, 'App\\Model\\User', 27),
(12, 'App\\Model\\User', 28),
(12, 'App\\Model\\User', 39),
(16, 'App\\Model\\User', 8),
(16, 'App\\Model\\User', 11),
(19, 'App\\Model\\User', 28),
(22, 'App\\Model\\User', 1),
(22, 'App\\Model\\User', 9),
(22, 'App\\Model\\User', 10),
(22, 'App\\Model\\User', 18),
(22, 'App\\Model\\User', 29),
(22, 'App\\Model\\User', 31),
(22, 'App\\Model\\User', 39),
(22, 'App\\Model\\User', 42);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Model\\User', 1),
(1, 'App\\Model\\User', 8),
(1, 'App\\Model\\User', 9),
(1, 'App\\Model\\User', 10),
(1, 'App\\Model\\User', 11),
(1, 'App\\Model\\User', 18),
(1, 'App\\Model\\User', 21),
(1, 'App\\Model\\User', 23),
(1, 'App\\Model\\User', 28),
(1, 'App\\Model\\User', 31),
(1, 'App\\Model\\User', 39),
(2, 'App\\Model\\User', 12),
(2, 'App\\Model\\User', 13),
(2, 'App\\Model\\User', 14),
(2, 'App\\Model\\User', 15),
(2, 'App\\Model\\User', 16),
(2, 'App\\Model\\User', 17),
(2, 'App\\Model\\User', 19),
(2, 'App\\Model\\User', 20),
(2, 'App\\Model\\User', 21),
(2, 'App\\Model\\User', 22),
(2, 'App\\Model\\User', 23),
(2, 'App\\Model\\User', 24),
(2, 'App\\Model\\User', 25),
(2, 'App\\Model\\User', 27),
(2, 'App\\Model\\User', 28),
(3, 'App\\Model\\User', 5),
(3, 'App\\Model\\User', 6),
(3, 'App\\Model\\User', 7),
(3, 'App\\Model\\User', 26),
(3, 'App\\Model\\User', 29),
(3, 'App\\Model\\User', 30),
(4, 'App\\Model\\User', 42);

-- --------------------------------------------------------

--
-- Table structure for table `money_transfers`
--

CREATE TABLE `money_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `current_branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receive_type` varchar(255) DEFAULT NULL,
  `cash_drawer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bank_account_no` bigint(20) UNSIGNED DEFAULT NULL,
  `available_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `transfer_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `remaining_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=Transfer,1=Receive,2=Reject',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `money_transfers`
--

INSERT INTO `money_transfers` (`id`, `date`, `payment_method_id`, `current_branch_id`, `receiver_branch_id`, `receive_type`, `cash_drawer_id`, `bank_id`, `bank_account_no`, `available_amount`, `transfer_amount`, `remaining_amount`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '2023-05-25', 2, 1, 1, 'Cash Drawer', 2, NULL, NULL, 1161.00, 1000.00, 161.00, 0, 1, NULL, '2023-05-25 06:13:43', '2023-05-25 06:13:43');

-- --------------------------------------------------------

--
-- Table structure for table `months`
--

CREATE TABLE `months` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(9) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_purchase_price` varchar(255) DEFAULT NULL,
  `total_profit_price` double(8,2) DEFAULT NULL,
  `total_stock_quantity` double(8,2) DEFAULT NULL,
  `total_discount_quantity` int(11) DEFAULT NULL,
  `total_discount_price` int(11) DEFAULT NULL,
  `total_combo_price` varchar(255) DEFAULT NULL,
  `given_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `buy_products` int(11) DEFAULT NULL,
  `get_products` int(11) DEFAULT NULL,
  `offer_barcode` varchar(255) DEFAULT NULL,
  `discount_percentage` tinyint(4) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `combo_product` int(11) DEFAULT NULL,
  `combo_code` varchar(255) DEFAULT NULL,
  `discount_type` int(11) DEFAULT NULL COMMENT '2 = percentage, 1 = amount',
  `discount_amount` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive,1=Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer_products`
--

CREATE TABLE `offer_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `offer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_discount_amount` double DEFAULT NULL,
  `management_discount_amount` double DEFAULT NULL,
  `product_id` int(4) DEFAULT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `available_stock` varchar(255) DEFAULT NULL,
  `product_buy_price` varchar(255) DEFAULT NULL,
  `product_profit_price` double(8,2) NOT NULL,
  `discount_amount` double NOT NULL DEFAULT 0,
  `up_to` int(11) DEFAULT NULL,
  `quantity` tinyint(4) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `product_type` tinyint(4) DEFAULT NULL COMMENT '1=buy,2=get',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_address_id` int(11) DEFAULT NULL,
  `billing_address_id` int(11) DEFAULT NULL,
  `invoice_code` varchar(255) DEFAULT NULL,
  `payment_status` varchar(15) NOT NULL DEFAULT 'unpaid',
  `branch_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`branch_id`)),
  `order_status` varchar(15) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(15) DEFAULT NULL,
  `payment_amount` double(15,2) DEFAULT NULL,
  `payment_mobile_number` varchar(15) DEFAULT NULL,
  `transaction_ref` varchar(30) DEFAULT NULL,
  `sub_total_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `delivery_charge` double(11,2) NOT NULL DEFAULT 0.00,
  `customer_address` double(11,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_discount` double(8,2) DEFAULT NULL,
  `discount_total` double(8,2) DEFAULT NULL,
  `total_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=ecommerce',
  `order_exchange_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `vat_total` double(11,2) NOT NULL DEFAULT 0.00,
  `discount_total` double(11,2) NOT NULL DEFAULT 0.00,
  `buy_rate` double(11,2) NOT NULL DEFAULT 0.00,
  `sale_rate` double(11,2) NOT NULL DEFAULT 0.00,
  `quantity` double(11,2) NOT NULL DEFAULT 0.00,
  `product_total` double(11,2) NOT NULL DEFAULT 0.00,
  `net_total` double(11,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `due_collection` tinyint(4) NOT NULL DEFAULT 0,
  `date` varchar(10) NOT NULL,
  `note` mediumtext DEFAULT NULL,
  `amount` double(11,2) NOT NULL,
  `due` double(11,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `reference_status` varchar(255) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Sale', 'web', '2021-12-18 06:02:06', '2021-12-18 06:02:06'),
(2, 'Product', 'web', '2021-12-18 06:02:06', '2021-12-18 06:02:06'),
(3, 'Purchase', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(4, 'Cost', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(5, 'Invest', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(6, 'Owner', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(7, 'Bank', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(8, 'Cash', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(9, 'Customer', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(10, 'Supplier', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(11, 'Report', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(12, 'Product Transfer', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(13, 'User', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(14, 'Employee Management', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(15, 'Department', 'web', '2021-12-18 06:02:41', '2021-12-18 06:02:41'),
(16, 'Employee', 'web', '2021-12-18 06:08:10', '2021-12-18 06:08:10'),
(17, 'Salary', 'web', '2021-12-18 06:08:10', '2021-12-18 06:08:10'),
(18, 'Loan', 'web', '2021-12-18 06:08:10', '2021-12-18 06:08:10'),
(19, 'Attendance', 'web', '2021-12-18 06:08:10', '2021-12-18 06:08:10'),
(20, 'Bar Code', 'web', '2021-12-18 06:08:10', '2021-12-18 06:08:10'),
(21, 'Quotation', 'web', '2021-12-18 06:09:54', '2021-12-18 06:09:54'),
(22, 'All', 'web', '2021-12-18 06:09:54', '2021-12-18 06:09:54');

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

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '1',
  `product_slug` varchar(255) DEFAULT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_options` tinyint(1) NOT NULL DEFAULT 0,
  `category_id` bigint(20) NOT NULL,
  `unit_id` bigint(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `vat` double(5,2) DEFAULT NULL,
  `buy_price` double(11,2) NOT NULL,
  `sell_price` double(11,2) NOT NULL,
  `product_margin` double NOT NULL DEFAULT 0,
  `product_profit` double NOT NULL DEFAULT 0,
  `discount_type` varchar(255) DEFAULT NULL COMMENT '1=percentage,2=fixed',
  `discount_percentage` double NOT NULL DEFAULT 0,
  `discount_amount` double NOT NULL DEFAULT 0,
  `short_list` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_draft` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `size_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `variation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE `product_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `option_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_returns`
--

CREATE TABLE `product_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(10) NOT NULL,
  `sale_id` bigint(20) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` double(11,2) NOT NULL,
  `rate` double(11,2) NOT NULL,
  `amount` double(11,2) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_transfers`
--

CREATE TABLE `product_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` double(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variant_sku_barcodes`
--

CREATE TABLE `product_variant_sku_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `variant_price` double NOT NULL DEFAULT 0,
  `variant_buy_price` double NOT NULL DEFAULT 0,
  `variant_sku` varchar(255) DEFAULT NULL,
  `variant_barcode` varchar(255) DEFAULT NULL,
  `discount_type` varchar(255) DEFAULT NULL COMMENT '1=percentage,2=fixed',
  `discount_percentage` double NOT NULL DEFAULT 0,
  `discount_amount` double NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variant_values`
--

CREATE TABLE `product_variant_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `product_variant_sku_id` bigint(20) NOT NULL,
  `option_id` bigint(20) NOT NULL,
  `variant_value` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `vat_percentage` double NOT NULL DEFAULT 0,
  `vat` double NOT NULL DEFAULT 0,
  `extra_cost_name` varchar(255) DEFAULT NULL,
  `extra_cost` double NOT NULL DEFAULT 0,
  `discount_percentage` double NOT NULL DEFAULT 0,
  `discount` double NOT NULL DEFAULT 0,
  `total_quantity` double NOT NULL DEFAULT 0,
  `subtotal` double NOT NULL DEFAULT 0,
  `total` double NOT NULL DEFAULT 0,
  `note` mediumtext DEFAULT NULL,
  `sender_type` tinyint(4) NOT NULL DEFAULT 1,
  `send_by` varchar(255) DEFAULT NULL,
  `receive_by` bigint(20) DEFAULT NULL,
  `main_branch` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `main_branch` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `sell_price` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_dues`
--

CREATE TABLE `purchase_dues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `purchase_invoice` varchar(255) NOT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_amount` double NOT NULL DEFAULT 0,
  `paid_total` double NOT NULL DEFAULT 0,
  `due_total` double NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_payments`
--

CREATE TABLE `purchase_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `purchase_invoice` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `receipt_no` varchar(255) DEFAULT NULL,
  `purchase_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `total_buy_price` double NOT NULL DEFAULT 0,
  `total_advance` double NOT NULL DEFAULT 0,
  `total_pay` double NOT NULL DEFAULT 0,
  `total_due` double NOT NULL DEFAULT 0,
  `total_payable` double NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_bank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_bank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_number` varchar(255) DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_payment_invoices`
--

CREATE TABLE `purchase_payment_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_payments_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_invoice` varchar(255) DEFAULT NULL,
  `total_pay` double NOT NULL DEFAULT 0,
  `total_due` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_quantity` double NOT NULL DEFAULT 0,
  `total_amount` double NOT NULL DEFAULT 0,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_products`
--

CREATE TABLE `purchase_return_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_return_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_detail_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(10) NOT NULL,
  `company` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `subtotal` int(11) NOT NULL,
  `vat_percentage` int(11) DEFAULT NULL,
  `vat` double(11,2) DEFAULT NULL,
  `discount` double(11,2) DEFAULT NULL,
  `total` double(11,2) NOT NULL,
  `note` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_details`
--

CREATE TABLE `quotation_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` double(11,2) NOT NULL,
  `rate` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_id` varchar(255) DEFAULT NULL,
  `report_name` varchar(255) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `description` longtext DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2020-12-13 09:15:43', '2020-12-13 09:15:43'),
(2, 'User', 'web', '2021-01-26 06:53:19', '2021-01-26 06:53:19'),
(3, 'Supplier', 'web', '2022-07-04 14:45:57', '2022-07-04 14:45:57'),
(4, 'Employee', 'web', '2022-07-04 14:45:57', '2022-07-04 14:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `month_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `late` int(11) DEFAULT NULL,
  `leave_days` int(11) DEFAULT NULL,
  `absent` int(11) DEFAULT NULL,
  `present` int(11) NOT NULL,
  `late_fine` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `sale_type` tinyint(4) NOT NULL DEFAULT 1,
  `invoice_code` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `seller_id` varchar(255) DEFAULT NULL,
  `suppliers_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vat_percentage` double(11,2) NOT NULL DEFAULT 0.00,
  `vat_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `discount_percentage` double(11,2) NOT NULL DEFAULT 0.00,
  `discount_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `flat_discount` double(11,2) NOT NULL DEFAULT 0.00,
  `delivery_charge` double(11,2) NOT NULL DEFAULT 0.00,
  `additional_delivery_charge` double(11,2) NOT NULL DEFAULT 0.00,
  `additional_charge` double(11,2) NOT NULL DEFAULT 0.00,
  `change_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `net_total` double(11,2) NOT NULL DEFAULT 0.00,
  `final_total` double(11,2) NOT NULL DEFAULT 0.00,
  `payable_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `pay_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `due_total` double(11,2) NOT NULL DEFAULT 0.00,
  `return_total` double(10,2) NOT NULL DEFAULT 0.00,
  `exchange_total` double(10,2) NOT NULL DEFAULT 0.00,
  `customer_address` longtext DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_deliveries`
--

CREATE TABLE `sale_deliveries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_exchange_id` bigint(20) UNSIGNED DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `consignment_id` varchar(255) DEFAULT NULL,
  `merchant_order_id` varchar(255) DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_charge` double(10,2) NOT NULL DEFAULT 0.00,
  `additional_delivery_charge` double(11,2) NOT NULL DEFAULT 0.00,
  `amount_to_collect` double(10,2) NOT NULL DEFAULT 0.00,
  `order_status` tinyint(4) DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=sale,2=exchange	',
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_exchange_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `vat_total` double(11,2) NOT NULL DEFAULT 0.00,
  `discount_total` double(11,2) NOT NULL DEFAULT 0.00,
  `flat_discount_total` varchar(255) NOT NULL DEFAULT '0.00',
  `buy_rate` double(11,2) NOT NULL DEFAULT 0.00,
  `sale_rate` double(11,2) NOT NULL DEFAULT 0.00,
  `quantity` double(11,2) NOT NULL DEFAULT 0.00,
  `product_total` double(11,2) NOT NULL DEFAULT 0.00,
  `net_total` double(11,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_exchanges`
--

CREATE TABLE `sale_exchanges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `suppliers_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `seller_id` varchar(255) DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `delivery_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vat_percentage` double(11,2) NOT NULL DEFAULT 0.00,
  `vat_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `discount_percentage` double(11,2) NOT NULL DEFAULT 0.00,
  `discount_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `flat_discount` double(11,2) NOT NULL DEFAULT 0.00,
  `delivery_charge` double(11,2) NOT NULL DEFAULT 0.00,
  `additional_delivery_charge` double(11,2) NOT NULL DEFAULT 0.00,
  `additional_charge` double(11,2) NOT NULL DEFAULT 0.00,
  `change_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `net_total` double(11,2) NOT NULL DEFAULT 0.00,
  `payable_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `pay_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `due_total` double(11,2) NOT NULL DEFAULT 0.00,
  `return_total` double(11,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_payments`
--

CREATE TABLE `sale_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_exchange_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payable_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `paid` double(11,2) NOT NULL DEFAULT 0.00,
  `due` double(11,2) NOT NULL DEFAULT 0.00,
  `change_amount` double(11,2) NOT NULL DEFAULT 0.00,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_payment_histories`
--

CREATE TABLE `sale_payment_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_exchange_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payable_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `pay_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `paid_total` double(10,2) NOT NULL DEFAULT 0.00,
  `due_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `change_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_number` varchar(255) DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_returns`
--

CREATE TABLE `sale_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_type` tinyint(4) DEFAULT NULL COMMENT '1=return,2=exchange_return',
  `return_date` varchar(10) NOT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vat_percentage` double(10,2) NOT NULL DEFAULT 0.00,
  `vat_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `discount_percentage` double(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `flat_discount` double(10,2) NOT NULL DEFAULT 0.00,
  `return_total` double(10,2) NOT NULL DEFAULT 0.00,
  `return_amount` double(10,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_details`
--

CREATE TABLE `sale_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_type` tinyint(4) DEFAULT NULL COMMENT '1=return,2=exchange_return',
  `sale_return_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `vat_total` double(11,2) NOT NULL DEFAULT 0.00,
  `discount_total` double(11,2) NOT NULL DEFAULT 0.00,
  `flat_discount_total` varchar(255) NOT NULL DEFAULT '0.00',
  `buy_rate` double(11,2) NOT NULL DEFAULT 0.00,
  `sale_rate` double(11,2) NOT NULL DEFAULT 0.00,
  `quantity` double(11,2) NOT NULL DEFAULT 0.00,
  `product_total` double(11,2) NOT NULL DEFAULT 0.00,
  `net_total` double(11,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_purchase_histories`
--

CREATE TABLE `sale_return_purchase_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_type` tinyint(4) DEFAULT NULL COMMENT '1=return,2=exchange_return',
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_detail_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` double(11,2) NOT NULL DEFAULT 0.00,
  `buy_rate` double(11,2) NOT NULL DEFAULT 0.00,
  `sale_rate` double(11,2) NOT NULL DEFAULT 0.00,
  `buy_total` double(11,2) NOT NULL DEFAULT 0.00,
  `sale_total` double(11,2) NOT NULL DEFAULT 0.00,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 'site_logo', 'images/settings/1414020790_f105a1dd-1244-43c3-9735-273f64944a78.jpeg', NULL, NULL, '2023-05-21 11:05:02'),
(2, 'site_name', 'HEAD OFFICE', NULL, NULL, '2022-07-11 02:24:55'),
(3, 'phone_number', '695', NULL, NULL, '2022-07-06 02:32:00'),
(4, 'email', 'lexyxot@mailinator.com', NULL, NULL, '2022-07-06 02:32:00'),
(5, 'verify_email', 'zasixehap@mailinator.com', NULL, NULL, '2022-07-06 02:32:00'),
(6, 'vat_percentage', '7.5', NULL, NULL, NULL),
(7, 'exchange_total', '2', NULL, '2022-07-30 05:18:47', '2022-09-26 08:19:47'),
(8, 'exchange_in', '10', NULL, '2022-07-30 05:19:22', '2022-12-31 10:27:06'),
(9, 'return_total', '1', NULL, '2022-07-30 05:19:22', '2022-12-31 10:27:06'),
(10, 'return_in', '10', NULL, '2022-07-30 05:19:22', '2022-12-31 10:27:06'),
(11, 'sale_footer', 'www.colourful.com.bd\r\nNote: Products can be exchange withing 6 days\r\nNEW SELL CUSTOMER COPY', NULL, '2022-08-27 12:29:34', '2022-08-27 12:29:34'),
(12, 'inside_dhaka_charge', '70', NULL, '2022-08-29 11:06:42', '2022-08-29 11:06:42'),
(13, 'outside_dhaka_charge', '150', NULL, '2022-08-29 11:06:42', '2022-08-29 11:06:42'),
(14, 'language', '[{\"id\":2,\"name\":\"bangla\",\"direction\":\"ltr\",\"code\":\"bd\",\"status\":1,\"default\":false},{\"id\":3,\"name\":\"english\",\"direction\":\"ltr\",\"code\":\"en\",\"status\":1,\"default\":true}]', NULL, '2022-08-29 11:06:42', '2023-05-25 11:12:29'),
(15, 'currency_symbol', '$', NULL, NULL, NULL),
(16, 'currency_name', 'RUPI', NULL, NULL, '2023-05-25 08:31:12'),
(17, 'print_logo', 'images/settings/1387283198_2f9e276b-96a9-47e1-ab2c-c50d72fc2aeb.png', NULL, NULL, '2023-05-25 11:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_details_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `sell_price` int(11) NOT NULL DEFAULT 0,
  `buy_price` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `main_branch` bigint(20) UNSIGNED DEFAULT NULL,
  `current_branch` bigint(20) UNSIGNED DEFAULT NULL,
  `transfer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sale_detail_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_return_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stock_status` tinyint(4) DEFAULT 1 COMMENT '0=Sale,1=Stock',
  `offer_id` int(11) DEFAULT NULL,
  `offer_type` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `company_phone` varchar(15) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `owner_name` mediumtext DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--



-- --------------------------------------------------------

--
-- Table structure for table `transfer_receives`
--

CREATE TABLE `transfer_receives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `invoice_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=transfer,2=receive',
  `invoice_code` varchar(50) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `total_quantity` double NOT NULL DEFAULT 0,
  `subtotal` double NOT NULL DEFAULT 0,
  `total` double NOT NULL DEFAULT 0,
  `note` mediumtext DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'when supplier transfer',
  `transfer_branch` varchar(255) DEFAULT NULL,
  `receive_branch` varchar(255) DEFAULT NULL,
  `receive_by` bigint(20) DEFAULT NULL,
  `main_branch` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0=Transferring,Receiving,1==Transfer,Received,2=Reject',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_receive_details`
--

CREATE TABLE `transfer_receive_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `invoice_code` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transfer_receive_from` bigint(20) UNSIGNED DEFAULT NULL,
  `transfer_invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_barcode` varchar(255) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `main_branch` bigint(20) UNSIGNED DEFAULT NULL,
  `transfer_branch` bigint(20) UNSIGNED DEFAULT NULL,
  `current_branch` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `id_card_number` varchar(255) DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `is_main_branch` tinyint(1) NOT NULL DEFAULT 0,
  `section_id` bigint(20) DEFAULT NULL,
  `designation_id` bigint(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `previous_company` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_branches`
--

CREATE TABLE `user_branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_cards`
--

CREATE TABLE `user_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `discount` bigint(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `variation_name` varchar(255) DEFAULT NULL,
  `type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variation_value` varchar(255) DEFAULT NULL,
  `variation_code` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance_transfers`
--
ALTER TABLE `balance_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banks_user_id_foreign` (`user_id`);

--
-- Indexes for table `banks_transfers`
--
ALTER TABLE `banks_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banks_transfers_user_id_foreign` (`user_id`),
  ADD KEY `banks_transfers_receiver_bank_id_foreign` (`receiver_bank_id`),
  ADD KEY `banks_transfers_sender_bank_id_foreign` (`sender_bank_id`),
  ADD KEY `banks_transfers_created_by_foreign` (`created_by`),
  ADD KEY `banks_transfers_updated_by_foreign` (`updated_by`),
  ADD KEY `banks_transfers_cash_id_index` (`cash_id`),
  ADD KEY `banks_transfers_money_transfer_id_index` (`money_transfer_id`),
  ADD KEY `banks_transfers_current_branch_id_index` (`current_branch_id`);

--
-- Indexes for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_transactions_sale_id_foreign` (`sale_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_name_unique` (`name`),
  ADD KEY `branches_user_id_foreign` (`user_id`),
  ADD KEY `branches_created_by_foreign` (`created_by`),
  ADD KEY `branches_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `branch_payment_methods`
--
ALTER TABLE `branch_payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_payment_methods_payment_method_id_index` (`payment_method_id`),
  ADD KEY `branch_payment_methods_branch_id_index` (`branch_id`);

--
-- Indexes for table `branch_payment_method_histories`
--
ALTER TABLE `branch_payment_method_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_payment_method_histories_created_by_foreign` (`created_by`),
  ADD KEY `branch_payment_method_histories_updated_by_foreign` (`updated_by`),
  ADD KEY `branch_payment_method_histories_sale_id_index` (`sale_id`),
  ADD KEY `branch_payment_method_histories_branch_id_index` (`branch_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`);

--
-- Indexes for table `cashes`
--
ALTER TABLE `cashes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_drawers`
--
ALTER TABLE `cash_drawers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_drawers_created_by_foreign` (`created_by`),
  ADD KEY `cash_drawers_updated_by_foreign` (`updated_by`),
  ADD KEY `cash_drawers_branch_id_index` (`branch_id`);

--
-- Indexes for table `cash_histories`
--
ALTER TABLE `cash_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_histories_created_by_foreign` (`created_by`),
  ADD KEY `cash_histories_updated_by_foreign` (`updated_by`),
  ADD KEY `cash_histories_cash_id_index` (`cash_id`),
  ADD KEY `cash_histories_branch_id_index` (`branch_id`),
  ADD KEY `cash_histories_employee_id_index` (`employee_id`),
  ADD KEY `cash_histories_supplier_id_index` (`supplier_id`),
  ADD KEY `cash_histories_sender_id_index` (`sender_id`),
  ADD KEY `cash_histories_payment_method_id_index` (`payment_method_id`),
  ADD KEY `cash_histories_money_transfer_id_index` (`money_transfer_id`),
  ADD KEY `cash_histories_current_branch_id_index` (`current_branch_id`),
  ADD KEY `cash_histories_receiver_branch_id_index` (`receiver_branch_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `costs`
--
ALTER TABLE `costs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `costs_receipt_no_unique` (`receipt_no`),
  ADD KEY `costs_created_by_foreign` (`created_by`),
  ADD KEY `costs_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_created_by_foreign` (`created_by`),
  ADD KEY `customers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_men`
--
ALTER TABLE `delivery_men`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `delivery_men_phone_unique` (`phone`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_created_by_foreign` (`created_by`),
  ADD KEY `departments_updated_by_foreign` (`updated_by`),
  ADD KEY `departments_branch_id_index` (`branch_id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designations_created_by_foreign` (`created_by`),
  ADD KEY `designations_updated_by_foreign` (`updated_by`),
  ADD KEY `designations_department_id_index` (`department_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_department_id_foreign` (`department_id`),
  ADD KEY `employees_created_by_foreign` (`created_by`),
  ADD KEY `employees_updated_by_foreign` (`updated_by`),
  ADD KEY `employees_user_id_index` (`user_id`),
  ADD KEY `employees_branch_id_index` (`branch_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invests`
--
ALTER TABLE `invests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invests_product_id_foreign` (`product_id`),
  ADD KEY `invests_purchase_due_id_foreign` (`purchase_due_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_created_by_foreign` (`created_by`),
  ADD KEY `messages_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `money_transfers`
--
ALTER TABLE `money_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `money_transfers_created_by_foreign` (`created_by`),
  ADD KEY `money_transfers_updated_by_foreign` (`updated_by`),
  ADD KEY `money_transfers_payment_method_id_index` (`payment_method_id`),
  ADD KEY `money_transfers_current_branch_id_index` (`current_branch_id`),
  ADD KEY `money_transfers_receiver_branch_id_index` (`receiver_branch_id`),
  ADD KEY `money_transfers_cash_drawer_id_index` (`cash_drawer_id`),
  ADD KEY `money_transfers_bank_id_index` (`bank_id`),
  ADD KEY `money_transfers_bank_account_no_index` (`bank_account_no`);

--
-- Indexes for table `months`
--
ALTER TABLE `months`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offers_created_by_foreign` (`created_by`),
  ADD KEY `offers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `offer_products`
--
ALTER TABLE `offer_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offer_products_created_by_foreign` (`created_by`),
  ADD KEY `offer_products_updated_by_foreign` (`updated_by`),
  ADD KEY `offer_products_offer_id_index` (`offer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_invoice_code_unique` (`invoice_code`),
  ADD KEY `orders_created_by_foreign` (`created_by`),
  ADD KEY `orders_updated_by_foreign` (`updated_by`),
  ADD KEY `orders_customer_id_index` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_created_by_foreign` (`created_by`),
  ADD KEY `order_details_updated_by_foreign` (`updated_by`),
  ADD KEY `order_details_order_exchange_id_index` (`order_exchange_id`),
  ADD KEY `order_details_order_id_index` (`order_id`),
  ADD KEY `order_details_customer_id_index` (`customer_id`),
  ADD KEY `order_details_branch_id_index` (`branch_id`),
  ADD KEY `order_details_supplier_id_index` (`supplier_id`),
  ADD KEY `order_details_product_id_index` (`product_id`),
  ADD KEY `order_details_product_sku_index` (`product_sku`),
  ADD KEY `order_details_product_barcode_index` (`product_barcode`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owners_sale_id_foreign` (`sale_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_created_by_foreign` (`created_by`),
  ADD KEY `product_images_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_returns`
--
ALTER TABLE `product_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_returns_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_transfers`
--
ALTER TABLE `product_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variant_sku_barcodes`
--
ALTER TABLE `product_variant_sku_barcodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variant_sku_barcodes_variant_barcode_unique` (`variant_barcode`);

--
-- Indexes for table `product_variant_values`
--
ALTER TABLE `product_variant_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_created_by_foreign` (`created_by`),
  ADD KEY `purchases_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_details_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_details_product_id_foreign` (`product_id`),
  ADD KEY `purchase_details_created_by_foreign` (`created_by`),
  ADD KEY `purchase_details_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `purchase_dues`
--
ALTER TABLE `purchase_dues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_dues_created_by_foreign` (`created_by`),
  ADD KEY `purchase_dues_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `purchase_payments`
--
ALTER TABLE `purchase_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_payments_receipt_no_unique` (`receipt_no`),
  ADD KEY `purchase_payments_created_by_foreign` (`created_by`),
  ADD KEY `purchase_payments_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `purchase_payment_invoices`
--
ALTER TABLE `purchase_payment_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_returns_created_by_foreign` (`created_by`),
  ADD KEY `purchase_returns_updated_by_foreign` (`updated_by`),
  ADD KEY `purchase_returns_purchase_id_index` (`purchase_id`),
  ADD KEY `purchase_returns_supplier_id_index` (`supplier_id`),
  ADD KEY `purchase_returns_branch_id_index` (`branch_id`),
  ADD KEY `purchase_returns_user_id_index` (`user_id`);

--
-- Indexes for table `purchase_return_products`
--
ALTER TABLE `purchase_return_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_products_created_by_foreign` (`created_by`),
  ADD KEY `purchase_return_products_updated_by_foreign` (`updated_by`),
  ADD KEY `purchase_return_products_purchase_return_id_index` (`purchase_return_id`),
  ADD KEY `purchase_return_products_purchase_id_index` (`purchase_id`),
  ADD KEY `purchase_return_products_purchase_detail_id_index` (`purchase_detail_id`),
  ADD KEY `purchase_return_products_supplier_id_index` (`supplier_id`),
  ADD KEY `purchase_return_products_branch_id_index` (`branch_id`),
  ADD KEY `purchase_return_products_user_id_index` (`user_id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation_details`
--
ALTER TABLE `quotation_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_details_quotation_id_foreign` (`quotation_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reports_report_id_unique` (`report_id`),
  ADD KEY `reports_created_by_foreign` (`created_by`),
  ADD KEY `reports_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_invoice_code_unique` (`invoice_code`),
  ADD KEY `sales_created_by_foreign` (`created_by`),
  ADD KEY `sales_updated_by_foreign` (`updated_by`),
  ADD KEY `sales_branch_id_index` (`branch_id`),
  ADD KEY `sales_customer_id_index` (`customer_id`);

--
-- Indexes for table `sale_deliveries`
--
ALTER TABLE `sale_deliveries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sale_deliveries_consignment_id_unique` (`consignment_id`),
  ADD KEY `sale_deliveries_created_by_foreign` (`created_by`),
  ADD KEY `sale_deliveries_updated_by_foreign` (`updated_by`),
  ADD KEY `sale_deliveries_sale_id_index` (`sale_id`),
  ADD KEY `sale_deliveries_branch_id_index` (`branch_id`),
  ADD KEY `sale_deliveries_customer_id_index` (`customer_id`),
  ADD KEY `sale_deliveries_delivery_id_index` (`delivery_id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_details_created_by_foreign` (`created_by`),
  ADD KEY `sale_details_updated_by_foreign` (`updated_by`),
  ADD KEY `sale_details_sale_id_index` (`sale_id`),
  ADD KEY `sale_details_user_id_index` (`user_id`),
  ADD KEY `sale_details_customer_id_index` (`customer_id`),
  ADD KEY `sale_details_branch_id_index` (`branch_id`),
  ADD KEY `sale_details_supplier_id_index` (`supplier_id`),
  ADD KEY `sale_details_product_id_index` (`product_id`),
  ADD KEY `sale_details_product_sku_index` (`product_sku`),
  ADD KEY `sale_details_product_barcode_index` (`product_barcode`);

--
-- Indexes for table `sale_exchanges`
--
ALTER TABLE `sale_exchanges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_exchanges_created_by_foreign` (`created_by`),
  ADD KEY `sale_exchanges_updated_by_foreign` (`updated_by`),
  ADD KEY `sale_exchanges_sale_id_index` (`sale_id`),
  ADD KEY `sale_exchanges_branch_id_index` (`branch_id`),
  ADD KEY `sale_exchanges_customer_id_index` (`customer_id`);

--
-- Indexes for table `sale_payments`
--
ALTER TABLE `sale_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_payments_created_by_foreign` (`created_by`),
  ADD KEY `sale_payments_updated_by_foreign` (`updated_by`),
  ADD KEY `sale_payments_sale_id_index` (`sale_id`),
  ADD KEY `sale_payments_user_id_index` (`user_id`),
  ADD KEY `sale_payments_customer_id_index` (`customer_id`);

--
-- Indexes for table `sale_payment_histories`
--
ALTER TABLE `sale_payment_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_payment_histories_created_by_foreign` (`created_by`),
  ADD KEY `sale_payment_histories_updated_by_foreign` (`updated_by`),
  ADD KEY `sale_payment_histories_sale_id_index` (`sale_id`),
  ADD KEY `sale_payment_histories_user_id_index` (`user_id`),
  ADD KEY `sale_payment_histories_customer_id_index` (`customer_id`);

--
-- Indexes for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_returns_created_by_foreign` (`created_by`),
  ADD KEY `sale_returns_updated_by_foreign` (`updated_by`),
  ADD KEY `sale_returns_sale_id_index` (`sale_id`),
  ADD KEY `sale_returns_user_id_index` (`user_id`),
  ADD KEY `sale_returns_branch_id_index` (`branch_id`),
  ADD KEY `sale_returns_customer_id_index` (`customer_id`);

--
-- Indexes for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_return_details_created_by_foreign` (`created_by`),
  ADD KEY `sale_return_details_updated_by_foreign` (`updated_by`),
  ADD KEY `sale_return_details_sale_return_id_index` (`sale_return_id`),
  ADD KEY `sale_return_details_sale_id_index` (`sale_id`),
  ADD KEY `sale_return_details_user_id_index` (`user_id`),
  ADD KEY `sale_return_details_customer_id_index` (`customer_id`),
  ADD KEY `sale_return_details_branch_id_index` (`branch_id`),
  ADD KEY `sale_return_details_supplier_id_index` (`supplier_id`),
  ADD KEY `sale_return_details_product_id_index` (`product_id`),
  ADD KEY `sale_return_details_product_sku_index` (`product_sku`),
  ADD KEY `sale_return_details_product_barcode_index` (`product_barcode`);

--
-- Indexes for table `sale_return_purchase_histories`
--
ALTER TABLE `sale_return_purchase_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_return_purchase_histories_created_by_foreign` (`created_by`),
  ADD KEY `sale_return_purchase_histories_updated_by_foreign` (`updated_by`),
  ADD KEY `sale_return_purchase_histories_purchase_id_index` (`purchase_id`),
  ADD KEY `sale_return_purchase_histories_product_id_index` (`product_id`),
  ADD KEY `sale_return_purchase_histories_product_sku_index` (`product_sku`),
  ADD KEY `sale_return_purchase_histories_product_barcode_index` (`product_barcode`),
  ADD KEY `sale_return_purchase_histories_supplier_id_index` (`supplier_id`),
  ADD KEY `sale_return_purchase_histories_branch_id_index` (`branch_id`),
  ADD KEY `sale_return_purchase_histories_customer_id_index` (`customer_id`),
  ADD KEY `sale_return_purchase_histories_sale_id_index` (`sale_id`),
  ADD KEY `sale_return_purchase_histories_sale_detail_id_index` (`sale_detail_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_product_id_foreign` (`product_id`),
  ADD KEY `stocks_purchase_id_foreign` (`purchase_id`),
  ADD KEY `stocks_purchase_details_id_foreign` (`purchase_details_id`),
  ADD KEY `stocks_created_by_foreign` (`created_by`),
  ADD KEY `stocks_updated_by_foreign` (`updated_by`),
  ADD KEY `stocks_offer_id_index` (`offer_id`),
  ADD KEY `stocks_offer_type_index` (`offer_type`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_created_by_foreign` (`created_by`),
  ADD KEY `suppliers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `transfer_receives`
--
ALTER TABLE `transfer_receives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfer_receives_created_by_foreign` (`created_by`),
  ADD KEY `transfer_receives_updated_by_foreign` (`updated_by`),
  ADD KEY `transfer_receives_supplier_id_index` (`supplier_id`);

--
-- Indexes for table `transfer_receive_details`
--
ALTER TABLE `transfer_receive_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfer_receive_details_transfer_invoice_id_foreign` (`transfer_invoice_id`),
  ADD KEY `transfer_receive_details_transfer_receive_from_foreign` (`transfer_receive_from`),
  ADD KEY `transfer_receive_details_purchase_id_foreign` (`purchase_id`),
  ADD KEY `transfer_receive_details_product_id_foreign` (`product_id`),
  ADD KEY `transfer_receive_details_created_by_foreign` (`created_by`),
  ADD KEY `transfer_receive_details_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_created_by_foreign` (`created_by`),
  ADD KEY `users_updated_by_foreign` (`updated_by`),
  ADD KEY `users_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `user_branches`
--
ALTER TABLE `user_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_cards`
--
ALTER TABLE `user_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variations_type_id_foreign` (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balance_transfers`
--
ALTER TABLE `balance_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks_transfers`
--
ALTER TABLE `banks_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch_payment_methods`
--
ALTER TABLE `branch_payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch_payment_method_histories`
--
ALTER TABLE `branch_payment_method_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashes`
--
ALTER TABLE `cashes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_drawers`
--
ALTER TABLE `cash_drawers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_histories`
--
ALTER TABLE `cash_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `costs`
--
ALTER TABLE `costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_addresses`
--
ALTER TABLE `delivery_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_men`
--
ALTER TABLE `delivery_men`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invests`
--
ALTER TABLE `invests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1158;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=329;

--
-- AUTO_INCREMENT for table `money_transfers`
--
ALTER TABLE `money_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `months`
--
ALTER TABLE `months`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_products`
--
ALTER TABLE `offer_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_options`
--
ALTER TABLE `product_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_returns`
--
ALTER TABLE `product_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_transfers`
--
ALTER TABLE `product_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variant_sku_barcodes`
--
ALTER TABLE `product_variant_sku_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variant_values`
--
ALTER TABLE `product_variant_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_dues`
--
ALTER TABLE `purchase_dues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_payments`
--
ALTER TABLE `purchase_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_payment_invoices`
--
ALTER TABLE `purchase_payment_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_products`
--
ALTER TABLE `purchase_return_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotation_details`
--
ALTER TABLE `quotation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_deliveries`
--
ALTER TABLE `sale_deliveries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_exchanges`
--
ALTER TABLE `sale_exchanges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_payments`
--
ALTER TABLE `sale_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_payment_histories`
--
ALTER TABLE `sale_payment_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_returns`
--
ALTER TABLE `sale_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return_purchase_histories`
--
ALTER TABLE `sale_return_purchase_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transfer_receives`
--
ALTER TABLE `transfer_receives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer_receive_details`
--
ALTER TABLE `transfer_receive_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_branches`
--
ALTER TABLE `user_branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_cards`
--
ALTER TABLE `user_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banks`
--
ALTER TABLE `banks`
  ADD CONSTRAINT `banks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `banks_transfers`
--
ALTER TABLE `banks_transfers`
  ADD CONSTRAINT `banks_transfers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `banks_transfers_receiver_bank_id_foreign` FOREIGN KEY (`receiver_bank_id`) REFERENCES `banks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `banks_transfers_sender_bank_id_foreign` FOREIGN KEY (`sender_bank_id`) REFERENCES `banks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `banks_transfers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `banks_transfers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
  ADD CONSTRAINT `bank_transactions_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `branches_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `branches_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `branch_payment_methods`
--
ALTER TABLE `branch_payment_methods`
  ADD CONSTRAINT `branch_payment_methods_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
