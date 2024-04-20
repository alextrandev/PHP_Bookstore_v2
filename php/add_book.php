<?php require_once './components/header.php';

if (!isset($_SESSION["user"])) {
    header("Location: " . BASE_URL . "login.php?login=required");
    exit();
}

if (isset($_POST["add_book_form"])) {
    try {
        [
            "title" => $title,
            "description" => $desc,
            "author" => $author,
            "year" => $year,
            "genre" => $genre
        ] = $_POST;

        if ($title == "") {
            throw new Exception("Title cannot be empty");
        }

        if ($desc == "") {
            $desc = "Not available";
        }

        if ($author == "") {
            $author = "Unknown author";
        }

        $stmt = $pdo->prepare("SELECT * FROM books WHERE title=? AND author=?");
        $stmt->execute([$title, $author]);
        $total = $stmt->rowCount();
        if ($total) {
            throw new Exception("Book already added. Please add another book");
        }

        if ($year == "") {
            $year = "Undated";
        }

        $stmt = $pdo->prepare("INSERT INTO books (title, description, author, publishing_year, genre) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $desc, $author, $year, $genre]);
        $id = $pdo->lastInsertId();
        $success_msg = "New book added";
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}

?>

<form action="" method="post" class="form_container">
    <h2>Add new book</h2>

    <?php if (isset($error_msg)) : ?>
        <p class="error_msg"><?= $error_msg ?></p>
    <?php elseif (isset($success_msg)) : ?>
        <p class="success_msg"><?= $success_msg ?></p>
        <section class="book">
            <a href="delete_book.php?id=<?= $id ?>"><button class="delete_button">Delete</button></a>
            <a href="edit_book.php?id=<?= $id ?>"><button class="edit_button">Edit</button></a>
            <h3><?= $title ?></h3>
            <p class="publishing_info">
                <span class="author"><?= $author ?></span>,
                <span class="year"><?= $year ?></span>
            </p>
            <p class="description"><?= $desc ?></p>
        </section>
    <?php endif; ?>

    <table>
        <tr>
            <td><Label for="title">Book title</Label></td>
            <td>
                <input type="text" name="title" id="title" value="<?= $title ?? "" ?>">
            </td>
        </tr>
        <tr>
            <td><Label for="description">Description</Label></td>
            <td>
                <textarea id="description" name="description" rows="4" cols="47"><?= $desc ?? "" ?></textarea>
            </td>
        </tr>
        <tr>
            <td><Label for="author">Author</Label></td>
            <td><input type="text" name="author" id="author" value="<?= $author ?? "" ?>"></td>
        </tr>
        <tr>
            <td><Label for="year">Publishing year</Label></td>
            <td><input type="text" name="year" id="year"></td>
        </tr>
        <tr>
            <td><label for="genre">Genre</label></td>
            <td>
                <select name="genre" id="genre">
                    <?php foreach ($genres as $genre) : ?>
                        <option value="<?= $genre ?>"><?= $genre ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="add_book_form" value="Add book"></td>
        </tr>
    </table>
</form>

<?php require_once './components/footer.php'; ?>