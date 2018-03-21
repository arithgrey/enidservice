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
var flag_estoy_en_agendado = 0; 
var id_base_telefonica = 0;  
var tmp_tel = 0; 
var menu_actual = "clientes";
var num_accesos =0;
var num_usuarios_referencia =0;
var num_proceso_compra =0;
var venta_efectiva =0;
var enviar_pagos =0;
var banco =0;
var numero_tarjeta =0;
var propietario ="";
var id_proyecto_persona_forma_pago =0;
var tipo_video =1; 
$(document).ready(function(){	

	$('.datetimepicker_persona').datepicker();
	$('.datetimepicker4').datepicker();
	$('.datetimepicker5').datepicker();			
	
	/*hora*/
	$('.datetimepicker1').timepicker();
	$('.datetimepicker2').datepicker();
	$("footer").ready(carga_informe_mensual);
	$("footer").ready(carga_metricas_afiliados);
	
	$(".tab_productividad").click(carga_metricas_afiliados);
	/**/
	$(".enviar_pagos").click(metodos_de_envio_disponibles);
	/**/
	$(".informe_ventas").click(carga_informe_mensual);
	/**/
	
	
	/**/
	$(".video_facebook").click(function(){		
		set_tipo_video(1);
	});
	/**/
	$(".video_youtube").click(function(){		
		set_tipo_video(2);
	});
	/**/
	$(".videos_disponibles").click(carga_videos_disponibles);

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
	reset_form_agenda();
	
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
	data_send =  $(".form_busqueda_labor_venta").serialize()+"&"+$.param({"id_usuario" : get_id_usuario() });			
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
	data_send =  $(".form_referido").serialize() +"&"+ $.param({"id_usuario" : get_id_usuario() , "flag_tipo_persona":1  , "tipo_persona" : 1});			

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
function cargar_info_agendados(e){

	set_menu_actual("agendados");
	set_flag_estoy_en_agendado(0);
	url =  "../base/index.php/api/ventas_tel/agendados/format/json/";	
	data_send =  $(".form_busqueda_agendados").serialize();				
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_info_agendados" , "Cargando ... ", 1 );
			}
	}).done(function(data){																				
		llenaelementoHTML(".place_info_agendados" , data);		
		/**/
		$(".info_persona_agendados").click(function(e){
			id_persona =  e.target.id;
			set_persona(id_persona);
			carga_info_persona();	
		});			
		/**/
		$(".btn_agendar_llamada").click(asigna_valor_persona_agendado);	
		$(".marcar_llamada_btn").click(marcar_llamada_hecha);
		/*Cargamos num agendados en notificación*/
		
		set_flag_estoy_en_agendado(1);
		/**/
	}).fail(function(){			
		show_error_enid(".place_info_agendados" , "Error ... ");
	});		

	e.preventDefault();
}
/**/
function  marcar_llamada_hecha(e){	

	set_llamada(e.target.id);
	llenaelementoHTML(".place_llamada_hecha" , "");
	
}
/**/
function registrar_llamada_hecha(e){
	
	url =  "../base/index.php/api/ventas_tel/agendados_llamada_hecha/format/json/";		
	data_send =  {id_llamada :  get_llamada()};				
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_llamada_hecha" , "Cargando ... ", 1 );
			}
	}).done(function(data){																				
		
		show_response_ok_enid(".place_llamada_hecha" , "Llamada hecha!");
		$("#modal_llamada_efectuada").modal("hide");
		$(".form_busqueda_agendados").submit();
		

	}).fail(function(){			
		show_error_enid(".place_llamada_hecha" , "Error ... ");
	});		
	e.preventDefault();	
}
/**/
function cargar_base_de_marcacion(){
	$("#registro_prospecto").tab("hide");
	$(".place_contactos_disponibles").empty();
	$("#contenedor_formulario_contactos").show();
	show_response_ok_enid(".place_resultado_final" , "<div class='row'><span class='white'> Listo! siguiente contacto </span></div>");				
}
/***/
function reset_contenido_form_lanza_lista_de_marcacion(){
	

	show_response_ok_enid(".place_registro_prospecto" , "Posible cliente registrado!");					
	document.getElementById("form_referido").reset(); 	
	/**/	
	$(".form_busqueda_posibles_clientes").submit();	
	$("#tab_productividad").tab("show");
	$(".base_tab_posiblies_clientes").tab("show");
	/**/
}
/**/
function muestra_form_agendar_llamada(){
	showonehideone(".contenedor_form_agenda" , ".btn_ocultar_form");
}
/**/
function reset_form_agenda(){
	
	set_referencia_email(0);
	$(".input_f_agenda").val("");
	$(".contenedor_form_agenda").hide();
}
/**/
function get_referencia_email(){	
	return  referencia_email;
}
/**/
function set_referencia_email(n_referencia){
	referencia_email =  n_referencia;
	$(".referencia_email").val(referencia_email);
}
/**/
/**/
/*
	function ganancias_por_plan(){

		url =  "../q/index.php/api/ventas/porcentaje_ganancias/format/json/";		
		data_send =  {};				

		$.ajax({
				url : url , 
				type: "GET",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_ganancias_por_plan" , "Cargando ... ", 1 );
				}
		}).done(function(data){																				
			
			llenaelementoHTML(".place_ganancias_por_plan" , data);
		}).fail(function(){			
			show_error_enid(".place_ganancias_por_plan" , "Error ... ");
		});		
		
	}
*/
function carga_metricas_afiliados(){

	
		url =  "../q/index.php/api/afiliacion/reporte_global/format/json/";		
		data_send =  {};				

		$.ajax({
				url : url , 
				type: "GET",
				data: data_send, 
				beforeSend: function(){
					show_load_enid(".place_metricas_afiliado" , "Cargando ... ", 1 );
				}
		}).done(function(data){																				
				
			

			for(var x in data ){

				set_num_accesos(data[x].num_accesos);
				set_num_usuarios_referencia(data[x].num_usuarios_referencia); 
				set_num_proceso_compra(data[x].num_proceso_compra);
				set_venta_efectiva(data[x].venta_efectiva);
				console.log(data[x]);
				
			}
			/**/
			construye_metricas_afiliado();
			
		}).fail(function(){			
			show_error_enid(".place_metricas_afiliado" , "Error ... ");
		});		
}
/**/
function construye_metricas_afiliado(){

      var data = new google.visualization.DataTable();         
      
       var data = google.visualization.arrayToDataTable([
         ['Tus logros del mes', 'Total' ],
         ['Visitas a tus publicaciones', get_num_accesos() ],
         ['Posibles clientes', get_num_usuarios_referencia()],
         ['En proceso de compra', get_num_proceso_compra()],
         ['Ventas efectivas', get_venta_efectiva() ]
      ]);


      var options = {
        title: 'Tus logros del mes',      
      };

      var materialChart = new google.charts.Bar(document.getElementById('place_metricas_afiliado'));
      materialChart.draw(data, options);
}
/**/
function get_num_accesos(){
	return num_accesos;
}
/**/
function set_num_accesos(n_num){
	if (n_num != null ){
		num_accesos = n_num;
	}else{
		num_accesos = 0;
	}

}
/**/

function get_num_usuarios_referencia(){
	return num_usuarios_referencia;
}
/**/
function set_num_usuarios_referencia(n_num_usuarios_ref){
	if (n_num_usuarios_ref != null ){
		num_usuarios_referencia = n_num_usuarios_ref;
	}else{
		num_usuarios_referencia = 0;
	}

}
/**/
function get_num_proceso_compra(){
	return num_proceso_compra;
}
/**/
function set_num_proceso_compra(n_num_user_compra){
	if (n_num_user_compra != null ){
		num_proceso_compra = n_num_user_compra;
	}else{
		num_proceso_compra = 0;
	}
}
/**/

function get_venta_efectiva(){
	return venta_efectiva;
}
/**/
function set_venta_efectiva(n_ventas){
	if (n_ventas != null ){
		venta_efectiva = n_ventas;
	}else{
		venta_efectiva = 0;
	}
}
/**/
function metodos_de_envio_disponibles(){

	url =  "../pagos/index.php/api/afiliados/metodos_disponibles_pago/format/json/";	
	data_send = {};	
	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".place_info_cuentas_pago" , "Cargando ..." , 1 );
		}
	}).done(function(data){	

		llenaelementoHTML(".place_info_cuentas_pago" , data);
		/**/
		$(".actualizar_form").click(registra_actualizacion_banco_persona);
		$(".siguiente_banco").click(valida_banco_seleccionado);
		/**/
		$(".siguiente_numero_tarjeta").click(valida_tarjeta_registrada);
		/**/
		$(".banco_cuenta").change(muestra_imagen_banco);

		/**/
		$(".numero_tarjeta").keyup(function(){
			quita_espacios(".numero_tarjeta");
		});

		 $('.next').click(function() { 
            var numStep = $(this).attr( "num-step" );
            var clStep = '#collapse' + (parseInt(numStep) + 1);
            $(clStep).collapse('show');
            $('#accordion .in').collapse('hide');
            console.log(clStep);   
            /*cambiar estilo e imagen a botón*/
            $('.s' + numStep).addClass('step-ok').removeClass('step');
            $('.s' + numStep).empty().append('<i class=\"fa fa-check\" aria-hidden=\"true\"><\/i>');

        });

        $('.prev').click(function() {
            var numStep = $(this).attr( "num-step" );
            var clStep = '#collapse' + (parseInt(numStep) - 1);
            $(clStep).collapse('show');
            $('#accordion .in').collapse('hide');
        });

        $('.btn-primary').click(function() {

            var delay = 4000; 
            //setTimeout(function(){ window.location = 'p3'; }, delay);

        });
        
         $('.btn-secondary').click(function() {
            $('.step-ok').addClass('step').removeClass('step-ok');
            $('.s0').empty().append('1');
            $('.s1').empty().append('2');
            $('#collapse0').collapse('show');
            $('#accordion .in').collapse('hide');

        });
       
		
	}).fail(function(){
		show_error_enid(".place_info_cuentas_pago" , "Error al cargar ..."); 
	});
}
/**/
function registra_cuenta_afiliado(e){

	
	alert($(".form_cuenta_banco").serialize());
	e.preventDefault();
}
/**/
function muestra_imagen_banco(){

	
	banco =  $(".banco_cuenta").val();

	set_banco(parseInt(banco));
	var bancos_imgs = [ "", "1.png", "2.png" , "3.png", "4.png", "5.png", "6.png", "7.png" , "8.png", "9.png"];

		if (get_banco()>0) {
			url_img_banco =  "../img_tema/bancos/"+bancos_imgs[banco];	    	
	        imagen ="<img src='"+url_img_banco+"' style='width:100%'>";
	        llenaelementoHTML(".place_imagen_banco" , imagen);
	    }
	    else{
	    	llenaelementoHTML(".place_imagen_banco" , "");	
	    }	    
}
/**/
function set_banco(n_banco){
	banco = n_banco;
}
/**/
function get_banco(){
	return banco;
}
/**/
function registra_actualizacion_banco_persona(){

	flag_1 =  valida_banco_seleccionado();	
	flag_2 =  valida_tarjeta_registrada();
	flag_3 =  valida_propietario_tarjeta();


	if (flag_1 == 1){
		if (flag_2 == 1) {
			if (flag_3 == 1){

					url =  "../pagos/index.php/api/afiliados/cuenta_afiliado/format/json/";						
					data_send = {"numero_tarjeta" : get_numero_tarjeta(), "banco" : get_banco(), "propietario" : get_propietario()};	

					$.ajax({
						url : url , 
						type : "PUT" ,
						data: data_send , 
						beforeSend: function(){
							show_load_enid( ".place_info_cuentas_pago" , "Cargando ..." , 1 );
						}
					}).done(function(data){							
						//show_response_ok_enid(".place_info_cuentas_pago" , "Información actualizada");
						metodos_de_envio_disponibles();
					}).fail(function(){
						show_error_enid(".place_info_cuentas_pago" , "Error al cargar ..."); 
					});

			}
		}
	}
}
/**/
function set_numero_tarjeta(n_numero_tarjeta){
	numero_tarjeta =  n_numero_tarjeta;
}
/**/
function get_numero_tarjeta(){
	return  numero_tarjeta;
}
/**/
function valida_banco_seleccionado(){
	
	banco =  $(".banco_cuenta").val();
	set_banco(banco);
	if(get_banco() ==  0){
		
		$('.step-ok').addClass('step').removeClass('step-ok');
        $('.s0').empty().append('1');
        $('.s1').empty().append('2');
        $('#collapse0').collapse('show');
        $('#accordion .in').collapse('hide');
        llenaelementoHTML( ".place_banco" ,  "<span class='alerta_enid'>Selecciona un banco</span>");
        return 0;
	}else{

		llenaelementoHTML( ".place_banco" ,  "");
		return 1;
	}	
}
/**/
function valida_tarjeta_registrada(){	

	numero_tarjeta =  $(".numero_tarjeta").val();
	set_numero_tarjeta(numero_tarjeta);		
	return  valida_text_form(".numero_tarjeta" , ".place_numero_tarjeta" , 16 , "Número de tarjeta" );		
	
}
/**/
function valida_propietario_tarjeta(){

	propietario =  $(".propietario").val();
	set_propietario(propietario);
	return valida_text_form(".propietario" , ".place_propietario_tarjeta" , 5 , "Propietario de la tarjeta" );			
	
}
/**/
function get_propietario(){
	return propietario;
}
/**/
function set_propietario(n_propietario){
	propietario = n_propietario;
}
/**/
function carga_informe_mensual(){
	
	url =  "../q/index.php/api/afiliacion/ventas/format/json/";	
	data_send = {};	
	$.ajax({
		url : url , 
		type : "GET" ,
		data: data_send , 
		beforeSend: function(){
			show_load_enid( ".ventas_usuario" , "Cargando ..." , 1 );
		}
	}).done(function(data){	

		llenaelementoHTML(".ventas_usuario" , data);
		$(".ver_detalle_pago").click(cargar_info_resumen_pago_pendiente);
	}).fail(function(){
		show_error_enid(".ventas_usuario" , "Error al cargar ..."); 
	});
	set_num_persona(0);
	
}
/**/
function cargar_info_resumen_pago_pendiente(e){
	/**/
	id_proyecto_persona_forma_pago =  e.target.id;
	set_id_proyecto_persona_forma_pago(id_proyecto_persona_forma_pago);

	url =  "../pagos/index.php/api/cobranza/resumen_desglose_pago/format/json/";	
	data_send =  {id_proyecto_persona_forma_pago : get_id_proyecto_persona_forma_pago()};					
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".ventas_usuario" , "Cargando ... ", 1 );
			}
	}).done(function(data){																				
		/**/

		llenaelementoHTML(".ventas_usuario" , "<div><h1>Información de compra para el cliente</h1></div><div class='info_compra'></div>");		
		llenaelementoHTML(".info_compra" , data);
		/**/
	}).fail(function(){			
		show_error_enid(".ventas_usuario" , "Error ... ");
	});	
}
/**/
function set_id_proyecto_persona_forma_pago(n_id_proyecto_persona_forma_pago){
	id_proyecto_persona_forma_pago =  n_id_proyecto_persona_forma_pago;
}
/**/
function get_id_proyecto_persona_forma_pago(){
	return id_proyecto_persona_forma_pago;
}
/**/
function carga_videos_disponibles(e){
	
	url =  "../portafolio/index.php/api/portafolio/videos_disponibles/format/json/";				
	data_send =  {"tipo_video" : get_tipo_video()};		

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_info_videos_disponibles" , "Cargando ... ", 1 );
			}
	}).done(function(data){																				
		
		llenaelementoHTML(".place_info_videos_disponibles" , data);

	}).fail(function(){			
		show_error_enid(".place_info_videos_disponibles" , "Error ... ");
	});	
	

}
/**/
function get_tipo_video(){
	return tipo_video;
}
/**/
function set_tipo_video(n_tipo_video){
	tipo_video =  n_tipo_video;	
}
