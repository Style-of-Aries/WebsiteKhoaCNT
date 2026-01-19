<?php
ob_start();
?>
<style>
    .error {
        color: red;
        /* margin-left: px; */
    }

    form.song-form {
        background-color: #231b2e;
        padding: 24px;
        border-radius: 8px;
        /* max-width: 600px; */
        width: 50%;
        /* height: 70%; */
        /* margin: auto; */
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    label {
        font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="file"],
    input[type="password"],
    select {
        padding: 10px;
        border: none;
        border-radius: 4px;
        background-color: #2e253a;
        color: white;
        width: 100%;
        outline: none;
    }

    input[type="submit"] {
        padding: 12px;
        background-color: #9b4de0;
        border: none;
        color: white;
        font-weight: bold;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
        outline: none;
    }

    input[type="submit"]:hover {
        background-color: #b86aff;
    }
</style>


<h2>Sửa thông tin Môn học:<?= $subject['name'] ?> </h2>

<form class="song-form" action="index.php?controller=subject&action=edit" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value=" <?= $subject['id'] ?>">

    <div>
        <span>Tên khoa</span>
        <input type="text" name="name" placeholder="Mã lớp" value="<?= $subject['name'] ?>" required>
        <?php if (!empty($errorMaSv)) echo "<span style='color:red;'>$errorMaSv</span><br>"; ?>
    </div>
    <div>
        <span>Mã môn học</span>
        <input type="text" name="subject_code" placeholder="Mã môn học" value="<?= $subject['subject_code'] ?>" required>
    </div>
    <div>
        <span>Số tín chỉ</span>
        <input type="text" name="credits" placeholder="Số tín chỉ" value="<?= $subject['credits'] ?>" required>
    </div>
    <div>
        <span>Lớp</span>
        <select name="department_id" required>
            <option value="">-- Chọn lớp --</option>

            <?php foreach ($department as $class): ?>
                <option
                    value="<?= $class['id'] ?>"
                    <?= ($class['id'] == $subject['department_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($class['faculty_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <i class="fa-solid fa-school"></i>
    </div>

    <input type="submit" value="Sửa thông tin" name="btn_edit">
</form>
<?php
$content = ob_get_clean();
include "../views/admin/layout.php";
?>