<?php
ob_start();
// var_dump($sessions);
// var_dump($students);
// var_dump($attendanceResult);
// die();
?>


<div class="container-admin">
    <h2>Bảng điểm danh</h2>

    <form method="POST" action="index.php?controller=attendance&action=saveAttendance">

        <input type="hidden" name="course_class_id" value="<?= $_GET['course_class_id'] ?>">
        <div class="table-wrapper">
        <table class="main-table">
            <thead>
                <tr>
                    <th>MSSV</th>
                    <th class="thName">Họ tên</th>

                    <?php while ($session = mysqli_fetch_assoc($sessions)): ?>
                        <th><?= date('d/m', strtotime($session['session_date'])) ?></th>
                    <?php endwhile; ?>
                </tr>
            </thead>

            <tbody>
                <?php mysqli_data_seek($sessions, 0); ?>

                <?php while ($sv = mysqli_fetch_assoc($students)): ?>
                    <tr>
                        <td><?= $sv['student_code'] ?></td>
                        <td class="tdName"><?= $sv['full_name'] ?></td>

                        <?php while ($session = mysqli_fetch_assoc($sessions)): ?>
                            <?php
                            $status = $attendanceMap[$sv['id']][$session['id']] ?? '';
                            ?>

                            <?php
                            $class = 'att-empty';
                            if ($status == 'present')
                                $class = 'att-present';
                            if ($status == 'late')
                                $class = 'att-late';
                            if ($status == 'absent')
                                $class = 'att-absent';
                            ?>

                            <td class="<?= $class ?>">
                                <select name="attendance[<?= $sv['id'] ?>][<?= $session['id'] ?>]" class="att-select"
                                    onchange="this.parentElement.className = this.options[this.selectedIndex].dataset.class">

                                    <option value="" data-class="att-empty">--</option>
                                    <option value="present" data-class="att-present" <?= $status == 'present' ? 'selected' : '' ?>>
                                        Có mặt</option>
                                    <option value="late" data-class="att-late" <?= $status == 'late' ? 'selected' : '' ?>>Muộn
                                    </option>
                                    <option value="absent" data-class="att-absent" <?= $status == 'absent' ? 'selected' : '' ?>>
                                        Vắng</option>
                                </select>
                            </td>

                        <?php endwhile; ?>

                        <?php mysqli_data_seek($sessions, 0); ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>
        <button type="submit" class="att-btn">💾 Lưu tất cả điểm danh</button>

    </form>


   <?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>