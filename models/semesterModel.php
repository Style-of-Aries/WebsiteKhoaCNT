<?php
require_once "./../config/database.php";
class semesterModel extends database
{

    private $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
    }
    public function getAll()
    {
        $sql = "
           SELECT * FROM semesters;
        ";

        return $this->__query($sql);
    }
    public function getActiveSemester()
    {
        $sql = "SELECT * FROM semesters WHERE is_active = 1 LIMIT 1";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function layHocKyDangHoatDong()
{
    $sql = "SELECT * FROM semesters WHERE is_active = 1 LIMIT 1";
    return mysqli_fetch_assoc($this->__query($sql));
}


    public function addMonHoc($name, $subject_code, $credits, $department_id)
    {

        $sql = "
            INSERT INTO subjects (subject_code, name, credits, department_id)
            VALUES ('$subject_code', '$name', '$credits','$department_id' )
        ";
        return $this->__query($sql);
    }
    public function editMonHoc($id, $name, $subject_code, $credits, $department_id)
    {

        $sql = "
            UPDATE subjects
        SET 
            name = '$name',
            subject_code = '$subject_code',
            credits = '$credits',
            department_id = '$department_id'
        WHERE id = '$id'
        ";
        return $this->__query($sql);
    }
    public function checkMonHoc($name, $id)
    {

        $sql = "Select *from subjects where name = '$name'AND id != '$id'
        LIMIT 1";
        $query = $this->__query($sql);
        if (mysqli_num_rows($query) > 0) {
            return true;
        }
    }

    public function getParents()
    {
        $sql = "SELECT id, name FROM department";
        return $this->__query($sql);
    }
    public function deleteMonHoc($id)
    {
        $sql = "delete from subjects where id= '$id'";
        return $this->__query($sql);
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM subjects WHERE id='$id'";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    public function __query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }
}
