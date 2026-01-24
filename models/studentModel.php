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
    s.id,
    s.student_code,
    s.created_at,
    s.class_id,
    s.department_id,

    sp.full_name,
    sp.gender,
    sp.date_of_birth,
    sp.email,
    sp.phone,
    sp.identity_number,
    sp.address,
    sp.avatar,
    sp.education_type,
    sp.status,

    c.class_name,
    d.name AS department_name

FROM student s
JOIN student_profiles sp 
    ON sp.student_id = s.id

LEFT JOIN classes c 
    ON c.id = s.class_id

LEFT JOIN department d 
    ON d.id = s.department_id

WHERE s.id = '$id';

";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    // lấy toàn bộ thông tin của sinh viên
    public function getAll()
    {
        $sql = "SELECT
    s.id,
    s.student_code,
    s.created_at,
    s.class_id,
    s.department_id,

    sp.full_name,
    sp.gender,
    sp.date_of_birth,
    sp.email,
    sp.phone,
    sp.identity_number,
    sp.address,
    sp.avatar,
    sp.education_type,
    sp.status,

    c.class_name,
    d.name AS department_name

    FROM student s
    JOIN student_profiles sp 
    ON sp.student_id = s.id

    LEFT JOIN classes c 
    ON c.id = s.class_id

    LEFT JOIN department d 
    ON d.id = s.department_id";

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
    sp.gender,
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
        $sql = "Select *from student_profiles where email='$email'AND id != $id
        LIMIT 1";
        $query = $this->__query($sql);
        if (mysqli_num_rows($query) > 0) {
            return true;
        }
    }
    public function isStudentCodeExists($student_code, $id)
    {
        $student_code = trim($student_code);
        $id = trim($id);

        $sql = "SELECT id FROM student
            WHERE student_code = '$student_code'
            AND id != '$id'";
        $query = $this->__query($sql);

        return mysqli_num_rows($query) > 0;
    }
    public function updateStudent($id, $student_code, $department_id, $class_id)
    {
        if ($this->isStudentCodeExists($student_code, $id)) {
            return "duplicate_code";
        }
        $sql = "UPDATE student SET student_code='$student_code',class_id='$class_id',department_id='$department_id' WHERE id='$id'";
        return $this->__query($sql);
    }
    public function updateStudent_profiles($id, $gender, $full_name, $email, $phone, $date_of_birth, $address, $education_type, $status, $identity_number, $avatar)
    {
        $sql = "UPDATE student_profiles SET gender='$gender',full_name='$full_name',email='$email',phone='$phone',date_of_birth='$date_of_birth' ,address='$address',identity_number='$identity_number' ,avatar='$avatar',education_type='$education_type',status = '$status' WHERE student_id='$id'";
        return $this->__query($sql);
    }

    // thêm mới sinh viên 
    public function addSinhVien($student_code, $class_id, $gender, $education_type, $status, $department_id, $full_name, $email, $phone, $date_of_birth, $address, $identity_number, $avatar, $username, $password)
    {
        mysqli_begin_transaction($this->connect); //bắt đầu nhưng CHƯA được ghi hẳn vào CSDL

        // 1. Insert student
        $sqlStudent = "
        INSERT INTO student(student_code, class_id,department_id,created_at)
        VALUES (
            '$student_code',
            '$class_id',
            '$department_id',
            NOW()
        )
    ";
        if ($this->__query($sqlStudent) === false) {
            mysqli_rollback($this->connect);
            return false;
        }
        // echo $sqlStudent;
        // die;

        // 2. Lấy ID sinh viên vừa insert
        $studentId = mysqli_insert_id($this->connect);

        $sqlProfile = "
        INSERT INTO student_profiles
                (student_id, full_name,gender, email, phone, date_of_birth, address, identity_number, avatar,education_type,status)
                VALUES (
                    '$studentId',
                    '$full_name',
                    '$gender',
                    '$email',
                    '$phone',
                    '$date_of_birth',
                    '$address',
                    '$identity_number',
                    '$avatar',
                    '$education_type',
                    '$status'
                )
            ";

        // echo $sqlProfile;
        // die;

        if ($this->__query($sqlProfile) === false) {
            mysqli_rollback($this->connect);
            return false;
        }

        // 3. Insert users
        // $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $sqlUser = "
        INSERT INTO users(username, password, role, ref_id)
        VALUES (
            '$username',
            '$password',
            'student',
            '$studentId'
        )
    ";

        // echo $sqlUser;
        // die;
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
    public function deleteSprofiles($id)
    {
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
