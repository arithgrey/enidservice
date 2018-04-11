function get_lugar_por_stus_compra(){	
	nuevo_place ="";
	if(get_option("modalidad_ventas") == 0){		
		/**/
		switch(parseFloat(get_option("estado_compra"))){
			case 10:
		        nuevo_place = ".place_resumen_servicio";	        
		        break;
		    case 6:
		        nuevo_place = ".place_servicios_contratados";	        
		        break;
		    case 1:	    	
		        nuevo_place = ".place_servicios_contratados_y_pagados";
		        break;
		    default:       
		} 	
	}else{
		nuevo_place = ".place_ventas_usuario";
	}
	return nuevo_place;
}
/**/
function carga_compras_usuario(){

	place_info = get_lugar_por_stus_compra();  		
	url =  "../portafolio/index.php/api/portafolio/proyecto_persona_info/format/json/";		
	data_send =  { "status": get_option("estado_compra") , "modalidad" : get_option("modalidad_ventas")  };				
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){

				show_load_enid(place_info , "Cargando ... ", 1 );
			}
	}).done(function(data){									
		/**/
		llenaelementoHTML(place_info  , data);								
		$(".solicitar_desarrollo").click(function(e){
			id_proyecto =  e.target.id;	
			set_proyecto(id_proyecto);
			carga_tikets_usuario_servicio();
		});				
		$(".form_q_servicios").submit();		
		$(".resumen_pagos_pendientes").click(cargar_info_resumen_pago_pendiente);
		$(".btn_direccion_envio").click(carga_informacion_envio);
		$(".ver_mas_compras_o_ventas").click(carga_compras_o_ventas_concluidas);
	}).fail(function(){			
		show_error_enid(place_info  , "Error ... ");
	});		
}
/**/
function carga_form_solicitar_desarrollo(e){

	url =  "../portafolio/index.php/api/tickets/form/format/json/";	
	data_send =  {"id_persona" : get_persona() , id_proyecto : get_proyecto()};				

		$.ajax({
				url : url , 
				type: "GET",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
				}
		}).done(function(data){													
			
			llenaelementoHTML(".place_proyectos" , data);							


			$(".form_ticket").submit(registra_ticket);
			$(".regresar_tickets_usuario").click(function(){
				carga_tikets_usuario_servicio();
			});


		}).fail(function(){			
			show_error_enid(".place_proyectos" , "Error ... ");
	});				
}
/**/
function registra_ticket(e){

	url =  "../portafolio/index.php/api/tickets/ticket/format/json/";	
	data_send = $(".form_ticket").serialize()+"&"+ $.param({"id_proyecto" : get_proyecto() , "id_usuario" : get_id_usuario()});				

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
function carga_informacion_envio(e){
	
	id_recibo =  e.target.id;
	set_option("recibo" , id_recibo);
	carga_informacion_envio_complete();
}

function carga_compras_o_ventas_concluidas(){	
	
	place_info = get_lugar_por_stus_compra();  		
	url =  "../portafolio/index.php/api/portafolio/compras_efectivas/format/json/";		
	data_send =  {"modalidad" : get_option("modalidad_ventas"), "page" : get_option("page") };				


	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){

				show_load_enid(place_info , "Cargando ... ", 1 );
			}
	}).done(function(data){									

		llenaelementoHTML(place_info  , data);								
		$(".pagination > li > a, .pagination > li > span").css("color" , "white");	
		$(".pagination > li > a, .pagination > li > span").click(function(e){				
			
			set_option("page", $(this).text());
			carga_compras_o_ventas_concluidas();
			e.preventDefault();				
		});
		
	}).fail(function(){			
		show_error_enid(place_info  , "Error ... ");
	});	
}