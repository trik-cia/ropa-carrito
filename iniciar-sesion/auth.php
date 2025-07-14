<!-- verifica el index1.php si son los datos correctos de lo contrario los rechaza y no ingresa al dashboard -->

<?php
session_start();
require_once '../db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $input = trim($_POST['nick_usuario']);
    $password_usuario = $_POST['password_usuario'];
    $stmt = $pdo ->prepare("SELECT * FROM usuarios WHERE nick_usuario = :input OR  correo_usuario = :input");
    $stmt ->execute(['input' =>$input]);

    //si esto correcto la entrada al input entonces se almacenara en  $usuario
    $usuario = $stmt ->fetch();

    //validar el nombre de usuario/email y contraseña 
    if($usuario && password_verify($password_usuario,$usuario['password_usuario'])){
        //validar la sesion , vamos a pasar los parametros
        $_SESSION['usuario'] = [
            //llamas los campos q deseas usar en este caso para el dashboard
            'id_usuario' => $usuario['id_usuario'],
            'nick_usuario' => $usuario['nick_usuario'],  
            'nombre_completo_usuario' =>$usuario['nombre_completo_usuario'],
        ];

        //registrar log
        $stmt = $pdo ->prepare("INSERT INTO login_logs(usuario_id, ip_address, user_agent)
        VALUES(?,?,?)");

        $stmt ->execute([$usuario['id_usuario'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']]);

        header(("Location: dashboard.php"));
        exit;
    }else{
        $_SESSION['error'] = 'Credenciales incorrectas';
        //de no acceder correctamente se vuelve al inicio del login
        header(("Location: index1.php"));
    }

}

?>
