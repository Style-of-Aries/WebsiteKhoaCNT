<?php
require_once "./../models/adminModel.php";
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
require_once "./../models/classesModel.php";
require_once "./../models/departmentModel.php";
require_once "./../models/subjectModel.php";
require_once "./../models/subjectScoreComponentsModel.php";
class subjectController
{
    private $userModel;
    private $connect;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $departmentModel;
    private $subjectModel;
    private $subjectScoreComponentsModel;
    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->subjectScoreComponentsModel = new subjectScoreComponentsModel($connect);
        $this->classesModel = new classesModel($connect);
        $this->studentModel = new studentModel($connect);
        $this->userModel = new userModel($connect);
        $this->lecturerModel = new lecturerModel($connect);
        $this->departmentModel = new departmentModel($connect);
        $this->subjectModel = new subjectModel($connect);
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
        $department = $this->departmentModel->getAllDepartment();
        require_once './../views/admin/subject/add.php';
    }
    public function editMonHoc()
    {
        $id = $_GET['id'];
        $department = $this->departmentModel->getAllDepartment();
        $subject = $this->subjectModel->getById($id);
        $components = $this->subjectScoreComponentsModel->getBySubject($id);
        require_once './../views/admin/subject/edit.php';
    }
    // thêm 
    // public function add()
    // {
    //     if ($_POST['btn_add']) {
    //         $name = $_POST['name'];
    //         $subject_code = $_POST['subject_code'];
    //         $credits = $_POST['credits'];
    //         $department_id = $_POST['department_id'];

    //         $subjects = $this->subjectModel->addMonHoc($name, $credits, $department_id);
    //         if ($subjects) {
    //             $this->getAllMonHoc();
    //         }
    //     }
    // }
    public function addNew()
    {
        if (!isset($_POST['btn_add'])) {
            return;
        }

        // ==============================
        // 1️⃣ LẤY & LỌC DỮ LIỆU
        // ==============================
        $name = trim($_POST['name'] ?? '');
        // $subject_code = trim($_POST['subject_code'] ?? '');
        $credits = (int) ($_POST['credits'] ?? 0);
        $department_id = (int) ($_POST['department_id'] ?? 0);
        $subject_type = $_POST['subject_type'] ?? '';


        $components = $_POST['components'] ?? [];

        $error = '';
        $subjectNormal = false;
        $subjectProject = false;

        // ==============================
        // 2️⃣ VALIDATE CƠ BẢN
        // ==============================

        if ($name === '' && $error === '') {
            $error = "Tên môn không được để trống";
        }

        // if ($subject_code === '' && $error === '') {
        //     $error = "Mã môn không được để trống";
        // }

        if ($credits <= 0 && $error === '') {
            $error = "Số tín chỉ phải lớn hơn 0";
        }

        if ($department_id <= 0 && $error === '') {
            $error = "Vui lòng chọn khoa";
        }

        if (!in_array($subject_type, ['NORMAL', 'PROJECT']) && $error === '') {
            $error = "Loại môn không hợp lệ";
        }

        if ($subject_type === 'NORMAL')
            $subjectNormal = true;
        if ($subject_type === 'PROJECT')
            $subjectProject = true;
        // ==============================
        // 3️⃣ CHECK TRÙNG MÃ MÔN
        // ==============================

        // if ($this->subjectModel->isSubjectCodeExists($subject_code) && $error === '') {
        //     $error = "Mã môn đã tồn tại";
        // }

        // ==============================
        // 4️⃣ VALIDATE CẤU TRÚC ĐIỂM
        // ==============================

        if (empty($components) && $error === '') {
            $error = "Phải có ít nhất 1 thành phần điểm";
        }

        if (!empty($components) && $error === '') {

            $totalWeight = 0;
            $hasTX = false;
            $hasDK = false;
            $hasCK = false;
            $isProject = false;

            foreach ($components as $c) {

                $type = $c['type'] ?? '';
                $weight = (int) ($c['weight'] ?? 0);
                $nameComponent = trim($c['name'] ?? '');

                if ($nameComponent === '' && $error === '') {
                    $error = "Tên thành phần điểm không được để trống";
                }

                if (!in_array($type, ['TX', 'DK', 'CK', 'PROJECT']) && $error === '') {
                    $error = "Loại điểm không hợp lệ";
                }

                if (($weight <= 0 || $weight > 100) && $error === '') {
                    $error = "Trọng số phải từ 1 đến 100";
                }

                if ($type === 'TX') {
                    $hasTX = true;
                }

                if ($type === 'DK') {
                    $hasDK = true;
                }

                if ($type === 'CK') {
                    $hasCK = true;
                }

                if ($type === 'PROJECT') {
                    $isProject = true;
                }

                $totalWeight += $weight;
            }

            if ($subjectNormal && (!$hasTX || !$hasDK) && $error === '') {
                $error = "Môn thường phải có ít nhất 1 điểm thường xuyên và định kì";
            }

            if ($totalWeight !== 100 && $error === '') {
                $error = "Tổng trọng số phải bằng 100%";
            }

            if ($subjectNormal && !$isProject && !$hasCK && $error === '') {
                $error = "Phải có ít nhất 1 điểm CK";
            }

            if ($subjectProject && count($components) > 1 && $error === '') {
                $error = "Môn đồ án chỉ được có 1 thành phần PROJECT";
            }

            if ($subjectProject && !$isProject && $error === '') {
                $error = "Môn đồ án phải có thành phần đồ án";
            }
        }

        // ==============================
        // 5️⃣ NẾU CÓ LỖI
        // ==============================

        if ($error !== '') {
            // var_dump($_POST);
            // die();
            $_SESSION['error'] = $error;
            $_SESSION['old'] = $_POST;
            error_log(
                date('Y-m-d H:i:s') . " | " . $error . PHP_EOL,
                3,
                __DIR__ . "/../logs/error.log"
            );
            header("Location: index.php?controller=subject&action=addMonHoc");
            exit;
        }

        // var_dump($subjectProject);
        // var_dump($subjectNormal);
        // var_dump($isProject);
        // var_dump($hasCK);
        // var_dump(count($components));
        // die();

        // ==============================
        // 6️⃣ TRANSACTION INSERT
        // ==============================
        $this->connect->begin_transaction();

        try {

            $subject_id = $this->subjectModel->addMonHoc(
                $name,
                // $subject_code,
                $credits,
                $department_id,
                $subject_type
            );

            if (!$subject_id) {
                throw new Exception("Không thể thêm môn học");
            }

            // 🔥 Thêm từng component
            foreach ($components as $component) {

                $nameComponent = trim($component['name'] ?? '');

                if ($nameComponent === '') {
                    throw new Exception("Tên thành phần điểm không được để trống");
                }

                $type = $component['type'] ?? '';
                $weight = (int) ($component['weight'] ?? 0);

                $result = $this->subjectScoreComponentsModel
                    ->add($subject_id, $nameComponent, $type, $weight);

                if (!$result) {
                    throw new Exception("Không thể thêm cấu trúc điểm");
                }
            }

            $this->connect->commit();

            $_SESSION['success'] = "Thêm môn học thành công";
            header("Location: index.php?controller=subject&action=getAllMonHoc");
            exit;

        } catch (Exception $e) {

            $this->connect->rollback();

            error_log(
                date('Y-m-d H:i:s') . " | " . $e->getMessage() . PHP_EOL,
                3,
                __DIR__ . "/../logs/error.log"
            );

            $_SESSION['error'] = "Hệ thống đang gặp sự cố";
            $_SESSION['old'] = $_POST;
            header("Location: index.php?controller=subject&action=addMonHoc");
            exit;
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
            $subject_type= $_POST['subject_type'];
            if ($this->subjectModel->checkMonHoc($id, $name)) {
                $errorMaSv = "Khoa đã tồn tại";
            }
            if (empty($errorMaSv)) {
                $this->subjectModel->editMonHoc($id, $name,$subject_code, $credits, $department_id,$subject_type);
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

    public function editNew()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php");
            exit;
        }

        $errors = "";

        // ================= POST =================
        if (isset($_POST['btn_edit'])) {

            $id = $_POST['id'];
            $name = trim($_POST['name']);
            $subject_code = trim($_POST['subject_code']);
            $credits = trim($_POST['credits']);
            $department_id = $_POST['department_id'];
            $subject_type = $_POST['subject_type'];
            $components = $_POST['components'] ?? [];
            $subjectNormal = ($subject_type === 'NORMAL');
            $subjectProject = ($subject_type === 'PROJECT');
            $errors = "";
            $totalWeight = 0;
            $hasTX = false;
            $hasDK = false;
            $hasCK = false;
            $isProject = false;

            // ================= VALIDATE SUBJECT =================

            if (empty($name) && $errors === "") {
                $errors = "Tên môn học không được để trống";
            }

            if (empty($subject_code) && $errors === "") {
                $errors = "Mã môn học không được để trống";
            }

            if (($credits === '' || !is_numeric($credits) || $credits <= 0) && $errors === "") {
                $errors = "Số tín chỉ phải lớn hơn 0";
            }

            if (empty($department_id) && $errors === "") {
                $errors = "Vui lòng chọn khoa";
            }

            // ================= VALIDATE COMPONENT =================

            if (empty($components) && $errors === "") {
                $errors = "Phải có ít nhất 1 thành phần điểm";
            }


            if ($errors === '') {

                foreach ($components as $c) {

                    $type = $c['type'] ?? '';
                    $weight = (int) ($c['weight'] ?? 0);
                    $nameComponent = trim($c['name'] ?? '');

                    if ($nameComponent === '' && $errors === '') {
                        $errors = "Tên thành phần điểm không được để trống";
                    }

                    if (!in_array($type, ['TX', 'DK', 'CK', 'PROJECT']) && $errors === '') {
                        $errors = "Loại điểm không hợp lệ";
                    }

                    if (($weight <= 0 || $weight > 100) && $errors === '') {
                        $errors = "Trọng số phải từ 1 đến 100";
                    }

                    if ($type === 'TX') {
                        $hasTX = true;
                    }

                    if ($type === 'DK') {
                        $hasDK = true;
                    }

                    if ($type === 'CK') {
                        $hasCK = true;
                    }

                    if ($type === 'PROJECT') {
                        $isProject = true;
                    }

                    $totalWeight += $weight;
                }
                if ($subjectNormal && (!$hasTX || !$hasDK) && $errors === '') {
                    $errors = "Môn thường phải có ít nhất 1 điểm thường xuyên và định kì";
                }

                if ($totalWeight !== 100 && $errors === '') {
                    $errors = "Tổng trọng số phải bằng 100%";
                }

                if ($subjectNormal && !$isProject && !$hasCK && $errors === '') {
                    $errors = "Phải có ít nhất 1 điểm CK";
                }

                if ($subjectProject && count($components) > 1 && $errors === '') {
                    $errors = "Môn đồ án chỉ được có 1 thành phần PROJECT";
                }

                if ($subjectProject && !$isProject && $errors === '') {
                    $errors = "Môn đồ án phải có thành phần đồ án";
                }
            }

            if ($totalWeight != 100 && $errors === "") {
                $errors = "Tổng trọng số phải bằng 100";
            }

            // ================= Nếu có lỗi =================
            if ($errors !== "") {

                $subject = [
                    'id' => $id,
                    'name' => $name,
                    'subject_code' => $subject_code,
                    'credits' => $credits,
                    'subject_type' => $subject_type,
                    'department_id' => $department_id
                ];
                $department = $this->departmentModel->getAll();
                $components = $this->subjectScoreComponentsModel->getBySubject($id);
                $_SESSION['error'] = $errors;
                include "./../views/admin/subject/edit.php";
                return;
            }

            // ================= UPDATE SUBJECT =================
            $this->subjectModel->editMonHoc(
                $id,
                $name,
                $subject_code,
                $credits,
                $department_id,
                $subject_type
            );

            // ================= UPDATE COMPONENT =================
            $this->subjectScoreComponentsModel->deleteBySubjectId($id);

            foreach ($components as $comp) {
                $this->subjectScoreComponentsModel->add(
                    $id,
                    $comp['name'],
                    $comp['weight'],
                    $comp['type']
                );
            }

            $_SESSION['success'] = "Cập nhật môn học thành công!";
            $this->getAllMonHoc();
            exit;
        }

        include "./../views/admin/subject/edit.php";
    }
    public function deleteMonHoc()
    {
        $id = $_GET['id'];
        $this->subjectModel->deleteMonHoc($id);
        $this->getAllMonHoc();
    }
}
