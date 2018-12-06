function auto_completa_direccion(){

	quita_espacios(".codigo_postal"); 	
	var cp 					= get_parameter(".codigo_postal");
	var numero_caracteres 	= cp.length; 
	if(numero_caracteres > 4 ) {
		var url 		=  "../q/index.php/api/codigo_postal/cp/format/json/";	
		var data_send 	=  {"cp" : cp , "delegacion" : get_option("delegacion") };
		request_enid( "GET",  data_send , url , response_auto_complete_direccion );
	}
}
/**/
function response_auto_complete_direccion(data){

	
	if(data.resultados >0){
		llenaelementoHTML(".place_colonias_info" , data.colonias);				
		$(".parte_colonia_delegacion").show();			

		$(".delegacion_c").show();
		llenaelementoHTML(".place_delegaciones_info" , data.delegaciones);	

		$(".estado_c").show();
		llenaelementoHTML(".place_estado_info" , data.estados);

		$(".pais_c").show();
		llenaelementoHTML(".place_pais_info" , data.pais);					
		muestra_error_codigo(0);	
		set_option("existe_codigo_postal", 1);

	}else{
		/**/		
		var elementos  =  [".delegacion" , ".place_colonias_info"];
		set_black(elementos);		
		$(".parte_colonia_delegacion").hide();
		set_option("existe_codigo_postal", 0);
		muestra_error_codigo(1);	
	}	
}
/**/
function muestra_error_codigo(flag_error){
	llenaelementoHTML( ".place_codigo_postal" ,  "");
	if (flag_error ==  1) {
		$(".codigo_postal").css("border" , "1px solid rgb(13, 62, 86)");			
		var mensaje_user =  "Codigo postal invalido, verifique"; 		
		llenaelementoHTML( ".place_codigo_postal" ,  "<span class='alerta_enid'>" + mensaje_user + "</span>");
		recorrepage("#codigo_postal");
	}
}

/**/
function registra_nueva_direccion(e){

	if(get_option("existe_codigo_postal") ==  1){
		registro_direccion();	
		
	}else{
		muestra_error_codigo(1);
	}
	e.preventDefault();
}
/**/
function registro_direccion(){
	
	if (asentamiento != 0 ){
		
		set_option("id_recibo" , $(".id_recibo").val());
		var data_send 		=  	$(".form_direccion_envio").serialize();		
		var url 			=  	"../q/index.php/api/codigo_postal/direccion_envio_pedido/format/json/";
		request_enid( "POST",  data_send , url , response_registro_direccion);
	}else{
		recorrepage("#asentamiento");										
		llenaelementoHTML( ".place_asentamiento" ,  "<span class='alerta_enid'>Seleccione</span>");
	}
}
/**/
var  response_registro_direccion = function(data){

	
	if (data != -1 ){
			
		var url_area_cliente	=  "../area_cliente/?action=compras&ticket="+get_option("id_recibo"); 	
		var url_seguimiento 	=  "../pedidos/?seguimiento="+get_option("id_recibo")+"&&domicilio=1"; 			
		var url =  (get_parameter(".es_seguimiento") != undefined && get_parameter(".es_seguimiento") ==  1) ? url_seguimiento :url_area_cliente; 
		redirect(url);

	}else{

		format_error( ".notificacion_direccion", "VERIFICA LOS DATOS DE TU DIRECCIÓN");
		recorrepage(".notificacion_direccion");	
	}	
}
/**/
function oculta_delegacion_estado_pais(flag){


	var elementos = [".delegacion_c" , ".estado_c" , ".pais_c" , ".button_c" , ".direccion_principal_c"];
	for(var x in elementos){
		if (flag ==  "1") {
			$(elementos[x]).hide();	
		}else{
			$(elementos[x]).show();
		}
		x ++;
	}
}
function carga_informacion_envio_complete(){
	
	var url 		=  	"../q/index.php/api/usuario_direccion/direccion_envio_pedido/format/json/";		
	var data_send 	=  	{id_recibo : get_option("recibo")};				
	var place_info 	=	".place_info";		
	if(get_option("interno") ==  1){
		place_info =".place_servicios_contratados";
	}	
	request_enid( "GET",  data_send , url , function(data){
		response_carga_informacion_envio_complete(data , place_info)	
	});	
}
/**/
function response_carga_informacion_envio_complete(data , place_info){

		llenaelementoHTML(place_info , data);				
		$(".resumen_pagos_pendientes").click(cargar_info_resumen_pago_pendiente);		
		$(".editar_envio_btn").click(function(){
			showonehideone(".contenedor_form_envio" ,  ".contenedor_form_envio_text" );
		});
		/**/
		$(".codigo_postal").keyup(auto_completa_direccion);
		
		$(".numero_exterior").keyup(function (){
			quita_espacios(".numero_exterior"); 	
		});
		$(".numero_interior").keyup(function (){
			quita_espacios(".numero_interior"); 
		});
		
		$(".form_direccion_envio").submit(registra_nueva_direccion);
}
function informacion_envio_complete(){

	var url 		=  "../q/index.php/api/codigo_postal/direccion_envio_pedido/format/json/";	
	var data_send 	=  {id_recibo : get_option("id_proyecto_persona_forma_pago")};				
	request_enid( "GET",  data_send , url , function(){
		llenaelementoHTML(".place_direccion_envio" , data);		
		recorrepage(".contenedo_compra_info");
	}  , ".place_direccion_envio");
}