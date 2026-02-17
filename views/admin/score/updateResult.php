<?php
ob_start();
$role = $_SESSION['user']['role'];

?>

<div class="admin-table-wrapper">

    <div class="table-toolbar">
        <h2>📋 Danh sách sinh viên</h2>
        <input type="text" id="searchTable" placeholder="Tìm kiếm sinh viên...">
    </div>

    <form method="post" action="index.php?controller=lecturer&action=saveScores">

        <input type="hidden" name="class_id" value="<?= $_GET['course_class_id'] ?>">

        <div class="table-wrap">
            <table class="main-table" id="mainTable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>MSSV</th>
                        <th>Họ tên</th>
                        <th>Ngày sinh</th>
                        <th>Điểm TX</th>
                        <th>Điểm ĐK</th>
                        <th>Điểm thi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt = 1; ?>
                    <?php foreach ($students as $row): ?>

                        <?php
                        $credits = $row['subject_credits'] ?? 2;

                        if ($credits <= 2)
                            $numFrequentScores = 2;
                        elseif ($credits == 3)
                            $numFrequentScores = 3;
                        else
                            $numFrequentScores = 4;

                        $frequentScores = json_decode($row['frequent_scores'] ?? '[]', true);
                        $midScore = $row['midterm_score'];
                        $midValue = ($midScore === null) ? '' : round($midScore, 1);
                        $finalScore = $row['final_exam_score'];
                        $finalValue = ($finalScore === null) ? '' : round($finalScore, 1);
                        ?>

                        <tr>
                            <td><?= $stt++ ?></td>
                            <td><?= htmlspecialchars($row['student_code']) ?></td>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td><?= htmlspecialchars($row['date_of_birth']) ?></td>

                            <!-- Điểm thường xuyên -->
                            <td>
                                <div class="input-frequentScore">
                                    <?php for ($i = 1; $i <= $numFrequentScores; $i++): ?>

                                        <?php if ($role == 'lecturer'): ?>
                                            <input type="number" name="scores[<?= $row['student_id'] ?>][frequent][]"
                                                value="<?= $frequentScores[$i - 1] ?? '' ?>" step="0.1" min="0" max="10"
                                                class="score-input">
                                        <?php else: ?>
                                            <input type="number" value="<?= $frequentScores[$i - 1] ?? '' ?>" readonly
                                                class="score-input disabled-input">
                                        <?php endif; ?>

                                    <?php endfor; ?>
                                </div>
                            </td>

                            <!-- Điểm định kỳ -->
                            <td>
                                <?php if ($role == 'lecturer'): ?>
                                    <input type="number" name="scores[<?= $row['student_id'] ?>][mid]" value="<?= $midValue ?>"
                                        step="0.1" min="0" max="10" class="score-input">
                                <?php else: ?>
                                    <input type="number" value="<?= $midValue ?>" readonly class="score-input disabled-input">
                                <?php endif; ?>
                            </td>


                            <!-- Điểm thi -->
                            <td>
                                <?php if ($role == 'exam_office'): ?>
                                    <input type="number" name="scores[<?= $row['student_id'] ?>][final]"
                                        value="<?= $finalValue ?>" step="0.1" min="0" max="10" class="score-input final-input">
                                <?php else: ?>
                                    <input type="number" value="<?= $finalValue ?>" readonly class="score-input disabled-input">
                                <?php endif; ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <div class="save-score-wrapper">    
            <button class="att-btn" type="submit"> 
                <span>💾Lưu điểm</span>
            </button>
        </div>

    </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layoutNew.php';
?>