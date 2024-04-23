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

$stmt = $pdo->prepare("SELECT * FROM books WHERE book_id=?");
$stmt->execute([$book_id]);
$total = $stmt->rowCount();
if (!$total) {
    header("Location: " . BASE_URL);
    exit();
}

$stmt = $pdo->prepare("INSERT INTO favorites (user_id, book_id) VALUES (?, ?)");
$stmt->execute([$user_id, $book_id]);
header("Location: " . BASE_URL);
exit();

require_once './components/footer.php';
