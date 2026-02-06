<?php ob_start(); ?>

<form class="add-form"
    action="index.php?controller=course_classes&action=edit"
    method="POST">

    <h2>Sửa học phần: <?= $course_classes['class_code'] ?></h2>

    <!-- ID học phần -->
    <input type="hidden" name="id" value="<?= $course_classes['id'] ?>">

    <!-- Mã lớp -->
    <label>Mã lớp</label>
    <input type="text"
        name="class_code"
        value="<?= $course_classes['class_code'] ?>"
        readonly>

    <!-- Môn học -->
    <label>Môn học</label>
    <select name="subject_id">
        <?php foreach ($subject as $s): ?>
            <option value="<?= $s['id'] ?>"
                <?= $course_classes['subject_id'] == $s['id'] ? 'selected' : '' ?>>
                <?= $s['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (!empty($errors['subject_id'])): ?>
        <small style="color:red"><?= $errors['subject_id'] ?></small>
    <?php endif; ?>


    <!-- Giảng viên -->
    <label>Giảng viên</label>
    <select name="lecturer_id">
        <?php foreach ($lecturer as $l): ?>
            <option value="<?= $l['id'] ?>"
                <?= $course_classes['lecturer_id'] == $l['id'] ? 'selected' : '' ?>>
                <?= $l['full_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (!empty($errors['lecturer_id'])): ?>
        <small style="color:red"><?= $errors['lecturer_id'] ?></small>
    <?php endif; ?>


    <!-- Sĩ số -->
    <label>Sĩ số tối đa</label>
    <input type="number"
        name="max_students"
        value="<?= $course_classes['max_students'] ?>">
    <?php if (!empty($errors['max_students'])): ?>
        <small style="color:red"><?= $errors['max_students'] ?></small>
    <?php endif; ?>


    <!-- Thứ -->
    <label>Thứ</label>
    <select name="day_of_week">
        <option value="">-- Chọn thứ --</option>
        <?php for ($i = 2; $i <= 7; $i++): ?>
            <option value="<?= $i ?>"
                <?= $timetable['day_of_week'] == $i ? 'selected' : '' ?>>
                Thứ <?= $i ?>
            </option>
        <?php endfor; ?>
    </select>
    <?php if (!empty($errors['day_of_week'])): ?>
        <small style="color:red"><?= $errors['day_of_week'] ?></small>
    <?php endif; ?>


    <!-- Buổi -->
    <label>Buổi</label>
    <select name="session">
        <option value="">-- Chọn buổi --</option>
        <option value="Sáng" <?= $timetable['session'] == 'Sáng' ? 'selected' : '' ?>>Sáng</option>
        <option value="Chiều" <?= $timetable['session'] == 'Chiều' ? 'selected' : '' ?>>Chiều</option>
    </select>
    <?php if (!empty($errors['session'])): ?>
        <small style="color:red"><?= $errors['session'] ?></small>
    <?php endif; ?>


    <!-- Phòng -->
    <label>Phòng học</label>
    <select name="room_id">
        <?php foreach ($rooms as $r): ?>
            <option value="<?= $r['id'] ?>"
                <?= $timetable['room_id'] == $r['id'] ? 'selected' : '' ?>>
                <?= $r['room_name'] ?> (<?= $r['building'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (!empty($errors['room_id'])): ?>   
        <small style="color:red"><?= $errors['room_id'] ?></small>
    <?php endif; ?>


    <!-- Tuần học -->
    <label>Từ tuần</label>
    <select name="start_week">
        <?php
        $start = new DateTime($semesterStart);
        for ($i = 1; $i <= $totalWeeks - 1; $i++):
            $weekStart = clone $start;
            $weekStart->modify('+' . ($i - 1) * 7 . ' days');
            $weekEnd = clone $weekStart;
            $weekEnd->modify('+6 days');
        ?>
            <option value="<?= $i ?>"
                <?= $timetable['start_week'] == $i ? 'selected' : '' ?>>
                Tuần <?= $i ?> (<?= $weekStart->format('d/m/Y') ?> – <?= $weekEnd->format('d/m/Y') ?>)
            </option>
        <?php endfor; ?>
    </select>

    <label>Đến tuần</label>
    <select name="end_week">
        <?php
        $start = new DateTime($semesterStart);
        for ($i = 1; $i <= $totalWeeks - 1; $i++):
            $weekStart = clone $start;
            $weekStart->modify('+' . ($i - 1) * 7 . ' days');

            $weekEnd = clone $weekStart;
            $weekEnd->modify('+6 days');
        ?>
            <option value="<?= $i ?>"
                <?= $timetable['end_week'] == $i ? 'selected' : '' ?>>
                Tuần <?= $i ?>
                (<?= $weekStart->format('d/m/Y') ?>
                – <?= $weekEnd->format('d/m/Y') ?>)
            </option>
        <?php endfor; ?>
    </select>

    <?php if (!empty($errors['week'])): ?>
        <small style="color:red"><?= $errors['week'] ?></small>
    <?php endif; ?>




    <input type="submit" name="btn_edit" value="Lưu ">

</form>

<?php
$content = ob_get_clean();
include "../views/admin/layout.php";
?>