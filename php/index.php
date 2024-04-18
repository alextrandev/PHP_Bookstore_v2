<?php require_once './components/header.php';

$stmt = $pdo->prepare("SELECT * FROM books");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2><?= $_GET["genre"] ?? "All books" ?></h2>

<?php foreach ($rows as $bookNumber => $row) :
    [
        "book_id" => $id,
        "title" => $title,
        "description" => $desciption,
        "author" => $author,
        "publishing_year" => $year,
        "genre" => $genre
    ] = $row;

    echo <<<HTML
        <section class="book">
            <a class="bookmark fa fa-star-o" href="set_favorite.php?id={$id}" target="_blank"></a>
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