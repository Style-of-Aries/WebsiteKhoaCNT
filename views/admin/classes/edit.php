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


<h2>Sửa thông tin lớp học:<?= $user['class_name'] ?> </h2>

<form class="song-form" action="index.php?controller=classes&action=edit" method="POST" enctype="multipart/form-data">
     <input type="hidden" name="id" value=" <?= $user['id'] ?>">
    <div>
        <span>Tên lớp học</span>
        <input type="text" name="class_name" placeholder="Tên lớp học" value="<?= $user['class_name'] ?>" required>
    </div>
    <div>
        <span>Mã lớp</span>
        <input type="text" name="class_code" placeholder="Mã lớp" value="<?= $user['class_code'] ?>" required>
          <?php if (!empty($errorMaSv)) echo "<span style='color:red;'>$errorMaSv</span><br>"; ?>
    </div>
    <div>
        <span>Lớp</span>
        <select name="department_id" required>
            <option value="">-- Chọn lớp --</option>

            <?php foreach ($department as $class): ?>
                <option
                    value="<?= $class['id'] ?>"
                    <?= ($class['id'] == $user['department_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($class['faculty_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <i class="fa-solid fa-school"></i>
    </div>
    <div>
        <span>Giáo viên chủ nghiệm</span>
        <select name="lecturer_id" required>
            <option value="">-- Chọn giáo viên chủ nghiệm --</option>

            <?php foreach ($lecturer as $class): ?>
                <option
                    value="<?= $class['id'] ?>"
                    <?= ($class['id'] == $user['lecturer_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($class['full_name']) ?>
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