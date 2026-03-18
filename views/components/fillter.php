<?php
// $departments: danh sách khoa
// $selected: id đang chọn (optional)
// $name: tên input (default: department_id)

$name = $name ?? 'department_id';
$selected = $selected ?? null;
// print_r($departments);die();
?>

<select name="<?= $name ?>" onchange="this.form.submit()" class="select-filter">
    <option value="">-- Tất cả khoa --</option>

    <?php foreach ($departments as $d): ?>
        <option value="<?= $d['id'] ?>" <?= ($selected == $d['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($d['name']) ?>
        </option>
    <?php endforeach; ?>
</select>