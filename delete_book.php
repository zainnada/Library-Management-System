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


// Check if book ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid book ID.");
}

$book_id = $_GET['id'];

// Delete book from the database
$sql = "DELETE FROM books WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);

if ($stmt->execute()) {
    echo "<script>alert('Book deleted successfully!'); window.location='index.php';</script>";
} else {
    echo "Error deleting book: " . $conn->error;
}


/*

if ($_GET['available']){

        // Delete book from the database
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        echo "<script>alert('Book deleted successfully!'); window.location='index.php';</script>";
    } else {
        echo "Error deleting book: " . $conn->error;
    }

}
else{
    echo "You can't delete a borrowed book";
}

*/

$conn->close();
?>
