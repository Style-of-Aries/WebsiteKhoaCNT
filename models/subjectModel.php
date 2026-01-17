<?php
require_once "./../config/database.php";
class subjectModel extends database
{

    private $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
    }
    public function getAll()
    {
    $sql = "SELECT s.*, d.name AS department_name
                FROM subjects s
                LEFT JOIN department d ON s.department_id = d.id";
        return $this->__query($sql);
    }
    public function getAllGiangVienCuaKhoa($id)
    {
        $sql = "SELECT 
    s.id,
    s.full_name,
    s.lecturer_code,
    s.email,
    c.name
    FROM lecturer s
    LEFT JOIN department c ON s.department_id = c.id
    WHERE s.department_id = $id
    ";
        return $this->__query($sql);
    }

    public function addKhoa($name, $type, $parent_id){

        $sql = "
            INSERT INTO department (name, type, parent_id, created_at)
            VALUES ('$name', '$type', $parent_id, NOW())
        ";

        return $this->__query($sql);

    }
    public function editKhoa($id,$name, $type, $parent_id){

        $sql = "
            UPDATE department
        SET 
            name = '$name',
            type = '$type',
            parent_id = $parent_id,
            updated_at = NOW()
        WHERE id = '$id'
        ";

        return $this->__query($sql);

    }
    public function checkKhoa($name,$id)
    {

        $sql = "Select *from department where name = '$name'AND id != '$id'
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
    public function deleteKhoa($id){
        $sql= "delete from department where id= '$id'";
        return $this->__query($sql);
    }
     public function getById($id)
    {
        $sql = "SELECT * FROM department WHERE id='$id'";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    public function __query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }
}
