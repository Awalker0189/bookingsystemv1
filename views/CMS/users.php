<div class="container">
    <h1>Users List</h1>
    <table class="userstable">
        <tr>
            <th>Actions</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Position</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><a href="/cms/usered/<?= $user->userid ?>">Edit</a></td>
                <td> <?= htmlspecialchars($user->firstname) ?></td>
                <td> <?= htmlspecialchars($user->lastname) ?></td>
                <td> <?= htmlspecialchars($user->role) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
