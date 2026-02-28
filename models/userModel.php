<?php
class userModel
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

    // lấy user theo username
    public function getByUsername($name)
    {
        $sql = "SELECT * FROM users WHERE username='$name'";
        return $this->__query($sql);
    }

    public function getUserProfile($role, $refId)
    {
        switch ($role) {
            case 'lecturer':
                $sql = "SELECT full_name, 'Nam' as gender FROM lecturer WHERE id = $refId";
                break;

            case 'student':
                $sql = "SELECT full_name, gender FROM student_profiles WHERE student_id = $refId";
                break;

            case 'training_office':
                $sql = "SELECT full_name, 'Nam' as gender FROM training_office WHERE id = $refId";
                break;

            case 'academic_affairs':
                $sql = "SELECT full_name, 'Nam' as gender FROM academic_affairs WHERE id = $refId";
                break;

            case 'exam_office':
                $sql = "SELECT full_name, 'Nam' as gender FROM exam_office WHERE id = $refId";
                break;

            case 'student_affairs':
                $sql = "SELECT full_name, 'Nam' as gender FROM student_affairs WHERE id = $refId";
                break;

            case 'admin':
                return [
                    'full_name' => 'Administrator',
                    'gender' => 'Nam'
                ];

            default:
                return null;
        }
        $result = $this->__query($sql);
        return mysqli_fetch_assoc($result);
    }
    public function getAll()
    {
        $sql = "
        SELECT 
            id,
            username,
            password,
            ref_id,
            CASE role
                WHEN 'admin' THEN 'Quản trị viên'
                WHEN 'lecturer' THEN 'Giảng viên'
                WHEN 'student' THEN 'Sinh viên'
                WHEN 'training_office' THEN 'Phòng đào tạo'
                WHEN 'academic_affairs' THEN 'Phòng học vụ'
                WHEN 'exam_office' THEN 'Phòng khảo thí'
                WHEN 'student_affairs' THEN 'Phòng công tác sinh viên'
                ELSE role
            END AS role
        FROM users
    ";

        return $this->__query($sql);
    }

    // lấy thông tin user theo id 
    public function getById($id)
    {
        $sql = "SELECT * FROM users WHERE id='$id'";
        return $this->__query($sql);
    }
    public function getByIdUser($id_user)
    {
        $sql = "SELECT * FROM users WHERE id='$id_user'";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }


    // kiểm tra email 
    public function checkEmail($email)
    {

        $sql = "
        SELECT email FROM student WHERE email = '$email'
        UNION
        SELECT email FROM lecturer WHERE email = '$email'";
        $query = $this->__query($sql);
        if (mysqli_num_rows($query) > 0) {
            return true; // email đã tồn tại
        }
        return false;
    }

    
    public function KtUserName($username, $id)
    {
        $sql = "
        SELECT id 
        FROM users 
        WHERE username = '$username'
        AND ref_id != $id
        LIMIT 1
    ";

        $query = $this->__query($sql);

        return mysqli_num_rows($query) > 0;
    }

    public function getByRef_id($id)
    {
        $sql = "select * from users where ref_id='$id'";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    public function updateUser($id, $username, $password)
    {
        $sql = "UPDATE users SET username='$username',password = '$password' WHERE ref_id='$id'";
        $query = $this->__query($sql);
    }

    public function checkEmailByRole($role, $email)
{
    switch ($role) {
        case 'lecturer':
            $table = 'lecturer';
            break;

        case 'student':
            $table = 'student_profiles';
            break;

        case 'training_office':
            $table = 'training_office';
            break;

        case 'academic_affairs':
            $table = 'academic_affairs';
            break;

        case 'exam_office':
            $table = 'exam_office';
            break;

        case 'student_affairs':
            $table = 'student_affairs';
            break;

        default:
            return false; // role không hợp lệ
    }

    $sql = "SELECT id FROM $table 
            WHERE email = '$email'
            LIMIT 1";

    $result = mysqli_query($this->connect, $sql);

    if(mysqli_num_rows($result) > 0){
        return true;  // Email đã tồn tại
    }

    return false; // Email hợp lệ
}
    public function addUser($role, $full_name, $email, $code, $department)
    {

        mysqli_begin_transaction($this->connect);

        try {

            $refId = null;

            // =========================
            // STUDENT
            // =========================
            // if ($role === 'student') {

            //     $sqlStudent = "
            //     INSERT INTO student(student_code, class_id, department_id, created_at)
            //     VALUES (
            //         '$code',
            //         'null',
            //         'null',
            //         NOW()
            //     )
            // ";

            //     if (!$this->__query($sqlStudent)) {
            //         throw new Exception("Insert student failed");
            //     }

            //     $refId = mysqli_insert_id($this->connect);
            // }

            // LECTURER
            if ($role === 'lecturer') {

                $sql = "
                INSERT INTO lecturer(full_name, lecturer_code, email, department_id)
                VALUES (
                    '$full_name',
                    '$code',
                    '$email',
                    '$department'
                )
            ";

                if (!$this->__query($sql)) {
                    throw new Exception("Insert lecturer failed");
                }

                $refId = mysqli_insert_id($this->connect);
            }

            // TRAINING OFFICE
            elseif ($role === 'training_office') {

                $sql = "
                INSERT INTO training_office(full_name, office_code, email, created_at)
                VALUES (
                    '$full_name',
                    '$code',
                    '$email',
                    NOW()
                )
            ";

                if (!$this->__query($sql)) {
                    throw new Exception("Insert training office failed");
                }

                $refId = mysqli_insert_id($this->connect);
            }

            // ACADEMIC AFFAIRS
            elseif ($role === 'academic_affairs') {

                $sql = "
                INSERT INTO academic_affairs(full_name, office_code, email, created_at)
                VALUES (
                    '$full_name',
                    '$code',
                    '$email',
                    NOW()
                )
            ";

                if (!$this->__query($sql)) {
                    throw new Exception("Insert academic affairs failed");
                }

                $refId = mysqli_insert_id($this->connect);
            }

            // EXAM OFFICE
            elseif ($role === 'exam_office') {

                $sql = "
                INSERT INTO exam_office(full_name, office_code, email, created_at)
                VALUES (
                    '$full_name',
                    '$code',
                    '$email',
                    NOW()
                )
            ";

                if (!$this->__query($sql)) {
                    throw new Exception("Insert exam office failed");
                }

                $refId = mysqli_insert_id($this->connect);
            }

            // STUDENT AFFAIRS
            elseif ($role === 'student_affairs') {

                $sql = "
                INSERT INTO student_affairs(full_name, office_code, email, created_at)
                VALUES (
                    '$full_name',
                    '$code',
                    '$email',
                    NOW()
                )
            ";

                if (!$this->__query($sql)) {
                    throw new Exception("Insert student affairs failed");
                }

                $refId = mysqli_insert_id($this->connect);
            }

            // INSERT USERS

            $sqlUser = "
            INSERT INTO users(username, password, role, ref_id)
            VALUES (
                '$code',
                '$code',
                '$role',
                '$refId'
            )
        ";

            if (!$this->__query($sqlUser)) {
                throw new Exception("Insert user failed");
            }

            mysqli_commit($this->connect);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($this->connect);
            echo $e->getMessage(); // thêm dòng này
            die();
        }
    }
    public function deleteUser($id){
        $sql = "DELETE FROM users WHERE id = $id";  
        return $this->__query($sql);

    }
    public function deleteUsers($id, $ref_id, $role)
    {
        mysqli_begin_transaction($this->connect);

        try {

            switch ($role) {
                case 'Giảng viên':
                    $sql = "DELETE FROM lecturer WHERE id = $ref_id";
                    break;

                case 'student':
                    $sql = "DELETE FROM student WHERE id = $ref_id";
                    break;

                case 'Phòng đào tạo':
                    $sql = "DELETE FROM training_office WHERE id = $ref_id";
                    break;

                case 'Học vụ':
                    $sql = "DELETE FROM academic_affairs WHERE id = $ref_id";
                    break;

                case 'Khảo thí':
                    $sql = "DELETE FROM exam_office WHERE id = $ref_id";
                    break;

                case 'Công tác SV':
                    $sql = "DELETE FROM student_affairs WHERE id = $ref_id";
                    break;

                case 'admin':
                    // admin không có bảng phụ
                    $sql = null;
                    break;

                default:
                    throw new Exception("Role không hợp lệ");
            }

            if ($sql) {
                if (!mysqli_query($this->connect, $sql)) {
                    throw new Exception("Lỗi xóa bảng phụ");
                }
            }

            // Xóa user
            $sqlUser = "DELETE FROM users WHERE id = $id";
            if (!mysqli_query($this->connect, $sqlUser)) {
                throw new Exception("Lỗi xóa user");
            }

            mysqli_commit($this->connect);
            return true;
        } catch (Exception $e) {
            mysqli_rollback($this->connect);
            return false;
        }
    }
}
