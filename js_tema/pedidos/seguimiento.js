"use strict";
$(document).ready(function(){
	valida_notificacion_pago();
	carga_productos_sugeridos();
});
let valida_notificacion_pago = function(){

	let proceso =  get_parameter(".notificacion_pago");
	
	if (proceso ==  1) {

		let text = "¿HAZ REALIZADO TU COMPRA?";
		$.confirm({
		    title: text,
		    content: '',
		    type: 'green',
		    buttons: {   
		        ok: {
		            text: "SI, QUIERO NOTIFICAR MI COMPRA",
		            btnClass: 'btn-primary',
		            keys: ['enter'],
		            action: function(){
						notificar_compra();		                
		            }
		        },
		        cancel: function(){
		           
		        }
		    }
		});
	}
};
let notificar_compra =  function(){

	let recibo 	  =  get_parameter(".orden");
	let data_send =  {recibo : recibo};
	let url 	  =  "../q/index.php/api/recibo/notificacion_pago/format/json/";  
	request_enid( "PUT",  data_send, url, procesa_notificacion )
};
let procesa_notificacion = function(data){

	let text = "RECIBIMOS LA NOTIFICACIÓN DE TU COMPRA!";
		$.confirm({
		    title: text,
		    content: '',
		    type: 'green',
		    buttons: {   
		        ok: {
		            text: "RASTREA TU PEDIDO",
		            btnClass: 'btn-primary',
		            keys: ['enter'],
		            action: function(){
						redirect("");
		            }
		        }
		    }
		});
};
let carga_productos_sugeridos = function(){

	let url 		=  "../q/index.php/api/servicio/sugerencia/format/json/";
	let q 			=  get_parameter(".qservicio");
	let data_send 	= {"id_servicio" :  q};
	request_enid( "GET",  data_send, url, response_carga_productos);
}
let response_carga_productos = function(data){
	if (data["sugerencias"] == undefined ){
		$(".text_interes").removeClass("hidden");
		llenaelementoHTML(".place_tambien_podria_interezar" , data);
	}
}