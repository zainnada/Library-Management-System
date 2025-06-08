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

<form method="POST" action="insert_book.php">
    <input type="text" name="title" placeholder="Book Title" required>
    <input type="text" name="author" placeholder="Author" required>
    <button type="submit">Add Book</button>
    <link rel="stylesheet" href="style.css">
</form>

<a class="a1" href="index.php">Back to Library</a>
