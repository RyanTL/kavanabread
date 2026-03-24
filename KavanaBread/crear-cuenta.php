<?php
// Página de crear cuenta — por ahora solo muestra el formulario (sin funcionalidad)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta – Kavana Bread</title>
    <link rel="stylesheet" href="styles.css">
</head>


<!-- Para conectar la pagina a la base de datos -->


<body class="body-crear-cuenta">

    <div class="card">

        <!-- Panel izquierdo: Logo -->
        <div class="card-left">
            <img src="assets/LOGO.png" alt="Kavana Bread Logo">
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
                            <input type="text" id="username" name="username" placeholder="Juan">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastname">Apellido</label>
                        <div class="input-wrapper">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input type="text" id="lastname" name="lastname" placeholder="Garcia">
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
                        <input type="email" id="email" name="email" placeholder="juan@ejemplo.com">
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
                        <input type="password" id="password" name="password" placeholder="Mín. 8 caracteres">
                    </div>
                </div>

                <button type="submit" name="btn-crear" class="btn-crear">Crear cuenta</button>

                <p class="login-link">
                    Ya tienes una cuenta? <a href="iniciar-sesion.php">Iniciar Sesion</a>
                </p>



              <!-- Para enviar los datos a la base de datos -->
                <?php include ("db.php");
   
if (isset($_POST['btn-crear'])){

     #Aqui estan los nombres de las tablas de login
     $username = mysqli_real_escape_string($conn, $_POST['username']);
     $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $password = mysqli_real_escape_string($conn, $_POST['password']);

     
	#Esto es para cuando el usuario envie la contraseña en el folmulario la encripte
     $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $check = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email'");
        #Esto verifica que si el ususario puso el mismo email que otro usuario le deja saber que ya existe ua cuenta con ese email
        if (mysqli_num_rows($check) > 0) {
        echo "<p style='text-align:center;'>Esta cuenta ya existe</p>";
        echo "<p style='text-align:center;'>Si creo ya la cuenta con ese email por favor inicie seccion</p>";
        } else {
           
         #Aqui añade los datos que el usuario puso para añadirla a la base de datos
	     $sql_login = "INSERT INTO login(username, lastname, email, password)
	     VALUES
         ('$username','$lastname','$email','$hashed_password')";

         
      
	      if (mysqli_query($conn, $sql_login)) {

          #Aqui crea el carro exclusivamente para cada usuario y se le guarden lo que tengan hay incluso si unden log out
          $user_id = mysqli_insert_id($conn);
          $sql_cart = "INSERT INTO cart(user_id, status)
	     VALUES
         ('$user_id' , 'active')";
         mysqli_query($conn, $sql_cart);

           echo "<p style='text-align:center;'>Cuenta creada con exito</p>";
           echo "<p style='text-align:center;'>Ahora puede iniciar seccion</p>";
           
        } else {
            #Esto le deja saber que hubo un error al usuario al crear la cuenta por si la conexion falla o algo
          echo "Error al crear cuenta intentelo de nuevo";
        }

       }
        }
          ?>





            </form>
        </div>

    </div>

</body>
</html>
