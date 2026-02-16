-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for system_services
CREATE DATABASE IF NOT EXISTS `system_services` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `system_services`;

-- Dumping structure for table system_services.academic_affairs
CREATE TABLE IF NOT EXISTS `academic_affairs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `office_code` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `office_code` (`office_code`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table system_services.academic_affairs: ~0 rows (approximately)
DELETE FROM `academic_affairs`;
INSERT INTO `academic_affairs` (`id`, `full_name`, `office_code`, `email`, `created_at`) VALUES
	(1, 'Phòng Học vụ CNTT', 'HV_CNTT', 'hocvu_cntt@university.edu.vn', '2026-02-16 16:06:51');

-- Dumping structure for table system_services.academic_results
CREATE TABLE IF NOT EXISTS `academic_results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `course_class_id` bigint unsigned NOT NULL,
  `process_score` decimal(4,2) DEFAULT NULL,
  `midterm_score` decimal(4,2) DEFAULT NULL,
  `final_exam_score` decimal(4,2) DEFAULT NULL,
  `final_grade` decimal(5,2) DEFAULT NULL,
  `grade_letter` char(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `result` enum('pass','fail') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `frequent_scores` text COLLATE utf8mb4_general_ci COMMENT 'JSON điểm thường xuyên',
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`,`course_class_id`),
  KEY `course_class_id` (`course_class_id`),
  CONSTRAINT `academic_results_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  CONSTRAINT `academic_results_ibfk_2` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.academic_results: ~3 rows (approximately)
DELETE FROM `academic_results`;
INSERT INTO `academic_results` (`id`, `student_id`, `course_class_id`, `process_score`, `midterm_score`, `final_exam_score`, `final_grade`, `grade_letter`, `result`, `frequent_scores`) VALUES
	(1, 22, 1, 10.00, 9.50, 10.00, 9.90, 'A', 'pass', '["10","10","10"]'),
	(2, 25, 1, 10.00, 10.00, 10.00, 10.00, 'A', 'pass', '["10","10","10"]'),
	(3, 16, 1, 10.00, NULL, 8.00, 4.80, 'D', 'pass', '["10"]');

-- Dumping structure for table system_services.attendance
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `course_class_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late') COLLATE utf8mb4_general_ci DEFAULT 'present',
  `session_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `course_class_id` (`course_class_id`),
  KEY `fk_attendance_session` (`session_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_attendance_session` FOREIGN KEY (`session_id`) REFERENCES `class_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.attendance: ~45 rows (approximately)
DELETE FROM `attendance`;
INSERT INTO `attendance` (`id`, `student_id`, `course_class_id`, `date`, `status`, `session_id`) VALUES
	(1, 16, 1, '2025-09-02', 'present', 1),
	(2, 16, 1, '2025-09-09', 'absent', 2),
	(3, 16, 1, '2025-09-16', 'absent', 3),
	(4, 16, 1, '2025-09-23', 'absent', 4),
	(5, 16, 1, '2025-09-30', 'absent', 5),
	(6, 16, 1, '2025-10-07', 'absent', 6),
	(7, 16, 1, '2025-10-14', 'absent', 7),
	(8, 16, 1, '2025-10-21', 'absent', 8),
	(9, 16, 1, '2025-10-28', 'absent', 9),
	(10, 16, 1, '2025-11-04', 'absent', 10),
	(11, 16, 1, '2025-11-11', 'absent', 11),
	(12, 16, 1, '2025-11-18', 'absent', 12),
	(13, 16, 1, '2025-11-25', 'absent', 13),
	(14, 16, 1, '2025-12-02', 'absent', 14),
	(15, 16, 1, '2025-12-09', 'absent', 15),
	(16, 22, 1, '2025-09-02', 'present', 1),
	(17, 22, 1, '2025-09-09', 'present', 2),
	(18, 22, 1, '2025-09-16', 'present', 3),
	(19, 22, 1, '2025-09-23', 'present', 4),
	(20, 22, 1, '2025-09-30', 'present', 5),
	(21, 22, 1, '2025-10-07', 'present', 6),
	(22, 22, 1, '2025-10-14', 'present', 7),
	(23, 22, 1, '2025-10-21', 'present', 8),
	(24, 22, 1, '2025-10-28', 'present', 9),
	(25, 22, 1, '2025-11-04', 'present', 10),
	(26, 22, 1, '2025-11-11', 'present', 11),
	(27, 22, 1, '2025-11-18', 'present', 12),
	(28, 22, 1, '2025-11-25', 'present', 13),
	(29, 22, 1, '2025-12-02', 'present', 14),
	(30, 22, 1, '2025-12-09', 'present', 15),
	(31, 25, 1, '2025-09-02', 'absent', 1),
	(32, 25, 1, '2025-09-09', 'absent', 2),
	(33, 25, 1, '2025-09-16', 'absent', 3),
	(34, 25, 1, '2025-09-23', 'absent', 4),
	(35, 25, 1, '2025-09-30', 'absent', 5),
	(36, 25, 1, '2025-10-07', 'absent', 6),
	(37, 25, 1, '2025-10-14', 'absent', 7),
	(38, 25, 1, '2025-10-21', 'absent', 8),
	(39, 25, 1, '2025-10-28', 'absent', 9),
	(40, 25, 1, '2025-11-04', 'absent', 10),
	(41, 25, 1, '2025-11-11', 'absent', 11),
	(42, 25, 1, '2025-11-18', 'absent', 12),
	(43, 25, 1, '2025-11-25', 'absent', 13),
	(44, 25, 1, '2025-12-02', 'absent', 14),
	(45, 25, 1, '2025-12-09', 'absent', 15);

-- Dumping structure for table system_services.audit_logs
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `target_type` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `target_id` bigint unsigned DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `audit_logs_chk_1` CHECK (json_valid(`data`))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.audit_logs: ~2 rows (approximately)
DELETE FROM `audit_logs`;
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `target_type`, `target_id`, `data`, `created_at`) VALUES
	(1, 1, 'CREATE', 'student', 16, '{"student":"SV001"}', '2026-01-07 11:15:57'),
	(2, 2, 'UPDATE', 'academic_results', 1, '{"grade":8.5}', '2026-01-07 11:15:57');

-- Dumping structure for table system_services.classes
CREATE TABLE IF NOT EXISTS `classes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class_code` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `department_id` bigint unsigned NOT NULL,
  `lecturer_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `class_code` (`class_code`),
  KEY `department_id` (`department_id`),
  KEY `lecturer_id` (`lecturer_id`),
  CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE,
  CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.classes: ~3 rows (approximately)
DELETE FROM `classes`;
INSERT INTO `classes` (`id`, `class_name`, `class_code`, `department_id`, `lecturer_id`) VALUES
	(1, 'CNTT K19A', 'CNTT19Aa', 3, 4),
	(2, 'CNTT K19B', 'CNTT19a', 3, 11),
	(3, 'cnt03', 'cnt04', 2, 4);

-- Dumping structure for table system_services.class_sessions
CREATE TABLE IF NOT EXISTS `class_sessions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_class_id` bigint unsigned NOT NULL,
  `session_date` date NOT NULL,
  `day_of_week` tinyint NOT NULL,
  `session` enum('Sáng','Chiều') COLLATE utf8mb4_general_ci NOT NULL,
  `week_number` int NOT NULL,
  `room_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_class_date` (`course_class_id`,`session_date`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `class_sessions_ibfk_1` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `class_sessions_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.class_sessions: ~35 rows (approximately)
DELETE FROM `class_sessions`;
INSERT INTO `class_sessions` (`id`, `course_class_id`, `session_date`, `day_of_week`, `session`, `week_number`, `room_id`, `created_at`) VALUES
	(1, 1, '2025-09-02', 2, 'Sáng', 1, 1, '2026-02-03 09:05:16'),
	(2, 1, '2025-09-09', 2, 'Sáng', 2, 1, '2026-02-03 09:05:16'),
	(3, 1, '2025-09-16', 2, 'Sáng', 3, 1, '2026-02-03 09:05:16'),
	(4, 1, '2025-09-23', 2, 'Sáng', 4, 1, '2026-02-03 09:05:16'),
	(5, 1, '2025-09-30', 2, 'Sáng', 5, 1, '2026-02-03 09:05:16'),
	(6, 1, '2025-10-07', 2, 'Sáng', 6, 1, '2026-02-03 09:05:16'),
	(7, 1, '2025-10-14', 2, 'Sáng', 7, 1, '2026-02-03 09:05:16'),
	(8, 1, '2025-10-21', 2, 'Sáng', 8, 1, '2026-02-03 09:05:16'),
	(9, 1, '2025-10-28', 2, 'Sáng', 9, 1, '2026-02-03 09:05:16'),
	(10, 1, '2025-11-04', 2, 'Sáng', 10, 1, '2026-02-03 09:05:16'),
	(11, 1, '2025-11-11', 2, 'Sáng', 11, 1, '2026-02-03 09:05:16'),
	(12, 1, '2025-11-18', 2, 'Sáng', 12, 1, '2026-02-03 09:05:16'),
	(13, 1, '2025-11-25', 2, 'Sáng', 13, 1, '2026-02-03 09:05:16'),
	(14, 1, '2025-12-02', 2, 'Sáng', 14, 1, '2026-02-03 09:05:16'),
	(15, 1, '2025-12-09', 2, 'Sáng', 15, 1, '2026-02-03 09:05:16'),
	(16, 10, '2025-09-04', 4, 'Chiều', 1, NULL, '2026-02-06 17:35:13'),
	(17, 10, '2025-09-11', 4, 'Chiều', 2, NULL, '2026-02-06 17:35:13'),
	(18, 10, '2025-09-18', 4, 'Chiều', 3, NULL, '2026-02-06 17:35:13'),
	(19, 10, '2025-09-25', 4, 'Chiều', 4, NULL, '2026-02-06 17:35:13'),
	(20, 10, '2025-10-02', 4, 'Chiều', 5, NULL, '2026-02-06 17:35:13'),
	(21, 10, '2025-10-09', 4, 'Chiều', 6, NULL, '2026-02-06 17:35:13'),
	(22, 10, '2025-10-16', 4, 'Chiều', 7, NULL, '2026-02-06 17:35:13'),
	(23, 11, '2025-09-05', 5, 'Chiều', 1, NULL, '2026-02-11 04:27:49'),
	(24, 11, '2025-09-12', 5, 'Chiều', 2, NULL, '2026-02-11 04:27:49'),
	(25, 11, '2025-09-19', 5, 'Chiều', 3, NULL, '2026-02-11 04:27:49'),
	(26, 11, '2025-09-26', 5, 'Chiều', 4, NULL, '2026-02-11 04:27:49'),
	(27, 11, '2025-10-03', 5, 'Chiều', 5, NULL, '2026-02-11 04:27:49'),
	(28, 11, '2025-10-10', 5, 'Chiều', 6, NULL, '2026-02-11 04:27:49'),
	(29, 11, '2025-10-17', 5, 'Chiều', 7, NULL, '2026-02-11 04:27:49'),
	(30, 11, '2025-10-24', 5, 'Chiều', 8, NULL, '2026-02-11 04:27:49'),
	(31, 12, '2025-09-06', 6, 'Chiều', 1, NULL, '2026-02-14 09:30:43'),
	(32, 12, '2025-09-13', 6, 'Chiều', 2, NULL, '2026-02-14 09:30:43'),
	(33, 12, '2025-09-20', 6, 'Chiều', 3, NULL, '2026-02-14 09:30:43'),
	(34, 12, '2025-09-27', 6, 'Chiều', 4, NULL, '2026-02-14 09:30:43'),
	(35, 12, '2025-10-04', 6, 'Chiều', 5, NULL, '2026-02-14 09:30:43'),
	(36, 12, '2025-10-11', 6, 'Chiều', 6, NULL, '2026-02-14 09:30:43'),
	(37, 12, '2025-10-18', 6, 'Chiều', 7, NULL, '2026-02-14 09:30:43'),
	(38, 12, '2025-10-25', 6, 'Chiều', 8, NULL, '2026-02-14 09:30:43');

-- Dumping structure for table system_services.course_classes
CREATE TABLE IF NOT EXISTS `course_classes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` bigint unsigned NOT NULL,
  `lecturer_id` bigint unsigned NOT NULL,
  `semester_id` bigint unsigned NOT NULL,
  `class_code` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `max_students` int DEFAULT '60',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_subject_lecturer_semester` (`subject_id`,`lecturer_id`,`semester_id`),
  UNIQUE KEY `class_code` (`class_code`,`semester_id`),
  KEY `subject_id` (`subject_id`),
  KEY `lecturer_id` (`lecturer_id`),
  KEY `semester_id` (`semester_id`),
  CONSTRAINT `course_classes_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_classes_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_classes_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.course_classes: ~3 rows (approximately)
DELETE FROM `course_classes`;
INSERT INTO `course_classes` (`id`, `subject_id`, `lecturer_id`, `semester_id`, `class_code`, `max_students`) VALUES
	(1, 2, 61, 1, 'PHP1', 60),
	(3, 3, 4, 1, '2026BMPM000001', 40),
	(8, 1, 11, 1, '2026BMPM000004', 20),
	(10, 4, 61, 1, '2026KCNTT000001', 60),
	(11, 4, 11, 1, '2026KCNTT000002', 60),
	(12, 3, 11, 1, '2026BMPM000005', 60);

-- Dumping structure for table system_services.department
CREATE TABLE IF NOT EXISTS `department` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('school','faculty','department') COLLATE utf8mb4_general_ci NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `staff_count` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `department_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `department` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.department: ~4 rows (approximately)
DELETE FROM `department`;
INSERT INTO `department` (`id`, `name`, `type`, `parent_id`, `staff_count`, `created_at`, `updated_at`) VALUES
	(1, 'Trường Đại học CNTT', 'faculty', 2, 200, '2026-01-07 11:41:17', '2026-01-23 05:44:37'),
	(2, 'Khoa Công nghệ Thông tin', 'faculty', 1, 80, '2026-01-07 11:41:17', '2026-01-07 11:41:17'),
	(3, 'Bộ môn Phần mềm', 'department', 2, 40, '2026-01-07 11:41:17', '2026-01-07 11:41:17'),
	(6, 'mewmew', 'faculty', 2, NULL, '2026-02-14 16:24:53', NULL);

-- Dumping structure for table system_services.exam_office
CREATE TABLE IF NOT EXISTS `exam_office` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `office_code` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `office_code` (`office_code`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table system_services.exam_office: ~0 rows (approximately)
DELETE FROM `exam_office`;
INSERT INTO `exam_office` (`id`, `full_name`, `office_code`, `email`, `created_at`) VALUES
	(1, 'Phòng Khảo thí CNTT', 'KT_CNTT', 'khaothi_cntt@university.edu.vn', '2026-02-16 16:06:51');

-- Dumping structure for table system_services.learning_materials
CREATE TABLE IF NOT EXISTS `learning_materials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subject_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_url` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` enum('pdf','video','doc') COLLATE utf8mb4_general_ci DEFAULT 'pdf',
  PRIMARY KEY (`id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `learning_materials_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.learning_materials: ~3 rows (approximately)
DELETE FROM `learning_materials`;
INSERT INTO `learning_materials` (`id`, `subject_id`, `title`, `file_url`, `type`) VALUES
	(1, 1, 'Giáo trình C', '/uploads/c.pdf', 'pdf'),
	(2, 2, 'PHP MVC Video', '/uploads/php.mp4', 'video'),
	(3, 3, 'MySQL Tài liệu', '/uploads/mysql.docx', 'doc');

-- Dumping structure for table system_services.lecturer
CREATE TABLE IF NOT EXISTS `lecturer` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lecturer_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `department_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lecturer_code` (`lecturer_code`),
  UNIQUE KEY `email` (`email`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `lecturer_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.lecturer: ~4 rows (approximately)
DELETE FROM `lecturer`;
INSERT INTO `lecturer` (`id`, `full_name`, `lecturer_code`, `email`, `department_id`) VALUES
	(4, 'Nguyễn Văn Tứ', 'GV001', 'gv1@gmail.com', 3),
	(11, 'Trần Thị A', 'GV002', 'gv2@gmail.com', 3),
	(61, 'Nguyễn Đức Trọng', '342005', 'ductrong34end@gmail.com', 2);

-- Dumping structure for table system_services.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `room_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `building` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `capacity` int DEFAULT NULL,
  `type` enum('theory','lab','exam') COLLATE utf8mb4_general_ci DEFAULT 'theory',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.rooms: ~3 rows (approximately)
DELETE FROM `rooms`;
INSERT INTO `rooms` (`id`, `room_name`, `building`, `capacity`, `type`) VALUES
	(1, 'P101', 'A', 50, 'theory'),
	(2, 'LAB201', 'B', 40, 'lab'),
	(3, 'HALL01', 'C', 200, 'exam');

-- Dumping structure for table system_services.semesters
CREATE TABLE IF NOT EXISTS `semesters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `academic_year` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `semester_number` tinyint NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.semesters: ~2 rows (approximately)
DELETE FROM `semesters`;
INSERT INTO `semesters` (`id`, `name`, `academic_year`, `semester_number`, `start_date`, `end_date`, `is_active`) VALUES
	(1, 'Học kỳ 1', '2025-2026', 1, '2025-09-01', '2026-02-15', 1),
	(2, 'Học kỳ 2', '2025-2026', 2, '2026-02-24', '2026-06-01', 0);

-- Dumping structure for table system_services.student
CREATE TABLE IF NOT EXISTS `student` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `class_id` bigint unsigned DEFAULT NULL,
  `department_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_code` (`student_code`),
  KEY `class_id` (`class_id`),
  KEY `student_fk_department` (`department_id`),
  CONSTRAINT `student_fk_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL,
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.student: ~3 rows (approximately)
DELETE FROM `student`;
INSERT INTO `student` (`id`, `student_code`, `class_id`, `department_id`, `created_at`, `updated_at`) VALUES
	(16, 'SV001', 1, 3, '2026-01-19 07:04:27', '2026-01-23 02:47:57'),
	(22, '2326CNT05', 3, 2, '2026-01-23 02:27:52', '2026-01-23 03:45:36'),
	(25, '312312', 1, 2, '2026-01-27 20:30:59', '2026-01-27 20:30:59');

-- Dumping structure for table system_services.student_affairs
CREATE TABLE IF NOT EXISTS `student_affairs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `office_code` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `office_code` (`office_code`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table system_services.student_affairs: ~0 rows (approximately)
DELETE FROM `student_affairs`;
INSERT INTO `student_affairs` (`id`, `full_name`, `office_code`, `email`, `created_at`) VALUES
	(1, 'Phòng Công tác HSSV CNTT', 'CTSV_CNTT', 'ctsv_cntt@university.edu.vn', '2026-02-16 16:06:51');

-- Dumping structure for table system_services.student_course_classes
CREATE TABLE IF NOT EXISTS `student_course_classes` (
  `student_id` bigint unsigned NOT NULL,
  `course_class_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`student_id`,`course_class_id`),
  KEY `course_class_id` (`course_class_id`),
  CONSTRAINT `student_course_classes_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_course_classes_ibfk_2` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.student_course_classes: ~4 rows (approximately)
DELETE FROM `student_course_classes`;
INSERT INTO `student_course_classes` (`student_id`, `course_class_id`) VALUES
	(16, 1),
	(22, 1),
	(25, 1),
	(22, 3),
	(22, 8);

-- Dumping structure for table system_services.student_profiles
CREATE TABLE IF NOT EXISTS `student_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` enum('Nam','Nữ','Khác') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `identity_number` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `education_type` enum('Chính quy','Liên thông','Tại chức') COLLATE utf8mb4_general_ci DEFAULT 'Chính quy',
  `status` enum('Đang học','Tạm dừng','Thôi học','Đã tốt nghiệp') COLLATE utf8mb4_general_ci DEFAULT 'Đang học',
  PRIMARY KEY (`id`),
  KEY `fk_profile_student` (`student_id`),
  CONSTRAINT `fk_profile_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.student_profiles: ~3 rows (approximately)
DELETE FROM `student_profiles`;
INSERT INTO `student_profiles` (`id`, `student_id`, `full_name`, `gender`, `date_of_birth`, `email`, `phone`, `address`, `identity_number`, `avatar`, `education_type`, `status`) VALUES
	(1, 16, 'Nguyễn Văn Tứ', 'Nam', '2005-06-19', 'sv1@gmail.comgg', '03720165', 'Vu hoi - vu thu - thai binh', '034205009263', '1.jpg', 'Chính quy', 'Đang học'),
	(13, 22, 'Nguyễn Đức Trọng', 'Nam', '2005-04-03', 'ductrong34end@gmail.com', '0968843380', 'Xã Thư Lâm - Tỉnh Hà Nội', '001205022394', 'student_22_1769798919.jpg', 'Chính quy', 'Đang học'),
	(14, 25, 'Trong', 'Nam', '2026-01-15', 'ductrong34@gmail.com', '03720165', 'Đông Anh - Hà Nội2', '034205009275', '1769545859_850661-anime-classroom-of-the-elite-group-of-people-full.jpg', '', '');

-- Dumping structure for table system_services.subjects
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subject_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `credits` int DEFAULT '3',
  `department_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subject_code` (`subject_code`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.subjects: ~24 rows (approximately)
DELETE FROM `subjects`;
INSERT INTO `subjects` (`id`, `subject_code`, `name`, `credits`, `department_id`) VALUES
	(1, 'CT101', 'Lập trình C', 6, 3),
	(2, 'CT202', 'Lập trình PHP', 3, 3),
	(3, 'CT30', 'Cơ sở dữ liệud', 3, 3),
	(4, 'TK3D', 'Thiết kế 3D', 6, 2),
	(5, 'IT101', 'Nhập môn Công nghệ thông tin', 3, 2),
	(6, 'IT102', 'Lập trình C cơ bản', 3, 2),
	(7, 'IT103', 'Lập trình hướng đối tượng', 3, 2),
	(8, 'IT104', 'Cấu trúc dữ liệu và giải thuật', 4, 2),
	(9, 'IT105', 'Cơ sở dữ liệu', 3, 2),
	(10, 'IT106', 'Hệ điều hành', 3, 2),
	(11, 'IT107', 'Mạng máy tính', 3, 2),
	(12, 'IT108', 'Phân tích và thiết kế hệ thống', 3, 2),
	(13, 'IT109', 'Công nghệ phần mềm', 3, 2),
	(14, 'IT110', 'Lập trình Web', 3, 2),
	(15, 'IT111', 'Lập trình Java nâng cao', 3, 2),
	(16, 'IT112', 'Lập trình PHP & MySQL', 3, 2),
	(17, 'IT113', 'An toàn và bảo mật thông tin', 3, 2),
	(18, 'IT114', 'Trí tuệ nhân tạo', 3, 2),
	(19, 'IT115', 'Khai phá dữ liệu', 3, 2),
	(20, 'IT116', 'Hệ quản trị cơ sở dữ liệu', 3, 2),
	(21, 'IT117', 'Điện toán đám mây', 3, 2),
	(22, 'IT118', 'Phát triển ứng dụng di động', 3, 2),
	(23, 'IT119', 'Kiểm thử phần mềm', 3, 2),
	(24, 'IT120', 'Đồ án chuyên ngành CNTT', 4, 2);

-- Dumping structure for table system_services.timetables
CREATE TABLE IF NOT EXISTS `timetables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `course_class_id` bigint unsigned NOT NULL,
  `room_id` bigint unsigned NOT NULL,
  `day_of_week` tinyint NOT NULL,
  `session` enum('Sáng','Chiều') COLLATE utf8mb4_general_ci NOT NULL,
  `start_week` int NOT NULL,
  `end_week` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_room_day_session` (`room_id`,`day_of_week`,`session`),
  UNIQUE KEY `uq_class_day_session` (`course_class_id`,`day_of_week`,`session`),
  KEY `course_class_id` (`course_class_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `timetables_ibfk_1` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `timetables_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.timetables: ~3 rows (approximately)
DELETE FROM `timetables`;
INSERT INTO `timetables` (`id`, `course_class_id`, `room_id`, `day_of_week`, `session`, `start_week`, `end_week`) VALUES
	(1, 1, 1, 2, 'Sáng', 1, 15),
	(2, 3, 2, 3, 'Chiều', 3, 10),
	(4, 8, 2, 2, 'Sáng', 1, 19),
	(6, 10, 1, 4, 'Chiều', 1, 7),
	(7, 11, 2, 5, 'Chiều', 1, 8),
	(8, 12, 3, 6, 'Chiều', 1, 8);

-- Dumping structure for table system_services.training_office
CREATE TABLE IF NOT EXISTS `training_office` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `office_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `office_code` (`office_code`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.training_office: ~2 rows (approximately)
DELETE FROM `training_office`;
INSERT INTO `training_office` (`id`, `full_name`, `office_code`, `email`, `phone`, `created_at`) VALUES
	(1, 'Phòng Đào Tạo Khoa Công Nghệ Thông Tin', 'PDT_CNTT', 'daotao_cntt@university.edu.vn', '02438889999', '2026-02-06 07:42:38'),
	(2, 'Nguyễn Thị Hương – Cán bộ đào tạo', 'CB_DT_01', 'huongdt@university.edu.vn', '0988777666', '2026-02-06 07:42:38');

-- Dumping structure for table system_services.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','lecturer','student','training_office','academic_affairs','exam_office','student_affairs') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ref_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table system_services.users: ~13 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `password`, `role`, `ref_id`) VALUES
	(1, 'admin123', '123', 'admin', 0),
	(2, 'gv1', '123', 'lecturer', 4),
	(3, 'gv2', '123', 'lecturer', 11),
	(4, 'nvt', '123', 'student', 16),
	(18, 'qq', 'q', 'lecturer', 54),
	(20, 'nvtsssss', ' 123', 'lecturer', 59),
	(23, 'nguyenductrong', '123', 'student', 22),
	(24, 'ductrong', '123', 'lecturer', 61),
	(25, 'trong', '123', 'student', 25),
	(26, 'pdt', '123', 'training_office', 1),
	(31, 'hocvu', '123', 'academic_affairs', 1),
	(32, 'khaothi', '123', 'exam_office', 1),
	(33, 'ctsv', '123', 'student_affairs', 1);

-- Dumping structure for trigger system_services.trg_calc_final_grade_insert
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_calc_final_grade_insert` BEFORE INSERT ON `academic_results` FOR EACH ROW BEGIN
    IF NEW.process_score IS NOT NULL
       AND NEW.midterm_score IS NOT NULL
       AND NEW.final_exam_score IS NOT NULL THEN

        SET NEW.final_grade =
            NEW.final_exam_score * 0.6
          + ((NEW.process_score + NEW.midterm_score) / 2) * 0.4;

        SET NEW.grade_letter = CASE
            WHEN NEW.final_grade >= 8.5 THEN 'A'
            WHEN NEW.final_grade >= 7.0 THEN 'B'
            WHEN NEW.final_grade >= 5.5 THEN 'C'
            WHEN NEW.final_grade >= 4.0 THEN 'D'
            ELSE 'F'
        END;

        SET NEW.result = IF(NEW.final_grade >= 4.0, 'pass', 'fail');
    END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger system_services.trg_calc_final_grade_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg_calc_final_grade_update` BEFORE UPDATE ON `academic_results` FOR EACH ROW BEGIN
    IF NEW.process_score IS NOT NULL
       AND NEW.midterm_score IS NOT NULL
       AND NEW.final_exam_score IS NOT NULL THEN

        SET NEW.final_grade =
            NEW.final_exam_score * 0.6
          + ((NEW.process_score + NEW.midterm_score) / 2) * 0.4;

        SET NEW.grade_letter = CASE
            WHEN NEW.final_grade >= 8.5 THEN 'A'
            WHEN NEW.final_grade >= 7.0 THEN 'B'
            WHEN NEW.final_grade >= 5.5 THEN 'C'
            WHEN NEW.final_grade >= 4.0 THEN 'D'
            ELSE 'F'
        END;

        SET NEW.result = IF(NEW.final_grade >= 4.0, 'pass', 'fail');
    END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
