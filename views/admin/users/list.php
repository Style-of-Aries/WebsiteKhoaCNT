<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>
<div class="admin-table-wrapper">
  <div class="table-toolbar">
    <h2>Danh sách Người dùng</h2>
    <input type="text" id="searchTable" placeholder="Tìm kiếm người dùng, tên đăng nhập, vai trò...">
  </div>
  <div class="table-wrap">
    <table class="main-table" id="mainTable">
      <thead>
        <tr>
          <th onclick="sortTable(0)">STT</th>
          <th onclick="sortTable(1)">Tên đăng nhập</th>
          <th onclick="sortTable(2)">Mật khẩu</th>
          <th onclick="sortTable(3)">Vai trò</th>
          <th onclick="sortTable(4)">ID tham chiếu</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $index => $user): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['password']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td class="ref_id"><?= htmlspecialchars($user['ref_id']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>



<!-- <h2>Danh sách ngươi dùng</h2> -->

<!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->



<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>