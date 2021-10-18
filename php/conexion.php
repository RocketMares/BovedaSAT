<?php

 class ConexionSQL
 {
     public function ObtenerConexionBD()
     {
        $BD_NAME = 'BovedaProyect';
        $USER = 'Analisis';
        $pass = 'Malitos20';
        //$ServerName = "DESKTOP-4Q2P8VT";
        //$ServerName = '99.85.26.227';
        $ServerName = '99.85.24.8';
        $connectionInfo = ['Database' => "$BD_NAME", 'CharacterSet' => 'UTF-8', 'UID' => "$USER", 'PWD' => "$pass"];
        //Se prepara la conexi�n
        $con = sqlsrv_connect($ServerName, $connectionInfo);
         //echo "<script>alert('entro a conexxion');</script>";
         return $con;
     }
     public function CerrarConexion($con)
     {
         sqlsrv_close($con);
     }
 }
