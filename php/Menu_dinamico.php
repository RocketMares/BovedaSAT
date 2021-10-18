<?php

class Menu
{
  public static function ConsultaMenu($id_perfil, $id_padre)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
    //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Menu_app WHERE
        id_perfil = $id_perfil and id_padre = $id_padre
        and estatus = 'A'
         ORDER BY orden ASC";

    $rst = sqlsrv_query($con, $query);
    $filas[] = null;
    if ($rst) {
      while ($rows = sqlsrv_fetch_array($rst, SQLSRV_FETCH_ASSOC)) {
        $filas[] = array(
      'id_menu' => $rows['id_menu'],
      'id_padre' => $rows['id_padre'],
      'orden' => $rows['orden'],
      'nombre_menu' => $rows['nombre_menu'],
      'url_menu' => $rows['url_menu'],
      'estatus' => $rows['estatus'],
      'Funcion' => $rows['Funcion']
        );
      }
      return $filas;
      $conexion->CerrarConexion($con);
    }
  }
  public static function ConsultaMenu_Encabezados($id_perfil)
  {
    include_once 'conexion.php';
    $conexion = new ConexionSQL(); // SE INSTANCIA LA CLASE CONEXIÓN
    //SE MANDA A LLAMAR LA CONEXIÓN Y SE ABRE
    $con = $conexion->ObtenerConexionBD();
    $query = "SELECT * FROM Menu_app WHERE id_perfil = $id_perfil AND id_padre = 0
        AND estatus = 'A' ORDER BY orden ASC";

    $rst = sqlsrv_query($con, $query);
    if ($rst) {
      $filas[] = null;
      while ($rows = sqlsrv_fetch_array($rst, SQLSRV_FETCH_ASSOC)) {
        $filas[] = array(
          'id_menu' => $rows['id_menu'], 'id_padre' => $rows['id_padre'],
          'orden' => $rows['orden'], 'nombre_menu' => $rows['nombre_menu'], 'url_menu' => $rows['url_menu'],
          'estatus' => $rows['estatus'], 'Funcion' => $rows['Funcion']
        );
      }
      return $filas;
      $conexion->CerrarConexion($con);
    }
  }

  public function RenderMenu($id_perfil)
  {
    include_once 'sesion.php';
    $user = $_SESSION['ses_rfc_corto'];
    $menu = self::ConsultaMenu_Encabezados($id_perfil);
    $html[] = null;
    $posicion = 0;
    $html[$posicion] = "<ul class='navbar-nav mr-auto '>";
    for ($i = 1; $i < count($menu); $i++) {
      if ($menu[$i]["estatus"] == "A") {
          $posicion++;

          if ($menu[$i]['nombre_menu']== 'Integraciónes Pendientes') {
            $modal_activa = "Onclick='Muestra_integraciones_pendientes(\"$user\")'";
          }
          else {
            $modal_activa = "";
          }

        $html[$posicion] = "<li class='nav-item'><a class='nav-link-sat' style='color:white;' href='".$menu[$i]['url_menu']."' >".$menu[$i]['nombre_menu']."</a></li>";
        $submenu = self::ConsultaMenu($id_perfil, $menu[$i]["id_menu"]);
        if (count($submenu) - 1 != 0) {

          $html[$posicion] = "<li class='nav-item dropdown'><a class='nav-link-sat dropdown-toggle' style='color:white;'  role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' href='".$menu[$i]['url_menu']."'>".$menu[$i]['nombre_menu']."</a>
            <div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
          for ($j = 1; $j < count($submenu); $j++) {
            if ($submenu[$j]["estatus"] == "A") {
              $posicion++;

              $html[$posicion] = "<a class='dropdown-item-sat' href='" . $submenu[$j]['url_menu'] . "' onclick='" . $submenu[$j]['Funcion'] . "'>" . $submenu[$j]['nombre_menu'] . "</a>";
              $subopcion = self::ConsultaMenu($id_perfil, $submenu[$j]["id_menu"]);
              if (count($subopcion) - 1 != 0) {
                $posicion++;
                $html[$posicion] = "<div class='dropdown-divider'></div>";
                for ($m = 0; $m < count($subopcion); $m++) {
                  if ($subopcion[$m]["estatus"] == "A") {
                    $posicion++;
                    $html[$posicion] = "<a class='dropdown-item-sat' href='" . $subopcion[$m]['url_menu'] . "'onclick='" . $subopcion[$m]['Funcion'] . "'>" . $subopcion[$m]['nombre_menu'] . "</a>";
                  }
                }
                $posicion++;
                $html[$posicion] = "<div class='dropdown-divider'></div>";
              }
            }
          }
          $posicion++;
          $html[$posicion] = "</div>
            </li>";
        }
      }
    }
    $c = count($html);
    $html[$c] = "</ul>

    <script>


        $(document).ready(function(){
          $(\"#Ver_modal_reasig\").on('click',function(){
              $(\"#Modal_reasigna_cartera\").modal();
          })
      });
    </script>

    ";
    return $html;
  }

  public function Crear_menu()
  {
    include_once 'MetodosUsuarios.php';

    $consulta_user = new MetodosUsuarios();

    $nombre = $consulta_user->Consulta_nombre_user($_SESSION['ses_rfc_corto']);
    include_once 'ConsultaContribuyentes.php';
    $consulta_contr = new ConsultaContribuyentes();
    $dato_num = $consulta_contr->cuenta_integra();
    $num_carrito_integra = $dato_num[0]['total_carrito'];
    $num_FAC_CREA = $dato_num[0]['total_fac_creadas'];
    $num_integra_proc = $dato_num[0]['total_proc_entrega'];

    if ($num_carrito_integra <= 0) {
    $num1 = null;
    }
    else {
    $num1 = $num_carrito_integra;
    }
    if ($num_FAC_CREA <= 0) {
    $num2 = null;
    }
    else {
    $num2 = $num_FAC_CREA;
    }
    if ($num_integra_proc <= 0) {
    $num3 = null;
    }
    else {
    $num3 = $num_integra_proc;
    }

    //$Puesto = $consulta_user->Consulta_nombre_puesto($_SESSION['ses_rfc_corto']);
    // self::comentario();
    self::Carga_individuaL();
    //self::Carga_individuaL_pagos();
    self::Reasignacion();
    self::resbusqueda();
    self::DETALLE_RDFDA();
    $user = $_SESSION['ses_id_perfil'];
    echo "<nav class='navbar navbar-expand-lg  navbar-sat fixed-top' style='background-color:#781438;'>
             <a class='navbar-brand' style='color:white;' style='font-size:25px;' style='cursor:pointer;' id='verr'  href='index.php' ><img src='img\LOGO11.png' width='50' height='50' class=d-inline-block align-top alt=''> Bóveda </a>
              <button class='navbar-toggler' style='color:black;' type='button'  data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
              </button>
              <div class='collapse navbar-collapse'  id='navbarSupportedContent'>";
    $html = self::RenderMenu($_SESSION['ses_id_perfil']);
    for ($i = 0; $i < count($html); $i++) {
      echo $html[$i];
    }
    $user = $_SESSION['ses_rfc_corto'];
    echo "


                <div class='form-inline my-2 my-lg-0 ml-auto'>
                  <input class='form-control mr-sm-2' id='busquedas' type='search' placeholder='Contribuyentes' aria-label='Search'>
                  <button class='btn btn-light   my-2 my-sm-0' type='button' onclick='Buscar_contribuyente()' >Buscar</button>
                </div>
                <div class='form-inline my-2 my-lg-0 ml-auto'>
                <button type='button' id='notif' class='btn btn-outline-primary'onclick ='Muestra_integraciones_pendientes()'>
                <i class= 'fas fa-archive'></i> <span class='badge badge-danger 'id='notificaciones'  data-toggle='tooltip' data-placement='right' title='Carrito de integracion' >$num1</span>
               <i class= 'fas fa-archive'></i> <span class='badge badge-warning 'id='notificaciones'  data-toggle='tooltip' data-placement='right' title='Facturas generadas' >$num2</span>
              <i class= 'fas fa-archive'></i> <span class='badge badge-info 'id='notificaciones'  data-toggle='tooltip' data-placement='right' title='Facturas en proceso de entrega' >$num3</span>
                
               </button>
                </div>
                <ul class='navbar-nav ml-auto'>
                    <li class='nav-item dropdown'>
                      <a class='nav-link-sat dropdown-toggle'id='cerrar' style='color:white;' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                          $nombre
                      </a>
                      <div class='dropdown-menu'   aria-labelledby='cerrar'>
                      <a class='dropdown-item-sat'   href='#' id='CerrarSesion' >Cerrar sesión</a>
                      </div>
                    </li>
                </ul>
              </div>
            </nav>
            ";
  }

  public function Footer()
  {
    $arreglo_nombre = explode(" ", $_SESSION["ses_nombre"]); // SE COMVIERTE EN ARREGLO EL NOMBRE DELIMITADO POR ESPACIOS
    $nombre = $arreglo_nombre[0];  // SE CREA EL NOMBRE CONCATENADO CON LA PRIMERA LETRA DE LA POSICIÓN 1
    echo "
      <!-- Footer inicio -->

        <div class='w-100' style='padding: none;position:relative;'>
        <footer class='container-fluid py-5 bg-secondary text-white'  vh-100>
                <p class='float-right'><a class='text-white' href='http://99.85.26.227:8181/Comunicados/login.html'>Comunicados</a></p>
                <p>&copy; SAT. &middot; <a class='text-white' href='https://intrasat2.sat.gob.mx/'>Intrasat</a>&middot;</p>
                <footer class='blockquote-footer text-white'>DESARROLLADO POR: <cite title='Source Title'><br>
                ANDRÉS MARES SÁNCHEZ  (MASA955J1@dssat.sat.gob.mx) <BR>
                JOSÉ ALBERTO CRUZ CARDOSO (CUCA867R@dssat.sat.gob.mx)</cite></footer>
        </footer>
        </div>

        <!-- Footer fin -->

          </body>
          <script src='js/jquery-3.1.1.js'></script>
          <script src='js/popper.min.js'></script>
          <script src='js/bootstrap.js'></script>
          <script src='js/bootstrap.min.js'></script>
          <script src='js/responsive-calendar.js'></script>
          <script src='js/scripts_index.js'></script>
          <script src='js/scripts_menu_vertical.js'></script>
          <script type='text/javascript'>
            $(document).ready(function() {
              $(\"#CerrarSesion\").click(function (e) {
                e.preventDefault();
                alert('¡Vuelva pronto $nombre!')
                location.href=\"php/cerrar_sesion.php\";
                });
            });
            </script>";
  }
  public function Footer2()
  {
    // $arreglo_nombre = explode(" ", $_SESSION["ses_nombre"]); // SE COMVIERTE EN ARREGLO EL NOMBRE DELIMITADO POR ESPACIOS
    // $nombre = $arreglo_nombre[0];  // SE CREA EL NOMBRE CONCATENADO CON LA PRIMERA LETRA DE LA POSICIÓN 1
    echo "
      <!-- Footer inicio -->

        <div class='w-100 position-fixed' style='padding: none;position:relative;'>
        <footer class='container-fluid py-5 bg-secondary text-white '  >
                <p class='float-right'><a class='text-white' href='http://99.85.26.227:8181/Comunicados/login.html'>Comunicados</a></p>
                <p>&copy; SAT. &middot; <a class='text-white' href='https://intrasat2.sat.gob.mx/'>Intrasat</a>&middot;</p>
                <footer class='blockquote-footer text-white'>DESARROLLADO POR: <cite title='Source Title'><br>
                ANDRÉS MARES SÁNCHEZ  (MASA955J1@dssat.sat.gob.mx) <BR>
                JOSÉ ALBERTO CRUZ CARDOSO (CUCA867R@dssat.sat.gob.mx)</cite></footer>
        </footer>
        </div>

        <!-- Footer fin -->
        ";


  }
  public function Modal_notificacion_integracion(){
    // include_once 'sesion.php';
    $user =$_SESSION['ses_rfc_corto'];
  echo"  <div class='modal fade bd-example-modal-xl' id='Caja_integraciones' tabindex='-1' role='dialog'
    aria-labelledby='myExtraLargeModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-xl'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Detalles de integración</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <ul class='nav nav-pills mb-3' id='pills-tab' role='tablist'>
                    <li class='nav-item'>
                        <a class='nav-link active' id='pills-home-tab' data-toggle='pill' href='#pills-home'
                            role='tab' aria-controls='pills-home' aria-selected='true'
                            onclick ='Muestra_integraciones_pendientes(\"".$user."\")'>Vista
                            previa de la factura</a> </li> <li class='nav-item'>
                            <a class='nav-link' id='pills-profile-tab' data-toggle='pill' href='#pills-profile'
                                role='tab' aria-controls='pills-profile' aria-selected='false'
                               onclick ='Muestra_integraciones_generadas_pendientes_por_entregar(\"".$user."\")'>Facturas
                                generadas</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' id='pills-contact-tab' data-toggle='pill' href='#pills-contact'
                            role='tab' aria-controls='pills-contact' aria-selected='false'
                            onclick ='Muestra_integraciones_procesos_integracion(\"".$user."\")'>Facturas
                            entregadas</a>
                    </li>
                </ul>
                <div class='tab-content' id='pills-tabContent'>
                    <div class='tab-pane fade show active' id='pills-home' role='tabpanel'
                        aria-labelledby='pills-home-tab'>
                        <div class=' container ' id='contenido_inter'></div>
                    </div>
                    <div class='tab-pane fade' id='pills-profile' role='tabpanel'
                        aria-labelledby='pills-profile-tab'>
                        <div class=' container ' id='Vista_solicitudes_pendientes_por_entregar'></div>
                    </div>
                    <div class='tab-pane fade' id='pills-contact' role='tabpanel' id=''
                        aria-labelledby='pills-contact-tab'>
                        <div class=' container ' id='Vista_solicitudes_de_integracion_procesos'></div>
                    </div>
                </div>

            </div>
        </div>
    </div>";
  }
  public function Menu_deslizable_principales()
  {
    echo "<div id='mySidenav' class='sidenav lead'>
              <div class=' justify-content-end'>
              <a href='javascript:void(0)'  onclick='closeNav()'><i class='fas fa-times-circle'></i></a>
              </div>
              <a href='#'><i class='fas fa-angle-double-right'></i> Acceso directo a:</a>
              <ul>
                  <li><a href='#' onclick='Pendientes_entrevista()'><i class='fas fa-comments'></i> Pendientes de entrevista</a></li>
                  <li><a href='#' onclick='Entrevistas_plazos_10()'><i class='fas fa-grin-beam-sweat'></i> Plazos 10</a></li>
                  <li><a href='#' onclick='Entrevistas_plazos_30()'><i class='fas fa-frown'></i> Plazos 30</a></li>
                  <li><a href='#' onclick='Entrevistas_fuera_plazos()'><i class='fas fa-angry'></i> Fuera de plazos</a></li>
              </ul>
          </div>";
  }

  public function Menu_deslizable_secundario()
  {
    echo "<div id='mySidenav' class='sidenav lead'>
              <div class=' justify-content-end'>
              <a href='javascript:void(0)'  onclick='closeNav()'><i class='fas fa-times-circle'></i></a>
              </div>
              <a href='#'><i class='fas fa-angle-double-right'></i> Acceso directo a:</a>
              <ul>
                  <li><a href='#' onclick='Entrevistas_activas()'><i class='fas fa-comments'></i> Entrevistas activas</a></li>
                  <li><a href='#' onclick='Entrevistas_no_activas()'><i class='fas fa-comment-dots'></i> Entrevistas no activas</a></li>
              </ul>
            </div>";
  }
  public function Carga_individuaL()
  {
    echo "
        <div class='modal fade' id='Carga_contri' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true' style='overflow-y: scroll;'>
          <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Carga de Contribuyente.</h5>
                <button type='button' id='ventana' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                <ul>
                <li class='h5'>
                  <p>Registrar Contribuyente</p>
                </li>
                </ul>
                <div class='form-row'>
                  <div class='form-group col-md-4'>
                    <label for='RFC'>RFC :<samp class='text-danger'>*</samp></label>
                    <input type='text' class='form-control input-sm' id='RFC' name='RFC' placeholder='XXXX4548' maxlength='13'>
                  </div>
                  <div class='form-group col-md-4'>
                  <label for='RFC'>No. Oficio :<samp class='text-danger'>*</samp></label>
                  <input type='text' class='form-control input-sm' id='oficio' name='oficio' placeholder='' maxlength='20'>
                </div>
                  <div class='form-group col-md-4'>
                    <label for='Fecha_Prog'>Fecha Programada:<samp class='text-danger'>*</samp></label>
                    <input type='text' class='form-control' id='Fecha_Prog' name='Fecha_Prog' placeholder='dd/mm/yyy'>
                  </div>
                  <div class='form-group col-md-12'>
                    <label for='Razon_Social'>Razon Social :<samp class='text-danger'>*</samp></label>
                    <input type='text' class='form-control input-sm' id='Rason_Social' name='Razon_social' placeholder='NOMBRE´S S.A. de C.V.' maxlength='50'>
                  </div>
                  <div class='form-group col-md-4'>
                  <label for='Fecha_vig'>Fecha Vigencia:<samp class='text-danger'>*</samp></label>
                  <input type='text' class='form-control' id='Fecha_vig' name='Fecha_vig' placeholder='dd/mm/yyy'>
                </div>
                  <div class='form-group col-md-4'>
                    <label for='Prioridad'>Prioridad:<samp class='text-danger'>*</samp></label>
                    <select class='custom-select' id='Prioridad' name='Prioridad' >
                      <option value='0'>Seleccionar opción</option>
                      <option value='1'>NORMAL</option></option>
                      <option value='2'>URGENTE</option></option>
                      <option value='3'>EXTRAURGENTE</option></option>
                     </select>
                  </div>
                  <div class='form-group col-md-4'>
                  <label for='No_empleado'>No. Empleado :<samp class='text-danger'>*</samp></label>
                  <input type='text' class='form-control input-sm' id='no_empleado' name='No_empleado' placeholder='101822' maxlength='6'>
                </div>
                </div>

            </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                <button type='button' class='btn btn-outline-success' id='btn_confirmar1' onclick='confirmar_contri()'>Confirmar aplicación</button>
              </div>
            </div>
          </div>
        </div>

        <div class='modal fade' id='confirmar_contri' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h5 class='modal-title' id='exampleModalLabel'>Confirmar Carga de Contribuyente</h5>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                  </button>
                </div>
                <div class='modal-body'>
                  ¿Seguro que desea cargar al contribuyente?
                </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                  <button type='button' class='btn btn-outline-success' onclick='Caraga_individual_contri()'>Confirmar aplicación</button>
                </div>
              </div>
            </div>
          </div>

        ";
  }

  public function Reasignacion()
  {
    echo "


        <div class='modal fade-long' id='Reasigna_analista' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true' style='overflow-y: scroll;'>
          <div class='modal-dialog modal-dialog-centered modal-lg' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Reasignacion de Entrevista</h5>
                <button type='button' id='ventana' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>

                <div class='row'>
                  <div class='col-md-4'>
                    <label for='entrevista'>No. Entrevista :<samp class='text-danger'>*</samp></label>
                    <input type='number' class='form-control input-sm' id='Entrevista' name='entrevista' placeholder='No.Entrevista' maxlength='13'>
                </div>
                <div class='col-md-8 ml-auto'>
                  <div id='res'></div>
                  </div>
                </div>

                <div class='row'>
                  <div class='col-md-4'>
                    <label for='N_analista'>Nuevo Analista :<samp class='text-danger'>*</samp></label>
                    <input type='number' class='form-control input-sm' id='Analista' name='Analista' placeholder='No.Empleado' maxlength='13'>
                </div>
                <div class='col-md-8 ml-auto'>
                  <div id='res2'></div>
                  </div>
                </div>
              </div>
              <div id='result'>

              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                <button type='button' class='btn btn-outline-success' id='btn_confirmar' onclick='confirmar_reasignacion()'>Confirmar Reasignacion</button>
              </div>
            </div>
          </div>
        </div>
        </div>

        <div class='modal fade' id='confirmar_reasignacion' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h5 class='modal-title' id='exampleModalLabel'>Confirmar reasignacion</h5>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                  </button>
                </div>
                <div class='modal-body'>
                  ¿Seguro que desea confirmar la reasignacion?
                </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                  <button type='button' class='btn btn-outline-success' onclick='reasignar()'>Confirmar Reasignacion</button>
                </div>
              </div>
            </div>
          </div>

        ";
  }
  public function resbusqueda(){
    echo "<div class='modal fade' id='Modal_res_busqueda_general' tabindex='-1' role='dialog'>
    <div class='modal-dialog modal-dialog-scrollable modal-xl' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='display-9 mb-1'> RESULTADOS DE BÚSQUEDA</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <!-- Contenido del modal aqui-->
                <div class='form-inline my-2 my-lg-0 ml-auto'>
                    <section class='principal'>
                        <div id='datosBusRes'></div>
                    </section>
                </div>
            </div>
            <div class='modal-footer'>

             <button type='button' class='btn btn-primary' data-dismiss='modal'>Cerrar</button>

            </div>
        </div>
    </div>
</div>
";
  }



  public function DETALLE_RDFDA(){
    echo "<div class='modal fade' id='Modal_detalle_RDFDA' tabindex='-1' role='dialog'>
    <div class='modal-dialog modal-dialog-scrollable modal-lg' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='display-9 mb-1'>DETALLE DE DETERMINANTE</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <!-- Contenido del modal aqui-->
                <div class='form-inline my-2 my-lg-0 ml-auto'>
                    <section class='principal'>
                        <div id='datosdetalleRDFDA'></div>
                    </section>
                </div>
            </div>
            <div class='modal-footer'>

             <button type='button' class='btn btn-primary' data-dismiss='modal'>Cerrar</button>

            </div>
        </div>
    </div>
</div>
";
  }
}
