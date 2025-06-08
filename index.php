<?php
session_start();

// إذا كان الكوكيز يحتوي على اسم الأدمن، نقوم بتسجيل الدخول
if (isset($_COOKIE['admin'])) {
    $_SESSION['admin'] = $_COOKIE['admin'];
}

// إذا لم يكن الأدمن مسجلاً دخولًا، نعيده إلى صفحة تسجيل الدخول
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


// Fetch all books
$books = $conn->query("SELECT * FROM books");

$friends_result = $conn->query("SELECT * FROM friends");

// Fetch borrowed books with details
$borrowed_books = $conn->query("
    SELECT borrows.id, books.title, books.author, friends.name, borrows.borrow_date, borrows.return_date 
    FROM borrows 
    JOIN books ON borrows.book_id = books.id 
    JOIN friends ON borrows.friend_id = friends.id
");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="admin-info">
        Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?> |
        <a href="logout.php">Logout</a>
    </div>    


    <br>
    <h1>Shehda Sweedan Library</h1>
    <br>
    <!-- <img id="img1" src="img1.jpg" title="laptop" alt="laptop image"/> -->
    <h2>Library Books</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Available</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $books->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['author'] ?></td>
                <td><?= $row['available'] ? 'Yes' : 'No' ?></td>
                <td>
                    
                    <!-- <a href="borrow.php?book_id=<?= $row['id'] ?>">Borrow</a> | -->
                    <!-- <a href="borrow.php?book_id=<?php echo $row['id']; ?>">Borrow</a> | -->

                    <?php if ($row['available']): ?> <a href="borrow.php?book_id=<?php echo $row['id']; ?>">Borrow</a>
                    <?php else: ?>Unavailable<?php endif; ?> <span style="color: aliceblue">|</span>

                    <a href="edit_book.php?id=<?= $row['id'] ?>">Edit</a>

                    <!-- <a href="delete_book.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a> -->

                    <?php if ($row['available']): ?> <span style="color: aliceblue">|</span> <a
                            href="delete_book.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">
                            Delete</a>
                    <?php else: ?>     <?php endif; ?>


                    <!--  <a href="delete_book.php?id=<?= $row['id'] ?>"               
                <?php if ($row['available']): ?><a href="delete_book.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')"
                    <?php endif; ?>
                >Delete</a>
                -->

                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Borrowed Books History</h2>
    <table border="1">
        <tr>
            <th>Book Title</th>
            <th>Author</th>
            <th>Borrowed By</th>
            <th>Borrow Date</th>
            <th>Return Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $borrowed_books->fetch_assoc()): ?>
            <tr>
                <td><?= $row['title'] ?></td>
                <td><?= $row['author'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['borrow_date'] ?></td>
                <td><?= $row['return_date'] ?: 'Not Returned' ?></td>
                <td>


                    <!-- <a href="return.php?borrow_id=<?= $row['id'] ?>">Return</a> -->

                    <?php if (!$row['return_date']): ?> <a href="return.php?borrow_id=<?php echo $row['id']; ?>">Return</a>
                    <?php else: ?>Returned<?php endif; ?>


                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Library Friends</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $friends_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="edit_friend.php?id=<?= $row['id'] ?>">Edit</a> <span style="color: aliceblue">|</span>
                    <a href="delete_friend.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>

            </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a class="a1" href="add_book.php">Add Book</a> |
    <a class="a1" href="add_friend.php">Add Friend</a>
    <br>
    <br>
    <br>
</body>

</html>