<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel – Kavana Bread</title>
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
            <h1>Admin Panel</h1>

            <form action="admin.php" method="POST">

        

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

                



              <!-- Para enviar los datos a la base de datos -->
                <?php 
                if (session_status() == PHP_SESSION_NONE){
                 session_start(); 
                }
                
                include ("db.php");
                

if (isset($_POST['btn-login'])){

     #Aqui estan los nombres de las tablas de login
     
     
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $password = mysqli_real_escape_string($conn, $_POST['password']);

     
	#Esto es para cuando el usuario envie la contraseña en el folmulario la encripte
     $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $check = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email'");
        #Esto verifica que si el ususario puso el mismo email que otro usuario le deja saber que ya existe ua cuenta con ese email
       
           
         #Aqui añade los datos que el usuario puso para añadirla a la base de datos
	     $query = mysqli_query($conn, "SELECT * FROM login WHERE email= '$email'");
       
       $user = mysqli_fetch_assoc($query);
         

          if ($user && password_verify($password, $user['password'])) {
            
        #Esto llevara al usuario a otra pagina
        
        $_SESSION['id'] = $user["id"];
        $_SESSION['email'] = $user['email'];
        $_SESSION['username'] = $user['username']; #esto es para mostrar  el email
        header("Location: AdminPanel.php");
        exit();

        } else {
       echo "<p style='text-align:center;'></p> incorrect password or email ";
	     

       }
        }
          ?>

            </form>
        </div>

    </div>

</body>
</html>
