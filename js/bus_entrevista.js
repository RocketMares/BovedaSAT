	$(document).ready(function(){
                                
        var consulta;
                                                                          
         //hacemos focus al campo de búsqueda
        $("#Entrevista").focus();
                                                                                                    
        //comprobamos si se pulsa una tecla
        $("#Entrevista").keyup(function(e){
                                     
              //obtenemos el texto introducido en el campo de búsqueda
              consulta = $("#Entrevista").val();
                                                                           
              //hace la búsqueda
                                                                                  
              $.ajax({
                    type: "POST",
                    url: "php/buscar_entrevista.php",
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

$(document).ready(function(){
                                
      var consulta;
                                                                        
       //hacemos focus al campo de búsqueda
      $("#Analista").focus();
                                                                                                  
      //comprobamos si se pulsa una tecla
      $("#Analista").keyup(function(e){
                                   
            //obtenemos el texto introducido en el campo de búsqueda
            consulta = $("#Analista").val();
                                                                         
            //hace la búsqueda
                                                                                
            $.ajax({
                  type: "POST",
                  url: "php/buscar_entrevista.php",
                  data: "ANALISTA_NUEVO="+consulta,
                  dataType: "html",
                  beforeSend: function(){
                      //imagen de carga
                      $("#res2").html("<p align='center'><img src='../img/carga.gif' /></p>");
                },
                  error: function(){
                        alert("error petición ajax");
                  },
                  success: function(data){                                                    
                        $("#res2").empty();
                        $("#res2").append(data);
                                                           
                  }
            });
                                                                                
                                                                         
      });
                                                                 
});