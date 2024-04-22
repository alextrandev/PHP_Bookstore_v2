<?php require_once './components/header.php';

if (!isset($_SESSION["user"])) {
    header("Location: " . BASE_URL . "login.php?login=required");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: " . BASE_URL . "manage_book.php");
    exit();
}

$id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM books where book_id=?");
$stmt->execute([$id]);
$total = $stmt->rowCount();
if (!$total) {
    header("Location: " . BASE_URL . "manage_book.php");
    exit();
}
$row = $stmt->fetch(PDO::FETCH_ASSOC);
[
    "title" => $title,
    "description" => $desc,
    "author" => $author,
    "publishing_year" => $year
] = $row;

if (isset($_POST["delete_form"])) {
    $stmt = $pdo->prepare("DELETE FROM books where book_id=?");
    $stmt->execute([$id]);
    header("Location: " . BASE_URL . "manage_book.php?delete=success");
    exit();
}
?>

<h2>Confirm delete book</h2>
<section class="book">
    <h3><?= $title ?></h3>
    <p class="publishing_info">
        <span class="author"><?= $author ?></span>,
        <span class="year"><?= $year ?></span>
    </p>
    <p class="description"><?= $desc ?></p>
</section>
<form action="" method="post"><input type="submit" name="delete_form" value="Confirm"></form>

<?php require_once './components/footer.php'; ?>