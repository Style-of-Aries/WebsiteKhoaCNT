<?php
require_once "./../config/database.php";
class timetableModel extends database
{

    private $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
    }
    public function getAll($id)
    {
        $sql = "
            SELECT
    cc.class_code        AS ma_hoc_phan,
    s.name               AS ten_hoc_phan,
    l.full_name          AS giang_vien,
    t.day_of_week        AS thu,
    t.session            AS buoi_hoc,
    r.room_name          AS phong_hoc,
    se.name   AS ky_hoc,
    se.academic_year   AS nam_hoc
    FROM timetables t
    JOIN course_classes cc ON t.course_class_id = cc.id
    JOIN subjects s        ON cc.subject_id = s.id
    JOIN lecturer l       ON cc.lecturer_id = l.id
    JOIN rooms r           ON t.room_id = r.id
    JOIN semesters se      ON cc.semester_id = se.id
    WHERE t.course_class_id = $id
    ORDER BY 
    se.academic_year,
    se.name,
    t.day_of_week,
    FIELD(t.session, 'Sáng', 'Chiều')";
        return $this->__query($sql);
    }
    public function lichHocSv($id)
    {
        $sql = "
            SELECT
    s.id AS student_id,
    s.student_code,

    sb.subject_code,
    sb.name AS subject_name,

    cc.class_code AS course_class_code,

    se.name AS semester_name,
    se.academic_year,

    t.day_of_week,
    t.session,

    r.room_name,
    r.building,

    l.full_name AS lecturer_name
FROM student s
JOIN student_course_classes scc 
    ON s.id = scc.student_id
JOIN course_classes cc 
    ON scc.course_class_id = cc.id
JOIN subjects sb 
    ON cc.subject_id = sb.id
JOIN semesters se 
    ON cc.semester_id = se.id
JOIN timetables t 
    ON cc.id = t.course_class_id
JOIN rooms r 
    ON t.room_id = r.id
JOIN lecturer l 
    ON cc.lecturer_id = l.id
WHERE s.id = $id";
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

    public function addHocPhan($subject_id, $lecturer_id, $semester_id, $class_code, $max_students)
    {

        $sql = "
            INSERT INTO course_classes (subject_id,lecturer_id,semester_id,class_code,max_students)
            VALUES ('$subject_id', '$lecturer_id', '$semester_id','$class_code','$max_students' )
        ";
        return $this->__query($sql);
    }
    public function malop($subject_id)
    {
        $year = date('Y');

        // 1. Lấy tên khoa
        $sqlDept = "
        SELECT d.name
        FROM subjects s
        JOIN department d ON s.department_id = d.id
        WHERE s.id = '$subject_id'
    ";
        $dept = $this->__query($sqlDept)->fetch_assoc();

        // 2. Viết tắt khoa (CNTT)
        $words = explode(' ', $dept['name']);
        $deptCode = '';
        foreach ($words as $w) {
            $deptCode .= strtoupper(mb_substr($w, 0, 1));
        }

        // 3. Lấy mã lớn nhất
        $sqlLast = "
        SELECT class_code
        FROM course_classes
        WHERE class_code LIKE '{$year}{$deptCode}%'
        ORDER BY class_code DESC
        LIMIT 1
    ";
        $last = $this->__query($sqlLast)->fetch_assoc();

        $lastNumber = $last ? intval(substr($last['class_code'], -6)) : 0;

        // 4. Tạo mã mới
        $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);

        return $year . $deptCode . $newNumber;
    }

    public function editHocPhan($id, $subject_id, $lecturer_id, $semester_id, $class_code, $max_students)
    {

        $sql = "
            UPDATE course_classes
        SET 
            subject_id = '$subject_id',
            lecturer_id = '$lecturer_id',
            semester_id = '$semester_id',
            class_code = '$class_code',
            max_students = '$max_students'
        WHERE id = '$id'
        ";
        return $this->__query($sql);
    }
    public function checkHocPhan($subject_id, $lecturer_id, $semester_id)
    {

        $sql = "
        SELECT 1
        FROM course_classes
        WHERE subject_id = $subject_id
          AND lecturer_id = $lecturer_id
          AND semester_id = $semester_id
    ";
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
    public function deleteHocPhan($id)
    {
        $sql = "delete from course_classes where id= '$id'";
        return $this->__query($sql);
    }
    public function getById($id)
    {
        $sql = "SELECT * FROM course_classes WHERE id='$id'";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    public function __query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }
}
