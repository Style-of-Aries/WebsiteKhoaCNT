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
class academicResultController
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


    public function searchScore()
    {
        // Khởi tạo mặc định để tránh undefined variable
        $student = null;
        $result = null;
        $statistics = [
            'avg_gpa_4' => null,
            'avg_score_10' => null,
            'passed_credits' => 0
        ];

        // Chỉ xử lý khi submit form
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['student_code'])) {

            $studentCode = trim($_POST['student_code']);

            $studentId = $this->studentModel->getIdByStudentCode($studentCode);
            if ($studentId) {

                $student = $this->studentModel->getAllProfile($studentId);
                if (!$student) {
                    $_SESSION['error'] = "Không tìm thấy sinh viên";
                    header("Location: index.php?controller=academicResult&action=searchScore");
                    exit;
                }
                $result = $this->academicResultsModel->getStudentGrades($studentId);

                $statQuery = $this->academicResultsModel->getStudentStatistics($studentId);
                $statistics = mysqli_fetch_assoc($statQuery);
            }
        }

        include './../views/admin/score/searchScore.php';
    }
}