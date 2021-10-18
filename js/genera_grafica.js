$(document).ready(function(){
                                
    var consulta;
                                                                      
     //hacemos focus al campo de búsqueda
    $("#years").focus();
                                                                                                
    //comprobamos si se pulsa una tecla
    $("#years").click(function(e){
    //$("#years").keyup(function(e){
                                 
          //obtenemos el texto introducido en el campo de búsqueda
          consulta = $("#years").val();
        // consulta = 2019                                                            
          //hace la búsqueda
                                                                              
          $.ajax({
                type: "POST",
                url: "php/buscar_graf_año.php",
                data: "b="+consulta,
                dataType: "html",
                beforeSend: function(){
                      //imagen de carga
                      $("#GRAF").html("<p align='center'><img src='img/carga.gif' /></p>");
                },
                error: function(){
                      alert("error petición ajax");
                },
                success: function(data){  
                    //alert(data);                                                  
                      $("#GRAF").empty();
                      $("#GRAF").append(data);
                                                         
                }
          });
                                                                              
                                                                       
    });
                                                               
});