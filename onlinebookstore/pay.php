<?php
require_once 'config.php';
if (!isset($_SESSION['userID']) || $_SESSION['accountType'] !== 'customer') { header('Location: login.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: customerindex.php'); exit; }

$isbn     = intval($_GET['isbn'] ?? 0);
$quantity = intval($_GET['quantity'] ?? 0);
$total    = intval($_GET['total'] ?? 0);
$pay      = $_POST['pay'];
$userID   = $conn->real_escape_string($_SESSION['userID']);
$timestamp= date('Y-m-d H:i:s');
$commitStatus = 0;

$conn->begin_transaction();
try {
    $conn->query("INSERT INTO Orders(customerID,bookID,quantity,total,timestamp) VALUES ('$userID',$isbn,$quantity,$total,'$timestamp')");
    $conn->query("UPDATE Inventory SET soldStock=soldStock+$quantity WHERE bookID=$isbn");
    $conn->query("UPDATE Inventory SET totalStock=totalStock-$quantity WHERE bookID=$isbn");

    if ($pay === '1') {
        $conn->query("INSERT INTO Payment(customerID,paymentInfo) VALUES ('$userID',1)");
        $commitStatus = 1;
    } else {
        // Simulate failed payment - rollback
        throw new Exception("Payment failed");
    }
    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    $commitStatus = 0;
}

header("Location: orderconfirmation.php?response=$commitStatus");
exit;
?>
