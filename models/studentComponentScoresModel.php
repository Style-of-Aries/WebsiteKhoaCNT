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
        sc.id AS component_id,
        CASE 
    WHEN ROUND(scs.score,1) IN (0,10)
        THEN FORMAT(ROUND(scs.score,1),0)
    ELSE ROUND(scs.score,1)
END AS score
    FROM student_course_classes scc
    JOIN student s 
        ON s.id = scc.student_id
    JOIN score_components sc 
        ON sc.course_class_id = scc.course_class_id
    LEFT JOIN student_component_scores scs
        ON scs.student_id = s.id
        AND scs.component_id = sc.id
    WHERE scc.course_class_id = $course_class_id
    ORDER BY s.id, sc.id
";

        $result = $this->__query($sql);

        $scores = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $scores[$row['student_id']][$row['component_id']] = $row['score'];
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
    public function saveScore($studentId, $componentId, $scoreValue)
    {
        $studentId = (int) $studentId;
        $componentId = (int) $componentId;
        $scoreValue = (float) $scoreValue;

        $sql = "
        INSERT INTO student_component_scores (student_id, component_id, score)
        VALUES ($studentId, $componentId, $scoreValue)
        ON DUPLICATE KEY UPDATE score = $scoreValue
    ";

        return $this->__query($sql);
    }

}