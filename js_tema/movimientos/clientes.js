"use strict";
function mostrar_campos_editables(){

	if (get_option("flageditable") ==  0 ){

		showonehideone('.editable' , '.texto_editable' );	
		$(".text_btn_editar_campos").text("Guardar");
		set_option("flageditable", 1);
		
	}else{

		showonehideone('.texto_editable' , '.editable');	
		$(".text_btn_editar_campos").text("Editar");
		set_option("flageditable", 0);
	}
}
/**/
function actualiza_info_campo( valor ,id_persona , name ){
	
	var nuevo_valor = valor.value;  
	var data_send = {"id_persona" : id_persona , "nuevo_valor" :  nuevo_valor , "name" :  name };
	var url =  "../persona/index.php/api/persona/q/format/json/";	
	request_enid( "PUT",  data_send, url, response_actualiza_info_campo , ".place_campo_editado");
}
/**/
function response_actualiza_info_campo(data){
	show_response_ok_enid(".place_campo_editado" , "Información actualizada!");									
	carga_info_persona();
}
/**/
function actualiza_info_campo_change( valor , id_persona , name ){
	

	var nombre_campo = ["", "idtipo_negocio", "id_servicio", "id_fuente"];
	var nuevo_name  = nombre_campo[name];

	var nuevo_valor = valor.value;  
	var data_send = {"id_persona" : id_persona , "nuevo_valor" :  nuevo_valor , "name" :  nuevo_name };
	var url =  "../persona/index.php/api/persona/q/format/json/";	
	request_enid( "PUT",  data_send, url, response_actualiza_info_campo_change , ".place_campo_editado" );
}
/**/
function response_actualiza_info_campo_change(data){

	show_response_ok_enid(".place_campo_editado" , "Información actualizada!");									
	carga_info_persona();
}

/**/
function set_info_persona_ticket(event){
	id_persona = event.target.id;
	set_option("persona", id_persona);
	get_proyectos_persona();
}