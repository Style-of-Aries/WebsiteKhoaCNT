<?php ob_start(); ?>
<div class="container-main">
    <h2>📚 Mở học kỳ mới</h2>
    <form method="POST" action="index.php?controller=semester&action=add">

        <div class="row">
            <!-- Tên học kỳ -->
            <div class="col">
                <label>Tên học kỳ</label>
                <select name="name" required>
                    <option value="">-- Chọn học kỳ --</option>
                    <option value="Học kì 1">Học kì 1</option>
                    <option value="Học kì 2">Học kì 2</option>
                    <!-- <option value="Hè">Hè</option> -->
                </select>
            </div>
        </div>
        <div class="row">
            <!-- Năm học -->
            <?php
            $year = date('Y');
            $nextYear = $year + 1;
            $defaultYear = $year . '-' . $nextYear;
            ?>
            <div class="col">
                <label>Năm học</label>
                <input type="text" name="academic_year" value="<?= $defaultYear ?>" placeholder="Ví dụ: 2025-2026"
                    pattern="\d{4}-\d{4}" required>
                <small>Định dạng: YYYY-YYYY</small>
            </div>
        </div>
        <div class="row">
            <!-- Ngày bắt đầu -->
            <div class="col">
                <label>Ngày bắt đầu</label>
                <input type="date" name="start_date" required>
            </div>
        </div>
        <div class="row">
            <!-- Ngày kết thúc -->
            <div class="col">
                <label>Ngày kết thúc</label>
                <input type="date" name="end_date" required>
            </div>
        </div>
        <button type="submit" class="btn-submit" name="btn_add">Tạo học kỳ</button>
    </form>
</div>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>