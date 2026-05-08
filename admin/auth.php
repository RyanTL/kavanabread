<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: ../iniciar-sesion.php");
    exit();
}

if (($_SESSION['is_admin'] ?? false) !== true) {
    header("Location: ../menu-principal.php");
    exit();
}
?>
