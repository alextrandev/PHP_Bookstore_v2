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
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$_SESSION["favorites"] = array();
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
<h3>Your favorite books</h3>

<?php
if (count($rows)) :

    foreach ($rows as $row) :
        [
            "book_id" => $id,
            "title" => $title,
            "description" => $desciption,
            "author" => $author,
            "publishing_year" => $year
        ] = $row;

        $_SESSION["favorites"][] = $id;

        echo <<<HTML
        <section class="book">
            <a href="edit_book.php?id={$id}">
                <button class="edit_button">Edit</button>
            </a>
            <a href="delete_book.php?id={$id}">
                <button class="delete_button">Delete</button>
            </a>
            <a class="bookmark fa fa-star" href="set_favorite.php?id={$id}&profile=true"></a>
            <h3>$title</h3>
            <p class="publishing_info">
                <span class="author">$author</span>,
                <span class="year">$year</span>
            </p>
            <p class="description">$desciption</p>
        </section>
    HTML;

    endforeach;

else :

    echo "<p>Empty</p>";

endif;

require_once './components/footer.php'; ?>