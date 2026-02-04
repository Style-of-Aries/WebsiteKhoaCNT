<?php
require_once __DIR__ . "/../../config/config.php";

$user = $_SESSION['user'] ?? null;
$role = $user['role'] ?? 'guest';
$name = $user['name'] ?? 'Guest';
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

<!-- HEADER -->
<header class="portal-header">

  <!-- LEFT -->
  <div class="header-left">
    <i class='bx bxs-graduation'></i>
    <span>Student Portal</span>
  </div>

  <!-- NAV -->
  <nav class="header-nav">
    <?php if ($role === 'student'): ?>
      <a href="index.php" class="<?= $currentController==''?'active':'' ?>">Trang chủ</a>
      <a href="?controller=student&action=getCourseClass">Môn học</a>
      <a href="?controller=student&action=lichHoc">Lịch học</a>
      <a href="?controller=student&action=getAllResult">Điểm</a>
    <?php endif; ?>

    <?php if ($role === 'lecturer'): ?>
      <a href="index.php">Trang chủ</a>
      <a href="?controller=lecturer&action=classes">Lớp học</a>
      <a href="?controller=lecturer&action=grading">Chấm điểm</a>
      <a href="?controller=lecturer&action=stats">Thống kê</a>
    <?php endif; ?>

    <?php if ($role === 'admin'): ?>
      <a href="index.php">Dashboard</a>
      <a href="?controller=admin&action=users">Người dùng</a>
      <a href="?controller=admin&action=students">Sinh viên</a>
      <a href="?controller=admin&action=settings">Cài đặt</a>
    <?php endif; ?>
  </nav>

  <!-- RIGHT -->
  <div class="header-right">

    <i class='bx bx-bell'></i>

    <div class="user-menu">
      <img src="<?= BASE_URL ?>img/<?= $gender === 'Nam' ? 'male.jpg' : 'avatar-nu.jpg' ?>">
      <span><?= htmlspecialchars($name) ?></span>
      <i class='bx bx-chevron-down'></i>

      <div class="user-dropdown">
        <a href="#">👤 Hồ sơ</a>
        <a href="index.php?controller=auth&action=logout">🚪 Đăng xuất</a>
      </div>
    </div>

  </div>

</header>

<!-- CONTENT -->
<main class="portal-content">
  <?php echo $content ?? '' ?>
</main>

</body>
</html>
