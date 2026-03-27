<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel – Kavana Bread</title>
    <link rel="stylesheet" href="styles.css">


</head>

<body class="body-crear-cuenta">
  
  <div class="table">
    

        <!-- Panel izquierdo: Logo -->
        <div class="card-left">
          
            <img src="assets/LOGO.png" alt="Kavana Bread Logo">
        </div>
         <div class="card-right">
            <h1>Admin Panel</h1>
<?php 
                if (session_status() == PHP_SESSION_NONE){
                 session_start();

                }
                #Esto es para mostrar quien esta logueado
               echo "Bienvenid@, ". $_SESSION['username'];
               echo "(". $_SESSION['email'];
               echo").";
              
                include ("db.php");
?>
           

             <form action="admin.php" method="POST">

        

               <button type="submit" name="btn-inventario" class="btn-crear">Manejar Inventario</button>

                 <button type="submit" name="btn-crear" class="btn-crear">Ver ordenes</button>
                   <button type="submit" name="btn-crear" class="btn-crear">Ver Cuentas</button>
                     <button type="submit" name="btn-crear" class="btn-crear">Log</button>

 <?php 
                  

?>
</div>