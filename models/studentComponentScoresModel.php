<?php
class studentComponentScoresModel
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

    public function getScores($course_class_id)
    {
        $course_class_id = (int) $course_class_id;

        $sql = "
    SELECT 
    s.id AS student_id,
    ssc.id AS subject_component_id,
    CASE 
        WHEN ROUND(scs.score,1) IN (0,10)
            THEN FORMAT(ROUND(scs.score,1),0)
        ELSE ROUND(scs.score,1)
    END AS score
FROM student_course_classes scc

JOIN student s 
    ON s.id = scc.student_id

JOIN course_classes cc
    ON cc.id = scc.course_class_id

JOIN subject_score_components ssc
    ON ssc.subject_id = cc.subject_id

LEFT JOIN student_component_scores scs
    ON scs.student_id = s.id
    AND scs.subject_component_id = ssc.id

WHERE scc.course_class_id = $course_class_id

ORDER BY s.id, ssc.id
";

        $result = $this->__query($sql);

        $scores = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $scores[$row['student_id']][$row['subject_component_id']] = $row['score'];
        }

        return $scores;
    }

    public function canEditComponent($role, $type)
    {
        $map = [
            'admin' => ['TX', 'DK', 'CK', 'PROJECT'],
            'lecturer' => ['TX', 'DK', 'PROJECT'],
            'exam_office' => ['CK']
        ];

        return in_array($type, $map[$role] ?? []);
    }

    public function saveScore($studentId, $courseClassId, $subjectComponentId, $scoreValue)
    {
        $studentId = (int) $studentId;
        $courseClassId = (int) $courseClassId;
        $subjectComponentId = (int) $subjectComponentId;
        $scoreValue = (float) $scoreValue;

        $sql = "
        INSERT INTO student_component_scores 
        (student_id, course_class_id, subject_component_id, score)
        VALUES ($studentId, $courseClassId, $subjectComponentId, $scoreValue)
        ON DUPLICATE KEY UPDATE score = $scoreValue
    ";

        return $this->__query($sql);
    }

    public function checkEligibility($studentId, $courseClassId)
    {
        $studentId = (int) $studentId;
        $courseClassId = (int) $courseClassId;

        $sql = "
        SELECT 
    SUM(scs.score * sc.weight) / 40 AS eligibility_score
FROM student_component_scores scs
JOIN subject_score_components sc 
    ON sc.id = scs.subject_component_id
WHERE scs.course_class_id = $courseClassId
AND scs.student_id = $studentId
AND sc.type IN ('TX','DK')
    ";

        $result = $this->__query($sql);
        $row = mysqli_fetch_assoc($result);

        return $row['eligibility_score'];
    }

}