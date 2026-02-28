<?php
ob_start();
?>


<form class="add-form" action="index.php?controller=user&action=edit" method="POST" enctype="multipart/form-data">
    <h2>Thêm người dùng mới</h2>

    <div>
        <label>Họ và tên</label>
        <input type="text" name="full_name" value="<?= $if_user['full_name'] ?>" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= $if_user['email'] ?>">
    </div>
    <label>Role</label>
    <select name="role" id="roleSelect" onchange="toggleDepartment()">
        <option value="training_office"
            <?= $user['role'] == 'training_office' ? 'selected' : '' ?>>
            Phòng đào tạo
        </option>

        <option value="lecturer"
            <?= $user['role'] == 'lecturer' ? 'selected' : '' ?>>
            Giảng viên
        </option>

        <option value="academic_affairs"
            <?= $user['role'] == 'academic_affairs' ? 'selected' : '' ?>>
            Học vụ
        </option>

        <option value="exam_office"
            <?= $user['role'] == 'exam_office' ? 'selected' : '' ?>>
            Khảo thí
        </option>

        <option value="student_affairs"
            <?= $user['role'] == 'student_affairs' ? 'selected' : '' ?>>
            Công tác SV
        </option>
    </select>

    <div class="col" id="department_id" 
     style="<?= ($user['role'] === 'lecturer') ? '' : 'display:none;' ?>">
    
    <label>Khoa</label>
    <select name="department_id">
        <option value="">-- Chọn Khoa --</option>

        <?php foreach ($department as $dept): ?>
            <option value="<?= $dept['id'] ?>"
                <?= ($if_user['department_id'] == $dept['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($dept['faculty_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

    <input type="submit" value="Lưu" name="btn_edit">
</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>