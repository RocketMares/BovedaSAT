function filtros_users() { 

    var nombre = $("#nombre_b").val();
    var area = $("#id_sub_admin_b").val();
    var dep = $("#deptos_f").val();
    var perfil = $("#perfil_b").val();

    // console.log(nombre)
    // console.log(area)
    // console.log($(dep).val())
    // console.log(perfil)
  
    if ( ($("#nombre_b").val().length > 1 ) && area == '0' && dep == '0' && perfil == '0')  {
        createCookie("nombre",nombre,1)
        location.href="Expedientes.php?por_nombre=1";
    }else if(($("#nombre_b").val().length > 1 ) && area != '0' && dep == '0' && perfil == '0'){
        createCookie("nombre",nombre,1)
        createCookie("subadmin",area,1)
        location.href="Expedientes.php?por_nomb_sub=1";
    }else if(($("#nombre_b").val().length > 1 ) && area != '0' && dep != '0' && perfil == '0'){
        createCookie("nombre",nombre,1)
        createCookie("subadmin",area,1)
        createCookie("deptos",dep,1)
        location.href="Expedientes.php?por_nomb_sub_dep=1";
    }else if(($("#nombre_b").val().length > 1 ) && area != '0' && dep != '0' && perfil != '0'){
        createCookie("nombre",nombre,1)
        createCookie("subadmin",area,1)
        createCookie("deptos",dep,1)
        createCookie("perfil",perfil,1)
        location.href="Expedientes.php?por_nomb_sub_dep_per=1";
    }else if ( ($("#nombre_b").val().length < 1 ||  $("#nombre_b").val() == " ") && area != '0' && dep == '0' && perfil == '0')  {
        createCookie("subadmin",area,1)
        location.href="Expedientes.php?por_sub=1";
    }else if(($("#nombre_b").val().length < 1 ) && area != '0' && dep != '0' && perfil == '0'){
        createCookie("subadmin",area,1)
        createCookie("deptos",dep,1)
        location.href="Expedientes.php?por_sub_dep=1";
    }else if(($("#nombre_b").val().length < 1 ) && area == '0' && dep == '0' && perfil != '0'){
        createCookie("perfil",perfil,1)
        location.href="Expedientes.php?por_perfil=1";
    }else if(($("#nombre_b").val().length < 1 ) && area != '0' && dep != '0' && perfil != '0'){
        createCookie("perfil",perfil,1)
        createCookie("subadmin",area,1)
        createCookie("deptos",dep,1)
        location.href="Expedientes.php?por_perfil_sub_dep=1";
    }else if(($("#nombre_b").val().length < 1 ) && area == '0' && dep == '0' && perfil == '0'){
        location.href="Expedientes.php?usuarios=1";
    }
  }
  $(document).ready(function () {
    $("#agregar_user").click(function (e) { 
       $("#Modal_form_registrar").modal();
    });
 });
 
 $(document).ready(function() {
   $("#id_admin_A").change(function () {
     $("#ID_DEPA_A").find('option').remove().end().append(
       '<option value="whatever"></option>').val('whatever');
     $("#id_admin_A option:selected").each(function () {
          id_admin = $(this).val();
       $.post("Obtener_Combos.php",{id_admin:id_admin},function (data) {
         $("#id_sub_admin_A").html(data);
       })
     })
   })
 });
 $(document).ready(function() {
   $("#num_admin").change(function () {
     $("#id_sub_admin_b").find('option').remove().end().append(
       '<option value="whatever"></option>').val('whatever');
     $("#num_admin option:selected").each(function () {
          id_admin = $(this).val();
       $.post("Obtener_Combos.php",{id_admin:id_admin},function (data) {
         $("#id_sub_admin_b").html(data);
       })
     })
   })
 });
 
 $(document).ready(function() {
 $("#id_sub_admin_A").change(function () {
   $("#id_sub_admin_A option:selected").each(function () {
        var id_sub_admin = $(this).val();
     $.post("php/Obtener_Combos.php",{id_sub_admin:id_sub_admin},function (data) {
       $("#ID_DEPA_A").html(data);
     })
   })
 })
 });
 

 
 $(document).ready(function() {
 $("#id_sub_admin_b").change(function () {
   $("#deptos_b").find('option').remove().end().append(
     '<option value="whatever"></option>').val('whatever');
   $("#id_sub_admin_b option:selected").each(function () {
     var id_sub_admin = $(this).val();
     $.post("php/Obtener_Combos.php",{id_sub_admin:id_sub_admin},function (data) {
       $("#deptos_b").html(data);
     })
   })
 })
 });
 
 
 $(document).ready(function() {
 $("#id_admin").change(function () {
  $("#ID_DEPA").find('option').remove().end().append(
    '<option value="whatever"></option>').val('whatever');
  $("#id_admin option:selected").each(function () {
       id_admin = $(this).val();
    $.post("php/Obtener_Combos.php",{id_admin:id_admin},function (data) {
      $("#id_sub_admin").html(data);
    })
  })
 })
 });
 
 
 $(document).ready(function() {
 $("#id_admin_A").change(function () {
   $("#ID_DEPA_A").find('option').remove().end().append(
     '<option value="whatever"></option>').val('whatever');
   $("#id_admin_A option:selected").each(function () {
        id_admin = $(this).val();
     $.post("php/Obtener_Combos.php",{id_admin:id_admin},function (data) {
       $("#id_sub_admin_A").html(data);
     })
   })
 })
 });
 
 
 $(document).ready(function() {
 $("#id_sub_admin").change(function () {
 $("#id_sub_admin option:selected").each(function () {
     id_sub_admin = $(this).val();
  $.post("php/Obtener_Combos.php",{id_sub_admin:id_sub_admin},function (data) {
    $("#ID_DEPA").html(data);
  })
 })
 })
 });
 $(document).ready(function() {
 $("#num_admin").change(function () {
  $("#num_admin option:selected").each(function () {
       id_admin = $(this).val();
    $.post("php/Obtener_Combos.php",{id_admin:id_admin},function (data) {
      $("#id_sub_admin_b").html(data);
    })
  })
 })
 });
 $(document).ready(function() {
 $("#id_sub_admin_b").change(function () {
  $("#id_sub_admin_b option:selected").each(function () {
       id_sub_admin = $(this).val();
    $.post("php/Obtener_Combos.php",{id_sub_admin:id_sub_admin},function (data) {
      $("#deptos_f").html(data);
    })
  })
 })
 });
 $(document).ready(function() {
   $("#deptos_f").change(function () {
    $("#deptos_f option:selected").each(function () {
         id_sub_admin1 = $(this).val();
      $.post("php/Obtener_Combos.php",{id_sub_admin1:id_sub_admin1},function (data) {
        $("#nombre_dep_cam").html(data);
      })
    })
   })
   });
 
 
     $(document).ready(function() {
       $("#id_autoridad").change(function () {
        $("#id_autoridad option:selected").each(function () {
             id_sub_admin1 = $(this).val();
          $.post("php/Obtener_Combos.php",{id_autoridad:id_autoridad},function (data) {
            $("#Nombre_autor").text(data);
          })
        })
       })
       });


    function Resultado(){
    var Busqueda = document.getElementById('busqueda_proc').value;
    $.ajax({
      url: 'php/vista_conf_expedientes.php',
      type: 'POST',
      dataType: 'html',
      data: {
          Busqueda_sol_exp: Busqueda
      },
  })
   .done(function (respuesta) {
       location.reload();
   });
  //     $("#datosObservaciones").html(respuesta);
  // })
  // .fail(function () {
  //     console.log("error");
  // });

    //alert(Busqueda);
    }