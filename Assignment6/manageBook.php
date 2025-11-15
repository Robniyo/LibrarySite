<?php
session_start();
if(!isset($_SESSION['librarian_id'])){
    header("Location: login.php");
    exit();
}
?>

<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "library_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all books
$sql = "SELECT * FROM books ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books | MyLibrary</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #1a73e8;
            color: white;
        }
        td a {
            padding: 6px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        .edit {
            background: #28a745;
        }
        .edit:hover { background: #218838; }
        .delete {
            background: #dc3545;
        }
        .delete:hover { background: #c82333; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="logo">MyLibrary</div>
    <ul class="menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="books.php">Books</a></li>
        <li><a href="library.php" class="active">Library</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<section class="books-section">
    <h2 class="section-title">Manage Books</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Year</th>
            <th>Category</th>
            <th>Description</th>
            <th>Modify</th>
        </tr>

        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= $row['year'] ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td>
                    <a href="editBook.php?id=<?= $row['id'] ?>" class="edit">Edit</a>
                    <a href="deleteBook.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">No books found.</td></tr>
        <?php endif; ?>
    </table>

</section>

</body>
</html>

<?php $conn->close(); ?>
