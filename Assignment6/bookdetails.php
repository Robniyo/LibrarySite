<?php
session_start();
$conn = new mysqli("localhost","root","","library_db");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

if(!isset($_GET['book_id'])) {
    die("Book not specified.");
}
$book_id = intval($_GET['book_id']);

$stmt = $conn->prepare("SELECT * FROM books WHERE id=?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows != 1) {
    die("Book not found.");
}
$book = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($book['title']) ?> | MyLibrary</title>
<link rel="stylesheet" href="style.css">
<style>
.book-detail {
    max-width: 700px;
    margin: 50px auto;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 6px 20px rgba(0,0,0,0.1);
}
.book-detail h2 { font-size:26px; margin-bottom:15px; }
.book-detail p { font-size:16px; color:#555; margin-bottom:10px; }
.action-btns {
    display:flex;
    gap:20px;
    margin-top:20px;
}
.action-btns a {
    padding:12px 20px;
    background:#1a73e8;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-weight:600;
}
.action-btns a:hover { background:#155bb5; }
</style>
</head>
<body>

<div class="book-detail">
    <h2><?= htmlspecialchars($book['title']) ?></h2>
    <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
    <p><strong>Year:</strong> <?= $book['year'] ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($book['category']) ?></p>
    <p><strong>Description:</strong> <?= htmlspecialchars($book['description']) ?></p>

    <div class="action-btns">
        <a href="#?book_id=<?= $book['id'] ?>">Read</a>

        <a href="borrowers.php?book_id=<?= $book['id'] ?>">Borrow / Purchase</a>
        <a href="index.php">Back  Home</a>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
