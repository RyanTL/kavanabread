<?php

// Verifica si la sesión ya fue iniciada //
// Si no, la inicia para poder usar variables de sesión //
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">

    <!-- Librería de iconos (Font Awesome) -->
    <script src = "https://kit.fontawesome.com/bde2b79879.js" crossorigin = "anonymous"></script>
    <link rel = "stylesheet" href = "styles/seccionsobremi.css">

    <!-- Estilos globales del navbar -->
    <link rel="stylesheet" href="assets/css/navbar.css"/>
    <title>Kavana Bread | Pantalla Principal</title>
</head>

<body>
    <?php 
        // Inserta el navbar reutilizable //
        include "navbar.php";
    ?>

    <?php
        // Inserta el contenido de ayuda contextual para esta página //
        $helpFile = "help-content/sobremi.html";
        include "help.php";
    ?>

    <!-- La nav bar previa (Gustavo Bauer)

    */ La barra amarilla arriba /*
    <div class = "topBarContainer">
        <div class = "topBarContent-right">
            <div class = "menuContainer">
                <i class = "fa-solid fa-bars" id = "menuIcon"></i>
                <div class = "menuContent" id = "menuContent">
                    <a href = "trayectoria.php">Tienda</a>
                    <a href = "trayectoria.php">Sobre Mí</a>
                    <a href = "trayectoria.php">Más</a>
                </div>
            </div>
                <a href = "trayectoria.php">
                    <img src = "imagenes/Kavana_logo.png" alt = "" srcset = "" class = "mainLogo">
                </a>
        </div>
        <div class = "topBarContent-left">
            <a href = "trayectoria.php"><i class = "fa-solid fa-phone"></i></a>
            <a href = "trayectoria.php"><i class = "fa-solid fa-envelope"></i></a>
            <a href = "trayectoria.php"><i class = "fa-solid fa-location-dot"></i></a>
            <a href = "trayectoria.php"><i class = "fa-solid fa-cart-shopping"></i></a>
            <a href = "trayectoria.php"><i class = "fa-regular fa-user" id = "userIcon"></i></a>
        </div>
    </div>

    -->

    <!-- Contenedor principal de la sección "Sobre Mí" -->
    <div class = "mainContainer">

        <!-- Contenido textual -->
        <div class = "mainContent">

            <!-- Primer párrafo descriptivo de la empresa -->
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Kavana Bread es una panadería artesanal que se enfoca en la fermentación natural y el uso de ingredientes orgánicos de alta calidad. Producimos panes de masa madre con una textura crujiente por fuera y una miga suave por dentro. Nuestra meta es recuperar los métodos tradicionales de panificación, evitando aditivos artificiales para ofrecer un producto más saludable. Cada pieza es elaborada a mano, respetando los tiempos de reposo que requiere el cereal para desarrollar su sabor. Se ofrecen ejemplares como el pan blanco, con granos y combinaciones creativas de semillas. 
            </p>
            <br>

            <!-- Segundo párrafo con información adicional -->
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                El menú también una variedad de productos de repostería y opciones de brunch artesanales. Igualmente, ofrecemos talleres y recursos para aquellos interesados en aprender el arte de la panadería en casa. La experiencia va más allá de la compra, ya que busca proveer al consumidor con sustento saludable y de la más alta calidad...
            </p>
        </div>
    </div>
</body>

</html>
