<?php
ob_start();
?>


<form class="add-form" action="index.php?controller=user&action=editAd" method="POST" enctype="multipart/form-data">
    <h2>Sửa thông tin dùng mới</h2>

    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <div>
        <label>Tài khoản</label>
        <input type="text" name="username" value="<?= $user['username'] ?>" required>
    </div>
    <div>
        <label>Email</label>
        <input type="text" name="password" value="<?= $user['password'] ?>">
    </div>
    <label>Role</label>
    <input type="text"
        value="<?=
               $user['role'] == 'admin' ? 'Quản trị viên' : ($user['role'] == 'training_office' ? 'Phòng đào tạo' : ($user['role'] == 'lecturer' ? 'Giảng viên' : ($user['role'] == 'academic_affairs' ? 'Học vụ' : ($user['role'] == 'exam_office' ? 'Khảo thí' : ($user['role'] == 'student_affairs' ? 'Công tác SV' : '')))))
                ?>"
        disabled>

    <input type="hidden" name="role" value="<?= $user['role'] ?>">



    <input type="submit" value="Lưu" name="btn_edit">
</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>