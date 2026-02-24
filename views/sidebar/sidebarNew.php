<?php
// include __DIR__ .'./../../config/permission.php';
require_once __DIR__ . "/../../services/PermissionService.php";
$role = $_SESSION['user']['role'];
// var_dump($role);
// var_dump(PermissionService::has($role, 'attendance'));
// die;

?>

<div class="logo">
    <a href="index.php?controller=admin&action=index" class="logo-link">
        <img src="<?= BASE_URL ?>img/logo-truong.png" alt="">
        <span>HPC</span>
    </a>
</div>
<!-- <ul class="navi">
    <li class="dropdown">
        <a href="index.php?controller=admin&action=index" class="drop-btn">Trang chủ</a>
    </li>
    <li class="dropdown">
        <a class="drop-btn">Quản lý ▸</a>
        <ul class="submenu">
            <li><a href="index.php?controller=admin&action=getAllUser">Người dùng</a></li>
            <li><a href="index.php?controller=department&action=getAllKhoa">Khoa</a></li>
            <li><a href="index.php?controller=subject&action=getAllMonHoc">Môn học</a></li>
            <li><a href="index.php?controller=classes&action=getAllLopHoc">Lớp hành chính</a></li>
            <li><a href="index.php?controller=course_classes&action=getAllHocPhan">Lớp học phần</a></li>
            <li><a href="index.php?controller=admin&action=getAllGiangVien">Giảng viên</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="index.php?controller=admin&action=getAllSinhVien" class="drop-btn">Quản lý hồ sơ sinh viên</a>
    </li>
    <li class="dropdown">
        <a class="drop-btn">Quản lý học tập ▸</a>
        <ul class="submenu">
            <li><a href="#">Điểm danh</a></li>
            <li><a href="#">Điểm thành phần</a></li>
            <li><a href="#">Điểm thi</a></li>
            <li><a href="#">Tra cứu điểm</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a class="drop-btn">Quản lý thời khóa biểu</a>
    </li>
</ul> -->
<ul class="navi">
    <li class="<?= PermissionService::has($role, 'dashboard') ? 'dropdown' : 'locked' ?>">
        <a class="drop-btn" href="index.php?controller=admin&action=index">Trang chủ</a>
    </li>
    <li class="<?= PermissionService::has($role, 'students') ? 'dropdown' : 'locked' ?>">
        <a class="drop-btn" href="index.php?controller=admin&action=getAllUser">Người dùng</a>
    </li>
    <li class="dropdown">
        <a class="drop-btn">Đào tạo ▸</a>
        <ul class="submenu">

            <li class="<?= PermissionService::has($role, 'departments') ? 'dropdown' : 'locked' ?>">
                <a href="index.php?controller=department&action=getAllKhoa">Khoa</a>
            </li>

            <li class="<?= PermissionService::has($role, 'subjects') ? 'dropdown' : 'locked' ?>">
                <a href="index.php?controller=subject&action=getAllMonHoc">Môn học</a>
            </li>

            <li class="<?= PermissionService::has($role, 'classes') ? 'dropdown' : 'locked' ?>">
                <a href="index.php?controller=classes&action=getAllLopHoc">Lớp hành chính</a>
            </li>

            <li class="<?= PermissionService::has($role, 'course_classes') ? 'dropdown' : 'locked' ?>">
                <a href="index.php?controller=course_classes&action=getAllHocPhan">Lớp học phần</a>
            </li>

        </ul>
    </li>

    <li class="<?= PermissionService::has($role, 'students') ? 'dropdown' : 'locked' ?>">
        <a class="drop-btn" href="index.php?controller=admin&action=getAllSinhVien">Hồ sơ sinh viên</a>
    </li>

    <li class="dropdown">
        <a class="drop-btn">Kết quả học tập ▸</a>
        <ul class="submenu">

            <li class="<?= PermissionService::has($role, 'attendance') ? 'dropdown' : 'locked' ?>">
                <a href="index.php?controller=lecturer&action=getCourseClass&type=attendance">Điểm danh</a>
            </li>

            <li class="<?= PermissionService::has($role, 'score') ? 'dropdown' : 'locked' ?>">
                <a href="index.php?controller=lecturer&action=getCourseClass&type=score">Nhập điểm</a>
            </li>

            <li class="<?= PermissionService::has($role, 'view_scores') ? 'dropdown' : 'locked' ?>">
                <a href="index.php?controller=lecturer&action=getCourseClass">Tra cứu điểm</a>
            </li>

        </ul>
    </li>

    <li class="<?= PermissionService::has($role, 'timetable') ? 'dropdown' : 'locked' ?>">
        <a class="drop-btn" href="index.php?controller=timetable&action=getAllTkb">Thời khóa biểu</a>
    </li>

</ul>

<div class="btn-logout">
    <button class="logoutBtn" onclick="location.href='index.php?controller=auth&action=logout'">
        <div class="sign"><svg viewBox="0 0 512 512">
                <path
                    d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z">
                </path>
            </svg></div>
        <div class="text">Đăng xuất</div>
    </button>
</div>