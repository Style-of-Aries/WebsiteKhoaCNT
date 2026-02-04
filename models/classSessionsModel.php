<?php
require_once "./../config/database.php";

class classSessionsModel extends database
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
        // Lấy timetable + semester
        $sql = "
            SELECT t.*, s.start_date 
            FROM timetables t
            JOIN course_classes cc ON t.course_class_id = cc.id
            JOIN semesters s ON cc.semester_id = s.id
            WHERE t.course_class_id = $courseClassId
            LIMIT 1
        ";

        $result = $this->__query($sql);
        if (!$result || mysqli_num_rows($result) == 0) {
            return false;
        }

        $timetable = mysqli_fetch_assoc($result);
        
        $startWeek = $timetable['start_week'];
        $endWeek   = $timetable['end_week'];
        $targetDow = $timetable['day_of_week']; // 1 = Thứ 2
        $session   = $timetable['session'];
        $semesterStart = $timetable['start_date'];

        // 🔹 Tính ngày buổi đầu tiên đúng thứ
        $currentDow = date('N', strtotime($semesterStart));
        $offset = $targetDow - $currentDow;
        if ($offset < 0) $offset += 7;

        $firstSessionDate = strtotime("+$offset days", strtotime($semesterStart));

        // 🔹 Loop sinh từng tuần
        for ($week = $startWeek; $week <= $endWeek; $week++) {

            $sessionDate = date('Y-m-d', strtotime("+".($week - 1)." weeks", $firstSessionDate));

            // ❌ Check trùng buổi
            $checkSql = "
                SELECT id FROM class_sessions 
                WHERE course_class_id = $courseClassId 
                AND session_date = '$sessionDate'
            ";

            $exists = $this->__query($checkSql);

            if (mysqli_num_rows($exists) == 0) {

                // ✅ Insert session
                $insertSql = "
                    INSERT INTO class_sessions 
                    (course_class_id, session_date, day_of_week, session, week_number)
                    VALUES ($courseClassId, '$sessionDate', $targetDow, '$session', $week)
                ";

                $this->__query($insertSql);
            }
        }
        return true;
    }
}
