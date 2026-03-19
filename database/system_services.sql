  -- phpMyAdmin SQL Dump
  -- version 5.2.3
  -- https://www.phpmyadmin.net/
  --
  -- Máy chủ: localhost:3306
  -- Thời gian đã tạo: Th3 18, 2026 lúc 02:57 AM
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
  (1, 'Phòng Học vụ CNTT', 'HV_CNTT', 'hocvu_cntt@university.edu.vn', '2026-02-16 16:06:51'),
  (2, 'Giáo vụ', 'HV00001', 'duongdomic@gmail.com', '2026-03-06 18:01:41');

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
    `approval_status` enum('DRAFT','APPROVED','PUBLISHED') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'PUBLISHED' COMMENT 'Trạng thái xử lý kết quả',
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
  (32, 29, 60, 10.0, 'A', 4.00, 'pass', 'PUBLISHED', NULL, NULL, NULL, '2026-03-14 14:24:12', '2026-03-14 14:24:12');

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

  --
  -- Đang đổ dữ liệu cho bảng `attendance`
  --

  INSERT INTO `attendance` (`id`, `student_id`, `session_id`, `status`) VALUES
  (39, 29, 193, 'present'),
  (40, 29, 194, 'present'),
  (41, 29, 195, 'present'),
  (42, 29, 196, 'present'),
  (43, 29, 197, 'present');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `classes`
  --

  CREATE TABLE `classes` (
    `id` bigint UNSIGNED NOT NULL,
    `class_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `class_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `department_id` bigint UNSIGNED NOT NULL,
    `lecturer_id` bigint UNSIGNED DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Đang đổ dữ liệu cho bảng `classes`
  --

  INSERT INTO `classes` (`id`, `class_name`, `class_code`, `department_id`, `lecturer_id`) VALUES
  (11, 'CNTT K19A', 'CNTT K19A', 13, 62),
  (12, 'LKT01', 'LKT01', 17, 65);

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `class_sessions`
  --

  CREATE TABLE `class_sessions` (
    `id` bigint UNSIGNED NOT NULL,
    `course_class_id` bigint UNSIGNED NOT NULL,
    `session_date` date NOT NULL,
    `day_of_week` tinyint NOT NULL,
    `session` enum('Sáng','Chiều') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `week_number` int NOT NULL,
    `room_id` bigint UNSIGNED DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Đang đổ dữ liệu cho bảng `class_sessions`
  --

  INSERT INTO `class_sessions` (`id`, `course_class_id`, `session_date`, `day_of_week`, `session`, `week_number`, `room_id`, `created_at`) VALUES
  (188, 61, '2026-02-25', 3, 'Chiều', 1, 3, '2026-03-11 04:50:12'),
  (189, 61, '2026-03-04', 3, 'Chiều', 2, 3, '2026-03-11 04:50:12'),
  (190, 61, '2026-03-11', 3, 'Chiều', 3, 3, '2026-03-11 04:50:12'),
  (191, 61, '2026-03-18', 3, 'Chiều', 4, 3, '2026-03-11 04:50:12'),
  (192, 61, '2026-03-25', 3, 'Chiều', 5, 3, '2026-03-11 04:50:12'),
  (193, 60, '2026-02-25', 3, 'Sáng', 1, 1, '2026-03-11 04:52:43'),
  (194, 60, '2026-03-04', 3, 'Sáng', 2, 1, '2026-03-11 04:52:43'),
  (195, 60, '2026-03-11', 3, 'Sáng', 3, 1, '2026-03-11 04:52:43'),
  (196, 60, '2026-03-18', 3, 'Sáng', 4, 1, '2026-03-11 04:52:43'),
  (197, 60, '2026-03-25', 3, 'Sáng', 5, 1, '2026-03-11 04:52:43'),
  (198, 62, '2026-02-25', 3, 'Sáng', 1, 2, '2026-03-11 04:53:44'),
  (199, 62, '2026-03-04', 3, 'Sáng', 2, 2, '2026-03-11 04:53:44'),
  (200, 62, '2026-03-11', 3, 'Sáng', 3, 2, '2026-03-11 04:53:44'),
  (201, 62, '2026-03-18', 3, 'Sáng', 4, 2, '2026-03-11 04:53:44'),
  (202, 62, '2026-03-25', 3, 'Sáng', 5, 2, '2026-03-11 04:53:44'),
  (203, 63, '2026-02-26', 4, 'Chiều', 1, 1, '2026-03-17 11:47:42'),
  (204, 63, '2026-03-05', 4, 'Chiều', 2, 1, '2026-03-17 11:47:42'),
  (205, 63, '2026-03-12', 4, 'Chiều', 3, 1, '2026-03-17 11:47:42'),
  (206, 63, '2026-03-19', 4, 'Chiều', 4, 1, '2026-03-17 11:47:42'),
  (207, 63, '2026-03-26', 4, 'Chiều', 5, 1, '2026-03-17 11:47:42'),
  (208, 63, '2026-04-02', 4, 'Chiều', 6, 1, '2026-03-17 11:47:42');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `course_classes`
  --

  CREATE TABLE `course_classes` (
    `id` bigint UNSIGNED NOT NULL,
    `subject_id` bigint UNSIGNED NOT NULL,
    `lecturer_id` bigint UNSIGNED NOT NULL,
    `semester_id` bigint UNSIGNED NOT NULL,
    `class_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `max_students` int DEFAULT '60',
    `registration_start` datetime DEFAULT NULL,
    `registration_end` datetime DEFAULT NULL,
    `status` enum('draft','open','studying','closed','finished') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'draft'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Đang đổ dữ liệu cho bảng `course_classes`
  --

  INSERT INTO `course_classes` (`id`, `subject_id`, `lecturer_id`, `semester_id`, `class_code`, `max_students`, `registration_start`, `registration_end`, `status`) VALUES
  (60, 56, 66, 2, '2026CNTT000002', 20, '2026-03-10 00:00:00', '2026-03-20 23:59:59', 'finished'),
  (61, 57, 66, 2, '2026CNTT000003', 20, '2026-03-11 00:00:00', '2026-03-21 23:59:59', 'open'),
  (62, 62, 67, 2, '2026CNTT000004', 20, '2026-03-13 00:00:00', '2026-03-21 23:59:59', 'open'),
  (63, 53, 68, 2, '2026CNTT000005', 20, '2026-03-07 00:00:00', '2026-03-12 23:59:59', 'open'),
  (65, 58, 69, 2, '2026CNTT000006', 1, '2026-03-13 00:00:00', '2026-03-23 23:59:59', 'open'),
  (66, 55, 65, 2, '2026CNTT000007', 20, '2026-03-13 00:00:00', '2026-03-23 23:59:59', 'open');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `department`
  --

  CREATE TABLE `department` (
    `id` bigint UNSIGNED NOT NULL,
    `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `type` enum('school','faculty','department') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `parent_id` bigint UNSIGNED DEFAULT NULL,
    `staff_count` int DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Đang đổ dữ liệu cho bảng `department`
  --

  INSERT INTO `department` (`id`, `name`, `type`, `parent_id`, `staff_count`, `created_at`, `updated_at`) VALUES
  (8, 'Trường Công nghệ Thông tin và Truyền thông', 'school', 8, 120, '2026-02-28 16:04:00', '2026-02-28 16:04:00'),
  (12, 'Khoa Công nghệ thông tin', 'faculty', 8, NULL, '2026-03-01 21:21:36', NULL),
  (13, 'Công nghệ thông tin', 'department', 12, NULL, '2026-03-01 21:22:05', NULL),
  (14, 'Thiết kế đồ họa', 'department', 12, NULL, '2026-03-06 14:35:40', NULL),
  (15, 'Khoa học máy tính', 'department', 12, NULL, '2026-03-06 14:36:13', NULL),
  (16, 'Khoa luật', 'faculty', 8, NULL, '2026-03-14 14:13:36', NULL),
  (17, 'Luật kinh tế', 'department', 16, NULL, '2026-03-14 14:13:51', NULL);

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
  -- Cấu trúc bảng cho bảng `lecturer`
  --

  CREATE TABLE `lecturer` (
    `id` bigint UNSIGNED NOT NULL,
    `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `lecturer_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `department_id` bigint UNSIGNED DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Đang đổ dữ liệu cho bảng `lecturer`
  --

  INSERT INTO `lecturer` (`id`, `full_name`, `lecturer_code`, `email`, `department_id`) VALUES
  (62, 'Nguyễn Đức Trọng', 'GV00001', 'ductrong34end@gmail.com', 12),
  (63, 'Nguyễn Văn Tứ', 'GV00002', 'ductrong34end@gmail.comdd', 12),
  (64, 'Nguyễn Văn Tứ', 'GV00003', 'ductrong34end@gmail.comddd', 12),
  (65, 'Trần Thị Nghĩa', 'GV00004', 'ductrong34end@gmail.comfgdfg', 12),
  (66, 'Lê Thị Thuý', 'GV00005', 'ductrong34end@gmail.comghfghd', 12),
  (67, 'Nguyễn Thị Huyền', 'GV00006', 'ductrong34end@gmail.comdsgdgs', 12),
  (68, 'Lê Văn Úy', 'GV00007', 'ductrong34end@gmail.comfghfgh', 12),
  (69, 'Nghiêm Thị Thu Hà', 'GV00008', 'ductrong34end@gmail.comsdgsda', 12);

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `rooms`
  --

  CREATE TABLE `rooms` (
    `id` bigint UNSIGNED NOT NULL,
    `room_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `building` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `capacity` int DEFAULT NULL,
    `type` enum('theory','lab','exam') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'theory'
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
    `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `academic_year` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `semester_number` tinyint NOT NULL,
    `start_date` date DEFAULT NULL,
    `end_date` date DEFAULT NULL,
    `is_active` tinyint(1) DEFAULT '0'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Đang đổ dữ liệu cho bảng `semesters`
  --

  INSERT INTO `semesters` (`id`, `name`, `academic_year`, `semester_number`, `start_date`, `end_date`, `is_active`) VALUES
  (1, 'Học kỳ 1', '2025-2026', 1, '2025-09-01', '2026-02-15', 0),
  (2, 'Học kỳ 2', '2025-2026', 2, '2026-02-24', '2026-06-01', 1),
  (3, 'Học kỳ 1', '2026-2027', 1, '2026-09-01', '2027-01-10', 0),
  (5, 'Học kỳ 2', '2026-2027', 2, '2027-01-15', '2027-05-30', 0),
  (6, 'Học kỳ 1', '2027-2028', 1, '2027-09-01', '2028-01-10', 0),
  (7, 'Học kỳ 1', '2024-2025', 1, '2024-09-01', '2025-01-10', 0),
  (8, 'Học kỳ 2', '2024-2025', 2, '2025-01-15', '2025-05-30', 0);

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `student`
  --

  CREATE TABLE `student` (
    `id` bigint UNSIGNED NOT NULL,
    `student_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `class_id` bigint UNSIGNED DEFAULT NULL,
    `department_id` bigint UNSIGNED DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Đang đổ dữ liệu cho bảng `student`
  --

  INSERT INTO `student` (`id`, `student_code`, `class_id`, `department_id`, `created_at`, `updated_at`) VALUES
  (29, '202600001', 11, 13, '2026-03-02 02:57:33', '2026-03-02 02:57:33'),
  (30, '202600002', 11, 13, '2026-03-07 17:13:24', '2026-03-07 17:13:24'),
  (31, '202600003', 11, 13, '2026-03-07 17:14:13', '2026-03-07 17:14:13'),
  (32, '202600004', 11, 13, '2026-03-07 17:14:46', '2026-03-07 17:14:46'),
  (33, '202600005', 11, 13, '2026-03-07 17:16:39', '2026-03-07 17:16:39'),
  (34, '202600006', 12, 17, '2026-03-07 17:17:15', '2026-03-14 14:15:01'),
  (35, '202600007', 11, 13, '2026-03-07 17:18:29', '2026-03-07 17:18:29'),
  (36, '202600008', 11, 13, '2026-03-07 17:25:03', '2026-03-07 17:25:03');

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
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

  --
  -- Đang đổ dữ liệu cho bảng `student_component_scores`
  --

  INSERT INTO `student_component_scores` (`id`, `student_id`, `course_class_id`, `subject_component_id`, `score`, `created_at`, `updated_at`) VALUES
  (142, 29, 60, 65, 10.00, '2026-03-14 14:24:12', '2026-03-14 14:24:12'),
  (143, 29, 60, 66, 10.00, '2026-03-14 14:24:12', '2026-03-14 14:24:12'),
  (144, 29, 60, 67, 10.00, '2026-03-14 14:24:12', '2026-03-14 14:24:12'),
  (145, 29, 60, 68, 10.00, '2026-03-14 14:24:12', '2026-03-14 14:24:12');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `student_course_classes`
  --

  CREATE TABLE `student_course_classes` (
    `student_id` bigint UNSIGNED NOT NULL,
    `course_class_id` bigint UNSIGNED NOT NULL,
    `subject_id` bigint UNSIGNED NOT NULL,
    `semester_id` bigint UNSIGNED NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Đang đổ dữ liệu cho bảng `student_course_classes`
  --

  INSERT INTO `student_course_classes` (`student_id`, `course_class_id`, `subject_id`, `semester_id`) VALUES
  (29, 66, 55, 2),
  (29, 60, 56, 2),
  (30, 65, 58, 2);

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `student_profiles`
  --

  CREATE TABLE `student_profiles` (
    `id` bigint UNSIGNED NOT NULL,
    `student_id` bigint UNSIGNED NOT NULL,
    `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `gender` enum('Nam','Nữ','Khác') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `date_of_birth` date DEFAULT NULL,
    `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `identity_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
    `education_type` enum('Chính quy','Liên thông','Tại chức') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Chính quy',
    `status` enum('Đang học','Bảo lưu','Thôi học','Đã tốt nghiệp') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Đang học'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Đang đổ dữ liệu cho bảng `student_profiles`
  --

  INSERT INTO `student_profiles` (`id`, `student_id`, `full_name`, `gender`, `date_of_birth`, `email`, `phone`, `address`, `identity_number`, `avatar`, `education_type`, `status`) VALUES
  (17, 29, 'Nguyễn Đức Trọng', 'Nam', '2005-04-03', 'ductrong34end@gmail.com', '0968843380', 'Xã Thư Lâm - Tỉnh Hà Nội', '001205022394', 'profile.jpg', 'Chính quy', 'Đã tốt nghiệp'),
  (18, 30, 'Nguyen Van A', 'Nam', '2026-03-11', 'duc@gmail.com', '0123456789', 'Xã Thư Lâm - Tỉnh Hà Nội', '034205009263', '', 'Chính quy', 'Đang học'),
  (19, 31, 'Nguyen Van B', 'Nữ', '2026-03-08', 'abc@gmail.com', '0976483819', 'Xã Thư Lâm - Tỉnh Hà Nộidd', '001205022394', '', 'Chính quy', 'Bảo lưu'),
  (20, 32, 'Nguyen Van C', 'Nam', '2026-03-12', 'abc1@gmail.com', '01354345263', 'Đông Anh - Hà Nội2', '034205009263', '', 'Chính quy', 'Đang học'),
  (21, 33, 'Nguyen Van D', 'Nữ', '2026-03-10', 'abc12@gmail.com', '2452372575', 'Xã Thư Lâm - Tỉnh Hà Nội', '23452457675678', '', 'Chính quy', 'Đang học'),
  (22, 34, 'Nguyen Van E', 'Nam', '2026-03-03', 'abc123@gmail.com', '0976483819', 'Xã Thư Lâm - Tỉnh Hà Nộisdas', '001205022394', '', 'Chính quy', 'Đang học'),
  (23, 35, 'Nguyen Van F', 'Nam', '2026-03-17', 'abc1233@gmail.com', '2463574657', 'Xã Thư Lâm - Tỉnh Hà Nộisdas', '5465768676564', '', 'Chính quy', 'Đang học'),
  (24, 36, 'Nguyen Van G', 'Nam', '2026-03-09', 'abc12334@gmail.com', '0968843380', 'Xã Thư Lâm - Tỉnh Hà Nộidd', '001205022394', '', 'Chính quy', 'Đang học');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `student_semesters`
  --

  CREATE TABLE `student_semesters` (
    `id` int NOT NULL,
    `student_id` bigint UNSIGNED NOT NULL,
    `semester_id` bigint UNSIGNED NOT NULL,
    `status` enum('studying','reserved','absent') DEFAULT 'studying',
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

  --
  -- Đang đổ dữ liệu cho bảng `student_semesters`
  --

  INSERT INTO `student_semesters` (`id`, `student_id`, `semester_id`, `status`, `created_at`) VALUES
  (2, 29, 1, 'studying', '2026-03-02 02:57:43'),
  (3, 32, 1, 'studying', '2026-03-09 09:13:59'),
  (4, 34, 1, 'studying', '2026-03-09 09:42:50'),
  (5, 33, 1, 'studying', '2026-03-09 09:43:11'),
  (6, 29, 2, 'studying', '2026-03-10 10:41:53'),
  (7, 30, 2, 'studying', '2026-03-10 10:41:53'),
  (8, 31, 2, 'reserved', '2026-03-10 10:41:53'),
  (9, 32, 2, 'studying', '2026-03-10 10:41:53'),
  (10, 33, 2, 'studying', '2026-03-10 10:41:53'),
  (11, 34, 2, 'studying', '2026-03-10 10:41:53'),
  (12, 35, 2, 'studying', '2026-03-10 10:41:53'),
  (13, 36, 2, 'studying', '2026-03-10 10:41:53'),
  (21, 30, 1, 'studying', '2026-03-10 12:02:17'),
  (22, 31, 1, 'reserved', '2026-03-10 12:02:17'),
  (23, 35, 1, 'studying', '2026-03-10 12:02:17'),
  (24, 36, 1, 'studying', '2026-03-10 12:02:17'),
  (28, 29, 3, 'studying', '2026-03-10 12:23:33'),
  (29, 30, 3, 'studying', '2026-03-10 12:23:33'),
  (30, 31, 3, 'studying', '2026-03-10 12:23:33'),
  (31, 32, 3, 'studying', '2026-03-10 12:23:33'),
  (32, 33, 3, 'studying', '2026-03-10 12:23:33'),
  (33, 34, 3, 'studying', '2026-03-10 12:23:33'),
  (34, 35, 3, 'studying', '2026-03-10 12:23:33'),
  (35, 36, 3, 'studying', '2026-03-10 12:23:33'),
  (36, 29, 7, 'studying', '2026-03-12 20:59:34'),
  (37, 29, 8, 'studying', '2026-03-12 20:59:43');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `subjects`
  --

  CREATE TABLE `subjects` (
    `id` bigint UNSIGNED NOT NULL,
    `subject_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `credits` int DEFAULT '3',
    `department_id` bigint UNSIGNED DEFAULT NULL,
    `subject_type` enum('NORMAL','PROJECT') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'NORMAL',
    `recommended_year` int NOT NULL DEFAULT '1'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Đang đổ dữ liệu cho bảng `subjects`
  --

  INSERT INTO `subjects` (`id`, `subject_code`, `name`, `credits`, `department_id`, `subject_type`, `recommended_year`) VALUES
  (53, 'LTCB00001', 'Lập trình căn bản', 3, 13, 'NORMAL', 1),
  (54, 'TH00001', 'Tin học', 3, 13, 'NORMAL', 1),
  (55, 'ĐáTN00001', 'Đồ án tốt nghiệp', 6, 13, 'PROJECT', 3),
  (56, 'LTHđT00001', 'Lập trình hướng đối tượng', 3, 13, 'NORMAL', 1),
  (57, 'HQTCSDL00001', 'Hệ quản trị cơ sở dữ liệu', 3, 13, 'NORMAL', 2),
  (58, 'TA00001', 'Tiếng Anh', 3, 13, 'NORMAL', 1),
  (59, 'TK300001', 'Thiết kế 3D', 3, 14, 'NORMAL', 2),
  (60, 'TKđHVQC00001', 'Thiết kế đồ họa và quảng cáo', 3, 14, 'NORMAL', 1),
  (62, 'PTTKHT00001', 'Phân tích thiết kế hệ thống', 3, 13, 'NORMAL', 2),
  (63, 'QCA00001', 'Quả Chín ấn', 6, 15, 'NORMAL', 1);

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `subject_score_components`
  --

  CREATE TABLE `subject_score_components` (
    `id` bigint UNSIGNED NOT NULL,
    `subject_id` bigint UNSIGNED NOT NULL,
    `name` varchar(100) DEFAULT NULL,
    `type` enum('TX','DK','CK','PROJECT') NOT NULL,
    `weight` decimal(5,2) NOT NULL,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

  --
  -- Đang đổ dữ liệu cho bảng `subject_score_components`
  --

  INSERT INTO `subject_score_components` (`id`, `subject_id`, `name`, `type`, `weight`, `created_at`) VALUES
  (56, 53, 'Chuyên cần', 'TX', 10.00, '2026-03-01 21:22:59'),
  (57, 53, 'Bài kiểm tra 1', 'TX', 10.00, '2026-03-01 21:22:59'),
  (58, 53, 'Bài kiểm tra 2', 'DK', 20.00, '2026-03-01 21:22:59'),
  (59, 53, 'Bài thi', 'CK', 60.00, '2026-03-01 21:22:59'),
  (60, 54, 'Chuyên cần', 'TX', 10.00, '2026-03-01 21:24:22'),
  (61, 54, 'Bài kiểm tra 1', 'TX', 10.00, '2026-03-01 21:24:22'),
  (62, 54, 'Bài kiểm tra 2', 'DK', 20.00, '2026-03-01 21:24:22'),
  (63, 54, 'Bài thi', 'CK', 60.00, '2026-03-01 21:24:22'),
  (64, 55, 'Đồ án', 'PROJECT', 100.00, '2026-03-01 21:24:56'),
  (65, 56, 'Chuyên cần', 'TX', 10.00, '2026-03-01 21:25:56'),
  (66, 56, 'Bài kiểm tra 1', 'TX', 10.00, '2026-03-01 21:25:56'),
  (67, 56, 'Bài kiểm tra 2', 'DK', 20.00, '2026-03-01 21:25:56'),
  (68, 56, 'Bài thi', 'CK', 60.00, '2026-03-01 21:25:56'),
  (69, 57, NULL, 'TX', 10.00, '2026-03-04 12:01:04'),
  (70, 57, NULL, 'TX', 10.00, '2026-03-04 12:01:04'),
  (71, 57, NULL, 'CK', 60.00, '2026-03-04 12:01:04'),
  (72, 57, NULL, 'DK', 20.00, '2026-03-04 12:01:04'),
  (73, 58, NULL, 'TX', 8.00, '2026-03-04 13:36:04'),
  (74, 58, NULL, 'TX', 8.00, '2026-03-04 13:36:04'),
  (75, 58, NULL, 'TX', 8.00, '2026-03-04 13:36:04'),
  (76, 58, NULL, 'DK', 16.00, '2026-03-04 13:36:04'),
  (77, 58, NULL, 'CK', 60.00, '2026-03-04 13:36:04'),
  (78, 59, NULL, 'TX', 8.00, '2026-03-06 14:36:46'),
  (79, 59, NULL, 'TX', 8.00, '2026-03-06 14:36:46'),
  (80, 59, NULL, 'TX', 8.00, '2026-03-06 14:36:46'),
  (81, 59, NULL, 'DK', 16.00, '2026-03-06 14:36:46'),
  (82, 59, NULL, 'CK', 60.00, '2026-03-06 14:36:46'),
  (83, 60, NULL, 'TX', 10.00, '2026-03-06 15:14:09'),
  (84, 60, NULL, 'TX', 10.00, '2026-03-06 15:14:09'),
  (85, 60, NULL, 'DK', 20.00, '2026-03-06 15:14:09'),
  (86, 60, NULL, 'CK', 60.00, '2026-03-06 15:14:09'),
  (88, 62, NULL, 'TX', 10.00, '2026-03-07 10:24:07'),
  (89, 62, NULL, 'TX', 10.00, '2026-03-07 10:24:07'),
  (90, 62, NULL, 'DK', 20.00, '2026-03-07 10:24:07'),
  (91, 62, NULL, 'PROJECT', 60.00, '2026-03-07 10:24:07'),
  (92, 63, NULL, 'TX', 5.00, '2026-03-10 12:33:12'),
  (93, 63, NULL, 'TX', 5.00, '2026-03-10 12:33:12'),
  (94, 63, NULL, 'TX', 5.00, '2026-03-10 12:33:12'),
  (95, 63, NULL, 'TX', 5.00, '2026-03-10 12:33:12'),
  (96, 63, NULL, 'DK', 10.00, '2026-03-10 12:33:12'),
  (97, 63, NULL, 'DK', 10.00, '2026-03-10 12:33:12'),
  (98, 63, NULL, 'CK', 60.00, '2026-03-10 12:33:12');

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `timetables`
  --

  CREATE TABLE `timetables` (
    `id` bigint UNSIGNED NOT NULL,
    `course_class_id` bigint UNSIGNED NOT NULL,
    `room_id` bigint UNSIGNED NOT NULL,
    `day_of_week` tinyint NOT NULL,
    `session` enum('Sáng','Chiều') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `start_week` int NOT NULL,
    `end_week` int NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Đang đổ dữ liệu cho bảng `timetables`
  --

  INSERT INTO `timetables` (`id`, `course_class_id`, `room_id`, `day_of_week`, `session`, `start_week`, `end_week`) VALUES
  (30, 61, 3, 3, 'Chiều', 1, 5),
  (31, 60, 1, 3, 'Sáng', 1, 5),
  (32, 62, 2, 3, 'Sáng', 1, 5),
  (33, 63, 1, 4, 'Chiều', 1, 6);

  -- --------------------------------------------------------

  --
  -- Cấu trúc bảng cho bảng `training_office`
  --

  CREATE TABLE `training_office` (
    `id` bigint UNSIGNED NOT NULL,
    `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `office_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
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
    `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `role` enum('admin','lecturer','student','training_office','academic_affairs','exam_office','student_affairs') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `ref_id` bigint UNSIGNED NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  --
  -- Đang đổ dữ liệu cho bảng `users`
  --

  INSERT INTO `users` (`id`, `username`, `password`, `role`, `ref_id`) VALUES
  (1, 'admin123', '123', 'admin', 0),
  (4, 'nvt', '123', 'student', 16),
  (23, 'nguyenductrong', '123', 'student', 22),
  (26, 'pdt', '123', 'training_office', 1),
  (31, 'hocvu', '123', 'academic_affairs', 1),
  (32, 'khaothi', '123', 'exam_office', 1),
  (33, 'ctsv', '123', 'student_affairs', 1),
  (34, 'GV00001', 'GV00001', 'lecturer', 62),
  (37, '202600001', '202600001', 'student', 29),
  (38, 'GV00002', 'GV00002', 'lecturer', 63),
  (39, 'HV00001', 'HV00001', 'academic_affairs', 2),
  (40, '202600002', '202600002', 'student', 30),
  (41, '202600003', '202600003', 'student', 31),
  (42, '202600004', '202600004', 'student', 32),
  (43, '202600005', '202600005', 'student', 33),
  (44, '202600006', '202600006', 'student', 34),
  (45, '202600007', '202600007', 'student', 35),
  (46, '202600008', '202600008', 'student', 36),
  (47, 'GV00003', 'GV00003', 'lecturer', 64),
  (48, 'GV00004', 'GV00004', 'lecturer', 65),
  (49, 'GV00005', 'GV00005', 'lecturer', 66),
  (50, 'GV00006', 'GV00006', 'lecturer', 67),
  (51, 'GV00007', 'GV00007', 'lecturer', 68),
  (53, 'GV00008', 'GV00008', 'lecturer', 69);

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
    ADD KEY `fk_course_classes_semester` (`semester_id`);

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
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `uq_year_semester` (`academic_year`,`semester_number`);

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
    ADD UNIQUE KEY `uq_student_subject_semester` (`student_id`,`subject_id`,`semester_id`),
    ADD KEY `course_class_id` (`course_class_id`);

  --
  -- Chỉ mục cho bảng `student_profiles`
  --
  ALTER TABLE `student_profiles`
    ADD PRIMARY KEY (`id`),
    ADD KEY `fk_profile_student` (`student_id`);

  --
  -- Chỉ mục cho bảng `student_semesters`
  --
  ALTER TABLE `student_semesters`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `student_id` (`student_id`,`semester_id`),
    ADD KEY `fk_student_semesters_semester` (`semester_id`);

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
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

  --
  -- AUTO_INCREMENT cho bảng `academic_results`
  --
  ALTER TABLE `academic_results`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

  --
  -- AUTO_INCREMENT cho bảng `attendance`
  --
  ALTER TABLE `attendance`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

  --
  -- AUTO_INCREMENT cho bảng `classes`
  --
  ALTER TABLE `classes`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

  --
  -- AUTO_INCREMENT cho bảng `class_sessions`
  --
  ALTER TABLE `class_sessions`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

  --
  -- AUTO_INCREMENT cho bảng `course_classes`
  --
  ALTER TABLE `course_classes`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

  --
  -- AUTO_INCREMENT cho bảng `department`
  --
  ALTER TABLE `department`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

  --
  -- AUTO_INCREMENT cho bảng `exam_office`
  --
  ALTER TABLE `exam_office`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

  --
  -- AUTO_INCREMENT cho bảng `lecturer`
  --
  ALTER TABLE `lecturer`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

  --
  -- AUTO_INCREMENT cho bảng `rooms`
  --
  ALTER TABLE `rooms`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

  --
  -- AUTO_INCREMENT cho bảng `semesters`
  --
  ALTER TABLE `semesters`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

  --
  -- AUTO_INCREMENT cho bảng `student`
  --
  ALTER TABLE `student`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

  --
  -- AUTO_INCREMENT cho bảng `student_affairs`
  --
  ALTER TABLE `student_affairs`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

  --
  -- AUTO_INCREMENT cho bảng `student_component_scores`
  --
  ALTER TABLE `student_component_scores`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

  --
  -- AUTO_INCREMENT cho bảng `student_profiles`
  --
  ALTER TABLE `student_profiles`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

  --
  -- AUTO_INCREMENT cho bảng `student_semesters`
  --
  ALTER TABLE `student_semesters`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

  --
  -- AUTO_INCREMENT cho bảng `subjects`
  --
  ALTER TABLE `subjects`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

  --
  -- AUTO_INCREMENT cho bảng `subject_score_components`
  --
  ALTER TABLE `subject_score_components`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

  --
  -- AUTO_INCREMENT cho bảng `timetables`
  --
  ALTER TABLE `timetables`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

  --
  -- AUTO_INCREMENT cho bảng `training_office`
  --
  ALTER TABLE `training_office`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

  --
  -- AUTO_INCREMENT cho bảng `users`
  --
  ALTER TABLE `users`
    MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

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
    ADD CONSTRAINT `fk_course_classes_semester` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE RESTRICT;

  --
  -- Ràng buộc cho bảng `department`
  --
  ALTER TABLE `department`
    ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `department` (`id`) ON DELETE SET NULL;

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
  -- Ràng buộc cho bảng `student_semesters`
  --
  ALTER TABLE `student_semesters`
    ADD CONSTRAINT `fk_student_semesters_semester` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE,
    ADD CONSTRAINT `fk_student_semesters_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE;

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
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
