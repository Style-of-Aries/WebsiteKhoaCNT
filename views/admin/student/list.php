<!-- views/admin/songs/list.php -->
<?php
//  require_once "./../../../config/config.php";
?>
<?php
ob_start();
?>
<div class="container-admin">
  <div class="sv-header">
    <h2>Danh sách sinh viên</h2>
    <div class="add">
      <a href="index.php?controller=admin&action=addSinhVien">
        <i class="ri-add-circle-line"></i>
        Thêm Sinh Viên Mới</a>
    </div>
  </div>
  <?php foreach ($students as $index => $user): ?>
    <div class="student-card">
      <div class="student-avatar">
        <img src="<?= BASE_URL ?>/upload/avatar/<?= $user['avatar'] ?>" alt="avatar">
      </div>

      <div class="student-info">
        <div class="btnManager">
          <h3><?= htmlspecialchars($user['full_name']) ?></h3>
          <a href="index.php?controller=user&action=getAllResult&id=<?= $user['student_code'] ?>&full_name=<?= $user['full_name'] ?>"
            class="action-btn view-btn"><i class="ri-bar-chart-line"></i>Bảng điểm</a> 
          <a href="index.php?controller=admin&action=editSv&id=<?= $user['student_code'] ?>&full_name=<?= $user['full_name'] ?>"
            class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
          <a href="index.php?controller=admin&action=deleteStudent&id=<?= $user['id'] ?>" class="action-btn delete-btn"
            onclick="return confirm('Xóa người dùng này?')"><i class="ri-delete-bin-line"></i> Xóa</a>
        </div>
        <div class="info-grid">
          <div class="info-item">
            <i class='bx bx-user' data-label="Mã sinh viên"></i>
            <span><?= htmlspecialchars($user['student_code']) ?></span>
          </div>

          <div class="info-item">
            <i class='bx bx-calendar' data-label="Ngày sinh"></i>
            <span><?= htmlspecialchars($user['date_of_birth']) ?></span>
          </div>
          <div class="info-item">
            <i class='bx bx-male-female' data-label="Giới tính"></i>
            <span><?= htmlspecialchars($user['gender']) ?></span>
          </div>

          <div class="info-item">
            <i class='bx bx-sitemap' data-label="Khoa"></i>
            <span><?= htmlspecialchars($user['department_name']) ?></span>
          </div>
          <div class="info-item">
            <i class='bx bx-book' data-label="Lớp"></i>
            <span><?= htmlspecialchars($user['class_name']) ?></span>
          </div>

          <div class="info-item">
            <i class='bx bx-envelope' data-label="Email"></i>
            <span><?= htmlspecialchars($user['email']) ?></span>
          </div>

          <div class="info-item">
            <i class='bx bx-phone' data-label="Số điện thoại"></i>
            <span><?= htmlspecialchars($user['phone']) ?></span>
          </div>

          <div class="info-item">
            <i class='bx bx-id-card' data-label="CCCD / CMND"></i>
            <span><?= htmlspecialchars($user['identity_number']) ?></span>
          </div>

          <div class="info-item">
            <i class='bx bxs-graduation' data-label="Hệ đào tạo"></i>
            <span><?= htmlspecialchars($user['education_type']) ?></span>
          </div>

          <div class="info-item">
            <i class='bx bx-check-circle' data-label="Trạng thái"></i>
            <span><?= htmlspecialchars($user['status']) ?></span>
          </div>
          <div class="info-item">
            <i class='bx bx-calendar-event' data-label="Thời gian nhập học"></i>
            <span><?= htmlspecialchars($user['created_at']) ?></span>
          </div>

          <div class="info-item">
            <i class='bx bx-home' data-label="Địa chỉ"></i>
            <span><?= htmlspecialchars($user['address']) ?></span>
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