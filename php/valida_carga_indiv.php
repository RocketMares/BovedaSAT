<?php

if (isset($_POST['data1'])) {
    $datos = json_decode($_POST['data1']);
    include_once 'ConsultaContribuyentes.php';
    $metodos = new ConsultaContribuyentes();
    $RFC = $datos->rfc;
    $det = $datos->det;
    $razon = $datos->razon;
    $aut = $datos->aut;
    $fec_det = $datos->fec_det;
    $emp = $datos->emp;
    $fec_inv = $datos->fec_inv;
    $estatus = $datos->estatus;
    echo idate('y', $fec_det);
    // echo $RFC."/".$det."/".$fec_det."/".$aut;
    // $valida1 = $metodos->Crear_Contri($RFC, $razon);
    // $valida2 = $metodos->crea_expedientes_indi($RFC, $razon, $det, $aut, $fec_det);
    // $valida3 = $metodos->crea_determinante_indiv($RFC, $razon, $det, $aut, $fec_det, $fec_inv, $estatus, $emp);
    // echo $valida2 ."<br>".$valida3;
}
if(isset($_POST['data'])){
    $datos = json_decode($_POST['data']);
 include_once 'ConsultaContribuyentes.php';
 $metodos = new ConsultaContribuyentes();
 $RFC = $datos->rfc;
 $det = $datos->det;
 $resol = $datos->resol;
 $razon = $datos->razon;
 $aut = $datos->aut;
 $fec_det = $datos->fec_det;
 $emp = $datos->emp;
 $fec_inv = $datos->fec_inv;
 $estatus = $datos->estatus;


 }