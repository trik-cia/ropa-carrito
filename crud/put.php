<?php
header('Content-Type: application/json');
require_once '../db.php';

// Obtener el ID del producto
$id_producto = $_POST['id_producto'];

// Obtener la imagen actual de la base de datos
$sqlSelect = "SELECT imagen_producto FROM productos WHERE id_producto = ?";
$stmtSelect = $pdo->prepare($sqlSelect);
$stmtSelect->execute([$id_producto]);
$producto = $stmtSelect->fetch(PDO::FETCH_ASSOC);

// Mantener la imagen anterior por defecto
$nombreArchivo = $producto ? $producto['imagen_producto'] : "noimage.png";

// Si se sube una nueva imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $nombreOriginal = $_FILES['imagen']['name'];
    $tempPath = $_FILES['imagen']['tmp_name'];
    $ext = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

    //  Extensiones permitidas
    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($ext, $extensionesPermitidas)) {
        echo json_encode(["error" => "Extensión de archivo no permitida. Solo se aceptan: jpg, jpeg, png, gif"]);
        exit;
    }

    $nombreArchivo = uniqid('img_') . "." . $ext;
    $rutaDestino = __DIR__ . "/imgs/" . $nombreArchivo;

    if (!move_uploaded_file($tempPath, $rutaDestino)) {
        echo json_encode(["error" => "Error al guardar la imagen"]);
        exit;
    }
}

$sql = "UPDATE productos 
SET nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, 
    stock_producto = ?, descuento_producto = ?, categoria_id = ?, imagen_producto = ?
WHERE id_producto = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['nombre_producto'],
    $_POST['descripcion_producto'],
    $_POST['precio_producto'],
    $_POST['stock_producto'],
    $_POST['descuento_producto'],
    $_POST['categoria_id'],
    $nombreArchivo,
    $id_producto
]);

echo json_encode(["message" => "Producto actualizado correctamente"]);

?>
