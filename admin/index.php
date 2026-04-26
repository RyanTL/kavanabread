<?php
if (session_status() == PHP_SESSION_NONE) session_start();
if (isset($_SESSION['username'])) {
    header("Location: panel.php");
} else {
    header("Location: login.php");
}
exit;
