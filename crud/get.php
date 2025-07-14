<?php
header('Content-type: application/json');
require_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

$sql = "SELECT p.*, c.nombre_categoria 
        FROM productos p
        INNER JOIN categorias c ON p.categoria_id = c.id";

$conditions = [];
$params = [];

if (!empty($data->nombre_producto)) {
    $conditions[] = "p.nombre_producto LIKE ?";
    $params[] = "%" . $data->nombre_producto . "%";
}

if (!empty($data->descripcion_producto)) {
    $conditions[] = "p.descripcion_producto LIKE ?";
    $params[] = "%" . $data->descripcion_producto . "%";
}

if (!empty($data->categoria_id)) {
    $conditions[] = "p.categoria_id = ?";
    $params[] = $data->categoria_id;
}

// Si hay condiciones, las agregamos con WHERE
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($productos);
?>
