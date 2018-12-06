$(document).ready(function(){
	$(".tipos_puntos_encuentro").change(iniciar_proceso_entrega);
	$('.datetimepicker5').datepicker();						 
	$(".form_punto_encuentro").submit(registra_usuario);
	$(".form_punto_encuentro_horario").submit(notifica_punto_entrega);	
	$(".link_acceso").click(set_link);
	$(".telefono").keyup(quita_espacios_en_telefono);
});

var iniciar_proceso_entrega = function(){

	var opcion  =  parseInt(get_valor_selected(".tipos_puntos_encuentro"));	
	switch(opcion) {
		case 0:
	        
	        break;

	    case 1:
			muestra_lineas_metro(1);			        
	        break;
	    case 2:
	        muestra_lineas_metro(2);	
	        break;
	    
	    case 3:
	        
	        break;

	    default:

	        break;
	} 

}
/**/
var muestra_lineas_metro = function(tipo){
	
	var url  	   	= "../q/index.php/api/linea_metro/index/format/json/";	
	var servicio 	=  get_parameter(".servicio"); 		
	var data_send  	= {"v":1, tipo:tipo, "servicio":servicio};
	set_option("tipo" , tipo);
	request_enid( "GET",  data_send, url, response_lineas_metro);

}
var response_lineas_metro = function(data){	
	
	llenaelementoHTML(".place_lineas" , data);
	$(".linea_metro").click(muestra_estaciones);
}
var muestra_estaciones = function(){

	
	$(".tipos_puntos_encuentro").hide();
	var id 			 =  get_parameter_enid($(this) , "id");
	var nombre_linea =  get_parameter_enid($(this) , "nombre_linea");
	
	
	set_option("nombre_linea" ,nombre_linea);
	if (id > 0 ) {		
		if (get_parameter(".primer_registro") ==  1 ) {

			var servicio 	=  	get_parameter(".servicio"); 	
			var url  	   = "../q/index.php/api/punto_encuentro/linea_metro/format/json/";
			var data_send  = {"id":id , "v":1 , "servicio" : servicio};		
			request_enid( "GET",  data_send, url, response_estaciones);			
		}else{

			/*Pre registro*/
			var url  	   = "../q/index.php/api/punto_encuentro/linea_metro/format/json/";
			var data_send  = {"id":id , "v":2 , "recibo" : get_parameter(".recibo")};					
			request_enid( "GET",  data_send, url, response_estaciones);	
		}
	}
}
var response_estaciones = function(data){


	var texto_centro =  "";
	switch(parseInt(get_option("tipo"))) {
		case 0:
	        
	        break;

	    case 1:
			texto_centro =  "LÍNEA DEL METRO: "+get_option("nombre_linea");
	        break;
	    case 2:
	        texto_centro =  "LÍNEA DEL METROBUS: "+get_option("nombre_linea");
	        break;

	    case 3:

	        break;

	    default:

	        break;
	}
	
	llenaelementoHTML(".place_lineas" , data);
	llenaelementoHTML(".nombre_linea_metro" ,  texto_centro);
	$(".punto_encuentro").click(muestra_horarios);	
}
var muestra_horarios = function(){
	
	var id 			 		=  get_parameter_enid($(this) , "id");	
	set_option("punto_encuentro" , id);
	var nombre_estacion 	=  get_parameter_enid($(this) , "nombre_estacion");
	var costo_envio 		=  get_parameter_enid($(this) , "costo_envio");
	var flag_envio_gratis 	=  get_parameter_enid($(this) , "flag_envio_gratis");
	if (id > 0) {

		var text 			= "";
		$(".mensaje_cobro_envio").hide();
		set_parameter(".punto_encuentro_form" , id);
		set_option("id_punto_encuentro" , id);	
		llenaelementoHTML(".nombre_estacion_punto_encuentro" , "<span class='strong'>ESTACIÓN:</span> "+nombre_estacion)
		$(".nombre_estacion_punto_encuentro").addClass("nombre_estacion_punto_encuentro_extra");



		var texto_cargos_entrega =  "<span class='text_costo_envio'>"+costo_envio+"MXN</span>";
		var texto_cargos_gratis  =  "<span class='text_costo_envio_gratis'>ENVÍO GRATIS!</span>";

		var texto_cargos_entrega = (flag_envio_gratis ==  1 ) ? texto_cargos_gratis: texto_cargos_entrega;
		llenaelementoHTML(".cargos_por_entrega" ,  "<span class='strong'>CARGO POR ENTREGA:</span>"+ texto_cargos_entrega)
		$(".cargos_por_entrega").addClass("cargos_por_entrega_extra");
		$(".contenedor_estaciones").hide();
		
		if (flag_envio_gratis ==  0 ) {
			var text  = "Recuerda que previo a la entrega de tu producto, deberás realizar el pago de "+costo_envio+" pesos por concepto de gastos de envío";	
			llenaelementoHTML(".mensaje_cobro_envio" ,  text);
			$(".mensaje_cobro_envio").show();
		}
		

		$(".btn_continuar_punto_encuentro").show();
		$(".btn_continuar_punto_encuentro").click(muestra_quien_recibe);

	}

}
var muestra_quien_recibe = function(){

	display_elements([".resumen_encuentro",".titulo_principal_puntos_encuentro"],0);
	display_elements([".formulario_quien_recibe"] ,1);
	
}

var registra_usuario = function(e){
	
	var nombre 		= 	get_parameter(".form_punto_encuentro .nombre").length;
	var correo 		= 	get_parameter(".form_punto_encuentro .correo").length;
	var telefono 	= 	get_parameter(".form_punto_encuentro .telefono").length;
	
	if ( nombre > 4 && correo > 5 && telefono > 5){
		
		var password 	 = 	""+CryptoJS.SHA1(randomString(8));					
		var data_send 	 = 	$(".form_punto_encuentro").serialize()+"&"+$.param({"password":password , "servicio" : get_parameter(".servicio")});					

		var url 		 = 	"../q/index.php/api/cobranza/primer_orden/format/json/";
		bloquea_form(".form_punto_encuentro");	
		$(".contenedor_ya_tienes_cuenta").hide();			
		request_enid("POST",  data_send , url , response_registro_usuario , ".place_notificacion_punto_encuentro_registro");					

	}else{
		
		focus_input([".form_punto_encuentro .nombre" ,".form_punto_encuentro .correo" , ".form_punto_encuentro .telefono"]);
	}
	e.preventDefault();	
	
}
var response_registro_usuario = function(data){

	display_elements([".place_notificacion_punto_encuentro_registro"] , 0);
	if (data.usuario_existe == 1 ) {
		
		$(".text_usuario_registrado_pregunta").hide();		
		display_elements([".text_usuario_registrado" , ".contenedor_ya_tienes_cuenta"] , 1);
		recorrepage(".text_usuario_registrado");
		
	}else{
		display_elements([".contenedor_eleccion_correo_electronico", ".formulario_quien_recibe"] , 0);
		redirect("../area_cliente/?action=compras&ticket="+data.id_recibo);
	}

}
var set_link = function(){
			
	var plan 			  = get_parameter_enid($(this) , "plan");	
	var num_ciclos 	      = get_parameter_enid($(this) , "num_ciclos");		
	var data_send         = $.param({"plan" : plan , "num_ciclos": num_ciclos , "punto_encuentro" : get_option("punto_encuentro")});
	var url				  = "../login/index.php/api/sess/servicio/format/json/"; 
	request_enid( "POST",  data_send, url, response_set_link);
	
}
var response_set_link = function(data){
	redirect("../login");
}
var  quita_espacios_en_telefono = function(){
	
	var valor 	= 	get_parameter(".telefono");
	var nuevo 	=  	quitar_espacios_numericos(valor);
	$(".telefono").val(nuevo);	
}
var notifica_punto_entrega = function(e){

	debugger;
	var url 		 	= 	"../q/index.php/api/cobranza/solicitud_cambio_punto_entrega/format/json/";
	if (get_parameter(".primer_registro") ==  1) {
		var url 		 	= 	"../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";	
	}	
	var data_send 		=  $(".form_punto_encuentro_horario").serialize()+"&"+$.param({"tipo_entrega":1});			
	bloquea_form(".form_punto_encuentro_horario");
	request_enid("POST",  data_send , url , response_notificacion_punto_entrega , ".place_notificacion_punto_encuentro");						
	e.preventDefault();
}
var response_notificacion_punto_entrega = function(data){	
	display_elements([".place_notificacion_punto_encuentro" , ".form_punto_encuentro_horario"] , 0);	
	if (get_parameter(".primer_registro") ==  1) {		
		redirect("../area_cliente/?action=compras&ticket="+data.id_recibo);			
	}else{
		redirect("../pedidos/?seguimiento="+get_parameter(".recibo")+"&domicilio=1");			
	}
}