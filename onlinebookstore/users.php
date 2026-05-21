<?php
require_once 'config.php';
if (!isset($_SESSION['userID']) || $_SESSION['accountType'] !== 'admin') { header('Location: login.php'); exit; }
$adminData    = $conn->query("SELECT * FROM Admins")->fetch_all(MYSQLI_NUM);
$customerData = $conn->query("SELECT * FROM Customers")->fetch_all(MYSQLI_NUM);
$adminNav = '<nav id="menu" class="pull-right"><ul><li><a href="adminindex.php">Home</a></li><li><a href="search.php">Search Books</a></li><li><a href="books.php">Books</a><ul><li><a href="books.php">Add</a></li><li><a href="books.php">Update</a></li><li><a href="books.php">Delete</a></li></ul></li><li><a href="inventory.php">Inventory</a></li><li><a href="users.php">Users</a><ul><li><a href="users.php">Admins</a></li><li><a href="users.php">Customers</a></li></ul></li><li><a href="myorders.php">Orders</a></li><li><a href="myaccount.php">My Account</a></li></ul></nav>';
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><title>Daily Dose of Reading</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet"><link href="static/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="static/css/bootstrappage.css" rel="stylesheet"/><link href="static/css/main.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" crossorigin="anonymous">
<script src="static/js/jquery-1.7.2.min.js"></script><script src="static/bootstrap/js/bootstrap.min.js"></script><script src="static/js/superfish.js"></script></head>
<body>
<div id="top-bar" class="container"><div class="row">
    <div class="span4"><a href="adminindex.php" class="logo pull-left"><img src="static/images/websitelogo.png" class="site_logo" alt=""></a></div>
    <div class="span8"><div class="account pull-right"><ul class="user-menu"><li><a href="logout.php">Logout</a></li></ul></div></div>
</div></div>
<div id="wrapper" class="container">
    <section class="navbar main-menu"><div class="navbar-inner main-menu"><?= $adminNav ?></div></section>
    <section class="main-content"><div class="row"><div class="span12">

        <!-- Admins -->
        <div class="row"><div class="span12">
            <h4 class="title"><span class="pull-left"><span class="text"><span class="line"><strong>Admins</strong></span></span></span></h4>
            <ul class="thumbnails">
                <?php foreach ($adminData as $admin): ?>
                <li class="span2"><div class="product-box">
                    <p><img src="static/images/usericon.jpg" alt="" /></p>
                    <a href="#" class="title"><?= htmlspecialchars($admin[1]) ?> <?= htmlspecialchars($admin[2]) ?></a><br/>
                    <a href="#" class="category"><?= htmlspecialchars($admin[0]) ?></a><br>
                    <p style="font-size:12px"><?= htmlspecialchars($admin[3]) ?><br/><?= htmlspecialchars($admin[5]) ?></p>
                </div></li>
                <?php endforeach; ?>
            </ul>
        </div></div>

        <!-- Customers -->
        <div class="row"><div class="span12">
            <h4 class="title"><span class="pull-left"><span class="text"><span class="line"><strong>Customers</strong></span></span></span></h4>
            <ul class="thumbnails">
                <?php foreach ($customerData as $customer): ?>
                <li class="span2"><div class="product-box">
                    <p><img src="static/images/usericon.jpg" alt="" /></p>
                    <a href="#" class="title"><?= htmlspecialchars($customer[1]) ?> <?= htmlspecialchars($customer[2]) ?></a><br/>
                    <a href="#" class="category"><?= htmlspecialchars($customer[0]) ?></a><br>
                    <p style="font-size:12px"><?= htmlspecialchars($customer[3]) ?><br/><?= htmlspecialchars($customer[5]) ?></p>
                </div></li>
                <?php endforeach; ?>
            </ul>
        </div></div>

    </div></div></section>
    <section id="copyright"></section>
</div>
<script src="static/js/common.js"></script>
</body></html>
