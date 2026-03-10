<?php
class studentSemesterModel
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

    public function updateStatus($studentId, $semesterId, $status)
    {
        $studentId = (int) $studentId;
        $semesterId = (int) $semesterId;
        $status = mysqli_real_escape_string($this->connect, $status);

        // Kiểm tra đã có record chưa
        $checkSql = "SELECT id FROM student_semesters
                 WHERE student_id = $studentId
                 AND semester_id = $semesterId";

        $checkResult = $this->__query($checkSql);

        if (mysqli_num_rows($checkResult) == 0) {

            // Nếu chưa có → insert
            $insertSql = "INSERT INTO student_semesters (student_id, semester_id, status)
                      VALUES ($studentId, $semesterId, '$status')";

            return $this->__query($insertSql);

        } else {

            // Nếu đã có → update
            $updateSql = "UPDATE student_semesters
                      SET status = '$status'
                      WHERE student_id = $studentId
                      AND semester_id = $semesterId";

            return $this->__query($updateSql);
        }
    }
    public function getAcademicYear($studentId)
    {
        $studentId = (int) $studentId;

        $sql = "SELECT CEIL(COUNT(*) / 2) AS academic_year
            FROM student_semesters
            WHERE student_id = $studentId
            AND status = 'studying'";

        $result = $this->__query($sql);
        $row = mysqli_fetch_assoc($result);

        $year = (int) $row['academic_year'];

        return $year > 0 ? $year : 1;
    }

    public function createForNewSemester($semesterId)
    {
        $semesterId = (int) $semesterId;

        $sql = "
    INSERT INTO student_semesters (student_id, semester_id, status)
    SELECT s.id, $semesterId, 'studying'
    FROM student s
    JOIN student_profiles sp ON sp.student_id = s.id
    WHERE sp.status = 'Đang học'
    AND NOT EXISTS (
        SELECT 1
        FROM student_semesters ss
        WHERE ss.student_id = s.id
        AND ss.semester_id = $semesterId
    )";

        return $this->__query( $sql);
    }
}