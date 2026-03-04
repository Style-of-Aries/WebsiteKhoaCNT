<?php
ob_start();
$role = $_SESSION['user']['role'];
// var_dump($scores);die;
?>

<div class="admin-table-wrapper">
    <button class="back-button" onclick="location.href='index.php?controller=lecturer&action=getCourseClass&type=score'">
        <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1024 1024">
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
                                    <?= $c['component_name'] ?>
                                    (<?= $c['weight'] ?>%)
                                </span>
                            </th>
                        <?php endwhile; ?>
                        <?php if ($role === 'admin' || $role === 'exam_office'): ?>
                            <th>ĐK thi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    mysqli_data_seek($components, 0);
                    $stt = 1;

                    foreach ($students as $student):
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
                            <?php if ($role === 'admin' || $role === 'exam_office'): ?>
                                <td class="dkthi">
                                    <?php
                                    $status = $eligibilities[$student['id']] ?? null;
                                    // var_dump($status);
                                    if ($status === null) {
                                        echo "<span style='color:gray'>Không áp dụng</span>";
                                    } elseif ($status >= 5) {
                                        echo "<span style='color:green'>Đủ điều kiện</span>";
                                    } else {
                                        echo "<span style='color:red'>Không đủ</span>";
                                    }
                                    ?>
                                </td>
                            <?php endif; ?>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="save-score-wrapper">
            <?php if ($statusCourseClass === "studying"): ?>
                <button class="att-btn" type="submit">
                    <span>💾Lưu điểm</span>
                </button>
            <?php endif; ?>
        </div>

    </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layoutNew.php';
?>