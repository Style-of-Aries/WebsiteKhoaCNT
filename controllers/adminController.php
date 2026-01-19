<?php
require_once "./../models/adminModel.php";
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
require_once "./../models/classesModel.php";
require_once "./../models/departmentModel.php";
class adminController
{


    private $model;
    private $userModel;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $departmentModel;
    public function __construct()
    {
        $this->model = new adminModel();
        $this->studentModel = new studentModel();
        $this->userModel = new userModel();
        $this->lecturerModel = new lecturerModel();
        $this->classesModel = new classesModel();
        $this->departmentModel = new departmentModel();
    }

    // giao diện dashboard
    public function index()
    {
        $totalSinhVien = $this->studentModel->getAll();
        $totalGiangVien = $this->lecturerModel->getAll();
        $totalLopHoc = $this->classesModel->getAll();
        $totalKhoa = $this->departmentModel->getAll();
        require_once './../views/admin/dashboard/dashboard.php';
    }
    // giao diện danh sách người dùng
    public function getAllUser()
    {

        $users = $this->userModel->getAll();
        require_once './../views/admin/users/list.php';
    }

    public function no_index()
    {
        // $users = $this->userModel->getAll();
        require_once './../views/admin/users/list_no.php';
    }


    // giao diện danh sách sinh viên 
    public function getAllSinhVien()
    {
        $students = $this->studentModel->getAll();
        require_once './../views/admin/student/list.php';
    }
    // giao diện danh sách giảng viên 
    public function getAllGiangVien()
    {
        $lecturers = $this->lecturerModel->getAll();
        require_once './../views/admin/lecturer/list.php';
    }

    // sửa sv 

    public function editSv()
    {
        $errorEmail = $errorMaSv = $errorName = "";
        $id = $_GET['id'];
        $classes = $this->classesModel->getAll();
        $user = $this->studentModel->getById($id);
        $userNd = $this->userModel->getByRef_id($id);
        require_once './../views/admin/student/edit.php';
    }
    public function editSinhVien()
    {

        if (isset($_POST['btn_edit'])) {
            $id = $_POST['id'];
            $full_name = $_POST['full_name'];
            $student_code = $_POST['student_code'];
            $email = $_POST['email'];
            $class_id = $_POST['class_id'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            // $sdtRegister = $_POST['phone'];
            if ($this->studentModel->KtMa($id, $student_code)) {
                $errorMaSv = "Mã sinh viên đã tồn tại";
            }
            if ($this->userModel->KtUserName($username, $id)) {
                $errorName = "Tài khoản đã tồn tại";
            }
            if ($this->studentModel->KtEmail($email, $id)) {
                $errorEmail = "Email đã tồn tại";
            }
            if ($this->lecturerModel->KtEmail($email, $id)) {
                $errorEmail = "Email đã tồn tại";
            }

            if (empty($errorName) && empty($errorEmail) && empty($errorMaSv)) {
                $this->studentModel->updateSinhVien($id, $full_name, $student_code, $email, $class_id);
                $this->userModel->updateUser($id, $username, $password);
                $this->getAllSinhVien();
                exit;
            } else {
                // Gán lại dữ liệu vừa nhập để hiển thị lại form
                $user = [
                    'id' => $id,
                    'full_name' => $full_name,
                    'student_code' => $student_code,
                    'email' => $email,
                    'class_id' => null
                ];
                $userNd = [
                    'username' => $username,
                    'password' => $password
                ];
                $classes = $this->classesModel->getAll();
            }
        }
        include_once "./../views/admin/student/edit.php";
    }


    // bắt đầu thêm sinh viên 


    // truy cập tới giao diện sinh viên
    public function addSinhVien()
    {
        $classes = $this->classesModel->getAll();

        require_once './../views/admin/student/add.php';
    }
    // thêm mới sinh Đ
    public function add()
    {
        if ($_POST['btn_add']) {
            $full_name = $_POST['full_name'];
            $student_code = $_POST['student_code'];
            $email = $_POST['email'];
            $class_id = $_POST['class_id'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            $student = $this->studentModel->addSinhVien($full_name, $student_code, $email, $class_id, $username, $password);
            if ($student) {
                $this->getAllSinhVien();
            } else {
                $this->no_index();
            }
        }
    }
    public function editGv()
    {
        $errorEmail = $errorMaSv = $errorName = "";
        $id = $_GET['id'];
        $user = $this->lecturerModel->getById($id);
        $userNd = $this->userModel->getByRef_id($id);
        $department = $this->departmentModel->getAll();
        require_once './../views/admin/lecturer/edit.php';
    }
    public function editGiangVien()
    {

        if (isset($_POST['btn_edit'])) {
            $id = $_POST['id'];
            $full_name = $_POST['full_name'];
            $lecturer_code = $_POST['lecturer_code'];
            $email = $_POST['email'];
            $department_id = $_POST['department_id'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            // $sdtRegister = $_POST['phone'];

            if ($this->userModel->KtUserName($username, $id)) {
                $errorName = "Tài khoản đã tồn tại";
            }
            if ($this->lecturerModel->KtMagv($lecturer_code, $id)) {
                $errorMaSv = "Mã giảng viên đã tồn tại";
            }
            if ($this->studentModel->KtEmail($email, $id)) {
                $errorEmail = "Email đã tồn tại";
            }
            if ($this->lecturerModel->KtEmail($email, $id)) {
                $errorEmail = "Email đã tồn tại";
            }
            if ($this->lecturerModel->isLecturerCodeExists($lecturer_code, $id)) {
                $errorMaSv = "Mã giảng viên đã tồn tại";
            }
            if (empty($errorName) && empty($errorEmail) && empty($errorMaSv)) {
                $this->lecturerModel->updateGiangVien($id, $full_name, $lecturer_code, $email, $department_id);
                $this->userModel->updateUser($id, $username, $password);
                $this->getAllGiangVien();
                exit;
            } else {
                // Gán lại dữ liệu vừa nhập để hiển thị lại form
                $user = [
                    'id' => $id,
                    'full_name' => $full_name,
                    'lecturer_code' => $lecturer_code,
                    'email' => $email,
                    'department_id' => $department_id
                ];
                $userNd = [
                    'username' => $username,
                    'password' => $password
                ];
                $department = $this->departmentModel->getAll();
            }
        }
        include_once "./../views/admin/lecturer/edit.php";
    }


    // bắt đầu thêm sinh viên 



    // kết thúc thêm giảng viên 

    // bắt đầu thêm giảng viên 


    // truy cập tới giao diện sinh viên
    public function addGiangVien()
    {
        $department = $this->departmentModel->getAll();
        require_once './../views/admin/lecturer/add.php';
    }
    // thêm mới sinh viên
    public function addGv()
    {
        if ($_POST['btn_add']) {
            $full_name = $_POST['full_name'];
            $lecturer_code = $_POST['lecturer_code'];
            $email = $_POST['email'];
            $department_id = $_POST['department_id'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            $student = $this->lecturerModel->addGiangVien($full_name, $lecturer_code, $email, $department_id, $username, $password);
            if ($student) {
                $this->getAllGiangVien();
            } else {
                $this->no_index();
            }
        }
    }

    // kết thúc thêm sinh viên 

    // xóa người dùng 
    public function deleteUser()
    {
        $id = $_GET['id'];
        $role = $_GET['role'];
        $ref_id = $_GET['ref_id'];
        if ($role == 'student') {
            $this->studentModel->deleteStudent($ref_id);
        } else {
            $this->lecturerModel->deleteLecturer($ref_id);
        }
        $this->userModel->deleteUser($id);
        $this->index();
    }

    public function deleteStudent()
    {
        $ref_id = $_GET['id'];
        $id = $_GET['id'];
        $this->studentModel->deleteStudent($ref_id);
        $this->userModel->deleteUser($id);
        $this->getAllSinhVien();
    }
    public function deleteLecturer()
    {
        $ref_id = $_GET['id'];
        $id = $_GET['id'];
        $this->lecturerModel->deleteLecturer($ref_id);
        $this->userModel->deleteUser($id);
        $this->getAllGiangVien();
    }
}
