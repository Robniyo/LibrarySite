<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MyLibrary | Home</title>
<link rel="stylesheet" href="style.css">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f5f6fa;
    color: #333;
}

.navbar {
    background: #1a73e8; 
    padding: 18px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    color: #fff;
    font-size: 26px;
    font-weight: bold;
}

.menu {
    list-style: none;
    display: flex;
    gap: 25px;
}

.menu a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
    transition: 0.3s;
}

.menu a:hover,
.menu .active {
    color: #ffd600; 
}

.hero-section {
    height: 80vh;
    background: linear-gradient(rgba(26, 115, 232,0.7), rgba(26, 115, 232,0.7)), url('library-bg.jpg') center/cover no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    flex-direction: column;
}

.hero-content h1 {
    color: #fff;
    font-size: 48px;
    margin-bottom: 15px;
    animation: fadeIn 1s forwards;
}

.hero-content p {
    color: #f1f1f1;
    font-size: 20px;
    margin-bottom: 25px;
    animation: fadeIn 1s 0.5s forwards;
}

.hero-btn {
    background: #ffd600;
    padding: 14px 30px;
    color: #111;
    text-decoration: none;
    font-weight: bold;
    border-radius: 6px;
    transition: 0.3s;
    animation: fadeIn 1s 1s forwards;
}

.hero-btn:hover {
    background: #ffea00;
}


.features {
    padding: 60px 20px;
    text-align: center;
    background: #fff;
}

.section-title {
    font-size: 32px;
    margin-bottom: 40px;
    color: #1a73e8;
}

.features-container {
    display: flex;
    justify-content: center;
    gap: 25px;
    flex-wrap: wrap;
}

.feature-box {
    background: #f0f4ff;
    width: 280px;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
}

.feature-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
}


@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}


.footer {
    background: #1a73e8;
    color: #fff;
    text-align: center;
    padding: 18px 0;
    font-size: 16px;
}

</style>
</head>
<body>

<nav class="navbar">
    <div class="logo">MyLibrary</div>
    <ul class="menu">
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="books.php">Books</a></li>
        <li><a href="library.php">Library</a></li>
        <?php if(isset($_SESSION['librarian_id'])): ?>
            <li><a href="logout.php" class="logout-btn">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>

<header class="hero-section">
    <div class="hero-content">
        <h1 class="fade-in">Welcome to MyLibrary 📚</h1>
        <p class="fade-in delay1">Your gateway to reading, borrowing, and managing books with ease.</p>
        <a href="books.php" class="hero-btn fade-in delay2">Explore Books</a>
    </div>
</header>

<section class="features">
    <h2 class="section-title">Why Choose MyLibrary?</h2>

    <div class="features-container">

        <div class="feature-box fade-up">
            <h3>📘 Read Anytime</h3>
            <p>Access thousands of books anytime and anywhere, without limitations.</p>
        </div>

        <div class="feature-box fade-up delay1">
            <h3>📚 Borrow Easily</h3>
            <p>Borrow books with one click and track your reading history.</p>
        </div>

        <div class="feature-box fade-up delay2">
            <h3>⚡ Fast & Simple</h3>
            <p>An easy-to-use platform designed for speed, comfort, and productivity.</p>
        </div>

    </div>
</section>

<footer class="footer">
    <p>© <?php echo date("Y"); ?> | robertniyonkuru@gmail.com | All Rights Reserved</p>
</footer>

</body>
</html>
