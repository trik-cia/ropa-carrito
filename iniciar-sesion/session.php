<!-- validamos q verdaderamente hayamos iniciado sesion -->

<?php

//si estado session actual es igual a que no se ha iniciado sesion php entonces solo ejecuta 
//solo ejecuta sesion_star si aun no esta activa
/* si aun no has iniciado sesion entonces iniciala */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['usuario'])){
    header("Location: index1.php");
    exit;
}

?>