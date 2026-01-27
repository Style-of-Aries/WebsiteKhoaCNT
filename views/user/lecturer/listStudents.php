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
                    <th>Quá trình</th>
                    <th>Giữa kỳ</th>
                    <th>Cuối kỳ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($students)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['student_code']) ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td>
                            <input type="number" name="scores[<?= $row['student_id'] ?>][process]"
                                value="<?= $row['process_score'] ?>" step="0.1" min="0" max="10" class="score-input"
                                placeholder="—" inputmode="decimal" title="Điểm từ 0 đến 10" oninput="
        if (this.value === '') return;
        if (this.value < 0) this.value = 0;
        if (this.value > 10) this.value = 10;
    ">
                        </td>
                        <td>
                            <input type="number" name="scores[<?= $row['student_id'] ?>][mid]"
                                value="<?= $row['midterm_score'] ?>" step="0.1" min="0" max="10" class="score-input"
                                placeholder="—" inputmode="decimal" title="Điểm từ 0 đến 10" oninput="
        if (this.value === '') return;
        if (this.value < 0) this.value = 0;
        if (this.value > 10) this.value = 10;
    ">
                        </td>
                        <td>
                            <input type="number" name="scores[<?= $row['student_id'] ?>][final]"
                                value="<?= $row['final_exam_score'] ?>" step="0.1" min="0" max="10" class="score-input"
                                placeholder="—" inputmode="decimal" title="Điểm từ 0 đến 10" oninput="
        if (this.value === '') return;
        if (this.value < 0) this.value = 0;
        if (this.value > 10) this.value = 10;
    ">
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