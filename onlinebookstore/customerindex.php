<?php
require_once 'config.php';
if (!isset($_SESSION['userID']) || $_SESSION['accountType'] !== 'customer') {
    header('Location: login.php'); exit;
}

$genre_imgs = [
    'Adventure' => 'https://picsum.photos/seed/adventurebook/120/160',
    'Horror'    => 'https://picsum.photos/seed/horrorbook/120/160',
    'Mystery'   => 'https://picsum.photos/seed/mysterybook/120/160',
    'Fiction'   => 'https://picsum.photos/seed/fictionbook/120/160',
    'Science Fiction' => 'https://picsum.photos/seed/scifibook/120/160',
    'History'   => 'https://picsum.photos/seed/historybook/120/160',
];
$booksData = $conn->query("SELECT b.bookID,a.authorID,b.publisherID,b.title,b.genre,b.publicationYear,b.price,a.firstName,a.lastName FROM Books as b INNER JOIN Authors as a ON b.authorID = a.authorID ORDER BY bookID")->fetch_all(MYSQLI_NUM);
$genreData = $conn->query("SELECT DISTINCT genre FROM Books")->fetch_all(MYSQLI_NUM);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"><title>Daily Dose of Reading</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="static/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="static/css/bootstrappage.css" rel="stylesheet"/>
    <link href="static/css/flexslider.css" rel="stylesheet"/>
    <link href="static/css/main.css" rel="stylesheet"/>
    <script src="static/js/jquery-1.7.2.min.js"></script>
    <script src="static/bootstrap/js/bootstrap.min.js"></script>
    <script src="static/js/superfish.js"></script>
    <script src="static/js/jquery.scrolltotop.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" crossorigin="anonymous">
</head>
<body>
<div id="top-bar" class="container">
    <div class="row">
        <div class="span4"><a href="customerindex.php" class="logo pull-left"><img src="static/images/websitelogo.png" class="site_logo" alt=""></a></div>
        <div class="span8"><div class="account pull-right"><ul class="user-menu"><li><a href="logout.php">Logout</a></li></ul></div></div>
    </div>
</div>
<div id="wrapper" class="container">
    <section class="navbar main-menu">
        <div class="navbar-inner main-menu">
            <nav id="menu" class="pull-right">
                <ul>
                    <li><a href="customerindex.php">Home</a></li>
                    <li><a href="customersearch.php">Search Books</a></li>
                    <li><a href="myorders.php">My Orders</a></li>
                    <li><a href="myaccount.php">My Account</a></li>
                </ul>
            </nav>
        </div>
    </section>
    <br/>
    <section class="homepage-slider" id="home-slider">
        <div class="flexslider">
            <ul class="slides">
                <li><img src="static/images/carousel/carousel1.jpg" alt="" /></li>
                <li><img src="static/images/carousel/carousel2.jpg" alt="" /></li>
                <li><img src="static/images/carousel/Carousel3.jpg" alt="" /></li>
                <li><img src="static/images/carousel/Carousel4.jpg" alt="" /></li>
            </ul>
        </div>
    </section>
    <section class="header_text">
        There is more treasure in books than in all the pirate's loot on Treasure Island.<br/> - Walt Disney
    </section>

    <section class="main-content">
        <div class="row"><div class="span12">
            <!-- GENRE -->
            <div class="row"><div class="span12">
                <h4 class="title"><span class="pull-left"><span class="text"><span class="line"><strong>GENRE</strong></span></span></span></h4>
                <div class="myCarousel carousel slide"><div class="carousel-inner"><div class="active item">
                    <ul class="thumbnails">
                        <?php foreach ($genreData as $genre): ?>
                        <li class="span2"><div class="product-box">
                            <p><a href="#"><img src="<?= isset($genre_imgs[$genre[0]]) ? $genre_imgs[$genre[0]] : 'static/images/books/genre.png' ?>" alt="<?= htmlspecialchars($genre[0]) ?>" style="width:120px;height:160px;object-fit:cover;border-radius:4px;" /></a></p>
                            <p class="price"><?= htmlspecialchars($genre[0]) ?></p>
                        </div></li>
                        <?php endforeach; ?>
                    </ul>
                </div></div></div>
            </div></div>
            <br/>

            <!-- Books by Genre -->
            <?php foreach ($genreData as $genre): ?>
            <div class="row"><div class="span12">
                <h4 class="title"><span class="pull-left"><span class="text"><span class="line"><strong><?= htmlspecialchars($genre[0]) ?></strong> Books</span></span></span></h4>
                <div class="myCarousel carousel slide"><div class="carousel-inner"><div class="active item">
                    <ul class="thumbnails">
                        <?php foreach ($booksData as $book): if ($book[4] == $genre[0]): ?>
                        <li class="span2"><div class="product-box">
                            <p><a href="bookdetail.php?id=<?= $book[0] ?>"><img src="<?= isset($genre_imgs[$book[4]]) ? $genre_imgs[$book[4]] : 'static/images/books/book.png' ?>" alt="<?= htmlspecialchars($book[3]) ?>" style="width:120px;height:160px;object-fit:cover;border-radius:4px;" /></a></p>
                            <a href="bookdetail.php?id=<?= $book[0] ?>" class="title"><?= htmlspecialchars($book[3]) ?> (<?= $book[0] ?>)</a><br/>
                            <a href="bookdetail.php?id=<?= $book[0] ?>" class="title">- <?= htmlspecialchars($book[7]) ?> <?= htmlspecialchars($book[8]) ?></a><br/>
                            <a href="bookdetail.php?id=<?= $book[0] ?>" class="category"><?= htmlspecialchars($book[4]) ?></a>
                            <p class="price">Rs <?= $book[6] ?> /-</p>
                        </div></li>
                        <?php endif; endforeach; ?>
                    </ul>
                </div></div></div>
            </div></div>
            <?php endforeach; ?>

            <!-- All Books -->
            <div class="row"><div class="span12">
                <h4 class="title"><span class="pull-left"><span class="text"><span class="line"><strong>All </strong>Books</span></span></span></h4>
                <div class="myCarousel carousel slide"><div class="carousel-inner"><div class="active item">
                    <ul class="thumbnails">
                        <?php foreach ($booksData as $book): ?>
                        <li class="span2"><div class="product-box">
                            <p><a href="bookdetail.php?id=<?= $book[0] ?>"><img src="<?= isset($genre_imgs[$book[4]]) ? $genre_imgs[$book[4]] : 'static/images/books/book.png' ?>" alt="<?= htmlspecialchars($book[3]) ?>" style="width:120px;height:160px;object-fit:cover;border-radius:4px;" /></a></p>
                            <a href="bookdetail.php?id=<?= $book[0] ?>" class="title"><?= htmlspecialchars($book[3]) ?> (<?= $book[0] ?>)</a><br/>
                            <a href="bookdetail.php?id=<?= $book[0] ?>" class="title">- <?= htmlspecialchars($book[7]) ?> <?= htmlspecialchars($book[8]) ?></a><br/>
                            <a href="bookdetail.php?id=<?= $book[0] ?>" class="category"><?= htmlspecialchars($book[4]) ?></a>
                            <p class="price">Rs <?= $book[6] ?> /-</p>
                        </div></li>
                        <?php endforeach; ?>
                    </ul>
                </div></div></div>
            </div></div>

            <!-- Developer -->
            <h4 class="title"><span class="text"><strong>Developer</strong></span></h4>
            <div class="row feature_box"><div class="span3"><div class="service"><div class="responsive">
                <img src="static/images/feature_img_3.png" alt="" />
                <h4><strong>M J Naeem</strong></h4><p>&nbsp;</p>
                <a href="mailto:mjnaeem2004@gmail.com"><i class="far fa-envelope" style="font-size:24px;color:black"></i></a>
                <a href="https://github.com/NAEEM-1-0"><i class="fab fa-github" style="font-size:24px;color:black"></i></a>
            </div></div></div></div>

        </div></div>
    </section>

    <section id="footer-bar">
        <div class="row"><div class="span3">
            <h3 class="contact"><span><strong>CONTACT US</strong></span></h3>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
                $fname = $conn->real_escape_string($_POST['fname']);
                $lname = $conn->real_escape_string($_POST['lname']);
                $email = $conn->real_escape_string($_POST['emailID']);
                $message = $conn->real_escape_string($_POST['message']);
                $ts = date('Y-m-d H:i:s');
                $conn->query("INSERT INTO ContactUs(firstName,lastName,emailID,message,timestamp) VALUES ('$fname','$lname','$email','$message','$ts')");
                echo '<script>alert("Message Submitted!");</script>';
            }
            ?>
            <form action="customerindex.php" class="form-stacked" method="POST">
                <fieldset>
                    <div class="control-group"><label class="control-label">First Name</label><div class="controls"><input type="text" class="input-xlarge" name="fname"></div></div>
                    <div class="control-group"><label class="control-label">Last Name</label><div class="controls"><input type="text" class="input-xlarge" name="lname"></div></div>
                    <div class="control-group"><label class="control-label">Mail Id</label><div class="controls"><input type="text" class="input-xlarge" name="emailID"></div></div>
                    <div class="control-group"><label class="control-label">Message Us</label><div class="controls"><textarea style="height:200px;width:336px" name="message"></textarea></div></div>
                    <div class="control-group"><input class="btn btn-inverse large" type="submit" value="Submit" name="submit"></div>
                </fieldset>
            </form>
        </div></div>
    </section>
    <section id="copyright"></section>
</div>
<script src="static/js/common.js"></script>
<script src="static/js/jquery.flexslider-min.js"></script>
<script>$(function(){$(document).ready(function(){$('.flexslider').flexslider({animation:"fade",slideshowSpeed:4000,animationSpeed:600,controlNav:false,directionNav:true});});});</script>
<style>.contact{color:#eb4800}</style>
</body>
</html>
