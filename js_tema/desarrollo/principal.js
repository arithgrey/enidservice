"use strict";
$(document).ready(function(){

	let num_departamento = get_parameter(".num_departamento"); 
	set_option("modulo", 2);

	$("footer").ready(function(){
		let  id_depto = get_parameter(".num_departamento");		
		set_option("id_depto", id_depto);
	});

	$(".depto").change(function(){

		let id_depto 	= get_parameter(".depto");						
		set_option("id_depto", id_depto);
		carga_tikets_usuario();
	});

	$(".q").keyup(carga_tikets_usuario);

	$("footer").ready(carga_num_pendientes);		
	$('.datetimepicker_persona').datepicker();
	$('.datetimepicker4').datepicker();
	$('.datetimepicker5').datepicker();					
	$(".form_busqueda_actividad_enid").submit(cargar_productividad);		


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

	$(".comparativa").click(carga_comparativas);
	$(".abrir_ticket").click(form_nuevo_ticket);

});

let cargar_productividad = function(e){
		
	let url =  "../q/index.php/api/productividad/usuario/format/json/";
	request_enid( "GET",  data_send, url, 1, ".place_productividad",  0 ,".place_productividad");
	e.preventDefault();
}
let recorre_web_version_movil = function(){
	recorrepage(".tab-content");
}
let  carga_metricas_desarrollo = function(e){


	if (get_parameter(".form_busqueda_desarrollo #datetimepicker4").length > 5 &&  get_parameter(".form_busqueda_desarrollo #datetimepicker5").length > 5){

		let url 		=  "../q/index.php/api/desarrollo/global/format/json/";	
		let data_send 	=  $(".form_busqueda_desarrollo").serialize();
		bloquea_form(".form_busqueda_desarrollo");
		request_enid( "GET",  data_send, url, response_carga_metricas, ".place_metricas_desarrollo");

	}else{
		
		let inputs = [".form_busqueda_desarrollo #datetimepicker4" , ".form_busqueda_desarrollo #datetimepicker5"];
		focus_input(inputs);		
	}
	e.preventDefault();
}
let response_carga_metricas = function(data){

	llenaelementoHTML(".place_metricas_desarrollo" , data);
	$('th').click(ordena_table_general);		
}
let carga_comparativas = function(){

	debugger;
	let url 		=  "../q/index.php/api/desarrollo/comparativas/format/json/";
	let data_send 	=  { tiempo: 1 };

	request_enid( "GET" ,  data_send, url, function(){
		llenaelementoHTML(".place_metricas_comparativa" , data);
		$('th').click(ordena_table_general);		
		
	}, ".place_metricas_comparativa");
}
let carga_solicitudes_cliente = function(e){

	
	if (get_parameter(".form_busqueda_desarrollo_solicitudes #datetimepicker4").length > 5 &&  get_parameter(".form_busqueda_desarrollo_solicitudes #datetimepicker5").length > 5){
		
		let url =  "../q/index.php/api/desarrollo/global_calidad/format/json/";	
		let data_send =  $(".form_busqueda_desarrollo_solicitudes").serialize();
		request_enid( "GET",  data_send, url, response_carga_solicitudes,".place_metricas_servicio");
	}else{
		
		let  inputs = [".form_busqueda_desarrollo_solicitudes #datetimepicker4", ".form_busqueda_desarrollo_solicitudes #datetimepicker5"];
		focus_input(inputs);
		
	}
	e.preventDefault();
}
let response_carga_solicitudes= function(data){
	llenaelementoHTML(".place_metricas_servicio" , data);
	$('th').click(ordena_table_general);		
}

let carga_num_pendientes = function(){

	let url =  "../q/index.php/api/desarrollo/num_tareas_pendientes/format/json/";		
	let data_send =  {"id_usuario" : get_option("id_usuario") , "id_departamento" :  get_option("id_depto") };				
	request_enid( "GET",  data_send, url, 1, ".place_tareas_pendientes" ,".place_tareas_pendientes" );
}

let form_nuevo_ticket = function(){
		
	let url =  "../q/index.php/api/tickets/form/format/json/";	
	let data_send =  {};					
	request_enid( "GET",  data_send, url, response_form_nuevo_ticket,".place_form_tickets" );
}

let response_form_nuevo_ticket = function(data){
	llenaelementoHTML(".place_form_tickets" , data);							
	$(".form_ticket").submit(registra_ticket);				
}

let registra_ticket = function(e){

	let url =  "../q/index.php/api/tickets/index/format/json/";
	let data_send = $(".form_ticket").serialize();				
	request_enid( "POST",  data_send, url, response_registro_ticket, ".place_registro_ticket" );
	e.preventDefault();
	
}
let response_registro_ticket = function(data){
	llenaelementoHTML(".place_registro_ticket" , "A la brevedad se realizará su solicitud!");							
	set_option("id_ticket", data); 
	$("#ver_avances").tab("show");
	$("#base_tab_clientes").tab("show");
	carga_info_detalle_ticket();
}

let set_estatus_ticket =  function(e){
	
	let nuevo_estado 	= 	get_parameter_enid($(this) , "id");
	let url 			=  	"../q/index.php/api/tickets/status/format/json/";	
	let data_send 		=  	{"id_ticket" : get_option("id_ticket") , "status" : nuevo_estado };				
	request_enid( "PUT",  data_send, url, function(){}, ".place_proyectos");
}
let carga_info_detalle_ticket = function(){

	let url =  "../q/index.php/api/tickets/detalle/format/json/";	
	let data_send =  {"id_ticket" : get_option("id_ticket")};				
	request_enid( "GET",  data_send, url, response_carga_ticket);
}

let response_carga_ticket = function(data){

	
	llenaelementoHTML(".place_proyectos" , data);	
	display_elements([".seccion_nueva_tarea" ] , 0);	
	$(".mostrar_tareas_pendientes").hide();
	$(".btn_mod_ticket").click(set_estatus_ticket);
	$(".btn_agregar_tarea").click(agregar_tarea);

		
	$(".agregar_respuesta").click(carga_formulario_respuesta_ticket);
	$(".comentarios_tarea").click(carga_comentarios_tareas);	
	$(".form_agregar_tarea").submit(registra_tarea);
	$(".tarea").click(actualiza_tareas);	
	$(".mostrar_tareas_pendientes").click(muestra_tareas_por_estatus);
	$(".mostrar_todas_las_tareas").click(muestra_todas_las_tareas);	
	$(".ver_tickets").click(function(){
		carga_tikets_usuario();
	});
	if (get_option("flag_mostrar_solo_pendientes") ==  1){
		muestra_tareas_por_estatus();
	}

}
let carga_formulario_respuesta_ticket = function(e){
	
	let tarea 		= get_parameter_enid($(this) , "id");
	set_option("tarea", tarea);	
	let url 		=  	"../q/index.php/api/tickets/formulario_respuesta/format/json/";	
	let data_send 	=  	{"tarea" : tarea};				
	let seccion 	=	".seccion_respuesta_"+get_option("tarea");

	request_enid( "GET",  data_send, url, function(data){
		llenaelementoHTML(seccion , data);
		$(".form_respuesta_ticket").submit(registra_respuesta_pregunta);

	}, seccion);
}

let carga_comentarios_tareas = function(e){

	
	showonehideone( ".ocultar_comentarios" , ".comentarios_tarea");
	let tarea 		= 	get_parameter_enid($(this) , "id");
	set_option("tarea", tarea);	
	let url 		=  	"../q/index.php/api/respuesta/respuestas/format/json/";	
	let data_send 	=  	{"tarea" : tarea};				
	let seccion 	=	".seccion_respuesta_"+get_option("tarea");
	set_option("seccion" , seccion);
	request_enid( "GET",  data_send, url, response_carga_comentario_tareas);
	

}

let carga_comentarios_terea_simple = function(){

	let tarea 		=   get_option("tarea");	
	let url 		=  	"../q/index.php/api/respuesta/respuestas/format/json/";	
	let data_send 	=  	{"tarea" : tarea};				
	let seccion 	=	".seccion_respuesta_"+tarea;
	set_option("seccion" , seccion);
	request_enid( "GET",  data_send, url, response_carga_comentario_tareas);
	
}

let  response_carga_comentario_tareas = function(data){
	
	let seccion = get_option("seccion");
	llenaelementoHTML(seccion , data);
	$(".ocultar_comentarios").click(function(e){
		set_option("tarea", get_parameter_enid($(this) , "id"));		
		$(seccion).empty();			
	});
	
}

let registra_tarea = function(e){

	let requerimiento 	=  $(".form_agregar_tarea .note-editable").html();		
	let url 			=  "../q/index.php/api/tarea/index/format/json/";	
	let data_send 		=  $(".form_agregar_tarea").serialize()+"&"+ $.param({"id_ticket" : get_option("id_ticket") , "tarea": requerimiento });				
	request_enid( "POST",  data_send, url, carga_info_detalle_ticket, ".place_proyectos");
	e.preventDefault();

}
let muestra_tareas_por_estatus = function(){

	showonehideone( ".mostrar_todas_las_tareas" , ".tarea_pendiente"  );
	$(".mostrar_tareas_pendientes").hide();
	set_option("flag_mostrar_solo_pendientes", 1);
}

let  muestra_todas_las_tareas = function(){

	showonehideone( ".tarea_pendiente"  , ".mostrar_todas_las_tareas");	
	$(".mostrar_tareas_pendientes").show();
	set_option("flag_mostrar_solo_pendientes", 0);	
}
let carga_tikets_usuario = function(){
	
	
	recorre_web_version_movil();
	let status_ticket = 0; 	
	if (document.querySelector(".estatus_tickets")) {		
		status_ticket =  get_parameter(".estatus_tickets");
	}
	let keyword 	= 	get_parameter(".q"); 	
	set_option("keyword" , keyword);	
	let url 		=  	"../q/index.php/api/tickets/ticket_desarrollo/format/json/";			
	let data_send 	= 	{ "status" : status_ticket , "id_departamento" :  get_option("id_depto") , "keyword" : get_option("keyword"), "modulo": get_option("modulo") };
	request_enid( "GET",  data_send, url, response_carga_tickets, ".place_proyectos" );

	
}
let response_carga_tickets = function(data){
	
	llenaelementoHTML(".place_proyectos" , data);
	$(".ver_detalle_ticket").click(function(e){

		set_option("id_ticket", get_parameter_enid($(this) , "id")); 
		carga_info_detalle_ticket();
	});

	$(".btn_refresh").click(function(){
		carga_tikets_usuario();
	});

	$(".estatus_tickets").change(function(){
		carga_tikets_usuario();
	});	
	carga_num_pendientes();
}
let  actualiza_tareas = function(e){

	set_option("id_tarea" , get_parameter_enid($(this) , "id"));
	let nuevo_valor 	= this.value;
	let url 			=  "../q/index.php/api/tarea/estado/format/json/";	
	let data_send 		= {"id_tarea" : get_option("id_tarea") ,  "nuevo_valor" : nuevo_valor , "id_ticket" : get_option("id_ticket") };				
	request_enid( "PUT",  data_send, url, response_actualiza_tareas, ".place_proyectos");	
}

let response_actualiza_tareas = function(data){

	if (data ==  "cerrado") {
		carga_tikets_usuario();
	}else{
		carga_info_detalle_ticket();					
	}	
}
let show_section_dinamic_button = function(seccion) {
    let x = ($(seccion).is(":visible")) ? $(seccion).hide() : $(seccion).show();
}
let agregar_tarea = function(){

	show_section_dinamic_button(".seccion_nueva_tarea");
	show_section_dinamic_button(".btn_agregar_tarea");
	recorrepage(".seccion_nueva_tarea");
	
	display_elements([".listado_pendientes" , ".mostrar_todas_las_tareas" ,".table_resumen_ticket"] , 0);			
	$('.summernote').summernote({
		placeholder: 'Tarea pendiente',
		tabsize: 2,
		height: 100
	});
		
};
let cerrar_ticket = function(id){

	id =  parseInt(id)
	if( id  > 0 ){
		set_option("id_ticket" , id );
		show_confirm("¿DESEAS CERRAR EL TICKET?", "Se descartarán todas sus tareas incluidas", "CERRAR TICKET", confirmacion_cerrar_ticket);
	}

}
let confirmacion_cerrar_ticket = function(){

	let id_ticket 	=  	get_option("id_ticket");
	let url 		=  	"../q/index.php/api/tickets/estado/format/json/";
	let data_send 	= 	{"status" : 2 , "id_ticket": id_ticket};
	request_enid( "PUT",  data_send, url, carga_tikets_usuario);

}