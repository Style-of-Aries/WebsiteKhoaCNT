<?php
class academicResultsModel
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

    public function calculateFinalResult($studentId, $courseClassId)
    {
        $sql = "
        SELECT sc.score, ssc.weight
        FROM student_component_scores sc
        JOIN subject_score_components ssc 
            ON sc.subject_component_id = ssc.id
        WHERE sc.student_id = $studentId
        AND sc.course_class_id = $courseClassId
    ";

        $result = $this->__query($sql);

        $finalScore = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            $finalScore += $row['score'] * ($row['weight'] / 100);
        }

        $finalScore = round($finalScore, 1);

        // Quy đổi điểm chữ + GPA
        if ($finalScore >= 8.5) {
            $letter = 'A';
            $gpa = 4.0;
            $status = 'pass';
        } elseif ($finalScore >= 8.0) {
            $letter = 'B+';
            $gpa = 3.5;
            $status = 'pass';
        } elseif ($finalScore >= 7.0) {
            $letter = 'B';
            $gpa = 3.0;
            $status = 'pass';
        } elseif ($finalScore >= 6.5) {
            $letter = 'C+';
            $gpa = 2.5;
            $status = 'pass';
        } elseif ($finalScore >= 5.5) {
            $letter = 'C';
            $gpa = 2.0;
            $status = 'pass';
        } elseif ($finalScore >= 5.0) {
            $letter = 'D+';
            $gpa = 1.5;
            $status = 'pass';
        } else {
            $letter = 'F';
            $gpa = 0;
            $status = 'fail';
        }

        // Insert or update academic_results
        $insert = "
        INSERT INTO academic_results 
        (student_id, course_class_id, final_score, letter_grade, gpa_4, result_status)
        VALUES ($studentId, $courseClassId, $finalScore, '$letter', $gpa, '$status')
        ON DUPLICATE KEY UPDATE
        final_score = VALUES(final_score),
        letter_grade = VALUES(letter_grade),
        gpa_4 = VALUES(gpa_4),
        result_status = VALUES(result_status),
        approval_status = 'DRAFT'
    ";

        return $this->__query($insert);
    }

    public function calculateGPA($studentId)
    {
        $sql = "
        SELECT ar.gpa_4, s.credits
        FROM academic_results ar
        JOIN course_classes cc ON ar.course_class_id = cc.id
        JOIN subjects s ON cc.subject_id = s.id
        WHERE ar.student_id = $studentId
        AND ar.approval_status = 'PUBLISHED'
    ";

        $result = $this->__query($sql);

        $totalCredits = 0;
        $totalPoints = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            $totalCredits += $row['credits'];
            $totalPoints += $row['gpa_4'] * $row['credits'];
        }

        if ($totalCredits == 0)
            return 0;

        return round($totalPoints / $totalCredits, 2);
    }

    public function getStudentGrades($student_id)
    {
        $sql = "
            SELECT 
                ar.course_class_id,
                sub.name AS subject_name,   -- sửa tại đây
                sub.subject_code,
                sub.credits,

                ssc.name AS component_name,
                ssc.type,
                scs.score,

                ar.final_score,
                ar.letter_grade

            FROM academic_results ar

            JOIN course_classes cc 
                ON ar.course_class_id = cc.id

            JOIN subjects sub 
                ON cc.subject_id = sub.id

            LEFT JOIN student_component_scores scs 
                ON scs.student_id = ar.student_id
                AND scs.course_class_id = ar.course_class_id

            LEFT JOIN subject_score_components ssc 
                ON ssc.id = scs.subject_component_id

            WHERE ar.student_id = '$student_id'
            AND ar.approval_status = 'PUBLISHED'

            ORDER BY ar.course_class_id, ssc.type
        ";

        return $this->__query($sql);
    }

    public function getScoreByStudentCode($student_id)
    {
        $sql = "
            SELECT 
                ar.course_class_id,
                sub.name AS subject_name,   -- sửa tại đây
                sub.subject_code,
                sub.credits,

                ssc.name AS component_name,
                ssc.type,
                scs.score,

                ar.final_score,
                ar.letter_grade

            FROM academic_results ar

            JOIN course_classes cc 
                ON ar.course_class_id = cc.id

            JOIN subjects sub 
                ON cc.subject_id = sub.id

            LEFT JOIN student_component_scores scs 
                ON scs.student_id = ar.student_id
                AND scs.course_class_id = ar.course_class_id

            LEFT JOIN subject_score_components ssc 
                ON ssc.id = scs.subject_component_id

            WHERE ar.student_id = '$student_id'

            ORDER BY ar.course_class_id, ssc.type
        ";

        return $this->__query($sql);
    }

    public function getStudentStatistics($student_id)
{
    $sql = "
        SELECT 
            SUM(sub.credits) AS total_credits,

            SUM(
                CASE 
                    WHEN ar.result_status = 'pass' 
                    THEN sub.credits 
                    ELSE 0 
                END
            ) AS passed_credits,

            SUM(ar.final_score * sub.credits) 
                / NULLIF(SUM(sub.credits),0) AS avg_score_10,

            SUM(ar.gpa_4 * sub.credits) 
                / NULLIF(SUM(sub.credits),0) AS avg_gpa_4

        FROM academic_results ar

        JOIN course_classes cc 
            ON ar.course_class_id = cc.id

        JOIN subjects sub 
            ON cc.subject_id = sub.id

        WHERE ar.student_id = '$student_id'
        AND ar.approval_status = 'PUBLISHED'
    ";

    return $this->__query($sql);
}
}