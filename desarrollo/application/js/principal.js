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
	
	
	
	/**/
	$(".btn_mostrar_mas_campos").click(muestra_oculta_campos_persona);
	/*hora*/
	$('.datetimepicker1').timepicker();
	$('.datetimepicker2').datepicker();
	set_option("id_usuario" , $(".id_usuario").val());
	
	$(".li_menu").click(recorre_web_version_movil);	
	
	/**/

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

});
/**/
function descarga_contacto(e){

	set_nombre_tipo_negocio($("#tipo_negocio>option:selected").text());  
	set_flag_base_telefonica(1);
	set_tipo_negocio($(".tipo_negocio").val());


	url =  "../base/index.php/api/ventas_tel/prospecto/format/json/";	
	data_send = $(".form_busqueda_contacto").serialize();	
	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".place_contactos_disponibles" , "Cargando ..." , 1 );
		}
	}).done(function(data){	


		if (data ==  0) {
			redirect("");
		}else{

			/*Si no hay contactos, carga de nuevo*/
			llenaelementoHTML(".place_contactos_disponibles" , data);		
			$("#contenedor_formulario_contactos").hide();
			$(".form_tipificacion").submit(registra_avance);
			set_nombre_tipo_negocio(get_nombre_tipo_negocio());  


			/*Cuando se lanza formulario de agendamiento*/		
		}
		
	}).fail(function(){
		show_error_enid(".place_contactos_disponibles" , "Error al cargar ..."); 
	});
	set_num_persona(0);
	e.preventDefault();
}
/**/
function registra_avance(e){	
	

	val_tipificacion =  $("#tipificacion").val();	
	tmp_tel = $(".telefono_venta").val();
	$("#telefono_info_contacto").val(tmp_tel);			
	set_telefono(tmp_tel);
	set_fuente($("#id_fuente_marcacion").val());
	set_referencia_email(0);	
	/*Reset en los formularios*/	
	
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
		registra_tipificacion();
	}
	e.preventDefault();
}
/**/
/**/
function carga_metricas_prospectacion(e){


	url =  "../q/index.php/api/ventas/laborventa/format/json/";	
	data_send =  $(".form_busqueda_labor_venta").serialize()+"&"+$.param({"id_usuario" : get_option("id_usuario") });			
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_metricas_labor_venta" , "Cargando ... ", 1 );
			}
	}).done(function(data){						

		llenaelementoHTML(".place_metricas_labor_venta" , data);	
	}).fail(function(){		
		//show_error_enid(".place_metricas_labor_venta" , "Error ... ");
	});
	e.preventDefault();	
}
/**/

/**/
function carga_ejemplos_disponibles(e){
	
	url =  "../portafolio/index.php/api/portafolio/proyecto/labor_venta/format/json/";	
	data_send =  $(".form_busqueda_proyectos").serialize();
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_muestras_proyectos" , "Cargando ... ", 1 );
			}
	}).done(function(data){											
			llenaelementoHTML(".place_muestras_proyectos" , data);			
	}).fail(function(){		
		show_error_enid(".place_muestras_proyectos" , "Error ... ");
	});
	e.preventDefault();	
}
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
function registra_tipificacion(){

	url =  "../base/index.php/api/ventas_tel/prospecto/format/json/";	
	data_send = $(".form_tipificacion").serialize();
		$.ajax({
			url : url , 
			type : "PUT" ,
			data: data_send , 
			beforeSend: function(){
				show_load_enid(".place_update_prospecto" , "Cargando ..." , 1 );
			}
		}).done(function(data){		
			cargar_base_de_marcacion();
		}).fail(function(){
			show_error_enid(".place_update_prospecto" , "Error al cargar ..."); 
	});
	
}
/**/

function registrar_posiblie_cliente(e){

	url =  "../base/index.php/api/ventas/prospecto/format/json/";	
	data_send =  $(".form_referido").serialize() +"&"+ $.param({"id_usuario" : get_option("id_usuario") });			

	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_registro_prospecto" , "Cargando ... ", 1 );
			}
	}).done(function(data){																


		reset_contenido_form_lanza_lista_de_marcacion();
		
	}).fail(function(){		
		show_error_enid(".place_registro_prospecto" , "Error ... ");

	});		
	e.preventDefault();
}
/**/
function muestra_form_referidos(){	
	set_num_persona(1);
}
/**/
function set_num_persona(z){
	
	if (z == 1){
		$('.telefono_info_contacto').attr('readonly', false);		
		$(".telefono_info_contacto").val("");	
	}else{
		$('.telefono_info_contacto').attr('readonly', true);					
	}
}
/**/
function muestra_oculta_campos_persona(){

	if (campos_disponibles == 0 ){

		showonehideone( ".menos_campos" , ".mas_campos");
		$(".campo_avanzado").show();
		campos_disponibles = 1;
	}else{
		showonehideone(".mas_campos" , ".menos_campos" );		
		$(".campo_avanzado").hide();
		campos_disponibles = 0;
	}
}
/**/
function cargar_base_de_marcacion(){
	$("#registro_prospecto").tab("hide");
	$(".place_contactos_disponibles").empty();
	$("#contenedor_formulario_contactos").show();
	show_response_ok_enid(".place_resultado_final" , "<div class='row'><span class='white'> Listo! siguiente contacto </span></div>");				
}
/**/
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
	
	e.preventDefault();	
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
function carga_num_pendientes(){
	
	alert();
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
