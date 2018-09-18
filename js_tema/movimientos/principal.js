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
	$("footer").ready(cargar_ultimos_movimientos);
});
/**/
function metodos_de_envio_disponibles(){

	var url =  "../pagos/index.php/api/afiliados/metodos_disponibles_pago/format/json/";	
	var data_send = {};	
	request_enid( method,  data_send, url, response_metodos_envio, ".place_info_cuentas_pago" );
}
/**/
function response_metodos_envio(data){
		llenaelementoHTML(".place_info_cuentas_pago" , data);
		/**/
		$(".actualizar_form").click(registra_actualizacion_banco_persona);
		$(".siguiente_banco").click(valida_banco_seleccionado);
		$(".siguiente_numero_tarjeta").click(valida_tarjeta_registrada);
		$(".banco_cuenta").change(muestra_imagen_banco);

		$(".numero_tarjeta").keyup(function(){
			quita_espacios(".numero_tarjeta");
		});

		 $('.next').click(function() { 
            var numStep = get_attr( this , "num-step" );
            var clStep = '#collapse' + (parseInt(numStep) + 1);
            $(clStep).collapse('show');
            $('#accordion .in').collapse('hide');
            console.log(clStep);   
            /*cambiar estilo e imagen a botón*/
            $('.s' + numStep).addClass('step-ok').removeClass('step');
            $('.s' + numStep).empty().append('<i class=\"fa fa-check\" aria-hidden=\"true\"><\/i>');

        });

        $('.prev').click(function() {
            var numStep = get_attr( this , "num-step" );
            var clStep = '#collapse' + (parseInt(numStep) - 1);
            $(clStep).collapse('show');
            $('#accordion .in').collapse('hide');
        });

        $('.btn-primary').click(function() {

            var delay = 4000; 
        });
        
         $('.btn-secondary').click(function() {
            $('.step-ok').addClass('step').removeClass('step-ok');
            $('.s0').empty().append('1');
            $('.s1').empty().append('2');
            $('#collapse0').collapse('show');
            $('#accordion .in').collapse('hide');

        });
       
}
/**/
function muestra_imagen_banco(){

	
	var banco =  $(".banco_cuenta").val();

	set_option("banco", parseInt(banco));
	var bancos_imgs = [ "", "1.png", "2.png" , "3.png", "4.png", "5.png", "6.png", "7.png" , "8.png", "9.png"];

	if (get_option("banco")>0) {
		url_img_banco =  "../img_tema/bancos/"+bancos_imgs[banco];	    	
	    imagen ="<img src='"+url_img_banco+"' style='width:100%'>";
	    llenaelementoHTML(".place_imagen_banco" , imagen);
	}else{
		llenaelementoHTML(".place_imagen_banco" , "");	
	}	    
}
/**/
function registra_actualizacion_banco_persona(){

	flag_1 =  valida_banco_seleccionado();	
	flag_2 =  valida_tarjeta_registrada();
	flag_3 =  valida_propietario_tarjeta();

	if (flag_1 == 1){
		if (flag_2 == 1) {
			if (flag_3 == 1){

					var url =  "../pagos/index.php/api/afiliados/cuenta_afiliado/format/json/";						
					var data_send = {"numero_tarjeta" : get_numero_tarjeta(), "banco" : get_option("banco"), "propietario" : get_propietario()};	
					request_enid( "PUT",  data_send, url, metodos_de_envio_disponibles, ".place_info_cuentas_pago");
			}
		}
	}
}
/**/
function valida_banco_seleccionado(){
	
	banco =  $(".banco_cuenta").val();
	set_option("banco", banco);
	if(get_option("banco") ==  0){
		
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
	set_option("numero_tarjeta",numero_tarjeta);		
	return  valida_text_form(".numero_tarjeta" , ".place_numero_tarjeta" , 16 , "Número de tarjeta" );		
	
}
/**/
function valida_propietario_tarjeta(){
	propietario =  $(".propietario").val();
	set_optino("propietario" , propietario);
	return valida_text_form(".propietario" , ".place_propietario_tarjeta" , 5 , "Propietario de la tarjeta" );				
}