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
/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shehda_library_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
*/
// include "db_connect.php";
require_once "db_connect.php"; // require once is better than include, because the database connection is important.

$borrow_id = $_GET['borrow_id'];

// يفترض ان الكتاب الذي يتم ارجاعه يختفي زر الارجاع من عنده
// 

$conn->query("UPDATE borrows SET return_date = NOW() WHERE id = $borrow_id");
$conn->query("UPDATE books SET available = 1 WHERE id = (SELECT book_id FROM borrows WHERE id = $borrow_id)");

header("Location: index.php");
?>
