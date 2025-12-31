<?php
    require_once "./../config/database.php";
class userModel extends database
{

    private $connect;

    public function __construct()
    {
        $this->connect= $this->connect();
    }

    // lấy user theo username
    public function getByUsername($name){
        $sql = "SELECT * FROM users WHERE username='$name'";
        return $this->__query($sql);
    }
    public function getAll(){
        $sql = " select * from users";
        return $this->__query($sql);
    }
    
    public function __query($sql){
        return mysqli_query($this->connect,$sql);
    }
}