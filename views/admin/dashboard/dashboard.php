<?php
ob_start();
require_once __DIR__ . "/../../../services/PermissionService.php";
$role = $_SESSION['user']['role'];
$urlSV = PermissionService::has($role, 'students')
    ? 'data-url="index.php?controller=admin&action=getAllSinhVien"'
    : '';

$urlGV = PermissionService::has($role, 'lecturer')
    ? 'data-url="index.php?controller=admin&action=getUserRoleLecturer"'
    : '';
$urlKhoa = PermissionService::has($role, 'departments')
    ? 'data-url="index.php?controller=department&action=getAllListDepartment"'
    : '';
$urlLop = PermissionService::has($role, 'classes')
    ? 'data-url="index.php?controller=classes&action=getAllLopHoc"'
    : '';
// print_r($urlSV);
// var_dump(PermissionService::has($role, 'student'));die();    
?>
<div class="containerDashboard">
    <div class="dashboard-cards">

        <div class="card" id="totalSV" <?= $urlSV ?>>
            <h3><i class="bx bxs-graduation"></i> Tổng số sinh viên</h3>
            <p><?= count($totalSinhVien) ?></p>
        </div>

        <div class="card" id="totalGV" <?= $urlGV ?>>
            <h3><i class="bx bxs-user-badge"></i> Tổng số giảng viên</h3>
            <p><?= count($totalGiangVien) ?></p>
        </div>

        <div class="card" id="totalLop" <?= $urlLop ?>>
            <h3><i class="bx bxs-group"></i> Tổng số lớp học</h3>
            <p><?= count($totalLopHoc) ?></p>
        </div>

        <div class="card" id="totalKhoa" <?= $urlKhoa ?>>
            <h3><i class="bx bxs-building"></i> Tổng số ngành học</h3>
            <p><?= count($totalKhoa) ?></p>
        </div>
    </div>

    <div style="display: flex; margin-top: 20px; gap: 20px;">
        <!-- CHART -->
        <div class="chartBox">

            <h2>Sinh viên theo ngành học</h2>

            <canvas id="facultyChart"></canvas>

        </div>

        <div class="card-student-new">
            <div class="card-header">
                <h3>🎓 Sinh viên mới</h3>
                
                <?= PermissionService::has($role, 'student')
                    ? '<a href="index.php?controller=admin&action=getAllSinhVien">Xem tất cả</a>'
                    : '' ?>
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
    document.querySelectorAll(".card").forEach(card => {
        card.addEventListener("click", function () {
            const url = this.getAttribute("data-url");
            if (url) {
                window.location.href = url;
            }
        });
    });
    const labels = <?= json_encode($labels) ?>;
    const total = <?= json_encode($total) ?>;
    const male = <?= json_encode($male) ?>;
    const female = <?= json_encode($female) ?>;

    new Chart(document.getElementById("facultyChart"), {
        type: 'bar',

        data: {
            labels: labels,
            datasets: [
                {
                    label: "Tổng SV",
                    data: total,
                    backgroundColor: "#4BC0C0",
                    borderRadius: 8
                },
                {
                    label: "Nam",
                    data: male,
                    backgroundColor: "#36A2EB",
                    borderRadius: 8
                },
                {
                    label: "Nữ",
                    data: female,
                    backgroundColor: "#FF6384",
                    borderRadius: 8
                }
            ]
        },

        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 13
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 14
                        }
                    },
                }, // ✅ thêm dấu phẩy ở đây

                y: {
                    beginAtZero: true,
                    ticks: {
                        maxTicksLimit: 6,
                        font: {
                            size: 13
                        }
                    },
                    grid: {
                        color: "#eee"
                    }
                }
            }
        }
    });
</script>


<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>