<?php
ob_start();
?>
<div class="container-admin">
    <h2>Bảng điểm học tập</h2>
    <table class="main-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Môn học</th>
                <th>Mã môn</th>
                <th>Số tín chỉ</th>
                <th>Điểm quá trình</th>
                <th>Điểm thi</th>
                <th>Điểm tổng kết</th>
                <th>Điểm chữ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Lập trình C++</td>
                <td>CT001</td>
                <td>3</td>
                <td>
                    TX: 8.5<br>
                    GK: 7.5
                </td>
                <td>8.0</td>
                <td><b>8.1</b></td>
                <td>A</td>
            </tr>

            <tr>
                <td>2</td>
                <td>Cơ sở dữ liệu</td>
                <td>CT002</td>
                <td>3</td>
                <td>
                    TX: 7.0<br>
                    GK: 7.5
                </td>
                <td>7.0</td>
                <td><b>7.2</b></td>
                <td>B</td>
            </tr>

            <tr>
                <td>3</td>
                <td>Lập trình Web</td>
                <td>CT003</td>
                <td>4</td>
                <td>
                    TX: 9.0<br>
                    GK: 8.5
                </td>
                <td>9.0</td>
                <td><b>8.9</b></td>
                <td>A</td>
            </tr>

            <tr>
                <td>4</td>
                <td>Toán cao cấp A1</td>
                <td>MT001</td>
                <td>3</td>
                <td>
                    TX: 6.5<br>
                    GK: 7.0
                </td>
                <td>6.5</td>
                <td><b>6.7</b></td>
                <td>C</td>
            </tr>
        </tbody>

        <!-- <tbody>
        <?php foreach ($users as $index => $user): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['password']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td><?= htmlspecialchars($user['ref_id']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody> -->
    </table>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../admin/layout.php';
?>