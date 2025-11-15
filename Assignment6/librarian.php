<?php
session_start();
$host="localhost"; $user="root"; $password=""; $dbname="library_db";
$conn = new mysqli($host, $user, $password, $dbname);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$signup_error = $signup_success = "";
$login_error = "";


if(isset($_POST['signup'])){
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($fullname) || empty($username) || empty($password)){
        $signup_error = "Please fill all fields for signup.";
    } else {
   
        $stmt = $conn->prepare("SELECT * FROM librarians WHERE username=?");
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows > 0){
            $signup_error = "Username already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt2 = $conn->prepare("INSERT INTO librarians (fullname, username, password) VALUES (?, ?, ?)");
            $stmt2->bind_param("sss",$fullname,$username,$hash);
            if($stmt2->execute()){
                $signup_success = "Signup successful! You can login now.";
            } else {
                $signup_error = "Error: ".$stmt2->error;
            }
            $stmt2->close();
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
<title>Librarian Signup</title>
<link rel="stylesheet" href="style.css">
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #e0f0ff, #f7faff);
    margin: 0;
    padding: 0;
}


.container {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 40px;
    padding: 80px 20px;
    flex-wrap: wrap;
}


.form-box {
    background: #fff;
    padding: 35px 30px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    width: 340px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.form-box:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.form-box h2 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 24px;
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
    transition: border 0.2s, box-shadow 0.2s;
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
    transition: background 0.3s, transform 0.2s;
}

.btn:hover {
    background: #155bb5;
    transform: translateY(-2px);
}

/* ===== SUCCESS & ERROR MESSAGES ===== */
p.success {
    color: #28a745;
    text-align: center;
    font-weight: 600;
    margin-bottom: 10px;
}

p.error {
    color: #dc3545;
    text-align: center;
    font-weight: 600;
    margin-bottom: 10px;
}

@media (max-width: 768px) {
    .container {
        flex-direction: column;
        align-items: center;
        padding: 50px 10px;
    }

    .form-box {
        width: 90%;
    }
}

</style>
</head>
<body>

<div class="container">

<div class="form-box">
<h2>Signup Librarian</h2>
<?php if($signup_success) echo "<p class='success'>$signup_success</p>"; ?>
<?php if($signup_error) echo "<p class='error'>$signup_error</p>"; ?>
<form action="#" method="post">
<input type="text" name="fullname" placeholder="Full Name">
<input type="text" name="username" placeholder="Username">
<input type="password" name="password" placeholder="Password">
<input type="submit" name="signup" value="Signup" class="btn">
<a href="login.php" style = 'width: 14em; color: red;'>Already Have an account</a>
</form>
</div>
</body>
</html>
