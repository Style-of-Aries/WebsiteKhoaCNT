<h2>Trang giảng viên</h2>
<ul class="menu">

    <li class="<?= ($currentController == 'lecturer' && $currentAction == 'lichDayGv') ? 'active' : '' ?>">
        <a href="index.php?controller=lecturer&action=lichDayGv" class="menu-link">
            <i class='bx bx-calendar'></i>Lịch dạy
        </a>
    </li>

    <!-- <li class="<?= ($currentController == 'admin' && $currentAction == 'getAllSinhVien') ? 'active' : '' ?>">
        <a href="index.php?controller=admin&action=getAllSinhVien" class="menu-link">
            <i class="bx bx-calendar-event"></i> Lịch coi thi
        </a>
    </li> -->

    <li class="<?= ($currentController == 'student' && $currentAction == 'getCoureClass') ? 'active' : '' ?>">
        <a href="index.php?controller=lecturer&action=getCourseClass" class="menu-link">
           <i class='bx bxs-book'></i> Môn học
        </a>
    </li>

    <!-- <li class="<?= ($currentController == 'classes' && $currentAction == 'getAllLopHoc') ? 'active' : '' ?>">
        <a href="index.php?controller=classes&action=getAllLopHoc" class="menu-link">
            <i class="bx bx-medal"></i> Điểm rèn luyện
        </a>
    </li>

    <li class="<?= ($currentController == 'department' && $currentAction == 'getAllKhoa') ? 'active' : '' ?>">
        <a href="index.php?controller=department&action=getAllKhoa" class="menu-link">
            <i class="bx bx-wallet"></i> Học phí
        </a>
    </li>

    <li class="<?= ($currentController == 'subject' && $currentAction == 'getAllMonHoc') ? 'active' : '' ?>">
        <a href="index.php?controller=subject&action=getAllMonHoc" class="menu-link">
            <i class="bx bxs-book"></i> Danh Sách Môn học
        </a>
    </li> -->

</ul>
<!-- <?php
echo $currentController . ' - ' . $currentAction;
?> -->