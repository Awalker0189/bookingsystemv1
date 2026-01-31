<h1>Users List</h1>
<ul>
    <?php foreach ($users as $user): ?>
        <li><?= $user->userid ?>: <?= htmlspecialchars($user->firstname) ?></li>
    <?php endforeach; ?>
</ul>
