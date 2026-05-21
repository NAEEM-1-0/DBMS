<?php
require_once 'config.php';
if (!isset($_SESSION['userID']) || $_SESSION['accountType'] !== 'customer') { header('Location: login.php'); exit; }

$bookID = intval($_GET['id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: customerindex.php'); exit; }

$quantity = intval($_POST['quantity']);
$result = $conn->query("SELECT bookID,price,title FROM Books WHERE bookID=$bookID");
$bookData = $result ? $result->fetch_row() : null;
if (!$bookData) { echo "Book not found"; exit; }
$totalPrice = $bookData[1] * $quantity;
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><title>Daily Dose of Reading</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet"><link href="static/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="static/css/bootstrappage.css" rel="stylesheet"/><link href="static/css/main.css" rel="stylesheet"/>
<script src="static/js/jquery-1.7.2.min.js"></script><script src="static/bootstrap/js/bootstrap.min.js"></script></head>
<body>
<div id="top-bar" class="container"><div class="row">
    <div class="span4"><a href="#" class="logo pull-left"><img src="static/images/websitelogo.png" class="site_logo" alt=""></a></div>
</div></div>
<div id="wrapper" class="container">
    <section class="main-content"><div class="row"><div class="span12">
        <h4 class="title"><span class="text"><strong>PAYMENT </strong>DETAILS</span></h4>
        <div class="span5">
            <address>
                <h5><strong>Book Title:</strong> <?= htmlspecialchars($bookData[2]) ?></h5>
                <strong>Book ISBN:</strong> <?= $bookData[0] ?><br>
                <strong>Book Price:</strong> <?= $bookData[1] ?><br>
                <strong>Quantity:</strong> <?= $quantity ?><br>
            </address>
            <h4><strong>Total Price: Rs <?= $totalPrice ?> /-</strong></h4>
            <p><strong>NOTE:</strong> For Transaction Purpose, enter incorrect or correct payment info accordingly</p>
        </div>
        <form action="pay.php?isbn=<?= $bookData[0] ?>&quantity=<?= $quantity ?>&total=<?= $totalPrice ?>" class="form-stacked" method="POST">
            <fieldset>
                <div class="control-group"><label class="control-label">Payment Information</label><div class="controls">
                    <select name="pay">
                        <option value="1" selected>Enter Correct Information</option>
                        <option value="null">Enter Incorrect Information</option>
                    </select>
                </div></div>
                <div class="control-group"><input class="btn btn-inverse large" type="submit" value="PAY NOW"><hr>
                    <p><a href="customerindex.php">Cancel Buy</a></p>
                </div>
            </fieldset>
        </form>
    </div></div></section>
    <section id="copyright"></section>
</div>
<script src="static/js/common.js"></script>
</body></html>
