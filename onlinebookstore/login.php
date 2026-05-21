<?php require_once 'config.php';

$response = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $account  = $_POST['account'];

    if ($account === 'customer') {
        $result = $conn->query("SELECT * FROM Customers WHERE customerID='$username' AND password='$password'");
        if ($result && $result->num_rows > 0) {
            $_SESSION['userID'] = $username;
            $_SESSION['accountType'] = 'customer';
            header('Location: customerindex.php');
            exit;
        } else { $response = 0; }
    } elseif ($account === 'admin') {
        $result = $conn->query("SELECT * FROM Admins WHERE adminID='$username' AND password='$password'");
        if ($result && $result->num_rows > 0) {
            $_SESSION['userID'] = $username;
            $_SESSION['accountType'] = 'admin';
            header('Location: adminindex.php');
            exit;
        } else { $response = 0; }
    }
}
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
</head>
<body>
    <div id="top-bar" class="container">
        <div class="row">
            <div class="span4"><a href="index.php" class="logo pull-left"><img src="static/images/websitelogo.png" class="site_logo" alt=""></a></div>
            <div class="span8">
                <div class="account pull-right">
                    <ul class="user-menu">
                        <li><a href="index.php">Go Back</a></li>
                        <li><a href="register.php">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="wrapper" class="container">
        <section class="main-content">
            <div class="row">
                <div class="span12">
                    <h4 class="title"><span class="text"><strong>Login</strong> Form</span></h4>
                    <div class="content">
                        <form action="login.php" class="form-stacked" method="POST">
                            <fieldset>
                                <div class="control-group">
                                    <label class="control-label">Username</label>
                                    <div class="controls"><input type="text" placeholder="Enter your username" class="input-xlarge" name="username" required></div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Password</label>
                                    <div class="controls"><input type="password" placeholder="Enter your password" class="input-xlarge" name="password" required></div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Account Type</label>
                                    <div class="controls">
                                        <select name="account">
                                            <option value="customer" selected>Customer</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <input class="btn btn-inverse large" type="submit" value="Sign into your account">
                                    <hr>
                                    <p class="reset"><a href="#">Forgot password?</a></p>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php if ($response === 0): ?>
    <script>alert("Login Failed! Please enter correct credentials");</script>
    <?php endif; ?>
</body>
</html>
