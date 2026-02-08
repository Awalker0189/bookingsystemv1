<div class="container">
    <h1>Customer List</h1>
    <div class="filters">
        <form action="" method="post">
            <label for="keyword">Search: <input type="text" name="keyword"></label>
            <label for="active">Active: <select name="active" id="">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select></label>
            <input type="submit" value="Search">
        </form>
    </div>
    <table class="userstable">
        <tr>
            <th>Actions</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Position</th>
        </tr>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><a href="/cms/usered/<?= $customer->userid ?>">Edit</a></td>
                <td> <?= htmlspecialchars($customer->firstname) ?></td>
                <td> <?= htmlspecialchars($customer->lastname) ?></td>
                <td> <?= htmlspecialchars($customer->active) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
