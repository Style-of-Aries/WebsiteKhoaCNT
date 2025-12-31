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

<h2>Sửa thông tin người dùng</h2>
<form class="song-form" action="index.php?controller=user&action=editUser" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value=" <?= $user['id'] ?>">
    <div>
        <label for="">Tên đăng nhập: </label>
        <input type="text" name="username" placeholder="Tên đăng nhập" value="<?= $user['username'] ?>" required>
        <!-- <i class="fa-solid fa-user"></i> -->
        <?php if (!empty($errorName)) echo "<span style='color:red;'>$errorName</span><br>"; ?>
    </div>
    <div>
        <label for="">Email: </label>
        <input type="text" name="email" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <!-- <i class="fa-solid fa-envelope"></i> -->
        <?php if (!empty($errorEmail)) echo "<span style='color:red;'>$errorEmail</span><br>"; ?>
    </div>
    <div>
        <label for="">Mật khẩu:</label>
        <input type="text" name="password" placeholder="Mật khẩu" value="<?= $user['password'] ?>" required>
        <!-- <i class="fa-solid fa-lock"></i> -->
    </div>
    <input type="submit" value="Lưu" name="btn_editUser">
</form>



<?php
$mainContent = ob_get_clean();
include __DIR__ . '/../layout/layout.php';
?>