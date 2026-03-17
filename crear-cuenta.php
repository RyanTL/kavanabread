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
                        <label for="nombre">Nombre</label>
                        <div class="input-wrapper">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input type="text" id="nombre" name="nombre" placeholder="Juan">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <div class="input-wrapper">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input type="text" id="apellido" name="apellido" placeholder="Garcia">
                        </div>
                    </div>
                </div>

                <!-- Correo electrónico -->
                <div class="form-group-full">
                    <label for="correo">Correo Electronico</label>
                    <div class="input-wrapper">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <input type="email" id="correo" name="correo" placeholder="juan@ejemplo.com">
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="form-group-full">
                    <label for="contrasena">Contraseña</label>
                    <div class="input-wrapper">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="contrasena" name="contrasena" placeholder="Mín. 8 caracteres">
                    </div>
                </div>

                <button type="submit" class="btn-crear">Crear cuenta</button>

                <p class="login-link">
                    Ya tienes una cuenta? <a href="iniciar-sesion.php">Iniciar Sesion</a>
                </p>

            </form>
        </div>

    </div>

</body>
</html>
