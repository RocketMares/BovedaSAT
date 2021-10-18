<?php

include_once '../php/conexion.php';
$conexion = new ConexionSQL();

$respaldo_com = $conexion->Crear_backup_comunicados();
echo $respaldo_com;

$respaldo_ent = $conexion->Crear_backup_entrevistas();
echo $respaldo_ent;