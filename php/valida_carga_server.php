<?php

    $nombre_archivo = $_FILES['archvioID']['name'];
    $tipo_archivo = $_FILES['archvioID']['type'];
    $tamano_archivo = $_FILES['archvioID']['size'];
    $Carpeta = "../Expedientes/";
        if (move_uploaded_file($_FILES['archvioID']['tmp_name'],$Carpeta.$nombre_archivo)){
                echo "El archivo ha sido cargado correctamente.";
        } else {
                echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
        }


