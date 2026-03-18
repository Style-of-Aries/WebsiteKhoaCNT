<h2>Trang sinh viên</h2>
<ul class="menu">

    <li class="<?= ($currentController == 'student' && $currentAction == 'profile') ? 'active' : '' ?>">
        <a href="index.php?controller=student&action=profile" class="menu-link">
            <i class='bx bx-id-card'></i>Thông tin lý lịch
        </a>
    </li>

    <li class="<?= ($currentController == 'student' && $currentAction == 'lichHoc') ? 'active' : '' ?>">
        <a href="index.php?controller=student&action=lichHoc" class="menu-link">
            <i class='bx bx-calendar'></i>Thời khóa biểu
        </a>
    </li>

    <!-- <li class="<?= ($currentController == 'admin' && $currentAction == 'getAllSinhVien') ? 'active' : '' ?>">
        <a href="index.php?controller=admin&action=getAllSinhVien" class="menu-link">
            <i class="bx bx-calendar-event"></i> Lịch thi
        </a>
    </li> -->

    <li class="<?= ($currentController == 'student' && $currentAction == 'getAllResult') ? 'active' : '' ?>">
        <a href="index.php?controller=student&action=getAllResult" class="menu-link">
           <i class='bx bx-bar-chart-alt-2'></i> Kết quả học tập
        </a>
    </li>

    <!-- <li class="<?= ($currentController == 'classes' && $currentAction == 'getAllLopHoc') ? 'active' : '' ?>">
        <a href="index.php?controller=classes&action=getAllLopHoc" class="menu-link">
            <i class="bx bx-medal"></i> Điểm rèn luyện
        </a>
    </li> -->

    <li class="<?= ($currentController == 'student' && $currentAction == 'getCourseClass') ? 'active' : '' ?>">
        <a href="index.php?controller=student&action=getCourseClass" class="menu-link">
            <i class="bx bx-wallet"></i> Đăng ký lớp
        </a>
    </li>

    <!-- <li class="<?= ($currentController == 'subject' && $currentAction == 'getAllMonHoc') ? 'active' : '' ?>">
        <a href="index.php?controller=subject&action=getAllMonHoc" class="menu-link">
            <i class="bx bxs-book"></i> Danh Sách Môn học
        </a>
    </li> -->

</ul>
<!-- <?php
echo $currentController . ' - ' . $currentAction;
?> -->