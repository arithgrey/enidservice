"use strict";
let actualiza_info_campo = function (valor, id_persona, name) {

    let nuevo_valor = valor.value;
    let data_send = {"id_persona": id_persona, "nuevo_valor": nuevo_valor, "name": name};
    let url = "../persona/index.php/api/persona/q/format/json/";
    request_enid("PUT", data_send, url, response_actualiza_info_campo, ".place_campo_editado");
}
let response_actualiza_info_campo = function (data) {

    show_response_ok_enid(".place_campo_editado", "Información actualizada!");
    carga_info_persona();

}
/*
*
* function mostrar_campos_editables(){

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
let actualiza_info_campo_change = function( valor , id_persona , name ){


	let nombre_campo = ["", "idtipo_negocio", "id_servicio", "id_fuente"];
	let nuevo_name  = nombre_campo[name];

	let nuevo_valor = valor.value;
	let data_send = {"id_persona" : id_persona , "nuevo_valor" :  nuevo_valor , "name" :  nuevo_name };
	let url =  "../persona/index.php/api/persona/q/format/json/";
	request_enid( "PUT",  data_send, url, response_actualiza_info_campo_change , ".place_campo_editado" );
}
function response_actualiza_info_campo_change(data){

	show_response_ok_enid(".place_campo_editado" , "Información actualizada!");
	carga_info_persona();
}
function set_info_persona_ticket(event){
	id_persona = event.target.id;
	set_option("persona", id_persona);
	get_proyectos_persona();
}


*/