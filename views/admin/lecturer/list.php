<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>

<div class="container-admin">
  <div class="gv-header">
    <h2>Danh sách giảng viên</h2>
    <form method="GET" action="index.php" class="search-form">
      <input type="hidden" name="controller" value="admin">
      <input type="hidden" name="action" value="getAllGiangVien">
      <input type="text" name="keyword" placeholder="Tìm theo tên, mã GV, email, khoa..."
        value="<?= $_GET['keyword'] ?? '' ?>">
      <button type="submit">
        <i class="ri-search-line"></i> Tìm kiếm
      </button>
    </form>

    <div class="add">
      <a href="index.php?controller=admin&action=addGiangVien">
        <i class="ri-add-circle-line"></i>
        Thêm Giảng Viên Mới</a>
    </div>
    <table class="main-table">
      <thead>
        <tr>
          <th>STT</th>
          <th>Tên giảng viên</th>
          <th>Mã giảng viên</th>
          <th>Email</th>
          <th>Khoa</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($lecturers as $index => $lecture): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($lecture['full_name']) ?></td>
            <td><?= htmlspecialchars($lecture['lecturer_code']) ?></td>
            <td><?= htmlspecialchars($lecture['email']) ?></td>
            <td><?= htmlspecialchars($lecture['name']) ?></td>
            <td>
              <a href="index.php?controller=admin&action=editGV&id=<?= $lecture['id'] ?>&user=<?= $lecture['full_name'] ?>"
                class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
              <a href="index.php?controller=admin&action=deleteLecturer&id=<?= $lecture['id'] ?>"
                class="action-btn delete-btn" onclick="return confirm('Xóa giảng viên này?')"><i
                  class="ri-delete-bin-line"></i> Xóa</a>
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