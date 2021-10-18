<?php

if (isset($_POST['aviso'])) {
    include_once "ConsultaContribuyentes.php";
    include_once "sesion.php";
    $metodos = new ConsultaContribuyentes();
    $user= $_SESSION['ses_rfc_corto'];
    $accion = $metodos->Carga_rfcs_nuevos_cargas_diarias($user);
    echo $accion; 
}
if (isset($_POST['aviso2'])) {
    include_once "ConsultaContribuyentes.php";
    include_once "sesion.php";
    $metodos = new ConsultaContribuyentes();
    $user= $_SESSION['ses_rfc_corto'];
    $accion = $metodos->Carga_expedientes_nuevos($user);
    echo $accion; 
}

if (isset($_POST['aviso3'])) {
    include_once "ConsultaContribuyentes.php";
    include_once "sesion.php";
    $metodos = new ConsultaContribuyentes();
    $user= $_SESSION['ses_rfc_corto'];
    $accion = $metodos->Carga_rfcs_nuevos_cargas_diarias_masiv($user);
    echo $accion; 
}
if (isset($_POST['aviso4'])) {
    include_once "ConsultaContribuyentes.php";
    include_once "sesion.php";
    $metodos = new ConsultaContribuyentes();
    $user= $_SESSION['ses_rfc_corto'];
    $accion = $metodos->Carga_expedientes_nuevos_masvi($user);
    echo $accion; 
}