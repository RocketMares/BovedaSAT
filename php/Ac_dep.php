<?php
if (isset($_POST["array2"])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $Metodos =  new ConsultaContribuyentes();
    $datos = $_POST["array2"];
    $admin = $datos["admin"];
    $sub_admin_asoc = $datos["sub"];
    $dep_asoc = $datos["dep_asoc"];
    $nombre_dep = $datos["nombre_dep"];
    $estatus = $datos["estatus"];
    $Metodos->Actualizar_datos_dep($admin,$sub_admin_asoc,$dep_asoc,$nombre_dep,$estatus);
    
        echo "Carga exitosa!";
    
}else {
    echo 'No inserto el dato en la base de datos';
}
