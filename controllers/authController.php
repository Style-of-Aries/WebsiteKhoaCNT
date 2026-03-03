<?php
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";
require_once "./../models/trainningOfficeModel.php";

class authController
{
    private $connect;
    private $userModel;
    private $studentModel;
    private $lecturerModel;
    private $trainningOfficeModel;

    public function __construct($connect)
    {
        $this->connect = $connect;
        // session_start();
        $this->studentModel = new studentModel($connect);
        $this->userModel = new userModel($connect);
        $this->lecturerModel = new lecturerModel($connect);
    }

    public function login() //trang đăng nhập
    {
        $errorLogin = "";
        $oldUsername = "";
        include_once "./../views/auth/login.php";
        // include_once "./../views/auth/loginNew.php";
    }
    // function xử lý chức năng đăng nhập
    public function auth_login()
    {
        $errorLogin = "";
        $oldUsername = "";

        if (isset($_POST['btn_login'])) {

            $name = trim($_POST['username']);
            $password = trim($_POST['password']);
            $oldUsername = $name;

            $result = $this->userModel->getByUsername($name);
            $user = mysqli_fetch_assoc($result);

            // ❗ 1. Kiểm tra user tồn tại trước
            if (!$user) {
                $errorLogin = "Tài khoản không tồn tại";
                include_once "./../views/auth/login.php";
                return;
            }

            // ❗ 2. Kiểm tra mật khẩu
            if (trim($user['password']) !== $password) {
                $errorLogin = "Sai mật khẩu";
                include_once "./../views/auth/login.php";
                return;
            }

            // ❗ 3. Lấy profile sau khi chắc chắn user tồn tại
            $profile = $this->userModel->getUserProfile(
                $user['role'],
                $user['ref_id']
            );

            $_SESSION['user'] = [
                'id' => $user['id'],
                'role' => $user['role'],
                'ref_id' => $user['ref_id'],
                'name' => $user['username'],
                'full_name' => $profile['full_name'] ?? 'Unknown',
                'gender' => $profile['gender'] ?? 'Nam'
            ];

            if ($user['role'] == 'student') {
                header('Location: index.php?controller=student&action=profile');
            } else {
                header('Location: index.php?controller=admin&action=index');
            }

            exit();
        }
    }


    //Xử lí chức năng đăng ký
    // public function register()
    // {
    //     $vlName = $vlEmail = $vlPass = $vlCfPass = $vlSdt = "";
    //     $error = $errorPass = $errorName = $errorEmail = $errorCfPass = $errorsdt = "";
    //     require_once "./../views/auth/register.php";
    // }
    // public function auth_register()
    // {
    //     // Giá trị giữ lại nếu có lỗi
    //     $vlName = $vlEmail = $vlPass = $vlCfPass = $vlSdt = "";
    //     // Biến lỗi cho từng trường
    //     $errorName = $errorEmail = $errorPass = $errorCfPass = $errorsdt = "";
    //     $role = 2;

    //     if (isset($_POST['btn_register'])) {
    //         $userNameRegister = $_POST['username'];
    //         $emailRegister = $_POST['email'];
    //         $passRegister = $_POST['password'];
    //         $confirm_password = $_POST['confirm_password'];


    //         // Validate từng trường
    //         if (empty($userNameRegister)) {
    //             $errorName = "Vui lòng không để trống";
    //         } elseif ($this->authModel->authUserName($userNameRegister)) {
    //             $errorName = "Tài khoản đã tồn tại";
    //         } else {
    //             $vlName = $userNameRegister;
    //         }

    //         if (empty($emailRegister)) {
    //             $errorEmail = "Vui lòng không để trống";
    //         } elseif ($this->authModel->authEmail($emailRegister)) {
    //             $errorEmail = "Email đã tồn tại";
    //         } else {
    //             $vlEmail = $emailRegister;
    //         }

    //         if (empty($passRegister)) {
    //             $errorPass = "Vui lòng không để trống";
    //         } else {
    //             $vlPass = $passRegister;
    //         }

    //         if ($confirm_password !== $passRegister) {
    //             $errorCfPass = "Mật khẩu không chính xác";
    //         } else {
    //             $vlCfPass = $confirm_password;
    //         }



    //         // Nếu không có lỗi thì đăng ký và chuyển trang
    //         if (
    //             empty($errorName) && empty($errorEmail) && empty($errorPass)
    //             && empty($errorCfPass)
    //         ) {
    //             $this->authModel->authUsers($userNameRegister, $emailRegister, $passRegister, $role);


    //             $this->login();
    //             exit;
    //         }
    //     }


    //     include_once "./../views/auth/register.php";
    // }
    // //Xử lý chức năng đăng nhập
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit();
    }
}
