<?php require_once './components/header.php';

if (!isset($_SESSION["user"])) {
    header("Location: " . BASE_URL . "login.php?login=required");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: " . BASE_URL);
    exit();
}

$book_id = $_GET["id"];
$user_id = $_SESSION["user"]["user_id"];

$findBookStmt = $pdo->prepare("SELECT * FROM books WHERE book_id=?");
$findBookStmt->execute([$book_id]);
$total = $findBookStmt->rowCount();

if (!$total) {
    header("Location: " . BASE_URL);
    exit();
}

$checkFavoriteStmt = $pdo->prepare("SELECT * FROM favorites WHERE user_id=? AND book_id=?");
$checkFavoriteStmt->execute([$user_id, $book_id]);
$total = $checkFavoriteStmt->rowCount();

if ($total) {
    $removeFavoriteStmt = $pdo->prepare("DELETE FROM favorites WHERE user_id=? AND book_id=?");
    $removeFavoriteStmt->execute([$user_id, $book_id]);
    unset($_SESSION["favorites"][array_search($book_id, $_SESSION["favorites"])]);
} else {
    $addFavoriteStmt = $pdo->prepare("INSERT INTO favorites (user_id, book_id) VALUES (?, ?)");
    $addFavoriteStmt->execute([$user_id, $book_id]);
    $_SESSION["favorites"][] = $book_id;
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();

require_once './components/footer.php';
