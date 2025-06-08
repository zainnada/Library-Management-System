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
// Include database connection
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

// Check if friend ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid friend ID.");
}

$friend_id = $_GET['id'];

// Check if the friend has borrowed books
$check_borrow_sql = "SELECT * FROM borrows WHERE friend_id = ?";
$stmt = $conn->prepare($check_borrow_sql);
$stmt->bind_param("i", $friend_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Cannot delete this friend. They have borrowed books.'); window.location='index.php';</script>";
    exit();
}

// Delete friend from the database
$sql = "DELETE FROM friends WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $friend_id);

if ($stmt->execute()) {
    echo "<script>alert('Friend deleted successfully!'); window.location='index.php';</script>";
} else {
    echo "Error deleting friend: " . $conn->error;
}

$conn->close();
?>
