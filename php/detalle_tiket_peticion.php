
<?php
include_once 'ConsultaContribuyentes.php';
include_once 'conexion.php';
$conexion = new ConexionSQL();
$metodos = new ConsultaContribuyentes();
$con = $conexion->ObtenerConexionBD();

   if (isset($_POST['tiket'])) {
    include_once 'sesion.php';
    $tiket = $_POST['tiket'];
    $id_perfil = $_SESSION['ses_id_perfil'];
    $_SESSION["tiket_estatus"] = $_POST['tiket'];
    //$metodos->Estatus_busqueda($tiket);
    $query = "SELECT
    contri.rfc,
    tik.user_mov,
    tik.id_proc,
    case 
 WHEN (tik.Prioridad = 1) THEN 'URGENTE'
 ELSE 'NORMAL'
 END AS Prioridad
 ,
    Emp.nombre_empleado,
    det.num_determinante,
    etapa.fecha_alta,
    det.RDFDA,
    etapa.id_proc_det,
    det.fojas
    FROM Etapa_poc etapa
    INNER JOIN Determinante det ON det.id_determinante=etapa.id_determinante
    INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
    INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
    INNER JOIN Tikets tik ON etapa.id_tiket = tik.id_tiket
    INNER JOIN Empleado Emp ON TIk.user_mov = Emp.rfc_corto
    WHERE etapa.id_tiket=$tiket AND etapa.estatus = 'A'
    ";
    $resultado = sqlsrv_query($con, $query);
    $query2 = "SELECT Asunto,id_proc,        case 
    WHEN (Prioridad = 1) THEN 'URGENTE'
    ELSE 'NORMAL'
    END AS Prioridad
    FROM Tikets WHERE id_tiket=$tiket";
     $Asunto = sqlsrv_query($con, $query2);
    while ($TIK = sqlsrv_fetch_array($Asunto, SQLSRV_FETCH_ASSOC)) {
     $Tik1=$TIK['Asunto'];
     $prioridad= $TIK['Prioridad'];
     $estatus_tik = $TIK['id_proc'];
    }
    $salida = '';
    $salida .= "
     <br>
     <form method='post' name='form' id='form'>
      <a class='btn btn-info text-white  btn btn-secondary btn-block' data-toggle='tooltip' data-placement='right' title='Imprimir bolante' href='php/Crear_Bolante.php?id_tiket=$tiket' target='_blank'><i class='fas fa-envelope-open-text'></i></a>
      <div class='alert alert-primary' role='alert'>	
      Asunto: $Tik1
      </div>";
   

      $salida .= " <div class='alert alert-primary' role='alert'>	
              Prioridad: $prioridad
              </div>";      
   
              $salida .= "<table class='table table-striped text-center shadow p-1 bg-white rounded' aling='center '>
         
                <tr class='table-info table table-hover mb-0'>
                <td>
                <div class='letra1'><b>#</b>
               </td> ";
               
               if ($id_perfil == 8 && $estatus_tik != 11 || $id_perfil == 1 && $estatus_tik != 11 ) {
                    
                $salida .= " <td>
        <div class='letra1'><b>
            <input type='radio' name='todo' onClick='seleccionar_todo()' id='todo'></b>
        </td> ";
            
        }
        $salida .= "<td>
                        <div class='letra1'><b>RFC</b>
                    </td>
                    <td>
                        <div class='letra2'><b>Determinante</b>
                    </td>
                    <td>
                        <div class='letra1'><b>Fecha Petición</b>
                    </td>
                    <td>
                        <div class='letra2'><b>Estatus</b>
                    </td>
                    <td>
                    <div class='letra2'><b>Usuario</b>
                </td>
                <td>
                <div class='letra2'><b>Fojas</b>
            </td>
                </tr> 
                ";
$J= 1;
    while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
        $estatus = $fila['id_proc_det'];
        $estatus_tik = $fila['id_proc'];
        switch ($estatus) {
            case 11:
            $estatus = 'Disponible';
            $activo = 'disabled';
            $color = 'dark';
            break;
            case 2:
            $estatus = 'Solicitado';
            $activo = '';
            $color = 'primary';
            break;
            case 7:
            $estatus = 'Búsqueda';
            $activo = '';
            $color = 'primary';
            break;
        }
        $salida .= "
                        <tr class='text-center'> 
                        <td>".$J++."</td>";

                        if ($id_perfil == 8 && $estatus_tik != 11 || $id_perfil == 1 && $estatus_tik != 11 ) {
                            $estatus_1 =$fila['id_proc_det'];
                                if ($estatus_1   != 11) {
                                    $salida .= "  <td><input type='checkbox' name='checkbox[]' id='RDFDA' value= '".$fila['RDFDA']."' $activo></td>	";
                                }
                                else {
                                    $estatus_2 = $fila['id_proc'];
                                    if ($estatus_2 != 4) {
                                        $salida .= "  <td></td>	";
                                        
                                    }
                                    else{
                                        $salida .= "";
                                    }
                                }
                            
                        }
                        $salida .= " <td id='rfc' class='td'>".$fila['rfc']."</td>
                            <td>".$fila['num_determinante']."</td>
                            <td>".$fila['fecha_alta']->format('d/m/Y H:i' )."</td>
                            <td>".$estatus."</td>
                            <td>".$fila['nombre_empleado']."</td>
                            <td>
                            Núm. fojas: ".$fila['fojas']." ";
                            if ($fila['fojas'] != 0 ) {
                                $salida.="";
                            }
                            else {
                               $salida .= "<br> <button type='button' class='btn btn-$color' data-toggle='modal' onclick='Cambia_fojas(\"".$fila['RDFDA']."\")' $activo>Cambiar</button></td>";
                            }
                            
                            $salida .= " </tr>";
    }
    $salida .= '
           
                   
            </table><br>
            </form>
                                       

    </div>
</body>
</html>';
    echo $salida;
       //echo $tiket;
   }
   if (isset($_POST['tiket_prestamo'])) {
    $tiket = $_POST['tiket_prestamo'];
     include_once 'sesion.php';
    $_SESSION["tiket_obs"] = $_POST['tiket_prestamo'];
    $_SESSION["tiket_estatus"] = $_POST['tiket_prestamo'];
    $query = "SELECT
      contri.rfc,
      tik.user_prest,
      tik.user_mov,
      Emp.nombre_empleado,
      det.num_determinante,
      tik.fecha_prest,
      etapa.id_proc_det,
      etapa.id_etapa,
      det.RDFDA,
      etapa.id_tikeT,
      tik.Asunto
      FROM Etapa_poc etapa
      INNER JOIN Determinante det ON det.id_determinante=etapa.id_determinante
      INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
      INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
      INNER JOIN Tikets tik ON etapa.id_tiket = tik.id_tiket
      INNER JOIN Empleado Emp ON TIk.user_mov = Emp.rfc_corto
      WHERE etapa.id_tiket=$tiket AND etapa.id_proc_det=8 AND etapa.estatus = 'A'

 ";
 
 $query2 = "select Asunto from Tikets where id_tiket=$tiket";
    $resultado = sqlsrv_query($con, $query);
     $Asunto = sqlsrv_query($con, $query2);
    while ($TIK = sqlsrv_fetch_array($Asunto, SQLSRV_FETCH_ASSOC)) {
     $Tik1=$TIK['Asunto'];
    }

    $salida = '';
    $usuario_valida = $_SESSION['ses_rfc_corto'];
    $id_perfil = $_SESSION['ses_id_perfil'];
    $salida .= "
 
    <form method='post' name='form' id='form'>
    <div class='form-row'>
    

    </div>
    <div class='alert alert-primary' role='alert'>	
    Asunto: $Tik1
    </div>

         <table class='table table-striped text-center table-sm shadow p-1 bg-white rounded' aling='center'>
         
         <tr class='table-info table table-hover mb-0 text-center'>
         <td>
         <div class='letra1'><b>#</b></div>
        </td>

                
                 <td>
                     <div class='letra1'><b>RFC</b>
                 </td>
                 <td>
                     <div class='letra2'><b>Determinante</b>
                 </td>
                 <td>
                     <div class='letra1'><b>Fecha Petición</b>
                 </td>
                 <td>
                     <div class='letra2'><b>Estatus</b>
                 </td>
                 <td>
                 <div class='letra2'><b>Usuario</b>
             </td>
             <td>
             <div class='letra2'><b>Observación</b>
         </td>
             </tr>";
$J=1;
    while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
     $fecha_prestamo = ($fila["fecha_prest"] != null) ? $fila["fecha_prest"]->format('d/m/Y H:i') : null;
        $estatus = '';
        switch ($fila['id_proc_det']) {
             case 2:
             $estatus = 'Solicitado';
             break;
             case 7:
             $estatus = 'Busqueda';
             break;
             case 3:
             $estatus = 'Disponible';
             break;
             case 8:
             $estatus = 'Prestamo';
             break;

        }
       // <td><input type='checkbox' name='checkbox[]' id='RDFDA' value= '".$fila['RDFDA']."'/></td>	
        
        $usuario_ini = $fila['user_mov'];
        $salida .= "
        <tr class='text-center'>
        <td>".$J++."</td>
        <td id='rfc' class='td'>".$fila['rfc']."</td>
            <td>".$fila['num_determinante']."</td>
            <td>". $fecha_prestamo ."</td>
            <td>".$estatus."</td>
            <td>".$fila['nombre_empleado']."</td>
            <td>";
            if($_SESSION["ses_rfc_corto"] == $fila['user_mov'] )
            {  
               $salida .=" <i class='fas fa-comment-dots' onclick='agrega_observacion(\"".$fila['RDFDA']."\")'data-toggle='tooltip' data-placement='top' title='Agrega un comentario' ></i>";
               $salida .=" <i class='fas fa-eye' onclick='vista_comentarios(\"".$fila['id_etapa']."\")'data-toggle='tooltip' data-placement='top' title='Visualiza interaccion con el expediente' ></i>";
               $salida .=" <i class='fas fa-file-upload' onclick='Muestra_mod_integracion(\"".$fila['RDFDA']."\")'data-toggle='tooltip' data-placement='top' title='Integra documentacion'></i>";
               
            }
            
            
            else{
                $salida .="<i class='fas fa-eye' onclick='vista_comentarios(\"".$fila['id_etapa']."\")'data-toggle='tooltip' data-placement='top' title='Visualiza interaccion con el expediente'></i>";
            }
           
     
         $salida .="
            </td>
            </tr>"; 
    }

    $salida .= '

         
                 
         </table><br>
         </form>
                                     

 </div>
</body>
</html>';
    echo $salida;
    //echo $tiket;
}
if (isset($_POST['tiket_dispo_cancel'])) {
    $tiket = $_POST['tiket_dispo_cancel'];
     include_once 'sesion.php';
    // $_SESSION["tiket_obs"] = $_POST['tiket_dispo_cancel'];
    $_SESSION["tiket_estatus"] = $_POST['tiket_dispo_cancel'];
    $query = "SELECT
    contri.rfc,
    contri.razon_social,
    tik.user_prest,
    tik.user_mov,
    Emp.nombre_empleado,
    det.num_determinante,
    tik.fecha_prest,
    tik.fecha_cancel,
    etapa.id_proc_det,
    etapa.id_etapa,
    det.RDFDA,
    etapa.id_tikeT,
    tik.Asunto
    FROM Etapa_poc etapa
    INNER JOIN Determinante det ON det.id_determinante=etapa.id_determinante
    INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
    INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
    INNER JOIN Tikets tik ON etapa.id_tiket = tik.id_tiket
    INNER JOIN Empleado Emp ON TIk.user_mov = Emp.rfc_corto
    WHERE etapa.id_tiket=$tiket AND etapa.id_proc_det=12 AND etapa.estatus = 'A' 

 ";
 
 $query2 = "select Asunto from Tikets where id_tiket=$tiket";
    $resultado = sqlsrv_query($con, $query);
     $Asunto = sqlsrv_query($con, $query2);
    while ($TIK = sqlsrv_fetch_array($Asunto, SQLSRV_FETCH_ASSOC)) {
     $Tik1=$TIK['Asunto'];
    }

    $salida = '';
    $usuario_valida = $_SESSION['ses_rfc_corto'];
    $id_perfil = $_SESSION['ses_id_perfil'];
    $salida .= "
 
    <form method='post' name='form' id='form'>
    <div class='form-row'>
    

    </div>
    <div class='alert alert-primary' role='alert'>	
    Asunto: $Tik1
    </div>

         <table class='table table-striped text-center table-sm shadow p-1 bg-white rounded' aling='center'>
         
         <tr class='table-info table table-hover mb-0 text-center'>
         <td>
         <div class='letra1'><b>#</b></div>
        </td>
              
                 <td>
                     <div class='letra1'><b>RFC</b>
                 </td>
                 <td>
                     <div class='letra2'><b>Determinante</b>
                 </td>
                 <td>
                 <div class='letra1'><b>Razón social</b>
                </td>
                 <td>
                     <div class='letra1'><b>Fecha Petición</b>
                 </td>
                 <td>
                     <div class='letra2'><b>Estatus</b>
                 </td>
                 <td>
                 <div class='letra2'><b>Usuario</b>
             </td>
             </tr>";
$J=1;
    while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
     $fecha_prestamo = ($fila["fecha_cancel"] != null) ? $fila["fecha_cancel"]->format('d/m/Y H:i') : null;
        $estatus = '';
        switch ($fila['id_proc_det']) {
             case 2:
             $estatus = 'Solicitado';
             break;
             case 7:
             $estatus = 'Busqueda';
             break;
             case 3:
             $estatus = 'Disponible';
             break;
             case 8:
             $estatus = 'Prestamo';
             break;
             case 12:
                $estatus = 'Cancelado';
                break;

        }
       // <td><input type='checkbox' name='checkbox[]' id='RDFDA' value= '".$fila['RDFDA']."'/></td>	
        
        $usuario_ini = $fila['user_mov'];
        $salida .= "
        <tr class='text-center'>
        <td>".$J++."</td>
        <td id='rfc' class='td'>".$fila['rfc']."</td>
            <td>".$fila['num_determinante']."</td>
            <td>".$fila['razon_social']."</td>
            <td>". $fecha_prestamo ."</td>
            <td>".$estatus."</td>
            <td>".$fila['nombre_empleado']."</td>";
     
         $salida .="
            </td>
            </tr>"; 
    }

    $salida .= '

         
                 
         </table><br>
         </form>
                                     

 </div>
</body>
</html>';
    echo $salida;
    //echo $tiket;
}
if (isset($_POST['tiket_POR_APROBAR'])) {
    $tiket = $_POST['tiket_POR_APROBAR'];
     include_once 'sesion.php';
    // $_SESSION["tiket_obs"] = $_POST['tiket_dispo_cancel'];
    $_SESSION["tiket_estatus"] = $_POST['tiket_POR_APROBAR'];
    $query = "SELECT
    contri.rfc,
    contri.razon_social,
    tik.user_prest,
    tik.user_mov,
    case 
    WHEN (tik.Prioridad = 1) THEN 'URGENTE'
    ELSE 'NORMAL'
    END AS Prioridad
    ,
    Emp.nombre_empleado,
    det.num_determinante,
    etapa.fecha_alta,
    tik.fecha_prest,
    tik.fecha_cancel,
    etapa.id_proc_det,
    etapa.id_etapa,
    det.RDFDA,
    etapa.id_tikeT,
    tik.Asunto
    FROM Etapa_poc etapa
    INNER JOIN Determinante det ON det.id_determinante=etapa.id_determinante
    INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
    INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
    INNER JOIN Tikets tik ON etapa.id_tiket = tik.id_tiket
    INNER JOIN Empleado Emp ON TIk.user_mov = Emp.rfc_corto
    WHERE etapa.id_tiket=$tiket AND etapa.id_proc_det=2 AND etapa.estatus = 'A' 

 ";
 
 $query2 = "SELECT Asunto,  case 
 WHEN (Prioridad = 1) THEN 'URGENTE'
 ELSE 'NORMAL'
 END AS Prioridad from Tikets where id_tiket=$tiket";
    $resultado = sqlsrv_query($con, $query);
     $Asunto = sqlsrv_query($con, $query2);
    while ($TIK = sqlsrv_fetch_array($Asunto, SQLSRV_FETCH_ASSOC)) {
     $Tik1=$TIK['Asunto'];
     $prioridad= $TIK['Prioridad'];
    }

    $salida = '';
    $usuario_valida = $_SESSION['ses_rfc_corto'];
    $id_perfil = $_SESSION['ses_id_perfil'];
    $salida .= "
 
    <form method='post' name='form' id='form'>
    <div class='form-row'>
    

    </div>
    <div class='alert alert-primary' role='alert'>	
    Asunto: $Tik1
    </div>";
    $salida .= " <div class='alert alert-primary' role='alert'>	
                 Prioridad: $prioridad
                 </div>";      

    $salida .=" <table class='table table-striped text-center table-sm shadow p-1 bg-white rounded' aling='center'>
         
         <tr class='table-info table table-hover mb-0 text-center'>
         <td>
         <div class='letra1'><b>#</b></div>
        </td>
              
                 <td>
                     <div class='letra1'><b>RFC</b>
                 </td>
                 <td>
                     <div class='letra2'><b>Determinante</b>
                 </td>
                 <td>
                 <div class='letra1'><b>Razón social</b>
                </td>
                 <td>
                     <div class='letra1'><b>Fecha Petición</b>
                 </td>
                 <td>
                     <div class='letra2'><b>Estatus</b>
                 </td>
                 <td>
                 <div class='letra2'><b>Usuario</b>
             </td>
             </tr>";
$J=1;
    while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
     $fecha_prestamo = ($fila["fecha_alta"] != null) ? $fila["fecha_alta"]->format('d/m/Y H:i') : null;
        $estatus = '';
        switch ($fila['id_proc_det']) {
             case 2:
             $estatus = 'Solicitado';
             break;
             case 7:
             $estatus = 'Busqueda';
             break;
             case 3:
             $estatus = 'Disponible';
             break;
             case 8:
             $estatus = 'Prestamo';
             break;
             case 12:
                $estatus = 'Cancelado';
                break;

        }
       // <td><input type='checkbox' name='checkbox[]' id='RDFDA' value= '".$fila['RDFDA']."'/></td>	
        
        $usuario_ini = $fila['user_mov'];
        $salida .= "
        <tr class='text-center'>
        <td>".$J++."</td>
        <td id='rfc' class='td'>".$fila['rfc']."</td>
            <td>".$fila['num_determinante']."</td>
            <td>".$fila['razon_social']."</td>
            <td>". $fecha_prestamo ."</td>
            <td>".$estatus."</td>
            <td>".$fila['nombre_empleado']."</td>";
     
         $salida .="
            </td>
            </tr>"; 
    }

    $salida .= '

         
                 
         </table><br>
         </form>
                                     

 </div>
</body>
</html>';
    echo $salida;
    //echo $tiket;
}
if (isset($_POST['tiket_cancelado_notif'])) {
    $tiket = $_POST['tiket_cancelado_notif'];
     include_once 'sesion.php';
    // $_SESSION["tiket_obs"] = $_POST['tiket_dispo_cancel'];
    $_SESSION["tiket_estatus"] = $_POST['tiket_cancelado_notif'];
    $query = "SELECT
    contri.rfc,
    contri.razon_social,
    tik.user_prest,
    tik.user_mov,
    case 
    WHEN (tik.Prioridad = 1) THEN 'URGENTE'
    ELSE 'NORMAL'
    END AS Prioridad
    ,
    Emp.nombre_empleado,
    det.num_determinante,
    etapa.fecha_alta,
    tik.fecha_prest,
    tik.fecha_cancel,
    etapa.id_proc_det,
    etapa.id_etapa,
    det.RDFDA,
    etapa.id_tikeT,
    tik.Asunto
    FROM Etapa_poc etapa
    INNER JOIN Determinante det ON det.id_determinante=etapa.id_determinante
    INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
    INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
    INNER JOIN Tikets tik ON etapa.id_tiket = tik.id_tiket
    INNER JOIN Empleado Emp ON TIk.user_mov = Emp.rfc_corto
    WHERE etapa.id_tiket=$tiket and etapa.id_proc_det=12 AND etapa.estatus = 'A' 

 ";
 
 $query2 = "SELECT Asunto,  case 
 WHEN (Prioridad = 1) THEN 'URGENTE'
 ELSE 'NORMAL'
 END AS Prioridad from Tikets where id_tiket=$tiket";
    
     $Asunto = sqlsrv_query($con, $query2);
    while ($TIK = sqlsrv_fetch_array($Asunto, SQLSRV_FETCH_ASSOC)) {
     $Tik1=$TIK['Asunto'];
     $prioridad= $TIK['Prioridad'];
    }

    $salida = '';
    $usuario_valida = $_SESSION['ses_rfc_corto'];
    $id_perfil = $_SESSION['ses_id_perfil'];
    $salida .= "
 
    <form method='post' name='form' id='form'>
    <div class='form-row'>
    

    </div>
    <div class='alert alert-primary' role='alert'>	
    Asunto: $Tik1
    </div>";
    $salida .= " <div class='alert alert-primary' role='alert'>	
                 Prioridad: $prioridad
                 </div>";      

    $salida .=" <table class='table table-responsive table-striped text-center table-sm shadow p-1 bg-white rounded' aling='center'>
         
         <tr class='table-info table table-hover mb-0 text-center'>
         <td>
         <div class='letra1'><b>#</b></div>
        </td>
              
                 <td>
                     <div class='letra1'><b>RFC</b>
                 </td>
                 <td>
                     <div class='letra2'><b>Determinante</b>
                 </td>
                 <td>
                 <div class='letra1'><b>Razón social</b>
                </td>
                 <td>
                     <div class='letra1'><b>Fecha cancelación</b>
                 </td>
                 <td>
                     <div class='letra2'><b>Estatus</b>
                 </td>
                 <td>
                 <div class='letra2'><b>Usuario</b>
             </td>
             </tr>";
             $resultado = sqlsrv_query($con, $query);
$J=1;
    while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
    
        $fecha_prestamo = ($fila["fecha_cancel"] != null) ? $fila["fecha_cancel"]->format('d/m/Y H:i') : null;
        $estatus = '';
        switch ($fila['id_proc_det']) {
             case 2:
             $estatus = 'Solicitado';
             break;
             case 7:
             $estatus = 'Busqueda';
             break;
             case 3:
             $estatus = 'Disponible';
             break;
             case 8:
             $estatus = 'Prestamo';
             break;
             case 12:
                $estatus = 'Cancelado';
                break;

        }
       // <td><input type='checkbox' name='checkbox[]' id='RDFDA' value= '".$fila['RDFDA']."'/></td>	
        
        $usuario_ini = $fila['user_mov'];
        $salida .= "
        <tr class='text-center'>
        <td>".$J++."</td>
        <td id='rfc' class='td'>".$fila['rfc']."</td>
            <td>".$fila['num_determinante']."</td>
            <td>".$fila['razon_social']."</td>
            <td>". $fecha_prestamo ."</td>
            <td>".$estatus."</td>
            <td>".$fila['nombre_empleado']."</td>";
     
         $salida .="
            </td>
            </tr>"; 
    }

    $salida .= '

         
                 
         </table><br>
         </form>
                                     

 </div>
</body>
</html>';
    echo $salida;
    //echo $tiket;
}
//AQUI LLEGA LA SOLICITUD DE DETALLE DEL TIKET EN PROCESOS DE devolución 
if (isset($_POST['tiket_dev'])) {
    include_once 'sesion.php';
    include_once 'ConsultaContribuyentes.php';
    $metodos1 = new ConsultaContribuyentes();
    $_SESSION["tiket_estatus"] = $_POST['tiket_dev'];
    $id_perfil =  $_SESSION["ses_id_perfil"];
    $tiket = $_POST['tiket_dev'];
    $estatus_tik = $metodos1->Consulta_estatus_act_ticket($tiket);
    $query = " SELECT
    contri.rfc,
    tik.user_mov,
    tik.id_proc,
	Emp.nombre_empleado,
    det.num_determinante,
    etapa.fecha_alta,
    etapa.id_proc_det,
    det.RDFDA,
    etapa.id_tiket,
    etapa.id_etapa,
    det.estatus_cred as estatus_det
    FROM Etapa_poc etapa
    INNER JOIN Determinante det ON det.id_determinante=etapa.id_determinante
    INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
    INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
    INNER JOIN Tikets tik ON etapa.id_tiket = tik.id_tiket
	INNER JOIN Empleado Emp ON TIk.user_mov = Emp.rfc_corto
    WHERE etapa.id_tiket=$tiket AND (etapa.id_proc_det=4 OR etapa.id_proc_det=9 OR etapa.id_proc_det=5) AND etapa.estatus = 'A'
    ";
    $resultado = sqlsrv_query($con, $query);
    $query2 = "select Asunto from Tikets where id_tiket=$tiket";
    $resultado = sqlsrv_query($con, $query);
     $Asunto = sqlsrv_query($con, $query2);
    while ($TIK = sqlsrv_fetch_array($Asunto, SQLSRV_FETCH_ASSOC)) {
     $Tik1=$TIK['Asunto'];
    }

    $salida = '';

    $salida .= "
<br>
<form method='post' name='form' id='form'>";
if ($id_perfil == 8 && $estatus_tik != 4 || $id_perfil == 1 && $estatus_tik != 4 ) {
     $salida .= " <div class='form-row'>
             <input class='btn btn-secondary' type='reset' name='cancel' id='cancel' value='Desmarcar todos'/>
             </div>";      
     
}

$salida .= "<div class='alert alert-primary ' role='alert'>	
Asunto: $Tik1
</div>

            <table class='table table-sm table-striped text-center shadow p-1 bg-white rounded' aling='center'>
            
                <tr class='table-info table table-hover mb-0 text-center'>
                   <td>
                   <div class='letra1'><b>#</b></div>
                    </td>";
                    if ($id_perfil == 8 && $estatus_tik != 4 || $id_perfil == 1 && $estatus_tik != 4 ) {
                        
                            $salida .= " <td>
                    <div class='letra1'><b>
                        <input type='radio' name='todo' onClick='seleccionar_todo()' id='todo'></b>
					</td> ";
                        
                    }
                    $salida .= " <td>
                        <div class='letra1'><b>RFC</b>
                    </td>
                    <td>
                        <div class='letra2'><b>Determinante</b>
                    </td>
                    <td>
                        <div class='letra1'><b>Fecha Petición</b>
                    </td>
                    <td>
                        <div class='letra2'><b>Estatus</b>
                    </td>
                    <td>
                    <div class='letra2'><b>Estatus Determinante</b>
                    </td>
                    <td>
                    <div class='letra2'><b>Usuario</b>
                     </td>
                     <td>
                     <div class='letra2'><b>Comentarios</b>
                      </td>
                </tr> 
                ";
                $J= 1;
// SE RECORREN LOS DATOS PARA DAR FORMA A LA TALBA
    while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
        //SE VALIDA ESTATUS DEL DETERMINANTE
        $estatus = $fila['id_proc_det'];
        switch ($estatus) {
            case 4:
           
            $estatus = 'Devuelto';
            $activo = 'disabled';
            $icono = '';
            $accion = '';
            $icono2 = '';
            $accion2 = '';
            $color = 'dark';
            break;
            case 5:
            $estatus = 'Proceso de devolución';
            $activo = '';
            $icono = 'fas fa-comment';
            $accion =  "onclick='agrega_observacion_dev_1(\"".$fila['RDFDA']."\")'";
            $icono2 = 'fas fa-file-upload';
            $accion2 =  "onclick='Muestra_mod_integracion(\"".$fila['RDFDA']."\")'";
            $color = 'primary';
            break;
        }
        //SE VALIDA ESTATUS DEL DETERMINANTE PARA DAR OPCION A DARLO DE BAJA/REACTIVACION
        $estatus_det = $fila['estatus_det'];
        switch ($estatus_det) {
            case 'A':
            $estatus_det = "ACTIVO";
            $OPCION = "<option value='B'>BAJA</option>";
            break;
            case 'N':
            $estatus_det = "BAJA";
            $OPCION = "<option value='B'>ACTIVO</option>";
            break;
            case 'B':
            $estatus_det = "BAJA";
            $OPCION = "<option value='B'>ACTIVO</option>";
            break;
        }
        //SE RECORRE EL ARREGLO DE DATOS POR LAS CELDAS
        
        $salida .= "
        <tr class='text-center'>
        <td>".$J++."</td>";
        if ($id_perfil == 8 || $id_perfil == 1  ) {
            $estatus_1 =$fila['id_proc_det'];
                if ($estatus_1   != 4) {
                    $salida .= "  <td><input type='checkbox' name='checkbox[]' id='RDFDA' value= '".$fila['RDFDA']."' $activo></td>	";
                }
                else {
                    $estatus_2 = $fila['id_proc'];
                    if ($estatus_2 != 4) {
                        $salida .= "  <td></td>	";
                        
                    }
                    else{
                        $salida .= "";
                    }
                }
            
        }
        
        $salida .= " <td id='rfc' class='td'>".$fila['rfc']."</td>
            <td>".$fila['num_determinante']."</td>
            <td>".$fila['fecha_alta']->format('d/m/Y')."</td>
            <td>".$estatus."</td>
            <td> 
            $estatus_det";
            if($_SESSION["ses_id_perfil"] == 8 || $_SESSION["ses_id_perfil"] == 1)
            { 
            $salida .=" <button type='button' class='btn btn-$color' data-toggle='modal' onclick='Cambia_estatus(\"".$fila['RDFDA']."\")' $activo>Cambia</button>";
            }
            $salida .="
            
            </td>
            <td>".$fila['nombre_empleado']."</td>
            <td class='text-center align-content-center'>";

            if($_SESSION["ses_rfc_corto"] == $fila['user_mov'])
            { 
            $salida .="<i type='button' class='$icono' $accion data-toggle='tooltip' data-placement='top' title='Agrega un comentario'></i>";
            $salida .=" <i class='$icono2' $accion2 data-toggle='tooltip' data-placement='top' title='Integra documentacion'></i>";
            }        
            
            $salida .= " <i type='button' class='fas fa-eye' onclick='vista_comentarios_dev(\"".$fila['RDFDA']."\")' data-toggle='tooltip' data-placement='top' title='Visualiza interaccion con el expediente'></i>
            
            </td>
        </tr>";
    }

    $salida .= '

            
                    
            </table><br>
            </form>
                                        

    </div>
</body>
</html>';
    echo $salida;
    //echo $tiket;
}
if (isset($_POST['busqueda'])) {
    $bus = $_POST['busqueda'];

    $query = " SELECT 
    id_proc,
    id_determinante,
    RDFDA,
    rfc,
    razon_social,
    num_determinante,
	det.estatus_cred as estatus_det, 
    fecha_determinante,
    (SELECT nombre_autoridad FROM Autoridad WHERE id_autoridad=det.id_autoridad) AS autoridad
    FROM [Determinante] det
    INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
    INNER JOIN Contribuyente c ON c.id_contribuyente=expe.id_contribuyente
    
    WHERE
    num_determinante ='$bus' OR
    rfc ='$bus' OR
    razon_social like'%$bus%' OR
    rfc = '$bus' 
    ";
    $resultado = sqlsrv_query($con, $query);

    $salida = '';

    $salida .= "
<br>
<form method='post' name='form' id='form'>
<div class='form-row'>

<div class='form-group col-md-12' align='right'>	
    
</div>
</div>
            <table class='table table-striped text-center shadow p-1 bg-white rounded' aling='center'>
            
                <tr class='table-info table table-hover mb-0 text-center'>
                <td>
                <div class='letra1'><b>#</b></div>
               </td>
                    <td>
                        <div class='letra1'><b></b>
                    </td>
                    <td>
                        <div class='letra1'><b>RFC</b>
                    </td>
                    <td>
                    <div class='letra2'><b>Razón social</b>
                    </td>
                    <td>
                        <div class='letra2'><b>Determinante</b>
                    </td>
                    <td>
                        <div class='letra1'><b>Fecha Det.</b>
                    </td>
                    <td>
                        <div class='letra2'><b>Autoridad</b>
                    </td>
                    <td>
                        <div class='letra2'><b>Estatus Mov.</b>
                    </td>
                    <td>
                    <div class='letra2'><b>Estatus Det.</b>
                </td>
                </tr> 
                ";
    $J= 1;
    while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
        $estatus = '';
        switch ($fila['id_proc']) {
            case 1:
            $estatus = 'Carga';
            break;
            case 2:
            $estatus = 'Solicitud';
            break;
            case 3:
            $estatus = 'Disponible';
            break;
            case 11:
            $estatus = 'Disponible Boveda';
            break;
            case 4:
            $estatus = 'Devuelto';
            break;
            case 5:
            $estatus = 'Proceso de devolución';
            break;
            case 7:
            $estatus = 'Busqueda';
            break;
            case 9:
            $estatus = 'devolución Parcial';
            break;
            case 8:
            $estatus = 'Prestamo';
            break;
        }
       $estatus_det =  $fila['estatus_det'];
        switch ($estatus_det) {
            case 'A':
                $text = "ACTIVO";
                break;
            case 'N':
                $text = "BAJA";
                break;
            case 'B':
                $text = "BAJA";
                break;
        }
        $RDFDA = $fila['RDFDA'];
        $salida .= "
                        <tr class='text-center'>
                        <td>".$J++."</td>
                        <td>
                        <a class='btn btn-info text-white btn-block btn btn-secondary' data-toggle='tooltip' data-placement='right' title='detalle determinante' onclick='detalle_bus(\"$RDFDA\")'><i class='fas fa-search'></i></a>
                        </td>
                            <td>".$fila['rfc'].'</td>
                            <td>'.$fila['razon_social'].'</td>
                            <td>'.$fila['num_determinante'].'</td>
                            <td>'.$fila['fecha_determinante']->format('d/m/Y').'</td>
                            <td>'.$fila['autoridad'].'</td>
                            <td>'.$estatus.'</td>
                            <td>'.$text.'</td>
                            
                        </tr>';
    }

    $salida .= '

            
                    
            </table><br>
            </form>
                                        

    </div>
</body>
</html>';
    echo $salida;
    //echo $tiket;
}
if (isset($_POST['detalle_RDFDA'])) {
    $RDFDA = $_POST['detalle_RDFDA'];

     $query = "SELECT
     etapa.id_proc_det,
   tik.Asunto,
   case
   when (tik.motivo_cancel = 1) then 'PETICION POR PARTE DEL ANALISTA'
   when (tik.motivo_cancel = 2) then 'PETICION DEL JEFE O ENCARGADO'
   when (tik.motivo_cancel = 2) then 'NO SE ENCONTRO REGISTRO DE LA DETERMINANTE'
   END AS Motivo_cancel
   ,
    etapa.fojas,
    etapa.user_alta,
    etapa.user_valida,
    Emp2.nombre_empleado as Nom_mov,
    etapa.fecha_valida,
    etapa.fecha_alta,
    etapa.id_tiket,
    etapa.estatus_det_cam,
    Emp.nombre_empleado as nom_user_alta
     FROM Etapa_poc etapa
     LEFT JOIN Tikets tik ON tik.id_tiket = etapa.id_tiket
     INNER JOIN Determinante det ON det.id_determinante=etapa.id_determinante
     INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
     INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
     INNER JOIN Empleado Emp ON etapa.user_alta = Emp.rfc_corto
     LEFT JOIN Empleado Emp2 ON etapa.user_valida = Emp2.rfc_corto
      WHERE det.RDFDA='$RDFDA' ORDER BY fecha_alta DESC
     ";
    $resultado = sqlsrv_query($con, $query);
    $query2 = "SELECT distinct
    contri.rfc,
	(select nombre_empleado from Empleado where id_empleado = (select id_empleado from Determinante where RDFDA = '$RDFDA')) AS encargado,
	det.id_determinante,
	det.RDFDA,
    contri.razon_social,
    det.num_determinante,
    det.fecha_alta,
    det.fojas,
	(SELECT SUM(eta.fojas) FROM Etapa_poc eta where id_determinante = (select id_determinante from Determinante where RDFDA = '$RDFDA') and id_proc_det = 15 and estatus = 'A' ) integra_fojas,
    aut.nombre_autoridad,
    Emp.nombre_empleado
     FROM Determinante det
     INNER JOIN Autoridad aut on det.id_autoridad = aut.id_autoridad
     INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
	 left JOIN Etapa_poc eta ON eta.id_determinante=det.id_determinante
     INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
     INNER JOIN Empleado Emp ON det.user_alta = Emp.rfc_corto
    WHERE det.RDFDA='$RDFDA'
    ";

   $resultado2 = sqlsrv_query($con, $query2);
   while ($fila2 = sqlsrv_fetch_array($resultado2, SQLSRV_FETCH_ASSOC)) {
       $user_encargado = $fila2['encargado'];
       $Contri = $fila2['razon_social'];
       $rfc = $fila2['rfc'];
       $num_det = $fila2['num_determinante'];
       $fecha_carga = $fila2['fecha_alta']->format('d/m/Y H:i');
       $user_carga = $fila2['nombre_empleado'];
       $autoridad = $fila2['nombre_autoridad'];
       $fojas = $fila2['fojas'];
       $fojas_integra = $fila2['integra_fojas'];
       $fotas_totales = $fojas + $fojas_integra;

   }
   
    $salida = '';

    $salida .= "
    <ul class='nav nav-tabs' id='myTab' role='tablist'>
  <li class='nav-item'>
    <a class='nav-link active' id='home-tab' data-toggle='tab' href='#home' role='tab' aria-controls='home' aria-selected='true'>Detalle</a>
  </li>
  <li class='nav-item'>
    <a class='nav-link' id='profile-tab' data-toggle='tab' href='#profile' role='tab' aria-controls='profile' aria-selected='false'>Movimientos</a>
  </li>
  </ul>
  <div class='tab-content' id='myTabContent'>
  <div class='tab-pane fade show active' id='home' role='tabpanel' aria-labelledby='home-tab'>
  <div class='card' >
  <ul class='list-group list-group-flush'>

  <li class='list-group-item'><p class = 'font-weight-bold'> RFC del Contribuyente: $rfc </p></li>
    <li class='list-group-item'> <p class = 'font-weight-bold'> Nombre del Contribuyente:  $Contri </p></li>
    <li class='list-group-item'><p class = 'font-weight-bold'> Número de la determinante:  $num_det </p></li>
    <li class='list-group-item'><p class = 'font-weight-bold'> Número de fojas registradas:  $fotas_totales </p></li>
    <li class='list-group-item'> <p class = 'font-weight-bold'>Autoridad determinante:  $autoridad </p></li>
    <li class='list-group-item'><p class = 'font-weight-bold'>   Fecha de carga:  $fecha_carga </p></li>
    <li class='list-group-item'><p class = 'font-weight-bold'> Usuario encargado: $user_encargado </p></li>
    <li class='list-group-item'><p class = 'font-weight-bold'>   Usuario carga:  $user_carga </p></li>
  </ul>
</div>
</div>

  <div class='tab-pane fade' id='profile' role='tabpanel' aria-labelledby='profile-tab'>
  
  <br>
  <form method='post' name='form' id='form'>
  <div class='form-row'>
  <div class='form-group col-md-12' align='right'>	
      
  </div>
  </div>
              <table class='table table-sm text-center shadow p-1 bg-white rounded' aling='center'>
              
                  <tr class='table-info table table-hover mb-0 sticky-top'>
                      <td>
                          <div class='letra1'><b>No.</b></div>
                      </td>
                      <td>
                          <div class='letra1'><b>Proceso</b>
                      </td>
                      <td>
                          <div class='letra2'><b>Usuario</b>
                      </td>
                      <td>
                          <div class='letra1'><b>Fecha Movimiento</b>
                      </td>
                      <td>
                          <div class='letra2'><b>Ticket</b>
                      </td>
                      <td>
                      <div class='letra2'><b>Asunto</b>
                      </td>
                      
                     
                  </tr> 
                  ";
                  $conteo = 1;
      while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
       
          $estatus = $fila['id_proc_det'];
          switch ($estatus) {
              case 1:
              $estatus = 'Carga';
              break;
              case 2:
              $estatus = 'Solicitud';
              $user_mov = $fila['nom_user_alta'];
              $fecha = $fila['fecha_alta'] =! null ? $fila['fecha_alta']->format('d/m/Y H:i') : "";
              break;
              case 3:
              $estatus = 'Disponible';
              break;
              case 4:
              $estatus = 'Devuelto';
              $user_mov = $fila['Nom_mov'];
              $fecha = $fila['fecha_valida'] =! null ? $fila['fecha_valida']->format('d/m/Y H:i') : "";
              break;
              case 5:
              $estatus = 'Proceso de devolución';
              $user_mov = $fila['nom_user_alta'];
              $fecha = $fila['fecha_valida'] =! null ? $fila['fecha_valida']->format('d/m/Y H:i') : "";
              break;
              case 7:
              $estatus = 'Busqueda';
              $user_mov = $fila['Nom_mov'];
              $fecha = $fila['fecha_valida'] =! null ? $fila['fecha_valida']->format('d/m/Y H:i') : "";
              break;
              case 8:
              $estatus = 'Prestamo';
              $user_mov = $fila['Nom_mov'];
              $fecha = $fila['fecha_valida'] =! null ? $fila['fecha_valida']->format('d/m/Y H:i') : "";
              break;
              case 9:
              $estatus = 'devolución Parcial';
              $user_mov = $fila['Nom_mov'];
              $fecha = $fila['fecha_valida'] =! null ? $fila['fecha_valida']->format('d/m/Y H:i') : "";
              break;
              case 10:
              $estatus = 'Presolicitud';
              break;
              case 11:
              $estatus = 'Disponible Boveda';
              break;
              case 12:
              $user_mov = $fila['Nom_mov'];
              $fecha = $fila['fecha_valida'] =! null ? $fila['fecha_valida']->format('d/m/Y H:i') : "";
              $motivo_can = $fila['Motivo_cancel'];
              $estatus = 'Tiket Cancelado <br> Motivo: <br>'. $motivo_can;
              break;   
              case 13:
  
              if ($fila['estatus_det_cam'] === 'A') {
                  $estatus_det_cam = "Activa";
              }
              elseif ($fila['estatus_det_cam'] === NULL) {
                  $estatus_det_cam = "";
              }else {
                  $estatus_det_cam = "Baja";
              }
              
              $estatus = 'Cambio de estatus Determinante: '.$estatus_det_cam;
              break; 
              case 14:
              $user_mov = $fila['nom_user_alta'];
              $fecha = $fila['fecha_alta'] =! null ? $fila['fecha_alta']->format('d/m/Y H:i') : "";
              $motivo_can = $fila['fojas'];
              $estatus = 'Se agrega núm. de fojas: <br>'.$motivo_can.' fojas';
              break; 
                case 15:
                $user_mov = $fila['nom_user_alta'];
                $fecha = $fila['fecha_alta'] =! null ? $fila['fecha_alta']->format('d/m/Y H:i') : "";
                $motivo_can = $fila['fojas'];
                $estatus = 'Se integro documentación: <br>'.$motivo_can.' fojas';
                break;                                                                                                                                                                                                                                                                                
           }
  
          $salida .= "
                          <tr class = 'text-center'>
                              <td>".$conteo++."</td>
                              <td>$estatus </td>
                              <td>".$user_mov."</td>
                              <td>".$fecha."</td>
                              <td>".$fila['id_tiket']."</td>
                              <td>".$fila['Asunto']."</td> 
                          </tr>";
      }
  
      $salida .= "
  
              
                      
              </table><br>
              </form>
  </div>
                                        

    </div>
</body>
</html>";
    echo $salida;
    //echo $tiket;
}
if (isset($_POST['fojas_det'])) {
    $RDFDA = $_POST['fojas_det'];
    include_once 'sesion.php';
  $query = "SELECT
  fojas
  FROM Determinante
  WHERE RDFDA = '$RDFDA'";
$Insumo = sqlsrv_query($con,$query);
while($fila = sqlsrv_fetch_array($Insumo, SQLSRV_FETCH_ASSOC)){
$cuenta = $fila['fojas'];
}
    $salida = "

    <H1>Verifica y agrega el número de fojas por expediente.</h1>
    <p>Número de fojas registradas:  ".$cuenta."</p>
    <input type='text' class='form-control' id='fojas_num' placeholder='Núm. fojas Ejem: 520'onkeypress='return numero(event)' required >
    <button type='button' class='btn btn-block btn-primary ' onclick='Manda_registro_de_fojas(\"".$RDFDA."\")'>Registrar</button>
    </form>";

    echo $salida;

}
if (isset($_POST["datos_des"])) {
    include_once 'ConsultaContribuyentes.php';
    $contri = new ConsultaContribuyentes();
    $datos=$_POST["datos_des"];
   // $datos = json_decode($_POST["datos_des"]);
    $resultado = $contri->inserta_Observacion($datos);
    echo $resultado;
}
if (isset($_POST["datos_des_dev"])) {
    include_once 'ConsultaContribuyentes.php';
    $contri = new ConsultaContribuyentes();
    $datos=$_POST["datos_des_dev"];
   // $datos = json_decode($_POST["datos_des"]);
    $resultado = $contri->inserta_Observacion_dev($datos);
    echo $resultado;
}
if (isset($_POST['RDFDA_ob'])) 
{
    include_once 'sesion.php';
    $_SESSION["RDFDA_ob_clic"]=$_POST['RDFDA_ob'];

}
if (isset($_POST['RDFDA_ob_dev'])) 
{
    include_once 'sesion.php';
    $_SESSION["RDFDA_ob_clic_dev"]=$_POST['RDFDA_ob_dev'];

}



if (isset($_POST['RDFDA_observacion'])) {
    $RDFDA_observa = $_POST['RDFDA_observacion'];
     include_once 'sesion.php';

$query = "SELECT 
ob.user_alta,
emp.nombre_empleado,
ob.id_observacion,
ob.observacion,
ob.fecha_alta,
descrip.Descripcion,
etap.id_tiket
FROM Etapa_poc etap 
INNER JOIN Determinante det ON etap.id_determinante = det.id_determinante
INNER JOIN Observaciones ob ON det.id_determinante = ob.id_determinante
INNER JOIN Descripciones descrip ON ob.id_des = descrip.id_des
INNER JOIN Empleado emp ON emp.rfc_corto=ob.user_alta
WHERE det.id_determinante = (SELECT id_determinante  FROM  Etapa_poc WHERE id_etapa = $RDFDA_observa) AND etap.id_etapa = $RDFDA_observa AND ob.Tiket = (SELECT id_tiket FROM Etapa_poc WHERE id_etapa = $RDFDA_observa)
";
 $prepare = sqlsrv_query($con,$query);
    $salida = '';
  //  $usuario_valida = $_SESSION['ses_rfc_corto'];
    //$id_perfil = $_SESSION['ses_id_perfil'];
    $salida .= "

    <form method='post' name='form' id='form'>

         <table class='table table-striped text-center shadow p-1 bg-white rounded' aling='center'>
         
         <tr class='table-info table table-hover mb-0'>
         <td>
         <div class='letra1'><b>No.</b>
     </td>      
                 <td>
                     <div class='letra1'><b>Empleado</b>
                 </td>
                 <td>
                     <div class='letra1'><b>Observación</b>
                 </td>
                 <td>
                     <div class='letra1'><b>Fecha</b>
                 </td>
                 <td>
                     <div class='letra1'><b>Descripción</b>
                 </td>
             </tr>";
$contador=0;
    while ($fila = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
      $contador++;
        $salida .= "
                     <tr class='text-center'>
                         <td>".$contador."</td>
                         <td>".$fila['nombre_empleado']."</td>
                         <td WIDTH='300'>".$fila['observacion']."</td>
                         <td WIDTH='120'>".$fila['fecha_alta']->format('d/m/Y H:i')."</td>
                         <td WIDTH='300'>".$fila['Descripcion']."</td>";
                         
         $salida .="
                             </td>
                             </tr>"; 
    }

    $salida .= '

         
                 
         </table><br>
         </form>
 </div>
</body>
</html>';
    echo $salida;
    //echo $tiket;
}
if (isset($_POST['RDFDA_observacion_dev'])) {
    include_once 'sesion.php';
    $RDFDA_observa = $_POST['RDFDA_observacion_dev'];
    $tiket = $_SESSION['tiket_estatus'];
    $query = "SELECT 
            ob.user_alta,
            emp.nombre_empleado,
            ob.id_observacion,
            ob.observacion,
            ob.fecha_alta,
            descrip.Descripcion
            FROM Determinante det
            INNER JOIN Observaciones ob ON det.id_determinante = ob.id_determinante
            INNER JOIN Descripciones descrip ON ob.id_des = descrip.id_des
            INNER JOIN Empleado emp ON emp.rfc_corto=ob.user_alta
	WHERE det.RDFDA = '$RDFDA_observa' AND ob.Tiket = $tiket";
 
 $prepare = sqlsrv_query($con,$query);
    $salida = '';
  //  $usuario_valida = $_SESSION['ses_rfc_corto'];
    //$id_perfil = $_SESSION['ses_id_perfil'];
    $salida .= "

    <form method='post' name='form' id='form'>

         <table class='table table-striped text-center shadow p-1 bg-white rounded' aling='center'>
         
         <tr class='table-info table table-hover mb-0'>
         <td>
         <div class='letra1'><b>No.</b>
     </td>      
                 <td>
                     <div class='letra1'><b>Empleado</b>
                 </td>
                 <td>
                     <div class='letra1'><b>Observación</b>
                 </td>
                 <td>
                     <div class='letra1'><b>Fecha</b>
                 </td>
                 <td>
                     <div class='letra1'><b>Descripción</b>
                 </td>
             </tr>";
$contador=0;
    while ($fila = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
      $contador++;
        $salida .= "
                     <tr>
                         <td>".$contador."</td>
                         <td>".$fila['nombre_empleado']."</td>
                         <td WIDTH='300'>".$fila['observacion']."</td>
                         <td WIDTH='120'>".$fila['fecha_alta']->format('d/m/Y H:i')."</td>
                         <td WIDTH='300'>".$fila['Descripcion']."</td>";
                         
         $salida .="
                             </td>
                             </tr>"; 
    }

    $salida .= '

         
                 
         </table><br>
         </form>
                                     

 </div>
</body>
</html>';
    echo $salida;
    //echo $tiket;
}
if (isset($_POST['RDFDA_observacion_vis'])) {
    $RDFDA_observa = $_POST['RDFDA_observacion_vis'];
     include_once 'sesion.php';
      $tiket=$_SESSION["tiket_obs"];

    $query = "SELECT
    ob.user_alta,
    emp.nombre_empleado,
    ob.observacion,
    ob.fecha_alta,
    ob.Tiket,
    descrip.Descripcion,
    ob.Tiket
    FROM Observaciones ob 
    INNER JOIN Determinante det ON det.id_determinante = ob.id_determinante 
    INNER JOIN Descripciones descrip ON ob.id_des = descrip.id_des
    INNER JOIN Empleado emp ON emp.rfc_corto=ob.user_alta
     WHERE det.RDFDA = '$RDFDA_observa'";

 $Insumo = sqlsrv_query($con,$query);
    $salida = '';
  //  $usuario_valida = $_SESSION['ses_rfc_corto'];
    //$id_perfil = $_SESSION['ses_id_perfil'];
    $salida .= "
   
    <form method='post' name='form' id='form'>

         <table class='table table-striped text-center shadow p-1 bg-white rounded' aling='center'>
         
         <tr class='table-info table table-hover mb-0 text-center'>
         <td>
         <div class='letra1'><b>No.</b>
     </td>      
                 <td>
                     <div class='letra1'><b>Empleado</b>
                 </td>
                 <td>
                     <div class='letra1'><b>Observación</b>
                 </td>
                 <td>
                     <div class='letra1'><b>Fecha</b>
                 </td>
                 <td>
                     <div class='letra1'><b>Descripción</b>
                 </td>
                 <td>
                 <div class='letra1'><b>No. Ticket</b>
             </td>
             </tr>";
$contador=1;
    while ($fila = sqlsrv_fetch_array($Insumo, SQLSRV_FETCH_ASSOC)) {
        $salida .= "
                     <tr class='text-center'>
                         <td>".$contador++."</td>
                         <td>".$fila['nombre_empleado']."</td>
                         <td WIDTH='300'>".$fila['observacion']."</td>
                         <td WIDTH='120'>".$fila['fecha_alta']->format('d/m/Y H:i')."</td>
                         <td WIDTH='300'>".$fila['Descripcion']."</td>
                         <td WIDTH='300'>".$fila['Tiket']."</td>";
                         
         $salida .="
                             </td>
                             </tr>"; 
    }

    $salida .= "

         
                 
         </table><br>
         </form>";
         $id_perfil = $_SESSION['ses_id_perfil'];
        if ($id_perfil == 1 || $id_perfil == 8) {
            $salida.="<button type='button' class='btn btn-info' data-toggle='modal' onclick='Cambia_estatus_vis(\"".$RDFDA_observa."\")' >Cambia estatus del credito</button>";
        }               
        
         $salida.="</div>
</body>
</html>";
    echo $salida;
    //echo $tiket;
}
if (isset($_POST['estatus_det'])) {
    $RDFDA = $_POST['estatus_det'];


    $salida = "

    <H1>Baja y reactivación de creditos<h1>
    
<select class='custom-select text-center' id='Estatus_det_fin_tiket' name= 'Estatus_det_fin_tiket' >
  <option selected class='text-center'>Estatus</option>
        <option value='A'>ACTIVO</option>
        <option value='B'>BAJA</option>
</select>
    <button type='button' class='btn btn-block btn-primary ' onclick='Manda_estatus(\"".$RDFDA."\")'>Cambia estatus</button>
  
    </form>";

    echo $salida;

}
if (isset($_POST['estatus_det_visor'])) {
    $RDFDA = $_POST['estatus_det_visor'];


    $salida = "

    <H1>Baja y reactivación de creditos<h1>
    <form class='form-inline'>
    <select class='custom-select my-1 mr-sm-2' id='Estatus_det_fin_tiket_vis' name= 'Estatus_det_fin_tiket'>
        <option selected>Estatus</option>
        <option value='A'>ACTIVO</option>
        <option value='B'>BAJA</option>
    </select>

    </div>
    <div class = 'my-3 mt-3'>
    <button type='button' class='btn btn-primary' onclick='Manda_estatus_visor(\"".$RDFDA."\")'>Cambia estatus</button>
    </div>
    </form>";

    echo $salida;

}
if (isset($_POST['Cam_ticket'])) {
    $tiket = $_POST['Cam_ticket'];
    include_once 'sesion.php';
    $_SESSION["tiket_cambio_pro"] = $tiket;
    include_once 'ConsultaContribuyentes.php';
    include_once 'conexion.php';
    $conexion = new ConexionSQL();
    $metodos = new ConsultaContribuyentes();
    $con = $conexion->ObtenerConexionBD();
$query = "SELECT
emp.nombre_empleado 
,emp.rfc_corto
FROM Tikets tik
INNER JOIN Empleado emp ON emp.rfc_corto = tik.user_mov
WHERE id_tiket = $tiket AND tik.estatus = 'A'";

$prepare = sqlsrv_query($con,$query);
while ($fila = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
    $salida ="<div class='text-center mt-2 my-2'>
    <h3> Numero de Ticket: ".$tiket."</h3>
    </div>";

    $salida .="
    <table class='table shadow p-1 bg-white rounded'>
    <thead>
        <tr class='text-center'>
            <th scope='col'>Propietario actual</th>
            <th scope='col'>Nuevo propietario</th>
        </tr>
    </thead>
    <tbody>
        <tr class ='text-center' >
            <th scope='row'>".$fila['nombre_empleado']."</th>
            <th scope='row'>";

            $query="SELECT  DISTINCT * FROM Empleado emp 
            WHERE emp.estatus = 'A' Order By emp.nombre_empleado asc";
            $resultado = sqlsrv_query($con, $query);
            $salida .=" <input id='Cambio_empleado_ticket' list='nombres_lista' name='nombres_lista' type='text' style=' widith=40%;'>";
            $salida .="<datalist id='nombres_lista'>";
            while ($fila2 = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
            $salida .=" <option value='".$fila2['rfc_corto']."'>".$fila2['nombre_empleado']." </option>";
            }
            $salida .=" </datalist>
        </th>
        </tr>
    </tbody>
</table>";
}
echo $salida;

}

if (isset($_POST['Carrito'])) {
	$user = $_POST['Carrito'];
    include_once 'ConsultaContribuyentes.php';
    $metodos = new ConsultaContribuyentes();
    $datos_agregados = $metodos->Consulta_lista_carrito($user);
    if (isset($datos_agregados)) {
        $CUENTA = count($datos_agregados);
    }
    else {
        $CUENTA = 0;
    }
        echo  "
        <div class='form-group col-md-6'>
        <strong>Total de agregados:  ".$CUENTA."</strong>
        </div>
        <table class='table table-sm text-center shadow p-1 bg-white rounded'>
        <thead>
            <tr>
            <th scope='col'>#</th>
            <th scope='col'>RFC</th>
            <th scope='col'>Razón social</th>
            <th scope='col'>Número determinante</th>
            <th scope='col'>Autoridad</th>
            <th scope='col'>Ticket</th>
            </tr>
        </thead>
        <tbody>";
        $j = 1;
        if (isset($datos_agregados)) {
            for ($i=0; $i < count($datos_agregados) ; $i++) {
                echo"   
                <tr>
                <th scope='row'>".$j++."</th>
                <td>".$datos_agregados[$i]['rfc']."</td>
                <td>".$datos_agregados[$i]['razon_social']."</td>
                <td>".$datos_agregados[$i]['num_determinante']."</td>
                <td>".$datos_agregados[$i]['nombre_autoridad']."</td>
                <td>".$datos_agregados[$i]['id_tiket']."</td>
                </tr>";
            }
        } else {
           echo"   
        <tr>
        <th scope='row'>SN</th>
        <td>SN</td>
        <td>SN</td>
        <td>@SN</td>
        <td>SN</td>
        <td>@SN</td>
        </tr>";
        }
        
       echo" 
        </tbody>
        </table>
        ";
    
   

}
if (isset($_POST['Muestra_form'])) {
	$RDFDA = $_POST['Muestra_form'];
    $_SESSION["RDFDA"] = $RDFDA;
    $rd = $_SESSION['RDFDA'];
    include_once "ConsultaContribuyentes.php";
    $metodos = new ConsultaContribuyentes();
    $rows_Objeto = $metodos->Consulta_Objeto1();
   // <form  class=' text-justify text-dark' action='php/validar_Integracion.php' method='post' enctype='multipart/form-data'>
        echo  "  
        <form  class=' text-justify text-dark' method='post' enctype='multipart/form-data'>
        <label for='num_objeto'>Objeto <spam class='text-danger' >*</spam> </label>
        <select class='form-control' id='num_objeto1' name='num_objeto1'>
            <option value='0'>Seleccionar Objeto</option>";
            for ($i = 0; $i < count($rows_Objeto); $i++) { echo "<option value='" . $rows_Objeto[$i]["id_objeto"] . "'>" .
                $rows_Objeto[$i]["Objeto"] . "</option>" ; } echo"</select> <label for='inputState'>Situación <spam class='text-danger' >*</spam></label>
                <select class='form-control' id='id_situacion' name='id_situacion'>
                    <option value='0'>Seleccionar Situacion</option>
                </select>
    
    
                <label for='id_etapas_select'>Etapa <spam class='text-danger' >*</spam></label>
                <select class='form-control' id='id_etapas_select' name='id_etapas_select'>
                    <option value='0'>Seleccionar Etapa</option>
                </select>
    
    
                <label for='fecha_doc_inte'>Fecha del Documento/Oficio: <spam class='text-danger' >*</spam></label>
                <input type='text' class='form-control' id='fecha_doc_inte' name='fecha_doc_inte'>
    
                <div class= 'row'>
                <div class='form-row col-3'>
                    <div class='form-group col-md-9'>
                        <label for='fojas'>Fojas: <spam class='text-danger' >*</spam></label>
                        <input type='text' class='form-control' id='fojas' name='fojas' onkeypress='return numero(event)'>
                    </div>
                </div>
                <div class='form-group row'>
                <label class='mr-sm-2' for='inlineFormCustomSelect'>Tipo de documento a integrar <spam class='text-danger' >*</spam></label>
                <select class='custom-select mr-sm-2' id='tip_doc'>
                <option value='0' selected>Selecciona tipo de documento</option>
                <option value='1'>Original</option>
                <option value='2'>Copia certificada</option>
                <option value='3'>Copia foto-estatica</option>
                <option value='3'>Correo</option>
                <option value='4'>Captura de pantalla</option>
                </select>
                </div>
                </div>
                <label for='num_objeto'>Observaciones</label>
                <div class='col-sm-10 my-2'>
                    <textarea class='form-control' id='Obs' name='Obs' rows='3' placeholder='Observaciones'></textarea>
    
    
                <!--<div class='form-group row mt-3'>
                    <label for='inputEmail3' class='col-sm-2 col-form-label'> Archivo : <spam class='text-danger' >*</spam></label>
                    <div class='col-sm-10'>
                        <input type='file' class='form-control-file' id='archivo_int' name='archivo_int'
                            accept='.pdf,.zip,.doc,.xlsx'>
                    </div>
                </div>-->
                </div>
                <button type='button'  class='btn btn-primary' onclick='valida_formulario_inter_ticket(\"".$rd."\")'>Registra integración</button>
    </form>
<script type='text/javascript' src='js/libs/bootstrap-datepicker.min.js'></script>
<script src='js/libs/locales/bootstrap-datepicker.es.js' charset='UTF-8'></script>
<script src='js/libs/bootstrap-datepicker.js' charset='UTF-8'></script>
<link rel='stylesheet' href='css/libs/bootstrap-datepicker3.min.css'>
<script type='text/javascript'>

 $(document).ready(function() {
     
$(\"#num_objeto1\").change(function() {
  $(\"#num_objeto1 option:selected\").each(function() {
    id_obj = $(this).val();
    $.post(\"php/Obtener_Combos.php\", {
      id_obj: id_obj
    }, function(data) {
      $(\"#id_situacion\").html(data);
    })
  })
})

$(\"#id_situacion\").change(function() {
  $(\"#id_situacion option:selected\").each(function() {
    id_sit = $(this).val();
    id_obj=$(\"#num_objeto1\").val();
    datos ={
        id_sit:id_sit,
        id_obj:id_obj
    }
    $.post(\"php/Obtener_Combos.php\", {
      Etapa: datos
    }, function(data) {
      $(\"#id_etapas_select\").html(data);
    })
  })
})

$(\"#fecha_doc_inte\").datepicker({
    endDate: 'today',
    autoclose: true,
    todayHighlight: true,
    format: 'yyyy/mm/dd',
    toggleActive: true,
    language: 'es'
})


});



function valida_formulario_inter_ticket(RDFDA){
    if(
        $(\"#num_objeto1\").val() == 0
        || $(\"#id_situacion\").val() == 0
        || $(\"#id_etapas_select\").val() == 0
        || $(\"#fecha_doc_inte\").val() == ''
        || $(\"#fojas\").val() == ''
        || $(\"#tip_doc\").val() == 0){
        
            alert('No puedes dejar en blanco ningun dato que tenga el asterisco rojo.');
    
    }
    else{
        manda_datos_inter(RDFDA);
    }
}
function manda_datos_inter(RDFDA){
        var RDFDA = RDFDA;
        var num_objeto = $(\"#num_objeto1\").val();
        var id_situacion= $(\"#id_situacion\").val();
        var id_etapas_select= $(\"#id_etapas_select\").val();
        var fecha_doc_inte= $(\"#fecha_doc_inte\").val();
        var fojas= $(\"#fojas\").val();
        var tip_doc= $(\"#tip_doc\").val();
        var Obs= $(\"#Obs\").val();
        var datos = { RDFDA:RDFDA,
            num_objeto:num_objeto,
            id_situacion:id_situacion,
            id_etapas_select:id_etapas_select,
            fecha_doc_inte:fecha_doc_inte,
            fojas:fojas,
            tip_doc:tip_doc,
            Obs:Obs}
            var json = JSON.stringify(datos);
        $.post(\"php/validar_Integracion.php\",{integracion_tik:json},function(data){
            alert(data);
            //location.reload();
        });
    }
</script>

";
    
   

}
if (isset($_POST['caja_integ'])) {
    $u = $_POST['caja_integ'];
    include_once 'sesion.php';
     include_once 'ConsultaContribuyentes.php';
    $metodos = new ConsultaContribuyentes();
    $user = $_SESSION['ses_rfc_corto'];
    $datos = $metodos->Modal_registro_int($user);
     echo "
     Documentos por integrar a los siguientes expedientes:
 
     <table class='table table-sm table-responsive vh-50 text-center shadow p-1 bg-white rounded'>
     <thead>
         <tr class='text-center'>
         <th scope='col'>#</th>
             <th scope='col'>RFC</th>
             <th scope='col'>Núm. determinante</th>
             <th scope='col'>Objeto</th>
             <th scope='col'>Situación</th>
             <th scope='col'>Etapa</th>
             <th scope='col'>Tipo de Documento</th>
             <th scope='col'>Observación</th>
             <th scope='col'>fecha</th>
         </tr>
     </thead>
     <tbody>";
     $a= 1;
      if (isset($datos)) {
         for ($i=0; $i < count($datos) ; $i++) { 
             echo "
             <tr>
             <td>".$a++." <button type='button' class='  btn btn-outline-danger' data-toggle='tooltip' data-html='true' title='Cancelar integracion' onclick='Cancela_integracion(\"".$datos[$i]['id_Integracion']."\")'><i class= 'fas fa-trash'></i></button> </td>
             <td>".$datos[$i]['rfc']."</td>
             <td>".$datos[$i]['num_determinante']."</td>
             <td>".$datos[$i]['Objeto']."</td>
             <td>".$datos[$i]['Situacion']."</td>
             <td>".$datos[$i]['Etapa']."</td>
             <td>".$datos[$i]['tipo_doc_res']."</td>
             <td>".$datos[$i]['Observaciones']."</td>
             <td>".$datos[$i]['fecha_mov']->format('d/m/Y H:i')."</td>
             </tr>";
         }
      }
    else {
        echo "No tienes solicitudes pendientes de integración";
    }
    echo" </tbody>
 </table>
 </div>
 <div class='modal-footer'>
     <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>";
     if (isset($datos)) {
         echo"<button type='button' id='genera_ticket_integracion' class='btn btn-primary'>Generar integracion</button>";
     }
     
 echo"</div>
 <script>
 $(document).ready(function(){
    $(\"#genera_ticket_integracion\").on(\"click\",function(){
         $.post(\"php/validar_integracion.php\",{genera_tik_in:1},function(data){
            toastr.success(data,\"Notificación\",{
                \"progressBar\": true
            })
         })
         Muestra_integraciones_pendientes()
     })
})
 </script>
";

}
if (isset($_POST['caja_integ_pentienes_por_entregar'])) {
   include_once 'sesion.php';
     include_once 'ConsultaContribuyentes.php';
     $u = $_SESSION['ses_rfc_corto'];
    $metodos = new ConsultaContribuyentes();
    $datos = $metodos->Modal_tik_generados_pero_no_entregados($u);
     echo "
  
     <table class='table table-sm table-responsive vh-50 text-center shadow p-1 bg-white rounded'>
     <thead>
         <tr class='text-center'>
         <th scope='col'>#</th>
             <th scope='col'>Núm. Ticket</th>
             <th scope='col'>Proceso</th>
             <th scope='col'>Fecha alta</th>
             <th scope='col'>Fojas</th>
             <th scope='col'>Imprimir ticket</th>
             <th scope='col'>Acciones</th>
         </tr>
     </thead>
     <tbody>";
     $a= 1;
      if ($datos!= NULL) {
         for ($i=0; $i < count($datos) ; $i++) { 
             echo "
             <tr>
             <td>".$a++." </td>
             <td>  ".$datos[$i]['id_tiket_integra']."</td>
             <td>".$datos[$i]['nombre_proc_det']."</td>
             <td>".$datos[$i]['fecha_alta']->format('d/m/Y H:i')."</td>
             <td>".$datos[$i]['fojas']."</td>
             <td><a class='btn btn-outline-danger' data-toggle='tooltip' data-placement='right' title=' Imprimir ticket' href='php/Crear_bolante_integracion.php?id_tiket_integra=".$datos[$i]['id_tiket_integra']."'target='_blank'><i class= 'fas fa-file-pdf'></i></a></td>
             <td><a class='btn btn-dark text-white' data-toggle='tooltip' data-placement='right' title='Cancelar Ticket integracion' onclick='Cancela_tik_integracion(\"".$datos[$i]['id_tiket_integra']."\")'><i class= 'fas fa-trash'></i></a>
                 <a class='btn btn-success text-white' data-toggle='tooltip' data-placement='right' title='Notificar entrega para integracion' onclick='Pasar_envio_tik_integracion(\"".$datos[$i]['id_tiket_integra']."\")'><i class= 'fas fa-arrow-alt-circle-right'></i></a></td>
             </tr>";
         }
      }
    else {
        echo "No tiene tickets de integración pendientes por entregar";
    }
    echo" </tbody>
 </table>
 </div>
    <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
       
    </div>
";

}
if (isset($_POST['caja_integ_PROCESOS_entregar'])) {
    include_once 'sesion.php';
      include_once 'ConsultaContribuyentes.php';
      $user = $_SESSION['ses_rfc_corto'];
      $perfil= $_SESSION['ses_id_perfil'];
      $dep = $_SESSION['ses_id_depto'];
      $sub = $_SESSION['ses_id_sub_admin'];
      $admin = $_SESSION['ses_id_admin'];
     $metodos = new ConsultaContribuyentes();
     $datos = $metodos->Modal_tik_generados_procesos($user,$perfil,$dep,$sub,$admin);
      echo "
   
      <table class='table table-sm table-responsive vh-50 text-center shadow p-1 bg-white rounded'>
      <thead>
          <tr class='text-center'>
          <th scope='col'>#</th>
              <th scope='col'>Núm. Ticket</th>
              <th scope='col'>Fecha alta</th>
              <th scope='col'>Fojas</th>
              <th scope='col'>Imprimir ticket</th>
              <th scope='col'>Semaforo</th>
              <th scope='col'>Descripción</th>
              <th scope='col'>Acciones</th>
          </tr>
      </thead>
      <tbody>";
      $a= 1;
       if ($datos!= NULL) {
          for ($i=0; $i < count($datos) ; $i++) { 
              switch ($datos[$i]["id_proc"]) {
                case 19:
                $semaforo='spinner-grow text-danger' ;
                break;
                case 20:
                    $semaforo='spinner-grow text-warning' ;
                break;
                case 21:
                    $semaforo='spinner-grow text-success' ;
                break;
                case 22:
                $semaforo='spinner-grow text-dark' ;
                break;
              }
         
           
              echo "
              <tr>
              <td>".$a++." </td>
              <td>  ".$datos[$i]['id_tiket_integra']."</td>
              
              <td>".$datos[$i]['fecha_alta']->format('d/m/Y H:i')."</td>
              <td>".$datos[$i]['fojas']."</td>
              <td><a class='btn btn-outline-danger' data-toggle='tooltip' data-toggle='tooltip' data-placement='right' title=' Imprimir ticket' href='php/Crear_bolante_integracion.php?id_tiket_integra=".$datos[$i]['id_tiket_integra']."'target='_blank'><i class= 'fas fa-file-pdf'></i></a></td>
            <td>
            <div class='$semaforo' role='status'>
                <span class='sr-only'>Loading...</span>
            </div>
             </td>
             <td>".$datos[$i]['nombre_proc_det']."</td>
              <td><a  class='btn btn-outline-secondary' data-toggle='tooltip' data-html='true' data-toggle='tooltip' data-placement='right' title='Editar Cancelar integración' onclick='Cancela_tik_integracion(\"".$datos[$i]['id_tiket_integra']."\")'><i class= 'fas fa-trash'></i></a></td>
              </tr>";
          }
       }
     else {
         echo "No tiene tickets de integración en procesos de entrega o entregados";
     }
     echo" </tbody>
  </table>
  </div>
   </div>
     <div class='modal-footer'>
         <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
        
     </div>
 ";
 
 }
   ?>

