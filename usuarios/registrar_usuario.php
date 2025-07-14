<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Registro de usuarios</title>
</head>
<body class= "bg-primary bg-gradient text-white d-flex jusfify-content-center align-items-center vh-100">
    
    <div class="container">
        <div class="card mx-auto p-4" style="max-width: 400px;">
            <h2 class="text-center mb-4">Crear una cuenta</h2>

            <form action="guardar_usuario.php" method="POST">
        <div class="mb-3">
            <label for="nombre_completo_usuario">Nombre completo</label>
            <input type="text" name="nombre_completo_usuario" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="correo_usuario">Correo electronico</label>
            <input type="mail" name="correo_usuario" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nick_usuario">Nombre de usuario</label>
            <input type="text" name="nick_usuario" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_usario">Contraseña</label>
            <input type="password" name="password_usuario" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrarse</button>
    </form>

        </div>

    </div>

    
</body>
</html>