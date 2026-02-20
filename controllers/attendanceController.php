<?php
require_once '../models/course_classesModel.php';
require_once '../models/timetableModel.php';
require_once '../config/config.php';
require_once '../models/attendanceModel.php';
require_once '../models/classSessionsModel.php';
class attendanceController
{
    private $connect;
    private $attendanceModel;
    private $courseClassesModel;
    private $classSessionsModel;
    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->attendanceModel = new AttendanceModel($connect);
        $this->courseClassesModel = new course_classesModel($connect);
        $this->classSessionsModel = new classSessionsModel($connect);
    }
    public function sessions()
    {
        $courseClassId = $_GET['course_class_id'];

        // Lấy danh sách buổi học
        $sessions = $this->classSessionsModel->getByCourseClassId($courseClassId);

        // Lấy sinh viên lớp
        $students = $this->courseClassesModel->getStudents($courseClassId);

        // Lấy toàn bộ điểm danh theo lớp
        $attendanceResult = $this->attendanceModel->getAttendanceByCourseClass($courseClassId);

        // Map dữ liệu attendance theo student_id + session_id
        $attendanceMap = [];
        while ($row = mysqli_fetch_assoc($attendanceResult)) {
            $attendanceMap[$row['student_id']][$row['session_id']] = $row['status'];

        }

        // $attendanceResult = $this->attendanceModel->getAttendanceBySession($selectedSessionId);


        // if ($selectedSessionId) {
        //     $students = $this->courseClassesModel->updateAttendanceByCourseClass($courseClassId);
        //     $attendanceResult = $this->attendanceModel->getAttendanceBySession($selectedSessionId);

        //     $attendanceMap = [];
        //     while ($row = mysqli_fetch_assoc($attendanceResult)) {
        //         $attendanceMap[$row['student_id']] = $row['status'];
        //     }
        // }

        require_once "./../views/admin/lecturer/sessions.php";
    }


    // Lưu điểm danh
    public function saveAttendance()
    {
        if (!isset($_POST['course_class_id'])) {
            die("Thiếu course_class_id");
        }

        $courseClassId = $_POST['course_class_id'];
        $attendanceData = $_POST['attendance'] ?? [];

        $result = $this->attendanceModel->saveAttendance($courseClassId, $attendanceData);

        if ($result) {
            $_SESSION['success'] = 'Đã lưu điểm danh thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi khi lưu điểm danh';
        }

        header("Location: index.php?controller=attendance&action=sessions&course_class_id=$courseClassId");
        exit;
    }

}