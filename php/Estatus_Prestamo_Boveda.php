<?php
if (isset($_POST["array"])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $busqueda = new ConsultaContribuyentes();
    $tiket = $_SESSION['tiket_estatus'];
    $resultado = $busqueda->Cambiar_Estatus_prestamo_tiket($tiket);
    echo $resultado;
}