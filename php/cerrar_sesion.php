<?php


  include_once 'ConsultaContribuyentes.php';
  $busqueda = new ConsultaContribuyentes();
  //$datos = $_POST["cancela"];
  $resultado = $busqueda->Cancelacion_tiket();
  $accion = $busqueda->bus_tiket_disponibles_por_caducar();
  $accion1 = $busqueda->bus_tiket_peticion_por_caducar();
  include_once 'sesion.php';
  if(session_destroy()){
    header('location:../login.php');
  }

?>