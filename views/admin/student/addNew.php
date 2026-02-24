<?php
ob_start();
?>

<form class="profile-paper" action="index.php?controller=admin&action=add" method="POST" enctype="multipart/form-data">

    <!-- Quốc hiệu -->
    <div class="national">
        <h2>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h2>
        <p>Độc lập - Tự do - Hạnh phúc</p>
    </div>

    <div class="form-title">
        Hồ sơ sinh viên
    </div>

    <!-- HEADER -->
    <div class="profile-header">
        <!-- <label class="avatar-box">
            <input type="file" name="avatar" hidden onchange="previewAvatar(event)">
            <img id="avatarPreview" src="" alt="Ảnh 3x4">
        </label> -->
        <!-- <label>Ảnh đại diện</label> -->

        <label class="avatar-box" for="realFile">
            <div class="file-info">
                <img id="avatarPreview" src="<?= !empty($studentprf['avatar'])
                    ? BASE_URL . 'upload/avatar/' . $studentprf['avatar']
                    : BASE_URL . 'uploads/avatars/default.png' ?>" alt="Avatar">

                <!-- <span id="fileName">
                    <?= !empty($studentprf['avatar']) ? $studentprf['avatar'] : 'Chọn ảnh' ?>
                </span> -->
            </div>
        </label>
        
        <input type="file" name="avatar" id="realFile" hidden accept="image/*">

        <input type="hidden" name="old_avatar" value="<?= $studentprf['avatar'] ?>">

        <div class="header-info">
            <div class="info-row">
                <label>Họ và tên</label>
                <input type="text" name="full_name" required>
            </div>

            <div class="info-row">
                <label>Mã sinh viên</label>
                <input disabled type="text" name="student_code" value=" <?= $student ?>" required>
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
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
        </div>

        <div class="info-row">
            <label>Ngày sinh</label>
            <input type="date" name="date_of_birth">
        </div>

        <div class="info-row">
            <label>Email</label>
            <input type="email" name="email">
        </div>

        <div class="info-row">
            <label>Số điện thoại</label>
            <input type="text" name="phone">
        </div>

        <div class="info-row">
            <label>CCCD / CMND</label>
            <input type="text" name="identity_number">
        </div>

        <div class="info-row">
            <label>Địa chỉ</label>
            <input type="text" name="address">
        </div>
    </div>

    <!-- THÔNG TIN HỌC VỤ -->
    <div class="section">
        <h3>Thông tin học vụ</h3>

        <div class="info-row">
            <label>Lớp hành chính</label>
            <!-- <input type="text" name="class_name"> -->
            <select name="class_id" required>
                <option value="">-- Chọn lớp --</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?= $class['id'] ?>">
                        <?= $class['class_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="info-row">
            <label>Khoa</label>
            <select name="department_id" required>
                <option value="">-- Chọn khoa --</option>
                <?php foreach ($department as $dept): ?>
                    <option value="<?= $dept['id'] ?>">
                        <?= $dept['faculty_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="info-row">
            <label>Hệ đào tạo</label>
            <select name="education_type" required>
                <option value="">-- Chọn hệ đào tạo --</option>
                <option value="Chính quy">Chính quy</option>
                <option value="Liên thông">Liên thông</option>
            </select>
        </div>
    </div>

    <div class="actions">
        <button type="submit" class="btn-submit" name="btn_add">LƯU HỒ SƠ</button>
    </div>

</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>