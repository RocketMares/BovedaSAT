<?php
if (isset($_POST["array2"])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $Metodos =  new ConsultaContribuyentes();
    $datos = $_POST["array2"];
    $admin = $datos["admin"];
    $sub_admin_asoc = $datos["sub_admin_asoc"];
    $nombre_sub = $datos["nombre_sub"];
    $estatus = $datos["estatus"];
    $resultado = $Metodos->Actualizar_datos_area($admin,$sub_admin_asoc,$nombre_sub,$estatus);
    if ($resultado == TRUE) {
        return 'Se actualizo satisfactoriamente la atuoridad';
    }else{
        return 'No se actualizo la atuoridad';
    }
   
    
}
if (isset($_POST['autoridad'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $Metodos =  new ConsultaContribuyentes();
    $datos = $_POST["autoridad"];
    $id_autoridad = $datos["id_autoridad"];
    $Nombre_autor = $datos["Nombre_autor"];
    $estatus = $datos["estatus"];
    $resultado = $Metodos->Actualizar_autoridad($id_autoridad,$Nombre_autor,$estatus);
    return $resultado;
}
if (isset($_POST['re_autoridad'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $Metodos =  new ConsultaContribuyentes();
    $datos = $_POST["re_autoridad"];
    $id_autoridad = $datos["num_aut"];
    $Nombre_autor = $datos["nombre_aut"];
    $resultado = $Metodos->Regis_autoridad($id_autoridad,$Nombre_autor);
    return $resultado;
}