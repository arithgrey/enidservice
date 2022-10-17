"use strict";
let cargar_num_envios_a_validacion =  () => {

	let url =  "../q/index.php/api/ventas_tel/num_agendados_validacion/format/json/";
	let data_send =  {"id_usuario" : get_id_usuario()};

	$.ajax({
			url : url ,
			type: "GET",
			data: data_send,
			beforeSend: function(){}
	}).done(function(data){
		render_enid(".place_num_envios_a_validacion" , data);
		recorre_web_version_movil();

	}).fail(function(){
		show_error_enid(".place_correo_envio" , "Error al cargar número de agendados en email");
	});


};

let cargar_num_agendados_email = () => {
	
	let url =  "../q/index.php/api/ventas_tel/num_agendados_email/format/json/";
	let data_send =  {"id_usuario" : get_id_usuario()};

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){																						
		render_enid(".place_numero_agendados_email" , data);

	}).fail(function(){			
		show_error_enid(".place_correo_envio" , "Error al cargar número de agendados en email");
	});		
};

let   cargar_num_agendados = () => {
	
	let url =  "../q/index.php/api/ventas_tel/num_agendados/format/json/";
	let data_send =  {"id_usuario" : get_id_usuario()};
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				sload(".place_llamada_hecha" , "Cargando ... ", 1 );
			}
	}).done(function(data){																						

		render_enid(".place_num_agendados" , data.num_agendados_posibles_clientes);
		render_enid(".place_num_agendados_totales" , data.totales);
		render_enid(".place_num_agendados_llamar_despues" , data.num_agendados_llamar_despues );

		
	

	}).fail(function(){			
		show_error_enid(".place_llamada_hecha" , "Error ... ");
	});		
};

let   cargar_num_clientes_restantes = () => {

	let url =  "../q/index.php/api/ventas_tel/num_clientes_restantes/format/json/";
	let data_send =  {"id_usuario" : get_id_usuario()};
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				sload(".place_llamada_hecha" , "Cargando ... ", 1 );
			}
	}).done(function(data){																						
		render_enid(".place_num_productividad" , data);

	}).fail(function(){			
		show_error_enid(".place_llamada_hecha" , "Error ... ");
	});		
};