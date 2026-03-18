<!-- views/admin/songs/list.php -->
<?php
ob_start();
$now = date('Y-m-d', NOW);
function getStatus($row, $now)
{

  // $now = date('2025-09-02');
  // print_r($now);die();
  if (!$row['first_session'])
    return;
  if ($now >= $row['first_session'] && $now <= $row['last_session'])
    return 'studying';
}
// print_r($course_classes);die();
?>
<div class="admin-table-wrapper">
  <div class="table-toolbar">
    <h2>Danh sách Học phần</h2>
    <input type="text" id="searchTable" placeholder="Tìm kiếm học phần, mã lớp, môn học...">
  </div>
  <!-- <div class="add">
      <a href="index.php?controller=course_classes&action=addHocPhan">
        <i class="ri-add-circle-line"></i>
        Thêm Học Phần Mới</a>
    </div> -->
  <button class="add-button" onclick="location.href='index.php?controller=course_classes&action=addHocPhan'">
    <div class="sign">+</div>
    <div class="text">Thêm Học Phần Mới</div>
  </button>
  </style>
  <!-- <h2>Danh sách ngươi dùng</h2> -->

  <!-- <a href="admin.php?action=create" class="btn-custom"><i class="ri-add-line"></i> Thêm bài hát</a> -->
  <div class="table-wrap">
    <table class="main-table" id="mainTable">
      <thead>
        <tr>
          <th onclick="sortTable(0)">STT</th>
          <th onclick="sortTable(1)">Mã lớp</th>
          <!-- <th onclick="sortTable(2)">Môn học</th> -->
          <th onclick="sortTable(3)">Giảng viên</th>
          <th onclick="sortTable(4)">Học kỳ</th>
          <th onclick="sortTable(5)">Sĩ số</th>
          <th onclick="sortTable(6)">Thời hạn đăng ký</th>
          <th onclick="sortTable(7)">Trạng thái</th>
          <th class="action">Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($course_classes as $index => $subject): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($subject['class_code']) ?><br><?= htmlspecialchars($subject['subject_name']) ?></td>
            <!-- <td></td> -->
            <td><?= htmlspecialchars($subject['lecturer_name']) ?></td>
            <td style="width: 250px;"><?= htmlspecialchars($subject['semester_name']) ?>
              (<?= htmlspecialchars($subject['academic_year']) ?>)
            </td>
            <td>
              <?= htmlspecialchars($subject['total_students']) ?>
              /
              <?= htmlspecialchars($subject['max_students']) ?>
            </td>
            <td style="width: 200px;">
              <?= date('d/m', strtotime($subject['registration_start'])) ?> -
              <?= date('d/m/Y', strtotime($subject['registration_end'])) ?>
            </td>
            <td>
              <?php
              $statusCourseClass = getStatus($subject, $now);
              $start = date('d/m/Y', strtotime($subject['registration_start']));
              $end = date('d/m/Y', strtotime($subject['registration_end']));
              $firstSession = !empty($subject['first_session'])
                ? strtotime($subject['first_session'])
                : null;
              ?>

              <?php if ($subject['status'] === "finished"): ?>
                <span class="count-badge blue">Hoàn thành</span>

              <?php elseif ($statusCourseClass === "studying"): ?>
                <span class="count-badge green">Đang diễn ra</span>

              <?php elseif ($now >= $start && $now <= $end): ?>
                <span class="count-badge yellow">Đang mở đăng ký</span>

              <?php elseif ($now > $end): ?>
                <span class="count-badge orange">Đã đóng đăng ký</span>


              <?php else: ?>
                <span class="count-badge">Không xác định</span>
              <?php endif; ?>
            </td>
            <td style="display: flex; width: 250px; justify-content: center;">
              <!-- <button class="view-button"
                onclick="location.href='index.php?controller=timetable&action=tkb&id=<?= $subject['id'] ?>'">
                <svg xmlns="http://www.w3.org/2000/svg" class="view-svgIcon" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                  </path>
                </svg>
              </button> -->
              <button class="viewTkb-button"
                onclick="location.href='index.php?controller=timetable&action=getTkbByCourseClassId&id=<?= $subject['id'] ?>'">
                <svg class="viewTkb-svgIcon" viewBox="0 0 24 24">
                  <path
                    d="M7 2a1 1 0 0 1 1 1v1h8V3a1 1 0 1 1 2 0v1h1a2 2 0 0 1 2 2v2H3V6a2 2 0 0 1 2-2h1V3a1 1 0 0 1 1-1zm14 8v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8h18zM7 12h4v4H7v-4z" />
                </svg>
              </button>
              <button class="edit-button"
                onclick="location.href='index.php?controller=course_classes&action=editHocPhan&id=<?= $subject['id'] ?>'">
                <svg class="edit-svgIcon" viewBox="0 0 512 512">
                  <path
                    d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                  </path>
                </svg>
              </button>
              <button class="delete-button"
                onclick="if(confirm('Xóa lớp học này?')) location.href='index.php?controller=course_classes&action=deleteHocPhan&id=<?= $subject['id'] ?>'">
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
<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>