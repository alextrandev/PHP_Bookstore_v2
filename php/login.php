<?php require_once './components/header.php';

if (isset($_POST["login_as_guest"])) {
    $_SESSION["user"] = "guest";
    header("Location: " . BASE_URL . "profile.php");
    exit();
}

if (isset($_POST["login_form"])) {
}

?>

<form action="" method="post" class="form_container">
    <h2>Login</h2>

    <?php if (isset($error_msg)) : ?>
        <p class="error_msg"><?= $error_msg ?></p>
    <?php elseif (isset($_GET["register"])) : ?>
        <p class="success_msg">Account registration successful. You can now login</p>
    <?php elseif (isset($_GET["logout"])) : ?>
        <p class="success_msg">Logout successful</p>
    <?php endif; ?>

    <table>
        <tr>
            <td><Label for="email">E-mail</Label></td>
            <td><input type="text" name="email" id="email" value="<?= $_GET["email"] ?? $email ?? "" ?>"></td>
        </tr>
        <tr>
            <td><Label for="password">Password</Label></td>
            <td><input type="password" name="password" id="password"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="login_form" value="Login"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="login_as_guest" value="Login as Guest"></td>
        </tr>
    </table>
</form>

<?php require_once './components/footer.php'; ?>