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
    public function getAllSinhVienCuaLop(){
        $id=$_GET['id'];
        $students = $this->classesModel->getAllSinhVienCuaLop($id);
        require_once './../views/admin/classes/listSv.php';
    }
    public function addLopHoc()
    {
        $department = $this->departmentModel->getAllDepartment();
        $lecturer = $this->lecturerModel->getAll();
        require_once './../views/admin/classes/add.php';
    }
    public function editLh()
    {
        $id=$_GET['id'];
        $user= $this->classesModel->getById($id);
        $department = $this->departmentModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        require_once './../views/admin/classes/edit.php';
    }
    // thêm 
    public function add()
    {
        if ($_POST['btn_add']) {
            $class_name = $_POST['class_name'];
            $class_code = $class_name;
            $department_id = $_POST['department_id'];
            $lecturer_id = $_POST['lecturer_id'];
            $class = $this->classesModel->addLopHoc($class_name, $class_code, $department_id, $lecturer_id);
            if ($class) {
                $this->getAllLopHoc();
            }
        }
    }
    // sửa 
    public function edit(){
        if ($_POST['btn_edit']) {
            $id= $_POST['id'];
            $class_name = $_POST['class_name'];
            $class_code = $_POST['class_code'];
            $department_id = $_POST['department_id'];
            $lecturer_id = $_POST['lecturer_id'];
            if ($this->classesModel->checkMaLop($id, $class_code)) {
                $errorMaSv = "Lớp đã tồn tại";
            }
            if (empty($errorMaSv)) {
                $this->classesModel->editLopHoc($id,$class_name, $class_code, $department_id, $lecturer_id);
                $this->getAllLopHoc();
                exit;
            }
             else {
                // Gán lại dữ liệu vừa nhập để hiển thị lại form
                $user = [
                    'id' => $id,
                    'class_name' => $class_name,
                    'class_code' => $class_code,
                    'department_id' => $department_id,
                    'lecturer_id' => $lecturer_id
                ];
                $department= $this->departmentModel->getAll();
                $lecturer= $this->lecturerModel->getAll();
            }
        }
        include_once "./../views/admin/classes/edit.php";

    }
    public function deleteLh(){

        $id= $_GET['id'];
        $this->classesModel->deleteLh($id);
        $this->getAllLopHoc();
    }
}
