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
    <link rel="stylesheet" href="<?= BASE_URL ?>css/layoutAdmin.css">
    <link rel="icon" href="<?= BASE_URL ?>img/favicon_io/favicon.ico" type="image/x-icon">
</head>

<body>
    <div class="layout">
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

        <div class="header">
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
            </div>
        </div>


        <div class="sidebar">
            <?php
            $currentController = $_GET['controller'] ?? '';
            $currentAction = $_GET['action'] ?? '';
            require_once __DIR__ . '/../sidebar/sidebarNew.php';
            ?>
        </div>

        <div class="main-content">
            <?php echo $content ?? '' ?>
        </div>
    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= BASE_URL ?>js/adminNew.js"></script>
</body>

</html>