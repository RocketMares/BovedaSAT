<?php

if (isset($_POST['cambios'])) {
    include_once 'ConsultaContribuyentes.php';
    $metodos = new ConsultaContribuyentes();
    $datos = $_POST['cambios'];
    $Emp_1 = $datos['id_empleado_1'];
    $Emp_2 = $datos['id_empleado_2'];
    $resultado = $metodos->Actualizar_cartera_cambios($Emp_1,$Emp_2);
    echo $resultado;
    //echo "LLegan las variables ".$Emp_1." y".$Emp_2;
}
if (isset($_POST['cambios_tik'])) {
    include_once 'ConsultaContribuyentes.php';
    include_once 'sesion.php';
    $metodos = new ConsultaContribuyentes();
    //Se instancian las variables mandadas por el script
    $datos = $_POST['cambios_tik'];
    //Se recorre el arreglo de datos
    $Nuevo_us = $datos['empleado_cambio'];
    $ticket = $_SESSION["tiket_cambio_pro"];
    //se mandan datos al metodo 
    $resultado = $metodos->Actualizar_propietario_ticket($Nuevo_us,$ticket);
    //echo $RFC_CORTO." Y ".$ticket;
    //Se visualiza resultado por medio de el script
    echo $resultado;
}