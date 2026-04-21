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
  <link rel="stylesheet" href="assets/css/seccionartesanal.css"/>
</head>

<body>

<!-- Incluye el archivo navbar.php para reutilizar la barra de navegación 
en esta página -->
<?php include 'navbar.php'; ?>

<main>
  <!-- Título de la sección -->
  <h1 class="main-title">Sección de Artesanal</h1>

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
    document.querySelectorAll('.oz-select').forEach(selector => selector.selectedIndex = 0);
    document.querySelectorAll('.product-card').forEach(tarjeta => {
      const ozSelect = tarjeta.querySelector('.oz-select');
      const precioEl = tarjeta.querySelector('.price');
      if (ozSelect && precioEl) {
        precioEl.textContent = `$${parseFloat(ozSelect.value).toFixed(2)} c/u`;
      }
    });
    mostrarPanCarritos('Cantidades y onzas reiniciadas');
  }

// Inventario de productos
  const inventario = [
    { nombre: "Mantequilla Fresca",      precio: 6.00,  imagen: "assets/products/mantequillafresca.jpeg" },
    { nombre: "Jalea de Fresa",          precio: 5.00,  imagen: "assets/products/jaleadefresa.jpeg" },
    { nombre: "Jalea de Blueberry",      precio: 5.00,  imagen: "assets/products/jaleadeblueberry.jpg" },
    { nombre: "Mantequilla de Cilantro", precio: null,  imagen: "assets/products/mantequilladecilantro.jpeg",
      variantes: [
        { label: "3 oz", precio: 5.00 },
        { label: "8 oz", precio: 12.00 }
      ]
    },
  ];
  
// Agregar al carrito
  function agregarAlCarrito(nombre, tamano, cantidad, precio, imagen) {
    fetch('agregar_carrito.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ nombre, tamano, cantidad, precio, imagen })
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

      if (producto.variantes) {
        const opcionesVariante = producto.variantes
          .map(variante => `<option value="${variante.precio}">${variante.label}</option>`)
          .join('');

        tarjeta.innerHTML = `
          <div class="card-top">
            <img src="${producto.imagen}" alt="${producto.nombre}" loading="lazy"/>
            <div class="card-info">
              <h3>${producto.nombre}</h3>
              <p class="price">$${producto.variantes[0].precio.toFixed(2)} c/u</p>
              <div class="card-actions">
                <div class="selectors-row">
                  <select class="oz-select">${opcionesVariante}</select>
                  <select class="qty-select" name="cantidad">${opcionesCantidad}</select>
                </div>
                <button class="add-button">Agregar al carrito</button>
              </div>
            </div>
          </div>`;

        const selectOz       = tarjeta.querySelector('.oz-select');
        const selectCantidad = tarjeta.querySelector('.qty-select');
        const precioEl       = tarjeta.querySelector('.price');

        selectOz.addEventListener('change', () => {
          precioEl.textContent = `$${parseFloat(selectOz.value).toFixed(2)} c/u`;
        });

        tarjeta.querySelector('.add-button').addEventListener('click', () => {
          const precio   = parseFloat(selectOz.value);
          const cantidad = parseInt(selectCantidad.value);
          const etiqueta = selectOz.options[selectOz.selectedIndex].text;
          agregarAlCarrito(producto.nombre, etiqueta, cantidad, precio, producto.imagen);
        });

      } else {
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
          agregarAlCarrito(producto.nombre, null, cantidad, producto.precio, producto.imagen);
        });
      }

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