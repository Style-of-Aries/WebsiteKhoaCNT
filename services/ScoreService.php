<?php
class ScoreService
{
    protected $conn;
    protected $scoreModel;
    protected $componentModel;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->scoreModel = new studentComponentScoresModel($conn);
        $this->componentModel = new subjectScoreComponentsModel($conn);
    }

    public function saveScoreWithRule($studentId, $subjectComponentId, $courseClassId, $role, $scoreValue)
    {
        $component = $this->componentModel->getComponentById($subjectComponentId);

        if (!$component) {
            throw new Exception("Thành phần không tồn tại");
        }

        // Check quyền
        if (!$this->scoreModel->canEditComponent($role, $component['type'])) {
            throw new Exception("Không có quyền nhập {$component['type']}");
        }

        // Nếu là CK hoặc weight > 50%
        if ($component['weight'] >= 50) {

            $eligibility = $this->scoreModel
                ->checkEligibility($studentId, $courseClassId);

            if ($eligibility < 5) {
                throw new Exception("SV $studentId không đủ điều kiện dự thi");
            }
        }

        return $this->scoreModel->saveScore(
            $studentId,
            $courseClassId,
            $subjectComponentId,
            $scoreValue
        );
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
                }
            }
        }

        return [
            'errors' => $errors,
            'successCount' => $successCount
        ];
    }
}