<?php

if (isset($_POST['tiket'])) {
    $tiket = $_POST['tiket'];
    include_once 'ConsultaContribuyentes.php';
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $metodos = new ConsultaContribuyentes();
    $con = $conexion->ObtenerConexionBD();
    $resultado= $metodos->Estatus_busqueda($tiket);
    //echo $resultado;
}