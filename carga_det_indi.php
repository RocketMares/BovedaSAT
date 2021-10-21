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
</head>

<?php
require_once 'php/menu_dinamico.php';
$menu = new Menu();
?>

<body>
    <?php
    $menu->Crear_menu();
    ?>


    <div class="container mt-5 pt-5">
        <center>
            <h1 class="display-4">Registro de determinante</h1>
        </center>
    </div>
    <div class="container pt-4 my-4">
        <!-- <H1 class="display-4">Registro de Determinante: </H1> -->
        <form>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationServer01">Número determinante:</label>
                    <input type="text" class="form-control " id="Num_det" placeholder="Núm. determinante" required>

                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationServer02">ID Resolución:</label>
                    <input type="text" class="form-control " id="id_resol" placeholder="Núm. de resolución"
                        onkeypress="return numero(event)">

                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationServer02">RFC del Contribuyente:</label>
                    <input type="text" class="form-control " id="RFC_contri" name="RFC_contri"
                        placeholder="RFC del Contribuyente" onkeyup="javascript:this.value=this.value.toUpperCase();"
                        required maxlength="13">

                </div>
                <div class="col-md-6 mb-3">
                    <label for="validationServerUsername">Razón social:</label>
                    <div class="input-group">
                        <input type="text" class="form-control " id="razon_social" name="razon_social"
                            placeholder="Nombre del Contribuyente" aria-describedby="inputGroupPrepend3" required>

                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationServerUsername">Autoridad Determinante:</label>
                    <div class="input-group">
                        <select class="custom-select" id="autoridad_selec" name="autoridad_selec" required>
                            <option value="0" selected>Selecciona autoridad Determinante</option>
                            <?php
                            require_once 'php/ConsultaContribuyentes.php';
                            $metodos = new ConsultaContribuyentes();
                            $autoridad = $metodos->Consulta_Autoridad();
                            for ($i=0; $i <count($autoridad) ; $i++) { 
                            echo "<option value='".$autoridad[$i]['num_Autoridad']."'>".$autoridad[$i]['nombre_autoridad']."</option>";
                            }
                          ?>

                        </select>

                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class='form-group col-md-3'>
                    <label for='fecha_seg'>Fecha del determinante:<samp class='text-danger'>*</samp></label>
                    <input type='text' class='form-control fecha_end ' id='fecha_det' name='fecha_det'
                        placeholder='yyyy/mm/dd'>
                </div>
                <div class="col-md-6">
                    <label for="validationServer05">Empleado Asignado:</label>
                    <select class="custom-select" id="empleado_selec" name="empleado_selec">
                        <option value="0" selected>Selecciona empleado</option>
                        <?php
                            require_once 'php/ConsultaContribuyentes.php';
                            $metodos = new ConsultaContribuyentes();
                            $empleado = $metodos->Consulta_empleado();
                            for ($i=0; $i <count($empleado) ; $i++) { 
                            echo "<option value='".$empleado[$i]['id_empleado']."'>".$empleado[$i]['nombre_empleado']."</option>";
                            }
                          ?>
                    </select>

                </div>

            </div>
            <div class="form-row">
                <div class='form-group col-md-4'>
                    <label for='fecha_seg'>Fecha del inventario:<samp class='text-danger'>*</samp></label>
                    <input type=' text' class='form-control fecha_end' id='fecha_inventario' name='fecha_inventario'
                        placeholder='yyyy/mm/dd'>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationServerUsername">Estatus Determinante:</label>
                    <div class="col-auto my-1">
                        <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>
                        <select class="custom-select mr-sm-2" id="Estatus_cred" >
                            <option value="0" selected>Selecciona...</option>
                            <option value="A">Activa</option>
                            <option value="B">Baja</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class='form-group col-md-8'>
                    <label for='llave_rdfda'>Genera llave RDFDA:<samp class='text-danger'>*</samp></label>
                    <input type='text'  class='form-control ' id='llave_rdfda' name='llave_rdfda'
                        placeholder='RFC/DETERMINANTE/FEC_DET/AUTORIDAD' disabled>
                </div>
                
            </div>
            <button class="btn btn-primary" type="button" onclick="registro_det()">Registrar determinante</button>

    </div>
    </form>
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
    <?php 
     $menu->Modal_notificacion_integracion();
    ?>
    <?php
    // se imprime footer
    $menu->Footer();
    ?>

    <script type='text/javascript' src='js/registro_det_indi.js'></script>
    <script type='text/javascript' src='js/libs/bootstrap-datepicker.min.js'></script>
    <script src='js/libs/locales/bootstrap-datepicker.es.js' charset='UTF-8'></script>
    <script src="js/valida_formularios_entrevistas.js"></script>
    <link rel="stylesheet" href="css/libs/bootstrap-datepicker3.min.css">
    <script type='text/javascript' src='js/toastr.min.js'></script>

</body>

</html>