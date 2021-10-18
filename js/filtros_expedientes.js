    //----------------COMBOS---------------//FILTROS------------------

    $(document).ready(function () {

        $("#Ocultar").on('click', function () {
            $("#filtros").hide("fast", function () {
                $(this).prev().hide("fast", arguments.callee);
            })

        })
        $("#Monstrar").on('click', function () {
            $("#filtros").show("fast");
            $("#Ocultar").show("fast");
        })


        $('#sub_admin').change(function () {
            $('#sub_admin option:selected').each(function () {
                sub = $(this).val();
                $.post("php/Obtener_combos.php", {
                    id_sub_admin: sub
                }, function (data) {}).done(function (respuesta) {
                    $('#depto').html(respuesta);
                })
            })
        })
      
        $('#quita_filtro').on('click', function () {
            location.href = "Expedientes.php?pagina=1";
        })

        $('#filtra_estructura').on('click', function () {
            sub = $('#sub_admin').val();
            dep = $('#depto').val();



            if (sub != 0 && dep != 0 || dep != 0) {
                createCookie("sub", sub, 1)
                createCookie("dep", dep, 1)
                location.href = "Expedientes.php?estructura=1";
            } else {
                toastr.info('No puedes dejar el campo de subadministracion o departamento vacio para activar este filtro', 'Notificación', {
                    "progressBar": true
                })
            }

        })
        $('#filtra_por_empleado').on('click', function () {
            id_emp = $('#empleados').val();


            if (id_emp != 0) {
                createCookie("nom_emp", id_emp, 1)
                location.href = "Expedientes.php?Usuario=1";

            } else {
                toastr.info('Debes seleccionar un empleado para activar este filtro', 'Notificación', {
                    "progressBar": true
                })
            }

        })
        $('#filtra_num_det').on('click', function () {
            num_det = $('#number_det').val();

            if (num_det != '') {
                createCookie("num_det", num_det, 1)
                location.href = "Expedientes.php?num_det=1";
            } else {
                toastr.info('No puedes dejar el campo de determinante vacio para activar este filtro', 'Notificación', {
                    "progressBar": true
                })
            }
        })

        $('#filtra_por_rfc').on('click', function () {

            if ($('#Filtro_RFC').val() != ''  ) {
                if ($('#Filtro_RFC').val().length > 3) {
                    rfc = $('#Filtro_RFC').val();
                    createCookie("rfc", rfc, 1)
                    location.href = "Expedientes.php?RFC=1";
                }
                else {
                    toastr.info('No puedes usar un RFC menor a 4 caracteres para activar este filtro', 'Notificación', {
                        "progressBar": true
                    });
                }
               
            } else {
                toastr.info('No puedes dejar el campo de folio de Gestor vacio para activar este filtro', 'Notificación', {
                    "progressBar": true
                });
            }

        })

        $('#filtra_por_razon').on('click', function () {
            razon = $('#filtro_razon').val();
            //console.log(razon)
            if (razon != '') {
                createCookie("nombre_razon", razon, 1)
                location.href = "Expedientes.php?razon=1";
            } else {
                toastr.info('No puedes dejar el campo de Num. determinante vacio para activar este filtro', 'Notificación', {
                    "progressBar": true
                });
            }
        })
        $('#filtra_por_estatus_cred').on('click', function () {
            est_cred = $('#estatus_cred').val();

            if (est_cred != 0) {
                createCookie("estatus_cred", est_cred, 1)
                location.href = "Expedientes.php?Cred=1";
            } else {
                toastr.info('Debes seleccionar una opcion en prioridad para activar este filtro', 'Notificación', {
                    "progressBar": true
                });
            }

        })


    })
