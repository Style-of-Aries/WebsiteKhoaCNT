<?php
ob_start();
$title = "Hồ sơ cá nhân";
?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success" id="autoHideAlert">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error" id="autoHideAlert">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form action="index.php?controller=student&action=updateProfile" method="POST" enctype="multipart/form-data" class="profile-card">

    <!-- ===== HEADER ===== -->
    <div class="profile-header">

        <img id="avatarPreview" src="<?= BASE_URL ?>/upload/avatar/<?= $profile['avatar'] ?>" class="avatar-img">

        <input type="file" id="avatarInput" name="avatar" accept="image/*" hidden onchange="previewAvatar(event)">

        <div class="nameAndbtn">
            <h2><?= $profile['full_name'] ?></h2>
            <p class="student-code">MSSV: <?= $profile['student_code'] ?></p>

            <!-- Có thể ẩn bằng CSS nếu không cho sửa -->
            <label for="avatarInput" class="btn-upload">
                <i class='bx bx-camera'></i> Chọn ảnh thẻ
            </label>
        </div>

    </div>


    <!-- ===== THÔNG TIN HỌC VỤ ===== -->
    <div class="profile-section">
        <h3>Thông tin học vụ</h3>

        <div class="info-row">
            <label>Lớp hành chính</label>
            <input type="text" value="<?= $profile['class_name'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>Khoa / Bộ môn</label>
            <input type="text" value="<?= $profile['department_name'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>Hệ đào tạo</label>
            <input type="text" value="<?= $profile['education_type'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>Trạng thái học tập</label>
            <input type="text" value="<?= $profile['status'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>GPA</label>
            <input type="text" value="<?= $profile['gpa'] ?? '0.00' ?>" readonly>
        </div>

        <div class="info-row">
            <label>Tổng tín chỉ</label>
            <input type="text" value="<?= $profile['total_credits'] ?? 0 ?>" readonly>
        </div>

        <div class="info-row">
            <label>Số môn đã học</label>
            <input type="text" value="<?= $profile['total_courses'] ?? 0 ?>" readonly>
        </div>
    </div>


    <!-- ===== THÔNG TIN CÁ NHÂN ===== -->
    <div class="profile-section">
        <h3>Thông tin cá nhân</h3>

        <div class="info-row">
            <label>Giới tính</label>
            <select name="gender" disabled>
                <option value="">-- Chưa xác định --</option>
                <option value="Nam" <?= $profile['gender'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= $profile['gender'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                <option value="Khác" <?= $profile['gender'] == 'Khác' ? 'selected' : '' ?>>Khác</option>
            </select>
        </div>

        <div class="info-row">
            <label>Ngày sinh</label>
            <input type="date" name="date_of_birth" value="<?= $profile['date_of_birth'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>Email</label>
            <input type="email" name="email" value="<?= $profile['email'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>Số điện thoại</label>
            <input type="text" name="phone" value="<?= $profile['phone'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>CCCD / CMND</label>
            <input type="text" name="identity_number" value="<?= $profile['identity_number'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>Địa chỉ</label>
            <input type="text" name="address" value="<?= $profile['address'] ?>" readonly>
        </div>

    </div>


    <!-- ===== ACTION ===== -->
    <div class="actions">
        <button type="submit" class="btn-save">Cập nhật</button>
    </div>

</form>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>
