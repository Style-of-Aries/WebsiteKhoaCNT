<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>
<div class="container-admin">
  <div class="subject-header">
<h2>Danh sách môn học</h2>
<div class="add">
  <a href="index.php?controller=subject&action=addMonHoc">
    <i class="ri-add-circle-line"></i> 
    Thêm Môn Học Mới</a>
</div>
</style>
<!-- <h2>Danh sách ngươi dùng</h2> -->

      <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
    <table class="main-table">
      <thead>
        <tr>
          <th>STT</th>
          <th>Tên môn học</th>
          <th>Mã môn học</th>
          <th>Số tín chỉ</th>
          <th>Ban quản lý</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($subjects as $index => $subject): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($subject['name']) ?></td>
            <td><?= htmlspecialchars($subject['subject_code']) ?></td>
            <td><?= htmlspecialchars($subject['credits']) ?></td>
            <td><?= htmlspecialchars($subject['department_name']) ?></td>
            <td>
              <!-- <a href="index.php?controller=subject&action=getAllSinhVienCuaMonHoc&id=<?= $subject['id'] ?>&user=<?=$subject['name'] ?>" class="action-btn yt-btn"><i class="ri-pencil-line"></i>Xem danh sách sinh viên</a> -->
              <a href="index.php?controller=subject&action=editMonHoc&id=<?= $subject['id'] ?>&user=<?=$subject['name'] ?>" class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
              <a href="index.php?controller=subject&action=deleteMonHoc&id=<?= $subject['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Xóa môn học này?')"><i class="ri-delete-bin-line"></i> Xóa</a>
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
