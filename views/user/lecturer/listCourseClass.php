<?php
ob_start();
?>

<div class="container-admin">
    <h2>Danh sách lớp dạy</h2>
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
                    <td>
                        <a href="index.php?controller=lecturer&action=getStudentsByCourseClass&class_id=<?= $row['id'] ?>"
                            class="btn btn-primary btn-sm">
                            Xem danh sách lớp
                        </a>
                    </td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../admin/layout.php';
?>