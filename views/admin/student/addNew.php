<?php
ob_start();
?>

<form class="profile-paper" method="POST" enctype="multipart/form-data">
    <button class="back-button" onclick="history.back()">
        <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1024 1024">
            <path
                d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z">
            </path>
        </svg>
        <span>Quay lại</span>
    </button>

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
        <label class="avatar-box">
            <input type="file" name="avatar" hidden onchange="previewAvatar(event)">
            <img id="avatarPreview" src="" alt="Ảnh 3x4">
        </label>

        <div class="header-info">
            <div class="info-row">
                <label>Họ và tên</label>
                <input type="text" name="full_name" required>
            </div>

            <div class="info-row">
                <label>Mã sinh viên</label>
                <input type="text" name="student_code" required>
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
                <?php foreach($classes as $class): ?>
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
                <?php foreach($department as $dept): ?>
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
        <button type="submit" class="btn-submit">LƯU HỒ SƠ</button>
    </div>

</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>