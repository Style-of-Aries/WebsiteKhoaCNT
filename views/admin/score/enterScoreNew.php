<?php
ob_start();
$role = $_SESSION['user']['role'];
// var_dump($scores);die;
?>

<div class="admin-table-wrapper">

    <div class="table-toolbar">
        <h2>📋 Danh sách sinh viên</h2>
        <input type="text" id="searchTable" placeholder="Tìm kiếm sinh viên...">
    </div>

    <form method="post" action="index.php?controller=lecturer&action=saveScoresNew">

        <input type="hidden" name="course_class_id" value="<?= $_GET['course_class_id'] ?>">

        <div class="table-wrap">
            <table class="main-table" id="mainTable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>MSSV</th>
                        <th>Họ tên</th>
                        <th>Ngày sinh</th>
                        <?php while ($c = mysqli_fetch_assoc($components)): ?>
                            <th>
                                <span class="info-components">
                                    <?= $c['name'] ?>
                                    (<?= $c['weight'] ?>%)
                                </span>
                            </th>
                        <?php endwhile; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    mysqli_data_seek($components, 0);
                    $stt = 1;

                    while ($student = mysqli_fetch_assoc($students)):
                        ?>

                        <tr>
                            <td><?= $stt++ ?></td>
                            <td><?= $student['student_code'] ?></td>
                            <td class="tdName"><?= $student['full_name'] ?></td>
                            <td class="tdDate"><?= $student['date_of_birth'] ?></td>
                            <?php while ($c = mysqli_fetch_assoc($components)): ?>
                                <td class="tdInputScore">
                                    <?php
                                    $canEdit = false;

                                    // Admin nhập được tất cả
                                    if ($role === 'admin') {
                                        $canEdit = true;
                                    }

                                    // Giảng viên nhập điểm quá trình + giữa kỳ
                                    if ($role === 'lecturer' && $c['type'] !== 'CK') {
                                        $canEdit = true;
                                    }

                                    // Phòng khảo thí chỉ nhập điểm thi cuối kỳ
                                    if ($role === 'exam_office' && $c['type'] === 'CK') {
                                        $canEdit = true;
                                    }
                                    // var_dump($canEdit);die;
                                    ?>

                                    <input class="score-input" type="number" step="0.1" min="0" max="10" 
                                        name="scores[<?= $student['id'] ?>][<?= $c['id'] ?>]" value="<?= isset($scores[$student['id']][$c['id']])
                                                ? $scores[$student['id']][$c['id']]
                                                : '' ?>" <?= $canEdit ? '' : 'disabled' ?>>


                                </td>
                            <?php endwhile; ?>
                            <?php mysqli_data_seek($components, 0); ?>

                        </tr>

                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="save-score-wrapper">
            <button class="att-btn" type="submit">
                <span>💾Lưu điểm</span>
            </button>
        </div>

    </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layoutNew.php';
?>