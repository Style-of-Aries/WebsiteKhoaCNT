<?php
ob_start();
?>
<div class="container-admin">
    <h2>📊 Bảng điểm học tập</h2>

    <table class="main-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Môn học</th>
                <th>Mã môn</th>
                <th>Số tín chỉ</th>
                <th>Điểm quá trình</th>
                <th>Điểm thi</th>
                <th>Điểm tổng kết</th>
                <th>Điểm chữ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stt = 1;
            while ($row = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                    <td><?= $stt++ ?></td>

                    <td><?= htmlspecialchars($row['subject_name']) ?></td>
                    <td><?= $row['subject_code'] ?></td>
                    <td><?= $row['credits'] ?></td>

                    <td>
                        TX: <?= $row['process_score'] ?? '-' ?><br>
                        GK: <?= $row['midterm_score'] ?? '-' ?>
                    </td>

                    <td><?= $row['final_exam_score'] ?? '-' ?></td>

                    <td>
                        <?php if ($row['final_grade'] !== null): ?>
                            <b><?= $row['final_grade'] ?></b>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>

                    <td>
                        <?= $row['grade_letter'] ?? '-' ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../admin/layout.php';
?>