<?php


    if ($_FILES["archivito"]['error'] != 4) {
        include_once 'sesion.php';
        $id_user = $_SESSION["ses_id_usuario"];
        $foratos_permitidos =  array(".xlsx");
        $nombre_original = $_FILES['archivito']['name'];
        $nombre_temp_archivo = $_FILES['archivito']['tmp_name'];
        $path = "../temp_files/carga_nueva$id_user.xlsx";

        $ext_archivo = substr($nombre_original, strrpos($nombre_original, '.'));
        if(in_array($ext_archivo, $foratos_permitidos)){
            if (move_uploaded_file($nombre_temp_archivo, $path)) {
                //se cargo exitosamente el archivo en el servidor
                //esta listo para empezar a usarse.
                header("location:../Carga_m_Autoridad.php?resultado=1");
            }else{
                //El archivo es más pesado de lo permitido en el servidor (10 MB).
                header("location:../Carga_m_Autoridad.php?resultado=4");
            }

        }else{
        //el formato del documento no esta permitido.
            header('Location:../Carga_m_Autoridad.php?resultado=3');
             
        }
    }else{
        //no se selecciono ningun archivo
        header('Location:../Carga_m_Autoridad.php?resultado=2');
    }


    



?>