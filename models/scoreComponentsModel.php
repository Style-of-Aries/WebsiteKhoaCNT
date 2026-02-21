<?php
require_once "./../config/database.php";
class scoreComponentsModel
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

    public function add($course_class_id, $name, $type, $weight)
    {
        $sql =
            "INSERT INTO score_components
            (course_class_id, name, type, weight)
            VALUES ('$course_class_id', '$name', '$type', '$weight')";
        return $this->__query($sql);

    }
    public function getByCourseClass($course_class_id)
    {
        $sql = "
        SELECT id, name, type, weight
        FROM score_components
        WHERE course_class_id = $course_class_id
    ";

        return $this->__query($sql);
    }
    public function getComponentById($id)
    {
        $id = (int) $id;

        $sql = "SELECT * FROM score_components WHERE id = $id LIMIT 1";
        $result = $this->__query($sql);

        if (mysqli_num_rows($result) == 0) {
            return false;
        }

        return mysqli_fetch_assoc($result);
    }

}