var det = $('#Num_det').val();
var resol = $('#id_resol').val();
var rfc = $('#RFC_contri').val();
var razon = $('#razon_social').val();
var aut = $('#autoridad_selec').val();
var fec_det = $('#fecha_det').val();
var emp = $('#empleado_selec').val();
var fec_inv = $('#fecha_inventario').val();
var estatus = $('#Estatus_cred').val();




function registro_det() {

    if ($("#Num_det").val() == '') {
        toastr.warning('No puedes dejar el Número determinante en blanco .', 'Notificación:', {
            "progressBar": true
        });
    } else {
        if ($("#RFC_contri").val().length < 4) {
            toastr.warning('No puedes registrar un RFC con menos de 4 caracteres.', 'Notificación:', {
                "progressBar": true
            });
        } else {
            if ($("#razon_social").val() == '') {
                toastr.warning('No puedes registrar la razón social en blanco', 'Notificación:', {
                    "progressBar": true
                });
            } else {
                if ($("#autoridad_selec").val() == 0) {
                    toastr.warning('Debes seleccionar un autoridad determinante', 'Notificación:', {
                        "progressBar": true
                    });
                } else {
                    if ($("#fecha_det").val() == '') {
                        toastr.warning('Debes agregar la fecha de la determinante', 'Notificación:', {
                            "progressBar": true
                        });
                    } else {
                        if ($("#empleado_selec").val() == 0) {
                            toastr.warning('Debes asignarla a un empleado vigente', 'Notificación:', {
                                "progressBar": true
                            });
                        } else {
                            if ($("#fecha_inventario").val() == '') {
                                toastr.warning('Debes agregar la fecha de inventario o captura', 'Notificación:', {
                                    "progressBar": true
                                });
                            } else {
                                if ($("#Estatus_cred").val() == 0) {
                                    toastr.warning('Debes seleccionar el estado de la determinante si esta en "Baja" o "Activa"', 'Notificación:', {
                                        "progressBar": true
                                    });
                                } else {
                                    Manda_datos_det_indi();
                                }
                            }

                        }
                    }
                }
            }
        }
    }
}

function Manda_datos_det_indi(){
var det = $('#Num_det').val();
var resol = $('#id_resol').val();
var rfc = $('#RFC_contri').val();
var razon = $('#razon_social').val();
var aut = $('#autoridad_selec').val();
var fec_det = $('#fecha_det').val();
var emp = $('#empleado_selec').val();
var fec_inv = $('#fecha_inventario').val();
var estatus = $('#Estatus_cred').val();
if (resol == '') {
    datos = {
        det:det,
        rfc:rfc,
        razon:razon,
        aut:aut,
        fec_det:fec_det,
        emp:emp,
        fec_inv:fec_inv,
        estatus:estastus
        
    }
    var json = JSON.stringify(datos);
    $.post("php/valida_carga_indiv.php",{data1:json},function(data){
        toastr.success(data, 'Notificación:', {
            "progressBar": true
        });
    })


    } else{
        datos ={ 
        det:det,
        resol:resol,
        rfc:rfc,
        razon:razon,
        aut:aut,
        fec_det:fec_det,
        emp:emp,
        fec_inv:fec_inv,
        estatus:estatus
        }
        var json = JSON.stringify(datos);
        $.post("php/valida_carga_indiv.php",{data:json},function(data){
            toastr.success(data, 'Notificación:', {
                "progressBar": true
            });
        })
}

}