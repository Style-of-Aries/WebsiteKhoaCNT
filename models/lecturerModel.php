<?php
    require_once "./../config/database.php";
class lecturerModel extends database
{

    private $connect;

    public function __construct()
    {
        $this->connect= $this->connect();
    }

    // lấy thông tin user theo id
    public function getById($id){
        $sql = "SELECT * FROM lecturer WHERE id='$id'";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    // lấy toàn bộ thông tin của giảng viên
     public function getAll(){
        $sql = "SELECT * FROM lecturer";
        return $this->__query($sql);
    }
    
    public function __query($sql){
        return mysqli_query($this->connect,$sql);
    }
}