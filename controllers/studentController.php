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
    

    public function index(){
        $students = $this->studentModel->getAll();
        require_once './../views/admin/student/list.php';
    }
    

    

    
}
