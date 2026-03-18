<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>

<div class="container-admin">
  <div class="gv-header">
    <h2>Danh sách sinh viên</h2>
    <form method="GET" action="index.php" class="search-form">
      <input type="hidden" name="controller" value="admin">
      <input type="hidden" name="action" value="getAllSinhVien">

      <input type="text" name="keyword" placeholder="Tìm theo tên, mã SV, email, khoa, lớp..."
        value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">

      <button type="submit">
        <i class="ri-search-line"></i> Tìm kiếm
      </button>
    </form>


    <div class="add">
      <a href="index.php?controller=admin&action=addSinhVien">
        <i class="ri-add-circle-line"></i> Thêm Sinh Viên Mới
      </a>
    </div>
  </div>

  <table class="main-table">
    <thead>
      <tr>
        <th>STT</th>
        <th>Tên sinh viên</th>
        <th>Mã sinh viên</th>
        <th>Email</th>
        <th>Khoa</th>
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
include "../views/admin/layout.php";
?>