<?php
    require_once "./../config/database.php";
class authModel extends database
{

    private $connect;

    public function __construct()
    {
        $this->connect= $this->connect();
    }

    //start register
    //Kiểm tra xem email có tồn tại không c
    public function authEmail($emailRegister){
        $sql="Select *from users where email='$emailRegister'";
        $query=$this->__query($sql);
        if(mysqli_num_rows($query)>0){
            return true;
        }
    }
    public function authUserName($userNameRegister){
        $sql="Select *from users where username='$userNameRegister'";
        $query=$this->__query($sql);
        if(mysqli_num_rows($query)>0){
            return true;
        }
    }
    // Thêm tài khoản vào bảng users
    public function authUsers($userNameRegister,$emailRegister,$passRegister,$role){
        $sql="INSERT INTO users(username,email,password,role_id) VALUES ('$userNameRegister','$emailRegister','$passRegister',$role)";
        $query=$this->__query($sql);
    }
    //end register


    //start login

    // public function authUsersLogin($emailLogin,$passLogin){
    public function authUsersLogin($name,$passLogin){
        $sql="SELECT *FROM users where username='$name' or email='$name'";
        $query=$this->__query($sql);
        if($row=mysqli_fetch_assoc($query)){
            if($passLogin == $row['password']){
                return $row;
            }
        }
        return false;
    }
    //end login
    
    public function __query($sql){
        return mysqli_query($this->connect,$sql);
    }
}