<?php
session_start();
$conn = new mysqli("localhost","root","","library_db");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

if(!isset($_GET['book_id'])){
    die("Book not specified.");
}
$book_id = intval($_GET['book_id']);

$success = $error = '';
if(isset($_POST['borrow'])) {
    $name = trim($_POST['name']);
    $national_id = trim($_POST['national_id']);
    $phone = trim($_POST['phone']);
    $book_type = $_POST['book_type']; // Borrow or Purchase

    if(empty($name) || empty($national_id) || empty($phone)) {
        $error = "Please fill all fields.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM borrowers WHERE national_id=?");
        $stmt->bind_param("s",$national_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows > 0) {
            $borrower = $res->fetch_assoc();
            $borrower_id = $borrower['id'];
        } else {
            $stmt2 = $conn->prepare("INSERT INTO borrowers (name, national_id, phone) VALUES (?,?,?)");
            $stmt2->bind_param("sss",$name,$national_id,$phone);
            $stmt2->execute();
            $borrower_id = $stmt2->insert_id;
            $stmt2->close();
        }

        $stmt3 = $conn->prepare("INSERT INTO borrowed_books (borrower_id, book_id, book_type) VALUES (?,?,?)");
        $stmt3->bind_param("iis",$borrower_id, $book_id, $book_type);
        if($stmt3->execute()){
            $success = "Successfully registered and recorded as '$book_type'.";
        } else {
            $error = "Failed to record borrowing.";
        }
        $stmt3->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Borrow / Purchase Book</title>
<link rel="stylesheet" href="style.css">
<style>
.form-container {
    max-width: 450px;
    margin:50px auto;
    background:#fff;
    padding:30px;
    border-radius:12px;
    box-shadow:0 6px 20px rgba(0,0,0,0.1);
}
.form-container h2 { text-align:center; margin-bottom:20px; }
.form-container input[type="text"], .form-container input[type="tel"], select {
    width:100%; padding:12px; margin:10px 0; border-radius:8px; border:1px solid #ccc;
}
.btn {
    width:100%; padding:12px; margin-top:15px; background:#1a73e8; color:#fff; border:none; border-radius:8px; cursor:pointer;
}
.btn:hover { background:#155bb5; }
p.success { color:green; text-align:center; }
p.error { color:red; text-align:center; }
</style>
</head>
<body>

<div class="form-container">
<h2>Borrow / Purchase Book</h2>
<?php if($success) echo "<p class='success'>$success</p>"; ?>
<?php if($error) echo "<p class='error'>$error</p>"; ?>

<form action="" method="post">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="text" name="national_id" placeholder="National ID (16 digits)" maxlength="16" required>
    <input type="tel" name="phone" placeholder="Phone Number" required>
    <select name="book_type" required>
        <option value="">--Select Option--</option>
        <option value="Borrow">Borrow</option>
        <option value="Purchase">Purchase</option>
    </select>
    <input type="submit" name="borrow" value="Submit" class="btn">
    <a href="index.php">Back Home</a>
</form>
</div>

</body>
</html>

<?php $conn->close(); ?>
