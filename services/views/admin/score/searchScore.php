<?php
ob_start();
?>

<div class="admin-table-wrapper">
    <form class="searchScore" method="POST" action="index.php?controller=academicResult&action=searchScore">
        <button type="submit">
            <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img"
                aria-labelledby="search">
                <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9"
                    stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
        <input class="inputSearchScore" placeholder="Nhập mã sinh viên" required="" type="text" name="student_code">
        <button class="reset" type="reset">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </form>


    <div class="summary-box">
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>

            <?php if ($student): ?>

                <div class="student-info">
                    <h3><?= htmlspecialchars($student['full_name']) ?></h3>
                    <p>MSSV: <?= htmlspecialchars($student['student_code']) ?></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
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
include __DIR__ . '/../layoutNew.php';
?>