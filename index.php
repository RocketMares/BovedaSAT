<?php

include_once 'php/sesion.php';

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
    <link rel="stylesheet" href="css/toastr.min.css">
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

    <script language="javascript" type="text/javascript">
        function seleccionar_todo() {
            for (i = 0; i < document.form.elements.length; i++)
                if (document.form.elements[i].type == "checkbox")
                    document.form.elements[i].checked = 1
        }

        function ControlNum() {
            var tecla = window.event.keyCode;
            if (tecla < 48 || tecla > 57) {
                window.event.returnValue = false;
            } else {
                window.event.returnValue = true;
            }
        }
    </script>

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
    <div class="container-fluid" style="padding-top: 3rem !important;">
        <div>
            <div class="container col-md-10 " id="main" style="padding-top: 3rem !important;">
                <?php
            $id_perfil = $_SESSION['ses_id_perfil'];
            $us = $_SESSION['ses_rfc_corto'];
            // if ($id_perfil==1 || $id_perfil == 8 ) { // CUANDO SE TERMINE EL MODULO SE DESCOMENTA ESTA LINEA
                if ($id_perfil==1  ) {   // POR EL MOMENTO, SE REALIZAN PRUBEAS AUN
                echo" <button type='button' class='btn btn-primary' data-toggle='modal' onclick='Invoca_Modulo_barras()' data-backdrop='static'>
                <img src='img/índice.jpg' width='30' height='30'
                class='d-inline-block align-top' alt=''> Código de barras.
                </button>";
            }
            
    ?>


                <!-- VISTAS GENERALES PARA VISUALIZAR TICKETS DE PRESTAMOS  -->

                <div class="container text-center py-2">
                    <h1 class="display-4 mb-2">Sistema de Bóveda SAT</h1>
                </div>
                <?php
              ?>
                <div class="container-fluid">
                    <?php
                include_once 'php/Creando_vistas.php';
                $vistas = new Vistas_de_Usuarios();
                $vistas->vistaGeneral();

                ?>

                </div>
            </div>
        </div>

        <!--MODAL NUEVA PETICION-->

        <div class="modal fade" id="Modal_form_peticion" tabindex="-1" role="dialog" data-backdrop="static">
            <div class="modal-dialog modal-dialog-scrollable modal-xl   " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="display-9 mb-1"> BÚSQUEDA DE EXPEDIENTES.</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal aqui-->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <?php
                              $us = $_SESSION['ses_rfc_corto'];
                               echo "<a class='nav-link' id='profile-tab' data-toggle='tab' href='#profile' role='tab'
                                    aria-controls='profile' aria-selected='false'
                                    onclick='revisa_peticiones_agregadas(\"".$us."\")'>Carrito de peticiones
                                    <i type='button' class='fas fa-cart-plus'></i></a>";
                            ?>
                            </li>
                        </ul>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <div class='form-inline my-2 my-lg-0 ml-auto'>
                                        <section class='principal'>


                                            <div class='form'>
                                                <div class="form-group col-md-6">
                                                    <label for="Buscar">BUSCAR: <samp
                                                            class="text-danger">*</samp></label>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input class="form-control mr-sm-2 letras" type='text'
                                                        name='caja_busqueda' id='caja_busqueda'
                                                        onkeyup="javascript:this.value=this.value.toUpperCase();"></input>
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="manda_busqueda()">Buscar</button>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <small>Puedes buscar por RFC, Razón Social o Determinante.</small>
                                                </div>
                                                <!-- <button type="button" class="btn btn-primary btn-block" id="buscar_docs">Buscar</button> -->
                                            </div>

                                            <div id='datos'>

                                        </section>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <!-- Carrito de peticiones -->
                                <h1 class="display-6">Carrito de peticiones.</h1>
                                <div class='form-inline my-2 my-lg-0 ml-auto'>
                                    <section class='principal'>
                                        <div id='datos_del_carrito'></div>


                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="agregar" class="btn btn-block btn-primary">Agregar</button>
                        <?php
                        $perfil = $_SESSION['ses_id_perfil'];
                        if ($perfil == 1 || $perfil == 10 || $perfil == 12 || $perfil == 9 ) {
                            echo "<button type='button' id='pedir1' class='btn btn-block btn-primary'>Pedir</button>";
                        }
                        else {
                            echo "<button type='button' id='pedir2' class='btn btn-block btn-primary'>Pedir</button>";
                        }
                        ?>
                        <button type="button" id="cancela" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--MODAL DETALLE-->
        <div class="modal fade" id="Modal_detalle_tiket_pet" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="display-9 mb-1"> DETALLE TICKET.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal aqui-->
                        <div class='form-inline my-2 my-lg-0 ml-auto'>
                            <section class='principal'>
                                <div id='datostiket'></div>
                            </section>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?php
                $id_perfil = $_SESSION['ses_id_perfil'];
                if ($id_perfil==1 || $id_perfil == 8 ) {
                  echo"  <button type='submit' class='btn btn-success' data-dismiss='modal' onclick='Confirm_disponible_tik()' >Expediente Listo</button>";
                  
                  echo"  <button type='submit' class='btn btn-info' data-dismiss='modal' onclick='Confirm_prest_tik()' >Entregar Prestamo</button>";
                }
                echo"  <button type='submit' class='btn btn-danger' data-dismiss='modal' onclick='Confirm_cancel_tik()' >Cancelar Ticket</button>";
                ?>

                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="LECTOR_BARRAS" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Código de barras</h5>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="num_ticket_code_bar"
                            placeholder='Usé el lector o digita el código' onkeypress='return numero(event)'>

                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <nav class="navbar navbar-dark ">
                                            <a class="navbar-brand text-dark">
                                                <img src="img/LOGO11.ico" width="30" height="30"
                                                    class="d-inline-block align-top" alt="">
                                                Vista previa:
                                            </a>
                                        </nav>
                                    </th>
                                    <th scope="col">
                                        <nav class="navbar ">
                                            <a class="navbar-brand text-dark">
                                                <img src="img/documentoPrestado.jpg" width="30" height="30"
                                                    class="d-inline-block align-top" alt="">
                                                Determinantes seleccionadas:
                                            </a>
                                        </nav>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>
                                        <div class=' my-2 my-lg-0 ml-auto'>
                                            <section class='principal'>
                                                <div id='datos_ticket_codebar'></div>
                                            </section>
                                        </div>
                                    </th>
                                    <td>
                                        <div class='my-2 my-lg-0 ml-auto '>

                                            <section class='principal'>
                                                <div id='Historial_mov_del_dia_x_user'></div>

                                            </section>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <br>
                        <!-- <nav class="navbar " style="background-color:#378a57;"> -->

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancela_selec"
                            data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger" id="limpia_select">Limpiar selección</button>
                        <button type="button" class="btn btn-dark" id="Agrega_proc_prev">Agregar selección</button>
                        <button type="button" class="btn btn-success" id="reiniciar">Registrar Movimiento</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="CancelaTiket" tabindex="-1" aria-labelledby="CancelaTiket" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirma</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Seguro de continuar con la baja de esta solicitud?</p>

                        <?php
                     $id_perfil = $_SESSION['ses_id_perfil'];
                        if($id_perfil == 1 || $id_perfil == 8){
                            echo" <select class='custom-select' id='motiv_cancel'>
                            <option value  ='0' selected>Motivo</option>
                            <option value='1'>Peticion por parte del analista</option>
                            <option value='2'>No cuenta con ninguna determinante con registro en bóveda</option>
                            <option value='3'>Peticion de encargado de bóveda</option>
                        </select>";
                        }
                        else {
                            echo" <select class='custom-select' id='motiv_cancel'>
                            <option value='0' selected>Motivo</option>
                            <option value='4'>Ya no es necesario</option>
                            <option value='5'>Error en la peticion de ticket</option>
                        </select>";
                        }
                     

                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" onclick="Tiket_cancelado()">Continuar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="PrestaTicket" tabindex="-1" aria-labelledby="CancelaTiket" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirma</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Confirma prestamo?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success" onclick="Tiket_prest()">Continuar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="DISPONIBLETicket" tabindex="-1" aria-labelledby="CancelaTiket" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirma</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Confirma que ya tiene todos los expedientes encontrados de este ticket?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success" onclick="Tiket_disponible()">Continuar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal_detalle_tiket_prestamo" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="display-9 mb-1"> DETALLE TICKET PRESTAMOS.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal aqui-->
                        <div class='form-inline my-2 my-lg-0 ml-auto'>
                            <section class='principal'>
                                <div id='datostiketprestamo'></div>
                            </section>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?php 
                    $id_perfil = $_SESSION['ses_id_perfil'];
                    if ($id_perfil != 8 && $id_perfil != 7 ) {
                       echo "<button type='button' onclick='Confirm_dev_tik()' class='btn btn-block btn-primary'>Entregar</button>";
                      // echo "<button type='button' class='btn btn-success' id='Entrega_prestamo_interno' name='Entrega_prestamo_interno'>Entregar prestamo interno en Boveda</button>";
                    }
                    
                    if($id_perfil == 8 || $id_perfil == 1){
                       echo" <button type='button' class='btn btn-block btn-success' data-toggle='modal' data-target='#exampleModal'>
                           Entrega de présmtao interno
                        </button>";
                    }
                    ?>
                        <button type="button" class="btn btn-primary " data-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Prestamo Interno -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirma Entrega de Ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que desea entregar el ticket de prestamo interno en Boveda?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="Tiket_dev_inter()">Entrega Prestamo
                            interno</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal_pet_dev_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirma</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que desea entregar los documentos de este prestamo?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="Tiket_dev_pet()">Continuar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-xl" id="Modal_detalle_tiket_dev" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="display-9 mb-1"> DETALLE TICKET DEVUELTO.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal aqui-->
                        <div class='form-inline my-2 my-lg-0 ml-auto'>
                            <section class='principal'>
                                <div id='datostiketdev'></div>
                            </section>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?php
                    include_once "php/ConsultaContribuyentes.php";
                    include_once 'php/sesion.php';
                    $metodos = new ConsultaContribuyentes();
                    $id_perfil = $_SESSION['ses_id_perfil'];
                    $ticket = $_SESSION['tiket_estatus'];
                    $estatus_tik = $metodos->Consulta_estatus_act_ticket($ticket);
                    if ($id_perfil == 8  || $id_perfil== 1 ) {

                            echo "<button type='button' id='Entrega_boveda_Parcial' class='btn-block btn btn-success'>Entregar</button>";
                        
                    }
                    ?>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>
        <div class='modal' id='Modal_Comentario' tabindex='-1' role='dialog'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title'>AGREGAR OBSERVACIÓN</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='formulario form-inline'>
                        <div class="form-group form-inline col-md-12">
                            <label for="Buscar">BUSCAR: <samp class="text-danger">*</samp></label>
                            <div class='formulario form-inline'>
                                <?php
                                            include_once 'php/conexion.php';
                                            $conexion = new ConexionSQL();
                                            $con = $conexion->ObtenerConexionBD();
                                            $query="select*from Descripciones";
                                            $resultado = sqlsrv_query($con, $query);

                                            echo "<datalist id='colores'>";
                                            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                            echo " <option value='".$fila['Descripcion']."'></option>";
                                            }
                                            echo " </datalist>
                                            <input id='Des' list='colores' name='colores' type='text'>
                                            "; 
                                        ?>
                            </div>
                        </div>
                    </div>
                    <div class='modal-body'>
                        <div class='form-row'>
                            <div class='form-group col-md-6'>
                                <label for='Observacion'>Observación</label>
                                <textarea id='Observacion' cols='50' rows='5' style='resize: both;'></textarea>
                            </div>
                        </div>
                    </div>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-primary' onclick='valida_Observacion()'>Guardar</button>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class='modal fade' id='Modal_Comentario_dev' tabindex='-1' role='dialog'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title'>AGREGAR OBSERVACIÓN DEV.</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='formulario form-inline'>
                        <div class="form-group form-inline col-md-12">
                            <label for="Buscar">BUSCAR: <samp class="text-danger">*</samp></label>
                            <div class='formulario form-inline'>
                                <?php
                                include_once 'php/conexion.php';
                                $conexion = new ConexionSQL();
                                $con = $conexion->ObtenerConexionBD();
                                $query="select*from Descripciones";
                                $resultado = sqlsrv_query($con, $query);

                                echo "<datalist id='colores'>";
                                while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                                echo " <option value='".$fila['Descripcion']."'></option>";
                                }
                                echo " </datalist>
                                <input id='Des_dev' list='colores' name='colores' type='text'>
                                "; 
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class='modal-body'>
                        <div class='form-row'>
                            <div class='form-group col-md-6'>
                                <label for='Observacion'>Observación</label>
                                <textarea id='Observacion_dev' cols='50' rows='5' style='resize: both;'></textarea>
                            </div>
                        </div>
                    </div>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-primary'
                            onclick='valida_Observacion_dev()'>Guardar</button>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="Modal_vistas_ob" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="display-9 mb-1"> DETALLE OBSERVACIONES.</h5>
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
        <div class="modal fade bd-example-modal-lg" id="integra_docs2" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="background-color:#bdc3c7 ;">
                    <div class="modal-header">
                        <h5 class="display-9 mb-1 text-dark"> INTEGRACIONES.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal aqui-->

                        <section class='principal'>
                            <div id='formulario_integracion'></div>


                        </section>

                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" id="Modal_vistas_ob_dev" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="display-9 mb-1"> DETALLE OBSERVACIONES.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal aqui-->
                        <div class='form-inline my-2 my-lg-0 ml-auto'>
                            <section class='principal'>
                                <div id='datosObservaciones1'></div>
                            </section>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="Modal_estatus_det" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">ESTATUS DETERMINANTE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        CAMBIA EL ESTATUS

                        <div id="selecciona_estatus"></div>
                    </div>
                    <section>


                    </section>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal_fojas_det" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">FOJAS POR DETERMINANTE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">


                        <div id="selecciona_fojas"></div>
                    </div>
                    <section>


                    </section>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
                        $users = $info_users->Consulta_usuarios_2();
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
        <div class="modal fade" id="Confirma_accion" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        <button type="button" class="btn btn-success"
                            onclick="Afecta_cambio_cartera()">Continuar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg" id="modal_reasinga_tiket" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">REASIGNA TICKET.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <H1 class="text-center"> ACTUALIZA PROPIETARIO </H1>


                    </div>
                    <section>
                        <div id="tabla_contenido_cambio_ticket"></div>

                    </section>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success"
                            onclick="Confima_cambio_propietario_ticket()">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Confirma_cambio_propietario_ticket" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">CONFIRMA CAMBIO.</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro de continuar esta acción?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success"
                            onclick="Afecta_cambio_propietario_ticket()">Continuar</button>
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
        $alertas = $muestra->alertas_tickets_cancelados();
      
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
                        echo" <button type='button' class='btn btn-block btn-danger' data-toggle='modal' onclick='Tiket_niega_salida()'>
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
        <div class="modal fade" id="Modal_detalle_tiket_cancelado_por_notif" tabindex="-1" role="dialog">
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
                                <div id='datos_tiket_cancelado_notf'></div>
                            </section>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?php 
                    $id_perfil = $_SESSION['ses_id_perfil'];
                    if($id_perfil == 11 || $id_perfil == 1 || $id_perfil == 7 || $id_perfil == 5){
                        
                       echo" <button type='button' class='btn btn-block btn-success' data-toggle='modal' onclick='Tiket_cancelado_notif()'>
                       NOTIFICADO.
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
    if(isset($_GET["Integracion"])){
        switch($_GET["Integracion"]){
          case 1: 
          echo "<script>
            alert('Se cargo exitosamente el documento.')
          </script>";
          break;
    
          case 2: 
          echo "<script>
            alert('No se pudo cargar el documento, el documento debe pesar igual o menos de 10 MB.')
          </script>";
          break;
    
          case 3: 
          echo "<script>
            alert('El archivo no se encuentra dentro de las extenciones aceptables. (xlsx,pdf,doc,zip)')
          </script>";
          break;
    
          case 4: 
          echo "<script>
            alert('No se selecciono un docuemto')
          </script>";
          break;
          case 5: 
            echo "<script>
              alert('No se cargo la Integracion')
            </script>";
            break;
    
        }
      }
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////                                                              /
////////                       //////////////////////////////                                                              /
////////        ///            //////////////////////////////                                                              /
////////      ///////         ///////////////////////////////                                                              /  
////////       //////        ////////////////////////////////                                                              /
////////         ///      ///////////////////////////////////                                                              /
////////               //////////////////////////////////////                                                              /
////////         //        //////////////////////////////////                                                              /
////////        ////         ////////////////////////////////                                                              /
////////        /////          //////////////////////////////                                                              /
////////        //////          /////////////////////////////                                                              /
////////        ///////           ///////////////////////////                                                              /
/////////////////////////////////////////////////////////////                                                              /
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/                                                           ////////////////////////////////////////////////////////////////
/                                                           ///////              //////////////////              ///////////
/                                                           ///////               ///////////////                ///////////
/                                                           ///////                ////////////                  ///////////
/                                                           ///////       /         /////////         /          ///////////
/                                                           ///////       ///        //////          //          ///////////
/                                                           ///////       ////        ///          ////          ///////////
/                                                           ///////       /////                   /////          ///////////
/                                                           ///////       //////                 //////          ///////////
/                                                           ///////       ///////               ///////          ///////////
/                                                           ///////       ////////             ////////          ///////////
/                                                           ///////       //////////          /////////          ///////////
/                                                           ////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
    ?>

    <script type='text/javascript' src='js/toastr.min.js'></script>


</html>