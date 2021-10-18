<?php


if (isset($_POST['Notif'])) {
    
    include_once 'conexion.php';
    $BD = new ConexionSQL();
    $con = $BD->ObtenerConexionBD();
    $user = $_SESSION['ses_rfc_corto'];
    $query = "SELECT COUNT(*) total FROM Integraciones where user_mov = '$user'  and id_tiket is null and id_tiket_integra is null ";
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
    // echo 'Se registro con exito la solicitud de integracion, revisa tu bandeja de integración!';


}

if (isset($_POST['notif'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $consulta_contr = new ConsultaContribuyentes();
    $dato_num = $consulta_contr->cuenta_integra();
    $num = $num_carrito_integra = $dato_num[0]['total_carrito'];
    $num2 =  $num_FAC_CREA = $dato_num[0]['total_fac_creadas'];
    $num3 = $num_integra_proc = $dato_num[0]['total_proc_entrega'];
    echo $num;
     
}

if (isset($_POST['borrar_integracion'])) {
    $id_inte = $_POST['borrar_integracion'];
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $consulta_contr = new ConsultaContribuyentes();
    $acction = $consulta_contr->borrar_integracion($id_inte);
    if ($acction == false) {
        echo "Ocurrio un erro ". $acction;
    } else {
        echo "Se cancelo la integracion seleccionada";
    }
}
if (isset($_POST['tik_integracion_PROC_envio'])) {
    $id_inte = $_POST['tik_integracion_PROC_envio'];
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $consulta_contr = new ConsultaContribuyentes();
    $acction = $consulta_contr->pasa_envio_proc_integracion($id_inte);
    echo $acction;
}


if (isset($_POST['borrar_tik_integracion'])) {
    $id_tik_inte = $_POST['borrar_tik_integracion'];
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $consulta_contr = new ConsultaContribuyentes();
    $acction = $consulta_contr->borrar_x_id_integracion($id_tik_inte);
    $acction2 = $consulta_contr->borrar_tiket_integracion($id_tik_inte);
    if ($acction) {
        if($acction2){
            echo "Se borro satisfactoriamente el ticket de integracion";
        }else {
            echo "Ocurrio un error ". $acction2;
        }
    } else {
        echo "Ocurrio un error ". $acction;
    }
}