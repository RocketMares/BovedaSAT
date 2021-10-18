<?php

if (isset($_POST["id_usuario"])) {
    include_once 'MetodosUsuarios.php';
    $usuarios = new MetodosUsuarios();
    $id_usuario = $_POST["id_usuario"];
    $datos_user = $usuarios->Consulta_Datos_Usere($id_usuario);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($datos_user);
}
if (isset($_POST["auto_admin_name"])) {
    $id_admin = $_POST['auto_admin_name'];
    include_once 'MetodosUsuarios.php';
    $consulta = new MetodosUsuarios();
    $resultado = $consulta->Consulta_AUTO_Admin($id_admin);
    echo $resultado[0]['nombre_admin'];
    
  }
  if (isset($_POST["auto_admin_name_corto"])) {
    $id_admin = $_POST['auto_admin_name_corto'];
    include_once 'MetodosUsuarios.php';
    $consulta = new MetodosUsuarios();
    $resultado = $consulta->Consulta_AUTO_Admin($id_admin);
    echo $resultado[0]['nombre_corto'];
    
  }
  if (isset($_POST["auto_dep_name"])) {
    $id_sub = $_POST['auto_dep_name'];
    include_once 'MetodosUsuarios.php';
    $consulta = new MetodosUsuarios();
    $resultado = $consulta->Consulta_AUTO_dep($id_sub);
    echo $resultado[0]['nombre_depto'];
    
  }
  