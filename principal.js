var red_social = 0;
var servicio =  0; 

$(document).ready(function(){
	$("footer").ready(carga_objetivos_dia);
	$("footer").ready(carga_info_registros);
	$("#form_registro_contacto").submit(registra_contacto);
	$(".productividad_btn").ready(cargar_productividad);
	$('#datetimepicker4').datepicker();
	$('#datetimepicker5').datepicker();	
	$(".form_busqueda_actividad_enid").submit(cargar_productividad);
	$("#form_update_correo").submit(actualiza_contactos);
	$("#form_descargar_contactos").submit(descargar_contactos);
	$(".mensaje_red_social").submit(registrar_mensaje_red_social);

	$(".servicio_red_social").change(function(){
		set_servicio($(".servicio_red_social").val() );
		carga_mensaje_red_social();
	});

	$(".servicio_red_social_ml").change(function(){
		set_servicio($(".servicio_red_social_ml").val() );
		carga_mensaje_red_social();
	});

	
	$(".btn_tareas_fb").click(function(){
		set_red_social(1);	
		set_servicio($(".servicio_red_social").val() );
		carga_mensaje_red_social();
	});

	$(".btn_tareas_mercado_libre").click(function(){
		set_red_social(2);	
		set_servicio($(".servicio_red_social_ml").val() );
		carga_mensaje_red_social();
	});
	
	
	
});
/**/
function registra_contacto(e){
	
	url =  "../base/index.php/api/base/prospecto/format/json/";	
	data_send =  $("#form_registro_contacto").serialize();

	$.ajax({
			url : url , 
			type: "POST",
			data: $("#form_registro_contacto").serialize(), 
			beforeSend: function(){
				show_load_enid(".place_registro" , "Cargando ... ", 1 );
			}
	}).done(function(data){										
			
			//console.log(data);			
			llenaelementoHTML(".place_registro" , data );			
			document.getElementById("form_registro_contacto").reset();
			carga_info_registros();				
			
		}).fail(function(){
			show_error_enid(".place_registro" , "Error ... al cargar portafolio.");
	});
	e.preventDefault();
}
/**/
function actualiza_contactos(e){

	url =  "../base/index.php/api/base/prospecto/format/json/";	
	data_send =  $("#form_update_correo").serialize();

	$.ajax({
			url : url , 
			type: "PUT",
			data: $("#form_update_correo").serialize(), 
			beforeSend: function(){
				show_load_enid(".place_registro" , "Cargando ... ", 1 );
			}
	}).done(function(data){										
			
			console.log(data);			
			llenaelementoHTML(".place_registro" , data );			
			document.getElementById("form_update_correo").reset();
			carga_info_registros();				
			
		}).fail(function(){
			show_error_enid(".place_registro" , "Error ... al cargar portafolio.");
	});
	e.preventDefault();
}
/**/
function carga_info_registros(){
	
	url =  "../base/index.php/api/base/prospecto/format/json/";
	$.ajax({
			url : url , 
			type: "GET",
			data: {}, 
			beforeSend: function(){
				show_load_enid(".place_reporte_mail" , "Cargando ... ", 1 );
			}
	}).done(function(data){										
			
		llenaelementoHTML(".place_reporte_mail" , data);											
			
	}).fail(function(){
			show_error_enid(".place_reporte_mail" , "Error ... al cargar portafolio.");
	});

}
/**/
function cargar_productividad(e){
		
	url =  "../q/index.php/api/productividad/usuario/format/json/";
	$.ajax({
			url : url , 
			type: "GET",
			data: $(".form_busqueda_actividad_enid").serialize(), 
			beforeSend: function(){
				show_load_enid(".place_productividad" , "Cargando ... ", 1 );
		}
	}).done(function(data){										
			
		llenaelementoHTML(".place_productividad" , data);											
			
	}).fail(function(){
			show_error_enid(".place_productividad" , "Error ... al cargar portafolio.");
	});	
	e.preventDefault();
}
/**/
function descargar_contactos(e){

	url =  "../base/index.php/api/base/prospectos/format/json/";
	
	$.ajax({
			url : url , 
			type: "GET",
			data: $("#form_descargar_contactos").serialize(), 
			beforeSend: function(){
				show_load_enid(".place_contactos_disponibles" , "Cargando ... ", 1 );
		}
	}).done(function(data){										
			
		llenaelementoHTML(".place_contactos_disponibles" , data);											
			
	}).fail(function(){
			show_error_enid(".place_contactos_disponibles" , "Error ... al cargar portafolio.");
	});	
	
	e.preventDefault();
}
/**/
function registrar_mensaje_red_social(e){

	data_send =  $(".mensaje_red_social").serialize()+ "&" + $.param({"red_social" : get_red_social() }) ; 


	url =  $(".mensaje_red_social").attr("action");
	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_mensaje_red_social" , "Cargando ... ", 1 );
		}
	}).done(function(data){										
		
		show_response_ok_enid(".place_mensaje_red_social" , "Registrado!");											
		$("#registrar_info_red_social").modal("hide");
		carga_mensaje_red_social();
			
	}).fail(function(){
			show_error_enid(".place_mensaje_red_social" , "Error ... al cargar portafolio.");
	});	
	
	e.preventDefault();

}
/**/
function set_red_social(n_red_social){
	red_social =  n_red_social;
}
/**/
function get_red_social(){
	return red_social;
}
function carga_mensaje_red_social(e){
	
	data_send =  $.param({"red_social" : get_red_social() ,  "servicio" :  get_servicio() }) ; 	
	url =  $(".mensaje_red_social").attr("action");
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".plance_mensaje_red_social" , "Cargando ... ", 1 );
		}
	}).done(function(data){										
		
		if (get_red_social() ==  1 ) {
			$(".parche_mercado_libre").empty();
			$(".parche_fb").html("<div class='plance_mensaje_red_social'></div>");
			
		}else{
			$(".parche_fb").empty();
			$(".parche_mercado_libre").html("<div class='plance_mensaje_red_social'></div>");
			
		}

		llenaelementoHTML(".plance_mensaje_red_social" , data);											
		
			
	}).fail(function(){
			show_error_enid(".plance_mensaje_red_social" , "Error ... al cargar portafolio.");
	});	
	
	e.preventDefault();

	

}
/**/
function set_servicio(n_servicio){

	servicio =  n_servicio;
}
/**/
function get_servicio(){
	return servicio;
}
/**/
function carga_objetivos_dia(){

	data_send =  {}; 
	url =  "../q/index.php/api/objetivos/usuario/format/json/";
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_objetivos" , "Cargando ... ");
		}
	}).done(function(data){										
		
		llenaelementoHTML(".place_objetivos" , data);											
		
			
	}).fail(function(){
			show_error_enid(".place_objetivos" , "Error ... al cargar portafolio.");
	});	
	
	
}



function copiarAlPortapapeles(){
   

  text_info = $(".contenedor_msj_facebook").text();
  $(".contenedor_msj_temporal").show();
  $(".contenedor_msj_temporal").val(text_info);
  $(".contenedor_msj_temporal").select();
  var successful = document.execCommand('copy');
  $(".contenedor_msj_temporal").hide();
}