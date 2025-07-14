<?php
session_start();
require_once '../db.php'; //archivo conexión
require 'guardar_pedido.php';
require '../correo/correo_enviar.php';

$carrito = $_SESSION['carrito'] ?? [];

if (!$carrito) {
    die("Carrito vacío.");
}

$nombre_cliente = $_POST['nombre_cliente'];
$correo_cliente = $_POST['correo_cliente'];

// Guardamos el pedido
list($json_generado, $total) = guardarPedido($pdo, $nombre_cliente, $correo_cliente, $carrito);

// Preparamos el correo
$asunto = "Resumen de tu compra - Total: $" . number_format($total, 2);
// Enviamos el correo
$envio = enviarCorreo($correo_cliente, $asunto, $json_generado);

// 🔽 A partir de aquí va la parte visual
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen del pedido</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ✅ Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
if ($envio === true) {
    $_SESSION['carrito'] = [];

    echo '
    <div class="container mt-5 text-center">
        <div class="alert alert-success">
            <h4 class="alert-heading">¡Pedido realizado con éxito! 🎉</h4>
            <p>Resumen enviado al correo:</p>
            <p><strong>' . htmlspecialchars($correo_cliente) . '</strong></p>
        </div>

        <div class="card text-start mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h5 class="card-title">Resumen del pedido (JSON)</h5>
                <pre class="card-text bg-light p-3 rounded" style="white-space: pre-wrap;">' . htmlspecialchars($json_generado) . '</pre>
            </div>
        </div>

        <a href="index2.php" class="btn btn-primary mt-4">Volver al inicio</a>
    </div>
    ';
} else {
    echo '
    <div class="container mt-5 text-center">
        <div class="alert alert-warning">
            <h4 class="alert-heading">Pedido guardado, pero falló el envío del correo 😕</h4>
            <p>' . htmlspecialchars($envio) . '</p>
            <a href="index2.php" class="btn btn-secondary mt-3">Volver al inicio</a>
        </div>
    </div>
    ';
}
?>

</body>
</html>
