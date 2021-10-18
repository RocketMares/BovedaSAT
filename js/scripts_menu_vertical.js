
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }
    
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

    function Pendientes_entrevista() {
        location.href="Accesos_directos.php?pendientes=1";
    }

    function Entrevistas_plazos_10() {
        location.href="Accesos_directos.php?plazos_10=1";
    }

    function Entrevistas_plazos_30() {
        location.href="Accesos_directos.php?plazos_30=1";
    }

    function Entrevistas_fuera_plazos() {
        location.href="Accesos_directos.php?fuera_plazos=1";
    }

    function Entrevistas_activas() {
        location.href="Contribuyentes_asig.php?activas=1";
    }

    function Entrevistas_no_activas() {
        location.href="Contribuyentes_asig.php?no_activas=1";
    }

    function Buscar_contribuyente() {
        var busqueda = $("#busquedas").val();
        $("#Modal_res_busqueda_general").modal();
        busqueda_general(busqueda) 
    }
    function busqueda_general(busqueda){
        $.ajax({
            url: 'php/detalle_tiket_peticion.php' ,
            type: 'POST' ,
            dataType: 'html',
            data: {busqueda: busqueda},
        }) 
        .done(function(respuesta){
            //alert(respuesta);
            $("#datosBusRes").html(respuesta);
        })
        .fail(function(){
            console.log("error");
        });
    }
    function detalle_bus(RDFDA) {
        $("#Modal_detalle_RDFDA").modal();
        busqueda_detalle_RDFDA(RDFDA) 
    }

    function busqueda_detalle_RDFDA(RDFDA){
        $.ajax({
            url: 'php/detalle_tiket_peticion.php' ,
            type: 'POST' ,
            dataType: 'html',
            data: {detalle_RDFDA: RDFDA},
        }) 
        .done(function(respuesta){
            //alert(respuesta);
            $("#datosdetalleRDFDA").html(respuesta);
        })
        .fail(function(){
            console.log("error");
        });
    }
