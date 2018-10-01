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
var id_proyecto_persona_forma_pago = 0;
var id_persona = 0;

$(document).ready(function(){	
		
	set_option("action" , $(".action").val());		
	set_option("estado_compra" , 6);	
	set_option("interno" ,1);
	valida_accion_inicial();

	
	$(".btn_mis_ventas").click(function(){			
		set_option("estado_compra" , 1);			
		set_option("modalidad_ventas" , 1);		
		carga_compras_usuario();	
	});
	/*On click,  cargamos deudas pendientes de esta persona*/
	$(".btn_cobranza").click(function(){				
		/**/
		set_option("estado_compra" , 6);			
		set_option("modalidad_ventas" , 0);
		carga_compras_usuario();		
	});
	$(".btn_buzon").click(function(){
		/**/
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
		
		/**/
		set_option( "modalidad_ventas", get_parameter_enid($(this) , "id"));  		
		$(".contenedor_opciones_buzon").show();
		carga_buzon();
	});
	/**/
	$(".num_alcance").click(alcance_producto);
	$("footer").ready(carga_num_preguntas);
	
	
});
/**/
function carga_num_preguntas(){
	
	set_option("modalidad_ventas" , 1);	
	url =  "../q/index.php/api/pregunta/preguntas_sin_leer/format/json/";		
	data_send =  {"modalidad" : get_option("modalidad_ventas")};	
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				//show_load_enid(".place_buzon" , "Cargando ... ", 1 );
			}
	}).done(function(data){									
		/**/
		$(".notificacion_preguntas_sin_leer_ventas").empty();
		$(".notificacion_preguntas_sin_leer_cliente").empty();
		total_sin_leer =0;
		if(data.modo_vendedor>0){
			llenaelementoHTML(".notificacion_preguntas_sin_leer_ventas"  , "<span class='notificacion_preguntas_no_leida'>"+data.modo_vendedor+"</span>");			
			total_sin_leer = total_sin_leer + parseInt(data.modo_vendedor); 
		}if(data.modo_cliente>0){
			llenaelementoHTML(".notificacion_preguntas_sin_leer_cliente"  ,"<span class='notificacion_preguntas_no_leida'>"+data.modo_cliente+"</span>");
			total_sin_leer = total_sin_leer + parseInt(data.modo_cliente);
		}		
		if(total_sin_leer > 0 ){
			llenaelementoHTML(".notificacion_preguntas_sin_leer_cliente_buzon"  ,"<span class='notificacion_preguntas_no_leida white'>"+total_sin_leer+"</span>");
		}
		
	}).fail(function(){			
		show_error_enid(".place_buzon"  , "Error ... ");
	});	
}
/**/
function valida_accion_inicial(){
	
	action =   get_option("action"); 		
	switch(action){
	    case "ventas":
			set_option("modalidad_ventas" , 1);		
			carga_compras_usuario();		
	        break;
	    case "compras":
			set_option("modalidad_ventas" , 0);				
			carga_compras_usuario();		
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
/**/
function alcance_producto(e){
	tipo =  get_parameter_enid($(this) , "id");	
	url =  "../q/index.php/api/servicio/alcance_producto/format/json/";		
	data_send =  {tipo:tipo};			
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){}
	}).done(function(data){											
		redirect("../producto/?producto="+data);
	}).fail(function(){			
		show_error_enid(".place_buzon"  , "Error ... ");
	});	
}
