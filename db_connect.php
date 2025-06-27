<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zain_library_db";

// error of the socket
$conn = new mysqli($servername, $username, $password, $dbname, 3306, '/var/run/mysqld/mysqld.sock'); // solution 1: assign the true socket file
//$conn = new mysqli("127.0.0.1", $username, $password, $dbname); // solution 2: make mysqli using TCP/IP "127.0.0.1" instead of using the socket
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
