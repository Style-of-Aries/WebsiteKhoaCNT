<?php
ob_start();
?>
<style>
    .error {
        color: red;
        /* margin-left: px; */
    }

    form.song-form {
        background-color: #231b2e;
        padding: 24px;
        border-radius: 8px;
        /* max-width: 600px; */
        width: 50%;
        /* height: 70%; */
        /* margin: auto; */
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    label {
        font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="file"],
    input[type="password"],
    select {
        padding: 10px;
        border: none;
        border-radius: 4px;
        background-color: #2e253a;
        color: white;
        width: 100%;
        outline: none;
    }

    input[type="submit"] {
        padding: 12px;
        background-color: #9b4de0;
        border: none;
        color: white;
        font-weight: bold;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
        outline: none;
    }

    input[type="submit"]:hover {
        background-color: #b86aff;
    }
</style>


<h2>Thêm sinh viên</h2>

<form class="song-form" action="index.php?controller=admin&action=add" method="POST" enctype="multipart/form-data">
    <div>
        <label>Họ và tên</label>
        <input type="text" name="full_name" required>
        <!-- <i class="fa-solid fa-user"></i> -->
        <!-- <small class="error" id="error-title"></small> -->
    </div>
    <div>
        <label>Mã sinh viên</label>
        <input type="text" name="student_code" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" required>
    </div>
    <!-- <div>
        <label>Lớp</label>
        <select name="class_id" required>
            <option value="">-- Chọn lớp --</option>
            
        </select>
    </div> -->
    <div>
        <label>Tên đăng nhập</label>
        <input type="text" name="username" required>
    </div>
    <div class="form-group">
        <label>Mật khẩu</label>
        <input type="password" name="password" required>
    </div>
    <input type="submit" value="Thêm sinh viên" name="btn_add">
</form>
<?php
$content = ob_get_clean();
include "../views/admin/layout.php";
?>