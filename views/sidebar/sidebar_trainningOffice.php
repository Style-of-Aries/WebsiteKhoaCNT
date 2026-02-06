<h2>Trang phòng đào tạo</h2>
<ul class="menu">

    <li class="<?= ($currentController == 'trainningOffice' && $currentAction == 'getAll') ? 'active' : '' ?>">
        <a href="index.php?controller=trainningOffice&action=getAll" class="menu-link">
            <i class='bx bx-id-card'></i>Thông tin sinh viên
        </a>
    </li>

</ul>
<!-- <?php
echo $currentController . ' - ' . $currentAction;
?> -->