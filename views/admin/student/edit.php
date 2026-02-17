<?php
ob_start();
?>


<form class="add-form" action="index.php?controller=admin&action=editSinhVien" method="POST"
    enctype="multipart/form-data">
    <h2>Sửa thông tin sinh viên: <?php echo $studentprf['full_name'] ?></h2>
    <input type="hidden" name="id" value=" <?= $student['id'] ?>">


    <!-- Avatar -->
    <label>Ảnh đại diện</label>


    <div class="fake-file">
        <button type="button" onclick="openFile()">Choose File</button>

        <div class="file-info">
            <img id="avatarPreview"
                src="<?= !empty($studentprf['avatar'])
                            ? BASE_URL . 'upload/avatar/' . $studentprf['avatar']
                            : BASE_URL . 'upload/avatar/default.png' ?>"
                alt="Avatar">

            <span id="fileName">
                <?= !empty($studentprf['avatar']) ? $studentprf['avatar'] : 'No file chosen' ?>
            </span>
        </div>
    </div>

    <input type="file" name="avatar" id="realFile" hidden accept="image/*" onchange="updateFileName(this)">
    <input type="hidden" name="old_avatar" value="<?= $studentprf['avatar'] ?>">




    <!-- Họ tên -->
    <div>
        <label>Họ và tên</label>
        <input type="text" name="full_name" value="<?= $studentprf['full_name'] ?>" required>
    </div>
    <!-- Giới tính -->
    <div>
        <label>Giới tính</label>
        <select name="gender" required>
            <option value="Nam" <?= $studentprf['gender'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
            <option value="Nữ" <?= $studentprf['gender'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
            <option value="Khác" <?= $studentprf['gender'] == 'Khác' ? 'selected' : '' ?>>Khác</option>
        </select>
    </div>
    <!-- Mã sinh viên -->
    <div>
        <label>Mã sinh viên</label>
        <input type="text" name="student_code" value="<?= $student['student_code'] ?>" required>
        <?php if (!empty($errorMaSv)) echo "<span style='color:red;'>$errorMaSv</span><br>"; ?>
    </div>

    <!-- Ngày sinh -->
    <div>
        <label>Ngày sinh</label>
        <input type="date" name="date_of_birth" value="<?= $studentprf['date_of_birth'] ?>" required>
    </div>
    <div>
        <label>Thời gian nhập học</label>
        <input type="text" name="created_at" value="<?= $student['created_at'] ?>" required>
    </div>
    <div>
        <label>Khoa</label>
        <select name="department_id" required>
            <?php foreach ($department as $department): ?>
                <option
                    value="<?= $department['id'] ?>"
                    <?= ($department['id'] == $student['department_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($department['faculty_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <i class="fa-solid fa-school"></i>
    </div>

    <!-- Lớp -->
    <div>
        <label>Lớp</label>
        <select name="class_id" required>
            <?php foreach ($classes as $class): ?>
                <option
                    value="<?= $class['id'] ?>"
                    <?= ($class['id'] == $student['class_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($class['class_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>


    <!-- Hệ đào tạo -->
    <div>
        <label>Hệ đào tạo</label>
        <select name="education_type">
            <option <?= $studentprf['education_type'] == 'Chính quy' ? 'selected' : '' ?>>Chính quy</option>
            <option <?= $studentprf['education_type'] == 'Liên thông' ? 'selected' : '' ?>>Liên thông</option>
            <option <?= $studentprf['education_type'] == 'Tại chức' ? 'selected' : '' ?>>Tại chức</option>
        </select>
    </div>


    <!-- Trạng thái -->
    <div>
        <label>Trạng thái</label>
        <select name="status">
            <option <?= $studentprf['status'] == 'Đang học' ? 'selected' : '' ?>>Đang học</option>
            <option <?= $studentprf['status'] == 'Tạm dừng' ? 'selected' : '' ?>>Tạm dừng</option>
            <option <?= $studentprf['status'] == 'Thôi học' ? 'selected' : '' ?>>Thôi học</option>
            <option <?= $studentprf['status'] == 'Đã tốt nghiệp' ? 'selected' : '' ?>>Đã tốt nghiệp</option>
        </select>
    </div>

    <!-- Email -->
    <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= $studentprf['email'] ?>" required>
        <?php if (!empty($errorEmail)) echo "<span style='color:red;'>$errorEmail</span><br>"; ?>
    </div>

    <!-- Số điện thoại -->
    <div>
        <label>Số điện thoại</label>
        <input type="text" name="phone" value="<?= $studentprf['phone'] ?>" required>
    </div>

    <!-- CCCD -->
    <div>
        <label>Số CCCD</label>
        <input type="text" name="identity_number" value="<?= $studentprf['identity_number'] ?>" required>
    </div>

    <!-- Địa chỉ -->
    <div>
        <label>Địa chỉ</label>
        <input type="text" name="address" value="<?= $studentprf['address'] ?>" required>
    </div>

    <!-- Tài khoản -->
    <div>
        <label>Tên đăng nhập</label>
        <input type="text" name="username" placeholder="Tài khoản" value="<?= $userNd['username'] ?>" required>
        <?php if (!empty($errorName))
            echo "<span style='color:red;'>$errorName</span><br>"; ?>
    </div>

    <div>
        <label>Mật khẩu</label>
        <input type="text" name="password" placeholder="Mật khẩu" value="<?= $userNd['password'] ?>" required>
    </div>

    <input type="submit" value="Lưu" name="btn_edit">
</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>