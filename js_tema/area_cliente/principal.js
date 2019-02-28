let id_tarea = 0;
let flageditable  =0;
let persona = 0;
let telefono = 0;
let id_proyecto = 0; 
let id_usuario = 0;
let id_ticket = 0;
let flag_mostrar_solo_pendientes = 0;
let id_proyecto_persona_forma_pago =  "";
let menu_actual = "clientes";
let id_servicio = 0;
let id_persona = 0;

$(document).ready(function(){	
		
	
	set_option("estado_compra" , 6);	
	set_option("interno" ,1);
	valida_accion_inicial();

	
	$(".btn_mis_ventas").click(function(){			

		set_option("estado_compra" , 1);
		set_option("modalidad_ventas" , 1);		
		carga_compras_usuario();

	});

	$(".btn_cobranza").click(function(){				

		set_option("estado_compra" , 6);			
		set_option("modalidad_ventas" , 0);
		carga_compras_usuario();		
	});

	$(".btn_buzon").click(function(){

		carga_num_preguntas();
		carga_buzon();	
	});
	
	$(".preguntas").click(function(e){

		if(get_parameter_enid($(this) , "id") ==  0){
			$(".btn_preguntas_compras").addClass("a_enid_blue");
			$(".btn_preguntas_compras").removeClass("a_enid_black");
			$(".btn_preguntas_ventas").addClass("a_enid_black");
		}else{

			$(".btn_preguntas_ventas").addClass("a_enid_blue");
			$(".btn_preguntas_ventas").removeClass("a_enid_black");
			$(".btn_preguntas_compras").addClass("a_enid_black");		
		}		

		set_option( "modalidad_ventas", get_parameter_enid($(this) , "id"));  		
		$(".contenedor_opciones_buzon").show();
		carga_buzon();
	});

	$(".num_alcance").click(alcance_producto);
	
	
});
let carga_num_preguntas = function(){

	let url =  "../q/index.php/api/pregunta/preguntas_sin_leer/format/json/";		
	let data_send =  {"modalidad" : get_option("modalidad_ventas")};	
	request_enid( "GET",  data_send, url, response_carga_num_preguntas);
}
let response_carga_num_preguntas = function (data){

	$(".notificacion_preguntas_sin_leer_ventas").empty();
	$(".notificacion_preguntas_sin_leer_cliente").empty();
	let total_sin_leer =0;
		
	if(data.modo_vendedor>0){
		llenaelementoHTML(".notificacion_preguntas_sin_leer_ventas"  , "<span class='notificacion_preguntas_no_leida'>"+data.modo_vendedor+"</span>");			
		total_sin_leer = total_sin_leer + parseInt(data.modo_vendedor); 
	}
	if(total_sin_leer > 0 ){
		llenaelementoHTML(".notificacion_preguntas_sin_leer_cliente_buzon"  ,"<span class='notificacion_preguntas_no_leida white'>"+total_sin_leer+"</span>");
	}
		
}
let valida_accion_inicial = function(){


	switch(get_parameter(".action")){
	    case "ventas":

			set_option("modalidad_ventas" , 1);
			set_option("estado_compra" , 1);
			carga_compras_usuario();		
	        break;
	    case "compras":

	    	set_option("modalidad_ventas" , 0);					    	
	    	if (get_parameter(".ticket") > 0 ) {
	    		/*Cargo la información del ticket*/
	    		cargar_info_resumen_pago_pendiente();
	    	}else{
	    		carga_compras_usuario();		
	    	}
			

	        break;
	    case "preguntas":
	    	set_option("modalidad_ventas" , 0);				
	    	carga_num_preguntas();
			carga_buzon();

	        break;
	    default:
	    	set_option("modalidad_ventas" , 0);				
			carga_compras_usuario();		
	        break;		
	} 
}
let alcance_producto = function(e){
	let tipo 		=  get_parameter_enid($(this) , "id");	
	let url 		=  "../q/index.php/api/servicio/alcance_producto/format/json/";		
	let data_send 	=  {tipo:tipo};			
	request_enid( "GET",  data_send, url , function(data){
		redirect("../producto/?producto="+data);
	});	
}
let notifica_tipo_compra =  function(tipo, recibo){
	
	let url 		=  "../q/index.php/api/intento_compra/index/format/json/";		
	let data_send 	=  {tipo : tipo , recibo : recibo};			
	request_enid( "POST",  data_send, url);	
	
};