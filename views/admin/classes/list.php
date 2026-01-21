<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>
<!-- <style>
    a{

        text-decoration: none;
        color: white;
    }
    
  .add {
    width: 200px;
    height: 30px;
    border: 1px solid;
    margin-bottom: 20px;
    border-radius: 20px;
    display: flex;
    align-items: center;
  justify-content: center;
  background-color: #1ca522ff;
  }
  .add>a{
    width: 100%;  
    display: inline-block;
    line-height: 30px;
    margin: 5px;
    text-decoration: none;
    color: #fff;
  }
</style> -->

<div class="container-admin">
  <div class="lop-header">
    <h2>Danh sách lớp học</h2>
    <div class="add">
      <a href="index.php?controller=admin&action=addGiangVien">
        <i class="ri-add-circle-line"></i>
        Thêm Lớp Học Mới</a>
    </div>
    <table class="main-table">
      <thead>
        <tr>
          <th>STT</th>
          <th>Tên lớp</th>
          <th>Mã lớp</th>
          <th>Khoa</th>
          <th>Giáo viên chủ nhiệm</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($classes as $index => $class): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($class['class_name']) ?></td>
            <td><?= htmlspecialchars($class['class_code']) ?></td>
            <td><?= htmlspecialchars($class['department_name']) ?></td>
            <td><?= htmlspecialchars($class['lecturer_name']) ?></td>
            <td>
              <a href="index.php?controller=classes&action=getAllSinhVienCuaLop&id=<?= $class['id'] ?>&user=<?=$class['class_name'] ?>" class="action-btn yt-btn"><i class="ri-pencil-line"></i>Xem danh sách sinh viên</a>
              <a href="index.php?controller=classes&action=editLh&id=<?= $class['id'] ?>&user=<?=$class['class_name'] ?>" class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
              <a href="index.php?controller=classes&action=deleteLh&id=<?= $class['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Xóa lớp học này?')"><i class="ri-delete-bin-line"></i> Xóa</a>
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