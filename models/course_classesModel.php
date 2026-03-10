<?php
require_once "./../config/database.php";
class course_classesModel
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
        $sql = "
            SELECT 
    cc.id,
    cc.class_code,
    s.name AS subject_name,
    l.full_name AS lecturer_name,
    se.name AS semester_name,
    se.academic_year,
    cc.max_students,
    cc.registration_start,
    cc.registration_end,
    cc.status,

    COUNT(DISTINCT scc.student_id) AS total_students,

    MIN(cs.session_date) AS first_session,
    MAX(cs.session_date) AS last_session

FROM course_classes cc

JOIN subjects s 
    ON cc.subject_id = s.id

JOIN lecturer l 
    ON cc.lecturer_id = l.id

JOIN semesters se 
    ON cc.semester_id = se.id

LEFT JOIN student_course_classes scc 
    ON scc.course_class_id = cc.id

LEFT JOIN class_sessions cs
    ON cs.course_class_id = cc.id

GROUP BY 
    cc.id,
    cc.class_code,
    s.name,
    l.full_name,
    se.name,
    cc.max_students

ORDER BY 
    se.name ASC,
    cc.class_code ASC;

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

    public function capNhatHocPhan(
        $id,
        $subject_id,
        $lecturer_id,
        $max_students,
        $registration_start,
        $registration_end,
        $status
    ) {
        // Ép kiểu an toàn
        $id = (int) $id;
        $subject_id = (int) $subject_id;
        $lecturer_id = (int) $lecturer_id;
        $max_students = (int) $max_students;

        // Escape chuỗi
        $registration_start = mysqli_real_escape_string($this->connect, $registration_start);
        $registration_end = mysqli_real_escape_string($this->connect, $registration_end);
        $status = mysqli_real_escape_string($this->connect, $status);

        $sql = "UPDATE course_classes SET
                subject_id = $subject_id,
                lecturer_id = $lecturer_id,
                max_students = $max_students,
                registration_start = '$registration_start',
                registration_end = '$registration_end',
                status = '$status'
            WHERE id = $id";

        $result = mysqli_query($this->connect, $sql);

        if (!$result) {
            throw new Exception("Lỗi update: " . mysqli_error($this->connect));
        }

        return true;
    }

    // public function editHocPhan($id, $subject_id, $lecturer_id, $semester_id, $class_code, $max_students)
    // {

    //     $sql = "
    //         UPDATE course_classes
    //     SET 
    //         subject_id = '$subject_id',
    //         lecturer_id = '$lecturer_id',
    //         semester_id = '$semester_id',
    //         class_code = '$class_code',
    //         max_students = '$max_students'
    //     WHERE id = '$id'
    //     ";
    //     return $this->__query($sql);
    // }
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

    public function getTimeStudying($courseClassId)
    {
        $courseClassId = (int) $courseClassId;
        $sql = "SELECT 
    MIN(session_date) AS first_session,
    MAX(session_date) AS last_session
FROM class_sessions
WHERE course_class_id = $courseClassId;";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function getCourseClassSV($studentId, $academic_year)
    {
        $academic_year = (int) $academic_year;
        $studentId = (int) $studentId;

        $sql = "
        SELECT 
    cc.id,
    cc.class_code,
    s.name AS subject_name,
    cc.max_students,
    l.full_name AS lecturer_name,

    cc.registration_start,
    cc.registration_end,

    COUNT(DISTINCT scc.student_id) AS current_students,

    GROUP_CONCAT(
        DISTINCT CONCAT(
            CASE t.day_of_week
                WHEN 2 THEN 'Thứ 2'
                WHEN 3 THEN 'Thứ 3'
                WHEN 4 THEN 'Thứ 4'
                WHEN 5 THEN 'Thứ 5'
                WHEN 6 THEN 'Thứ 6'
                WHEN 7 THEN 'Thứ 7'
                ELSE 'CN'
            END,
            ' (Tuần ', t.start_week, '-', t.end_week,
            ' ', t.session, ')'
        )
        ORDER BY t.day_of_week
        SEPARATOR '<br>'
    ) AS schedule,

    EXISTS (
        SELECT 1 
        FROM student_course_classes sc2 
        WHERE sc2.course_class_id = cc.id 
        AND sc2.student_id = 29
    ) AS is_registered

FROM course_classes cc

JOIN subjects s 
    ON cc.subject_id = s.id

JOIN lecturer l 
    ON cc.lecturer_id = l.id

JOIN semesters sem 
    ON cc.semester_id = sem.id
    AND sem.is_active = 1

LEFT JOIN timetables t 
    ON cc.id = t.course_class_id

LEFT JOIN student_course_classes scc 
    ON cc.id = scc.course_class_id

WHERE 
    cc.status <> 'finished'
    AND s.recommended_year = $academic_year
    AND s.department_id = (
        SELECT department_id 
        FROM student 
        WHERE id = $studentId
    )

GROUP BY 
    cc.id

ORDER BY 
    s.name;
    ";

        return $this->__query($sql);
    }
    public function tonTaiHocPhan($subject_id, $lecturer_id, $semester_id)
    {
        $sql = "SELECT id FROM course_classes
            WHERE subject_id = $subject_id
            AND lecturer_id = $lecturer_id
            AND semester_id = $semester_id";
        return mysqli_num_rows($this->__query($sql)) > 0;
    }

    public function themHocPhan(
        $subject_id,
        $lecturer_id,
        $semester_id,
        $class_code,
        $max_students,
        $registration_start,
        $registration_end,
        $status
    ) {
        $sql = "INSERT INTO course_classes
            (subject_id, lecturer_id, semester_id, class_code, max_students, registration_start, registration_end, status)  
            VALUES
            ($subject_id, $lecturer_id, $semester_id, '$class_code', $max_students, '$registration_start',
    '$registration_end',
    '$status')";
        $this->__query($sql);
        return mysqli_insert_id($this->connect);
    }


    // Kiểm tra sinh viên đã đăng ký chưa
    public function isRegistered($studentId, $classId)
    {
        $sql = "
        SELECT 1
        FROM student_course_classes
        WHERE student_id = '$studentId'
          AND course_class_id = '$classId'
        LIMIT 1
    ";

        $query = $this->__query($sql);

        return mysqli_num_rows($query) > 0;
    }

    // Đăng ký lớp học phần
    public function register($studentId, $classId)
    {
        $sql = "
            INSERT INTO student_course_classes (student_id, course_class_id)
            VALUES ($studentId, $classId)
        ";
        return $this->__query($sql);
    }

    public function registerNew($student_id, $course_class_id)
    {
        $student_id = (int) $student_id;
        $course_class_id = (int) $course_class_id;

        mysqli_begin_transaction($this->connect);

        try {

            // 1️⃣ Lấy thông tin lớp (khóa record tránh race condition)
            $sql = "
            SELECT subject_id, semester_id, max_students, status,
                   registration_start, registration_end
            FROM course_classes
            WHERE id = $course_class_id
            FOR UPDATE
        ";

            $result = mysqli_query($this->connect, $sql);

            if (!$result || mysqli_num_rows($result) == 0) {
                throw new Exception("Lớp học phần không tồn tại.");
            }

            $course = mysqli_fetch_assoc($result);

            if ($course['status'] !== 'open') {
                throw new Exception("Lớp chưa mở đăng ký.");
            }

            // ✅ 2️⃣ Kiểm tra thời gian đăng ký
            $now = date('Y-m-d H:i:s', NOW);

            if ($now < $course['registration_start']) {
                throw new Exception("Chưa đến thời gian đăng ký.");
            }

            if ($now > $course['registration_end']) {
                throw new Exception("Đã hết thời gian đăng ký.");
            }

            // 3️⃣ Kiểm tra số môn đã đăng ký trong học kỳ

            $semester_id = (int) $course['semester_id'];

            $sql = "
SELECT COUNT(DISTINCT subject_id) AS total_subjects
FROM student_course_classes
WHERE student_id = $student_id
AND semester_id = $semester_id
";

            $result = mysqli_query($this->connect, $sql);
            $row = mysqli_fetch_assoc($result);

            if ($row['total_subjects'] >= 5) {
                throw new Exception("Sinh viên chỉ được đăng ký tối đa 5 môn trong học kỳ.");
            }

            // 3️⃣ Kiểm tra sĩ số
            $sql = "
            SELECT COUNT(*) AS total
            FROM student_course_classes
            WHERE course_class_id = $course_class_id
        ";

            $result = mysqli_query($this->connect, $sql);
            $row = mysqli_fetch_assoc($result);

            if ($row['total'] >= $course['max_students']) {
                throw new Exception("Lớp đã đủ số lượng sinh viên.");
            }

            // 4️⃣ Kiểm tra trùng lịch học (cùng học kỳ)

            $semester_id = (int) $course['semester_id'];

            $sql = "
SELECT 1
FROM timetables t_new

JOIN timetables t_old 
    ON t_old.day_of_week = t_new.day_of_week
    AND t_old.session = t_new.session
    AND NOT (
        t_old.end_week < t_new.start_week
        OR
        t_old.start_week > t_new.end_week
    )

JOIN student_course_classes scc
    ON scc.course_class_id = t_old.course_class_id
    AND scc.student_id = $student_id
    AND scc.semester_id = $semester_id

WHERE t_new.course_class_id = $course_class_id

LIMIT 1
";

            $result = mysqli_query($this->connect, $sql);

            if (mysqli_num_rows($result) > 0) {
                throw new Exception("Lịch học bị trùng với một lớp đã đăng ký trong học kỳ này.");
            }

            $subject_id = (int) $course['subject_id'];


            // 4️⃣ Insert (DB sẽ tự chặn trùng môn cùng kỳ bằng UNIQUE)
            $sql = "
            INSERT INTO student_course_classes
            (student_id, course_class_id, subject_id, semester_id)
            VALUES ($student_id, $course_class_id, $subject_id, $semester_id)
        ";

            $this->__query($sql);

            mysqli_commit($this->connect);
            return true;

        } catch (mysqli_sql_exception $e) {

            mysqli_rollback($this->connect);

            if ($e->getCode() == 1062) {
                throw new Exception("Bạn đã đăng ký môn này trong học kỳ rồi.");
            }

            throw new Exception("Lỗi hệ thống: " . $e->getMessage());
        }
    }

    public function cancelRegister($studentId, $classId)
    {
        $sql = "
            DELETE FROM student_course_classes
WHERE student_id = '$studentId'
AND course_class_id = $classId
        ";
        return $this->__query($sql);
    }

    // Đếm số SV đã đăng ký
    public function countStudents($classId)
    {
        $sql = "
            SELECT COUNT(*) as total
            FROM student_course_classes
            WHERE course_class_id = $classId
        ";
        return $this->__query($sql);
    }

    //Lấy lớp học phần giảng viên đảm nhiệm
    public function getCourseClassGV($lecturerId)
    {
        $sql = "
        SELECT 
    cc.id,
    cc.class_code,
    s.name AS subject_name,
    se.name AS semester_name,
    cc.max_students,
    se.academic_year,
    cc.registration_start,
    cc.registration_end,
    cc.status,
    COUNT(DISTINCT scc.student_id) AS total_students,
    MIN(cs.session_date) AS first_session,
    MAX(cs.session_date) AS last_session
FROM course_classes cc
JOIN subjects s ON cc.subject_id = s.id
JOIN semesters se ON cc.semester_id = se.id
LEFT JOIN student_course_classes scc 
       ON cc.id = scc.course_class_id
       LEFT JOIN class_sessions cs
    ON cs.course_class_id = cc.id
WHERE cc.lecturer_id = $lecturerId
GROUP BY cc.id
ORDER BY se.id DESC, cc.class_code;
";
        return $this->__query($sql);
    }

    public function updateResultByCourseClass($classId)
    {
        $sql = "
        SELECT 
            st.id AS student_id,
            st.student_code,
            sp.full_name,
            sp.date_of_birth,

            sub.id AS subject_id,
            sub.credits AS subject_credits,

            ar.frequent_scores,   -- ✅ SỬA Ở ĐÂY
            ar.process_score,
            ar.midterm_score,
            ar.final_exam_score,
            ar.final_grade,
            ar.grade_letter,
            ar.result

        FROM student_course_classes scc

        JOIN student st 
            ON scc.student_id = st.id

        LEFT JOIN student_profiles sp 
            ON sp.student_id = st.id

        JOIN course_classes cc
            ON cc.id = scc.course_class_id

        JOIN subjects sub
            ON sub.id = cc.subject_id

        LEFT JOIN academic_results ar
            ON ar.student_id = st.id
            AND ar.course_class_id = scc.course_class_id

        WHERE scc.course_class_id = '$classId'
        ORDER BY 
SUBSTRING_INDEX(full_name, ' ', -1) ASC,
student_code ASC
        
    ";

        return $this->__query($sql);
    }

    public function getStudents($classId)
    {
        $sql = "
        SELECT s.id, s.student_code, sp.full_name, sp.date_of_birth
FROM student_course_classes scc
JOIN student s ON s.id = scc.student_id
LEFT JOIN student_profiles sp ON sp.student_id = s.id
WHERE scc.course_class_id = $classId
ORDER BY 
SUBSTRING_INDEX(full_name, ' ', -1) ASC,
student_code ASC
;";
        return $this->__query($sql);
    }
    public function getStudentsWithExamConditions($courseClassId)
    {
        $sql = "
         SELECT 
    s.id AS student_id,
    s.student_code,
    sp.full_name,

    COUNT(a.id) AS total_sessions,
    SUM(CASE WHEN a.status = 'present' THEN 1 ELSE 0 END) AS attended_sessions,

    IFNULL(ar.process_score, 0) AS process_score,
    IFNULL(ar.midterm_score, 0) AS midterm_score,

    ROUND((IFNULL(ar.process_score, 0) + IFNULL(ar.midterm_score, 0)) / 2, 2) AS avg_score

FROM student_course_classes scc
JOIN student s ON s.id = scc.student_id
JOIN student_profiles sp ON sp.student_id = s.id

LEFT JOIN attendance a 
    ON a.student_id = s.id 
    AND a.course_class_id = scc.course_class_id

LEFT JOIN academic_results ar 
    ON ar.student_id = s.id 
    AND ar.course_class_id = scc.course_class_id

WHERE scc.course_class_id = $courseClassId

GROUP BY 
    s.id,
    s.student_code,
    sp.full_name,
    ar.process_score,
    ar.midterm_score
    ";


        return $this->__query($sql);
    }

    // public function deleteStudentCourseClass($id)
    // {
    //     $sql = "DELETE FROM student_course_classes WHERE course_class_id = $id";
    //     return $this->__query($sql);
    // }

    // public function deleteAcademicResults($id)
    // {
    //     $sql = "DELETE FROM academic_results WHERE course_class_id = $id";
    //     return $this->__query($sql);
    // }

    // public function deleteAttendance($id)
    // {
    //     $sql = "DELETE FROM attendance WHERE course_class_id = $id";
    //     return $this->__query($sql);
    // }

    public function deleteHocPhanOnly($id)
    {
        $sql = "DELETE FROM course_classes WHERE id = $id";
        return $this->__query($sql);
    }

    public function updateFinished($course_class_id)
    {
        $course_class_id = (int) $course_class_id;

        $sql = "
UPDATE course_classes
SET status = 'finished'
WHERE id = $course_class_id
";

        mysqli_query($this->connect, $sql);
    }

    public function checkAllFinalScoresEntered($courseClassId)
    {
        $courseClassId = (int) $courseClassId;

        $sql = "
        SELECT COUNT(*) AS missing
        FROM student_course_classes scc
        JOIN subject_score_components sc 
            ON sc.subject_id = scc.subject_id
        LEFT JOIN student_component_scores scs 
            ON scs.student_id = scc.student_id
            AND scs.course_class_id = scc.course_class_id
            AND scs.subject_component_id = sc.id
        WHERE scc.course_class_id = $courseClassId
        AND sc.type IN ('CK','PROJECT')
        AND scs.score IS NULL
    ";

        $result = $this->__query($sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['missing'] == 0; // true nếu đã nhập hết
        }

        return false;
    }
}
