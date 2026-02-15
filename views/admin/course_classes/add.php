    <?php ob_start(); ?>
    <form class="add-form" action="index.php?controller=course_classes&action=add" method="POST">
        <h2>Thêm học phần mới</h2>

        <!-- môn học  -->
        <select name="subject_id">
            <option value="">-- Chọn môn học --</option>
            <?php foreach ($subject as $s): ?>
                <option value="<?= $s['id'] ?>"
                    <?= ($old['subject_id'] ?? '') == $s['id'] ? 'selected' : '' ?>>
                    <?= $s['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['subject_id'])): ?>
            <small style="color:red"><?= $errors['subject_id'] ?></small>
        <?php endif; ?>



        <!-- giảng viên  -->
        <select name="lecturer_id">
            <option value="">-- Chọn giảng viên --</option>
            <?php foreach ($lecturer as $l): ?>
                <option value="<?= $l['id'] ?>"
                    <?= ($old['lecturer_id'] ?? '') == $l['id'] ? 'selected' : '' ?>>
                    <?= $l['full_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['lecturer_id'])): ?>
            <small style="color:red"><?= $errors['lecturer_id'] ?></small>
        <?php endif; ?>



        <!-- Học kỳ -->
        <!-- <label>Học kỳ</label>
        <select name="semester_id" required>
            <option value="">-- Chọn học kỳ --</option>
            <?php foreach ($semesters as $se): ?>
                <option value="<?= $se['id'] ?>"><?= $se['name'] ?> (<?= $se['academic_year'] ?>)</option>
            <?php endforeach; ?>
        </select> -->

        <!-- sĩ só  -->
        <input type="number"
            name="max_students"
            value="<?= $old['max_students'] ?? 60 ?>">
        <?php if (!empty($errors['max_students'])): ?>
            <small style="color:red"><?= $errors['max_students'] ?></small>
        <?php endif; ?>



        <!-- Thứ -->
        <?php
        $oldDays = $old['day_of_week'] ?? [''];
        $oldSessions = $old['session'] ?? [''];
        $oldRooms = $old['room_id'] ?? [''];

        $count = max(count($oldDays), 1);
        ?>

        <div id="schedule-wrapper">

            <?php for ($index = 0; $index < $count; $index++): ?>

                <div class="schedule-item" style="margin-bottom:15px; padding:10px; border:1px solid #ccc;">

                    <!-- Thứ -->
                    <select name="day_of_week[]">
                        <option value="">-- Chọn thứ --</option>
                        <?php for ($i = 2; $i <= 7; $i++): ?>
                            <option value="<?= $i ?>"
                                <?= ($oldDays[$index] ?? '') == $i ? 'selected' : '' ?>>
                                Thứ <?= $i ?>
                            </option>
                        <?php endfor; ?>
                    </select>

                    <?php if (!empty($errors['day_of_week'])): ?>
                        <small style="color:red"><?= $errors['day_of_week'] ?></small>
                    <?php endif; ?>


                    <!-- Buổi -->
                    <select name="session[]">
                        <option value="">-- Chọn buổi --</option>
                        <option value="Sáng"
                            <?= ($oldSessions[$index] ?? '') == 'Sáng' ? 'selected' : '' ?>>
                            Sáng
                        </option>
                        <option value="Chiều"
                            <?= ($oldSessions[$index] ?? '') == 'Chiều' ? 'selected' : '' ?>>
                            Chiều
                        </option>
                    </select>

                    <?php if (!empty($errors['session'])): ?>
                        <small style="color:red"><?= $errors['session'] ?></small>
                    <?php endif; ?>


                    <!-- Phòng -->
                    <select name="room_id[]">
                        <option value="">-- Chọn phòng --</option>
                        <?php foreach ($rooms as $r): ?>
                            <option value="<?= $r['id'] ?>"
                                <?= ($oldRooms[$index] ?? '') == $r['id'] ? 'selected' : '' ?>>
                                <?= $r['room_name'] ?> (<?= $r['building'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <?php if (!empty($errors['room_id'])): ?>
                        <small style="color:red"><?= $errors['room_id'] ?></small>
                    <?php endif; ?>

                    <?php if ($index > 0): ?>
                        <button type="button" onclick="removeSchedule(this)">X</button>
                    <?php endif; ?>

                </div>

            <?php endfor; ?>

        </div>

        <button type="button" onclick="addSchedule()">+ Thêm buổi</button>



        <!-- <h3>
        Học kỳ:
        <?= date('d/m/Y', strtotime($semesterStart)) ?>
        -
        <?= date('d/m/Y', strtotime($semesterEnd)) ?>
    </h3> -->

        <label>Từ tuần</label>
        <select name="start_week" required>
            <?php
            $start = new DateTime($semesterStart);

            for ($i = 1; $i <= $totalWeeks - 1; $i++) {
                $weekStart = clone $start;
                $weekStart->modify('+' . ($i - 1) * 7 . ' days');

                $weekEnd = clone $weekStart;
                $weekEnd->modify('+6 days');
            ?>
                <option value="<?= $i ?>"
                    <?= (!empty($old['start_week']) && $old['start_week'] == $i) ? 'selected' : '' ?>>

                    Tuần <?= $i ?>
                    (<?= $weekStart->format('d/m/Y') ?>
                    –
                    <?= $weekEnd->format('d/m/Y') ?>)
                </option>
            <?php } ?>
        </select>

        <br><br>

        <label>Đến tuần</label>
        <select name="end_week" required>
            <?php
            for ($i = 1; $i <= $totalWeeks - 1; $i++) {
                $weekStart = clone $start;
                $weekStart->modify('+' . ($i - 1) * 7 . ' days');

                $weekEnd = clone $weekStart;
                $weekEnd->modify('+6 days');
            ?>
                <option value="<?= $i ?>"
                    <?= (!empty($old['end_week']) && $old['end_week'] == $i) ? 'selected' : '' ?>>

                    Tuần <?= $i ?>
                    (<?= $weekStart->format('d/m/Y') ?>
                    –
                    <?= $weekEnd->format('d/m/Y') ?>)
                </option>
            <?php } ?>
        </select>
        <?php if (!empty($errors['week'])): ?>
            <small style="color:red"><?= $errors['week'] ?></small>
        <?php endif; ?>




        <input type="submit" name="btn_add" value="Thêm học phần">
    </form>

    <?php
    $content = ob_get_clean();
    include "../views/admin/layout.php";
    ?>