<?php
require_once "./../config/database.php";
class subjectModel
{

    protected $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    protected function __query($sql)
    {
        return mysqli_query($this->connect, $sql);
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

    public function addMonHoc($name, $credits, $department_id)
{
    $subject_code = $this->generateSubjectCode($name);

    $sql = "
        INSERT INTO subjects (subject_code, name, credits, department_id)
        VALUES ('$subject_code', '$name', '$credits', '$department_id)
    ";

    $this->__query($sql);
    return mysqli_insert_id($this->connect);
}
    public function getInitials($name)
{
    // Chuẩn hóa khoảng trắng
    $name = trim($name);
    $name = preg_replace('/\s+/', ' ', $name);

    // Tách từng từ
    $words = explode(' ', $name);

    $initials = '';

    foreach ($words as $word) {
        $initials .= strtoupper(mb_substr($word, 0, 1, 'UTF-8'));
    }

    return $initials;
}
    public function generateSubjectCode($name)
{
    $prefix = $this->getInitials($name);

    $sql = "SELECT subject_code 
            FROM subjects 
            WHERE subject_code LIKE '$prefix%' 
            ORDER BY id DESC 
            LIMIT 1";

    $result = $this->__query($sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $number = intval(substr($row['subject_code'], strlen($prefix)));
        $number++;
    } else {
        $number = 1;
    }

    return $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
}
    public function editMonHoc($id, $name, $subject_code, $credits, $department_id, $subject_type)
    {

        $sql = "
            UPDATE subjects
        SET 
            name = '$name',
            subject_code = '$subject_code',
            credits = '$credits',
            department_id = '$department_id',
            subject_type = '$subject_type'
        WHERE id = '$id'
        ";
        return $this->__query($sql);

    }

    public function isSubjectCodeExists($subject_code)
    {
        $subject_code = trim($subject_code);

        if ($subject_code === '') {
            return false;
        }

        $sql = "
        SELECT id 
        FROM subjects 
        WHERE subject_code = '$subject_code'
        LIMIT 1
    ";

        $result = $this->__query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return true;
        }

        return false;
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
}
