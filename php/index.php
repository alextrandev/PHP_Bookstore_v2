<?php
ob_start();
session_start();
require_once "./components/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="shortcut icon" href="./assets/logo.png" type="image/x-icon">
  <title>Bookstore v2</title>

</head>

<body>
  <div id="container">
    <header>
      <h1>Your Favorite Books</h1>
    </header>
    <nav id="main-navi">
      <ul>
        <li><a href="<?= BASE_URL ?>">Home</a></li>
        <li><a href="<?= BASE_URL ?>manage.php">Manage books</a></li>
        <li><a href="<?= BASE_URL ?>register.php">Register</a></li>
        <li><a href="<?= BASE_URL ?>login.php">Login</a></li>
        <li><a href="<?= BASE_URL ?>logout.php">Logout</a></li>
      </ul>
      <ul>
        <li><a href="<?= BASE_URL ?>">All</a></li>
        <?php foreach ($genres as $genre) : ?>
          <li><a href="<?= BASE_URL ?>?genre=<?= $genre ?>"><?= $genre ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <main>
      <h2><?= $_GET["genre"] ?? "All books" ?></h2>
      <section class="book">
        <a class="bookmark fa fa-star" href="setfavorite.php?remove="></a>
        <h3>Book title</h3>
        <p class="publishing-info">
          <span class="author">Author</span>,
          <span class="year">Year</span>
        </p>
        <p class="description">Description</p>
      </section>
    </main>
    <footer>
      <p>Copyright &copy; <a href="https://alextran.dev" target="_blank">Alex Tran</a></p>
    </footer>
  </div>
</body>

</html>