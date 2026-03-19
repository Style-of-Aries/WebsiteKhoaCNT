<?php
require_once "./../models/adminModel.php";
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
require_once "./../models/classesModel.php";
require_once "./../models/departmentModel.php";
class classesController
{
    private $connect;
    private $userModel;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $departmentModel;
    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->classesModel = new classesModel($connect);
        $this->studentModel = new studentModel($connect);
        $this->userModel = new userModel($connect);
        $this->lecturerModel = new lecturerModel($connect);
        $this->departmentModel = new departmentModel($connect);
    }

    public function getAllLopHoc()
    {

        $classes = $this->classesModel->getAll();
        require_once './../views/admin/classes/list.php';
    }
    public function getAllSinhVienCuaLop()
    {
        $id = $_GET['id'];
        $students = $this->classesModel->getAllSinhVienCuaLop($id);
        require_once './../views/admin/classes/listSv.php';
    }

    public function addLopHoc()
    {
        $errorLop = '';
        $department = $this->departmentModel->getAllDepartment();
        $lecturer = $this->lecturerModel->getAll();
        require_once './../views/admin/classes/add.php';
    }
    public function editLh()
    {
        $id = $_GET['id'];
        $user = $this->classesModel->getById($id);
        $department = $this->departmentModel->getAllDepartment();
        $lecturer = $this->lecturerModel->getAll();
        require_once './../views/admin/classes/edit.php';
    }
    // thêm 
    public function getLecturerByDepartment()
    {
        $department_id = $_GET['id'];

        $lecturers = $this->classesModel->getLecturerByDepartment($department_id);

        header('Content-Type: application/json');
        echo json_encode($lecturers);
        exit;
    }
    public function add()
    {
        $old = [];
        $errorLop = '';
        if (isset($_POST['btn_add'])) {

            $old = $_POST;
            $class_name = $_POST['class_name'];
            $class_code = $class_name;
            $department_id = $_POST['department_id'];
            $lecturer_id = $_POST['lecturer_id'];
            if ($this->classesModel->checkMaLopAdd($class_code)) {
                $errorLop = "Lớp hành chính đã tồn tại";
            }
            if (empty($errorLop)) {
                $class = $this->classesModel->addLopHoc($class_name, $class_code, $department_id, $lecturer_id);
                if ($class) {
                    $this->getAllLopHoc();
                    exit();
                }
            }
        }
        // nếu sai gán lại dữ liệu
        $department = $this->departmentModel->getAllDepartment();
        $lecturer = $this->lecturerModel->getAll();
        include_once "./../views/admin/classes/add.php";
    }
    // sửa 
    public function edit()
    {
        // Luôn lấy danh sách để tránh lỗi khi load lại view
        $department = $this->departmentModel->getAllDepartment();
        $lecturer = $this->lecturerModel->getAll();

        if (isset($_POST['btn_edit'])) {
            $id = $_POST['id'];
            $class_name = $_POST['class_name'];
            $class_code = $_POST['class_code'];
            $department_id = $_POST['department_id'];
            $lecturer_id = $_POST['lecturer_id'];
            if ($this->classesModel->checkMaLop( $class_code,$id)) {
                $errorLop = "Lớp hành chính đã tồn tại";
            }
            if (empty($errorLop)) {
                $this->classesModel->editLopHoc($id, $class_name, $class_code, $department_id, $lecturer_id);
                $this->getAllLopHoc();
                exit;
            } else {
                // Gán lại dữ liệu vừa nhập để hiển thị lại form
                $user = [
                    'id' => $id,
                    'class_name' => $class_name,
                    'class_code' => $class_code,
                    'department_id' => $department_id,
                    'lecturer_id' => $lecturer_id
                ];
                $department = $this->departmentModel->getAllDepartment();
                $lecturer = $this->lecturerModel->getAll();
            }
        } else {
            // Load dữ liệu ban đầu khi vào trang edit
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $user = $this->classesModel->getById($id);
            }
        }
        include_once "./../views/admin/classes/edit.php";
    }
    public function deleteLh()
    {

        $id = $_GET['id'];
        $this->classesModel->deleteLh($id);
        $this->getAllLopHoc();
    }
}
