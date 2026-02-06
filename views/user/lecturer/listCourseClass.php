<?php
ob_start();
?>

<div class="container-admin">
    <h2>Danh sách lớp dạy</h2>
    <div class="table-wrapper">
        <table class="main-table">
            <thead>
                <tr>
                    <th>Mã lớp</th>
                    <th>Môn học</th>
                    <th>Học kỳ</th>
                    <th>Sĩ số</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($classes)): ?>
                    <tr>
                        <td><?= $row['class_code'] ?></td>
                        <td><?= $row['subject_name'] ?></td>
                        <td><?= $row['semester_name'] ?></td>
                        <td><?= $row['total_students'] ?>/<?= $row['max_students'] ?></td>
                        <td class="action-btn">
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
                        </td>

                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>