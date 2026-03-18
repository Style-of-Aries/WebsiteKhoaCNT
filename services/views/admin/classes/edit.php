<?php
ob_start();
?>

<div class="container-main">
    <h2>Sửa thông tin lớp học:<?= $user['class_name'] ?> </h2>

    <form class="song-form" action="index.php?controller=classes&action=edit" method="POST"
        enctype="multipart/form-data">
        <input type="hidden" name="id" value=" <?= $user['id'] ?>">
        <div class="row">
            <div class="col">
                <label>Tên lớp học</label>
                <input type="text" name="class_name" placeholder="Tên lớp học" value="<?= $user['class_name'] ?>"
                    required>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label>Mã lớp</label>
                <input type="text" name="class_code" placeholder="Mã lớp" value="<?= $user['class_code'] ?>" required>
                <?php if (!empty($errorMaSv))
                    echo "<span style='color:red;'>$errorMaSv</span><br>"; ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label>Lớp</label>
                <select name="department_id" required>
                    <option value="">-- Chọn lớp --</option>

                    <?php foreach ($department as $class): ?>
                        <option value="<?= $class['id'] ?>" <?= ($class['id'] == $user['department_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($class['faculty_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <i class="fa-solid fa-school"></i>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label>Giáo viên chủ nghiệm</label>
                <select name="lecturer_id" required>
                    <option value="">-- Chọn giáo viên chủ nghiệm --</option>

                    <?php foreach ($lecturer as $class): ?>
                        <option value="<?= $class['id'] ?>" <?= ($class['id'] == $user['lecturer_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($class['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <i class="fa-solid fa-school"></i>
            </div>
        </div>

        <!-- <input type="submit" value="Sửa thông tin" name="btn_edit"> -->
        <button class="btn-submit" name="btn_edit" type="submit">Cập nhật lớp</button>
    </form>
</div>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>