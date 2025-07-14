<?php

function guardarPedido($pdo, $nombre_cliente, $correo_cliente, $carrito){ 
$total = 0;
$productos_json = [];

$ids = implode(',', array_keys($carrito));
$stmt = $pdo ->query("SELECT * FROM productos WHERE id_producto IN ($ids)");
$productos = $stmt ->fetchAll(PDO::FETCH_ASSOC);

foreach($productos as$producto){
    $cantidad = $carrito[$producto['id_producto']];
    $subtotal = $producto['precio_producto']*$cantidad;
    $total += $subtotal;

    $productos_json[]=[
        'producto' =>$producto['nombre_producto'],
        'precio_producto' =>$producto['precio_producto'],
        'cantidad' => $cantidad
    ];
}

$stmt = $pdo ->prepare("INSERT INTO pedidos_carrito (nombre_cliente, correo_cliente, total , estado_pedido) VALUES (?,?,?,?)");
$stmt ->execute([$nombre_cliente, $correo_cliente, $total, 'pendiente']);

$json = json_encode([
    'cliente' => $nombre_cliente,
    'correo' => $correo_cliente,
    'productos' =>$productos_json,
    'total' => $total
]);

file_put_contents('pedido.json', $json);
return[$json , $total];
}
?>