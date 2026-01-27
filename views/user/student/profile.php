<?php
ob_start();
$title = "Hồ sơ cá nhân";
?>
<!-- <link rel="stylesheet" href="<?= BASE_URL ?>css/user.css"> -->
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
<form action="index.php?controller=student&action=updateProfile" method="POST" enctype="multipart/form-data"
    class="profile-card">

    <div class="profile-header">
        <!-- <label class="avatar-label">Ảnh thẻ</label> -->

        <img id="avatarPreview" src="<?= BASE_URL ?>/upload/avatar/<?= $profile['avatar'] ?>" class="avatar-img">

        <!-- input file ẩn -->
        <input type="file" id="avatarInput" name="avatar" accept="image/*" hidden onchange="previewAvatar(event)">

        <!-- nút chọn ảnh -->
        <div class="nameAndbtn">
            <h2><?= $profile['full_name'] ?></h2>
            <label for="avatarInput" class="btn-upload"><i class='bx bx-camera'></i>Chọn ảnh thẻ</label>
        </div>
    </div>



    <div class="profile-info">

        <div class="info-row">
            <label>Giới tính</label>
            <select name="gender">
                <option value="">-- Xóa / Chưa xác định --</option>
                <option value="Nam" <?= $profile['gender'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= $profile['gender'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                <option value="Khác" <?= $profile['gender'] == 'Khác' ? 'selected' : '' ?>>Khác</option>
            </select>
        </div>

        <div class="info-row">
            <label>Ngày sinh</label>
            <input type="date" name="date_of_birth" value="<?= $profile['date_of_birth'] ?>">
        </div>

        <div class="info-row">
            <label>Email</label>
            <input type="email" name="email" value="<?= $profile['email'] ?>">
        </div>

        <div class="info-row">
            <label>Số điện thoại</label>
            <input type="text" name="phone" value="<?= $profile['phone'] ?>">
        </div>

        <div class="info-row">
            <label>CCCD / CMND</label>
            <input type="text" name="identity_number" value="<?= $profile['identity_number'] ?>">
        </div>

        <div class="info-row">
            <label>Địa chỉ</label>
            <input type="text" name="address" value="<?= $profile['address'] ?>">
        </div>

        <div class="actions">
            <button type="submit" class="btn-save">Cập nhật</button>
        </div>
    </div>
</form>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../admin/layout.php';
?>