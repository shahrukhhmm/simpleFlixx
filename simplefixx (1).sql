-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2025 at 04:30 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simplefixx`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctor_details`
--

CREATE TABLE `doctor_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `education` varchar(255) DEFAULT NULL,
  `specialty` varchar(255) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `hospital` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_details`
--

INSERT INTO `doctor_details` (`id`, `user_id`, `education`, `specialty`, `experience`, `hospital`, `created_at`, `updated_at`) VALUES
(1, 5, 'MBBS', 'Cardiology', 5, 'abc hospital', '2025-06-15 06:24:06', '2025-06-15 06:24:06'),
(2, 4, 'MD', 'Physician', 2, 'country hsopital', '2025-06-15 06:24:46', '2025-06-15 06:24:46');

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
(5, '2014_10_12_000000_create_users_table', 1),
(6, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(7, '2019_08_19_000000_create_failed_jobs_table', 1),
(8, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(9, '2025_06_15_111851_create_doctor_details_table', 2),
(10, '2025_06_15_113248_create_pharmacy_details_table', 3),
(12, '2025_06_19_164111_create_orders_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `health_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`health_history`)),
  `weight_management_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`weight_management_history`)),
  `medication_requests` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`medication_requests`)),
  `add_ons` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`add_ons`)),
  `shipping_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`shipping_options`)),
  `consent` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`consent`)),
  `payment_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_details`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `health_history`, `weight_management_history`, `medication_requests`, `add_ons`, `shipping_options`, `consent`, `payment_details`, `created_at`, `updated_at`) VALUES
(1, 1, '\"{\\\"height_cm\\\":\\\"55\\\",\\\"weight_kg\\\":\\\"45\\\",\\\"discontinued_conditions\\\":[\\\"vomiting\\\"],\\\"how_often\\\":\\\"2-3 days a week\\\",\\\"weight_loss_medications\\\":[\\\"phentermine\\\"],\\\"past_year_guilt\\\":[\\\"nausea_element\\\"],\\\"past_month_diagnosis\\\":[\\\"yes\\\"],\\\"disease_conditions\\\":[\\\"no\\\"],\\\"sleep_apnea\\\":[\\\"yes\\\"],\\\"thyroid_disease\\\":[\\\"no\\\"],\\\"mental_health\\\":[\\\"yes\\\"],\\\"thyroid_tumor\\\":[\\\"yes\\\"],\\\"eating_disorder\\\":[\\\"no\\\"],\\\"pregnancy_breastfeeding\\\":[\\\"no\\\"],\\\"getting_pregnant\\\":[\\\"no\\\"],\\\"type_diabetes\\\":[\\\"yes\\\"],\\\"substance_abuse\\\":[\\\"yes\\\"],\\\"bariatric_surgery\\\":[\\\"yes\\\"],\\\"dose_increase\\\":[\\\"yes\\\"],\\\"video_consultation\\\":\\\"text\\\"}\"', '\"{\\\"notice_acknowledged\\\":true}\"', '\"{\\\"requested_medication\\\":\\\"asadasd\\\",\\\"requested_rx\\\":\\\"GLP-1 with Hyaluron Maintenance Package $350\\\"}\"', '\"{\\\"side_effects\\\":\\\"nausea\\\",\\\"purchased_medication\\\":\\\"yes\\\",\\\"prescription_increase\\\":\\\"yes_slow\\\",\\\"add_b12\\\":\\\"yes\\\",\\\"add_glycine\\\":\\\"yes\\\",\\\"glp1_issues\\\":\\\"yes\\\",\\\"add_nausea_med\\\":\\\"no\\\",\\\"0\\\":\\\"Anti-Aging Medication $30 - 4 mg Ondansetron\\\",\\\"1\\\":\\\"Anti-Aging Pills $30 - 20-Count\\\",\\\"2\\\":\\\"Phentermine 37.5 mg $60 - 60-Count\\\",\\\"3\\\":\\\"NAD+ Anti-Aging $179 - 3 month supply\\\",\\\"4\\\":\\\"NAD+ $309 - 6 month supply\\\",\\\"5\\\":\\\"Hydration Honey PM Moisturizer $40\\\",\\\"6\\\":\\\"Royal H2 Anti-Aging Body Oil $40\\\",\\\"7\\\":\\\"Royal H2 Daily Moisturizer with Zinc Oxide $40\\\",\\\"8\\\":\\\"Royal Honeysuckle Body and Hair Smoothing Balm $37\\\",\\\"9\\\":\\\"Anti-Acne Facial Polish $20\\\"}\"', '\"{\\\"shipping_address_line1\\\":\\\"asdasd\\\",\\\"shipping_address_line2\\\":\\\"asd\\\",\\\"shipping_city\\\":\\\"asdasdas\\\",\\\"shipping_state\\\":\\\"sadas\\\",\\\"shipping_zip\\\":\\\"6456456\\\",\\\"billing_same_as_shipping\\\":\\\"1\\\",\\\"billing_address_line1\\\":\\\"jajidsgkjsa\\\",\\\"billing_address_line2\\\":\\\"jsakdh\\\",\\\"billing_city\\\":\\\"asd\\\",\\\"billing_state\\\":\\\"asd\\\",\\\"billing_zip\\\":\\\"45687\\\",\\\"shipping_type\\\":\\\"standard\\\"}\"', '\"{\\\"signature\\\":\\\"asdsad asd sa d\\\"}\"', NULL, '2025-06-20 07:26:08', '2025-06-20 07:26:08');

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

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_details`
--

CREATE TABLE `pharmacy_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tel_no` varchar(255) DEFAULT NULL,
  `second_address` varchar(255) DEFAULT NULL,
  `fax_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pharmacy_details`
--

INSERT INTO `pharmacy_details` (`id`, `user_id`, `tel_no`, `second_address`, `fax_no`, `created_at`, `updated_at`) VALUES
(1, 6, '5646521365425', 'Rawalpindi', '345423542132', '2025-06-15 06:40:04', '2025-06-15 06:40:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `status`, `email_verified_at`, `password`, `phone`, `date_of_birth`, `sex`, `state`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin', 'active', NULL, '$2y$12$xo/zrK2dHcQvC.zpXdbSYunYeuzPpbv/Dz9fhfHOR1SjgLkUsrxD2', NULL, NULL, NULL, NULL, NULL, '2025-06-15 10:48:25', NULL),
(2, 'csutomer', 'customer@gmail.com', 'customer', 'active', NULL, '$2y$12$LEbYoic1so36AVr1pC8sV.Z2w0rqg1GFW5Mommq.IB7IKg6v/ng9.', '03445566158', '2025-06-20', 'female', 'punjab', NULL, '2025-06-15 05:53:10', '2025-06-20 08:44:46'),
(3, 'customer22', 'customer2@gmail.com', 'customer', 'pending', NULL, '$2y$12$V8Uic.DWdc8sH6plVevxROSMn.djnkgJXgGe6zloiP02vDGFolgI2', '13046540325', '2025-06-15', 'female', 'punjab', NULL, '2025-06-15 06:01:53', '2025-06-15 06:01:53'),
(4, 'doctor', 'doctor@gmail.com', 'doctor', 'active', NULL, '$2y$12$IWLBLNtFW167zU53MSzkQ..yqjTSKkYI5gCBh7mOnHyqMSosA13xW', '03445566158', NULL, 'male', 'punjab', NULL, '2025-06-15 06:23:06', '2025-06-20 09:04:58'),
(5, 'doctor', 'doctor2@gmail.com', 'doctor', 'active', NULL, '$2y$12$8HQnldPbF4B5sInng9Jmze1Iqxvxe2xAJyQYkZUWzCXc2cZIYB9le', '03445566158', '2025-06-16', 'male', 'punjab', NULL, '2025-06-15 06:24:06', '2025-06-15 06:24:06'),
(6, 'pharmacy', 'pharmacy@mail.com', 'pharmacy', 'active', NULL, '$2y$12$isU9gJTVDpa.DmsqNDGueeuwcGCwS5Ecz696LAfq/FYikQRnh6qvi', '03246504034', NULL, NULL, 'masdjk', NULL, '2025-06-15 06:40:04', '2025-06-15 06:40:04'),
(7, 'csutoemra sdasd', 'customer213@gmail.com', 'customer', 'active', NULL, '$2y$12$t6/1PwHJej5.fXvhBJFFTeXbFYxJDXgDdn6HhLcAZaeHBdXuoikoC', '64050654534', '2025-06-15', 'other', 'pub', NULL, '2025-06-15 07:01:03', '2025-06-15 07:02:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctor_details`
--
ALTER TABLE `doctor_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

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
-- Indexes for table `pharmacy_details`
--
ALTER TABLE `pharmacy_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pharmacy_details_user_id_foreign` (`user_id`);

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
-- AUTO_INCREMENT for table `doctor_details`
--
ALTER TABLE `doctor_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pharmacy_details`
--
ALTER TABLE `pharmacy_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctor_details`
--
ALTER TABLE `doctor_details`
  ADD CONSTRAINT `doctor_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pharmacy_details`
--
ALTER TABLE `pharmacy_details`
  ADD CONSTRAINT `pharmacy_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
