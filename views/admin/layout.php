<?php
require_once __DIR__ . "/../../config/config.php";
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminNvt</title>
    <!-- Remix Icon: đẹp, phổ biến, hiện đại -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/admin.css">
</head>

<body>
    <div class="header">
        <!-- <p>Hệ thống quản lý sinh viên</p> -->
        <div class="title">
            <i class='bx bxs-graduation'></i>
            Hệ thống quản lý sinh viên
        </div>
        <div class="avatar">
            <?php
            $name = $_SESSION['user']['name'] ?? 'Admin';
            $gender = $_SESSION['user']['gender'] ?? 'Nam';
            if ($gender === 'Nam'): ?>
                <img src="<?= BASE_URL ?>img/male.jpg" alt="avatar" id="avatarBtn">
            <?php else: ?>
                <img src="<?= BASE_URL ?>img/avatar-nu.jpg" alt="avatar" id="avatarBtn">
            <?php endif; ?>
            <?= $name ?>
            <div class="dropboxAdmin">
                <a href="index.php?controller=auth&action=logout" class="menu-link">
                    🚪 Đăng Xuất
                </a>
            </div>
        </div>
    </div>

    <div class="layout">

        <div class="sidebar">
            <!-- <img src="./../admin/1/img/php.png" alt="logo" class="logo"> -->
            <h2>Quản lý</h2>
            <ul class="menu">
                <li>
                    <a href="index.php?controller=admin&action=index" class="menu-link">
                        <i class="ri-bar-chart-fill"></i>Danh Sách Người Dùng
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=admin&action=getAllSinhVien" class="menu-link">
                        <i class="ri-bar-chart-fill"></i> Danh Sách Sinh Viên
                    </a>
                </li>

                <li>
                    <a href="index.php?controller=admin&action=getAllGiangVien" class="menu-link">
                        <i class="ri-bar-chart-fill"></i> Danh Sách Giảng Viên
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=classes&action=getAllLopHoc" class="menu-link">
                        <i class="ri-bar-chart-fill"></i> Danh Sách Lớp Học
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=department&action=getAllKhoa" class="menu-link">
                        <i class="ri-bar-chart-fill"></i> Danh Sách Khoa
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=auth&action=logout" class="menu-link">
                        🚪 Đăng Xuất
                    </a>
                </li>
            </ul>

        </div>
        <div class="main-content">
            <?php echo $content ?? '' ?>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= BASE_URL ?>js/admin.js"></script>
    
</body>

</html>