function get_conceptos(){
	
	data_send = {};
	url =  "../base/index.php/api/privacidad/conceptos/format/json/";		
	data_send =  {};
		$.ajax({
				url : url , 
				type: "GET",
				data: data_send , 
				beforeSend: function(){}

		}).done(function(data){										
			llenaelementoHTML(".contenedor_conceptos_privacidad" , data);			
			$(".concepto_privacidad").click(update_conceptos_privacidad);
		}).fail(function(){
				
	});
}
/**/
function  update_conceptos_privacidad(e){
	
	concepto =  e.target.id;
	termino_asociado =  $(this).attr("termino_asociado");		
	data_send = {"concepto": concepto, "termino_asociado" : termino_asociado};

	url =  "../base/index.php/api/privacidad/concepto/format/json/";			
		$.ajax({
				url : url , 
				type: "PUT",
				data: data_send , 
				beforeSend: function(){}

		}).done(function(data){													
			
			get_conceptos();						
			show_response_ok_enid(".place_registro_conceptos" , "Terminos de privacidad actualizados!");
		}).fail(function(){
				
	});
}
