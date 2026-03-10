<?php
ob_start();

$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
// var_dump($semester);
// die();
?>

<div class="container-main">
    <button class="back-button"
        onclick="location.href='index.php?controller=semester&action=getAllSemester'">
        <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1024 1024">
            <path
                d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z">
            </path>
        </svg>
        <span>Quay lại</span>
    </button>
    <h2>✏️ Chỉnh sửa học kỳ</h2>

    <form method="POST" action="index.php?controller=semester&action=edit&id=<?= $semester['id'] ?>">

        <div class="row">
            <div class="col">
                <label>Tên học kỳ</label>

                <select name="semester_number" required>

                    <option value="1" <?= ($old['semester_number'] ?? $semester['semester_number']) == 1 ? 'selected' : '' ?>>
                        Học kỳ 1
                    </option>

                    <option value="2" <?= ($old['semester_number'] ?? $semester['semester_number']) == 2 ? 'selected' : '' ?>>
                        Học kỳ 2
                    </option>

                </select>

            </div>
        </div>

        <div class="row">

            <div class="col">
                <label>Năm học</label>

                <input type="text" name="academic_year"
                    value="<?= htmlspecialchars($old['academic_year'] ?? $semester['academic_year']) ?>"
                    placeholder="Ví dụ: 2025-2026" pattern="\d{4}-\d{4}" required>

                <small>Định dạng: YYYY-YYYY</small>
            </div>

        </div>

        <div class="row">
            <div class="col">
                <label>Ngày bắt đầu</label>

                <input type="date" name="start_date"
                    value="<?= htmlspecialchars($old['start_date'] ?? ($semester['start_date'] ?? '')) ?>" required>

            </div>
            <div class="col">
                <label>Ngày kết thúc</label>

                <input type="date" name="end_date"
                    value="<?= htmlspecialchars($old['end_date'] ?? ($semester['end_date'] ?? '')) ?>" required>

            </div>
        </div>

        <button type="submit" class="btn-submit" name="btn_update">
            Cập nhật học kỳ
        </button>

    </form>
</div>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>