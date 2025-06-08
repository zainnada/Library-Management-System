<?php
session_start();
if (isset($_COOKIE['admin'])) {
    $_SESSION['admin'] = $_COOKIE['admin'];
}
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>


<?php
//$conn = new mysqli("localhost", "root", "", "shehda_library_db");
// include "db_connect.php";
require_once "db_connect.php"; // require once is better than include, because the database connection is important.

$name = $_POST['name'];
$email = $_POST['email'];
$conn->query("INSERT INTO friends (name, email) VALUES ('$name', '$email')");
header("Location: index.php");
?>
