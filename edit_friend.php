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

// Fetch book details
$sql = "SELECT * FROM friends WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $friend_id);
$stmt->execute();
$result = $stmt->get_result();
$friend = $result->fetch_assoc();

if (!$friend) {
    die("Friend not found.");
}

// Update friend details (Only Title & Author)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $update_sql = "UPDATE friends SET name=?, email=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $name, $email, $friend_id);

    if ($stmt->execute()) {
        echo "<script>alert('friend updated successfully!'); window.location='index.php';</script>";
    } else {
        echo "Error updating friend: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Friend</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Friend</h2>
    <form method="post">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($friend['name']); ?>" required>

        <label>Email:</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($friend['email']); ?>" required>

        <button type="submit">Update Friend</button>
    </form>
    <a class="a1" href="index.php">Back to Library</a>
</body>
</html>

<?php $conn->close(); ?>