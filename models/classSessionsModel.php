<?php
require_once "./../config/database.php";

class classSessionsModel
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

    public function getByCourseClassId($courseClassId)
    {
        $sql = "SELECT * FROM class_sessions
                WHERE course_class_id = $courseClassId
                ORDER BY session_date";
        return $this->__query($sql);
    }

    // ✅ SINH BUỔI HỌC TỰ ĐỘNG
    public function generateSessions($courseClassId)
    {
        $sql = "
        SELECT t.*, s.start_date 
        FROM timetables t
        JOIN course_classes cc ON t.course_class_id = cc.id
        JOIN semesters s ON cc.semester_id = s.id
        WHERE t.course_class_id = $courseClassId
        ORDER BY t.day_of_week
    ";

        $result = $this->__query($sql);
        if (!$result || mysqli_num_rows($result) == 0) {
            return false;
        }

        $timetable = mysqli_fetch_assoc($result);

        $startWeek = (int) $timetable['start_week'];
        $endWeek = (int) $timetable['end_week'];
        $targetDow = (int) $timetable['day_of_week']; // 1 = Thứ 2
        $session = $timetable['session'];
        $room = $timetable['room_id'];
        // $lecturer = $timetable['lecturer_id'];
        $semesterStart = $timetable['start_date'];

        // 🔹 Tìm ngày học đầu tiên đúng thứ trong tuần 1
        $date = new DateTime($semesterStart);

        while ($date->format('N') != $targetDow) {
            $date->modify('+1 day');
        }

        // 🔹 Nhảy đến tuần startWeek
        $date->modify('+' . (($startWeek - 1) * 7) . ' days');

        // 🔹 Sinh từng buổi
        for ($week = $startWeek; $week <= $endWeek; $week++) {

            $sessionDate = $date->format('Y-m-d');

            // Check trùng
            $checkSql = "
            SELECT id FROM class_sessions 
            WHERE course_class_id = $courseClassId 
            AND session_date = '$sessionDate'
        ";
            $exists = $this->__query($checkSql);

            if (mysqli_num_rows($exists) == 0) {

                $insertSql = "
                INSERT INTO class_sessions 
                (course_class_id, session_date, day_of_week, session, week_number,room_id)
                VALUES ($courseClassId, '$sessionDate', $targetDow, '$session', $week,$room)
            ";

                $this->__query($insertSql);
            }

            // ➕ sang tuần tiếp theo
            $date->modify('+7 days');
        }

        return true;
    }


}
