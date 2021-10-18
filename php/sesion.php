<?php
//$URL_ = "localhost:8282";
//$URL_ = "192.168.1.69:2323";
//$URL_ = "99.85.24.227:2323";
//$URL_ = '99.85.26.227:8282';
$URL_ = '99.85.24.8:8282';

session_start(); //valida si esta activa la seci?n, sino, no le deja seguir viendo la data y lo regresa a loginDEj.php
if (isset($_SESSION['ses_id_usuario'])
&& isset($_SESSION['ses_rfc_corto'])
&& isset($_SESSION['ses_correo'])
&& isset($_SESSION['ses_nombre'])
&& isset($_SESSION['ses_id_perfil'])
&& isset($_SESSION['tiempo'])
&& isset($_SESSION["ses_id_depto"]) 
&& isset($_SESSION["ses_id_sub_admin"])
&& isset($_SESSION['ses_id_admin'])
|| isset($_SESSION['ses_jefe_directo'])
|| isset($_SESSION['estatus_ent'])) {
    if ($_SESSION['ses_id_perfil'] != 1) {
        require_once 'MetodosUsuarios.php';
        $user = new MetodosUsuarios();
        $inactivo = 3600;
        $vida_session = time() - $_SESSION['tiempo'];
        if ($vida_session > $inactivo) {
            $registro = $user->Registro_fin_sesion();
            
            //Removemos sesi�n.
            session_unset();
            //Destruimos sesi�n.
            session_destroy();
            //Redirigimos pagina.
            header("Location: http://$URL_/BovedaSAT/login.php?error=8");

            die();
        }

        $_SESSION['tiempo'] = time();
    }
} else {
    require_once 'MetodosUsuarios.php';
    $user = new MetodosUsuarios();
    $registro = $user->Registro_fin_sesion();
    header("location:http://$URL_/BovedaSAT/login.php?error=7");
    
    exit();
}







