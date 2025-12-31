<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>

<h2>Danh sách yêu thích của <?php echo $_GET['user'] ?> </h2>
      <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Ảnh</th>
            <th>Tên bài hát</th>
            <th>Ca sĩ</th>
            <th>Audio</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($songyts as $index => $songyt): ?>
          <tr>
            <!-- <td><?= $song['id']   ?></td> -->
            <td><?= $index +1   ?></td>
            <td><img src="<?= $songyt['image'] ?>" class="img-thumbnail"></td>
            <td><?= htmlspecialchars($songyt['name']) ?></td>
            <td><?= htmlspecialchars($songyt['artist']) ?></td>
            <td><audio src="<?= htmlspecialchars($songyt['fileSong']) ?>" controls  muted></audio></td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>


<?php
$content=ob_get_clean();
include "../views/admin/layout.php";
?>
