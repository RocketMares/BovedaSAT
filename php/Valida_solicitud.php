<?php

if (isset($_POST["agrega"])) {

    //echo $_POST["array"];
    
    include_once 'ConsultaContribuyentes.php';
    $busqueda = new ConsultaContribuyentes();
    $datos = $_POST["agrega"];
    $resultado = $busqueda->Registrar_solicitud($datos);
   //$resultado="hola";
    echo $resultado;

   
}
if (isset($_POST["entrega"])) {

    //echo $_POST["entrega"];
    
    include_once 'ConsultaContribuyentes.php';
    $busqueda = new ConsultaContribuyentes();
    $datos = $_POST["entrega"];
    $resultado = $busqueda->Registrar_entrega($datos);
   //$resultado="hola";
    echo $resultado;

   
}
if (isset($_POST["cancela"])) {
    
    include_once 'ConsultaContribuyentes.php';
    $busqueda = new ConsultaContribuyentes();
    $datos = $_POST["cancela"];
    $resultado = $busqueda->Cancelacion_tiket();
   //$resultado="hola";
//    if (isset($resultado)) {
//        echo $resultado;
//    }
   
}
if (isset($_POST["pedir"])) {
    $datos=$_POST["pedir"];
    include_once 'ConsultaContribuyentes.php';
    $busqueda = new ConsultaContribuyentes();

    $resultado = $busqueda->pedir_tiket($datos);
    echo $resultado;   
}

if (isset($_POST["Objeto"])) {
    include_once 'sesion.php';
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $Objeto=$_POST['Objeto'];
    $_SESSION["List"]=$Objeto;
    $query = "select DISTINCT Situacion, id_situación from Situaciones where id_objeto='$Objeto'";
    $prepare = sqlsrv_query($con, $query);

    if ($prepare) {
        $cadena="<label>Selecciona la Situacion: </label> 
        <select id='lista2' name='lista2'>";
        while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        
            $cadena=$cadena.'<option value='.$row["id_situación"].'>'.$row["Situacion"].'</option>';
        }
        echo  $cadena."</select>";          
        }    
}
if (isset($_POST["Objeto2"])) {
    include_once 'sesion.php';
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $con = $conexion->ObtenerConexionBD();
    $Objeto=$_POST['Objeto2'];
    $Objeto1=$_SESSION["List"];
    $query = "select DISTINCT id_etapa,etapa from Situaciones where Id_situación=$Objeto and id_objeto=$Objeto1";
    $prepare = sqlsrv_query($con, $query);
echo  $Objeto1;
    // if ($prepare) {
    //     $cadena="<label>Selecciona la Etapa: </label> 
    //     <select id='lista3' name='lista3'>";
    //     while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
        
    //         $cadena=$cadena.'<option value='.$row["id_etapa"].'>'.$row["etapa"].'</option>';
    //     }
    //     echo  $cadena."</select>";          
    //     }    
}