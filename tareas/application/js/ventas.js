function carga_metricas_prospectacion(e){
	

	url =  "../base/index.php/api/ventas/labor_venta/format/json/";	
	data_send =  $(".form_busqueda_labor_venta").serialize();			

	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_metricas_labor_venta" , "Cargando ... ", 1 );
			}
	}).done(function(data){								
			
			llenaelementoHTML(".place_metricas_labor_venta" , data);
			
		}).fail(function(){
			
		show_error_enid(".place_metricas_labor_venta" , "Error ... ");
	});

	e.preventDefault();	
}
/**/
function cargar_posibles_clientes(e){

	url =  "../base/index.php/api/ventas/prospecto/format/json/";	
	data_send =  $(".form_busqueda_prospecto").serialize();		
	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_prospecto_propuesta" , "Cargando ... ", 1 );
			}
	}).done(function(data){											
			llenaelementoHTML(".place_prospecto_propuesta" , data);			
			$('#datetimepicker6').datepicker();	
			$(".form_registro_propuesta").submit(registra_propuesta);
		}).fail(function(){			
			show_error_enid(".place_prospecto_propuesta" , "Error ... ");
	});

	e.preventDefault();
}
/**/
function registra_propuesta(e){
	
	url =  "../base/index.php/api/ventas/propuesta/format/json/";		
	data_send = $(".form_registro_propuesta").serialize();	
	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_prospecto_propuesta_registro" , "Cargando ... ", 1 );
			}
	}).done(function(data){	
						
			show_response_ok_enid(".place_prospecto_propuesta_registro" , "Propuesta registrada!");		
			$("#registrar_propuesta").modal("hide");
			document.getElementById("form_registro_propuesta").reset(); 
		}).fail(function(){			
			show_error_enid(".place_prospecto_propuesta_registro" , "Error ... ");
	});

	e.preventDefault();

}