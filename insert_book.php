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

$title = $_POST['title'];
$author = $_POST['author'];
$conn->query("INSERT INTO books (title, author) VALUES ('$title', '$author')");
header("Location: index.php");
?>
