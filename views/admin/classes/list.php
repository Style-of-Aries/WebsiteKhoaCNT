<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>
<style>
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
</style>

<h2>Danh sách lớp học</h2>
<div class="add">
  <a href="index.php?controller=classes&action=addLopHoc">
    <i class="ri-add-circle-line"></i> 
    Thêm Lớp Học Mới</a>
</div>
</style>
<!-- <h2>Danh sách ngươi dùng</h2> -->

      <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>id</th>
            <th>Tên lớp</th>
            <th>Mã lớp</th>
            <th>Khoa</th>
            <th>Giảng viên chủ nghiệm</th>
            <th>Hành Động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($classes as $index => $user): ?>
          <tr>
            <td><?= $index +1   ?></td>
            <td><?= $user['id']   ?></td>
            <td><a href="index.php?controller=admin&action=yeuThich&id=<?= $user['id'] ?>&user=<?=$user['class_name'] ?>"><?= htmlspecialchars($user['class_name']) ?></a></td>
            <td><?= htmlspecialchars($user['class_code']) ?></td>
            <td><?= htmlspecialchars($user['department_name']) ?></td>
            <td><?= htmlspecialchars($user['lecturer_name']) ?></td>
            <td>
              <!-- <a href="index.php?controller=admin&action=yeuThich&id=<?= $user['id'] ?>&user=<?=$user['full_name'] ?>" class="action-btn yt-btn"><i class="ri-pencil-line"></i>Danh sách yêu thích</a> -->
              <a href="index.php?controller=classes&action=getAllSinhVienCuaLop&id=<?= $user['id'] ?>&user=<?=$user['class_name'] ?>" class="action-btn yt-btn"><i class="ri-pencil-line"></i>Xem danh sách sinh viên</a>
              <a href="index.php?controller=classes&action=editLh&id=<?= $user['id'] ?>&user=<?=$user['class_name'] ?>" class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
              <a href="index.php?controller=classes&action=deleteLh&id=<?= $user['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Xóa lớp học này?')"><i class="ri-delete-bin-line"></i> Xóa</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>


<?php
$content=ob_get_clean();
include "../views/admin/layout.php";
?>
