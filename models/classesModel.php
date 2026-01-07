<?php
require_once "./../config/database.php";
class classesModel extends database
{

    private $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
    }


    public function deleteLh($id){
        $sql= "delete from classes where id= '$id'";
        return $this->__query($sql);
    }
    public function checkMaLop($class_code,$id)
    {

        $sql = "Select *from classes where class_code = '$class_code'AND id != '$id'
        LIMIT 1";
        $query = $this->__query($sql);
        if (mysqli_num_rows($query) > 0) {
            return true;
        }
    }
    public function addLopHoc($class_name, $class_code, $department_id, $lecturer_id)
    {
        $sql = "INSERT INTO `classes` (`class_name`, `class_code`, `department_id`, `lecturer_id`) VALUES ('$class_name', '$class_code', '$department_id', '$lecturer_id')";
        return $this->__query($sql);
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM classes WHERE id='$id'";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    public function editLopHoc($id, $class_name, $class_code, $department_id, $lecturer_id)
    {
        $sql = "UPDATE classes SET class_name='$class_name',class_code='$class_code', department_id='$department_id',lecturer_id='$lecturer_id' WHERE id='$id'";
        $query = $this->__query($sql);
    }

    public function getAll()
    {
        $sql = "
    SELECT 
    c.id,
    c.class_name,
    c.class_code,
    d.name AS department_name,
    l.full_name AS lecturer_name
    FROM classes c
    LEFT JOIN department d ON c.department_id = d.id
    LEFT JOIN lecturer l ON c.lecturer_id = l.id
";
        return $this->__query($sql);
    }

    public function getAllSinhVienCuaLop($id)
    {
        $sql = "
        SELECT 
            s.id,
            s.full_name,
            s.student_code,
            s.email,
            c.class_name
        FROM student s
        LEFT JOIN classes c ON s.class_id = c.id
        WHERE s.class_id = $id
    ";
        return $this->__query($sql);
    }
    public function __query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }
}
