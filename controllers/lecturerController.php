<?php
// require_once '../models/userModel.php';
require_once '../models/lecturerModel.php';
require_once '../models/timetableModel.php';
require_once '../config/config.php';
class lecturerController
{
    private $lecturerModel;
    private $timetableModel;
    public function __construct()
    {
        $this->lecturerModel = new lecturerModel();
        $this->timetableModel = new timetableModel();
    }
    

    public function index(){
        $user = $_SESSION['user'];
        $lecturer = $this->lecturerModel->getById($user['ref_id']);
        // $subjectsTeaching = $this->lecturerModel->sidebarSubjects($user['ref_id']);
        require_once './../views/user/lecturer/index.php';
    }

    public function lichDayGv()
    {
        $id = $_SESSION['user']['ref_id'];
        // $user = $_SESSION['user'];
        // $id =$_SESSION['user']['id'];
        $timetables=$this->timetableModel->lichDayGv($id);
        require_once './../views/user/lecturer/lichDay.php';
    }
    
}
