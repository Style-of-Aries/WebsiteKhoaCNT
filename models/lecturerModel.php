<?php
require_once "./../config/database.php";
class lecturerModel
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
        $sql = "SELECT * FROM lecturer WHERE id='$id'";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    // lấy toàn bộ thông tin của giảng viên
    public function getAll()
    {
        $sql = "SELECT 
    s.id,
    s.full_name,
    s.lecturer_code,
    s.email,
    c.name
    FROM lecturer s
    LEFT JOIN department c ON s.department_id = c.id";
        $query = $this->__query($sql);
        $lecturers = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $lecturers[] = $row;
        }
        return $lecturers;
    }
    public function searchLecturers($keyword)
{
    $keyword = trim($keyword);

    $sql = "
        SELECT 
            s.id,
            s.full_name,
            s.lecturer_code,
            s.email,
            c.name
        FROM lecturer s
        LEFT JOIN department c ON s.department_id = c.id
        WHERE 
            s.full_name LIKE '%$keyword%'
            OR s.lecturer_code LIKE '%$keyword%'
            OR s.email LIKE '%$keyword%'
            OR c.name LIKE '%$keyword%'
    ";

    $query = $this->__query($sql);

    $lecturers = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $lecturers[] = $row;
    }
    return $lecturers;
}

    // end 


    // thêm mới giảng viên 
    public function addGiangVien($full_name, $code, $email, $department_id)
    {
        mysqli_begin_transaction($this->connect);

        // 1. Insert student
        $sqlStudent = "INSERT INTO `lecturer` ( `full_name`, `lecturer_code`, `email`, `department_id`) VALUES ( '$full_name', '$code', '$email', $department_id)";


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
            '$code',
            '$code',
            'lecturer',
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

    // kết thúc thêm giảng viên 
    public function KtEmail($email, $id)
{
    $email = trim($email);
    $id = (int)$id;

    $sql = "SELECT id FROM lecturer 
            WHERE email = '$email' 
            AND id != $id 
            LIMIT 1";

    $query = $this->__query($sql);

    return mysqli_num_rows($query) > 0;
}
    public function KtMagv($lecturer_code, $id)
    {
        $sql = "Select *from lecturer where lecturer_code ='$lecturer_code'AND id != $id
        LIMIT 1";
        $query = $this->__query($sql);
        if (mysqli_num_rows($query) > 0) {
            return true;
        }
    }
    public function isLecturerCodeExists($lecturer_code, $id)
    {
        $lecturer_code = trim($lecturer_code);
        $id = trim($id);

        $sql = "SELECT id FROM lecturer
            WHERE lecturer_code = '$lecturer_code'
            AND id != '$id'";
        $query = $this->__query($sql);

        return mysqli_num_rows($query) > 0;
    }

    public function updateGiangVien($id, $full_name, $lecturer_code, $email, $department_id)
    {
        // chuẩn hóa dữ liệu
        $id = trim($id);
        $full_name = trim($full_name);
        $lecturer_code = trim($lecturer_code);
        $email = trim($email);
        $department_id = trim($department_id);

        //  chặn trùng trước khi update
        if ($this->isLecturerCodeExists($lecturer_code, $id)) {
            return "duplicate_code";
        }

        $sql = "UPDATE lecturer SET
                full_name = '$full_name',
                lecturer_code = '$lecturer_code',
                email = '$email',
                department_id = '$department_id'
            WHERE id = '$id'";

        return $this->__query($sql);
    }


    // xóa giảng viên 
    public function deleteLecturer($ref_id)
    {
        $sql = "delete from lecturer where id= $ref_id";
        return $this->__query($sql);
    }

    public function sidebarSubjects($lecturer_id)
    {
        // $lecturer_id = $_SESSION['lecturer_id'];

        $sql = "
        SELECT DISTINCT s.id, s.name
        FROM lecturer_subjects ls
        JOIN subjects s ON ls.subject_id = s.id
        WHERE ls.lecturer_id = $lecturer_id";

        return $this->__query($sql);
    }

}

