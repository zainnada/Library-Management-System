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






<form method="POST" action="insert_friend.php">
    <input type="text" name="name" placeholder="Friend Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Add Friend</button>
    <link rel="stylesheet" href="style.css">
</form>


<a class="a1" href="index.php">Back to Library</a>
