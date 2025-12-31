<?php
ob_start();
?>
<h2>Ca sĩ</h2>


<div class="playlist-container">
    <?php foreach ($nghesi as $index => $song): ?>
        <td class="card list-item"><a href="index.php?controller=user&action=tacgia&id=<?= $song['id'] ?>&name=<?= $song['name'] ?>">
        <div class="card list-item">
            <img src="<?= $song['image'] ?>" alt="" class="thumbnail"></a></td>
            <!-- <div class="play-btn">
                <i class="fa-solid fa-play play-icon"></i>
            </div> -->
            <div class="info">
                <h3><?= htmlspecialchars(string: $song['name']) ?></h3>
            </div>
        </div>

    <?php endforeach ?>
</div>
<?php
$mainContent = ob_get_clean();
include __DIR__ . '/../layout/layout.php';
?>