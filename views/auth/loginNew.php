<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <?php
    require_once __DIR__ . "/../../config/config.php";
    ?>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/authNew.css">
</head>
    
<body>
    <header class="header">
        <nav class="navbar">
            <a href="#" class="nav-link">Home</a>
            <a href="#" class="nav-link">About</a>
            <a href="#" class="nav-link">Services</a>
            <a href="#" class="nav-link">Contact</a>
        </nav>

        <form action="#" class="search-bar">
            <input type="text" placeholder="Search.....">
            <button type="submit"><i class='bx  bx-search'></i> </button>
        </form>
    </header>
    <div class="background"></div>
    <div class="container">
        <div class="content">
            <h2 class="logo"><i class='bx bxs-graduation'></i>HPC</h2>
            <div class="text-sci">
                <h2>Welcome!<br><span>To Our Website.</span></h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.</p>
                <div class="social-icons">
                    <a href="https://www.facebook.com/ductrong34"><i class='bx bxl-facebook'></i></a>
                    <a href="https://www.tiktok.com/@style_of_aries"><i class='bx bxl-tiktok'></i></a>
                    <a href="https://www.instagram.com/n_d_t__34/"><i class='bx bxl-instagram'></i></a>
                    <a href="https://github.com/Style-of-Aries"><i class='bx bxl-github'></i></a>
                </div>
            </div>
        </div>

        <div class="logreg-box">
            <div class="form-box login">
                <form action="index.php?controller=auth&action=auth_login" method="post">
                    <h2>Sign In</h2>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-user'></i></span>
                        <input name="username" type="text" required>
                        <label>Username</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input name="password" type="password" required>
                        <label>Password</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox">Remember me</label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" name="btn_login" class="btn">Login</button>
                    <!-- <div class="login-register">
                        <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
                    </div> -->
                </form>
            </div>
            <!-- <div class="form-box register">
                <form action="#">
                    <h2>Sign Up</h2>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
                        <input type="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-user'></i></span>
                        <input type="text" required>
                        <label>Username</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input type="password" required>
                        <label>Password</label>
                    </div>
                    <button type="submit" class="btn">Register</button>
                    <div class="login-register">
                        <p>Already have an account? <a href="#" class="login-link">Login</a></p>
                    </div>
                </form>
            </div> -->
        </div>
    </div>
    <!-- <script src="script.js"></script> -->
</body>
</html>