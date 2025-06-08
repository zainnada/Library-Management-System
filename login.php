<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<?php
session_start();

//include 'db.php'; // الاتصال بقاعدة البيانات
/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shehda_library_db";

// error of the socket
$conn = new mysqli($servername, $username, $password, $dbname, 3306, '/var/run/mysqld/mysqld.sock'); // solution 1: assign the true socket file
//$conn = new mysqli($servername, $username, $password, $dbname); // solution 2: make mysqli using TCP/IP instead of using the socket
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
*/
// include "db_connect.php"; // to don't use a frequent code..
require_once "db_connect.php"; // require once is better than include, because the database connection is important.




if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        // تعيين كوكيز لمدة ساعة (3600 ثانية)
        setcookie("admin", $username, time() + 3600, "/"); // الكوكيز تكون صالحة لمدة ساعة فقط
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Library Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" name="login">Login</button>
    </form>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
