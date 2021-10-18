<?php

if (isset($_POST['dato'])) {
    $dato = $_POST['dato'];
    include_once 'ConsultaContribuyentes.php';
    $metodos = new ConsultaContribuyentes();
    $datos = $metodos->Consulta_code_bar($dato);
    $proceso_activo_tiket = $datos[0]['id_proc'];
    $tiket = $datos[0]['id_tiket'];
    $accion = $metodos->Procesos_sig_code_bar($datos,$proceso_activo_tiket,$tiket);
    echo $accion;
}
if (isset($_POST['seleccion'])) {
    $dato = $_POST['seleccion'];
    include_once 'ConsultaContribuyentes.php';
    $metodos = new ConsultaContribuyentes();
    $datos = $metodos->Consulta_code_bar($dato);
    // $tiket = $datos[0]['id_tiket'];
    $agregar = $metodos->Procesos_seleccion_proc_prevent($datos);
    //$accion = $metodos->Procesos_sig_code_bar($datos,$proceso_activo_tiket,$tiket);
    echo $agregar;
}

if (isset($_POST['borrar_select'])) {
    include_once 'ConsultaContribuyentes.php';
    $metodos = new ConsultaContribuyentes();
    
    $agregar = $metodos->borarr_select();
    //$accion = $metodos->Procesos_sig_code_bar($datos,$proceso_activo_tiket,$tiket);
    //echo $agregar;
}