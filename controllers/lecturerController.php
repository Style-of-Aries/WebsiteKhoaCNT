<?php
// require_once '../models/userModel.php';
require_once '../models/lecturerModel.php';
require_once '../models/course_classesModel.php';
require_once '../models/timetableModel.php';
require_once '../config/config.php';
require_once '../models/resultModel.php';
class lecturerController
{
    private $resultModel;
    private $courseClassModel;
    private $lecturerModel;
    private $timetableModel;
    public function __construct()
    {
        $this->resultModel = new resultModel();
        $this->courseClassModel = new course_classesModel();
        $this->lecturerModel = new lecturerModel();
        $this->timetableModel = new timetableModel();
    }


    public function index()
    {
        $user = $_SESSION['user'];
        $lecturer = $this->lecturerModel->getById($user['ref_id']);
        // $subjectsTeaching = $this->lecturerModel->sidebarSubjects($user['ref_id']);
        require_once './../views/user/lecturer/index.php';
    }

    public function getCourseClass()
    {
        $role = $_SESSION['user']['role'];
        $lecturerId = $_SESSION['user']['ref_id'];
        // $classes = $this->courseClassModel->getCourseClassGV($lecturerId);
        if ($role === 'admin' || $role === 'exam_office') {
            $classes = $this->courseClassModel->getAll();
        } else {
            $classes = $this->courseClassModel->getCourseClassGV($lecturerId);
        }
        require_once '../views/admin/lecturer/listCourseClass.php';
    }
    public function getStudentsWithExamConditions()
    {
        if (!isset($_GET['course_class_id'])) {
            die('Thiếu course_class_id');
        }

        $courseClassId = $_GET['course_class_id'];

        $students = $this->courseClassModel->getStudentsWithExamConditions($courseClassId);


        require_once "./../views/user/lecturer/listStudentsByCourseClass.php";
    }


    public function lichDayGv()
    {
        $lecturerId = $_SESSION['user']['ref_id'];

        $weeks = $this->timetableModel->getWeeksOfActiveSemester();

        $week = isset($_GET['week']) ? (int) $_GET['week'] : null;

        if ($week) {
            $timetables = $this->timetableModel->lichDayGvTheoTuan($lecturerId, $week);
        } else {
            $timetables = [];
        }

        require_once './../views/user/lecturer/lichDay.php';
    }


    public function updateResultByCourseClass()
    {
        if (!isset($_SESSION['user']['ref_id'])) {
            die('Chưa đăng nhập');
        }

        if (!isset($_GET['course_class_id'])) {
            die('Thiếu course_class_id');
        }
        $classId = $_GET['course_class_id'];
        $students = $this->courseClassModel->updateResultByCourseClass($classId);
        require_once "./../views/admin/score/updateResult.php";
    }

    // public function saveScores()
    // {
    //     if (!isset($_POST['class_id'], $_POST['scores'])) {
    //         die('Thiếu dữ liệu');
    //     }

    //     $classId = $_POST['class_id'];
    //     $scores = $_POST['scores'];
    //     $model = $this->resultModel;

    //     foreach ($scores as $studentId => $studentScores) {

    //         foreach ($studentScores as $type => $score) {

    //             // Cho phép chưa nhập
    //             if ($score === '' || $score === null) {
    //                 continue;
    //             }

    //             // Validate khi có nhập
    //             if (!is_numeric($score) || $score < 0 || $score > 10) {
    //                 $_SESSION['error'] = 'Điểm phải nằm trong khoảng 0 - 10';
    //                 header("Location: index.php?controller=lecturer&action=updateResultByCourseClass&course_class_id=$classId");
    //                 exit;
    //             }
    //         }
    //     }

    //     foreach ($scores as $studentId => $score) {
    //         $model->saveScore(
    //             $studentId,
    //             $classId,
    //             $score['process'] ?? null,
    //             $score['mid'] ?? null,
    //             $score['final'] ?? null
    //         );
    //     }
    //     $_SESSION['success'] = 'Nhập điểm thành công';
    //     header("Location: index.php?controller=lecturer&action=getStudentsByCourseClass&class_id=$classId");
    //     exit;
    // }

    public function saveScores()
    {
        // 🔐 Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Bạn chưa đăng nhập';
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $role = $_SESSION['user']['role'];

        // 🔐 Phân quyền
        if (!in_array($role, ['admin','lecturer', 'exam_office'])) {
            $_SESSION['error'] = 'Bạn không có quyền truy cập';
            header('Location: index.php');
            exit;
        }

        // 🔎 Kiểm tra dữ liệu POST
        if (!isset($_POST['class_id'], $_POST['scores'])) {
            $_SESSION['error'] = 'Thiếu dữ liệu gửi lên';
            header('Location: index.php');
            exit;
        }

        $classId = $_POST['class_id'];
        $scores = $_POST['scores'];

        // ✅ Validate điểm TX
        foreach ($scores as $studentId => $studentScores) {
            if (isset($studentScores['frequent'])) {
                foreach ($studentScores['frequent'] as $score) {

                    if ($score === '' || $score === null) {
                        continue;
                    }

                    if (!is_numeric($score) || $score < 0 || $score > 10) {
                        $_SESSION['error'] = 'Điểm phải nằm trong khoảng 0 - 10';
                        header("Location: index.php?controller=lecturer&action=updateResultByCourseClass&course_class_id=$classId");
                        exit;
                    }
                }
            }
        }

        // 💾 Lưu DB
        foreach ($scores as $studentId => $studentScores) {

            $frequentScores = $studentScores['frequent'] ?? [];

            $frequentScores = array_filter($frequentScores, function ($s) {
                return $s !== '' && is_numeric($s);
            });

            $frequentJson = json_encode($frequentScores);

            $processAvg = null;
            if (count($frequentScores) > 0) {
                $processAvg = round(array_sum($frequentScores) / count($frequentScores), 2);
            }

            $midtermScore = $studentScores['mid'] ?? null;
            if ($midtermScore === '' || !is_numeric($midtermScore)) {
                $midtermScore = null;
            } elseif ($midtermScore < 0 || $midtermScore > 10) {
                $_SESSION['error'] = 'Điểm phải nằm trong khoảng 0 - 10';
                header("Location: index.php?controller=lecturer&action=updateResultByCourseClass&course_class_id=$classId");
                exit;
            }

            $finalExamScore = $studentScores['final'] ?? null;
            if ($finalExamScore === '' || !is_numeric($finalExamScore)) {
                $finalExamScore = null;
            } elseif ($finalExamScore < 0 || $finalExamScore > 10) {
                $_SESSION['error'] = 'Điểm phải nằm trong khoảng 0 - 10';
                header("Location: index.php?controller=lecturer&action=updateResultByCourseClass&course_class_id=$classId");
                exit;
            }

            $this->resultModel->saveScore(
                $studentId,
                $classId,
                $frequentJson,
                $processAvg,
                $midtermScore,
                $finalExamScore,
                $role
            );
        }

        $_SESSION['success'] = 'Nhập điểm thành công';

        header("Location: index.php?controller=lecturer&action=updateResultByCourseClass&course_class_id=$classId");
        exit;
    }



}
