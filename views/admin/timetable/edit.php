<?php ob_start(); ?>

<form class="add-form"
    action="index.php?controller=timetable&action=edit"
    method="POST">

    <h2>Sửa thời khóa biểu</h2>

    <!-- ID học phần -->
    <input type="hidden" name="id" value="<?= $class_sessions['id'] ?>">
    <input  type="hidden"
        name="course_class_id"
        value="<?= $class_sessions['course_class_id'] ?>"
        >


    <!-- Môn học -->
    <label>Môn học</label>
    <select disabled name="subject_id">
        <?php foreach ($subject as $s): ?>
            <option value="<?= $s['id'] ?>"
                <?= $course_classes['id'] == $s['id'] ? 'selected' : '' ?>>
                <?= $s['subject_name'] ?> - <?= $s['class_code'] ?> - <?= $s['lecturer_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (!empty($errors['subject_id'])): ?>
        <small style="color:red"><?= $errors['subject_id'] ?></small>
    <?php endif; ?>
  
    

  


    <!-- Sĩ số -->
    


    <label>Ngày học</label>
    <input type="date" name="session_date" value="<?= $class_sessions['session_date'] ?>">

    <!-- Thứ -->
    <label>Thứ</label>
    <select name="day_of_week">
        <option value="">-- Chọn thứ --</option>
        <?php for ($i = 2; $i <= 7; $i++): ?>
            <option value="<?= $i ?>"
                <?= $class_sessions['day_of_week'] == $i ? 'selected' : '' ?>>
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
        <option value="Sáng" <?= $class_sessions['session'] == 'Sáng' ? 'selected' : '' ?>>Sáng</option>
        <option value="Chiều" <?= $class_sessions['session'] == 'Chiều' ? 'selected' : '' ?>>Chiều</option>
    </select>
    <?php if (!empty($errors['session'])): ?>
        <small style="color:red"><?= $errors['session'] ?></small>
    <?php endif; ?>


    <!-- Phòng -->
    <label>Phòng học</label>
    <select name="room_id">
        <?php foreach ($rooms as $r): ?>
            <option value="<?= $r['id'] ?>"
                <?= $class_sessions['room_id'] == $r['id'] ? 'selected' : '' ?>>
                <?= $r['room_name'] ?> (<?= $r['building'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (!empty($errors['room_id'])): ?>
        <small style="color:red"><?= $errors['room_id'] ?></small>
    <?php endif; ?>




    <input type="submit" name="btn_edit" value="Lưu ">

</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>