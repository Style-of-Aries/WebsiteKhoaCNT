<?php
require_once "./../models/adminModel.php";
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
require_once "./../models/classesModel.php";
class classesController
{
    private $userModel;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    public function __construct()
    {
        $this->classesModel = new classesModel();
        $this->studentModel = new studentModel();
        $this->userModel = new userModel();
        $this->lecturerModel = new lecturerModel();
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
}
