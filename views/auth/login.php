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

<body >
  
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
      <div class="input-box">
        <input type="text" name="username" placeholder="Tài Khoản" required>
        <i class="fa-solid fa-envelope"></i>
      </div>

      <div class="input-box">
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <i class="fa-solid fa-lock"></i>
      </div>

      <span  class="error"><?php echo $errorLogin ?></span>

      <div class="remember-forgot">
        <label><input type="checkbox" name="remember"> Nhớ mật khẩu</label>
        <a href="#">Quên mật khẩu?</a>
      </div>

      <button type="submit" name="btn_login" class="btn">Đăng nhập</button>

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