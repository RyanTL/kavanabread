<?php
/*
 * Autor Frontend: Ryan Torres Lugo
 * Autor Backend: Kelvin Acosta
 * Proyecto: KavanaBread
 */
if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit; }
include(__DIR__ . '/../config/db.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM products WHERE Product_ID = $id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);
?>

<?php
#Para editar productos
if (isset($_POST['Editar'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);

 $stmt = $conn->prepare("UPDATE products
 SET Product_Name= ?, Price= ?, Quantity= ?
            WHERE Product_ID= ?");
    $stmt->bind_param("sdii", $nombre, $precio, $cantidad, $id);
    $stmt->execute();
           header("Location: panel.php");
            exit();

}
?>

<?php
if (isset($_POST['Delete'])) {
   #Para eliminar un producto
   
    $id = intval($_POST['id']);
$stmt = $conn->prepare("DELETE FROM products
            WHERE Product_ID= ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
           header("Location: panel.php");
            exit();

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto – Kavana Bread</title>
    <link rel="stylesheet" href="/kavanabread/assets/styles.css">
</head>
<body class="admin-layout">

    <!-- MOBILE HEADER -->
    <header class="mobile-header">
        <a href="panel.php" class="mobile-back-icon" title="Volver">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
        <span class="mobile-page-title">Editar Producto</span>
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
             <a href="panel.php" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Admins
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
                <h1>Editar Producto</h1>
                <p class="tab-subtitle"><?php echo $product ? htmlspecialchars($product['Product_Name']) : 'Producto #' . $id; ?></p>
            </div>
            <a href="panel.php" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Volver
            </a>
        </div>

        <div class="content-card admin-form-card">
            <form action="edit-product.php" method="POST" class="admin-form">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="admin-form-field">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre"
                        value="<?php echo $product ? htmlspecialchars($product['Product_Name']) : ''; ?>"
                        placeholder="Nombre del producto" required>
                </div>
                <div class="admin-form-field">
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" required>
                        <?php
                        $currentCat = $product ? (int)$product['category_ID'] : 0;
                        $catResult = mysqli_query($conn, "SELECT category_ID, name FROM category");
                        while ($cat = mysqli_fetch_array($catResult)) {
                            $selected = ($cat['category_ID'] == $currentCat) ? 'selected' : '';
                            echo '<option value="' . (int)$cat['category_ID'] . '" ' . $selected . '>' . htmlspecialchars($cat['name']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="admin-form-row">
                    <div class="admin-form-field">
                        <label for="precio">Precio ($)</label>
                        <input type="number" id="precio" name="precio" step="0.01" min="0"
                            value="<?php echo $product ? htmlspecialchars($product['Price']) : ''; ?>"
                            placeholder="0.00" required>
                    </div>
                    <div class="admin-form-field">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" id="cantidad" name="cantidad" min="0"
                            value="<?php echo $product ? htmlspecialchars($product['Quantity']) : ''; ?>"
                            placeholder="0" required>
                    </div>
                </div>
                <div class="admin-form-actions">
                    <form method="POST" action="edit-product.php" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')" style="margin:0;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <button type="submit" name="Delete" class="btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                            Eliminar
                        </button>
                    </form>
                    <div class="form-actions-right">
                        <a href="panel.php" class="btn-secondary">Cancelar</a>
                        <button type="submit" name="Editar" class="btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Guardar Cambios
                        </button>
                    </div>
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

