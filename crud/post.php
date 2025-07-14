<?php
header('Content-Type: application/json');
require_once '../db.php';

$nombreArchivo = null;

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $nombreOriginal = $_FILES['imagen']['name'];
    $tempPath = $_FILES['imagen']['tmp_name'];

    $ext = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
    $nombreArchivo = uniqid('img_') . "." . $ext; // nombre único

    $rutaDestino = __DIR__ . "/imgs/" . $nombreArchivo;

    if (!move_uploaded_file($tempPath, $rutaDestino)) {
        echo json_encode(["error" => "Error al guardar la imagen"]);
        exit;
    }
} else {
    $nombreArchivo = "noimage.png"; // O puedes dejar null si prefieres
}

$sql = "INSERT INTO productos 
(nombre_producto, descripcion_producto, precio_producto, stock_producto, descuento_producto, categoria_id, imagen_producto) 
VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['nombre_producto'],
    $_POST['descripcion_producto'],
    $_POST['precio_producto'],
    $_POST['stock_producto'],
    $_POST['descuento_producto'],
    $_POST['categoria_id'],
    $nombreArchivo
]);

echo json_encode(["message" => "Producto insertado correctamente"]);
