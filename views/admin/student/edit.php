<?php
ob_start();
?>

<form class="profile-paper"
    action="index.php?controller=admin&action=editSinhVien"
    method="POST"
    enctype="multipart/form-data">

    <!-- hidden id -->
    <input type="hidden" name="id" value="<?= $student['id'] ?>">
    <input type="hidden" name="created_at" value="<?= $student['created_at'] ?>">
    <input type="hidden" name="old_avatar" value="<?= $studentprf['avatar'] ?>">

    <!-- Quốc hiệu -->
    <div class="national">
        <h2>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h2>
        <p>Độc lập - Tự do - Hạnh phúc</p>
    </div>

    <div class="form-title">
        CHỈNH SỬA HỒ SƠ SINH VIÊN
    </div>

    <!-- HEADER -->
    <div class="profile-header">

        <!-- Avatar -->
        <label class="avatar-box" for="realFile">
            <div class="file-info">
                <img id="avatarPreview"
                    src="<?= !empty($studentprf['avatar'])
                                ? BASE_URL . 'upload/avatar/' . $studentprf['avatar']
                                : BASE_URL . 'uploads/avatars/default.png' ?>"
                    alt="Avatar">
                <span>
                    <?= !empty($studentprf['avatar'])
                        ? $studentprf['avatar']
                        : 'Chọn ảnh' ?>
                </span>
            </div>
        </label>

        <input type="file"
            name="avatar"
            id="realFile"
            hidden
            accept="image/*">
            

        <div class="header-info">

            <div class="info-row">
                <label>Họ và tên</label>
                <input type="text"
                    name="full_name"
                    value="<?= $studentprf['full_name'] ?>"
                    required>
            </div>

            <div class="info-row">
                <label>Mã sinh viên</label>
                <input type="text"
                    name="student_code"
                    value="<?= $student['student_code'] ?>"
                    required>
                <span style="color:red"><?= $errorMaSv ?? '' ?></span>
            </div>

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
            <input type="date"
                name="date_of_birth"
                value="<?= $studentprf['date_of_birth'] ?>">
        </div>

        <div class="info-row">
            <label>Email</label>
            <input type="email"
                name="email"
                value="<?= $studentprf['email'] ?>">
            <span style="color:red"><?= $errorEmail ?? '' ?></span>
        </div>

        <div class="info-row">
            <label>Số điện thoại</label>
            <input type="text"
                name="phone"
                value="<?= $studentprf['phone'] ?>">
        </div>

        <div class="info-row">
            <label>CCCD / CMND</label>
            <input type="text"
                name="identity_number"
                value="<?= $studentprf['identity_number'] ?>">
        </div>

        <div class="info-row">
            <label>Địa chỉ</label>
            <input type="text"
                name="address"
                value="<?= $studentprf['address'] ?>">
        </div>
    </div>

    <!-- THÔNG TIN HỌC VỤ -->
    <div class="section">
        <h3>Thông tin học vụ</h3>

        <div class="info-row">
            <label>Lớp hành chính</label>
            <select name="class_id" required>
                <option value="">-- Chọn lớp --</option>
                <?php while ($class = mysqli_fetch_assoc($classes)): ?>
                    <option value="<?= $class['id'] ?>"
                        <?= $student['class_id'] == $class['id'] ? 'selected' : '' ?>>
                        <?= $class['class_name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="info-row">
            <label>Khoa</label>
            <select name="department_id" required>
                <option value="">-- Chọn khoa --</option>
                <?php while ($dept = mysqli_fetch_assoc($department)): ?>
                    <option value="<?= $dept['id'] ?>"
                        <?= $student['department_id'] == $dept['id'] ? 'selected' : '' ?>>
                        <?= $dept['faculty_name'] ?>
                    </option>
                <?php endwhile; ?>
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
            <label>Username</label>
            <input type="text"
                name="username"
                value="<?= $userNd['username'] ?>">
            <span style="color:red"><?= $errorName ?? '' ?></span>
        </div>

        <div class="info-row">
            <label>Password</label>
            <input type="text"
                name="password"
                value="<?= $userNd['password'] ?>">
        </div>
    </div>

    <div class="actions">
        <button type="submit"
            class="btn-submit"
            name="btn_edit">
            CẬP NHẬT HỒ SƠ
        </button>
    </div>

</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>