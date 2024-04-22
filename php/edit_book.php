<?php
$manageBookPath = "manage_book.php";
require_once './components/header.php';

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
    "publishing_year" => $year,
    "genre" => $genre
] = $row;

if (isset($_POST["edit_book_form"])) {
    if ($id <= 41) {
        header("Location: " . BASE_URL . "manage_book.php?editDefaultBook=false");
        exit();
    }

    try {
        if ($_POST["title"] == "") {
            throw new Exception("Title cannot be empty");
        }

        if ($_POST["description"] == "") {
            $_POST["description"] = "Not available";
        }

        if ($_POST["author"] == "") {
            $_POST["author"] = "Unknown author";
        }

        $stmt = $pdo->prepare("SELECT * FROM books WHERE title=? AND author=?");
        $stmt->execute([$_POST["title"], $_POST["author"]]);
        $total = $stmt->rowCount();
        if ($total) {
            throw new Exception("Book already added. Please add another book");
        }

        if ($_POST["year"] == "") {
            $_POST["year"] = "Undated";
        }

        $stmt = $pdo->prepare(
            "UPDATE books SET title=?, description=?, author=?, publishing_year=?, genre=? where book_id=?"
        );
        $stmt->execute([$_POST["title"], $_POST["description"], $_POST["author"], $_POST["year"], $_POST["genre"], $id]);
        header("Location: " . BASE_URL . "manage_book.php?edit=success");
        exit();
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}
?>

<form action="" method="post" class="form_container">
    <h2>Edit book</h2>

    <?php if (isset($error_msg)) : ?>
        <p class="error_msg"><?= $error_msg ?></p>
    <?php endif; ?>

    <table>
        <tr>
            <td><Label for="title">Book title</Label></td>
            <td>
                <input type="text" name="title" id="title" value="<?= $_POST["title"] ?? $title ?? "" ?>">
            </td>
        </tr>
        <tr>
            <td><Label for="description">Description</Label></td>
            <td>
                <textarea id="description" name="description" rows="4" cols="47"><?= $_POST["description"] ?? $desc ?? "" ?></textarea>
            </td>
        </tr>
        <tr>
            <td><Label for="author">Author</Label></td>
            <td><input type="text" name="author" id="author" value="<?= $_POST["author"] ?? $author ?? "" ?>"></td>
        </tr>
        <tr>
            <td><Label for="year">Publishing year</Label></td>
            <td><input type="text" name="year" id="year" value="<?= $_POST["year"] ?? $year ?? "" ?>"></td>
        </tr>
        <tr>
            <td><label for="genre">Genre</label></td>
            <td>
                <select name="genre" id="genre">
                    <?php foreach ($genres as $item) : ?>
                        <option value="<?= $item ?>" <?= $item == $genre ? "selected" : "" ?>><?= $item ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="edit_book_form" value="Edit book"></td>
        </tr>
    </table>
</form>

<?php require_once './components/footer.php'; ?>