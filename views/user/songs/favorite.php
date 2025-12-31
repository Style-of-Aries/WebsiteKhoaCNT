<h2>Danh sách yêu thích</h2>

<?php foreach ($favories as $index => $song): ?>
  <div class="card favorite-item" data-index="<?= $index; ?>" data-id="<?= $song['id']; ?>"
    data-name="<?= $song['name']; ?>" data-img="<?= $song['image']; ?>" data-artist="<?= $song['artist']; ?>"
    data-song="<?= $song['fileSong']; ?>">

    <!-- <div class="favorite-number"><?= $index + 1 ?></div> -->

    <div class="favorite-thumb-wrapper">
      <img src="<?= $song['image'] ?>" alt="<?= htmlspecialchars($song['name']) ?>" class="favorite-thumb">
      <div class="play-btn">
        <i class="fa-solid fa-play play-icon"></i>
      </div>
    </div>

    <div class="favorite-title"><?= htmlspecialchars($song['name']) ?></div>
    <div class="favorite-artist"><?= htmlspecialchars($song['artist']) ?></div>
    <div id="bxh-timeSong"><?= $song['duration'] ?></div>
    <div class="favoriteBtn" data-id="<?= $song['id']; ?>">
      <i class="fa-solid fa-heart"></i>
    </div>
  </div>
<?php endforeach; ?>