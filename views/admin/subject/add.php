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
            <div class="col">
                <label>Mã Môn học</label>
                <input type="text" name="subject_code" value="<?= htmlspecialchars($old['credits'] ?? '') ?>" required>
            </div>
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
            <span>Khoa</span>
            <select name="department_id" required>
                <option value="">-- Chọn khoa --</option>

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
                                    <option value="TX" <?= $comp['type'] == 'TX' ? 'selected' : '' ?>>TX</option>
                                    <option value="DK" <?= $comp['type'] == 'DK' ? 'selected' : '' ?>>DK</option>
                                    <option value="CK" <?= $comp['type'] == 'CK' ? 'selected' : '' ?>>CK</option>
                                    <option value="PROJECT" <?= $comp['type'] == 'PROJECT' ? 'selected' : '' ?>>PROJECT</option>
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