<?php
// Página de crear cuenta
?>
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
    <title>Crear Cuenta – Kavana Bread</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body class="body-crear-cuenta">

    <div class="card">

        <!-- Panel izquierdo: Logo -->
        <div class="card-left">
            <img src="assets/logo.png" alt="Kavana Bread Logo">
        </div>

        <!-- Panel derecho: Formulario -->
        <div class="card-right">
            <h1>Crea tu cuenta</h1>

            <form action="crear-cuenta.php" method="POST">

                <!-- Nombre y Apellido en la misma fila -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Nombre</label>
                        <div class="input-wrapper">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input type="text" id="username" name="username" placeholder="Juan" required minlength="2" maxlength="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastname">Apellido</label>
                        <div class="input-wrapper">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input type="text" id="lastname" name="lastname" placeholder="Garcia" required minlength="2" maxlength="50">
                        </div>
                    </div>
                </div>

                <!-- Correo electrónico -->
                <div class="form-group-full">
                    <label for="email">Correo Electronico</label>
                    <div class="input-wrapper">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <input type="email" id="email" name="email" placeholder="juan@ejemplo.com" required maxlength="100">
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
                        <input type="password" id="password" name="password" placeholder="Mín. 8 caracteres" required minlength="8" maxlength="100">
                    </div>
                </div>

                <button type="submit" name="btn-crear" class="btn-crear">Crear cuenta</button>

                <p class="login-link">
                    Ya tienes una cuenta? <a href="iniciar-sesion.php">Iniciar Sesion</a>
                </p>

                <?php include(__DIR__ . '/config/db.php');

if (isset($_POST['btn-crear'])){

     #Aqui estan los nombres de las tablas de login
     $username = trim($_POST['username'] ?? '');
     $lastname = trim($_POST['lastname'] ?? '');
     $email    = trim($_POST['email'] ?? '');
     $password = $_POST['password'] ?? '';

     #Validacion de los campos antes de crear la cuenta
     $errors = [];
     if ($username === '' || $lastname === '' || $email === '' || $password === '') {
         $errors[] = "Todos los campos son obligatorios";
     }
     if ($username !== '' && mb_strlen($username) < 2) {
         $errors[] = "El nombre debe tener al menos 2 caracteres";
     }
     if ($lastname !== '' && mb_strlen($lastname) < 2) {
         $errors[] = "El apellido debe tener al menos 2 caracteres";
     }
     if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $errors[] = "El correo electronico no es valido";
     }
     if ($password !== '' && strlen($password) < 8) {
         $errors[] = "La contraseña debe tener al menos 8 caracteres";
     }

     if (!empty($errors)) {
         foreach ($errors as $err) {
             echo "<p style='text-align:center; color:#b91c1c;'>" . htmlspecialchars($err) . "</p>";
         }
     } else {

     $username = mysqli_real_escape_string($conn, $username);
     $lastname = mysqli_real_escape_string($conn, $lastname);
     $email    = mysqli_real_escape_string($conn, $email);

     #Esto es para cuando el usuario envie la contraseña en el formulario la encripte
     $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $check = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email'");
        #Esto verifica que si el usuario puso el mismo email que otro usuario le deja saber que ya existe una cuenta con ese email
        if (mysqli_num_rows($check) > 0) {
        echo "<p style='text-align:center;'>Esta cuenta ya existe</p>";
        echo "<p style='text-align:center;'>Si creo ya la cuenta con ese email por favor inicie seccion</p>";
        } else {

         #Aqui añade los datos que el usuario puso para añadirla a la base de datos
         $sql_login = "INSERT INTO login(username, lastname, email, password)
         VALUES
         ('$username','$lastname','$email','$hashed_password')";

          if (mysqli_query($conn, $sql_login)) {

          #Aqui crea el carro exclusivamente para cada usuario
          $user_id = mysqli_insert_id($conn);
          $sql_cart = "INSERT INTO cart(user_id, status)
         VALUES
         ('$user_id' , 'active')";
         mysqli_query($conn, $sql_cart);

           echo "<p style='text-align:center;'>Cuenta creada con exito</p>";
           echo "<p style='text-align:center;'>Ahora puede iniciar seccion</p>";

        } else {
          echo "Error al crear cuenta intentelo de nuevo";
        }

       }
        }
        }
          ?>

            </form>
        </div>

    </div>

</body>
</html>
