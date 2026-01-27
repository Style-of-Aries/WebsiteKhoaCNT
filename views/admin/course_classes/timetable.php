<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>
<div class="container-admin">
  <div class="subject-header">
<h2>Lịch học môn: <?php echo $_GET['user'] ?> </h2>
<!-- <div class="add">
  <a href="index.php?controller=course_classes&action=addHocPhan">
    <i class="ri-add-circle-line"></i> 
    Thêm Học Phần Mới</a>
</div> -->
</style>
<!-- <h2>Danh sách ngươi dùng</h2> -->

      <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
    <table class="main-table">
      <thead>
        <tr>
          <th>Mã học phần</th>
          <th>Tên học phần</th>
          <th>Giảng viên</th>
          <th>Thứ</th>
          <th>Buổi</th>
          <th>Kỳ học</th>
          <th>Năm học</th>
          <th>Phòng học</th>
          <!-- <th>Hành động</th> -->
        </tr>
      </thead>
      <tbody>
        <?php foreach ($time_tables as $index => $subject): ?>
          <tr>
            <!-- <td><?= $index + 1 ?></td> -->
            <td><?= htmlspecialchars($subject['ma_hoc_phan']) ?></td>
            <td><?= htmlspecialchars($subject['ten_hoc_phan']) ?></td>
            <td><?= htmlspecialchars($subject['giang_vien']) ?></td>
            <td><?= htmlspecialchars($subject['thu']) ?></td>
            <td><?= htmlspecialchars($subject['buoi_hoc']) ?></td>
            <td><?= htmlspecialchars($subject['ky_hoc']) ?></td>
            <td><?= htmlspecialchars($subject['nam_hoc']) ?></td>
            <td><?= htmlspecialchars($subject['phong_hoc']) ?></td>
            
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
