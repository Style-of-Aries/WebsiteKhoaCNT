<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>
<div class="container-admin">
  <div class="user-header">
    <h2>Danh sách người dùng</h2>
    <table class="main-table">
      <thead>
        <tr>
          <th>STT</th>
          <th>Tên đăng nhập</th>
          <th>Mật khẩu</th>
          <th>Vai trò</th>
          <th>id Sinh viên/Giảng viên</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $index => $user): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['password']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td><?= htmlspecialchars($user['ref_id']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>



  <!-- <h2>Danh sách ngươi dùng</h2> -->

  <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->



  <?php
  $content = ob_get_clean();
  include "../views/admin/layout.php";
  ?>