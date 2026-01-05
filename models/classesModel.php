<?php
require_once "./../config/database.php";
class classesModel extends database
{

    private $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
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

    public function getAllSinhVienCuaLop($id){
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
