<?php
// require_once '../models/userModel.php';
require_once '../models/lecturerModel.php';
require_once '../models/course_classesModel.php';
require_once '../models/timetableModel.php';
require_once '../config/config.php';
require_once '../models/resultModel.php';
// require_once '../models/scoreComponentsModel.php';
require_once '../models/studentModel.php';
require_once '../models/studentComponentScoresModel.php';
require_once '../services/ScoreService.php';
require_once '../models/subjectScoreComponentsModel.php';
require_once '../models/academicResultsModel.php';
class lecturerController
{
    private $ScoreService;
    private $academicResultsModel;
    private $resultModel;
    private $subjectScoreComponentsModel;
    private $connect;
    private $courseClassModel;
    private $lecturerModel;
    private $studentModel;
    private $studentComponentScoresModel;
    private $timetableModel;
    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->studentModel = new studentModel($connect);
        $this->subjectScoreComponentsModel = new subjectScoreComponentsModel($connect);
        $this->academicResultsModel = new academicResultsModel($connect);
        $this->ScoreService = new ScoreService($connect);
        $this->studentComponentScoresModel = new studentComponentScoresModel($connect);
        $this->resultModel = new resultModel($connect);
        $this->courseClassModel = new course_classesModel($connect);
        $this->lecturerModel = new lecturerModel($connect);
        $this->timetableModel = new timetableModel($connect);
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
            $_SESSION['error'] = "Chưa đăng nhập";
            header('Location: index.php');
            exit;
        }

        if (!isset($_GET['course_class_id'])) {
            $_SESSION['error'] = "Thiếu course_class_id";
            header('Location: index.php?controller=lecturer&action=getCourseClass&type=score');
            exit;
        }

        $classId = (int) $_GET['course_class_id'];

        // 1️⃣ Lấy thông tin lớp học phần
        $courseClass = $this->courseClassModel->getById($classId);

        if (!$courseClass) {
            $_SESSION['error'] = "Lớp học phần không tồn tại";
            header('Location: index.php?controller=lecturer&action=getCourseClass&type=score');
            exit;
        }

        $subjectId = $courseClass['subject_id'];

        // 2️⃣ Lấy sinh viên
        $studentsResult = $this->courseClassModel->getStudents($classId);

        // Chuyển về mảng để dùng nhiều lần
        $students = [];
        while ($row = mysqli_fetch_assoc($studentsResult)) {
            $students[] = $row;
        }

        // 3️⃣ Lấy cấu trúc điểm
        $components = $this->subjectScoreComponentsModel->getBySubject($subjectId);

        // 4️⃣ Lấy điểm sinh viên
        $scores = $this->studentComponentScoresModel->getScores($classId);

        // 5️⃣ Nếu là phòng khảo thí → tính điều kiện thi
        $eligibilities = [];

        if ($_SESSION['user']['role'] === 'exam_office' || $_SESSION['user']['role'] === 'admin') {

            $eligibilities = $this->ScoreService
                ->getEligibilityList($students, $classId);
        }

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
        $courseClassId = $_POST['course_class_id'] ?? null;
        $scores = $_POST['scores'] ?? null;

        if (!in_array($role, ['admin', 'lecturer', 'exam_office'])) {
            $_SESSION['error'] = "Bạn không có quyền!";
            header("Location: index.php");
            exit;
        }

        if (!$scores || !is_array($scores)) {
            $_SESSION['error'] = "Không có dữ liệu điểm!";
            header("Location: index.php");
            exit;
        }

        mysqli_begin_transaction($this->connect);

        try {

            $result = $this->ScoreService->saveMultipleScores(
                $scores,
                $courseClassId,
                $role
            );

            if (!empty($result['errors'])) {
                throw new Exception(implode("<br>", $result['errors']));
            }

            mysqli_commit($this->connect);
            $_SESSION['success'] = "Đã lưu {$result['successCount']} điểm!";

        } catch (Exception $e) {

            mysqli_rollback($this->connect);
            $_SESSION['error'] = $e->getMessage();
            error_log(
                date('Y-m-d H:i:s') . " | " . $e->getMessage() . PHP_EOL,
                3,
                __DIR__ . "/../logs/error.log"
            );
        }

        header("Location: index.php?controller=lecturer&action=updateResultByCourseClass&course_class_id=$courseClassId");
        exit;
    }

}
