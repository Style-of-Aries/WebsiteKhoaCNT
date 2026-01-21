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

    // lấy thông tin user theo id 
    public function getById($id)
    {
        $sql = "SELECT * FROM users WHERE id='$id'";
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

    public function deleteUser($ref_id)
    {
        $sql = "delete from users where ref_id= '$ref_id'";
        return $this->__query($sql);
    }
    public function KtUserName($username, $id)
    {
        $sql = "
        SELECT id 
        FROM users 
        WHERE username = '$username'
        AND ref_id != $id
        LIMIT 1
    ";

        $query = $this->__query($sql);

        return mysqli_num_rows($query) > 0;
    }

    public function getByRef_id($id)
    {
        $sql = "select * from users where ref_id='$id'";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    public function updateUser($id, $username, $password)
    {
        $sql = "UPDATE users SET username='$username',password = '$password' WHERE ref_id='$id'";
        $query = $this->__query($sql);
    }
    public function __query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }
}
