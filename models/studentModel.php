<?php
require_once "./../config/database.php";
class studentModel extends database
{

    private $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
    }

    // lấy thông tin user theo id
    public function getById($id)
    {
        $sql = "SELECT * FROM student WHERE id='$id'";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    // lấy toàn bộ thông tin của sinh viên
    public function getAll()
    {
        $sql = "SELECT * FROM student";
        return $this->__query($sql);
    }

    // thêm mới sinh viên 
    public function addSinhVien($full_name, $student_code, $email, $username, $password)
    {
        mysqli_begin_transaction($this->connect);

        // 1. Insert student
        $sqlStudent = "
        INSERT INTO student(full_name, student_code, email, class_id)
        VALUES (
            '$full_name',
            '$student_code',
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
            'student',
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


    public function __query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }
}
