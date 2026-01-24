<?php
require_once __DIR__ . "/../../config/config.php";
$currentController = $_GET['controller'] ?? '';
$currentAction = $_GET['action'] ?? '';


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
    <link rel="stylesheet" href="<?= BASE_URL ?>css/layout.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/user.css">
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
            <i class='bx bxs-chevron-down'></i>
            <div class="dropboxAdmin">
                <a href="index.php?controller=auth&action=logout" class="btn-logout">
                    🚪 Đăng Xuất
                </a>
            </div>
        </div>
    </div>

    <div class="layout">

        <div class="sidebar">
            <?php
            $currentController = $_GET['controller'] ?? '';
            $currentAction = $_GET['action'] ?? '';

            if (isset($_SESSION['user'])) {
                $role = $_SESSION['user']['role'];
                if ($role === 'admin') {
                    include __DIR__ . '/../sidebar/sidebar_admin.php';
                } elseif ($role === 'student') {
                    include __DIR__ . '/../sidebar/sidebar_student.php';
                } else {
                    include __DIR__ . '/../sidebar/sidebar_lecturer.php';
                }
            }
            ?>
        </div>
        <div class="main-content">
            <?php echo $content ?? '' ?>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= BASE_URL ?>js/admin.js"></script>
    <script src="<?= BASE_URL ?>js/user.js"></script>

</body>

</html>