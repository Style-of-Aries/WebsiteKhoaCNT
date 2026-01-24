<?php
ob_start();
?>
<div class="welcome-container">
    <h1 class="welcome-text">
        Xin chào, <span>Nguyễn Đức Trọng</span>
    </h1>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../../admin/layout.php';
?>