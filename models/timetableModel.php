<?php
require_once "./../config/database.php";
class timetableModel
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

    public function checkTrungLichGv($lecturer_id, $session_date, $session, $id)
    {
        $sql = "SELECT cs.id
            FROM class_sessions cs
            JOIN course_classes cc ON cs.course_class_id = cc.id
            WHERE cc.lecturer_id = '$lecturer_id'
            AND cs.session_date = '$session_date'
            AND cs.session = '$session'
            AND cs.id != '$id'";

        $result = $this->__query($sql);

        return mysqli_num_rows($result) > 0;
    }
    public function getAllNoAdd()
    {
        $sql = "SELECT 
        cc.id,
    cc.class_code,
    s.name AS subject_name,
    l.full_name AS lecturer_name,
    se.name AS semester_name,
    se.academic_year
FROM course_classes cc
LEFT JOIN class_sessions cs 
       ON cc.id = cs.course_class_id
JOIN subjects s 
       ON cc.subject_id = s.id
JOIN lecturer l 
       ON cc.lecturer_id = l.id
JOIN semesters se 
       ON cc.semester_id = se.id
WHERE cs.course_class_id IS NULL";
        return $this->__query($sql);
    }
    public function getAllCourse_Classes()
    {
        $sql = "SELECT 
        cc.id,
    cc.class_code,
    s.name AS subject_name,
    l.full_name AS lecturer_name,
    se.name AS semester_name,
    se.academic_year
FROM course_classes cc
LEFT JOIN class_sessions cs 
       ON cc.id = cs.course_class_id
JOIN subjects s 
       ON cc.subject_id = s.id
JOIN lecturer l 
       ON cc.lecturer_id = l.id
JOIN semesters se 
       ON cc.semester_id = se.id";
        return $this->__query($sql);
    }
    public function getAllTkb()
    {
        $sql = "SELECT 
                cs.id,
                s.name AS subject_name,
                DATE_FORMAT(cs.session_date, '%d/%m/%Y') AS session_date,
                cs.course_class_id,
                cs.day_of_week,
                cs.session,
                cs.week_number,
                r.room_name,
                r.building,
                l.full_name,
                l.lecturer_code,
                cc.class_code
            FROM class_sessions cs
            JOIN course_classes cc ON cs.course_class_id = cc.id
            JOIN subjects s ON cc.subject_id = s.id
            JOIN lecturer l ON cc.lecturer_id = l.id
            LEFT JOIN rooms r ON cs.room_id = r.id
            ORDER BY cs.session_date ASC";
        return $this->__query($sql);
    }
    public function getAllTkbEdit($course_class_id)
    {
        $sql = "SELECT 
            cs.id,
            s.name AS subject_name,
            DATE_FORMAT(cs.session_date, '%d/%m/%Y') AS session_date,
            cs.course_class_id,
            cs.day_of_week,
            cs.session,
            cs.week_number,
            r.room_name,
            r.building,
            l.full_name,
            l.lecturer_code,
            cc.class_code
        FROM class_sessions cs
        JOIN course_classes cc ON cs.course_class_id = cc.id
        JOIN subjects s ON cc.subject_id = s.id
        JOIN lecturer l ON cc.lecturer_id = l.id
        LEFT JOIN rooms r ON cs.room_id = r.id
        WHERE cs.course_class_id = $course_class_id
        ORDER BY cs.session_date ASC
        ";

        return $this->__query($sql);
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
    public function lichHocSvTheoTuan($studentId, $week)
    {
        $sql = "
SELECT
    sb.name AS subject_name,
    cs.day_of_week,
    cs.session,
    r.room_name,
    l.full_name AS lecturer_name,

    GROUP_CONCAT(DISTINCT c.class_name ORDER BY c.class_name SEPARATOR '+') 
        AS admin_classes

FROM student_course_classes scc

JOIN course_classes cc 
    ON cc.id = scc.course_class_id

JOIN subjects sb 
    ON sb.id = cc.subject_id

-- Lấy lịch từ class_sessions thay vì timetables
JOIN class_sessions cs 
    ON cs.course_class_id = cc.id

JOIN rooms r 
    ON r.id = cs.room_id

JOIN lecturer l 
    ON l.id = cc.lecturer_id

-- Lấy toàn bộ sinh viên học chung học phần
JOIN student_course_classes scc2 
    ON scc2.course_class_id = cc.id

JOIN student st 
    ON st.id = scc2.student_id

JOIN classes c 
    ON c.id = st.class_id

WHERE scc.student_id = $studentId
  AND cs.week_number = $week

GROUP BY 
    sb.name,
    cs.day_of_week,
    cs.session,
    r.room_name,
    l.full_name

ORDER BY 
    cs.day_of_week,
    FIELD(cs.session, 'Sáng', 'Chiều');
";

        return $this->__query($sql);
    }
    //     public function lichHocSvTheoTuan($studentId, $week)
    //     {
    //         $sql = "
    //     SELECT
    //     sb.name AS subject_name,
    //     t.day_of_week,
    //     t.session,
    //     r.room_name,
    //     l.full_name AS lecturer_name,

    //     -- Gộp các lớp hành chính học chung
    //     GROUP_CONCAT(DISTINCT c.class_name ORDER BY c.class_name SEPARATOR '+') 
    //         AS admin_classes

    // FROM student_course_classes scc
    // JOIN course_classes cc 
    //     ON cc.id = scc.course_class_id

    // JOIN subjects sb 
    //     ON sb.id = cc.subject_id

    // JOIN timetables t 
    //     ON t.course_class_id = cc.id

    // JOIN rooms r 
    //     ON r.id = t.room_id

    // JOIN lecturer l 
    //     ON l.id = cc.lecturer_id

    // -- Lấy toàn bộ sinh viên trong học phần
    // JOIN student_course_classes scc2 
    //     ON scc2.course_class_id = cc.id

    // JOIN student st 
    //     ON st.id = scc2.student_id

    // JOIN classes c 
    //     ON c.id = st.class_id

    // WHERE scc.student_id = $studentId
    //   AND t.start_week <= $week
    //   AND t.end_week >= $week

    // GROUP BY 
    //     sb.name,
    //     t.day_of_week,
    //     t.session,
    //     r.room_name,
    //     l.full_name

    // ORDER BY 
    //     t.day_of_week,
    //     FIELD(t.session, 'Sáng', 'Chiều');
    //     ";

    //         return $this->__query($sql);
    //     }

    public function lichHocSv($studentId)
    {
        $sql = "  SELECT
    s.id                AS student_id,
    s.student_code,

    sb.subject_code,
    sb.name             AS subject_name,

    cc.id               AS course_class_id,
    cc.class_code       AS course_class_code,

    se.name             AS semester_name,
    se.academic_year,

    cs.session_date,
    cs.day_of_week,
    cs.session,
    cs.week_number,

    r.room_name,
    r.building,

    l.full_name         AS lecturer_name

FROM student AS s

INNER JOIN student_course_classes AS scc
        ON scc.student_id = s.id

INNER JOIN course_classes AS cc
        ON cc.id = scc.course_class_id

INNER JOIN subjects AS sb
        ON sb.id = cc.subject_id

INNER JOIN semesters AS se
        ON se.id = cc.semester_id


INNER JOIN class_sessions AS cs
        ON cs.course_class_id = cc.id

INNER JOIN rooms AS r
        ON r.id = cs.room_id

INNER JOIN lecturer AS l
        ON l.id = cc.lecturer_id

WHERE s.id = $studentId

ORDER BY cs.session_date ASC";

        return $this->__query($sql);
    }
    public function lichDayGvTheoTuan($lecturerId, $week)
    {
        $sql = "
    SELECT
    sb.name AS subject_name,
    t.day_of_week,
    t.session,
    r.room_name,
    l.full_name AS lecturer_name,

    -- Gộp các lớp hành chính học chung
    GROUP_CONCAT(DISTINCT c.class_name ORDER BY c.class_name SEPARATOR '+') 
        AS admin_classes

FROM course_classes cc

JOIN subjects sb 
    ON sb.id = cc.subject_id

JOIN timetables t 
    ON t.course_class_id = cc.id

JOIN rooms r 
    ON r.id = t.room_id

JOIN lecturer l 
    ON l.id = cc.lecturer_id

-- Lấy toàn bộ sinh viên trong học phần
JOIN student_course_classes scc 
    ON scc.course_class_id = cc.id

JOIN student st 
    ON st.id = scc.student_id

JOIN classes c 
    ON c.id = st.class_id

WHERE cc.lecturer_id = $lecturerId
  AND t.start_week <= $week
  AND t.end_week >= $week

GROUP BY 
    sb.name,
    t.day_of_week,
    t.session,
    r.room_name,
    l.full_name

ORDER BY 
    t.day_of_week,
    FIELD(t.session, 'Sáng', 'Chiều');

    ";

        return $this->__query($sql);
    }

    public function phongDaCoLich($room_id, $day, $session)
    {
        $sql = "SELECT id FROM timetables
            WHERE room_id = $room_id
            AND day_of_week = $day
            AND session = '$session'";
        return mysqli_num_rows($this->__query($sql)) > 0;
    }

    public function lopDaCoLich($course_class_id, $day, $session)
    {
        $sql = "SELECT id FROM timetables
            WHERE course_class_id = $course_class_id
            AND day_of_week = $day
            AND session = '$session'";
        return mysqli_num_rows($this->__query($sql)) > 0;
    }

    public function themThoiKhoaBieu($course_class_id, $room_id, $day, $session, $start_week, $end_week)
    {
        $sql = "INSERT INTO timetables
            (course_class_id, room_id, day_of_week, session, start_week, end_week)
            VALUES
            ($course_class_id, $room_id, $day, '$session', $start_week, $end_week)";
        $this->__query($sql);
    }


    public function getWeeksOfActiveSemester()
    {
        $sql = "
        SELECT start_date, end_date
        FROM semesters
        WHERE is_active = 1
        LIMIT 1
    ";

        $semester = $this->__query($sql)->fetch_assoc();
        if (!$semester) return [];

        $start = new DateTime($semester['start_date']);
        $end   = new DateTime($semester['end_date']);

        $weeks = [];
        $week = 1;

        while ($start <= $end) {
            $weekStart = clone $start;
            $weekEnd = clone $start;
            $weekEnd->modify('+6 days');

            if ($weekEnd > $end) {
                $weekEnd = $end;
            }

            $weeks[] = [
                'from'  => $weekStart->format('Y-m-d'),
                'to'    => $weekEnd->format('Y-m-d'),
                'label' => 'Tuần ' . $week . ' (' .
                    $weekStart->format('d/m/Y') . ' - ' .
                    $weekEnd->format('d/m/Y  ') . ')'
            ];

            $start->modify('+7 days');
            $week++;
        }

        return $weeks;
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
    public function getByCourseClassId($course_class_id)
    {
        $sql = "SELECT * FROM timetables WHERE course_class_id = $course_class_id ";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    public function getByClass_sessionId($id_buoihoc)
    {

        $sql = "SELECT * FROM class_sessions WHERE id = $id_buoihoc LIMIT 1";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    public function phongDaCoLichEdit($room_id, $session_date, $session, $course_class_id)
    {
        $sql = "
        SELECT id FROM class_sessions
        WHERE room_id = '$room_id'
          AND session_date = '$session_date'
          AND session = '$session'
          AND course_class_id != $course_class_id
    ";
        return mysqli_num_rows($this->__query($sql)) > 0;
    }

    public function updateTimetable(
        $course_class_id,
        $room_id,
        $day,
        $session,
        $start_week,
        $end_week
    ) {
        $sql = "
        UPDATE timetables
        SET
            room_id = $room_id,
            day_of_week = $day,
            session = '$session',
            start_week = $start_week,
            end_week = $end_week
        WHERE course_class_id = $course_class_id
    ";
        return $this->__query($sql);
    }

    public function updateWeek($id, $session_date, $week_number)
    {
        $sql = "UPDATE class_sessions
        SET session_date = '$session_date', week_number = '$week_number'
        WHERE id = '$id'";

        return $this->__query($sql);
    }
    public function getStartDate($course_class_id)
    {
        $sql = "SELECT s.start_date
        FROM course_classes cc
        JOIN semesters s ON cc.semester_id = s.id
        WHERE cc.id = $course_class_id";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }
    public function updateClass_sessions(
        $id,
        $room_id,
        $day,
        $session,
        $session_date,
        $week_number
        // $start_week,
        // $end_week
    ) {
        $sql = "
        UPDATE class_sessions
        SET
            room_id = $room_id,
            day_of_week = $day,
            session = '$session',
            session_date = '$session_date',
            week_number= '$week_number'
            
            
        WHERE id = $id
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
    public function deleteByCourseClassId($course_class_id)
    {
        $sql = "DELETE FROM timetables WHERE course_class_id = $course_class_id";
        return $this->__query($sql);
    }
    public function checkRoomTuan(
        $room_id,
        $day,
        $session,
        $semester_id,
        $startWeek,
        $endWeek
    ) {
        $sql = "
        SELECT t.*
FROM timetables t
JOIN course_classes cc ON t.course_class_id = cc.id
WHERE t.room_id = '$room_id'
  AND t.day_of_week = '$day'
  AND t.session = '$session'
  AND cc.semester_id = $semester_id
        AND (
            ($startWeek BETWEEN start_week AND end_week)
            OR
            ($endWeek BETWEEN start_week AND end_week)
            OR
            (start_week BETWEEN $startWeek AND $endWeek)
        )
    ";
        // var_dump($sql);

        return mysqli_num_rows($this->__query($sql)) > 0;
    }
    // public function deleteHocPhanOnly($id)
    // {
    //     $sql = "DELETE FROM class_sessions WHERE id = $id";
    //     return $this->__query($sql);
    // }
    public function deleteHocPhanTrigger($id_buoihoc)
    {
        $session = $this->getByClass_sessionId($id_buoihoc);

        $courseClassId = $session['course_class_id'];

        $dayOfWeek = $session['day_of_week'];
        $this->__query("DELETE FROM class_sessions WHERE id=$id_buoihoc");

        $sql = "SELECT COUNT(*) as total 
            FROM class_sessions 
            WHERE course_class_id=$courseClassId
            AND day_of_week='$dayOfWeek'";

        $result = mysqli_fetch_assoc($this->__query($sql));

        // Nếu không còn buổi nào của thứ đó thì xóa timetable tương ứng
        if ($result['total'] == 0) {
            $sqlDelete = "DELETE FROM timetables
                      WHERE course_class_id=$courseClassId
                      AND day_of_week='$dayOfWeek'";

            $this->__query($sqlDelete);
        }
        return true;
    }
}
