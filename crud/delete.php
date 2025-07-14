<?php

header('Content-Type: application/json');
require_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

$sql = "DELETE FROM productos WHERE id_producto = ?";

$stmt = $pdo->prepare($sql);
$stmt ->execute([$data ->id]);

echo json_encode(["message" => "Producto eliminado correctamente"]);

?>