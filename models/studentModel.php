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
        $sql = "SELECT
    sp.avatar,
    sp.full_name,
    s.id,
    s.student_code,
    sp.education_type,
    sp.status,
    sp.date_of_birth,
    c.class_name,
    sp.email,
    sp.phone,
    sp.identity_number,
    sp.address
    FROM student s
    JOIN student_profiles sp ON sp.student_id = s.id
    LEFT JOIN classes c ON c.id = s.class_id
    WHERE s.id = '$id';
";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    // lấy toàn bộ thông tin của sinh viên
    public function getAll()
    {
        $sql = "SELECT
    sp.avatar,
    sp.full_name,
    s.id,
    s.student_code,
    sp.education_type,
    sp.status,
    sp.date_of_birth,
    c.class_name,
    sp.email,
    sp.phone,
    sp.identity_number,
    sp.address
    FROM student s
    JOIN student_profiles sp ON sp.student_id = s.id
    LEFT JOIN classes c ON c.id = s.class_id;
    ";
        return $this->__query($sql);
    }
    public function getAllds()
    {
        $sql = "SELECT
    sp.avatar,
    sp.full_name,
    s.id,
    s.student_code,
    sp.education_type,
    sp.status,
    sp.date_of_birth,
    c.class_name,
    sp.email,
    sp.phone,
    sp.identity_number,
    sp.address
    FROM student s
    JOIN student_profiles sp ON sp.student_id = s.id
    LEFT JOIN classes c ON c.id = s.class_id;
    ";
        $query = $this->__query($sql);
        $students = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $students[] = $row;
        }
        return $students;
    }
    public function getAllProfile($id)
    {
        $sql = "SELECT *
FROM student s
JOIN student_profiles sp
    ON s.id = sp.student_id
WHERE s.id = $id;";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function KtMa($id, $student_code)
    {
        $sql = "Select *from student where student_code='$student_code'AND id != $id
        LIMIT 1";
        $query = $this->__query($sql);
        if (mysqli_num_rows($query) > 0) {
            return true;
        }
    }

    public function KtEmail($email, $id)
    {
        $sql = "Select *from student where email='$email'AND id != $id
        LIMIT 1";
        $query = $this->__query($sql);
        if (mysqli_num_rows($query) > 0) {
            return true;
        }
    }
    public function updateSinhVien($id, $full_name, $student_code, $email, $class_id)
    {
        $sql = "UPDATE student SET full_name='$full_name',student_code='$student_code', email='$email',class_id=$class_id WHERE id='$id'";
        $query = $this->__query($sql);
    }

    // thêm mới sinh viên 
    public function addSinhVien($full_name, $student_code, $email, $class_id, $username, $password)
    {
        mysqli_begin_transaction($this->connect);

        // 1. Insert student
        $sqlStudent = "
        INSERT INTO student(full_name, student_code, email, class_id)
        VALUES (
            '$full_name',
            '$student_code',
            '$email',
            '$class_id'
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


    // xóa sinh viên 
    public function deleteSprofiles($id){
        $sql = "delete from student_profiles where student_id= $id";
        return $this->__query($sql);
    }
    public function deleteStudent($id)
    {
        $sql = "delete from student where id= $id";
        return $this->__query($sql);
    }
    public function __query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }
}
