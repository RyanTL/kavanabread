<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username']) && ($_SESSION['is_admin'] ?? false) === true) {
    header("Location: panel.php");
    exit();
}

header("Location: ../iniciar-sesion.php");
exit();
?>
