<?php
// Página de forma de pago - KavanaBread

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Si el usuario no está logueado, lo manda al login
if (!isset($_SESSION['id'])) {
    header("Location: iniciar-sesion.php");
    exit();
} 

// Conectar a la base de datos
include("config/db.php");

$mensaje = "";
$tipo_mensaje = "";

// Obtener los productos del carrito (igual que cart.php)
$cart_items = $_SESSION['cart_items'] ?? [];

// Si el carrito está vacío, regresar al carrito
if (empty($cart_items)) {
    header("Location: cart.php");
    exit();
}

// Calcular subtotal, tax y total desde los items del carrito
$subtotal = 0;
$shipping_total = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
    $shipping_total += $item['envio'] ?? 0;
}
$tax   = round($subtotal * 0.115, 2); // IVU 11.5% PR
$total = round($subtotal + $shipping_total + $tax, 2);

function crearOrdenDemo($conn, $user_id, $metodo, $subtotal, $tax, $total, $cart_items) {
    $conn->begin_transaction();

    try {
        $estado = "Completada";
        $stmt = $conn->prepare("INSERT INTO orders (user_id, payment_method, subtotal, tax, total, status) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("No se pudo preparar la orden.");
        }
        $stmt->bind_param("isddds", $user_id, $metodo, $subtotal, $tax, $total, $estado);
        if (!$stmt->execute()) {
            throw new Exception("No se pudo crear la orden.");
        }
        $order_id = $conn->insert_id;

        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_name, product_size, quantity, unit_price, shipping, line_total) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt_item) {
            throw new Exception("No se pudieron preparar los productos de la orden.");
        }

        foreach ($cart_items as $item) {
            $product_name = $item['nombre'];
            $product_size = $item['tamano'] ?? null;
            $quantity = (int) $item['cantidad'];
            $unit_price = (float) $item['precio'];
            $shipping = (float) ($item['envio'] ?? 0);
            $line_total = ($unit_price * $quantity) + $shipping;

            $stmt_item->bind_param("issiddd", $order_id, $product_name, $product_size, $quantity, $unit_price, $shipping, $line_total);
            if (!$stmt_item->execute()) {
                throw new Exception("No se pudo guardar un producto de la orden.");
            }
        }

        $conn->commit();
        return $order_id;
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }
}

// Procesar el formulario cuando el usuario presione Pagar
if (isset($_POST['btn-comprar'])) {
    $metodo = $_POST['metodo_pago'] ?? '';

    if ($metodo === 'tarjeta') {
        $numero  = preg_replace('/\s+/', '', $_POST['numero_tarjeta'] ?? '');
        $nombre  = htmlspecialchars(trim($_POST['nombre_tarjeta'] ?? ''));
        $fecha   = htmlspecialchars(trim($_POST['fecha_expiracion'] ?? ''));
        $cvv     = htmlspecialchars(trim($_POST['cvv'] ?? ''));
        $errores = [];

        if (!preg_match('/^\d{16}$/', $numero))
            $errores[] = "El número de tarjeta debe tener 16 dígitos.";
        if (strlen($nombre) < 3)
            $errores[] = "Ingresa el nombre del titular.";
        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $fecha))
            $errores[] = "La fecha debe tener formato MM/YY.";
        if (!preg_match('/^\d{3,4}$/', $cvv))
            $errores[] = "CVV inválido.";

        if (empty($errores)) {
            try {
                $order_id = crearOrdenDemo($conn, (int) $_SESSION['id'], $metodo, $subtotal, $tax, $total, $cart_items);
                // Vaciar el carrito después de compra exitosa
                $_SESSION['cart_items'] = [];
                $mensaje = "¡Compra realizada con éxito! Tu número de orden es #" . $order_id . ".";
                $tipo_mensaje = "exito";
                $cart_items = []; // Limpiar para que no muestre productos después
            } catch (Exception $e) {
                $mensaje = "No se pudo guardar la orden. Inténtalo de nuevo.";
                $tipo_mensaje = "error";
            }
        } else {
            $mensaje = implode("<br>", $errores);
            $tipo_mensaje = "error";
        }

    } elseif ($metodo === 'paypal' || $metodo === 'googlepay') {
        try {
            $order_id = crearOrdenDemo($conn, (int) $_SESSION['id'], $metodo, $subtotal, $tax, $total, $cart_items);
            // Demo: aquí iría la redirección real a PayPal / Google Pay.
            $_SESSION['cart_items'] = [];
            $mensaje = "¡Compra realizada con éxito! Tu número de orden es #" . $order_id . ".";
            $tipo_mensaje = "exito";
            $cart_items = [];
        } catch (Exception $e) {
            $mensaje = "No se pudo guardar la orden. Inténtalo de nuevo.";
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "Selecciona un método de pago.";
        $tipo_mensaje = "error";
    }
}

$metodo_seleccionado = $_POST['metodo_pago'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forma de Pago – Kavana Bread</title>

    <!-- Falta el CSS de forma de pago -->
    
</head>
<body>
 
    <!-- Navbar del proyecto -->
    <?php include 'navbar.php'; ?>
 
    <main>
        <h1>Seleccionar Forma de Pago</h1>
 
        <?php if (!empty($mensaje)): ?>
            <div class="msg <?= $tipo_mensaje ?>"><?= $mensaje ?></div>
        <?php endif; ?>
 
        <?php if ($tipo_mensaje !== 'exito'): ?>
        <form action="forma-de-pago.php" method="POST">
            <div class="pago-grid">
 
                <!-- Métodos de pago -->
                <div class="metodos">
 
                    <!-- PayPal -->
                    <label class="metodo-opcion">
                        <input type="radio" name="metodo_pago" value="paypal"
                            <?= $metodo_seleccionado === 'paypal' ? 'checked' : '' ?>>
                        PayPal
                    </label>

                    <!-- Google Pay -->
                    <label class="metodo-opcion">
                        <input type="radio" name="metodo_pago" value="googlepay"
                            <?= $metodo_seleccionado === 'googlepay' ? 'checked' : '' ?>>
                        Google Pay
                    </label>
 
                    <!-- Tarjeta -->
                    <label class="metodo-opcion">
                        <input type="radio" name="metodo_pago" value="tarjeta"
                            <?= $metodo_seleccionado === 'tarjeta' ? 'checked' : '' ?>>
                        Targeta de Crédito/Débito
                    </label>
 
                    <!-- Formulario de tarjeta -->
                    <div class="form-tarjeta">
                        <div>
                            <label>Número de Targeta</label>
                            <input type="text" name="numero_tarjeta"
                                   placeholder="1234123412341234" maxlength="16"
                                   value="<?= htmlspecialchars($_POST['numero_tarjeta'] ?? '') ?>">
                        </div>
                        <div>
                            <label>Nombre en Targeta</label>
                            <input type="text" name="nombre_tarjeta" placeholder="Card Name"
                                   value="<?= htmlspecialchars($_POST['nombre_tarjeta'] ?? '') ?>">
                        </div>
                        <div class="form-row-tarjeta">
                            <div>
                                <label>Fecha de Expiración</label>
                                <input type="text" name="fecha_expiracion"
                                       placeholder="MM/YY" maxlength="5"
                                       value="<?= htmlspecialchars($_POST['fecha_expiracion'] ?? '') ?>">
                            </div>
                            <div>
                                <label>CVV</label>
                                <input type="text" name="cvv" placeholder="CVV" maxlength="4"
                                       value="<?= htmlspecialchars($_POST['cvv'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
 
 
                </div>
 
                <!-- Carrito y resumen -->
                <div class="carrito-col">
 
                    <!-- Tu Carrito — viene de $_SESSION['cart_items'] igual que cart.php -->
                    <div class="carrito-box">
                        <h3>Tu Carrito (<?= count($cart_items) ?>)</h3>
                        <?php foreach ($cart_items as $item): ?>
                            <div class="carrito-item">
                                <div class="item-foto">
                                    <?php if (!empty($item['imagen']) && file_exists($item['imagen'])): ?>
                                        <img src="<?= htmlspecialchars($item['imagen']) ?>" alt="<?= htmlspecialchars($item['nombre']) ?>">
                                    <?php else: ?>
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5">
                                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <path d="m21 15-5-5L5 21"/>
                                        </svg>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div class="item-nombre"><?= htmlspecialchars($item['nombre']) ?></div>
                                    <div class="item-cantidad">x<?= (int)$item['cantidad'] ?></div>
                                    <div class="item-precio">$<?= number_format($item['precio'] * $item['cantidad'], 2) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
 
                    <!-- Resumen de Orden -->
                    <div class="resumen-box">
                        <h3>Resumen de Orden</h3>
                        <div class="resumen-fila">
                            <span>Subtotal:</span>
                            <span>$<?= number_format($subtotal, 2) ?></span>
                        </div>
                        <div class="resumen-fila">
                            <span>Tax (11.5%):</span>
                            <span>$<?= number_format($tax, 2) ?></span>
                        </div>
                        <div class="resumen-fila">
                            <span>Envío:</span>
                            <span>$<?= number_format($shipping_total, 2) ?></span>
                        </div>
                        <div class="resumen-fila total">
                            <span>Total:</span>
                            <span>$<?= number_format($total, 2) ?></span>
                        </div>
                    </div>
 
                </div>
            </div>
 
            <!-- Botones -->
            <div class="pago-botones">
                <a href="cart.php" class="btn-regresar">Regresar</a>
                <button type="submit" name="btn-comprar" class="btn-comprar">Comprar</button>
            </div>
 
        </form>
        <?php else: ?>
            <!-- Botón después de compra exitosa -->
            <div class="pago-botones">
                <a href="index.php" class="btn-comprar">Volver al inicio</a>
            </div>
        <?php endif; ?>
 
    </main>
 
</body>
</html>