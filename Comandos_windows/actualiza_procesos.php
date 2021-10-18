<?php

include_once '../php/conexion.php';
$conexion = new ConexionSQL();
$con = $conexion->ObtenerConexionBD();
$query1 = "INSERT INTO Proceso
            (id_entrevista,id_estatus_proc,estatus,fecha_alta,user_alta)
            (SELECT 
            id_entrevista as id
            ,5 as estatus_pro
            ,'A' as estatus
            ,GETDATE() as fecha_alta
            ,'SERVIDOR' as user_alta  
            FROM Entrevista
            WHERE  GETDATE() BETWEEN plazo_10 and plazo_10+1
            AND estatus = 'A')";

$query2 = "INSERT INTO Proceso
            (id_entrevista,id_estatus_proc,estatus,fecha_alta,user_alta)
            (SELECT 
            id_entrevista as id
            ,6 as estatus_pro
            ,'A' as estatus
            ,GETDATE() as fecha_alta
            ,'SERVIDOR' as user_alta  
            FROM Entrevista
            WHERE GETDATE() BETWEEN plazo_30 and plazo_30+1
            AND estatus = 'A')";

$query3 = "INSERT INTO Proceso
            (id_entrevista,id_estatus_proc,estatus,fecha_alta,user_alta)
            (SELECT 
            id_entrevista as id
            ,26 as estatus_pro
            ,'A' as estatus
            ,GETDATE() as fecha_alta
            ,'SERVIDOR' as user_alta  
            FROM Entrevista
            WHERE GETDATE() > plazo_30+2
            AND estatus = 'A')";

$prepare1 = sqlsrv_query($con,$query1);
$prepare2 = sqlsrv_query($con,$query2);
$prepare3 = sqlsrv_query($con,$query3);

if ($prepare1 === false || $prepare1 === false || $prepare3) {
    echo  print_r(sqlsrv_errors(),true);
} else {
    echo "¡Actualización de procesos exitosa!";
}


