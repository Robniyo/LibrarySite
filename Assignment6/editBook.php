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

$error = "";
$success = "";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid book ID.");
}
$book_id = intval($_GET['id']);


$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    die("Book not found.");
}
$book = $result->fetch_assoc();
$stmt->close();


if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $year = trim($_POST['year']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);

    if (empty($title) || empty($author) || empty($year) || empty($category)) {
        $error = "Please fill in all required fields.";
    } else {
        $stmt = $conn->prepare("UPDATE books SET title=?, author=?, year=?, category=?, description=? WHERE id=?");
        $stmt->bind_param("ssissi", $title, $author, $year, $category, $description, $book_id);

        if ($stmt->execute()) {
            $success = "Book updated successfully!";
            $book['title'] = $title;
            $book['author'] = $author;
            $book['year'] = $year;
            $book['category'] = $category;
            $book['description'] = $description;
        } else {
            $error = "Error updating book: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book | MyLibrary</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="logo">MyLibrary</div>
    <ul class="menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="books.php">Books</a></li>
        <li><a href="library.php" class="active">Library</a></li>
        <li><a href="manageBook.php">Manage Books</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<section class="books-section">
    <h2 class="section-title">Edit Book</h2>

    <?php if($success) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>

    <form action="editBook.php?id=<?= $book_id ?>" method="post" class="book-form">
        <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" placeholder="Book Title *">
        <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" placeholder="Author Name *">
        <input type="number" name="year" value="<?= $book['year'] ?>" placeholder="Publication Year *">
        <input type="text" name="category" value="<?= htmlspecialchars($book['category']) ?>" placeholder="Category *">
        <textarea name="description" placeholder="Short Description"><?= htmlspecialchars($book['description']) ?></textarea>
        <input type="submit" name="submit" value="Update Book" class="btn">
    </form>
</section>

</body>
</html>
