<h2>Trang giảng viên</h2>

<ul class="menu">
    <?php if (!empty($subjectsTeaching)): ?>
        <?php foreach ($subjectsTeaching as $subject): ?>
            <li>
                <a href="index.php?controller=lecturer&action=getSubjectSchedule&subject_id=<?= $subject['id'] ?>"
                   class="menu-link">
                    <i class="bx bxs-book"></i>
                    <?= htmlspecialchars($subject['name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    <?php else: ?>
        <li class="empty">
            <span>Chưa được phân công môn học</span>
        </li>
    <?php endif; ?>
</ul>
