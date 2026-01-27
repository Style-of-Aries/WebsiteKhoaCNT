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

    public function getAllResult($studentId)
    {
        $sql = "
        SELECT
            sub.subject_code,
            sub.name AS subject_name,
            sub.credits,
            cc.class_code,
            se.name AS semester_name,
            se.academic_year,
            ar.process_score,
            ar.midterm_score,
            ar.final_exam_score,
            ar.final_grade,
            ar.grade_letter,
            ar.result
        FROM student_course_classes scc
        JOIN course_classes cc ON scc.course_class_id = cc.id
        JOIN subjects sub ON cc.subject_id = sub.id
        JOIN semesters se ON cc.semester_id = se.id
        LEFT JOIN academic_results ar
            ON ar.student_id = scc.student_id
           AND ar.course_class_id = scc.course_class_id
        WHERE scc.student_id = $studentId
        ORDER BY se.academic_year DESC, se.semester_number DESC
    ";
        return $this->__query($sql);
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