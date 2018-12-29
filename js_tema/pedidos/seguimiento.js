$(document).ready(function(){

	valida_notificacion_pago();
});
var valida_notificacion_pago = function(){

	var proceso =  get_parameter(".notificacion_pago");
	
	if (proceso ==  1) {

		var text = "¿HAZ REALIZADO TU COMPRA?";
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
var notificar_compra =  function(){

	var recibo 	  =  get_parameter(".orden");
	var data_send =  {recibo : recibo};
	var url 	  =  "../q/index.php/api/recibo/notificacion_pago/format/json/";  
	request_enid( "PUT",  data_send, url, procesa_notificacion )
};
var procesa_notificacion = function(data){

	var text = "RECIBIMOS LA NOTIFICACIÓN DE TU COMPRA!";
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