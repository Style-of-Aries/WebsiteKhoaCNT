<?php
ob_start();
?>

<form class="profile-paper" method="POST" enctype="multipart/form-data">

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
                <?php while ($class = mysqli_fetch_assoc($classes)): ?>
                    <option value="<?= $class['id'] ?>">
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
                    <option value="<?= $dept['id'] ?>">
                        <?= $dept['faculty_name'] ?>
                    </option>
                <?php endwhile; ?>
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

        <div class="info-row">
            <label>Trạng thái học tập</label>
            <select name="status" required>
                <option value="">-- Chọn trạng thái --</option>
                <option value="Đang học">Đang học</option>
                <option value="Bảo lưu">Bảo lưu</option>
                <option value="Thôi học">Thôi học</option>
                <option value="Đã tốt nghiệp">Đã tốt nghiệp</option>
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