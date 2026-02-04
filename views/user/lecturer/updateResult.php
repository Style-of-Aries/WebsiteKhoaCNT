<?php
ob_start();
?>

<div class="container-admin">
    <h2>Danh sách sinh viên</h2>

    <form method="post" action="index.php?controller=lecturer&action=saveScores">

        <input type="hidden" name="class_id" value="<?= $_GET['class_id'] ?>">

        <table class="main-table">
            <thead>
                <tr>
                    <th>MSSV</th>
                    <th>Họ tên</th>
                    <th>Ngày sinh</th>
                    <th>Điểm thường xuyên</th>
                    <th>Điểm định kỳ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($students)): ?>

                    <?php
                    // Lấy số tín chỉ
                    $credits = $row['subject_credits'] ?? 2;

                    // Quy tắc: tín chỉ → số điểm TX
                    if ($credits <= 2) {
                        $numFrequentScores = 2;
                    } elseif ($credits == 3) {
                        $numFrequentScores = 3;
                    } else {
                        $numFrequentScores = 4;
                    }
                    ?>

                    <tr>
                        <td><?= htmlspecialchars($row['student_code']) ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td><?= htmlspecialchars($row['date_of_birth']) ?></td>

                        <!-- Điểm thường xuyên -->
                        <?php
                        $frequentScores = json_decode($row['frequent_scores'] ?? '[]', true);
                        // echo '<pre>';
                        // print_r($row['frequent_scores']);
                        // echo '</pre>';
                        ?>

                        <td>
                            <div class="input-frequentScore">
                                <?php for ($i = 1; $i <= $numFrequentScores; $i++): ?>
                                    <input type="number" name="scores[<?= $row['student_id'] ?>][frequent][]"
                                        value="<?= $frequentScores[$i - 1] ?? '' ?>" step="0.1" min="0" max="10"
                                        class="score-input" placeholder="--" inputmode="decimal" title="Điểm từ 0 đến 10"
                                        oninput="
                                        if (this.value === '') return;
                                        if (this.value < 0) this.value = 0;
                                        if (this.value > 10) this.value = 10;
                                      ">
                                <?php endfor; ?>
                            </div>
                        </td>

                        <!-- Điểm định kỳ -->
                        <td>
                            <?php
                            $midScore = $row['midterm_score'];
                            $midValue = ($midScore === null) ? '' : round($midScore, 1);
                            ?>

                            <input type="number" name="scores[<?= $row['student_id'] ?>][mid]" value="<?= $midValue ?>"
                                step="0.1" min="0" max="10" class="score-input" placeholder="--" inputmode="decimal"
                                title="Điểm từ 0 đến 10">
                        </td>
                    </tr>

                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="save-score-wrapper">
            <button type="submit" class="btn-save-score">
                💾 Lưu điểm
            </button>
        </div>

    </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../admin/layout.php';
?>