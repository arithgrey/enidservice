/**/
function carga_contactos_solo_llamar_despues(){

	url =  "../base/index.php/api/ventas_tel/llamar_despues/format/json/";		
	data_send = {"id_persona" : get_persona() , "id_usuario" : get_id_usuario()};
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_info_agendados_llamar_despues" , "Cargando ... ", 1 );
			}
	}).done(function(data){			
		
		llenaelementoHTML(".place_info_agendados_llamar_despues" , data);
		
		$(".llamada_hecha_llamar_despues").click(function(e){

			id_base_telefonica =  e.target.id;
			set_id_base_telefonica(id_base_telefonica);
			recorre_web_version_movil();
			/**/

		});
		$(".form_tipificacion_llamar_despues").submit(registrar_avance_llamar_despues);


	}).fail(function(){			
		show_error_enid(".place_info_agendados_llamar_despues" , "Error ... ");
	});		

}
/**/
function marca_llama_hecha_comentario(){	
	url =  "../base/index.php/api/ventas_tel/marca_llamada_hecha_posterior_comentario/format/json/";		
	data_send = {"id_persona" : get_persona() , "id_usuario" : get_id_usuario()};
	
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_registro_cometario_posterior_llamada" , "Cargando ... ", 1 );
			}
	}).done(function(data){			

		show_response_ok_enid(".place_convertir_cliente" , "Información actualizada!");										
		cargar_num_agendados();
		set_flag_estoy_en_agendado(1);

	}).fail(function(){			
		show_error_enid(".place_registro_cometario_posterior_llamada" , "Error ... ");
	});		
}
/**/

function registrar_avance_llamar_despues(e){

	val_tipificacion =  $("#tipificacion_llamar_despues").val();		
	tmp_tel = get_tmp_tel();
	$("#telefono_info_contacto").val(tmp_tel);			
	set_telefono(tmp_tel);
	set_referencia_email(0);	
	reset_form_agenda();
	recorre_web_version_movil();	

	/*Cuando se tiene que registrar la información de la persona */
	if (val_tipificacion ==  "1" || val_tipificacion ==  "9" ){				

		$('.agregar_posible_cliente_btn').tab('show'); 			
		
	}else if(val_tipificacion ==  "8"){
		/*Mostramos el form y seteamos a 1 sólo enviar referencia*/
		set_referencia_email(1);
		$('.agregar_posible_cliente_btn').tab('show'); 							
		
	}else if(val_tipificacion == "2" ){
		/*Cuando pide llamar después, lanzar formulario*/
		$('.btn_agendar_llamada_base_marcacion').tab('show'); 				

		/**/		
	}else{			
		/*Registra tipificación*/
		registra_tipificacion_llamada_seguimiento();
	}


	e.preventDefault();
}
/***/
function registra_tipificacion_llamada_seguimiento(){

	url =  "../base/index.php/api/ventas_tel/prospecto/format/json/";	
	data_send = $(".form_tipificacion_llamar_despues").serialize()+"&" + $.param({"telefono" : get_telefono() , "id_usuario" : get_id_usuario() });

	$.ajax({
			url : url , 
			type : "PUT" ,
			data: data_send , 
			beforeSend: function(){
				show_load_enid(".place_update_prospecto" , "Cargando ..." , 1 );
			}
		}).done(function(data){	

			$('.tab_ejemplos_disponibles').tab('show'); 						
			$('.base_tab_agendados').tab('show'); 						
			carga_contactos_solo_llamar_despues();					
			recorre_web_version_movil();
			cargar_num_agendados();
			
		}).fail(function(){
			show_error_enid(".place_update_prospecto" , "Error al cargar ..."); 
	});
	
}