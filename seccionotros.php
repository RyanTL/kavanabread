<!DOCTYPE html>
<html lang="es">

<!-- Configuración del documento HTML (idioma, codificación y diseño responsivo) -->
<head>
  <meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kavaná Bread</title>

  <!-- Librería de íconos (Font Awesome) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <!-- Estilos CSS -->
  <link rel="stylesheet" href="assets/css/navbar.css"/>
  <link rel="stylesheet" href="assets/css/seccionotros.css"/>
</head>

<body>

<!-- Incluye el archivo navbar.php para reutilizar la barra de navegación 
en esta página -->
<?php include 'navbar.php'; ?>

<main>
  <!-- Título de la sección -->
  <h1 class="main-title">Sección de Otros</h1>

  <!-- Contenedor principal de contenido -->
  <div class="content">

  <!-- Botón para reiniciar filtros -->
    <div class="reset-wrapper">
      <button class="reset-btn" onclick="resetearFiltros()">
        <i class="fas fa-rotate-left"></i> Reiniciar
      </button>
    </div>

  <!-- Grid donde se muestran los productos -->
    <div class="product-grid" id="productos-grid"></div>
  </div>
</main>

<!-- Contenedor de notificación temporal (toast) que muestra mensajes al agregar 
productos al carrito -->
<div id="toast"></div>

<script>
// Función menú despegable "drop-down list" 
  function MenuDespegable() {
    const menu = document.getElementById('dropdown-menu');
    menu.classList.toggle('open');
  }

// Reinicia filtros
  function resetearFiltros() {
    document.querySelectorAll('.qty-select').forEach(selector => selector.value = '1');
    document.querySelectorAll('.product-card').forEach(tarjeta => actualizarTarjetaProducto(tarjeta));
    mostrarPanCarritos('Cantidades reiniciadas');
  }

// Inventario de productos
  const inventario = [
    { nombre: "Nueces y Almendras con Caramelo", precio: 5.00, imagen: "assets/products/almendras.jpeg" },
    { nombre: "Cocacha Pan Italiano",            precio: 8.00, imagen: "assets/products/panitaliano.jpeg" },
    { nombre: "Tiavaca (4)",                     precio: 6.00, imagen: "assets/products/tiavaca.jpeg" },
    { nombre: "Granola Mix Masa Madre",          precio: 5.00, imagen: "assets/products/granolamasamadre.jpeg" },
  ];

// Actualiza tarjeta del producto 
  function actualizarTarjetaProducto(tarjeta) {
    const precio = parseFloat(tarjeta.dataset.precio);
    if (!isNaN(precio)) {
      const cantidad = parseInt(tarjeta.querySelector('.qty-select').value);
    }
  }

// Agregar al carrito 
  function agregarAlCarrito(nombre, cantidad, precio, imagen) {
    fetch('agregar_carrito.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ nombre, tamano: null, cantidad, precio, imagen })
    })
    .then(respuesta => respuesta.json())
    .then(datos => {
      mostrarPanCarritos(datos.exito ? datos.mensaje : 'Error al agregar al carrito');
    })
    .catch(() => mostrarPanCarritos('Error de conexión'));
  }

// Genera los productos en pantalla
  function mostrarProductos() {
    const grid = document.getElementById("productos-grid");
    grid.innerHTML = "";

    for (let producto of inventario) {
      const tarjeta = document.createElement("div");
      tarjeta.className = "product-card";

      const opcionesCantidad = [...Array(10)]
        .map((_, indice) => `<option value="${indice+1}">${indice+1}</option>`)
        .join('');

      tarjeta.dataset.precio = producto.precio;

      tarjeta.innerHTML = `
        <div class="card-top">
          <img src="${producto.imagen}" alt="${producto.nombre}" loading="lazy"/>
          <div class="card-info">
            <h3>${producto.nombre}</h3>
            <p class="price">$${producto.precio.toFixed(2)} c/u</p>
            <div class="card-actions">
              <div class="selectors-row">
                <select class="qty-select" name="cantidad">${opcionesCantidad}</select>
              </div>
              <button class="add-button">Agregar al carrito</button>
            </div>
          </div>
        </div>`;

    // Agregar al carrito 
      tarjeta.querySelector('.add-button').addEventListener('click', () => {
        const cantidad = parseInt(tarjeta.querySelector('.qty-select').value);
        agregarAlCarrito(producto.nombre, cantidad, producto.precio, producto.imagen);
      });

      grid.appendChild(tarjeta);
    }
  }

// Muestra una notificación temporal (toast) con el mensaje de confirmación 
// al agregar productos al carrito
  function mostrarPanCarritos(mensaje) {
    const toast = document.getElementById("toast");
    toast.textContent = mensaje;
    toast.classList.add("show");
    setTimeout(() => toast.classList.remove("show"), 2200);
  }

  mostrarProductos();
  
</script>

</body>

</html>