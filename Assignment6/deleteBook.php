<?php
session_start();

if(!isset($_SESSION['librarian_id'])){
    header("Location: librarian.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$dbname = "library_db";

$conn = new mysqli($host, $user, $password, $dbname);
if($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if(!isset($_GET['id']) || empty($_GET['id'])){
    die("Invalid book ID.");
}

$book_id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $book_id);

if($stmt->execute()){
    $stmt->close();
    $conn->close();
    header("Location: manageBook.php?msg=deleted");
    exit();
}else{
    $error = "Error deleting book: ".$stmt->error;
    $stmt->close();
    $conn->close();
    die($error);
}
?>
