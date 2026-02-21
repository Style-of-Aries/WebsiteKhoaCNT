<?php
require_once "./../config/database.php";
class studentModel
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
    public function getAllProfile($studentId)
    {

        //         $sql = "SELECT *
// FROM student s
// JOIN student_profiles sp
//     ON s.id = sp.student_id
// WHERE s.id = $id;";
//         $query = $this->__query($sql);
//         return mysqli_fetch_assoc($query);
        $sql = "
        SELECT 
    st.id AS student_id,
    st.student_code,

    -- Thông tin cá nhân
    sp.full_name,
    sp.gender,
    sp.date_of_birth,
    sp.email,
    sp.phone,
    sp.address,
    sp.identity_number,
    sp.avatar,
    sp.education_type,
    sp.status,

    -- Lớp hành chính
    c.class_name,
    c.class_code,

    -- Khoa / bộ môn
    d.name AS department_name,
    d.type AS department_type,

    -- GPA + tín chỉ + số môn
    stats.gpa,
    stats.total_credits,
    stats.total_courses,

    -- Thời gian tạo
    st.created_at

FROM student st

LEFT JOIN student_profiles sp 
    ON sp.student_id = st.id

LEFT JOIN classes c 
    ON st.class_id = c.id

LEFT JOIN department d 
    ON st.department_id = d.id

LEFT JOIN (
    SELECT 
        ar.student_id,
        ROUND(AVG(ar.final_grade), 2) AS gpa,
        SUM(sb.credits) AS total_credits,
        COUNT(ar.course_class_id) AS total_courses
    FROM academic_results ar
    JOIN course_classes cc 
        ON cc.id = ar.course_class_id
    JOIN subjects sb 
        ON sb.id = cc.subject_id
    GROUP BY ar.student_id
) stats 
    ON stats.student_id = st.id

WHERE st.id = $studentId;
";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function searchStudents($keyword)
    {
        $keyword = mysqli_real_escape_string($this->connect, $keyword);

        $sql = "
        SELECT 
            s.id,
            s.student_code,
            sp.full_name,
            sp.email,
            c.class_name,
            d.name AS department_name
        FROM student s
        JOIN student_profiles sp ON sp.student_id = s.id
        LEFT JOIN classes c ON c.id = s.class_id
        LEFT JOIN department d ON d.id = s.department_id
        WHERE
            sp.full_name LIKE '%$keyword%'
            OR s.student_code LIKE '%$keyword%'
            OR sp.email LIKE '%$keyword%'
            OR c.class_name LIKE '%$keyword%'
            OR d.name LIKE '%$keyword%'
        ORDER BY s.id DESC
    ";

        return $this->__query($sql);
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
    public function updateStudent_profiles($id, $gender, $full_name, $email, $phone, $date_of_birth, $address, $education_type, $status, $identity_number, $avatarupdate)
    {
        $sql = "UPDATE student_profiles SET gender='$gender',full_name='$full_name',email='$email',phone='$phone',date_of_birth='$date_of_birth' ,address='$address',identity_number='$identity_number' ,avatar ='$avatarupdate',education_type='$education_type',status = '$status' WHERE student_id='$id'";
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
    // Sửa thông tin ở trang của sinh viên
    public function updateProfile($student_id, array $data)
    {
        if (empty($data)) {
            return true;
        }

        mysqli_begin_transaction($this->connect);

        $fields = [];
        foreach ($data as $column => $value) {
            if ($value !== null) {
                $safeValue = mysqli_real_escape_string($this->connect, $value);
                $fields[] = "$column = '$safeValue'";
            }
        }

        if (empty($fields)) {
            mysqli_commit($this->connect);
            return true;
        }

        $sql = "UPDATE student_profiles 
            SET " . implode(', ', $fields) . "
            WHERE student_id = " . intval($student_id);

        if ($this->__query($sql) === false) {
            mysqli_rollback($this->connect);
            return false;
        }

        mysqli_commit($this->connect);
        return true;
    }

    public function studentExists($id)
    {
        $id = (int) $id;

        $sql = "SELECT id FROM student WHERE id = $id LIMIT 1";
        $result = $this->__query($sql);

        return mysqli_num_rows($result) > 0;
    }

}

