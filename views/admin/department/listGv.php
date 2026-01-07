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

<h2>Danh sách giảng viên khoa: <?php echo $_GET['user'] ?> </h2>
<div class="add">
  <a href="index.php?controller=admin&action=addGiangVien">
    <i class="ri-add-circle-line"></i> 
    Thêm Giảng Viên Mới</a>
</div>
</style>
<!-- <h2>Danh sách ngươi dùng</h2> -->

      <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>id</th>
            <th>Họ và tên</th>
            <!-- <th>Email</th> -->
            <th>Mã Giảng Viên</th>
            <th>Email</th>
            <th>Khoa</th>
            <th>Hành Động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($department as $index => $user): ?>
          <tr>
            <td><?= $index +1   ?></td>
            <td><?= $user['id']   ?></td>
            <td><a href="index.php?controller=admin&action=yeuThich&id=<?= $user['id'] ?>&user=<?=$user['full_name'] ?>"><?= htmlspecialchars($user['full_name']) ?></a></td>
            <td><?= htmlspecialchars($user['lecturer_code']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td>
              <!-- <a href="index.php?controller=admin&action=yeuThich&id=<?= $user['id'] ?>&user=<?=$user['full_name'] ?>" class="action-btn yt-btn"><i class="ri-pencil-line"></i>Danh sách yêu thích</a> -->
              <a href="index.php?controller=admin&action=editGv&id=<?= $user['id'] ?>&user=<?=$user['full_name'] ?>" class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
              <a href="index.php?controller=admin&action=deleteLecturer&id=<?= $user['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Xóa người dùng này?')"><i class="ri-delete-bin-line"></i> Xóa</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>


<?php
$content=ob_get_clean();
include "../views/admin/layout.php";
?>
