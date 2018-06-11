var  nombre ="";
var  apellido_paterno ="";
var  apellido_materno ="";
var  tel_contacto ="";
var  email ="";
var monto_a_pagar =0;
var flag_accesos =0;
var resultados =0; 
var flag_pago_notificado_previamente = 0;
$(document).ready(function(){

	$('.datetimepicker4').datepicker();
	$('.datetimepicker5').datepicker();			
	
	$("footer").ready(function() {
		recorrepage("#info_articulo");		
	});


	$(".num_recibo").keyup(quita_espacios_en_input_num);
	/**/	
	in_session =  $(".in_session").val(); 
	
	$(".num_recibo").keypress(valida_auto_complete_recibo);	
	if(in_session ==  "1"){

		$("footer").ready(valida_auto_complete);
		$("footer").ready(valida_auto_complete_recibo);	
		
	}
	$(".form_notificacion").submit(notifica_pago);
	/**/

});
/**/
function notifica_pago(e){

	flag =  get_resultados();  

	if (flag > 0 ){

		flag =  get_pago_notificado_previamente();  
		if(flag == 0 ){

			url =  "../pagos/index.php/api/cobranza/notifica_pago_usuario/format/json/";	
			data_send =  $(".form_notificacion").serialize();

			$.ajax({
					url : url , 
					type: "POST",
					data: data_send , 
					beforeSend: function(){
						show_load_enid(".placa_notificador_pago" , "Cargando ... ", 1 );
					}
			}).done(function(data){										
								
				llenaelementoHTML(".placa_notificador_pago" , "<span class='blue_enid_background white' style='padding:10px;'> Recibimos la notificación de tu pago, a la brevedad será procesado!.</span>");
				recorrepage(".placa_notificador_pago");

				notifica_registro_pago(data);
				

			}).fail(function(){
					show_error_enid(".placa_notificador_pago" , "Error ... al cargar portafolio.");
			});
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
/**/
function notifica_registro_pago(data){	
	/**/	 
	data_send =  {"id_notificacion_pago" : data};	
	url = "../msj/index.php/api/emp/notifica_pago/format/json/";

	$.ajax({
		url : url , 					
		type : "POST" , 
		data: data_send, 
			beforeSend : function(){						
				show_load_enid(".placa_notificador_pago" ,  "Validando datos " , 1 );
			}
		}).done(function(data){	

			llenaelementoHTML(".placa_notificador_pago" , "<div class='white' style='background:#04319E;padding:10px;font-size:.9em;'> Su pago ha sido notificado, a continuación será procesado, puede consultar más detalles desde su área de clientes <a href='../login' class='strong' style='color:white!important;'> ingresando aquí</a> </div> ");
			//document.getElementById("form_notificacion").reset();			
			$(".form_notificacion :input").attr("disabled", true);
			
		}).fail(function(){							
			show_error_enid(".placa_notificador_pago" , "Error al iniciar sessión");				
	});
	/**/		

}
/**/
function valida_auto_complete_recibo(){
	/**/
	num_recibo =  $(".num_recibo").val();		
	data_send = {"recibo" : num_recibo};
		
		url =  "../pagos/index.php/api/cobranza/info_saldo_pendiente/format/json/";	
		$.ajax({
			url : url , 					
			type : "GET" , 
			data: data_send, 
			beforeSend : function(){}
		}).done(function(data){	


			console.log(data);
			
			
			pago_notificado_previamente=  data.resultado_notificado;  			
			resultados =  data.resultados;
			set_resultados(resultados);
			set_pago_notificado_previamente(pago_notificado_previamente);
			if (resultados == 0 && get_flag_accesos() > 0){
				llenaelementoHTML(".place_recibo" , "<span class='alerta_enid'>Recibo no encontrado</span>");
			}else{				
				set_flag_accesos(1);		
				$(".place_recibo").empty();

			}
			
			
			
			
			id_servicio =  data.id_servicio;
			info_pago_pendiente =  data.info_pago_pendiente;			
			monto_a_pagar =  info_pago_pendiente[0].monto_a_pagar;  			

			set_monto_a_pagar(monto_a_pagar);			
			set_id_servicio(id_servicio);
			set_select_servicio(data.data_servicio);
			
			
	

		}).fail(function(){					
		});	
		
}
/**/
function valida_auto_complete(){

	url =  "../q/index.php/api/clientes/info_pago/format/json/";	
	$.ajax({
		url : url , 					
		type : "GET" , 
		data: data_send, 
			beforeSend : function(){}
		}).done(function(data){	

			nombre = data[0].nombre;			
			apellido_paterno = data[0].apellido_paterno;
			apellido_materno = data[0].apellido_materno;			
			email = data[0].email;
			

			if (apellido_paterno == null){
				apellido_paterno ="";
			}if (apellido_materno == null){
				apellido_materno ="";
			}
			nombre_completo =  nombre + " " + apellido_materno + " " + apellido_paterno;
			set_nombre(nombre_completo);
			set_email(email);
			
		}).fail(function(){							
			
		});	
}
/**/
function set_nombre(n_nombre){
	nombre =  n_nombre;
	valorHTML(".nombre" , nombre);
} 
function get_nombre(){
	return  nombre;
} 
/**/
function set_email(n_email){
	email = n_email;
	valorHTML(".email" , email);
} 
function get_email(){
	return email;
} 
/**/
function set_monto_a_pagar(n_monto_a_pagar){
	monto_a_pagar =  n_monto_a_pagar;
	valorHTML(".cantidad" , monto_a_pagar);
}
/**/
function get_monto_a_pagar(){
	return monto_a_pagar; 
}
/**/
function set_id_servicio(n_id_servicio){
	id_servicio =  n_id_servicio;
	selecciona_select(".servicio" , id_servicio);	
}
/**/
function get_id_servicio(){
	return id_servicio;
}
/**/
function get_flag_accesos(){
	return flag_accesos;
}
/**/
function set_flag_accesos(n_val){
	flag_accesos =  n_val;
}	
/**/
function set_resultados(n_resultados){
	resultados =  n_resultados;
}
/**/
function get_resultados(){
	return resultados;
}
/**/
function set_pago_notificado_previamente(n_pago_notificado_previamente){
	flag_pago_notificado_previamente=  n_pago_notificado_previamente;
}
/**/
function get_pago_notificado_previamente(){
	return flag_pago_notificado_previamente;
}
/**/
function set_select_servicio(data_servicio){

	select ="<select name='servicio' class='form-control input-sm servicio' id='servicio'>";
	for (var x in data_servicio) {

		id_servicio =  data_servicio[x].id_servicio;
		nombre_servicio=  data_servicio[x].nombre_servicio;
		select +=  "<option value='"+id_servicio+"'>"+nombre_servicio+"</option>";

	}
	select +="</select>";	
	llenaelementoHTML("#servicio" , select );
}