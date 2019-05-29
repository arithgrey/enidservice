"use strict";
let get_proyectos_persona = function(){
	let url =  "../q/index.php/api/portafolio/proyecto_persona/format/json/";
    let data_send =  {"id_persona" : get_persona()};

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){							

		render_enid(".place_proyectos" , data);				

		$(".solicitar_desarrollo").click(function(e){
			id_proyecto =  get_parameter_enid($(this) , "id");	
			set_proyecto(id_proyecto);
			carga_tikets_usuario();
		});

		$(".btn_clientes").click(carga_clientes);
		

	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});		

}
let carga_form_solicitar_desarrollo = function(e){

    let url =  "../q/index.php/api/tickets/form/format/json/";
    let  data_send =  {"id_persona" : get_persona() , id_proyecto : get_proyecto()};


		$.ajax({
				url : url , 
				type: "GET",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
				}
		}).done(function(data){													
			render_enid(".place_proyectos" , data);							
			$(".form_ticket").submit(registra_ticket);
			
			$(".regresar_tickets_usuario").click(function(){
				carga_tikets_usuario();
			});
			$('.summernote').summernote();

		}).fail(function(){			
			show_error_enid(".place_proyectos" , "Error ... ");
	});				

}
let registra_ticket = function(e){


	let url =  "../q/index.php/api/tickets/ticket/format/json/";
	let data_send = $(".form_ticket").serialize()+"&"+ $.param({"id_proyecto" : get_proyecto() , "id_usuario" : get_id_usuario()});

		$.ajax({
				url : url , 
				type: "POST",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_registro_ticket" , "Cargando ... ", 1 );
				}
		}).done(function(data){																

			render_enid(".place_registro_ticket" , "A la brevedad se realizará su solicitud!");							
			set_id_ticket(data); 
			carga_info_detalle_ticket();


								

		}).fail(function(){			
			show_error_enid(".place_registro_ticket" , "Error ... ");
		});	
					
	e.preventDefault();
}
let carga_tikets_usuario = function(){
	
	recorre_web_version_movil();
    let status_ticket = 0;
	if (document.querySelector(".estatus_tickets")) {		
		status_ticket =  $(".estatus_tickets").val();
	}


    let url =  "../q/index.php/api/tickets/ticket/format/json/";
    let data_send =  {id_proyecto : get_proyecto() , "status" : status_ticket };


		$.ajax({
				url : url , 
				type: "GET",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
				}
		}).done(function(data){													


			render_enid(".place_proyectos" , data);										
			$(".solicitar_desarrollo_form").click(carga_form_solicitar_desarrollo);
			/*Ver detalle ticket completo*/
			$(".ver_detalle_ticket").click(function(e){
				set_id_ticket(get_parameter_enid($(this) , "id")); 
				carga_info_detalle_ticket();
			});

			$(".btn_refresh").click(function(){
				carga_tikets_usuario();
			});

			$(".estatus_tickets").change(function(){
				carga_tikets_usuario();
			});
			$(".regresar_serivicios_cliente").click(get_proyectos_persona);	


		}).fail(function(){			
			show_error_enid(".place_proyectos" , "Error ... ");
	});				
}

let carga_info_detalle_ticket = function(){

	let url =  "../q/index.php/api/tickets/detalle/format/json/";
	let data_send =  {"id_ticket" : get_id_ticket()};

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){							

		render_enid(".place_proyectos" , data);				
		$('.summernote').summernote();
		$(".asunto_ticket").click(modificar_asunto);
		$(".btn_mod_ticket").click(actualizar_estatus_ticket);
		$(".form_agregar_tarea").submit(registra_tarea);
		$(".tarea").click(actualiza_tareas);
		recorrepage("#asunto_ticket");

			$(".mostrar_tareas_pendientes").click(muestra_tareas_por_estatus);
			$(".mostrar_todas_las_tareas").click(muestra_todas_las_tareas);

		$(".ver_tickets").click(function(){
			carga_tikets_usuario();
		});

		if (get_flag_mostrar_solo_pendientes() ==  1) {
			muestra_tareas_por_estatus();
		}
		recorrepage(".mostrar_todas_las_tareas");
		


		

	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});		
}

let  actualizar_estatus_ticket = function(e){
	
	let nuevo_estado= get_parameter_enid($(this) , "id");
	let url =  "../q/index.php/api/tickets/status/format/json/";
	let data_send =  {"id_ticket" : get_id_ticket() , "status" : nuevo_estado };

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

let  registra_tarea = function(e){
	
	let requerimiento =  $(".note-editable").html();
	$(".tarea_pendiente").val(requerimiento);
	
	let url =  "../q/index.php/api/tarea/index/format/json/";
	let data_send =  $(".form_agregar_tarea").serialize()+"&"+ $.param({"id_ticket" : get_id_ticket() });

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

let  actualiza_tareas = function(e){
		

	set_id_tarea(get_parameter_enid($(this) , "id"));
	let nuevo_valor = this.value;

	let url =  "../q/index.php/api/tarea/estado/format/json/";
	let data_send = {"id_tarea" : get_id_tarea() ,  "nuevo_valor" : nuevo_valor , "id_ticket" : get_id_ticket() };
	
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
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

let regresar_list_posible_cliente = function(){

	let menu = get_menu_actual();
	switch(menu){

		case "envios_a_validar":
				$(".form_busqueda_posibles_clientes").submit();			 			
			break; 

		case "clientes":
				$(".form_busqueda_clientes").submit();		
			break; 

		case "agendados":
				$(".form_busqueda_agendados").submit();
			break; 
			
		default: 
			
			break; 		
	}
}

let  modificar_asunto = function(e){
	
	recorre_web_version_movil();
	asunto_ticket = get_parameter_enid($(this) , "id");
	$(".mof_asunto").val(asunto_ticket);

	$(".form-actualizar-asunto").submit(actualiza_asunto_ticket);
}
let actualiza_asunto_ticket = function(e){
	
	let data_send = $(".form-actualizar-asunto").serialize()+"&"+$.param({"id_ticket" : get_id_ticket()});
	let url =  "../q/index.php/api/tickets/asunto/format/json/";
	
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){							


		$('.agregar_posible_cliente_btn').tab('show'); 							
		$(".btn_abrir_ticket").tab("show");

		carga_info_detalle_ticket();
		

	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});	

	e.preventDefault();
}
let get_menu_actual = function(){
	return menu_actual;
}

let muestra_tareas_por_estatus = function(){

	showonehideone( ".mostrar_todas_las_tareas" , ".tarea_pendiente"  );
	$(".mostrar_tareas_pendientes").hide();
	set_flag_mostrar_solo_pendientes(1);
}

let muestra_todas_las_tareas = function(){

	showonehideone( ".tarea_pendiente"  , ".mostrar_todas_las_tareas");	
	$(".mostrar_tareas_pendientes").show();
	set_flag_mostrar_solo_pendientes(0);	
}

let set_flag_mostrar_solo_pendientes = function(n_val){
	flag_mostrar_solo_pendientes = n_val;
}

let get_flag_mostrar_solo_pendientes = function(){
	return  flag_mostrar_solo_pendientes;	
}


let get_flag_estoy_en_agendado = function(){
	return flag_estoy_en_agendado;
}
/*
function set_flag_estoy_en_agendado(n_flag_estoy_en_agendado){
    flag_estoy_en_agendado = n_flag_estoy_en_agendado;
}

function get_id_base_telefonica(){
	return id_base_telefonica; 
}

function set_id_base_telefonica(n_id_base_telefonica){
	id_base_telefonica =  n_id_base_telefonica;
}
function set_menu_actual(n_menu_actual){
    menu_actual =  n_menu_actual;
}
*/