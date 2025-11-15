<?php
session_start();
if(!isset($_SESSION['librarian_id'])){
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost","root","","library_db");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$sql = "SELECT 
            b.name AS borrower_name, 
            b.national_id, 
            b.phone, 
            bk.title AS book_title, 
            bb.book_type, 
            bb.borrow_date 
        FROM borrowed_books bb
        JOIN borrowers b ON bb.borrower_id = b.id
        JOIN books bk ON bb.book_id = bk.id
        ORDER BY bb.borrow_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Library Stats | MyLibrary</title>
<link rel="stylesheet" href="style.css">
<style>
table { 
    width: 90%; 
    margin: 30px auto; 
    border-collapse: collapse; 
    background:#fff; 
    box-shadow:0 4px 15px rgba(0,0,0,0.1); 
    border-radius:8px; 
    overflow:hidden;
}
th, td { 
    padding: 12px 15px; 
    border-bottom:1px solid #ddd; 
    text-align:center; 
}
th { 
    background: #1a73e8; 
    color:#fff; 
    font-weight:600;
}
tr:hover { 
    background:#f1f5fb; 
}
</style>
</head>
<body>

<h2 style="text-align:center;">Library Stats & Borrowers</h2>

<table>
<tr>
    <th>Borrower Name</th>
    <th>National ID</th>
    <th>Phone</th>
    <th>Book Title</th>
    <th>Type</th>
    <th>Borrow Date</th>
</tr>

<?php if($result->num_rows>0): ?>
    <?php while($row=$result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['borrower_name']) ?></td>
            <td><?= htmlspecialchars($row['national_id']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['book_title']) ?></td>
            <td><?= htmlspecialchars($row['book_type']) ?></td>
            <td><?= date("d-m-Y H:i", strtotime($row['borrow_date'])) ?></td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
<tr><td colspan="6">No borrowing records found.</td></tr>
<?php endif; ?>
</table>

</body>
</html>

<?php $conn->close(); ?>
