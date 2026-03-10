<?php
ob_start();
?>

<form class="profile-paper" action="index.php?controller=admin&action=add" method="POST" enctype="multipart/form-data">

    <!-- Quốc hiệu -->
    <!-- <div class="national">
        <h2>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h2>
        <p>Độc lập - Tự do - Hạnh phúc</p>
    </div> -->

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
                <input type="text" name="full_name" placeholder="Nguyễn Văn A" value="<?= $old['full_name'] ?? '' ?>" required>
            </div>

            <div class="info-row">
                <label>Mã sinh viên</label>

                <!-- hiển thị -->
                <input type="text" value="<?= $old['student_code'] ?? $student_code ?>" readonly>

                <!-- gửi dữ liệu -->
                <input type="hidden" name="student_code" value="<?= $old['student_code'] ?? $student_code ?>">
            </div>
        </div>
    </div>

    <!-- THÔNG TIN CÁ NHÂN -->
    <div class="section">
        <h3>Thông tin cá nhân</h3>

        <div class="info-row">
            <label>Giới tính</label>
            <select name="gender" required>
                <option value="">-- Chọn --</option>
                <option value="Nam"
                    <?= ($old['gender'] ?? '') == 'Nam' ? 'selected' : '' ?>>
                    Nam
                </option>

                <option value="Nữ"
                    <?= ($old['gender'] ?? '') == 'Nữ' ? 'selected' : '' ?>>
                    Nữ
                </option>

                <option value="Khác"
                    <?= ($old['gender'] ?? '') == 'Khác' ? 'selected' : '' ?>>
                    Khác
                </option>
            </select>
        </div>

        <div class="info-row">
            <label>Ngày sinh</label>
            <input type="date" name="date_of_birth" value="<?= $old['date_of_birth'] ?? '' ?>" required>
            <span style="color:red"><?= $errorDate ?? '' ?></span>

        </div>

        <div class="info-row">
            <label>Email</label>
            <input type="email" name="email" placeholder="hpc@gmail.com" value="<?= $old['email'] ?? '' ?>" required>
            <span style="color:red"><?= $errorEmail ?? '' ?></span>
        </div>
        <div>

            <div class="info-row">
                <label>Số điện thoại</label>
                <input type="text" name="phone" placeholder="0969768666" pattern="^(03|05|07|08|09)[0-9]{8}$" value="<?= $old['phone'] ?? '' ?>" required>
                <span style="color:red"><?= $errorSdt ?? '' ?></span>

            </div>

            <div class="info-row">
                <label>CCCD / CMND</label>
                <input type="text" name="identity_number" placeholder="034205009263" pattern="^[0-9]{9}$|^[0-9]{12}$"
                    title="CMND 9 số hoặc CCCD 12 số" value="<?= $old['identity_number'] ?? '' ?>" required>
                <span style="color:red"><?= $errorCccd ?? '' ?></span>

            </div>

            <div class="info-row">
                <label>Địa chỉ</label>
                <input type="text" name="address" placeholder="Đường Phan Trọng Tuệ - Thanh Trì - Hà Nội" value="<?= $old['address'] ?? '' ?>" required>
            </div>
        </div>

        <!-- THÔNG TIN HỌC VỤ -->
        <div class="section">
            <h3>Thông tin học vụ</h3>

            <div class="info-row">
                <label>Ngành học</label>
                <select name="department_id" id="departmentSelect" required>
                    <option value="">-- Chọn ngành học --</option>
                    <?php foreach ($department as $dept): ?>
                        <option value="<?= $dept['id'] ?>"
                            <?= (isset($old['department_id']) && $old['department_id'] == $dept['id']) ? 'selected' : '' ?>>
                            <?= $dept['faculty_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="info-row">
                <label>Lớp hành chính</label>
                <!-- <input type="text" name="class_name"> -->
                <select name="class_id" id="classSelect" required>
                    <option value="">-- Chọn lớp --</option>
                    <?php foreach ($classes as $class): ?>
                        <!-- <option value="<?= $class['id'] ?>">
                            <?= $class['class_name'] ?>
                        </option> -->
                        <option value="<?= $class['id'] ?>"
                            <?= (isset($old['class_id']) && $old['class_id'] == $class['id']) ? 'selected' : '' ?>>
                            <?= $class['class_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="info-row">
                <label>Hệ đào tạo</label>
                <select name="education_type" required>
                    <option value="">-- Chọn hệ đào tạo --</option>
                    <option value="Chính quy"
                        <?= ($old['education_type'] ?? '') == 'Chính quy' ? 'selected' : '' ?>>
                        Chính quy
                    </option>
                    <option value="Liên thông"
                        <?= ($old['education_type'] ?? '') == 'Liên thông' ? 'selected' : '' ?>>
                        Liên thông
                    </option>
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