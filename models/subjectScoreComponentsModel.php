<?php
class subjectScoreComponentsModel
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
    public function add($subject_id, $type, $weight)
    {
        $subject_id = (int) $subject_id;
        $weight = (int) $weight;
        // $name = trim($name);
        $type = trim($type);

        $allowedTypes = ['TX', 'DK', 'CK', 'PROJECT'];

        if (
            $subject_id <= 0 ||
            !in_array($type, $allowedTypes) ||
            $weight <= 0 || $weight > 100
        ) {
            return false;
        }

        $sql = "
        INSERT INTO subject_score_components    
        (subject_id, type, weight)
        VALUES ($subject_id, '$type', $weight)
    ";

        return $this->__query($sql);
    }

    public function getBySubject($subject_id)
    {
        $sql = "
        SELECT 
    id,
    type,
    weight,
    CASE type
        WHEN 'TX' THEN 'Thường xuyên'
        WHEN 'DK' THEN 'Định kỳ'
        WHEN 'CK' THEN 'Điểm thi'
        WHEN 'PROJECT' THEN 'Đồ án'
    END AS component_name
FROM subject_score_components
WHERE subject_id = $subject_id
ORDER BY id ASC;
    ";

        return $this->__query($sql);
    }
    public function getComponentById($id)
    {
        $id = (int) $id;

        $sql = "SELECT * FROM subject_score_components WHERE id = $id LIMIT 1";
        $result = $this->__query($sql);

        if (mysqli_num_rows($result) == 0) {
            return false;
        }

        return mysqli_fetch_assoc($result);
    }

    public function deleteBySubjectId($subjectId)
    {
        $sql = "delete from subject_score_components where subject_id= '$subjectId'";
        return $this->__query($sql);
    }
}