-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th2 22, 2026 lúc 02:51 PM
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
  `final_score` decimal(4,1) DEFAULT NULL COMMENT 'Điểm hệ 10 (1 chữ số thập phân)',
  `letter_grade` varchar(2) DEFAULT NULL COMMENT 'A, B+, C...',
  `gpa_4` decimal(3,2) DEFAULT NULL COMMENT 'GPA hệ 4',
  `result_status` enum('pass','fail') DEFAULT NULL COMMENT 'Kết quả đạt hay không',
  `approval_status` enum('DRAFT','APPROVED','PUBLISHED') DEFAULT 'DRAFT' COMMENT 'Trạng thái xử lý kết quả',
  `approved_by` bigint UNSIGNED DEFAULT NULL COMMENT 'User exam_office duyệt',
  `approved_at` timestamp NULL DEFAULT NULL COMMENT 'Thời điểm duyệt',
  `published_at` timestamp NULL DEFAULT NULL COMMENT 'Thời điểm công bố',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `academic_results`
--

INSERT INTO `academic_results` (`id`, `student_id`, `course_class_id`, `final_score`, `letter_grade`, `gpa_4`, `result_status`, `approval_status`, `approved_by`, `approved_at`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 22, 26, 9.0, 'A', 4.00, 'pass', 'DRAFT', NULL, NULL, NULL, '2026-02-21 14:12:50', '2026-02-21 14:16:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `session_id` bigint UNSIGNED NOT NULL,
  `status` enum('present','absent','late') DEFAULT 'present'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(24, 37, 61, 2, '2026KCNTT000001', 30),
(26, 37, 61, 1, '2026KCNTT000002', 30),
(29, 47, 61, 1, '2026KCNTT000003', 30);

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
  `course_class_id` bigint UNSIGNED NOT NULL,
  `subject_component_id` bigint UNSIGNED NOT NULL,
  `score` decimal(4,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Đang đổ dữ liệu cho bảng `student_component_scores`
--

INSERT INTO `student_component_scores` (`id`, `student_id`, `course_class_id`, `subject_component_id`, `score`, `created_at`, `updated_at`) VALUES
(136, 22, 26, 8, 9.00, '2026-02-21 14:12:50', '2026-02-21 14:16:00'),
(142, 22, 29, 27, 10.00, '2026-02-22 04:36:15', '2026-02-22 04:36:15');

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
(22, 26),
(22, 29);

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
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `subject_type` enum('NORMAL','PROJECT') COLLATE utf8mb4_general_ci DEFAULT 'NORMAL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `subjects`
--

INSERT INTO `subjects` (`id`, `subject_code`, `name`, `credits`, `department_id`, `subject_type`) VALUES
(36, 'IT34', 'Phân tích thiết kế hệ thống', 3, 2, 'NORMAL'),
(37, 'IT51', 'Đồ án tốt nghiệp', 3, 2, 'PROJECT'),
(38, 'IT01', 'Cơ sở dữ liệu', 3, 2, 'NORMAL'),
(47, 'd123', 'Quả Chín Quá', 6, 2, 'NORMAL');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subject_score_components`
--

CREATE TABLE `subject_score_components` (
  `id` bigint UNSIGNED NOT NULL,
  `subject_id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` enum('TX','DK','CK','PROJECT') NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Đang đổ dữ liệu cho bảng `subject_score_components`
--

INSERT INTO `subject_score_components` (`id`, `subject_id`, `name`, `type`, `weight`, `created_at`) VALUES
(4, 36, 'Chuyên cần', 'TX', 10.00, '2026-02-20 17:03:16'),
(5, 36, 'Bài kiểm tra 1', 'TX', 10.00, '2026-02-20 17:03:16'),
(6, 36, 'Bài kiểm tra 2', 'DK', 20.00, '2026-02-20 17:03:16'),
(7, 36, 'Bài tập lớn', 'CK', 60.00, '2026-02-20 17:03:16'),
(8, 37, 'Đồ án', 'PROJECT', 100.00, '2026-02-20 17:04:30'),
(9, 38, 'Chuyên cần', 'TX', 10.00, '2026-02-20 17:09:13'),
(10, 38, 'Bài kiểm tra 1', 'TX', 10.00, '2026-02-20 17:09:13'),
(11, 38, 'Bài kiểm tra 2', 'DK', 20.00, '2026-02-20 17:09:13'),
(12, 38, 'Bài thi', 'CK', 60.00, '2026-02-20 17:09:13'),
(27, 47, 'Chuyên cần', 'TX', 10.00, '2026-02-22 04:30:58'),
(28, 47, 'Bài kiểm tra 1', 'TX', 10.00, '2026-02-22 04:30:58'),
(29, 47, 'Bài kiểm tra 2', 'DK', 20.00, '2026-02-22 04:30:58'),
(30, 47, 'Bài tập lớn', 'PROJECT', 60.00, '2026-02-22 04:30:58');

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
  ADD UNIQUE KEY `uq_student_course` (`student_id`,`course_class_id`),
  ADD KEY `course_class_id` (`course_class_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Chỉ mục cho bảng `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_attendance` (`student_id`,`session_id`),
  ADD KEY `session_id` (`session_id`);

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
  ADD UNIQUE KEY `uq_student_component` (`student_id`,`course_class_id`,`subject_component_id`),
  ADD KEY `fk_scs_course` (`course_class_id`),
  ADD KEY `fk_scs_component` (`subject_component_id`);

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
-- Chỉ mục cho bảng `subject_score_components`
--
ALTER TABLE `subject_score_components`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_subject_component` (`subject_id`,`name`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `course_classes`
--
ALTER TABLE `course_classes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT cho bảng `subject_score_components`
--
ALTER TABLE `subject_score_components`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `academic_results_ibfk_2` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `academic_results_ibfk_3` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ràng buộc cho bảng `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `class_sessions` (`id`) ON DELETE CASCADE;

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
-- Ràng buộc cho bảng `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_fk_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL;

--
-- Ràng buộc cho bảng `student_component_scores`
--
ALTER TABLE `student_component_scores`
  ADD CONSTRAINT `fk_scs_component` FOREIGN KEY (`subject_component_id`) REFERENCES `subject_score_components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_scs_course` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_scs_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE;

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
-- Ràng buộc cho bảng `subject_score_components`
--
ALTER TABLE `subject_score_components`
  ADD CONSTRAINT `fk_subject_component_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

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
