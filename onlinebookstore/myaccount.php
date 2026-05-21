<?php
require_once 'config.php';
if (!isset($_SESSION['userID'])) { header('Location: login.php'); exit; }
$userID      = $conn->real_escape_string($_SESSION['userID']);
$accountType = $_SESSION['accountType'];

if ($accountType === 'admin') {
    $Data = $conn->query("SELECT * FROM Admins WHERE adminID='$userID'")->fetch_row();
} else {
    $Data = $conn->query("SELECT * FROM Customers WHERE customerID='$userID'")->fetch_row();
}

$adminNav    = '<nav id="menu" class="pull-right"><ul><li><a href="adminindex.php">Home</a></li><li><a href="search.php">Search Books</a></li><li><a href="books.php">Books</a><ul><li><a href="books.php">Add</a></li><li><a href="books.php">Update</a></li><li><a href="books.php">Delete</a></li></ul></li><li><a href="inventory.php">Inventory</a></li><li><a href="users.php">Users</a><ul><li><a href="users.php">Admins</a></li><li><a href="users.php">Customers</a></li></ul></li><li><a href="myorders.php">Orders</a></li><li><a href="myaccount.php">My Account</a></li></ul></nav>';
$customerNav = '<nav id="menu" class="pull-right"><ul><li><a href="customerindex.php">Home</a></li><li><a href="customersearch.php">Search Books</a></li><li><a href="myorders.php">My Orders</a></li><li><a href="myaccount.php">My Account</a></li></ul></nav>';
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
    <div class="span4"><a href="<?= $accountType==='admin'?'adminindex.php':'customerindex.php' ?>" class="logo pull-left"><img src="static/images/websitelogo.png" class="site_logo" alt=""></a></div>
    <div class="span8"><div class="account pull-right"><ul class="user-menu"><li><a href="logout.php">Logout</a></li></ul></div></div>
</div></div>
<div id="wrapper" class="container">
    <section class="navbar main-menu"><div class="navbar-inner main-menu">
        <?= $accountType === 'admin' ? $adminNav : $customerNav ?>
    </div></section>
    <section class="main-content"><div class="row"><div class="span12">
        <h4 class="title"><span class="pull-left"><span class="text"><span class="line"><strong>My Account</strong></span></span></span></h4>
        <section class="header_text">
            <p><img src="static/images/usericon.jpg" alt="" width="70" height="70" /></p>
            <p>
                NAME:- <?= htmlspecialchars($Data[1]) ?> <?= htmlspecialchars($Data[2]) ?><br/>
                USERNAME:- <?= htmlspecialchars($Data[0]) ?><br/>
                ACCOUNT TYPE:- <?= htmlspecialchars($accountType) ?><br/>
                EMAIL ID:- <?= htmlspecialchars($Data[3]) ?><br/>
                PHONE NO:- <?= htmlspecialchars($Data[5]) ?><br/>
                PASSWORD:- <?= htmlspecialchars($Data[4]) ?>
            </p>
            <?php if ($accountType === 'customer'): ?>
            <p>
                COUNTRY:- <?= htmlspecialchars($Data[6] ?? '') ?><br/>
                STATE:- <?= htmlspecialchars($Data[7] ?? '') ?><br/>
                PINCODE:- <?= htmlspecialchars($Data[8] ?? '') ?><br/>
                ADDRESS:- <?= htmlspecialchars($Data[9] ?? '') ?>
            </p>
            <?php endif; ?>
        </section>
    </div></div></section>
    <section id="copyright"></section>
</div>
<script src="static/js/common.js"></script>
</body></html>
