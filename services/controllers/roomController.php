<?php
require_once "./../models/adminModel.php";
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
require_once "./../models/classesModel.php";
require_once "./../models/departmentModel.php";
require_once "./../models/subjectModel.php";
require_once "./../models/course_classesModel.php";
require_once "./../models/semesterModel.php";
require_once "./../models/timetableModel.php";
require_once "./../models/roomModel.php";

class roomController
{
    private $userModel;
    private $connect;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $departmentModel;
    private $subjectModel;
    private $course_classesModel;
    private $semesterModel;
    private $timetableModel;
    private $roomModel;

    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->classesModel = new classesModel($connect);
        $this->studentModel = new studentModel($connect);
        $this->userModel = new userModel($connect);
        $this->lecturerModel = new lecturerModel($connect);
        $this->departmentModel = new departmentModel($connect);
        $this->subjectModel = new subjectModel($connect);
        $this->course_classesModel = new course_classesModel($connect);
        $this->semesterModel = new semesterModel($connect);
        $this->timetableModel = new timetableModel($connect);
        $this->roomModel = new roomModel($connect);
    }

    public function getAll()
    {
        $room = $this->roomModel->getAll();
        require_once './../views/admin/room/list.php';
    }

    public function addPhongHoc()
    {
        require_once './../views/admin/room/add.php';
    }
    public function editPhongHoc()
    {
        $id = $_GET['id'];
        $rooms = $this->roomModel->getById($id);
        require_once './../views/admin/room/edit.php';
    }
    // thêm 
    public function add()
    {
        $errorName = null;
        $old = [];

        if (isset($_POST['btn_add'])) {

            $room_name = $_POST['room_name'] ?? null;
            $building = $_POST['building'] ?? null;
            $capacity = $_POST['capacity'] ?? null;
            $type = $_POST['type'] ?? null;

            // Lưu lại dữ liệu cũ
            $old = [
                'room_name' => $room_name,
                'building' => $building,
                'capacity' => $capacity,
                'type' => $type
            ];

            // 1Kiểm tra email trùng
            $checkName = $this->roomModel->checkName($room_name, $building);

            if ($checkName) {
                $errorName = "Phòng học đã tồn tại!";
            } else {
                $room = $this->roomModel->addRoom(
                    $room_name,
                    $building,
                    $capacity,
                    $type
                );

                if ($room) {
                    $this->getAll();
                    exit();
                }
            }
        }

        include_once "./../views/admin/room/add.php";
    }
    // sửa 
    public function edit()
    {
        if ($_POST['btn_edit']) {
            $id = $_POST['id'];
            $room_name = $_POST['room_name'] ?? null;
            $building = $_POST['building'] ?? null;
            $capacity = $_POST['capacity'] ?? null;
            $type = $_POST['type'] ?? null;
            $checkName = $this->roomModel->checkNameId($id, $room_name, $building);
            if ($checkName) {
                $errorName = "Phòng học đã tồn tại!";
            }

            if (empty($errorName)) {
                $room = $this->roomModel->editPhongHoc($id,$room_name,$building,$capacity,$type);
                if ($room) {
                    $this->getAll();
                    exit();
                }
            } else {

                $rooms = [
                    'room_name' => $room_name,
                    'building' => $building,
                    'id' => $id,
                    'capacity' => $capacity,
                    'type' => $type
                ];
                
            }
        }
        include_once "./../views/admin/room/edit.php";
    }
    public function deleteRoom()
    {
        $id = $_GET['id'];
        $this->roomModel->deleteRoom($id);
        $this->getAll();
    }
}
