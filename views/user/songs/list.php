<?php
ob_start();
?>

<h2>Danh sách bài hát</h2>
<?php 
shuffle($songs); 
shuffle($songsHTH);
shuffle($songsDomic);
shuffle($songsDrt);
shuffle($songsEXSH);
shuffle($songsMTP);
shuffle($songsWn);
shuffle($songsWren);
?>
<div class="playlist-container">
    <?php foreach ($songs as $index => $song): ?>
        <div class="card list-item" data-playlist="all" data-index="<?= $index; ?>" data-id="<?= $song['id']; ?>"
            data-name="<?= $song['name']; ?>" data-img="<?= $song['image']; ?>" data-artist="<?= $song['artist']; ?>"
            data-song="<?= $song['fileSong']; ?>">
            <img src="<?= $song['image'] ?>" alt="" class="thumbnail">
            <div class="play-btn">
                <i class="fa-solid fa-play play-icon"></i>
            </div>
            <div class="info">
                <h3><?= htmlspecialchars(string: $song['name']) ?></h3>
                <p><?= htmlspecialchars($song['artist']) ?></p>
            </div>
        </div>
    <?php endforeach ?>
</div>
<h2>HIEUTHUHAI</h2>
<div class="playlist-container">
    <?php foreach ($songsHTH as $index => $song): ?>
        <div class="card list-item" data-playlist="duongdomic" data-index="<?= $index; ?>" data-id="<?= $song['id']; ?>"
            data-name="<?= $song['name']; ?>" data-img="<?= $song['image']; ?>" data-artist="<?= $song['artist']; ?>"
            data-song="<?= $song['fileSong']; ?>">
            <img src="<?= $song['image'] ?>" alt="" class="thumbnail">
            <div class="play-btn">
                <i class="fa-solid fa-play play-icon"></i>
            </div>
            <div class="info">
                <h3><?= htmlspecialchars(string: $song['name']) ?></h3>
                <p><?= htmlspecialchars($song['artist']) ?></p>
            </div>
        </div>
    <?php endforeach ?>
</div>
<h2>Wren Evans</h2>
<div class="playlist-container">
    <?php foreach ($songsWren as $index => $song): ?>
        <div class="card list-item" data-playlist="duongdomic" data-index="<?= $index; ?>" data-id="<?= $song['id']; ?>"
            data-name="<?= $song['name']; ?>" data-img="<?= $song['image']; ?>" data-artist="<?= $song['artist']; ?>"
            data-song="<?= $song['fileSong']; ?>">
            <img src="<?= $song['image'] ?>" alt="" class="thumbnail">
            <div class="play-btn">
                <i class="fa-solid fa-play play-icon"></i>
            </div>
            <div class="info">
                <h3><?= htmlspecialchars(string: $song['name']) ?></h3>
                <p><?= htmlspecialchars($song['artist']) ?></p>
            </div>
        </div>
    <?php endforeach ?>
</div>
<h2>Sơn Tùng MTP</h2>
<div class="playlist-container">
    <?php foreach ($songsMTP as $index => $song): ?>
        <div class="card list-item" data-playlist="duongdomic" data-index="<?= $index; ?>" data-id="<?= $song['id']; ?>"
            data-name="<?= $song['name']; ?>" data-img="<?= $song['image']; ?>" data-artist="<?= $song['artist']; ?>"
            data-song="<?= $song['fileSong']; ?>">
            <img src="<?= $song['image'] ?>" alt="" class="thumbnail">
            <div class="play-btn">
                <i class="fa-solid fa-play play-icon"></i>
            </div>
            <div class="info">
                <h3><?= htmlspecialchars(string: $song['name']) ?></h3>
                <p><?= htmlspecialchars($song['artist']) ?></p>
            </div>
        </div>
    <?php endforeach ?>
</div>
<h2>Dangrangto</h2>
<div class="playlist-container">
    <?php foreach ($songsDrt as $index => $song): ?>
        <div class="card list-item" data-playlist="duongdomic" data-index="<?= $index; ?>" data-id="<?= $song['id']; ?>"
            data-name="<?= $song['name']; ?>" data-img="<?= $song['image']; ?>" data-artist="<?= $song['artist']; ?>"
            data-song="<?= $song['fileSong']; ?>">
            <img src="<?= $song['image'] ?>" alt="" class="thumbnail">
            <div class="play-btn">
                <i class="fa-solid fa-play play-icon"></i>
            </div>
            <div class="info">
                <h3><?= htmlspecialchars(string: $song['name']) ?></h3>
                <p><?= htmlspecialchars($song['artist']) ?></p>
            </div>
        </div>
    <?php endforeach ?>
</div>
<h2>W/n</h2>
<div class="playlist-container">
    <?php foreach ($songsWn as $index => $song): ?>
        <div class="card list-item" data-playlist="duongdomic" data-index="<?= $index; ?>" data-id="<?= $song['id']; ?>"
            data-name="<?= $song['name']; ?>" data-img="<?= $song['image']; ?>" data-artist="<?= $song['artist']; ?>"
            data-song="<?= $song['fileSong']; ?>">
            <img src="<?= $song['image'] ?>" alt="" class="thumbnail">
            <div class="play-btn">
                <i class="fa-solid fa-play play-icon"></i>
            </div>
            <div class="info">
                <h3><?= htmlspecialchars(string: $song['name']) ?></h3>
                <p><?= htmlspecialchars($song['artist']) ?></p>
            </div>
        </div>
    <?php endforeach ?>
</div>
<h2>Dương Domic</h2>
<div class="playlist-container">
    <?php foreach ($songsDomic as $index => $song): ?>
        <div class="card list-item" data-playlist="duongdomic" data-index="<?= $index; ?>" data-id="<?= $song['id']; ?>"
            data-name="<?= $song['name']; ?>" data-img="<?= $song['image']; ?>" data-artist="<?= $song['artist']; ?>"
            data-song="<?= $song['fileSong']; ?>">
            <img src="<?= $song['image'] ?>" alt="" class="thumbnail">
            <div class="play-btn">
                <i class="fa-solid fa-play play-icon"></i>
            </div>
            <div class="info">
                <h3><?= htmlspecialchars(string: $song['name']) ?></h3>
                <p><?= htmlspecialchars($song['artist']) ?></p>
            </div>
        </div>
    <?php endforeach ?>
</div>
<h2>EXSH</h2>
<div class="playlist-container">
    <?php foreach ($songsEXSH as $index => $song): ?>
        <div class="card list-item" data-playlist="EXSH" data-index="<?= $index; ?>" data-id="<?= $song['id']; ?>"
            data-name="<?= $song['name']; ?>" data-img="<?= $song['image']; ?>" data-artist="<?= $song['artist']; ?>"
            data-song="<?= $song['fileSong']; ?>">
            <img src="<?= $song['image'] ?>" alt="" class="thumbnail">
            <div class="play-btn">
                <i class="fa-solid fa-play play-icon"></i>
            </div>
            <div class="info">
                <h3><?= htmlspecialchars(string: $song['name']) ?></h3>
                <p><?= htmlspecialchars($song['artist']) ?></p>
            </div>
        </div>
    <?php endforeach ?>
</div>
<?php
$mainContent = ob_get_clean();
include __DIR__ . '/../layout/layout.php';
?>