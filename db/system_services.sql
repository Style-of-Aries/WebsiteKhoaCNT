-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 27, 2026 lúc 09:31 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

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
-- Cấu trúc bảng cho bảng `academic_results`
--

CREATE TABLE `academic_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_class_id` bigint(20) UNSIGNED NOT NULL,
  `process_score` decimal(4,2) DEFAULT NULL,
  `midterm_score` decimal(4,2) DEFAULT NULL,
  `final_exam_score` decimal(4,2) DEFAULT NULL,
  `final_grade` decimal(5,2) DEFAULT NULL,
  `grade_letter` char(2) DEFAULT NULL,
  `result` enum('pass','fail') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_class_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late') DEFAULT 'present'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `target_type` varchar(50) DEFAULT NULL,
  `target_id` bigint(20) UNSIGNED DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `class_code` varchar(255) DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `lecturer_id` bigint(20) UNSIGNED DEFAULT NULL
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
-- Cấu trúc bảng cho bảng `course_classes`
--

CREATE TABLE `course_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `lecturer_id` bigint(20) UNSIGNED NOT NULL,
  `semester_id` bigint(20) UNSIGNED NOT NULL,
  `class_code` varchar(50) DEFAULT NULL,
  `max_students` int(11) DEFAULT 60
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `course_classes`
--

INSERT INTO `course_classes` (`id`, `subject_id`, `lecturer_id`, `semester_id`, `class_code`, `max_students`) VALUES
(1, 2, 61, 1, 'PHP1', 60),
(3, 3, 4, 1, '2026BMPM000001', 60),
(4, 2, 4, 1, '2026BMPM000002', 60);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department`
--

CREATE TABLE `department` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('school','faculty','department') NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `staff_count` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `department`
--

INSERT INTO `department` (`id`, `name`, `type`, `parent_id`, `staff_count`, `created_at`, `updated_at`) VALUES
(1, 'Trường Đại học CNTT', 'faculty', 2, 200, '2026-01-07 11:41:17', '2026-01-23 05:44:37'),
(2, 'Khoa Công nghệ Thông tin', 'faculty', 1, 80, '2026-01-07 11:41:17', '2026-01-07 11:41:17'),
(3, 'Bộ môn Phần mềm', 'department', 2, 40, '2026-01-07 11:41:17', '2026-01-07 11:41:17'),
(5, 'dsffsdg', 'school', 2, NULL, '2026-01-24 17:11:35', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `learning_materials`
--

CREATE TABLE `learning_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_url` varchar(500) DEFAULT NULL,
  `type` enum('pdf','video','doc') DEFAULT 'pdf'
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `lecturer_code` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lecturer`
--

INSERT INTO `lecturer` (`id`, `full_name`, `lecturer_code`, `email`, `department_id`) VALUES
(4, 'Nguyễn Văn Tứ', 'GV001', 'gv1@gmail.com', 3),
(11, 'Trần Thị A', 'GV002', 'gv2@gmail.com', 3),
(60, 'df', 'df', 'tutue9692@gmail.comdd', 1),
(61, 'Nguyễn Đức Trọng', '342005', 'ductrong34end@gmail.com', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `building` varchar(50) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `type` enum('theory','lab','exam') DEFAULT 'theory'
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `academic_year` varchar(20) NOT NULL,
  `semester_number` tinyint(4) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_code` varchar(50) NOT NULL,
  `class_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `student`
--

INSERT INTO `student` (`id`, `student_code`, `class_id`, `department_id`, `created_at`, `updated_at`) VALUES
(16, 'SV001', 1, 3, '2026-01-19 07:04:27', '2026-01-23 02:47:57'),
(22, '2326CNT05', 3, 2, '2026-01-23 02:27:52', '2026-01-23 03:45:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student_course_classes`
--

CREATE TABLE `student_course_classes` (
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_class_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `student_course_classes`
--

INSERT INTO `student_course_classes` (`student_id`, `course_class_id`) VALUES
(22, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `student_profiles`
--

CREATE TABLE `student_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `gender` enum('Nam','Nữ','Khác') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `identity_number` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `education_type` enum('Chính quy','Liên thông','Tại chức') DEFAULT 'Chính quy',
  `status` enum('Đang học','Tạm dừng','Thôi học','Đã tốt nghiệp') DEFAULT 'Đang học'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `student_profiles`
--

INSERT INTO `student_profiles` (`id`, `student_id`, `full_name`, `gender`, `date_of_birth`, `email`, `phone`, `address`, `identity_number`, `avatar`, `education_type`, `status`) VALUES
(1, 16, 'Nguyễn Văn Tứ', 'Nam', '2005-06-19', 'sv1@gmail.comgg', '03720165', 'Vu hoi - vu thu - thai binh', '034205009263', '1.jpg', 'Chính quy', 'Đang học'),
(13, 22, 'Nguyễn Đức Trọng', 'Nam', '2005-04-04', 'nguyenductrong@ffsdfsd.comdf', '0976483819', 'Xã Thư Lâm - Tỉnh Hà Nội', '034205009275', 'profile.jpg', 'Liên thông', 'Tạm dừng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `credits` int(11) DEFAULT 3,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `subjects`
--

INSERT INTO `subjects` (`id`, `subject_code`, `name`, `credits`, `department_id`) VALUES
(1, 'CT101', 'Lập trình C', 6, 3),
(2, 'CT202', 'Lập trình PHP', 3, 3),
(3, 'CT30', 'Cơ sở dữ liệud', 3, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `timetables`
--

CREATE TABLE `timetables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_class_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `day_of_week` tinyint(4) NOT NULL,
  `session` enum('Sáng','Chiều') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `timetables`
--

INSERT INTO `timetables` (`id`, `course_class_id`, `room_id`, `day_of_week`, `session`) VALUES
(1, 1, 1, 2, 'Sáng'),
(2, 3, 2, 3, 'Chiều'),
(3, 4, 1, 4, 'Sáng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','lecturer','student') NOT NULL,
  `ref_id` bigint(20) UNSIGNED NOT NULL
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
(22, 'nvtdfdf', 'dfdf', 'lecturer', 60),
(23, 'nguyenductrong', '123', 'student', 22),
(24, 'ductrong', '123', 'lecturer', 61);

--
-- Chỉ mục cho các bảng đã đổ
--

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
  ADD KEY `course_class_id` (`course_class_id`);

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
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `academic_results`
--
ALTER TABLE `academic_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `course_classes`
--
ALTER TABLE `course_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `department`
--
ALTER TABLE `department`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `learning_materials`
--
ALTER TABLE `learning_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `student`
--
ALTER TABLE `student`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `student_profiles`
--
ALTER TABLE `student_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `academic_results`
--
ALTER TABLE `academic_results`
  ADD CONSTRAINT `academic_results_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `academic_results_ibfk_2` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `course_classes`
--
ALTER TABLE `course_classes`
  ADD CONSTRAINT `course_classes_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_classes_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_classes_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `department` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD CONSTRAINT `learning_materials_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lecturer`
--
ALTER TABLE `lecturer`
  ADD CONSTRAINT `lecturer_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_fk_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `student_course_classes`
--
ALTER TABLE `student_course_classes`
  ADD CONSTRAINT `student_course_classes_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_course_classes_ibfk_2` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD CONSTRAINT `fk_profile_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `timetables`
--
ALTER TABLE `timetables`
  ADD CONSTRAINT `timetables_ibfk_1` FOREIGN KEY (`course_class_id`) REFERENCES `course_classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timetables_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

DELIMITER $$
--
-- Sự kiện
--
CREATE DEFINER=`root`@`localhost` EVENT `ev_update_semester_status` ON SCHEDULE EVERY 1 DAY STARTS '2026-01-25 16:47:31' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    UPDATE semesters
    SET is_active = IF(
        CURDATE() BETWEEN start_date AND end_date,
        1,
        0
    );
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
