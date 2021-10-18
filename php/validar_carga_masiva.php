<?php

if (isset($_POST["constante"])) {
    if ($_POST["constante"] == 1) {
        include_once 'ConsultaContribuyentes.php';
        $contrib = new ConsultaContribuyentes();
        $contrib->Insertar_Autoridades();
    }elseif ($_POST["constante"] == 2) {
       include_once 'sesion.php';
       $id_user = $_SESSION["ses_id_usuario"];
       $ruta = "../temp_files/carga_nueva$id_user.xlsx";
       unlink($ruta);
       echo "Carga cancelada.";
    }

}
if (isset($_POST["USU"])) {
    if ($_POST["USU"] == 1) {
        include_once 'ConsultaContribuyentes.php';
        $contrib = new ConsultaContribuyentes();
        $contrib->Insertar_Usuarios();
    }elseif ($_POST["USU"] == 2) {
       include_once 'sesion.php';
       $id_user = $_SESSION["ses_id_usuario"];
       $ruta = "../temp_files/carga_nueva$id_user.xlsx";
       unlink($ruta);
       echo "Carga cancelada.";
    }

}
if (isset($_POST["det"])) {
    if ($_POST["det"] == 1) {
        include_once 'ConsultaContribuyentes.php';
        $contrib = new ConsultaContribuyentes();
        $contrib->Insertar_det();
    }elseif ($_POST["det"] == 2) {
       include_once 'sesion.php';
       $id_user = $_SESSION["ses_id_usuario"];
       $ruta = "../temp_files/carga_nueva$id_user.xlsx";
       unlink($ruta);
       echo "Carga cancelada.";
    }

}

?>