<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>

<div class="admin-table-wrapper">
  <div class="table-toolbar">
    <h2>Danh sách Sinh viên</h2>
    <input type="text" id="searchTable" placeholder="Tìm kiếm sinh viên, mã sinh viên, email...">
  </div>
  <!-- <div class="add">
    <a href="index.php?controller=admin&action=addSinhVien">
      <i class="ri-add-circle-line"></i> Thêm Sinh Viên Mới
    </a>
  </div> -->

  <button class="add-button" onclick="location.href='index.php?controller=admin&action=addSinhVien'">
    <div class="sign">+</div>
    <div class="text">Thêm Sinh Viên Mới</div>
  </button>

  <table class="main-table" id="mainTable">
    <thead>
      <tr>
        <th onclick="sortTable(0)">STT</th>
        <th onclick="sortTable(1)">Tên sinh viên</th>
        <th onclick="sortTable(2)">Mã sinh viên</th>
        <th onclick="sortTable(3)">Email</th>
        <th onclick="sortTable(4)">Khoa</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($students as $index => $user): ?>
        <tr>
          <td><?= $index + 1 ?></td>
          <td><?= htmlspecialchars($user['full_name']) ?></td>
          <td><?= htmlspecialchars($user['student_code']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= htmlspecialchars($user['department_name']) ?></td>
          <td>
            <a href="index.php?controller=admin&action=chiTiet&id=<?= $user['id'] ?>&full_name=<?= $user['full_name'] ?>"
              class="action-btn edit-btn"><i class="ri-pencil-line"></i>Chi tiết</a>
            <a href="index.php?controller=admin&action=editSv&id=<?= $user['id'] ?>&full_name=<?= $user['full_name'] ?>"
              class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
            <a href="index.php?controller=admin&action=deleteStudent&id=<?= $user['id'] ?>" class="action-btn delete-btn"
              onclick="return confirm('Xóa người dùng này?')"><i class="ri-delete-bin-line"></i> Xóa</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</div>



<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>