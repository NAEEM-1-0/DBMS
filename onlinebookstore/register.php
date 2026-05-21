<?php require_once 'config.php';

$response = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $fname    = $conn->real_escape_string($_POST['fname']);
    $lname    = $conn->real_escape_string($_POST['lname']);
    $email    = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $phone    = $conn->real_escape_string($_POST['phone']);
    $country  = $conn->real_escape_string($_POST['country']);
    $state    = $conn->real_escape_string($_POST['state']);
    $pincode  = $conn->real_escape_string($_POST['pincode']);
    $address  = $conn->real_escape_string($_POST['address']);

    $sql = "INSERT INTO Customers(customerID,firstName,lastName,address,pincode,country,phone,state,emailID,password)
            VALUES ('$username','$fname','$lname','$address','$pincode','$country','$phone','$state','$email','$password')";
    if ($conn->query($sql)) {
        $response = 1;
    } else {
        $response = 0;
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
</head>
<body>
    <div id="top-bar" class="container">
        <div class="row">
            <div class="span4"><a href="index.php" class="logo pull-left"><img src="static/images/websitelogo.png" class="site_logo" alt=""></a></div>
            <div class="span8">
                <div class="account pull-right">
                    <ul class="user-menu">
                        <li><a href="index.php">Go Back</a></li>
                        <li><a href="login.php">Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="wrapper" class="container">
        <section class="main-content">
            <div class="row">
                <div class="span12">
                    <h4 class="title"><span class="text"><strong>Register</strong> Form</span></h4>
                    <div class="content">
                        <form action="register.php" method="POST" class="form-stacked">
                            <fieldset>
                                <div class="control-group"><label class="control-label">Username</label><div class="controls"><input type="text" placeholder="Enter your username" class="input-xlarge" name="username" required></div></div>
                                <div class="control-group"><label class="control-label">Email address</label><div class="controls"><input type="email" placeholder="Enter your email" class="input-xlarge" name="email" required></div></div>
                                <div class="control-group"><label class="control-label">Password</label><div class="controls"><input type="password" placeholder="Enter your password" class="input-xlarge" name="password" required minlength="8"></div></div>
                                <div class="control-group"><label class="control-label">First Name</label><div class="controls"><input type="text" placeholder="Enter your first name" class="input-xlarge" name="fname" required></div></div>
                                <div class="control-group"><label class="control-label">Last Name</label><div class="controls"><input type="text" placeholder="Enter your last name" class="input-xlarge" name="lname" required></div></div>
                                <div class="control-group"><label class="control-label">Phone Number</label><div class="controls"><input type="number" placeholder="Enter your phone number" class="input-xlarge" name="phone" required></div></div>
                                <div class="control-group"><label class="control-label">State</label><div class="controls"><input type="text" placeholder="Enter your state" class="input-xlarge" name="state" required></div></div>
                                <div class="control-group"><label class="control-label">Pincode</label><div class="controls"><input type="number" placeholder="Enter your pincode" class="input-xlarge" name="pincode" required></div></div>
                                <div class="control-group"><label class="control-label">Address</label><div class="controls"><input type="text" placeholder="Enter your address" class="input-xlarge" name="address" required></div></div>
                                <div class="control-group"><label class="control-label">Country</label><div class="controls"><input type="text" placeholder="Enter your country" class="input-xlarge" name="country" required></div></div>
                                <div class="actions"><input class="btn btn-inverse large" type="submit" value="Create your account"></div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php if ($response === 1): ?><script>alert("Registration successful!");</script><?php endif; ?>
    <?php if ($response === 0): ?><script>alert("Registration Failed! Username may already exist.");</script><?php endif; ?>
</body>
</html>
