<?php
require_once "./../models/adminModel.php";
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
require_once "./../models/classesModel.php";
require_once "./../models/departmentModel.php";
class departmentController
{
    private $userModel;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $departmentModel;
    public function __construct()
    {
        $this->classesModel = new classesModel();
        $this->studentModel = new studentModel();
        $this->userModel = new userModel();
        $this->lecturerModel = new lecturerModel();
        $this->departmentModel = new departmentModel();
    }

    public function getAllKhoa()
    {

        $departments = $this->departmentModel->getAll();
        require_once './../views/admin/department/list.php';
    }
    public function getAllGiangVienCuaKhoa(){
        $id=$_GET['id'];
        $department = $this->departmentModel->getAllGiangVienCuaKhoa($id);
        require_once './../views/admin/department/listGv.php';
    }
    public function addKhoa()
    {
        $parents = $this->departmentModel->getParents();
        require_once './../views/admin/department/add.php';
    }
    public function editKhoa()
    {
        $id=$_GET['id'];
        $parents = $this->departmentModel->getParents();
        $user= $this->departmentModel->getById($id);
        require_once './../views/admin/department/edit.php';
    }
    // thêm 
    public function add()
    {
        if ($_POST['btn_add']) {
            $name = $_POST['name'];
            $type = $_POST['type'];
            $parent_id = $_POST['parent_id'];
            $class = $this->departmentModel->addKhoa($name, $type, $parent_id);
            if ($class) {
                $this->getAllKhoa();
            }
        }
    }
    // sửa 
    public function edit(){
        if ($_POST['btn_edit']) {
            $id= $_POST['id'];
            $name = $_POST['name'];
            $type = $_POST['type'];
            $parent_id = $_POST['parent_id'];
            if ($this->departmentModel->checkKhoa($id, $name)) {
                $errorMaSv = "Khoa đã tồn tại";
            }
            if (empty($errorMaSv)) {
                $this->departmentModel->editKhoa($id,$name, $type, $parent_id);
                $this->getAllKhoa();
                exit;
            }
             else {
                // Gán lại dữ liệu vừa nhập để hiển thị lại form
                $user = [
                    'id' => $id,
                    'name' => $name,
                    'type' => $type,
                    'parent_id' => $parent_id
                ];
            }
        }
        include_once "./../views/admin/department/edit.php";

    }
    public function deleteKhoa(){

        $id= $_GET['id'];
        $this->departmentModel->deleteKhoa($id);
        $this->getAllKhoa();
    }
}
