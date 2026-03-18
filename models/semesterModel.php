<?php
require_once "./../config/database.php";
class semesterModel
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
    public function getAll()
    {
        $sql = "SELECT * FROM semesters s ORDER BY s.academic_year,s.semester_number";

        $query = $this->__query($sql);

        $data = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
        }

        return $data;
    }


    public function getActiveSemester()
    {
        $sql = "SELECT * FROM semesters WHERE is_active = 1 LIMIT 1";
        $query = $this->__query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function layHocKyDangHoatDong()
    {
        $sql = "SELECT * FROM semesters WHERE is_active = 1 LIMIT 1";
        return mysqli_fetch_assoc($this->__query($sql));
    }


    public function addMonHoc($name, $subject_code, $credits, $department_id)
    {

        $sql = "
            INSERT INTO subjects (subject_code, name, credits, department_id)
            VALUES ('$subject_code', '$name', '$credits','$department_id' )
        ";
        return $this->__query($sql);
    }
    public function editMonHoc($id, $name, $subject_code, $credits, $department_id)
    {

        $sql = "
            UPDATE subjects
        SET 
            name = '$name',
            subject_code = '$subject_code',
            credits = '$credits',
            department_id = '$department_id'
        WHERE id = '$id'
        ";
        return $this->__query($sql);
    }
    public function checkMonHoc($name, $id)
    {

        $sql = "Select *from subjects where name = '$name'AND id != '$id'
        LIMIT 1";
        $query = $this->__query($sql);
        if (mysqli_num_rows($query) > 0) {
            return true;
        }
    }

    public function getParents()
    {
        $sql = "SELECT id, name FROM department";
        return $this->__query($sql);
    }
    public function deleteMonHoc($id)
    {
        $sql = "delete from subjects where id= '$id'";
        return $this->__query($sql);
    }
    public function getById($id)
    {
        $id = (int) $id; // ép kiểu để tránh SQL injection

        $sql = "SELECT * FROM semesters WHERE id = $id";

        $result = $this->__query($sql);

        return mysqli_fetch_assoc($result);
    }

    public function addSemester($name, $academic_year, $semester_number, $start_date, $end_date)
    {
        $name = mysqli_real_escape_string($this->connect, $name);
        $academic_year = mysqli_real_escape_string($this->connect, $academic_year);
        $semester_number = (int) $semester_number;
        $start_date = mysqli_real_escape_string($this->connect, $start_date);
        $end_date = mysqli_real_escape_string($this->connect, $end_date);

        $sql = "INSERT INTO semesters (name, academic_year, semester_number, start_date, end_date, is_active)
            VALUES ('$name', '$academic_year', $semester_number, '$start_date', '$end_date', 0)";

        return $this->__query($sql);
    }

    public function semesterExists($academic_year, $semester_number)
    {
        $academic_year = mysqli_real_escape_string($this->connect, $academic_year);
        $semester_number = (int) $semester_number;

        $sql = "SELECT id 
            FROM semesters 
            WHERE academic_year='$academic_year' 
            AND semester_number=$semester_number";

        $result = mysqli_query($this->connect, $sql);

        return mysqli_num_rows($result) > 0;
    }
    public function updateSemester($id, $name, $academic_year, $semester_number, $start_date, $end_date)
    {
        $id = (int) $id;

        $sql = "UPDATE semesters 
            SET 
                name = '$name',
                academic_year = '$academic_year',
                semester_number = '$semester_number',
                start_date = '$start_date',
                end_date = '$end_date'
            WHERE id = $id";

        return $this->__query($sql);
    }
    public function deleteSemester($id)
    {
        $sql = "delete from semesters where id= '$id'";
        return $this->__query($sql);
    }
    public function activateSemester($id)
    {
        $id = (int) $id;

        $sql = "
        UPDATE semesters
        SET is_active = CASE 
            WHEN id = $id THEN 1
            ELSE 0
        END
    ";

        return $this->__query($sql);
    }
    public function deactivateSemester($id)
    {
        $id = (int) $id;

        $sql = "UPDATE semesters 
            SET is_active = 0
            WHERE id = $id";

        return $this->__query( $sql);
    }
}
