<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>

<div class="admin-table-wrapper">
  <div class="table-toolbar">
    <h2>Danh sách Giảng viên</h2>
    <input type="text" id="searchTable" placeholder="Tìm kiếm giảng viên, mã giảng viên, email...">
  </div>

  <!-- <div class="add">
    <a href="index.php?controller=admin&action=addGiangVien">
      <i class="ri-add-circle-line"></i>
      Thêm Giảng Viên Mới</a>
  </div> -->
  <button class="add-button" onclick="location.href='index.php?controller=admin&action=addGiangVien'">
    <div class="sign">+</div>
    <div class="text">Thêm Giảng Viên Mới</div>
  </button>
  <div class="table-wrap">
    <table class="main-table" id="mainTable">
      <thead>
        <tr>
          <th onclick="sortTable(0)">STT</th>
          <th onclick="sortTable(1)">Tên giảng viên</th>
          <th onclick="sortTable(2)">Mã giảng viên</th>
          <th onclick="sortTable(3)">Email</th>
          <th onclick="sortTable(4)">Khoa</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($lecturers as $index => $lecture): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($lecture['full_name']) ?></td>
            <td><?= htmlspecialchars($lecture['lecturer_code']) ?></td>
            <td><?= htmlspecialchars($lecture['email']) ?></td>
            <td><?= htmlspecialchars($lecture['name']) ?></td>
            <td>
              <a href="index.php?controller=admin&action=editGV&id=<?= $lecture['id'] ?>&user=<?= $lecture['full_name'] ?>"
                class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
              <a href="index.php?controller=admin&action=deleteLecturer&id=<?= $lecture['id'] ?>"
                class="action-btn delete-btn" onclick="return confirm('Xóa giảng viên này?')"><i
                  class="ri-delete-bin-line"></i> Xóa</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</div>



<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>