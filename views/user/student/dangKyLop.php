<?php
ob_start();
?>

<div class="container-admin">

    <h2>Các lớp đang mở ở kì này</h2>

    <table class="main-table">
        <thead class="table-secondary">
            <tr>
                <th>Mã Lớp</th>
                <th>Tên Môn Học</th>
                <th>Sĩ Số Tối Đa</th>
                <th>Đã Đăng Ký</th>
                <th>Còn Trống</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($classes as $row):
                $remaining = $row['max_students'] - $row['current_students'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['class_code']) ?></td>
                    <td><?= htmlspecialchars($row['subject_name']) ?></td>
                    <td class="text-center"><?= $row['max_students'] ?></td>
                    <td class="text-center"><?= $row['current_students'] ?></td>
                    <td class="text-center">
                        <?php if ($remaining > 0): ?>
                            <span class="badge bg-success badge-slot">
                                <?= $remaining ?>
                            </span>
                        <?php else: ?>
                            <span class="badge bg-warning badge-slot">
                                0
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if ($row['is_registered']): ?>

                            <button class="btn btn-secondary btn-sm" disabled>
                                Đã đăng ký
                            </button>


                        <?php elseif ($remaining > 0): ?>

                            <a href="index.php?controller=student&action=registerCourseClass&class_id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">
                                Đăng Ký
                            </a>

                        <?php else: ?>

                            <button class="btn btn-secondary btn-sm" disabled>
                                Đã Đầy
                            </button>

                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../admin/layout.php';
?>