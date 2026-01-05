<?php
// require_once '../models/userModel.php';
require_once '../models/lecturerModel.php';
require_once '../config/config.php';
class lecturerController
{
    private $lecturerModel;
    public function __construct()
    {
        $this->lecturerModel = new lecturerModel();
    }
    

    public function index(){
        $students = $this->lecturerModel->getAll();
        require_once './../views/admin/lecturer/list.php';
    }

    
    
}
