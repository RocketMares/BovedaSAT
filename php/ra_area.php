<?php

if (isset($_POST["array"])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $Metodos =  new ConsultaContribuyentes();
    $datos = $_POST['array'];
    $id_admin = $datos['admin'];
    $nombre_sub_admin = $datos['nombre_sub'];

    $Metodos->Crear_Subadmin($id_admin,$nombre_sub_admin);
    if ($Metodos != true) {
        echo "<script> alert('Fallo la creacion de la subadministración.') </script>";
    }
    else {
        echo "<script> alert('Se creo la Subadministracíon satisfactoriamente.') </script>";
    }
       
}


?>