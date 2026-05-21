<?php
require_once 'config.php';
if (!isset($_SESSION['userID']) || $_SESSION['accountType'] !== 'admin') {
    header('Location: login.php'); exit;
}

$response = null;

// ADD BOOK
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $bookID  = intval($_POST['bookID']);
    $title   = $conn->real_escape_string($_POST['title']);
    $genre   = $conn->real_escape_string($_POST['genre']);
    $fname   = $conn->real_escape_string($_POST['fname']);
    $lname   = $conn->real_escape_string($_POST['lname']);
    $year    = intval($_POST['year']);
    $price   = intval($_POST['price']);
    $country = $conn->real_escape_string($_POST['country']);
    $stock   = intval($_POST['stock']);
    try {
        // Publisher
        $r = $conn->query("SELECT publisherID FROM Publishers WHERE country='$country'");
        if ($r->num_rows === 0) {
            $conn->query("INSERT INTO Publishers(country) VALUES ('$country')");
        }
        $pubID = $conn->query("SELECT publisherID FROM Publishers WHERE country='$country'")->fetch_row()[0];

        // Author
        $r2 = $conn->query("SELECT authorID FROM Authors WHERE firstName='$fname' AND lastName='$lname'");
        if ($r2->num_rows === 0) {
            $conn->query("INSERT INTO Authors(firstName,lastName) VALUES ('$fname','$lname')");
        }
        $authID = $conn->query("SELECT authorID FROM Authors WHERE firstName='$fname' AND lastName='$lname'")->fetch_row()[0];

        $conn->query("INSERT INTO Books(bookID,authorID,publisherID,title,genre,publicationYear,price) VALUES ($bookID,$authID,$pubID,'$title','$genre',$year,$price)");
        $conn->query("INSERT INTO Inventory(bookID,totalStock,soldStock) VALUES ($bookID,$stock,0)");
        $response = 1;
    } catch (Exception $e) { $response = 0; }
    if ($conn->errno) $response = 0;
}

// UPDATE BOOK
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $bookID  = intval($_POST['bookID']);
    $price1  = intval($_POST['price1']);
    $price2  = intval($_POST['price2']);
    $fname   = $conn->real_escape_string($_POST['fname']);
    $lname   = $conn->real_escape_string($_POST['lname']);
    $country = $conn->real_escape_string($_POST['country']);
    $authRow = $conn->query("SELECT authorID FROM Authors WHERE firstName='$fname' AND lastName='$lname'")->fetch_row();
    $pubRow  = $conn->query("SELECT publisherID FROM Publishers WHERE country='$country'")->fetch_row();
    if ($authRow && $pubRow) {
        $authID = $authRow[0]; $pubID = $pubRow[0];
        $ok = $conn->query("UPDATE Books SET price=$price2 WHERE bookID=$bookID AND authorID=$authID AND publisherID=$pubID AND price=$price1");
        $response = ($conn->affected_rows > 0) ? 1 : 0;
    } else { $response = 0; }
}

// DELETE BOOK
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $bookID  = intval($_POST['bookID']);
    $fname   = $conn->real_escape_string($_POST['fname']);
    $lname   = $conn->real_escape_string($_POST['lname']);
    $country = $conn->real_escape_string($_POST['country']);
    $authRow = $conn->query("SELECT authorID FROM Authors WHERE firstName='$fname' AND lastName='$lname'")->fetch_row();
    $pubRow  = $conn->query("SELECT publisherID FROM Publishers WHERE country='$country'")->fetch_row();
    if ($authRow && $pubRow) {
        $authID = $authRow[0]; $pubID = $pubRow[0];
        $authBooks = $conn->query("SELECT count(*) FROM Books WHERE authorID=$authID")->fetch_row()[0];
        $pubBooks  = $conn->query("SELECT count(*) FROM Books WHERE publisherID=$pubID")->fetch_row()[0];
        $conn->query("DELETE FROM Inventory WHERE bookID=$bookID");
        $conn->query("DELETE FROM Books WHERE bookID=$bookID");
        if ($authBooks == 1) $conn->query("DELETE FROM Authors WHERE authorID=$authID");
        if ($pubBooks  == 1) $conn->query("DELETE FROM Publishers WHERE publisherID=$pubID");
        $response = 1;
    } else { $response = 0; }
}

$adminNav = '<nav id="menu" class="pull-right"><ul>
<li><a href="adminindex.php">Home</a></li>
<li><a href="search.php">Search Books</a></li>
<li><a href="books.php">Books</a><ul><li><a href="books.php">Add</a></li><li><a href="books.php">Update</a></li><li><a href="books.php">Delete</a></li></ul></li>
<li><a href="inventory.php">Inventory</a></li>
<li><a href="users.php">Users</a><ul><li><a href="users.php">Admins</a></li><li><a href="users.php">Customers</a></li></ul></li>
<li><a href="myorders.php">Orders</a></li>
<li><a href="myaccount.php">My Account</a></li>
</ul></nav>';
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
</head>
<body>
<div id="top-bar" class="container">
    <div class="row">
        <div class="span4"><a href="adminindex.php" class="logo pull-left"><img src="static/images/websitelogo.png" class="site_logo" alt=""></a></div>
        <div class="span8"><div class="account pull-right"><ul class="user-menu"><li><a href="logout.php">Logout</a></li></ul></div></div>
    </div>
</div>
<div id="wrapper" class="container">
    <section class="navbar main-menu"><div class="navbar-inner main-menu"><?= $adminNav ?></div></section>
    <section class="main-content">
        <div class="row"><div class="span12">

            <!-- ADD BOOK -->
            <div class="row"><div class="span12">
                <h4 class="title"><span class="pull-left"><span class="text"><span class="line"><strong>ADD </strong>BOOK</span></span></span></h4>
                <div class="content">
                <form action="books.php" class="form-stacked" method="POST">
                    <input type="hidden" name="action" value="add">
                    <fieldset>
                        <div class="control-group"><label class="control-label">Book ISBN</label><div class="controls"><input type="number" placeholder="Enter book ISBN" class="input-xlarge" name="bookID" required></div></div>
                        <div class="control-group"><label class="control-label">Book Title</label><div class="controls"><input type="text" placeholder="Enter book title" class="input-xlarge" name="title" required></div></div>
                        <div class="control-group"><label class="control-label">Genre</label><div class="controls"><input type="text" placeholder="Enter book genre" class="input-xlarge" name="genre" required></div></div>
                        <div class="control-group"><label class="control-label">Price</label><div class="controls"><input type="number" placeholder="Enter book price" class="input-xlarge" name="price" required></div></div>
                        <div class="control-group"><label class="control-label">Author First Name</label><div class="controls"><input type="text" placeholder="Enter first name" class="input-xlarge" name="fname" required></div></div>
                        <div class="control-group"><label class="control-label">Author Last Name</label><div class="controls"><input type="text" placeholder="Enter last name" class="input-xlarge" name="lname" required></div></div>
                        <div class="control-group"><label class="control-label">Publication Year</label><div class="controls"><input type="number" placeholder="Enter the year" class="input-xlarge" name="year" required></div></div>
                        <div class="control-group"><label class="control-label">Publication Country</label><div class="controls"><input type="text" placeholder="Enter the country" class="input-xlarge" name="country" required></div></div>
                        <div class="control-group"><label class="control-label">Stock</label><div class="controls"><input type="number" placeholder="Enter the stock" class="input-xlarge" name="stock" required></div></div>
                        <div class="control-group"><input class="btn btn-inverse large" type="submit" value="Add Book"></div>
                    </fieldset>
                </form>
                </div>
            </div></div>

            <!-- UPDATE BOOK -->
            <div class="row"><div class="span12">
                <h4 class="title"><span class="pull-left"><span class="text"><span class="line"><strong>UPDATE </strong>BOOK Price</span></span></span></h4>
                <div class="content">
                <form action="books.php" class="form-stacked" method="POST">
                    <input type="hidden" name="action" value="update">
                    <fieldset>
                        <div class="control-group"><label class="control-label">Book ISBN</label><div class="controls"><input type="number" placeholder="Enter book ISBN" class="input-xlarge" name="bookID" required></div></div>
                        <div class="control-group"><label class="control-label">Author First Name</label><div class="controls"><input type="text" placeholder="Enter first name" class="input-xlarge" name="fname" required></div></div>
                        <div class="control-group"><label class="control-label">Author Last Name</label><div class="controls"><input type="text" placeholder="Enter last name" class="input-xlarge" name="lname" required></div></div>
                        <div class="control-group"><label class="control-label">Publication Country</label><div class="controls"><input type="text" placeholder="Enter country" class="input-xlarge" name="country" required></div></div>
                        <div class="control-group"><label class="control-label">Original Price</label><div class="controls"><input type="number" placeholder="Enter original price" class="input-xlarge" name="price1" required></div></div>
                        <div class="control-group"><label class="control-label">New Price</label><div class="controls"><input type="number" placeholder="Enter new price" class="input-xlarge" name="price2" required></div></div>
                        <div class="control-group"><input class="btn btn-inverse large" type="submit" value="Update Book Price"></div>
                    </fieldset>
                </form>
                </div>
            </div></div>

            <!-- DELETE BOOK -->
            <div class="row"><div class="span12">
                <h4 class="title"><span class="pull-left"><span class="text"><span class="line"><strong>DELETE </strong>Books</span></span></span></h4>
                <div class="content">
                <form action="books.php" class="form-stacked" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <fieldset>
                        <div class="control-group"><label class="control-label">Book ISBN</label><div class="controls"><input type="number" placeholder="Enter book ISBN" class="input-xlarge" name="bookID" required></div></div>
                        <div class="control-group"><label class="control-label">Author First Name</label><div class="controls"><input type="text" placeholder="Enter first name" class="input-xlarge" name="fname" required></div></div>
                        <div class="control-group"><label class="control-label">Author Last Name</label><div class="controls"><input type="text" placeholder="Enter last name" class="input-xlarge" name="lname" required></div></div>
                        <div class="control-group"><label class="control-label">Publication Country</label><div class="controls"><input type="text" placeholder="Enter the country" class="input-xlarge" name="country" required></div></div>
                        <div class="control-group"><input class="btn btn-inverse large" type="submit" value="Delete Book"></div>
                    </fieldset>
                </form>
                </div>
            </div></div>

        </div></div>
    </section>
    <section id="copyright"></section>
</div>
<?php if ($response === 1): ?><script>alert("Success!");</script><?php endif; ?>
<?php if ($response === 0): ?><script>alert("Operation Failed!");</script><?php endif; ?>
<script src="static/js/common.js"></script>
</body>
</html>
