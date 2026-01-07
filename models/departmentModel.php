<?php
require_once "./../config/database.php";
class departmentModel extends database
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
    k.id,
    k.name AS faculty_name,
    t.name AS parent_name,
    k.type,
    COUNT(l.id) AS staff_count,
    k.created_at,
    k.updated_at
FROM department k
LEFT JOIN department t 
    ON k.parent_id = t.id
LEFT JOIN lecturer l 
    ON l.department_id = k.id
GROUP BY 
    k.id,
    k.name,
    t.name,
    k.type,
    k.created_at,
    k.updated_at;

    ";

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
