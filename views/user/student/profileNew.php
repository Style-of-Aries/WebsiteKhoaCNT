<?php
ob_start();
?>

<div class="profile-paper">

    <!-- Quốc hiệu -->
    <div class="national">
        <h2>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h2>
        <p>Độc lập - Tự do - Hạnh phúc</p>
    </div>

    <div class="form-title">
        HỒ SƠ SINH VIÊN
    </div>

    <!-- HEADER -->
    <div class="profile-header">

        <!-- Avatar -->
        <div class="avatar-box">
            <img id="avatarPreview" src="<?= !empty($studentprf['avatar'])
                ? BASE_URL . 'upload/avatar/' . $studentprf['avatar']
                : BASE_URL . 'uploads/avatars/default.png' ?>" alt="Avatar">
        </div>


        <div class="header-info">

            <div class="info-row">
                <label>Họ và tên</label>
                <input type="text" name="full_name" value="<?= $studentprf['full_name'] ?>" readonly>
            </div>

            <div class="info-row">
                <label>Mã sinh viên</label>
                <input type="text" name="student_code" value="<?= $student['student_code'] ?>" readonly>
                <!-- <span style="color:red"><?= $errorMaSv ?? '' ?></span> -->
            </div>

        </div>
    </div>

    <!-- THÔNG TIN CÁ NHÂN -->
    <div class="section">
        <h3>Thông tin cá nhân</h3>

        <div class="info-row">
            <label>Giới tính</label>
            <input type="text" value="<?= $studentprf['gender'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>Ngày sinh</label>
            <input type="date" name="date_of_birth" value="<?= $studentprf['date_of_birth'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>Email</label>
            <input type="email" name="email" value="<?= $studentprf['email'] ?>" readonly>
            <!-- <span style="color:red"><?= $errorEmail ?? '' ?></span> -->
        </div>

        <div class="info-row">
            <label>Số điện thoại</label>
            <input type="text" name="phone" value="<?= $studentprf['phone'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>CCCD / CMND</label>
            <input type="text" name="identity_number" value="<?= $studentprf['identity_number'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>Địa chỉ</label>
            <input type="text" name="address" value="<?= $studentprf['address'] ?>" readonly>
        </div>
    </div>

    <!-- THÔNG TIN HỌC VỤ -->
    <div class="section">
        <h3>Thông tin học vụ</h3>

        <div class="info-row">
            <label>Lớp hành chính</label>
            <input type="text" value="<?= $student['class_name'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>Khoa</label>
            <input type="text" value="<?= $student['department_name'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>Hệ đào tạo</label>
            <input type="text" value="<?= $studentprf['education_type'] ?>" readonly>
        </div>

        <div class="info-row">
            <label>Trạng thái học tập</label>
            <input type="text" value="<?= $studentprf['status'] ?>" readonly>
        </div>
    </div>

</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>