<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard | MyLibrary</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo">MyLibrary</div>
    <ul class="menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="books.php">Books</a></li>
        <li><a href="library.php" class="active">Library</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>


<section class="dashboard-section">
    <h2 class="section-title">Welcome Librarian</h2>
    <p class="dashboard-intro">Manage books, view statistics, and keep the library organized.</p>

    <div class="dashboard-actions">

        <div class="action-card">
            <h3>Manage Books</h3>
            <p>Add, Edit or delete existing books</p>
            <a href="InsertBook.php" class="btn">Add Books</a>
            <a href="manageBook.php" class="btn">Manage Books</a>
        </div>


    </div>
</section>

</body>
</html>
