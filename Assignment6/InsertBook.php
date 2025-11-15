<?php
session_start();
if(!isset($_SESSION['librarian_id'])){
    header("Location: login.php");
    exit();
}
?>

<?php
$conn = mysqli_connect("localhost", "root", "", "library_db");

if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $year = trim($_POST['year']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);

$ins = mysqli_query($conn,"INSERT INTO books (title, author, year, category, description) VALUES ('$title', '$author', '$year', '$category', '$description')");

    if ($ins) {
        $success = "Book added successfully.";
    } else {
        $error = "Error adding book: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books | MyLibrary</title>
    <link rel="stylesheet" href="style.css">
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
    <h2 class="section-title">Add a New Book</h2>

    <form action="#" method="post" class="book-form">
        <input type="text" name="title" placeholder="Book Title *">
        <input type="text" name="author" placeholder="Author Name *">
        <input type="number" name="year" placeholder="Publication Year *">
        <input type="text" name="category" placeholder="Category *">
        <textarea name="description" placeholder="Short Description"></textarea>
        <input type="submit" name="submit" value="Add Book" class="btn">
    </form>
</section>

</body>
</html>
