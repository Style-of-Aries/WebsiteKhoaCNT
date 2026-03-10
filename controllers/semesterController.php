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
require_once "./../models/studentSemesterModel.php";
class semesterController
{
    private $userModel;
    private $connect;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $departmentModel;
    private $subjectModel;
    private $course_classesModel;
    private $studentSemesterModel;
    private $semesterModel;
    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->classesModel = new classesModel($connect);
        $this->studentModel = new studentModel($connect);
        $this->studentSemesterModel = new studentSemesterModel($connect);
        $this->userModel = new userModel($connect);
        $this->lecturerModel = new lecturerModel($connect);
        $this->departmentModel = new departmentModel($connect);
        $this->subjectModel = new subjectModel($connect);
        $this->course_classesModel = new course_classesModel($connect);
        $this->semesterModel = new semesterModel($connect);
    }

    public function getAllSemester()
    {
        $semesters = $this->semesterModel->getAll();
        require_once './../views/admin/semester/list.php';
    }


    public function getAllGiangVienCuaKhoa()
    {
        $id = $_GET['id'];
        $department = $this->departmentModel->getAllGiangVienCuaKhoa($id);
        require_once './../views/admin/department/listGv.php';
    }
    public function addSemester()
    {
        require_once './../views/admin/semester/add.php';
    }
    public function editSemester()
    {
        $id = $_GET['id'];
        $semester = $this->semesterModel->getById($id);
        if (!$semester) {
            $_SESSION['error'] = "không có thông tin học kỳ với id = $id";
            header("Location: index.php?controller=semester&action=getAllSemester");
            exit;
        }
        require_once './../views/admin/semester/edit.php';
    }
    // thêm 
    public function add()
    {
        $errors = "";

        if (isset($_POST['btn_add'])) {

            $semester_number = $_POST['semester_number'] ?? '';
            $academic_year = trim($_POST['academic_year'] ?? '');
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';

            $name = "Học kỳ " . $semester_number;

            // VALIDATE SEMESTER
            if (!in_array($semester_number, [1, 2])) {
                $errors = "Học kỳ không hợp lệ";
            }

            // VALIDATE YEAR
            if (!preg_match('/^\d{4}-\d{4}$/', $academic_year) && $errors === "") {
                $errors = "Năm học phải có định dạng YYYY-YYYY";
            } else {

                list($year1, $year2) = explode('-', $academic_year);

                if ($year2 != $year1 + 1 && $errors === "") {
                    $errors = "Năm học sau phải lớn hơn năm trước 1 năm";
                }
            }

            // VALIDATE DATE
            if ((empty($start_date) || empty($end_date)) && $errors === "") {
                $errors = "Phải chọn ngày bắt đầu và ngày kết thúc";
            } else {

                if (strtotime($start_date) >= strtotime($end_date) && $errors === "") {
                    $errors = "Ngày kết thúc phải sau ngày bắt đầu";
                }
            }

            // CHECK EXISTS
            if (empty($errors)) {

                if ($this->semesterModel->semesterExists($academic_year, $semester_number)) {
                    $errors = "Học kỳ này đã tồn tại";
                }
            }

            // INSERT
            if (empty($errors)) {

                $result = $this->semesterModel->addSemester(
                    $name,
                    $academic_year,
                    $semester_number,
                    $start_date,
                    $end_date
                );

                if ($result) {

                    $_SESSION['success'] = "Tạo học kỳ thành công";
                    header("Location: index.php?controller=semester&action=getAllSemester");
                    exit();

                } else {

                    $errors = "Không thể tạo học kỳ";
                }
            }

            $_SESSION['error'] = $errors;
            $_SESSION['old'] = $_POST;
            header("Location: index.php?controller=semester&action=addSemester");
            exit();
        }
    }
    // sửa 
    public function edit()
    {
        $errors = "";

        $id = $_GET['id'] ?? 0;

        if (isset($_POST['btn_update'])) {

            $semester_number = $_POST['semester_number'] ?? '';
            $academic_year = trim($_POST['academic_year'] ?? '');
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';

            $name = "Học kỳ " . $semester_number;

            // VALIDATE SEMESTER
            if (!in_array($semester_number, [1, 2])) {
                $errors = "Học kỳ không hợp lệ";
            }

            // VALIDATE YEAR
            if (!preg_match('/^\d{4}-\d{4}$/', $academic_year) && $errors === "") {

                $errors = "Năm học phải có định dạng YYYY-YYYY";

            } else {

                list($year1, $year2) = explode('-', $academic_year);

                if ($year2 != $year1 + 1 && $errors === "") {
                    $errors = "Năm học sau phải lớn hơn năm trước 1 năm";
                }
            }

            // VALIDATE DATE
            if ((empty($start_date) || empty($end_date)) && $errors === "") {

                $errors = "Phải chọn ngày bắt đầu và ngày kết thúc";

            } else {

                if (strtotime($start_date) >= strtotime($end_date) && $errors === "") {
                    $errors = "Ngày kết thúc phải sau ngày bắt đầu";
                }
            }


            // UPDATE
            if (empty($errors)) {

                $result = $this->semesterModel->updateSemester(
                    $id,
                    $name,
                    $academic_year,
                    $semester_number,
                    $start_date,
                    $end_date
                );

                if ($result) {

                    $_SESSION['success'] = "Cập nhật học kỳ thành công";
                    header("Location: index.php?controller=semester&action=getAllSemester");
                    exit();

                } else {

                    $errors = "Không thể cập nhật học kỳ";
                }
            }

            $_SESSION['error'] = $errors;
            $_SESSION['old'] = $_POST;

            header("Location: index.php?controller=semester&action=editSemester&id=" . $id);
            exit();
        }
    }
    public function deleteSemester()
    {
        $id = $_GET['id'];
        $this->semesterModel->deleteSemester($id);
        header("Location: index.php?controller=semester&action=getAllSemester");
    }

    public function activateSemester()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "Không tìm thấy học kỳ";
            header("Location:index.php?controller=semester&action=getAllSemester");
            exit();
        }

        $id = (int) $_GET['id'];

        // Lấy học kỳ cần kích hoạt
        $semester = $this->semesterModel->getById($id);

        if (!$semester) {
            $_SESSION['error'] = "Học kỳ không tồn tại";
            header("Location:index.php?controller=semester&action=getAllSemester");
            exit();
        }

        // Kiểm tra nếu đã active
        if ($semester['is_active'] == 1) {
            $_SESSION['error'] = "Học kỳ này đã được kích hoạt";
            header("Location:index.php?controller=semester&action=getAllSemester");
            exit();
        }

        // Kiểm tra ngày hợp lệ
        if (strtotime($semester['start_date']) >= strtotime($semester['end_date'])) {
            $_SESSION['error'] = "Thời gian học kỳ không hợp lệ";
            header("Location:index.php?controller=semester&action=getAllSemester");
            exit();
        }

        // Kiểm tra có học kỳ đang active không
        $activeSemester = $this->semesterModel->getActiveSemester();

        if ($activeSemester) {

            // Nếu học kỳ hiện tại chưa kết thúc
            if (strtotime($activeSemester['end_date']) > NOW) {

                $_SESSION['error'] = "Học kỳ hiện tại chưa kết thúc, không thể kích hoạt học kỳ mới";
                header("Location:index.php?controller=semester&action=getAllSemester");
                exit();
            }
        }


        // Kích hoạt học kỳ mới
        $result = $this->semesterModel->activateSemester($id);

        if ($result) {
            $this->studentSemesterModel->createForNewSemester($id);
            $_SESSION['success'] = "Kích hoạt học kỳ thành công";

        } else {

            $_SESSION['error'] = "Không thể kích hoạt học kỳ";
        }

        header("Location:index.php?controller=semester&action=getAllSemester");
        exit();
    }

    public function deactivateSemester()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "Không tìm thấy học kỳ";
            header("Location:index.php?controller=semester&action=getAllSemester");
            exit();
        }

        $id = (int) $_GET['id'];

        $semester = $this->semesterModel->getById($id);

        if (!$semester) {
            $_SESSION['error'] = "Học kỳ không tồn tại";
            header("Location:index.php?controller=semester&action=getAllSemester");
            exit();
        }

        if ($semester['is_active'] == 0) {
            $_SESSION['error'] = "Học kỳ đã tắt";
            header("Location:index.php?controller=semester&action=getAllSemester");
            exit();
        }

        $result = $this->semesterModel->deactivateSemester($id);

        if ($result) {
            $_SESSION['success'] = "Đã tắt học kỳ";
        } else {
            $_SESSION['error'] = "Không thể tắt học kỳ";
        }

        header("Location:index.php?controller=semester&action=getAllSemester");
        exit();
    }
}
