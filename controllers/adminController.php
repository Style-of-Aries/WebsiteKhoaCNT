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
    public function index(){

        $users= $this->userModel->getAll();
        require_once './../views/admin/users/list.php';
    }
    public function getAllSinhVien(){
        $students= $this->studentModel->getAll();
        require_once './../views/admin/student/list.php';
    }
    public function getAllGiangVien(){
        $lecturers= $this->lecturerModel->getAll();
        require_once './../views/admin/lecturer/list.php';
    }
    
}
