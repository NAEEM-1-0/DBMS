<?php
require_once 'config.php';
if (!isset($_SESSION['userID']) || $_SESSION['accountType'] !== 'customer') { header('Location: login.php'); exit; }
$id = intval($_GET['id'] ?? 0);
$result = $conn->query("SELECT b.bookID,b.title,b.genre,b.price,b.publicationYear,a.firstName,a.lastName,p.country FROM Books b JOIN Authors a ON b.authorID=a.authorID JOIN Publishers p ON b.publisherID=p.publisherID WHERE b.bookID=$id");
$bookData = $result ? $result->fetch_row() : null;
if (!$bookData) { echo "Book not found"; exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><title>Daily Dose of Reading</title><meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet"><link href="static/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="static/css/bootstrappage.css" rel="stylesheet"/><link href="static/css/main.css" rel="stylesheet"/>
<script src="static/js/jquery-1.7.2.min.js"></script><script src="static/bootstrap/js/bootstrap.min.js"></script><script src="static/js/superfish.js"></script></head>
<body>
<div id="top-bar" class="container"><div class="row">
    <div class="span4"><a href="customerindex.php" class="logo pull-left"><img src="static/images/websitelogo.png" class="site_logo" alt=""></a></div>
    <div class="span8"><div class="account pull-right"><ul class="user-menu"><li><a href="customerindex.php">Go Back</a></li></ul></div></div>
</div></div>
<div id="wrapper" class="container">
    <section class="main-content"><div class="row"><div class="span12">
        <h4 class="title"><span class="text"><strong>BOOK</strong> Details</span></h4>
        <div class="span5">
            <address>
                <h5><strong>Title:</strong> <?= htmlspecialchars($bookData[1]) ?></h5>
                <strong>Book ISBN:</strong> <?= $bookData[0] ?><br>
                <strong>Genre:</strong> <?= htmlspecialchars($bookData[2]) ?><br>
                <strong>Author Name:</strong> <?= htmlspecialchars($bookData[5]) ?> <?= htmlspecialchars($bookData[6]) ?><br>
                <strong>Publication Year:</strong> <?= $bookData[4] ?><br>
                <strong>Publication Country:</strong> <?= htmlspecialchars($bookData[7]) ?><br>
            </address>
            <h4><strong>Price: Rs <?= $bookData[3] ?> /-</strong></h4><br/>
        </div>
        <form action="buybook.php?id=<?= $bookData[0] ?>" class="form-stacked" method="POST">
            <fieldset>
                <div class="control-group"><label class="control-label">Quantity</label>
                    <div class="controls"><input type="number" placeholder="enter quantity" class="input-xlarge" name="quantity" min="1" max="5" required></div>
                </div>
                <div class="control-group">
                    <input class="btn btn-inverse large" type="submit" value="BUY NOW"><hr>
                    <p><a href="customerindex.php">Cancel Buy</a></p>
                </div>
            </fieldset>
        </form>
    </div></div></section>
    <section id="copyright"></section>
</div>
<script src="static/js/common.js"></script>
</body></html>
