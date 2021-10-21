<?php

class ConsultaContribuyentes
{   
    public function Modal_tik_generados_pero_no_entregados($user){
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "SELECT 
        tik_in.id_tiket_integra,
        emp.nombre_empleado,
        tik_in.fecha_alta,
        pro.nombre_proc_det,
        tik_in.fojas,
        tik_in.id_proc
        FROM Tikets_integracion tik_in
        INNER JOIN Empleado emp ON tik_in.user_alta = emp.rfc_corto
        INNER JOIN Procesos pro ON tik_in.id_proc = pro.id_proc_det
        where tik_in.user_alta = '$user' and tik_in.id_proc = 18 ";
        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if(isset($fila)){
                return $fila;
            }else {
                return false;
            }
        } else {
            return "no hay datos";
        }
    }
    public function Modal_tik_generados_procesos($user,$perfil,$dep,$sub,$admin){
        include_once 'conexion.php';
        include_once 'sesion.php';

        switch ($perfil) {
            case 1:
            $condicion = "where tik_in.id_proc = 19 or  tik_in.id_proc = 20  OR tik_in.id_proc = 21";
            break;
            case 2:
             $condicion = "where tik_in.user_alta = '$user' and tik_in.id_proc = 19 or  tik_in.id_proc = 20 OR tik_in.id_proc = 21";
            break;
            case 4:
            $condicion = "where emp.id_depto = $dep and tik_in.id_proc = 19 or  tik_in.id_proc = 20 OR  tik_in.id_proc = 21";
            break;
            case 5:
            $condicion = "where emp.id_sub_admin = $sub and tik_in.id_proc = 19 or  tik_in.id_proc = 20 OR  tik_in.id_proc = 21";
            break;
            case 7:
            $condicion = "where emp.id_admin = $admin and tik_in.id_proc = 19 or  tik_in.id_proc = 20 OR  tik_in.id_proc = 21";
            break;
            case 8:
            $condicion = "where  tik_in.id_proc = 19 or  tik_in.id_proc = 20 OR tik_in.id_proc = 21";
            break;
            case 9:
            $condicion = "where tik_in.user_alta = '$user' and tik_in.id_proc = 19 or  tik_in.id_proc = 20 OR tik_in.id_proc = 21";
            break;
            case 10:
            $condicion = "where emp.id_depto = $dep and tik_in.id_proc = 19 or  tik_in.id_proc = 20 OR tik_in.id_proc = 21";
            break;
            case 11:
            $condicion = "where emp.id_sub_admin = $sub and tik_in.id_proc = 19 or  tik_in.id_proc = 20 OR tik_in.id_proc = 21";
            break;
        }
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();

        $query = "SELECT 
        tik_in.id_tiket_integra,
        emp.nombre_empleado,
        tik_in.fecha_alta,
        pro.nombre_proc_det,
        tik_in.fojas,
        tik_in.id_proc
        FROM Tikets_integracion tik_in
        INNER JOIN Empleado emp ON tik_in.user_alta = emp.rfc_corto
        INNER JOIN Procesos pro ON tik_in.id_proc = pro.id_proc_det
        $condicion ORDER BY fecha_alta desc ";
        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if(isset($fila)){
                return $fila;
            }else {
                return false;
            }
        } else {
            return "no hay datos";
        }
    }
    public function Modal_integraciones_procesos($user){
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "SELECT 
        tik_in.id_tiket_integra,
        emp.nombre_empleado,
        tik_in.fecha_alta,
        pro.nombre_proc_det,
        tik_in.fojas
        FROM Tikets_integracion tik_in
        INNER JOIN Empleado emp ON tik_in.user_alta = emp.rfc_corto
        INNER JOIN Procesos pro ON tik_in.id_proc = pro.id_proc_det
        where tik_in.user_alta = '$user' ";
        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if(isset($fila)){
                return $fila;
            }else {
                return false;
            }
        } else {
            return "no hay datos";
        }
    }
    public function crear_ticket_integracion($datos){
        include_once 'sesion.php';
        include_once 'conexion.php';
        $user = $_SESSION['ses_rfc_corto'];
         $BD = new ConexionSQL();
         $con = $BD->ObtenerConexionBD();
        $query = " INSERT INTO [Tikets_integracion]
        ([id_proc]
        ,[user_alta]
        ,[fecha_alta]
        ,[estatus]
        ,[fojas])
        SELECT 
        18 AS id_proc
        ,'$user' as [user_alta]
        ,GETDATE() as [fecha_alta]
        ,'A' as [estatus]
        ,(SELECT SUM(fojas) from Integraciones where user_mov = '$user'and id_tiket is null and id_tiket_integra is null )as [fojas]";
        $resultado = sqlsrv_query($con,$query);
        if ($resultado) {
            return true;
             
            
        }
            else {
                return print_r(sqlsrv_errors(),"Ocurrio un error en la instruccion") ;
        }
    }
    public function cabecera_vistas(){
        echo "  <table class='table table-responsive  text-center vh-75 shadow p-1 bg-white rounded '>
                    <thead class='table table-dark sticky-top'>
                     <tr>
                         <th scope='col'>#</th>
                         <th scope='col'>RFC</th>
                         <th scope='col'>Razón Social</th>
                         <th scope='col'>Número Determinante</th>
                         <th scope='col'>Autoridad Determinante</th>
                         <th scope='col'>Estado</th>
                         <th scope='col'>Administración</th>
                         <th scope='col'>Subadministración</th>
                         <th scope='col'>Departamento</th>
                         <th scope='col'>Nombre Encargado</th>
                         <th scope='col'>Fecha Determinante</th>
                         <th scope='col'>Acciones</th>
                     </tr>
                     </thead>
                     <tbody>";
    }
    public function borrar_integracion($id_inte)
    {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
        $query = "  DELETE from Integraciones where id_Integracion = $id_inte";
        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            return true;
            $conexion->CerrarConexion($con);
        } else {
            return false;
        }
    }
    public function pasa_envio_proc_integracion($id_inte)
    {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
        $query = " 	UPDATE Tikets_integracion set id_proc = 19  where id_tiket_integra = $id_inte
        UPDATE [Integraciones] set bandera = 2  where id_tiket_integra = $id_inte";
        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            return "La integracion seleccionada esta en proceso de entrega";
            $conexion->CerrarConexion($con);
        } else {
            return print_r(sqlsrv_errors(),false);
           
        }
    }
    public function borrar_x_id_integracion($id_tik_integra){
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
        $query = "  DELETE from Integraciones where id_tiket_integra = $id_tik_integra";
        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            return true;
            $conexion->CerrarConexion($con);
        } else {
            return print_r(sqlsrv_errors(),true);
        }
    }
    public function borrar_tiket_integracion($id_tik_integra){
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
        $query = "  DELETE from Tikets_integracion where [id_tiket_integra] = $id_tik_integra";
        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            return true;
            $conexion->CerrarConexion($con);
        } else {
            return print_r(sqlsrv_errors(),true);
        }
    }

    public function Datos_busca_vista_cargas_nuevas()
    {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "SELECT distinct [rfc]
        ,[razon_social]
        ,[id_autoridad]
        ,[no_analista]
        ,[Fecha_de_registro]
        ,[numero_determinante]
        ,[Fecha_de_resolución]
        ,[RDFDA]
    FROM [BovedaProyect].[dbo].[vw_Sin_filtro_cargas_diarias_nw] ";
        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if(isset($fila)){
                return $fila;
            }else {
                return false;
            }
        } else {
            return "no hay datos";
        }
    }
    public function Comprueba_limite_integracion($user)
    {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "SELECT count(*) total from Integraciones WHERE user_mov = '$user'and id_tiket is null and id_tiket_integra is null";
        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila = $row['total'];
            }
            if(isset($fila)){
                return $fila;
            }else {
                return false;
            }
        } else {
            return "no hay datos";
        }
    }
    public function Datos_para_integrar($user)
    {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "SELECT * from Integraciones WHERE user_mov = '$user' and id_tiket is null and id_tiket_integra is null ";
        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if(isset($fila)){
                return $fila;
            }else {
                return false;
            }
        } else {
            return "no hay datos";
        }
    }
    public function Agrupa_integraciones_sin_ticket_a_solicitud($user)
    {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "  UPDATE Integraciones set id_tiket_integra = 
        (SELECT MAX(id_tiket_integra) from Tikets_integracion where user_alta =  '$user' ), bandera= 1  WHERE id_tiket is null and  [id_tiket_integra] is null ";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            return true;
        
        } else {
            return false;
        }
         
    }
    public function Datos_busca_vista_cargas_nuevas_masvi()
    {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "SELECT distinct [rfc]
        ,[razon_social]
        ,[id_autoridad]
        ,[no_analista]
        ,[estatus]
        ,[id_resol]
        ,[Fecha_de_registro]
        ,[numero_determinante]
        ,[Fecha_de_resolución]
        ,[RDFDA]
    FROM [BovedaProyect].[dbo].[vw_Sin_filtro_faltantes_nw]";
        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if(isset($fila)){
                return $fila;
            }else {
                return false;
            }
        } else {
            return "no hay datos";
        }
    }
    public function busca_nuevas_rdfda_cargas_diarias()
    {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "  SELECT distinct [RFC]
        ,[Razón Social]
        ,[IDAUDETERMINANTE]
        ,[No# Anlista]
        ,[Fecha de registro]
        ,[Número de resolución]
        ,[Fecha_de_resolución]
        ,[RDFDA]
        ,[cargado_RDFDA]
        ,[cargado_rfc]
        FROM [BovedaProyect].[dbo].[vw_Comparacion_faltantes_cargas_diarias_nw]";
        $resultado = sqlsrv_query($con, $query);
        if (isset($resultado)) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            return $fila;
        } else {
            return false;
        }
    }
    public function busca_actualiza_rdfda_cargas_diarias()
    {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "  SELECT distinct [RFC]
        ,[Razón Social]
        ,[IDAUDETERMINANTE]
        ,[No# Anlista]
        ,[Fecha de registro]
        ,[Número de resolución]
        ,[Fecha_de_resolución]
        ,[RDFDA]
        ,[cargado_RDFDA]
        ,[cargado_rfc]
        FROM [BovedaProyect].[dbo].[vw_Comparacion_faltantes_cargas_diarias_nw] where [cargado_RDFDA] is not null";
        $resultado = sqlsrv_query($con, $query);
        if (isset($resultado)) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            
            return $fila;
        } else {
            return false;
        }
    }
    public static function Actualiza_User_por_RDFDA_cargas_diarias($No_analista,$RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $query = "UPDATE Determinante SET id_empleado = (SELECT id_empleado FROM Empleado WHERE no_empleado = $No_analista  ),fecha_mod = getdate()  WHere RDFDA = '$RDFDA'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            return true;
        } else {
            return false;
        }
    }

    public function carga_contris_nuevos($rfc,$razon,$user){
    
        include_once "conexion.php";
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();

        $query = " IF NOT EXISTS (SELECT * FROM Contribuyente WHERE rfc = '$rfc' OR razon_social ='$razon') BEGIN
        INSERT INTO Contribuyente ([rfc]
                ,[razon_social]
                ,[estatus]
                ,[user_alta]
                ,[fecha_alta])
                SELECT 
                '$rfc' AS [rfc]
                ,'$razon' AS [razon_social]
                ,'A' AS [estatus]
                ,'$user' AS [user_alta]
                ,GETDATE() AS [fecha_alta]
                END"; //Por ultimo, se actualiza el nombre del usuario 
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            return true;
          
        } else {
            return false;
        }
    }
 
    public function Carga_rfcs_nuevos_cargas_diarias($user)
    {   
        include_once "sesion.php";
        $datos = self::Datos_busca_vista_cargas_nuevas();
        if (isset($datos)) {
             for ($i=0; $i < count($datos) ; $i++) {
                 $rfc=$datos[$i]['rfc'];
                 $razon = $datos[$i]['razon_social'];
               

                self::carga_contris_nuevos($rfc,$razon,$user);
                
             }
             return "Carga exitosa!";
         }
         else{
             return "No hay registros nuevos por cargar";
         }

    }
    public function Carga_rfcs_nuevos_cargas_diarias_masiv($user)
    {   
        include_once "sesion.php";
        $datos = self::Datos_busca_vista_cargas_nuevas_masvi();
        if (isset($datos)) {
             for ($i=0; $i < count($datos) ; $i++) {
                 $rfc=$datos[$i]['rfc'];
                 $razon = $datos[$i]['razon_social'];
               

                self::carga_contris_nuevos($rfc,$razon,$user);
                
             }
             return "Carga exitosa!";
         }
         else{
             return "No hay registros nuevos por cargar";
         }

    }
    public function Carga_expedientes_nuevos($user)
    {   
        include_once "sesion.php";
        $datos = self::Datos_busca_vista_cargas_nuevas();
        if (isset($datos)) {
             for ($i=0; $i < count($datos) ; $i++) {
                 $rfc=$datos[$i]['rfc'];
                 $razon = $datos[$i]['razon_social'];
                 $id_aut = $datos[$i]['id_autoridad'];
                 $analista = $datos[$i]['no_analista'];
               
                 $fec_reg = $datos[$i]['Fecha_de_registro'];
                 $num_det = $datos[$i]['numero_determinante'];
                 $fec_det = $datos[$i]['Fecha_de_resolución'];
                 $RDFDA = $datos[$i]['RDFDA'];
                self::Crea_exp_por_RDFDA($rfc,$razon,$user,$analista,$id_aut,$num_det,$fec_det,$fec_reg,$RDFDA);
                
             }
             return "Carga exitosa!";
         }
         else{
             return "No hay registros nuevos por cargar";
         }

    }
    public function Carga_expedientes_nuevos_masvi($user)
    {   
        include_once "sesion.php";
        $datos = self::Datos_busca_vista_cargas_nuevas_masvi();
        if (isset($datos)) {
             for ($i=0; $i < count($datos) ; $i++) {
                 $rfc=$datos[$i]['rfc'];
                 $razon = $datos[$i]['razon_social'];
                 $id_aut = $datos[$i]['id_autoridad'];
                 $analista = $datos[$i]['no_analista'];
                 $id_resol = $datos[$i]['id_resol'];
                 $estatus_cred = $datos[$i]['estatus'];
                 $fec_reg = $datos[$i]['Fecha_de_registro'];
                 $num_det = $datos[$i]['numero_determinante'];
                 $fec_det = $datos[$i]['Fecha_de_resolución'];
                 $RDFDA = $datos[$i]['RDFDA'];
                self::Crea_exp_por_RDFDA_masvi($rfc,$razon,$user,$analista,$id_resol,$id_aut,$num_det,$fec_det,$fec_reg,$RDFDA,$estatus_cred);
                
             }
             return "Carga exitosa!";
         }
         else{
             return "No hay registros nuevos por cargar";
         }

    }
    public function Crea_exp_por_RDFDA_masvi($rfc,$razon,$user,$analista,$id_resol,$id_aut,$num_det,$fec_det,$fec_reg,$RDFDA,$estatus_cred){
        include_once "conexion.php";
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $fec_inve =$fec_reg->format('Y-m-d');
        $fec_det = $fec_det->format('Y-m-d');
        $query = "IF NOT EXISTS (SELECT * FROM Determinante WHERE RDFDA = '$RDFDA') BEGIN
        INSERT INTO Expediente (
                id_contribuyente,
                fecha_alta,
                user_alta,
                estatus)
                SELECT
                (SELECT distinct id_contribuyente FROM Contribuyente WHERE rfc ='$rfc' or razon_social = '$razon' ) AS id_contribuyente ,
                GETDATE() AS fecha_alta,
                '$user' AS user_alta,
                'A' AS estatus
               
          INSERT INTO [Determinante] (
            id_expediente,
            id_autoridad,
            id_empleado,
            estatus_cred,
            fojas,
            fecha_inv,
            fecha_determinante,
            num_determinante,
            id_rersolucion,
            RDFDA,
            fecha_alta,
            user_alta,
            estatus,
            id_proc)
            values(
            (Select max(id_expediente)id_expediente 
            from Expediente where id_contribuyente=(
                Select distinct id_contribuyente from Contribuyente 
                where rfc='$rfc' or razon_social = '$razon')),
              (select id_autoridad from Autoridad where num_Autoridad=$id_aut), 
              (select id_empleado from Empleado where no_empleado=$analista),
              '$estatus_cred',
                0,
              '$fec_inve' ,
              '$fec_det',
                '$num_det',
                $id_resol,
                '$RDFDA',
                GETDATE(),
                '$user',
                'A',
                1)
                END
                ELSE BEGIN
                UPDATE Determinante SET fecha_mod = GETDATE(),user_mod = '$user', estatus_cred = '$estatus_cred', id_empleado = (select id_empleado from Empleado where no_empleado=$analista) where RDFDA ='$RDFDA'
                END
                
                "; //Por ultimo, se actualiza el nombre del usuario 
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
           return true;
         
        } else {
            return print_r(sqlsrv_errors(),false);

        }
    }   
     public function Crea_exp_por_RDFDA($rfc,$razon,$user,$analista,$id_aut,$num_det,$fec_det,$fec_reg,$RDFDA){
        include_once "conexion.php";
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "IF NOT EXISTS (SELECT * FROM Determinante WHERE RDFDA = '$RDFDA') BEGIN
        INSERT INTO Expediente (
                id_contribuyente,
                fecha_alta,
                user_alta,
                estatus)
                SELECT
                (SELECT distinct id_contribuyente FROM Contribuyente WHERE rfc ='$rfc' or razon_social = '$razon' ) AS id_contribuyente ,
                GETDATE() AS fecha_alta,
                '$user' AS user_alta,
                'A' AS estatus
                
                END"; //Por ultimo, se actualiza el nombre del usuario 
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
           self::Crea_RDFDA_por_expediente($rfc,$razon,$user,$analista,$id_aut,$num_det,$fec_det,$fec_reg,$RDFDA);
         
        } else {
            return print_r(sqlsrv_errors(),false);

        }
    }
    
   
    public function Crea_RDFDA_por_expediente($rfc,$razon,$user,$analista,$id_aut,$num_det,$fec_det,$fec_reg,$RDFDA){
        include_once "conexion.php";
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $fec_inve =$fec_reg->format('Y-m-d');
        $fec_det = $fec_det->format('Y-m-d');
        $query = "IF NOT EXISTS (SELECT * FROM Determinante WHERE RDFDA = '$RDFDA') BEGIN
          INSERT INTO [Determinante] (
            id_expediente,
            id_autoridad,
            id_empleado,
            estatus_cred,
            fojas,
            fecha_inv,
            fecha_determinante,
            num_determinante,
            
            RDFDA,
            fecha_alta,
            user_alta,
            estatus,
            id_proc)
    values(
    (Select max(id_expediente)id_expediente 
    from Expediente where id_contribuyente=(
        Select distinct id_contribuyente from Contribuyente 
        where rfc='$rfc' or razon_social = '$razon')),
      (select id_autoridad from Autoridad where num_Autoridad=$id_aut), 
      (select id_empleado from Empleado where no_empleado=$analista),
      'A',
        0,
      '$fec_inve' ,
      '$fec_det',
        '$num_det',
        '$RDFDA',
        GETDATE(),
        '$user',
        'A',
        1)
        END";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
          return true;
          $BD->CerrarConexion($con);
        } else {
            return print_r(sqlsrv_errors(),false);

        }
    }

    public function comprueba($rfc,$razon){
        include_once "conexion.php";
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "SELECT distinct rfc,razon_social from Contribuyente where rfc='$rfc' or razon_social = '$razon'";
        $prepare = sqlsrv_query($con, $query);
        if (isset($prepare)) {
            return true;
             $BD->CerrarConexion($con);
        } else {
            return false;
        }

        
    }
    public function comprueba2($RDFDA){
        include_once "conexion.php";
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "SELECT RDFDA from Determinante where RDFDA='$RDFDA'";
        $prepare = sqlsrv_query($con, $query);
        if (isset($prepare)) {
            return true;
           
        } else {
            return false;
        }

    }
    public function cuenta_integra()
    {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
        $query = "  SELECT TOP 1
        (SELECT COUNT(*) total FROM Integraciones where user_mov = '$user' and id_tiket is null and id_tiket_integra is null)  as total_carrito,
        (SELECT COUNT(*) total FROM Tikets_integracion where user_alta = '$user' and id_proc = 18)  as total_fac_creadas,
        (SELECT COUNT(*) total FROM Tikets_integracion where user_alta = '$user' and id_proc != 18 and id_proc != 21 )  as total_proc_entrega
		FROM Integraciones";
        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
            } else {
                return null;
            }
        } else {
            return print_r(sqlsrv_errors(),true);
        }
    }
    public function Modal_registro_int($user)
    {
        include_once 'conexion.php';
        $BD = new ConexionSQL();
        $con = $BD->ObtenerConexionBD();
        $query = "    SELECT 
        cont.rfc,
        cont.razon_social,
        det.num_determinante,
        sit.Objeto,
        sit.Situacion,
        sit.[etapa ] as Etapa,
        inte.Observaciones,
        inte.fecha_mov,
        inte.id_tiket,
        inte.id_Integracion,
        case 
        when ( inte.tipo_doc = 1) then 'Original' 
        when ( inte.tipo_doc = 2) then 'Copia certificada' 
        when ( inte.tipo_doc = 3) then 'Copia foto-estatica' 
        when ( inte.tipo_doc = 4) then 'Correo' 
        when ( inte.tipo_doc = 5) then 'Captura de pantalla' 
        end as tipo_doc_res,
        emp.nombre_empleado
        FROM Integraciones inte
        INNER JOIN Situaciones sit on inte.id_situaciones = sit.id_situaciones
        INNER JOIN Determinante det ON det.id_determinante = inte.id_det
        INNER JOIN Expediente expe ON det.id_expediente = expe.id_expediente
        INNER JOIN Contribuyente cont ON cont.id_contribuyente = expe.id_contribuyente 
        INNER JOIN Empleado emp ON emp.rfc_corto = inte.user_mov
        WHERE emp.rfc_corto = '$user'and inte.id_tiket is null and inte.id_tiket_integra is null order BY inte.fecha_mov desc";

        $resultado = sqlsrv_query($con, $query);
        if ($resultado) {
            while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
            } else {
                return null;
            }
        } else {
            return false;
        }
    }

    public function Consulta_Objeto1()
    {
        include_once "conexion.php";
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI?N
        //SE MANDA A LLAMAR LA CONEXI?N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "  select distinct id_objeto,Objeto from Situaciones order by (Objeto) asc";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI?N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Consulta_info_det($det)
    {
        include_once "conexion.php";
        include_once "sesion.php";
        $user = $_SESSION['ses_id_usuario'];
        $perfil = $_SESSION['ses_id_perfil'];
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI?N
        //SE MANDA A LLAMAR LA CONEXI?N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
       
        $query = "SELECT 
        det.id_determinante,
        contri.rfc,
        contri.razon_social,
        det.num_determinante,
        fecha_determinante,
        aut.nombre_autoridad,
        det.RDFDA
        FROM Determinante det
        INNER JOIN Expediente exped on exped.id_expediente = det.id_expediente
        INNER JOIN Contribuyente contri ON contri.id_contribuyente = exped.id_contribuyente
         INNER JOIN Autoridad aut ON aut.id_autoridad = det.id_autoridad
      INNER JOIN Empleado emp ON emp.id_empleado = det.id_empleado
      where det.id_determinante = $det
   
     ";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI?N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Consulta_RFC_contri($rfc)
    {
        include_once "conexion.php";
        include_once "sesion.php";
        $user = $_SESSION['ses_id_usuario'];
        $perfil = $_SESSION['ses_id_perfil'];
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI?N
        //SE MANDA A LLAMAR LA CONEXI?N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        switch ($perfil) {
            case 1:
            $condiciones = "";
             break;
            
            default:
            $condiciones = "and (emp.id_empleado  = $user 
            OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user))
            OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user ) AND id_admin =  1 )
            OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT id_empleado FROM Empleado WHERE  id_admin =  1 AND jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado = $user))) ";
            break;
        }
        $query = "	SELECT 
        det.id_determinante,
        contri.rfc,
        contri.razon_social,
        det.num_determinante,
        fecha_determinante,
        aut.nombre_autoridad,
        det.RDFDA
        FROM Determinante det
        INNER JOIN Expediente exped on exped.id_expediente = det.id_expediente
        INNER JOIN Contribuyente contri ON contri.id_contribuyente = exped.id_contribuyente
         INNER JOIN Autoridad aut ON aut.id_autoridad = det.id_autoridad
      INNER JOIN Empleado emp ON emp.id_empleado = det.id_empleado
      where contri.rfc = '$rfc'
        $condiciones 
     ";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI?N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Procesos_sig_code_bar($datos_principal, $proceso_activo_tiket, $tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $datoss = self::bus_tiket_prest_pet_dev_par_com($tiket);
        $det_devuletas = self::total_tiket_consulta_det_devueltas($tiket);
        $datos_corres = self::bus_tiket_code_bar($tiket);
        $asunto = $datos_corres[0]['Asunto'];
        $user_valida = $_SESSION['ses_rfc_corto'];
        $user_alta = $datoss[0]['user_alta'];
        switch ($proceso_activo_tiket) {
                 case 2:
                 $estado_Act = "Petición en curso";
                 $estado_sig = "Búsqueda";
                 return "Se valida que son la misma cuenta y el estado del ticket es ".$estado_Act." y el que sigue es ".$estado_sig;
                 break;
                 case 7:
                 $resultado = self::Cambiar_Estatus_Disponible($tiket);
                 return $resultado;
                 break;
                 case 11:
                 $resultado = self::Cambiar_Estatus_prestamo_tiket($tiket);
                return $resultado;
                 break;
                 case 8:
                  if ($asunto == "Consulta en Boveda") {
                      $resultado = self::Boveda_tiket_dev_interna($tiket);
                      return $resultado;
                  } else {
                      return "Solo se pueden devolver Tickets en esta opcion si son prestamos internos de Bóveda";
                  }
                 break;
                 case 5:
                     $total_array = count($datos_principal) ;
                     $filtro = count($datoss);
                     $diferencia = ($filtro - $det_devuletas);
                     if (isset($datoss)) {
                         if ($filtro != $total_array) {
                             for ($i=0; $i < count($datos_principal)  ; $i++) {
                                 self::Crea_cambios_etapa_x_det_etapa_pet_pacial($datos_principal[$i]['id_tiket'], $user_alta, $datos_principal[$i]['RDFDA']);
                                 self::Cambia_estatus_det_proc_pet_PARCIAL($datos_principal[$i]['RDFDA']);
                                 self::baja_etapas_anteriores_al_cambio_pet_dev_parc($datos_principal[$i]['id_tiket'], $datos_principal[$i]['RDFDA']); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                             }
                             $query = "UPDATE Tikets SET id_proc = 9, fecha_recive_par = GETDATE(), user_recive_par = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                             $prepare = sqlsrv_query($con, $query);
                             if ($prepare) {
                                 return 'El ticket fue devuelto de manera parcial';
                                 $conexion->CerrarConexion($con);
                             } else {
                                 return false;
                             }
                         } elseif ($filtro == $total_array || $total_array == $diferencia) {
                             for ($i=0; $i < count($datos_principal) ; $i++) {
                                 self::Crea_cambios_etapa_x_det_etapa_pet_dev_interna_bov($datos_principal[$i]['id_tiket'], $datos_principal[$i]['user_alta'], $datos_principal[$i]['id_determinante']);
                                 self::Cambia_estatus_det_proc_pet_dev_inter_bov($datos_principal[$i]['id_determinante']);
                             }
                             self::baja_etapas_anteriores_al_cambio_pet_dev_comp($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                             $query = "UPDATE Tikets SET id_proc = 4, fecha_recive_comp = GETDATE(), user_recive_comp = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                             $prepare = sqlsrv_query($con, $query);
                             if ($prepare) {
                                 return 'El ticket fue devuelto satisfactoriamente';
                                 $conexion->CerrarConexion($con);
                             } else {
                                 return false;
                             }
                         }
                     } else {
                          return 'El ticket no cuenta con determinantes en peticion de devolución';
                      }
               

                 break;
                 case 9:
                    $total_array = count($datos_principal) ;
                    $filtro = count($datoss);
                    $diferencia = ($filtro - $det_devuletas);
                    if (isset($datoss)) {
                        if ($filtro != $total_array) {
                            for ($i=0; $i < count($datos_principal)  ; $i++) {
                                self::Crea_cambios_etapa_x_det_etapa_pet_pacial($datos_principal[$i]['id_tiket'], $user_alta, $datos_principal[$i]['RDFDA']);
                                self::Cambia_estatus_det_proc_pet_PARCIAL($datos_principal[$i]['RDFDA']);
                                self::baja_etapas_anteriores_al_cambio_pet_dev_parc($datos_principal[$i]['id_tiket'], $datos_principal[$i]['RDFDA']); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                            }
                            $query = "UPDATE Tikets SET id_proc = 9, fecha_recive_par = GETDATE(), user_recive_par = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                            $prepare = sqlsrv_query($con, $query);
                            if ($prepare) {
                                return 'El ticket fue devuelto de manera parcial';
                                $conexion->CerrarConexion($con);
                            } else {
                                return false;
                            }
                        } elseif ($filtro == $total_array || $total_array == $diferencia) {
                            for ($i=0; $i < count($datos_principal) ; $i++) {
                                self::Crea_cambios_etapa_x_det_etapa_pet_dev_interna_bov($datos_principal[$i]['id_tiket'], $datos_principal[$i]['user_alta'], $datos_principal[$i]['id_determinante']);
                                self::Cambia_estatus_det_proc_pet_dev_inter_bov($datos_principal[$i]['id_determinante']);
                            }
                            self::baja_etapas_anteriores_al_cambio_pet_dev_comp($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                            $query = "UPDATE Tikets SET id_proc = 4, fecha_recive_comp = GETDATE(), user_recive_comp = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                            $prepare = sqlsrv_query($con, $query);
                            if ($prepare) {
                                return 'El ticket fue devuelto satisfactoriamente';
                                $conexion->CerrarConexion($con);
                            } else {
                                return false;
                            }
                        }
                    } else {
                         return 'El ticket no cuenta con determinantes en peticion de devolución';
                     }
                 break;
                 case 4:
                    
                    return "El ticket ".$tiket." ya ha sido entregado en Bóveda.";
                    
                   break;
             }
    }
    public function Procesos_seleccion_proc_prevent($datos_principal)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_alta = $datos_principal[0]['user_mov'];

        for ($i=0; $i < count($datos_principal)  ; $i++) {
            $filtro = self::Consulta_user_mov_x_dia_en_cadena($datos_principal[$i]['id_determinante']);
            if (isset($filtro)) {
                return "No se puede agregar a la seleccion por que ya se encuentra seleccionada.";
            } else {
                self::Crea_proceso_previo_x_det($datos_principal[$i]['id_tiket'], $user_alta, $datos_principal[$i]['RDFDA']);
                return "Se ha agregado la seleccion.";
            }
        }
    }
    public function Consulta_evitar_duplicar_select($objeto)
    {
        include_once("conexion.php");
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT DISTINCT objeto from [Situaciones] where Id_Objeto=$objeto";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        $rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
        return  $rows;
    }
    
    public function Consulta_Objeto($objeto)
    {
        include_once("conexion.php");
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT DISTINCT objeto from [Situaciones] where Id_Objeto=$objeto";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        $rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
        return  $rows;
    }
    public static function Consulta_DET($RDFDA)
    {
        $RDFDA = $_SESSION['RDFDA'];
        include_once("conexion.php");
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT id_determinante from Determinante where RDFDA='$RDFDA'";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        $rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
        return  $rows;
    }
    public static function Consulta_DET_tick($RDFDA)
    {
        //$RDFDA = $_SESSION['RDFDA'];
        include_once("conexion.php");
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT id_determinante from Determinante where RDFDA='$RDFDA'";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        $rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
        return  $rows;
    }
    public static function Consulta_id_situacion($id_obj, $id_sit, $id_etapa)
    {
        include_once("conexion.php");
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $query = "SELECT id_situaciones FROM Situaciones WHERE Id_Objeto = $id_obj and [Id_situación ]=$id_sit and id_etapa=$id_etapa";
        $prepare = sqlsrv_query($con, $query);
        $rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
        return  $rows;
    }

    public function Inserta_integarcion($datos)
    {
        $id_=self::Consulta_DET();
        $id_det=$id_['id_determinante'];
        $id_1=self::Consulta_id_situacion($datos["id_Objeto"], $datos["id_situacion"], $datos["id_etapa"]);
        $id_situaciones=$id_1['id_situaciones'];
       
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
    
        $query = "INSERT Into Integraciones (id_situaciones,id_det,fecha_of,fecha_mov,user_mov,Observaciones)
        values ($id_situaciones,$id_det,'".$datos["fecha_doc_inte"]."',
        GETDATE(),'".$datos["usuario"]."','".$datos["Obs"]."',".$datos['tip_doc'].")
        ";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            if (self::Inserta_PROC_integarcion($datos)) {
                return "Se Inserto correctamente la integracion";
            } else {
                return "Error en la integracion";
            }
        }
    }
    public function Inserta_integarcion_en_tikets($datos, $tik)
    {
        $id_=self::Consulta_DET_tick($datos->RDFDA);
        $id_det=$id_['id_determinante'];
        $id_1=self::Consulta_id_situacion($datos->num_objeto, $datos->id_situacion, $datos->id_etapas_select);
        $id_situaciones=$id_1['id_situaciones'];
       
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user =  $_SESSION['ses_rfc_corto'];
        $query = "INSERT Into Integraciones (id_situaciones,id_det,fecha_of,fecha_mov,user_mov,Observaciones,id_tiket,tipo_doc)
        values ($id_situaciones,$id_det,'".$datos->fecha_doc_inte."',
        GETDATE(),'".$user."','".$datos->Obs."',$tik,".$datos->tip_doc.")
        ";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            if (self::Inserta_PROC_integarcion_en_tiket($datos, $tik)) {
                return "Se Inserto correctamente la integracion";
            } else {
                return "Error en la integracion";
            }
        }
    }
    public function Inserta_integarcion_anim($datos)
    {
        include_once 'sesion.php';
        include_once 'conexion.php';
        $id_=self::Consulta_DET_tick($datos->RDFDA);
        $user =  $_SESSION['ses_rfc_corto'];
        $id_det=$id_['id_determinante'];
        $id_1=self::Consulta_id_situacion($datos->num_objeto, $datos->id_situacion, $datos->id_etapas_select);
        $id_situaciones=$id_1['id_situaciones'];
       if (($total =self::Comprueba_limite_integracion($user)) >= 25) {
           return false;
       }
       else{
   
       
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
      
        $query = "INSERT INTO Integraciones (id_situaciones,id_det,fecha_of,fecha_mov,user_mov,Observaciones,tipo_doc,bandera)
        values ($id_situaciones,$id_det,'".$datos->fecha_doc_inte."',
        GETDATE(),'".$user."','".$datos->Obs."',".$datos->tip_doc.",0)
        ";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return true;
            // if (self::Inserta_PROC_integarcion_anim($datos)) {
            //     return "Se Inserto correctamente la integracion";
            // } else {
            //     return "Error en la integracion";
            // }
        }
       }
       
    }
    public function Inserta_integarcion_select($datos)
    {
        include_once 'sesion.php';
        include_once 'conexion.php';
        $id_det= $datos->id_det;
        $id_1=self::Consulta_id_situacion($datos->num_objeto, $datos->id_situacion, $datos->id_etapas_select);
        $id_situaciones=$id_1['id_situaciones'];
        $user =  $_SESSION['ses_rfc_corto'];
        if (($total =self::Comprueba_limite_integracion($user)) >= 25) {
            return false;
        }
        else{
            $conexion = new ConexionSQL();
            $con = $conexion->ObtenerConexionBD();
        
            $query = "INSERT INTO Integraciones (id_situaciones,id_det,fecha_of,fecha_mov,user_mov,Observaciones,tipo_doc,bandera,fojas)
            values ($id_situaciones,$id_det,'".$datos->fecha_doc_inte."',
            GETDATE(),'".$user."','".$datos->Obs."',".$datos->tip_doc.",0,$datos->fojas)
            ";
            $prepare = sqlsrv_query($con, $query);
            if ($prepare == false) {
                die(print_r(sqlsrv_errors(), true));
            } else {
                return true;
                // if (self::Inserta_PROC_integarcion_anim($datos)) {
                //     return "Se Inserto correctamente la integracion";
                // } else {
                //     return "Error en la integracion";
                // }
            }
        }
       
    }
    public function borarr_select()
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $user = $_SESSION['ses_rfc_corto'];
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $query = "DELETE FROM Etapa_poc where id_proc_det = 16 AND user_valida = '$user'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return true;
        }
    }
    public static function Inserta_PROC_integarcion($datos)
    {
        $id_=self::Consulta_DET();
        $id_det=$id_['id_determinante'];
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
    
        $query = "  INSERT INTO Etapa_poc 
        (
        id_proc_det,
        user_alta,
        fecha_alta,
        id_determinante,
        estatus,
        fojas)
        values(15,'".$datos["usuario"]."',GETDATE(),$id_det,'A',".$datos["fojas"].")
        ";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return true;
        }
    }
    public static function Inserta_PROC_integarcion_en_tiket($datos, $tik)
    {
        $id_=self::Consulta_DET_tick($datos->RDFDA);
        $id_det=$id_['id_determinante'];
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
        $query = "  INSERT INTO Etapa_poc 
        (
        id_proc_det,
        user_alta,
        fecha_alta,
        id_determinante,
        id_tiket,
        estatus,
        fojas)
        values(15,'".$user."',GETDATE(),$id_det,$tik,'A',".$datos->fojas.")
        ";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return true;
        }
    }
    public static function Inserta_PROC_integarcion_anim($datos)
    {
        $id_det=$datos->id_det;
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
        $query = "  INSERT INTO Etapa_poc 
        (
        id_proc_det,
        user_alta,
        fecha_alta,
        id_determinante,
        estatus,
        fojas)
        values(15,'".$user."',GETDATE(),$id_det,'A',".$datos->fojas.")
        ";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return true;
        }
    }
    public function alertasdisponibles()
    {   include_once 'sesion.php';
        $perfil = $_SESSION['ses_id_perfil'];
        $sub = $_SESSION['ses_id_sub_admin'];
        $dep = $_SESSION['ses_id_depto'];

        $datos_dis = self::Disponibles_fuera_de_plazo($perfil, $sub, $dep);
        
        if (isset($datos_dis)) {
            $cuenta_dis = count($datos_dis);
        } else {
            $cuenta_dis = 0;
        }
        if (isset($datos_dis)) {
            switch ($perfil) {
                    case 1:
                    $mensaje =" <P>Los siguientes tickets estan en espera de entrega en la recepción de bóveda. </p>";
                    break;
                    case 7:
                    $mensaje =" <P> Tienes expedientes que están disponibles para recoger en bóveda.<br>
                    Recuerda que solo tienes 2 dias para pasar por tus expeidneites a bóveda, despues de ese tiempo se cancelara tu solicitud.</p>";
                    break;
                    case 2:
                    $mensaje =" <P> Tienes expedientes que están disponibles para recoger en bóveda.<br>
                    Recuerda que solo tienes 2 dias para pasar por tus expeidneites a bóveda, despues de ese tiempo se cancelara tu solicitud.</p>";
                    break;
                    case 9:
                    $mensaje =" <P> Tienes expedientes que están disponibles para recoger en bóveda.<br>
                    Recuerda que solo tienes 2 dias para pasar por tus expeidneites a bóveda, despues de ese tiempo se cancelara tu solicitud.</p>";
                    break;
                    case 4:
                    $mensaje =" <P> Tú o tu equipo de trabajo cuentan con expedientes que están disponibles para recoger en bóveda.<br>
                    Recuerden que solo tienen 2 dias para pasar por sus expeidneites a bóveda, despues de ese tiempo se cancelara sus solicitudes.</p>";
                    break;
                    case 10:
                    $mensaje =" <P> Tú o tu equipo de trabajo cuentan con expedientes que están disponibles para recoger en bóveda.<br>
                    Recuerden que solo tienen 2 dias para pasar por sus expeidneites a bóveda, despues de ese tiempo se cancelara sus solicitudes.</p>";
                    break;
                    case 11:
                    $mensaje =" <P> Tienes expedientes que están disponibles para recoger en bóveda.<br>
                    Recuerda que solo tienes 2 dias para pasar por tus expeidneites a bóveda, despues de ese tiempo se cancelara tu solicitud.</p>";
                    break;
                    case 12:
                    $mensaje =" <P> Tienes expedientes que están disponibles para recoger en bóveda.<br>
                    Recuerda que solo tienes 2 dias para pasar por tus expeidneites a bóveda, despues de ese tiempo se cancelara tu solicitud.</p>";
                    break;
                    
                }
              
            echo"
                <div class='modal fade bd-example-modal-xl' id='Modal_ticket_alerta_users_disponibles' tabindex='-1' role='dialog'
                aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog  modal-xl' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>ALERTA</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                        $mensaje
                            <nav>
                                <div class='nav nav-tabs' id='nav-tab' role='tablist'>
                                    <a class='nav-item nav-link active' id='nav-home-tab' data-toggle='tab' href='#dispone_plazo' role='tab' aria-controls='nav-home' aria-selected='true'>Disponibles (".$cuenta_dis.")</a>
                                </div>
                            </nav>
                            <div class='tab-content' id='nav-tabContent'>
                                <div class='tab-pane fade show active' id='dispone_plazo' role='tabpanel' aria-labelledby='nav-home-tab'>
                                    <div class='container-fluid my-3'>";
            $tab_prest = self::tabla_dispo($datos_dis);
            echo"
                                    </div>
                                </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>";
        }
    }
    public function alertasdisponibles_CANCELADOS()
    {
        $perfil = $_SESSION['ses_id_perfil'];
        $sub = $_SESSION['ses_id_sub_admin'];
        $dep = $_SESSION['ses_id_depto'];
        $datos_dis = self::Disponibles_CANCELADOS($perfil, $sub, $dep);
        
        if (isset($datos_dis)) {
            $cuenta_dis = count($datos_dis);
        } else {
            $cuenta_dis = 0;
        }
        if (isset($datos_dis)) {
            echo"
                <div class='modal fade bd-example-modal-xl' id='Modal_ticket_alerta_users_disponibles_cancel' tabindex='-1' role='dialog'
                aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog  modal-xl' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>ALERTA</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <P> Tienes Tickets disponibles cancelados, revisa que los expedientes esten en su lugar de los siguientes tickets: </p>
                            <nav>
                                <div class='nav nav-tabs' id='nav-tab' role='tablist'>
                                    <a class='nav-item nav-link active' id='nav-home-tab' data-toggle='tab' href='#dispone_plazo' role='tab' aria-controls='nav-home' aria-selected='true'>Cancelados (".$cuenta_dis.")</a>
                                </div>
                            </nav>
                            <div class='tab-content' id='nav-tabContent'>
                                <div class='tab-pane fade show active' id='dispone_plazo' role='tabpanel' aria-labelledby='nav-home-tab'>
                                    <div class='container-fluid my-3'>";
            $tab_prest = self::tabla_dispo_cencel($datos_dis);
            echo"
                                    </div>
                                </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>";
        }
    }
    public function alertas_tickets_por_aprobar()
    {
        $perfil = $_SESSION['ses_id_perfil'];
        $sub = $_SESSION['ses_id_sub_admin'];
        $dep = $_SESSION['ses_id_depto'];
        $datos_dis = self::tickets_por_aprobar($perfil, $sub, $dep);
        
        if (isset($datos_dis)) {
            $cuenta_dis = count($datos_dis);
        } else {
            $cuenta_dis = 0;
        }
        if (isset($datos_dis)) {
            switch ($perfil) {
                    case 1:
                    $mensaje =" <P>Los siguientes tickets estan a la espera de aprobación para su salida de bóveda. </p>";
                    break;
                    case 7:
                    $mensaje =" <P> Los siguientes tickets estan a la espera de aprobación para su salida de bóveda. </p>";
                    break;
                    case 2:
                    $mensaje ="<P>Tú ticket se solicito correctamente, pero requiere aprobación para su salida de bóveda. <br>
                    Esta aprobación se dara por el subadministrador de su área. </p>";
                    break;
                    case 9:
                    $mensaje ="<P>Tú ticket se solicito correctamente, pero requiere aprobación para su salida de bóveda. <br>
                    Esta aprobación se dara por el subadministrador de su área. </p>";
                    break;
                    case 4:
                    $mensaje =" <P>Los tickets de su equipo se solicitaron correctamente, pero requieren aprobacioón para su salida de bóveda.
                    <br>Esta aprobación se dara por el subadministrador de su área. </p>";
                    break;
                    case 10:
                    $mensaje =" <P>Los tickets de su equipo se solicitaron correctamente, pero requieren aprobacioón para su salida de bóveda.
                    <br>Esta aprobación se dara por el subadministrador de su área. </p>";
                    break;
                    case 11:
                    $mensaje =" <P>Los siguientes tickets requieren de su aprobación para su salida de bóveda. </p>";
                    break;
                    case 12:
                    $mensaje =" <P>Los siguientes tickets requieren de su aprobación para su salida de bóveda. </p>";
                    break;
                    
                }
            echo"
                <div class='modal fade bd-example-modal-xl' id='Modal_ticket_alerta_por_aprobar' tabindex='-1' role='dialog'
                aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog  modal-xl' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>ALERTA</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                          $mensaje
                            <nav>
                                <div class='nav nav-tabs' id='nav-tab' role='tablist'>
                                    <a class='nav-item nav-link active' id='nav-home-tab' data-toggle='tab' href='#dispone_plazo' role='tab' aria-controls='nav-home' aria-selected='true'>Tickets por aprobar (".$cuenta_dis.")</a>
                                </div>
                            </nav>
                            <div class='tab-content' id='nav-tabContent'>
                                <div class='tab-pane fade show active' id='dispone_plazo' role='tabpanel' aria-labelledby='nav-home-tab'>
                                    <div class='container-fluid my-3'>";
            $tab_prest = self::tabla_tickets_por_aprobar($datos_dis);
            echo"
                                    </div>
                                </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>";
        }
    }
    public function alertas_tickets_cancelados()
    {
        $perfil = $_SESSION['ses_id_perfil'];
        $sub = $_SESSION['ses_id_sub_admin'];
        $dep = $_SESSION['ses_id_depto'];
        $datos_CANCEL = self::tickets_cancelados_por_analistas($perfil, $sub, $dep);
        
        if (isset($datos_CANCEL)) {
            $cuenta_dis = count($datos_CANCEL);
        } else {
            $cuenta_dis = 0;
        }
        if (isset($datos_CANCEL)) {
            switch ($perfil) {
                    case 1:
                    $mensaje ="<P>Hay tickets cancelados.</p>";
                    break;
                    case 2:
                    $mensaje ="<P>Tú ticket ha sido cancelado aqui podras verificar el motivo</p>";
                    break;
                    case 9:
                    $mensaje ="<P>Tú ticket ha sido cancelado aqui podras verificar el motivo </p>";
                    break;
                    case 4:
                    $mensaje =" <P>Los tickets de su equipo se solicitaron fueron cancelados,aqui podras revisar cuales fueron y a quien se los cancelaron.
                    <br>Avisa a tu analista para que tambien revise su sitio. </p>";
                    break;
                    case 10:
                    $mensaje =" <P>Los tickets de su equipo se solicitaron correctamente, pero requieren aprobacioón para su salida de bóveda.
                    <br>Esta aprobación se dara por el subadministrador te su área4. </p>";
                    break;
                    case 11:
                    $mensaje =" <P>Los siguientes tickets requieren de tu aprobación para su salida de bóveda. </p>";
                    break;
                    case 5:
                    $mensaje =" <P>Los siguientes tickets requieren de tu aprobación para su salida de bóveda. </p>";
                    break;
                    
                }
            echo"
                <div class='modal fade bd-example-modal-xl' id='Modal_ticket_alerta_cancelados_2' tabindex='-1' role='dialog'
                aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog  modal-xl' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>ALERTA</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                          $mensaje
                            <nav>
                                <div class='nav nav-tabs' id='nav-tab' role='tablist'>
                                    <a class='nav-item nav-link active' id='nav-home-tab' data-toggle='tab' href='#dispone_plazo' role='tab' aria-controls='nav-home' aria-selected='true'>Tickets Cancelados (".$cuenta_dis.")</a>
                                </div>
                            </nav>
                            <div class='tab-content' id='nav-tabContent'>
                                <div class='tab-pane fade show active' id='dispone_plazo' role='tabpanel' aria-labelledby='nav-home-tab'>
                                    <div class='container-fluid my-3'>";
            $tab_prest = self::tabla_tickets_cancelados_por_revisar($datos_CANCEL);
            echo"
                                    </div>
                                </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>";
        }
    }
    public function alertasgenera()
    {
        $perfil = $_SESSION['ses_id_perfil'];
        $sub = $_SESSION['ses_id_sub_admin'];
        $dep = $_SESSION['ses_id_depto'];
        //Se hace la petificion a la base de datos
        $datos_prest = self::Prestamos_fuera_de_plazo($perfil, $sub, $dep);
        $datos_pet = self::Peticiones_fuera_de_plazo($perfil, $sub, $dep);
        $datos_busq = self::Busquedas_fuera_de_plazo($perfil, $sub, $dep);
        $datos_parcial = self::Devoluciones_parciales_fuera_de_plazo($perfil, $sub, $dep);
        if (isset($datos_prest)) {
            $cuenta_prest = count($datos_prest);
        } else {
            $cuenta_prest = 0;
        }
        if (isset($datos_pet)) {
            $cuenta_pet = count($datos_pet);
        } else {
            $cuenta_pet = 0;
        }
        if (isset($datos_busq)) {
            $cuenta_busq = count($datos_busq);
        } else {
            $cuenta_busq = 0;
        }
        if (isset($datos_parcial)) {
            $cuenta_parcial = count($datos_parcial);
        } else {
            $cuenta_parcial = 0;
        }
        //  $datos_gen = array($datos_prest,$datos_pet,$datos_busq,$datos_parcial);
        //se valida que tenga datos la busqueda
        if (isset($datos_prest) || isset($datos_pet) || isset($datos_busq) || isset($datos_parcial)) {
            echo"
                <div class='modal fade bd-example-modal-xl' id='Modal_pendientes' tabindex='-1' role='dialog'
                aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog  modal-xl' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='exampleModalLabel'>TICKET´S FUERA DE PLAZO</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <P> Proximos seguimientos: </p>
                            <nav>
                                <div class='nav nav-tabs' id='nav-tab' role='tablist'>
                                    <a class='nav-item nav-link active' id='nav-home-tab' data-toggle='tab' href='#Prestamos_plazo' role='tab' aria-controls='nav-home' aria-selected='true'>T. Préstamo (".$cuenta_prest.")</a>
                                    <a class='nav-item nav-link' id='busqueda_plazos' data-toggle='tab' href='#busquedas_fuera_de_tiempo' role='tab' aria-controls='busqueda_plazo' aria-selected='false'>T. Búsqueda (".$cuenta_busq.")</a>
                                    <a class='nav-item nav-link' id='peticion_plazos' data-toggle='tab' href='#peticion_plazo' role='tab' aria-controls='peticion_plazo' aria-selected='false'>T. Petición (".$cuenta_pet.")</a>
                                    <a class='nav-item nav-link' id='parcial_plazos' data-toggle='tab' href='#parcial_plazo' role='tab' aria-controls='parcial_plazo' aria-selected='false'>T. dev. Parcial (".$cuenta_parcial.")</a>
                                </div>
                            </nav>
                            <div class='tab-content' id='nav-tabContent'>
                                <div class='tab-pane fade show active' id='Prestamos_plazo' role='tabpanel' aria-labelledby='nav-home-tab'>
                                    <div class='container-fluid my-3'>";
            $tab_prest = self::tabla_prest($datos_prest);
            echo"
                                    </div>
                                </div>
                                <div class='tab-pane fade' id='busquedas_fuera_de_tiempo' role='tabpanel' aria-labelledby='nav-home-tab'>
                                <div class='container-fluid my-3'>";
            $tab_busq = self::tabla_busq($datos_busq);
            echo"
                                </div>
                            </div>
                                <div class='tab-pane fade' id='peticion_plazo' role='tabpanel' aria-labelledby='peticion_plazo'>
                                    <div class='container-fluid my-3'>";
            $tab_pet = self::tabla_pet($datos_pet);
            echo"
                                    </div>
                                </div>
                                <div class='tab-pane fade' id='parcial_plazo' role='tabpanel' aria-labelledby='parcial_plazo'>
                                    <div class='container-fluid my-3'>";
            $tab_parcial = self::tabla_parcial($datos_parcial);
            echo"
                                    
                                    </div>
                                </div>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
        }
        //Se genera Modal para vista de los ususarios
    }
    public function Actualizar_propietario_ticket($Nuevo_us, $ticket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        //Se genera la consulta de informacion de los determinantes en el numero de Ticket
        $filas = self::Consulta_det_x_user_asignadas_a_procesos($ticket, $Nuevo_us);
        if (isset($filas)) { //Se valida que tenga información la busqueda de determinantes
            $user_alta = $filas[0]['user_alta'];
            if ($user_alta != $Nuevo_us) { //Se valida que el nuevo propietario no sea el mismo analista
                for ($i=0; $i < count($filas) ; $i++) {
                    self::Crea_cambios_etapa_x_det($filas[$i]['Estatus_proc'], $filas[$i]['determinantes'], $ticket, $Nuevo_us);
                }
                //self::Crea_cambios_etapa_x_det($filas, $ticket, $Nuevo_us); //se manda el array de datos junto con el numero de ticket y el usuario para crear las etapas a nombre del nuevo propietario
                self::baja_etapas_anteriores_al_cambio($Nuevo_us, $ticket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                $query = "UPDATE Tikets SET user_mov = '$Nuevo_us' WHERE id_tiket = $ticket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                $prepare = sqlsrv_query($con, $query);
                if ($prepare) {
                    return 'Se realizo el cambio de propietario';
                    $conexion->CerrarConexion($con);
                } else {
                    return 'No se efectuo el cambio de propietario';
                    $conexion->CerrarConexion($con);
                }
            } else {
                return "No se puede asignar un Ticket al mismo usuario";
            }
        } else {
            return 'No tiene determinantes asignadas al ticket: ' . $ticket;
        }
    }

    public function Consulta_user_mov_x_dia()
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $user = $_SESSION['ses_rfc_corto'];
        $query = "SELECT  
        det.RDFDA,
        det.id_determinante,
        contri.rfc,
        contri.razon_social,
        tik.user_mov,
        tik.id_tiket,
        Emp.nombre_empleado,
        det.num_determinante,
        etapa.fecha_alta,
        etapa.user_alta,
        etapa.id_proc_det,
        tik.id_proc
        FROM Etapa_poc etapa
        INNER JOIN Determinante det ON det.id_determinante=etapa.id_determinante
        INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
        INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
        INNER JOIN Tikets tik ON etapa.id_tiket = tik.id_tiket
        INNER JOIN Empleado Emp ON TIk.user_mov = Emp.rfc_corto
        WHERE etapa.user_valida = '$user' 
       and ( etapa.id_proc_det = 16 AND etapa.estatus = 'N') ORDER BY etapa.fecha_valida DESC ";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Consulta_user_mov_x_dia_en_cadena($datos)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $user = $_SESSION['ses_rfc_corto'];
        $query = "SELECT  
        det.RDFDA,
        det.id_determinante,
        contri.rfc,
        contri.razon_social,
        tik.user_mov,
        tik.id_tiket,
        Emp.nombre_empleado,
        det.num_determinante,
        etapa.fecha_alta,
        etapa.user_alta,
        etapa.id_proc_det,
        tik.id_proc
        FROM Etapa_poc etapa
        INNER JOIN Determinante det ON det.id_determinante=etapa.id_determinante
        INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
        INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
        INNER JOIN Tikets tik ON etapa.id_tiket = tik.id_tiket
        INNER JOIN Empleado Emp ON TIk.user_mov = Emp.rfc_corto
        WHERE det.id_determinante = $datos and etapa.user_valida = '$user' 
       and ( etapa.id_proc_det = 16 AND etapa.estatus = 'N') ORDER BY etapa.fecha_valida DESC ";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Consulta_datos_tiket($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT
        emp.nombre_empleado 
        ,emp.rfc_corto
        FROM Tikets tik
        INNER JOIN Empleado emp ON emp.rfc_corto = tik.user_mov
        WHERE id_tiket = $tiket AND tik.estatus = 'A'";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Consulta_code_bar($consulta)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT distinct
        det.RDFDA,
        det.id_determinante,
        contri.rfc,
        contri.razon_social,
        tik.user_mov,
        tik.id_tiket,
        Emp.nombre_empleado,
        det.num_determinante,
        etapa.fecha_alta,
        etapa.user_alta,
        etapa.id_proc_det,
        tik.id_proc
        FROM Etapa_poc etapa
        INNER JOIN Determinante det ON det.id_determinante=etapa.id_determinante
        INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
        INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
        INNER JOIN Tikets tik ON etapa.id_tiket = tik.id_tiket
        INNER JOIN Empleado Emp ON TIk.user_mov = Emp.rfc_corto
        WHERE etapa.id_tiket=$consulta 
        AND (etapa.id_proc_det = 2 AND etapa.estatus = 'A' 
		OR etapa.id_proc_det = 7 AND etapa.estatus = 'A' 
        OR etapa.id_proc_det = 11 AND etapa.estatus = 'A'
        OR etapa.id_proc_det = 8 AND etapa.estatus = 'A'
        OR etapa.id_proc_det = 5 AND etapa.estatus = 'A') 
		OR det.id_determinante = $consulta 
		AND (etapa.id_proc_det = 2 AND etapa.estatus = 'A' 
		OR etapa.id_proc_det = 7 AND etapa.estatus = 'A' 
        OR etapa.id_proc_det = 11 AND etapa.estatus = 'A'
        OR etapa.id_proc_det = 8 AND etapa.estatus = 'A'
        OR etapa.id_proc_det = 5 AND etapa.estatus = 'A')";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }

    public function Consulta_det_x_user($Emp_1)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT * FROM Determinante WHERE id_empleado =$Emp_1";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function estatus_ticket($ticket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT * FROM Tikets WHERE id_tiket = $ticket";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $proceso[] =  $rows['id_proc'];
            }
            sqlsrv_close($con);
            if (isset($proceso)) {
                return $procesos;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Consulta_det_x_user_asignadas_a_procesos($ticket, $RFC_CORTO)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT id_proc_det
        ,user_alta
        ,fecha_alta
        ,id_determinante
        ,user_valida
        ,fecha_valida
        ,id_tiket
        ,estatus
        ,fecha_mod
        ,estatus_det_cam FROM Etapa_poc WHERE id_tiket = $ticket  AND estatus = 'A'";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] =  array(
                    'determinantes' => $rows['id_determinante'],
                    'Estatus_proc' => $rows['id_proc_det'],
                    'user_alta' => $rows['user_alta'],
                    'fecha_alta' => $rows['fecha_alta'],
                    'user_valida' => $rows['user_valida'],
                    'fecha_valida' => $rows['fecha_valida'],
                    'id_tiket' => $rows['id_tiket'],
                    'estatus' => $rows['estatus'],
                    'fecha_mod' => $rows['fecha_mod']
                );
            }
            sqlsrv_close($con);
            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }

    public function Consulta_det_x_user_asignadas_a_procesos_1($ticket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT top(1) * FROM Etapa_poc WHERE id_tiket = $ticket AND estatus = 'A'";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $rows;
            }
            sqlsrv_close($con);
            if (isset($fila)) {
                return $fila;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Actualizar_cartera_cambios($Emp_1, $Emp_2)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        //$user_alta = $_SESSION["ses_rfc_corto"];
        $datos = self::Consulta_det_x_user($Emp_1);
        if (isset($datos)) {
            for ($i = 0; $i < count($datos); $i++) {
                self::Guarda_cambios($datos[$i]['id_determinante'], $datos[$i]['estatus'], $Emp_1, $Emp_2);
            }
            $query = "UPDATE Determinante SET id_empleado = $Emp_2 WHERE id_empleado = $Emp_1 ";
            $prepare = sqlsrv_query($con, $query);
            if ($prepare) {
                return 'Se realizo el cambio en la cartera';
                $conexion->CerrarConexion($con);
            } else {
                return false;
                $conexion->CerrarConexion($con);
            }
        } else {
            return 'El analista no cuenta con cartera asignada, revise nuevamente su solicitud.';
        }
    }
    public static function Guarda_cambios($determinante, $estatus, $Emp_1, $Emp_2)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $USU = $_SESSION["ses_rfc_corto"];
        $query = "INSERT INTO Cambios_cartera 
        (id_empleado_act,id_empleado_cambio,id_determinante,fecha_cambio,user_cambio,estatus_cred)
        values( $Emp_1,$Emp_2,$determinante,GETDATE(),'$USU','$estatus')
        ";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }
    public static function baja_etapas_anteriores_al_cambio($Nuevo_us, $ticket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $USU = $_SESSION["ses_rfc_corto"];
        $query = "UPDATE Etapa_poc SET estatus = 'N' WHERE  user_alta != '$Nuevo_us' AND id_tiket = $ticket";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }
    public static function baja_etapas_anteriores_al_cambio_BUSQUEDA($ticket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $USU = $_SESSION["ses_rfc_corto"];
        $query = "UPDATE Etapa_poc SET estatus = 'N' WHERE  id_proc_det = 2 AND id_tiket = $ticket AND estatus = 'A'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }

    public static function baja_etapas_anteriores_al_cambio_cancel($ticket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $USU = $_SESSION["ses_rfc_corto"];
        $query = "UPDATE Etapa_poc SET estatus = 'N' WHERE  (id_proc_det = 2 OR id_proc_det = 7 OR id_proc_det = 11) AND id_tiket = $ticket AND estatus = 'A'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }
    public static function baja_etapas_anteriores_al_cambio_pet_dev($ticket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $USU = $_SESSION["ses_rfc_corto"];
        $query = "UPDATE Etapa_poc SET estatus = 'N' WHERE  id_proc_det = 8 AND id_tiket = $ticket AND estatus = 'A'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }
    public static function baja_etapas_anteriores_al_cambio_pet_dev_interna_bov($ticket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $USU = $_SESSION["ses_rfc_corto"];
        $query = "UPDATE Etapa_poc SET estatus = 'N' WHERE  id_proc_det = 8 AND id_tiket = $ticket AND estatus = 'A'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }
    public static function baja_etapas_anteriores_al_cambio_caduc_dispo($ticket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $USU = $_SESSION["ses_rfc_corto"];
        $query = "UPDATE Etapa_poc SET estatus = 'N' WHERE  id_proc_det = 11 AND id_tiket = $ticket AND estatus = 'A'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }
    public static function baja_etapas_anteriores_al_cambio_caduc_peticion($ticket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $USU = $_SESSION["ses_rfc_corto"];
        $query = "UPDATE Etapa_poc SET estatus = 'N' WHERE  id_proc_det = 2 OR id_proc_det = 7 AND id_tiket = $ticket AND estatus = 'A'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }
    public static function baja_etapas_anteriores_al_cambio_pet_dev_parc($ticket, $RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $USU = $_SESSION["ses_rfc_corto"];
        $query = "UPDATE Etapa_poc SET estatus = 'N' WHERE  id_proc_det = 5 AND id_tiket = $ticket AND id_determinante = (SELECT id_determinante FROM Determinante WHERE RDFDA ='$RDFDA') AND estatus = 'A'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }
    public static function baja_etapas_anteriores_al_cambio_pet_dev_comp($ticket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $USU = $_SESSION["ses_rfc_corto"];
        $query = "UPDATE Etapa_poc SET estatus = 'N', fecha_mod = GETDATE()  WHERE  id_proc_det = 5 AND id_tiket = $ticket AND estatus = 'A'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }
    public static function baja_etapas_anteriores_al_cambio_prest($ticket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $USU = $_SESSION["ses_rfc_corto"];
        $query = "UPDATE Etapa_poc SET estatus = 'N' WHERE  (id_proc_det = 2 OR id_proc_det = 7 OR id_proc_det = 11) AND id_tiket = $ticket AND estatus = 'A'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }
    public static function baja_etapas_anteriores_al_cambio_dispo($ticket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $USU = $_SESSION["ses_rfc_corto"];
        $query = "UPDATE Etapa_poc SET estatus = 'N' WHERE  (id_proc_det = 2 OR id_proc_det = 7) AND id_tiket = $ticket AND estatus = 'A'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }
    public static function Crea_cambios_etapa_x_det($estatus_det, $determinante, $ticket, $Nuevo_us)
    { //Se hace prueba de llegada de datos al metodo
        //$datos = array($determinante,$RFC_CORTO,$user_valida,$proceso,$ticket);
        //return $datos;
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_valida = $_SESSION['ses_rfc_corto'];
        $query = "INSERT INTO Etapa_poc (
                id_proc_det,
                user_alta,
                fecha_alta,
                id_determinante,
                user_valida,
                fecha_valida,
                id_tiket,
                estatus,
                fecha_mod
                )
               VALUES (
                $estatus_det,
               '$Nuevo_us'
               ,GETDATE(),
               $determinante,
               '$user_valida'
               ,GETDATE()
               ,$ticket
               ,'A'
               ,GETDATE()
               )
            ";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego el cambio correctamente.";
        }
    }
    public static function universo_datos_expedientes_filtrado($busqueda)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_admin = $_SESSION["ses_id_admin"];
        $id_perfil = $_SESSION["ses_id_perfil"];
        $id_depto = $_SESSION["ses_id_depto"];
        $user = $_SESSION["ses_id_usuario"];
        switch ($id_perfil) {
            case 1:
                $condicion = "";
                break;
                case 9:
                    $condicion = "";
                    break;
                    case 10:
                        $condicion = "";
                        break;
                case 11:
                    $condicion = "";
                    break;
                    case 12:
                        $condicion = "";
                        break;
            case 8:
                $condicion = "";
                break;
            case 7:
                $condicion = "";
                break;
            case 2:

                $condicion = " where 
                emp.id_empleado  = $user 
                OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo = $user AND id_admin = $id_admin)
                OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT id_empleado FROM Empleado WHERE jefe_directo =$user ) AND id_admin =  $id_admin )
                OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT id_empleado FROM Empleado WHERE jefe_directo = $user)))";
            
                 break;
                 case 4:

                    $condicion = " where 
                    emp.id_empleado  = $user 
                    OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo = $user AND id_admin = $id_admin)
                    OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT id_empleado FROM Empleado WHERE jefe_directo =$user ) AND id_admin =  $id_admin )
                    OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT id_empleado FROM Empleado WHERE jefe_directo = $user)))";
                
                break;
                         
        }

        $query = "	 SELECT COUNT(*) AS total
        FROM (SELECT
		ROW_NUMBER() OVER(ORDER BY (fecha_determinante) Asc) AS seq,
        emp.id_empleado,
        emp.nombre_empleado,
        Dep.nombre_depto,
        Sub.nombre_sub_admin,
        Adm.nombre_admin,
        id_proc,
        id_determinante,
        RDFDA,
        rfc,
        razon_social,
        num_determinante,
        fecha_determinante,
        (SELECT nombre_autoridad FROM Autoridad where id_autoridad=det.id_autoridad) as autoridad
        from [Determinante] det
        INNER JOIN Empleado emp ON emp.id_empleado=det.id_empleado
        INNER JOIN Departamento Dep ON emp.id_depto=Dep.id_depto
        INNER JOIN SubAdmin Sub ON emp.id_sub_admin=Sub.id_sub_admin
        INNER JOIN Administracion Adm ON emp.id_admin=Adm.id_admin
        LEFT JOIN Expediente expe ON expe.id_expediente=det.id_expediente
        LEFT JOIN Contribuyente c ON c.id_contribuyente=expe.id_contribuyente
        $condicion ) bus WHERE
        (bus.rfc = '$busqueda' 
        OR  bus.razon_social LIKE '%$busqueda%'
        OR  bus.num_determinante = '$busqueda')";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public function Consulta_Admin()
    {
        include_once("php/conexion.php");
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT * FROM Administracion 
        WHERE estatus = 'A'
        ORDER BY nombre_admin ASC";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Consulta_lista_carrito($user)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT 
        RDFDA,
        num_determinante,
        razon_social,
        contri.rfc,
        aut.nombre_autoridad,
        etapa.id_tiket
        FROM Determinante Det
        INNER JOIN Expediente expe ON expe.id_expediente = Det.id_expediente
        INNER JOIN Contribuyente contri ON contri.id_contribuyente = expe.id_contribuyente
        INNER JOIN Etapa_poc Etapa ON Det.id_determinante = Etapa.id_determinante
        INNER JOIN Autoridad aut ON Det.id_autoridad = aut.id_autoridad
        Where Etapa.id_proc_det = 10 and Etapa.user_alta = '$user'";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public static function inserta_Observacion($datos)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $RDFDA = $_SESSION["RDFDA_ob_clic"];
        $USU = $_SESSION["ses_rfc_corto"];
        $tiket = $_SESSION["tiket_obs"];
        // return $RDFDA;
        $query = "INSERT INTO Observaciones 
        (id_determinante,observacion,user_alta,fecha_alta,id_des,Tiket)
        values(
        (select id_determinante from Determinante where RDFDA='$RDFDA'),
        '".$datos['observa']."','$USU',GETDATE(),
        (select id_des from Descripciones where Descripcion='" . $datos['Des'] . "'),$tiket
        )
      ";


        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego correctamente el comentario";
        }
    }
    public static function inserta_Observacion_dev($datos)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $RDFDA = $_SESSION["RDFDA_ob_clic_dev"];
        $USU = $_SESSION["ses_rfc_corto"];
        $tiket = $_SESSION["tiket_estatus"];
        // return $RDFDA;
        $query = "INSERT INTO Observaciones 
        (id_determinante,observacion,user_alta,fecha_alta,id_des,Tiket)
        values(
        (select id_determinante from Determinante where RDFDA='$RDFDA'),
        '" . $datos['observa'] . "','$USU',GETDATE(), (select id_des from Descripciones where Descripcion='" . $datos['Des'] . "'),$tiket
        )
      ";


        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return "Se agrego correctamente el comentario";
        }
    }
    public function Consulta_Local()
    {
        include_once("php/conexion.php");
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI?N
        //SE MANDA A LLAMAR LA CONEXI?N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT * FROM Administracion WHERE estatus = 'A' ORDER BY nombre_admin ASC";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI?N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Busca_Conincidir_aut($num_autoridad)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI?N
        //SE MANDA A LLAMAR LA CONEXI?N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT * FROM [Autoridad] WHERE num_Autoridad = $num_autoridad";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI?N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Consulta_Autoridad()
    {
        include_once("php/conexion.php");
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI?N
        //SE MANDA A LLAMAR LA CONEXI?N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT * FROM Autoridad WHERE estatus = 'A' Order by nombre_autoridad asc ";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI?N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Consulta_Autoridad_especifica($id_autoridad)
    {
        include_once("php/conexion.php");
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI?N
        //SE MANDA A LLAMAR LA CONEXI?N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT * FROM Autoridad WHERE estatus = 'A' AND id_autoridad = $id_autoridad ";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI?N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Consulta_estatus_act_ticket($tiket)
    {
        include_once "conexion.php";
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI?N
        //SE MANDA A LLAMAR LA CONEXI?N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT id_proc FROM Tikets WHERE id_tiket = $tiket";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI?N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas = $rows['id_proc'];
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Consulta_empleado()
    {
        include_once("php/conexion.php");
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI?N
        //SE MANDA A LLAMAR LA CONEXI?N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT 
        sub.rfc_corto,
        sub.id_empleado,
        sub.no_empleado,
        sub.nombre_empleado,
        sub.correo,
        sub.id_admin,
        lo.nombre_admin,
        sub.id_sub_admin,
        area.nombre_sub_admin,
        sub.id_depto,
        depa.nombre_depto
        FROM Empleado AS sub 
        INNER JOIN Administracion lo on lo.id_admin = sub.id_admin
        INNER JOIN SubAdmin area on area.id_sub_admin = sub.id_sub_admin
        INNER JOIN Departamento depa on depa.id_depto = sub.id_depto
        WHERE sub.estatus = 'A'
        ORDER BY (sub.fecha_alta) DESC ";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI?N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }

    public function Consulta_Sub($id_admin)
    {
        include_once("php/conexion.php");
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT * FROM SubAdmin 
        WHERE estatus = 'A'
        AND id_admin = $id_admin 
        ORDER BY nombre_sub_admin ASC";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }

    public function Consulta_Dep($id_admin)
    {
        include_once("php/conexion.php");
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXI�N
        //SE MANDA A LLAMAR LA CONEXI�N Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT * FROM [Departamento] 
        WHERE estatus = 'A'
        AND id_admin = $id_admin 
        ORDER BY nombre_depto ASC";
        //SE VALIDA EL QUERY CON FORME A LA CONEXI�N
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $rows;
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }
    public function Leer_archivo_Autoridad()
    {
        include_once 'php/Classes/PHPExcel.php';
        include_once 'php/Classes/PHPExcel/Reader/Excel2007.php';
        $objReader = new PHPExcel_Reader_Excel2007();
        $objFecha = new PHPExcel_Shared_Date();
        $id_user = $_SESSION["ses_id_usuario"];
        $ruta = "temp_files/carga_nueva$id_user.xlsx";
        if (is_file($ruta)) {
            $objPHPExcel = $objReader->load($ruta);

            // Asignar hoja de excel activa
            $objPHPExcel->setActiveSheetIndex(0);
            $i = 0; //posición 0 del arreglo
            $j = 2; //desde que fila se cuenta
            $_DATOS_EXCEL[] = null;
            do {
                $_DATOS_EXCEL[$i]['Id_Autoridad_Determ'] = $objPHPExcel->getActiveSheet()->getCell('A' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Autoridad_determ'] = $objPHPExcel->getActiveSheet()->getCell('B' . $j)->getCalculatedValue();
                $i++;
                $j++;
            } while ($j < 100);

            $numerador = 1;
            $html[] = null;
            for ($i = 0; $i < count($_DATOS_EXCEL); $i++) {
                $html[$i] = self::rows_leer_archivo($_DATOS_EXCEL[$i], $numerador);
                $numerador++;
            }


            echo "
             <div class='text-center py-3'>
                    <button class='btn btn-dark btn_sat_black text-white' onclick='ConfirmarCargaAut(1)'>Confirmar carga</button>
                    <button class='btn btn-secondary' onclick='ConfirmarCargaAut(2)'>Cancelar</button>
             </div>
             <table class='table table-sm table-striped'>
             <thead>
               <tr>
                 <th scope='col'>#</th>
                 <th scope='col'>Id_Autoridad_Determ</th>
                 <th scope='col'>Autoridad_determ</th>
               </tr>
             </thead>
             <tbody>";

            for ($i = 1; $i < count($html); $i++) {
                echo $html[$i];
            }

            echo "</tbody>
            </table>";
        } else {
            echo "<p class='h1 vh-100'>No se ha cargado ningun archivo aún.</p>";
        }
    }
    public static function rows_leer_archivo($datos, $numerador)
    {
        include_once 'php/MetodosUsuarios.php';
        $usuarios = new MetodosUsuarios();

        $error_a = "<span class='d-inline-block' data-toggle='tooltip' data-placement='top' data-html='true' title='<b>Autoridad ingresada con anterioridad.</b>'>
                        <i class='fas fa-exclamation-circle text-warning'></i>
                    </span>";
        $valido_a = "<span class='d-inline-block' data-toggle='tooltip' data-placement='top' data-html='true' title='<b>Analista valido.</b>'>
                    <i class='fas fa-check-circle text-success'></i>
            </span>";


        if (self::Consulta_aut_exist($datos["Id_Autoridad_Determ"]) == false) {
            $autoridad_identificado = $valido_a;
        } else {
            $autoridad_identificado = $error_a;
        }

        $html = "<tr>
                    <th scope='row'>$numerador</td>
                    <td>" . $datos["Id_Autoridad_Determ"] . "</td>
                    <td>" . $datos["Autoridad_determ"] . "</td>
                    <td>$autoridad_identificado</td>
                </tr>";
        return $html;
    }

    public static function Consulta_aut_exist($id_autoridad)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE CREA UN QUERY
        $query = "SELECT * FROM Autoridad WHERE (num_Autoridad = $id_autoridad) ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas = array('autoridad' => $row["nombre_autoridad"]);
            }
            if (isset($filas)) {
                return $filas;
            } else {
                return false;
            }
            $conexion->CerrarConexion($con);
        } else {
            return false;
        }
    }
    public function Insertar_Autoridades()
    {
        include_once 'Classes/PHPExcel.php';
        include_once 'Classes/PHPExcel/Reader/Excel2007.php';
        include_once 'sesion.php';
        include_once 'MetodosUsuarios.php';
        $usuarios = new MetodosUsuarios();
        $objReader = new PHPExcel_Reader_Excel2007();
        $id_user = $_SESSION["ses_id_usuario"];
        $ruta = "../temp_files/carga_nueva$id_user.xlsx";

        $objPHPExcel = $objReader->load($ruta);

        // Asignar hoja de excel activa
        $objPHPExcel->setActiveSheetIndex(0);
        $j = 3; //desde que fila se cuenta
        do {
            $_DATOS_EXCEL['Id_Autoridad_Determ'] = $objPHPExcel->getActiveSheet()->getCell('A' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['Autoridad_determ'] = $objPHPExcel->getActiveSheet()->getCell('B' . $j)->getCalculatedValue();

            $llave = self::Consulta_aut_exist($_DATOS_EXCEL["Id_Autoridad_Determ"]);

            if ($llave == false) {
                if ($error_c = self::Crear_Autoridad($_DATOS_EXCEL) != true) {
                    $errores[] = array('id_au' => $_DATOS_EXCEL['Id_Autoridad_Determ'], 'error' => "No se pudo crear la Autoridad; " . $error_c);
                }
            } else {
                $errores[] = array('id_au' => $_DATOS_EXCEL['Id_Autoridad_Determ'], 'error' => "Autoridad registrada con anterioridad; ");
            }


            $j++;
        } while (($objPHPExcel->getActiveSheet()->getCell('A' . $j)->getCalculatedValue() != null));

        unlink($ruta);
        if (isset($errores)) {
            $formato = self::Formato_error($errores);
        } else {
            $formato = self::Formato_exito();
        }
        echo $formato;
    }
    public static function Crear_Autoridad($datos)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        include_once 'Classes/PHPExcel.php';
        include_once 'Classes/PHPExcel/Reader/Excel2007.php';
        //  include_once 'MantenimientoEntrevistas.php';
        // $entrevistas = new MantenimientoEntrevistas();
        $objFecha = new PHPExcel_Shared_Date();
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $num = $datos["Id_Autoridad_Determ"];
        $nombre_aut = $datos["Autoridad_determ"];
        $usuario = $_SESSION["ses_rfc_corto"];



        $query = "  insert into Autoridad (nombre_autoridad,num_Autoridad,fecha_alta,user_alta,estatus)
        values ('$nombre_aut'," . $num . ",GETDATE(),'$usuario','A' ) ";


        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return true;
        }
    }
    public static function Crear_Subadmin($id_admin, $nombre_sub_admin)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $usuario = $_SESSION["ses_rfc_corto"];
        $query = "  INSERT INTO [SubAdmin] ([nombre_sub_admin],[id_admin],fecha_alta,user_alta,estatus)
        VALUES ('$nombre_sub_admin'," . $id_admin . ",GETDATE(),'$usuario','A' ) ";


        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return true;
        }
    }
    public static function Crear_Admin($nombre_admin, $nombre_admin_corto)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $usuario = $_SESSION["ses_rfc_corto"];
        $query = " INSERT INTO Administracion
         (nombre_admin,
         nombre_corto,
         fecha_alta,
         user_alta,
         estatus)
        VALUES 
        ('$nombre_admin',
        '$nombre_admin_corto'
        ,GETDATE(),
        '$usuario',
        'A')";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return true;
        }
    }
    public function Actualizar_datos_admin($admin, $nombre_admin_cam, $nombre_cort_admin_cam, $estatus)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_alta = $_SESSION["ses_rfc_corto"];
        switch ($estatus) {
            case 'A':
                $query = "UPDATE Administracion 
                    SET nombre_admin = '$nombre_admin_cam',
                    nombre_corto = '$nombre_cort_admin_cam' ,
                    fecha_baja = GETDATE(),
                    user_baja = '$user_alta' ,
                    estatus = 'A'
                    WHERE id_admin = $admin ";
                break;
            case 'N':
                $query = "UPDATE Administracion 
                    SET nombre_admin = '$nombre_admin_cam',
                    nombre_corto = '$nombre_cort_admin_cam' ,
                    fecha_baja = GETDATE(),
                    user_baja = '$user_alta' ,
                    estatus = 'N'
                    WHERE id_admin = $admin ";
                break;
            default:
                $query = "UPDATE Administracion 
                    SET nombre_admin = '$nombre_admin_cam',
                    nombre_corto = '$nombre_cort_admin_cam',
                    fecha_baja = GETDATE(),
                    user_baja = '$user_alta' ,
                    WHERE id_admin = $admin ";
                break;
        }
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            return true;
            $conexion->CerrarConexion($con);
        } else {
            return false;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Crear_dep($id_admin, $id_sub_admin, $nombre_dep)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $usuario = $_SESSION["ses_rfc_corto"];
        $query = "   INSERT INTO [dbo].[Departamento] (id_admin,id_sub_admin,nombre_depto,fecha_alta,user_alta,estatus)
        VALUES ($id_admin,$id_sub_admin,'$nombre_dep',GETDATE(),'$usuario','A')";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return true;
        }
    }
    public function Actualizar_datos_area($admin, $sub_admin_asoc, $nombre_sub, $estatus)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_alta = $_SESSION["ses_rfc_corto"];
        switch ($estatus) {
            case 'A':
                $query = "
                update SubAdmin  
                set nombre_sub_admin = '$nombre_sub'
                , id_admin = $admin 
                , user_mod = '$user_alta'
                , estatus = 'A'
                ,fecha_mod = GETDATE()
                where id_sub_admin = $sub_admin_asoc";
                break;
            case 'N':
                $query = "
                update SubAdmin  
                set nombre_sub_admin = '$nombre_sub'
                , id_admin = $admin 
                , user_mod = '$user_alta'
                , estatus = 'N'
                ,fecha_mod = GETDATE()
                where id_sub_admin = $sub_admin_asoc";
                break;
            default:
                $query = "
                update SubAdmin  
                set nombre_sub_admin = '$nombre_sub'
                , id_admin = $admin 
                , user_mod = '$user_alta'
                ,fecha_mod = GETDATE()
                where id_sub_admin = $sub_admin_asoc";
                break;
        }

        $prepare = sqlsrv_query($con, $query);
        if ($prepare == true) {
            return 'Se actualizo Exitosamente';
            $conexion->CerrarConexion($con);
        } else {
            return 'Algo no salbio bien';
            $conexion->CerrarConexion($con);
        }
    }
    public function Actualizar_autoridad($id_autoridad, $Nombre_autor, $estatus)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_alta = $_SESSION["ses_rfc_corto"];
        switch ($estatus) {
            case 'A':
                $query = "UPDATE [Autoridad]  
        SET nombre_autoridad = '$Nombre_autor'
        , user_mod = '$user_alta'
        , estatus = 'A'
        ,fecha_mod = GETDATE()
        WHERE id_autoridad = $id_autoridad";
                break;
            case 'N':
                $query = "UPDATE [Autoridad]  
        SET nombre_autoridad = '$Nombre_autor'
        , user_mod = '$user_alta'
        , estatus = 'A'
        ,fecha_mod = GETDATE()
        WHERE id_autoridad = $id_autoridad";
                break;
            default:
                $query = "UPDATE [Autoridad]  
        SET nombre_autoridad = '$Nombre_autor'
        , user_mod = '$user_alta'
        ,fecha_mod = GETDATE()
        WHERE id_autoridad = $id_autoridad";
                break;
        }

        $prepare = sqlsrv_query($con, $query);
        if ($prepare == true) {
            return 'Se actualizo Exitosamente';
            $conexion->CerrarConexion($con);
        } else {
            return 'Algo no salbio bien';
            $conexion->CerrarConexion($con);
        }
    }
    public function Regis_autoridad($num_autoridad, $Nombre_autor)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_alta = $_SESSION["ses_rfc_corto"];
        $filtro = self::Busca_Conincidir_aut($num_autoridad);
        if (isset($filtro)) {
            return 'Esta autoridad ya se encuentra registrada, favor de validar nuevamente';
        } else {
            $query = "  INSERT INTO Autoridad (
                [nombre_autoridad]
                    ,[num_Autoridad]
                    ,[fecha_alta]
                    ,[user_alta]
                    ,[estatus])
                    VALUES('$Nombre_autor',$num_autoridad,GETDATE(),'$user_alta','A')";
            $prepare = sqlsrv_query($con, $query);
            if ($prepare == true) {
                return 'Se registro la autoridad Exitosamente';
                $conexion->CerrarConexion($con);
            } else {
                return 'Algo no salbio bien';
                $conexion->CerrarConexion($con);
            }
        }
    }
    public function Actualizar_datos_dep($admin, $sub_admin_asoc, $dep_asoc, $nombre_dep, $estatus)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_alta = $_SESSION["ses_rfc_corto"];
        switch ($estatus) {
            case 'A':
                $query = "UPDATE
                [dbo].[Departamento]
                SET 
                id_admin = $admin,
                id_sub_admin = $sub_admin_asoc 
                , nombre_depto = '$nombre_dep'
                , user_baja = '$user_alta'
                , estatus = 'A'
                ,fecha_baja = GETDATE()
                WHERE id_depto = $dep_asoc";
                break;
            case 'N':
                $query = "UPDATE
                [dbo].[Departamento]
                SET 
                id_admin = $admin,
                id_sub_admin = $sub_admin_asoc 
                , nombre_depto = '$nombre_dep'
                , user_baja = '$user_alta'
                , estatus = 'N'
                ,fecha_baja = GETDATE()
                WHERE id_depto = $dep_asoc";
                break;
            default:
                $query = "UPDATE
                [dbo].[Departamento]
                SET 
                id_admin = $admin,
                id_sub_admin = $sub_admin_asoc 
                , nombre_depto = '$nombre_dep'
                , user_baja = '$user_alta'
                ,fecha_baja = GETDATE()
                WHERE id_depto = $dep_asoc";
                break;
        }

        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            return true;
            $conexion->CerrarConexion($con);
        } else {
            return print_r(sqlsrv_errors(),false);
            $conexion->CerrarConexion($con);
        }
    }
    public static function Formato_error($datos)
    {
        $html = "<div class='alert alert-danger' role='alert'><ul>";
        for ($i = 0; $i < count($datos); $i++) {
            if ($i == 9) {
                $html .= "<a onclick='vermas()' href='#' id='link_ver'>Ver mas</a>
                            <div id='vermasdiv' style='display:none'> 
                                <li>Error con <b>" . $datos[$i]["id_au"] . "</b>: " . $datos[$i]["error"] . "</li>
                            ";
            } else {
                $html .= "<li>Error con <b>" . $datos[$i]["id_au"] . "</b>: " . $datos[$i]["error"] . "</li>";
            }
        }
        if (count($datos) >= 10) {
            $html .= "</div></ul></div>";
        } else {
            $html .= "</ul></div>";
        }
        return $html;
    }
    public static function Formato_exito()
    {
        $html = "<div class='alert alert-success' role='alert'>
                    ¡Carga realizada con éxito!
                </div>";
        return $html;
    }
    public static function ConsultaFecha_Exacta()
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $query = "SELECT TOP 1 GETDATE() AS FECHA_ACTUAL;";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        } else {
            return sqlsrv_errors();
            $conexion->CerrarConexion($con);
        }
    }

    public function Leer_archivo_usuarios()
    {
        include_once 'php/Classes/PHPExcel.php';
        include_once 'php/Classes/PHPExcel/Reader/Excel2007.php';
        $objReader = new PHPExcel_Reader_Excel2007();
        $objFecha = new PHPExcel_Shared_Date();
        $id_user = $_SESSION["ses_id_usuario"];
        $ruta = "temp_files/carga_nueva$id_user.xlsx";
        if (is_file($ruta)) {
            $objPHPExcel = $objReader->load($ruta);

            // Asignar hoja de excel activa
            $objPHPExcel->setActiveSheetIndex(0);
            $i = 0; //posición 0 del arreglo
            $j = 2; //desde que fila se cuenta
            $_DATOS_EXCEL[] = null;
            do {
                $_DATOS_EXCEL[$i]['no_Empleado'] = $objPHPExcel->getActiveSheet()->getCell('A' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Analista'] = $objPHPExcel->getActiveSheet()->getCell('B' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['RFC'] = $objPHPExcel->getActiveSheet()->getCell('C' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Correo'] = $objPHPExcel->getActiveSheet()->getCell('D' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Admin'] = $objPHPExcel->getActiveSheet()->getCell('E' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['SubAdmin'] = $objPHPExcel->getActiveSheet()->getCell('F' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Dpto'] = $objPHPExcel->getActiveSheet()->getCell('G' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Jefe'] = $objPHPExcel->getActiveSheet()->getCell('H' . $j)->getCalculatedValue();
                $i++;
                $j++;
            } while ($j < 100);

            $numerador = 1;
            $html[] = null;
            for ($i = 0; $i < count($_DATOS_EXCEL); $i++) {
                $html[$i] = self::rows_leer_archivo2($_DATOS_EXCEL[$i], $numerador);
                $numerador++;
            }


            echo "
             <div class='text-center py-3'>
                    <button class='btn btn-dark btn_sat_black text-white' onclick='ConfirmarCargaUSU(1)'>Confirmar carga</button>
                    <button class='btn btn-secondary' onclick='ConfirmarCargaUSU(2)'>Cancelar</button>
             </div>
             <table class='table table-sm table-responsive vh-50 table-striped'>
             <thead>
               <tr>
                <th scope='col'>#</th>
                <th scope='col'>No. Empleado</th>
                <th scope='col'>Nombre</th>
               </tr>
             </thead>
             <tbody>";

            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }

            echo "</tbody>
            </table>";
        } else {
            echo "<p class='h1 vh-100'>No se ha cargado ningun archivo aún.</p>";
        }
    }
    public static function rows_leer_archivo2($datos, $numerador)
    {
        include_once 'php/MetodosUsuarios.php';
        $usuarios = new MetodosUsuarios();

        $error_a = "<span class='d-inline-block' data-toggle='tooltip' data-placement='top' data-html='true' title='<b>Empleado ingresado con anterioridad.</b>'>
                        <i class='fas fa-exclamation-circle text-warning'></i>
                    </span>";
        $valido_a = "<span class='d-inline-block' data-toggle='tooltip' data-placement='top' data-html='true' title='<b>Analista valido.</b>'>
                    <i class='fas fa-check-circle text-success'></i>
            </span>";


        if (self::Consulta_usu_exist($datos["no_Empleado"]) == false) {
            $identificado = $valido_a;
        } else {
            $identificado = $error_a;
        }

        $html = "<tr>
                    <th scope='row'>$numerador</td>
                    <td>" . $datos["no_Empleado"] . "</td>
                    <td>" . $datos["Analista"] . "</td>
                    <td>$identificado</td>
                </tr>";
        return $html;
    }
    public static function Consulta_usu_exist($no_empleado)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE CREA UN QUERY
        $query = "SELECT * FROM Empleado WHERE (no_empleado = $no_empleado) ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas = array('Nombre_empleado' => $row["nombre_empleado"]);
            }
            if (isset($filas)) {
                return $filas;
            } else {
                return false;
            }
            $conexion->CerrarConexion($con);
        } else {
            return false;
        }
    }
    public function Insertar_Usuarios()
    {
        include_once 'Classes/PHPExcel.php';
        include_once 'Classes/PHPExcel/Reader/Excel2007.php';
        include_once 'sesion.php';
        include_once 'MetodosUsuarios.php';
        $usuarios = new MetodosUsuarios();
        $objReader = new PHPExcel_Reader_Excel2007();
        $id_user = $_SESSION["ses_id_usuario"];
        $ruta = "../temp_files/carga_nueva$id_user.xlsx";

        $objPHPExcel = $objReader->load($ruta);

        // Asignar hoja de excel activa
        $objPHPExcel->setActiveSheetIndex(0);
        $j = 2; //desde que fila se cuenta
        do {
            $_DATOS_EXCEL['num_empleado'] = $objPHPExcel->getActiveSheet()->getCell('A' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['Analista'] = $objPHPExcel->getActiveSheet()->getCell('B' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['RFC'] = $objPHPExcel->getActiveSheet()->getCell('C' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['Correo'] = $objPHPExcel->getActiveSheet()->getCell('D' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['id_admin'] = $objPHPExcel->getActiveSheet()->getCell('E' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['id_sub_admin'] = $objPHPExcel->getActiveSheet()->getCell('F' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['id_depto'] = $objPHPExcel->getActiveSheet()->getCell('G' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['jefe_directo'] = $objPHPExcel->getActiveSheet()->getCell('H' . $j)->getCalculatedValue();
            $llave = self::Consulta_usu_exist($_DATOS_EXCEL["num_empleado"]);

            if ($llave == false) {
                if ($error_c = self::Crear_Usuario($_DATOS_EXCEL) != true) {
                    $errores[] = array('num_empleado' => $_DATOS_EXCEL['num_empleado'], 'error' => "No se pudo crear el usuario; " . $error_c);
                }
            } else {
                $errores[] = array('num_empleado' => $_DATOS_EXCEL['num_empleado'], 'error' => "Usuario registrado con anterioridad; ");
            }


            $j++;
        } while (($objPHPExcel->getActiveSheet()->getCell('A' . $j)->getCalculatedValue() != null));

        unlink($ruta);
        if (isset($errores)) {
            $formato = self::Formato_error2($errores);
        } else {
            $formato = self::Formato_exito2();
        }
        echo $formato;
    }
    public static function Crear_Usuario($datos)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        include_once 'Classes/PHPExcel.php';
        include_once 'Classes/PHPExcel/Reader/Excel2007.php';
        $objFecha = new PHPExcel_Shared_Date();
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $id_usu = $datos['num_empleado'];
        $analista = $datos["Analista"];
        $rfc = $datos["RFC"];
        $correo = $datos["Correo"];
        $Admin1 = $datos['id_admin'];
        $sub = $datos['id_sub_admin'];
        $dpto = $datos['id_depto'];
        $Jefe = $datos['jefe_directo'];
        $usuario = $_SESSION["ses_rfc_corto"];
        $query = "INSERT INTO Empleado (id_admin,id_sub_admin,id_depto,id_puesto,id_perfil,rfc_corto,nombre_empleado,correo,estatus,passwd,user_alta,fecha_alta,no_empleado,jefe_directo,responsiva) 
        VALUES ( $Admin1 , $sub , $dpto ,1,2,'" . $rfc . "','" . $analista . "','" . $correo . "','A','e10adc3949ba59abbe56e057f20f883e','" . $usuario . "',GETDATE()," . $id_usu . "," . $Jefe . " ,0) ";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            return true;
        }
    }
    public static function Formato_error2($datos)
    {
        $html = "<div class='alert alert-danger' role='alert'><ul>";
        for ($i = 0; $i < count($datos); $i++) {
            if ($i == 9) {
                $html .= "<a onclick='vermas()' href='#' id='link_ver'>Ver mas</a>
                            <div id='vermasdiv' style='display:none'> 
                                <li>Error con <b>" . $datos[$i]["num_empleado"] . "</b>: " . $datos[$i]["error"] . "</li>
                            ";
            } else {
                $html .= "<li>Error con <b>" . $datos[$i]["num_empleado"] . "</b>: " . $datos[$i]["error"] . "</li>";
            }
        }
        if (count($datos) >= 10) {
            $html .= "</div></ul></div>";
        } else {
            $html .= "</ul></div>";
        }
        return $html;
    }
    public static function Formato_exito2()
    {
        $html = "<div class='alert alert-success' role='alert'>
                    ¡Carga realizada con éxito!
                </div>";
        return $html;
    }
    public function Leer_archivo_Det()
    {
        include_once 'php/Classes/PHPExcel.php';
        include_once 'php/Classes/PHPExcel/Reader/Excel2007.php';
        $objReader = new PHPExcel_Reader_Excel2007();
        $objFecha = new PHPExcel_Shared_Date();
        $id_user = $_SESSION["ses_id_usuario"];
        $ruta = "temp_files/carga_nueva$id_user.xlsx";
        if (is_file($ruta)) {
            $objPHPExcel = $objReader->load($ruta);

            // Asignar hoja de excel activa
            $objPHPExcel->setActiveSheetIndex(0);
            $i = 0; //posición 0 del arreglo
            $j = 2; //desde que fila se cuenta
            $_DATOS_EXCEL[] = null;
            do {
                $_DATOS_EXCEL[$i]['RFC'] = $objPHPExcel->getActiveSheet()->getCell('A' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Contribuyente'] = $objPHPExcel->getActiveSheet()->getCell('B' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Id_Autoridad_Determ'] = $objPHPExcel->getActiveSheet()->getCell('C' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['No Empleado Analista'] = $objPHPExcel->getActiveSheet()->getCell('D' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Estatus'] = $objPHPExcel->getActiveSheet()->getCell('E' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['IdResolucion'] = $objPHPExcel->getActiveSheet()->getCell('F' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Fec_Inventario'] = $objPHPExcel->getActiveSheet()->getCell('G' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Docto'] = $objPHPExcel->getActiveSheet()->getCell('H' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Fec_Determ'] = $objPHPExcel->getActiveSheet()->getCell('I' . $j)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['RDFDA'] = $objPHPExcel->getActiveSheet()->getCell('J' . $j)->getCalculatedValue();
                $i++;
                $j++;
            } while ($j <= 120);

            $numerador = 1;
            $html[] = null;
            for ($i = 0; $i < count($_DATOS_EXCEL); $i++) {
                $html[$i] = self::rows_leer_archivo3($_DATOS_EXCEL[$i], $numerador);
                $numerador++;
            }


            echo "
             <div class='text-center py-3'>
                    <button class='btn btn-dark btn_sat_black text-white' onclick='ConfirmarCargaDet(1)'>Confirmar carga</button>
                    <button class='btn btn-secondary' onclick='ConfirmarCargaDet(2)'>Cancelar</button>
             </div>
             <table class='table table-responsive vh-50 table-sm table-striped shadow p-1 bg-white rounded'>
             <thead>
               <tr>
                 <th scope='col'>#</th>
                 <th scope='col'>RFC</th>
                 <th scope='col'>Contribuyente</th>
                 <th scope='col'>Resolusión</th>
                 <th scope='col'>RDFDA</th>
               </tr>
             </thead>
             <tbody>";

            for ($i = 0; $i < count($html); $i++) {
                echo $html[$i];
            }

            echo "</tbody>
            </table>";
        } else {
            echo "<p class='h1 vh-100'>No se ha cargado ningun archivo aún.</p>";
        }
    }
    public static function rows_leer_archivo3($datos, $numerador)
    {
        include_once 'php/MetodosUsuarios.php';
        $usuarios = new MetodosUsuarios();

        $error_a = "<span class='d-inline-block' data-toggle='tooltip' data-placement='top' data-html='true' title='<b>Empleado no registrado. " . $datos["No Empleado Analista"] . "</b>'>
                        <i class='fas fa-exclamation-circle text-warning'></i>
                    </span>";
        $error_a2 = "<span class='d-inline-block' data-toggle='tooltip' data-placement='top' data-html='true' title='<b>RDFDA repetido.</b>'>
                    <i class='fas fa-exclamation-circle text-warning'></i>
                </span>";
        $valido_a = "<span class='d-inline-block' data-toggle='tooltip' data-placement='top' data-html='true' title='<b>Analista valido.</b>'>
                    <i class='fas fa-check-circle text-success'></i>
            </span>";


        if (self::Consulta_usu_exist($datos["No Empleado Analista"]) != false) {
        if (self::Consulta_RDFDA_exist($datos["RDFDA"]) == false) {
            $identificado = $valido_a;
        } else {
            $identificado = $error_a2;
        }
          } else {
              $identificado = $error_a;
         }
        $html = "<tr>
                    <th scope='row'>$numerador</td>
                    <td>" . $datos["RFC"] . "</td>
                    <td>" . $datos["Contribuyente"] . "</td>
                    <td>" . $datos["IdResolucion"] . "</td>
                    <td>" . $datos["RDFDA"] . "</td>
                    <td>$identificado</td>
                </tr>";
        return $html;
    }
    public static function Consulta_RDFDA_exist($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE CREA UN QUERY
        $query = "SELECT * FROM Determinante Where RDFDA = '$RDFDA'";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas =$row;
            }
            if (isset($filas)) {
                return $filas;
            } else {
                return false;
            }
            $conexion->CerrarConexion($con);
        } else {
            return false;
        }
    }
    public static function Convierte_fec_en_varchar($fec)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE CREA UN QUERY
        $query = "SELECT CAST('$fec' as varchar) fec_string";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas =$row;
            }
            if (isset($filas)) {
                return $filas;
            } else {
                return false;
            }
            $conexion->CerrarConexion($con);
        } else {
            return false;
        }
    }
    public static function Consulta_Contri_exist($RFC, $Contribuyente)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE CREA UN QUERY
        $query = "SELECT distinct * FROM Contribuyente where rfc = '$RFC' or razon_social ='$Contribuyente'";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if (isset($prepare)) {
            return true;
        } else {
            return false;
        }
    }
    public static function Consulta_razon_exist($razon)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE CREA UN QUERY
        $query = "SELECT * FROM Contribuyente where razon_social= '$razon'";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if (isset($prepare)) {
            return true;
        } else {
            return false;
        }
    }


    public function Insertar_det()
    {
        include_once 'Classes/PHPExcel.php';
        include_once 'Classes/PHPExcel/Reader/Excel2007.php';
        include_once 'sesion.php';
        include_once 'MetodosUsuarios.php';
        $usuarios = new MetodosUsuarios();
        $objReader = new PHPExcel_Reader_Excel2007();
        $id_user = $_SESSION["ses_id_usuario"];
        $ruta = "../temp_files/carga_nueva$id_user.xlsx";

        $objPHPExcel = $objReader->load($ruta);
        set_time_limit(84600);
        // Asignar hoja de excel activa
        $objPHPExcel->setActiveSheetIndex(0);
        $j = 2; //desde que fila se cuenta
        do {
            $_DATOS_EXCEL['RFC'] = $objPHPExcel->getActiveSheet()->getCell('A' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['Contribuyente'] = $objPHPExcel->getActiveSheet()->getCell('B' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['Id_Autoridad_Determ'] = $objPHPExcel->getActiveSheet()->getCell('C' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['No Empleado Analista'] = $objPHPExcel->getActiveSheet()->getCell('D' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['Estatus'] = $objPHPExcel->getActiveSheet()->getCell('E' . $j)->getCalculatedValue();
            if(($_DATOS_EXCEL['IdResolucion'] = $objPHPExcel->getActiveSheet()->getCell('F' . $j)->getCalculatedValue()) == NULL){ continue; }
            $_DATOS_EXCEL['Fec_Inventario'] = $objPHPExcel->getActiveSheet()->getCell('G' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['Docto'] = $objPHPExcel->getActiveSheet()->getCell('H' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['Fec_Determ'] = $objPHPExcel->getActiveSheet()->getCell('I' . $j)->getCalculatedValue();
            $_DATOS_EXCEL['RDFDA'] = $objPHPExcel->getActiveSheet()->getCell('J' . $j)->getCalculatedValue();


            if ($usuarios->Consulta_user_exist($_DATOS_EXCEL["No Empleado Analista"]) != false) {
                if (self::Consulta_contri_exist($_DATOS_EXCEL["RFC"], $_DATOS_EXCEL['Contribuyente']) != false) {
                    if (self::Consulta_RDFDA_exist($_DATOS_EXCEL["RDFDA"]) == false) {
                        if ($error_c = self::Crear_exp($_DATOS_EXCEL) != true) {
                            $errores[] = array('RFC' => $_DATOS_EXCEL['RFC'], 'error' => "No se pudo crear el expediente2; " . $error_c);
                        }
                        if ($valor = self::Crear_det($_DATOS_EXCEL) != true) {
                            $errores[] = array('RFC' => $_DATOS_EXCEL['RFC'], 'error' => "No se pudo reasignar la RDFDA; " . $valor);
                        }
                    } else {
                        if ($resto =  self::Actualiza_User_por_RDFDA($_DATOS_EXCEL) != false) {
                            $errores[] = array('RFC' => $_DATOS_EXCEL['RDFDA'], 'Se actualizo el analista.'.$_DATOS_EXCEL['No Empleado Analista'].'/'.$resto);
                        }
                    }
                } else {
                    if ($contrib = self::Crear_Contri($_DATOS_EXCEL) != true) {
                        $errores[] = array('RFC' => $_DATOS_EXCEL['RFC'], 'error' => "No se pudo registrar al contribuyente; " . $contrib);
                    }
                    if ($error_c = self::Crear_exp($_DATOS_EXCEL) != true) {
                        $errores[] = array('RFC' => $_DATOS_EXCEL['RFC'], 'error' => "No se pudo crear el expediente1; " . $error_c);
                    }
                    if ($valor = self::Crear_det($_DATOS_EXCEL) != true) {
                        $errores[] = array('RFC' => $_DATOS_EXCEL['RFC'], 'error' => "No se pudo reasignar la RDFDA; " . $valor);
                    }
                }
            } else {
                $errores[] = array('RFC' => $_DATOS_EXCEL['No Empleado Analista'], 'error' => "Analista asignado no valido.");
            }

            $j++;
        } while (($objPHPExcel->getActiveSheet()->getCell('A' . $j)->getCalculatedValue() != ''));

        unlink($ruta);
        if (isset($errores)) {
            $formato = self::Formato_error3($errores);
        } else {
            $formato = self::Formato_exito3();
        }
        echo $formato;
    }

    public static function Cambia_fojas_det($det, $num_fojas)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $fojas = self::Tiene_fojas1($det);
        if ($fojas != 0) {
            return "Esta determinante ya cuenta con número de fojas contabilizada, no la puedes modificar en la entrega.";
        } else {
            $query = "UPDATE Determinante SET fojas = $num_fojas, user_mod = '$user', fecha_mod = GETDATE()  where RDFDA = '$det'";
            $prepare = sqlsrv_query($con, $query);
            if ($prepare === false) {
                $errorsql = print_r(sqlsrv_errors(), false);
                $conexion->CerrarConexion($con);
                return 'No se ha registrado correctamente el número de fojas, consulte con su administrador.';
            } else {
                return 'Se ha registrado el número de fojas de la determinante.';
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function busca_id_det($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        $con = $conexion->ObtenerConexionBD();
        $query = "SELECT id_determinante FROM Determinante WHERE RDFDA = '$RDFDA'";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $id_det = $row['id_determinante'];
            }
            if (isset($id_det)) {
                return $id_det;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function Tiene_fojas($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $query = "SELECT fojas FROM Determinante WHERE id_determinante = $RDFDA";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $id_det = $row['fojas'];
            }
            if (isset($id_det)) {
                return $id_det;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function Tiene_fojas1($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $query = "SELECT fojas FROM Determinante WHERE RDFDA = '$RDFDA'";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $id_det = $row['fojas'];
            }
            if (isset($id_det)) {
                return $id_det;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function inserta_cambio_fojas($busca_id_det, $tiket, $fojas)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $tiene= self::Tiene_fojas($busca_id_det);
        if ($tiene != 0) {
            return 'La determinante ya tiene un número de fojas registrado.';
        } else {
            $query = "INSERT INTO Etapa_poc 
            (user_alta,
            id_determinante,
            fecha_alta,
            estatus,
            id_proc_det,
            id_tiket,
            fojas)
            values(
            '$user'
            ,$busca_id_det,
            GETDATE(),
            'N'
            ,14,
            $tiket,
            $fojas)";
            $prepare = sqlsrv_query($con, $query);
            if ($prepare == false) {
                $errorsql = print_r(sqlsrv_errors(), false);
                $conexion->CerrarConexion($con);
                return 'Se ha agregado el numero de fojas de el expediente correctamente';
            } else {
                return 'No se actualizo el numero de fojas del expediente';
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function Formato_error3($datos)
    {
        $html = "<div class='alert alert-danger' role='alert'><ul>";
        for ($i = 0; $i < count($datos); $i++) {
            if ($i == 9) {
                $html .= "<a onclick='vermas()' href='#' id='link_ver'>Ver mas</a>
                            <div id='vermasdiv' style='display:none'> 
                                <li>Error con <b>" . $datos[$i]["RFC"] . "</b>: " . $datos[$i]["error"] . "</li>
                            ";
            } else {
                $html .= "<li>Error con <b>" . $datos[$i]["RFC"] . "</b>: " . $datos[$i]["error"] . "</li>";
            }
        }
        if (count($datos) >= 10) {
            $html .= "</div></ul></div>";
        } else {
            $html .= "</ul></div>";
        }
        return $html;
    }
    public static function Formato_exito3()
    {
        $html = "<div class='alert alert-success' role='alert'>
                    ¡Carga realizada con éxito!
                </div>";
        return $html;
    }

    public static function Crear_Contri($datos)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $usuario = $_SESSION["ses_rfc_corto"];
        $RFC = $datos['RFC'];
        $Contribuyente =$datos['Contribuyente'];
        $query = "	INSERT INTO Contribuyente ([rfc]
		,[razon_social]
		,[estatus]
		,[user_alta]
		,[fecha_alta])
		SELECT 
		'$RFC' AS [rfc]
		,'$Contribuyente' AS [razon_social]
		,'A' AS [estatus]
		,'$usuario' AS [user_alta]
		,GETDATE() AS [fecha_alta]
        ";

        $prepare = sqlsrv_query($con, $query);

        if ($prepare === false) {
            return print_r(sqlsrv_errors(), false);
        } else {
            return true;
        }
    }
    public static function Crear_conjunta_RDFDA($datos)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        self::crea_expedientes($datos);
        self::crea_determinante($datos);
        $RFC = $datos['RFC'];
        $razon = $datos['Contribuyente'];
        $usuario = $_SESSION["ses_rfc_corto"];
        $query1 = "IF NOT EXISTS (SELECT *FROM Contribuyente WHERE rfc = '$RFC' and razon_social = '$razon') BEGIN
		INSERT INTO Contribuyente ([rfc]
		,[razon_social]
		,[estatus]
		,[user_alta]
		,[fecha_alta])
		SELECT 
		'$RFC' AS [rfc]
		,'$razon' AS [razon_social]
		,'A' AS [estatus]
		,'$usuario' AS [user_alta]
		,GETDATE() AS [fecha_alta]
		END";

        $prepare1 = sqlsrv_query($con, $query1);
        if ($prepare1 == true) {
            return 'Se creo el contribuyente';
        } else {
            return  $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
        }
    }
    public function crea_expedientes($datos)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $RFC = $datos['RFC'];
        $razon = $datos['Contribuyente'];
        $RDFDA = $datos['RDFDA'];
        $usuario = $_SESSION["ses_rfc_corto"];
        $query2 ="IF NOT EXISTS (SELECT *FROM Determinante WHERE RDFDA = '$RDFDA') 
		BEGIN
		INSERT INTO Expediente (id_contribuyente,Caja,fecha_alta,user_alta,estatus)
                VALUES (
        (SELECT id_contribuyente FROM Contribuyente WHERE rfc ='$RFC' AND razon_social = '$razon' ),
        NULL,
        GETDATE(),
        '$usuario',
        'A')
		END";
        $prepare2 = sqlsrv_query($con, $query2);
        if ($prepare2 == true) {
            return 'Se creo el contribuyente';
        } else {
            return  $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
        }
    }
    public function crea_expedientes_indi($RFC,$razon,$det,$aut,$fec_det)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $usuario = $_SESSION["ses_rfc_corto"];
        $query2 =" IF NOT EXISTS (SELECT *FROM Determinante WHERE RDFDA = CONCAT('$RFC','/','$det','/',cast ($fec_det AS int)+2,'/',$aut)) 
		BEGIN
		INSERT INTO Expediente (id_contribuyente,Caja,fecha_alta,user_alta,estatus)
                VALUES (
        (SELECT id_contribuyente FROM Contribuyente WHERE rfc ='$RFC' AND razon_social = '$razon' ),
        NULL,
        GETDATE(),
        '$usuario',
        'A')
		END";
        $prepare2 = sqlsrv_query($con, $query2);
        if ($prepare2 == true) {
            return 'Se creo el contribuyente';
        } else {
            return  $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
        }
    }
    public function crea_determinante($datos)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();

        $fecha_Inv = $datos['Fec_Inventario'];
        $fecha_det = $datos['Fec_Determ'];
        $Id_Autoridad_Determ = $datos["Id_Autoridad_Determ"];
        $No_Empleado = $datos["No Empleado Analista"];
        $Estatus = $datos["Estatus"];
        $IdResolucion = $datos['IdResolucion'];
        $Docto = $datos['Docto'];
        $RDFDA = $datos['RDFDA'];
        $usuario = $_SESSION["ses_rfc_corto"];
        $razon = $datos['Contribuyente'];
        $query3 ="IF NOT EXISTS (SELECT *FROM Determinante WHERE RDFDA = '$RDFDA') 
		BEGIN
		INSERT INTO [Determinante] (id_expediente,id_autoridad,id_empleado,estatus_cred,fojas,id_rersolucion,fecha_inv,fecha_determinante,
      num_determinante,RDFDA,fecha_alta,user_alta,estatus,id_proc)
      values(
        (Select max(id_expediente)id_expediente from Expediente where id_contribuyente=(Select id_contribuyente from Contribuyente where rfc='$RFC' AND razon_social ='$razon')),
          (select id_autoridad from Autoridad where num_Autoridad=$Id_Autoridad_Determ),
          (select id_empleado from Empleado where no_empleado=$No_Empleado),
          '$Estatus',
          0,
          $IdResolucion,
            '$fecha_Inv',
            '$$fecha_det',
            '$Docto',
            '$RDFDA',
            GETDATE(),
            '$usuario',
            'A',
            1
          )
		END
		ELSE 
		BEGIN
		UPDATE Determinante SET id_empleado = (SELECT id_empleado from Empleado where no_empleado = $No_Empleado), estatus_cred = '$Estatus'  WHere RDFDA = '$RDFDA'
		END";
        $prepare3 = sqlsrv_query($con, $query3);
        if ($prepare3 == true) {
            return 'Se creo el contribuyente';
        } else {
            return  $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
        }
    }
    public function crea_determinante_indiv($RFC,$razon,$det,$aut,$fec_det,$fec_inv,$estatus,$emp)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $usuario = $_SESSION['ses_rfc_corto'];

        $query3 ="IF NOT EXISTS (SELECT *FROM Determinante WHERE RDFDA = CONCAT('$RFC','/','$det','/',cast ($fec_det AS int)+2,'/',$aut)) 
		BEGIN
		INSERT INTO [Determinante] (id_expediente,id_autoridad,id_empleado,estatus_cred,fojas,fecha_inv,fecha_determinante,
      num_determinante,RDFDA,fecha_alta,user_alta,estatus,id_proc)
      values(
        (Select max(id_expediente)id_expediente from Expediente where id_contribuyente=(Select id_contribuyente from Contribuyente where rfc='$RFC' AND razon_social ='$razon')),
          (select id_autoridad from Autoridad where num_Autoridad=$aut),
          $emp,
          '$estatus',
          0,
            '$fec_inv',
            '$$fec_det',
            '$det',
            CONCAT('$RFC','/','$det','/',cast ($fec_det AS int)+2,'/',$aut),
            GETDATE(),
            '$usuario',
            'A',
            1
          )
		END
		ELSE 
		BEGIN
		UPDATE Determinante SET id_empleado = $emp, estatus_cred = '$estatus'  WHere RDFDA = CONCAT('$RFC','/','$det','/',cast ($fec_det AS int)+2,'/',$aut)
		END";
        $prepare3 = sqlsrv_query($con, $query3);
        if ($prepare3 == true) {
            return 'Se creo el contribuyente';
        } else {
            return  $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proceso_Asignado($datos)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $RDFDA = $datos['RDFDA'];
        $Estatus = $datos["Estatus"];
        $con = $conexion->ObtenerConexionBD();
        $query = "INSERT INTO Etapa_poc (id_proc_det,user_alta,fecha_alta,id_determinante,estatus) 
        values(
            1,'$user',GETDATE(),
            (select id_determinante from determinante where RDFDA='$RDFDA','$Estatus')
            )";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Crear_det($datos)
    {
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $objFecha = new PHPExcel_Shared_Date();
        $timestamp =  $objFecha->ExcelToPHP($datos['Fec_Inventario']);
        $fecha_Inv = date("Y-m-d", $timestamp);
        $f_Inv = DateTime::createFromFormat('Y-m-d', $fecha_Inv);
        $Fec_Inventario =  $f_Inv->format('Y/m/d');
        $timestamp2 =  $objFecha->ExcelToPHP($datos['Fec_Determ']);
        $fecha_det = date("Y-m-d", $timestamp2);
        $f_det = DateTime::createFromFormat('Y-m-d', $fecha_det);
        $Fec_Determ =  $f_det->format('Y/m/d');
        $RFC = $datos['RFC'];
        $Contribuyente = $datos["Contribuyente"];
        $Id_Autoridad_Determ = $datos["Id_Autoridad_Determ"];
        $No_Empleado = $datos["No Empleado Analista"];
        $Estatus = $datos["Estatus"];
        $IdResolucion = $datos['IdResolucion'];
        $Docto = $datos['Docto'];
        $RDFDA = $datos['RDFDA'];
        $Contribuyente = $datos['Contribuyente'];
        $usuario = $_SESSION["ses_rfc_corto"];

        $query = "INSERT INTO [Determinante] (
                id_expediente,
                id_autoridad,
                id_empleado,
                estatus_cred,
                fojas,
  
                fecha_inv,
                fecha_determinante,
                num_determinante,
                RDFDA,
                fecha_alta,
                user_alta,
                estatus,
                id_proc)
      values(
        (Select max(id_expediente)id_expediente 
        from Expediente where id_contribuyente=(
            Select distinct id_contribuyente from Contribuyente 
            where rfc='$RFC' or razon_social = '$Contribuyente')),
          (select id_autoridad from Autoridad where num_Autoridad=$Id_Autoridad_Determ), 
          (select id_empleado from Empleado where no_empleado=$No_Empleado),
          '$Estatus',
          0,
          Case $IdResolucion when '' then null Else $IdResolucion,
            '$Fec_Inventario',
            '$Fec_Determ',
            '$Docto',
            '$RDFDA',
            GETDATE(),
            '$usuario',
            'A',
            1)";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            return true;
        } else {
            die(print_r(sqlsrv_errors(), false));
            // if ($proceso = self::Proceso_Asignado($datos)) {
            //     return true;
            // } else {
            //     return false;
            // }
        }
    }
    public static function Crear_exp($datos)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();

        $RFC = $datos['RFC'];
        $Contribuyente =$datos['Contribuyente'];
        $query = "INSERT INTO Expediente (id_contribuyente,fecha_alta,user_alta,estatus)
                VALUES (
                (SELECT distinct id_contribuyente FROM Contribuyente WHERE rfc ='$RFC' or razon_social = '$Contribuyente' ),
                GETDATE(),
                '$user',
                'A')";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            return true;
        } else {
            return print_r(sqlsrv_errors(),false) ;

        }
    }
    public static function Actualiza_User_por_RDFDA($datos)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        include_once 'MetodosUsuarios.php';
        $conexion = new ConexionSQL();
        $datos_us = new MetodosUsuarios();
        //$user_ses = $_SESSION["ses_rfc_corto"];
        $Docto = $datos["Docto"];
        $user = $datos["No Empleado Analista"];
        $RDFDA = $datos["RDFDA"];
        $estatus_cred = $datos['Estatus'];
        $con = $conexion->ObtenerConexionBD();
        //$query = "UPDATE Determinante SET id_empleado = (SELECT id_empleado FROM Empleado WHERE no_empleado = $user  ), num_determinante = '$Docto' , estatus_cred = '$estatus_cred'  WHere RDFDA = '$RDFDA'";
        $query = "UPDATE Determinante SET id_empleado = (SELECT id_empleado FROM Empleado WHERE no_empleado = $user  ) , estatus_cred = '$estatus_cred'  WHere RDFDA = '$RDFDA'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            return true;
        } else {
            return false;
        }
    }

    public static function Consulta_Rep($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "  select *from Etapa_poc where
        id_proc_det=10 and user_alta='$user' 
        and id_determinante=(SELECT id_determinante FROM determinante WHERE RDFDA='$RDFDA')";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } elseif ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas = array('id_etapa' => $rows["id_etapa"]);
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return true;
            } else {
                return false;
            }
        }
    }
    public static function Consulta_total_prepeticion()
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "
        SELECT COUNT(*) total_pre FROM Etapa_poc where 
              user_alta='$user' and
              id_proc_det=10 
        ";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } elseif ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas = array('total_pre' => $rows["total_pre"]);
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                if ($filas['total_pre'] >= 25) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function Registrar_solicitud($datos)
    {
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        if ($_SESSION["agrega"] == 0) {
            $no_tiket = self::Genera_tiket();
            $_SESSION["agrega"] = $no_tiket;
        } else {
            $no_tiket = $_SESSION["agrega"];
        }
        $id_perfil = $_SESSION['ses_id_perfil'];
        $RDFDA = explode(", ", $datos);
        $total_prestamos_usu = self::contador_det_por_usu();
        $pedidos_peticion = (count($RDFDA) - 1) + $total_prestamos_usu['total'];

        if ($id_perfil == 5 && $pedidos_peticion <= 25) { /////////////////////
            $res = self::agrega_carrito($RDFDA, $no_tiket);
            return $res;
        } elseif ($id_perfil == 5 && $pedidos_peticion > 100) {
            return "Solo puedes pedir 100 expedientes y tienes " . $total_prestamos_usu['total'] . " pedidos";
        } else {
            if ($pedidos_peticion <= 25) {
                $res = self::agrega_carrito($RDFDA, $no_tiket);
                return $res;
            } else {
                return "Solo puedes pedir 25 expedientes y tienes " . $total_prestamos_usu['total'] . " pedidos";
            }
        }
    }
    public static function contador_det_por_usu()
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY

        $query = " SELECT COUNT(*) total FROM Etapa_poc where 
        user_alta='$user' and
        (id_proc_det=2 or
        id_proc_det=5 or
        id_proc_det=7 or
        id_proc_det=8 or
        id_proc_det=10 or
        id_proc_det=11) and estatus = 'A'";
        $con = $conexion->ObtenerConexionBD();
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas = array('total' => $row["total"]);
            }
            if (isset($filas)) {
                return $filas;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }

    public static function agrega_carrito($RDFDA, $no_tiket)
    {
        $bandera = 1;
        $bandera2 = 1;
        for ($i = 0; $i < count($RDFDA) - 1; $i++) {
            $consulta_rep = self::Consulta_Rep($RDFDA[$i]);
            $consulta_max = self::Consulta_total_prepeticion();
            if ($consulta_max == true) {
                $i = count($RDFDA);
                $bandera2 = 2;
            } else {
                if ($consulta_rep == true) {
                    $i = count($RDFDA);
                    $bandera = 2;
                }
            }
        }
        if ($bandera == 2) {
            return "Una o varias determinantes ya fueron agregadas anteriormente al ticket: " . $no_tiket;
        } elseif ($bandera2 == 2) {
            return "Solo se pueden agregar 25 expedientes por ticket";
        } else {
            for ($i = 0; $i < count($RDFDA) - 1; $i++) {
                $Proceso = self::Proceso_peticion($RDFDA[$i], $no_tiket);
                if ($Proceso = !false) {
                    $Proc_estatus = self::Proc_estatus($RDFDA[$i]);
                }
            }
            if ($Proc_estatus = !false) {
                return "Agregado al Ticket: " . $no_tiket;
            } else {
                return "Algo salio mal";
            }
        }
    }

    public function Estatus_disponible($datos)
    {
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $no_tiket = self::Genera_tiket();
        $RDFDA = explode(", ", $datos);

        for ($i = 0; $i < count($RDFDA) - 1; $i++) {
            $Proceso = self::Proceso_peticion($RDFDA[$i], $no_tiket);
            if ($Proceso = !false) {
                $Proc_estatus = self::Proc_estatus($RDFDA[$i]);
            }
        }
        if ($Proc_estatus = !false) {
            return "Proceso Exitoso";
        } else {
            return "Algo salio mal";
        }
    }
    public function Registrar_entrega($datos)
    {
        include_once 'sesion.php';

        $RDFDA = explode(", ", $datos);
        $tiket = self::bus_tiket_busqueda_Proc_dev($RDFDA[0]);
        $total_array = count($RDFDA) - 1;
        $total_tiket = self::total_tiket($tiket);


        for ($i = 0; $i < count($RDFDA) - 1; $i++) {
            if ($Proceso = !false) {
                $Proc_estatus = self::Proc_Dev($RDFDA[$i]);
            }
        }
        if ($Proc_estatus = !false) {
            if ($total_array == $total_tiket) {
                self::cambia_estatus_tiket_proc_dev($tiket);
            } else {
                self::cambia_estatus_tiket_proc_dev($tiket);
            }
            return "Proceso Exitoso";
        } else {
            return "Algo salio mal";
        }
    }
    public static function Proceso_debolucion($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $tiket = self::bus_tiket($RDFDA);
        $query = "
        insert into Etapa_poc (id_proc_det,user_alta,fecha_alta,id_determinante,id_tiket,estatus) 
        values(
            5,'" . $user . "',GETDATE(),
            (select id_determinante from determinante where RDFDA='" . $RDFDA . "'),$tiket,'A'
            )";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            $conexion->CerrarConexion($con);
            return true;
        }
    }
    public function Cancelacion_tiket()
    {
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $no_tiket = $_SESSION["agrega"];
        if ($_SESSION["agrega"] != 0) {
            $Proceso = self::Proc_peticion_cancelado($no_tiket);
            $Proc_estatus = self::Proc_estatus_cancelado();
            $tiket = self::tiket_cancelado($no_tiket);

            if ($Proc_estatus = !false && $Proceso = !false && $tiket = !false) {
                $_SESSION["agrega"] = 0;
                return "Cancelacion de Ticket: " . $no_tiket;
            } else {
                return "Algo salio mal en la cancelacion";
            }
        } else {
            $Proceso = self::Proc_cancelado_pre();
            $Proc_estatus = self::Proc_estatus_cancelado();
            $tiket = self::tiket_cancelado_pre();
        }
        //  return "Cancelacion de Tiket";
    }
    public static function Proc_cancelado_pre()
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "delete Etapa_poc where id_proc_det=10 and user_alta='$user'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function tiket_cancelado_pre()
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "delete Tikets where id_proc=10 and user_mov='$user'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public function pedir_tiket($datos)
    {
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $no_tiket = $_SESSION["agrega"];
        $asunto = $datos['cod'];
        $prioridad = $datos['prioridad'];
        $valida_dia = self::valida_dias_habiles();
        $hoy = self::consulta_fecha_hoy();
        if ($valida_dia != true || $hoy != true) {
            if ($_SESSION["agrega"] != 0) {
                $Proceso = self::Proc_peticion($no_tiket);
                $Proc_estatus = self::Proc_estatus_pedir();
                $tiket = self::tiket_pedido($no_tiket, $asunto, $prioridad);
                if ($Proceso = !false && $Proc_estatus = !false && $tiket = !false) {
                    $_SESSION["agrega"] = 0;
                    return "Ticket " . $no_tiket . "  solicitado con éxito";
                } else {
                    return "Algo salio mal en la solicitud";
                }
            }
        } else {
            return "Dia no habil para peticiones";
        }
    }

    public function valida_dias_habiles()
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "SELECT * FROM [BovedaProyect].[dbo].dias_habiles WHERE dia_no_habil = CAST( (FORMAT(DAY(GETDATE()),'00') + '-' +   FORMAT(MONTH(GETDATE()),'00')  + '-' + FORMAT(YEAR(GETDATE()),'0000')) AS DATETIME)";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }

    public function consulta_fecha_hoy()
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "SELECT GETDATE() AS HOY";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
            if ($dias[date("w")] == "Domingo" || $dias[date("w")] == "Sábado") {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }


    public static function tiket_pedido($tiket, $asunto, $prioridad)
    {
        $asunto2 = $asunto == 1 ? 'Baja' : ($asunto == 2 ? 'Consulta en Boveda' : ($asunto == 3 ? 'Consulta en area' : 'falso'));
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        if ($prioridad == 0) {
            if ($asunto2 == 'Consulta en Boveda' || $asunto2 == 'Baja') {
                $query = "UPDATE Tikets set id_proc=2, Asunto='$asunto2',estatus = 'A', Prioridad = 0 where user_mov='$user' and id_tiket=$tiket";
            } elseif ($asunto2 == 'Consulta en area') {
                $query = "UPDATE Tikets set id_proc=2, Asunto='$asunto2',Prioridad = 0 where user_mov='$user' and id_tiket=$tiket";
            }
        } elseif ($prioridad == 1) {
            if ($asunto2 == 'Consulta en Boveda' || $asunto2 == 'Baja') {
                $query = "UPDATE Tikets set id_proc=2, Asunto='$asunto2',estatus = 'A',Prioridad = 1 where user_mov='$user' and id_tiket=$tiket";
            } elseif ($asunto2 == 'Consulta en area') {
                $query = "UPDATE Tikets set id_proc=2, Asunto='$asunto2', Prioridad = 1 where user_mov='$user' and id_tiket=$tiket";
            }
        } else {
            if ($asunto2 == 'Consulta en Boveda' || $asunto2 == 'Baja') {
                $query = "UPDATE Tikets set id_proc=2, Asunto='$asunto2',estatus = 'A',Prioridad = 0  where user_mov='$user' and id_tiket=$tiket";
            } elseif ($asunto2 == 'Consulta en area') {
                $query = "UPDATE Tikets set id_proc=2, Asunto='$asunto2',Prioridad = 0  where user_mov='$user' and id_tiket=$tiket";
            }
        }
        

        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }


    public static function Proc_estatus_Cancelado()
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "
        update Determinante set id_proc=3, fecha_mod = GETDATE(),user_mod='$user' where id_proc=10 and user_mod='$user'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proc_estatus_pedir()
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "
        update Determinante set id_proc=2, fecha_mod = GETDATE(),user_mod='$user' where id_proc=10 and user_mod='$user'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }

    public static function Proc_peticion_cancelado($tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "
        delete Etapa_poc where id_proc_det=10 and user_alta='$user' and id_tiket=$tiket";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proc_peticion($tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "
        update Etapa_poc set id_proc_det=2 where user_alta='$user' and id_tiket=$tiket";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }

    public static function tiket_cancelado($tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "
        delete Tikets where user_mov='$user' and id_tiket=$tiket";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }

    public static function cambia_estatus_tiket_proc_dev($tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = " UPDATE Tikets SET id_proc = 5, fecha_pet_dev= GETDATE() WHERE id_tiket =$tiket
            UPDATE Etapa_poc SET id_proc_det = 5,user_valida='$user' , fecha_mod= GETDATE() WHERE id_tiket = $tiket
            UPDATE Determinante SET id_proc = 5,user_mod='$user' , fecha_mod = GETDATE()
           FROM Etapa_poc Eta 
           INNER JOIN Determinante det on Eta.id_determinante = det.id_determinante
           WHERE id_tiket = $tiket";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public function Cancelar_Tiket_Solicitud($datos)
    {
        include_once 'sesion.php';

        $RDFDA = explode(", ", $datos);
        $tiket = self::bus_tiket_busqueda($RDFDA[0]);
        $total_array = count($RDFDA) - 1;
        $total_tiket = self::total_tiket($tiket);


        for ($i = 0; $i < count($RDFDA) - 1; $i++) {
            if ($Proceso = !false) {
                $Proc_estatus = self::Proc_cancela_tik($RDFDA[$i]);
            }
        }
        if ($Proc_estatus = !false) {
            if ($total_array == $total_tiket) {
                self::Cancelar_Tiket_Estatus(1, $tiket);
            } else {
                self::Cancelar_Tiket_Estatus(2, $tiket);
            }
            return "Proceso Exitoso";
        } else {
            return "Algo salio mal";
        }
    }
    public function Cambiar_Estatus_Disponible($tiket)
    {
        include_once 'sesion.php';
        include_once 'conexion.php';
        $metodos = new ConsultaContribuyentes();
        $conexion = new ConexionSQL();
        $datos = $metodos->bus_tiket_dispo($tiket);
        $user_valida = $_SESSION['ses_rfc_corto'];
        if (isset($datos)) {
            for ($i=0; $i < count($datos) ; $i++) {
                self::Crea_cambios_etapa_x_det_etapa_dispo($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                self::Cambia_estatus_det_proc_dispo($datos[$i]['id_determinante']);
            }
            self::baja_etapas_anteriores_al_cambio_dispo($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
              $query = "UPDATE Tikets SET id_proc = 11, fecha_dispone = GETDATE(), user_dispone = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
              $con = $conexion->ObtenerConexionBD();
            $prepare = sqlsrv_query($con, $query);
            if ($prepare) {
                return 'Cambio exitoso';
                $conexion->CerrarConexion($con);
            } else {
                return 'no se efectuo el cambio';
                $conexion->CerrarConexion($con);
            }
        } else {
            return 'No se puede hacer esta acción 2 veces';
        }
    }
    public function agrega_motivo_cancel($tiket, $motivo)
    {
        include_once 'sesion.php';
        include_once 'conexion.php';
        $metodos = new ConsultaContribuyentes();
        $conexion = new ConexionSQL();
        $query = "UPDATE Tikets SET motivo_cancel = $motivo  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
        $con = $conexion->ObtenerConexionBD();
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            return 'El ticket se cancelo satisfactoriamente';
            $conexion->CerrarConexion($con);
        } else {
            return 'No se efectuo el movimiento de cancelación';
            $conexion->CerrarConexion($con);
        }
    }
  
    public function Cambiar_Estatus_Cancelado($tiket)
    {
        include_once 'sesion.php';
        include_once 'conexion.php';
        $metodos = new ConsultaContribuyentes();
        $conexion = new ConexionSQL();
        $datos = $metodos->bus_tiket_cancel($tiket);
        $user_valida = $_SESSION['ses_rfc_corto'];
        $perfil = $_SESSION['ses_id_perfil'];
        switch ($perfil) {
            case 1:
                if (isset($datos)) {
                    for ($i=0; $i < count($datos) ; $i++) {
                        self::Crea_cambios_etapa_x_det_etapa_cancelado($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                        self::Cambia_estatus_det_proc_canel($datos[$i]['id_determinante']);
                    }
                    self::baja_etapas_anteriores_al_cambio_cancel($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                      $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                      $con = $conexion->ObtenerConexionBD();
                    $prepare = sqlsrv_query($con, $query);
                    if ($prepare) {
                        return 'El ticket se cancelo satisfactoriamente';
                        $conexion->CerrarConexion($con);
                    } else {
                        return 'No se efectuo el movimiento de cancelación';
                        $conexion->CerrarConexion($con);
                    }
                } else {
                    return 'No se puede hacer esta acción 2 veces';
                }
            break;
            case 8:
                if (isset($datos)) {
                    for ($i=0; $i < count($datos) ; $i++) {
                        self::Crea_cambios_etapa_x_det_etapa_cancelado($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                        self::Cambia_estatus_det_proc_canel($datos[$i]['id_determinante']);
                    }
                    self::baja_etapas_anteriores_al_cambio_cancel($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                      $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                      $con = $conexion->ObtenerConexionBD();
                    $prepare = sqlsrv_query($con, $query);
                    if ($prepare) {
                        return 'El ticket se cancelo satisfactoriamente';
                        $conexion->CerrarConexion($con);
                    } else {
                        return 'No se efectuo el movimiento de cancelación';
                        $conexion->CerrarConexion($con);
                    }
                } else {
                    return 'No se puede hacer esta acción 2 veces';
                }
            break;
            case 2:
                if (isset($datos)) {
                    $estatus_operacion = $datos[0]['id_proc'];
                    if ($estatus_operacion != 2) {
                        return "El ticket se encuentra en proceso de diferente por parte de Bóveda.\n Ya no se puede elimiar la petición en estos momentos.";
                    } else {
                        for ($i=0; $i < count($datos) ; $i++) {
                            self::Crea_cambios_etapa_x_det_etapa_cancelado($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                            self::Cambia_estatus_det_proc_canel($datos[$i]['id_determinante']);
                        }
                        self::baja_etapas_anteriores_al_cambio_cancel($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                          $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                          $con = $conexion->ObtenerConexionBD();
                        $prepare = sqlsrv_query($con, $query);
                        if ($prepare) {
                            return 'El ticket se cancelo satisfactoriamente';
                            $conexion->CerrarConexion($con);
                        } else {
                            return 'No se efectuo el movimiento de cancelación';
                            $conexion->CerrarConexion($con);
                        }
                    }
                } else {
                    return 'Puede que el ticket ya no se encuentre en estado de peticiones';
                }
            break;
            case 9:
                if (isset($datos)) {
                    $estatus_operacion = $datos[0]['id_proc'];
                    if ($estatus_operacion != 2) {
                        return "El ticket se encuentra en proceso de diferente por parte de Bóveda.\n Ya no se puede elimiar la petición en estos momentos.";
                    } else {
                        for ($i=0; $i < count($datos) ; $i++) {
                            self::Crea_cambios_etapa_x_det_etapa_cancelado($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                            self::Cambia_estatus_det_proc_canel($datos[$i]['id_determinante']);
                        }
                        self::baja_etapas_anteriores_al_cambio_cancel($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                          $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                          $con = $conexion->ObtenerConexionBD();
                        $prepare = sqlsrv_query($con, $query);
                        if ($prepare) {
                            return 'El ticket se cancelo satisfactoriamente';
                            $conexion->CerrarConexion($con);
                        } else {
                            return 'No se efectuo el movimiento de cancelación';
                            $conexion->CerrarConexion($con);
                        }
                    }
                } else {
                    return 'Puede que el ticket ya no se encuentre en estado de peticiones';
                }
            break;
            case 4:
                if (isset($datos)) {
                    $estatus_operacion = $datos[0]['id_proc'];
                    if ($estatus_operacion != 2) {
                        return "El ticket se encuentra en proceso diferente por parte de Bóveda.\n Ya no se puede elimiar la petición en estos momentos.";
                    } else {
                        for ($i=0; $i < count($datos) ; $i++) {
                            self::Crea_cambios_etapa_x_det_etapa_cancelado($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                            self::Cambia_estatus_det_proc_canel($datos[$i]['id_determinante']);
                        }
                        self::baja_etapas_anteriores_al_cambio_cancel($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                          $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                          $con = $conexion->ObtenerConexionBD();
                        $prepare = sqlsrv_query($con, $query);
                        if ($prepare) {
                            return 'El ticket se cancelo satisfactoriamente';
                            $conexion->CerrarConexion($con);
                        } else {
                            return 'No se efectuo el movimiento de cancelación';
                            $conexion->CerrarConexion($con);
                        }
                    }
                } else {
                    return 'Puede que el ticket ya no se encuentre en estado de peticiones';
                }
            break;
            case 10:
                if (isset($datos)) {
                    $estatus_operacion = $datos[0]['id_proc'];
                    if ($estatus_operacion != 2) {
                        return "El ticket se encuentra en proceso de diferente por parte de Bóveda.\n Ya no se puede elimiar la petición en estos momentos.";
                    } else {
                        for ($i=0; $i < count($datos) ; $i++) {
                            self::Crea_cambios_etapa_x_det_etapa_cancelado($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                            self::Cambia_estatus_det_proc_canel($datos[$i]['id_determinante']);
                        }
                        self::baja_etapas_anteriores_al_cambio_cancel($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                          $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                          $con = $conexion->ObtenerConexionBD();
                        $prepare = sqlsrv_query($con, $query);
                        if ($prepare) {
                            return 'El ticket se cancelo satisfactoriamente';
                            $conexion->CerrarConexion($con);
                        } else {
                            return 'No se efectuo el movimiento de cancelación';
                            $conexion->CerrarConexion($con);
                        }
                    }
                } else {
                    return 'Puede que el ticket ya no se encuentre en estado de peticiones';
                }
            break;
            case 5:
                if (isset($datos)) {
                    $estatus_operacion = $datos[0]['id_proc'];
                    if ($estatus_operacion != 2) {
                        return "El ticket se encuentra en proceso de diferente por parte de Bóveda.\n Ya no se puede elimiar la petición en estos momentos.";
                    } else {
                        for ($i=0; $i < count($datos) ; $i++) {
                            self::Crea_cambios_etapa_x_det_etapa_cancelado($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                            self::Cambia_estatus_det_proc_canel($datos[$i]['id_determinante']);
                        }
                        self::baja_etapas_anteriores_al_cambio_cancel($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                          $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                          $con = $conexion->ObtenerConexionBD();
                        $prepare = sqlsrv_query($con, $query);
                        if ($prepare) {
                            return 'El ticket se cancelo satisfactoriamente';
                            $conexion->CerrarConexion($con);
                        } else {
                            return 'No se efectuo el movimiento de cancelación';
                            $conexion->CerrarConexion($con);
                        }
                    }
                } else {
                    return 'Puede que el ticket ya no se encuentre en estado de peticiones';
                }
            break;
            case 11:
                if (isset($datos)) {
                    $estatus_operacion = $datos[0]['id_proc'];
                    if ($estatus_operacion != 2) {
                        return "El ticket se encuentra en proceso de diferente por parte de Bóveda.\n Ya no se puede elimiar la petición en estos momentos.";
                    } else {
                        for ($i=0; $i < count($datos) ; $i++) {
                            self::Crea_cambios_etapa_x_det_etapa_cancelado($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                            self::Cambia_estatus_det_proc_canel($datos[$i]['id_determinante']);
                        }
                        self::baja_etapas_anteriores_al_cambio_cancel($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                          $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                          $con = $conexion->ObtenerConexionBD();
                        $prepare = sqlsrv_query($con, $query);
                        if ($prepare) {
                            return 'El ticket se cancelo satisfactoriamente';
                            $conexion->CerrarConexion($con);
                        } else {
                            return 'No se efectuo el movimiento de cancelación';
                            $conexion->CerrarConexion($con);
                        }
                    }
                } else {
                    return 'Puede que el ticket ya no se encuentre en estado de peticiones';
                }
            break;
            case 12:
                if (isset($datos)) {
                    $estatus_operacion = $datos[0]['id_proc'];
                    if ($estatus_operacion != 2) {
                        return "El ticket se encuentra en proceso de diferente por parte de Bóveda.\n Ya no se puede elimiar la petición en estos momentos.";
                    } else {
                        for ($i=0; $i < count($datos) ; $i++) {
                            self::Crea_cambios_etapa_x_det_etapa_cancelado($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                            self::Cambia_estatus_det_proc_canel($datos[$i]['id_determinante']);
                        }
                        self::baja_etapas_anteriores_al_cambio_cancel($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                          $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                          $con = $conexion->ObtenerConexionBD();
                        $prepare = sqlsrv_query($con, $query);
                        if ($prepare) {
                            return 'El ticket se cancelo satisfactoriamente';
                            $conexion->CerrarConexion($con);
                        } else {
                            return 'No se efectuo el movimiento de cancelación';
                            $conexion->CerrarConexion($con);
                        }
                    }
                } else {
                    return 'Puede que el ticket ya no se encuentre en estado de peticiones';
                }
            break;
        }
    }
    public function Cambiar_Estatus_prestamo_tiket($tiket)
    {
        include_once 'sesion.php';
        include_once 'conexion.php';
        $metodos = new ConsultaContribuyentes();
        $conexion = new ConexionSQL();
        $datos = $metodos->bus_tiket_prest($tiket);
        $user_valida = $_SESSION['ses_rfc_corto'];
        if (isset($datos)) {
            for ($i=0; $i < count($datos) ; $i++) {
                self::Crea_cambios_etapa_x_det_etapa_prest($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                self::Cambia_estatus_det_proc_prest($datos[$i]['id_determinante']);
            }
            self::baja_etapas_anteriores_al_cambio_prest($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
              $query = "UPDATE Tikets SET id_proc = 8, fecha_prest = GETDATE(), user_prest = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
              $con = $conexion->ObtenerConexionBD();
            $prepare = sqlsrv_query($con, $query);
            if ($prepare) {
                return 'El ticket se entrego al usuario satisfactoriamente';
                $conexion->CerrarConexion($con);
            } else {
                return 'No se efectuo el movimiento';
                $conexion->CerrarConexion($con);
            }
        } else {
            return 'No se puede hacer esta acción 2 veces';
        }
    }
    public function Cambiar_Estatus_Prestamo($datos)
    {
        include_once 'sesion.php';

        $RDFDA = explode(", ", $datos);
        $tiket = self::bus_tiket_busqueda($RDFDA[0]);
        $total_array = count($RDFDA) - 1;
        $total_tiket = self::total_tiket($tiket);


        for ($i = 0; $i < count($RDFDA) - 1; $i++) {
            $Proc_estatus = self::Proc_Prestamo($RDFDA[$i]);
        }
        if ($Proc_estatus = !false) {
            if ($total_array == $total_tiket) {
                self::cambia_estatus_tiket_prestamo(1, $tiket);
            } else {
                self::cambia_estatus_tiket_prestamo(2, $tiket);
            }
            return "Proceso Exitoso";
        } else {
            return "Algo salio mal";
        }
    }
    public function Filtro_entrega_parcial($Tiket)
    {
        include_once 'sesion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $query = "SELECT COUNT(*) AS total_det FROM Etapa_poc WHERE id_tiket = $Tiket";
        $prepare = sqlsrv_query($con, $query);
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $contador = $row['total_det'];
            return $contador;
        }
    }
    public function Peticion_tiket_dev($tiket)
    {
        include_once 'sesion.php';
        include_once 'conexion.php';
        $metodos = new ConsultaContribuyentes();
        $conexion = new ConexionSQL();
        $datos = $metodos->bus_tiket_prest_pet_dev($tiket);
        $user_valida = $_SESSION['ses_rfc_corto'];
        if (isset($datos)) {
            for ($i=0; $i < count($datos) ; $i++) {
                self::Crea_cambios_etapa_x_det_etapa_pet_dev($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                self::Cambia_estatus_det_proc_pet_dev($datos[$i]['id_determinante']);
            }
            self::baja_etapas_anteriores_al_cambio_pet_dev($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
              $query = "UPDATE Tikets SET id_proc = 5,fecha_pet_dev = GETDATE() WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
              $con = $conexion->ObtenerConexionBD();
            $prepare = sqlsrv_query($con, $query);
            if ($prepare) {
                return 'El ticket se cambio a petición de devolución satisfactoriamente';
                $conexion->CerrarConexion($con);
            } else {
                return 'No se efectuo el movimiento de cancelación';
                $conexion->CerrarConexion($con);
            }
        } else {
            return 'No se puede hacer esta acción 2 veces';
        }
    }
    public function Boveda_tiket_dev_interna($tiket)
    {
        include_once 'sesion.php';
        include_once 'conexion.php';
        $metodos = new ConsultaContribuyentes();
        $conexion = new ConexionSQL();
        $datos = $metodos->bus_tiket_prest_pet_dev_INT($tiket);
        $user_valida = $_SESSION['ses_rfc_corto'];
        if (isset($datos)) {
            for ($i=0; $i < count($datos) ; $i++) {
                self::Crea_cambios_etapa_x_det_etapa_pet_dev_interna_bov($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                self::Cambia_estatus_det_proc_pet_dev_inter_bov($datos[$i]['id_determinante']);
            }
            self::baja_etapas_anteriores_al_cambio_pet_dev_interna_bov($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
              $query = "UPDATE Tikets SET id_proc = 4, fecha_recive_comp = GETDATE(), user_recive_comp = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
              $con = $conexion->ObtenerConexionBD();
            $prepare = sqlsrv_query($con, $query);
            if ($prepare) {
                return 'El ticket se cambio a petición de devolución interna.';
                $conexion->CerrarConexion($con);
            } else {
                return 'No se efectuo el movimiento de devolución interna.';
                $conexion->CerrarConexion($con);
            }
        } else {
            return 'El ticket no fue un prestamo interno de Bóveda';
        }
    }
    public function bus_tiket_disponibles_por_caducar_2($tiket, $diferencia, $dia_de_semana)
    {
        include_once 'sesion.php';
        include_once 'conexion.php';
        $metodos = new ConsultaContribuyentes();
        $conexion = new ConexionSQL();
        $datos = $metodos->bus_tiket_caduc_dispo($tiket);
        $user_valida = $_SESSION['ses_rfc_corto'];
        if (isset($datos)) {
            if ($dia_de_semana == 2 || $dia_de_semana == 3 || $dia_de_semana == 4) {
                if ($diferencia >=48) {
                    for ($i=0; $i < count($datos) ; $i++) {
                        self::Crea_cambios_etapa_x_det_etapa_caduca_dispo($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                        self::Cambia_estatus_det_proc_pet_dev_inter_bov($datos[$i]['id_determinante']);
                    }
                    self::baja_etapas_anteriores_al_cambio_caduc_dispo($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                      $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = 'BOVEDASA'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                      $con = $conexion->ObtenerConexionBD();
                    $prepare = sqlsrv_query($con, $query);
                    if ($prepare) {
                        return 'El ticket se cambio a petición de devolución interna.';
                        $conexion->CerrarConexion($con);
                    } else {
                        return 'No se efectuo el movimiento de devolución interna.';
                        $conexion->CerrarConexion($con);
                    }
                }
            } elseif ($dia_de_semana == 5||$dia_de_semana ==6) {
                if ($dia_de_semana == 5) {
                    if ($diferencia >=72) {
                        for ($i=0; $i < count($datos) ; $i++) {
                            self::Crea_cambios_etapa_x_det_etapa_caduca_dispo($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                            self::Cambia_estatus_det_proc_pet_dev_inter_bov($datos[$i]['id_determinante']);
                        }
                        self::baja_etapas_anteriores_al_cambio_caduc_dispo($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                          $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = 'BOVEDASA'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                          $con = $conexion->ObtenerConexionBD();
                        $prepare = sqlsrv_query($con, $query);
                        if ($prepare) {
                            return 'El ticket se cambio a petición de devolución interna.';
                            $conexion->CerrarConexion($con);
                        } else {
                            return 'No se efectuo el movimiento de devolución interna.';
                            $conexion->CerrarConexion($con);
                        }
                    }
                } elseif ($dia_de_semana ==6) {
                    if ($diferencia >=96) {
                        for ($i=0; $i < count($datos) ; $i++) {
                            self::Crea_cambios_etapa_x_det_etapa_caduca_dispo($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                            self::Cambia_estatus_det_proc_pet_dev_inter_bov($datos[$i]['id_determinante']);
                        }
                        self::baja_etapas_anteriores_al_cambio_caduc_dispo($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                          $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = 'BOVEDASA'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                          $con = $conexion->ObtenerConexionBD();
                        $prepare = sqlsrv_query($con, $query);
                        if ($prepare) {
                            return 'El ticket se cambio a petición de devolución interna.';
                            $conexion->CerrarConexion($con);
                        } else {
                            return 'No se efectuo el movimiento de devolución interna.';
                            $conexion->CerrarConexion($con);
                        }
                    }
                }
            }
        } else {
            return '';
        }
    }

    public function Estatus_Tiket_Procesos_dev_parc_completo($RDFDAs, $tiket)
    {
        include_once 'sesion.php';
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $datos = self::bus_tiket_prest_pet_dev_par_com($tiket);
        $det_devuletas = self::total_tiket_consulta_det_devueltas($tiket);
        $RDFDA = explode(", ", $RDFDAs);
        $total_array = count($RDFDA)-1 ;
        $user_valida = $_SESSION['ses_rfc_corto'];
        $user_alta = $datos[0]['user_alta'];
        $filtro = count($datos);
        $diferencia = ($filtro - $det_devuletas);
        if (isset($datos)) {
            if ($filtro != $total_array) {
                for ($i=0; $i < $total_array ; $i++) {
                    self::Crea_cambios_etapa_x_det_etapa_pet_pacial($tiket, $user_alta, $RDFDA[$i]);
                    self::Cambia_estatus_det_proc_pet_PARCIAL($RDFDA[$i]);
                    self::baja_etapas_anteriores_al_cambio_pet_dev_parc($tiket, $RDFDA[$i]); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                }
                $query = "UPDATE Tikets SET id_proc = 9, fecha_recive_par = GETDATE(), user_recive_par = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                $prepare = sqlsrv_query($con, $query);
                if ($prepare) {
                    return 'El ticket fue devuelto de manera parcial';
                    $conexion->CerrarConexion($con);
                } else {
                    return false;
                }
            } elseif ($filtro == $total_array || $total_array == $diferencia) {
                for ($i=0; $i < count($datos) ; $i++) {
                    self::Crea_cambios_etapa_x_det_etapa_pet_dev_interna_bov($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                    self::Cambia_estatus_det_proc_pet_dev_inter_bov($datos[$i]['id_determinante']);
                }
                self::baja_etapas_anteriores_al_cambio_pet_dev_comp($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                  $query = "UPDATE Tikets SET id_proc = 4, fecha_recive_comp = GETDATE(), user_recive_comp = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                  $prepare = sqlsrv_query($con, $query);
                if ($prepare) {
                    return 'El ticket fue devuelto satisfactoriamente';
                    $conexion->CerrarConexion($con);
                } else {
                    return false;
                }
            }
        } else {
            return 'El ticket no cuenta con determinantes en peticion de devolución';
        }
    }
    public function Estatus_Tiket_Prestamos_dev_parc_completo($RDFDAs, $tiket)
    {
        include_once 'sesion.php';
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $datos = self::bus_tiket_prest_pet_dev_par_com($tiket);
        $det_devuletas = self::total_tiket_consulta_det_devueltas($tiket);
        $RDFDA = explode(", ", $RDFDAs);
        $total_array = count($RDFDA)-1 ;
        $user_valida = $_SESSION['ses_rfc_corto'];
        $user_alta = $datos[0]['user_alta'];
        $filtro = count($datos);
        $diferencia = ($filtro - $det_devuletas);
        if (isset($datos)) {
            if ($filtro != $total_array) {
                for ($i=0; $i < $total_array ; $i++) {
                    self::Crea_cambios_etapa_x_det_etapa_pet_pacial($tiket, $user_alta, $RDFDA[$i]);
                    self::Cambia_estatus_det_proc_pet_PARCIAL($RDFDA[$i]);
                    self::baja_etapas_anteriores_al_cambio_pet_dev_parc($tiket, $RDFDA[$i]); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                }
                $query = "UPDATE Tikets SET id_proc = 9, fecha_recive_par = GETDATE(), user_recive_par = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                $prepare = sqlsrv_query($con, $query);
                if ($prepare) {
                    return 'El ticket fue devuelto de manera parcial';
                    $conexion->CerrarConexion($con);
                } else {
                    return false;
                }
            } elseif ($filtro == $total_array || $total_array == $diferencia) {
                for ($i=0; $i < count($datos) ; $i++) {
                    self::Crea_cambios_etapa_x_det_etapa_pet_dev_interna_bov($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                    self::Cambia_estatus_det_proc_pet_dev_inter_bov($datos[$i]['id_determinante']);
                }
                self::baja_etapas_anteriores_al_cambio_pet_dev_comp($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                  $query = "UPDATE Tikets SET id_proc = 4, fecha_recive_comp = GETDATE(), user_recive_comp = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                  $prepare = sqlsrv_query($con, $query);
                if ($prepare) {
                    return 'El ticket fue devuelto satisfactoriamente';
                    $conexion->CerrarConexion($con);
                } else {
                    return false;
                }
            }
        } else {
            return 'El ticket no cuenta con determinantes en peticion de devolución';
        }
    }




    public function Comprueba_Tiket_Viable($tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "SELECT id_proc FROM Tikets Where  id_tiket = $tiket";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas = array('id_proc' => $row["id_proc"]);
            }
            sqlsrv_close($con);

            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
        } else {
            print_r(sqlsrv_errors(), true);
        }
    }



    public static function Genera_tiket()
    {
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();

        $query = "INSERT INTO Tikets (user_mov,fecha_mov,estatus,id_proc)
        VALUES ('$user',GETDATE(),'N',10)  SELECT SCOPE_IDENTITY()id_tiket";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            sqlsrv_next_result($prepare);
            sqlsrv_fetch($prepare);
            $fila = array('id_tiket' => sqlsrv_get_field($prepare, 0));
            if ($fila["id_tiket"] != null) {
                return $fila["id_tiket"];
            } else {
                return print_r(sqlsrv_errors(), true);
            }
        }
    }
    public static function Proceso_peticion($RDFDA, $tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "INSERT INTO Etapa_poc (id_proc_det,user_alta,fecha_alta,id_determinante,id_tiket,estatus) 
        VALUES(
            10,'$user',GETDATE(),
            (SELECT id_determinante FROM determinante WHERE RDFDA='$RDFDA'),$tiket,'A'
            )";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proceso_entrega_parcial($RDFDA, $tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "INSERT INTO Etapa_poc (id_proc_det,user_alta,fecha_alta,id_determinante,id_tiket,estatus) 
        VALUES(
            4,'$user',GETDATE(),
            (SELECT id_determinante FROM determinante WHERE RDFDA='$RDFDA'),$tiket,'A'
            )";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Cancelar_Tiket_Estatus($estatus, $tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        if ($estatus == 1) {
            $query = "UPDATE Tikets SET id_proc = 12 ,estatus= 'N', [user_cancel]='$user' , [fecha_cancel]= GETDATE() WHERE id_tiket =$tiket
                UPDATE Etapa_poc SET id_proc_det = 12, user_valida='$user' , estatus= 'N', fecha_mod= GETDATE() WHERE id_tiket = $tiket
                UPDATE Determinante SET id_proc = 3,user_mod = '$user',  fecha_mod = GETDATE() 
                FROM Etapa_poc Eta 
                INNER JOIN Determinante det on Eta.id_determinante = det.id_determinante
                WHERE id_tiket = $tiket";
        } else {
            $query = "UPDATE Tikets SET id_proc = 12 ,estatus= 'N', [user_cancel]='$user' , [fecha_cancel]= GETDATE() WHERE id_tiket =$tiket
                UPDATE Etapa_poc SET id_proc_det = 12, user_valida='$user' , estatus= 'N', fecha_mod= GETDATE() WHERE id_tiket = $tiket
                UPDATE Determinante SET id_proc = 3,user_mod = '$user',  fecha_mod = GETDATE() 
                FROM Etapa_poc Eta 
                INNER JOIN Determinante det on Eta.id_determinante = det.id_determinante
                WHERE id_tiket = $tiket";
        }

        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proceso_Prestamo($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $tiket = self::bus_tiket($tiket);
        $query = " INSERT INTO Etapa_poc (id_proc_det,user_alta,fecha_alta,id_determinante,id_tiket,estatus) 
        VALUES(8,'" . $user . "',GETDATE(),
            (SELECT id_determinante FROM determinante WHERE RDFDA='" . $RDFDA . "'),$tiket,'A'
            )";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function cambia_estatus_tiket($tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = " UPDATE Tikets SET id_proc = 11, user_dispone='$user' , fecha_dispone= GETDATE() WHERE id_tiket =$tiket
        UPDATE Etapa_poc SET id_proc_det = 11,user_valida='$user' , fecha_mod= GETDATE() WHERE id_tiket = $tiket AND estatus = 'A'
        UPDATE Determinante SET id_proc = 11,user_mod='$user' , fecha_mod = GETDATE()
        FROM Etapa_poc Eta 
        INNER JOIN Determinante det on Eta.id_determinante = det.id_determinante
        WHERE id_tiket = $tiket";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function cambia_estatus_tiket_dev($estatus, $tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        if ($estatus == 1) {
            $query = " UPDATE Tikets SET id_proc = 5 ,  fecha_mov= GETDATE() WHERE id_tiket =$tiket
             UPDATE Etapa_poc SET id_proc_det = 5, fecha_mod= GETDATE() WHERE id_tiket = $tiket
             UPDATE Determinante SET id_proc = 5, fecha_mod = GETDATE()
            FROM Etapa_poc Eta 
            INNER JOIN Determinante det on Eta.id_determinante = det.id_determinante
            WHERE id_tiket = $tiket";
        } else {
            $query = " UPDATE Tikets SET id_proc = 5 , fecha_mov= GETDATE() WHERE id_tiket =$tiket
            UPDATE Etapa_poc SET id_proc_det = 5, fecha_mod= GETDATE() WHERE id_tiket = $tiket
            UPDATE Determinante SET id_proc = 5, fecha_mod = GETDATE()
            FROM Etapa_poc Eta 
            INNER JOIN Determinante det on Eta.id_determinante = det.id_determinante
            WHERE id_tiket = $tiket";
        }


        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function cambia_estatus_tiket_prestamo($estatus, $tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        if ($estatus == 1) {
            $query = " UPDATE Tikets SET id_proc = 8 , user_prest = '$user', fecha_prest= GETDATE() WHERE id_tiket =$tiket
             UPDATE Etapa_poc SET id_proc_det = 8,user_valida = '$user', fecha_mod= GETDATE() WHERE id_tiket = $tiket
             UPDATE Determinante SET id_proc = 8,user_mod = '$user',  fecha_mod = GETDATE()
            FROM Etapa_poc Eta 
            INNER JOIN Determinante det on Eta.id_determinante = det.id_determinante
            WHERE id_tiket = $tiket";
        } else {
            $query = " UPDATE Tikets SET id_proc = 8 , user_prest = '$user', fecha_prest= GETDATE() WHERE id_tiket =$tiket
            UPDATE Etapa_poc SET id_proc_det = 8,user_valida = '$user', fecha_mod= GETDATE() WHERE id_tiket = $tiket
            UPDATE Determinante SET id_proc = 8,user_mod = '$user',  fecha_mod = GETDATE()
           FROM Etapa_poc Eta 
           INNER JOIN Determinante det on Eta.id_determinante = det.id_determinante
           WHERE id_tiket = $tiket";
        }

        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }

    public static function cambia_estatus_cerrar_tiket_Completo($tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();

        $query = "UPDATE Tikets SET id_proc = 4 , [user_recive_comp]='$user' , [fecha_recive_comp]= GETDATE() WHERE id_tiket =$tiket
        UPDATE Etapa_poc SET id_proc_det = 4, user_valida='$user', fecha_mod= GETDATE() WHERE id_tiket = $tiket AND estatus = 'A'
        UPDATE Determinante SET id_proc = 3,user_mod = '$user',  fecha_mod = GETDATE() 
        FROM Etapa_poc Eta 
        INNER JOIN Determinante det on Eta.id_determinante = det.id_determinante
        WHERE Eta.id_tiket = $tiket AND Eta.estatus = 'A'";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function cambia_estatus_tiket_Parcial($tiket)
    {
        include_once 'conexion.php';

        include_once 'sesion.php';

        $conexion = new ConexionSQL();

        $user = $_SESSION["ses_rfc_corto"];

        $con = $conexion->ObtenerConexionBD();

        $query = "UPDATE Tikets SET id_proc = 9 ,estatus= 'A', [user_recive_par]='$user' , [fecha_recive_par]= GETDATE() WHERE id_tiket =$tiket";

        $prepare = sqlsrv_query($con, $query);

        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);

            $conexion->CerrarConexion($con);

            return $errorsql;
        } else {
            return true;

            $conexion->CerrarConexion($con);
        }
    }
    public static function cambia_estatus_tiket_COMPLETO($tiket)
    {
        include_once 'conexion.php';

        include_once 'sesion.php';

        $conexion = new ConexionSQL();

        $user = $_SESSION["ses_rfc_corto"];

        $con = $conexion->ObtenerConexionBD();

        $query = "UPDATE Tikets SET id_proc = 4 ,estatus= 'A', [user_recive_comp]='$user' , [fecha_recive_comp]= GETDATE() WHERE id_tiket =$tiket";

        $prepare = sqlsrv_query($con, $query);

        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);

            $conexion->CerrarConexion($con);

            return $errorsql;
        } else {
            return true;

            $conexion->CerrarConexion($con);
        }
    }
    public static function Proceso_devolucion($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $tiket = self::bus_tiket($RDFDA);
        $query = "
        insert into Etapa_poc (id_proc_det,user_alta,fecha_alta,id_determinante,id_tiket,estatus) 
        values(
            5,'" . $user . "',GETDATE(),
            (select id_determinante from determinante where RDFDA='" . $RDFDA . "'),$tiket,'A'
            )";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            $conexion->CerrarConexion($con);
            return true;
        }
    }

    public static function Proc_estatus($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "
        update Determinante set id_proc=10, fecha_mod = GETDATE(),user_mod='" . $user . "' where RDFDA ='" . $RDFDA . "'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proc_estatus_parcial($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "
        update Determinante set id_proc=4, fecha_mod = GETDATE(),user_mod='" . $user . "' where RDFDA ='" . $RDFDA . "'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Cambia_estatus_det($det, $estatus)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        switch ($estatus) {
            case 'A':
                $query = "UPDATE Determinante SET  estatus_cred = 'A', user_mod_est = '$user', fecha_mod_est = GETDATE()  where RDFDA = '$det'";
                break;
            case 'B':
                $query = "UPDATE Determinante SET  estatus_cred = 'B', user_mod_est = '$user', fecha_mod_est = GETDATE()  where RDFDA = '$det'";
                break;
        }

        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return 'La determinante no cambiado su estatus';
        } else {
            return 'La determinante ha cambiado su estatus';
            $conexion->CerrarConexion($con);
        }
    }
    public static function Cambia_estatus_det_proc($det)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
 
        $query = "UPDATE Determinante SET  id_proc = 7, user_mod_est = '$user', fecha_mod_est = GETDATE()  where id_determinante = $det";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return 'La determinante no cambiado su estatus';
        } else {
            return 'La determinante ha cambiado su estatus';
            $conexion->CerrarConexion($con);
        }
    }
    public static function Cambia_estatus_det_proc_dispo($det)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
 
        $query = "UPDATE Determinante SET  id_proc = 11, user_mod_est = '$user', fecha_mod_est = GETDATE()  where id_determinante = $det";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return 'La determinante no cambiado su estatus';
        } else {
            return 'La determinante ha cambiado su estatus';
            $conexion->CerrarConexion($con);
        }
    }
    public static function Cambia_estatus_det_proc_canel($det)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
 
        $query = "UPDATE Determinante SET  id_proc = 3, user_mod_est = '$user', fecha_mod_est = GETDATE()  where id_determinante = $det";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return 'La determinante no cambiado su estatus';
        } else {
            return 'La determinante ha cambiado su estatus';
            $conexion->CerrarConexion($con);
        }
    }
    public static function Cambia_estatus_det_proc_pet_dev($det)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
 
        $query = "UPDATE Determinante SET  id_proc = 5 , user_mod_est = '$user', fecha_mod_est = GETDATE()  where id_determinante = $det";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return 'La determinante no cambiado su estatus';
        } else {
            return 'La determinante ha cambiado su estatus';
            $conexion->CerrarConexion($con);
        }
    }
    public static function Cambia_estatus_det_proc_pet_dev_inter_bov($det)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
 
        $query = "UPDATE Determinante SET  id_proc = 3 , user_mod_est = '$user', fecha_mod_est = GETDATE()  where id_determinante = $det";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return 'La determinante no cambiado su estatus';
        } else {
            return 'La determinante ha cambiado su estatus';
            $conexion->CerrarConexion($con);
        }
    }
    public static function Cambia_estatus_det_proc_pet_PARCIAL($det)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
 
        $query = "UPDATE Determinante SET  id_proc = 3 , user_mod_est = '$user', fecha_mod_est = GETDATE()  where RDFDA = '$det'";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return 'La determinante no cambiado su estatus';
        } else {
            return 'La determinante ha cambiado su estatus';
            $conexion->CerrarConexion($con);
        }
    }
    public static function Cambia_estatus_det_proc_prest($det)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
 
        $query = "UPDATE Determinante SET  id_proc = 8, user_mod_est = '$user', fecha_mod_est = GETDATE()  where id_determinante = $det";

        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return 'La determinante no cambiado su estatus';
        } else {
            return 'La determinante ha cambiado su estatus';
            $conexion->CerrarConexion($con);
        }
    }
    public static function inserta_cambio_estatus($busca_id_det, $tiket, $estatus)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "  INSERT INTO Etapa_poc 
        (user_alta,
        id_determinante,
        fecha_alta,
        estatus,
        id_proc_det,
        id_tiket,
        estatus_det_cam)
        values(
        '$user'
        ,$busca_id_det,
        GETDATE(),
        'N'
        ,13,
        $tiket,
        '$estatus')";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return 'La determinante no cambiado su estatus';
        } else {
            return 'La determinante ha cambiado su estatus';
            $conexion->CerrarConexion($con);
        }
    }
    public static function inserta_cambio_estatus_visor($busca_id_det, $estatus)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "  INSERT INTO Etapa_poc 
        (user_alta,
        id_determinante,
        fecha_alta,
        estatus,
        id_proc_det,
        estatus_det_cam)
        values(
        '$user'
        ,$busca_id_det,
        GETDATE(),
        'N'
        ,13,
        '$estatus')";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return 'La determinante no cambiado su estatus';
        } else {
            return 'La determinante ha cambiado su estatus';
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proc_devocuion($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "
        update Determinante set id_proc=5, fecha_mod = GETDATE(),user_mod='" . $user . "' where RDFDA ='" . $RDFDA . "'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proc_disponible($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "UPDATE Determinante SET id_proc=11, fecha_mod = GETDATE(),user_mod='" . $user . "' WHERE RDFDA ='" . $RDFDA . "'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proc_cancela_tik($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "UPDATE Determinante SET id_proc=3, fecha_mod = GETDATE(),user_mod='" . $user . "' WHERE RDFDA ='" . $RDFDA . "'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proc_Prestamo($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "UPDATE Determinante SET id_proc=8, fecha_mod = GETDATE(),user_mod='" . $user . "' WHERE RDFDA ='" . $RDFDA . "'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proc_Dev($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "UPDATE Determinante SET id_proc=5, fecha_mod = GETDATE(),user_mod='" . $user . "' WHERE RDFDA ='" . $RDFDA . "'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proc_Cerrar_Tiket($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "UPDATE Determinante SET id_proc=3, fecha_mod = GETDATE(),user_mod=' $user' WHERE RDFDA ='$RDFDA'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Proc_Parcial_Tiket($RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = "UPDATE Determinante SET id_proc=3, fecha_mod = GETDATE(),user_mod=' $user' WHERE RDFDA ='$RDFDA'";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function bus_peticion_tikets($numero)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        $depto = $_SESSION["ses_id_depto"];
        $sub_admin = $_SESSION["ses_id_sub_admin"];
        $admin = $_SESSION["ses_id_admin"];
        $id_perfil = $_SESSION['ses_id_perfil'];
        if (isset($numero)) {
            switch ($id_perfil) {
                case 1:
                    $condiciones_pet = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and (id_proc=2 OR id_proc=7 OR id_proc=11 OR id_proc= 3) and Tik.estatus= 'A'";
                    break;
                case 8:
                    $condiciones_pet = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and (id_proc=2 OR id_proc=7 OR id_proc=11 OR id_proc= 3) and Tik.estatus= 'A'";
                    break;
                case 2:
                    $condiciones_pet = "WHERE (id_tiket like '%$numero%' and user_mov = '$user') and (id_proc=2 OR id_proc=7 OR id_proc=11 OR id_proc= 3 ) and Tik.estatus= 'A'";
                    break;
                    case 9:
                        $condiciones_pet = "WHERE (id_tiket like '%$numero%' and user_mov = '$user') and (id_proc=2 OR id_proc=7 OR id_proc=11 OR id_proc= 3 ) and Tik.estatus= 'A'";
                        break;
                case 4:
                    $condiciones_pet = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and  Emp.id_depto = $depto and ( id_proc=2 OR id_proc=7 OR id_proc=11 OR id_proc= 3) and Tik.estatus= 'A'";
                    break;
                    case 10:
                        $condiciones_pet = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and  Emp.id_depto = $depto and ( id_proc=2 OR id_proc=7 OR id_proc=11 OR id_proc= 3) and Tik.estatus= 'A'";
                        break;
                case 5:
                    $condiciones_pet = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and Emp.id_sub_admin = $sub_admin and ( id_proc=2 OR id_proc=7 OR id_proc=11 OR id_proc= 3) and Tik.estatus= 'A'";
                    break;
                    case 11:
                        $condiciones_pet = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and Emp.id_sub_admin = $sub_admin and ( id_proc=2 OR id_proc=7 OR id_proc=11 OR id_proc= 3) and Tik.estatus= 'A'";
                        break;
                case 7:
                    $condiciones_pet = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and Emp.id_admin = $admin and ( id_proc=2 OR id_proc=7 OR id_proc=11 OR id_proc= 3) and Tik.estatus= 'A'";
                    break;
                    case 12:
                        $condiciones_pet = "WHERE Emp.id_sub_admin = $sub_admin AND ( id_proc=2 OR id_proc=7 OR id_proc=11) and Tik.estatus= 'A'";
                        break;
            }
        } else {
            switch ($id_perfil) {
                case 1:
                    $condiciones_pet = "WHERE id_proc=2 OR id_proc=7 OR id_proc=11 and Tik.estatus= 'A'";
                    break;
                case 8:
                    $condiciones_pet = "WHERE id_proc=2 OR id_proc=7 OR id_proc=11 and Tik.estatus= 'A'";
                    break;
                case 2:
                    $condiciones_pet = " WHERE user_mov='$user' AND (id_proc=2 or id_proc=7 OR id_proc=11) and Tik.estatus= 'A'";
                    break;
                    case 9:
                        $condiciones_pet = " WHERE user_mov='$user' AND (id_proc=2 or id_proc=7 OR id_proc=11) and Tik.estatus= 'A'";
                        break;
                case 4:
                    $condiciones_pet = "WHERE Emp.id_depto = $depto AND ( id_proc=2 OR id_proc=7 OR id_proc=11) and Tik.estatus= 'A'";
                    break;
                    case 10:
                        $condiciones_pet = "WHERE Emp.id_depto = $depto AND ( id_proc=2 OR id_proc=7 OR id_proc=11) and Tik.estatus= 'A'";
                        break;
                case 5:
                    $condiciones_pet = "WHERE Emp.id_sub_admin = $sub_admin AND ( id_proc=2 OR id_proc=7 OR id_proc=11) and Tik.estatus= 'A'";
                    break;
                    case 11:
                        $condiciones_pet = "WHERE Emp.id_sub_admin = $sub_admin AND ( id_proc=2 OR id_proc=7 OR id_proc=11) and Tik.estatus= 'A'";
                        break;
                case 12:
                    $condiciones_pet = "WHERE Emp.id_sub_admin = $sub_admin AND ( id_proc=2 OR id_proc=7 OR id_proc=11) and Tik.estatus= 'A'";
                    break;
                case 7:
                    $condiciones_pet = "WHERE Emp.id_admin = $admin AND ( id_proc=2 OR id_proc=7 OR id_proc=11) and Tik.estatus= 'A'";
                    break;
            }
        }

        $query = " SELECT TOP (100)
        Tik.id_tiket,
        Tik.id_proc,
        Tik.user_mov,
        Tik.Prioridad,
        Tik.fecha_mov,
        Tik.fecha_valida,
        Tik.fecha_dispone
        FROM Tikets Tik 
        INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto 
        $condiciones_pet ORDER BY Prioridad DESC,  id_proc ASC ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function bus_tiket($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " select
        etapa.id_tiket
        from Etapa_poc etapa
        inner join Determinante det on det.id_determinante=etapa.id_determinante
        inner join Expediente expe on expe.id_expediente=det.id_expediente
        inner join Contribuyente contri on contri.id_contribuyente=expe.id_contribuyente
        where det.RDFDA='$RDFDA'
        and id_proc_det=8";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $tiket = $row['id_tiket'];
            return $tiket;
        }
    }
    public static function bus_tiket_busqueda($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " select
        etapa.id_tiket
        from Etapa_poc etapa
        inner join Determinante det on det.id_determinante=etapa.id_determinante
        inner join Expediente expe on expe.id_expediente=det.id_expediente
        inner join Contribuyente contri on contri.id_contribuyente=expe.id_contribuyente
        where det.RDFDA='$RDFDA'
        and (id_proc_det=2 or id_proc_det=7 or id_proc_det=11 )";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $tiket = $row['id_tiket'];
            return $tiket;
        }
    }
    public static function bus_tiket_busqueda_dis($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " select
        etapa.id_tiket
        from Etapa_poc etapa
        inner join Determinante det on det.id_determinante=etapa.id_determinante
        inner join Expediente expe on expe.id_expediente=det.id_expediente
        inner join Contribuyente contri on contri.id_contribuyente=expe.id_contribuyente
        where det.RDFDA='$RDFDA'
        and (id_proc_det=2 or id_proc_det=7 or id_proc_det=11 )";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $tiket = $row['id_tiket'];
            return $tiket;
        }
    }
    public static function bus_tiket_disponibles_por_caducar()
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = "SELECT DATEDIFF(HOUR,fecha_dispone,GETDATE()) as diferencia,(select DATEPART(dw,fecha_dispone) as DIA from tikets where id_proc = 11 ) dia_sem,id_tiket  from Tikets where id_proc = 11 ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                //$respuesta[] = array('id_tiket' =>$row['id_tiket'], 'diferencia' => $row['diferencia']);
                $respuesta[] = $row;
            }
            if (isset($respuesta)) {
                for ($i = 0; $i < count($respuesta); $i++) {
                    $tiket = $respuesta[$i]['id_tiket'];
                    $diferencia = $respuesta[$i]['diferencia'];
                    $dia_sem = $respuesta[$i]['dia_sem'];
                    self::bus_tiket_disponibles_por_caducar_2($tiket, $diferencia, $dia_sem);
                }
            }
        }
    }
    public function Depura_tiket_disponible_caducos($tiket, $diferencia)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        if ($diferencia >= 1) {
            $query = "UPDATE Tikets SET id_proc = 12 ,estatus= 'N', [user_cancel]='BOVEDASA' , [fecha_cancel]= GETDATE() WHERE id_tiket =$tiket
            UPDATE Etapa_poc SET id_proc_det = 12, user_valida='BOVEDASA' , estatus= 'N', fecha_mod= GETDATE() WHERE id_tiket = $tiket and estatus = 'A'
            UPDATE Determinante SET id_proc = 3,user_mod = 'BOVEDASA',  fecha_mod = GETDATE() 
            FROM Etapa_poc Eta 
            INNER JOIN Determinante det on Eta.id_determinante = det.id_determinante
            WHERE id_tiket = $tiket";
            $con = $conexion->ObtenerConexionBD();
            //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
            $prepare = sqlsrv_query($con, $query);
            if ($prepare === false) {
                $errorsql = print_r(sqlsrv_errors(), false);
                $conexion->CerrarConexion($con);
                return $errorsql;
            } else {
                return true;
                $conexion->CerrarConexion($con);
            }
            return 'éxito';
        } else {
            return 'no se econtraron tikets con mas de 1 dia en disponibles';
        }
    }

    public static function bus_tiket_peticion_por_caducar()
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = "SELECT DATEDIFF(HOUR,fecha_mov,GETDATE()) as diferencia,(select DATEPART(dw,fecha_mov) as DIA from tikets where id_proc = 2 ) dia_sem,id_tiket  from Tikets where id_proc = 2 ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                //$respuesta[] = array('id_tiket' =>$row['id_tiket'], 'diferencia' => $row['diferencia']);
                $respuesta[] = $row;
            }
            for ($i = 0; $i < count($respuesta); $i++) {
                self::Depura_tiket_peticion_caducos($respuesta[$i]['id_tiket'], $respuesta[$i]['diferencia'], $respuesta[$i]['dia_sem']);
            }
        }
    }
    public static function bus_tiket_de_dias_dispo_en_prest($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        //SE CREA UN QUERY
        $query = "SELECT DATEDIFF(HOUR,fecha_prest,GETDATE()) as diferencia,(select DATEPART(dw,fecha_prest) as DIA from Tikets where id_proc = 8 and id_tiket = $tiket ) dia_sem ,id_tiket  from Tikets where id_proc = 8 and id_tiket = $tiket  
        ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                //$respuesta[] = array('id_tiket' =>$row['id_tiket'], 'diferencia' => $row['diferencia']);
                $respuesta[] = $row;
            }
            if (isset($respuesta)) {
                return $respuesta;
            } else {
                return false;
            }
        }
    }
    
    public function Depura_tiket_peticion_caducos($tiket, $diferencia, $dia_de_semana)
    {
        include_once 'sesion.php';
        include_once 'conexion.php';
        $metodos = new ConsultaContribuyentes();
        $conexion = new ConexionSQL();
        $datos = $metodos->bus_tiket_caduc_peticion($tiket);
        $user_valida = $_SESSION['ses_rfc_corto'];
        if (isset($datos)) {
            if ($dia_de_semana == 2 || $dia_de_semana == 3) {
                if ($diferencia >=72) {
                    for ($i=0; $i < count($datos) ; $i++) {
                        self::Crea_cambios_etapa_x_det_etapa_caduca_dispo($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                        self::Cambia_estatus_det_proc_pet_dev_inter_bov($datos[$i]['id_determinante']);
                    }
                    self::baja_etapas_anteriores_al_cambio_caduc_peticion($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                  $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = 'BOVEDASA'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                  $con = $conexion->ObtenerConexionBD();
                    $prepare = sqlsrv_query($con, $query);
                    if ($prepare) {
                        return 'El ticket se cambio a petición de devolución interna.';
                        $conexion->CerrarConexion($con);
                    } else {
                        return 'No se efectuo el movimiento de devolución interna.';
                        $conexion->CerrarConexion($con);
                    }
                }
            } elseif ($dia_de_semana == 4) {
                if ($diferencia >=96) {
                    for ($i=0; $i < count($datos) ; $i++) {
                        self::Crea_cambios_etapa_x_det_etapa_caduca_dispo($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                        self::Cambia_estatus_det_proc_pet_dev_inter_bov($datos[$i]['id_determinante']);
                    }
                    self::baja_etapas_anteriores_al_cambio_caduc_dispo($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                          $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = 'BOVEDASA'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                          $con = $conexion->ObtenerConexionBD();
                    $prepare = sqlsrv_query($con, $query);
                    if ($prepare) {
                        return 'El ticket se cambio a petición de devolución interna.';
                        $conexion->CerrarConexion($con);
                    } else {
                        return 'No se efectuo el movimiento de devolución interna.';
                        $conexion->CerrarConexion($con);
                    }
                }
            } elseif ($dia_de_semana == 5) {
                if ($diferencia >=120) {
                    for ($i=0; $i < count($datos) ; $i++) {
                        self::Crea_cambios_etapa_x_det_etapa_caduca_dispo($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                        self::Cambia_estatus_det_proc_pet_dev_inter_bov($datos[$i]['id_determinante']);
                    }
                    self::baja_etapas_anteriores_al_cambio_caduc_dispo($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                          $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = 'BOVEDASA'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                          $con = $conexion->ObtenerConexionBD();
                    $prepare = sqlsrv_query($con, $query);
                    if ($prepare) {
                        return 'El ticket se cambio a petición de devolución interna.';
                        $conexion->CerrarConexion($con);
                    } else {
                        return 'No se efectuo el movimiento de devolución interna.';
                        $conexion->CerrarConexion($con);
                    }
                }
            } elseif ($dia_de_semana == 6) {
                if ($diferencia >=144) {
                    for ($i=0; $i < count($datos) ; $i++) {
                        self::Crea_cambios_etapa_x_det_etapa_caduca_dispo($tiket, $datos[$i]['user_alta'], $datos[$i]['id_determinante']);
                        self::Cambia_estatus_det_proc_pet_dev_inter_bov($datos[$i]['id_determinante']);
                    }
                        self::baja_etapas_anteriores_al_cambio_caduc_dispo($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                          $query = "UPDATE Tikets SET id_proc = 12, fecha_cancel = GETDATE(), user_cancel = 'BOVEDASA'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                          $con = $conexion->ObtenerConexionBD();
                        $prepare = sqlsrv_query($con, $query);
                        if ($prepare) {
                            return 'El ticket se cambio a petición de devolución interna.';
                            $conexion->CerrarConexion($con);
                    } else {
                        return 'No se efectuo el movimiento de devolución interna.';
                        $conexion->CerrarConexion($con);
                    }
                }
            }
        } else {
            return '';
        }
    }

    public static function bus_tiket_busqueda_dev_par($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " select
        etapa.id_tiket
        from Etapa_poc etapa
        inner join Determinante det on det.id_determinante=etapa.id_determinante
        inner join Expediente expe on expe.id_expediente=det.id_expediente
        inner join Contribuyente contri on contri.id_contribuyente=expe.id_contribuyente
        where det.RDFDA='$RDFDA'
        and (id_proc_det=5 or id_proc_det=9)";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $tiket = $row['id_tiket'];
            return $tiket;
        }
    }
    public static function bus_tiket_busqueda_Proc_dev($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " select
        etapa.id_tiket
        from Etapa_poc etapa
        inner join Determinante det on det.id_determinante=etapa.id_determinante
        inner join Expediente expe on expe.id_expediente=det.id_expediente
        inner join Contribuyente contri on contri.id_contribuyente=expe.id_contribuyente
        where det.RDFDA='$RDFDA'
        and id_proc_det=8";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $tiket = $row['id_tiket'];
            return $tiket;
        }
    }
    public static function bus_tiket_proc_dev($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " select
        etapa.id_tiket
        from Etapa_poc etapa
        inner join Determinante det on det.id_determinante=etapa.id_determinante
        inner join Expediente expe on expe.id_expediente=det.id_expediente
        inner join Contribuyente contri on contri.id_contribuyente=expe.id_contribuyente
        where det.RDFDA='$RDFDA'
        and id_proc_det=8";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $tiket = $row['id_tiket'];
            return $tiket;
        }
    }
    public static function bus_tiket_busqueda_Cierre($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " select
        etapa.id_tiket
        from Etapa_poc etapa
        inner join Determinante det on det.id_determinante=etapa.id_determinante
        inner join Expediente expe on expe.id_expediente=det.id_expediente
        inner join Contribuyente contri on contri.id_contribuyente=expe.id_contribuyente
        where det.RDFDA='$RDFDA'
        and (id_proc_det=5
        or id_proc_det=3)";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $tiket = $row['id_tiket'];
            return $tiket;
        }
    }
    public static function bus_tiket_busqueda_Cierre_interno($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " SELECT
        etapa.id_tiket
        from Etapa_poc etapa
        inner join Determinante det on det.id_determinante=etapa.id_determinante
        inner join Expediente expe on expe.id_expediente=det.id_expediente
        inner join Contribuyente contri on contri.id_contribuyente=expe.id_contribuyente
        where det.RDFDA='$RDFDA'
        and (id_proc_det=8)";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $tiket = $row['id_tiket'];
            return $tiket;
        }
    }
    public static function bus_tiket_busqueda_filtro_interno($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = "SELECT Asunto FROM Tikets where id_tiket = $tiket ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $Asunto = $row['Asunto'];
            return $Asunto;
        }
    }
    public static function bus_tiket_busqueda_prestamo_interno($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " select
        etapa.id_tiket
        from Etapa_poc etapa
        inner join Determinante det on det.id_determinante=etapa.id_determinante
        inner join Expediente expe on expe.id_expediente=det.id_expediente
        inner join Contribuyente contri on contri.id_contribuyente=expe.id_contribuyente
        where det.RDFDA='$RDFDA'
        and (id_proc_det=8)";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $tiket = $row['id_tiket'];
            return $tiket;
        }
    }
    public static function bus_tiket_busqueda_Parcial($RDFDA)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = "SELECT 
		etapa.id_tiket,
		etapa.id_determinante,
		det.id_proc,
		etapa.fecha_mod
		FROM Determinante det
		INNER JOIN Etapa_poc etapa ON etapa.id_determinante = det.id_determinante
		INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
        INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
		WHERE det.RDFDA = '$RDFDA' AND etapa.id_proc_det=5 AND etapa.estatus = 'A' ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $tiket = $row['id_tiket'];
            return $tiket;
        }
    }
    public static function total_tiket($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " SELECT COUNT(*)total from Etapa_poc where id_tiket=$tiket AND estatus = 'A'";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $tiket = $row['total'];
            return $tiket;
        }
    }
    public static function total_tiket_consulta_det_devueltas($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " 	SELECT COUNT(*)total from Etapa_poc where id_tiket= $tiket AND id_proc_det = 4 and estatus = 'A'";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $tiket = $row['total'];
            return $tiket;
        }
    }
    public static function busca_perfil_user_pet($user)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        // $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = "SELECT id_perfil FROM Empleado where rfc_corto = '$user'";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $perfil = $row['id_perfil'];
            return $perfil;
        }
    }
    public static function total_expedientes_diarios_por_user($user)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        // $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " SELECT COUNT(*) Total FROM Etapa_poc WHERE user_alta = '$user' AND DAY(fecha_alta)= DAY(GETDATE())";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $total = $row['Total'];
            return $total;
        }
    }
    public static function busca_user_peticion($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        // $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " SELECT user_mov FROM Tikets where id_tiket = $tiket";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            $row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC);
            $user = $row['user_mov'];
            return $user;
        }
    }
    public static function Contador_determinantes_por_tiket($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = "SELECT COUNT(*) AS devueltos,
        (select COUNT(*)total from Etapa_poc where id_tiket = $tiket AND estatus = 'A' ) as total_det   FROM Etapa_poc WHERE id_proc_det = 4 and id_tiket = $tiket AND estatus = 'A'";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas = array('devueltos' => $row["devueltos"], 'total_det' => $row["total_det"]);
            }
            if (isset($filas)) {
                return $filas;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }


    public static function bus_prestamos_tikets($numero)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        $depto = $_SESSION["ses_id_depto"];
        $sub_admin = $_SESSION["ses_id_sub_admin"];
        $admin = $_SESSION["ses_id_admin"];
        $id_perfil = $_SESSION['ses_id_perfil'];
        if (isset($numero)) {
            switch ($id_perfil) {
                case 1:
                    $condiciones_prest = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and (id_proc=8) ";
                    break;
                case 8:
                    $condiciones_prest = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and (id_proc=8) ";
                    break;
                case 2:
                    $condiciones_prest = "WHERE (id_tiket like '%$numero%' and user_mov = '$user') and (id_proc=8)";
                    break;
                case 9:
                    $condiciones_prest = "WHERE (id_tiket like '%$numero%' and user_mov = '$user') and (id_proc=8)";
                    break;
                case 4:
                    $condiciones_prest = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and  Emp.id_depto = $depto and ( id_proc=8)";
                    break;
                case 10:
                    $condiciones_prest = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and  Emp.id_depto = $depto and ( id_proc=8)";
                    break;
                case 5:
                    $condiciones_prest = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and Emp.id_sub_admin = $sub_admin and ( id_proc=8)";
                    break;
                    case 11:
                        $condiciones_prest = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and Emp.id_sub_admin = $sub_admin and ( id_proc=8)";
                        break;
                        case 12:
                            $condiciones_prest = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and Emp.id_sub_admin = $sub_admin and ( id_proc=8)";
                            break;
                case 7:
                    $condiciones_prest = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and Emp.id_admin = $admin and ( id_proc=8)";
                    break;
            }
        } else {
            switch ($id_perfil) {
                case 1:
                    $condiciones_prest = "WHERE id_proc=8 ";
                    break;
                case 8:
                    $condiciones_prest = "WHERE id_proc=8";
                    break;
                case 2:
                    $condiciones_prest = " WHERE user_mov='$user' AND id_proc=8";
                    break;
                case 9:
                    $condiciones_prest = " WHERE user_mov='$user' AND id_proc=8";
                    break;
                case 4:
                    $condiciones_prest = "WHERE Emp.id_depto = $depto and id_proc=8";
                    break;
                case 10:
                    $condiciones_prest = "WHERE Emp.id_depto = $depto and id_proc=8";
                    break;
                case 5:
                    $condiciones_prest = "WHERE Emp.id_sub_admin = $sub_admin and id_proc=8";
                    break;
                    case 11:
                        $condiciones_prest = "WHERE Emp.id_sub_admin = $sub_admin and id_proc=8";
                        break;
                        case 12:
                            $condiciones_prest = "WHERE Emp.id_sub_admin = $sub_admin and id_proc=8";
                            break;
                case 7:
                    $condiciones_prest = "WHERE Emp.id_admin = $admin and id_proc=8";
                    break;
            }
        }

        $query = "SELECT TOP (100)
                Tik.id_proc,
                DATEDIFF(DAY,fecha_prest,GETDATE()) as diferencia,
                Tik.user_mov,
                Emp.nombre_empleado,
                Tik.fecha_prest,
                Tik.id_tiket
                FROM Tikets Tik 
                INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
                $condiciones_prest ORDER BY id_proc DESC";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function Datos_de_imprecion2($Tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $query = "SELECT TOP 1 
                    contri.rfc,
                    tik.user_mov,
                    Emp.correo,
                    Emp.nombre_empleado,
                    det.num_determinante,
                    tik.fecha_valida,
                    etapa.id_proc_det,
                    det.RDFDA,
                    etapa.id_tiket,
                    Dep.nombre_depto,
                    Sub.nombre_sub_admin,
                    Adm.nombre_admin
                    FROM Etapa_poc etapa
                    INNER JOIN Determinante det ON det.id_determinante=etapa.id_determinante
                    INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
                    INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
                    INNER JOIN Tikets tik ON etapa.id_tiket = tik.id_tiket
                    INNER JOIN Empleado Emp ON TIk.user_mov = Emp.rfc_corto
                    INNER JOIN Departamento Dep ON Emp.id_depto = Dep.id_depto
                    INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
                    INNER JOIN Administracion Adm ON Emp.id_admin = Adm.id_admin
                    WHERE etapa.id_tiket=$Tiket AND (etapa.id_proc_det=2 or etapa.id_proc_det=11 or etapa.id_proc_det=7) ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas = $row;
            }
            if (isset($filas)) {
                return $filas;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function Datos_de_imprecion2_integracion($Tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $query = "SELECT top 1
        inte.id_tiket_integra,
        inte.user_mov,
        Emp.correo,
        Emp.nombre_empleado,
        det.num_determinante,
        tik_in.fecha_alta,
        Dep.nombre_depto,
        Sub.nombre_sub_admin,
        Adm.nombre_admin
        FROM Integraciones inte
        INNER JOIN Situaciones sit on inte.id_situaciones = sit.id_situaciones
        INNER JOIN Determinante det ON det.id_determinante = inte.id_det
        INNER JOIN Tikets_integracion tik_in ON tik_in.id_tiket_integra = inte.id_tiket_integra
        INNER JOIN Expediente expe ON det.id_expediente = expe.id_expediente
        INNER JOIN Contribuyente cont ON cont.id_contribuyente = expe.id_contribuyente 
        INNER JOIN Empleado emp ON emp.rfc_corto = inte.user_mov
        INNER JOIN Departamento Dep ON Emp.id_depto = Dep.id_depto
        INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
        INNER JOIN Administracion Adm ON Emp.id_admin = Adm.id_admin
        WHERE  inte.id_tiket_integra =$Tiket";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas = $row;
            }
            if (isset($filas)) {
                return $filas;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function Datos_de_imprecion($Tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $query = "SELECT 
        contri.rfc,
        tik.user_mov,
        Emp.correo,
		contri.razon_social,
        Emp.nombre_empleado,
        det.num_determinante,
        etapa.fecha_valida,
        Pro.nombre_proc_det,
        det.id_determinante,
        det.RDFDA,
        det.fojas AS FOJ,
        det.estatus_cred AS ESTATUS,
        etapa.id_tiket,
        etapa.id_etapa,
		Dep.nombre_depto,
		Sub.nombre_sub_admin,
		Adm.nombre_admin
        FROM Etapa_poc etapa
        INNER JOIN Determinante det ON det.id_determinante=etapa.id_determinante
        INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
        INNER JOIN Contribuyente contri ON contri.id_contribuyente=expe.id_contribuyente
        INNER JOIN Tikets tik ON etapa.id_tiket = tik.id_tiket
        INNER JOIN Empleado Emp ON TIk.user_mov = Emp.rfc_corto
		INNER JOIN Departamento Dep ON Emp.id_depto = Dep.id_depto
		INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
		INNER JOIN Administracion Adm ON Emp.id_admin = Adm.id_admin
		INNER JOIN Procesos Pro ON etapa.id_proc_det = Pro.id_proc_det
        WHERE etapa.id_tiket=$Tiket AND (etapa.id_proc_det=2 or etapa.id_proc_det=11 or etapa.id_proc_det=7 or etapa.id_proc_det=8 or etapa.id_proc_det=5 or etapa.id_proc_det=9 or etapa.id_proc_det=4) AND etapa.estatus = 'A'";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $row;
            }
            if (isset($filas)) {
                return $filas;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
     public static function Datos_de_imprecion_integracion($Tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        $query = "   SELECT 
        cont.rfc,
        cont.razon_social,
        det.num_determinante,
        sit.Objeto,
        sit.Situacion,
        sit.[etapa ] as Etapa,
        inte.Observaciones,
        inte.fecha_mov,
        inte.fecha_of,
        inte.id_tiket,
        inte.fojas,
        inte.id_Integracion,
		 case when (det.estatus_cred = 'A') 
         then 'Activo' else 'Baja' end as estatus,
        case when ( inte.tipo_doc = 1) then 'Original' 
        when ( inte.tipo_doc = 2) then 'Copia certificada' 
        when ( inte.tipo_doc = 3) then 'Copia foto-estatica' 
        when ( inte.tipo_doc = 4) then 'Correo' 
        when ( inte.tipo_doc = 5) then 'Captura de pantalla' 
        end as tipo_doc_res,
        emp.nombre_empleado
        FROM Integraciones inte
        INNER JOIN Situaciones sit on inte.id_situaciones = sit.id_situaciones
        INNER JOIN Determinante det ON det.id_determinante = inte.id_det
        INNER JOIN Expediente expe ON det.id_expediente = expe.id_expediente
        INNER JOIN Contribuyente cont ON cont.id_contribuyente = expe.id_contribuyente 
        INNER JOIN Empleado emp ON emp.rfc_corto = inte.user_mov
        WHERE  inte.id_tiket_integra =$Tiket order BY inte.fecha_mov desc";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = $row;
            }
            if (isset($filas)) {
                return $filas;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function bus_peticion_tikets_Devolucion($numero)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $user = $_SESSION["ses_rfc_corto"];
        $depto = $_SESSION["ses_id_depto"];
        $sub_admin = $_SESSION["ses_id_sub_admin"];
        $admin = $_SESSION["ses_id_admin"];
        $id_perfil = $_SESSION['ses_id_perfil'];
        if (isset($numero)) {
            switch ($id_perfil) {
                case 1:
                    $condiciones_dev = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and (id_proc=4 OR id_proc=9  OR id_proc= 5) ";
                    break;
                case 8:
                    $condiciones_dev = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and (id_proc=4 OR id_proc=9  OR id_proc= 5) ";
                    break;
                case 2:
                    $condiciones_dev = "WHERE (id_tiket like '%$numero%' and user_mov = '$user') and (id_proc=4 OR id_proc=9  OR id_proc= 5)";
                    break;
                    case 9:
                        $condiciones_dev = "WHERE (id_tiket like '%$numero%' and user_mov = '$user') and (id_proc=4 OR id_proc=9  OR id_proc= 5)";
                        break;
                case 4:
                    $condiciones_dev = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and  Emp.id_depto = $depto and ( id_proc=4 OR id_proc=9  OR id_proc= 5)";
                    break;
                    case 10:
                        $condiciones_dev = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and  Emp.id_depto = $depto and ( id_proc=4 OR id_proc=9  OR id_proc= 5)";
                        break;
                case 5:
                    $condiciones_dev = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and Emp.id_sub_admin = $sub_admin and (id_proc=4 OR id_proc=9  OR id_proc= 5)";
                    break;
                    case 11:
                        $condiciones_dev = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and Emp.id_sub_admin = $sub_admin and (id_proc=4 OR id_proc=9  OR id_proc= 5)";
                        break;
                        case 12:
                            $condiciones_dev = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and Emp.id_sub_admin = $sub_admin and (id_proc=4 OR id_proc=9  OR id_proc= 5)";
                            break;
                case 7:
                    $condiciones_dev = "WHERE (id_tiket like '%$numero%' OR nombre_empleado like '%$numero%') and Emp.id_admin = $admin and ( id_proc=4 OR id_proc=9  OR id_proc= 5)";
                    break;
            }
        } else {
            switch ($id_perfil) {
                case 1:
                    $condiciones_dev = "WHERE id_proc=4 OR id_proc=9 OR id_proc= 5 ";
                    break;
                case 8:
                    $condiciones_dev = "WHERE id_proc=4 OR id_proc=9  OR id_proc= 5";
                    break;
                case 2:
                    $condiciones_dev = " WHERE user_mov='$user' AND (id_proc=4 OR id_proc=9  OR id_proc= 5)";
                    break;
                    case 9:
                        $condiciones_dev = " WHERE user_mov='$user' AND (id_proc=4 OR id_proc=9  OR id_proc= 5)";
                        break;
                case 4:
                    $condiciones_dev = "WHERE Emp.id_depto = $depto and ( id_proc=4 OR id_proc=9  OR id_proc= 5)";
                    break;
                    case 10:
                        $condiciones_dev = "WHERE Emp.id_depto = $depto and ( id_proc=4 OR id_proc=9  OR id_proc= 5)";
                        break;
                case 5:
                    $condiciones_dev = "WHERE Emp.id_sub_admin = $sub_admin and ( id_proc=4 OR id_proc=9  OR id_proc= 5)";
                    break;
                    case 11:
                        $condiciones_dev = "WHERE Emp.id_sub_admin = $sub_admin and ( id_proc=4 OR id_proc=9  OR id_proc= 5)";
                        break;
                        case 12:
                            $condiciones_dev = "WHERE Emp.id_sub_admin = $sub_admin and ( id_proc=4 OR id_proc=9  OR id_proc= 5)";
                            break;
                case 7:
                    $condiciones_dev = "WHERE Emp.id_admin = $admin and ( id_proc=4 OR id_proc=9  OR id_proc= 5)";
                    break;
            }
        }
        //SE CREA UN QUERY
        $query = " SELECT TOP (100)
        Tik.id_proc,
        Tik.user_mov,
        Emp.nombre_empleado,
        Tik.fecha_pet_dev,
        Tik.fecha_recive_comp,
        Tik.fecha_recive_par,
        tIK.id_tiket
        FROM Tikets Tik 
        INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
         $condiciones_dev ORDER BY id_proc DESC,id_tiket DESC ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }

    public static function busqueda_Tabla_Expedientes()
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_admin = $_SESSION["ses_id_admin"];
        $id_depto = $_SESSION["ses_id_depto"];
        $id_perfil = $_SESSION["ses_id_perfil"];
        $user = $_SESSION["ses_id_usuario"];
        switch ($id_perfil) {
            case 1:
                $condicion = "";
                break;
                case 9:
                    $condicion = "";
                    break;
                    case 10:
                        $condicion = "";
                        break;
                        case 11:
                            $condicion = "";
                            break;
                        case 12:
                            $condicion = "";
                            break;
                case 2:
                   
                    $condicion =" where 
                    emp.id_empleado  = $user 
                    OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user))
                    OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user ) AND id_admin =  $id_admin )
                    OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado = $user))) ";
                    
                break;
                case 4:
                   
                    $condicion =" where 
                    emp.id_empleado  = $user 
                    OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user))
                    OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user ) AND id_admin =  $id_admin )
                    OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado = $user))) ";
                    
                   
                break;
                case 8:
                $condicion = "";
                break;
            case 7:
                $condicion = "";
                break;
            default:
            $condicion =" where 
            emp.id_empleado  = $user 
            OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user))
            OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user ) AND id_admin =  $id_admin )
            OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado = $user))) ";

                break;
        }
        //$busqueda = Busquedas_Filtradas_devolucion();
        //SE CREA UN QUERY
        $query = "	 SELECT 
        bus.seq,
        bus.id_proc,
        bus.id_empleado,
        bus.nombre_empleado,
        bus.nombre_depto,
        bus.nombre_sub_admin,
        bus.nombre_admin,
        bus.RDFDA,
        bus.rfc,
        bus.razon_social,
        bus.num_determinante,
        bus.fecha_determinante,
        bus.autoridad
        FROM (SELECT
		ROW_NUMBER() OVER(ORDER BY (fecha_determinante) Asc) AS seq,
        emp.id_empleado,
        emp.nombre_empleado,
        Dep.nombre_depto,
        Sub.nombre_sub_admin,
        Adm.nombre_admin,
        id_proc,
        id_determinante,
        RDFDA,
        rfc,
        razon_social,
        num_determinante,
        fecha_determinante,
        (SELECT nombre_autoridad FROM Autoridad where id_autoridad=det.id_autoridad) as autoridad
        from [Determinante] det
        INNER JOIN Empleado emp ON emp.id_empleado=det.id_empleado
        INNER JOIN Departamento Dep ON emp.id_depto=Dep.id_depto
        INNER JOIN SubAdmin Sub ON emp.id_sub_admin=Sub.id_sub_admin
        INNER JOIN Administracion Adm ON emp.id_admin=Adm.id_admin
        INNER JOIN Expediente expe ON expe.id_expediente=det.id_expediente
        INNER JOIN Contribuyente c ON c.id_contribuyente=expe.id_contribuyente
        $condicion ) bus ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function universo_datos_expedientes()
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_admin = $_SESSION["ses_id_admin"];
        $id_depto = $_SESSION["ses_id_depto"];
        $id_perfil = $_SESSION["ses_id_perfil"];
        $user = $_SESSION["ses_id_usuario"];
        $id_admin = $_SESSION["ses_id_admin"];
        $id_perfil = $_SESSION["ses_id_perfil"];
        $id_depto = $_SESSION["ses_id_depto"];
        $user = $_SESSION["ses_id_usuario"];
        switch ($id_perfil) {
            case 1:
                $condicion_x_perfil = "";
                break;
            case 8:
                $condicion_x_perfil = "";
                break;
            case 7:
                $condicion_x_perfil = "";
                break;
            case 2:
            $condicion_x_perfil ="   where 
            emp.id_empleado  = $user 
            OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user ))
            OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user  ) AND id_admin =  $id_admin )
            OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT top (1) id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT  jefe_directo FROM Empleado WHERE id_empleado = $user))) ";
            break;
            case 5:
                $condicion_x_perfil ="   where 
                emp.id_empleado  = $user 
                OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user ))
                OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user  ) AND id_admin =  $id_admin )
                OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT top (1) id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT  jefe_directo FROM Empleado WHERE id_empleado = $user))) ";
            break;
            case 4:
                $condicion_x_perfil ="where 
                emp.id_empleado  = $user 
                OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user ))
                OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user  ) AND id_admin =  $id_admin )
                OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT top (1) id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT  jefe_directo FROM Empleado WHERE id_empleado = $user))) ";
            break;
            case 9:
            $condicion_x_perfil = "";
            break;
            case 10:
            $condicion_x_perfil = "";
            break;
            case 11:
            $condicion_x_perfil = "";
            break;
            case 12:
            $condicion_x_perfil = "";
            break;
                         
        }
        switch ($_GET) {
            case isset($_GET['pagina']):
                $solicitud_busq = "";
            break;
            case isset($_GET['RFC']):
                $rfc = $_COOKIE["rfc"];
                $solicitud_busq = "where bus.rfc='$rfc'";
            break;
            case isset($_GET['num_det']):
                $num_det = $_COOKIE["num_det"];
                $solicitud_busq = "where bus.num_determinante = '$num_det'";
            break;
            case isset($_GET['razon']):
                $razon_social = $_COOKIE["nombre_razon"];
                $solicitud_busq = "where bus.razon_social Like '%$razon_social%'";
            break;
            case isset($_GET['aut']):
                $det = $_COOKIE["Deter"];
                $solicitud_busq = "where [Número Determinante] = '$det'";
            break;
            case isset($_GET['Cred']):
                $prioridad = $_COOKIE["estatus_cred"];
                 if($prioridad == 1){
                 $solicitud_busq = " where bus.estatus_cred = 'A' ";
                }
                if($prioridad == 2)
                $solicitud_busq = " where bus.estatus_cred = 'B' ";
            break;
            case isset($_GET['Usuario']):
                $id_emp = $_COOKIE["nom_emp"];
                $solicitud_busq = "where bus.id_empleado = $id_emp";
            break;
            case isset($_GET['estructura']):
                $sub = $_COOKIE["sub"];
                $dep = $_COOKIE["dep"];
                $solicitud_busq = "where (bus.id_depto = $dep and id_sub_admin = $sub)";
            break;
          
          }

        $query ="SELECT COUNT(*) AS total
        FROM (SELECT
		ROW_NUMBER() OVER(ORDER BY (fecha_determinante) Asc) AS seq,
        emp.id_empleado,
        emp.nombre_empleado,
        Dep.nombre_depto,
        Sub.nombre_sub_admin,
        Adm.nombre_admin,
        id_proc,
        id_determinante,
        RDFDA,
        Dep.id_depto,
		Sub.id_sub_admin,
        rfc,
        razon_social,
        estatus_cred,
        num_determinante,
        fecha_determinante,
        (SELECT nombre_autoridad FROM Autoridad where id_autoridad=det.id_autoridad) as autoridad
        from [Determinante] det
        LEFT JOIN Empleado emp ON emp.id_empleado=det.id_empleado
        INNER JOIN Departamento Dep ON emp.id_depto=Dep.id_depto
        INNER JOIN SubAdmin Sub ON emp.id_sub_admin=Sub.id_sub_admin
        INNER JOIN Administracion Adm ON emp.id_admin=Adm.id_admin
        LEFT JOIN Expediente expe ON expe.id_expediente=det.id_expediente
        LEFT JOIN Contribuyente c ON c.id_contribuyente=expe.id_contribuyente $condicion_x_perfil ) bus
        $solicitud_busq ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function busqueda_Tabla_Expedientes_VISTA($numero)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_admin = $_SESSION["ses_id_admin"];
        $id_perfil = $_SESSION["ses_id_perfil"];
        $id_depto = $_SESSION["ses_id_depto"];
        $user = $_SESSION["ses_id_usuario"];
        switch ($id_perfil) {
            case 1:
                $condicion_x_perfil = "";
         
                break;
            case 8:
                $condicion_x_perfil = "";
          
                break;
            case 7:
                $condicion_x_perfil = "";
  
                break;
            case 2:
           
                $condicion_x_perfil ="   where 
                emp.id_empleado  = $user 
                OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user ))
                OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user  ) AND id_admin =  $id_admin )
                OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT top (1) id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT  jefe_directo FROM Empleado WHERE id_empleado = $user))) ";
 
        
            break;
            case 5:
                $condicion_x_perfil ="   where 
                emp.id_empleado  = $user 
                OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user ))
                OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user  ) AND id_admin =  $id_admin )
                OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT top (1) id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT  jefe_directo FROM Empleado WHERE id_empleado = $user))) ";
           

            
            break;
            case 4:
                $condicion_x_perfil ="where 
                emp.id_empleado  = $user 
                OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo  IN (select jefe_directo from Empleado where id_empleado =  $user ))
                OR emp.id_empleado IN (SELECT top (1) id_empleado FROM Empleado WHERE jefe_directo IN (SELECT jefe_directo FROM Empleado WHERE id_empleado =$user  ) AND id_admin =  $id_admin )
                OR emp.id_empleado IN (SELECT id_empleado FROM Empleado WHERE jefe_directo IN (SELECT top (1) id_empleado FROM Empleado WHERE  id_admin =  $id_admin AND jefe_directo IN (SELECT  jefe_directo FROM Empleado WHERE id_empleado = $user))) ";
           
   
            
            break;
            case 9:
            $condicion_x_perfil = "";
   
            break;
            case 10:
            $condicion_x_perfil = "";

            break;
            case 11:
            $condicion_x_perfil = "";

            break;
            case 12:
            $condicion_x_perfil = "";

            break;
                         
        }
        switch ($_GET) {
            case isset($_GET['pagina']):
                $solicitud_busq = "";
            break;
            case isset($_GET['RFC']):
                $rfc = $_COOKIE["rfc"];
                $solicitud_busq = "and bus.rfc='$rfc'";
            break;
            case isset($_GET['num_det']):
                $num_det = $_COOKIE["num_det"];
                $solicitud_busq = "and bus.num_determinante = '$num_det'";
            break;
            case isset($_GET['razon']):
                $razon_social = $_COOKIE["nombre_razon"];
                $solicitud_busq = "and bus.razon_social Like '%$razon_social%'";
            break;
            case isset($_GET['aut']):
                $det = $_COOKIE["Deter"];
                $solicitud_busq = "and [Número Determinante] = '$det'";
            break;
            case isset($_GET['Cred']):
                $prioridad = $_COOKIE["estatus_cred"];
                 if($prioridad == 1){
                 $solicitud_busq = " and  bus.estatus_cred = 'A' ";
                }
                if($prioridad == 2)
                $solicitud_busq = " and bus.estatus_cred = 'B' ";
            break;
            case isset($_GET['Usuario']):
                $id_emp = $_COOKIE["nom_emp"];
                $solicitud_busq = "and bus.id_empleado =$id_emp";
            break;
            case isset($_GET['estructura']):
                $sub = $_COOKIE["sub"];
                $dep = $_COOKIE["dep"];
                $solicitud_busq = "and (bus.id_depto = $dep and bus.id_sub_admin = $sub)";
            break;
          
          }


        //$busqueda = Busquedas_Filtradas_devolucion();
        //SE CREA UN QUERY
        $query = "SELECT TOP (100)
        bus.seq,
        bus.id_proc,
        bus.id_empleado,
        bus.nombre_empleado,
        bus.nombre_depto,
        bus.nombre_sub_admin,
        bus.nombre_admin,
        bus.RDFDA,
        bus.rfc,
        bus.razon_social,
        bus.num_determinante,
        bus.fecha_determinante,
        bus.autoridad,
        bus.estatus_cred,
		bus.estatus,
        bus.id_depto,
		bus.id_sub_admin
        FROM (SELECT
		ROW_NUMBER() OVER(ORDER BY (fecha_determinante) DESC) AS seq,
        emp.id_empleado,
        emp.nombre_empleado,
        Dep.nombre_depto,
        Dep.id_depto,
		Sub.id_sub_admin,
        Sub.nombre_sub_admin,
        Adm.nombre_admin,
        id_proc,
        id_determinante,
        RDFDA,
        rfc,
        razon_social,
        num_determinante,
        fecha_determinante,
        estatus_cred,
		det.estatus,
        (SELECT nombre_autoridad FROM Autoridad where id_autoridad=det.id_autoridad) as autoridad
        from [Determinante] det
        INNER JOIN Empleado emp ON emp.id_empleado=det.id_empleado
        INNER JOIN Departamento Dep ON emp.id_depto=Dep.id_depto
        INNER JOIN SubAdmin Sub ON emp.id_sub_admin=Sub.id_sub_admin
        INNER JOIN Administracion Adm ON emp.id_admin=Adm.id_admin
        LEFT JOIN Expediente expe ON expe.id_expediente=det.id_expediente
        LEFT JOIN Contribuyente c ON c.id_contribuyente=expe.id_contribuyente
        $condicion_x_perfil ) bus
        WHERE bus.seq >= $numero $solicitud_busq";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
   
    public static function bus_tiket_busq($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_perfil = $_SESSION['ses_id_perfil'];
        $user = $_SESSION["ses_rfc_corto"];
        //$busqueda = Busquedas_Filtradas_devolucion();
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " SELECT 
        Tik.id_proc,
		Etapa.user_alta,
		Etapa.fecha_alta,
		Etapa.id_determinante,
		Etapa.user_valida,
		Etapa.fecha_valida,
		Etapa.id_tiket,
        Etapa.id_proc_det,
		Etapa.estatus
        FROM Tikets Tik
        INNER JOIN Etapa_poc Etapa ON Etapa.id_tiket = Tik.id_tiket
        WHERE Tik.id_tiket = $tiket AND (Tik.id_proc = 2 AND Etapa.id_proc_det = 2 AND Etapa.estatus = 'A' ) ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function bus_tiket_dispo($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_perfil = $_SESSION['ses_id_perfil'];
        $user = $_SESSION["ses_rfc_corto"];
        //$busqueda = Busquedas_Filtradas_devolucion();
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " SELECT 
        Tik.id_proc,
		Etapa.user_alta,
		Etapa.fecha_alta,
		Etapa.id_determinante,
		Etapa.user_valida,
		Etapa.fecha_valida,
		Etapa.id_tiket,
        Etapa.id_proc_det,
		Etapa.estatus
        FROM Tikets Tik
        INNER JOIN Etapa_poc Etapa ON Etapa.id_tiket = Tik.id_tiket
        WHERE Tik.id_tiket = $tiket AND (Tik.id_proc = 2 OR Tik.id_proc = 7 ) AND( Etapa.id_proc_det = 2 OR Etapa.id_proc_det = 7) AND Etapa.estatus = 'A' ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function bus_tiket_cancel($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_perfil = $_SESSION['ses_id_perfil'];
        $user = $_SESSION["ses_rfc_corto"];
        //$busqueda = Busquedas_Filtradas_devolucion();
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " SELECT 
        Tik.id_proc,
		Etapa.user_alta,
		Etapa.fecha_alta,
		Etapa.id_determinante,
		Etapa.user_valida,
		Etapa.fecha_valida,
		Etapa.id_tiket,
        Etapa.id_proc_det,
		Etapa.estatus
        FROM Tikets Tik
        INNER JOIN Etapa_poc Etapa ON Etapa.id_tiket = Tik.id_tiket
        WHERE Tik.id_tiket = $tiket AND (Tik.id_proc = 2 OR Tik.id_proc = 7 OR Tik.id_proc = 11 ) AND( Etapa.id_proc_det = 2 OR Etapa.id_proc_det = 7 OR Etapa.id_proc_det = 11) AND Etapa.estatus = 'A' ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function bus_tiket_code_bar($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_perfil = $_SESSION['ses_id_perfil'];
        $user = $_SESSION["ses_rfc_corto"];
        //$busqueda = Busquedas_Filtradas_devolucion();
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " SELECT 
        Tik.id_proc,
		Etapa.user_alta,
		Etapa.fecha_alta,
		Etapa.id_determinante,
		Etapa.user_valida,
		Etapa.fecha_valida,
		Etapa.id_tiket,
        Etapa.id_proc_det,
		Etapa.estatus,
        Tik.Asunto
        FROM Tikets Tik
        INNER JOIN Etapa_poc Etapa ON Etapa.id_tiket = Tik.id_tiket
        WHERE Tik.id_tiket = $tiket AND 
        (Tik.id_proc = 2 
        OR Tik.id_proc = 7 
        OR Tik.id_proc = 11
        OR Tik.id_proc = 8
        OR Tik.id_proc = 5
        OR Tik.id_proc = 9 ) 
        AND( Etapa.id_proc_det = 2 
        OR Etapa.id_proc_det = 7 
        OR Etapa.id_proc_det = 11
        OR Etapa.id_proc_det = 8
        OR Etapa.id_proc_det = 5
        OR Etapa.id_proc_det = 9) AND Etapa.estatus = 'A' ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function bus_tiket_prest_pet_dev($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_perfil = $_SESSION['ses_id_perfil'];
        $user = $_SESSION["ses_rfc_corto"];
        //$busqueda = Busquedas_Filtradas_devolucion();
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " SELECT 
        Tik.id_proc,
		Etapa.user_alta,
		Etapa.fecha_alta,
		Etapa.id_determinante,
		Etapa.user_valida,
		Etapa.fecha_valida,
		Etapa.id_tiket,
        Etapa.id_proc_det,
		Etapa.estatus
        FROM Tikets Tik
        INNER JOIN Etapa_poc Etapa ON Etapa.id_tiket = Tik.id_tiket
        WHERE Tik.id_tiket = $tiket AND (Tik.id_proc = 8) AND( Etapa.id_proc_det = 8) AND Etapa.estatus = 'A' ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function bus_tiket_prest_pet_dev_INT($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_perfil = $_SESSION['ses_id_perfil'];
        $user = $_SESSION["ses_rfc_corto"];
        //$busqueda = Busquedas_Filtradas_devolucion();
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = "   SELECT 
        Tik.id_proc,
		Etapa.user_alta,
		Etapa.fecha_alta,
		Etapa.id_determinante,
		Etapa.user_valida,
		Etapa.fecha_valida,
		Etapa.id_tiket,
        Etapa.id_proc_det,
		Etapa.estatus
        FROM Tikets Tik
        INNER JOIN Etapa_poc Etapa ON Etapa.id_tiket = Tik.id_tiket
        WHERE Tik.id_tiket = $tiket AND (Tik.id_proc = 8 AND Tik.Asunto = 'Consulta en Boveda' ) AND( Etapa.id_proc_det = 8) AND Etapa.estatus = 'A' ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function bus_tiket_caduc_dispo($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_perfil = $_SESSION['ses_id_perfil'];
        $user = $_SESSION["ses_rfc_corto"];
        //$busqueda = Busquedas_Filtradas_devolucion();
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = "   SELECT 
        Tik.id_proc,
		Etapa.user_alta,
		Etapa.fecha_alta,
		Etapa.id_determinante,
		Etapa.user_valida,
		Etapa.fecha_valida,
		Etapa.id_tiket,
        Etapa.id_proc_det,
		Etapa.estatus
        FROM Tikets Tik
        INNER JOIN Etapa_poc Etapa ON Etapa.id_tiket = Tik.id_tiket
        WHERE Tik.id_tiket = $tiket AND (Tik.id_proc = 11 ) AND( Etapa.id_proc_det = 11) AND Etapa.estatus = 'A' ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function bus_tiket_caduc_peticion($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_perfil = $_SESSION['ses_id_perfil'];
        $user = $_SESSION["ses_rfc_corto"];
        //$busqueda = Busquedas_Filtradas_devolucion();
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = "   SELECT 
        Tik.id_proc,
		Etapa.user_alta,
		Etapa.fecha_alta,
		Etapa.id_determinante,
		Etapa.user_valida,
		Etapa.fecha_valida,
		Etapa.id_tiket,
        Etapa.id_proc_det,
		Etapa.estatus
        FROM Tikets Tik
        INNER JOIN Etapa_poc Etapa ON Etapa.id_tiket = Tik.id_tiket
        WHERE Tik.id_tiket = $tiket AND (Tik.id_proc = 2 ) AND( Etapa.id_proc_det = 2) AND Etapa.estatus = 'A' ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function bus_tiket_prest_pet_dev_par_com($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_perfil = $_SESSION['ses_id_perfil'];
        $user = $_SESSION["ses_rfc_corto"];
        //$busqueda = Busquedas_Filtradas_devolucion();
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " SELECT 
        Tik.id_proc,
		Etapa.user_alta,
		Etapa.fecha_alta,
		Etapa.id_determinante,
		Etapa.user_valida,
		Etapa.fecha_valida,
		Etapa.id_tiket,
        Etapa.id_proc_det,
		Etapa.estatus
        FROM Tikets Tik
        INNER JOIN Etapa_poc Etapa ON Etapa.id_tiket = Tik.id_tiket
        WHERE Tik.id_tiket = $tiket AND (Tik.id_proc = 5 OR Tik.id_proc = 9    ) AND( Etapa.id_proc_det = 5) AND Etapa.estatus = 'A' ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function Busqueda_tik_codebar($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_perfil = $_SESSION['ses_id_perfil'];
        $user = $_SESSION["ses_rfc_corto"];
        //$busqueda = Busquedas_Filtradas_devolucion();
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " SELECT 
        Tik.id_proc,
		Etapa.user_alta,
		Etapa.fecha_alta,
		Etapa.id_determinante,
		Etapa.user_valida,
		Etapa.fecha_valida,
		Etapa.id_tiket,
        Etapa.id_proc_det,
		Etapa.estatus
        FROM Tikets Tik
        INNER JOIN Etapa_poc Etapa ON Etapa.id_tiket = Tik.id_tiket
        WHERE Tik.id_tiket = $tiket AND (Tik.id_proc = 2 OR Tik.id_proc = 7 or  Tik.id_proc = 11 or  Tik.id_proc = 8 or  Tik.id_proc = 5 or  Tik.id_proc = 9   ) AND( Etapa.id_proc_det = 7 or Etapa.id_proc_det = 2 or Etapa.id_proc_det = 11 or Etapa.id_proc_det = 8 or Etapa.id_proc_det = 5) AND Etapa.estatus = 'A' ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function bus_tiket_prest($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        include_once 'sesion.php';
        $id_perfil = $_SESSION['ses_id_perfil'];
        $user = $_SESSION["ses_rfc_corto"];
        //$busqueda = Busquedas_Filtradas_devolucion();
        $user = $_SESSION["ses_rfc_corto"];
        //SE CREA UN QUERY
        $query = " SELECT 
        Tik.id_proc,
		Etapa.user_alta,
		Etapa.fecha_alta,
		Etapa.id_determinante,
		Etapa.user_valida,
		Etapa.fecha_valida,
		Etapa.id_tiket,
        Etapa.id_proc_det,
		Etapa.estatus
        FROM Tikets Tik
        INNER JOIN Etapa_poc Etapa ON Etapa.id_tiket = Tik.id_tiket
        WHERE Tik.id_tiket = $tiket AND (Tik.id_proc = 2 OR Tik.id_proc = 7 OR Tik.id_proc = 11 ) AND( Etapa.id_proc_det = 2 OR Etapa.id_proc_det = 7 OR Etapa.id_proc_det = 11) AND Etapa.estatus = 'A' ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            //self::paginacion($filas);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function Estatus_busqueda($tiket)
    {
        include_once 'conexion.php';
        $metodos = new ConsultaContribuyentes();
        $conexion = new ConexionSQL();
        include_once 'sesion.php';
        $user_valida = $_SESSION['ses_rfc_corto'];
        $id_perfil = $_SESSION['ses_id_perfil'];
        $datos = $metodos->bus_tiket_busq($tiket);
        if (isset($datos)) {
            $datos1 = $metodos->bus_tiket_busq($tiket);
            switch ($id_perfil) {
                 case 8:
                  for ($i=0; $i < count($datos1) ; $i++) {
                      self::Crea_cambios_etapa_x_det_etapa_busqueda($tiket, $datos1[$i]['user_alta'], $datos1[$i]['id_determinante']);
                      self::Cambia_estatus_det_proc($datos1[$i]['id_determinante']);
                  }
                  self::baja_etapas_anteriores_al_cambio_BUSQUEDA($tiket); //Se da mantenimiento y se dan de baja las anteriores etapas con el nombre diferente del nuevo propietario
                  $query = "UPDATE Tikets SET id_proc = 7, fecha_valida = GETDATE(), user_valida = '$user_valida'  WHERE id_tiket = $tiket"; //Por ultimo, se actualiza el nombre del usuario movimiento para que aparezcan sus determinantes en ese ticket
                  $con = $conexion->ObtenerConexionBD();
                  $prepare = sqlsrv_query($con, $query);
                      if ($prepare) {
                          return 'Cambio exitoso';
                          $conexion->CerrarConexion($con);
                      } else {
                          return 'no se efectuo el cambio';
                          $conexion->CerrarConexion($con);
                      }
                      return 'Cambio exitoso';
                     break;
  
             }
       
        } else {
            echo "No hay datos ";
        }
    }
    public static function Crea_cambios_etapa_x_det_etapa_busqueda($tiket, $user_alta, $determinante)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_valida = $_SESSION['ses_rfc_corto'];
        if (isset($fecha_alta)) {
            $fecha= $fecha_alta;
        } else {
            $fecha= null;
        }

        $query = "INSERT INTO Etapa_poc 
            (id_proc_det,
                user_alta,
                fecha_alta,
                id_determinante,
                user_valida,
                fecha_valida,
                id_tiket,
                estatus)
            VALUES (
            7,
           '$user_alta',
            GETDATE(),
            $determinante,
            '$user_valida'
            ,GETDATE()
            ,$tiket
            ,'A'
            )
            ";
        
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Crea_cambios_etapa_x_det_etapa_dispo($tiket, $user_alta, $determinante)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_valida = $_SESSION['ses_rfc_corto'];
        $query = "INSERT INTO Etapa_poc 
            (id_proc_det,
                user_alta,
                fecha_alta,
                id_determinante,
                user_valida,
                fecha_valida,
                id_tiket,
                estatus)
            VALUES (
            11,
           '$user_alta',
            GETDATE(),
            $determinante,
            '$user_valida'
            ,GETDATE()
            ,$tiket
            ,'A'
            )
            ";
        
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Crea_cambios_etapa_x_det_etapa_cancelado($tiket, $user_alta, $determinante)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_valida = $_SESSION['ses_rfc_corto'];
        $query = "INSERT INTO Etapa_poc 
            (id_proc_det,
                user_alta,
                fecha_alta,
                id_determinante,
                user_valida,
                fecha_valida,
                id_tiket,
                estatus)
            VALUES (
            12,
           '$user_alta',
            GETDATE(),
            $determinante,
            '$user_valida'
            ,GETDATE()
            ,$tiket
            ,'A'
            )
            ";
        
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Crea_cambios_etapa_x_det_etapa_pet_dev($tiket, $user_alta, $determinante)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_valida = $_SESSION['ses_rfc_corto'];
        $query = "INSERT INTO Etapa_poc 
            (id_proc_det,
                user_alta,
                fecha_alta,
                id_determinante,
                user_valida,
                fecha_valida,
                id_tiket,
                estatus)
            VALUES (
            5,
           '$user_alta',
            GETDATE(),
            $determinante,
            '$user_valida'
            ,GETDATE()
            ,$tiket
            ,'A'
            )
            ";
        
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Crea_cambios_etapa_x_det_etapa_pet_dev_interna_bov($tiket, $user_alta, $determinante)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_valida = $_SESSION['ses_rfc_corto'];
        $query = "INSERT INTO Etapa_poc 
            (id_proc_det,
                user_alta,
                fecha_alta,
                id_determinante,
                user_valida,
                fecha_valida,
                id_tiket,
                estatus)
            VALUES (
            4,
           '$user_alta',
            GETDATE(),
            $determinante,
            '$user_valida'
            ,GETDATE()
            ,$tiket
            ,'A'
            )
            ";
        
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Crea_cambios_etapa_x_det_etapa_caduca_dispo($tiket, $user_alta, $determinante)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_valida = $_SESSION['ses_rfc_corto'];
        $query = "INSERT INTO Etapa_poc 
            (id_proc_det,
                user_alta,
                fecha_alta,
                id_determinante,
                user_valida,
                fecha_valida,
                id_tiket,
                estatus)
            VALUES (
            12,
           '$user_alta',
            GETDATE(),
            $determinante,
            '$user_valida'
            ,GETDATE()
            ,$tiket
            ,'A'
            )
            ";
        
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Crea_cambios_etapa_x_det_etapa_pet_pacial($tiket, $user_alta, $RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_valida = $_SESSION['ses_rfc_corto'];
        $query = "INSERT INTO Etapa_poc 
            (id_proc_det,
                user_alta,
                fecha_alta,
                id_determinante,
                user_valida,
                fecha_valida,
                id_tiket,
                estatus)
            VALUES (
            4,
           '$user_alta',
            GETDATE(),
            (SELECT id_determinante FROM Determinante WHERE RDFDA = '$RDFDA'),
            '$user_valida'
            ,GETDATE()
            ,$tiket
            ,'A'
            )
            ";
        
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Crea_proceso_previo_x_det($tiket, $user_alta, $RDFDA)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_valida = $_SESSION['ses_rfc_corto'];
        $query = "INSERT INTO Etapa_poc 
            (id_proc_det,
                user_alta,
                fecha_alta,
                id_determinante,
                user_valida,
                fecha_valida,
                id_tiket,
                estatus)
            VALUES (
            16,
           '$user_alta',
            GETDATE(),
            (SELECT id_determinante FROM Determinante WHERE RDFDA = '$RDFDA'),
            '$user_valida'
            ,GETDATE()
            ,$tiket
            ,'N'
            )
            ";
        
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Crea_cambios_etapa_x_det_etapa_prest($tiket, $user_alta, $determinante)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_valida = $_SESSION['ses_rfc_corto'];
        $query = "INSERT INTO Etapa_poc 
            (id_proc_det,
                user_alta,
                fecha_alta,
                id_determinante,
                user_valida,
                fecha_valida,
                id_tiket,
                estatus)
            VALUES (
            8,
           '$user_alta',
            GETDATE(),
            $determinante,
            '$user_valida'
            ,GETDATE()
            ,$tiket
            ,'A'
            )
            ";
        
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public static function Crea_cambios_etapa_x_det_etapa_cancel($tiket, $user_alta, $determinante)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $user_valida = $_SESSION['ses_rfc_corto'];
        if (isset($fecha_alta)) {
            $fecha= $fecha_alta;
        } else {
            $fecha= null;
        }

        $query = "INSERT INTO Etapa_poc 
            (id_proc_det,
                user_alta,
                fecha_alta,
                id_determinante,
                user_valida,
                fecha_valida,
                id_tiket,
                estatus)
            VALUES (
            12,
           '$user_alta',
            GETDATE(),
            $determinante,
            '$user_valida'
            ,GETDATE()
            ,$tiket
            ,'N'
            )
            ";
        
        $prepare = sqlsrv_query($con, $query);
        if ($prepare === false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return $errorsql;
        } else {
            return true;
            $conexion->CerrarConexion($con);
        }
    }
    public function Prestamos_fuera_de_plazo($perfil, $sub, $dep)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
        switch ($perfil) {
            case 1:
                $condiciones = "WHERE (Tik.id_proc=8 ) AND fecha_prest <= DATEADD(DAY, -5,GETDATE())";
                break;
            case 8:
                $condiciones = "WHERE (Tik.id_proc=8 ) AND fecha_prest <= DATEADD(DAY, -5,GETDATE())";
                break;
            case 2:
                $condiciones = "WHERE (Tik.id_proc=8 ) AND (fecha_prest <= DATEADD(DAY, -5,GETDATE())  AND Tik.user_mov = '$user'";
                break;
            case 9:
                $condiciones = "WHERE (Tik.id_proc=8 ) AND (fecha_prest <= DATEADD(DAY, -5,GETDATE())  AND Tik.user_mov = '$user'";
                break;
            case 4:
                $condiciones = "WHERE (Tik.id_proc=8 ) AND (fecha_prest <= DATEADD(DAY, -5,GETDATE()) AND dep.id_depto = $dep";
                break;
            case 10:
                $condiciones = "WHERE (Tik.id_proc=8 ) AND (fecha_prest <= DATEADD(DAY, -5,GETDATE()) AND dep.id_depto = $dep";
                break;
            case 5:
                $condiciones = "WHERE (Tik.id_proc=8 ) AND (fecha_prest <= DATEADD(DAY, -5,GETDATE()) AND Sub.nombre_sub_admin =$sub";
                break;
            case 7:
                $condiciones = "WHERE ";
                break;
            case 11:
                $condiciones = "WHERE (Tik.id_proc=8 ) AND (fecha_prest <= DATEADD(DAY, -5,GETDATE()) AND Sub.nombre_sub_admin =$sub";
                break;
            case 12:
                $condiciones = "WHERE (Tik.id_proc=8 ) AND (fecha_prest <= DATEADD(DAY, -5,GETDATE()) AND Sub.nombre_sub_admin =$sub";
                break;
        }
        $query = "SELECT
        Tik.id_proc,
        DATEDIFF(HOUR,fecha_prest,GETDATE()) as diferencia,
	    DATEPART(dw,fecha_prest) as dia_sem ,
        Tik.user_mov,
        Emp.nombre_empleado,
		dep.nombre_depto,
		sub.nombre_sub_admin,
        Tik.fecha_prest,
        Tik.fecha_pet_dev,
		Tik.fecha_recive_par,
        Tik.id_tiket
        FROM Tikets Tik 
        INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
		INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
		INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
        $condiciones ORDER BY diferencia DESC";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                $datos = $fila;
                return $datos;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public function Disponibles_fuera_de_plazo($perfil, $sub, $dep)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
        switch ($perfil) {
            case 1:
            $condiciones = "WHERE (Tik.id_proc=11 ) AND fecha_dispone <= DATEADD(DAY, 0,GETDATE())";
            break;
            case 8:
            $condiciones = "WHERE (Tik.id_proc=11 ) AND fecha_dispone <= DATEADD(DAY, 0,GETDATE())";
            break;
            case 2:
            $condiciones = "WHERE (Tik.id_proc=11) AND fecha_dispone <= DATEADD(DAY, 0,GETDATE())  AND Tik.user_mov = '$user'";
            break;
            case 7:
            $condiciones = "WHERE (Tik.id_proc=11) AND fecha_dispone <= DATEADD(DAY, 0,GETDATE())  AND Tik.user_mov = '$user'";
            break;
            case 9:
            $condiciones = "WHERE (Tik.id_proc=11) AND fecha_dispone <= DATEADD(DAY, 0,GETDATE())  AND Tik.user_mov = '$user'";
            break;
            case 4:
            $condiciones = "WHERE (Tik.id_proc=11 ) AND fecha_dispone <= DATEADD(DAY, 0,GETDATE()) AND dep.id_depto = $dep";
            break;
            case 5:
            $condiciones = "WHERE (Tik.id_proc=11 ) AND fecha_dispone <= DATEADD(DAY, 0,GETDATE()) AND dep.id_depto = $dep";
            break;
            case 10:
            $condiciones = "WHERE (Tik.id_proc=11 ) AND fecha_dispone <= DATEADD(DAY, 0,GETDATE()) AND dep.id_depto = $dep";
            break;
             case 11:
             $condiciones = "WHERE (Tik.id_proc=11 ) AND fecha_dispone <= DATEADD(DAY, 0,GETDATE()) AND Sub.nombre_sub_admin =$sub AND Tik.user_mov = '$user";
             break;
             case 12:
            $condiciones = "WHERE (Tik.id_proc=11 ) AND fecha_dispone <= DATEADD(DAY, 0,GETDATE()) AND Sub.nombre_sub_admin =$sub AND Tik.user_mov = '$user";
            break;
        }
        $query = "		SELECT
        Tik.id_proc,
		DATEDIFF(HOUR,fecha_dispone,GETDATE()) as diferencia,
	    DATEPART(dw,fecha_dispone) as dia_sem ,
        Tik.user_mov,
        Tik.fecha_dispone,
        Emp.nombre_empleado,
		dep.nombre_depto,
		sub.nombre_sub_admin,
        Tik.fecha_prest,
        Tik.fecha_dispone,
        Tik.fecha_pet_dev,
		Tik.fecha_recive_par,
        Tik.id_tiket
        FROM Tikets Tik 
        INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
		INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
		INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
        $condiciones ORDER BY diferencia DESC";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                $datos = $fila;
                return $datos;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public function Disponibles_CANCELADOS($perfil)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //$user = $_SESSION['ses_rfc_corto'];
        switch ($perfil) {
            case 1:
                $query = "SELECT 
                Tik.id_proc,
                Tik.user_mov,
                Tik.fecha_dispone,
                Tik.fecha_cancel,
                Tik.user_cancel,
                Emp.nombre_empleado,
                dep.nombre_depto,
                sub.nombre_sub_admin,
                Tik.fecha_prest,
                Tik.fecha_pet_dev,
                Tik.fecha_recive_par,
                Tik.id_tiket
                FROM tikets Tik
                INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
                INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
                INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
                WHERE id_proc = 12 AND fecha_dispone IS NOT NULL AND fecha_prest IS NULL AND user_cancel = 'BOVEDASA' AND Tik.estatus='A'";
                break;
            case 8:
                $query = "SELECT 
                Tik.id_proc,
                Tik.user_mov,
                Tik.fecha_dispone,
                Tik.fecha_cancel,
                Tik.user_cancel,
                Emp.nombre_empleado,
                dep.nombre_depto,
                sub.nombre_sub_admin,
                Tik.fecha_prest,
                Tik.fecha_pet_dev,
                Tik.fecha_recive_par,
                Tik.id_tiket
                FROM tikets Tik
                INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
                INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
                INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
                WHERE id_proc = 12 AND fecha_dispone IS NOT NULL AND fecha_prest IS NULL AND user_cancel = 'BOVEDASA' AND Tik.estatus='A'";
                break;
                default:
                $query = "";
                break;
        }
       
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                $datos = $fila;
                return $datos;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public function tickets_por_aprobar($perfil)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        $sub = $_SESSION['ses_id_sub_admin'];
        $dep = $_SESSION['ses_id_depto'];
        $user = $_SESSION['ses_rfc_corto'];
        //$user = $_SESSION['ses_rfc_corto'];
        switch ($perfil) {
        case 1:
            $query = "SELECT 
                Tik.id_proc,
                Tik.user_mov,
                Tik.fecha_dispone,
                Tik.fecha_cancel,
                Tik.user_cancel,
                Emp.nombre_empleado,
                dep.nombre_depto,
                sub.nombre_sub_admin,
                Tik.fecha_prest,
                Tik.fecha_mov,
                Tik.fecha_pet_dev,
                Tik.fecha_recive_par,
                Tik.Prioridad,
                Tik.id_tiket
                FROM tikets Tik
                INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
                INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
                INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
                WHERE id_proc = 2 AND Tik.fecha_mov IS NOT NULL  AND Tik.estatus='N'";
            break;
            case 2:
                $query = "SELECT 
                    Tik.id_proc,
                    Tik.user_mov,
                    Tik.fecha_dispone,
                    Tik.fecha_cancel,
                    Tik.user_cancel,
                    Emp.nombre_empleado,
                    dep.nombre_depto,
                    sub.nombre_sub_admin,
                    Tik.fecha_prest,
                    Tik.fecha_mov,
                    Tik.fecha_pet_dev,
                    Tik.fecha_recive_par,
                    Tik.Prioridad,
                    Tik.id_tiket
                    FROM tikets Tik
                    INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
                    INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
                    INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
                    WHERE id_proc = 2 AND Tik.fecha_mov IS NOT NULL  AND Tik.estatus='N' AND Emp.rfc_corto='$user' ";
                break;
                case 9:
                    $query = "SELECT 
                        Tik.id_proc,
                        Tik.user_mov,
                        Tik.fecha_dispone,
                        Tik.fecha_cancel,
                        Tik.user_cancel,
                        Emp.nombre_empleado,
                        dep.nombre_depto,
                        sub.nombre_sub_admin,
                        Tik.fecha_prest,
                        Tik.fecha_mov,
                        Tik.fecha_pet_dev,
                        Tik.fecha_recive_par,
                        Tik.Prioridad,
                        Tik.id_tiket
                        FROM tikets Tik
                        INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
                        INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
                        INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
                        WHERE id_proc = 2 AND Tik.fecha_mov IS NOT NULL  AND Tik.estatus='N' AND Emp.rfc_corto='$user' ";
                    break;
                    case 4:
                        $query = "SELECT 
                            Tik.id_proc,
                            Tik.user_mov,
                            Tik.fecha_dispone,
                            Tik.fecha_cancel,
                            Tik.user_cancel,
                            Emp.nombre_empleado,
                            dep.nombre_depto,
                            sub.nombre_sub_admin,
                            Tik.fecha_prest,
                            Tik.fecha_mov,
                            Tik.fecha_pet_dev,
                            Tik.fecha_recive_par,
                            Tik.Prioridad,
                            Tik.id_tiket
                            FROM tikets Tik
                            INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
                            INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
                            INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
                            WHERE id_proc = 2 AND Tik.fecha_mov IS NOT NULL  AND Tik.estatus='N' AND Emp.id_depto=$dep ";
                        break;
                        case 10:
                            $query = "SELECT 
                                Tik.id_proc,
                                Tik.user_mov,
                                Tik.fecha_dispone,
                                Tik.fecha_cancel,
                                Tik.user_cancel,
                                Emp.nombre_empleado,
                                dep.nombre_depto,
                                sub.nombre_sub_admin,
                                Tik.fecha_prest,
                                Tik.fecha_mov,
                                Tik.fecha_pet_dev,
                                Tik.fecha_recive_par,
                                Tik.Prioridad,
                                Tik.id_tiket
                                FROM tikets Tik
                                INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
                                INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
                                INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
                                WHERE id_proc = 2 AND Tik.fecha_mov IS NOT NULL  AND Tik.estatus='N' AND Emp.id_depto=$dep ";
                            break;
            case 7:
                $query = "SELECT 
                    Tik.id_proc,
                    Tik.user_mov,
                    Tik.fecha_dispone,
                    Tik.fecha_cancel,
                    Tik.user_cancel,
                    Emp.nombre_empleado,
                    dep.nombre_depto,
                    sub.nombre_sub_admin,
                    Tik.fecha_prest,
                    Tik.fecha_mov,
                    Tik.fecha_pet_dev,
                    Tik.fecha_recive_par,
                    Tik.Prioridad,
                    Tik.id_tiket
                    FROM tikets Tik
                    INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
                    INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
                    INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
                    WHERE id_proc = 2 AND Tik.fecha_mov IS NOT NULL  AND Tik.estatus='N'";
                break;
            case 5:
            $query = "SELECT 
                Tik.id_proc,
                Tik.user_mov,
                Tik.fecha_dispone,
                Tik.fecha_cancel,
                Tik.user_cancel,
                Emp.nombre_empleado,
                dep.nombre_depto,
                sub.nombre_sub_admin,
                Tik.fecha_prest,
                Tik.fecha_mov,
                Tik.fecha_pet_dev,
                Tik.fecha_recive_par,
                Tik.Prioridad,
                Tik.id_tiket
                FROM tikets Tik
                INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
                INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
                INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
                WHERE id_proc = 2 AND Tik.fecha_mov IS NOT NULL  AND Tik.estatus='N'AND emp.id_sub_admin =$sub";
            break;
                case 11:
                    $query = "SELECT 
                        Tik.id_proc,
                        Tik.user_mov,
                        Tik.fecha_dispone,
                        Tik.fecha_cancel,
                        Tik.user_cancel,
                        Emp.nombre_empleado,
                        dep.nombre_depto,
                        sub.nombre_sub_admin,
                        Tik.fecha_prest,
                        Tik.fecha_mov,
                        Tik.fecha_pet_dev,
                        Tik.fecha_recive_par,
                        Tik.Prioridad,
                        Tik.id_tiket
                        FROM tikets Tik
                        INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
                        INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
                        INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
                        WHERE id_proc = 2 AND Tik.fecha_mov IS NOT NULL  AND Tik.estatus='N' AND emp.id_sub_admin =$sub";
                    break;
                    case 12:
                        $query = "SELECT 
                            Tik.id_proc,
                            Tik.user_mov,
                            Tik.fecha_dispone,
                            Tik.fecha_cancel,
                            Tik.user_cancel,
                            Emp.nombre_empleado,
                            dep.nombre_depto,
                            sub.nombre_sub_admin,
                            Tik.fecha_prest,
                            Tik.fecha_mov,
                            Tik.fecha_pet_dev,
                            Tik.fecha_recive_par,
                            Tik.Prioridad,
                            Tik.id_tiket
                            FROM tikets Tik
                            INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
                            INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
                            INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
                            WHERE id_proc = 2 AND Tik.fecha_mov IS NOT NULL  AND Tik.estatus='N' AND emp.id_sub_admin =$sub";
                        break;
                    default:
                    $query = "";
                    break;
        }
       
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                $datos = $fila;
                return $datos;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public function tickets_cancelados_por_analistas($perfil)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        $sub = $_SESSION['ses_id_sub_admin'];
        $dep = $_SESSION['ses_id_depto'];
        $user = $_SESSION['ses_rfc_corto'];
        //$user = $_SESSION['ses_rfc_corto'];
        switch ($perfil) {
         case 1:
        $condicion ="  tik.id_proc = 12 AND user_cancel != 'BOVEDASA' and tik.estatus='A'";
        break;
        case 2:
        $condicion = "tik.id_proc = 12 AND user_cancel != 'BOVEDASA' AND emp1.rfc_corto='$user'and tik.estatus='A' ";
        break;
        case 9:
        $condicion = "  tik.id_proc = 12 AND user_cancel != 'BOVEDASA' AND emp1.rfc_corto='$user'and tik.estatus='A' ";
        break;
        case 4:
        $condicion = " tik.id_proc = 12 AND user_cancel != 'BOVEDASA' AND  emp1.id_depto=$dep and tik.estatus='A'";
        break;
        case 10:
        $condicion = " tik.id_proc = 12 AND user_cancel != 'BOVEDASA' AND emp1.id_depto=$dep and tik.estatus='A'";
        break;
        case 5:
        $condicion = " tik.id_proc = 12 AND user_cancel != 'BOVEDASA' AND emp1.id_sub_admin =$sub and tik.estatus='A'";
        break;
        case 11:
        $condicion = " tik.id_proc = 12 AND user_cancel != 'BOVEDASA' AND emp1.id_sub_admin =$sub and tik.estatus='A'";
        break;
        default:
        $condicion = "";
        break;
        }
        $query = "SELECT 
             emp.nombre_empleado As Responsable,
             tik.id_tiket,
             tik.fecha_cancel,
             tik.id_proc,
             emp1.nombre_empleado ,
             tik.Asunto,
            case 
             WHEN (tik.Prioridad = 1) THEN 'URGENTE'
             ELSE 'NORMAL'
             END AS Prioridad,
             case 
             WHEN (tik.motivo_cancel = 1) THEN 'PETICION POR PARTE DEL ANALISTA'
             WHEN (tik.motivo_cancel = 2) THEN 'PETICION DEL JEFE O ENCARGADO'
             WHEN (tik.motivo_cancel = 3) THEN 'NO SE ENCONTRARON UNA O VARIAS DETERMINANTES'
             WHEN (tik.motivo_cancel = 4) THEN 'YA NO ES NECESARIO'
            WHEN (tik.motivo_cancel = 5) THEN 'ERROR EN LA PETICION DEL TICKET'
             END AS Motivo_cancelación,
             sub.nombre_sub_admin,
			dep.nombre_depto
            FROM Tikets tik
            INNER JOIN Empleado emp ON emp.rfc_corto = tik.user_cancel 
            INNER JOIN Empleado emp1 ON emp1.rfc_corto = tik.user_mov 
			INNER JOIN SubAdmin sub ON emp1.id_sub_admin = sub.id_sub_admin
			INNER JOIN Departamento dep ON emp1.id_depto = dep.id_depto
            WHERE $condicion";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                $datos = $fila;
                return $datos;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public function Peticiones_fuera_de_plazo($perfil, $sub, $dep)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
        switch ($perfil) {
            case 1:
                $condiciones = "WHERE (Tik.id_proc=5) AND fecha_pet_dev <= DATEADD(DAY, -5,GETDATE())";
                break;
            case 8:
                $condiciones = "WHERE (Tik.id_proc=5) AND fecha_pet_dev <= DATEADD(DAY, -5,GETDATE())";
                break;
            case 2:
                $condiciones = "WHERE (Tik.id_proc=5) AND (fecha_pet_dev <= DATEADD(DAY, -5,GETDATE())  AND Tik.user_mov = '$user'";
                break;
            case 9:
                $condiciones = "WHERE (Tik.id_proc=5) AND (fecha_pet_dev <= DATEADD(DAY, -5,GETDATE())  AND Tik.user_mov = '$user'";
                break;
            case 4:
            $condiciones = "WHERE (Tik.id_proc=5) AND (fecha_pet_dev <= DATEADD(DAY, -5,GETDATE()) AND dep.id_depto = $dep";
            break;
            case 10:
            $condiciones = "WHERE (Tik.id_proc=5) AND (fecha_pet_dev <= DATEADD(DAY, -5,GETDATE()) AND dep.id_depto = $dep";
            break;
            case 5:
                $condiciones = "WHERE (Tik.id_proc=5) AND (fecha_pet_dev <= DATEADD(DAY, -5,GETDATE()) AND Sub.nombre_sub_admin =$sub";
                break;
                case 7:
                    $condiciones = "WHERE ";
                    break;
            case 11:
                $condiciones = "WHERE (Tik.id_proc=5) AND (fecha_pet_dev <= DATEADD(DAY, -5,GETDATE()) AND Sub.nombre_sub_admin =$sub";
                break;
            case 12:
                $condiciones = "WHERE (Tik.id_proc=5) AND (fecha_pet_dev <= DATEADD(DAY, -5,GETDATE()) AND Sub.nombre_sub_admin =$sub";
                break;
        }
        $query = "SELECT
        Tik.id_proc,
		DATEDIFF(HOUR,fecha_prest,GETDATE()) as diferencia,
	    DATEPART(dw,fecha_prest) as dia_sem ,
        Tik.user_mov,
        Emp.nombre_empleado,
		dep.nombre_depto,
		sub.nombre_sub_admin,
        Tik.fecha_prest,
        Tik.fecha_pet_dev,
		Tik.fecha_recive_par,
        Tik.id_tiket
        FROM Tikets Tik 
        INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
		INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
		INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
        $condiciones ORDER BY diferencia DESC";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                $datos = $fila;
                return $datos;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public function Devoluciones_parciales_fuera_de_plazo($perfil, $sub, $dep)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
        switch ($perfil) {
            case 1:
            $condiciones = "WHERE ( Tik.id_proc=9 ) AND fecha_recive_par <= DATEADD(DAY, -5,GETDATE())";
            break;
            case 8:
            $condiciones = "WHERE ( Tik.id_proc=9 ) AND fecha_recive_par <= DATEADD(DAY, -5,GETDATE())";
            break;
            case 2:
            $condiciones = "WHERE ( Tik.id_proc=9 ) AND (fecha_recive_par <= DATEADD(DAY, -5,GETDATE())  AND Tik.user_mov = '$user'";
            break;
            case 9:
            $condiciones = "WHERE ( Tik.id_proc=9 ) AND (fecha_recive_par <= DATEADD(DAY, -5,GETDATE())  AND Tik.user_mov = '$user'";
            break;
            case 4:
            $condiciones = "WHERE ( Tik.id_proc=9 ) AND (fecha_recive_par <= DATEADD(DAY, -5,GETDATE()) AND dep.id_depto = $dep";
            break;
            case 10:
            $condiciones = "WHERE ( Tik.id_proc=9 ) AND (fecha_recive_par <= DATEADD(DAY, -5,GETDATE()) AND dep.id_depto = $dep";
            break;
            case 7:
            $condiciones = "WHERE ";
            break;
            case 5:
            $condiciones = "WHERE ( Tik.id_proc=9 ) AND (fecha_recive_par <= DATEADD(DAY, -5,GETDATE()) AND Sub.nombre_sub_admin =$sub";
            break;
            case 11:
            $condiciones = "WHERE ( Tik.id_proc=9 ) AND (fecha_recive_par <= DATEADD(DAY, -5,GETDATE()) AND Sub.nombre_sub_admin =$sub";
            break;
            case 12:
            $condiciones = "WHERE ( Tik.id_proc=9 ) AND (fecha_recive_par <= DATEADD(DAY, -5,GETDATE()) AND Sub.nombre_sub_admin =$sub";
            break;
        }
        $query = "	SELECT
        Tik.id_proc,
		DATEDIFF(HOUR,fecha_prest,GETDATE()) as diferencia,
	    DATEPART(dw,fecha_prest) as dia_sem ,
        Tik.user_mov,
        Emp.nombre_empleado,
		dep.nombre_depto,
		sub.nombre_sub_admin,
        Tik.fecha_prest,
        Tik.fecha_pet_dev,
		Tik.fecha_recive_par,
        Tik.id_tiket
        FROM Tikets Tik 
        INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
		INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
		INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
        $condiciones ORDER BY diferencia DESC";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                $datos = $fila;
                return $datos;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public function Busquedas_fuera_de_plazo($perfil, $sub, $dep)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        $user = $_SESSION['ses_rfc_corto'];
            switch ($perfil) {
            case 1:
            $condiciones = "WHERE ( Tik.id_proc=7) AND fecha_valida <= DATEADD(DAY, -5,GETDATE())";
            break;
            case 8:
            $condiciones = "WHERE ( Tik.id_proc=7) AND fecha_valida <= DATEADD(DAY, -5,GETDATE())";
            break;
            case 2:
            $condiciones = "WHERE ( Tik.id_proc=7) AND (fecha_valida <= DATEADD(DAY, -5,GETDATE())  AND Tik.user_mov = '$user'";
            break;
            case 9:
            $condiciones = "WHERE ( Tik.id_proc=7) AND (fecha_valida <= DATEADD(DAY, -5,GETDATE())  AND Tik.user_mov = '$user'";
            break;
            case 4:
            $condiciones = "WHERE ( Tik.id_proc=7)AND (fecha_valida <= DATEADD(DAY, -5,GETDATE()) AND dep.id_depto = $dep";
            break;
            case 10:
            $condiciones = "WHERE ( Tik.id_proc=7)AND (fecha_valida <= DATEADD(DAY, -5,GETDATE()) AND dep.id_depto = $dep";
            break;
            case 7:
                $condiciones = "WHERE ";
                break;
            case 5:
            $condiciones = "WHERE ( Tik.id_proc=7) AND (fecha_valida <= DATEADD(DAY, -5,GETDATE()) AND Sub.nombre_sub_admin =$sub";
            break;
            case 11:
            $condiciones = "WHERE ( Tik.id_proc=7) AND (fecha_valida <= DATEADD(DAY, -5,GETDATE()) AND Sub.nombre_sub_admin =$sub";
            break;
            case 12:
            $condiciones = "WHERE ( Tik.id_proc=7) AND (fecha_valida <= DATEADD(DAY, -5,GETDATE()) AND Sub.nombre_sub_admin =$sub";
            break;
            }
        $query = "SELECT
        Tik.id_proc,
		DATEDIFF(HOUR,fecha_valida,GETDATE()) as diferencia,
	    DATEPART(dw,fecha_valida) as dia_sem ,
        Tik.user_mov,
        Emp.nombre_empleado,
		dep.nombre_depto,
		sub.nombre_sub_admin,
        Tik.fecha_prest,
        Tik.fecha_pet_dev,
        Tik.fecha_valida,
		Tik.fecha_recive_par,
        Tik.id_tiket
        FROM Tikets Tik 
        INNER JOIN Empleado Emp ON Tik.user_mov = Emp.rfc_corto
		INNER JOIN Departamento dep ON Emp.id_depto = dep.id_depto
		INNER JOIN SubAdmin Sub ON Emp.id_sub_admin = Sub.id_sub_admin
        $condiciones ORDER BY diferencia DESC";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                $datos = $fila;
                return $datos;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public static function bus_por_tiket($tiket)
    {
        include_once 'conexion.php';
        $conexion = new ConexionSQL();
        $query = " select
        contri.rfc,
        det.num_determinante,
        etapa.fecha_alta,
        etapa.id_proc_det
        from Etapa_poc etapa
        inner join Determinante det on det.id_determinante=etapa.id_determinante
        inner join Expediente expe on expe.id_expediente=det.id_expediente
        inner join Contribuyente contri on contri.id_contribuyente=expe.id_contribuyente
        where etapa.id_tiket=$tiket";
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $fila[] = $row;
            }
            if (isset($fila)) {
                return $fila;
                $conexion->CerrarConexion($con);
            } else {
                return null;
                $conexion->CerrarConexion($con);
            }
        }
    }
    public function tabla_prest($datos_prest)
    {
        if (isset($datos_prest)) {
            $tab_1 = " 
        <table class='table table-sm'>
        <thead>
        <tr>
        <th scope='col'>#</th>
        <th scope='col'>No. Ticket</th>
        <th scope='col'>Nombre empleado</th>
        <th scope='col'>Subadministración.</th>
        <th scope='col'>Departamento.</th>
        <th scope='col'>Fecha de prestamo</th>
        <th scope='col'>Estatus</th>
        <th scope='col'>No. Días</th>
        </tr>
        </thead>
        <tbody>";
            $a = 1;
            //Se recorre un arreglo por todos los tickets encontrados fuera de plazo
            for ($i = 0; $i < count($datos_prest); $i++) {
                $estatus = $datos_prest[$i]['id_proc'];
                //Se valida el proceso en el que se encuentra el Ticket
                switch ($estatus) {
                    case 8:
                    $text = 'Préstamo';
                    $fecha = $datos_prest[$i]['fecha_prest']->format('d/m/Y');
                    $horas_a_dias = intdiv(($datos_prest[$i]['diferencia']-48), 24);
                    break;
                    case 9:
                    $text = 'Deolución parcial';
                    $fecha = $datos_prest[$i]['fecha_recive_par']->format('d/m/Y');
                    $horas_a_dias = intdiv(($datos_prest[$i]['diferencia']-48), 24);
                    break;
                    case 5:
                    $text = 'Peticion de devolución';
                    $fecha = $datos_prest[$i]['fecha_pet_dev']->format('d/m/Y');
                    $horas_a_dias = intdiv(($datos_prest[$i]['diferencia']-48), 24);
                    break;
                    case 7:
                    $text = 'Búsqueda';
                    $fecha = $datos_prest[$i]['fecha_valida']->format('d/m/Y');
                    $horas_a_dias = intdiv(($datos_prest[$i]['diferencia']-48), 24);
                    break;
                }
                $tab_1 .= " 
            <tr>
            <th scope='row'>" . $a++ . "</th>
            <td>" . $datos_prest[$i]['id_tiket'] . "</td>
            <td>" . $datos_prest[$i]['nombre_empleado'] . "</td>
            <td>" . $datos_prest[$i]['nombre_sub_admin'] . "</td>
            <td>" . $datos_prest[$i]['nombre_depto'] . "</td>
            <td>" . $fecha . "</td>
            <td>" . $text . "</td>
            <td>" . $horas_a_dias . " días</td>
            </tr>";
            }

            $tab_1 .= "  </tbody>
        </table>";
            echo $tab_1;
        } else {
            echo "No hay ticket´s fuera de plazo en esta categoria! ";
        }
    }
    public function tabla_dispo($datos_dis)
    {
        if (isset($datos_dis)) {
            $tab_1 = " 
        <table class='table table-sm text-center'>
        <thead>
        <tr>
        <th scope='col'>#</th>
        <th scope='col'>No. Ticket</th>
        <th scope='col'>Nombre empleado</th>
        <th scope='col'>Subadministración.</th>
        <th scope='col'>Departamento.</th>
        <th scope='col'>Fecha disponible</th>
        <th scope='col'>Estatus</th>
        <th scope='col'>No. Días</th>
        </tr>
        </thead>
        <tbody>";
            $a = 1;
            //Se recorre un arreglo por todos los tickets encontrados fuera de plazo
            for ($i = 0; $i < count($datos_dis); $i++) {
                $estatus = $datos_dis[$i]['id_proc'];
                //Se valida el proceso en el que se encuentra el Ticket
                switch ($estatus) {
                    case 11:
                        $text = 'Disponible';
                        $fecha = $datos_dis[$i]['fecha_dispone']->format('d/m/Y');
                        $horas =  $datos_dis[$i]['diferencia'];
                        $dias_a_horas = intdiv($horas, 24);
                        break;
                }
                $tab_1 .= " 
            <tr>
            <th scope='row'>" . $a++ . "</th>
            <td>" . $datos_dis[$i]['id_tiket'] . "</td>
            <td>" . $datos_dis[$i]['nombre_empleado'] . "</td>
            <td>" . $datos_dis[$i]['nombre_sub_admin'] . "</td>
            <td>" . $datos_dis[$i]['nombre_depto'] . "</td>
            <td>" . $fecha . "</td>
            <td>" . $text . "</td>
            <td>" . $dias_a_horas . " días</td>
            </tr>";
            }

            $tab_1 .= "  </tbody>
        </table>";
            echo $tab_1;
        } else {
            echo "No hay ticket´s fuera de plazo en esta categoria! ";
        }
    }
    public function tabla_dispo_cencel($datos_dis)
    {
        if (isset($datos_dis)) {
            $tab_1 = " 
        <table class='table table-sm'>
        <thead>
        <tr>
        <th scope='col'>#</th>
        <th scope='col'>No. Ticket</th>
        <th scope='col'>Nombre empleado</th>
        <th scope='col'>Subadministración.</th>
        <th scope='col'>Departamento.</th>
        <th scope='col'>Fecha cancelación</th>
        <th scope='col'>Estatus</th>
        </tr>
        </thead>
        <tbody>";
            $a = 1;
            //Se recorre un arreglo por todos los tickets encontrados fuera de plazo
            for ($i = 0; $i < count($datos_dis); $i++) {
                $estatus = $datos_dis[$i]['id_proc'];
                //Se valida el proceso en el que se encuentra el Ticket
                switch ($estatus) {
                    case 12:
                        $text = 'Ticket cancelado';
                        $fecha = $datos_dis[$i]['fecha_cancel']->format('d/m/Y');
                        break;
                }
                $tab_1 .= " 
            <tr>
            <th scope='row'>" . $a++ . "</th>
            <td><a class='btn btn-outline-info' href='#'onclick='detalle_tiket_dispo_cancelados(" . $datos_dis[$i]["id_tiket"] . ")'>" .$datos_dis[$i]["id_tiket"] . "</a></td>
            <td>" . $datos_dis[$i]['nombre_empleado'] . "</td>
            <td>" . $datos_dis[$i]['nombre_sub_admin'] . "</td>
            <td>" . $datos_dis[$i]['nombre_depto'] . "</td>
            <td>" . $fecha . "</td>
            <td>" . $text . "</td>
            </tr>";
            }

            $tab_1 .= "  </tbody>
        </table>";
            echo $tab_1;
        } else {
            echo "No hay ticket´s fuera de plazo en esta categoria! ";
        }
    }

    public function tabla_tickets_cancelados_por_revisar($datos_dis)
    {
        if (isset($datos_dis)) {
            $tab_1 = " 
        <table class='table table-responsive table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
        <tr>
        <th scope='col'>#</th>
        <th scope='col'>No. Ticket</th>
        <th scope='col'>Nombre empleado</th>
        <th scope='col'>Subadministración.</th>
        <th scope='col'>Departamento.</th>
        <th scope='col'>Fecha cancelación</th>
        <th scope='col'>Estatus</th>
        <th scope='col'>Resp. de la cancelación</th>
        <th scope='col'>Motivo</th>
        </tr>
        </thead>
        <tbody>";
            $a = 1;
            //Se recorre un arreglo por todos los tickets encontrados fuera de plazo
            for ($i = 0; $i < count($datos_dis); $i++) {
                //Se valida el proceso en el que se encuentra el Ticket
                $text = 'Ticket cancelado';
                $fecha = $datos_dis[$i]['fecha_cancel']->format('d/m/Y H:i');
  
                $tab_1 .= " 
            <tr class=''>
            <th scope='row'>" . $a++ . "</th>
            <td><a class='btn btn-outline-info' onclick='detalle_tiket_cancelado_notif(" . $datos_dis[$i]["id_tiket"] . ")'>" .$datos_dis[$i]["id_tiket"] . "</a></td>
            <td>" . $datos_dis[$i]['nombre_empleado'] . "</td>
            <td>" . $datos_dis[$i]['nombre_sub_admin'] . "</td>
            <td>" . $datos_dis[$i]['nombre_depto'] . "</td>
            <td>" . $fecha . "</td>
            <td>" . $text . "</td>
            <td>" . $datos_dis[$i]['Responsable'] . "</td>
            <td>" . $datos_dis[$i]['Motivo_cancelación'] . "</td>
            </tr>";
            }

            $tab_1 .= "  </tbody>
        </table>";
            echo $tab_1;
        } else {
            echo "No hay ticket´s fuera de plazo en esta categoria! ";
        }
    }
    public function tabla_tickets_por_aprobar($datos_dis)
    {
        if (isset($datos_dis)) {
            $tab_1 = " 
        <table class='table table-sm table-striped shadow p-1 bg-white rounded'>
        <thead>
        <tr>
        <th scope='col'>#</th>
        <th scope='col'>No. Ticket</th>
        <th scope='col'>Nombre empleado</th>
        <th scope='col'>Subadministración.</th>
        <th scope='col'>Departamento.</th>
        <th scope='col'>Fecha cancelación</th>
        <th scope='col'>Estatus</th>
        <th scope='col'>Prioridad</th>
        </tr>
        </thead>
        <tbody>";
            $a = 1;
            //Se recorre un arreglo por todos los tickets encontrados fuera de plazo
            for ($i = 0; $i < count($datos_dis); $i++) {
                $estatus = $datos_dis[$i]['id_proc'];
                $Prioridad = $datos_dis[$i]['Prioridad'];
                //Se valida el proceso en el que se encuentra el Ticket
                switch ($estatus) {
                    case 2:
                        $text = 'Petición en curso';
                        $fecha = $datos_dis[$i]['fecha_mov']->format('d/m/Y');
                        if (isset($Prioridad)) {
                            if ($Prioridad == 1) {
                                $color = "table-danger";
                                $txt = "URGENTE";
                            } elseif ($Prioridad == 0) {
                                $color = "table-light";
                                $txt = "NORMAL";
                            }
                        } else {
                            $color = "table-light";
                            $txt = "NORMAL";
                        }

                        break;
                }
                $tab_1 .= " 
            <tr class='$color'>
            <th scope='row'>" . $a++ . "</th>
            <td><a class='btn btn-outline-info' href='#'onclick='detalle_tiket_por_aprobar(" . $datos_dis[$i]["id_tiket"] . ")'>" .$datos_dis[$i]["id_tiket"] . "</a></td>
            <td>" . $datos_dis[$i]['nombre_empleado'] . "</td>
            <td>" . $datos_dis[$i]['nombre_sub_admin'] . "</td>
            <td>" . $datos_dis[$i]['nombre_depto'] . "</td>
            <td>" . $fecha . "</td>
            <td>" . $text . "</td>
            <td>" . $txt . "</td>
            </tr>";
            }

            $tab_1 .= "  </tbody>
        </table>";
            echo $tab_1;
        } else {
            echo "No hay ticket´s fuera de plazo en esta categoria! ";
        }
    }
    public static function cambia_estatus_ticket_cancelado($tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = " UPDATE Tikets SET estatus = 'N' where id_tiket=  $tiket ";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return 'Cambio exitoso';
        } else {
            return 'Cambio exitoso';
            $conexion->CerrarConexion($con);
        }
    }
    public static function cambia_estatus_ticket_aprobado($tiket)
    {
        include_once 'conexion.php';
        include_once 'sesion.php';
        $conexion = new ConexionSQL();
        $user = $_SESSION["ses_rfc_corto"];
        $con = $conexion->ObtenerConexionBD();
        $query = " UPDATE Tikets SET estatus = 'A', user_aprovador = '$user', fecha_aprobada = GETDATE()  where id_tiket=  $tiket ";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare == false) {
            $errorsql = print_r(sqlsrv_errors(), false);
            $conexion->CerrarConexion($con);
            return 'Cambio exitoso';
        } else {
            return 'Cambio exitoso';
            $conexion->CerrarConexion($con);
        }
    }
    public function tabla_pet($datos_pet)
    {
        if (isset($datos_pet)) {
            $tab_1 = " <table class='table table-sm'>
         <thead>
         <tr>
         <th scope='col'>#</th>
         <th scope='col'>No. Ticket</th>
         <th scope='col'>Nombre empleado</th>
         <th scope='col'>Subadministración.</th>
         <th scope='col'>Departamento.</th>
         <th scope='col'>Fecha de prestamo</th>
         <th scope='col'>Estatus</th>
         <th scope='col'>No. Días</th>
         </tr>
         </thead>
         <tbody>";
            $a = 1;
            //Se recorre un arreglo por todos los tickets encontrados fuera de plazo
            for ($i = 0; $i < count($datos_pet); $i++) {
                $estatus = $datos_pet[$i]['id_proc'];
                //Se valida el proceso en el que se encuentra el Ticket
                    //Se valida el proceso en el que se encuentra el Ticket
                    switch ($estatus) {
                        case 8:
                        $text = 'Préstamo';
                        $fecha = $datos_pet[$i]['fecha_prest']->format('d/m/Y');
                        $horas_a_dias = intdiv(($datos_pet[$i]['diferencia']-48), 24);
                        break;
                        case 9:
                        $text = 'Deolución parcial';
                        $fecha = $datos_pet[$i]['fecha_recive_par']->format('d/m/Y');
                        $horas_a_dias = intdiv(($datos_pet[$i]['diferencia']-48), 24);
                        break;
                        case 5:
                        $text = 'Peticion de devolución';
                        $fecha = $datos_pet[$i]['fecha_pet_dev']->format('d/m/Y');
                        $horas_a_dias = intdiv(($datos_pet[$i]['diferencia']-48), 24);
                        break;
                        case 7:
                        $text = 'Búsqueda';
                        $fecha = $datos_pet[$i]['fecha_valida']->format('d/m/Y');
                        $horas_a_dias = intdiv(($datos_pet[$i]['diferencia']-48), 24);
                        break;
                    }
                $tab_1 .= " 
             <tr>
             <th scope='row'>" . $a++ . "</th>
             <td>" . $datos_pet[$i]['id_tiket'] . "</td>
             <td>" . $datos_pet[$i]['nombre_empleado'] . "</td>
             <td>" . $datos_pet[$i]['nombre_sub_admin'] . "</td>
             <td>" . $datos_pet[$i]['nombre_depto'] . "</td>
             <td>" . $fecha . "</td>
             <td>" . $text . "</td>
             <td>" . $horas_a_dias . " días</td>
             </tr>";
            }

            $tab_1 .= "  </tbody>
         </table>";
            echo $tab_1;
        } else {
            echo "No hay ticket´s fuera de plazo en esta categoria! ";
        }
    }

    public function tabla_busq($datos_busq)
    {   //echo 'entra aqui';
        //$vista = json_encode($datos_busq);
        //echo $vista;
        if (isset($datos_busq)) {
            $tab_1 = " 
             <table class='table table-sm'>
             <thead>
             <tr>
             <th scope='col'>#</th>
             <th scope='col'>No. Ticket</th>
             <th scope='col'>Nombre empleado</th>
             <th scope='col'>Subadministración.</th>
             <th scope='col'>Departamento.</th>
             <th scope='col'>Fecha búsqueda</th>
             <th scope='col'>Estatus</th>
             <th scope='col'>No. Días</th>
             </tr>
             </thead>
              <tbody>";
            $a = 1;
            //Se recorre un arreglo por todos los tickets encontrados fuera de plazo
            for ($i = 0; $i < count($datos_busq); $i++) {
                $estatus = $datos_busq['id_proc'];
                    switch ($estatus) {
                        case 8:
                        $text = 'Préstamo';
                        $fecha = $datos_busq[$i]['fecha_prest']->format('d/m/Y');
                        $horas_a_dias = intdiv(($datos_busq[$i]['diferencia']-48), 24);
                        break;
                        case 9:
                        $text = 'Deolución parcial';
                        $fecha = $datos_busq[$i]['fecha_recive_par']->format('d/m/Y');
                        $horas_a_dias = intdiv(($datos_busq[$i]['diferencia']-48), 24);
                        break;
                        case 5:
                        $text = 'Peticion de devolución';
                        $fecha = $datos_busq[$i]['fecha_pet_dev']->format('d/m/Y');
                        $horas_a_dias = intdiv(($datos_busq[$i]['diferencia']-48), 24);
                        break;
                        case 7:
                        $text = 'Búsqueda';
                        $fecha = $datos_busq[$i]['fecha_valida']->format('d/m/Y');
                        $horas_a_dias = intdiv(($datos_busq[$i]['diferencia']-48), 24);
                        break;
                    }
                //Se valida el proceso en el que se encuentra el Ticket
                $text = 'Búsqueda';
                $fecha = $datos_busq[$i]['fecha_valida']->format('d/m/Y');
                $tab_1 .= " 
                  <tr class='text-center'>
                  <th scope='row'>" . $a++ . "</th>
                  <td>" . $datos_busq[$i]['id_tiket'] . "</td>
                  <td>" . $datos_busq[$i]['nombre_empleado'] . "</td>
                  <td>" . $datos_busq[$i]['nombre_sub_admin'] . "</td>
                  <td>" . $datos_busq[$i]['nombre_depto'] . "</td>
                  <td>" . $fecha . "</td>
                  <td>" . $text . "</td>
                  <td>" . $horas_a_dias . " días</td>
                  </tr>";
            }

            $tab_1 .= "  </tbody>
              </table>";
            echo $tab_1;
        } else {
            echo "No hay ticket´s fuera de plazo en esta categoria! ";
        }
    }
    public function tabla_parcial($datos_parcial)
    {
        if (isset($datos_parcial)) {
            $tab_1 = " <table class='table table-sm'>
            <thead>
            <tr>
            <th scope='col'>#</th>
            <th scope='col'>No. Ticket</th>
            <th scope='col'>Nombre empleado</th>
            <th scope='col'>Subadministración.</th>
            <th scope='col'>Departamento.</th>
            <th scope='col'>Fecha dev. parcial</th>
            <th scope='col'>Estatus</th>
            <th scope='col'>No. Días</th>
            </tr>
            </thead>
            <tbody>";
            $a = 1;
            //Se recorre un arreglo por todos los tickets encontrados fuera de plazo
            for ($i = 0; $i < count($datos_parcial); $i++) {
                $estatus = $datos_parcial[$i]['id_proc'];
                //Se valida el proceso en el que se encuentra el Ticket
                    //Se valida el proceso en el que se encuentra el Ticket
                    switch ($estatus) {
                        case 8:
                        $text = 'Préstamo';
                        $fecha = $datos_parcial[$i]['fecha_prest']->format('d/m/Y');
                        $horas_a_dias = intdiv(($datos_parcial[$i]['diferencia']-48), 24);
                        break;
                        case 9:
                        $text = 'Deolución parcial';
                        $fecha = $datos_parcial[$i]['fecha_recive_par']->format('d/m/Y');
                        $horas_a_dias = intdiv(($datos_parcial[$i]['diferencia']-48), 24);
                        break;
                        case 5:
                        $text = 'Peticion de devolución';
                        $fecha = $datos_parcial[$i]['fecha_pet_dev']->format('d/m/Y');
                        $horas_a_dias = intdiv(($datos_parcial[$i]['diferencia']-48), 24);
                        break;
                        case 7:
                        $text = 'Búsqueda';
                        $fecha = $datos_parcial[$i]['fecha_valida']->format('d/m/Y');
                        $horas_a_dias = intdiv(($datos_parcial[$i]['diferencia']-48), 24);
                        break;
                    }
                $tab_1 .= " 
                <tr>
                <th scope='row'>" . $a++ . "</th>
                <td>" . $datos_parcial[$i]['id_tiket'] . "</td>
                <td>" . $datos_parcial[$i]['nombre_empleado'] . "</td>
                <td>" . $datos_parcial[$i]['nombre_sub_admin'] . "</td>
                <td>" . $datos_parcial[$i]['nombre_depto'] . "</td>
                <td>" . $fecha . "</td>
                <td>" . $text . "</td>
                <td>" . $horas_a_dias . " días</td>
                </tr>";
            }

            $tab_1 .= "  </tbody>
            </table>";
            echo $tab_1;
        } else {
            echo "No hay ticket´s fuera de plazo en esta categoria! ";
        }
    }
}
