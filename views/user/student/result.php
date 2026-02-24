<?php
ob_start();
?>

<div class="admin-table-wrapper">
    <h2>📊 Bảng điểm học tập</h2>
    <div class="summary-box">
        <p><b>🎓 GPA hệ 4:</b>
            <?= $statistics['avg_gpa_4'] !== null
                ? round($statistics['avg_gpa_4'], 1)
                : '-' ?>
        </p>

        <p><b>📘 TBC hệ 10:</b>
            <?= $statistics['avg_score_10'] !== null
                ? round($statistics['avg_score_10'], 1)
                : '-' ?>
        </p>

        <p><b>📚 Tổng tín chỉ đã tích lũy:</b>
            <?= $statistics['passed_credits'] ?? 0 ?>
        </p>
    </div>
    <table class="main-table grade-table">
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
            $currentCourse = null;

            $txList = [];
            $dkList = [];
            $finalExam = '-';

            if ($result && mysqli_num_rows($result) > 0):

                while ($row = mysqli_fetch_assoc($result)):

                    // Nếu chuyển sang môn mới → in môn cũ ra
                    if ($currentCourse !== null && $currentCourse != $row['course_class_id']) {
                        ?>
                        <tr>
                            <td><?= $stt++ ?></td>
                            <td><?= htmlspecialchars($subjectName) ?></td>
                            <td><?= htmlspecialchars($subjectCode) ?></td>
                            <td><?= $credits ?></td>

                            <td class="score-process">
                                <?php foreach ($txList as $tx): ?>
                                    <div>TX: <?= round($tx, 1) ?></div>
                                <?php endforeach; ?>

                                <?php foreach ($dkList as $dk): ?>
                                    <div>ĐK: <?= round($dk, 1) ?></div>
                                <?php endforeach; ?>
                            </td>

                            <td><?= $finalExam ?></td>

                            <!-- ĐIỂM TỔNG KẾT -->
                            <td>
                                <?= $finalScore !== null
                                    ? "<b>" . round($finalScore, 1) . "</b>"
                                    : '-' ?>
                            </td>

                            <td><?= $letterGrade ?? '-' ?></td>
                        </tr>
                        <?php
                        // Reset dữ liệu
                        $txList = [];
                        $dkList = [];
                        $finalExam = '-';
                    }

                    // Cập nhật môn hiện tại
                    $currentCourse = $row['course_class_id'];
                    $subjectName = $row['subject_name'];
                    $subjectCode = $row['subject_code'];
                    $credits = $row['credits'];
                    $finalScore = $row['final_score'];      // 🔥 LẤY TỪ academic_results
                    $letterGrade = $row['letter_grade'];

                    // Phân loại điểm
                    if ($row['type'] == 'TX') {
                        $txList[] = $row['score'];
                    }

                    if ($row['type'] == 'DK') {
                        $dkList[] = $row['score'];
                    }

                    if ($row['type'] == 'CK' || $row['type'] == 'PROJECT') {
                        $finalExam = $row['score'] !== null
                            ? round($row['score'], 1)
                            : '-';
                    }

                endwhile;

                // In môn cuối cùng
                ?>
                <tr>
                    <td><?= $stt++ ?></td>
                    <td><?= htmlspecialchars($subjectName) ?></td>
                    <td><?= htmlspecialchars($subjectCode) ?></td>
                    <td><?= $credits ?></td>

                    <td class="score-process">
                        <?php foreach ($txList as $tx): ?>
                            <div>TX: <?= round($tx, 1) ?></div>
                        <?php endforeach; ?>

                        <?php foreach ($dkList as $dk): ?>
                            <div>ĐK: <?= round($dk, 1) ?></div>
                        <?php endforeach; ?>
                    </td>

                    <td><?= $finalExam ?></td>

                    <!-- ĐIỂM TỔNG KẾT CUỐI -->
                    <td>
                        <?= $finalScore !== null
                            ? "<b>" . round($finalScore, 1) . "</b>"
                            : '-' ?>
                    </td>

                    <td><?= $letterGrade ?? '-' ?></td>
                </tr>

            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align:center;">
                        Chưa có dữ liệu điểm
                    </td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>