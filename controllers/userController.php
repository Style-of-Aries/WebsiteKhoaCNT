<?php
require_once '../models/userModel.php';
require_once '../models/adminModel.php';
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
require_once "./../models/classesModel.php";
require_once "./../models/departmentModel.php";
class userController
{
    private $userModel;
    private $adminModel;
    private $connect;
    private $studentModel;
    private $lecturerModel;
    private $classesModel;
    private $departmentModel;
    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->userModel = new UserModel($connect);
        $this->adminModel = new adminModel($connect);
        $this->studentModel = new studentModel($connect);
        $this->lecturerModel = new lecturerModel($connect);
        $this->classesModel = new classesModel($connect);
        $this->departmentModel = new departmentModel($connect);
    }
    public function getAllUser()
    {

        $users = $this->userModel->getAll();
        require_once './../views/admin/users/list.php';
        // require_once './../views/user/profile.php';
    }
    public function generateCode($role)
    {
        // 1. Xác định tiền tố
        switch ($role) {
            case 'student':
                $prefix = 'SV';
                break;
            case 'lecturer':
                $prefix = 'GV';
                break;
            case 'training_office':
                $prefix = 'PDT';
                break;
            case 'academic_affairs':
                $prefix = 'HV';
                break;
            case 'exam_office':
                $prefix = 'KT';
                break;
            case 'student_affairs':
                $prefix = 'CTSV';
                break;
            default:
                return false;
        }

        // 2. Lấy mã lớn nhất theo prefix
        $sql = "SELECT MAX(username) as max_code 
            FROM users 
            WHERE role = '$role' 
            AND username LIKE '$prefix%'";

        $result = mysqli_query($this->connect, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row['max_code']) {
            // Lấy phần số phía sau prefix
            $number = (int) substr($row['max_code'], strlen($prefix));
            $number++;
        } else {
            $number = 1;
        }

        // 3. Tạo mã mới
        $newCode = $prefix . str_pad($number, 5, "0", STR_PAD_LEFT);

        return $newCode;
    }
   public function add()
{
    $errorEmail = null;
    $old = [];
    $department = $this->departmentModel->getAllFaculty(); // load khoa trước

    if (isset($_POST['btn_add'])) {

        $role = $_POST['role'] ?? null;
        $full_name = $_POST['full_name'] ?? null;
        $email = $_POST['email'] ?? null;
        $department_id = $_POST['department_id'] ?? null;

        // Lưu lại dữ liệu cũ
        $old = [
            'role' => $role,
            'full_name' => $full_name,
            'email' => $email,
            'department_id' => $department_id
        ];

        // 1Kiểm tra email trùng
        $checkEmail = $this->userModel->checkEmailByRole($role, $email);

        if ($checkEmail) {
            $errorEmail = "Email đã tồn tại!";
        } else {

            // 2 Tạo mã tự động
            $code = $this->generateCode($role);

            // 3 Thêm user
            $user = $this->userModel->addUser(
                $role,
                $full_name,
                $email,
                $code,
                $department_id
            );

            if ($user) {
                $this->getAllUser();
                exit();
            }
        }
    }

    include_once "./../views/admin/users/add.php";
}
    public function editUser()
    {
        $id_user = $_GET['id'];
        $user = $this->userModel->getByIdUser($id_user);
        $department = $this->departmentModel->getAllFaculty();

        if ($user) {

            $id = $user['ref_id'];
            $role = $user['role'];

            if ($role === 'lecturer') {
                $if_user = $this->lecturerModel->getById($id);
            }
        }
        require_once './../views/admin/users/edit.php';
    }
    public function edit()
    {
        $department = null;
        if (isset($_POST['btn_edit'])) {
            $role = $_POST['role'];
            $full_name = $_POST['full_name'] ?? null;
            $email = $_POST['email'] ?? null;
            // if ($role === 'lecturer') {
            // }
            $department = $_POST['department_id'] ?? null;


            $errorEmail = $this->userModel->checkEmailByRole($role,$email);
            $code = $this->generateCode($role);
            // if ($role === 'lecturer') {

            //     $user = $this->lecturerModel->addGiangVien($full_name, $code, $email, $department);
            // } else {
            if(!isset($errorEmail)){
                $user = $this->userModel->addUser($role, $full_name, $email, $code, $department);
                if ($user) {
                    $this->getAllUser();
                    exit();
                }
            }else{
                
            }

        }
    }
    public function deleteUsers(){
        $id = $_GET['id'];
        $ref_id = $_GET['ref_id'];
        $role= $_GET['role'];
        $deleteUser = $this->userModel->deleteUsers($id,$ref_id,$role);
        if($deleteUser){
            $this->getAllUser();
            exit();
        }
    }
}
