<?php
ob_start();

/**
 * Chuẩn hoá dữ liệu: $schedule[session][day_of_week]
 */
$schedule = [];
foreach ($timetables as $row) {
    $schedule[$row['session']][$row['day_of_week']][] = $row;
}
?>

<div class="card">
    <h2 class="card-title">Thời khóa biểu</h2>

    <form method="get" class="selectWeek">
        <input type="hidden" name="controller" value="lecturer">
        <input type="hidden" name="action" value="lichDayGv">

        <select name="week" class="week-select">
            <option value="">--- Chọn tuần ---</option>
            <?php foreach ($weeks as $index => $w): ?>
                <?php $weekNumber = $index + 1; ?>
                <option value="<?= $weekNumber ?>" <?= (isset($_GET['week']) && $_GET['week'] == $weekNumber) ? 'selected' : '' ?>>
                    <?= $w['label'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn-search">Tìm kiếm</button>
    </form>



    <div class="tkb-grid">

        <?php
        $days = [
            2 => 'Thứ 2',
            3 => 'Thứ 3',
            4 => 'Thứ 4',
            5 => 'Thứ 5',
            6 => 'Thứ 6',
            7 => 'Thứ 7',
            8 => 'Chủ nhật'
        ];
        ?>

        <div class="tkb-header"></div>
        <?php foreach ($days as $d): ?>
            <div class="tkb-header"><?= $d ?></div>
        <?php endforeach; ?>

        <!-- ===== SÁNG ===== -->
        <div class="tkb-time">
            <span>07:30</span>
            <span class="dash">—</span>
            <span>11:30</span>
        </div>

        <?php foreach ($days as $dayKey => $dayLabel): ?>
            <div class="tkb-cell <?= !empty($schedule['Sáng'][$dayKey]) ? 'has-class' : '' ?>">
                <?php if (!empty($schedule['Sáng'][$dayKey])): ?>
                    <?php foreach ($schedule['Sáng'][$dayKey] as $item): ?>
                        <div class="tkb-item">
                            <strong><?= htmlspecialchars($item['subject_name']) ?></strong><br>
                            <span>Phòng: <?= htmlspecialchars($item['room_name']) ?></span><br>
                            <?php if (!empty($item['admin_classes'])): ?>
                                <span class="tkb-class">
                                    <?= htmlspecialchars($item['admin_classes']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <!-- ===== CHIỀU ===== -->
        <div class="tkb-time">
            <span>12:30</span>
            <span class="dash">—</span>
            <span>16:30</span>
        </div>
        <?php foreach ($days as $dayKey => $dayLabel): ?>
            <div class="tkb-cell">
                <?php if (!empty($schedule['Chiều'][$dayKey])): ?>
                    <?php foreach ($schedule['Chiều'][$dayKey] as $item): ?>
                        <strong><?= htmlspecialchars($item['subject_name']) ?></strong>
                        <!-- <div>Lớp: <?= htmlspecialchars($item['class_code']) ?></div> -->
                        <div>Phòng: <?= htmlspecialchars($item['room_name']) ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    </div>

</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../admin/layout.php';
?>