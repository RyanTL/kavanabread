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

// Obtener los productos del carrito
$cart_items = $_SESSION['cart_items'] ?? [];

// Si el carrito está vacío, regresar al carrito
if (empty($cart_items)) {
    header("Location: cart.php");
    exit();
}

// Calcular subtotal, tax y total
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
        if (!$stmt) throw new Exception("No se pudo preparar la orden.");
        $stmt->bind_param("isddds", $user_id, $metodo, $subtotal, $tax, $total, $estado);
        if (!$stmt->execute()) throw new Exception("No se pudo crear la orden.");
        $order_id = $conn->insert_id;

        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_name, product_size, quantity, unit_price, shipping, line_total) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt_item) throw new Exception("No se pudieron preparar los productos de la orden.");

        foreach ($cart_items as $item) {
            $product_name = $item['nombre'];
            $product_size = $item['tamano'] ?? null;
            $quantity     = (int) $item['cantidad'];
            $unit_price   = (float) $item['precio'];
            $shipping     = (float) ($item['envio'] ?? 0);
            $line_total   = ($unit_price * $quantity) + $shipping;

            $stmt_item->bind_param("issiddd", $order_id, $product_name, $product_size, $quantity, $unit_price, $shipping, $line_total);
            if (!$stmt_item->execute()) throw new Exception("No se pudo guardar un producto de la orden.");
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
                $_SESSION['cart_items'] = [];
                $mensaje = "¡Compra realizada con éxito! Tu número de orden es #" . $order_id . ".";
                $tipo_mensaje = "exito";
                $cart_items = [];
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
    <script src="https://kit.fontawesome.com/bde2b79879.js" crossorigin="anonymous"></script>
    
    <script src="https://www.paypal.com/sdk/js?client-id=TU_CLIENT_ID&currency=USD"></script>
    <link rel="stylesheet" href="styles/forma-de-pago.css">
    <link rel="stylesheet" href="assets/css/navbar.css"/>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <?php
        $helpFile = "help-content/pago.html";
        include "help.php";
    ?>

    <main class="checkout-container">
        <h1 class="title">Seleccionar Forma de Pago</h1>
        <div class="content">

            <div class="left">

                <?php if (!empty($mensaje)): ?>
                    <div class="msg <?= $tipo_mensaje ?>"><?= $mensaje ?></div>
                <?php endif; ?>

                <?php if ($tipo_mensaje !== 'exito'): ?>

                
                <form action="forma-de-pago.php" method="POST">
                    <div class="pago-grid">
                        <div class="metodos">

                            <!-- PayPal -->
                            <label class="metodo-opcion">
                                <input type="radio" name="metodo_pago" value="paypal"
                                    <?= $metodo_seleccionado === 'paypal' ? 'checked' : '' ?>>
                                PayPal
                                <div class="metodo-contenido">
                                    <button class="paypal-demo-btn" type="button">
                                        <img src="https://www.paypalobjects.com/webstatic/icon/pp258.png" alt="PayPal">
                                        <span>Pagar con PayPal</span>
                                    </button>
                                    <p style="font-size:12px; color:gray; text-align:center; margin-top:4px;">
                                        Serás redirigido a PayPal para completar tu pago.
                                    </p>
                                </div>
                            </label>

                            <!-- Tarjeta -->
                            <label class="metodo-opcion">
                                <input type="radio" name="metodo_pago" value="tarjeta"
                                    <?= $metodo_seleccionado === 'tarjeta' ? 'checked' : '' ?>>
                                Targeta de Crédito/Débito
                                <div class="metodo-contenido">
                                    <div class="form-column-targeta">
                                        <label class="form-targeta-title">Número de Targeta</label>
                                        <input type="text" name="numero_tarjeta"
                                            placeholder="1234123412341234" maxlength="16"
                                            value="<?= htmlspecialchars($_POST['numero_tarjeta'] ?? '') ?>">
                                    </div>
                                    <div class="form-column-targeta">
                                        <label class="form-targeta-title">Nombre en Targeta</label>
                                        <input type="text" name="nombre_tarjeta" placeholder="Nombre en Targeta"
                                            value="<?= htmlspecialchars($_POST['nombre_tarjeta'] ?? '') ?>">
                                    </div>
                                    <div class="form-row-tarjeta">
                                        <div>
                                            <label class="form-targeta-title">Fecha de Expiración</label>
                                            <input type="text" name="fecha_expiracion"
                                                placeholder="MM/YY" maxlength="5"
                                                value="<?= htmlspecialchars($_POST['fecha_expiracion'] ?? '') ?>">
                                        </div>
                                        <div>
                                            <label class="form-targeta-title">CVV</label>
                                            <input type="text" name="cvv" placeholder="CVV" maxlength="4"
                                                value="<?= htmlspecialchars($_POST['cvv'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Google Pay -->
                            <label class="metodo-opcion">
                                <input type="radio" name="metodo_pago" value="googlepay"
                                    <?= $metodo_seleccionado === 'googlepay' ? 'checked' : '' ?>>
                                Google Pay
                                <div class="metodo-contenido">
                                    <button class="google-pay-btn" type="button">
                                        <img src="images/googlepay.png" alt="Google Pay">
                                        <span>Pagar con Google Pay</span>
                                    </button>
                                </div>
                            </label>

                        </div>
                    </div>

                    
                    <div class="pago-botones">
                        <a href="cart.php" class="btn-regresar">Regresar</a>
                        <button type="submit" name="btn-comprar" class="btn-comprar">Comprar</button>
                    </div>

                </form>

                <?php else: ?>
                    <div class="pago-botones">
                        <a href="index.php" class="btn-comprar">Volver al inicio</a>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Carrito y resumen -->
            <div class="right">
                <div class="carrito-col">
                    <div class="carrito-box">
                        <h2>Tu Carrito (<?= count($cart_items) ?>)</h2>
                        <div class="carrito-scroll-wrapper">
                            <div class="carrito-items-scroll">
                                <?php foreach ($cart_items as $item): ?>
                                    <div class="carrito-item">
                                        <div class="item-foto">
                                            <img src="<?= htmlspecialchars($item['imagen'] ?? '') ?>"
                                                alt="<?= htmlspecialchars($item['nombre']) ?>"
                                                onerror="this.onerror=null; this.src='images/default.png';">
                                        </div>
                                        <div class="item-info">
                                            <div class="item-nombre"><?= htmlspecialchars($item['nombre']) ?></div>
                                            <div class="item-cantidad">x<?= (int)$item['cantidad'] ?></div>
                                            <div class="item-precio">$<?= number_format($item['precio'] * $item['cantidad'], 2) ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="resumen-box">
                        <h2>Resumen de Orden</h2>
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
                        <div class="resumen-fila-total">
                            <span>Total:</span>
                            <span>$<?= number_format($total, 2) ?></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        // Mostrar/ocultar contenido del método seleccionado
        document.addEventListener("DOMContentLoaded", () => {
            const opciones = document.querySelectorAll('.metodo-opcion');

            function updateUI() {
                opciones.forEach(opcion => {
                    const radio = opcion.querySelector('input[type="radio"]');
                    if (radio.checked) {
                        opcion.classList.add('active');
                    } else {
                        opcion.classList.remove('active');
                    }
                });
            }

            document.querySelectorAll('input[name="metodo_pago"]').forEach(radio => {
                radio.addEventListener("change", updateUI);
            });

            updateUI();
        });

        // Fade scroll del carrito
        document.addEventListener("DOMContentLoaded", () => {
            const scrollBox = document.querySelector(".carrito-items-scroll");
            const wrapper   = document.querySelector(".carrito-scroll-wrapper");
            if (!scrollBox || !wrapper) return;

            function updateFade() {
                const scrollTop    = scrollBox.scrollTop;
                const scrollHeight = scrollBox.scrollHeight;
                const clientHeight = scrollBox.clientHeight;

                wrapper.classList.toggle("show-top",    scrollTop > 5);
                wrapper.classList.toggle("show-bottom", scrollTop + clientHeight < scrollHeight - 5);
            }

            scrollBox.addEventListener("scroll", updateFade);
            updateFade();
        });

        // PayPal Buttons
        
        document.addEventListener("DOMContentLoaded", () => {
            if (typeof paypal !== 'undefined') {
                paypal.Buttons({
                    style: { layout: 'vertical', color: 'gold', shape: 'rect', label: 'paypal' },
                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{ amount: { value: '<?= number_format($total, 2) ?>' } }]
                        });
                    },
                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function(details) {
                            alert('Pago completado por ' + details.payer.name.given_name);
                        });
                    }
                }).render('#paypal-button-container');
            }
        });
    </script>

</body>
</html>
