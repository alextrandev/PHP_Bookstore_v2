<?php require_once './components/header.php';

if (!isset($_SESSION["user"])) {
    header("Location: " . BASE_URL . "login.php?login=required");
    exit();
}

[
    "user_id" => $user_id,
    "firstname" => $fn,
    "lastname" => $ln,
    "email" => $email,
    "created_at" => $createdAt
] = $_SESSION["user"];

$stmt = $pdo->prepare(
    "SELECT favorites.book_id, books.title, books.description, books.author, books.publishing_year 
    FROM favorites INNER JOIN books ON favorites.book_id=books.book_id
    WHERE favorites.user_id=?"
);
$stmt->execute([$user_id]);
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Welcome <?= $fn ?>!</h2>
<h3>Your profile</h3>
<table>
    <tr>
        <td>First name</td>
        <td><?= $fn ?></td>
    </tr>
    <tr>
        <td>Last name</td>
        <td><?= $ln ?></td>
    </tr>
    <tr>
        <td>E-mail</td>
        <td><?= $email ?></td>
    </tr>
    <tr>
        <td>Member from</td>
        <td><?= implode("/", array_reverse(explode("-", explode(" ", $createdAt)[0]))) ?></td>
    </tr>
</table>
<h3>Your favorite book</h3>
<?= '<pre>', var_dump($row), '</pre>'; ?>

<?php require_once './components/footer.php'; ?>