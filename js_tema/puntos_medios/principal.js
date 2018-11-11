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
			muestra_lineas_metro();			        
	        break;
	    case 2:
	        
	        break;
	    
	    case 3:
	        
	        break;

	    default:

	        break;
	} 

}
/**/
var muestra_lineas_metro = function(){
	
	var url  	   = "../q/index.php/api/linea_metro/index/format/json/";
	var data_send  = {"v":1};
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
		
		var url  	   = "../q/index.php/api/punto_encuentro/linea_metro/format/json/";
		var data_send  = {"id":id , "v":1};		
		request_enid( "GET",  data_send, url, response_estaciones);			
	}
}
var response_estaciones = function(data){

	llenaelementoHTML(".place_lineas" , data);
	llenaelementoHTML(".nombre_linea_metro" ,  "LÍNEA DEL METRO: "+get_option("nombre_linea"));
	$(".punto_encuentro").click(muestra_horarios);	
}
var muestra_horarios = function(){
	
	var id 			 	=  get_parameter_enid($(this) , "id");	
	set_option("punto_encuentro" , id);
	var nombre_estacion =  get_parameter_enid($(this) , "nombre_estacion");
	var costo_envio 	=  get_parameter_enid($(this) , "costo_envio");


	if (id > 0) {

		set_parameter(".punto_encuentro_form" , id);
		set_option("id_punto_encuentro" , id);	
		llenaelementoHTML(".nombre_estacion_punto_encuentro" , "<span class='strong'>ESTACIÓN:</span> "+nombre_estacion)
		$(".nombre_estacion_punto_encuentro").addClass("nombre_estacion_punto_encuentro_extra");

		llenaelementoHTML(".cargos_por_entrega" ,  "<span class='strong'>CARGO POR ENTREGA:</span> <span class='text_costo_envio'>"+costo_envio+"MXN</span>")
		$(".cargos_por_entrega").addClass("cargos_por_entrega_extra");
		$(".contenedor_estaciones").hide();
		var text  = "Recuerda que previo a la entrega de tu producto, deberás realizar el pago de 50 pesos por concepto de gastos de envío";
		llenaelementoHTML(".mensaje_cobro_envio" ,  text);
		$(".btn_continuar_punto_encuentro").show();
		$(".btn_continuar_punto_encuentro").click(muestra_quien_recibe);

	}

}
var muestra_quien_recibe = function(){
	
	display_elements([".resumen_encuentro",".titulo_principal_puntos_encuentro"],0);
	display_elements([".formulario_quien_recibe"] ,1);
}

var registra_usuario = function(e){
	
	var nombre 	= 	get_parameter(".nombre").length;
	var correo 	= 	get_parameter(".correo").length;	
	if ( nombre > 5 && correo > 5 ){
		
		var password 	 = 	""+CryptoJS.SHA1(randomString(8));					
		var data_send 	 = 	$(".form_punto_encuentro").serialize()+"&"+$.param({"password":password});					

		var url 		 = 	"../q/index.php/api/cobranza/primer_orden/format/json/";
		bloquea_form(".form_punto_encuentro");	
		$(".contenedor_ya_tienes_cuenta").hide();			
		request_enid("POST",  data_send , url , response_registro_usuario , ".place_notificacion_punto_encuentro_registro");					

	}else{
		
		focus_input([".correo_electronico" ,".nombre_correo"]);
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
		//desbloqueda_form(".form_punto_encuentro");
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

	var data_send 		=  $(".form_punto_encuentro_horario").serialize()+"&"+$.param({"es_contra_entrega":1});
	var url 		 	= 	"../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";
	bloquea_form(".form_punto_encuentro_horario");
	
	request_enid("POST",  data_send , url , response_notificacion_punto_entrega , ".place_notificacion_punto_encuentro");						
	e.preventDefault();
}
var response_notificacion_punto_entrega = function(data){	
	display_elements([".place_notificacion_punto_encuentro" , ".form_punto_encuentro_horario"] , 0);	
	redirect("../area_cliente/?action=compras&ticket="+data.id_recibo);		
}