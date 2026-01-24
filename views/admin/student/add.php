<?php
ob_start();
?>


<form class="add-form" action="index.php?controller=admin&action=add" method="POST" enctype="multipart/form-data">
    <h2>Thêm sinh viên mới</h2>

    <!-- Avatar -->
    <div>
        <label>Ảnh đại diện</label>
        <input type="file" name="avatar" accept="image/*">
    </div>

    <!-- Họ tên -->
    <div>
        <label>Họ và tên</label>
        <input type="text" name="full_name" required>
    </div>

    <!-- Mã sinh viên -->
    <div>
        <label>Mã sinh viên</label>
        <input type="text" name="student_code" required>
    </div>
    <!-- Giới tính -->
    <div>
        <label>Giới tính</label>
        <input type="text" name="gender" required>
    </div>

    <!-- Ngày sinh -->
    <div>
        <label>Ngày sinh</label>
        <input type="date" name="date_of_birth">
    </div>
     <div>
        <label>Khoa</label>
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

    <!-- Giới tính -->
    <div>
        <label>Giới tính</label>
        <div class="gender-group">
            <input type="radio" name="gender" value="male" required>Nam
            <input type="radio" name="gender" value="female">Nữ
            <!-- <input type="radio" name="gender" value="other"> -->
        </div>
    </div>

    <!-- Lớp -->
    <div>
        <label>Lớp</label>
        <select name="class_id" required>
            <option value="">-- Chọn lớp --</option>
            <?php foreach ($classes as $class): ?>
                <option value="<?= $class['id'] ?>">
                    <?= htmlspecialchars($class['class_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Hệ đào tạo -->
    <div>
        <label>Hệ đào tạo</label>
        <select name="education_type" required>
            <option value="chinh_quy">Chính quy</option>
            <option value="lien_thong">Liên thông</option>
            <option value="tai_chuc">Tại chức</option>
        </select>
    </div>

    <!-- Trạng thái -->
    <div>
        <label>Trạng thái</label>
        <select name="status" required>
            <option value="studying">Đang học</option>
            <option value="paused">Tạm dừng</option>
            <option value="dropped">Thôi học</option>
            <option value="graduated">Tốt nghiệp</option>
        </select>
    </div>

    <!-- Email -->
    <div>
        <label>Email</label>
        <input type="email" name="email">
    </div>

    <!-- Số điện thoại -->
    <div>
        <label>Số điện thoại</label>
        <input type="text" name="phone">
    </div>

    <!-- CCCD -->
    <div>
        <label>Số CCCD</label>
        <input type="text" name="identity_number">
    </div>

    <!-- Địa chỉ -->
    <div>
        <label>Địa chỉ</label>
        <input type="text" name="address">
    </div>

    <!-- Tài khoản -->
    <div>
        <label>Tên đăng nhập</label>
        <input type="text" name="username" required>
    </div>

    <div>
        <label>Mật khẩu</label>
        <input type="password" name="password" required>
    </div>

    <input type="submit" value="Thêm sinh viên" name="btn_add">
</form>

<?php
$content = ob_get_clean();
include "../views/admin/layout.php";
?>