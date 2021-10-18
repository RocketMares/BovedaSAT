	$(document).ready(function(){
                                
        var consulta;
                                                                          
         //hacemos focus al campo de búsqueda
        $("#busqueda_empleado").focus();
                                                                                                    
        //comprobamos si se pulsa una tecla
        $("#busqueda_empleado").keyup(function(e){
                                     
              //obtenemos el texto introducido en el campo de búsqueda
              consulta = $("#busqueda_empleado").val();
                                                                           
              //hace la búsqueda
                                                                                  
              $.ajax({
                    type: "POST",
                    url: "../php/buscar_empleado.php",
                    data: "b="+consulta,
                    dataType: "html",
                    beforeSend: function(){
                          //imagen de carga
                          $("#res").html("<p align='center'><img src='img/carga.gif' /></p>");
                    },
                    error: function(){
                          alert("error petición ajax");
                    },
                    success: function(data){                                                    
                          $("#res").empty();
                          $("#res").append(data);
                                                             
                    }
              });
                                                                                  
                                                                           
        });
                                                                   
});