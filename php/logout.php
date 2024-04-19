<?php require_once './components/header.php';
session_unset();
session_destroy();
header("Location: " . BASE_URL . "login.php?logout=success");
exit();
