<?php

require_once '../db.php';
//recibes los datos del post registrar_usuario , en nuevas variables creadas
$nombre_completo_usuario = $_POST['nombre_completo_usuario'];
$correo_usuario = $_POST['correo_usuario'];
$nick_usuario = $_POST['nick_usuario'];
$password_usuario = password_hash($_POST['password_usuario'], PASSWORD_DEFAULT);

//validar el formato del correo
if (!filter_var($correo_usuario, FILTER_VALIDATE_EMAIL)) {
    die("El correo no es válido.");
}

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios(nombre_completo_usuario, correo_usuario, nick_usuario , password_usuario)
    VALUES(?,?,?,?)");
    $stmt ->execute([$nombre_completo_usuario, $correo_usuario, $nick_usuario, $password_usuario]);
//confirma el registro en el index con el regitro ok
    header("Location: ../iniciar-sesion/index1.php?registro=ok");
} catch (PDOException $e) {
    echo "Error al registrar: " .$e->getMessage();
}


?>