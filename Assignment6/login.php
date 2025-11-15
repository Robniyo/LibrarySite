<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "library_db";

$conn = new mysqli($host, $user, $password, $dbname);
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

$login_error = "";

if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($username) || empty($password)){
        $login_error = "Please fill in both fields.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM librarians WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1){
            $user = $result->fetch_assoc();

            if(password_verify($password, $user['password'])){
                $_SESSION['librarian_id'] = $user['id'];
                $_SESSION['librarian_name'] = $user['fullname'];
                header("Location: index.php");
                exit();
            } else {
                $login_error = "Invalid username or password.";
            }
        } else {
            $login_error = "Invalid username or password.";
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
<title>Librarian Login | MyLibrary</title>
<link rel="stylesheet" href="style.css">
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #e0f0ff, #f7faff);
    margin: 0;
    padding: 0;
}

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.form-box {
    background: #fff;
    padding: 40px 35px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    width: 360px;
    text-align: center;
}

.form-box h2 {
    margin-bottom: 25px;
    color: #1a1a1a;
}

.form-box input[type="text"],
.form-box input[type="password"] {
    width: 100%;
    padding: 14px;
    margin: 12px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
}

.form-box input[type="text"]:focus,
.form-box input[type="password"]:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 6px rgba(26, 115, 232, 0.4);
    outline: none;
}

.btn {
    width: 100%;
    padding: 14px;
    margin-top: 15px;
    background: #1a73e8;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 16px;
}

.btn:hover {
    background: #155bb5;
}

p.error {
    color: #dc3545;
    font-weight: 600;
    margin-bottom: 10px;
}
</style>
</head>
<body>

<div class="login-container">
    <div class="form-box">
        <h2>Librarian Login</h2>
        <?php if($login_error) echo "<p class='error'>$login_error</p>"; ?>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login" class="btn">
            <a href="librarian.php">Don't Have an account?</a>
        </form>
    </div>
</div>

</body>
</html>
