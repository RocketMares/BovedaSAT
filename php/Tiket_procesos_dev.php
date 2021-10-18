
<?php
if (isset($_POST['pet_dev_'])) {

    include_once 'ConsultaContribuyentes.php';
    include_once 'sesion.php';
    $busqueda = new ConsultaContribuyentes();
    $tiket = $_SESSION["tiket_estatus"];
    $resultado = $busqueda->Peticion_tiket_dev($tiket);
    echo $resultado; 

}
if (isset($_POST['prest_dev_int'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $busqueda = new ConsultaContribuyentes();
    $tiket = $_SESSION["tiket_estatus"];
    $resultado = $busqueda->Boveda_tiket_dev_interna($tiket);

     echo $resultado; 
   
}
if (isset($_POST['array'])) {

    include_once 'ConsultaContribuyentes.php';
    include_once 'sesion.php';
    $busqueda = new ConsultaContribuyentes();
    $datos = $_POST["array"];
    $tiket = $_SESSION["tiket_estatus"];
    $resultado = $busqueda->Estatus_Tiket_Procesos_dev_parc_completo($datos,$tiket);

     echo $resultado; 
   
}
if (isset($_POST['datos_cambio'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';

    $busqueda = new ConsultaContribuyentes();

    $datos = $_POST["datos_cambio"];
    $det = $datos['RDFDA'];
    $estatus = $datos['estatus'];
    $resultado = $busqueda->Cambia_estatus_det($det,$estatus);
    $busca_id_det = $busqueda->busca_id_det($det);
    $tiket= $_SESSION["tiket_estatus"];
    $historial = $busqueda->inserta_cambio_estatus($busca_id_det,$tiket,$estatus);
    echo  $resultado; 
   
}
if (isset($_POST['datos_cambio_visor'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $busqueda = new ConsultaContribuyentes();
    $datos = $_POST["datos_cambio_visor"];
    $det = $datos['RDFDA'];
    $estatus = $datos['estatus'];
    //echo "Estos son los datos que arroja ".$det." Y ".$estatus;
     $resultado = $busqueda->Cambia_estatus_det($det,$estatus);
     $busca_id_det = $busqueda->busca_id_det($det);
     //$tiket= $_SESSION["tiket_estatus"];
     $historial = $busqueda->inserta_cambio_estatus_visor($busca_id_det,$estatus);
     echo  $resultado; 
   
}
if (isset($_POST['ticket_cancel'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $motivo = $_POST['ticket_cancel'];
    $busqueda = new ConsultaContribuyentes();
    $tiket= $_SESSION["tiket_estatus"];
    $historial = $busqueda->cambia_estatus_ticket_cancelado($tiket,$motivo);
    echo  "exito!";
   
}
if (isset($_POST['ticket_cancel_notif'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $busqueda = new ConsultaContribuyentes();
    $tiket= $_SESSION["tiket_estatus"];
    $historial = $busqueda->cambia_estatus_ticket_cancelado($tiket);
    echo  $historial;
   
}
if (isset($_POST['ticket_aprueba'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';

    $busqueda = new ConsultaContribuyentes();
    $tiket= $_SESSION["tiket_estatus"];
    $historial = $busqueda->cambia_estatus_ticket_aprobado($tiket);
    echo  "Confirma peticion de salida exitosa!";
   
}
if (isset($_POST['ticket_Negado'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';

    $busqueda = new ConsultaContribuyentes();
    $tiket= $_SESSION["tiket_estatus"];
    $historial = $busqueda->Cambiar_Estatus_Cancelado($tiket);
    echo  "Nego la salida de los archivos satisfactoriamente!";
   
}
if (isset($_POST['datos_fojas'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $busqueda = new ConsultaContribuyentes();
    $datos = $_POST["datos_fojas"];
    $det = $datos['RDFDA'];
    $num_fojas = $datos['num_fojas'];
    $tiket= $_SESSION["tiket_estatus"];
    $busca_id_det = $busqueda->busca_id_det($det);
    $historial = $busqueda->inserta_cambio_fojas($busca_id_det,$tiket,$num_fojas);
    $resultado = $busqueda->Cambia_fojas_det($det,$num_fojas);
    echo  $resultado; 
   
}