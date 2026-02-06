<?php
// require_once '../models/userModel.php';
require_once '../models/lecturerModel.php';
require_once '../models/studentModel.php';
require_once '../models/course_classesModel.php';
require_once '../models/timetableModel.php';
require_once '../config/config.php';
require_once '../models/resultModel.php';
require_once '../models/trainningOfficeModel.php';
class trainningOfficeController
{
    private $resultModel;
    private $courseClassModel;
    private $lecturerModel;
    private $studentModel;
    private $timetableModel;
    private $trainningOfficeModel;
    public function __construct()
    {
        $this->resultModel = new resultModel();
        $this->courseClassModel = new course_classesModel();
        $this->lecturerModel = new lecturerModel();
        $this->studentModel = new studentModel();
        $this->timetableModel = new timetableModel();
        $this->trainningOfficeModel = new trainningOfficeModel();
        $this->studentModel = new studentModel();
    }


    public function getAll()
    {
        $students = $this->studentModel->getAll();
        require_once './../views/user/trainningOffice/list.php';
    }

    public function getCourseClass()
    {
        $lecturerId = $_SESSION['user']['ref_id'];
        $classes = $this->courseClassModel->getCourseClassGV($lecturerId);
        require_once '../views/user/lecturer/listCourseClass.php';
    }
    public function lichDayGv()
    {
        $lecturerId = $_SESSION['user']['ref_id'];

        $weeks = $this->timetableModel->getWeeksOfActiveSemester();

        $week = isset($_GET['week']) ? (int)$_GET['week'] : null;

        if ($week) {
            $timetables = $this->timetableModel->lichDayGvTheoTuan($lecturerId, $week);
        } else {
            $timetables = [];
        }

        require_once './../views/user/lecturer/lichDay.php';
    }


    public function getStudentsByCourseClass()
    {
        if (!isset($_SESSION['user']['ref_id'])) {
            die('Chưa đăng nhập giảng viên');
        }

        if (!isset($_GET['class_id'])) {
            die('Thiếu class_id');
        }
        $classId = $_GET['class_id'];
        $students = $this->courseClassModel->getStudentByCourseClass($classId);
        require_once "./../views/user/lecturer/listStudents.php";
    }

    public function saveScores()
    {
        if (!isset($_POST['class_id'], $_POST['scores'])) {
            die('Thiếu dữ liệu');
        }

        $classId = $_POST['class_id'];
        $scores = $_POST['scores'];
        $model = $this->resultModel;

        foreach ($scores as $studentId => $studentScores) {

            foreach ($studentScores as $type => $score) {

                // Cho phép chưa nhập
                if ($score === '' || $score === null) {
                    continue;
                }

                // Validate khi có nhập
                if (!is_numeric($score) || $score < 0 || $score > 10) {
                    $_SESSION['error'] = 'Điểm phải nằm trong khoảng 0 - 10';
                    header('Location: index.php?controller=lecturer&action=getStudentsByCourseClass&class_id=' . $classId);
                    exit;
                }
            }
        }

        foreach ($scores as $studentId => $score) {
            $model->saveScore(
                $studentId,
                $classId,
                $score['process'] ?? null,
                $score['mid'] ?? null,
                $score['final'] ?? null
            );
        }
        $_SESSION['success'] = 'Nhập điểm thành công';
        header("Location: index.php?controller=lecturer&action=getStudentsByCourseClass&class_id=$classId");
        exit;
    }
}
