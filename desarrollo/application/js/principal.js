var id_tarea = 0;
var nombre_persona = 0;
var flageditable  =0; 
var llamada =  0;
var campos_disponibles = 0; 
var persona = 0;
var tipo_negocio = 0;
var fuente = 0;
var telefono = 0;
var flag_base_telefonica =0;
var id_proyecto = 0; 
var id_usuario = 0;
var id_ticket = 0;
var nombre_tipo_negocio = "";
var num_agendados ="";
var flag_mostrar_solo_pendientes = 0;
var referencia_email = 0;
var facturar_servicio = 0;
var servicio_requerido = "";
var nombre_ciclo_facturacion ="";
var proxima_fecha_vencimiento = "";
var id_proyecto_persona_forma_pago =  ""; 
var id_proyecto_persona =  "";
var menu_actual = "clientes";
var id_servicio = 0; 
var depto = 0; 
var flag_en_servicio = 0;
$(document).ready(function(){		


	num_departamento = $(".num_departamento").val(); 
	set_option("modulo", 2);
	
	/***/
	$("footer").ready(function(){
		id_depto = $(".num_departamento").val();		
		set_option("id_depto", id_depto);
	});
	/**/
	$(".depto").change(function(){

		id_depto = $(".contenedor_deptos .depto").val();				
		set_option("id_depto", id_depto);
		carga_tikets_usuario();
	});
	/**/
	$(".q").keyup(function(){
		carga_tikets_usuario();
	});


	$("footer").ready(carga_num_pendientes);	
	
	$('.datetimepicker_persona').datepicker();
	$('.datetimepicker4').datepicker();
	$('.datetimepicker5').datepicker();					
	$(".form_busqueda_actividad_enid").submit(cargar_productividad);		
	//$(".btn_mostrar_mas_campos").click(muestra_oculta_campos_persona);
	/*hora*/
	$('.datetimepicker1').timepicker();
	$('.datetimepicker2').datepicker();
	set_option("id_usuario" , $(".id_usuario").val());
	
	$(".li_menu").click(recorre_web_version_movil);		
	$("footer").ready(carga_tikets_usuario);	
	$(".base_tab_clientes").click(carga_tikets_usuario);
	$(".form_busqueda_desarrollo").submit(carga_metricas_desarrollo);
	$(".form_busqueda_desarrollo_solicitudes").submit(carga_solicitudes_cliente);

	if(num_departamento == 4 ){
			
		$(".contenedor_deptos").show();
		set_option("id_depto", num_departamento);		
		selecciona_select(".depto" , 4);
	}

	/**/
	$(".comparativa").click(carga_comparativas);
	$(".abrir_ticket").click(form_nuevo_ticket);

});

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
function recorre_web_version_movil(){
	recorrepage(".tab-content");
}
/**/
function carga_metricas_desarrollo(e){

	url =  "../q/index.php/api/desarrollo/global/format/json/";	
	data_send =  $(".form_busqueda_desarrollo").serialize();

	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".place_metricas_desarrollo" , "Cargando ..." , 1 );
		}
	}).done(function(data){	

		
		llenaelementoHTML(".place_metricas_desarrollo" , data);
			$('th').click(ordena_table_general);		
	}).fail(function(){
		show_error_enid(".place_metricas_desarrollo" , "Error al cargar ..."); 
	});
	
	e.preventDefault();
}
/**/
function carga_comparativas(){
	
	url =  "../q/index.php/api/desarrollo/comparativas/format/json/";	
	data_send =  {};

	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".place_metricas_comparativa" , "Cargando ..." , 1 );
		}
	}).done(function(data){	
		
		llenaelementoHTML(".place_metricas_comparativa" , data);
			$('th').click(ordena_table_general);		
			
	}).fail(function(){
		show_error_enid(".place_metricas_comparativa" , "Error al cargar ..."); 
	});
	
}
/**/
function carga_solicitudes_cliente(e){

	url =  "../q/index.php/api/desarrollo/global_calidad/format/json/";	
	data_send =  $(".form_busqueda_desarrollo_solicitudes").serialize();

	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".place_metricas_servicio" , "Cargando ..." , 1 );
		}
	}).done(function(data){	
		
		llenaelementoHTML(".place_metricas_servicio" , data);
			$('th').click(ordena_table_general);		
	}).fail(function(){
		show_error_enid(".place_metricas_servicio" , "Error al cargar ..."); 
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
function get_id_tarea(){
	return  id_tarea;
}
/**/
function set_id_tarea(n_id_tarea){
	id_tarea =  n_id_tarea;	
}
/**/
function carga_num_pendientes(){

	url =  "../q/index.php/api/desarrollo/num_tareas_pendientes/format/json/";		
	data_send =  {"id_usuario" : get_option("id_usuario") , "id_departamento" :  get_option("id_depto") };				

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				//show_load_enid(".place_tareas_pendientes" , "Cargando ... ", 1 );
			}
	}).done(function(data){		
		
		
		llenaelementoHTML(".place_tareas_pendientes" , data);

	}).fail(function(){			
		show_error_enid(".place_tareas_pendientes" , "Error ... ");
	});		
}
/**/
function form_nuevo_ticket(){
		
	url =  "../portafolio/index.php/api/tickets/form/format/json/";	
	data_send =  {};				
		
		$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_form_tickets" , "Cargando ... ", 1 );
			}
		}).done(function(data){				
				llenaelementoHTML(".place_form_tickets" , data);							
				$(".form_ticket").submit(registra_ticket);				
		}).fail(function(){			
			show_error_enid(".place_form_tickets" , "Error ... ");
		});
}
/**/
function registra_ticket(e){

	url =  "../portafolio/index.php/api/tickets/ticket/format/json/";
	data_send = $(".form_ticket").serialize();				

		$.ajax({
				url : url , 
				type: "POST",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_registro_ticket" , "Cargando ... ", 1 );
				}
		}).done(function(data){																

			llenaelementoHTML(".place_registro_ticket" , "A la brevedad se realizará su solicitud!");							
			set_option("id_ticket", data); 
			$("#ver_avances").tab("show");
			$("#base_tab_clientes").tab("show");
			carga_info_detalle_ticket();

		}).fail(function(){			
			show_error_enid(".place_registro_ticket" , "Error ... ");
		});		
	e.preventDefault();
	
}

/**/
function actualizar_estatus_ticket(e){
	
	nuevo_estado= e.target.id;
	url =  "../portafolio/index.php/api/tickets/status/format/json/";	
	data_send =  {"id_ticket" : get_option("id_ticket") , "status" : nuevo_estado };				

	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){									
		//carga_tickets_por_proyecto_producto();		
	}).fail(function(){			
		show_error_enid(".place_proyectos" , "Error ... ");
	});		
}
/**/
/****************************************************************************************************/
/*Necesario Necesario Necesario Necesario Necesario Necesario Necesario Necesario Necesario Necesario */
function carga_info_detalle_ticket(){
	

	url =  "../portafolio/index.php/api/tickets/detalle/format/json/";	
	data_send =  {"id_ticket" : get_option("id_ticket")};				

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){							

		
		llenaelementoHTML(".place_proyectos" , data);		
		$(".btn_mod_ticket").click(actualizar_estatus_ticket);
		$(".btn_agregar_tarea").click(function(){		
			show_section_dinamic_button(".seccion_nueva_tarea");
			show_section_dinamic_button(".btn_agregar_tarea");
			recorrepage(".seccion_nueva_tarea");
			
			$('.summernote').summernote({
		        placeholder: 'Tarea pendiente',
		        tabsize: 2,
		        height: 100
		      });



		});
		
		$(".agregar_respuesta").click(carga_formulario_respuesta_ticket);
		$(".comentarios_tarea").click(carga_comentarios_tareas);
		
		$(".form_agregar_tarea").submit(registra_tarea);
		$(".tarea").click(actualiza_tareas);
		
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
/**/
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
	data_send =  $(".form_agregar_tarea").serialize()+"&"+ $.param({"id_ticket" : get_option("id_ticket") , "tarea": requerimiento });				

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
	set_option("keyword" , keyword);	
		
	url =  "../portafolio/index.php/api/tickets/ticket_desarrollo/format/json/";			
	data_send = { "status" : status_ticket , "id_departamento" :  get_option("id_depto") , "keyword" : get_option("keyword"), "modulo": get_option("modulo") };				
	

		$.ajax({
				url : url , 
				type: "GET",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
				}
		}).done(function(data){													

			llenaelementoHTML(".place_proyectos" , data);										
			//$(".solicitar_desarrollo_form").click(carga_form_solicitar_desarrollo);
			/*Ver detalle ticket completo*/
			$(".ver_detalle_ticket").click(function(e){
				set_option("id_ticket", e.target.id); 
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
			
			
			carga_num_pendientes();
			/**/
		}).fail(function(){			
			show_error_enid(".place_proyectos" , "Error ... ");

	});	
	/**/
	
}
function actualiza_tareas(e){

	set_id_tarea(e.target.id);
	nuevo_valor = this.value;

	url =  "../portafolio/index.php/api/tarea/estado/format/json/";	
	data_send = {"id_tarea" : get_id_tarea() ,  "nuevo_valor" : nuevo_valor , "id_ticket" : get_option("id_ticket") };				

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