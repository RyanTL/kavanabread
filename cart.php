<?php

// Inicia la sesión PHP para acceder a los datos del carrito
session_start();

// Inicializa el carrito vacío como un array  
if (!isset($_SESSION['cart_items'])) {
    $_SESSION['cart_items'] = [];
}

// Manejo de eliminación de productos en el carrito
if (isset($_GET['remover'])) {
    $remove_id = (int) $_GET['remover'];
    $_SESSION['cart_items'] = array_values(
        array_filter($_SESSION['cart_items'], fn($elemento) => $elemento['id'] !== $remove_id)
    );
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

// Copia los artículos del carrito a un array para ser mostradas en el carrito
$cart_items = $_SESSION['cart_items'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kavaná Bread</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/cart.css">

</head>

<body>

<!-- Incluye el archivo navbar.php para utlizar de nuevo la barra de navegación 
en esta página -->
<?php include 'navbar.php'; ?>

<!-- Título de la sección -->
<main>
    <h1 class="page-title">
        <div class="cart-icon">
            <a><i class="fas fa-shopping-cart"></i></a>
        </div>
        Mi Carrito
    </h1>

    <!-- Grid en donde se muestran los productos en el carrito -->
    <div class="cart-wrapper">
        <div class="items-grid" id="carrito-grid"></div>

        <!-- Texto que se muestra cuando el carrito está vacío -->
        <div class="empty-cart" id="carrito-vacio" style="display:none;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 001.99 1.61h9.72a2 2 0 001.99-1.61L23 6H6"/></svg>
            <p>Tu carrito está vacío. ¡Agrega algunos productos!</p>
        </div>

        <!-- Barra con cantidad total de precio -->
        <div class="summary-bar" id="barra-resumen">
            <div class="grand-total">
                Total: <strong id="total-general">$0.00</strong>
            </div>

             <!-- Botón para volver a la sección de productos -->
            <a href="seccionpanes.php" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="17" height="17"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                Seguir Comprando
            </a>

            <!-- Botón de pago -->
            <a href="#" class="btn btn-primary">
                Pagar
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="17" height="17"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </a>
        </div>
    </div>
</main>

<div id="toast"></div>

<script>

// Datos de los productos para ser mostrados en el carrito
const carritoItems = <?= json_encode($cart_items) ?>;

// Muestra los productos escogidos junto con sus datos en el carrito
function mostrarProductosCarrito() {
    const grid         = document.getElementById('carrito-grid');
    const vacio        = document.getElementById('carrito-vacio');
    const barraResumen = document.getElementById('barra-resumen');
    const totalEl      = document.getElementById('total-general');

    // Limpia las tarjetas renderizadas anteriormente
    grid.innerHTML = '';

    // Estado del carrito cuando está vacío
    if (carritoItems.length === 0) {
        vacio.style.display        = 'block';
        barraResumen.style.display = 'none';
        return;
    }

    // Estado del carrito cuando tiene artículos
    vacio.style.display        = 'none';
    barraResumen.style.display = 'flex';

    let granTotal = 0;

    carritoItems.forEach((articulo, indice) => {
        const subtotal      = articulo.precio * articulo.cantidad;
        const totalEstimado = subtotal + articulo.envio;
        granTotal          += totalEstimado;

        // Crea la tarjeta del producto con un retraso de animación sucesivo
        const tarjeta = document.createElement('div');
        tarjeta.className = 'product-card';
        tarjeta.style.animationDelay = `${indice * 0.08}s`;

        // La fila de "Tamaño" que solo se muestra si el artículo tiene ese dato
        const filaTamano = articulo.tamano
            ? `<div class="info-row">
                   <span class="info-label">Tamaño:</span>
                   <span class="info-val">${articulo.tamano}</span>
               </div>`
            : '';

        // Construye el HTML interno de la tarjeta con los detalles del producto y el botón de eliminación
        tarjeta.innerHTML = `
            <div class="card-top">
                <img class="card-img"
                     src="${articulo.imagen}"
                     alt="${articulo.nombre}">
                <div class="card-info">
                    <div class="info-row">
                        <span class="info-label">Producto:</span>
                        <span class="info-val info-val--name">${articulo.nombre}</span>
                    </div>
                    ${filaTamano}
                    <div class="info-row">
                        <span class="info-label">Cantidad:</span>
                        <span class="info-val">${articulo.cantidad}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Precio:</span>
                        <span class="info-val">$${articulo.precio.toFixed(2)}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Envío:</span>
                        <span class="info-val">$${articulo.envio.toFixed(2)}</span>
                    </div>
                    <div class="info-row total-row">
                        <span class="info-label">Total:</span>
                        <span class="info-val">$${totalEstimado.toFixed(2)}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="?remover=${articulo.id}" class="btn-remover">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4h6v2"/>
                    </svg>
                    Remover
                </a>
                <span class="qty-badge">×${articulo.cantidad}</span>
            </div>`;

        grid.appendChild(tarjeta);
    });

    // Muestra el total de cantidad en la barra de resumen
    totalEl.textContent = `$${granTotal.toFixed(2)}`;
}

// Se ejecuta al cargar la página para renderizar el carrito
mostrarProductosCarrito();

</script>

</body>

</html>