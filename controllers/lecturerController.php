<?php
// require_once '../models/userModel.php';
require_once '../models/lecturerModel.php';
require_once '../models/course_classesModel.php';
require_once '../models/timetableModel.php';
require_once '../config/config.php';
require_once '../models/resultModel.php';
require_once '../models/scoreComponentsModel.php';
require_once '../models/studentModel.php';
require_once '../models/studentComponentScoresModel.php';
class lecturerController
{
    private $resultModel;
    private $connect;
    private $courseClassModel;
    private $lecturerModel;
    private $studentModel;
    private $studentComponentScoresModel;
    private $timetableModel;
    private $scoreComponentsModel;
    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->studentModel = new studentModel($connect);
        $this->studentComponentScoresModel = new studentComponentScoresModel($connect);
        $this->resultModel = new resultModel($connect);
        $this->courseClassModel = new course_classesModel($connect);
        $this->lecturerModel = new lecturerModel($connect);
        $this->timetableModel = new timetableModel($connect);
        $this->scoreComponentsModel = new scoreComponentsModel($connect);
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
        // $students = $this->courseClassModel->updateResultByCourseClass($classId);
        $students = $this->courseClassModel->getStudents($classId);
        $components = $this->scoreComponentsModel->getByCourseClass($classId);
        $scores = $this->studentComponentScoresModel->getScores($classId);
        // require_once "./../views/admin/score/updateResult.php";
        require_once "./../views/admin/score/enterScoreNew.php";

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
        if (!in_array($role, ['admin', 'lecturer', 'exam_office'])) {
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

    public function saveScoresNew()
    {

        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Bạn chưa đăng nhập!";
            header("Location: index.php");
            exit;
        }

        $role = $_SESSION['user']['role'];
        $course_class_id = $_POST['course_class_id'];
        if (!in_array($role, ['admin', 'lecturer', 'exam_office'])) {
            $_SESSION['error'] = "Bạn không có quyền!";
            header("Location: index.php?controller=lecturer&action=updateResultByCourseClass&course_class_id=$course_class_id");
            exit;
        }

        if (!isset($_POST['scores']) || !is_array($_POST['scores'])) {
            $_SESSION['error'] = "Không có dữ liệu điểm!";
            header("Location: index.php?controller=lecturer&action=updateResultByCourseClass&course_class_id=$course_class_id");
            exit;
        }

        $errors = [];
        $successCount = 0;

        mysqli_begin_transaction($this->connect);

        foreach ($_POST['scores'] as $studentId => $components) {

            if (!ctype_digit((string) $studentId)) {
                $errors[] = "Student ID không hợp lệ: $studentId";
                continue;
            }

            if (!$this->studentModel->studentExists($studentId)) {
                $errors[] = "Sinh viên không tồn tại: $studentId";
                continue;
            }

            foreach ($components as $componentId => $scoreValue) {

                if ($scoreValue === '')
                    continue;

                if (!ctype_digit((string) $componentId)) {
                    $errors[] = "Component ID không hợp lệ: $componentId";
                    continue;
                }

                $component = $this->scoreComponentsModel->getComponentById($componentId);
                if (!$component) {
                    $errors[] = "Thành phần điểm không tồn tại";
                    continue;
                }

                if (!$this->studentComponentScoresModel->canEditComponent($role, $component['type'])) {
                    $errors[] = "Không có quyền nhập {$component['type']}";
                    continue;
                }

                if (!preg_match('/^(10|[0-9](\.[0-9])?)$/', $scoreValue)) {
                    $errors[] = "Điểm không hợp lệ (SV: $studentId)";
                    continue;
                }

                $scoreValue = round((float) $scoreValue, 1);

                if (!$this->studentComponentScoresModel->saveScore($studentId, $componentId, $scoreValue)) {
                    $errors[] = "Lỗi khi lưu SV: $studentId";
                    continue;
                }

                $successCount++;
            }
        }

        if (!empty($errors)) {
            mysqli_rollback($this->connect);
            $_SESSION['error'] = implode("<br>", $errors);
        } else {
            mysqli_commit($this->connect);
            $_SESSION['success'] = "Đã lưu $successCount điểm!";
        }

        header("Location: index.php?controller=lecturer&action=updateResultByCourseClass&course_class_id=$course_class_id");
        exit;
    }




}
