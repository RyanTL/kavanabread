<!DOCTYPE html>
<!--
 * Autor Frontend: Ryan Torres Lugo
 * Autor Backend: Kelvin Acosta
 * Proyecto: KavanaBread
 -->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel – Kavana Bread</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body class="body-crear-cuenta">

    <div class="card">

        <!-- Panel izquierdo: Logo -->
        <div class="card-left">
            <img src="../assets/logo.png" alt="Kavana Bread Logo">
        </div>

        <!-- Panel derecho: Formulario -->
        <div class="card-right">
            <h1>Admin Panel</h1>

            <form action="login.php" method="POST">

                <!-- Correo electrónico -->
                <div class="form-group-full">
                    <label for="email">Correo Electronico</label>
                    <div class="input-wrapper">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <input type="email" id="email" name="email" placeholder="Admin Email">
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="form-group-full">
                    <label for="password">Contraseña</label>
                    <div class="input-wrapper">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="password" name="password" placeholder="Contraseña Admin">
                    </div>
                </div>

                <button type="submit" name="btn-login" class="btn-crear">Login</button>
            <?php
                if (session_status() == PHP_SESSION_NONE) session_start();

                include(__DIR__ . '/../config/db.php');

                if (isset($_POST['btn-login'])){

                     $email = mysqli_real_escape_string($conn, $_POST['email']);
                     $password = mysqli_real_escape_string($conn, $_POST['password']);

                     #Esto se encarga de desirle al usuario que debe de poner el email y la contaseña
                    if (empty($email) || empty($password)) {
                     echo '<div class="alert alert-danger">Favor de introducir el email y la contraseña</div>';
                    return;}
                    #Esto verifica si el email existe o no para iniciar sesion
                    $stmt = $conn->prepare("SELECT * FROM login WHERE email=?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();

                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();

                   if ($user && password_verify($password, $user['password'])) {

                        $_SESSION['id'] = $user["user_id"];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['username'] = $user['username'];
                        #Esto se encarga de verificar si el usuario es admin o no
                    $stmt2 = $conn->prepare("SELECT * FROM loginadmins WHERE user_id=?");
                    $stmt2->bind_param("i", $user['user_id']);
                    $stmt2->execute();
                    $adminResult = $stmt2->get_result();
                        if($adminResult->num_rows > 0){
                            $_SESSION['is_admin'] = true;
                            header("Location: panel.php");
                            exit();
                        } else {
                            $_SESSION['is_admin'] = false;
                              die("<h1>No eres admin</h1><p>Tus credenciales son correctas, pero no tienes permiso para entrar al panel de administrador.</p><a href='login.php'>Volver</a>"); 
                              exit();
                        }


                    } else {
                        echo "<p style='text-align:center;'>Correo o contraseña incorrectos</p>";
                    }
                }
                ?>

            </form>
        </div>

    </div>

</body>
</html>
