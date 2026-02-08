<!DOCTYPE html>
<html>
<head>
    <title>Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="css/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owlcarousel/owl.theme.default.min.css">
    <link href="/css/cms.css" rel="stylesheet">
</head>
<body id="<?php echo $bodyid ?? ''?>">
<div class="header">
    <div class="container">
        <div class="row accountbtns">
            <div class="col-lg-2">
                <a class="btn" href="/cms">CMS</a>
            </div>
            <div class="col-lg-8"></div>
            <div class="col-lg-2">
                <?php
                if(!isset($_SESSION['userid'])){
                    echo '<a class="btn" href="/login">Login</a>';
                    echo '<a class="btn" href="/register">Register</a>';
                } else {
                    echo '<a class="btn" href="/account">Account</a>';
                    echo '<a class="btn" href="/cms/logout">Logout</a>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="navcont">
        <div class="container">
            <ul class="nav">
                <li class="navlink <?php echo ($_SERVER['REQUEST_URI'] == '/cms' ? 'active' : ''); ?>"><a href="/cms">Home</a></li>
                <?php if(isset($_SESSION['role']) && in_array($_SESSION['role'], array('admin', 'barber', 'superuser', 'owner'))){ ?>
                    <li class="navlink <?php echo ($_SERVER['REQUEST_URI'] == '/cms/users' ? 'active' : ''); ?>"><a href="/cms/users">Users</a></li>
                <?php } ?>
                <li class="navlink <?php echo ($_SERVER['REQUEST_URI'] == '/cms/customers' ? 'active' : ''); ?>"><a href="/cms/customers">Customers</a></li>
                <li class="navlink <?php echo ($_SERVER['REQUEST_URI'] == '/cms/bookings' ? 'active' : ''); ?>"><a href="/cms/bookings">Bookings</a></li>
                <li class="navlink <?php echo ($_SERVER['REQUEST_URI'] == '/cms/reports' ? 'active' : ''); ?>"><a href="/cms/reports">Reports</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <?php
    $path = $_SERVER['REQUEST_URI']; // e.g. /usered/1
    $segments = explode('/', trim($path, '/')); // splits into ["usered","1"]

    // check if last segment is numeric
    if (isset($segments[1]) && is_numeric($segments[1])): ?>
        <a href="/users" class="btn">Back</a>
    <?php endif; ?>
</div>
