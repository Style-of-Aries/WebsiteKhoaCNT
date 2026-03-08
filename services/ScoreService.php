<?php
require_once '../models/attendanceModel.php';
class ScoreService
{
    protected $conn;
    protected $scoreModel;
    protected $componentModel;
    protected $academicResultsModel;
    protected $courseClassModel;
    protected $attendanceModel;
    protected $studentModel;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->academicResultsModel = new academicResultsModel($conn);
        $this->attendanceModel = new AttendanceModel($conn);
        $this->studentModel = new studentModel($conn);
        $this->scoreModel = new studentComponentScoresModel($conn);
        $this->componentModel = new subjectScoreComponentsModel($conn);
        $this->courseClassModel = new course_classesModel($conn);
    }

    public function saveScoreWithRule($studentId, $subjectComponentId, $courseClassId, $role, $scoreValue)
    {
        $component = $this->componentModel->getComponentById($subjectComponentId);

        if (!$component) {
            throw new Exception("Thành phần không tồn tại");
        }

        // 1️⃣ Check quyền
        if (!$this->scoreModel->canEditComponent($role, $component['type'])) {
            throw new Exception("Không có quyền nhập {$component['type']}");
        }

        $courseClass = $this->courseClassModel->getById($courseClassId);
        $subjectId = $courseClass['subject_id'];
        // Lấy cấu trúc điểm của môn
        $componentsResult = $this->componentModel->getBySubject($subjectId);

        $components = [];
        while ($row = mysqli_fetch_assoc($componentsResult)) {
            $components[] = $row;
        }

        // 2️⃣ Nếu là CK hoặc Project thì check điều kiện dự thi
        if (($component['type'] === 'CK' || $component['type'] === 'PROJECT') && count($components) > 1) {

            $eligibility = $this->scoreModel
                ->checkEligibility($studentId, $courseClassId);
            $studentprf = $this->studentModel->getAllProfile($studentId);
            $studentName = $studentprf['full_name'];
            $checkAttendance = $this->attendanceModel->checkAttendance($studentId, $courseClassId);
            if (!$checkAttendance) {
                throw new Exception("$studentName không đủ điều kiện chuyên cần (< 80%)");
            }
            if ($eligibility < 5) {
                throw new Exception("$studentName không đủ điều kiện dự thi");
            }
        }

        // 3️⃣ Lưu điểm
        $save = $this->scoreModel->saveScore(
            $studentId,
            $courseClassId,
            $subjectComponentId,
            $scoreValue
        );

        if (!$save) {
            throw new Exception("Lưu điểm thất bại");
        }

        // 4️⃣ Nếu là CK hoặc Project thì tính điểm tổng
        if ($component['type'] === 'CK' || $component['type'] === 'PROJECT') {

            if ($this->courseClassModel->checkAllFinalScoresEntered($courseClassId)) {
                $this->courseClassModel->updateFinished($courseClassId);
            }
            $this->academicResultsModel->calculateFinalResult($studentId, $courseClassId);
        }

        return true;
    }
    public function saveMultipleScores($scores, $courseClassId, $role)
    {
        $errors = [];
        $successCount = 0;

        foreach ($scores as $studentId => $components) {

            if (!ctype_digit((string) $studentId)) {
                $errors[] = "Student ID không hợp lệ: $studentId";
                continue;
            }

            foreach ($components as $subjectComponentId => $scoreValue) {

                if ($scoreValue === '')
                    continue;

                if (!ctype_digit((string) $subjectComponentId)) {
                    $errors[] = "Component ID không hợp lệ: $subjectComponentId";
                    continue;
                }

                if (!preg_match('/^(10|[0-9](\.[0-9])?)$/', $scoreValue)) {
                    $errors[] = "Điểm không hợp lệ (SV: $studentId)";
                    continue;
                }

                try {
                    $this->saveScoreWithRule(
                        $studentId,
                        $subjectComponentId,
                        $courseClassId,
                        $role,
                        round((float) $scoreValue, 1)
                    );

                    $successCount++;

                } catch (Exception $e) {
                    $errors[] = "SV $studentId: " . $e->getMessage();
                    error_log(
                        date('Y-m-d H:i:s') . " | " . $e->getMessage() . PHP_EOL,
                        3,
                        __DIR__ . "/../logs/error.log"
                    );
                }
            }
        }

        return [
            'errors' => $errors,
            'successCount' => $successCount
        ];
    }

    public function getEligibilityList($students, $classId)
    {
        $eligibilities = [];

        // Lấy thông tin lớp học phần
        $courseClass = $this->courseClassModel->getById($classId);
        $subjectId = $courseClass['subject_id'];

        // Lấy cấu trúc điểm của môn
        $componentsResult = $this->componentModel->getBySubject($subjectId);

        $components = [];
        while ($row = mysqli_fetch_assoc($componentsResult)) {
            $components[] = $row;
        }

        // 🔥 Nếu chỉ có 1 component và weight = 100% → MÔN ĐỒ ÁN
        if (count($components) == 1 && $components[0]['weight'] == 100) {

            foreach ($students as $student) {
                $eligibilities[$student['id']] = null; // Không áp dụng
            }

            return $eligibilities;
        }

        // ✅ Nếu là môn có điều kiện thi → kiểm tra bình thường
        foreach ($students as $student) {
            $eligibilities[$student['id']] =
                $this->scoreModel->checkEligibility($student['id'], $classId);
        }

        return $eligibilities;
    }
}