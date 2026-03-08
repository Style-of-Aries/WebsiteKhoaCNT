<?php
ob_start();
$type = $_GET['type'] ?? 'attendance';
$role = $_SESSION['user']['role'];

if ($type == 'attendance') {
    $url = "index.php?controller=attendance&action=sessions";
} else {
    $url = "index.php?controller=lecturer&action=updateResultByCourseClass";
}

function getStatus($row)
{
    $now = date('Y-m-d', NOW);
    // $now = date('2025-09-02');
    // print_r($now);die();
    if (!$row['first_session'])
        return;
    if ($now >= $row['first_session'] && $now <= $row['last_session'])
        return 'studying';
}
?>

<div class="admin-table-wrapper">
    <div class="table-toolbar">
        <h2>Danh sách lớp học phần</h2>
        <input type="text" id="searchTable" placeholder="Tìm kiếm mã lớp học phần...">
    </div>
    <div class="table-wrap">
        <table class="main-table" id="mainTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">STT</th>
                    <th onclick="sortTable(1)">Mã lớp</th>
                    <th onclick="sortTable(2)">Môn học</th>
                    <th onclick="sortTable(3)">Học kỳ</th>
                    <th onclick="sortTable(4)">Sĩ số</th>
                    <?php if ($role !== 'lecturer'): ?>
                        <th onclick="sortTable(5)">Giảng viên</th>
                    <?php endif; ?>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1;
                while ($row = mysqli_fetch_assoc($classes)): ?>
                    <tr class="trOnclick" onclick="window.location='<?= $url ?>&course_class_id=<?= $row['id'] ?>'">
                        <td><?= $stt++; ?></td>
                        <td><?= $row['class_code'] ?></td>
                        <td><?= $row['subject_name'] ?></td>
                        <td><?= $row['semester_name'] ?> (<?= $row['academic_year'] ?>)</td>
                        <td><?= $row['total_students'] ?>/<?= $row['max_students'] ?></td>
                        <?php if ($role !== 'lecturer'): ?>
                            <td>
                                <?= $row['lecturer_name'] ?>
                            </td>
                        <?php endif; ?>
                        <td>
                            <?php
                            $statusCourseClass = getStatus($row);
                            if ($row['status'] === "finished"): ?>
                                <div class="statusFinished">
                                    Hoàn thành
                                </div>
                            <?php elseif ($statusCourseClass === "studying"): ?>
                                <div class="statusStudying">
                                    Đang diễn ra
                                </div>
                            <?php elseif ($row['status'] === "open"): ?>
                                <div class="statusRegistering">
                                    Đang mở đăng ký
                                </div>
                            <?php endif; ?>
                        </td>
                        <!-- <td class="action-btn">
                            <a href="index.php?controller=lecturer&action=getStudentsWithExamConditions&course_class_id=<?= $row['id'] ?>"
                                class="btn btn-primary btn-sm">
                                Danh sách lớp
                            </a>
                            <a href="index.php?controller=lecturer&action=updateResultByCourseClass&class_id=<?= $row['id'] ?>"
                                class="btn btn-primary btn-sm">
                                Nhập điểm
                            </a>
                            <a href="index.php?controller=attendance&action=sessions&course_class_id=<?= $row['id'] ?>"
                                class="btn btn-primary btn-sm">
                                Điểm danh
                            </a>
                        </td> -->
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layoutNew.php';
?>