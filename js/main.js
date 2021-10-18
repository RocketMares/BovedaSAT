$(buscar_datos());

function buscar_datos(consulta){
	$.ajax({
		url: 'php/buscar.php' ,
		type: 'POST' ,
		dataType: 'html',
		data: {consulta: consulta},
	})
	.done(function(respuesta){
		
		$("#datos").html(respuesta);
	})
	.fail(function(){
		console.log("error");
	});
}

$(document).on('keyup','#num_ticket_code_bar', function(){
	var valor = $(this).val();
	if (valor != "") {
		buscar_datos_ticket_code(valor);
	}else{
		buscar_datos_ticket_code();
	}
});

// $(document).on('#caja_busqueda',$('#buscar_docs').click(function(){
// 	 	var valor = $(this).val();
// 		if (valor != "") {
// 	 		buscar_datos(valor);
// 	 	}else{
// 	 		buscar_datos();
// 	 	}
// 	 }));

// function buscar_datos_pet(consulta){
// 	$.post({
// 		url: 'php/Creando_vistas.php' ,
// 		type: 'GET' ,
// 		dataType: 'html',
// 		data: {consulta: consulta},
// 	})
// 	.done(function(respuesta){
		
// 		$("#datos").html(respuesta);
// 	})
// 	.fail(function(){
// 		console.log("error");
// 	});
// }
function manda_busqueda(){
	var valor = $('#caja_busqueda').val();
  	if (valor != "") {
  		buscar_datos(valor);
  	}else{
  		buscar_datos();
  	}
}
//  $(document).on('keyup','#caja_busqueda', function(){
//  	var valor = $(this).val();
//  	if (valor != "") {
//  		buscar_datos(valor);
//  	}else{
//  		buscar_datos();
//  	}
//  });
 function buscar_datos_pet(consulta){
 	$.ajax({
 		url: 'php/Creando_vistas.php' ,
 		type: 'GET' ,
 		dataType: 'html',
 		data: {consulta: consulta},
 	})
 	.done(function(respuesta){
		
 		$("#datos").html(respuesta);
 	})
 	.fail(function(){
 		console.log("error");
 	});
 }

$(document).on('keyup','#consulta_tik_pet', function(){
	var valor = $(this).val();
	console.log(valor);
	if (valor != "") {
		buscar_datos_pet(valor);
	}else{
		buscar_datos_pet();
	}
});
function consulta_tik_prest(consulta){
	$.ajax({
		url: 'php/Creando_vistas.php' ,
		type: 'GET' ,
		dataType: 'html',
		data: {consulta: consulta},
	})
	.done(function(respuesta){
		
		$("#datos").html(respuesta);
	})
	.fail(function(){
		console.log("error");
	});
}


$(document).on('keyup','#consulta_tik_prest', function(){
	var valor = $(this).val();
	console.log(valor);
	if (valor != "") {
		consulta_tik_prest(valor);
	}else{
		consulta_tik_prest();
	}
});
function buscar_datos_dev(consulta){
	$.ajax({
		url: 'php/Creando_vistas.php' ,
		type: 'GET' ,
		dataType: 'html',
		data: {consulta: consulta},
	})
	.done(function(respuesta){
		
		$("#datos").html(respuesta);
	})
	.fail(function(){
		console.log("error");
	});
}


$(document).on('keyup','#consulta_tik_dev', function(){
	var valor = $(this).val();
	console.log(valor);
	if (valor != "") {
		buscar_datos_dev(valor);
	}else{
		buscar_datos_dev();
	}
});


