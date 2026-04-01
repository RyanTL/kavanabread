<?php
// Credenciales y conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kavanabread";

$conn = new mysqli($servername, $username, $password, $dbname);

if (mysqli_connect_error()) {
    die("Database connection failed: " . mysqli_connect_error());
}
