<?php
session_start();
if(isset($_GET['registro']) && $_GET['registro'] == 'ok'){
    echo "<div class='alert alert-success'>Registro exitoso, ahora puedes iniciar sesion</div>"; 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <title>Iniciar sesion</title>


  <!-- Estilos personalizados -->
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
      background-size: 400% 400%;
      background-position: center;
      animation: animarFondo 18s ease infinite;
      height: 100vh;
      color: white;
      font-family: sans-serif;
    }

    @keyframes animarFondo {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .contenido {
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 2rem;
    }
  </style>
</head>
<body>
    <div class="contenido">
        <div class="card p-4" style="max-width: 400px; background:rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 20px; box-shadow: 0 8px 32px rgba(0,0,0,0.2);">
            <div class="card-header">
                Iniciar Sesion
            </div>

            <div class="card-body">
                <!-- si $_SESSION no tiene vacio entonces alert -->
                <?php if(!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>

                    <?php endif; ?>

                    <form action="auth.php" method="POST">
                            <!-- ingresar usuario -->
                            <div class="mb-3">
                                <label for="nick_usuario" class="form-label">Usuario o email</label>
                                <input type="text" name="nick_usuario" class="form-control" required>
                            
                            </div>
                            <!-- ingresar contraseña -->
                            <div class="mb-3">
                                <label for="password_usuario" class="form-label">Contraseña</label>
                                <input type="password" name="password_usuario" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Entrar</button>

                    </form>

                    <div class="mt-3 text-center">
                    <a href="../usuarios/registrar_usuario.php" class="btn btn-success w-100">Registrarse</a>
                    </div>
            </div>
        </div>

    </div>
  



  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

