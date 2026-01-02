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
    // end 


    // thêm mới sinh viên 
    public function addGiangVien($full_name, $lecturer_code, $email, $username, $password)
    {
        mysqli_begin_transaction($this->connect);

        // 1. Insert student
        $sqlStudent = "
        INSERT INTO lecturer(full_name, lecturer_code, email, department_id)
        VALUES (
            '$full_name',
            '$lecturer_code',
            '$email',
            null
        )
    ";

        if ($this->__query($sqlStudent) === false) {
            mysqli_rollback($this->connect);
            return false;
        }

        // 2. Lấy ID sinh viên vừa insert
        $studentId = mysqli_insert_id($this->connect);

        // 3. Insert users
        // $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $sqlUser = "
        INSERT INTO users(username, password, role, ref_id)
        VALUES (
            '$username',
            '$password',
            'lecturer',
            $studentId
        )
    ";

        if ($this->__query($sqlUser) === false) {
            mysqli_rollback($this->connect);
            return false;
        }

        // 4. Commit
        mysqli_commit($this->connect);
        return true;
    }

    // kết thúc thêm sinh viên 
    

 
    // xóa giảng viên 
    public function deleteLecturer($ref_id){
        $sql="delete from lecturer where id= $ref_id";
        return $this->__query($sql);
    }
    public function __query($sql){
        return mysqli_query($this->connect,$sql);
    }
}