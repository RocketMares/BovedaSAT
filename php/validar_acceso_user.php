<?php

if (isset($_POST["ID_USER"]) && isset($_POST["PASS_USER"])) {
    include_once 'MetodosUsuarios.php';
    $users = new MetodosUsuarios();
    $contrasena_default = "e10adc3949ba59abbe56e057f20f883e";
    if (($datos = $users->Consulta_User_Existe(strtoupper($_POST["ID_USER"]))) != null ) {
        $pass_enc = $users->Encriptado_Passwd($_POST["PASS_USER"]);
        if ($datos["passwd"] == $pass_enc) {
            if ($admin = $users->Valida_Admin_Activo($datos["id_admin"])) {
                if ($subadmin = $users->Valida_Subadmin_Activo($datos["id_sub_admin"])) {
                    if ($depto = $users->Valida_Dep_Activo($datos["id_depto"])) {
                        if ($perfil = $users->Valida_Perfil_Activo($datos["id_perfil"])) {
                            if ($responsiva = $users->Valida_Responsiva_firmada($datos['id_empleado'])!=0) {
                                if ($pass_enc == $contrasena_default) {
                                        session_start();
                                        $_SESSION["ses_id_usuario"] = $datos["id_empleado"];
                                        $_SESSION["ses_rfc_corto"] = $datos["rfc_corto"];
                                        $_SESSION["ses_correo"] = $datos["correo"];
                                        $_SESSION["ses_nombre"] = $datos["nombre_empleado"];
                                        $_SESSION["ses_id_perfil"] =$datos["id_perfil"];
                                        $_SESSION["ses_id_admin"] = $datos["id_admin"];
                                        $_SESSION["ses_id_depto"] = $datos["id_depto"];
                                        $_SESSION["ses_id_sub_admin"] = $datos["id_sub_admin"];
                                        $_SESSION["ses_jefe_directo"] = ($datos["jefe_directo"] != null) ? $datos["jefe_directo"] : $datos["id_empleado"];
                                        $_SESSION["ses_cambio_pass"] = "cambiar contraseña";
                                        $_SESSION["tiempo"] = time();
                                        $_SESSION["estatus_ent"] = 1;
                                        $_SESSION["ses_id_puesto"] =$datos["id_puesto"];
                                        $_SESSION["agrega"]=0;
                                        $_SESSION["tiket_obs"]=0;
                                        header('location:../Cambio_pass.php');
                                }else{
                                        session_start();
                                        $_SESSION["ses_id_usuario"] = $datos["id_empleado"];
                                        $_SESSION["ses_rfc_corto"] = $datos["rfc_corto"];
                                        $_SESSION["ses_correo"] = $datos["correo"];
                                        $_SESSION["ses_nombre"] = $datos["nombre_empleado"];
                                        $_SESSION["ses_id_perfil"] =$datos["id_perfil"];
                                        $_SESSION["ses_id_admin"] = $datos["id_admin"];
                                        $_SESSION["ses_id_depto"] = $datos["id_depto"];
                                        $_SESSION["ses_id_sub_admin"] = $datos["id_sub_admin"];
                                        $_SESSION["ses_jefe_directo"] = ($datos["jefe_directo"] != null) ? $datos["jefe_directo"] : $datos["id_empleado"];
                                        $_SESSION["tiempo"] = time();
                                        $_SESSION["estatus_ent"] = 1;
                                        $_SESSION["ses_id_puesto"] =$datos["id_puesto"];
                                        $_SESSION["ses_id_sess"] = $registro["id_sess"];
                                        $_SESSION["agrega"]=0;
                                        $_SESSION["tiket_obs"]=0;
                                        $_SESSION["tiket_obs_dev"]=0;
                                        $_SESSION["tiket_estatus"]=0;
                                        $_SESSION["tiket_cambio_pro"]=0;
                                        $_SESSION["List"]=0;
                                        $registro= $users->Reg_SES();
                                        include_once 'ConsultaContribuyentes.php';
                                        $busqueda = new ConsultaContribuyentes();
                                        $datos = $_POST["cancela"];
                                        $resultado = $busqueda->Cancelacion_tiket();
                                        $accion = $busqueda->bus_tiket_disponibles_por_caducar();
                                        $accion1 = $busqueda->bus_tiket_peticion_por_caducar();
                                        header('location:../index.php');
                                    // echo"<script> alert($accion) </script>";
                                }
                            }
                            else {
                                header('location:../login.php?error=9');
                            echo "No ha firmado responsiva, comuniquese con su administrador para verificar el envio de su responsiva.";
                            }
                        }else{
                            header('location:../login.php?error=1');
                            echo "El perfil esta inactivo.";
                        }
                    }else{
                        header('location:../login.php?error=2');
                        echo "El departamento esta inactivo.";
                    }
                }else{
                    header('location:../login.php?error=3');
                    echo "La subadminsitración esta inactivo.";
                }
            }else{
                header('location:../login.php?error=4');
                echo "La administración esta inactivo.";
            }
            
        }else{
            header('location:../login.php?error=5');
            echo "Las contraseñas no son iguales";
        }
    }else{
        header('location:../login.php?error=6');
        echo "El usuario no existe.";
    }
}

?>