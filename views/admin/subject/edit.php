<?php
ob_start();

$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);

function getValue($key, $default = '', $data = null)
{
    global $old;
    if (!empty($old)) {
        return htmlspecialchars($old[$key] ?? $default);
    }
    return htmlspecialchars($data[$key] ?? $default);
}
?>

<div class="container-main">

    <button class="back-button" onclick="history.back()">
        ← Quay lại
    </button>

    <h2>Sửa Môn học</h2>

    <form action="index.php?controller=subject&action=editNew" method="POST">
        <input type="hidden" name="id" value="<?= $subject['id'] ?>">
        <!-- ===== THÔNG TIN CƠ BẢN ===== -->
        <div class="row">
            <div class="col">
                <label>Ngành </label>
                <select name="department_id" required>
                    <option value="">-- Ngành --</option>

                    <?php foreach ($department as $dept): ?>
                        <option value="<?= $dept['id'] ?>" <?= getValue('department_id', '', $subject) == $dept['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dept['faculty_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col">
                <label>Tên Môn học</label>
                <input type="text" name="name" value="<?= getValue('name', '', $subject) ?>" required>
            </div>
            <div class="col">
                <label>Mã Môn học</label>
                <input type="text" name="subject_code" value="<?= getValue('subject_code', '', $subject) ?>" required>
            </div>

        </div>

        <div class="row">
            <div class="col">
                <label>Số tín chỉ</label>
                <input type="number" name="credits" min="1" value="<?= getValue('credits', '', $subject) ?>" readonly>
            </div>

            <div class="col">
                <label>Loại môn</label>

                <input type="text" value="<?= $subject['subject_type'] == 'NORMAL' ? 'Môn thường' : 'Đồ án' ?>"
                    readonly>

                <input type="hidden" name="subject_type" value="<?= $subject['subject_type'] ?>">
            </div>
            <div class="col">
                <label>Năm đào tạo đề xuất</label>
                <select name="recommended_year" required>
                    <option value="1" <?= getValue('recommended_year', '', $subject) == 1 ? 'selected' : '' ?>>
                        Năm nhất
                    </option>

                    <option value="2" <?= getValue('recommended_year', '', $subject) == 2 ? 'selected' : '' ?>>
                        Năm hai
                    </option>

                    <option value="3" <?= getValue('recommended_year', '', $subject) == 3 ? 'selected' : '' ?>>
                        Năm ba
                    </option>

                </select>
            </div>
        </div>

        <!-- ===== KHOA ===== -->


        <!-- ===== CẤU TRÚC ĐIỂM ===== -->
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

                <?php
                $dataComponents = $old['components'] ?? $components ?? [];
                ?>

                <?php foreach ($dataComponents as $index => $comp): ?>
                    <tr>
                        <td>
                            <input type="text" name="components[<?= $index ?>][name]"
                                value="<?= htmlspecialchars($comp['name']) ?>" readonly>
                        </td>

                        <td>
                            <select name="components[<?= $index ?>][type]" disabled>
                                <option value="TX" <?= $comp['type'] == 'TX' ? 'selected' : '' ?>>Thường xuyên</option>
                                <option value="DK" <?= $comp['type'] == 'DK' ? 'selected' : '' ?>>Định kì</option>
                                <option value="CK" <?= $comp['type'] == 'CK' ? 'selected' : '' ?>>Điểm thi</option>
                                <option value="PROJECT" <?= $comp['type'] == 'PROJECT' ? 'selected' : '' ?>>Đồ án</option>
                            </select>
                        </td>

                        <td>
                            <input type="number" class="weight-input" name="components[<?= $index ?>][weight]"
                                value="<?= htmlspecialchars($comp['weight']) ?>" readonly>
                        </td>

                        <td>
                            <button type="button" class="btn-remove btn-delete" disabled>
                                <span class="X"></span>
                                <span class="Y"></span>
                                <div class="close">Xóa</div>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <button type="button" class="add-button" id="btnAddComponent" disabled>
            <div class="sign">+</div>
            <div class="text">Thêm thành phần</div>
        </button>

        <div class="info-box">
            Tổng trọng số:
            <strong><span id="totalWeight">0</span>%</strong>
        </div>

        <button name="btn_edit" type="submit" class="btn-submit">
            Cập nhật môn học
        </button>

    </form>
</div>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>