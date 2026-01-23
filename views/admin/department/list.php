<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>
<div class="container-admin">
  <div class="department-header">
<h2>Danh sách Khoa</h2>
<div class="add">
  <a href="index.php?controller=department&action=addKhoa">
    <i class="ri-add-circle-line"></i> 
    Thêm Khoa Mới</a>
</div>
</style>
<!-- <h2>Danh sách ngươi dùng</h2> -->

      <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
    <table class="main-table">
      <thead>
        <tr>
          <th>STT</th>
          <th>Tên Khoa</th>
          <th>Loại đơn vị</th>
          <th>Thuộc</th>
          <th>Giáo viên</th>
          <th>Ngày thành lập</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($departments as $index => $department): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($department['faculty_name']) ?></td>
            <td><?= htmlspecialchars($department['type']) ?></td>
            <td><?= htmlspecialchars($department['parent_name']) ?></td>
            <td><?= htmlspecialchars($department['staff_count']) ?></td>
            <td><?= htmlspecialchars($department['created_at']) ?></td>
            <td>
              <a href="index.php?controller=department&action=getAllGiangVienCuaKhoa&id=<?= $department['id'] ?>&user=<?=$department['faculty_name'] ?>" class="action-btn yt-btn"><i class="ri-pencil-line"></i>Xem danh sách sinh viên</a>
              <a href="index.php?controller=department&action=editKhoa&id=<?= $department['id'] ?>&user=<?=$department['faculty_name'] ?>" class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
              <a href="index.php?controller=department&action=deleteKhoa&id=<?= $department['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Xóa lớp học này?')"><i class="ri-delete-bin-line"></i> Xóa</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
$content=ob_get_clean();
include "../views/admin/layout.php";
?>
