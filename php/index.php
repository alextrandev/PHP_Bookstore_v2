<?php require_once './components/header.php';

$stmt = $pdo->prepare("SELECT * FROM books");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
$filterGenre = $_GET["genre"] ?? true; //true mean all genre
$filteredBooks = array_reverse(array_filter($books, fn ($book) => $book["genre"] == $filterGenre));

//pagination
$booksPerPage = 5;
$numberofBooks = count($filteredBooks);
$numberOfPages = ceil($numberofBooks / $booksPerPage);

if (!isset($_GET["page"]) || $_GET["page"] <= 0) {
    $currentPage = 1;
} elseif ($_GET["page"] > $numberOfPages) {
    $currentPage = $numberOfPages;
} else {
    $currentPage = intval($_GET["page"]);
}

$firstBookIndex = (intval($currentPage) - 1) * $booksPerPage;
$displayBooks = array_slice($filteredBooks, $firstBookIndex, $booksPerPage);
?>

<div class="books_header">
    <h2><?= $filterGenre === true ? "All books" : $filterGenre ?></h2>
    <div class="pagination_container">
        <a href="<?= BASE_URL . "?page=" . ($currentPage - 1) ?>">&lt; Previous</a>
        <div class="pagination_pages">
            <span>Pages:</span>
            <?php for ($i = 1; $i <= $numberOfPages; $i++) : ?>
                <a class="<?= $i == $currentPage ? "bold" : "" ?>" href="<?= BASE_URL . "?page=" . ($i) ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

        </div>
        <a href="<?= BASE_URL . "?page=" . ($currentPage + 1) ?>">Next &gt;</a>
    </div>
</div>

<?php foreach ($displayBooks as $displayBook) :
    [
        "book_id" => $id,
        "title" => $title,
        "description" => $desciption,
        "author" => $author,
        "publishing_year" => $year,
        "genre" => $genre
    ] = $displayBook;

    if (isset($_SESSION["favorites"]) && in_array($id, $_SESSION['favorites'])) {
        $favoriteButtonStyle = "fa-star";
    } else {
        $favoriteButtonStyle = "fa-star-o";
    }

    echo <<<HTML
        <section class="book">
            <a 
                class="bookmark fa {$favoriteButtonStyle}" 
                href="set_favorite.php?id={$id}"
            >
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

require_once './components/footer.php' ?>