<?php
ob_start();
?>


<form class="add-form" action="index.php?controller=user&action=edit" method="POST" enctype="multipart/form-data">
    <h2>Sửa thông tin dùng mới</h2>

    <input type="hidden" name="id" value="<?= $if_user['id'] ?>">

    <div>
        <label>Họ và tên</label>
        <input type="text" name="full_name" value="<?= $if_user['full_name'] ?>" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= $if_user['email'] ?>">
    </div>
    <?php if (!empty($errorEmail)): ?>
        <p style="color:red;"><?= $errorEmail ?></p>
    <?php endif; ?>
    <label>Role</label>
    <input type="text" value="<?=
        $user['role'] == 'training_office' ? 'Phòng đào tạo' : ($user['role'] == 'lecturer' ? 'Giảng viên' : ($user['role'] == 'academic_affairs' ? 'Học vụ' : ($user['role'] == 'exam_office' ? 'Khảo thí' : ($user['role'] == 'student_affairs' ? 'Công tác SV' : ''))))
        ?>" disabled>

    <input type="hidden" name="role" value="<?= $user['role'] ?>">

    <div class="col" id="department_id" style="<?= ($user['role'] === 'lecturer') ? '' : 'display:none;' ?>">

        <label>Khoa</label>
        <select name="department_id" style="pointer-events: none;">
            <option value="">-- Chọn Khoa --</option>

            <?php foreach ($department as $dept): ?>
                <option value="<?= $dept['id'] ?>" <?= ($if_user['department_id'] == $dept['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dept['faculty_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button name="btn_edit" type="submit" class="btn-submit">
        Lưu
    </button>
</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>