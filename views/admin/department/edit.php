<?php
ob_start();
?>


<div class="container-main">
    <!-- <h2>Sửa thông tin khoa:<?= $user['name'] ?> </h2> -->

    <form class="song-form" action="index.php?controller=department&action=edit" method="POST"
        enctype="multipart/form-data">
        <input type="hidden" name="id" value=" <?= $user['id'] ?>">

        <div class="row">
            <div class="col">
                <label>Tên khoa</label>
                <input type="text" name="name" placeholder="Mã lớp" value="<?= $user['name'] ?>" required>
                <?php if (!empty($errorMaSv))
                    echo "<span style='color:red;'>$errorMaSv</span><br>"; ?>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label>Loại</label>
                <select name="type" required>
                    <option value="">-- Chọn loại --</option>
                    <option value="school" <?= ($user['type'] == 'school') ? 'selected' : '' ?>>
                        Trường
                    </option>
                    <option value="faculty" <?= ($user['type'] == 'faculty') ? 'selected' : '' ?>>
                        Khoa
                    </option>
                    <option value="department" <?= ($user['type'] == 'department') ? 'selected' : '' ?>>
                        Ngành
                    </option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Đơn vị cha</label>
                <select name="parent_id">
                    <option value="">-- Không có --</option>

                    <?php while ($row = mysqli_fetch_assoc($parents)) { ?>
                        <option value="<?= $row['id'] ?>" <?= ($user['parent_id'] == $row['id']) ? 'selected' : '' ?>>
                            <?= $row['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <!-- <input type="submit" value="Sửa thông tin" name="btn_edit"> -->
        <button class="btn-submit" name="btn_edit">Cập nhật khoa</button>
    </form>
</div>
<?php
$content = ob_get_clean();
include "../views/admin/layoutNew.php";
?>