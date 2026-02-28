<?php
ob_start();
// var_dump($_SESSION);die();
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

// Hàm tiện ích lấy giá trị cũ
function getOld($key, $default = '', $data = null)
{
    global $old;
    $source = $data ?? $old;
    return $source[$key] ?? $default;
}
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
    <h2>Thêm Môn học</h2>

    <form action="index.php?controller=subject&action=addNew" method="POST">
        <div class="row">
            <div class="col">
                <label>Tên Môn học</label>
                <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
            </div>
            <div class="col">
                <label>Số tín chỉ</label>
                <input type="number" name="credits" min="1" value="<?= htmlspecialchars($old['credits'] ?? '') ?>"
                    required>
            </div>
        </div>

        <div class="row">
            <!-- <div class="col">
                <label>Mã Môn học</label>
                <input type="text" name="subject_code" value="<?= htmlspecialchars($old['subject_code'] ?? '') ?>" required>
            </div> -->
            <div class="col">
                <label>Loại môn</label>
                <select name="subject_type" required>
                    <option value="NORMAL" <?= ($old['subject_type'] ?? '') == 'NORMAL' ? 'selected' : '' ?>>
                        Môn thường
                    </option>

                    <option value="PROJECT" <?= ($old['subject_type'] ?? '') == 'PROJECT' ? 'selected' : '' ?>>
                        Đồ án
                    </option>
                </select>
            </div>
        </div>

        <div class="col">
            <label>Ngành</label>
            <select name="department_id" required>
                <option value="">-- Chọn ngành --</option>

                <?php foreach ($department as $dept): ?>
                    <option value="<?= $dept['id'] ?>" <?= ($old['department_id'] ?? '') == $dept['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dept['faculty_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <h3>Cấu trúc điểm</h3>

        <table class="main-table" id="score-structure">
            <thead>
                <tr>
                    <th>Tên thành phần</th>
                    <th>Loại</th>
                    <th>Trọng số (%)</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($old['components'])): ?>
                    <?php foreach ($old['components'] as $index => $comp): ?>
                        <tr>
                            <td>
                                <input type="text" name="components[<?= $index ?>][name]"
                                    value="<?= htmlspecialchars($comp['name']) ?>">
                            </td>

                            <td>
                                <select name="components[<?= $index ?>][type]">
                                    <option value="TX" <?= $comp['type'] == 'TX' ? 'selected' : '' ?>>Thường xuyên</option>
                                    <option value="DK" <?= $comp['type'] == 'DK' ? 'selected' : '' ?>>Định kì</option>
                                    <option value="CK" <?= $comp['type'] == 'CK' ? 'selected' : '' ?>>Điểm thi</option>
                                    <option value="PROJECT" <?= $comp['type'] == 'PROJECT' ? 'selected' : '' ?>>Đồ án</option>
                                </select>
                            </td>

                            <td>
                                <input type="number" name="components[<?= $index ?>][weight]"
                                    value="<?= htmlspecialchars($comp['weight']) ?>">
                            </td>

                            <td>
                                <button type="button" class="btn-remove btn-delete">
                                    <span class="X"></span>
                                    <span class="Y"></span>
                                    <div class="close">Xóa</div>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- <button type="button" class="btn btn-add" id="btnAddComponent">
                + Thêm thành phần
            </button> -->
        <button type="button" class="add-button" id="btnAddComponent">
            <div class="sign">+</div>
            <div class="text">Thêm thành phần</div>
        </button>


        <div class="info-box">
            Tổng trọng số: <strong><span id="totalWeight">0</span>%</strong>
        </div>

        <!-- <button type="submit" class="btn btn-submit">
                Tạo lớp học phần
            </button> -->
        <button name="btn_add" type="submit" class="btn-submit">Thêm môn học</button>
    </form>
</div>
<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>