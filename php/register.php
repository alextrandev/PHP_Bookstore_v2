<?php require_once './components/header.php';

if (isset($_POST["register_form"])) {
    try {
        [
            "firstname" => $fn,
            "lastname" => $ln,
            "email" => $email,
            "password" => $pwd,
            "password_retype" => $pwd_retype
        ] = $_POST;

        if ($fn == "") {
            throw new Exception("First name cannot be empty");
        }

        if ($ln == "") {
            throw new Exception("Last name cannot be empty");
        }

        if ($email == "") {
            throw new Exception("Email cannot be empty");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Wrong email format");
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $total = $stmt->rowCount();
        if ($total) {
            $login = "<a href=" . BASE_URL . "login.php>Login</a>";
            throw new Exception("Email already exist. Try again or $login");
        }

        if ($pwd == "") {
            throw new Exception("Password cannot be empty");
        }

        if ($pwd !== $pwd_retype) {
            throw new Exception("Passwords does not match");
        }

        $pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$fn, $ln, $email, $pwd_hashed]);
        header("Location: " . BASE_URL . "login.php?register=success&email=" . $email);
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}
?>

<form action="" method="post" class="form_container">
    <h2>Create new user account</h2>

    <?php if (isset($error_msg)) : ?>
        <p class="error_msg"><?= $error_msg ?></p>
    <?php endif; ?>

    <table>
        <tr>
            <td><Label for="firstname">First name</Label></td>
            <td>
                <input type="text" name="firstname" id="firstname" value="<?= $fn ?? "" ?>">
            </td>
        </tr>
        <tr>
            <td><Label for="lastname">Last name</Label></td>
            <td><input type="text" name="lastname" id="lastname" value="<?= $ln ?? "" ?>"></td>
        </tr>
        <tr>
            <td><Label for="email">E-mail address</Label></td>
            <td><input type="text" name="email" id="email" value="<?= $email ?? "" ?>"></td>
        </tr>
        <tr>
            <td><Label for="password">Password</Label></td>
            <td><input type="password" name="password" id="password"></td>
        </tr>
        <tr>
            <td><Label for="password_retype">Retype password</Label></td>
            <td><input type="password" name="password_retype" id="password_retype"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="register_form" value="Register"></td>
        </tr>
    </table>
</form>

<?php require_once './components/footer.php'; ?>