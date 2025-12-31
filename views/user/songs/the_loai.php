<?php
ob_start();
?>
<h2>Thể loại</h2>


<div class="playlist-container">
    <?php foreach ($theloai as $index => $song): ?>
        <td class="card list-item">
            <a href="index.php?controller=user&action=songTheLoai&id=<?= $song['id'] ?>&name=<?= $song['ten_the_loai'] ?>">
        <div class="card list-item">
            <img src="<?= $song['image'] ?>" alt="" class="thumbnail"></a></td>
            <!-- <div class="play-btn">
                <i class="fa-solid fa-play play-icon"></i>
            </div> -->
            <div class="info">
                <h3><?= htmlspecialchars(string: $song['ten_the_loai']) ?></h3>
            </div>
        </div>

    <?php endforeach ?>
</div>
<?php
$mainContent = ob_get_clean();
include __DIR__ . '/../layout/layout.php';