<?php
session_start();
require_once '../db.php';

$buscar = $_GET['buscar']?? '';
if($buscar){
    $stmt = $pdo ->prepare("SELECT * FROM productos WHERE nombre_producto LIKE ?");
    $stmt ->execute (["%$buscar%"]);

}else{
    $stmt = $pdo ->query("SELECT * FROM productos");
}
$productos = $stmt ->fetchAll((PDO::FETCH_ASSOC));
if(!isset($_SESSION['carrito'])){
    $_SESSION['carrito'] = [];
}

//post
if($_SERVER['REQUEST_METHOD']== 'POST'){
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    $stmt = $pdo ->prepare("SELECT stock_producto FROM productos WHERE id_producto= ?");
    $stmt ->execute([$id_producto]);
    $producto = $stmt ->fetch();

    if($producto && $producto['stock_producto'] >=$cantidad){
        $_SESSION['carrito'][$id_producto] = ($_SESSION['carrito'][$id_producto] ?? 0) +$cantidad;
        header("Location: carrito.php");
        
    }else{
        echo "<script>alert('No hay suficientes stock disponible.')</script>";
    }
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
    <h1>Productos</h1>
    <form  method="get" class="mb-4">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar producto">
    </form>

    <div class="row">
        <?php foreach($productos as $producto): ?>
            <?php
            $precio_producto = $producto['precio_producto'];
            $descuento_producto = $producto['descuento_producto'];
            $precio_final= $precio_producto -($precio_producto*$descuento_producto/100);    
            ?>

            <div class="col-md-4">
                <form  method="post">
                    <div class="card mb-3">
                        <div class="card-body">
                           <div style="height: 200px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 8px; overflow: hidden;">
                            <img src="../crud/imgs/<?= $producto['imagen_producto'] ?>" 
                                alt="Imagen del producto" 
                                style="max-height: 100%; max-width: 100%; object-fit: contain;">
                            </div>
                            <p><?= $producto['descripcion_producto']?> </p>
                            <?php if ($descuento_producto >0): ?>
                                <p>
                                    <del>$<?= number_format($precio_producto, 2)?> </del>
                                    <strong class="text-success">$<?= number_format($precio_final, 2)?></strong>
                                    <span class="badge bg-success">-<?= $descuento_producto?>%</span>
                                </p>
                                <?php else:?>
                                    <p><strong>$<?= number_format($precio_producto, 2)?></strong></p>
                                    <?php endif; ?>
                                    <input type="hidden" name="id_producto" value="<?= $producto['id_producto']?>">
                                    <input type="number" id="stock_producto" name="cantidad" value="1" min="1" max="<?= $producto['stock_producto']?>" class="form-control mb-2">
                                    <button class="btn btn-primary">Agregar al carrito</button>
                        </div>
                    </div>
                </form>
            </div>

            <?php endforeach;?>
    </div>
    <a href="carrito.php" class="btn btn-success">Ver carrito</a>
    <a href="historial_pedido.php" class="btn btn-info">Ver historial</a>
    <a href="../iniciar-sesion/dashboard.php" class="btn btn-secondary">Volver a la pagina principal</a>
</body>
</html>