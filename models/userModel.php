<?php
require_once "./../config/database.php";
class userModel extends database
{

    private $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
    }

    // lấy user theo username
    public function getByUsername($name)
    {
        $sql = "SELECT * FROM users WHERE username='$name'";
        return $this->__query($sql);
    }
    public function getAll()
    {
        $sql = " select * from users";
        return $this->__query($sql);
    }

    // kiểm tra email 
    public function checkEmail($email)
    {

        $sql = "
        SELECT email FROM student WHERE email = '$email'
        UNION
        SELECT email FROM lecturer WHERE email = '$email'";
        $query = $this->__query($sql);
        if (mysqli_num_rows($query) > 0) {
            return true; // email đã tồn tại
        }
        return false;
    }
    public function __query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }
}
