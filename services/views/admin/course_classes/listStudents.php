<?php
ob_start();

// Convert mysqli_result nếu cần
if ($students instanceof mysqli_result) {
    $students = $students->fetch_all(MYSQLI_ASSOC);
}

// Nhận filter
$filter = $_GET['filter'] ?? 'all';

// Tổng SV
$totalStudents = count($students);

// ===== PRE-CALC STATS =====
$totalAllowed = 0;
$totalBanned = 0;

foreach ($students as $sv) {
    $attended = (int) ($sv['attended_sessions'] ?? 0);
    $total = (int) ($sv['total_sessions'] ?? 0);
    $process = (float) ($sv['process_score'] ?? 0);
    $mid = (float) ($sv['midterm_score'] ?? 0);

    $rate = ($total > 0) ? ($attended / $total) * 100 : 0;
    $avg = ($process + $mid) / 2;

    if ($rate >= 80 && $avg >= 4)
        $totalAllowed++;
    else
        $totalBanned++;
}
?>

<div class="container-admin">
    <h2>📊 Danh sách xét điều kiện thi</h2>

    <!-- ===== STATS ===== -->
    <div class="stats-box" data-allowed="<?= $totalAllowed ?>" data-banned="<?= $totalBanned ?>">

        <div class="stat total">👨‍🎓 Tổng SV: <?= $totalStudents ?></div>
        <div class="stat allowed">✅ Đủ điều kiện: <span id="count-allowed">0</span></div>
        <div class="stat banned">❌ Cấm thi: <span id="count-banned">0</span></div>
    </div>

    <!-- ===== CHART ===== -->
    <!-- <div class="chart-box">
        <canvas id="examChart"></canvas>
    </div> -->

    <!-- ===== FILTER ===== -->
    <form method="GET" class="filter-form">
        <input type="hidden" name="course_class_id" value="<?= $_GET['course_class_id'] ?? '' ?>">
        <input type="hidden" name="controller" value="lecturer">
        <input type="hidden" name="action" value="getStudentsWithExamConditions">

        <label>Lọc trạng thái:</label>
        <select name="filter" onchange="this.form.submit()">
            <option value="all" <?= $filter == 'all' ? 'selected' : '' ?>>Tất cả</option>
            <option value="allowed" <?= $filter == 'allowed' ? 'selected' : '' ?>>Được thi</option>
            <option value="banned" <?= $filter == 'banned' ? 'selected' : '' ?>>Cấm thi</option>
        </select>

        <!-- <button type="submit">Lọc</button> -->
    </form>


    <!-- ===== TABLE ===== -->
    <div class="table-wrapper">
        <table class="main-table">
            <thead>
                <tr>
                    <!-- <th>STT</th> -->
                    <th>Mã SV</th>
                    <th class="thName">Họ tên</th>
                    <th>Số buổi học</th>
                    <th>Số buổi đi học</th>
                    <th>Chuyên cần (%)</th>
                    <th>Điểm TX</th>
                    <th>Điểm ĐK</th>
                    <th>TB xét thi</th>
                    <th>Trạng thái</th>
                    <th>Lý do</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $i = 1;
                foreach ($students as $sv):

                    $attended = (int) ($sv['attended_sessions'] ?? 0);
                    $total = (int) ($sv['total_sessions'] ?? 0);
                    $process = (float) ($sv['process_score'] ?? 0);
                    $mid = (float) ($sv['midterm_score'] ?? 0);

                    $rate = ($total > 0) ? ($attended / $total) * 100 : 0;
                    $avg = round(($process + $mid) / 2, 1);

                    $isAllowed = ($rate >= 80 && $avg >= 4);

                    // FILTER
                    if ($filter == 'allowed' && !$isAllowed)
                        continue;
                    if ($filter == 'banned' && $isAllowed)
                        continue;

                    // Lý do
                    $reasons = [];
                    if ($rate < 80)
                        $reasons[] = "Thiếu chuyên cần";
                    if ($avg < 4)
                        $reasons[] = "Điểm TB thấp";

                    $reasonText = empty($reasons) ? "Hợp lệ" : implode(", ", $reasons);
                    ?>
                    <tr class="<?= !$isAllowed ? 'row-banned' : '' ?>">
                        <!-- <td><?= $i++ ?></td> -->
                        <td><?= htmlspecialchars($sv['student_code']) ?></td>
                        <td class="tdName"><?= htmlspecialchars($sv['full_name']) ?></td>
                        <td><?= $total ?></td>
                        <td><?= $attended ?></td>
                        <td><?= round($rate, 1) ?>%</td>
                        <td><?= round($process, 1) ?></td>
                        <td><?= round($mid, 1) ?></td>
                        <td><strong><?= $avg ?></strong></td>

                        <td>
                            <?php if ($isAllowed): ?>
                                <span class="status allowed">✅ Được thi</span>
                            <?php else: ?>
                                <span class="status banned">❌ Cấm thi</span>
                            <?php endif; ?>
                        </td>

                        <td class="reason"><?= $reasonText ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>