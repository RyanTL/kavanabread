<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <!-- Configuración del documento HTML (idioma, codificación y diseño responsivo) -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kavaná Bread</title>

  <!-- Librería de íconos (Font Awesome) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <!-- Estilos CSS -->
  <link rel="stylesheet" href="assets/css/navbar.css"/>
  <link rel="stylesheet" href="assets/css/seccionpanes.css"/>
</head>

<body>

<!-- Incluye el archivo navbar.php para reutilizar la barra de navegación 
en esta página -->
<?php include 'navbar.php'; ?>

<main>
  <!-- Título de la sección -->
  <h1 class="main-title">Sección de Panes</h1>

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
function menuDespegable() {
  document.getElementById('dropdown-menu').classList.toggle('open');
}

// Productos especiales
const ESPECIALES = ["pan curcuma", "pan chocolate 100%"];

function especialProducto(nombre) {
  return ESPECIALES.includes(nombre.toLowerCase());
}

// Inventario de productos
const inventario = [
  { nombre: "Pan Blanco",            imagen: "assets/products/panblanco.JPG" },
  { nombre: "Pan de Semillas",       imagen: "assets/products/pandesemillas.jpg" },
  { nombre: "Pan de Canela y Pasas", imagen: "assets/products/pandecanela.jpeg" },
  { nombre: "Pan de Avena y Miel",   imagen: "assets/products/pandemiel.jpeg" },
  { nombre: "Pan de Cúrcuma",        imagen: "assets/products/pandecurcumasmall.jpg",
    imagenGrande: "assets/products/pandecurcuma.jpeg" },
];

// Precio base según tamaño
function precioBase(nombre, tamano) {
  if (tamano === "pequeño")  return 7;
  if (tamano === "mediano")  return especialProducto(nombre) ? 15 : 12;
  if (tamano === "familiar") return especialProducto(nombre) ? 18 : 15;
  return 7;
}

// Total de compra
function calcularTotalCompra(nombre, tamano, cantidad) {
  if (tamano === "pequeño") {
    if (cantidad === 1) return 7;
    if (cantidad === 2) return 12;
    if (cantidad === 4) return 20;
    return cantidad * 7;
  }
  return cantidad * precioBase(nombre, tamano);
}


// Mostrar precio en tarjeta
function precioTarjetaProducto(nombre, tamano) {
  const base = precioBase(nombre, tamano);

  if (tamano === "pequeño") {
    return `
      <div class="oferta-texto">
        <strong>OFERTA</strong><br>
      </div>
      <div class="oferta-precio-texto">
        <strong>1x $7 &nbsp;|&nbsp; 2x $12 &nbsp;|&nbsp; 4x $20</strong><br>
      </div>`;
  }
  return `<div class="precio-texto"><strong>$${base.toFixed(2)} c/u</strong></div>`;
}

// Actualiza tarjeta del producto
function actualizarTarjetaProducto(tarjeta, producto) {
  const nombre  = tarjeta.dataset.nombre;
  const tamano  = tarjeta.querySelector(".size-select").value;
  const cantidad = parseInt(tarjeta.querySelector(".qty-select").value);

  tarjeta.querySelector(".price-display").innerHTML = precioTarjetaProducto(nombre, tamano);

  if (producto && producto.imagenGrande) {
    const imagen = tarjeta.querySelector("img");
    imagen.src = (tamano === "pequeño") ? producto.imagen : producto.imagenGrande;
  }
}

// Agregar al carrito
function agregarAlCarrito(producto, tamano, cantidad, precio, imagen) {
  fetch('agregar_carrito.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ nombre: producto, tamano, cantidad, precio, imagen })
  })
  .then(respuesta => respuesta.json())
  .then(datos => {
    if (datos.exito) {
      mostrarPanCarritos(datos.mensaje);
    } else {
      mostrarPanCarritos('Error al agregar al carrito');
    }
  })
  .catch(() => mostrarPanCarritos('Error de conexión'));
}

// Genera los productos en pantalla
function mostrarProductos() {
  const grid = document.getElementById("productos-grid");
  grid.innerHTML = "";

  for (const producto of inventario) {
    const tarjeta = document.createElement("div");
    tarjeta.className      = "product-card";
    tarjeta.dataset.nombre = producto.nombre;

    const opcionesCantidad = [...Array(10)]
      .map((_, indice) => `<option value="${indice+1}">${indice+1}</option>`)
      .join('');

    tarjeta.innerHTML = `
      <div class="card-top">
        <img src="${producto.imagen}" alt="${producto.nombre}">
        <div class="card-info">
          <h3>${producto.nombre}</h3>
          <div class="price-display"></div>
          <div class="card-actions">
            <select class="size-select">
              <option value="pequeño">Pequeño</option>
              <option value="mediano">Mediano</option>
              <option value="familiar">Familiar</option>
            </select>
            <select class="qty-select">${opcionesCantidad}</select>
            <button class="add-button">Agregar al carrito</button>
          </div>
        </div>
      </div>`;

  // Cambios en tamaño y cantidad del producto
    tarjeta.querySelector(".size-select").addEventListener("change", () => actualizarTarjetaProducto(tarjeta, producto));
    
    tarjeta.querySelector(".qty-select").addEventListener("change",  () => actualizarTarjetaProducto(tarjeta, producto));

  // Agregar al carrito 
    tarjeta.querySelector(".add-button").addEventListener("click", () => {
      const tamano   = tarjeta.querySelector(".size-select").value;
      const cantidad = parseInt(tarjeta.querySelector(".qty-select").value);
      const precio   = precioBase(producto.nombre, tamano);
      const imagen   = tarjeta.querySelector("img").src;
      agregarAlCarrito(producto.nombre, tamano, cantidad, precio, imagen);
    });

    actualizarTarjetaProducto(tarjeta, producto);
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

// Reinicia filtros 
function resetearFiltros() {
  document.querySelectorAll('.product-card').forEach(tarjeta => {
    tarjeta.querySelector('.qty-select').value  = '1';
    tarjeta.querySelector('.size-select').value = 'pequeño';
    const nombre   = tarjeta.dataset.nombre;
    const producto = inventario.find(producto => producto.nombre === nombre);
    actualizarTarjetaProducto(tarjeta, producto);
  });
  mostrarPanCarritos('Cantidades y tamaños reiniciados');
}

mostrarProductos();

</script>

</body>

</html>