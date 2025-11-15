<?php
session_start();

$conn = new mysqli("localhost","root","","library_db");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$sql = "SELECT * FROM books ORDER BY title ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Books | MyLibrary</title>
<link rel="stylesheet" href="style.css">
<style>
.books-section {
    padding: 40px 20px;
    max-width: 1200px;
    margin: auto;
}
.section-title {
    text-align: center;
    font-size: 32px;
    margin-bottom: 30px;
}
.books-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 25px;
}
.book-card {
    background: #fff;
    padding: 20px;
    width: 220px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    text-align: center;
}
.book-cover {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 15px;
}
.book-title {
    font-size: 18px;
    margin-bottom: 8px;
}
.book-author {
    font-size: 14px;
    color: #555;
    margin-bottom: 12px;
}
.btn {
    display: inline-block;
    padding: 10px 15px;
    background: #1a73e8;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}
.btn:hover { background: #155bb5; }
</style>
</head>
<body>

<nav class="navbar">
    <div class="logo">MyLibrary</div>
    <ul class="menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="library.php">Library</a></li>
        <?php if(isset($_SESSION['librarian_id'])): ?>
            <li><a href="logout.php">Logout (<?= $_SESSION['librarian_name'] ?>)</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>

<section class="books-section">
    <h2 class="section-title">Available Books</h2>
    <div class="books-container">

        <?php if($result->num_rows > 0): ?>
            <?php while($book = $result->fetch_assoc()): ?>
            <div class="book-card">
                <img src="https://via.placeholder.com/150" alt="Book Cover" class="book-cover">
                <h3 class="book-title">
                    <a href="bookdetails.php?book_id=<?= $book['id'] ?>"><?= htmlspecialchars($book['title']) ?></a>
                </h3>
                <p class="book-author">by <?= htmlspecialchars($book['author']) ?></p>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">No books available at the moment.</p>
        <?php endif; ?>

    </div>
</section>

</body>
</html>

<?php $conn->close(); ?>
