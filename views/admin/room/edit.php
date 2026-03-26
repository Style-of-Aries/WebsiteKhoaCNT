<?php
ob_start();
?>


<form class="add-form" action="index.php?controller=room&action=edit" method="POST" enctype="multipart/form-data">
    <h2>Sửa thông tin phòng học</h2>

    <input type="hidden" name="id" value="<?= $rooms['id'] ?>">

    <div>
        <label>Tên phòng học</label>
        <input type="text" name="room_name" value="<?= $rooms['room_name'] ?>" required>
    </div>
    <div>
        <label>Tòa</label>
        <select name="building" required>
            <option value="A" <?= $rooms['building'] == 'A' ? 'selected' : '' ?>>Tòa A</option>
            <option value="B" <?= $rooms['building'] == 'B' ? 'selected' : '' ?>>Tòa B</option>
            <option value="C" <?= $rooms['building'] == 'C' ? 'selected' : '' ?>>Tòa C</option>
        </select>
    </div>
    <div>
        <label>Số lượng</label>
        <input type="text" name="capacity" value="<?= $rooms['capacity'] ?>">
    </div>

    <label>Loại phòng</label>
    <select name="type" required>
        <option value="theory" <?= $rooms['type'] == 'theory' ? 'selected' : '' ?>>
            Phòng lý thuyết
        </option>
        <option value="lab" <?= $rooms['type'] == 'lab' ? 'selected' : '' ?>>
            Phòng máy
        </option>
    </select>
    <?php if (!empty($errorName)): ?>
        <p style="color:red;"><?= $errorName ?></p>
    <?php endif; ?>

    <!-- <input type="submit" value="Lưu" name="btn_edit"> -->
    <button name="btn_edit" type="submit" class="btn-submit">
        Lưu
    </button>
</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>