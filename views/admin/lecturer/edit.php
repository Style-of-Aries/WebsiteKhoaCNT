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


<h2>Sửa thông tin giảng viên:<?= $user['full_name'] ?> </h2>

<form class="song-form" action="index.php?controller=admin&action=editGiangVien" method="POST" enctype="multipart/form-data">
     <input type="hidden" name="id" value=" <?= $user['id'] ?>">
    <div>
        <span>Họ và tên</span>
        <input type="text" name="full_name" placeholder="Họ và tên" value="<?= $user['full_name'] ?>" required>
    </div>
    <div>
        <span>Mã giảng viên</span>
        <input type="text" name="lecturer_code" placeholder="Mã giảng viên" value="<?= $user['lecturer_code'] ?>" required>
          <?php if (!empty($errorMaSv)) echo "<span style='color:red;'>$errorMaSv</span><br>"; ?>
    </div>
    <div>
        <span>Email</span>
        <input type="text" name="email" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <i class="fa-solid fa-envelope"></i>
         <?php if (!empty($errorEmail)) echo "<span style='color:red;'>$errorEmail</span><br>"; ?>
    </div>
    <!-- <div>
        <span>Lớp</span>
        <input type="text" name="class_id" placeholder="Lớp" value="<?= htmlspecialchars($user['class_id']) ?>" required>
        <i class="fa-solid fa-envelope"></i>
    </div> -->
    <div>
        <label>Tên đăng nhập</label>
        <input type="text" name="username" placeholder="Tài khoản" value="<?= $userNd['username'] ?>" required>
          <?php if (!empty($errorName)) echo "<span style='color:red;'>$errorName</span><br>"; ?>
    </div>
    <div>
        <span>Mật khẩu:</span>
        <input type="text" name="password" placeholder="Mật khẩu" value="<?= $userNd['password'] ?>" required>
        <i class="fa-solid fa-lock"></i>
    </div>
    <input type="submit" value="Sửa thông tin" name="btn_edit">
</form>
<?php
$content = ob_get_clean();
include "../views/admin/layout.php";
?>