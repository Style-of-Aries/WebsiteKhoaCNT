<!-- views/admin/songs/list.php -->
<?php
ob_start();
?>

<div class="admin-table-wrapper">
  <div class="table-toolbar">
    <h2>Danh sách Sinh viên</h2>
    <input type="text" id="searchTable" placeholder="Tìm kiếm sinh viên, mã sinh viên, email...">
  </div>
  <!-- <div class="add">
    <a href="index.php?controller=admin&action=addSinhVien">
      <i class="ri-add-circle-line"></i> Thêm Sinh Viên Mới
    </a>
  </div> -->

  <button class="add-button" onclick="location.href='index.php?controller=admin&action=addSinhVien'">
    <div class="sign">+</div>
    <div class="text">Thêm Sinh Viên Mới</div>
  </button>

  <div class="table-wrap">
    <table class="main-table" id="mainTable">
      <thead>
        <tr>
          <th onclick="sortTable(0)">STT</th>
          <th onclick="sortTable(1)">Tên sinh viên</th>
          <th onclick="sortTable(2)">Mã sinh viên</th>
          <th onclick="sortTable(3)">Email</th>
          <th onclick="sortTable(4)">Khoa</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($students as $index => $user): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($user['full_name']) ?></td>
            <td><?= htmlspecialchars($user['student_code']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['department_name']) ?></td>
            <td class="action">
              <!-- <a href="index.php?controller=admin&action=editSv&id=<?= $user['id'] ?>&full_name=<?= $user['full_name'] ?>"
                class="action-btn edit-btn"><i class="ri-pencil-line"></i>Chi tiết</a>
              <a href="index.php?controller=admin&action=editSv&id=<?= $user['id'] ?>&full_name=<?= $user['full_name'] ?>"
                class="action-btn edit-btn"><i class="ri-pencil-line"></i>Sửa</a>
              <a href="index.php?controller=admin&action=deleteStudent&id=<?= $user['id'] ?>"
                class="action-btn delete-btn" onclick="return confirm('Xóa người dùng này?')"><i
                  class="ri-delete-bin-line"></i> Xóa</a> -->
              <button class="prf-button"
                onclick="location.href='index.php?controller=admin&action=editSv&id=<?= $user['id'] ?>&full_name=<?= $user['full_name'] ?>'">
                <svg xmlns="http://www.w3.org/2000/svg" class="prf-svgIcon" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                  </path>
                </svg>
              </button>
              <button class="delete-button"
                onclick="if(confirm('Xóa sinh viên này?')) location.href='index.php?controller=admin&action=deleteStudent&id=<?= $user['id'] ?>'">
                <svg class="delete-svgIcon" viewBox="0 0 448 512">
                  <path
                    d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                  </path>
                </svg>
              </button>
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