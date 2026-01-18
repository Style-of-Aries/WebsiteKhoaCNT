<?php
require_once "./../models/userModel.php";
require_once "./../models/studentModel.php";
require_once "./../models/lecturerModel.php";

class authController
{
    private $userModel;
    private $studentModel;
    private $lecturerModel;

    public function __construct()
    {
        // session_start();
        $this->studentModel = new studentModel();
        $this->userModel = new userModel();
        $this->lecturerModel = new lecturerModel();
    }
    
    public function login() //trang đăng nhập
    {
        $errorLogin = "";
        include_once "./../views/auth/login.php";
    }
    // function xử lý chức năng đăng nhập
    public function auth_login()
    {
        $errorLogin = "";
        if (isset($_POST['btn_login'])) {
            $name = $_POST['username'];
            $password = $_POST['password'];
            $user = $this->userModel->getByUsername($name);
            $user = mysqli_fetch_assoc($user);
            if ($user) {
                session_start();
                $_SESSION['user'] = [
                    'id'   => $user['id'],
                    'role' => $user['role']
                ];
                if ($user['role'] == 'student') {
                    $student = $this->studentModel->getById($user['ref_id']);
                    $_SESSION['profile'] = $student;
                    header('Location: index.php?controller=student&action=index');
                } elseif ($user['role'] == 'lecturer') {
                    $lecturer = $this->lecturerModel->getById($user['ref_id']);
                    $_SESSION['profile'] = $lecturer;
                    header('Location: index.php?controller=lecturer&action=index');
                } else {
                    header('Location: index.php?controller=admin&action=index');
                }
                exit();
            } else {
                $errorLogin = "Thông tin tài khoản mật khẩu không chính xác";
                include_once "./../views/auth/login.php";
            }
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
