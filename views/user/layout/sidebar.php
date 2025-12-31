<input type="checkbox" id="toggle-menu" hidden>
<aside class="sidebar">
    <div class="logoWeb">
        <a href="index.php?controller=user&action=index"><img src="<?= BASE_URL ?>img/logoMusic.jpg" alt="Logo"></a>
    </div>
    <label for="toggle-menu" class="toggle-btn">☰</label>
    <div class="sidebar-content">
        <ul class="nav-ul">
            
            <li class="nav-li"><a href="index.php?controller=user&action=index" class="ajax-link">
                    <i class="fas fa-compact-disc"></i>
                    <span>Khám phá</span>
                </a></li>
            <li class="nav-li"><a href="index.php?controller=user&action=bxh" class="ajax-link">
                    <i class="fas fa-chart-line"></i>
                    <span>BXH Nhạc Mới</span>
            <li class="nav-li"><a href="index.php?controller=user&action=nghe_si" class="ajax-link">
                    <i class="fa-solid fa-user"></i>
                    <span>Ca sĩ</span>
                </a></li>
            <li class="nav-li"><a href="index.php?controller=user&action=the_loai" class="ajax-link">
                    <i class="fa-solid fa-music"></i>
                    <span>Thể loại</span>
                </a></li> 
            <li class="nav-li"><a href="index.php?controller=user&action=favorite" class="ajax-link">
                    <i class="fa-solid fa-heart"></i>
                    <span>Yêu thích</span>
                </a></li>    
               
            <!-- <li class="nav-li rgrgr"><a href="index.php?controller=user&action=bxh" class="ajax-link">
                    <i class="fas fa-chart-line"></i>
                    <span>BXH Nhạc Mới</span>
                </a></li> -->
            <!-- <li class="nav-li dropdown">
                <input type="checkbox" id="toggle-author" hidden>
                <label for="toggle-author" class="dropdown-toggle">
                    <i class="fa-solid fa-user"></i>
                    <span class="123" >Tác giả</span>
                    <i class="fa fa-caret-down"></i>
                </label>
                <ul class="dropdown-menu">
                    <?php if (!empty($artsts)) : ?>
                        <?php foreach ($artsts as $artst): ?>
                            <li>
                                <a href="index.php?controller=user&action=tacgia&name=<?= urlencode($artst['artist']) ?>" class="ajax-link">
                                    <?= htmlspecialchars($artst['artist']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><span>Không có tác giả</span></li>
                    <?php endif; ?>
                </ul>
            </li> -->


        </ul>
    </div>
</aside>