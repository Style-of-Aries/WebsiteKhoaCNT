<?php
ob_start();
?>


<form class="add-form" action="index.php?controller=user&action=add" method="POST" enctype="multipart/form-data">
    <h2>Thêm người dùng mới</h2>

    <div>
        <label>Họ và tên</label>
        <input type="text" name="full_name" required>
    </div>
   <div>
        <label>Email</label>
        <input type="email" name="email">
    </div>
    <div>
        <label>Role</label>
    <select name="role">
        <!-- <option value="lecturer">Giảng viên</option>
        <option value="student">Sinh viên</option> -->
        <option value="training_office">Phòng đào tạo</option>
        <option value="academic_affairs">Học vụ</option>
        <option value="exam_office">Khảo thí</option>
        <option value="student_affairs">Công tác SV</option>
    </select></div>

    <input type="submit" value="Thêm người dùng" name="btn_add">
</form>

<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>