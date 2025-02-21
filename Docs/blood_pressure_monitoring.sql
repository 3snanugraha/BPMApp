-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 21, 2025 at 01:30 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_pressure_monitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood_pressure_readings`
--

CREATE TABLE `blood_pressure_readings` (
  `reading_id` int NOT NULL,
  `patient_id` int DEFAULT NULL,
  `systolic` int NOT NULL,
  `diastolic` int NOT NULL,
  `pulse_rate` int DEFAULT NULL,
  `reading_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blood_pressure_readings`
--

INSERT INTO `blood_pressure_readings` (`reading_id`, `patient_id`, `systolic`, `diastolic`, `pulse_rate`, `reading_date`, `notes`) VALUES
(1, 1, 130, 85, 75, '2025-02-19 22:05:47', 'Pengukuran pagi hari'),
(2, 1, 135, 88, 78, '2025-02-19 22:05:47', 'Setelah olahraga'),
(3, 2, 128, 82, 72, '2025-02-19 22:05:47', 'Pengukuran rutin'),
(4, 2, 125, 70, 90, '2025-02-19 22:05:47', 'Kondisi istirahat');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_patients`
--

CREATE TABLE `doctor_patients` (
  `doctor_id` int NOT NULL,
  `patient_id` int NOT NULL,
  `assigned_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctor_patients`
--

INSERT INTO `doctor_patients` (`doctor_id`, `patient_id`, `assigned_date`) VALUES
(1, 1, '2025-02-19 22:05:47'),
(2, 2, '2025-02-19 22:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_profiles`
--

CREATE TABLE `doctor_profiles` (
  `doctor_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `license_number` varchar(50) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctor_profiles`
--

INSERT INTO `doctor_profiles` (`doctor_id`, `user_id`, `full_name`, `specialization`, `license_number`, `phone_number`) VALUES
(1, 2, 'Dr. Budi Santoso', 'Spesialis Jantung', 'IDN-123456', '081234567890'),
(2, 3, 'Dr. Ani Wijaya', 'Spesialis Penyakit Dalam', 'IDN-789012', '081234567891');

-- --------------------------------------------------------

--
-- Table structure for table `medications`
--

CREATE TABLE `medications` (
  `medication_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `dosage_form` varchar(50) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `medications`
--

INSERT INTO `medications` (`medication_id`, `name`, `description`, `dosage_form`, `created_by`, `created_at`) VALUES
(1, 'Amlodipin', 'Obat untuk menurunkan tekanan darah tinggi', 'Tablet 5mg', 1, '2025-02-19 22:05:47'),
(2, 'Captopril', 'ACE inhibitor untuk hipertensi', 'Tablet 25mg', 1, '2025-02-19 22:05:47'),
(3, 'Bisoprolol', 'Beta blocker untuk tekanan darah', 'Tablet 5mg', 1, '2025-02-19 22:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `patient_medications`
--

CREATE TABLE `patient_medications` (
  `patient_medication_id` int NOT NULL,
  `patient_id` int DEFAULT NULL,
  `medication_id` int DEFAULT NULL,
  `dosage` varchar(50) DEFAULT NULL,
  `frequency` varchar(50) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `prescribed_by` int DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient_medications`
--

INSERT INTO `patient_medications` (`patient_medication_id`, `patient_id`, `medication_id`, `dosage`, `frequency`, `start_date`, `end_date`, `prescribed_by`, `notes`) VALUES
(1, 1, 1, '1 tablet', 'Sekali sehari', '2025-02-21', '2024-01-01', 1, 'Diminum pagi hari'),
(2, 2, 2, '1 tablet', 'Dua kali sehari', '2025-02-21', '2025-03-21', 2, 'Diminum pagi dan malam'),
(3, 2, 1, '1 Tablet', '3x Sehari', '2025-02-22', '2025-02-25', 1, 'Tidak dimakan, tapi diminum');

-- --------------------------------------------------------

--
-- Table structure for table `patient_profiles`
--

CREATE TABLE `patient_profiles` (
  `patient_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `address` text,
  `phone_number` varchar(20) DEFAULT NULL,
  `emergency_contact` varchar(100) DEFAULT NULL,
  `emergency_phone` varchar(20) DEFAULT NULL,
  `medical_history` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient_profiles`
--

INSERT INTO `patient_profiles` (`patient_id`, `user_id`, `full_name`, `date_of_birth`, `gender`, `address`, `phone_number`, `emergency_contact`, `emergency_phone`, `medical_history`) VALUES
(1, 4, 'Ahmad Hidayat', '1990-05-15', 'M', 'Jl. Merdeka No. 123, Jakarta', '081234567892', 'Sinta Hidayat', '081234567893', 'Riwayat hipertensi keluarga'),
(2, 5, 'Siti Rahayu', '1985-08-20', 'F', 'Jl. Sudirman No. 45, Bandung', '081234567894', 'Rudi Rahayu', '081234567895', 'Alergi penisilin');

-- --------------------------------------------------------

--
-- Table structure for table `patient_recommendations`
--

CREATE TABLE `patient_recommendations` (
  `patient_recommendation_id` int NOT NULL,
  `patient_id` int DEFAULT NULL,
  `reading_id` int DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `patient_recommendations`
--

INSERT INTO `patient_recommendations` (`patient_recommendation_id`, `patient_id`, `reading_id`, `title`, `description`, `created_by`, `created_at`) VALUES
(1, 1, 1, 'Prehipertensi - Perlu Perhatian', 'Tekanan darah Anda sedikit tinggi. Disarankan untuk:\r\n- Kurangi asupan garam\r\n- Tingkatkan aktivitas fisik\r\n- Hindari stres berlebih\r\n- Pantau tekanan darah secara rutin', 2, '2025-02-19 15:05:47'),
(2, 1, 2, 'Evaluasi Pasca Olahraga', 'Tekanan darah pasca olahraga menunjukkan respon normal. Rekomendasi:\r\n- Pertahankan rutinitas olahraga\r\n- Istirahat cukup\r\n- Jaga hidrasi\r\n- Lakukan pendinginan setelah olahraga', 2, '2025-02-19 15:05:47'),
(3, 2, 3, 'Tekanan Darah Normal', 'Hasil pemeriksaan menunjukkan tekanan darah normal. Saran:\n- Pertahankan pola makan sehat\n- Lanjutkan aktivitas fisik teratur\n- Jaga kualitas tidur\n- Lakukan pemeriksaan rutin', 3, '2025-02-19 15:05:47'),
(4, 2, 4, 'Kondisi Optimal', 'Tekanan darah dalam kondisi optimal. Rekomendasi:\n- Pertahankan gaya hidup sehat\n- Konsumsi makanan seimbang\n- Kelola stres dengan baik\n- Rutin check-up kesehatan', 3, '2025-02-19 15:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','doctor','patient') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@bpm.com', 'admin', '2025-02-19 22:05:47', '2025-02-19 22:05:57'),
(2, 'dr.budi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'budi@bpm.com', 'doctor', '2025-02-19 22:05:47', '2025-02-19 22:05:47'),
(3, 'dr.ani', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ani@bpm.com', 'doctor', '2025-02-19 22:05:47', '2025-02-19 22:05:47'),
(4, 'ahmad', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ahmad@mail.com', 'patient', '2025-02-19 22:05:47', '2025-02-19 22:05:47'),
(5, 'siti', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'siti@mail.com', 'patient', '2025-02-19 22:05:47', '2025-02-21 00:39:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood_pressure_readings`
--
ALTER TABLE `blood_pressure_readings`
  ADD PRIMARY KEY (`reading_id`),
  ADD KEY `idx_bp_readings_patient_date` (`patient_id`,`reading_date`);

--
-- Indexes for table `doctor_patients`
--
ALTER TABLE `doctor_patients`
  ADD PRIMARY KEY (`doctor_id`,`patient_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `license_number` (`license_number`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `medications`
--
ALTER TABLE `medications`
  ADD PRIMARY KEY (`medication_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `patient_medications`
--
ALTER TABLE `patient_medications`
  ADD PRIMARY KEY (`patient_medication_id`),
  ADD KEY `medication_id` (`medication_id`),
  ADD KEY `prescribed_by` (`prescribed_by`),
  ADD KEY `idx_patient_meds_patient` (`patient_id`);

--
-- Indexes for table `patient_profiles`
--
ALTER TABLE `patient_profiles`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `patient_recommendations`
--
ALTER TABLE `patient_recommendations`
  ADD PRIMARY KEY (`patient_recommendation_id`),
  ADD KEY `reading_id` (`reading_id`),
  ADD KEY `idx_patient_recommendations_patient` (`patient_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blood_pressure_readings`
--
ALTER TABLE `blood_pressure_readings`
  MODIFY `reading_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  MODIFY `doctor_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `medications`
--
ALTER TABLE `medications`
  MODIFY `medication_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patient_medications`
--
ALTER TABLE `patient_medications`
  MODIFY `patient_medication_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `patient_profiles`
--
ALTER TABLE `patient_profiles`
  MODIFY `patient_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patient_recommendations`
--
ALTER TABLE `patient_recommendations`
  MODIFY `patient_recommendation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_pressure_readings`
--
ALTER TABLE `blood_pressure_readings`
  ADD CONSTRAINT `blood_pressure_readings_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_profiles` (`patient_id`);

--
-- Constraints for table `doctor_patients`
--
ALTER TABLE `doctor_patients`
  ADD CONSTRAINT `doctor_patients_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor_profiles` (`doctor_id`),
  ADD CONSTRAINT `doctor_patients_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patient_profiles` (`patient_id`);

--
-- Constraints for table `doctor_profiles`
--
ALTER TABLE `doctor_profiles`
  ADD CONSTRAINT `doctor_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `medications`
--
ALTER TABLE `medications`
  ADD CONSTRAINT `medications_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `patient_medications`
--
ALTER TABLE `patient_medications`
  ADD CONSTRAINT `patient_medications_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_profiles` (`patient_id`),
  ADD CONSTRAINT `patient_medications_ibfk_2` FOREIGN KEY (`medication_id`) REFERENCES `medications` (`medication_id`),
  ADD CONSTRAINT `patient_medications_ibfk_3` FOREIGN KEY (`prescribed_by`) REFERENCES `doctor_profiles` (`doctor_id`);

--
-- Constraints for table `patient_profiles`
--
ALTER TABLE `patient_profiles`
  ADD CONSTRAINT `patient_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `patient_recommendations`
--
ALTER TABLE `patient_recommendations`
  ADD CONSTRAINT `patient_recommendations_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patient_profiles` (`patient_id`),
  ADD CONSTRAINT `patient_recommendations_ibfk_3` FOREIGN KEY (`reading_id`) REFERENCES `blood_pressure_readings` (`reading_id`),
  ADD CONSTRAINT `patient_recommendations_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
