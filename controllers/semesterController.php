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
class course_classesController
{
    private $userModel;private $connect;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $departmentModel;
    private $subjectModel;
    private $course_classesModel;
    private $semesterModel;
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
    }

    public function getAllHocPhan()
    {
        $course_classes = $this->course_classesModel->getAll();
        require_once './../views/admin/course_classes/list.php';
    }
    

    public function getAllGiangVienCuaKhoa()
    {
        $id = $_GET['id'];
        $department = $this->departmentModel->getAllGiangVienCuaKhoa($id);
        require_once './../views/admin/department/listGv.php';
    }
    public function addHocPhan()
    {
        $subject = $this->subjectModel->getAll();
        $lecturer = $this->lecturerModel->getAll();
        require_once './../views/admin/course_classes/add.php';
    }
    public function editMonHoc()
    {
        $id = $_GET['id'];
        $department = $this->departmentModel->getAll();
        $subject = $this->subjectModel->getById($id);
        require_once './../views/admin/subject/edit.php';
    }
    // thêm 
    public function add()
    {
        if ($_POST['btn_add']) {
            $name = $_POST['name'];
            $subject_code = $_POST['subject_code'];
            $credits = $_POST['credits'];
            $department_id = $_POST['department_id'];
            $subjects = $this->subjectModel->addMonHoc($name, $subject_code, $credits,$department_id);
            if ($subjects) {
                $this->getAllHocPhan();
            }
        }
    }
    // sửa 
    public function edit()
    {
        if ($_POST['btn_edit']) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $subject_code = $_POST['subject_code'];
            $credits = $_POST['credits'];
            $department_id = $_POST['department_id'];
            if ($this->subjectModel->checkMonHoc($id, $name)) {
                $errorMaSv = "Khoa đã tồn tại";
            }
            if (empty($errorMaSv)) {
                $this->subjectModel->editMonHoc($id,$name, $subject_code, $credits,$department_id);
                $this->getAllHocPhan();

                exit;
            } else {
                // Gán lại dữ liệu vừa nhập để hiển thị lại form
                $subject = [
                    'id' => $id,
                    'name' => $name,
                    'subject_code' => $subject_code,
                    'credits' => $credits,
                ];
                $department = $this->departmentModel->getAll();

            }
        }
        include_once "./../views/admin/subject/edit.php";
    }
    public function deleteMonHoc()
    {
        $id = $_GET['id'];
        $this->subjectModel->deleteMonHoc($id);
        $this->getAllHocPhan();
    }
}
