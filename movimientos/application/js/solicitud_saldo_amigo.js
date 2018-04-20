$(document).ready(function(){		
	$(".monto_a_ingresar").keyup(valida_monto_ingreso);	
	$(".solicitar_saldo_amigo_form").submit(solicita_saldo_amigo);
});
/**/
function valida_monto_ingreso(){
	valor =  this.value; 	
	$(".monto_a_ingresar").val(quitar_espacios_numericos(valor));		
}
/**/
function solicita_saldo_amigo(e){
	url =  "../pagos/index.php/api/tickets/solicitud_amigo/format/json/";	
	data_send =  $(".solicitar_saldo_amigo_form").serialize();
	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_solicitud_amigo" , "Cargando ... ", 1 );
				bloquea_form(".solicitar_saldo_amigo_form");
			}
	}).done(function(data){			

		url_movimientos ="../movimientos";
		msj =  "Tu solicitud fue enviada, cuando tu amigo responda, tendrás un notificación, puedes consultar tus solicitudes <a href='"+url_movimientos+"' class='a_enid_blue_sm white'>aquí</a>";
		llenaelementoHTML(".place_solicitud_amigo" , "<br><div class='mensaje_envio_amigo'>"+msj+"</div>");
	}).fail(function(){			
		show_error_enid(".place_solicitud_amigo" , "Error ... ");
	});			
	e.preventDefault();	
}