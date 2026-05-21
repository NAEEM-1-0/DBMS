<?php
require_once 'config.php';
if (!isset($_SESSION['userID']) || $_SESSION['accountType'] !== 'customer') { header('Location: login.php'); exit; }

$booksData = []; $search = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = $_POST['search'];
    $query  = '%' . $conn->real_escape_string($_POST['query']) . '%';
    $sql = '';
    if ($search === 'title')  $sql = "SELECT b.bookID,a.authorID,b.publisherID,b.title,b.genre,b.publicationYear,b.price,a.firstName,a.lastName FROM Books b,Authors a WHERE title LIKE '$query' AND b.authorID=a.authorID";
    if ($search === 'genre')  $sql = "SELECT b.bookID,a.authorID,b.publisherID,b.title,b.genre,b.publicationYear,b.price,a.firstName,a.lastName FROM Books b,Authors a WHERE b.genre LIKE '$query' AND b.authorID=a.authorID";
    if ($search === 'author') $sql = "SELECT b.bookID,a.authorID,b.publisherID,b.title,b.genre,b.publicationYear,b.price,a.firstName,a.lastName FROM Books b,Authors a WHERE (a.firstName LIKE '$query' OR a.lastName LIKE '$query') AND b.authorID=a.authorID";
    if ($sql) $booksData = $conn->query($sql)->fetch_all(MYSQLI_NUM);
}
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
    <div class="span8"><div class="account pull-right"><ul class="user-menu"><li><a href="logout.php">Logout</a></li></ul></div></div>
</div></div>
<div id="wrapper" class="container">
    <section class="navbar main-menu"><div class="navbar-inner main-menu"><nav id="menu" class="pull-right"><ul>
        <li><a href="customerindex.php">Home</a></li><li><a href="customersearch.php">Search Books</a></li>
        <li><a href="myorders.php">My Orders</a></li><li><a href="myaccount.php">My Account</a></li>
    </ul></nav></div></section>
    <section class="main-content"><div class="row"><div class="span12">
        <div class="row"><div class="span12">
            <h4 class="title"><span class="pull-left"><span class="text"><span class="line"><strong>Search</strong></span></span></span></h4>
            <form action="customersearch.php" class="form-stacked" method="POST">
                <fieldset>
                    <div class="control-group"><label class="control-label">Search by</label><div class="controls">
                        <select name="search">
                            <option value="title" <?= $search=='title'?'selected':'' ?>>Title</option>
                            <option value="genre" <?= $search=='genre'?'selected':'' ?>>Genre</option>
                            <option value="author" <?= $search=='author'?'selected':'' ?>>Author</option>
                        </select>
                    </div></div>
                    <div class="control-group"><label class="control-label">Query</label><div class="controls"><input type="text" placeholder="Enter search query" class="input-xlarge" name="query" required></div></div>
                    <div class="control-group"><input class="btn btn-inverse large" type="submit" value="Search"></div>
                </fieldset>
            </form>
        </div></div>

        <?php if (!empty($booksData)): ?>
        <div class="row"><div class="span12">
            <h4 class="title"><span class="pull-left"><span class="text"><span class="line"><strong>Result</strong></span></span></span></h4>
            <ul class="thumbnails">
                <?php foreach ($booksData as $book): ?>
                <li class="span2"><div class="product-box">
                    <p><a href="bookdetail.php?id=<?= $book[0] ?>"><img src="static/images/books/book.png" alt="" /></a></p>
                    <a href="bookdetail.php?id=<?= $book[0] ?>" class="title"><?= htmlspecialchars($book[3]) ?> (<?= $book[0] ?>)</a><br/>
                    <a href="bookdetail.php?id=<?= $book[0] ?>" class="title">- <?= htmlspecialchars($book[7]) ?> <?= htmlspecialchars($book[8]) ?></a><br/>
                    <a href="bookdetail.php?id=<?= $book[0] ?>" class="category"><?= htmlspecialchars($book[4]) ?></a>
                    <p class="price">Rs <?= $book[6] ?> /-</p>
                </div></li>
                <?php endforeach; ?>
            </ul>
        </div></div>
        <?php endif; ?>
    </div></div></section>
    <section id="copyright"></section>
</div>
<script src="static/js/common.js"></script>
</body></html>
