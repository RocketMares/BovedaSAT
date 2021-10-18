
   
    $('#subir').on('click',function(){
        var miArchvio = $("#archvioID").prop('files')[0];
        var formData_example = new FormData($(".form_example")[0]);
        formData_example.append('archvioID',miArchvio);
        console.log(miArchvio)
        $.ajax({
        url: "./php/valida_carga_server.php",
        type: "POST",
        contentType: false,
        processData: false,
        data: formData_example,
            }) .done(function(respuesta){
            toastr.success(respuesta, 'Notificación:', {
                "progressBar": true
            })
        })
       
    });


