$("#ver").click(function (e) {
    openNav();
});

function Tiket_disponible() {

    // alert('hola entras aqui ');
    $.post("php/Estatus_disponible.php", {
        array: 1
    }, function (data) {
        alert(data);
        location.reload();
    });

}
$(document).ready(function () {
    $('#carga_inte_al').on('click', function () {
        $.post("php/resultados_prueba.php", {
            Notif: 1
        }, function (data) {

        })
    });
})

function valida_formulario_inter_ticket(RDFDA) {
    if (
        $("#num_objeto").val() == 0 ||
        $("#id_situacion").val() == 0 ||
        $("#id_etapas_select").val() == 0 ||
        $("#fecha_doc_inte").val() == '' ||
        $("#fojas").val() == '' ||
        $("#tip_doc").val() == 0) {
        //alert('No puedes dejar en blanco ningun dato que tenga el asterisco rojo.');
        toastr.error('No puedes dejar en blanco ningun dato que tenga el asterisco rojo.', 'Notificación:', {
            "progressBar": true
        });

    } else {
        manda_datos_inter(RDFDA);
    }
}

function valida_formulario_inter_masv() {
    if (
        $("#det_exp").val() == 0 ||
        $("#num_objeto").val() == 0 ||
        $("#id_situacion").val() == 0 ||
        $("#id_etapas_select").val() == 0 ||
        $("#fecha_doc_inte").val() == '' ||
        $("#fojas").val() == '' ||
        $("#tip_doc").val() == 0) {
        //alert('No puedes dejar en blanco ningun dato que tenga el asterisco rojo.');
        toastr.error('No puedes dejar en blanco ningun dato que tenga el asterisco rojo.', 'Notificación:', {
            "progressBar": true
        });

    } else {
        manda_datos_inter_masv();
    }
}

function manda_datos_inter_masv() {
    var id_det = $("#det_exp").val();
    var num_objeto = $("#num_objeto").val();
    var id_situacion = $("#id_situacion").val();
    var id_etapas_select = $("#id_etapas_select").val();
    var fecha_doc_inte = $("#fecha_doc_inte").val();
    var fojas = $("#fojas").val();
    var tip_doc = $("#tip_doc").val();
    var Obs = $("#Obs").val();
    var datos = {
        id_det: id_det,
        num_objeto: num_objeto,
        id_situacion: id_situacion,
        id_etapas_select: id_etapas_select,
        fecha_doc_inte: fecha_doc_inte,
        fojas: fojas,
        tip_doc: tip_doc,
        Obs: Obs
    }
    var json = JSON.stringify(datos);
    $.post("php/validar_Integracion.php", {
        datos_inter_select: json
    }, function (data) {
        toastr.success(data + "<br /><br /><button type='button' id='notif' class='btn btn-dark clear' onclick ='Muestra_integraciones_pendientes()'>Revisar avance</button>", 'Notificación:', {
            "progressBar": true,
        });
        limpia_camp();
        //location.reload();
    });
}

function manda_datos_inter(RDFDA) {
    var RDFDA = RDFDA;
    var num_objeto = $("#num_objeto").val();
    var id_situacion = $("#id_situacion").val();
    var id_etapas_select = $("#id_etapas_select").val();
    var fecha_doc_inte = $("#fecha_doc_inte").val();
    var fojas = $("#fojas").val();
    var tip_doc = $("#tip_doc").val();
    var Obs = $("#Obs").val();
    var datos = {
        RDFDA: RDFDA,
        num_objeto: num_objeto,
        id_situacion: id_situacion,
        id_etapas_select: id_etapas_select,
        fecha_doc_inte: fecha_doc_inte,
        fojas: fojas,
        tip_doc: tip_doc,
        Obs: Obs
    }
    var json = JSON.stringify(datos);
    $.post("php/validar_Integracion.php", {
        datos_inter: json
    }, function (data) {
        toastr.success(data + "<br /><br /><button type='button' id='notif' class='btn btn-dark clear' onclick ='Muestra_integraciones_pendientes()'>Revisar avance</button>", 'Notificación:', {
            "progressBar": true,
        });
        limpia_camp();
        //location.reload();
    });
}

function Muestra_integraciones_pendientes() {
    $('#Caja_integraciones').modal();
    $.ajax({
        url: 'php/detalle_tiket_peticion.php',
        type: 'POST',
        dataType: 'html',
        data: {
            caja_integ: 1
        }
    }).done(function (respuesta) {
        $('#contenido_inter').html(respuesta);
    })
}
function Muestra_integraciones_generadas_pendientes_por_entregar() {
    $('#Caja_integraciones').modal();
    $.ajax({
        url: 'php/detalle_tiket_peticion.php',
        type: 'POST',
        dataType: 'html',
        data: {
            caja_integ_pentienes_por_entregar: 1
        }
    }).done(function (respuesta) {
        $('#Vista_solicitudes_pendientes_por_entregar').html(respuesta);
    })
}
function Muestra_integraciones_procesos_integracion() {
    $('#Caja_integraciones').modal();
    $.ajax({
        url: 'php/detalle_tiket_peticion.php',
        type: 'POST',
        dataType: 'html',
        data: {
            caja_integ_PROCESOS_entregar: 1
        }
    }).done(function (respuesta) {
        $('#Vista_solicitudes_de_integracion_procesos').html(respuesta);
    })
}
function Cancela_integracion(id_inter) {

    $.ajax({
        url: 'php/resultados_prueba.php',
        type: 'POST',
        dataType: 'html',
        data: {
            borrar_integracion: id_inter
        }
    }).done(function (respuesta) {
        toastr.success(respuesta + "<br /><br /><button type='button' id='notif' class='btn btn-dark clear'>Ok</button>", 'Notificación:', {
            "progressBar": true,
        });
    })
    Muestra_integraciones_pendientes()
}
function Cancela_tik_integracion(id_inter) {
    $.ajax({
        url: 'php/resultados_prueba.php',
        type: 'POST',
        dataType: 'html',
        data: {
            borrar_tik_integracion: id_inter
        }
    }).done(function (respuesta) {
        toastr.success(respuesta + "<br /><br /><button type='button' id='notif' class='btn btn-dark clear'>Ok</button>", 'Notificación:', {
            "progressBar": true,
        });
    })
    Muestra_integraciones_generadas_pendientes_por_entregar()
}
function Pasar_envio_tik_integracion(id_inter) {
    $.ajax({
        url: 'php/resultados_prueba.php',
        type: 'POST',
        dataType: 'html',
        data: {
            tik_integracion_PROC_envio: id_inter
        }
    }).done(function (respuesta) {
        toastr.success(respuesta + "<br /><br /><button type='button' id='notif' class='btn btn-dark clear'>Ok</button>", 'Notificación:', {
            "progressBar": true,
        });
    })
    Muestra_integraciones_generadas_pendientes_por_entregar()
}

$(document).ready(function () {
    $(document).one('mousemove', function () {
        $.ajax({
            url: 'php/resultados_prueba.php',
            type: 'POST',
            dataType: 'html',
            data: {
                notif: 1
            }
        }).done(function (respuesta) {
            if (respuesta != 0) {

                $('#notificaciones').html(respuesta);
                toastr.info("Tienes integraciones pentienes (" + respuesta + ") <br /><br /><button type='button' id='notif' class='btn btn-dark clear'>Ok</button>", 'Notificación:', {
                    "preventDuplicates": true,
                    "progressBar": true,
                    "positionClass": "toast-bottom-right",
                });

            }

        }).fail(function () {
            //alert('algo salio mal');
        });
    })

    $('#refleja').on('click', function () {
        $.ajax({
            url: 'php/resultados_prueba.php',
            type: 'POST',
            dataType: 'html',
            data: {
                notif: 1
            }
        }).done(function (respuesta) {
            var valor = respuesta;
            if (valor != 0) {
                $('#notificaciones').html(valor);

            } else {
                $('#notificaciones').html();
            }

        }).fail(function () {
            //alert('algo salio mal');
        });

    });
})

function limpia_camp() {
    $("#num_objeto").val("");
    $("#id_situacion").val("");
    $("#id_etapas_select").val("");
    $("#fecha_doc_inte").val("");
    $("#fojas").val("");
    $("#tip_doc").val("");
    $("#Obs").val("");
}

function revisa_peticiones_agregadas(user) {
    $.post("php/detalle_tiket_peticion.php", {
            Carrito: user
        }, function (data) {

        }).done(function (respuesta) {
            $("#datos_del_carrito").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function Confirm_cancel_tik() {

    $("#CancelaTiket").modal();


}

function Confirm_salida_tik() {

    $("#CancelaTiket").modal();


}

function Invoca_Modulo_barras() {

    $("#LECTOR_BARRAS").modal();
    AUTOFOCUS();

}

function AUTOFOCUS() {
    $('#LECTOR_BARRAS').on('shown.bs.modal', function () {
        $('#num_ticket_code_bar').trigger('focus');
    });
};

function Confirm_prest_tik() {

    $("#PrestaTicket").modal();


}

function Confirm_disponible_tik() {

    $("#DISPONIBLETicket").modal();


}

function Confirm_dev_tik() {

    $("#Modal_pet_dev_1").modal();


}



function Tiket_cancelado() {
    motiv = $('#motiv_cancel').val();
    if (motiv == 0) {

        toastr.warning('Debes seleccionar un motivo para la cancelacion',"Notificación",{
            "progressBar": true
        })
    }
    else{
        $.post("php/Cancelar_solicitud.php", {
            array: motiv
        }, function (data) {
            alert(data);
            location.reload();
        });
    }
    
}

function Tiket_prest() {

    //alert('hola entras aqui ');
    $.post("php/Estatus_prestamo_Boveda.php", {
        array: 1
    }, function (data) {
        alert(data);
        location.reload();
    });

}

function Tiket_dev_pet() {
    $.post("php/Tiket_procesos_dev.php", {
        pet_dev_: 1
    }, function (data) {
        alert(data);
        location.reload();
    });

}

function Tiket_dev_inter() {

    // alert('hola entras aqui ');
    $.post("php/Tiket_procesos_dev.php", {
        prest_dev_int: 1
    }, function (data) {
        alert(data);
        location.reload();
    });

}





var moda = $("#Modal_pendientes").modal();
var modal2 = $("#Modal_ticket_alerta_users_disponibles").modal();
var modal3 = $("#Modal_ticket_alerta_users_disponibles_cancel").modal();
var modal4 = $("#Modal_ticket_alerta_por_aprobar").modal();
var modal4 = $("#Modal_ticket_alerta_cancelados_2").modal();

function Busqueda() {
    var busqueda = document.getElementById('busqueda').value;
    if (busqueda != '') {
        var busq = busqueda;
        location.href = "Expedientes.php?pagina=1&busqueda=" + busq
    } else {
        alert('No puedes dejar en blanco la busqueda o presiona el boton de buscar para realizar tú busqueda.')
    }
}

function quitar_filtro_busqueda() {
    location.href = "Expedientes.php?pagina=1"
}

function BuscarDatosContrib(id_contrib) {
    var con = id_contrib
    createCookie('contribuyente', con, 1)
    location.href = "detalle_contribuyente.php";
}

function vermas() {
    $('#vermasdiv').toggle();
    $('#link_ver').toggle();
}

function renovar() {
    location.reload();
}



function vista_comentarios_vis(RDFDA) {

    $("#Modal_vistas_ob").modal();
    buscar_datos_observaciones_vis(RDFDA);

}

function agrega_observacion_dev_1(RDFDA) {
    $("#Modal_Comentario_dev").modal();
    accion_agrega(RDFDA);
}

function Muestra_mod_integracion(RDFDA) {
    $("#integra_docs2").modal();
    Muestra_form_integracion(RDFDA);
}

function Muestra_form_integracion(RDFDA) {
    $.ajax({
        url: 'php/detalle_tiket_peticion.php',
        type: 'POST',
        dataType: 'html',
        data: {
            Muestra_form: RDFDA
        }
    }).done(function (respuesta) {
        $('#formulario_integracion').html(respuesta);
    }).fail(function (respuesta) {
        alert('algo salio mal');
    });

}

function accion_agrega(RDFDA) {
    $.ajax({
        url: 'php/detalle_tiket_peticion.php',
        type: 'POST',
        dataType: 'html',
        data: {
            RDFDA_ob_dev: RDFDA
        }
    });
}

function valida_Observacion_dev() {
    if ($("#Des_dev").val().length < 1) {
        alert('Los datos marcados con el asterico no deben ser dejados en blanco.');
    } else {
        //alert('OK');
        Registrar_obs_dev();
    }
}

function Registrar_obs_dev() {

    var observa = $("#Observacion_dev").val();
    var Des = $("#Des_dev").val();
    //  alert(observa);
    var datos = {
        observa: observa,
        Des: Des
    };

    //var json = JSON.stringify(datos);
    $.post("php/detalle_tiket_peticion.php", {
        datos_des_dev: datos
    }, function (data) {
        alert(data);
        location.reload();
    });

}

function Manda_estatus(RDFDA) {
    var estatus = document.getElementById('Estatus_det_fin_tiket').value;
    var RDFDA = RDFDA;
    var datos = {
        RDFDA: RDFDA,
        estatus: estatus,
    };
    //alert(datos);
    if (estatus != '') {
        $.post("php/Tiket_procesos_dev.php", {
                datos_cambio: datos
            }, function (data) {

            })
            .done(function (respuesta) {
                alert(respuesta);
                location.reload();
            })
            .fail(function () {
                console.log("error");
            });
    } else {
        alert('Selecciona un estatus.');
    }

}

function Manda_estatus_visor(RDFDA) {

    var estatus = document.getElementById('Estatus_det_fin_tiket_vis').value;
    var RDFDA = RDFDA;
    var datos = {
        RDFDA: RDFDA,
        estatus: estatus,
    };
    if (estatus != '') {
        $.post("php/Tiket_procesos_dev.php", {
                datos_cambio_visor: datos
            }, function (data) {

            })
            .done(function (respuesta) {
                alert(respuesta);
                location.reload();
            })
            .fail(function () {
                console.log("error");
            });
    } else {

        alert('Selecciona un estatus.');

    }

}

function vista_comentarios_dev(RDFDA) {

    $("#Modal_vistas_ob_dev").modal();
    buscar_datos_observaciones_dev(RDFDA)

}

 function Activa_modal_reasigna() {

     $("#Modal_reasigna_cartera").modal();
 }
$(document).ready(function(){
    $('#Ver_modal_reasig').on('click',function(){
        $("#Modal_reasigna_cartera").modal();
    })
})
function Confima_cambio_cartera() {

    $("#Confirma_accion").modal();

}

function Cambia_fojas(RDFDA) {

    $("#Modal_fojas_det").modal();
    buscar_det_fojas(RDFDA)

}

function buscar_det_fojas(RDFDA) {
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            type: 'POST',
            dataType: 'html',
            data: {
                fojas_det: RDFDA
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#selecciona_fojas").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function Manda_registro_de_fojas(RDFDA) {
    var num_fojas = document.getElementById('fojas_num').value;
    var RDFDA = RDFDA;
    var datos = {
        RDFDA: RDFDA,
        num_fojas: num_fojas,
    };
    //alert(datos);
    if (num_fojas != '') {
        $.post("php/Tiket_procesos_dev.php", {
                datos_fojas: datos
            }, function (data) {

            })
            .done(function (respuesta) {
                alert(respuesta);
                //location.reload();
            })
            .fail(function () {
                console.log("error");
            });
    } else {
        alert('Ingresa el número de fojas de el expediente.');
    }

}

function Confima_cambio_propietario_ticket() {

    $("#Confirma_cambio_propietario_ticket").modal();

}

function Afecta_cambio_cartera() {
    var id_empleado_1 = $("#usuario_1_act").val();
    var id_empleado_2 = $("#usuario_2_cam").val();
    var datos = {
        id_empleado_1: id_empleado_1,
        id_empleado_2: id_empleado_2
    };
    //var json = JSON.stringify(datos);
    //alert('Si entra aqui' + json);
    if (id_empleado_1 != 'Selecciona Usuario' || id_empleado_2 != 'Selecciona Usuario' || id_empleado_1 != 'Selecciona Usuario' && id_empleado_2 != 'Selecciona Usuario') {
        $.post("php/Valida_cambio_reasigna_cartera.php", {
                cambios: datos
            })
            .done(function (data) {
                alert(data);
                location.reload();
            })
            .fail(function () {
                console.log("error");
            });
    } else {
        alert('No deje los requisitos marcados en blanco.');
    }
    //  //location.reload();
}

function Afecta_cambio_propietario_ticket() {
    var empleado_cambio = $("#Cambio_empleado_ticket").val();
    var datos = {
        empleado_cambio: empleado_cambio,
    };
    if (empleado_cambio != '') {
        $.post("php/Valida_cambio_reasigna_cartera.php", {
                cambios_tik: datos
            })
            .done(function (data) {
                alert(data);
                location.reload();
            })
            .fail(function () {
                console.log("error");
            });
    } else {
        alert('No deje los requisitos marcados en blanco.');
    }
    //location.reload();
}

function vista_comentarios(tiket) {

    $("#Modal_vistas_ob").modal();
    buscar_datos_observaciones(tiket)

}

function Abre_modal_reasinga(tiket) {

    $("#modal_reasinga_tiket").modal();
    buscar_datos_Ticket_cambios(tiket)

}
$(buscar_datos());
$(buscar_datos_ticket_code());

function buscar_datos(consulta) {
    $.ajax({
            url: 'php/buscar.php',
            type: 'POST',
            dataType: 'html',
            data: {
                consulta: consulta
            },
        })
        .done(function (respuesta) {

            $("#datos").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function numero(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

$(document).on('keyup', '#num_ticket_code_bar', function () {
    var valor = $(this).val();
    if (valor != "") {
        buscar_datos_ticket_code(valor);
    } else {
        buscar_datos_ticket_code();
    }
});

function buscar_datos_ticket_code(consulta) {
    $.ajax({
            url: 'php/Busqueda_codebar.php',
            type: 'POST',
            dataType: 'html',
            data: {
                consulta_code_bar: consulta
            },
        })
        .done(function (respuesta) {

            $("#datos_ticket_codebar").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });

}

function buscar_datos_Ticket_cambios(tiket) {
    var ticket = tiket;
    //alert(tiket);
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            type: 'POST',
            dataType: 'html',
            data: {
                Cam_ticket: ticket
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#tabla_contenido_cambio_ticket").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function buscar_datos_observaciones(tiket) {
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            type: 'POST',
            dataType: 'html',
            data: {
                RDFDA_observacion: tiket
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#datosObservaciones").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function buscar_datos_observaciones_dev(RDFDA) {
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            type: 'POST',
            dataType: 'html',
            data: {
                RDFDA_observacion_dev: RDFDA
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#datosObservaciones1").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function buscar_datos_observaciones_vis(RDFDA) {
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            type: 'POST',
            dataType: 'html',
            data: {
                RDFDA_observacion_vis: RDFDA
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#datosObservaciones").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function agrega_observacion(RDFDA) {
    //alert(RDFDA);

    //var variable1 = '<%= Session["Variable1"] %>';
    $.ajax({
        url: 'php/detalle_tiket_peticion.php',
        type: 'POST',
        dataType: 'html',
        data: {
            RDFDA_ob: RDFDA
        },
    })
    $("#Modal_Comentario").modal();

}

function valida_Observacion() {
    if ($("#Des").val().length < 1) {
        alert('Los datos marcados con el asterico no deben ser dejados en blanco.');
    } else {
        //alert('OK');
        Registrar_obs();
    }
}

function Registrar_obs() {

    var observa = $("#Observacion").val();
    var Des = $("#Des").val();
    //  alert(observa);
    var datos = {
        observa: observa,
        Des: Des
    };

    //var json = JSON.stringify(datos);
    $.post("php/detalle_tiket_peticion.php", {
        datos_des: datos
    }, function (data) {
        alert(data);
        location.reload();
    });

}


function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function ConfirmarCargaAut(valor) {

    $.post("php/validar_carga_masiva.php", {
        constante: valor
    }, function (data) {
        $("#texto_result").html(data);
        $("#resultado_carga").modal({
            backdrop: 'static',
            keyboard: false
        });
    });
}

function ConfirmarCargaUSU(valor) {
    $.post("php/validar_carga_masiva.php", {
        USU: valor
    }, function (data) {
        $("#texto_result").html(data);
        $("#resultado_carga").modal({
            backdrop: 'static',
            keyboard: false
        });
    });
}

function ConfirmarCargaDet(valor) {
    $.post("php/validar_carga_masiva.php", {
        det: valor
    }, function (data) {
        $("#texto_result").html(data);
        $("#resultado_carga").modal({
            // backdrop: 'static',
            // keyboard: false
        });
    });
}

function BuscarContribuyentes(id_empleado) {
    var id_operativo = id_empleado
    createCookie('id_operativo', id_operativo, 1)
    location.href = "Contribuyentes_asig.php?operativo=1";
}

function BuscarContribuyentesA(id_empleado) {
    var id_analista = id_empleado
    createCookie('id_analista', id_analista, 1)
    location.href = "Contribuyentes_asig.php?analista=1";
}


function Buscar_analistas(id_empleado) {
    var id_jefe = id_empleado
    createCookie('id_jefe', id_jefe, 1)
    location.href = "Contribuyentes_asig.php?jefedepto=1";
}

function Buscar_jefes(id_empleado) {
    var id_sub = id_empleado
    createCookie('id_sub', id_sub, 1)
    location.href = "Contribuyentes_asig.php?id_sub=1";
}

function DetalleEntrevista(id_ent) {
    var id_ent = id_ent
    createCookie('id_ent', id_ent, 1)
    location.href = "Detalle_entrevista.php";
}

function ocultar_detalles() {
    $("#detalles_ent").toggle();
    $("#detalles_mot").toggle();
    $("#detalles_insumo").toggle();
}

function detalles_ent() {
    $("#detalles_ent").toggle('slow');
}

function detalles_insumo() {
    $("#detalles_insumo").toggle('slow');
}

function detalles_mot() {
    $("#detalles_mot").toggle('slow');
}

function modal_retro() {
    $('#modal_retro').modal({
        backdrop: 'static',
        keyboard: false
    })
}

function modal_detalle_calendario(fecha) {

    $.post("php/valida_dia_pendientes.php", {
        fechas: fecha
    }, function (data) {
        $("#contenido").html(data); //Carga los elementos al body/content del modal
        $('#detalle').modal('toggle'); // eManada a llamar el modal
    });
}

$('.numeros').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});


$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip()
});


function myTimer() {

    var hora = new Date();
    var myhora = hora.toLocaleTimeString();
    var dia_f = (hora.getDate() < 10) ? "0" + hora.getDate() : hora.getDate();
    var mes = hora.getMonth() + 1
    var mes_f = (mes < 10) ? "0" + mes : mes;
    var dia = (dia_f + "/" + mes_f + "/" + hora.getFullYear());
    var hora7 = hora.getHours();
    var min = hora.getMinutes();
    var sec = hora.getSeconds();

    if ((hora7 >= 13 && hora7 <= 15) && min >= 00 && sec >= 00) {
        $.post("php/valida_dia_pendientes.php", {
            fechas_alertas: dia
        }, function (data) {
            var res = data;
            if (res == 1) {

            } else {
                modal_detalle_calendario(dia);
            }
        });
    }
}



function myTimer_delay() { //jefes

    var hora = new Date();
    var myhora = hora.toLocaleTimeString();
    var dia_f = (hora.getDate() < 10) ? "0" + hora.getDate() : hora.getDate();
    var mes = hora.getMonth() + 1;
    var mes_f = (mes < 10) ? "0" + mes : mes;
    var dia = (dia_f + "/" + mes_f + "/" + hora.getFullYear());
    var hora7 = hora.getHours();
    var min = hora.getMinutes();
    var sec = hora.getSeconds();

    if ((hora7 >= 13 && hora7 <= 15)) {
        $.post("php/valida_dia_pendientes.php", {
            fechas_alertas: dia
        }, function (data) {
            var res = data;
            if (res == 1) {

            } else {
                modal_detalle_calendario(dia);
            }
        });
    }
}
$(document).ready(function () {
    $("#busquedas").keypress(function (event) {
        if (event.keyCode === 13) {
            Buscar_contribuyente();
        }
    });
});


function para_individual() {
    $('#Carga_contri').modal('toggle');
}


function para_individual_pagos() {
    $('#Carga_pago').modal('toggle');
}

function para_reasignar() {
    $('#Reasigna_analista').modal('toggle');
}

// ---------------- Busqueda-------------------------------

$(document).ready(function () {
    $("#agregar_peticion").click(function (e) {
        // alert('HOLIS');
        // ($("#Modal_nu").modal())
        ($("#Modal_form_peticion").modal())
    });
});


// function detalle_ti(tiket) {
//     //alert(tiket);
//     $("#Modal_detalle_tiket_pet").modal();
// }

function detalle_tiket_peticion(tiket) {
    //alert(tiket);
    $("#Modal_detalle_tiket_pet").modal();
    buscar_datos_tiket_peticion(tiket)

}

function Cambia_estatus(RDFDA) {

    $("#Modal_estatus_det").modal();
    buscar_det_estatus(RDFDA)

}

function Cambia_estatus_vis(RDFDA) {

    $("#Modal_estatus_det_VISOR").modal();
    buscar_det_estatus_VISOR(RDFDA)

}

function detalle_tiket_pestamo(tiket) {
    //alert(tiket);
    $("#Modal_detalle_tiket_prestamo").modal();
    buscar_datos_tiket_prestamos(tiket)

}

function detalle_tiket_dispo_cancelados(tiket) {
    //alert(tiket);
    $("#Modal_detalle_tiket_dispo_cancel").modal();
    buscar_datos_tiket_dispo_cancel(tiket)

}

function detalle_tiket_por_aprobar(tiket) {
    //alert(tiket);
    $("#Modal_detalle_tiket_por_aprobar").modal();
    buscar_datos_tiket_POR_APROB(tiket)

}

function detalle_tiket_cancelado_notif(tiket) {
    //alert(tiket);
    $("#Modal_detalle_tiket_cancelado_por_notif").modal();
    buscar_datos_notif_cancel(tiket)

}

function detalle_tiket_dev(tiket) {
    // alert(tiket);
    $("#Modal_detalle_tiket_dev").modal();
    buscar_datos_tiket_dev(tiket)

}

function buscar_datos_tiket_peticion(tiket) {
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            url2: 'php/estatus_cambia_perfil.php',
            type: 'POST',
            dataType: 'html',
            data: {
                tiket: tiket
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#datostiket").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
    $.ajax({
            url: 'php/estatus_cambia_perfil.php',
            type: 'POST',
            dataType: 'html',
            data: {
                tiket: tiket
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            //$("#datostiket").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function MandaTiketImpreso(tiket) {
    $.ajax({
            url: 'php/Crear_Bolante.php',
            type: 'POST',
            dataType: 'html',
            data: {
                tiket: tiket
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#datostiket").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function Estatus_disponible(tiket) {
    $.ajax({
            url: 'php/Estatus_disponible.php',
            type: 'POST',
            dataType: 'html',
            data: {
                tiket_en_busqueda: tiket
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#datostiket").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function buscar_datos_tiket_prestamos(tiket) {
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            type: 'POST',
            dataType: 'html',
            data: {
                tiket_prestamo: tiket
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#datostiketprestamo").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function buscar_datos_tiket_dispo_cancel(tiket) {
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            type: 'POST',
            dataType: 'html',
            data: {
                tiket_dispo_cancel: tiket
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#datos_tiket_dispo_cancel").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function buscar_datos_tiket_POR_APROB(tiket) {
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            type: 'POST',
            dataType: 'html',
            data: {
                tiket_POR_APROBAR: tiket
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#datos_tiket_por_aprob").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function buscar_datos_notif_cancel(tiket) {
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            type: 'POST',
            dataType: 'html',
            data: {
                tiket_cancelado_notif: tiket
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#datos_tiket_cancelado_notf").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function Tiket_cancelado_disponible_reac() {


    $.post("php/Tiket_procesos_dev.php", {
        ticket_cancel: 1
    }, function (data) {
        alert(data);
        location.reload();
    });

}

function Tiket_cancelado_notif() {


    $.post("php/Tiket_procesos_dev.php", {
        ticket_cancel_notif: 1
    }, function (data) {
        alert(data);
        location.reload();
    });

}

function Tiket_Aprueba_salida() {
    $.post("php/Tiket_procesos_dev.php", {
        ticket_aprueba: 1
    }, function (data) {
        alert(data);
        location.reload();
    });

}

function Tiket_niega_salida() {
    $.post("php/Tiket_procesos_dev.php", {
        ticket_Negado: 1
    }, function (data) {
        alert(data);
        location.reload();
    });

}

function buscar_det_estatus(RDFDA) {
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            type: 'POST',
            dataType: 'html',
            data: {
                estatus_det: RDFDA
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#selecciona_estatus").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function buscar_det_estatus_VISOR(RDFDA) {
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            type: 'POST',
            dataType: 'html',
            data: {
                estatus_det_visor: RDFDA
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#selecciona_estatus_1").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

function buscar_datos_tiket_dev(tiket) {
    $.ajax({
            url: 'php/detalle_tiket_peticion.php',
            type: 'POST',
            dataType: 'html',
            data: {
                tiket_dev: tiket
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#datostiketdev").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}

// function Buscar_contribuyente() {
//     var busqueda = $("#bus").val();
//     alert(busqueda);
//     $.post("php/resultados_busquedas.php", {
//         busqueda: busqueda
//     }, function (data) {});
// }

$('#agregar').click(function () {

    var selected = '';
    var RDFDA = '';
    $('#form input[type=checkbox]').each(function () {
        if (this.checked) {

            RDFDA += $(this).val() + ', ';
        }
    });
    if (RDFDA != '') {
        // alert('Has seleccionado: '+RDFDA); 
        $.post("php/Valida_solicitud.php", {
            agrega: RDFDA
        }, function (data) {
            alert(data);
            // location.reload();
            return false;
        });
    } else {
        alert('Debes seleccionar un expediente');
        return false;
    }
    //alert('Has seleccionado 2: '+RDFDA);  
});

$('#cancela').click(function () {
    $.post("php/Valida_solicitud.php", {
        cancela: 1
    }, function (data) {
        //console.log(data); 
    });
    $('#caja_busqueda').val("");
    //location.reload();
    //alert('Has seleccionado 2: '+RDFDA);  
});
$('#pedir1').click(function () {
    var cod1 = document.getElementById("asunto").value;
    var prioridad = document.getElementById("prioridad").value;
    if (prioridad != '') {
        var datos = {
            cod: cod1,
            prioridad: prioridad
        };
        if (cod1 != 0) {
            $.post("php/Valida_solicitud.php", {
                pedir: datos
            }, function (data) {
                alert(data);
                location.reload();
                return false;
            });
        } else {
            alert('Debes seleccionar un Asunto');
            return false;
        }
    }

});
$('#pedir2').click(function () {
    var cod = document.getElementById("asunto").value;

    if (cod != 0) {
        $.post("php/Valida_solicitud.php", {
            pedir: cod
        }, function (data) {

            alert(data) ? "" : location.reload();
        });

    } else {
        alert('Debes seleccionar un Asunto');
        return false;
    }
});

$('#Entrega_boveda').click(function () {
    var selected = '';
    var RDFDA = '';
    $('#form input[type=checkbox]').each(function () {
        if (this.checked) {

            RDFDA += $(this).val() + ', ';
        }
    });
    //alert('Has seleccionado: '+RDFDA); 
    if (RDFDA != '') {
        $.post("php/Cerrar_tiket.php", {
            array: RDFDA
        }, function (data) {
            alert(data);
            location.reload();
            return true;
        });
    } else {
        alert('Debes seleccionar un expediente');
        return false;
    }
});



$('#Entrega_boveda_Parcial').click(function () {

    var selected = '';
    var RDFDA = '';

    $('#form input[type=checkbox]').each(function () {
        if (this.checked) {

            RDFDA += $(this).val() + ', ';

        }
    });
    if (RDFDA != '') {
        $.post("php/Tiket_procesos_dev.php", {
            array: RDFDA,
            //estatus : cod
        }, function (data) {
            alert(data);
            location.reload();
            return true;
        });
    } else {
        alert('Debes seleccionar un expediente');
        return false;
    }
});

// $('#pedir').click(function(){


// if(cod != 0){
//     $.post("php/Valida_solicitud.php", {pedir:cod}, function (data) {

//         alert(data) ? "" : location.reload();
//         }); 

// } else {
//     alert('Debes seleccionar un Asunto');
//     return false;
// }
// });   
$('#Prestar_Tiket').click(function () {
    var selected = '';
    var RDFDA = '';
    $('#form input[type=checkbox]').each(function () {
        if (this.checked) {

            RDFDA += $(this).val() + ', ';
        }
    });
    //alert('Has seleccionado: '+RDFDA); 
    if (RDFDA != '') {
        $.post("php/Estatus_Prestamo_Boveda.php", {
            array: RDFDA
        }, function (data) {
            alert(data);
            location.reload();
            return false;
        });
    } else {
        alert('Debes seleccionar un expediente');
        return false;
    }
});

function Registrar_usuario() {

    var rfc = $("#RFC_CORTO").val();
    var nombre = $("#NOMBRE").val();
    var no_empleado = $("#NO_EMPLEADO").val();
    var correo = $("#CORREO").val();
    var local = $("#id_admin").val();
    var area = $("#id_sub_admin").val();
    var depa = $("#ID_DEPA").val();
    var rfc_jefe = $("#RFC_JEFE").val();
    var id_perfil = $("#ID_PERFIL").val();
    var id_puesto = $("#ID_PUESTO").val();
    var estus = $("#estatus").val();

    var datos = {
        rfc_corto: rfc,
        nombre_u: nombre,
        no_emp: no_empleado,
        correo: correo,
        id_admin: local,
        id_sub_admin: area,
        id_depa: depa,
        jefe: rfc_jefe,
        perfil: id_perfil,
        puesto: id_puesto,
        estatus: estus
    };

    var json = JSON.stringify(datos);
    $.post("php/Valida_R_User.php", {
        array: json
    }, function (data) {
        alert(data);
        location.reload();
    });

}

$('#entregar').click(function () {
    var selected = '';
    var RDFDA = '';
    $('#form input[type=checkbox]').each(function () {
        if (this.checked) {

            RDFDA += $(this).val() + ', ';
        }
    });
    if (RDFDA != '') {
        // alert('Has seleccionado: '+RDFDA); 
        $.post("php/Valida_solicitud.php", {
            entrega: RDFDA
        }, function (data) {
            alert(data);
            location.reload();
            return false;
        });
    } else {
        alert('Debes seleccionar un expediente');
        return false;
    }
    //alert('Has seleccionado 2: '+RDFDA);  
});
$('#Entrega_prestamo_interno').click(function () {
    var selected = '';
    var RDFDA = '';
    $('#form input[type=checkbox]').each(function () {
        if (this.checked) {

            RDFDA += $(this).val() + ', ';
        }
    });
    if (RDFDA != '') {
        //alert('Has seleccionado: '+RDFDA); 
        $.post("php/Cerrar_tiket.php", {
            entrega_interna: RDFDA
        }, function (data) {
            alert(data);
            location.reload();
            return false;
        });
    } else {
        alert('Debes seleccionar un expediente');
        return false;
    }
    //alert('Has seleccionado 2: '+RDFDA);  
});

$('#reiniciar').click(function () {
    var codebar = $("#num_ticket_code_bar").val();
    if (codebar != '') {
        //alert(codebar);

        $.post("php/Procesos_code_bar.php", {
                dato: codebar
            }, function (data) {

            }).done(function (data) {

            })
            .fail(function () {
                console.log("error");
            });
        $('#num_ticket_code_bar').val("");
        AUTOFOCUS();
    } else {
        toastr.warning('Teclea o usé el lector de código para seguir con la solicitud. <br> <center> <button type=\"button\" class = \"btn btn-dark \"> ok </button> </center> ','Notificacion',{
            "progressBar": true
            }
        );
    }
});
$(document).ready(function () {
    $('#Agrega_proc_prev').on('click', function () {
        codigo = $('#num_ticket_code_bar').val();
        if (codigo != '') {
            $.post("php/Procesos_code_bar.php", {
                seleccion: codigo
            }, function (data) {
                //alert(data);
                actualiza_tabla_selec();
                $('#num_ticket_code_bar').val("");
                AUTOFOCUS();
                buscar_datos_ticket_code();
            })

        } else {
            alert('No hay nada que agregar a la selección.');
        }

    })
    $('#cancela_selec').on('click', function () {
        //alert('si entra aqui');
        $.post("php/Procesos_code_bar.php", {
            borrar_select: 1
        }, function (data) {
            actualiza_tabla_selec()
            $('#num_ticket_code_bar').val("");
            AUTOFOCUS();
            buscar_datos_ticket_code();
            //alert(data);
            //location.reload();
        })
    })
    $('#limpia_select').on('click', function () {
        //alert('si entra aqui');
        $.post("php/Procesos_code_bar.php", {
            borrar_select: 1
        }, function (data) {
            actualiza_tabla_selec()
            $('#num_ticket_code_bar').val("");
            AUTOFOCUS();
            buscar_datos_ticket_code();
            //alert(data);
            //location.reload();
        })
    })

    // 

});

function actualiza_tabla_selec() {
    //alert('entra aqui')
    $.ajax({
            url: "php/Busqueda_codebar.php",
            type: "POST",
            dataType: "html",
            data: {
                user_mov: 1
            },
        })
        .done(function (respuesta) {
            //alert(respuesta);
            $("#Historial_mov_del_dia_x_user").html(respuesta);
        })
        .fail(function () {
            console.log("error");
        });

}



function integra(RDFDA) {

    location.href = "integracion.php?RDFDA=" + RDFDA;
    // buscar_datos_observaciones_vis(RDFDA)

}


function Registrar_Sub_administracion() {

    var admin = $("#id_admin_1").val();
    var nombre_sub = $("#nombre_area").val();
    var datos = {
        admin: admin,
        nombre_sub: nombre_sub,
    };
    //  var json = JSON.stringify(datos);
    // alert('Si entra aqui' + json);
    if (nombre_sub != "") {
        $.post("php/ra_area.php", {
            array: datos
        }, function (data) {
            //alert(data);
            location.reload();
        });
    } else {
        alert('No puede dejar en blanco el nombre de la Sub Administración.')
    }
    //  //location.reload();

}


function Actualiza_Sub_administracion() {

    var admin = $("#num_admin").val();
    var sub_admin_asoc = $("#id_sub_admin_b").val();
    var nombre_sub = $("#nombre_area_1").val();
    var estatus = $('input:radio[name=Estatus_activo]:checked').val();

    var datos = {
        admin: admin,
        sub_admin_asoc: sub_admin_asoc,
        nombre_sub: nombre_sub,
        estatus: estatus,

    };
    // var json = JSON.stringify(datos);
    //alert('Si entra aqui' + json);    
    if (nombre_sub != "") {
        $.post("php/Ac_area.php", {
            array2: datos
        }, function (data) {
            alert(data);
            location.reload();

        });
    } else {
        alert('No puede dejar en blanco el nombre de la Sub Administración.')
    }


}

function Actualiza_autoridad() {

    var id_autoridad = $("#id_autoridad").val();
    var Nombre_autor = $("#Nombre_autor").val();
    var estatus = $('input:radio[name=estatus]:checked').val();

    var datos = {
        id_autoridad: id_autoridad,
        Nombre_autor: Nombre_autor,
        estatus: estatus
    };
    //  var json = JSON.stringify(datos);
    //  alert('Si entra aqui' + json);    
    if (Nombre_autor != "") {
        $.post("php/Ac_area.php", {
            autoridad: datos
        }, function (data) {
            alert(data);
            location.reload();

        });
    } else {
        alert('No puede dejar en blanco el nombre de la Sub Administración.');
    }

}

function Registrar_Administracion() {

    var nom_admin = $("#nombre_area").val();
    var nom_admin_cort = $("#nombre_area_corto").val();
    var datos = {
        nom_admin: nom_admin,
        nom_admin_cort: nom_admin_cort,
    };
    // var json = JSON.stringify(datos);
    // alert('Si entra aqui' + json);
    //location.reload();
    $.post("php/ra_admin.php", {
        array: datos
    }, function (data) {
        //alert(data);
        location.reload();
    });
    //  //location.reload();

}

function Actualiza_Administracion() {

    var admin_asoc = $("#id_admin").val();
    var nombre_admin_cam = $("#nombre_admin_cam").val();
    var nombre_cort_admin_cam = $("#nombre_cort_admin_cam").val();
    var estatus = $('input:radio[name=Estatus]:checked').val();

    var datos = {
        admin_asoc: admin_asoc,
        nombre_admin_cam: nombre_admin_cam,
        nombre_cort_admin_cam: nombre_cort_admin_cam,
        estatus: estatus,
    };
    //    var json = JSON.stringify(datos);
    //   alert('Si entra aqui' + json);    
    $.post("php/Ac_admin.php", {
        array: datos
    }, function (data) {
        alert(data);
        location.reload();

    });


}

function Registrar_departamento() {

    var admin = $("#id_admin").val();
    var sub = $("#id_sub_admin").val();
    var nombre_dep = $("#nombre_dep").val();
    var datos = {
        admin: admin,
        sub: sub,
        nombre_dep: nombre_dep,
    };
    //  var json = JSON.stringify(datos);
    //  alert('Si entra aqui' + json);
    $.post("php/ra_dep.php", {
        array: datos
    }, function (data) {
        //alert(data);
        location.reload();
    });
    //  //location.reload();

}

function Registra_autoridad() {

    var nombre_aut = $("#nombre_autoridad").val();
    var num_aut = $("#numero_autoridad").val();
    var datos = {
        nombre_aut: nombre_aut,
        num_aut: num_aut
    };
    //  var json = JSON.stringify(datos);
    //  alert('Si entra aqui' + json);
    if (nombre_aut != '' || num_aut != '' || nombre_aut != '' && num_aut != '') {
        $.post("php/Ac_area.php", {
                re_autoridad: datos
            })
            .done(function (data) {
                alert(data);
                location.reload();
            })
            .fail(function () {
                console.log("error");
            });
    } else {
        alert('No deje los requisitos marcados en blanco.');
    }
    //  //location.reload();

}

function Actualiza_departamento() {

    var admin = $("#num_admin").val();
    var sub = $("#id_sub_admin_b").val();
    var dep_asoc = $("#deptos_f").val();
    var nombre_dep = $("#nombre_dep_cam").val();
    var estatus = $('input:radio[name=Estatus_activo]:checked').val();

    var datos = {
        admin: admin,
        sub: sub,
        nombre_dep: nombre_dep,
        dep_asoc: dep_asoc,
        estatus: estatus,

    };
    if (nombre_dep != "") {
        $.post("php/Ac_dep.php", {
            array2: datos
        }, function (data) {
            alert(data);
            location.reload();

        });
    } else
        alert('No puede dejar en blanco el nombre del departamento a actualizar');
    //    var json = JSON.stringify(datos);
    //   alert('Si entra aqui' + json);    



}
$(buscar_nombre_cambio());

function buscar_nombre_cambio(consulta) {
    $.ajax({
            url: 'php/Obtener_combos.php',
            type: 'POST',
            dataType: 'html',
            data: {
                nombre_emp: consulta
            },
        })
        .done(function (respuesta) {

            $("#nombres_lista").html(respuesta);
            // console.log(respuesta);
            //alert(respuesta);
        })
        .fail(function () {
            console.log("error");
        });
}



$(document).on('keyup', '#nombres_lista', function () {
    var valor = $(this).val();

    if (valor != "") {
        buscar_nombre_cambio(valor);
    } else {
        buscar_nombre_cambio();
    }
});


$(document).ready(function () {
    $('#buscar_contri').on('click', function () {
        var text = $('#rfc_contri').val();
        $.post("php/Obtener_combos.php", {
            rfc: text
        }, function (data) {
            $("#det_exp").html(data);
        })
    })
    $('#det_exp').change(function () {
        $('#det_exp option:selected').each(function () {
            id_det = $(this).val();
            // alert(id_det)

            $.post("php/Obtener_combos.php", {
                info_det: id_det
            }, function (data) {
                $("#div_ino").html(data);
            })
        })
    })

})
$(document).ready(function(){
    $('#id_sub_admin_b').change(function () {
        $('#id_sub_admin_b option:selected').each(function () {
            sub = $(this).val();
           
            $.post("php/consulta_datos_user.php", {
                auto_sbu_name: sub
            }, function (data) {
            }).done(function(data){
                    $("#nombre_sub_admin2").val(data);
            })
        })
    })
   })
   $(document).ready(function(){
    $('#deptos_f').change(function () {
        $('#deptos_f option:selected').each(function () {
            dep = $(this).val();
           
            $.post("php/consulta_datos_user.php", {
                auto_dep_name: dep
            }, function (data) {
            }).done(function(data){
                    $("#nombre_dep_cam").val(data);
            })
        })
    })
   })
   $(document).ready(function(){
    $('#id_admin').change(function () {
        $('#id_admin option:selected').each(function () {
            admin = $(this).val();
           
            $.post("php/consulta_datos_user.php", {
                auto_admin_name: admin
            }, function (data) {
            }).done(function(data){
                    $("#nombre_admin_cam").val(data);
            })
        })
      })
      $('#id_admin').change(function () {
        $('#id_admin option:selected').each(function () {
            admin = $(this).val();
           
            $.post("php/consulta_datos_user.php", {
                auto_admin_name_corto: admin
            }, function (data) {
            }).done(function(data){
                    $("#nombre_cort_admin_cam").val(data);
            })
        })
      })
   })
$(document).ready(function(){
    $('#cargas_diarias').on('click',function(){
        $.post("php/valida_carga_masiva_2.php",{aviso:1},function(data){
            //alert(data)
              toastr.success(data,"Notificación",{
                  "progressBar": true
              })
        })
    })
    $('#carga_expedientes').on('click',function(){
        $.post("php/valida_carga_masiva_2.php",{aviso2:1},function(data){
            //alert(data)
              toastr.success(data,"Notificación",{
                  "progressBar": true
              })
        })
    })
    $('#cargas_masiv').on('click',function(){
        $.post("php/valida_carga_masiva_2.php",{aviso3:1},function(data){
            //alert(data)
              toastr.success(data,"Notificación",{
                  "progressBar": true
              })
        })
    })
    $('#carga_expedientes_masiv').on('click',function(){
        $.post("php/valida_carga_masiva_2.php",{aviso4:1},function(data){
            //alert(data)
              toastr.success(data,"Notificación",{
                  "progressBar": true
              })
        })
    })
   
})