"use strict";
$(document).ready(function(){

	$('.datetimepicker4').datepicker();
	$('.datetimepicker5').datepicker();				
	$("footer").ready(function() {
		recorrepage("#info_articulo");		
	});
	$(".num_recibo").keyup(function(){
		quita_espacios_en_input_num(".num_recibo");
		valida_auto_complete_recibo();
	});

	$(".form_notificacion").submit(notifica_pago);
	

});
let notifica_pago = function(e){

	let flag 	=  get_option("resultados");
	if (flag > 0 ){
		flag =  get_option("pago_notificado_previamente");
		if(flag == 0 ){

			let url 		=  "../q/index.php/api/notificacion_pago/notifica_pago_usuario/format/json/";	
			let data_send 	=  $(".form_notificacion").serialize();
			request_enid( "POST",  data_send, url, response_notificacion_pago, ".placa_notificador_pago" );
		}else{

			$(".num_recibo").css("border" , "1px solid rgb(13, 62, 86)");
			llenaelementoHTML(".place_recibo" , "<span class='alerta_enid'>Este pago ya ha sido notificado previamente</span>");
			recorrepage(".num_recibo");	
		}

	}else{
		$(".num_recibo").css("border" , "1px solid rgb(13, 62, 86)");
		recorrepage(".num_recibo");
	}
	e.preventDefault();
}

let response_notificacion_pago = function(data){

	llenaelementoHTML(".placa_notificador_pago" , "<span class='blue_enid_background white' style='padding:10px;'> Recibimos la notificación de tu pago, a la brevedad será procesado!.</span>");
	recorrepage(".placa_notificador_pago");
	notifica_registro_pago(data);
}

let notifica_registro_pago = function(data){

	let data_send =  {"id_notificacion_pago" : data};	
	let url = "../msj/index.php/api/emp/notifica_pago/format/json/";
	request_enid( "POST",  data_send, url, response_notificacion_registro_pago , ".placa_notificador_pago" );	
}
let response_notificacion_registro_pago = function(data){
	llenaelementoHTML(".placa_notificador_pago" , "<div class='white' style='background:#04319E;padding:10px;font-size:.9em;'> Su pago ha sido notificado, a continuación será procesado, puede consultar más detalles desde su área de clientes <a href='../login' class='strong' style='color:white!important;'> ingresando aquí</a> </div> ");
	$(".form_notificacion :input").attr("disabled", true);
			
}
let valida_auto_complete_recibo = function(){
	
	let num_recibo 	=  $(".num_recibo").val();		
	let url 		=  "../pagos/index.php/api/cobranza/info_saldo_pendiente/format/json/";	
	let data_send 	=  {"recibo" : num_recibo};
	request_enid( "GET",  data_send, url , response_autocomplete);		
}

let response_autocomplete = function(data){
		
	let resultados 			=  data.resultados;
	set_option("resultados" , resultados);
	set_option("pago_notificado_previamente" , data.resultado_notificado);
	if (resultados == 0 && get_option("flag_accesos") > 0){
		llenaelementoHTML(".place_recibo" , "<span class='alerta_enid'>Recibo no encontrado</span>");
	}else{						

		set_option("flag_accesos" , 1);
		$(".place_recibo").empty();
	}	
	let id_servicio 		=  data.id_servicio;
	let info_pago_pendiente =  data.info_pago_pendiente;				
	let saldo_cubierto 		= info_pago_pendiente[0].saldo_cubierto;	
	let monto_a_pagar 		=  info_pago_pendiente[0].monto_a_pagar;
	notifica_recibo_en_proceso(saldo_cubierto , monto_a_pagar);

	set_option("monto_a_pagar" 	, monto_a_pagar);
	set_parameter(".cantidad" 	, monto_a_pagar );
	set_id_servicio(id_servicio);
	set_select_servicio(data.data_servicio);
			
}
let notifica_recibo_en_proceso = function(saldo_cubierto , monto_a_pagar){
	if(saldo_cubierto >= monto_a_pagar){
		$(".place_recibo").show();		
		llenaelementoHTML(".place_recibo" , "RECIBIMOS TU NOTIFICACIÓN!");
	}
}

let set_id_servicio = function(id_servicio){
	selecciona_select(".servicio" , id_servicio);	
}
let set_select_servicio = function(data_servicio){

	let select ="<select name='servicio' class='form-control input-sm servicio' id='servicio'>";
	for (let x in data_servicio) {

		let id_servicio =  data_servicio[x].id_servicio;
		let nombre_servicio=  data_servicio[x].nombre_servicio;
		select +=  "<option value='"+id_servicio+"'>"+nombre_servicio+"</option>";
	}
	select +="</select>";	
	llenaelementoHTML("#servicio" , select );
}
/*
* function response_valida_auto_complete(data){
	let nombre 				= data[0].nombre;
	let apellido_paterno 	= data[0].apellido_paterno;
	let apellido_materno 	= data[0].apellido_materno;
	let email 				= data[0].email;

	if (apellido_paterno == null){
		apellido_paterno ="";
	}if (apellido_materno == null){
		apellido_materno ="";
	}
	let nombre_completo =  nombre + " " + apellido_materno + " " + apellido_paterno;
	set_option("nombre_completo" , nombre_completo);
	set_parameter(".nombre" , nombre_completo);
	set_option("nombre_completo" , nombre_completo);
	set_parameter(".email" , email);
	set_option(".email" . email);
}
*/