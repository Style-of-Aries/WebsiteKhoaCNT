<?php
ob_start();
?>
<h2>Thông tin người dùng</h2>
<!-- views/admin/songs/list.php -->
 
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
  table {
  width: 90%;
  margin: 40px auto;
  border-collapse: collapse;
  border-radius: 12px;
  overflow: hidden;
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(10px);
  box-shadow: 0 0 15px rgba(255, 0, 128, 0.3);
  color: #fff;
  font-family: "Poppins", sans-serif;
}

thead {
  background: linear-gradient(90deg, #ff007f, #00d4ff);
}

thead th {
  padding: 15px;
  text-align: left;
  font-size: 16px;
  letter-spacing: 0.5px;
  text-transform: uppercase;
}

tbody tr {
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  transition: background 0.3s ease;
}

tbody tr:hover {
  background: rgba(255, 0, 128, 0.15);
}

tbody td {
  padding: 12px 15px;
  font-size: 15px;
}

/* Liên kết hành động */
.action-btn {
  display: inline-block;
  padding: 8px 14px;
  margin: 2px;
  border-radius: 6px;
  font-size: 14px;
  text-decoration: none;
  transition: 0.3s;
}

.yt-btn {
  background: rgba(0, 212, 255, 0.2);
  border: 1px solid #00d4ff;
  color: #00d4ff;
}

.yt-btn:hover {
  background: #00d4ff;
  color: #000;
}

.edit-btn {
  background: rgba(255, 0, 128, 0.2);
  border: 1px solid #ff007f;
  color: #ff007f;
}

.edit-btn:hover {
  background: #ff007f;
  color: #000;
}

.delete-btn {
  background: rgba(255, 50, 50, 0.2);
  border: 1px solid #ff3232;
  color: #ff3232;
}

.delete-btn:hover {
  background: #ff3232;
  color: #000;
}

/* Liên kết username */
td a {
  color: #00d4ff;
  text-decoration: none;
}

td a:hover {
  color: #ff007f;
  text-shadow: 0 0 10px #ff007f;
}

</style>

</style>
      <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
      <table>
        <thead>
          <tr>
            <!-- <th>#</th> -->
            <th>UserName</th>
            <th>Email</th>
            <th>PassWord</th>
            <!-- <th>Số điện thoại</th> -->
            <th>Hành Động</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($user as $index => $user): ?>
          <tr>
            <!-- <td><?= $user['id']   ?></td> -->
            <!-- <td><?= $index +1   ?></td> -->
            <td><a href="index.php?controller=admin&action=yeuThich&id=<?= $user['id'] ?>&user=<?=$user['username'] ?>"><?= htmlspecialchars($user['username']) ?></a></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['password']) ?></td>
            <td>
              <a href="index.php?controller=user&action=favorite" class="action-btn yt-btn"><i class="ri-pencil-line"></i>Danh sách yêu thích</a>
              <a href="index.php?controller=user&action=edit_User&id=<?= $user['id'] ?>&user=<?=$user['username'] ?>" class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa thông tin</a>
              <!-- <a href="index.php?controller=admin&action=deleteUser&id=<?= $user['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Xóa người dùng này?')"><i class="ri-delete-bin-line"></i> Xóa người dùng</a> -->
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>

      
      
<?php
$mainContent = ob_get_clean();
include __DIR__ . '/../layout/layout.php';
?>