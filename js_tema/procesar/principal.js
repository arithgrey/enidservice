var plan = 0;
var num_ciclos =  0;
var dominio =  0;
var descripcion_servicio ="";
var ciclo_facturacion = 0;
var id_persona = 0;
var id_proyecto_persona_forma_pago =0;
var email = "";
var nombre = "";
var telefono =  ""; 
var usuario_referencia =  0;
var direccion ="";
var option =[];
$(document).ready(function(){

	$(".base_compras").hide();
	$(".nav-sidebar").hide();
	$(".base_paginas_extra").hide();
	recorrepage(".contenedor_compra");	
	$(".form-miembro-enid-service").submit(registra_afiliado);

	set_option( "plan", $(".plan").val());
	set_option( "dominio" , $(".dominio").val());	
	set_option( "num_ciclos" , $(".num_ciclos").val());
	set_option( "ciclo_facturacion" , $(".ciclo_facturacion").val());
	set_option( "descripcion_servicio" , $(".resumen_producto").val());

	$(".btn_procesar_pedido_cliente").click(procesar_pedido_usuario_activo);
	$(".telefono").keyup(quita_espacios_en_telefono);


});
/**/
function registra_afiliado(e){

	text_password =  $.trim($(".password").val());	
	if (text_password.length>7 ) {
		flag =  valida_num_form(".telefono" , ".place_telefono" ); 
		if (flag == 1 ){
				flag2 =  valida_text_form(".telefono" , ".place_telefono" , 6 , "Número telefónico" );
				if (flag2 ==  1 ) {


					//debugger;
					$(".resumen_productos_solicitados").hide();					
					recorrepage(".contenedor_formulario_compra");
					
					bloquea_form(".form-miembro-enid-service");
					var url 	= 	"../q/index.php/api/cobranza/primer_orden/format/json/";				
					var pw 		= 	$.trim($(".password").val());	
					var pwpost 	= 	""+CryptoJS.SHA1(pw);


					set_option("email", $(".email").val());					
					set_option("nombre" ,$(".nombre").val());					
					set_option("telefono",$(".telefono").val());		
					set_option("usuario_referencia", $(".q2").val());																
					set_option("talla"	, $(".talla").val());																				
					var data_send =  {"password": pwpost , "email" : get_option("email") , "nombre" : get_option("nombre"), "telefono": get_option("telefono") , "plan" : get_option("plan") , "num_ciclos" : get_option("num_ciclos"), "descripcion_servicio" : get_option("descripcion_servicio"), "ciclo_facturacion":get_option("ciclo_facturacion"), "usuario_referencia":get_option("usuario_referencia") , "talla" : get_option("talla")};				
					request_enid( "POST",  data_send, url, respuesta_registro, 0 , before_registro_afiliado);	
				}			
			}		
		}else{
			desbloqueda_form(".form-miembro-enid-service");
			llenaelementoHTML( ".place_password_afiliado" ,  "<span class='alerta_enid'>Registre una contraseña de mínimo 8 caracteres</span>");
		}

	e.preventDefault();
}
/**/
function before_registro_afiliado(){
	bloquea_form(".form-miembro-enid-service");											
	show_load_enid(".place_registro_afiliado" ,  "Validando datos " , 1 );
}
/***/
var respuesta_registro = function(data){

	if (data != -1) {								

		desbloqueda_form(".form-miembro-enid-service");
		if(data.usuario_existe > 0){

			flex(".usuario_existente");						
			$(".place_registro_afiliado").empty();
			recorrepage(".usuario_existente");

		}else{									

			set_option("data_registro" , data);
			set_option("registro" , 1);
			set_option("usuario_nuevo" , 1);
			config_direccion();
		}
	
	}else{								
		redirect("../");
	}
	
}

/**/
function procesar_pedido_usuario_activo(){


	var url = "../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";		
	set_option("talla"	, $(".talla").val());		
	var data_send =  {"plan" : get_option("plan") , "num_ciclos": get_option("num_ciclos"), "descripcion_servicio" : get_option("descripcion_servicio"),"ciclo_facturacion":get_option("ciclo_facturacion") ,  "talla" : get_option("talla") };					
	request_enid( "POST",  data_send, url, respuesta_proceso_venta_usuario_activo, "" , before_procesar_pedido_activo);
	
}
/**/
function before_procesar_pedido_activo(){
	$('.btn_procesar_pedido_cliente').prop('disabled', true);
	show_load_enid(".place_proceso_compra" ,  "Validando datos " , 1 );
}
/**/
function response_procesar_pedido_activo(data){
	show_error_enid(".place_proceso_compra" , "Error al iniciar sessión");			
}
/**/
function respuesta_proceso_venta_usuario_activo(data){				


	set_option("data_registro" , data);
	set_option("registro" , 0);
	set_option("usuario_nuevo" , 0);
	config_direccion();	
}
/**/
function quita_espacios_en_telefono(){
	
	var valor 	= 	get_parameter(".telefono");
	var nuevo 	=  	quitar_espacios_numericos(valor);
	$(".telefono").val(nuevo);	
}
/**/
/**/
function get_usuario_referencia(){
	return usuario_referencia;
}
/**/
function get_direccion(){
	return direccion;
}
/**/
function set_direccion(n_direccion){
	direccion =  n_direccion;
}
/**/
function config_direccion(){

	var data_registro =  get_option("data_registro");		
	var ficha 	      =	 "";
	if (get_option("usuario_nuevo") == 1){
		
		ficha =  data_registro.ficha;		
	}else{
		data_registro =  get_option("data_registro");		
		ficha =  data_registro.ficha; 	
	}

	$(".contenedo_compra_info").show();
	llenaelementoHTML(".contenedo_compra_info" , ficha);
	recorrepage(".contenedor_compra");	
	$(".codigo_postal").keyup(auto_completa_direccion);		
	$(".numero_exterior").keyup(function (){
		quita_espacios(".numero_exterior");
	});						
	$(".numero_interior").keyup(function (){
		quita_espacios(".numero_interior"); 
	});
	$(".form_direccion_envio").submit(registra_nueva_direccion);							
	
}