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

// Fetch book details
$sql = "SELECT * FROM books WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    die("Book not found.");
}

// Update book details (Only Title & Author)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];

    $update_sql = "UPDATE books SET title=?, author=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $title, $author, $book_id);

    if ($stmt->execute()) {
        echo "<script>alert('Book updated successfully!'); window.location='index.php';</script>";
    } else {
        echo "Error updating book: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Book</h2>
    <form method="post">
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>

        <label>Author:</label>
        <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>

        <button type="submit">Update Book</button>
    </form>
    <a class="a1" href="index.php">Back to Library</a>
</body>
</html>

<?php $conn->close(); ?>