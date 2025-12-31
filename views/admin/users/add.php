<?php
ob_start();
?>
<style>
    .error {
        color: red;
        /* margin-left: px; */
        margin-bottom: 10px;
        margin-top: 10px;
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
    input[type="file"],
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

<h2>Thêm mới người dùng</h2>
<form class="song-form" action="index.php?controller=admin&action=admin_register" method="POST" enctype="multipart/form-data">
    <div>
        <input type="text" name="username" placeholder="Tên đăng nhập" value="<?php echo $vlName; ?>" required>
        <!-- <i class="fa-solid fa-user"></i> -->
        <span class="error"><?php echo $errorName ?></span>
    </div>
    <div>
        <input type="text" name="email" placeholder="Email" value="<?php echo $vlEmail; ?>" required>
        <i class="fa-solid fa-envelope"></i>
        <span class="error"><?php echo $errorEmail ?></span>
    </div>
    <div>
        <input type="text" name="password" placeholder="Mật khẩu" value="<?php echo $vlPass; ?>" required>
        <i class="fa-solid fa-lock"></i>
        <span class="error"><?php echo $errorPass ?></span>
    </div>
    <div>
        <input type="text" name="confirm_password" placeholder="Xác nhận mật khẩu"
            value="<?php echo $vlCfPass; ?>" required>
        <i class="fa-solid fa-lock"></i>
        <span class="error"><?php echo $errorCfPass ?></span>
    </div>
    <div>
        <label for="role">Quyền người dùng:</label>
        <select name="role_id" id="role" required>
            <option value="2" selected>Người dùng (User)</option>
            <option value="1">Quản trị viên (Admin)</option>
        </select>
    </div>
    <input type="submit" value="Thêm mới người dùng" name="btn_register">
</form>




<?php
$content = ob_get_clean();
include "../views/admin/layout.php";
?>