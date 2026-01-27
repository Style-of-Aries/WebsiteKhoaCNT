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

class course_classesController
{
    private $userModel;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $departmentModel;
    private $subjectModel;
    private $course_classesModel;
    private $semesterModel;
    private $timetableModel;

    public function __construct()
    {
        $this->classesModel = new classesModel();
        $this->studentModel = new studentModel();
        $this->userModel = new userModel();
        $this->lecturerModel = new lecturerModel();
        $this->departmentModel = new departmentModel();
        $this->subjectModel = new subjectModel();
        $this->course_classesModel = new course_classesModel();
        $this->semesterModel = new semesterModel();
        $this->timetableModel = new timetableModel();
    }

    public function getAllHocPhan()
    {
        $course_classes = $this->course_classesModel->getAll();
        require_once './../views/admin/course_classes/list.php';
    }


    public function lichHoc()
    {
        $id = $_GET['id'];
        $time_tables = $this-> timetableModel->getAll($id);
        require_once './../views/admin/course_classes/timetable.php';
    }
    public function addHocPhan()
    {
        $errorHocPhan = "";
        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        $semester = $this->semesterModel->getAll();
        require_once './../views/admin/course_classes/add.php';
    }
    public function editHocPhan()
    {
        $id = $_GET['id'];
        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        $semester = $this->semesterModel->getAll();
        $course_classes=$this->course_classesModel->getById($id);
        require_once './../views/admin/course_classes/edit.php';
    }
    // thêm 
    public function add()
    {
        if ($_POST['btn_add']) {

            $subject_id = $_POST['subject_id'];
            $lecturer_id = $_POST['lecturer_id'];
            $semester_id = $_POST['semester_id'];
            $max_students = $_POST['max_students'];
            $class_code = $this->course_classesModel->malop($subject_id);
            if ($this->course_classesModel->checkHocPhan($subject_id, $lecturer_id, $semester_id)) {
                $errorHocPhan = "Giảng viên đã dạy môn này!";
            }
            if (empty($errorHocPhan)) {
                $course_classes = $this->course_classesModel->addHocPhan($subject_id, $lecturer_id, $semester_id, $class_code, $max_students);
                if ($course_classes) {
                    $this->getAllHocPhan();
                    exit();
                }
            } else {
                $subject = $this->subjectModel->getAll();
                $lecturer = $this->lecturerModel->getAll();
                $semester = $this->semesterModel->getAll();
            }
        }
        include_once "./../views/admin/course_classes/add.php";
    }
    // sửa 
    public function edit()
    {
        if ($_POST['btn_edit']) {
            $id = $_POST['id'];
            $subject_id = $_POST['subject_id'];
            $lecturer_id = $_POST['lecturer_id'];
            $semester_id = $_POST['semester_id'];
            $max_students = $_POST['max_students'];
            $class_code = $_POST['class_code'];
            if ($this->course_classesModel->checkHocPhan($subject_id, $lecturer_id, $semester_id)) {
                $errorHocPhan = "Giảng viên đã dạy môn này!";
            }
            if (empty($errorHocPhan)) {
                $course_classes = $this->course_classesModel->editHocPhan($id, $subject_id, $lecturer_id, $semester_id, $class_code, $max_students);
                if ($course_classes) {
                    $this->getAllHocPhan();
                    exit();
                }
            } else {

                $course_classes = [
                    'max_students' => $max_students,
                    'class_code' => $class_code,
                    'id' => $id,
                    'subject_id' => $subject_id,
                    'lecturer_id' => $lecturer_id,
                    'semester_id' => $semester_id
                ];
                $subject = $this->subjectModel->getAll();
                $lecturer = $this->lecturerModel->getAll();
                $semester = $this->semesterModel->getAll();
            }
        }
        include_once "./../views/admin/course_classes/edit.php";
    }
    public function deleteHocPhan()
    {
        $id = $_GET['id'];
        $this->course_classesModel->deleteHocPhan($id);
        $this->getAllHocPhan();
    }
}
