<?php

if (isset($_POST['datos_inter'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $met = new ConsultaContribuyentes();
    $user = $_SESSION['ses_rfc_corto'];
    $vis = $_POST['datos_inter'];
    $datos = json_decode($vis);
    if ($met->Inserta_integarcion_anim($datos)) {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        
        $query = "SELECT COUNT(*) total FROM Integraciones where user_mov = '$user'  and id_tiket is null and id_tiket_integra is null";
        $resultado = sqlsrv_query($con,$query);
        if ($resultado) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila = $row['total'];
                echo "La integracion se ha registrado correctamente,se ha agregado a su bandeja (".$filtro.")";
            }
        }
        else{
            echo "no hay resultados";
        }
    } else {
        echo "Has llegado al limite de integraciones";
        //header("location:../index.php?Integracion=5");
    }
    
}
if (isset($_POST['genera_tik_in'])) {
   include_once 'sesion.php';
   include_once 'ConsultaContribuyentes.php';
   include_once 'conexion.php';
   $met = new ConsultaContribuyentes();
   $user = $_SESSION['ses_rfc_corto'];
   $datos = $met->Datos_para_integrar($user);
   if (isset($datos)) {
        if($met->crear_ticket_integracion($datos)){
            if ($met->Agrupa_integraciones_sin_ticket_a_solicitud($user)) {
                echo "Exito al crear el ticket de integracion";
            }
            else {
                echo print_r(sqlsrv_errors(),false);
            }

        }else {
            echo print_r(sqlsrv_errors(),false);
        }   
   }
   else {
    echo "No hay integraciones peidntes por asignar a solicitud";
   }

}
if (isset($_POST['datos_inter_select'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $met = new ConsultaContribuyentes();
    $vis = $_POST['datos_inter_select'];
    $datos = json_decode($vis);
    if ($met->Inserta_integarcion_select($datos)) {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
        $query = "SELECT COUNT(*) total FROM Integraciones where user_mov = '$user'  and id_tiket is null and id_tiket_integra is null";
        $resultado = sqlsrv_query($con,$query);
        if ($resultado) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila = $row['total'];
                echo "La integracion se ha registrado correctamente,se ha agregado a su bandeja (".$fila.")";
            }
        }
        else{
            echo "no hay resultados";
        }
    } else {
        echo "Has llegado al limite de integraciones";
        //header("location:../index.php?Integracion=5");
    }
}


// if (isset($_POST["num_objeto"])) {
//     include_once 'sesion.php';
//     include_once 'ConsultaContribuyentes.php';
//     $integra = new ConsultaContribuyentes();
//     $RDFDA=$_SESSION["RDFDA"];
//     $USU= $_SESSION["ses_rfc_corto"];
//     $datos_int = array('id_Objeto'=>$_POST["num_objeto"],
//                         'id_situacion'=>$_POST["id_situacion"],
//                         'id_etapa'=>$_POST["id_etapas_select"],
//                         'fecha_doc_inte'=>$_POST["fecha_doc_inte"],
//                         'RDFDA'=>$RDFDA,
//                         'usuario'=>$USU,
//                         'Obs'=>$_POST["Obs"],
//                         'fojas'=>$_POST["fojas"],
//                         'tip_doc'=>$_POST["tip_doc"]
//                 );
//     //------------------------Sin Archivo--------------------

//     if($integra->Inserta_integarcion($datos_int)){
//         echo "Se Integro exitosamente el documento ....";
//         header("location:../Integracion.php?Integracion=1"); 
//     }
//     else {
//         echo "Error";
//         header("location:../Integracion.php?Integracion=5"); 
//     }
          

    //----------------------- Fin Sin Archivo----------------------

    //----------------------- Con Archivo---------------------------
        // if ($_FILES['archivo_int']['error'] != 4) {
        
        //     $Objeto =  $integra->Consulta_Objeto($datos_int["id_Objeto"]);
        //     $obj=$Objeto['objeto'];
        //     $id_=$integra->Consulta_DET();
        //     $id_det=$id_['id_determinante'];
        
        //     $path = "../pdf/";
        //     $nombre_original = $_FILES['archivo_int']['name'];
        //     $nombre_temp_archivo = $_FILES['archivo_int']['tmp_name'];
        //     $ext_archivo = substr($nombre_original, strrpos($nombre_original, '.'));
        //     $nombre_archivo = $id_det."_".$obj.$ext_archivo;
        //     $formatos = array(".xlsx",".pdf",".zip",".doc");
        //     if(in_array($ext_archivo, $formatos)){
        //         echo "Esta dentro de los valores permitidos.<br>";
        //         echo print_r($_FILES['archivo_int'],true);
        //         if (move_uploaded_file($nombre_temp_archivo, $path.$nombre_archivo)) {
        //           //  $Integracion->Inserta_integarcion($datos_int);
        //             echo "Se Integro exitosamente el documento ....";
        //             header("location:../Integracion.php?Integracion=1");
        //         }else{
        //             echo "No se pudo cargar el documento, el documento debe pesar igual o menos de 10 MB.";
        //             header("location:../Integracion.php?Integracion=2");
        //         }
        //     }else{
        //         echo "El archivo no se encuentra dentro de las extenciones aceptables. (xlsx,pdf,doc,zip)";
        //         header("location:../Integracion.php?Integracion=3");
        //     }
           
        // }else{
        //     echo "Sin Documento seleccionado";
        //     header("location:../Integracion.php?Integracion=4");
        //     echo "<br>";
        //     echo print_r($result,true);
      //  }
    //----------------------------------Fin Con Archivo
        //}
if (isset($_POST["integracion_tik"])) {
    //echo "Entra aqui";
     include_once 'sesion.php';
     include_once 'ConsultaContribuyentes.php';
     $integra = new ConsultaContribuyentes();
     $datos=$_POST['integracion_tik'];
     $datos_int = json_decode($datos);
     $tik=  $_SESSION["tiket_estatus"];
     $USU= $_SESSION["ses_rfc_corto"];
    if ($integra->Inserta_integarcion_en_tikets($datos_int,$tik)) {
        echo "Se Integro exitosamente el documento ....";
        //header("location:../index.php?Integracion=1");
    } else {
        echo "Error";
        //header("location:../index.php?Integracion=5");
    }

//      ------------------------Sin Archivo con metodo post agregado al formulario--------------------
    //    $RDFDA=$_SESSION["RDFDA"];
    //    $tik=  $_SESSION["tiket_estatus"];
    //    $USU= $_SESSION["ses_rfc_corto"];
    //    $datos_int = array('id_Objeto'=>$_POST["num_objeto1"],
    //                        'id_situacion'=>$_POST["id_situacion"],
    //                        'id_etapa'=>$_POST["id_etapas_select"],
    //                        'fecha_doc_inte'=>$_POST["fecha_doc_inte"],
    //                        'RDFDA'=>$RDFDA,
    //                        'usuario'=>$USU,
    //                        'Obs'=>$_POST["Obs"],
    //                        'fojas'=>$_POST["fojas"],
    //                );
    //    //------------------------Sin Archivo--------------------
    //    // $vis = json_encode($datos_int);
    //    // echo $vis;
    //     if ($integra->Inserta_integarcion_en_tikets($datos_int,$tik)) {
    //         echo "Se Integro exitosamente el documento ....";
    //         header("location:../index.php?Integracion=1");
    //     } else {
    //         echo "Error";
    //         header("location:../index.php?Integracion=5");
    //     }
    //----------------------- Fin Sin Archivo----------------------

    //----------------------- Con Archivo---------------------------
        //    $datos_int = array('RDFDA'=>$datos["RDFDA"],
    //        'id_Objeto'=>$datos["num_objeto"],
    //                        'id_situacion'=>$datos["id_situacion"],
    //                       'id_etapa'=>$datos["id_etapas_select"],
    //                        'fecha_doc_inte'=>$datos["fecha_doc_inte"],
    //                        'RDFDA'=>$datos,
    // //                       'usuario'=>$datos,
    // //                       'Obs'=>$datos["Obs"],
    // //                       'fojas'=>$datos["fojas"],
    // //                       'tip_doc'=>$datos["tip_doc"]
    // //               );
    //------------------------Sin Archivo--------------------
   // if ($integra->Inserta_integarcion_en_tikets($datos_int,$tik)) {
     //   echo "Se Integro exitosamente el documento ....";
        //header("location:../index.php?Integracion=1");
    //} else {
       // echo "Error";
        //header("location:../index.php?Integracion=5");
   //}
        // if ($_FILES['archivo_int']['error'] != 4) {
        
        //     $Objeto =  $integra->Consulta_Objeto($datos_int["id_Objeto"]);
        //     $obj=$Objeto['objeto'];
        //     $id_=$integra->Consulta_DET();
        //     $id_det=$id_['id_determinante'];
        
        //     $path = "../pdf/";
        //     $nombre_original = $_FILES['archivo_int']['name'];
        //     $nombre_temp_archivo = $_FILES['archivo_int']['tmp_name'];
        //     $ext_archivo = substr($nombre_original, strrpos($nombre_original, '.'));
        //     $nombre_archivo = $id_det."_".$obj.$ext_archivo;
        //     $formatos = array(".xlsx",".pdf",".zip",".doc");
        //     if(in_array($ext_archivo, $formatos)){
        //         echo "Esta dentro de los valores permitidos.<br>";
        //         echo print_r($_FILES['archivo_int'],true);
        //         if (move_uploaded_file($nombre_temp_archivo, $path.$nombre_archivo)) {
        //           //  $Integracion->Inserta_integarcion($datos_int);
        //             echo "Se Integro exitosamente el documento ....";
        //             header("location:../Integracion.php?Integracion=1");
        //         }else{
        //             echo "No se pudo cargar el documento, el documento debe pesar igual o menos de 10 MB.";
        //             header("location:../Integracion.php?Integracion=2");
        //         }
        //     }else{
        //         echo "El archivo no se encuentra dentro de las extenciones aceptables. (xlsx,pdf,doc,zip)";
        //         header("location:../Integracion.php?Integracion=3");
        //     }
           
        // }else{
        //     echo "Sin Documento seleccionado";
        //     header("location:../Integracion.php?Integracion=4");
        //     echo "<br>";
        //     echo print_r($result,true);
      //  }
    //----------------------------------Fin Con Archivo
}