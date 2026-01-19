<?php
require_once "./../models/adminModel.php";
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
require_once "./../models/classesModel.php";
require_once "./../models/departmentModel.php";
require_once "./../models/subjectModel.php";
class subjectController
{
    private $userModel;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $departmentModel;
    private $subjectModel;
    public function __construct()
    {
        $this->classesModel = new classesModel();
        $this->studentModel = new studentModel();
        $this->userModel = new userModel();
        $this->lecturerModel = new lecturerModel();
        $this->departmentModel = new departmentModel();
        $this->subjectModel = new subjectModel();
    }

    public function getAllMonHoc()
    {
        $subjects = $this->subjectModel->getAll();
        require_once './../views/admin/subject/list.php';
    }

    public function getAllGiangVienCuaKhoa()
    {
        $id = $_GET['id'];
        $department = $this->departmentModel->getAllGiangVienCuaKhoa($id);
        require_once './../views/admin/department/listGv.php';
    }
    public function addMonHoc()
    {
        $department = $this->departmentModel->getAll();
        require_once './../views/admin/subject/add.php';
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
                $this->getAllMonHoc();
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
                $this->getAllMonHoc();

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
        $this->getAllMonHoc();
    }
}
