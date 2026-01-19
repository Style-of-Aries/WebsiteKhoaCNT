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


<h2>Thêm Môn hoch</h2>

<form class="song-form" action="index.php?controller=subject&action=add" method="POST" enctype="multipart/form-data">
    <div>
        <label>Tên Môn học</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>Mã Môn học</label>
        <input type="text" name="subject_code" required>
    </div>
    <div>
        <label>Số tín chỉ</label>
        <input type="text" name="credits" required>
    </div>
    
    <div>
        <span>Khoa</span>
        <select name="department_id" required>
            <option value="">-- Chọn khoa --</option>
            <?php foreach ($department as $department): ?>
                <option value="<?= $department['id'] ?>">
                    <?= htmlspecialchars($department['faculty_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <i class="fa-solid fa-school"></i>
    </div>

    
    <input type="submit" value="Thêm môn học" name="btn_add">
</form>
<?php
$content = ob_get_clean();
include "../views/admin/layout.php";
?>