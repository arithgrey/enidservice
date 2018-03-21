function carga_metricas_por_usuario(e){


	url =  "../q/index.php/api/productividad/usuarios/format/json/";
	$.ajax({
		url : url , 
		type : "GET" ,
		data: $(".form_busqueda_productividad_usuario").serialize() , 
		beforeSend: function(){
			show_load_enid( ".place_productividad_usuario" , "Cargando ..." , 1 );
		}
	}).done(function(data){
		
		llenaelementoHTML(".place_productividad_usuario" , data);		

	}).fail(function(){
		show_error_enid(".place_productividad_usuario" , "Error al cargar ..."); 
	});
	
	e.preventDefault();
}