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

<h2>Danh sách người dùng</h2>
<div class="add">
  <a href="index.php?controller=admin&action=addUser">
    <i class="ri-add-circle-line"></i> 
    Thêm Người Dùng Mới</a>
</div>
</style>
<!-- <h2>Danh sách ngươi dùng</h2> -->

      <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>UserName</th>
            <!-- <th>Email</th> -->
            <th>PassWord</th>
            <th>Role</th>
            <th>id</th>
            <th>Hành Động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $index => $user): ?>
          <tr>
            <!-- <td><?= $user['id']   ?></td> -->
            <td><?= $index +1   ?></td>
            <td><a href="index.php?controller=admin&action=yeuThich&id=<?= $user['id'] ?>&user=<?=$user['username'] ?>"><?= htmlspecialchars($user['username']) ?></a></td>
            <td><?= htmlspecialchars($user['password']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td><?= htmlspecialchars($user['ref_id']) ?></td>
            <td>
              <!-- <a href="index.php?controller=admin&action=yeuThich&id=<?= $user['id'] ?>&user=<?=$user['username'] ?>" class="action-btn yt-btn"><i class="ri-pencil-line"></i>Danh sách yêu thích</a> -->
              <a href="index.php?controller=admin&action=edit_User&id=<?= $user['id'] ?>&user=<?=$user['username'] ?>" class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa thông tin</a>
              <a href="index.php?controller=admin&action=deleteUser&id=<?= $user['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Xóa người dùng này?')"><i class="ri-delete-bin-line"></i> Xóa người dùng</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>


<?php
$content=ob_get_clean();
include "../views/admin/layout.php";
?>
