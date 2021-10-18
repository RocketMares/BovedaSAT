<?php

class Menu_Scroll
{
    public function Generar_menu_Scroll_Sub($id_admin)
    {
        include_once 'ConsultaComunicados.php';
        $consultas = new ConsultaComunicados();
        $nombres_subs = $consultas->Consulta_Local_Area($id_admin);
        $html[] = 0;
        $canvasid = "canvasArea";
        for ($i=0; $i < count($nombres_subs); $i++) { 
            $html[$i] = "<a class='nav-link ml-3 my-1 bg-dark' href='#canvasArea".$nombres_subs[$i]["id_sub_admin"]."'>".$nombres_subs[$i]["nombre_corto"]."</a>";
        }
        if ($html[0] != null) {
            return $html;
        }else{
            return "Problemas de conexión o posible falta de datos.";
        }
        
    }

    public function Generar_menu_Scroll_Sub_in($id_admin)
    {
        include_once 'ConsultaComunicados.php';
        $consultas = new ConsultaComunicados();
        $nombres_subs = $consultas->Consulta_Local_Area($id_admin);
        $html[] = 0;
        $canvasid = "#canvasArea_";
        for ($i=0; $i < count($nombres_subs); $i++) { 
            $html[$i] = "<a class='nav-link ml-3 my-1 bg-dark' href='$canvasid".$nombres_subs[$i]["id_sub_admin"]."'>".$nombres_subs[$i]["nombre_corto"]."</a>";
        }
        if ($html[0] != null) {
            return $html;
        }else{
            return "Problemas de conexión o posible falta de datos.";
        }
        
    }

    public function Generar_menu_Scroll_Sub_Ind($id_sub_admin)
    {
        include_once 'ConsultaComunicados.php';
        $consultas = new ConsultaComunicados();
        $nombres_subs = $consultas->Consulta_Local_Datos_Area($id_sub_admin);
        $canvasid = "#canvasArea";
            $html = "<a class='nav-link ml-3 my-1 bg-dark' href='$canvasid".$nombres_subs["id_sub_admin"]."'>".$nombres_subs["nombre_corto"]."</a>";
        if($nombres_subs != null){
            return $html;
        }else{
            return "Problemas de conexión o posible falta de datos.";
        }
        
    }


    public function Generar_menu_Scroll_Local($id_admin)
    {
        include_once 'ConsultaComunicados.php';
        $consultas = new ConsultaComunicados();
        $nombre_admin = $consultas->Consulta_LocalInfo($id_admin);
        $html[] = 0;
        $canvasid = "canvasLocal";
        for ($i=0; $i < count($nombre_admin); $i++) { 
            $html[$i] = "<a class='nav-link ml-3 my-1 bg-dark' href='#$canvasid$id_admin'>".$nombre_admin[$i]["nombre_corto"]."</a>";
        }
        if ($html[0] != null) {
            return $html;
        }else{
            return "Problemas de conexión o posible falta de datos.";
        }
        
    }
    public function Generar_sub($id_sub)
    {
        include_once("conexion.php");
        $conexion = new ConexionSQL();
        $con = $conexion->ObtenerConexionBD();
        $query = "SELECT * FROM SubAdmin WHERE (id_admin = $id_sub)
        AND  (nombre_sub_admin NOT IN (SELECT nombre_sub_admin FROM Administracion 
        WHERE nombre_sub_admin LIKE 'ADMIN%'))
        AND (ESTATUS = 'A')
        ORDER BY nombre_sub_admin ASC";
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            //SE DISPONE LA CONSULTA COMO UN ARREGLO
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = array('id_sub_admin' => $row["id_sub_admin"], 'nombre_sub_admin' => $row["nombre_sub_admin"], 'estatus' => $row["estatus"], 'nombre_corto' => $row["nombre_corto"]);
            }
            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
            sqlsrv_close($con);
        } else {
            return sqlsrv_errors();
            sqlsrv_close($con);
        }
    }

    public function Generar_Admin($id_admin)
    {
        include_once("conexion.php");
        $conexion = new ConexionSQL();// SE INSTANCIA LA CLASE CONEXIÓN
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE CREA UN QUERY
        $query = "SELECT * FROM Administracion WHERE id_admin = $id_admin AND ESTATUS = 'A'";
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);
        if ($prepare) {
            while ($rows = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = array(
                    'id_admin' => $rows["id_admin"], 'nombre_admin' => $rows["nombre_admin"], 'estatus' => $rows["estatus"],
                    'nombre_corto' => $rows["nombre_corto"]
                );
            }
            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
            sqlsrv_close($con);
        } else {
            return sqlsrv_errors();
            sqlsrv_close($con);
        }
    }
    
    public function Generar_deps($id_admin)
    {
        include_once("conexion.php");
        $conexion = new ConexionSQL();// SE INSTANCIA LA CLASE CONEXIÓN
        //SE CREA UN QUERY
        $query = "SELECT * FROM Departamento WHERE 
        (id_admin = $id_admin)
        AND (nombre_depto NOT IN (SELECT nombre_depto FROM Departamento 
        WHERE nombre_depto LIKE 'ADMIN%' OR nombre_depto LIKE 'SUB%')) AND ESTATUS='A'
        ORDER BY nombre_depto ASC ";
        //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
        $con = $conexion->ObtenerConexionBD();
        //SE VALIDA EL QUERY CON FORME A LA CONEXIÓN
        $prepare = sqlsrv_query($con, $query);

        if ($prepare) {
            //SE DISPONE LA CONSULTA COMO UN ARREGLO
            while ($row = sqlsrv_fetch_array($prepare, SQLSRV_FETCH_ASSOC)) {
                $filas[] = array('id_depto' => $row["id_depto"], 'nombre_depto' => $row["nombre_depto"], 'estatus' => $row["estatus"], 'nombre_corto' => $row["nombre_corto"]);
            }
            if (isset($filas)) {
                return $filas;
            } else {
                return null;
            }
            $conexion->CerrarConexion($con);
        } else {
            return sqlsrv_errors();
            $conexion->CerrarConexion($con);
        }
    }

    public function Generar_menu_Scroll_Local_in($id_admin)
    {
        include_once 'ConsultaComunicados.php';
        $consultas = new ConsultaComunicados();
        $nombre_admin = $consultas->Consulta_LocalInfo($id_admin);
        $html[] = 0;
        $canvasid = "canvasLocal_";
        for ($i=0; $i < count($nombre_admin); $i++) { 
            $html[$i] = "<a class='nav-link ml-3 my-1 bg-dark' href='#$canvasid$id_admin'>".$nombre_admin[$i]["nombre_corto"]."</a>";
        }
        if ($html[0] != null) {
            return $html;
        }else{
            return "Problemas de conexión o posible falta de datos.";
        }
        
    }

    public function  Generar_menu_Scroll_Deps($id_admin)
    {
        include_once 'ConsultaComunicados.php';
        $consultas = new ConsultaComunicados();
        $nombres_deps = $consultas->Consulta_Local_Area_Dep_Df($id_admin);
        $html[] = 0;
        $canvasid = "#canvasDeps";
        for ($i=0; $i < count($nombres_deps); $i++) { 
            $html[$i] = "<a class='nav-link ml-3 my-1 bg-dark' href='$canvasid".$nombres_deps[$i]["id_depto"]."'>".$nombres_deps[$i]["nombre_corto"]."</a>";
        }
        if ($html[0] != null) {
            return $html;
        }else{
            return "Problemas de conexión o posible falta de datos.";
        }
    }

    public function  Generar_menu_Scroll_Deps_in($id_admin)
    {
        include_once 'ConsultaComunicados.php';
        $consultas = new ConsultaComunicados();
        $nombres_deps = $consultas->Consulta_Local_Area_Dep_Df($id_admin);
        $html[] = 0;
        $canvasid = "#canvasDeps_";
        for ($i=0; $i < count($nombres_deps); $i++) { 
            $html[$i] = "<a class='nav-link ml-3 my-1 bg-dark' href='$canvasid".$nombres_deps[$i]["id_depto"]."'>".$nombres_deps[$i]["nombre_corto"]."</a>";
        }
        if ($html[0] != null) {
            return $html;
        }else{
            return "Problemas de conexión o posible falta de datos.";
        }
    }

    public function  Generar_menu_Scroll_Deps_Ind($id_dep)
    {
        include_once 'ConsultaComunicados.php';
        $consultas = new ConsultaComunicados();
        $nombres_deps = $consultas->Consulta_Local_Area_Dep_jf($id_dep);
        $html[] = 0;
        $canvasid = "#canvasDeps";
        for ($i=0; $i < count($nombres_deps); $i++) { 
            $html[$i] = "<a class='nav-link ml-3 my-1 bg-dark' href='$canvasid".$nombres_deps[$i]["id_depto"]."'>".$nombres_deps[$i]["nombre_corto"]."</a>";
        }
        if ($html[0] != null) {
            return $html;
        }else{
            return "Problemas de conexión o posible falta de datos.";
        }
    }

    public function  Generar_menu_Scroll_Deps_Por_Sub($id_sub_admin)
    {
        include_once 'ConsultaContribuyentes.php';
        $consultas = new ConsultaContribuyentes();
        $nombres_deps = $consultas->Consulta_sub_Dep($id_sub_admin);
        $html[] = 0;
        $canvasid = "#canvasDeps";
        for ($i=0; $i < count($nombres_deps); $i++) { 
            $html[$i] = "<a class='nav-link ml-3 my-1 bg-dark' href='$canvasid".$nombres_deps[$i]["id_depto"]."'>".$nombres_deps[$i]["nombre_corto"]."</a>";
        }
        if ($html[0] != null) {
            return $html;
        }else{
            return "Problemas de conexión o posible falta de datos.";
        }
    }




    

    public function LanzadorMenu_Scroll($id_perfil)
    {
                //  include_once 'ConsultaComunicados.php';
                include_once 'php/MetodosUsuarios.php';
                $user = new MetodosUsuarios();
                  //$comunicados = new ConsultaComunicados();
                  $obtener_info = $user->Consulta_User_Existe($_SESSION['ses_rfc_corto']);

                  switch($id_perfil){

                    case 6:
                      echo " <li class='nav-item bg-dark'>
                                Vistas por Administración";
                                $local = self::Generar_menu_Scroll_Local($obtener_info["id_admin"]);
                                for($i = 0; $i<count($local ); $i++){
                                  echo $local[$i];
                                }
                      echo "</li>";

                      echo "<li class='nav-item bg-dark'>
                              Vistas por Sub´s
                              <nav class='nav nav-pills flex-column'>";
                              $subs = self::Generar_menu_Scroll_Sub($obtener_info["id_sub_admin"]);
                              for($i = 0; $i<count($subs ); $i++){
                                echo $subs[$i];
                              }
                      echo "  </nav>
                            </li>";

                      echo "<li class='nav-item bg-dark'>
                            Vistas por Dep's
                              <nav class='nav nav-pills flex-column'>";
                              $deps =self::Generar_menu_Scroll_Deps($obtener_info["id_depto"]);
                              for($i = 0; $i<count($deps ); $i++){
                                echo $deps[$i];
                              }
                    echo "    </nav>
                            </li>";
                    break;
                              //Menu para administradores
                    case 2:

                    echo " <li class=nav-item bg-dark'>
                    Vistas por Local";
                    $local = self::Generar_menu_Scroll_Local($obtener_info["id_admin"]);
                    for($i = 0; $i<count($local ); $i++){
                      echo $local[$i];
                    }
                    echo "</li>";

                    echo "<li class='nav-item bg-dark'>
                            Vistas por Sub´s
                            <nav class='nav nav-pills flex-column'>";
                            $subs = self::Generar_menu_Scroll_Sub($obtener_info["id_sub_admin"]);
                            for($i = 0; $i<count($subs ); $i++){
                                echo $subs[$i];
                            }
                    echo "  </nav>
                            </li>";

                    echo "<li class='nav-item bg-dark'>
                            Vistas por Dep's
                            <nav class='nav nav-pills flex-column'>";
                            $deps =self::Generar_menu_Scroll_Deps($obtener_info["id_depto"]);
                            for($i = 0; $i<count($deps ); $i++){
                                echo $deps[$i];
                            }
                    echo "    </nav>
                            </li>";

                    break;
                              //Menu para subadministradores
                    case 4:
                       
                        echo "<li class='nav-item bg-dark'>
                                Vistas por Sub´s
                                <nav class='nav nav-pills flex-column'>";
                                $subs = self::Generar_menu_Scroll_Sub_Ind($obtener_info["id_sub_admin"]);
                                
                                 echo $subs;
                                
                        echo "  </nav>
                                </li>";

                        echo "<li class='nav-item bg-dark'>
                                Vistas por Dep's
                                <nav class='nav nav-pills flex-column'>";
                                $deps =self::Generar_menu_Scroll_Deps_Por_Sub($obtener_info["id_depto"]);
                                for($i = 0; $i<count($deps ); $i++){
                                    echo $deps[$i];
                                }
                        echo "    </nav>
                                </li>";

                    break;
                              //Menu para jefes de departamento
                    case 5:
                    echo "<li class='nav-item bg-dark'>
                                Vistas por Dep's
                                <nav class='nav nav-pills flex-column'>";
                                $deps =self::Generar_menu_Scroll_Deps_Ind($obtener_info["id_depto"]);
                                for($i = 0; $i<count($deps ); $i++){
                                    echo $deps[$i];
                                }
                    echo "    </nav>
                            </li>";
                    break;

        }
    }


    public function LanzadorMenu_Scroll_Vista_Por_Comunicado($id_perfil)
    {
                  include_once 'php/MantenimientoUsuarios.php';
                  $user = new MetodosUsuarios();
                  $obtener_info = $user->Cosulta_datos_usuario($_SESSION['ses_rfc']);

                  switch($id_perfil){

                    case 6:
                      echo " <li class=nav-item bg-dark'>
                                Vistas por Local";
                                $local = self::Generar_menu_Scroll_Local_in($obtener_info["id_admin"]);
                                for($i = 0; $i<count($local ); $i++){
                                  echo $local[$i];
                                }
                      echo "</li>";

                      echo "<li class='nav-item bg-dark'>
                              Vistas por Sub´s
                              <nav class='nav nav-pills flex-column'>";
                              $subs = self::Generar_menu_Scroll_Sub_in($obtener_info["id_sub_admin"]);
                              for($i = 0; $i<count($subs ); $i++){
                                echo $subs[$i];
                              }
                      echo "  </nav>
                            </li>";

                      echo "<li class='nav-item bg-dark'>
                            Vistas por Dep's
                              <nav class='nav nav-pills flex-column'>";
                              $deps =self::Generar_menu_Scroll_Deps_in($obtener_info["id_depto"]);
                              for($i = 0; $i<count($deps ); $i++){
                                echo $deps[$i];
                              }
                    echo "    </nav>
                            </li>";
                    break;
                              //Menu para administradores
                    case 2:

                    echo " <li class=nav-item bg-dark'>
                    Vistas por Local";
                    $local = self::Generar_menu_Scroll_Local($obtener_info["id_admin"]);
                    for($i = 0; $i<count($local ); $i++){
                      echo $local[$i];
                    }
                    echo "</li>";

                    echo "<li class='nav-item bg-dark'>
                            Vistas por Sub´s
                            <nav class='nav nav-pills flex-column'>";
                            $subs = self::Generar_menu_Scroll_Sub($obtener_info["id_sub_admin"]);
                            for($i = 0; $i<count($subs ); $i++){
                                echo $subs[$i];
                            }
                    echo "  </nav>
                            </li>";

                    echo "<li class='nav-item bg-dark'>
                            Vistas por Dep's
                            <nav class='nav nav-pills flex-column'>";
                            $deps =self::Generar_menu_Scroll_Deps($obtener_info["id_depto"]);
                            for($i = 0; $i<count($deps ); $i++){
                                echo $deps[$i];
                            }
                    echo "    </nav>
                            </li>";

                    break;
                              //Menu para subadministradores
                    case 4:
                       
                        echo "<li class='nav-item bg-dark'>
                                Vistas por Sub´s
                                <nav class='nav nav-pills flex-column'>";
                                $subs = self::Generar_menu_Scroll_Sub_Ind($obtener_info["id_sub_admin"]);
                                
                                 echo $subs;
                                
                        echo "  </nav>
                                </li>";

                        echo "<li class='nav-item bg-dark'>
                                Vistas por Dep's
                                <nav class='nav nav-pills flex-column'>";
                                $deps =self::Generar_menu_Scroll_Deps_Por_Sub($obtener_info["id_depto"]);
                                for($i = 0; $i<count($deps ); $i++){
                                    echo $deps[$i];
                                }
                        echo "    </nav>
                                </li>";

                    break;
                              //Menu para jefes de departamento
                    case 5:
                    echo "<li class='nav-item bg-dark'>
                                Vistas por Dep's
                                <nav class='nav nav-pills flex-column'>";
                                $deps =self::Generar_menu_Scroll_Deps_Ind($obtener_info["id_depto"]);
                                for($i = 0; $i<count($deps ); $i++){
                                    echo $deps[$i];
                                }
                    echo "    </nav>
                            </li>";
                    break;

        }
    }


}


?>