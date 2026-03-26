<?php
ob_start();
// var_dump($sessions);
// var_dump($students);
// var_dump($attendanceResult)."<br>";
// print_r($timeStudying);
// var_dump($check);die();
$today = date('Y-m-d',NOW);
/* kiểm tra lớp có buổi hôm nay không */
mysqli_data_seek($sessions,0);
$role = $_SESSION['user']['role'];
$hasSession = mysqli_num_rows($sessions) > 0;
$canEdit = false;

while($s = mysqli_fetch_assoc($sessions)){
    if($s['session_date'] == $today){
        $canEdit = true;
        break;
    }
}

mysqli_data_seek($sessions,0);
// die();
?>


<div class="admin-table-wrapper">

    <button class="back-button" onclick="history.back()">
        <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024">
            <path
                d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z">
            </path>
        </svg>
        <span>Quay lại</span>
    </button>

    <div class="table-toolbar">
        <h2>📋 Danh sách sinh viên</h2>
        <input type="text" id="searchTable" placeholder="Tìm kiếm sinh viên...">
    </div>

    <form method="POST" action="index.php?controller=attendance&action=saveAttendance">

        <input type="hidden" name="course_class_id" value="<?= $_GET['course_class_id'] ?>">

        <div class="table-wrap">

            <table class="attendance-table" id="mainTable">

                <thead>
                    <tr>
                        <th>STT</th>
                        <th>MSSV</th>
                        <th class="thName">Họ tên</th>

                        <?php while ($session = mysqli_fetch_assoc($sessions)): ?>

                            <?php
                            $isFuture = strtotime($session['session_date']) > strtotime($today);
                            $isToday = $session['session_date'] == $today;
                            ?>

                            <th class="<?= $isToday ? 'today-col' : '' ?>">
                                <?= date('d/m', strtotime($session['session_date'])) ?>
                            </th>

                        <?php endwhile; ?>

                        <th>% CC</th>

                    </tr>
                </thead>


                <tbody>

                    <?php mysqli_data_seek($sessions, 0); ?>
                    <?php $stt = 1; ?>

                    <?php foreach ($students as $sv): ?>

                        <tr>

                            <td><?= $stt++ ?></td>

                            <td><?= $sv['student_code'] ?></td>

                            <td class="tdName"><?= $sv['full_name'] ?></td>

                            <?php

                            $total = 0;
                            $present = 0;

                            ?>

                            <?php while ($session = mysqli_fetch_assoc($sessions)): ?>

                                <?php

                                $isFuture = strtotime($session['session_date']) > strtotime($today);
                                $isToday = $session['session_date'] == $today;

                                $status = $attendanceMap[$sv['id']][$session['id']] ?? 'present';

                                $class = 'att-present';

                                if ($status == 'late')
                                    $class = 'att-late';
                                if ($status == 'absent')
                                    $class = 'att-absent';

                                if (!$isFuture) {

                                    $total++;

                                    if ($status == 'present' || $status == 'late') {
                                        $present++;
                                    }

                                }

                                ?>

                                <td class="<?= $class ?> <?= $isToday ? 'today-col' : '' ?>">

                                    <select name="attendance[<?= $sv['id'] ?>][<?= $session['id'] ?>]" class="att-select"
                                        <?= ($role != 'admin' && !$isToday) ? 'disabled' : '' ?> onchange="changeColor(this)">

                                        <option value="present" data-class="att-present" <?= $status == 'present' ? 'selected' : '' ?>>
                                            Có mặt
                                        </option>

                                        <option value="late" data-class="att-late" <?= $status == 'late' ? 'selected' : '' ?>>
                                            Muộn
                                        </option>

                                        <option value="absent" data-class="att-absent" <?= $status == 'absent' ? 'selected' : '' ?>>
                                            Vắng
                                        </option>

                                    </select>

                                </td>

                            <?php endwhile; ?>

                            <?php mysqli_data_seek($sessions, 0); ?>

                            <?php

                            $percent = $total > 0 ? round($present / $total * 100) : 0;

                            ?>

                            <td class="percent-cell <?= $percent < 80 ? 'warning-att' : '' ?>">

                                <?= $percent ?>%

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>


        <div class="att-action">

            <button type="button" onclick="exportExcel()" class="export-btn">
                📥 Xuất Excel
            </button>

                <button class="att-btn" type="submit" <?= ($role != 'admin' && !$canEdit) ? 'disabled' : '' ?>>
                    <span>💾 Lưu điểm danh</span>
                </button>

        </div>

    </form>

</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layoutNew.php';
?>