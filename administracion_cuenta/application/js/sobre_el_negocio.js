function carga_info_sobre_el_negocio(){
	
	url =  "../base/index.php/api/negocio/";
	data_send  = {};
	$.ajax({
		url : url , 
		type: "GET",
		data: data_send , 
		beforeSend: function(){
			show_load_enid(".place_sobre_el_negocio" , "Cargando ... ");
		}
	}).done(function(data){												
		llenaelementoHTML(".place_sobre_el_negocio" , data);
		$(".entregas_en_casa").click(u_entregas_en_casa);
	}).fail(function(){
		//show_error_enid(".place_direccion_envio" , "Error ... al cargar portafolio.");
	});
}
/**/
function u_entregas_en_casa(e){
	url =  "../base/index.php/api/negocio/entregas_en_casa/format/json/";	
	data_send  = {entregas_en_casa : e.target.id};
	$.ajax({
		url : url , 
		type: "PUT",
		data: data_send , 
		beforeSend: function(){
			show_load_enid(".place_sobre_el_negocio" , "Cargando ... ");
		}
	}).done(function(data){													
		carga_info_sobre_el_negocio();		
	}).fail(function(){
		//show_error_enid(".place_direccion_envio" , "Error ... al cargar portafolio.");
	});
}