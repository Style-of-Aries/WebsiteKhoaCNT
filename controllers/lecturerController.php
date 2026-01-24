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
        $user = $_SESSION['user'];
        $lecturer = $this->lecturerModel->getById($user['ref_id']);
        $subjectsTeaching = $this->lecturerModel->sidebarSubjects($user['ref_id']);
        require_once './../views/user/lecturer/index.php';
    }

    
    
}
