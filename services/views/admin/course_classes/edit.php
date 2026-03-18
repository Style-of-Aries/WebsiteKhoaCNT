<?php
ob_start();

$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

/* 
   Nếu có lỗi validate → ưu tiên hiển thị lại dữ liệu old
   Nếu không → lấy dữ liệu từ DB ($courseClass)
*/
$data = $old ?: $course_classes;
?>

<div class="container-main">
    <button class="back-button" onclick="location.href='index.php?controller=course_classes&action=getAllHocPhan'">
        <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024">
            <path
                d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z">
            </path>
        </svg>
        <span>Quay lại</span>
    </button>

    <h2>Sửa lớp học phần</h2>

    <form class="form_add_course_class" method="POST" action="index.php?controller=course_classes&action=updateNew">
        <input type="hidden" name="id" value=" <?= $_GET['id'] ?>">

        <h3>Thông tin lớp học phần</h3>

        <!-- Môn học -->
        <div class="row">
            <div class="col">
                <label>Môn học</label>
                <select name="subject_id" required>
                    <option value="">-- Chọn môn --</option>
                    <?php foreach ($subject as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= ($data['subject_id'] == $s['id']) ? 'selected' : '' ?>>
                            <?= $s['subject_code'] ?> - <?= $s['name'] ?>
                            (Số tín chỉ: <?= $s['credits'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Giảng viên + Sĩ số -->
        <div class="row">
            <div class="col">
                <label>Giảng viên</label>
                <select name="lecturer_id" required>
                    <option value="">-- Chọn giảng viên --</option>
                    <?php foreach ($lecturer as $l): ?>
                        <option value="<?= $l['id'] ?>" <?= ($data['lecturer_id'] == $l['id']) ? 'selected' : '' ?>>
                            <?= $l['full_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col">
                <label>Sĩ số tối đa</label>
                <input type="number" name="max_students" required
                    value="<?= htmlspecialchars($data['max_students']) ?>">
            </div>
        </div>

        <!-- Thời gian đăng ký -->
        <div class="row">
            <div class="col">
                <label>Thời gian bắt đầu đăng ký</label>
                <input type="date" name="registration_start"
                    value="<?= htmlspecialchars(date('Y-m-d', strtotime($data['registration_start']))) ?>">
            </div>

            <div class="col">
                <label>Thời gian kết thúc đăng ký</label>
                <input type="date" name="registration_end"
                    value="<?= htmlspecialchars(date('Y-m-d', strtotime($data['registration_end']))) ?>">
            </div>
        </div>

        <button name="btn_update" type="submit" class="btn-submit">
            Cập nhật lớp học phần
        </button>
    </form>
</div>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>