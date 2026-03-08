<?php

class AttendanceModel
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

    // Lấy điểm danh theo lớp học phần
    public function getAttendanceByCourseClass($courseClassId)
    {
        $sql = "
            SELECT a.student_id, a.session_id, a.status
            FROM attendance a
            JOIN class_sessions cs ON a.session_id = cs.id
            WHERE cs.course_class_id = $courseClassId
        ";

        return $this->__query($sql);
    }

    // Lưu điểm danh (DẠNG NGANG)
    public function saveAttendance($courseClassId, $attendanceData)
    {
        $success = true;

        foreach ($attendanceData as $studentId => $sessions) {

            foreach ($sessions as $sessionId => $status) {

                if ($status == '')
                    continue;

                // Kiểm tra tồn tại
                $checkSql = "
                    SELECT id FROM attendance 
                    WHERE student_id = $studentId 
                    AND session_id = $sessionId
                ";
                $check = $this->__query($checkSql);

                if (!$check) {
                    $success = false;
                    continue;
                }

                // Nếu đã tồn tại → UPDATE
                if (mysqli_num_rows($check) > 0) {

                    $updateSql = "
                        UPDATE attendance 
                        SET status = '$status'
                        WHERE student_id = $studentId 
                        AND session_id = $sessionId
                    ";

                    if (!$this->__query($updateSql)) {
                        $success = false;
                    }

                }
                // Nếu chưa có → INSERT
                else {
                    $insertSql = "
                        INSERT INTO attendance (student_id, session_id, status)
                        VALUES ($studentId, $sessionId, '$status')
                    ";

                    if (!$this->__query($insertSql)) {
                        $success = false;
                    }
                }
            }
        }

        return $success;
    }

    public function checkAttendance($studentId, $courseClassId)
    {
        $studentId = (int) $studentId;
        $courseClassId = (int) $courseClassId;
        $sql = "SELECT 
            COUNT(cs.id) AS total_sessions,
            SUM(
                CASE 
                    WHEN a.status IN ('present','late') THEN 1 
                    ELSE 0 
                END
            ) AS attended_sessions
        FROM class_sessions cs
        LEFT JOIN attendance a 
            ON cs.id = a.session_id 
            AND a.student_id = $studentId
        WHERE cs.course_class_id = $courseClassId";
        $result = $this->__query($sql);
        if (!$result) {
            return false;
        }

        $row = mysqli_fetch_assoc($result);

        $total = (int) $row['total_sessions'];
        $attended = (int) $row['attended_sessions'];

        if ($total == 0) {
            return false;
        }

        $percent = ($attended / $total) * 100;

        return $percent >= 80;
    }
}
