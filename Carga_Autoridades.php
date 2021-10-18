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
            <h1>Mantenimiento de Autoridades</h1>
        </center>
    </div>
    <div class="container pt-4">
        <H1 class="display-4">Registro de Autoridades: </H1>
        <form action="php/ra_area.php" method="POST">
            <div class="form-group row">
                <label for="inputState" class="col-sm-2 col-form-label">Nombre de Autoridad: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombre_autoridad"
                        placeholder=" Ejem: Comision Nacional de Seguros y Fianzas" name="nombre_autoridad">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputState" class="col-sm-2 col-form-label">Numero de Autoridad: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="numero_autoridad" placeholder=" Ejem: 1136"
                        name="numero_autoridad">
                </div>
            </div>


            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="button" class="btn btn-primary" onclick="Registra_autoridad()">Registrar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="container pt-4">
        <H1 class="display-4">Actualizar Autoridades: </H1>
        <form action="php/ra_area.php" method="POST">
            <div class="form-group row">

                <label for="inputState" class="col-sm-2 col-form-label">Autoridad Asociada: </label>
                <div class="col-sm-10">
                    <select class="custom-select line" id="id_autoridad" name="id_autoridad">
                        <option value='0'>Seleccionar Autoridad</option>
                        <?php
                 include_once 'php/ConsultaContribuyentes.php';
                 $consulta = new ConsultaContribuyentes();
                 $rows_local = $consulta->Consulta_Autoridad();
                 for ($i = 0; $i < count($rows_local); $i++) {
                     if ($rows_local[$i]["estatus"] == "A") {
                         echo "<option value='" . $rows_local[$i]["id_autoridad"] . "'>" . $rows_local[$i]["nombre_autoridad"] . "</option>";
                     }
                 }
                 ?>

                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre de Autoridad: </label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="Nombre_autor" placeholder=" Ejem: Comision Nacional de Seguros y Fianzas" name="Nombre_autor" required>
                </div>
            </div>
            
            <fieldset class="form-group">
                <div class="row">
                    <legend class="col-form-label col-sm-2 pt-0">Estatus</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="estatus" id="estatus" value="A">
                            <label class="form-check-label" for="gridRadios1">
                                Activa
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="estatus" id="estatus" value="N">
                            <label class="form-check-label" for="gridRadios2">
                                Inactiva
                            </label>
                        </div>

                    </div>
                </div>
            </fieldset>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="button" class="btn btn-primary" onclick="Actualiza_autoridad()">Actualizar</button>
                </div>
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
                        <button type="button" class="btn btn-success" onclick="Confima_cambio_cartera()">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Confirma_accion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
        <button type="button" class="btn btn-success" onclick="Afecta_cambio_cartera()" >Continuar</button>
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
<!-- <script type="text/javascript" src="js/scripts_user.js"></script> -->
</body>

</html>