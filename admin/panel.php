<?php
if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include(__DIR__ . '/../config/db.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – Kavana Bread</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="admin-layout">

    <!-- MOBILE HEADER (hidden on desktop) -->
    <header class="mobile-header">
        <img src="../assets/logo.png" alt="Kavana Bread" class="mobile-logo">
        <span class="mobile-page-title" id="mobile-title">Inventario</span>
        <a href="login.php" class="mobile-logout-icon" title="Cerrar sesión">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        </a>
    </header>

    <!-- SIDEBAR (hidden on mobile) -->
    <aside class="admin-sidebar">
        <div class="sidebar-logo">
            <img src="../assets/logo.png" alt="Kavana Bread">
        </div>

        <nav class="sidebar-nav">
            <button class="nav-item active" data-tab="inventario">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                Inventario
            </button>
            <button class="nav-item" data-tab="ordenes">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                Ordenes
            </button>
            <button class="nav-item" data-tab="admins">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Admins
            </button>
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

        <!-- ===== INVENTARIO ===== -->
        <section id="tab-inventario" class="admin-tab active">
            <div class="tab-header">
                <div>
                    <h1>Inventario</h1>
                    <p class="tab-subtitle">Gestiona tus productos</p>
                </div>
                <a href="add-product.php" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Añadir Producto
                </a>
            </div>

            <div class="content-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM products";
                        $result = mysqli_query($conn, $sql);
                        while($show = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td class="td-id">#<?php echo $show['Product_ID']; ?></td>
                            <td class="td-name"><?php echo htmlspecialchars($show['Product_Name']); ?></td>
                            <td class="td-price">$<?php echo $show['Price']; ?></td>
                            <td class="td-qty">
                                <span class="qty-badge <?php echo ($show['Quantity'] < 5) ? 'qty-low' : ''; ?>">
                                    <?php echo $show['Quantity']; ?>
                                </span>
                            </td>
                            <td class="td-actions">
                                <a href="edit-product.php?id=<?php echo $show['Product_ID']; ?>" class="btn-edit">Editar</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- ===== ORDENES ===== -->
        <section id="tab-ordenes" class="admin-tab">
            <div class="tab-header">
                <div>
                    <h1>Ordenes</h1>
                    <p class="tab-subtitle">Revisa los pedidos recientes</p>
                </div>
            </div>
            <div class="content-card empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#c8c8c0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                <p>No hay ordenes disponibles</p>
            </div>
        </section>

        <!-- ===== ADMINS ===== -->
        <section id="tab-admins" class="admin-tab">
            <div class="tab-header">
                <div>
                    <h1>Admins</h1>
                    <p class="tab-subtitle">Gestiona los administradores</p>
                </div>
                <a href="add-admin.php" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Añadir Admin
                </a>
            </div>

            <div class="content-card">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td-id">#1</td>
                            <td class="td-name"><?php echo htmlspecialchars($_SESSION['username']); ?></td>
                            <td class="td-email"><?php echo htmlspecialchars($_SESSION['email']); ?></td>
                            <td class="td-actions">
                                <button type="button" class="btn-danger btn-danger-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <!-- MOBILE BOTTOM NAV (hidden on desktop) -->
    <nav class="mobile-nav">
        <button class="mobile-nav-item active" data-tab="inventario">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Z"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            <span>Inventario</span>
        </button>
        <button class="mobile-nav-item" data-tab="ordenes">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            <span>Ordenes</span>
        </button>
        <button class="mobile-nav-item" data-tab="admins">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span>Admins</span>
        </button>
        <a href="login.php" class="mobile-nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            <span>Salir</span>
        </a>
    </nav>

    <script>
    var tabTitles = { inventario: 'Inventario', ordenes: 'Ordenes', admins: 'Admins' };

    function switchTab(tab) {
        document.querySelectorAll('.nav-item[data-tab], .mobile-nav-item[data-tab]').forEach(function(n) {
            n.classList.toggle('active', n.getAttribute('data-tab') === tab);
        });
        document.querySelectorAll('.admin-tab').forEach(function(t) { t.classList.remove('active'); });
        document.getElementById('tab-' + tab).classList.add('active');
        var el = document.getElementById('mobile-title');
        if (el) el.textContent = tabTitles[tab] || '';
    }

    document.querySelectorAll('.nav-item[data-tab], .mobile-nav-item[data-tab]').forEach(function(item) {
        item.addEventListener('click', function() {
            switchTab(this.getAttribute('data-tab'));
        });
    });
    </script>

</body>
</html>
