<?php
require_once 'config.php';
if (!isset($_SESSION['userID'])) { header('Location: login.php'); exit; }
$response = $_GET['response'] ?? '0';
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><title>Daily Dose of Reading</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet"><link href="static/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="static/css/bootstrappage.css" rel="stylesheet"/><link href="static/css/main.css" rel="stylesheet"/>
<script src="static/js/jquery-1.7.2.min.js"></script></head>
<body>
<div id="top-bar" class="container"><div class="row">
    <div class="span4"><a href="customerindex.php" class="logo pull-left"><img src="static/images/websitelogo.png" class="site_logo" alt=""></a></div>
    <div class="span8"><div class="account pull-right"><ul class="user-menu"><li><a href="customerindex.php">Go Back</a></li></ul></div></div>
</div></div>
<div id="wrapper" class="container">
    <section class="main-content"><div class="row"><div class="span12">
        <h4 class="title"><span class="text"><strong>Order</strong> Confirmation</span></h4>
        <?php if ($response === '1'): ?>
            <p>Your order has been placed <strong>successfully</strong>! ✅</p>
        <?php else: ?>
            <p>Your order has <strong>failed</strong>! Please try again. ❌</p>
        <?php endif; ?>
        <br/><a href="customerindex.php" class="btn btn-inverse">Continue Shopping</a>
    </div></div></section>
    <section id="copyright"></section>
</div>
</body></html>
