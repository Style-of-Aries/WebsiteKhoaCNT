<?php
require_once __DIR__ . "/../../config/config.php";

$user = $_SESSION['user'] ?? null;
$role = $user['role'] ?? 'guest';
$fullName = $user['full_name'] ?? 'Guest';
$gender = $user['gender'] ?? 'Nam';

$currentController = $_GET['controller'] ?? '';
$currentAction = $_GET['action'] ?? '';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng thông tin sinh viên</title>

    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/userNew.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/layoutUser.css">
    <!-- <link rel="stylesheet" href="<?= BASE_URL ?>css/admin.css"> -->

</head>

<body>
    <div class="flash-message">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success" id="autoHideAlert">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error" id="autoHideAlert">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>

    <!-- HEADER -->
    <header class="portal-header">

        <!-- LEFT -->
        <div class="header-left">
            <i class='bx bxs-graduation'></i>
            <?php if ($role === 'student'): ?>
                <span>Cổng thông tin sinh viên</span>
            <?php elseif ($role === 'lecturer'): ?>
                <span>Cổng thông tin giảng viên</span>
            <?php endif; ?>
        </div>

        <!-- NAV -->
        <nav class="header-nav">
            <?php if ($role === 'student'): ?>
                <!-- <a href="index.php" class="<?= $currentController == '' ? 'active' : '' ?>">Trang chủ</a> -->
                <a href="?controller=student&action=profile">Hồ sơ</a>
                <a href="?controller=student&action=getCourseClass">Môn học</a>
                <a href="?controller=student&action=lichHoc">Lịch học   </a>
                <a href="?controller=student&action=getAllResult">Kết quả học tập</a>
            <?php endif; ?>

            <?php if ($role === 'lecturer'): ?>
                <!-- <a href="index.php">Trang chủ</a> -->
                <a href="?controller=lecturer&action=getCourseClass">Lớp dạy</a>
                <!-- <a href="?controller=lecturer&action=updateResultByCourseClass">Chấm điểm</a> -->
                <a href="?controller=lecturer&action=lichDayGv">Lịch dạy</a>
            <?php endif; ?>
        </nav>

        <!-- RIGHT -->
        <div class="header-right">

            <i class='bx bx-bell'></i>

            <div class="user-menu">
                <img src="<?= BASE_URL ?>img/<?= $gender === 'Nam' ? 'male.jpg' : 'avatar-nu.jpg' ?>">
                <span><?= htmlspecialchars($fullName) ?></span>
                <i class='bx bx-chevron-down'></i>

                <div class="user-dropdown">
                    <!-- <a href="#">👤 Hồ sơ</a> -->
                    <a href="index.php?controller=auth&action=logout">🚪 Đăng xuất</a>
                </div>
            </div>

        </div>

    </header>

    <div class="container"></div>
    <div class="layout">
        <!-- CONTENT -->
        <main class="portal-content">
            <?php echo $content ?? '' ?>
        </main>
    </div>
    <script src="<?= BASE_URL ?>js/user.js"></script>
</body>


</html>