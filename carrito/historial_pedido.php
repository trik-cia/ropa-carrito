<?php

include '../db.php';

$stmt = $pdo ->query("SELECT * FROM pedidos_carrito ORDER BY fecha_pedido DESC");
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="table container">
    <h1>Historial de pedidos</h1>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Correo</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Fecha</th>
        </tr>
            <?php foreach($pedidos as $p):?>
                <tr>
                    <td><?=$p['id_pedido']?></td>
                    <td><?=$p['nombre_cliente']?></td>
                    <td><?=$p['correo_cliente']?></td>
                    <td><?=$p['total']?></td>
                    <td><?=$p['estado_pedido']?></td>
                    <td><?=$p['fecha_pedido']?></td>
                    
                </tr>
        <?php endforeach;?>

    </table>
    <a href="index2.php" class="btn btn-primary">Volver al inicio</a>
</body>
</html>