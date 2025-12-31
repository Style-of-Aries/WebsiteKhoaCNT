<style>
    .artist-info {
        /* layout */
        display: flex;
        align-items: center;
        gap: 24px;
        width: 100%;
        /* max-width: 1100px; */
        margin: 0 auto 28px;
        padding: 18px;
        box-sizing: border-box;

        /* visual */
        /* background: linear-gradient(180deg, rgba(15,23,42,0.95), rgba(32,44,71,0.9)); */
        color: #fff;
        border-radius: 14px;
        position: relative;
        overflow: hidden;

        /* make this area approx 20% of viewport height */
        min-height: 20vh;
        align-items: center;
    }

    /* subtle decorative band behind content (gives depth as blurred image would) */
    .artist-info::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.02), rgba(0, 0, 0, 0.08));
        pointer-events: none;
        mix-blend-mode: overlay;
    }

    /* avatar */
    .artist-info img {
        width: 140px;
        height: 140px;
        min-width: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.14);
        box-shadow: 0 8px 30px rgba(2, 6, 23, 0.6);
        transform: translateZ(0);
    }

    /* text block */
    .artist-info h2 {
        font-size: 1.9rem;
        line-height: 1.05;
        margin: 0 0 6px;
        letter-spacing: -0.5px;
        color: #ffffff;
        font-weight: 700;
    }

    /* optional short description if present */
    .artist-info p {
        margin: 0;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.95rem;
        max-width: 60ch;
        opacity: 0.95;
    }

    /* right-side controls container example (if you want play/follow) */
    .artist-controls {
        margin-left: auto;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    /* example button style */
    .artist-controls .btn {
        background: rgba(255, 255, 255, 0.09);
        color: #fff;
        border: 0;
        padding: 10px 14px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(2, 6, 23, 0.4);
    }

    /* small viewport adjustments */
    @media (max-width: 900px) {
        .artist-info {
            padding: 16px;
            gap: 16px;
            min-height: 180px;
            /* ensure enough space when height is small */
        }

        .artist-info img {
            width: 110px;
            height: 110px;
            min-width: 110px;
        }

        .artist-info h2 {
            font-size: 1.4rem;
        }

        .artist-info p {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .artist-info {
            flex-direction: column;
            text-align: center;
            padding: 18px 12px;
            min-height: auto;
        }

        .artist-info img {
            width: 96px;
            height: 96px;
            min-width: 96px;
        }

        .artist-controls {
            margin-left: 0;
        }
    }
</style>
<?php
ob_start();
?>
<!-- <h2><?php echo $_GET['name']  ?></h2> -->

<?php if (!empty($songs)): ?>
    <div class="artist-info">
        <img src="<?= $songs[0]['artist_image'] ?>"
            alt="<?= htmlspecialchars($songs[0]['artist_name']) ?>"
            width="200">
        <h2><?= htmlspecialchars($songs[0]['artist_name']) ?></h2>
    </div>
<?php endif; ?>

<?php foreach ($songs as $index => $song): ?>
    <div class="card bxh-item" data-index="<?= $index; ?>" data-id="<?= $song['song_id']; ?>" data-name="<?= $song['song_name']; ?>"
        data-img="<?= $song['song_image']; ?>" data-artist="<?= $song['artist']; ?>" data-song="<?= $song['fileSong']; ?>">
        <div class="bxh-number"><?= $index + 1 ?></div>

        <div class="bxh-thumb-wrapper">
            <img src="<?= $song['song_image'] ?>" alt="<?= htmlspecialchars($song['song_name']) ?>" class="bxh-thumb">
            <div class="play-btn">
                <i class="fa-solid fa-play play-icon"></i>
            </div>
        </div>

        <div class="bxh-title"><?= htmlspecialchars($song['song_name']) ?></div>
        <div class="bxh-artist"><?= htmlspecialchars($song['artist']) ?></div>
        <div id="bxh-timeSong"><?= $song['duration'] ?></div>
        <!-- <div class="favoriteBtn" data-id="<?= $song['id']; ?>">
      <i class="fa-regular fa-heart"></i>
    </div> -->
    </div>
<?php endforeach; ?>

<?php
$mainContent = ob_get_clean();
include __DIR__ . '/../layout/layout.php';
?>