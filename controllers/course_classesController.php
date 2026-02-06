<?php
require_once "./../models/adminModel.php";
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
require_once "./../models/classesModel.php";
require_once "./../models/departmentModel.php";
require_once "./../models/subjectModel.php";
require_once "./../models/course_classesModel.php";
require_once "./../models/semesterModel.php";
require_once "./../models/timetableModel.php";
require_once "./../models/roomModel.php";
require_once "./../models/classSessionsModel.php";


class course_classesController
{
    private $classSessionsModel;
    private $userModel;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $departmentModel;
    private $subjectModel;
    private $course_classesModel;
    private $semesterModel;
    private $timetableModel;
    private $roomModel;

    public function __construct()
    {
        $this->classSessionsModel = new classSessionsModel();
        $this->classesModel = new classesModel();
        $this->studentModel = new studentModel();
        $this->userModel = new userModel();
        $this->lecturerModel = new lecturerModel();
        $this->departmentModel = new departmentModel();
        $this->subjectModel = new subjectModel();
        $this->course_classesModel = new course_classesModel();
        $this->semesterModel = new semesterModel();
        $this->timetableModel = new timetableModel();
        $this->roomModel = new roomModel();
    }

    public function getAllHocPhan()
    {
        $course_classes = $this->course_classesModel->getAll();
        require_once './../views/admin/course_classes/list.php';
    }


    public function lichHoc()
    {
        $id = $_GET['id'];
        $time_tables = $this->timetableModel->getAll($id);
        require_once './../views/admin/course_classes/timetable.php';
    }
    public function addHocPhan()
    {
        $errorHocPhan = "";
        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        $semesters = $this->semesterModel->getAll();
        $semester = $this->semesterModel->getActiveSemester();

        if (!$semester) {
            die("Chưa có học kỳ đang hoạt động");
        }

        // 2. ngày bắt đầu & kết thúc học kỳ
        $semesterStart = $semester['start_date']; // YYYY-MM-DD
        $semesterEnd = $semester['end_date'];   // YYYY-MM-DD

        // 3. tính tổng số tuần
        $days = (strtotime($semesterEnd) - strtotime($semesterStart)) / 86400 + 1;
        $totalWeeks = ceil($days / 7);

        $totalWeeks = ceil(
            (strtotime($semesterEnd) - strtotime($semesterStart) + 86400)
            / (7 * 86400)
        );
        $rooms = $this->roomModel->getAll();
        require_once './../views/admin/course_classes/add.php';
    }
    public function editHocPhan()
    {
        $id = $_GET['id'];
        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        $semester = $this->semesterModel->getAll();
        $course_classes = $this->course_classesModel->getById($id);
        require_once './../views/admin/course_classes/edit.php';
    }
    // thêm 
    public function add()
    {
        $errorHocPhan = "";

        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        $rooms = $this->roomModel->getAll();

        // 👉 LẤY HỌC KỲ ĐANG HOẠT ĐỘNG
        $semester = $this->semesterModel->layHocKyDangHoatDong();
        if (!$semester) {
            die(" Không có học kỳ đang hoạt động");
        }

        $semester_id = $semester['id'];
        $semesterStart = $semester['start_date'];
        $semesterEnd = $semester['end_date'];

        $totalWeeks = ceil(
            (strtotime($semesterEnd) - strtotime($semesterStart) + 86400)
            / (7 * 86400)
        );

        if (isset($_POST['btn_add'])) {

            $subject_id = (int) $_POST['subject_id'];
            $lecturer_id = (int) $_POST['lecturer_id'];
            $max_students = (int) $_POST['max_students'];

            $room_id = (int) $_POST['room_id'];
            $day = (int) $_POST['day_of_week'];
            $session = $_POST['session'];
            $startWeek = (int) $_POST['start_week'];
            $endWeek = (int) $_POST['end_week'];

            // ===== VALIDATE =====
            if ($startWeek > $endWeek) {
                $errorHocPhan = "Tuần bắt đầu không được lớn hơn tuần kết thúc";
            }

            if (
                $this->course_classesModel->tonTaiHocPhan(
                    $subject_id,
                    $lecturer_id,
                    $semester_id
                )
            ) {
                $errorHocPhan = " Giảng viên đã dạy môn này trong học kỳ";
            }

            if ($this->timetableModel->phongDaCoLich($room_id, $day, $session)) {
                $errorHocPhan = " Phòng học đã có lịch";
            }

            if (empty($errorHocPhan)) {

                $class_code = $this->course_classesModel->malop($subject_id);

                $course_class_id = $this->course_classesModel->themHocPhan(
                    $subject_id,
                    $lecturer_id,
                    $semester_id,
                    $class_code,
                    $max_students
                );

                $this->timetableModel->themThoiKhoaBieu(
                    $course_class_id,
                    $room_id,
                    $day,
                    $session,
                    $startWeek,
                    $endWeek
                );
                $this->classSessionsModel->generateSessions($course_class_id);
                $this->getAllHocPhan();
                exit();
            }
        }

        require_once './../views/admin/course_classes/add.php';
    }
    // sửa 
    public function edit()
    {
        if ($_POST['btn_edit']) {
            $id = $_POST['id'];
            $subject_id = $_POST['subject_id'];
            $lecturer_id = $_POST['lecturer_id'];
            $semester_id = $_POST['semester_id'];
            $max_students = $_POST['max_students'];
            $class_code = $_POST['class_code'];
            if ($this->course_classesModel->checkHocPhan($subject_id, $lecturer_id, $semester_id)) {
                $errorHocPhan = "Giảng viên đã dạy môn này!";
            }
            if (empty($errorHocPhan)) {
                $course_classes = $this->course_classesModel->editHocPhan($id, $subject_id, $lecturer_id, $semester_id, $class_code, $max_students);
                if ($course_classes) {
                    $this->getAllHocPhan();
                    exit();
                }
            } else {

                $course_classes = [
                    'max_students' => $max_students,
                    'class_code' => $class_code,
                    'id' => $id,
                    'subject_id' => $subject_id,
                    'lecturer_id' => $lecturer_id,
                    'semester_id' => $semester_id
                ];
                $subject = $this->subjectModel->getAll();
                $lecturer = $this->lecturerModel->getAll();
                $semester = $this->semesterModel->getAll();
            }
        }
        include_once "./../views/admin/course_classes/edit.php";
    }
    public function deleteHocPhan()
    {
        $id = $_GET['id'];
        $this->course_classesModel->deleteHocPhan($id);
        $this->getAllHocPhan();
    }

    public function getStudents()
    {
        if (!isset($_GET['id'])) {
            die('Thiếu id lớp học phần');
        }

        $id = $_GET['id'];
        $course_class = $this->course_classesModel->getById($id);
        $students = $this->course_classesModel->getStudentsWithExamConditions($id);

        require_once './../views/admin/course_classes/listStudents.php';
    }
}
