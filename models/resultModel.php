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


    public function saveScore($studentId, $classId, $frequentJson, $process, $mid, $final, $role)
    {
        $processSql = ($process === null || $process === '') ? "NULL" : $process;
        $midSql = ($mid === null || $mid === '') ? "NULL" : $mid;
        $finalSql = ($final === null || $final === '') ? "NULL" : $final;

        $check = $this->__query("
        SELECT id FROM academic_results
        WHERE student_id = '$studentId'
          AND course_class_id = '$classId'
        LIMIT 1
    ");

        if (mysqli_num_rows($check) > 0) {

            if ($role == 'lecturer') {

                // 👨‍🏫 Giảng viên chỉ được sửa TX + giữa kỳ
                $sql = "
                UPDATE academic_results
                SET
                    frequent_scores = '$frequentJson',
                    process_score   = $processSql,
                    midterm_score   = $midSql
                WHERE student_id = '$studentId'
                  AND course_class_id = '$classId'
            ";

            } elseif ($role == 'exam_office') {

                // 📝 Khảo thí chỉ được sửa điểm thi
                $sql = "
                UPDATE academic_results
                SET
                    final_exam_score = $finalSql
                WHERE student_id = '$studentId'
                  AND course_class_id = '$classId'
            ";
            }

        } else {

            // Nếu chưa tồn tại thì insert đầy đủ
            $sql = "
            INSERT INTO academic_results
            (student_id, course_class_id, frequent_scores, process_score, midterm_score, final_exam_score)
            VALUES ('$studentId', '$classId', '$frequentJson', $processSql, $midSql, $finalSql)
        ";
        }

        return $this->__query($sql);
    }




}