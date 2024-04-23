<?php require_once './components/header.php';

$stmt = $pdo->prepare("SELECT * FROM books");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
$filterGenre = $_GET["genre"] ?? true; //true mean all genre
$filteredBooks = array_filter($books, fn ($book) => $book["genre"] == $filterGenre);
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

    $favoriteButtonStyle = in_array($id, $_SESSION['favorites']) ? 'fa-star' : 'fa-star-o';

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