<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>
<div class="container-admin">
  <div class="subject-header">
<h2>Danh sách môn học</h2>
<div class="add">
  <a href="index.php?controller=course_classes&action=addHocPhan">
    <i class="ri-add-circle-line"></i> 
    Thêm Học Phần Mới</a>
</div>
</style>
<!-- <h2>Danh sách ngươi dùng</h2> -->

      <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
    <table class="main-table">
      <thead>
        <tr>
          <th>STT</th>
          <th>Mã lớp</th>
          <th>Môn học</th>
          <th>Giảng viên</th>
          <th>Học kỳ</th>
          <th>Số lượng tối đa</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($course_classes as $index => $subject): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($subject['class_code']) ?></td>
            <td><?= htmlspecialchars($subject['subject_name']) ?></td>
            <td><?= htmlspecialchars($subject['lecturer_name']) ?></td>
            <td><?= htmlspecialchars($subject['semester_name']) ?></td>
            <td><?= htmlspecialchars($subject['max_students']) ?></td>
            <td>
              <a href="index.php?controller=course_classes&action=lichHoc&id=<?= $subject['id'] ?>&user=<?=$subject['subject_name'] ?>" class="action-btn yt-btn"><i class="ri-pencil-line"></i>Lịch học</a>
              <a href="index.php?controller=course_classes&action=editHocPhan&id=<?= $subject['id']?>" class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
              <a href="index.php?controller=course_classes&action=deleteHocPhan&id=<?= $subject['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Xóa học phần này?')"><i class="ri-delete-bin-line"></i> Xóa</a>
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
