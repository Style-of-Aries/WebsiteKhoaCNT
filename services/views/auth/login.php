<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
  <?php
  require_once __DIR__ . "/../../config/config.php";
  ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>css/auth.css">
  <!-- <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css"> -->
  </style>
</head>

<body>

  <div class="khung">
    <!-- <div class="logoWeb">
      <img src="<?= BASE_URL ?>img/logoMusic.jpg" alt="">
    </div> -->
    <form action="index.php?controller=auth&action=auth_login" method="post">
      <h2>Đăng nhập</h2>
      <!-- <div class="input-box">
        <input type="text" name="email" placeholder="Email" required>
        <i class="fa-solid fa-envelope"></i>
      </div> -->
      <!-- From Uiverse.io by pharmacist-sabot -->
      <!-- <div class="glitch-input-wrapper">
        <div class="input-box">
          <input type="username" name="username" id="holo-input" class="holo-input" placeholder="" required="" />
          <label for="holo-input" class="input-label" data-text="Tên người dùng">Tên người dùng</label>

          <div class="input-border"></div>
          <div class="input-scanline"></div>
          <div class="input-glow"></div>

          <div class="input-data-stream">
            <div class="stream-bar" style="--i: 0;"></div>
            <div class="stream-bar" style="--i: 1;"></div>
            <div class="stream-bar" style="--i: 2;"></div>
            <div class="stream-bar" style="--i: 3;"></div>
            <div class="stream-bar" style="--i: 4;"></div>
            <div class="stream-bar" style="--i: 5;"></div>
            <div class="stream-bar" style="--i: 6;"></div>
            <div class="stream-bar" style="--i: 7;"></div>
            <div class="stream-bar" style="--i: 8;"></div>
            <div class="stream-bar" style="--i: 9;"></div>
          </div>

          <div class="input-corners">
            <div class="corner corner-tl"></div>
            <div class="corner corner-tr"></div>
            <div class="corner corner-bl"></div>
            <div class="corner corner-br"></div>
          </div>
        </div>
      </div>

      <div class="glitch-input-wrapper">
        <div class="input-box">
          <input type="password" name="password" id="holo-input" class="holo-input" placeholder="" required="" />
          <label for="holo-input" class="input-label" data-text="Mật khẩu">Mật khẩu</label>

          <div class="input-border"></div>
          <div class="input-scanline"></div>
          <div class="input-glow"></div>

          <div class="input-data-stream">
            <div class="stream-bar" style="--i: 0;"></div>
            <div class="stream-bar" style="--i: 1;"></div>
            <div class="stream-bar" style="--i: 2;"></div>
            <div class="stream-bar" style="--i: 3;"></div>
            <div class="stream-bar" style="--i: 4;"></div>
            <div class="stream-bar" style="--i: 5;"></div>
            <div class="stream-bar" style="--i: 6;"></div>
            <div class="stream-bar" style="--i: 7;"></div>
            <div class="stream-bar" style="--i: 8;"></div>
            <div class="stream-bar" style="--i: 9;"></div>
          </div>

          <div class="input-corners">
            <div class="corner corner-tl"></div>
            <div class="corner corner-tr"></div>
            <div class="corner corner-bl"></div>
            <div class="corner corner-br"></div>
          </div>
        </div>
      </div> -->


      <div class="input-box">
        <input required="" type="text" name="username" autocomplete="off" class="input">
        <label class="user-label">Tên người dùng</label>
        <i class="fa-solid fa-user"></i>
      </div>
      <div class="input-box">
        <input required="" type="password" name="password" autocomplete="off" class="input">
        <label class="user-label">Mật khẩu</label>
        <i class="fa-solid fa-lock"></i>
      </div>

      <span class="error"><?php echo $errorLogin ?></span>

      <div class="remember-forgot">
        <label><input type="checkbox" name="remember"> Nhớ mật khẩu</label>
        <a href="#">Quên mật khẩu?</a>
      </div>

      <!-- <button type="submit" name="btn_login" class="btn">Đăng nhập</button> -->
      <button type="submit" name="btn_login">
        Đăng nhập
        <div class="arrow-wrapper">
          <div class="arrow"></div>
        </div>
      </button>

      <div class="register-link">
        <!-- <p>Bạn chưa có tài khoản? <a href="index.php?controller=auth&action=register">Đăng ký</a></p> -->
      </div>
    </form>

    <!-- <h2>Đăng nhập</h2>
    <form action="index.php?action=auth_login" method="post">
      <input type="" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Mật khẩu" required>
      <span class="errorLogin"><?php echo $errorLogin ?></span>
      <button type="submit" name="btn_login">Đăng nhập</button>
    </form> -->
    <!-- <button class="login-btn google">
      <i class="fab fa-google"></i> Tiếp tục bằng Google
    </button>

    <button class="login-btn facebook">
     <i class="fab fa-facebook"></i> Tiếp tục bằng Facebook
    </button>

    <button class="login-btn apple">
      <i class="fab fa-apple"></i> Tiếp tục bằng Apple
    </button> -->
    <!-- <p>Bạn chưa có tài khoản?<a href="index.php?controller=auth&action=register">Đăng ký tài khoản</a></p> -->
  </div>
</body>


</html>