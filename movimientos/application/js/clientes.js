function mostrar_campos_editables(){

	if (get_flageditable() ==  0 ){

		showonehideone('.editable' , '.texto_editable' );	
		$(".text_btn_editar_campos").text("Guardar");
		set_flageditable(1);
	}else{

		showonehideone('.texto_editable' , '.editable');	
		$(".text_btn_editar_campos").text("Editar");
		set_flageditable(0);
	}
}
/**/
function set_flageditable(n_flageditable){

	flageditable  =  n_flageditable;
}
/**/
function get_flageditable(){
	return flageditable;
}
/**/
function actualiza_info_campo( valor ,id_persona , name ){
	
	nuevo_valor = valor.value;  
	data_send = {"id_persona" : id_persona , "nuevo_valor" :  nuevo_valor , "name" :  name };
	url =  "../persona/index.php/api/persona/q/format/json/";	
		
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_campo_editado" , "Cargando ... ", 1 );
			}
	}).done(function(data){									
		show_response_ok_enid(".place_campo_editado" , "Información actualizada!");									
		carga_info_persona();
		
	}).fail(function(){			
		show_error_enid(".place_campo_editado" , "Error ... ");
	});		
	
}
/**/
function actualiza_info_campo_change( valor , id_persona , name ){
	

	var nombre_campo = ["", "idtipo_negocio", "id_servicio", "id_fuente"];
	nuevo_name  = nombre_campo[name];

	nuevo_valor = valor.value;  
	data_send = {"id_persona" : id_persona , "nuevo_valor" :  nuevo_valor , "name" :  nuevo_name };
	url =  "../persona/index.php/api/persona/q/format/json/";	
	
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_campo_editado" , "Cargando ... ", 1 );
			}
	}).done(function(data){									
		
		show_response_ok_enid(".place_campo_editado" , "Información actualizada!");									
		carga_info_persona();
	}).fail(function(){			
		show_error_enid(".place_campo_editado" , "Error ... ");
	});			
}
/**/
function set_info_persona_ticket(event){

	
	id_persona = event.target.id;
	set_persona(id_persona);
	get_proyectos_persona();
}
/**/
function get_nombre_persona(){
	return nombre_persona; 	
}
/**/
function set_nombre_persona(n_nombre_persona){
	nombre_persona = n_nombre_persona;
}
/**/
function get_proyecto(){
	return id_proyecto;
}
/**/
function set_proyecto(n_proyecto){
	id_proyecto = n_proyecto;
}
/**/
function get_id_usuario(){
	return id_usuario;
}
/**/
function set_id_usuario(n_id_usuario){
	id_usuario =  n_id_usuario;
}
/**/
function set_id_ticket(n_id_ticket){
	id_ticket =  n_id_ticket;
}
/**/
function get_id_ticket(){
	return id_ticket;
}
/**/
function get_id_tarea(){
	return  id_tarea;
}
/**/
function set_id_tarea(n_id_tarea){
	id_tarea =  n_id_tarea;	
}