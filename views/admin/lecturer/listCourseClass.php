<?php
ob_start();
$type = $_GET['type'] ?? 'attendance';
$role = $_SESSION['user']['role'];

if ($type == 'attendance') {
    $url = "index.php?controller=attendance&action=sessions";
} else {
    $url = "index.php?controller=lecturer&action=updateResultByCourseClass";
}
?>

<div class="admin-table-wrapper">
    <div class="table-toolbar">
        <h2>Danh sách lớp học phần</h2>
        <input type="text" id="searchTable" placeholder="Tìm kiếm giảng viên, mã giảng viên, email...">
    </div>
    <table class="main-table" id="mainTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)">Mã lớp</th>
                <th onclick="sortTable(1)">Môn học</th>
                <th onclick="sortTable(2)">Học kỳ</th>
                <th onclick="sortTable(3)">Sĩ số</th>
                <?php if ($role !== 'lecturer'): ?>
                    <th onclick="sortTable(4)">Giảng viên</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($classes)): ?>
                <tr onclick="window.location='<?= $url ?>&course_class_id=<?= $row['id'] ?>'">
                    <td><?= $row['class_code'] ?></td>
                    <td><?= $row['subject_name'] ?></td>
                    <td><?= $row['semester_name'] ?></td>
                    <td><?= $row['total_students'] ?>/<?= $row['max_students'] ?></td>
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

<?php
$content = ob_get_clean();
include __DIR__ . '/../layoutNew.php';
?>