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
    <link href="css/responsive-calendar.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="css/css/all.css">
    <script defer src="js/js/all.js"></script>

    <script type="text/javascript" src="js/jquery-1.6.min.js"></script>
    <script type="text/javascript" src="js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/renueva.js"></script>
    <link rel="stylesheet" href="css/toastr.min.css">
</head>

<body>

    <?php
        include_once 'php/ConsultaContribuyentes.php';
        $consulta = new ConsultaContribuyentes();
        $rows_Objeto = $consulta->Consulta_Objeto1();
                
                                                    
        require_once 'php/menu_dinamico.php';
        $menu = new Menu();
        $menu->Crear_menu();
       
        ?>
    <!-- maquetación de vista -->

    <!-- contenedor general -->
    <div class="container-fluid" style="padding-top: 3rem !important;">

        <div class="container col-md-10 " id="main">

            <div class="container text-center py-2">
                <h1 class="display-4 mb-2">Integración de Documentos</h1>
                <!-- Aqui seleccionamos RFC y determinante -->
             
                <div class="row">
  
                    <div class="container pt-4">
                        <!-- Se descomenta esta  linea para que se agrege documentacion, si no, deje comentada la lina, para que solo agrege el registro a la base de datos -->
                        <!-- <form action="php/validar_Integracion.php" method="post" enctype="multipart/form-data"> -->
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group form-check-inline row">
                                <label for="inputState" class="col-sm-2 col-form-label">RFC:</label>
                                <div class="col-sm-10 ">
                                    <div class="input-group mb-10">
                                        <input type="text" class="form-control" id="rfc_contri" maxlength="13"required onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="buscar_contri">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputState" class="col-sm-2 col-form-label">Núm. determinante:</label>
                                <div class="col-sm-10">
                                    <select class="custom-select line" id="det_exp" name="det_exp">
                                    <option value='0'>Seleccionar Núm. determinante</option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="div_ino"></div>
                            <div class="form-group row">
                                <label for="inputState" class="col-sm-2 col-form-label">Seleccionar Objeto:</label>
                                <div class="col-sm-10">
                                    <select class="custom-select line" id="num_objeto" name="num_objeto">
                                        <option value='0'>Seleccionar Situacion</option>
                                        <?php

                            for ($i = 0; $i < count($rows_Objeto); $i++) {
                         echo "<option value='".$rows_Objeto[$i]["id_objeto"]."'>".$rows_Objeto[$i]["Objeto"]."</option>";
                              }
                 ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputState" class="col-sm-2 col-form-label">Situación Asociada:</label>
                                <div class="col-sm-10">
                                    <select class="custom-select line" id="id_situacion" name="id_situacion">
                                        <option value='0'>Seleccionar Situacion</option>


                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputState" class="col-sm-2 col-form-label">Etapa Asociada:</label>
                                <div class="col-sm-10">
                                    <select class="custom-select line" id="id_etapas_select" name="id_etapas_select">
                                        <option value='0'>Seleccionar etapa</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputState" class="col-sm-2 col-form-label">Tipo de documento:</label>
                                <div class="col-sm-10">
                                    <select class="custom-select line" id="tip_doc" name="tip_doc">
                                        <option value='0'>Seleccionar Tipo</option>
                                        <option value="1">Original</option>
                                        <option value="2">Copia certificada</option>
                                        <option value="3">Copia foto-estatica</option>
                                        <option value="4">Correo</option>
                                        <option value="5">Captura de pantalla</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputState" class="col-sm-2 col-form-label">Fecha del Documento/Oficio:
                                </label>
                                <div class="col-sm-10">

                                    <input type='text' class='form-control' id='fecha_doc_inte' name='fecha_doc_inte'>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputState" class="col-sm-2 col-form-label">Observaciones :</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="Obs" name="Obs" rows="3"
                                        placeholder="Observaciones"></textarea>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputState" class="col-sm-2 col-form-label">Num Fojas :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fojas" name="fojas" placeholder="Fojas"
                                        onkeypress='return numero(event)'>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label"> Archivo : </label>
                                <div class="col-sm-10">
                                <input type='file' class='form-control-file' id='archivo_int' name='archivo_int' accept='.pdf,.zip,.doc,.xlsx'>
                                </div>
                            </div>  -->

                            <div class="form-group row">

                                <div class="col-sm-10">
                                    <?php
                
                   echo "<button class='btn btn-dark btn_sat_black text-white btn-lg' id='refleja' onclick='valida_formulario_inter_masv()'
                    type='button'>Aceptar</button>";
                 ?>

                                </div>
                            </div>
                    </div>
                    </form>
                   
                </div>
            </div>
        </div>
    </div>
    <?php 
     $menu->Modal_notificacion_integracion();
    ?>

    <script type='text/javascript' src='js/toastr.min.js'></script>
    <?php
        //Footer
        $menu->Footer();
      ?>
    <script type='text/javascript' src='js/scripts_user.js'></script>

    <script src="js/valida_formularios_entrevistas.js"></script>
    <script type='text/javascript' src='js/libs/bootstrap-datepicker.min.js'></script>
    <script src='js/libs/locales/bootstrap-datepicker.es.js' charset='UTF-8'></script>
    <script src='js/libs/bootstrap-datepicker.js' charset='UTF-8'></script>
    <link rel="stylesheet" href="css/libs/bootstrap-datepicker3.min.css">


    <?php
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
?>

</html>
