<?php
session_start();
/* para ingresar al dashboard necesitamos con la confirmacion del session.php */
require 'session.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="bg-primary bg-gradient text-white d-flex justify-content-center align-items-center vh-100">

    <div class="container">
        <div class="card text-center p-4 mx-auto" style="max-width: 500 px;">
            <h2 class="mb-3">Bienvenido:<?php echo htmlspecialchars($_SESSION['usuario']['nick_usuario'])?></h2>

    <p><strong>Nombre Completo:</strong><?php echo htmlspecialchars($_SESSION['usuario']['nombre_completo_usuario'])?></p>
   
    <div class="mt-4 text-center">
             <a href="../carrito/index2.php" class="btn btn-primary">Tienda Virtual de ropa</a>
             <a href="logout.php" class="btn btn-success">Cerrar sesion</a>

    </div>

        </div>

    </div>
</body>
</html>
