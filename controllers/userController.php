<?php
require_once '../models/userModel.php';
require_once '../models/adminModel.php';
class userController
{
    private $userModel;
    private $adminModel;
    private $connect;
    public function __construct($connect)
    {
        $this->connect = $connect;
        $this->userModel = new UserModel($connect);
        $this->adminModel = new adminModel($connect);
    }
    public function getAllUser()
    {

        $users = $this->userModel->getAll();
        require_once './../views/admin/users/list.php';
        // require_once './../views/user/profile.php';
    }
    public function generateCode($role)
    {
        // 1. Xác định tiền tố theo role
        if ($role == 'student') {
            $prefix = 'SV';
        } elseif ($role == 'lecturer') {
            $prefix = 'GV';
        } elseif ($role == 'training_office') {
            $prefix = 'PDT';
        } elseif ($role == 'academic_affairs') {
            $prefix = 'HV';
        } elseif ($role == 'exam_office') {
            $prefix = 'KT';
        } elseif ($role == 'student_affairs') {
            $prefix = 'CTSV';
        } else {
            return false;
        }

        // 2. Lấy mã lớn nhất hiện tại của role đó
        $sql = "SELECT username 
            FROM users 
            WHERE role = '$role'
            ORDER BY id DESC 
            LIMIT 1";

        $result = mysqli_query($this->connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Lấy số phía sau tiền tố
            $number = intval(substr($row['username'], strlen($prefix)));
            $number++;
        } else {
            $number = 1;
        }

        // 3. Ghép lại mã mới
        $newCode = $prefix . str_pad($number, 5, "0", STR_PAD_LEFT);

        return $newCode;
    }
    public function add(){
        if($_POST['btn_add']){
            $role = $_POST['role'];
            $full_name = $_POST['full_name'] ?? null;
            $email = $_POST['email'] ?? null;
        }
    
        $code = $this->generateCode($role);
        $user= $this->userModel->addUser($role,$full_name,$email,$code);
        if($user){
            $this->getAllUser();
            exit();
        }
    }
}
