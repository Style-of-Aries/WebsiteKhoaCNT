<!-- views/admin/songs/list.php -->
<?php
//  require_once "./../../../config/config.php";
?>
<?php
ob_start();
?>
<div class="student">
  <div class="sv-header">
    <h2>Danh sách sinh viên</h2>
    <div class="add">
      <a href="index.php?controller=admin&action=addSinhVien">
        <i class="ri-add-circle-line"></i>
        Thêm Sinh Viên Mới</a>
    </div>
  </div>
  <!-- <h2>Danh sách ngươi dùng</h2> -->

  <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
  <!-- <table>
    <thead>
      <tr>

        <th>#</th>
        <th>id</th>
        <th>Họ và tên</th>
        <th>Mã Sinh Viên</th>
        <th>Email</th>
        <th>Lớp</th>
        <th>Hành Động</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($students as $index => $user): ?>
        <tr>
          <td><?= $index + 1 ?></td>
          <td><?= $user['id'] ?></td>
          <td><a
              href="index.php?controller=admin&action=yeuThich&id=<?= $user['id'] ?>&user=<?= $user['full_name'] ?>"><?= htmlspecialchars($user['full_name']) ?></a>
          </td>
          <td><?= htmlspecialchars($user['student_code']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= htmlspecialchars($user['class_name']) ?></td>
          <td>
            
            <a href="index.php?controller=admin&action=editSv&id=<?= $user['id'] ?>&full_name=<?= $user['full_name'] ?>"
              class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
            <a href="index.php?controller=admin&action=deleteStudent&id=<?= $user['id'] ?>" class="action-btn delete-btn"
              onclick="return confirm('Xóa người dùng này?')"><i class="ri-delete-bin-line"></i> Xóa</a>

          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table> -->
  <?php foreach ($students as $index => $user): ?>
    <div class="student-card">
      <div class="student-avatar">
        <img src="<?= BASE_URL ?>img/male.jpg" alt="avatar">
      </div>

      <div class="student-info">
        <div class="btnManager">
          <h3><?= htmlspecialchars($user['full_name']) ?></h3>
          <a href="index.php?controller=admin&action=editSv&id=<?= $user['student_code'] ?>&full_name=<?= $user['full_name'] ?>"
            class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
          <a href="index.php?controller=admin&action=deleteStudent&id=<?= $user['student_code'] ?>" class="action-btn delete-btn"
            onclick="return confirm('Xóa người dùng này?')"><i class="ri-delete-bin-line"></i> Xóa</a>
        </div>
        <div class="info-grid">
          <div class="info-item">
            <i class='bx bx-user'></i>
            <span><?= htmlspecialchars($user['student_code']) ?></span>
          </div>

          <div class="info-item">
            <i class='bx bx-calendar'></i>
            <span><?= htmlspecialchars($user['date_of_birth']) ?></span>
          </div>

          <div class="info-item">
            <i class='bx bx-book'></i>
            <span><?= htmlspecialchars($user['class_name']) ?></span>
          </div>

          <div class="info-item">
            <i class='bx bx-envelope'></i>
            <span><?= htmlspecialchars($user['email']) ?></span>
          </div>

          <div class="info-item">
            <i class='bx bx-phone'></i>
            <span><?= htmlspecialchars($user['phone']) ?></span>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach ?>
</div>

<?php
$content = ob_get_clean();
include "../views/admin/layout.php";
?>