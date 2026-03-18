<?php
ob_start();
?>

<form class="profile-paper" action="index.php?controller=admin&action=editSinhVien" method="POST"
    enctype="multipart/form-data">

    <!-- hidden id -->
    <input type="hidden" name="id" value="<?= $student['id'] ?>">
    <input type="hidden" name="created_at" value="<?= $student['created_at'] ?>">
    <input type="hidden" name="old_avatar" value="<?= $studentprf['avatar'] ?>">

    <!-- Quốc hiệu -->
    <!-- <div class="national">
        <h2>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h2>
        <p>Độc lập - Tự do - Hạnh phúc</p>
    </div> -->

    <div class="form-title">
        HỒ SƠ SINH VIÊN
    </div>

    <!-- HEADER -->
    <div class="profile-header">

        <!-- Avatar -->
        <label class="avatar-box" for="realFile">
            <div class="file-info">
                <?php if (!empty($studentprf['avatar'])): ?>
                    <img id="avatarPreview" src="<?= BASE_URL . 'upload/avatar/' . $studentprf['avatar'] ?>">
                <?php else: ?>
                    <img id="avatarPreview">
                <?php endif; ?>
            </div>
        </label>

        <input type="file" name="avatar" id="realFile" hidden accept="image/*">
        <input type="hidden" name="old_avatar" value="<?= $studentprf['avatar'] ?>">


        <div class="header-info">

            <div class="info-row">
                <label>Họ và tên</label>
                <input type="text" name="full_name" value="<?= $studentprf['full_name'] ?>" required>
            </div>

            <div class="info-row">
                <label>Mã sinh viên</label>
                <input type="text" name="student_code" value="<?= $student['student_code'] ?>" required>
            </div>
            <span style="color:red"><?= $errorMaSv ?? '' ?></span>

        </div>
    </div>

    <!-- THÔNG TIN CÁ NHÂN -->
    <div class="section">
        <h3>Thông tin cá nhân</h3>

        <div class="info-row">
            <label>Giới tính</label>
            <select name="gender">
                <option value="">-- Chọn --</option>
                <option value="Nam" <?= $studentprf['gender'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= $studentprf['gender'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                <option value="Khác" <?= $studentprf['gender'] == 'Khác' ? 'selected' : '' ?>>Khác</option>
            </select>
        </div>

        <div class="info-row">
            <label>Ngày sinh</label>
            <input type="date" name="date_of_birth" value="<?= $studentprf['date_of_birth'] ?>">

        </div>
        <span style="color:red"><?= $errorDate ?? '' ?></span>

        <div class="info-row">
            <label>Email</label>
            <input type="email" name="email" value="<?= $studentprf['email'] ?>">
        </div>
        <span style="color:red"><?= $errorEmail ?? '' ?></span>

        <div class="info-row">
            <label>Số điện thoại</label>
            <input type="text" name="phone" value="<?= $studentprf['phone'] ?>" required>

        </div>
        <span style="color:red"><?= $errorSdt ?? '' ?></span>

        <div class="info-row">
            <label>CCCD / CMND</label>
            <input type="text" name="identity_number" value="<?= $studentprf['identity_number'] ?>" required>
        </div>
        <span style="color:red"><?= $errorCccd ?? '' ?></span>

        <div class="info-row">
            <label>Địa chỉ</label>
            <input type="text" name="address" value="<?= $studentprf['address'] ?>" required>
        </div>
    </div>

    <!-- THÔNG TIN HỌC VỤ -->
    <div class="section">
        <h3>Thông tin học vụ</h3>

        <div class="info-row">
            <label>Ngành</label>
            <select name="department_id" id="departmentSelect" required>
                <option value="">-- Chọn ngành --</option>
                <?php foreach ($department as $dept): ?>
                    <option value="<?= $dept['id'] ?>" <?= $student['department_id'] == $dept['id'] ? 'selected' : '' ?>>
                        <?= $dept['faculty_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="info-row">
            <label>Lớp hành chính</label>
            <select name="class_id" id="classSelect" required>
                <option value="">-- Chọn lớp --</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?= $class['id'] ?>" <?= $student['class_id'] == $class['id'] ? 'selected' : '' ?>>
                        <?= $class['class_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>



        <div class="info-row">
            <label>Hệ đào tạo</label>
            <select name="education_type">
                <option value="Chính quy" <?= $studentprf['education_type'] == 'Chính quy' ? 'selected' : '' ?>>
                    Chính quy
                </option>
                <option value="Liên thông" <?= $studentprf['education_type'] == 'Liên thông' ? 'selected' : '' ?>>
                    Liên thông
                </option>
            </select>
        </div>

        <div class="info-row">
            <label>Trạng thái học tập</label>
            <select name="status">
                <option value="Đang học" <?= $studentprf['status'] == 'Đang học' ? 'selected' : '' ?>>
                    Đang học
                </option>
                <option value="Bảo lưu" <?= $studentprf['status'] == 'Bảo lưu' ? 'selected' : '' ?>>
                    Bảo lưu
                </option>
                <option value="Thôi học" <?= $studentprf['status'] == 'Thôi học' ? 'selected' : '' ?>>
                    Thôi học
                </option>
                <option value="Đã tốt nghiệp" <?= $studentprf['status'] == 'Đã tốt nghiệp' ? 'selected' : '' ?>>
                    Đã tốt nghiệp
                </option>
            </select>
        </div>
    </div>

    <!-- TÀI KHOẢN -->
    <div class="section">
        <h3>Tài khoản đăng nhập</h3>

        <div class="info-row">
            <label>Tài Khoản</label>
            <input type="text" name="username" value="<?= $userNd['username'] ?>">
            <span style="color:red"><?= $errorName ?? '' ?></span>
        </div>

        <div class="info-row">
            <label>Mật Khẩu</label>
            <input type="text" name="password" value="<?= $userNd['password'] ?>">
        </div>
    </div>

    <div class="actions">
        <button type="submit" class="btn-submit" name="btn_edit">
            CẬP NHẬT HỒ SƠ
        </button>
    </div>

</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>