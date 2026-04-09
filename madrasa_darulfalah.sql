-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2026 at 09:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `madrasa_darulfalah`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `boarding_required` tinyint(1) NOT NULL DEFAULT 0,
  `message` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admissions`
--

INSERT INTO `admissions` (`id`, `user_id`, `course_id`, `name`, `email`, `phone`, `dob`, `gender`, `father_name`, `address`, `city`, `qualification`, `boarding_required`, `message`, `status`, `reviewed_by`, `reviewed_at`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Test User', 'test@example.com', '1234567890', '2000-01-01', 'male', 'Test Guardian', 'Test Address', NULL, 'Graduate', 0, NULL, 'pending', NULL, NULL, NULL, '2026-03-19 13:19:27', '2026-03-19 13:19:27'),
(2, NULL, NULL, 'Ali Ahmed', 'mmoptics138@gmail.com', '+93 272707981', '2012-10-16', 'male', 'Shahbaz Bukhari', 'W24R+RP5 Liaquatabad Town, Karachi, Pakistan', NULL, 'primary', 0, NULL, 'pending', 1, '2026-03-19 13:37:06', NULL, '2026-03-19 13:28:14', '2026-03-19 13:37:06');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `urdu_title` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `urdu_content` longtext DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'all',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `urdu_title`, `content`, `urdu_content`, `type`, `is_active`, `expires_at`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'چھٹی', NULL, 'کل چھٹی ہے', NULL, 'both', 1, '2026-03-20 19:00:00', 1, '2026-03-19 14:18:28', '2026-03-19 14:29:41'),
(2, 'Test Announcement', NULL, 'This is a test announcement to verify the detail page content is showing correctly on the website and detail page.', NULL, 'all', 1, NULL, 1, '2026-03-19 15:43:40', '2026-03-19 15:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late') NOT NULL DEFAULT 'present',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `book_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `external_link` varchar(255) DEFAULT NULL,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_categories`
--

CREATE TABLE `book_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('madrasa-dar-ul-falah-cache-admin@example.com|127.0.0.1', 'i:1;', 1774085866),
('madrasa-dar-ul-falah-cache-admin@example.com|127.0.0.1:timer', 'i:1774085866;', 1774085866),
('madrasa-dar-ul-falah-cache-admin@gmail.com|127.0.0.1', 'i:1;', 1774643595),
('madrasa-dar-ul-falah-cache-admin@gmail.com|127.0.0.1:timer', 'i:1774643595;', 1774643595),
('madrasa-dar-ul-falah-cache-okashagfx@gmail.com|127.0.0.1', 'i:1;', 1774642955),
('madrasa-dar-ul-falah-cache-okashagfx@gmail.com|127.0.0.1:timer', 'i:1774642955;', 1774642955);

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Hifz', 'hifz', NULL, '2026-03-18 14:18:15', '2026-03-18 14:18:15'),
(2, 'Nazra', 'nazra', NULL, '2026-03-18 14:18:45', '2026-03-18 14:18:45'),
(4, 'Qaida', 'qaida', NULL, '2026-03-20 13:48:30', '2026-03-20 13:48:30');

-- --------------------------------------------------------

--
-- Table structure for table `cms_settings`
--

CREATE TABLE `cms_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_settings`
--

INSERT INTO `cms_settings` (`id`, `key`, `value`, `type`, `group`, `created_at`, `updated_at`) VALUES
(1, 'hero_title', 'Welcome to Madrasa Dar-ul-Falah', 'text', 'homepage', '2026-03-18 07:32:49', '2026-03-18 07:32:49'),
(2, 'hero_subtitle', 'Empowering minds with Islamic and modern education', 'text', 'homepage', '2026-03-18 07:32:49', '2026-03-18 07:32:49'),
(3, 'about_text', 'Madrasa Dar-ul-Falah is a premier Islamic educational institute...', 'textarea', 'about', '2026-03-18 07:32:49', '2026-03-18 07:32:49'),
(4, 'contact_email', 'info@madrasa.com', 'text', 'contact', '2026-03-18 07:32:49', '2026-03-18 07:32:49'),
(5, 'contact_phone', '+1234567890', 'text', 'contact', '2026-03-18 07:32:49', '2026-03-18 07:32:49'),
(6, 'address', '123 Islamic Center, City', 'textarea', 'contact', '2026-03-18 07:32:49', '2026-03-18 07:32:49'),
(7, 'site_name', 'Madrasa Dar-ul-Falah', 'text', 'general', '2026-03-18 18:27:57', '2026-03-18 18:27:57'),
(8, 'site_tagline', 'Excellence in Islamic Education', 'text', 'general', '2026-03-18 18:27:59', '2026-03-18 18:27:59'),
(9, 'footer_text', '© 2025 Madrasa Dar-ul-Falah. All rights reserved.', 'text', 'general', '2026-03-18 18:27:59', '2026-03-18 18:27:59'),
(10, 'contact_address', 'Street Number 11, Haji Mureed Goth, Firdous Colony, Karachi, 74600, Pakistan', 'text', 'general', '2026-03-18 18:27:59', '2026-03-18 18:27:59'),
(11, 'office_hours', 'Mon - Sat: 8:00 AM - 4:00 PM', 'text', 'general', '2026-03-18 18:27:59', '2026-03-18 18:27:59'),
(12, 'social_facebook', NULL, 'text', 'general', '2026-03-18 18:27:59', '2026-03-18 18:27:59'),
(13, 'social_instagram', NULL, 'text', 'general', '2026-03-18 18:27:59', '2026-03-18 18:27:59'),
(14, 'social_youtube', NULL, 'text', 'general', '2026-03-18 18:27:59', '2026-03-18 18:27:59'),
(15, 'social_twitter', NULL, 'text', 'general', '2026-03-18 18:27:59', '2026-03-18 18:27:59');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `urdu_title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `urdu_description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `level` enum('beginner','intermediate','advanced') NOT NULL DEFAULT 'beginner',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `urdu_title`, `slug`, `category_id`, `description`, `urdu_description`, `content`, `image`, `duration`, `fee`, `teacher_id`, `level`, `status`, `is_featured`, `order`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(3, 'Hifz-ul-Quran', NULL, 'hifz-ul-quran', 1, 'This course is designed for students who wish to memorize the complete Holy Quran (Hifz) under the guidance of qualified teachers. The program focuses on strong memorization, daily revision (Sabqi & Manzil), and accuracy with Tajweed. Students are trained with a disciplined routine to ensure long-term retention of the Quran.', NULL, 'Complete memorization of the Quran (30 Paras)\r\n\r\nDaily Sabaq (new lesson)\r\n\r\nSabqi (recent revision)\r\n\r\nManzil (old revision)\r\n\r\nStrong Tajweed application', NULL, '2 – 4 Years', 0.00, 4, 'intermediate', 1, 0, 0, NULL, NULL, '2026-03-20 13:25:34', '2026-03-20 14:12:11'),
(4, 'Nazra Quran', NULL, 'nazra-quran', 2, 'Nazra course focuses on correct and fluent recitation of the Holy Quran. Students learn how to read the Quran properly with Tajweed rules, improving pronunciation and fluency.', NULL, 'Fluent Quran reading\r\nBasic Tajweed rules\r\nCorrect pronunciation (Makharij)\r\nReading the complete Quran', NULL, '6 – 12 Months', 0.00, 7, 'beginner', 1, 0, 0, NULL, NULL, '2026-03-21 04:16:08', '2026-03-21 06:51:27'),
(5, 'Noorani Qaida', NULL, 'noorani-qaida', 4, 'This course is for beginners who are starting their journey in Quran learning. It teaches the Arabic alphabet, pronunciation, and basic reading skills required to read the Quran.', NULL, 'Arabic letters and sounds\r\nJoining letters\r\nBasic pronunciation (Makharij)\r\nReading simple words', NULL, '2 – 4 Months', 0.00, 4, 'beginner', 1, 0, 0, NULL, NULL, '2026-03-21 04:17:37', '2026-03-21 04:17:37'),
(6, 'Tajweed Course', NULL, 'tajweed-course', 1, 'This course focuses on teaching the rules of Tajweed in detail, ensuring that students recite the Quran with proper pronunciation and beauty as required in Islamic tradition.', NULL, 'Rules of Tajweed\r\nMakharij (points of articulation)\r\nSifaat (qualities of letters)\r\nPractical recitation improvement', NULL, '3 – 6 Months', 0.00, 5, 'advanced', 1, 0, 0, NULL, NULL, '2026-03-21 04:19:24', '2026-03-21 06:50:58'),
(7, 'Basic Islamic Studies', NULL, 'basic-islamic-studies', 2, 'This course provides students with essential Islamic knowledge, helping them understand their faith, daily practices, and moral values.', NULL, 'Basic Aqeedah (beliefs)\r\nDaily duas and prayers\r\nIslamic manners (Akhlaq)\r\nSunnah practices', NULL, '3 – 6 Months', 0.00, 9, 'beginner', 1, 0, 0, NULL, NULL, '2026-03-21 04:22:05', '2026-03-21 06:50:29');

-- --------------------------------------------------------

--
-- Table structure for table `course_student`
--

CREATE TABLE `course_student` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `enrolled_at` date DEFAULT NULL,
  `status` enum('active','completed','dropped') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_student`
--

INSERT INTO `course_student` (`id`, `course_id`, `student_id`, `enrolled_at`, `status`, `created_at`, `updated_at`) VALUES
(3, 6, 9, NULL, 'active', '2026-03-27 15:12:23', '2026-03-27 15:12:23'),
(4, 7, 7, NULL, 'active', '2026-03-27 15:12:40', '2026-03-27 15:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `event_date` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `location`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Annual Ceremony', 'Annual Ceremony Details.', '2026-08-21 10:00:00', 'Main Block Hall', 1, 1, '2026-03-19 14:58:13', '2026-03-19 15:30:34'),
(2, 'سالانہ امتحان', 'اپنے بچے کی حوصلہ افزائی کے لیے لازمی آئیں', '2026-04-22 09:30:00', 'Ground Floor Hall', 1, 1, '2026-03-19 15:32:32', '2026-03-19 15:32:32');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `program` varchar(255) NOT NULL,
  `exam_type` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `para` int(11) DEFAULT NULL,
  `surah` varchar(255) DEFAULT NULL,
  `ayah_from` int(11) DEFAULT NULL,
  `ayah_to` int(11) DEFAULT NULL,
  `mistakes` int(11) NOT NULL DEFAULT 0,
  `fluency` int(11) DEFAULT NULL,
  `tajweed` int(11) DEFAULT NULL,
  `grade` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `image`, `category`, `description`, `status`, `order`, `created_at`, `updated_at`) VALUES
(2, 'Exam Event', 'gallery/Sou2Zx9TdMLA7Ky8oeCmNggbvrAuf6zJpo3z8hF1.jpg', 'Events', NULL, 1, 0, '2026-03-27 15:28:32', '2026-03-27 15:28:32'),
(3, 'Teacher', 'gallery/XIMCwaslI0VXJ5YctWXHWEYj4rA6ig53jp0e33xh.jpg', 'Events', NULL, 1, 0, '2026-03-27 15:28:57', '2026-03-27 15:28:57'),
(4, 'Moderator', 'gallery/QUsgktkVue8pawOaBoSkYeaMrzryVolVahmqCPi2.jpg', 'Events', NULL, 1, 0, '2026-03-27 15:30:57', '2026-03-27 15:30:57');

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

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"3a2c2acd-faca-4316-a4fd-7a68483a16a2\",\"displayName\":\"App\\\\Mail\\\\DailyProgressNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\DailyProgressNotification\\\":6:{s:7:\\\"student\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Student\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"attendance\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Attendance\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:11:\\\"progressLog\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\ProgressLog\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:4:\\\"date\\\";s:10:\\\"2026-03-19\\\";s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:26:\\\"okashabukhari295@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\",\"batchId\":null},\"createdAt\":1773879199,\"delay\":null}', 0, NULL, 1773879199, 1773879199),
(2, 'default', '{\"uuid\":\"e194ae44-2e3f-489a-a6cd-1e0f97502329\",\"displayName\":\"App\\\\Mail\\\\DailyProgressNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:34:\\\"App\\\\Mail\\\\DailyProgressNotification\\\":5:{s:7:\\\"student\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Student\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:10:\\\"attendance\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:21:\\\"App\\\\Models\\\\Attendance\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:4:\\\"date\\\";s:10:\\\"2026-03-19\\\";s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:16:\\\"test@madrasa.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:3:\\\"job\\\";N;}\",\"batchId\":null},\"createdAt\":1773879199,\"delay\":null}', 0, NULL, 1773879199, 1773879199);

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
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `file_size` varchar(255) DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('lecture','assignment','notes','video','other') NOT NULL DEFAULT 'notes',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'Okasha', 'okashab51@gmail.com', '+923272707981', 'admissions', 'How I can apply here', 1, '2026-03-19 18:23:26', '2026-03-19 18:24:06');

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
(4, '2025_01_01_000010_create_cms_settings_table', 1),
(5, '2025_01_01_000011_create_teachers_table', 1),
(6, '2025_01_01_000012_create_courses_table', 1),
(7, '2025_01_01_000013_create_students_table', 1),
(8, '2025_01_01_000014_create_course_student_table', 1),
(9, '2025_01_01_000015_create_books_table', 1),
(10, '2025_01_01_000016_create_admissions_table', 1),
(11, '2025_01_01_000017_create_galleries_table', 1),
(12, '2025_01_01_000018_create_announcements_table', 1),
(13, '2025_01_01_000019_create_messages_table', 1),
(14, '2025_01_01_000020_create_materials_table', 1),
(15, '2025_01_01_000021_create_activity_logs_table', 1),
(16, '2025_01_01_000022_create_otp_verifications_table', 1),
(17, '2026_03_18_173228_create_categories_table', 2),
(18, '2026_03_18_173307_update_courses_and_students_for_categories', 2),
(19, '2026_03_18_203033_add_user_id_to_teachers', 3),
(20, '2026_03_18_203033_create_attendances_table', 3),
(21, '2026_03_19_015900_update_users_role_column', 4),
(22, '2026_03_18_230807_restructure_madrasa_system', 5),
(23, '2026_03_19_181308_add_boarding_to_admissions_table', 6),
(24, '2026_03_19_185450_add_urdu_support_to_tables', 7),
(25, '2026_03_19_191330_update_announcements_table_for_urdu_and_type', 8),
(26, '2026_03_19_193542_create_events_table', 9),
(27, '2026_03_19_220525_create_exams_table', 10),
(28, '2026_03_21_000000_fix_course_category_shadowing', 11),
(29, '2026_03_21_000001_add_faculty_info_to_teachers', 12),
(30, '2026_03_21_000002_make_teacher_name_nullable', 13),
(31, '2026_03_28_000000_add_name_to_students_table', 14),
(32, '2026_03_27_204525_create_book_categories_table', 15),
(33, '2026_03_27_204556_add_book_category_id_to_books_table', 15);

-- --------------------------------------------------------

--
-- Table structure for table `otp_verifications`
--

CREATE TABLE `otp_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `attempts` int(11) NOT NULL DEFAULT 0,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `resend_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otp_verifications`
--

INSERT INTO `otp_verifications` (`id`, `email`, `otp`, `expires_at`, `attempts`, `is_used`, `resend_count`, `created_at`, `updated_at`) VALUES
(1, 'test@madrasa.com', '$2y$12$43dKDNx14G4ifbJXV9GGf.PHFhurqeaJDyPxbn9NXgeuQc.PhZ.7i', '2026-03-18 12:47:39', 1, 0, 0, '2026-03-18 07:47:14', '2026-03-18 07:47:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('okashab51@gmail.com', '$2y$12$E2EZi8kc0cZFrvVHpKr/E.Jj8IaHahdPGURWzv/GRHK1sSWywV8KC', '2026-03-19 18:16:36');

-- --------------------------------------------------------

--
-- Table structure for table `progress_logs`
--

CREATE TABLE `progress_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `para` int(11) DEFAULT NULL,
  `surah` varchar(255) DEFAULT NULL,
  `ayah_from` varchar(255) DEFAULT NULL,
  `ayah_to` varchar(255) DEFAULT NULL,
  `lesson_type` enum('sabaq','sabqi','manzil') DEFAULT NULL,
  `remarks` text DEFAULT NULL,
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
('2DBwfaDASQyIILaxXitbYW7CehOtXHr6phNx153w', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWXNXTXZCZVhRSUhJZEFWYjJ6cHJtMGRLRzlnNWxOMjAweUNPbkpCQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzM6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9ib29rcyI7fX0=', 1774644772),
('BqCsjYngdC3dqawIFAI0huTiLtlirVHTlEiyjuP9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQUFXaHA4UjRLY1VpcnhEUnoxaURuWk5hc2R1ZllwbHZxMkU0cWlRZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1774646174),
('snxWwjfzJMonbT8KTC1fTjYkt2LqtbAXlzZ4NS6o', 18, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTkdDNTNGUXU0U1o4aEdHSEVqcWtpUmNmZEMwRks1bHNTazhEd3QxNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZWFjaGVyL2V4YW1zIjtzOjU6InJvdXRlIjtzOjE5OiJ0ZWFjaGVyLmV4YW1zLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTg7fQ==', 1774643042);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `program` enum('hifz','nazra','qaida') DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `urdu_name` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `guardian_phone` varchar(255) DEFAULT NULL,
  `cnic` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `batch` varchar(255) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `status` enum('active','inactive','graduated','expelled') NOT NULL DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `name`, `program`, `user_id`, `urdu_name`, `category_id`, `father_name`, `guardian_name`, `guardian_phone`, `cnic`, `dob`, `gender`, `address`, `city`, `class`, `batch`, `enrollment_date`, `status`, `notes`, `created_at`, `updated_at`, `teacher_id`) VALUES
(5, 'STD000001', 'Ahmed Raza', 'hifz', 19, NULL, NULL, NULL, 'Muhammad Raza', '+92 300 9876543', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-03-27 14:39:11', '2026-03-27 14:39:11', 5),
(6, 'STD000002', 'Bilal Khan', 'nazra', 20, NULL, NULL, NULL, 'Imran Khan', '+92 301 8765432', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-03-27 14:50:54', '2026-03-27 15:23:15', 9),
(7, 'STD000003', 'عثمان علی', 'qaida', 21, 'عثمان علی', NULL, NULL, 'Ali Ahmed', '+92 302 7654321', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-03-27 15:08:28', '2026-03-27 15:12:40', 8),
(8, 'STD000004', 'Hassan Mehmood', 'hifz', 22, 'حسن محمود', NULL, NULL, 'Mehmood Ahmed', '+92 303 6543210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-03-27 15:10:28', '2026-03-27 15:10:28', 8),
(9, 'STD000005', 'Okasha Bukhari', 'hifz', 23, 'عکاشہ بخاری', NULL, NULL, 'Shahbaz Bukhari', '03112333657', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-03-27 15:11:50', '2026-03-27 15:11:50', 7);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `urdu_name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `name`, `urdu_name`, `slug`, `designation`, `specialization`, `qualification`, `experience`, `email`, `phone`, `photo`, `bio`, `status`, `order`, `created_at`, `updated_at`) VALUES
(4, 9, 'Ahmad Raza', NULL, 'ahmad-raza', 'Head of Hifz', 'Tajweed', NULL, NULL, 'okashagfx@gmail.com', '03152294541', 'teachers/UK41rToZZoJrGWWrSat7fgh6kFEPZMjROnzxRieA.png', 'Great Teacher of Tajweed', 1, 0, '2026-03-19 12:21:12', '2026-03-19 12:21:12'),
(5, 14, 'Maulana Abdul Rehman', 'مولانا عبد الرحمن', 'maulana-abdul-rehman', 'Head of Hifz', 'Hifz, Tajweed', 'Alim-e-Deen, Hafiz-ul-Quran', '10', 'abdulrehman@madrasa.com', '+92 300 1234567', NULL, 'An experienced Hifz teacher with over 10 years of dedication in Quran memorization training, focusing on strong retention and disciplined revision (Sabqi & Manzil).', 1, 0, '2026-03-21 04:54:55', '2026-03-21 04:54:55'),
(7, 16, NULL, 'قاری محمد عثمان', 'kary-mhmd-aathman', 'تجوید کے ماہر', 'تجوید، ناظرہ', 'مستند تجوید استاد', '8', 'usman.qari@madrasa.com', '+92 301 2345678', NULL, 'تلفظ (مخارج) پر مضبوط حکم کے ساتھ تجوید میں ماہر، طلباء کو روانی اور صحیح قرآن کی تلاوت حاصل کرنے میں مدد کرتا ہے۔', 1, 0, '2026-03-21 05:45:30', '2026-03-21 05:45:30'),
(8, 17, 'Hafiz Bilal Ahmed', NULL, 'hafiz-bilal-ahmed', 'Hifz Instructor', 'Hifz, Revision (Manzil)', 'Hafiz-ul-Quran', '6', 'bilal.hafiz@madrasa.com', '+92 302 3456789', NULL, 'Focused on strengthening memorization through daily revision techniques and improving long-term retention of Quran.', 1, 0, '2026-03-21 05:53:11', '2026-03-21 05:53:11'),
(9, 18, 'Mufti Saad Ahmed', NULL, 'mufti-saad-ahmed', 'Islamic Studies Head', 'Fiqh, Islamic Studies', 'Mufti, Alim-e-Deen', '12', 'saad.mufti@madrasa.com', '+92 304 5678901', NULL, 'Highly qualified Islamic scholar providing guidance in Fiqh and daily Islamic practices with deep understanding of Shariah.', 1, 0, '2026-03-21 05:56:16', '2026-03-21 05:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `avatar`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@madrasa.com', '2026-03-18 16:41:41', '$2y$12$cv//iPYmmyT8Uz4TmQzseOgECSgNtLrSr7K/k6vHiWpiognWatI4K', 'admin', NULL, NULL, 1, NULL, '2026-03-18 07:32:49', '2026-03-18 16:41:41'),
(9, 'Ahmad Raza', 'okashagfx@gmail.com', '2026-03-19 14:55:52', '$2y$12$5AQo8anREDIfTLJtk1qMuu2RAtJyZdDphfZA7reBNjmzhXnWWrERC', 'teacher', NULL, NULL, 1, NULL, '2026-03-19 12:21:10', '2026-03-19 14:55:52'),
(12, 'Test User', 'test@test.com', NULL, '$2y$12$1/Mhl.PC6.9toyc1Pw25VeKhylYQjQZqer8KLZ0Nm63bm3OJOZkR2', 'user', NULL, NULL, 1, NULL, '2026-03-19 18:27:24', '2026-03-19 18:27:24'),
(13, 'Admin Test', 'admin@admin.com', NULL, '$2y$12$x2DoOZHJhzzStVu66dJdx.4ZjDdo61JmsDzQjpswtF8bfG7Fzj.tG', 'user', NULL, NULL, 1, NULL, '2026-03-21 03:22:02', '2026-03-21 03:22:02'),
(14, 'Maulana Abdul Rehman', 'abdulrehman@madrasa.com', NULL, '$2y$12$FBFQzcIiPGGi86vI6Ykcxux0xrSz3IAkxDfzJDNik.TrCqps2NPjW', 'teacher', NULL, NULL, 1, NULL, '2026-03-21 04:54:55', '2026-03-21 04:54:55'),
(16, 'قاری محمد عثمان', 'usman.qari@madrasa.com', NULL, '$2y$12$PRx0Dz.B1nbZgpST1gVpTuDUpAsODUFNY9J8B6cOdGeWFrfpgv3.q', 'teacher', NULL, NULL, 1, NULL, '2026-03-21 05:45:30', '2026-03-21 05:45:30'),
(17, 'Hafiz Bilal Ahmed', 'bilal.hafiz@madrasa.com', NULL, '$2y$12$vq5GK6alN4hgM8YkPih0T.peTTG6E0RsgUqsP.vGMAulroNx55WBS', 'teacher', NULL, NULL, 1, NULL, '2026-03-21 05:53:11', '2026-03-21 05:53:11'),
(18, 'Mufti Saad Ahmed', 'saad.mufti@madrasa.com', NULL, '$2y$12$z4Wr7CQ3Bb9XqUifvPMB7.td73Scp4PcvmlyB9uMQTe1ps76K1Uzu', 'teacher', NULL, NULL, 1, NULL, '2026-03-21 05:56:16', '2026-03-21 05:56:16'),
(19, 'Ahmed Raza', 'ahmed.raza@student.com', NULL, '$2y$12$FXf/KLOeqO53h/ouupU14e2S7Mz8816O0WJyjGxKMW5s7kqd70Fo2', 'student', NULL, NULL, 1, NULL, '2026-03-27 14:39:11', '2026-03-27 14:39:11'),
(20, 'Bilal Khan', 'bilal.khan@student.com', NULL, '$2y$12$h0yU5ET/cKSTvTlXK7N3PO6MZSwMzW3xJ6Bgh7wzl8CUfO5rp.R4i', 'student', NULL, NULL, 1, NULL, '2026-03-27 14:50:54', '2026-03-27 14:50:54'),
(21, 'عثمان علی', 'usman.ali@student.com', NULL, '$2y$12$ZE3CETAhzUoCr9S0QXLT/O7WrGrintSTZuv2QaCm5mfCHRGNZUa2C', 'student', NULL, NULL, 1, NULL, '2026-03-27 15:08:28', '2026-03-27 15:08:28'),
(22, 'Hassan Mehmood', 'hassan.mehmood@student.com', NULL, '$2y$12$teNzVKhwTonxm0ne2UfB9.dAW6K5.edd0c9gXlHwLUByCYhzTiv6u', 'student', NULL, NULL, 1, NULL, '2026-03-27 15:10:28', '2026-03-27 15:10:28'),
(23, 'Okasha Bukhari', 'okashabukhari295@gmail.com', NULL, '$2y$12$7uJcPrnf7Xws/UjKht76puyl3GqwstGSAW.fzlEIvGHerwTkIgzbq', 'student', NULL, NULL, 1, NULL, '2026-03-27 15:11:50', '2026-03-27 15:11:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`),
  ADD KEY `activity_logs_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admissions_user_id_foreign` (`user_id`),
  ADD KEY `admissions_course_id_foreign` (`course_id`),
  ADD KEY `admissions_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_created_by_foreign` (`created_by`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_student_id_date_unique` (`student_id`,`date`),
  ADD KEY `attendances_course_id_foreign` (`course_id`),
  ADD KEY `attendances_teacher_id_foreign` (`teacher_id`),
  ADD KEY `attendances_date_index` (`date`),
  ADD KEY `attendances_student_id_date_index` (`student_id`,`date`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `books_slug_unique` (`slug`),
  ADD KEY `books_book_category_id_foreign` (`book_category_id`);

--
-- Indexes for table `book_categories`
--
ALTER TABLE `book_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `book_categories_slug_unique` (`slug`);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `cms_settings`
--
ALTER TABLE `cms_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cms_settings_key_unique` (`key`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_slug_unique` (`slug`),
  ADD KEY `courses_teacher_id_foreign` (`teacher_id`),
  ADD KEY `courses_category_id_foreign` (`category_id`);

--
-- Indexes for table `course_student`
--
ALTER TABLE `course_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_student_course_id_foreign` (`course_id`),
  ADD KEY `course_student_student_id_foreign` (`student_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_created_by_foreign` (`created_by`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exams_student_id_exam_type_date_unique` (`student_id`,`exam_type`,`date`),
  ADD KEY `exams_student_id_date_index` (`student_id`,`date`),
  ADD KEY `exams_teacher_id_date_index` (`teacher_id`,`date`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materials_course_id_foreign` (`course_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otp_verifications_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `progress_logs`
--
ALTER TABLE `progress_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `progress_logs_student_id_date_unique` (`student_id`,`date`),
  ADD KEY `progress_logs_teacher_id_foreign` (`teacher_id`),
  ADD KEY `progress_logs_date_index` (`date`),
  ADD KEY `progress_logs_student_id_date_index` (`student_id`,`date`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_student_id_unique` (`student_id`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_category_id_foreign` (`category_id`),
  ADD KEY `students_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_slug_unique` (`slug`),
  ADD KEY `teachers_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_categories`
--
ALTER TABLE `book_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cms_settings`
--
ALTER TABLE `cms_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `course_student`
--
ALTER TABLE `course_student`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `progress_logs`
--
ALTER TABLE `progress_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `admissions`
--
ALTER TABLE `admissions`
  ADD CONSTRAINT `admissions_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `admissions_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `admissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_book_category_id_foreign` FOREIGN KEY (`book_category_id`) REFERENCES `book_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `courses_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `course_student`
--
ALTER TABLE `course_student`
  ADD CONSTRAINT `course_student_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_student_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `progress_logs`
--
ALTER TABLE `progress_logs`
  ADD CONSTRAINT `progress_logs_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `progress_logs_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
