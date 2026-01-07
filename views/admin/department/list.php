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

<h2>Danh sách Khoa</h2>
<div class="add">
  <a href="index.php?controller=department&action=addKhoa">
    <i class="ri-add-circle-line"></i> 
    Thêm Khoa Mới</a>
</div>
</style>
<!-- <h2>Danh sách ngươi dùng</h2> -->

      <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Tên Khoa</th>
            <th>Loại đơn vị</th>
            <th>Thuộc</th>
            <th>Giáo viên</th>
            <th>Ngày thành lập</th>
            <th>Hành Động</th>
            <!-- <th>Hành Động</th> -->
          </tr>
        </thead>
        <tbody>
          <?php foreach ($department as $index => $user): ?>
          <tr>
            <td><?= $index +1   ?></td>
            <!-- <td><?= $user['id']   ?></td> -->
            <td><a href="index.php?controller=admin&action=yeuThich&id=<?= $user['id'] ?>&user=<?=$user['faculty_name'] ?>"><?= htmlspecialchars($user['faculty_name']) ?></a></td>
            <td><?= htmlspecialchars($user['type']) ?></td>
            <td><?= htmlspecialchars($user['parent_name']) ?></td>
            <td><?= htmlspecialchars($user['staff_count']) ?></td>
            <td><?= htmlspecialchars($user['created_at']) ?></td>
            <!-- <td><?= htmlspecialchars($user['updated_at']) ?></td> -->
            <td>
              <a href="index.php?controller=department&action=getAllGiangVienCuaKhoa&id=<?= $user['id'] ?>&user=<?=$user['faculty_name'] ?>" class="action-btn yt-btn"><i class="ri-pencil-line"></i>Danh sách giảng viên</a>
              <a href="index.php?controller=department&action=editKhoa&id=<?= $user['id'] ?>&user=<?=$user['faculty_name'] ?>" class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
              <a href="index.php?controller=department&action=deleteKhoa&id=<?= $user['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Xóa lớp học này?')"><i class="ri-delete-bin-line"></i> Xóa</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>


<?php
$content=ob_get_clean();
include "../views/admin/layout.php";
?>
