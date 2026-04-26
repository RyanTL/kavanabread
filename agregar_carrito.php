<?php

// Inicia la sesión para acceder al carrito del usuario
session_start();

// Inicializa el carrito vacío como un array
if (!isset($_SESSION['cart_items'])) {
    $_SESSION['cart_items'] = [];
}

// Solo se aceptan solicitudes POST; cualquier otro método devuelve un error
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Lee y decodifica el cuerpo JSON de la solicitud
$datos = json_decode(file_get_contents('php://input'), true);

// Valida que los datos existan y contengan al menos el dato obligatorio "nombre"
if (!$datos || !isset($datos['nombre'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

// Extrae los datos del JSON con valores por defecto para los opcionales
$nombre   = $datos['nombre'];
$tamano   = $datos['tamano']   ?? 'pequeño'; 
$cantidad = (int)($datos['cantidad'] ?? 1);  
$precio   = (float)($datos['precio'] ?? 0);  
$imagen   = $datos['imagen']   ?? '';        

// Busca si ya existe un artículo con el mismo nombre Y tamaño en el carrito
$encontrado = false;
foreach ($_SESSION['cart_items'] as &$articulo) {
    if ($articulo['nombre'] === $nombre && $articulo['tamano'] === $tamano) {
        // Si ya existe, solo incrementa la cantidad en lugar de agregar un duplicado
        $articulo['cantidad'] += $cantidad;
        $encontrado = true;
        break;
    }
}
unset($articulo);

// Si el producto no estaba en el carrito, se agrega como un nuevo producto en el carrito
if (!$encontrado) {
    // Genera un ID único tomando el mayor ID existente
    $nuevo_id = count($_SESSION['cart_items']) > 0
        ? max(array_column($_SESSION['cart_items'], 'id')) + 1
        : 1;

    $_SESSION['cart_items'][] = [
        'id'       => $nuevo_id,
        'nombre'   => $nombre,
        'tamano'   => $tamano,
        'cantidad' => $cantidad,
        'precio'   => $precio,
        'envio'    => 2.50,   
        'imagen'   => $imagen,
    ];
}

// Devuelve una respuesta JSON confirmando la operación
echo json_encode([
    'exito'           => true,
    'mensaje'         => "$cantidad x $nombre ($tamano) agregado al carrito",
    'total_articulos' => count($_SESSION['cart_items']) 
]);