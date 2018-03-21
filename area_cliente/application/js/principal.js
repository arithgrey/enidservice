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
	
	if(get_option("action") ==  "ventas"){		
		set_option("modalidad_ventas" , 1);		
	}else{
		set_option("modalidad_ventas" , 0);				
	}
	$("footer").ready(carga_compras_usuario);		
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
	$(".btn_buzon").click(carga_buzon);
	$(".preguntas").click(function(e){

		if(e.target.id ==  0){
			$(".btn_preguntas_compras").addClass("a_enid_blue");
			$(".btn_preguntas_compras").removeClass("a_enid_black");
			$(".btn_preguntas_ventas").addClass("a_enid_black");
		}else{

			$(".btn_preguntas_ventas").addClass("a_enid_blue");
			$(".btn_preguntas_ventas").removeClass("a_enid_black");
			$(".btn_preguntas_compras").addClass("a_enid_black");
			
		}
		
		/**/
		set_option( "modalidad_ventas", e.target.id);  		
		$(".contenedor_opciones_buzon").show();
		carga_buzon();
	});
	/**/

});
