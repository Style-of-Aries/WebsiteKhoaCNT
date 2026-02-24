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
}