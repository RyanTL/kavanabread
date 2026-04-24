<?php
    //Variables para conectarse a la base de datosy la conexion
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "kavanabread";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    //Variables para confirmar usuario vacias hasta que se rellenen con la informacion necesaria
    $email = "";
    $loginPassword = "";
    
    //Comprobando conexion
    if (mysqli_connect_error()) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    else {
        $error = "";
        //Se comprueba que el usuario haya enviado la informacion requerida
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (empty($_POST["email"]) || empty($_POST["password"])) {
                $error = "Por favor, completa todos los campos.";
            } else {
                //Se guarda la informacion de usuario en las variables correspondientes
                $email = $_POST["email"];
                $loginPassword = $_POST["password"];
                //Se preparar la consulta para buscar el usuario
                $stmt = $conn->prepare("SELECT password FROM login WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $resultado = $stmt->get_result();
                //Verificar si la informacion coincide con algun usuario registrado
                //Los 'else' restantes son para mostrar errores
                if ($fila = $resultado->fetch_assoc()) {
                    //Verificar el password
                    if (!password_verify($loginPassword, $fila['password'])) {
                        $error = "La contraseña es incorrecta.";
                    } else {
                        header("Location: menu-principal.php");
                        exit();
                    }
                } else {
                    $error = "Este correo no está registrado.";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="styles.css">
    <title>Kavana Bread | Iniciar Sesión</title>
</head>
<body class="body-crear-cuenta">
    <div class = "card">
        <div class="card-left">
            <img src="assets/LOGO.png" alt="Kavana Bread Logo">
        </div>
        <div class="card-right">
            <h1>Iniciar Sesión</h1>

            <!-- Mensajes de error encima del 'form' -->
            <?php if (!empty($error)) : ?>
                <div class="error-message">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group-full">
                    <label for="email">Correo Electrónico:</label>
                    <div class="input-wrapper">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <input type="text" name="email" id="email" placeholder="juan@ejemplo.com"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                </div>
                <div class="form-group-full">
                    <label for="password">Contraseña:</label>
                    <div class="input-wrapper">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="password" name="password" placeholder="Mín. 8 caracteres">
                    </div>
                </div>
                <input type="submit" class="btn-crear-iniciar" value="Iniciar Sesión">
            </form>
            <p class="login-link">
                No tienes cuenta? <a href="crear-cuenta.php">Crear Cuenta</a>
            </p>
        </div>
    </div>
</body>
</html>
