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


<h2>Thêm Khoa</h2>

<form class="song-form" action="index.php?controller=department&action=add" method="POST" enctype="multipart/form-data">
    <div>
        <label>Tên Khoa</label>
        <input type="text" name="name" required>
        <!-- <i class="fa-solid fa-user"></i> -->
        <!-- <small class="error" id="error-title"></small> -->
    </div>
    
    
    <div>
        <label>Loại</label><br>
        <select name="type" required>
            <option value="">-- Chọn loại --</option>
            <option value="school">Trường</option>
            <option value="faculty">Khoa</option>
            <option value="department">Bộ môn</option>
        </select>
    </div>
    <div>
        <label>Đơn vị cha</label><br>
        <select name="parent_id">
            <option value="">-- Không có --</option>
            <?php while ($row = mysqli_fetch_assoc($parents)) { ?>
                <option value="<?= $row['id'] ?>">
                    <?= $row['name'] ?>
                </option>
            <?php } ?>
        </select>
    </div>

    
    <input type="submit" value="Thêm lớp học" name="btn_add">
</form>
<?php
$content = ob_get_clean();
include "../views/admin/layout.php";
?>