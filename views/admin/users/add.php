<?php
ob_start();
?>


<form class="add-form" action="index.php?controller=user&action=add" method="POST" enctype="multipart/form-data">
    <h2>Thêm người dùng mới</h2>

    <label for="">Họ và tên</label>
    <input type="text" name="full_name"
        value="<?= htmlspecialchars($old['full_name'] ?? '') ?>" required>

    <label for="">Email</label>
    <input type="email" name="email"
        value="<?= htmlspecialchars($old['email'] ?? '') ?>">

    <?php if (!empty($errorEmail)): ?>
        <p style="color:red;"><?= $errorEmail ?></p>
    <?php endif; ?>
    <div>
        <label>Role</label>
        <select name="role" id="roleSelect" onchange="toggleDepartment()">
            <!-- <option value="student">Sinh viên</option> -->
            <option value="training_office">Phòng đào tạo</option>
            <option value="lecturer">Giảng viên</option>
            <option value="academic_affairs">Học vụ</option>
            <option value="exam_office">Khảo thí</option>
            <option value="student_affairs">Công tác SV</option>
        </select>
    </div>
    <div class="col" id="department_id" style="display:none;">
        <label>Khoa</label>
        <select name="department_id">
            <option value="">-- Chọn Khoa --</option>

            <?php foreach ($department as $dept): ?>
                <option value="<?= $dept['id'] ?>" <?= ($old['department_id'] ?? '') == $dept['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dept['faculty_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <input type="submit" value="Thêm người dùng" name="btn_add">
</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>