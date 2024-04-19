<?php require_once './components/header.php';

if (!isset($_SESSION["user"])) {
    header("Location: " . BASE_URL . "login.php?login=required");
    exit();
}

?>

<p>Profile</p>

<?php require_once './components/footer.php'; ?>