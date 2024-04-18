<?php require_once './components/header.php' ?>

<h2><?= $_GET["genre"] ?? "All books" ?></h2>
<section class="book">
    <a href="delete_book.php?id=0"><button class="delete_button">Delete</button></a>
    <a href="add_book.php?id=0"><button class="edit_button">Edit</button></a>
    <h3>Book title</h3>
    <p class="publishing_info">
        <span class="author">Author</span>,
        <span class="year">Year</span>
    </p>
    <p class="description">Description</p>
</section>

<?php require_once './components/footer.php';
