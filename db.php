<?php

$host = 'localhost';
$dbname= 'ropa_carrito_bd';
$user = 'root';
$password = '';
$charset = 'utf8';

$options = [
    PDO::ATTR_ERRMODE  =>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE  =>PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset",$user,$password,$options);
/*     echo "conexion exitosa"; */
} catch (PDOException $e) {
    echo "error:" . $e->getMessage();
    exit;
}

?>