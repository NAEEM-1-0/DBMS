<?php
// Database configuration - XAMPP default settings
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');          // XAMPP default: no password
define('DB_NAME', 'onlinebookstore');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("<div style='color:red;padding:20px;font-family:arial'>
        <h3>Database Connection Failed!</h3>
        <p>Error: " . $conn->connect_error . "</p>
        <p>Make sure XAMPP MySQL is running and the database <b>onlinebookstore</b> is imported.</p>
    </div>");
}
$conn->set_charset("utf8");

session_start();
?>
