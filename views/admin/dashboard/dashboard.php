<?php
ob_start();
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
    <div class="studentChart">
        <h3>Thống kê sinh viên theo lớp học</h3>
        <div>
            <canvas id="studentChart"></canvas>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>

    