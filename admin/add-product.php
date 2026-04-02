<?php
if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
include(__DIR__ . '/../config/db.php');
?>

<?php
#Para añadir productos
if (isset($_POST['Añadir'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

    $sql = "INSERT INTO products(Product_Name, Price, Quantity)
            VAlUES ('$nombre', '$precio', '$cantidad')";

            $conn->query($sql);

            header("Location: panel.php");
            exit();

}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Producto – Kavana Bread</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="admin-layout">

    <!-- MOBILE HEADER -->
    <header class="mobile-header">
        <a href="panel.php" class="mobile-back-icon" title="Volver">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
        <span class="mobile-page-title">Añadir Producto</span>
        <div style="width:36px;"></div>
    </header>

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <div class="sidebar-logo">
            <img src="../assets/logo.png" alt="Kavana Bread">
        </div>
        <nav class="sidebar-nav">
            <a href="panel.php" class="nav-item active">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                Inventario
            </a>
            <a href="panel.php" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                Ordenes
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-chip">
                <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?></div>
                <div class="user-details">
                    <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <small><?php echo htmlspecialchars($_SESSION['email']); ?></small>
                </div>
            </div>
            <a href="login.php" class="btn-logout">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Cerrar sesión
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-main">
        <div class="tab-header">
            <div>
                <h1>Añadir Producto</h1>
                <p class="tab-subtitle">Nuevo producto al inventario</p>
            </div>
            <a href="panel.php" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Volver
            </a>
        </div>

        <div class="content-card admin-form-card">
            <form action="add-product.php" method="POST" class="admin-form">
                <div class="admin-form-field">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej. Pan Sobao" required>
                </div>
                <div class="admin-form-row">
                    <div class="admin-form-field">
                        <label for="precio">Precio ($)</label>
                        <input type="number" id="precio" name="precio" step="0.01" min="0" placeholder="0.00" required>
                    </div>
                    <div class="admin-form-field">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" id="cantidad" name="cantidad" min="0" placeholder="0" required>
                    </div>
                </div>
                <div class="admin-form-actions">
                    <a href="panel.php" class="btn-secondary">Cancelar</a>
                    <button type="submit" name="Añadir" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- MOBILE BOTTOM NAV -->
    <nav class="mobile-nav">
        <a href="panel.php" class="mobile-nav-item active">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            <span>Inventario</span>
        </a>
        <a href="panel.php" class="mobile-nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            <span>Ordenes</span>
        </a>
        <a href="login.php" class="mobile-nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            <span>Salir</span>
        </a>
    </nav>

</body>
</html>
