<h1>Booking List</h1>
<ul>
    <?php foreach ($bookings as $b): ?>
        <li><?= $b->id ?>: <?= htmlspecialchars($b->name) ?></li>
    <?php endforeach; ?>
</ul>
