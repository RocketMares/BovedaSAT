<?php

include_once 'php/sesion.php';

if (isset($_SESSION["ses_cambio_pass"])) {
    echo "<script>
    location.href='Cambio_pass.php';
    </script>";
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img\LOGO11.ico">
    <title>Bóveda SAT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/css/all.css">
    <script defer src="js/js/all.js"></script>

    <script type="text/javascript" src="js/jquery-1.6.min.js"></script>
    <script type="text/javascript" src="js/jquery.easyui.min.js"></script>
    <SCRIPT Language=Javascript SRC="js/scripts_index.js"></SCRIPT>
    <link rel="stylesheet" href="css/toastr.min.css">
    <!-- <script type="text/javascript" src="js/renueva.js"></script> -->
</head>

<body>

    <?php
        require_once 'php/menu_dinamico.php';
        $menu = new Menu();
        $menu->Crear_menu();
    
        ?>
    <!-- maquetación de vista -->

    <!-- contenedor general -->
    <div class="container-fluid" style="padding-top: 3rem !important;">

        <!-- primer elemento -->
        <?php
            $menu->Menu_deslizable_principales();
            ?>
        <!-- fin primer elemento -->

        <!-- Segundo elemento -->
        <div class="container col-md-10 text-center center-block" id="main">

            <div class="container text-center py-2">
                <h1 class="display-4 mb-2">Carga masiva de Determinantes</h1>
            </div>
            <div class="row container-fluid vh-50 mt-5 my-5">

                <div class=" row container" id="muestra_cargas">



                    <div class='row'>
                        <div class='card' style='width: 18rem;'>
                            <img src='img/04.png' class='card-img-top' alt='...'>
                            <div class='card-body'>
                                <h5 class='card-title'>Realizar carga RFC nuevos de: Vista Cargas_diarias</h5>
                                <a href='#' class='btn btn-primary' id='cargas_diarias'>Realiza carga</a>
                            </div>
                        </div>
                    </div>
                    <div class='card' style='width: 18rem;'>
                        <img src='img/documentoPrestado.jpg' class='card-img-top' alt='...'>
                        <div class='card-body'>
                            <h5 class='card-title'>Realizar carga expedientes nuevos de: Vista Cargas_diarias</h5>
                            <a href='#' class='btn btn-primary' id='carga_expedientes'>Realiza carga</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class='row '>
                <div class='card' style='width: 18rem;'>
                    <img src='img/04.png' class='card-img-top' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>Realizar carga RFC nuevos de: Vista Cargas_masiva</h5>
                        <a href='#' class='btn btn-primary' id='cargas_masiv'>Realiza carga</a>
                    </div>
                </div>
          
            <div class='card' style='width: 18rem;'>
                <img src='img/documentoPrestado.jpg' class='card-img-top' alt='...'>
                <div class='card-body'>
                    <h5 class='card-title'>Realizar carga expedientes nuevos de: Vista Cargas_masiva</h5>
                    <a href='#' class='btn btn-primary' id='carga_expedientes_masiv'>Realiza carga</a>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- <div class="d-flex justify-content-center align-items-center " >

                <?php

                if (isset($_GET["resultado"])) {
                    switch ($_GET["resultado"]) {
                        case 1:
                        $class_form = "";
                        $class_mensaje = "valid-feedback";
                        $mensaje_error = "Archivo permitido.";
                        $input = "is-valid";
                        break;

                        case 2:
                            $class_form = "was-validated vh-100";
                            $class_mensaje = "invalid-feedback";
                            $mensaje_error = "No se selecciono ningun archivo, favor de selecionarlo.";
                        break;

                        case 3:
                        $class_form = "was-validated vh-100";
                        $class_mensaje = "invalid-feedback";
                        $mensaje_error = "Debe de elegir un archivo de excel con extensión <strong>\".xlsx\"</strong>.";
                        break;

                        case 4:
                            $class_form = "was-validated vh-100";
                            $class_mensaje = "invalid-feedback";
                            $mensaje_error = "El archivo es demasiado pesado para cargarse, debe de pesar menos de 1000 MB.";
                        break;
                        default:
                        
                    }
                }

                ?>

                    <div class="container text-center  mt-2 my-2">
                        <form class="<?php echo (isset($class_form)) ? $class_form : 'vh-100'; ?>" action="php/valida_carga_Det.php" enctype="multipart/form-data"  method="post">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="archivito" name ="archivito" required>
                                <label class="custom-file-label <?php echo (isset($input)) ? $input : ''?>" for="archivo_cont">Seleccionar archivo de carga masiva. (xlsx).</label>
                                <div class="<?php echo (isset($class_mensaje)) ? $class_mensaje : ''; ?>"><?php echo (isset($mensaje_error)) ? $mensaje_error : ''; ?></div>
                                <a type="submit" class="btn btn-dark text-white"  href="formatos/Carga_M_Determinantes.xlsx" download="Formato.xlsx">Descarga formato de carga de determinantes.</a> 
                            
                            </div>
                           <br>
                            <button class="btn btn-dark btn_sat_black text-white btn-lg" type="submit">Cargar archivo.</button>
                        </form>

                        <div class="container" id="resultado">

                            <?php
                            //  if (isset($_GET["resultado"])) {
                            //      switch ($_GET["resultado"]) {
                            //        case 1:
                            //         include_once 'php/ConsultaContribuyentes.php';
                            //         $contribuyentes = new ConsultaContribuyentes();
                            //         $contribuyentes->Leer_archivo_Det();
                            //        break;
                            //     }
                            //  }

                            ?>

                        </div>

              
                    </div>



                </div>


            </div> -->


    </div>
    </div>
    <?php 
     $menu->Modal_notificacion_integracion();
    ?>

    <div class="modal fade" id="resultado_carga" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Carga masiva.</h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="renovar()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="texto_result">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="renovar()"
                        data-dismiss="modal">Aceptar</button>
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
    <script type='text/javascript' src='js/toastr.min.js'></script>
    <?php
        //Footer
        $menu->Footer();
      ?>

</html>
