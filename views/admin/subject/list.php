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

<h2>Danh sách môn học</h2>
<div class="add">
  <a href="index.php?controller=subject&action=addMonHoc">
    <i class="ri-add-circle-line"></i> 
    Thêm Môn Học Mới</a>
</div>
</style>
<!-- <h2>Danh sách ngươi dùng</h2> -->

      <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Tên môn học</th>
            <th>Mã môn học</th>
            <th>Số tín chỉ</th>
            <th>Ban quản lý</th>
            <th>Hành Động</th>
            <!-- <th>Hành Động</th> -->
          </tr>
        </thead>
        <tbody>
          <?php foreach ($subjects as $index => $user): ?>
          <tr>
            <td><?= $index +1   ?></td>
            <!-- <td><?= $user['id']   ?></td> -->
            <td><?= htmlspecialchars($user['name']) ?></a></td>
            <td><?= htmlspecialchars($user['subject_code']) ?></td>
            <td><?= htmlspecialchars($user['credits']) ?></td>
            <td><?= htmlspecialchars($user['department_name']) ?></td>
            <td>
              <!-- <a href="index.php?controller=subjects&action=getAll&id=<?= $user['id'] ?>&user=<?=$user['name'] ?>" class="action-btn yt-btn"><i class="ri-pencil-line"></i>Danh sách giảng viên</a> -->
              <a href="index.php?controller=subjects&action=editMonHoc&id=<?= $user['id'] ?>&user=<?=$user['name'] ?>" class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
              <a href="index.php?controller=subjects&action=deleteMonHoc&id=<?= $user['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Xóa lớp học này?')"><i class="ri-delete-bin-line"></i> Xóa</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>


<?php
$content=ob_get_clean();
include "../views/admin/layout.php";
?>
