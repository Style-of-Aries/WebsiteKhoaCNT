<?php
require_once '../models/userModel.php';
require_once '../models/studentModel.php';
require_once '../config/config.php';
class studentController
{
    private $studentModel;
    public function __construct()
    {
        $this->studentModel = new studentModel();
    }


    public function index()
    {
        $students = $this->studentModel->getAll();
        require_once './../views/user/student/index.php';
    }
    public function profile()
    {
        $user = $_SESSION['user'];
        $profile = $this->studentModel->getAllProfile($user['ref_id']);
        $_SESSION['profile'] = $profile;
        include "./../views/user/profile.php";
        require_once '../views/user/profile.php';
    }

    public function getAllResult()
    {
        include './../views/user/result.php';
    }

    public function getSchedule()
    {
        include "./../views/user/schedule.php";
    }

    


}
