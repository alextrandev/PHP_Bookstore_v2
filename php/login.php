<?php require_once './components/header.php';

if (isset($_POST["login_as_guest"])) {
    $_SESSION["user"] = "guest";
    header("Location: " . BASE_URL . "profile.php");
    exit();
}

if (isset($_POST["login_form"])) {
    try {
        ["email" => $email, "password" => $pwd] = $_POST;

        if ($email == "") {
            throw new Exception("Email cannot be empty");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Wrong email format");
        }

        $stmt = $pdo->prepare("SELECT user_id, password FROM users WHERE email=?");
        $stmt->execute([$email]);
        $total = $stmt->rowCount();

        if (!$total) {
            $register = "<a href=" . BASE_URL . "register.php?email=$email>Register new account</a>";
            throw new Exception("Email not found. Try again or $register");
        }

        if ($pwd == "") {
            throw new Exception("Password cannot be empty");
        }

        $rows = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($pwd, $rows["password"])) {
            throw new Exception("Email or password does not match");
        }

        $_SESSION["user"] = $rows["user_id"];
        header("Location: " . BASE_URL . "profile.php");
        exit();
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
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