<?php ob_start(); ?>
<form class="add-form" action="index.php?controller=course_classes&action=add" method="POST">
    <h2>Thêm học phần mới</h2>

    <!-- Môn học -->
    <label>Môn học</label>
    <select name="subject_id" required>
        <option value="">-- Chọn môn học --</option>
        <?php foreach ($subject as $s): ?>
            <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <!-- Giảng viên -->
    <label>Giảng viên</label>
    <select name="lecturer_id" required>
        <option value="">-- Chọn giảng viên --</option>
        <?php foreach ($lecturer as $l): ?>
            <option value="<?= $l['id'] ?>"><?= $l['full_name'] ?></option>
        <?php endforeach; ?>
    </select>

    <!-- Học kỳ -->
    <!-- <label>Học kỳ</label>
    <select name="semester_id" required>
        <option value="">-- Chọn học kỳ --</option>
        <?php foreach ($semesters as $se): ?>
            <option value="<?= $se['id'] ?>"><?= $se['name'] ?> (<?= $se['academic_year'] ?>)</option>
        <?php endforeach; ?>
    </select> -->

    <!-- Sĩ số -->
    <label>Sĩ số tối đa</label>
    <input type="number" name="max_students" min="1" max="300" value="60" required>

    
    <!-- Thứ -->
    <label>Thứ</label>
    <select name="day_of_week" required>
        <option value="">-- Chọn thứ --</option>
        <option value="2">Thứ 2</option>
        <option value="3">Thứ 3</option>
        <option value="4">Thứ 4</option>
        <option value="5">Thứ 5</option>
        <option value="6">Thứ 6</option>
        <option value="7">Thứ 7</option>
    </select>

    <!-- Buổi -->
    <label>Buổi</label>
    <select name="session" required>
        <option value="">-- Chọn buổi --</option>
        <option value="Sáng">Sáng</option>
        <option value="Chiều">Chiều</option>
    </select>

    <!-- Phòng -->
    <label>Phòng học</label>
    <select name="room_id" required>
        <option value="">-- Chọn phòng --</option>
        <?php foreach ($rooms as $r): ?>
            <option value="<?= $r['id'] ?>">
                <?= $r['room_name'] ?> (<?= $r['building'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
<!-- <h3>
    Học kỳ:
    <?= date('d/m/Y', strtotime($semesterStart)) ?>
    -
    <?= date('d/m/Y', strtotime($semesterEnd)) ?>
</h3> -->

<label>Từ tuần</label>
<select name="start_week" required>
    <?php
    $start = new DateTime($semesterStart);

    for ($i = 1; $i <= $totalWeeks-1; $i++) {
        $weekStart = clone $start;
        $weekStart->modify('+' . ($i - 1) * 7 . ' days');

        $weekEnd = clone $weekStart;
        $weekEnd->modify('+6 days');
        ?>
        <option value="<?= $i ?>">
            Tuần <?= $i ?>
            (<?= $weekStart->format('d/m/Y') ?>
            –
            <?= $weekEnd->format('d/m/Y') ?>)
        </option>
    <?php } ?>
</select>

<br><br>

<label>Đến tuần</label>
<select name="end_week" required>
    <?php
    for ($i = 1; $i <= $totalWeeks-1; $i++) {
        $weekStart = clone $start;
        $weekStart->modify('+' . ($i - 1) * 7 . ' days');

        $weekEnd = clone $weekStart;
        $weekEnd->modify('+6 days');
        ?>
        <option value="<?= $i ?>">
            Tuần <?= $i ?>
            (<?= $weekStart->format('d/m/Y') ?>
            –
            <?= $weekEnd->format('d/m/Y') ?>)
        </option>
    <?php } ?>
</select>



    <?php if (!empty($errorHocPhan)): ?>
        <p style="color:red"><?= $errorHocPhan ?></p>
    <?php endif; ?>

    <input type="submit" name="btn_add" value="Thêm học phần">
</form>

<?php
$content = ob_get_clean();
include "../views/admin/layout.php";
?>

