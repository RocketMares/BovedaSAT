<?php

if (isset($_POST["Password"]) && isset($_POST["Password_C"])) {
    include_once 'sesion.php';
    $pass = $_POST["Password"];
    $pass2 = $_POST["Password_C"];

    if ($pass == $pass2 && strlen($pass) >= 6) {

        include_once 'MetodosUsuarios.php';
        $usuarios = new MetodosUsuarios();

        $pass_enc = $usuarios->Encriptado_Passwd($pass);
        $actualizar = $usuarios->CambiarContrasenaUser_ses($_SESSION["ses_id_usuario"], $pass_enc);
                    $id_user = $_SESSION["ses_id_usuario"];
                    $user = $_SESSION["ses_rfc_corto"];
					$correo = $_SESSION["ses_correo"];
					$nombre = $_SESSION["ses_nombre"];
                    $id_perfil = $_SESSION["ses_id_perfil"];
                    $id_admin = $_SESSION["ses_id_admin"];
                    $tiempo = $_SESSION["tiempo"];
                    session_destroy();

                    session_start();
					$_SESSION["ses_id_usuario"] = $id_user;
                    $_SESSION["ses_rfc_corto"] = $user;
                    $_SESSION["ses_correo"] = $correo;
                    $_SESSION["ses_nombre"] = $nombre;
                    $_SESSION["ses_id_perfil"] =$id_perfil;
                    $_SESSION["ses_id_admin"] = $id_admin;
                    $_SESSION["tiempo"] = $tiempo;		
                    
        header("location:../index.php");
    
    }else if (strlen($pass) < 6 ) {
        header("location:../Cambio_Pass.php?error=1"); 
    }else if ($pass != $pass2){
        header("location:../Cambio_Pass.php?error=2");  
    }
}

?>