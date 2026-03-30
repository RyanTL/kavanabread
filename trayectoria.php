<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
    <script src = "https://kit.fontawesome.com/bde2b79879.js" crossorigin = "anonymous"></script>
    <link rel = "stylesheet" href = "styles/trayectoria.css">
    <title>Kavana Bread | Pantalla Principal</title>
</head>

<body>
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

    */ El cuadrado verde y su contenido /*
    <div class = "mainContainer">
        <div class = "mainContent-left">

            */ Imagen de cuadrado verde /*
            <img src = "imagenes/default_pic.jpg" alt = "pic" srcset = "" class = "mainPic">
        
        </div>
        <div class = "mainContent-right">

            */ Aqui va el mensaje del cuadrado verde /*
            <p> [ Texto de trayectoria y Logros Personales ] </p>

        </div>
    </div>
</body>

*/ Funcion de Javascript para el boton del menu /*
<script>
    const menuIcon = document.getElementById("menuIcon");
    const menuContent = document.getElementById("menuContent");

    menuIcon.addEventListener("click", () => {
        menuContent.classList.toggle("show");
    });

    document.addEventListener("click", (e) => {
        if (!menuIcon.contains(e.target) && !menuContent.contains(e.target)) {
            menuContent.classList.remove("show");
        }
    });
</script>

</html>
