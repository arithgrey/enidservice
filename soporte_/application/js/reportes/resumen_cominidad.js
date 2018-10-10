function  carga_informe_comunidad(){	
	var url 		=  	now + "index.php/api/emp/laexperiencia/format/json/";
	var id_empresa 	= 	get_parameter(".id_empresa");
	var in_session 	=  	get_parameter(".in_session");	
	
	$.ajax({
		url :  url , 
		data :  { "id_empresa" :id_empresa , "in_session" :  in_session , "config" : 1,  "seccion" : 3 } ,
		beforeSend: function(){			
			show_load_enid(".place_comentarios_comunidad" , "Cargando ..." , 1 ); 
		}
	}).done(function(data){				
		llenaelementoHTML(".place_comentarios_comunidad" , data );
		$(".btn-registrar-cambios").click(status_empresa);
	}).fail(function(){
		show_error_enid(".place_comentarios_comunidad" , "Problemas al cargar reporte al administrador ");
	});		
}
/**/
function status_empresa(e){
	
	id_experiencia =  get_parameter_enid($(this) , "id"); 
	url =  now + "index.php/api/emp/experienciaq/format/json/";		
	status_ =  ".status_"+ id_experiencia;
	nestatus =  $(status_).val(); 

	$.ajax({
		url : url , 
		type :  "PUT",
		data : {"id_experiencia" :  id_experiencia , "q" : "status" , "val" : nestatus } ,		
		beforeSend: function(){
			show_load_enid(".place_comentarios_comunidad" , "Actualizando estatus de la experiencia " , 1 ); 	
		}
	}).done(function(data){		
		show_response_ok_enid(".place_comentarios" ,  "Estado de la experiencia actualizando, con éxito" ); 								
		carga_informe_comunidad();
	}).fail(function(){
		show_error_enid(".place_comentarios_comunidad" , "Problemas al registrar cambios");		
	});
}