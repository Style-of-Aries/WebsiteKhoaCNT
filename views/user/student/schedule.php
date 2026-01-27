<?php
ob_start();
?>

<style>
    
</style>
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
        <div class="tkb-header">Thứ 2</div>
        <div class="tkb-header">Thứ 3</div>
        <div class="tkb-header">Thứ 4</div>
        <div class="tkb-header">Thứ 5</div>
        <div class="tkb-header">Thứ 6</div>
        <div class="tkb-header">Thứ 7</div>
        <div class="tkb-header">Chủ nhật</div>

        <!-- Ca 1 -->
        <div class="tkb-time">07:30 - 11:30</div>
        <div class="tkb-cell has-class">
            <strong>Lập trình PHP</strong>
            <span>P301</span>
        </div>
        <div class="tkb-cell"></div>
        <div class="tkb-cell has-class">
            <strong>Cơ sở dữ liệu</strong>
            <span>P204</span>
        </div>
        <div class="tkb-cell"></div>
        <div class="tkb-cell"></div>
        <div class="tkb-cell has-class">
            <strong>Thực hành mạng</strong>
            <span>P401</span>
        </div>
        <div class="tkb-cell"></div>

        <!-- Ca 2 -->
        <div class="tkb-time">12:30 - 16:30</div>
        <div class="tkb-cell"></div>
        <div class="tkb-cell has-class">
            <strong>Thiết kế Web</strong>
            <span>P105</span>
        </div>
        <div class="tkb-cell"></div>
        <div class="tkb-cell has-class">
            <strong>Quản trị mạng</strong>
            <span>P402</span>
        </div>
        <div class="tkb-cell"></div>
        <div class="tkb-cell"></div>
        <div class="tkb-cell"></div>

    </div>
</div>


<?php
$content = ob_get_clean();
include __DIR__ . '/../../admin/layout.php';
?>