<?php
require_once "./../config/database.php";

class AttendanceModel extends database
{
    private $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
    }

    public function __query($sql)
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

                if ($status == '') continue;

                // Kiểm tra tồn tại
                $checkSql = "
                    SELECT id FROM attendance 
                    WHERE student_id = $studentId 
                    AND session_id = $sessionId
                    AND course_class_id = $courseClassId
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
                        AND course_class_id = $courseClassId
                    ";

                    if (!$this->__query($updateSql)) {
                        $success = false;
                    }

                } 
                // Nếu chưa có → INSERT
                else {

                    $insertSql = "
                        INSERT INTO attendance (student_id, session_id, course_class_id, status)
                        VALUES ($studentId, $sessionId, $courseClassId, '$status')
                    ";

                    if (!$this->__query($insertSql)) {
                        $success = false;
                    }
                }
            }
        }

        return $success;
    }
}
