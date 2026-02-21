-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th2 19, 2026 lúc 10:14 PM
-- Phiên bản máy phục vụ: 8.4.3
-- Phiên bản PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `system_services`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `academic_affairs`
--

CREATE TABLE `academic_affairs` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `office_code` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `academic_affairs`
--

INSERT INTO `academic_affairs` (`id`, `full_name`, `office_code`, `email`, `created_at`) VALUES
(1, 'Phòng Học vụ CNTT', 'HV_CNTT', 'hocvu_cntt@university.edu.vn', '2026-02-16 16:06:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `academic_results`
--

CREATE TABLE `academic_results` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `course_class_id` bigint UNSIGNED NOT NULL,
  `process_score` decimal(4,2) DEFAULT NULL,
  `midterm_score` decimal(4,2) DEFAULT NULL,
  `final_exam_score` decimal(4,2) DEFAULT NULL,
  `final_grade` decimal(5,2) DEFAULT NULL,
  `grade_letter` char(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `result` enum('pass','fail') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `frequent_scores` text COLLATE utf8mb4_general_ci COMMENT 'JSON điểm thường xuyên'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `academic_results`
--

INSERT INTO `academic_results` (`id`, `student_id`, `course_class_id`, `process_score`, `midterm_score`, `final_exam_score`, `final_grade`, `grade_letter`, `result`, `frequent_scores`) VALUES
(1, 22, 1, 10.00, 10.00, 10.00, 10.00, 'A', 'pass', '[\"10\",\"10\",\"10\"]'),
(2, 25, 1, 5.67, 6.00, 5.00, 5.33, 'D', 'pass', '[\"6\",\"5\",\"6\"]'),
(3, 16, 1, 6.00, 7.00, NULL, 4.80, 'D', 'pass', '[\"6\",\"6\"]'),
(4, 22, 3, 5.00, NULL, NULL, NULL, NULL, NULL, '[\"5\"]');

--
-- Bẫy `academic_results`
--
DELIMITER $$
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
END
$$
DELIMITER ;
DELIMITER $$
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
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `course_class_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late') COLLATE utf8mb4_general_ci DEFAULT 'present',
  `session_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `attendance`
--

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
(31, 25, 1, '2025-09-02', 'present', 1),
(32, 25, 1, '2025-09-09', 'present', 2),
(33, 25, 1, '2025-09-16', 'present', 3),
(34, 25, 1, '2025-09-23', 'present', 4),
(35, 25, 1, '2025-09-30', 'late', 5),
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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `target_type` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `target_id` bigint UNSIGNED DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Đang đổ dữ liệu cho bảng `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `target_type`, `target_id`, `data`, `created_at`) VALUES
(1, 1, 'CREATE', 'student', 16, '{\"student\":\"SV001\"}', '2026-01-07 11:15:57'),
(2, 2, 'UPDATE', 'academic_results', 1, '{\"grade\":8.5}', '2026-01-07 11:15:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `classes`
--

CREATE TABLE `classes` (
  `id` bigint UNSIGNED NOT NULL,
  `class_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class_code` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `lecturer_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `class_code`, `department_id`, `lecturer_id`) VALUES
(1, 'CNTT K19A', 'CNTT19Aa', 3, 4),
(2, 'CNTT K19B', 'CNTT19a', 3, 11),
(3, 'cnt03', 'cnt04', 2, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class_sessions`
--

CREATE TABLE `class_sessions` (
  `id` bigint UNSIGNED NOT NULL,
  `course_class_id` bigint UNSIGNED NOT NULL,
  `session_date` date NOT NULL,
  `day_of_week` tinyint NOT NULL,
  `session` enum('Sáng','Chiều') COLLATE utf8mb4_general_ci NOT NULL,
  `week_number` int NOT NULL,
  `room_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `class_sessions`
--

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
(30, 11, '2025-10-24', 5, 'Chiều', 8, NULL, '2026-02-11 04:27:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_classes`
--

CREATE TABLE `course_classes` (
  `id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `lecturer_id` bigint UNSIGNED NOT NULL,
  `semester_id` bigint UNSIGNED NOT NULL,
  `class_code` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `max_students` int DEFAULT '60'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `course_classes`
--

INSERT INTO `course_classes` (`id`, `subject_id`, `lecturer_id`, `semester_id`, `class_code`, `max_students`) VALUES
(1, 2, 61, 1, 'PHP1', 60),
(3, 3, 4, 1, '2026BMPM000001', 40),
(8, 1, 11, 1, '2026BMPM000004', 20),
(10, 4, 61, 1, '2026KCNTT000001', 60),
(11, 4, 11, 1, '2026KCNTT000002', 60),
(18, 24, 61, 2, '2026KCNTT000003', 30),
(19, 12, 61, 1, '2026KCNTT000004', 31),
(21, 11, 61, 1, '2026KCNTT000005', 30);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department`
--

CREATE TABLE `department` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('school','faculty','department') COLLATE utf8mb4_general_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `staff_count` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `department`
--

INSERT INTO `department` (`id`, `name`, `type`, `parent_id`, `staff_count`, `created_at`, `updated_at`) VALUES
(1, 'Trường Đại học CNTT', 'faculty', 2, 200, '2026-01-07 11:41:17', '2026-01-23 05:44:37'),
(2, 'Khoa Công nghệ Thông tin', 'faculty', 1, 80, '2026-01-07 11:41:17', '2026-01-07 11:41:17'),
(3, 'Bộ môn Phần mềm', 'school', 3, 40, '2026-01-07 11:41:17', '2026-02-19 16:54:17'),
(6, 'mewmew', 'faculty', 2, NULL, '2026-02-14 16:24:53', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exam_office`
--

CREATE TABLE `exam_office` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `office_code` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `exam_office`
--

INSERT INTO `exam_office` (`id`, `full_name`, `office_code`, `email`, `created_at`) VALUES
(1, 'Phòng Khảo thí CNTT', 'KT_CNTT', 'khaothi_cntt@university.edu.vn', '2026-02-16 16:06:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `learning_materials`
--

CREATE TABLE `learning_materials` (
  `id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_url` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` enum('pdf','video','doc') COLLATE utf8mb4_general_ci DEFAULT 'pdf'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `learning_materials`
--

INSERT INTO `learning_materials` (`id`, `subject_id`, `title`, `file_url`, `type`) VALUES
(1, 1, 'Giáo trình C', '/uploads/c.pdf', 'pdf'),
(2, 2, 'PHP MVC Video', '/uploads/php.mp4', 'video'),
(3, 3, 'MySQL Tài liệu', '/uploads/mysql.docx', 'doc');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lecturer`
--

CREATE TABLE `lecturer` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lecturer_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lecturer`
--

INSERT INTO `lecturer` (`id`, `full_name`, `lecturer_code`, `email`, `department_id`) VALUES
(4, 'Nguyễn Văn Tứ', 'GV001', 'gv1@gmail.com', 3),
(11, 'Trần Thị A', 'GV002', 'gv2@gmail.com', 3),
(61, 'Nguyễn Đức Trọng', '342005', 'ductrong34end@gmail.com', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint UNSIGNED NOT NULL,
  `room_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `building` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `capacity` int DEFAULT NULL,
  `type` enum('theory','lab','exam') COLLATE utf8mb4_general_ci DEFAULT 'theory'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `room_name`, `building`, `capacity`, `type`) VALUES
(1, 'P101', 'A', 50, 'theory'),
(2, 'LAB201', 'B', 40, 'lab'),
(3, 'HALL01', 'C', 200, 'exam');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `score_components`
--

CREATE TABLE `score_components` (
  `id` bigint UNSIGNED NOT NULL,
  `course_class_id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` enum('TX','DK','CK','PROJECT') NOT NULL,
  `weight` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `score_components`
--

INSERT INTO `score_components` (`id`, `course_class_id`, `name`, `type`, `weight`) VALUES
(5, 18, 'Báo cáo', 'PROJECT', 100.00),
(6, 19, 'Chuyên cần', 'TX', 10.00),
(7, 19, 'Bài kiểm tra 1', 'TX', 10.00),
(8, 19, 'Bài kiểm tra 2', 'DK', 20.00),
(9, 19, 'Bài tập lớn', 'PROJECT', 60.00),
(10, 21, 'Chuyên cần', 'TX', 10.00),
(11, 21, 'Bài kiểm tra 1', 'TX', 10.00),
(12, 21, 'Bài kiểm tra 2', 'DK', 20.00),
(13, 21, 'Bài thi', 'CK', 60.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `semesters`
--

CREATE TABLE `semesters` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `academic_year` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `semester_number` tinyint NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `semesters`
--

INSERT INTO `semesters` (`id`, `name`, `academic_year`, `semester_number`, `start_date`, `end_date`, `is_active`) VALUES
(1, 'Học kỳ 1', '2025-2026', 1, '2025-09-01', '2026-02-15', 1),
(2, 'Học kỳ 2', '2025-2026', 2, '2026-02-24', '2026-06-01', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student`
--

CREATE TABLE `student` (
  `id` bigint UNSIGNED NOT NULL,
  `student_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `class_id` bigint UNSIGNED DEFAULT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `student`
--

INSERT INTO `student` (`id`, `student_code`, `class_id`, `department_id`, `created_at`, `updated_at`) VALUES
(16, 'SV001', 1, 3, '2026-01-19 07:04:27', '2026-01-23 02:47:57'),
(22, '2326CNT05', 3, 2, '2026-01-23 02:27:52', '2026-01-23 03:45:36'),
(25, '312312', 1, 2, '2026-01-27 20:30:59', '2026-01-27 20:30:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student_affairs`
--

CREATE TABLE `student_affairs` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `office_code` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `student_affairs`
--

INSERT INTO `student_affairs` (`id`, `full_name`, `office_code`, `email`, `created_at`) VALUES
(1, 'Phòng Công tác HSSV CNTT', 'CTSV_CNTT', 'ctsv_cntt@university.edu.vn', '2026-02-16 16:06:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student_component_scores`
--

CREATE TABLE `student_component_scores` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `component_id` bigint UNSIGNED NOT NULL,
  `score` decimal(4,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student_course_classes`
--

CREATE TABLE `student_course_classes` (
  `student_id` bigint UNSIGNED NOT NULL,
  `course_class_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `student_course_classes`
--

INSERT INTO `student_course_classes` (`student_id`, `course_class_id`) VALUES
(16, 1),
(22, 1),
(25, 1),
(22, 3),
(22, 8),
(22, 19),
(22, 21);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student_profiles`
--

CREATE TABLE `student_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` enum('Nam','Nữ','Khác') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `identity_number` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `education_type` enum('Chính quy','Liên thông','Tại chức') COLLATE utf8mb4_general_ci DEFAULT 'Chính quy',
  `status` enum('Đang học','Tạm dừng','Thôi học','Đã tốt nghiệp') COLLATE utf8mb4_general_ci DEFAULT 'Đang học'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `student_profiles`
--

INSERT INTO `student_profiles` (`id`, `student_id`, `full_name`, `gender`, `date_of_birth`, `email`, `phone`, `address`, `identity_number`, `avatar`, `education_type`, `status`) VALUES
(1, 16, 'Nguyễn Văn Tứ', 'Nam', '2005-06-19', 'sv1@gmail.comgg', '03720165', 'Vu hoi - vu thu - thai binh', '034205009263', '1.jpg', 'Chính quy', 'Đang học'),
(13, 22, 'Nguyễn Đức Trọng', 'Nam', '2005-04-03', 'ductrong34end@gmail.com', '0968843380', 'Xã Thư Lâm - Tỉnh Hà Nội', '001205022394', 'student_22_1769798919.jpg', 'Chính quy', 'Đang học'),
(14, 25, 'Trong', 'Nam', '2026-01-15', 'ductrong34@gmail.com', '03720165', 'Đông Anh - Hà Nội2', '034205009275', '1769545859_850661-anime-classroom-of-the-elite-group-of-people-full.jpg', '', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint UNSIGNED NOT NULL,
  `subject_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `credits` int DEFAULT '3',
  `department_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `subjects`
--

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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `timetables`
--

CREATE TABLE `timetables` (
  `id` bigint UNSIGNED NOT NULL,
  `course_class_id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED NOT NULL,
  `day_of_week` tinyint NOT NULL,
  `session` enum('Sáng','Chiều') COLLATE utf8mb4_general_ci NOT NULL,
  `start_week` int NOT NULL,
  `end_week` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `timetables`
--

INSERT INTO `timetables` (`id`, `course_class_id`, `room_id`, `day_of_week`, `session`, `start_week`, `end_week`) VALUES
(1, 1, 1, 2, 'Sáng', 1, 15),
(2, 3, 2, 3, 'Chiều', 3, 10),
(4, 8, 2, 2, 'Sáng', 1, 19),
(6, 10, 1, 4, 'Chiều', 1, 7),
(7, 11, 2, 5, 'Chiều', 1, 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `training_office`
--

CREATE TABLE `training_office` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `office_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `training_office`
--

INSERT INTO `training_office` (`id`, `full_name`, `office_code`, `email`, `phone`, `created_at`) VALUES
(1, 'Phòng Đào Tạo Khoa Công Nghệ Thông Tin', 'PDT_CNTT', 'daotao_cntt@university.edu.vn', '02438889999', '2026-02-06 07:42:38'),
(2, 'Nguyễn Thị Hương – Cán bộ đào tạo', 'CB_DT_01', 'huongdt@university.edu.vn', '0988777666', '2026-02-06 07:42:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','lecturer','student','training_office','academic_affairs','exam_office','student_affairs') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ref_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

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

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `academic_affairs`
--
ALTER TABLE `academic_affairs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `office_code` (`office_code`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `academic_results`
--
ALTER TABLE `academic_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`course_class_id`),
  ADD KEY `course_class_id` (`course_class_id`);

--
-- Chỉ mục cho bảng `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_class_id` (`course_class_id`),
  ADD KEY `fk_attendance_session` (`session_id`);

--
-- Chỉ mục cho bảng `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_code` (`class_code`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Chỉ mục cho bảng `class_sessions`
--
ALTER TABLE `class_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_class_date` (`course_class_id`,`session_date`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `course_classes`
--
ALTER TABLE `course_classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_subject_lecturer_semester` (`subject_id`,`lecturer_id`,`semester_id`),
  ADD UNIQUE KEY `class_code` (`class_code`,`semester_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `lecturer_id` (`lecturer_id`),
  ADD KEY `semester_id` (`semester_id`);

--
-- Chỉ mục cho bảng `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Chỉ mục cho bảng `exam_office`
--
ALTER TABLE `exam_office`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `office_code` (`office_code`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Chỉ mục cho bảng `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lecturer_code` (`lecturer_code`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `department_id` (`department_id`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `score_components`
--
ALTER TABLE `score_components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_class_id` (`course_class_id`);

--
-- Chỉ mục cho bảng `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_code` (`student_code`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `student_fk_department` (`department_id`);

--
-- Chỉ mục cho bảng `student_affairs`
--
ALTER TABLE `student_affairs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `office_code` (`office_code`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `student_component_scores`
--
ALTER TABLE `student_component_scores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_component` (`student_id`,`component_id`),
  ADD KEY `fk_grade_component` (`component_id`);

--
-- Chỉ mục cho bảng `student_course_classes`
--
ALTER TABLE `student_course_classes`
  ADD PRIMARY KEY (`student_id`,`course_class_id`),
  ADD KEY `course_class_id` (`course_class_id`);

--
-- Chỉ mục cho bảng `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_profile_student` (`student_id`);

--
-- Chỉ mục cho bảng `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subject_code` (`subject_code`),
  ADD KEY `department_id` (`department_id`);

--
-- Chỉ mục cho bảng `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_room_day_session` (`room_id`,`day_of_week`,`session`),
  ADD UNIQUE KEY `uq_class_day_session` (`course_class_id`,`day_of_week`,`session`),
  ADD KEY `course_class_id` (`course_class_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `training_office`
--
ALTER TABLE `training_office`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `office_code` (`office_code`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `academic_affairs`
--
ALTER TABLE `academic_affairs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `academic_results`
--
ALTER TABLE `academic_results`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT cho bảng `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `class_sessions`
--
ALTER TABLE `class_sessions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `course_classes`
--
ALTER TABLE `course_classes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `department`
--
ALTER TABLE `department`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `exam_office`
--
ALTER TABLE `exam_office`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `learning_materials`
--
ALTER TABLE `learning_materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `score_components`
--
ALTER TABLE `score_components`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `student`
--
ALTER TABLE `student`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `student_affairs`
--
ALTER TABLE `student_affairs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `student_component_scores`
--
ALTER TABLE `student_component_scores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `student_profiles`
--
ALTER TABLE `student_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `training_office`
--
ALTER TABLE `training_office`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `academic_results`
--
ALTER TABLE `academic_results`
  ADD CONSTRAINT `academic_results_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `academic_results_ibfk_2` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_attendance_session` FOREIGN KEY (`session_id`) REFERENCES `class_sessions` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE SET NULL;

--
-- Ràng buộc cho bảng `class_sessions`
--
ALTER TABLE `class_sessions`
  ADD CONSTRAINT `class_sessions_ibfk_1` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_sessions_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL;

--
-- Ràng buộc cho bảng `course_classes`
--
ALTER TABLE `course_classes`
  ADD CONSTRAINT `course_classes_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_classes_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_classes_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `department` (`id`) ON DELETE SET NULL;

--
-- Ràng buộc cho bảng `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD CONSTRAINT `learning_materials_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `lecturer`
--
ALTER TABLE `lecturer`
  ADD CONSTRAINT `lecturer_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL;

--
-- Ràng buộc cho bảng `score_components`
--
ALTER TABLE `score_components`
  ADD CONSTRAINT `score_components_ibfk_1` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_fk_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL;

--
-- Ràng buộc cho bảng `student_component_scores`
--
ALTER TABLE `student_component_scores`
  ADD CONSTRAINT `fk_grade_component` FOREIGN KEY (`component_id`) REFERENCES `score_components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_grade_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `student_course_classes`
--
ALTER TABLE `student_course_classes`
  ADD CONSTRAINT `student_course_classes_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_course_classes_ibfk_2` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD CONSTRAINT `fk_profile_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL;

--
-- Ràng buộc cho bảng `timetables`
--
ALTER TABLE `timetables`
  ADD CONSTRAINT `timetables_ibfk_1` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetables_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
<<<<<<< HEAD
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
=======
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
>>>>>>> 0e1944da8c3ee13b6af721a4759d61cd04dc530f
