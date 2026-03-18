<?php require_once __DIR__ . "/../../config/config.php"; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>css/auth.css">
<!-- <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</style>
<div class="khung">
    <!-- <div class="logoWeb">
        <img src="<?= BASE_URL ?>img/logoMusic.jpg" alt="">
    </div> -->
    <form action="index.php?controller=auth&action=auth_register" method="post">
        <h2>Đăng ký</h2>

        <div class="input-box">
            <input type="text" name="username" placeholder="Tên đăng nhập" value="<?php echo $vlName; ?>" required>
            <i class="fa-solid fa-user"></i>
            <span class="error"><?php echo $errorName ?></span>
        </div>

        <div class="input-box">
            <input type="email" name="email" placeholder="Email" value="<?php echo $vlEmail; ?>" required>
            <i class="fa-solid fa-envelope"></i>
            <span class="error"><?php echo $errorEmail ?></span>
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder="Mật khẩu" value="<?php echo $vlPass; ?>" required>
            <i class="fa-solid fa-lock"></i>
            <span class="error"><?php echo $errorPass ?></span>
        </div>

        <div class="input-box">
            <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu"
                value="<?php echo $vlCfPass; ?>" required>
            <i class="fa-solid fa-lock"></i>
            <span class="error"><?php echo $errorCfPass ?></span>
        </div>

        <!-- <div class="input-box">
            <input type="number" name="phone" placeholder="Số điện thoại" value="<?php echo $vlSdt; ?>" required>
            <i class="fa-solid fa-phone"></i>
            <span class="error"><?php echo $errorsdt ?></span>
        </div> -->

        <button type="submit" name="btn_register" class="btn">Đăng ký</button>

        <div class="register-link">
            <p>Đã có tài khoản? <a href="index.php?controller=auth&action=login">Đăng nhập</a></p>
        </div>
    </form>
</div>