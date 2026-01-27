<?php
ob_start();
?>


<form class="add-form" action="index.php?controller=course_classes&action=add" method="POST" enctype="multipart/form-data">
    <h2>Thêm học phần mới</h2>

<!-- 
    <div>
        <label>Mã lớp</label>
        <input type="text" name="class_code" required>
    </div> -->

    <label>Môn học</label>
    <select name="subject_id" required>
        <?php foreach ($subject as $s): ?>
            <option value="<?= $s['id'] ?>"
                <?= isset($course_classes) && $course_classes['subject_id'] == $s['id'] ? 'selected' : '' ?>>
                <?= $s['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Giảng viên</label>
    <select name="lecturer_id" required>
        <?php foreach ($lecturer as $l): ?>
            <option value="<?= $l['id'] ?>"
                <?= isset($course_classes) && $course_classes['lecturer_id'] == $l['id'] ? 'selected' : '' ?>>
                <?= $l['full_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Học kỳ</label>
    <select name="semester_id" required>
        <?php foreach ($semester as $se): ?>
            <option value="<?= $se['id'] ?>"
                <?= isset($course_classes) && $course_classes['semester_id'] == $se['id'] ? 'selected' : '' ?>>
                <?= $se['name'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Sĩ số</label>
    <input type="number" name="max_students"
        value="<?= $course_classes['max_students'] ?? 60 ?>" required>
    
    <?php if (!empty($errorHocPhan))
            echo "<span style='color:red;'>$errorHocPhan</span><br>"; ?>    
    <input type="submit" value="Thêm học phần" name="btn_add">
</form>

<?php
$content = ob_get_clean();
include "../views/admin/layout.php";
?>