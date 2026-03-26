<?php
ob_start();
?>


<form class="add-form" action="index.php?controller=room&action=add" method="POST" enctype="multipart/form-data">
    <h2>Thêm phòng học mới</h2>

    <label for="">Tên phòng học</label>
    <input type="text" name="room_name"
        value="<?= htmlspecialchars($old['room_name'] ?? '') ?>" required>

    <?php if (!empty($errorName)): ?>
        <p style="color:red;"><?= $errorName ?></p>
    <?php endif; ?>

    <label for="">Tòa</label>
    <select name="building" required>
        <option value="">-- Chọn tòa --</option>
        <option value="A" <?= ($old['building'] ?? '') == 'A' ? 'selected' : '' ?>>Tòa A</option>
        <option value="B" <?= ($old['building'] ?? '') == 'B' ? 'selected' : '' ?>>Tòa B</option>
        <option value="C" <?= ($old['building'] ?? '') == 'C' ? 'selected' : '' ?>>Tòa C</option>
    </select>
    <label for="">Số lượng</label>
    <input type="text" name="capacity"
        value="<?= htmlspecialchars($old['capacity'] ?? '') ?>" required>


    <div>
        <label>Loại phòng</label>
        <select name="type" required>
            <!-- <option value="student">Sinh viên</option> -->
            <option value="theory">Phòng lý thuyết</option>
            <option value="lab">Phòng máy</option>
        </select>
    </div>


    <!-- <input type="submit" value="Thêm phòng học" name="btn_add"> -->
    <button name="btn_add" type="submit" class="btn-submit">
        Thêm phòng học
    </button>
</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>