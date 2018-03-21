/**/
/**/
/**/
function get_proyectos_persona(){
	/**/	
	url =  "../portafolio/index.php/api/portafolio/proyecto_persona/format/json/";	
	data_send =  {"id_persona" : get_persona() , "usuario_validacion" : 0};				

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){							
		/**/
		llenaelementoHTML(".place_proyectos" , data);				

		$(".solicitar_desarrollo").click(function(e){
			id_proyecto =  e.target.id;	
			set_proyecto(id_proyecto);
			carga_tikets_usuario();
		});
		/**/
		$(".btn_clientes").click(carga_clientes);
		$(".form_q_servicios").submit();
		$(".persona_proyecto").click(renovar_servicio);
		/**/

	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});		
}
/**/
function registra_ticket(e){

	url =  "../portafolio/index.php/api/tickets/ticket/format/json/";	
	data_send = $(".form_ticket").serialize()+"&"+ $.param({ "id_usuario" : get_id_usuario()});				
	
	

		$.ajax({
				url : url , 
				type: "POST",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_registro_ticket" , "Cargando ... ", 1 );
				}
		}).done(function(data){																

			llenaelementoHTML(".place_registro_ticket" , "A la brevedad se realizará su solicitud!");							
			set_id_ticket(data); 
			carga_info_detalle_ticket();
			/**/

						

		}).fail(function(){			
			show_error_enid(".place_registro_ticket" , "Error ... ");
		});	
					
	e.preventDefault();
}
/**/


/**/

/**/
function actualizar_estatus_ticket(e){
	
	nuevo_estado= e.target.id;
	url =  "../portafolio/index.php/api/tickets/status/format/json/";	
	data_send =  {"id_ticket" : get_id_ticket() , "status" : nuevo_estado };				

	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){									
		carga_tikets_usuario();		
	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});		
}
/**/
/**/
/**/
/**/

/**/
function mover_ticket_depto(e){


	url =  "../portafolio/index.php/api/tickets/ticket/format/json/";	
	data_send = $(".form_mover_ticket_depto").serialize()+"&"+$.param({"id_ticket" : get_id_ticket() });				

	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){							
		
		$('#btn_renovar_servicio').tab('show'); 
		$('.base_tab_clientes').tab('show'); 

		carga_tikets_usuario();
		

	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});	

	e.preventDefault();
}
/**/
function set_flag_mostrar_solo_pendientes(n_val){
	flag_mostrar_solo_pendientes = n_val;
}
/**/
function get_flag_mostrar_solo_pendientes(){
	return  flag_mostrar_solo_pendientes;	
}
/**/
function set_id_proyecto_persona(n_id_proyecto_persona){
	id_proyecto_persona =  n_id_proyecto_persona;
}
/**/
function get_id_proyecto_persona(){
	return id_proyecto_persona;
}
/**/
function set_id_servicio(n_id_servicio){
	id_servicio =  n_id_servicio;
}
/**/
function get_id_servicio(){
	return id_servicio;
}
/**/

