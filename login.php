<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img\LOGO11.ico">
    <title>Bóveda SAT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <script  src="js/jquery-3.1.1.js"></script>
    <script  src="js/bootstrap.js"></script>
</head>
<body class="fondo">
<nav class="navbar navbar-expand-lg" style="background-color:#781438;">>
        <a class="navbar-brand text-white" style="font-size:25px;" href="#" id="ver" >Bóveda SAT</a>
        <a class="navbar-brand " style="font-size:25px;" href="#" id="ver2"> <a type="submit" class="btn btn-dark text-white"  href="formatos/Manual del usuario Bóveda SAT.pdf" download="Formato.xlsx">Descarga Manual del usuario.</a> </a>
</nav>

    <div class="container-fluid py-5">
        <?php
        if (isset($_GET["error"])) {
            switch ($_GET["error"]) {
                    case 1:
                        $error ="<div class='alert alert-danger' role='alert'>
                                El perfil esta inactivo.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;

                    case 2:
                        $error ="<div class='alert alert-danger' role='alert'>
                                El departamento esta inactivo.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>  
                                </div>";
                        echo $error;
                    break;
                    case 3:
                        $error ="<div class='alert alert-danger' role='alert'>
                                La subadminsitración esta inactivo.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;

                    case 4:
                        $error ="<div class='alert alert-danger' role='alert'>
                                La administración esta inactivo.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;

                    case 5:
                        $error ="<div class='alert alert-danger' role='alert'>
                                La contraseña no coincide con la registrada.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;
                    case 6:
                        $error ="<div class='alert alert-danger' role='alert'>
                                El usuario no existe.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;

                    case 7:
                        $error ="<div class='alert alert-danger' role='alert'>
                                No hay una sesion activa, debe iniciar sesión primero.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;

                    case 8:
                        $error ="<div class='alert alert-danger' role='alert'>
                                El tiempo de sesión expiró por inactividad.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button> 
                                </div>";
                        echo $error;
                    break;
                    case 9:
                    $error ="<div class='alert alert-danger' role='alert'>
                    No ha firmado responsiva, comuniquese con su administrador para verificar el envio de su responsiva.
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button> 
                            </div>";
                    echo $error;
                    break;
                
            }    
        }
                

        ?>

        <div class="container d-flex flex-column justify-content-around align-items-center">
        <h1 style="color:#781438";><b> Ingreso de usuarios</b></h1>
            <form action="php/validar_acceso_user.php" method="post" >
                <div class="form-group">
                    <label for="ID_USER">Usuario:</label>
                
                    <input type="text" class="form-control" id="ID_USER" name="ID_USER" placeholder="RFC CORTO" maxlength="8" required onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
                <div class="form-group">
                    <label for="PASS_USER">Contraseña:</label>
                    <input type="password" class="form-control" id="PASS_USER" name="PASS_USER" placeholder="Contraseña" maxlength="15" required onkeyup="javascript:this.value=this.value.toUpperCase();">
                </div>
                <div class="form-group">
                   
                   <a href="olvido_pass.php" class="text-dark" >¿Olvidaste tu contraseña? Da click aquí.</a>
                </div>
                <div class="text-center">
                <button type="submit" class="btn btn-lg btn-default">Entrar</button>
                </div>
            </form>
        </div>
    </div>
    <BR></BR>
    <BR></BR>


<?php
include_once 'php/Menu_dinamico.php';
$crear = new Menu();
$foter = $crear->Footer2(); 
?>
</body>
</html>