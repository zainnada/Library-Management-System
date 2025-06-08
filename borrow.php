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


// Get book ID from URL
$book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

// Fetch book details
$book_sql = "SELECT * FROM books WHERE id = ?";
$stmt = $conn->prepare($book_sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$book_result = $stmt->get_result();
$book = $book_result->fetch_assoc();

// Fetch all friends
$friends_result = $conn->query("SELECT * FROM friends");

// Handle borrow request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $friend_id = $_POST['friend_id'];
    $book_id = $_POST['book_id'];

    // Insert borrow record
    $borrow_sql = "INSERT INTO borrows (friend_id, book_id, borrow_date) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($borrow_sql);
    $stmt->bind_param("ii", $friend_id, $book_id);

    if ($stmt->execute()) {
        // Mark book as unavailable
        $update_book_sql = "UPDATE books SET available = 0 WHERE id = ?";
        $stmt = $conn->prepare($update_book_sql);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();

        echo "<script>alert('Book borrowed successfully!'); window.location='index.php';</script>";
    } else {
        echo "Error borrowing book: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<link rel="stylesheet" href="style.css">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow a Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Borrow a Book</h2>
    <form method="post">
        <label>Book:</label>
        <input type="text" value="<?php echo $book ? $book['title'] : ''; ?>" disabled>
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">

        <label>Select Friend:</label>
        <select name="friend_id" required>
            <option value="">-- Choose a Friend --</option>
            <?php while ($friend = $friends_result->fetch_assoc()): ?>
                <option value="<?php echo $friend['id']; ?>"><?php echo $friend['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Confirm Borrow</button>
    </form>

    <a class="a1" href="index.php">Back to Library</a>

</body>
</html>






            <!-- this way make the user choose the book and the friend every time click borrow.. -->
<!--
 
 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $friend_id = $_POST['friend_id'];
    $book_id = $_POST['book_id'];

    $conn->query("INSERT INTO borrows (friend_id, book_id) VALUES ($friend_id, $book_id)");
    $conn->query("UPDATE books SET available = 0 WHERE id = $book_id");
    
    header("Location: index.php");
}

// Fetch friends
$friends = $conn->query("SELECT * FROM friends");

// Fetch available books
$books = $conn->query("SELECT * FROM books WHERE available = 1");
?>

<form method="POST">
    <link rel="stylesheet" href="style.css">

    <label>Select Friend:</label>
    <select name="friend_id">
        <?php while ($row = $friends->fetch_assoc()) : ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
        <?php endwhile; ?>
    </select>

    <label>Select Book:</label>
    <select name="book_id">
        <?php while ($row = $books->fetch_assoc()) : ?>
            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Borrow</button>
</form>
        -->







<?php $conn->close(); ?>




