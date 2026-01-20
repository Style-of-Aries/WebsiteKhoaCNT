<?php
ob_start();
?>


<h2>Thêm giảng viên mới</h2>

<form class="add-form" action="index.php?controller=admin&action=addGv" method="POST" enctype="multipart/form-data">
    <div>
        <label>Họ và tên</label>
        <input type="text" name="full_name" required>
        <!-- <i class="fa-solid fa-user"></i> -->
        <!-- <small class="error" id="error-title"></small> -->
    </div>
    <div>
        <label>Mã giảng viên</label>
        <input type="text" name="lecturer_code" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <span>Khoa</span>
        <select name="department_id" required>
            <option value="">-- Chọn khoa --</option>

            <?php foreach ($department as $department): ?>
                <option value="<?= $department['id'] ?>">
                    <?= htmlspecialchars($department['faculty_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <i class="fa-solid fa-school"></i>
    </div>
    <div>
        <label>Tên đăng nhập</label>
        <input type="text" name="username" required>
    </div>
    <div class="form-group">
        <label>Mật khẩu</label>
        <input type="password" name="password" required>
    </div>
    <input type="submit" value="Thêm giảng viên" name="btn_add">
</form>
<?php
$content = ob_get_clean();
include "../views/admin/layout.php";
?>