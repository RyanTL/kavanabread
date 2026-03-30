<?php
#Estas son las credenciales del usuario de la base de datos y esto permite la conexion entre la pagina web y la base de datos 
 if (session_status() == PHP_SESSION_NONE){
                 session_start(); 
                }
$servername = "localhost";
$username = "kavanaAdmin";
$password = "nBcA4)Qc3DE8T_vd";
$username = "root";
$password = "";
$dbname = "kavanabread";

$conn = new mysqli($servername, $username, $password, $dbname);
#Este if es para dejar saber si hubo un error al conectarse  la base de datos
if (mysqli_connect_error())
  {
    die("Database connection failed: " . mysqli_connect_error());
  }
  #Esta en banco por el momento pero sesupone que hiba conected to the database haci que si no les sale en la pagina se concecto corrctamente
  echo "";
