<?php
ob_start();
?>

<div class="container-main">
    <button class="back-button" onclick="history.back()">
        <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1024 1024">
            <path
                d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z">
            </path>
        </svg>
        <span>Quay lại</span>
    </button>
    <h2>Thêm lớp học</h2>
    <form action="index.php?controller=classes&action=add" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col">
                <label>Tên lớp</label>
                <input type="text" name="class_name" required>
                <!-- <i class="fa-solid fa-user"></i> -->
                <!-- <small class="error" id="error-title"></small> -->
            </div>
        </div>
        <!-- <div class="row">
            <div class="col">
                <label>Mã lớp</label>
                <input type="text" name="class_code" required>
            </div>
        </div> -->

        <div class="row">
            <div class="col">
                <label>Ngành học</label>
                <select name="department_id" id="departmentSelect" required>
                    <option value="">-- Chọn ngành học --</option>

                    <?php foreach ($department as $dep): ?>
                        <option value="<?= $dep['id'] ?>">
                            <?= htmlspecialchars($dep['faculty_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <i class="fa-solid fa-school"></i>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label>Giảng viên chủ nhiệm</label>
                <select name="lecturer_id" id="lecturerSelect" required>
                    <option value="">-- Chọn giảng viên --</option>

                    <?php foreach ($lecturer as $class): ?>
                        <option value="<?= $class['id'] ?>">
                            <?= htmlspecialchars($class['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <i class="fa-solid fa-school"></i>
            </div>
        </div>


        <button class="btn-submit" type="submit" name="btn_add">Thêm lớp học</button>
    </form>
</div>
<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>