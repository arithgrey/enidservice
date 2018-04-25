var id_ticket = 0;
var modulo = 0;
var keyword ="";
function cargar_tareas_venta(e){
	id_proyecto =  e.target.id;	
	set_option( "modulo", 1 );
	carga_tickets_por_proyecto_producto();
}
function set_id_ticket(n_id_ticket){
	id_ticket =  n_id_ticket;
}
/**/
function get_id_ticket(){
	return id_ticket;
}
/**/
function carga_form_solicitar_desarrollo(e){

	if(get_option("modulo") !=  2){
		carga_form_solicitar_desarrollo_interno_usuario_enid();
	}else{

		carga_form_solicitud_desarrollo_interno();
	}				
}
/**/
function carga_form_solicitar_desarrollo_interno_usuario_enid(){
	
		url =  "../portafolio/index.php/api/tickets/form/format/json/";	
		data_send =  { id_proyecto : get_option("id_proyecto")};				

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
					carga_tickets_por_proyecto_producto();
				});


			}).fail(function(){			
				show_error_enid(".place_proyectos" , "Error ... ");
		});
}
/**/

/**/
function carga_form_solicitud_desarrollo_interno(){
	

	set_option("depto",$(".selector_departamento .depto").val()); 
	url =  "../portafolio/index.php/api/tickets/form_proyectos/format/json/";	
	data_send =  {"id_persona" : get_persona() , id_proyecto : get_option("id_proyecto") , "id_departamento" : get_option("id_depto")};				


		$.ajax({
				url : url , 
				type: "GET",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
				}
		}).done(function(data){									

			llenaelementoHTML(".place_proyectos" , data);							
			
			selecciona_select(".contenedor_form_depto .depto" , temporal_depto);

			$(".lista_cliente_ticket").change(carga_lista_servicios_cliente);					

			$(".form_ticket").submit(registra_ticket);
			$(".regresar_tickets_usuario").click(function(){
				carga_tikets_usuario();
			});

			$(".btn_siguiente_ticket").click(function(){						
				showonehideone( ".contenedor_formulario_ticket" , ".btn_siguiente_ticket"  );					
				selecciona_select(".contenedor_form_depto .depto" , get_option("id_depto"));			
			});
					

		}).fail(function(){			
			show_error_enid(".place_proyectos" , "Error ... ");
	});				

}


function registra_ticket(e){

	url =  "../portafolio/index.php/api/tickets/ticket/format/json/";

	data_send = $(".form_ticket").serialize()+"&"+ $.param({"id_proyecto" : get_option("id_proyecto") , "id_usuario" : get_id_usuario()});				
	if (get_option("modulo") == 2) {
		data_send = $(".form_ticket").serialize();					
		
	}			
	


	
		$.ajax({
				url : url , 
				type: "POST",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_registro_ticket" , "Cargando ... ", 1 );
				}
		}).done(function(data){																

			console.log(data);
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
/*
function carga_info_detalle_ticket(){

	url =  "../portafolio/index.php/api/tickets/detalle/format/json/";	
	data_send =  {"id_ticket" : get_id_ticket()};				

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){							

		llenaelementoHTML(".place_proyectos" , data);		
		$(".btn_mod_ticket").click(actualizar_estatus_ticket);
		$(".asunto_ticket").click(modificar_asunto);
		
		$(".form_agregar_tarea").submit(registra_tarea);
		$(".tarea").click(actualiza_tareas);
		recorrepage("#asunto_ticket");
		
			$(".mostrar_tareas_pendientes").click(muestra_tareas_por_estatus);
			$(".mostrar_todas_las_tareas").click(muestra_todas_las_tareas);
		
		$(".ver_tickets").click(function(){
			carga_tickets_por_proyecto_producto();
		});

		if (get_flag_mostrar_solo_pendientes() ==  1) {
			muestra_tareas_por_estatus();
		}
		$('.summernote').summernote();

	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});		
}
*/
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
		carga_tickets_por_proyecto_producto();		
	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});		
}
/**/

/**/


function actualiza_asunto_ticket(e){
	
	data_send = $(".form-actualizar-asunto").serialize()+"&"+$.param({"id_ticket" : get_id_ticket()});	
	url =  "../portafolio/index.php/api/tickets/asunto/format/json/";	
	
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){							

		/**/
		$('.agregar_posible_cliente_btn').tab('show'); 							
		$(".btn_abrir_ticket").tab("show");

		carga_info_detalle_ticket();
		

	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});	

	e.preventDefault();
}
/****************************************************************************************************/
/*Necesario Necesario Necesario Necesario Necesario Necesario Necesario Necesario Necesario Necesario */
function carga_info_detalle_ticket(){

	url =  "../portafolio/index.php/api/tickets/detalle/format/json/";	
	data_send =  {"id_ticket" : get_id_ticket()};				

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				//show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){							

		
		//carga_num_pendientes();
		llenaelementoHTML(".place_proyectos" , data);		
		$(".btn_mod_ticket").click(actualizar_estatus_ticket);
		$(".btn_agregar_tarea").click(function(){		
			show_section_dinamic_button(".seccion_nueva_tarea");
			show_section_dinamic_button(".btn_agregar_tarea");
			recorrepage(".seccion_nueva_tarea");
			/**/
		});
		
		$(".agregar_respuesta").click(carga_formulario_respuesta_ticket);
		$(".comentarios_tarea").click(carga_comentarios_tareas);
		/*Agregar tarea*/

		$(".form_agregar_tarea").submit(registra_tarea);
		$(".tarea").click(actualiza_tareas);
		//recorrepage("#asunto_ticket");
		/**/
			$(".mostrar_tareas_pendientes").click(muestra_tareas_por_estatus);
			$(".mostrar_todas_las_tareas").click(muestra_todas_las_tareas);
		/**/
		$(".ver_tickets").click(function(){
			carga_tikets_usuario();
		});

		if (get_flag_mostrar_solo_pendientes() ==  1) {
			muestra_tareas_por_estatus();
		}
		/**/
		$(".mover_ticket").click(mover_ticket_depto_pre);
		$('.summernote').summernote();


		/**/
	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});		
}
/**/
function carga_formulario_respuesta_ticket(e){
	
	tarea = e.target.id;
	set_tarea(tarea);	
	url =  "../portafolio/index.php/api/tickets/formulario_respuesta/format/json/";	
	data_send =  {"tarea" : tarea};				
	seccion =".seccion_respuesta_"+get_tarea();

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(seccion , "Cargando ... ", 1 );
			}
	}).done(function(data){							
		
		llenaelementoHTML(seccion , data);
		$(".form_respuesta_ticket").submit(registra_respuesta_pregunta);
		/**/
	}).fail(function(){			
		//show_error_enid(".place_proyectos" , "Error ... ");
	});		

}

function carga_comentarios_tareas(e){

	tarea = e.target.id;
	set_tarea(tarea);	
	url =  "../portafolio/index.php/api/tickets/respuesta/format/json/";	
	data_send =  {"tarea" : tarea};				
	seccion =".seccion_respuesta_"+get_tarea();

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(seccion , "Cargando ... ", 1 );
			}
	}).done(function(data){							
		
		llenaelementoHTML(seccion , data);
		
		$(".ocultar_comentarios").click(function(e){

			set_tarea(e.target.id);
			seccion =".seccion_respuesta_"+get_tarea();
			$(seccion).empty();			
		});
		/**/
	}).fail(function(){			
		//show_error_enid(".place_proyectos" , "Error ... ");
	});		


}
/**/
function registra_tarea(e){
	
	requerimiento =  $(".form_agregar_tarea .note-editable").html();		
	url =  "../portafolio/index.php/api/tarea/nueva/format/json/";	
	data_send =  $(".form_agregar_tarea").serialize()+"&"+ $.param({"id_ticket" : get_id_ticket() , "tarea": requerimiento });				

	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){		
								
		carga_info_detalle_ticket();				
	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});			
	
	e.preventDefault();
}
/**/


/**/
function muestra_tareas_por_estatus(){

	showonehideone( ".mostrar_todas_las_tareas" , ".tarea_pendiente"  );
	$(".mostrar_tareas_pendientes").hide();
	set_flag_mostrar_solo_pendientes(1);
}
/**/
function muestra_todas_las_tareas(){

	showonehideone( ".tarea_pendiente"  , ".mostrar_todas_las_tareas");	
	$(".mostrar_tareas_pendientes").show();
	set_flag_mostrar_solo_pendientes(0);	
}
/**/
function carga_tikets_usuario(){
	

	recorre_web_version_movil();
	status_ticket = 0; 	
	if (document.querySelector(".estatus_tickets")) {		
		status_ticket =  $(".estatus_tickets").val();
	}
	keyword = $(".q").val(); 	
	set_keyword(keyword);	
		
	url =  "../portafolio/index.php/api/tickets/ticket_desarrollo/format/json/";			
	data_send = { id_proyecto : get_option("id_proyecto") , "status" : status_ticket , "id_departamento" :  get_option("id_depto") , "keyword" : get_keyword(), "modulo": get_option("modulo") };				
	

		$.ajax({
				url : url , 
				type: "GET",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
				}
		}).done(function(data){													

			llenaelementoHTML(".place_proyectos" , data);										
			$(".solicitar_desarrollo_form").click(carga_form_solicitar_desarrollo);
			/*Ver detalle ticket completo*/
			$(".ver_detalle_ticket").click(function(e){
				set_id_ticket(e.target.id); 
				carga_info_detalle_ticket();
			});
			/**/
			$(".btn_refresh").click(function(){
				carga_tikets_usuario();
			});
			/**/
			$(".estatus_tickets").change(function(){
				carga_tikets_usuario();
			});	
			$(".regresar_serivicios_cliente").click(get_proyectos_persona);	
			
			carga_num_pendientes();
			/**/
		}).fail(function(){			
			show_error_enid(".place_proyectos" , "Error ... ");

	});	
	/**/
	
}
function carga_tickets_por_proyecto_producto(){
	
	
	recorre_web_version_movil();
	status_ticket = 0; 	
	if (document.querySelector(".estatus_tickets")) {		
		status_ticket =  $(".estatus_tickets").val();
	}	
	url =  "../portafolio/index.php/api/tickets/ticket_desarrollo/format/json/";		
	data_send =  {id_proyecto : get_option("id_proyecto") , "status" : status_ticket , "modulo" : get_option("modulo")};				


		$.ajax({
				url : url , 
				type: "GET",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
				}
		}).done(function(data){													


			llenaelementoHTML(".place_proyectos" , data);										
			$(".solicitar_desarrollo_form").click(carga_form_solicitar_desarrollo);
	
			$(".ver_detalle_ticket").click(function(e){
				set_id_ticket(e.target.id); 
				carga_info_detalle_ticket();
			});
			
			$(".btn_refresh").click(function(){
				carga_tickets_por_proyecto_producto();
			});
			
			$(".estatus_tickets").change(function(){
				carga_tickets_por_proyecto_producto();
			});	
			$(".regresar_serivicios_cliente").click(get_proyectos_persona);	
			
			
		}).fail(function(){			
			show_error_enid(".place_proyectos" , "Error ... ");
	});				
}
function actualiza_tareas(e){

	set_id_tarea(e.target.id);
	nuevo_valor = this.value;

	url =  "../portafolio/index.php/api/tarea/estado/format/json/";	
	data_send = {"id_tarea" : get_id_tarea() ,  "nuevo_valor" : nuevo_valor , "id_ticket" : get_id_ticket() };				

	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				//show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){							
		
		
		if (data ==  "cerrado") {
			carga_tikets_usuario();
		}else{
			carga_info_detalle_ticket();					
		}

		
	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});			
}
function mover_ticket_depto_pre(){
	recorre_web_version_movil();
}
function get_keyword(){
	return keyword;
}
/**/
function set_keyword(n_keyword){	
	keyword =  n_keyword;
}
function carga_lista_servicios_cliente(){
	
	/**/		
	set_persona( $(".lista_cliente_ticket").val());
	url =  "../portafolio/index.php/api/tickets/servicios_cliente/format/json/";	
	data_send =  {"id_persona" : get_persona() };				

	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_lista_servicios" , "Cargando ... ", 1 );
			}
	}).done(function(data){							
		/**/		
		llenaelementoHTML(".place_lista_servicios" , data);				

	}).fail(function(){			
		show_error_enid(".place_lista_servicios" , "Error ... ");
	});		


}	