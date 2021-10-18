<?php
if (isset($_POST["array"])) {
    
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $busqueda = new ConsultaContribuyentes();
    $tiket = $_SESSION['tiket_estatus'];
     $motivo = $_POST['array'];
    $adicional = $busqueda->agrega_motivo_cancel($tiket,$motivo);
    $resultado = $busqueda->Cambiar_Estatus_Cancelado($tiket);
    echo $resultado;
}
else{
    echo"No hay datos coherentes";
}