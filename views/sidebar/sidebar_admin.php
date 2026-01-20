<h2>Quản lý</h2>
<ul class="menu">

    <li class="<?= ($currentController=='admin' && $currentAction=='index') ? 'active' : '' ?>">
        <a href="index.php?controller=admin&action=index" class="menu-link">
            <i class="ri-bar-chart-fill"></i> Tổng quan
        </a>
    </li>

    <li class="<?= ($currentController=='admin' && $currentAction=='getAllUser') ? 'active' : '' ?>">
        <a href="index.php?controller=admin&action=getAllUser" class="menu-link">
            <i class="bx bxs-user"></i> Danh Sách Người Dùng
        </a>
    </li>

    <li class="<?= ($currentController=='admin' && $currentAction=='getAllSinhVien') ? 'active' : '' ?>">
        <a href="index.php?controller=admin&action=getAllSinhVien" class="menu-link">
            <i class="bx bxs-graduation"></i> Danh Sách Sinh Viên
        </a>
    </li>

    <li class="<?= ($currentController=='admin' && $currentAction=='getAllGiangVien') ? 'active' : '' ?>">
        <a href="index.php?controller=admin&action=getAllGiangVien" class="menu-link">
            <i class="bx bxs-user-badge"></i> Danh Sách Giảng Viên
        </a>
    </li>

    <li class="<?= ($currentController=='classes' && $currentAction=='getAllLopHoc') ? 'active' : '' ?>">
        <a href="index.php?controller=classes&action=getAllLopHoc" class="menu-link">
            <i class="bx bxs-group"></i> Danh Sách Lớp Học
        </a>
    </li>

    <li class="<?= ($currentController=='department' && $currentAction=='getAllKhoa') ? 'active' : '' ?>">
        <a href="index.php?controller=department&action=getAllKhoa" class="menu-link">
            <i class="bx bxs-building"></i> Danh Sách Khoa
        </a>
    </li>

    <li class="<?= ($currentController=='subject' && $currentAction=='getAllMonHoc') ? 'active' : '' ?>">
        <a href="index.php?controller=subject&action=getAllMonHoc" class="menu-link">
            <i class="bx bxs-book"></i> Danh Sách Môn học
        </a>
    </li>

</ul>

