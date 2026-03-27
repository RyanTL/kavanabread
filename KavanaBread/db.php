<?php
#Estas son las credenciales del usuario de la base de datos y tambien permite la coneccion de la base de datos con la pagina web
session_start();
$servername = "localhost";
$username = "kavanaAdmin";
$password = "nBcA4)Qc3DE8T_vd";
$dbname = "kavanabread";

$conn = new mysqli($servername, $username, $password, $dbname);
#Este if es para dejar saber si hubo un error al conectarse  la base de datos
if (mysqli_connect_error())
  {
    die("Database connection failed: " . mysqli_connect_error());
  }
  #Esta en blanco por el momento pero sesupone que hiba conected to the database haci que si no les sale en la pagina se concecto corrctamente
  echo "";


  ?>
