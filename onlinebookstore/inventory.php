<?php
require_once 'config.php';
if (!isset($_SESSION['userID']) || $_SESSION['accountType'] !== 'admin') { header('Location: login.php'); exit; }
$bookData = $conn->query("SELECT b.bookID,b.title,i.totalStock,i.soldStock FROM Books b,Inventory i WHERE b.bookID=i.bookID")->fetch_all(MYSQLI_NUM);
$adminNav = '<nav id="menu" class="pull-right"><ul><li><a href="adminindex.php">Home</a></li><li><a href="search.php">Search Books</a></li><li><a href="books.php">Books</a><ul><li><a href="books.php">Add</a></li><li><a href="books.php">Update</a></li><li><a href="books.php">Delete</a></li></ul></li><li><a href="inventory.php">Inventory</a></li><li><a href="users.php">Users</a><ul><li><a href="users.php">Admins</a></li><li><a href="users.php">Customers</a></li></ul></li><li><a href="myorders.php">Orders</a></li><li><a href="myaccount.php">My Account</a></li></ul></nav>';
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Daily Dose of Reading</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet"><link href="static/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="static/css/bootstrappage.css" rel="stylesheet"/><link href="static/css/main.css" rel="stylesheet"/>
<script src="static/js/jquery-1.7.2.min.js"></script><script src="static/bootstrap/js/bootstrap.min.js"></script><script src="static/js/superfish.js"></script>
<style>table{font-family:arial,sans-serif;border-collapse:collapse;width:100%}td,th{border:1px solid #ddd;text-align:left;padding:8px}tr:nth-child(even){background-color:#ddd}</style>
</head>
<body>
<div id="top-bar" class="container"><div class="row">
    <div class="span4"><a href="adminindex.php" class="logo pull-left"><img src="static/images/websitelogo.png" class="site_logo" alt=""></a></div>
    <div class="span8"><div class="account pull-right"><ul class="user-menu"><li><a href="logout.php">Logout</a></li></ul></div></div>
</div></div>
<div id="wrapper" class="container">
    <section class="navbar main-menu"><div class="navbar-inner main-menu"><?= $adminNav ?></div></section>
    <section class="main-content"><div class="row"><div class="span12">
        <div class="row"><div class="span12">
            <h4 class="title"><span class="pull-left"><span class="text"><span class="line"><strong>INVENTORY</strong></span></span></span></h4>
            <br/>
            <table>
                <tr><th>Book ISBN</th><th>Title</th><th>Total Stock</th><th>Sold Stock</th></tr>
                <?php foreach ($bookData as $book): ?>
                <tr><td><?= $book[0] ?></td><td><?= htmlspecialchars($book[1]) ?></td><td><?= $book[2] ?></td><td><?= $book[3] ?></td></tr>
                <?php endforeach; ?>
            </table><br/>
        </div></div>
    </div></div></section>
    <section id="copyright"></section>
</div>
<script src="static/js/common.js"></script>
</body></html>
