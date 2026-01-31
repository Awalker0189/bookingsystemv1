<!DOCTYPE html>
<html>
<head>
    <title>Bookings</title>
</head>
<body>
<h1>Booking List</h1>
<ul>
    <?php foreach ($bookings as $b): ?>
        <li><?= $b->id ?>: <?= htmlspecialchars($b->name) ?></li>
    <?php endforeach; ?>
</ul>
</body>
</html>
