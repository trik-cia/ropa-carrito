<?php
session_start();
require_once '../db.php';

$carrito = $_SESSION['carrito'] ?? [];
$productos = [];
$total = 0;

if($carrito){
    $ids = implode(',' , array_keys(($carrito)));
    $stmt = $pdo ->query ("SELECT * FROM productos WHERE id_producto IN ($ids)");
    $productos = $stmt ->fetchAll(PDO::FETCH_ASSOC);

    foreach ($productos as   &$producto){
        $cantidad = $carrito[$producto['id_producto']];
        $descuento_producto = $producto['descuento_producto'];
        $precio_final = $producto['precio_producto'] -($producto['precio_producto']*$descuento_producto/100);
        $subtotal = $cantidad * $precio_final;

        $producto['cantidad'] = $cantidad;
        $producto['precio_final'] = $precio_final;
        $producto['subtotal'] = $subtotal;
        $total += $subtotal;

    }
}


if($_SERVER['REQUEST_METHOD'] === 'POST'  && isset($_POST['id_producto'])){
    $_SESSION['carrito'][$_POST['id_producto']] = (int)$_POST['cantidad'];
header("Location: carrito.php");
}
if(isset($_GET['eliminar'])){
    //unset:borrala, isset :esta definida?
    unset($_SESSION['carrito'][$_GET['eliminar']]);
    header("Location: carrito.php");
}

if(isset($_GET['vaciar'])){
    unset($_SESSION['carrito']);
    header("Location: carrito.php");
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="container">
    <h1>Carrito de compras</h1>
    <a href="carrito.php?vaciar=1" class="btn btn-danger mb-3">Vaciar carrito</a>
    <table class="table table-bordered">
        <tr>
            <th>Productos</th>
            <th>Cantidad</th>
            <th>Precio final</th>
            <th>Sub total</th>
            <th>Acciones</th>
        </tr>
        <?php foreach($productos as $p): ?>
            <tr>
                <td><?= $p['nombre_producto']?></td>
                <td>
                    <form method="POST" action="carrito.php" class="form-actualizar">
                        <input type="number" name="cantidad" value="<?= $p['cantidad']?>" min="1">
                        <input type="hidden" name="id_producto" value="<?= $p['id_producto']?>">
                        <button class="btn btn-sm btn-warning">Actualizar</button>
                    </form>
                </td>

                <td>
                    <?php if($p['descuento_producto']>0):?>
                        <del>$<?= number_format($p['precio_producto'],2)?></del>
                        <strong>$<?= number_format($p['precio_final'], 2)?></strong>
                        <span class="badge bg-success">$<?= $p['descuento_producto']?></span>
                        <?php else:?>
                            $<?= number_format($p['precio_producto'], 2)?>
                        <?php endif; ?> 
                </td>
                <td>$ <?= number_format($p['subtotal'],2)?></td>
                
                <td><a href="carrito.php?eliminar=<?= $p['id_producto']?>" class="btn btn-sm btn-danger btn-eliminar">Eliminar</a></td>
            </tr>
            <?php endforeach; ?>
    </table>


    <p class="fs-4"><strong>Total: $<?= number_format($total, 2) ?></strong></p>

    <!-- form para finalizar compra nombre y correo  -->
    <form method="POST" action="procesar_pedido.php" class="mb-4">
    <div class="mb-3">
        <label for="nombre_cliente" class="form-label">Nombre completo</label>
        <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="correo_cliente" class="form-label">Correo electrónico</label>
        <input type="email" name="correo_cliente" id="correo_cliente" class="form-control" required>
    </div>
     
    <input type="hidden" name="total" value="<?= $total ?>">
    

    <button type="submit" class="btn btn-success">Finalizar compra</button>
</form>

    
    <a href="index2.php" class="btn btn-primary">Seguir comprando</a>
   
</body>
</html>




