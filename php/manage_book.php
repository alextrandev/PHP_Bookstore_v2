<?php
$manageBookPath = "manage_book.php";
require_once './components/header.php';

if (!isset($_SESSION["user"])) {
    header("Location: " . BASE_URL . "login.php?login=required");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM books");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
$filterGenre = $_GET["genre"] ?? true; //true mean all genre
$filteredBooks = array_reverse(array_filter($books, fn ($book) => $book["genre"] == $filterGenre));
?>

<h2><?= $filterGenre === true ? "All books" : $filterGenre ?></h2>

<?php foreach ($filteredBooks as $filteredBook) :
    [
        "book_id" => $id,
        "title" => $title,
        "description" => $desciption,
        "author" => $author,
        "publishing_year" => $year,
        "genre" => $genre
    ] = $filteredBook;

    echo <<<HTML
        <section class="book">
            <a href="edit_book.php?id={$id}">
                <button class="edit_button">Edit</button>
            </a>
            <a href="delete_book.php?id={$id}">
                <button class="delete_button">Delete</button>
            </a>
            <h3>$title</h3>
            <p class="publishing_info">
                <span class="author">$author</span>,
                <span class="year">$year</span>
            </p>
            <p class="description">$desciption</p>
        </section>
    HTML;

endforeach;

require_once './components/footer.php';
