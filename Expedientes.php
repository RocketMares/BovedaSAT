<?php

include_once 'php/sesion.php';
include_once 'php/ConsultaContribuyentes.php';
//  $Metodos = new ConsultaContribuyentes();
//  $universo = $Metodos->universo_datos_expedientes();
//  $Determinantes_por_pagina = 100;
//  $paginas = $universo[0]['total']/$Determinantes_por_pagina;
//  $pag_act = $_GET['pagina'];
//  $paginas_num = ceil($paginas);
if (!$_GET ) {
    header('Location:Expedientes.php?pagina=1');
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img\LOGO11.ico">
    <title>Bóveda SAT</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/css/all.css">
    <script defer src="js/js/all.js"></script>
    <script src="js//jquery-3.1.1.js"></script>
    <!--otros--->
    <link rel="stylesheet" href="css/bootstrap-table.min.css">
    <script src="js/bootstrap-table.min.js"></script>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>

    <script type="text/javascript" src="js/jquery-1.6.min.js"></script>
    <script type="text/javascript" src="js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/renueva.js"></script>
    <link rel="stylesheet" href="css/toastr.min.css">
    <script src="js/filtros_expedientes.js"></script>
</head>

<?php
require_once 'php/menu_dinamico.php';
$menu = new Menu();
?>

<body>
    <?php
    $menu->Crear_menu();
    ?>
    <!-- maquetación de vista -->
    <!-- contenedor general -->
    <div class="mt-5 pt-5">
        <center>
            <h1 class="display-4">Visor de Expedientes</h1>

        </center>
    </div>
    <center>
        <button type="button" id="Monstrar" class="btn btn-info">Mostrar Filtros</button>
        <button type="button" id="Ocultar" style="display: none;" class="btn btn-primary">Ocultar Filtros</button>

        <div class="container-fluid" id="main">
            <center>

                <div id="filtros" style="display: none;" class="col-md-7 col-sm-12">

                    <p class="h5"> Filtros de busqueda.</p>
                    <div class="py-3 text-center flex-colun justify-content-center align-items-center">
                    <?php 
                    $id_perfil = $_SESSION['ses_id_perfil'];
                        if ($id_perfil == 1 || $id_perfil ==7 || $id_perfil == 8 ||  $id_perfil ==10 || $id_perfil ==9 || $id_perfil ==11 ){
                         echo"   <div class='col-sm-11'>
                            <label class='input-group-text' for='inputGroupSelect01'>Por Departamento:</label>

                        </div>
                        <select class='custom-select col-5' id='sub_admin'>
                            <option value='0' selected>Selecciona Subadmin</option>";
                            
                            include_once "php/MetodosUsuarios.php";
                            $metodo = new MetodosUsuarios();
                            $admin = $metodo->Consulta_Subadmin($_SESSION['ses_id_admin']);
                            for ($i=0; $i < count($admin) ; $i++) { 
                            echo" <option value='".$admin[$i]['id_sub_admin']."'>".$admin[$i]['nombre_sub_admin']."</option>";
                            }
                           echo"
                        </select>
                        <select class='custom-select col-5' id='depto'>
                            <option value='0' selected>Selecciona Departamento</option>

                        </select>

                        <button type='button' class='btn btn-outline-dark' id='filtra_estructura'>Buscar</button>";
                        }
                    ?>
                        
                  
                        <div class="row">
                            <div class="input-group col-md-12">
                                <div class="col-sm-3">
                                    <label class="input-group-text" for="inputGroupSelect01"> Num. determinante:</label>
                                </div>
                                <input type="text" class="form-control col-8" id="number_det"
                                    placeholder="Ejemplo: escrito_17852">
                                <button type="button" class="btn btn-outline-dark" id="filtra_num_det">Buscar </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group col-md-12">
                                <div class="col-sm-3">
                                    <label class="input-group-text" for="inputGroupSelect01">RFC:</label>
                                </div>

                                <input type="text" class="form-control col-8" id="Filtro_RFC"
                                    placeholder="Ejemplo: MASA95821" required>
                                <button type="button" class="btn btn-outline-dark" id="filtra_por_rfc">Buscar</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group col-md-12">
                                <div class="col-sm-4">
                                    <label class="input-group-text" for="inputGroupSelect01"> Razón social:</label>
                                </div>
                                <input type="text" class="form-control col-8" id="filtro_razon"
                                    placeholder="Ejemplo: Grupo Méxicano de Cable SA ">
                                <button type="button" class="btn btn-outline-dark" id="filtra_por_razon">Buscar</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-group col-md-12">
                                <div class="col-sm-4">
                                    <label class="input-group-text" for="inputGroupSelect01"> Estatus del
                                        credito:</label>

                                </div>
                                <select class="custom-select" id="estatus_cred" name="estatus_cred">
                                    <option value='0'>Seleccionar Opción</option>
                                    <option value='1'>Activo.</option>
                                    <option value='2'>Baja.</option>
                                </select>
                                <button type="button" class="btn btn-outline-dark"
                                    id="filtra_por_estatus_cred">Buscar</button>
                            </div>
                        </div>


                    </div>
                    <?php
                    $id_perfil = $_SESSION['ses_id_perfil'];
                    if ($id_perfil == 1 || $id_perfil ==7 || $id_perfil == 8 ||  $id_perfil ==10 || $id_perfil ==9 || $id_perfil ==11) {
                        echo"  <div class='row'>
                        <div class='input-group col-md-12'>
                            <div class='col-sm-4'>
                                <label class='input-group-text' for='inputGroupSelect01'>Empleado:</label>

                            </div>
                            <select class='custom-select' id='empleados' name='empleados'>";
                         
                        include_once 'php/MetodosUsuarios.php';
                        $consulta = new MetodosUsuarios();
                        $resultado = $consulta->Consulta_usuarios_con_cartera();
                        echo"<option value='0'>Seleccionar Opción</option>";
                        for ($i=0; $i < count($resultado) ; $i++) {
                            echo $opciones[$i]=" <option value='".$resultado[$i]['id_empleado']."'>".$resultado[$i]['nombre_empleado']."</option>";
                        }
            

                        echo"    </select>
                            <button type='button' class='btn btn-outline-dark' id='filtra_por_empleado'>Buscar</button>
                        </div>
                    </div>";
                    }
                    ?>





                </div>
                <?php
 if (isset($_GET['pagina'])) {
    echo "";
}
else {
    echo "<button type='submit' class='btn btn-primary' id='quita_filtro' >Quitar filtros</button>";
}
?>
            </center>
    </center>
    </div>
    <?php
                include_once 'php/ConsultaContribuyentes.php';
                include_once 'php/MetodosUsuarios.php';
                $consulta = new ConsultaContribuyentes();
                $mu = new MetodosUsuarios();
                $rows_sub = $consulta->Consulta_Sub($_SESSION["ses_id_admin"]);
                $rows_administracion = $consulta->Consulta_Local();
                ?>



    <div class="container-fluid">
        <div class='card'>
            <div class='card-header'>
                <div class="d-flex bd-highlight">
                    <div class="mr-auto p-2 bd-highlight">

                        <?php
                              $universo = $consulta->universo_datos_expedientes();
                              if (isset($universo)) {
                                $Determinantes=$universo[0]['total'];
                                $contador = $Determinantes;
                              }
                              else {
                                  $contador = 0;
                              }
                              

        echo "<p class='lead'>Listado de Expedientes ( ".$contador." ) </p>";

       
        ?>

                    </div>

                </div>
            </div>

            <div class="container-fluid" style="padding-top: 3rem !important;">
                <!-- Segundo elemento -->


                <div class="table-responsive-lg  ">
                    <?php
                    include_once 'php/vista_conf_expedientes.php';
                    $vista = new Vista_Expedientes();
                    $vista_general = $vista->Vista_General();


                    ?>

                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal_vistas_ob" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="display-9 mb-1"> DETALLE INTERACCIONES.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal aqui-->
                        <div class='form-inline my-2 my-lg-0 ml-auto'>
                            <section class='principal'>
                                <div id='datosObservaciones'></div>
                            </section>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="Modal_reasigna_cartera" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">REASIGNA CARTERA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <h1 class="display-6 text-center"> Cambio de analista encargado: </h1>
                <p class="text-center">Aquí podras modificar la cartera del analista.</p>
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th scope="col">
                                <p>Analista encargado: </p>
                            </th>
                            <th scope="col">
                                <p>Nuevo analista encargado: </p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php

                    echo"<select class='custom-select custom-select-sm' id='usuario_1_act'>
                    <option selected>Selecciona Usuario</option>";
                    include_once 'php/MetodosUsuarios.php';
                    $info_users = new MetodosUsuarios();
                    $users = $info_users->Consulta_usuarios();
                    for ($i=0; $i <= count($users) ; $i++) { 
                    echo " <option value='".$users[$i]['id_empleado']."'>".$users[$i]['nombre_empleado']."</option>";
                    }
                    echo" </select>";
                    ?>
                            </td>
                            <td>
                                <?php

                        echo"<select class='custom-select custom-select-sm' id='usuario_2_cam'>
                        <option selected>Selecciona Usuario</option>";
                        include_once 'php/MetodosUsuarios.php';
                        $info_users = new MetodosUsuarios();
                        $users = $info_users->Consulta_usuarios();
                        for ($i=0; $i <= count($users) ; $i++) { 
                        echo " <option value='".$users[$i]['id_empleado']."'>".$users[$i]['nombre_empleado']."</option>";
                        }
                        echo" </select>";
                       ?>
                            </td>

                        </tr>
                    </tbody>
                </table>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="Confima_cambio_cartera()">Guardar
                        cambios</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Confirma_accion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Confirmar solicitud</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Recuerde que está acción afectara la operación de los analistas involucrados</p><br>
                    <p>¿Desea continuar esta acción?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="Afecta_cambio_cartera()">Continuar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Modal_estatus_det_VISOR" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ESTATUS DETERMINANTE VISOR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    CAMBIA EL ESTATUS

                    <div id="selecciona_estatus_1"></div>
                </div>
                <section>


                </section>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    
        require_once 'php/ConsultaContribuyentes.php';
        $muestra = new ConsultaContribuyentes();
        //se instancian variables para los filtros
        $alertas = $muestra->alertasgenera();
        $alertas = $muestra->alertasdisponibles();
        $alertas = $muestra->alertasdisponibles_CANCELADOS();
        $alertas = $muestra->alertas_tickets_por_aprobar();
      
    ?>
    <div class="modal fade" id="Modal_detalle_tiket_dispo_cancel" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="display-9 mb-1"> DETALLE TICKET CANCELADO.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del modal aqui-->
                    <div class='form-inline my-2 my-lg-0 ml-auto'>
                        <section class='principal'>
                            <div id='datos_tiket_dispo_cancel'></div>
                        </section>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php 
                    $id_perfil = $_SESSION['ses_id_perfil'];
                    if($id_perfil == 8 || $id_perfil == 1){
                       echo" <button type='button' class='btn btn-block btn-success' data-toggle='modal' onclick='Tiket_cancelado_disponible_reac()'>
                       CONFIRMA EXPEDIENTES REACOMODADOS
                        </button>";
                    }
                    ?>
                    <button type="button" class="btn btn-primary " data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>

    <?php 
     $menu->Modal_notificacion_integracion();
    ?>
    <div class="modal fade" id="Modal_detalle_tiket_por_aprobar" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="display-9 mb-1"> DETALLE TICKET POR APROBAR.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Contenido del modal aqui-->
                    <div class='form-inline my-2 my-lg-0 ml-auto'>
                        <section class='principal'>
                            <div id='datos_tiket_por_aprob'></div>
                        </section>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php 
                    $id_perfil = $_SESSION['ses_id_perfil'];
                    if($id_perfil == 11 || $id_perfil == 1 || $id_perfil == 7 || $id_perfil == 5){
                       echo" <button type='button' class='btn btn-block btn-success' data-toggle='modal' onclick='Tiket_Aprueba_salida()'>
                       CONFIRMA SALIDA DE LOS EXPEDIENTES.
                        </button>";
                        echo" <button type='button' class='btn btn-block btn-success' data-toggle='modal' onclick='Tiket_niega_salida()'>
                       DENEGAR SALIDA DE EXPEDIENTES.
                        </button>";
                    }
                    ?>
                    <button type="button" class="btn btn-primary " data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
    // se imprime footer
    $menu->Footer();

    
    ?>
    <script type='text/javascript' src='js/toastr.min.js'></script>
    <script type="text/javascript" src="js/script_expedientes.js"></script>

</body>

</html>