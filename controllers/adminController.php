<?php
require_once "./../models/adminModel.php";
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
class adminController
{


    private $model;
    private $userModel;
    private $studentModel;
    private $lecturerModel;
    public function __construct()
    {
        $this->model = new adminModel();
        $this->studentModel = new studentModel();
        $this->userModel = new userModel();
        $this->lecturerModel = new lecturerModel();
    }

    // giao diện danh sách người dùng
    public function index()
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



    // bắt đầu thêm sinh viên 


    // truy cập tới giao diện sinh viên
    public function addSinhVien()
    {
        require_once './../views/admin/student/add.php';
    }
    // thêm mới sinh viên
    public function add()
    {
        if ($_POST['btn_add']) {
            $full_name = $_POST['full_name'];
            $student_code = $_POST['student_code'];
            $email = $_POST['email'];
            // $class_id = $_POST['class_id'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            $student = $this->studentModel->addSinhVien($full_name, $student_code, $email, $username, $password);
            if ($student) {
                $this->getAllSinhVien();
            }else{
                $this->no_index();
            }
        }
    }

    // kết thúc thêm sinh viên 
}
