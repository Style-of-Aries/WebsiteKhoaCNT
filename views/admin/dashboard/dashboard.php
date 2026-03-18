<?php
ob_start();
// print_r($newStudents);die();    
?>
<div class="containerDashboard">
    <div class="dashboard-cards">
        <div class="card" id="totalSV">
            <h3><i class="bx bxs-graduation"></i> Tổng số sinh viên</h3>
            <p><?= count($totalSinhVien) ?></p>
        </div>
        <div class="card" id="totalGV">
            <h3><i class="bx bxs-user-badge"></i> Tổng số giảng viên</h3>
            <p><?= count($totalGiangVien) ?></p>
        </div>
        <div class="card" id="totalLop">
            <h3><i class="bx bxs-group"></i> Tổng số lớp học</h3>
            <p><?= count($totalLopHoc) ?></p>
        </div>
        <div class="card" id="totalKhoa">
            <h3><i class="bx bxs-building"></i> Tổng số khoa</h3>
            <p><?= count($totalKhoa) ?></p>
        </div>
    </div>

    <div style="display: flex;">
        <!-- CHART -->
        <div class="chartBox">

            <h2>Sinh viên theo khoa</h2>

            <canvas id="facultyChart"></canvas>

        </div>

        <div class="card-student-new">
            <div class="card-header">
                <h3>🎓 Sinh viên mới</h3>
                <a href="index.php?controller=admin&action=getAllSinhVien">Xem tất cả</a>
            </div>

            <div class="card-body">
                <?php if (!empty($newStudents)): ?>
                    <?php foreach ($newStudents as $sv): ?>
                        <div class="student-item">
                            <img src="<?=
                                    $sv['gender'] === 'Nữ'
                                    ? BASE_URL . 'img/female.jpg'
                                    : BASE_URL . 'img/male.jpg'
                                ?>" alt="avatar">

                            <div class="info">
                                <p class="name"><?= $sv['full_name'] ?></p>
                                <p class="meta">
                                    MSSV: <?= $sv['student_code'] ?> <br>
                                    <?= $sv['department_name'] ?>
                                </p>
                            </div>

                            <div class="date">
                                <?= date("d/m/Y", strtotime($sv['created_at'])) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Không có sinh viên mới</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const labels = <?= json_encode($facultyLabels) ?>;
    const data = <?= json_encode($facultyCount) ?>;

    new Chart(document.getElementById("facultyChart"), {

        type: 'bar',

        data: {
            labels: labels,
            datasets: [{
                label: "Số sinh viên",
                data: data,
                borderWidth: 1
            }]
        },

        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }

    });

</script>


<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>