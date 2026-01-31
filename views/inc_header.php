<!DOCTYPE html>
<html>
<head>
    <title>Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="owlcarousel/owl.theme.default.min.css">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>
<div class="header">
    <div class="banner">

    </div>
    <div>
        <ul class="nav">
            <li class="navlink <?php echo ($_SERVER['REQUEST_URI'] == '/' ? 'active' : ''); ?>"><a href="/">Home</a></li>
            <li class="navlink <?php echo ($_SERVER['REQUEST_URI'] == '/users' ? 'active' : ''); ?>"><a href="/users">Users</a></li>
            <li class="navlink <?php echo ($_SERVER['REQUEST_URI'] == '/bookings' ? 'active' : ''); ?>"><a href="/bookings">Bookings</a></li>
        </ul>
    </div>
    <!-- Set up your HTML -->
    <div class="owl-carousel">
        <div> Your Content </div>
        <div> Your Content </div>
        <div> Your Content </div>
        <div> Your Content </div>
        <div> Your Content </div>
        <div> Your Content </div>
        <div> Your Content </div>
    </div>

</div>
