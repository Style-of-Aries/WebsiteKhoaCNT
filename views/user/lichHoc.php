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

    <!-- Select chọn tuần -->
    <select id="weekSelect" class="week-select">
        <option value="">--- Chọn tuần ---</option>
        <?php foreach ($weeks as $w): ?>
            <option value="<?= $w['from'] . '|' . $w['to'] ?>">
                <?= $w['label'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="tkb-grid">

        <!-- Header -->
        <div class="tkb-header"></div>
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
        foreach ($days as $d):
        ?>
            <div class="tkb-header"><?= $d ?></div>
        <?php endforeach; ?>

        <!-- ===== CA SÁNG ===== -->
        <div class="tkb-time">07:30 - 11:30</div>
        <?php foreach ($days as $dayKey => $dayLabel): ?>
            <div class="tkb-cell <?= !empty($schedule['Sáng'][$dayKey]) ? 'has-class' : '' ?>">
                <?php if (!empty($schedule['Sáng'][$dayKey])): ?>
                    <?php foreach ($schedule['Sáng'][$dayKey] as $item): ?>
                        <strong><?= htmlspecialchars($item['subject_name']) ?></strong>
                        <span><?= htmlspecialchars($item['room_name']) ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <!-- ===== CA CHIỀU ===== -->
        <div class="tkb-time">12:30 - 16:30</div>
        <?php foreach ($days as $dayKey => $dayLabel): ?>
            <div class="tkb-cell <?= !empty($schedule['Chiều'][$dayKey]) ? 'has-class' : '' ?>">
                <?php if (!empty($schedule['Chiều'][$dayKey])): ?>
                    <?php foreach ($schedule['Chiều'][$dayKey] as $item): ?>
                        <strong><?= htmlspecialchars($item['subject_name']) ?></strong>
                        <span><?= htmlspecialchars($item['room_name']) ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../admin/layout.php';
?>
