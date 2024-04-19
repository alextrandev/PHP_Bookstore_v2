<?php require_once './components/header.php';

if (!isset($_SESSION["user"])) {
    header("Location: " . BASE_URL . "login.php?login=required");
    exit();
}

session_unset();
session_destroy();
header("Location: " . BASE_URL . "login.php?logout=success");
exit();
