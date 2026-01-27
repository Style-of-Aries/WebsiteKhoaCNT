<?php
require_once "./../config/database.php";
class resultModel extends database
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

    public function saveScore($studentId, $classId, $process, $mid, $final)
    {
        $check = $this->__query("
        SELECT id FROM academic_results
        WHERE student_id = '$studentId'
          AND course_class_id = '$classId'
        LIMIT 1
    ");

        if (mysqli_num_rows($check) > 0) {
            $sql = "
            UPDATE academic_results
            SET
                process_score = '$process',
                midterm_score = '$mid',
                final_exam_score = '$final'
            WHERE student_id = '$studentId'
              AND course_class_id = '$classId'
        ";
        } else {
            $sql = "
            INSERT INTO academic_results
            (student_id, course_class_id, process_score, midterm_score, final_exam_score)
            VALUES ('$studentId', '$classId', '$process', '$mid', '$final')
        ";
        }

        return $this->__query($sql);
    }

}