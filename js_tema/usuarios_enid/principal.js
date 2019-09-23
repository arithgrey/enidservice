"use strict";
$(document).ready(function(){

	set_option("estado_usuario" , 1);
	set_option("depto" , 0);	
	set_option("page" , 1);	
	$("footer").ready(carga_usuarios);			
	$(".equipo_enid_service").click(carga_usuarios);
	$(".form-miembro-enid-service").submit(actualizacion_usuario);
	$(".btn_nuevo_usuario").click(pre_nuevo_usuario);
	$(".form-miembro-enid-service .depto" ).change(get_puestos_por_cargo);
	$(".perfiles_permisos").click(carga_mapa_menu);
	$(".perfil_enid_service").change(carga_mapa_menu);
	$(".form_recurso").submit(registra_recurso);	

	$(".tab_afiliados").click(function(){
		set_option("depto" , 8);
		set_option("estado_usuario" , 1);
		carga_usuarios();
	});
	$(".tab_equipo_enid_service").click(function(){				
		set_option("page" , 1);	
		set_option("depto" , 0);
		set_option("estado_usuario" , 1);
		carga_usuarios();
	});
	$(".equipo_enid_service").click(function(e){				
		let estado_usuario  = get_attr(this, "id");
		set_option("page" , 1);	
		set_option("depto" , 0);
		set_option("estado_usuario" , estado_usuario);
		carga_usuarios();
	});
	$(".form_categoria").submit(simula_envio_categoria);
	$(".form-tipo-talla").submit(carga_tipos_tallas);
	$("#agregar_tallas_menu").click(function(){
		$(".form-tipo-talla").submit();
	});

});
let get_place_usuarios = () => {


	let nuevo_place ="";
	switch(parseFloat(get_option("depto") )){
		    case 0:
		        nuevo_place = ".usuarios_enid_service";	        
		        break;
		    case 8:	    	
		        nuevo_place = ".usuarios_enid_service_afiliados";
		        break;
		    default:      
	} 	
	return nuevo_place;
}
let carga_usuarios = () => {
	
	let place 		= 	get_place_usuarios();	
	let url 		=  	"../q/index.php/api/usuario/miembros_activos/format/json/";	
	let data_send 	= 	{"status": get_option("estado_usuario") , "id_departamento" : get_option("depto") , "page" : get_option("page") };					
	request_enid( "GET",  data_send, url, response_carga_usuario);
}
let response_carga_usuario = (data) => {
	let place 		= 	get_place_usuarios();	
	render_enid(place , data);		
	$(".pagination > li > a, .pagination > li > span").click(function(e){				
			set_option("page", $(this).text());
			carga_usuarios();
			e.preventDefault();				
	});
	$(".pagination > li > a, .pagination > li > span").css("color" , "white");
	recorre(".tab-content");	
	$(".usuario_enid_service").click(carga_data_usuario);
}
let pre_nuevo_usuario = () => {

	get_puestos_por_cargo();
	$(".email").removeAttr("readonly");	
	set_option("flag_editar",0);	
	document.getElementById("form-miembro-enid-service").reset();	
	$(".place_correo_incorrecto").empty();

}
let carga_data_usuario = (e) => {

	document.getElementById("form-miembro-enid-service").reset();	
	$(".place_correo_incorrecto").empty();
	recorre(".tab-content");
	set_option("id_usuario", get_parameter_enid($(this) , "id"));
	set_option("flag_editar",1);

	let url 		=  	"../q/index.php/api/usuario/miembro/format/json/";	
	let data_send 	= 	{"id_usuario" : get_option("id_usuario")};					
	request_enid( "GET",  data_send, url, response_carga_data_usuario);
}
let response_carga_data_usuario =  (data) => {

	$(".place_config_usuario").empty();
	let info_usuario =  data[0];

	let nombre 				= 	info_usuario.nombre;
	let apellido_paterno 	= 	info_usuario.apellido_paterno;
	let apellido_materno 	= 	info_usuario.apellido_materno;
	let email 				=  	info_usuario.email;
	let id_departamento 	= 	info_usuario.id_departamento;
	let inicio_labor 		=  	info_usuario.inicio_labor;
	let fin_labor 			=  	info_usuario.fin_labor;
	let turno 				=  	info_usuario.turno;
	let sexo 				=  	info_usuario.sexo;
	status 				=  	info_usuario.status;

	set_option("perfil", info_usuario.idperfil);

	valorHTML(".form-miembro-enid-service .nombre" , nombre);
	valorHTML(".form-miembro-enid-service .apellido_paterno" , apellido_paterno);
	valorHTML(".form-miembro-enid-service .apellido_materno" , apellido_materno);
	valorHTML(".form-miembro-enid-service .email" , email);
	selecciona_select(".form-miembro-enid-service .depto" , id_departamento);

	selecciona_select(".form-miembro-enid-service .estado_usuario" , status);
	selecciona_select(".estado_usuario" , status);		
	selecciona_select(".form-miembro-enid-service .inicio_labor" , inicio_labor);
	selecciona_select(".form-miembro-enid-service .fin_labor" , fin_labor);
	selecciona_select(".form-miembro-enid-service .turno" , turno);
	selecciona_select(".form-miembro-enid-service .sexo" , sexo);

	get_puestos_por_cargo();
}
let get_puestos_por_cargo = () => {

	let url 		=  	"../q/index.php/api/perfiles/puesto_cargo/format/json/";		
	let depto 		=  	$(".form-miembro-enid-service .depto" ).val();	
	let data_send 	= 	{id_departamento : depto};					
	request_enid( "GET", data_send, url, response_puesto_por_cargo);
}
let response_puesto_por_cargo = (data) => {

	render_enid(".place_puestos", data);
	selecciona_select(".form-miembro-enid-service .puesto" , get_option("perfil"));		
}
let actualizacion_usuario = (e) => {

	let data_send 	=  $(".form-miembro-enid-service").serialize()+"&"+$.param({"id_usuario" : get_option("id_usuario"), "editar" : get_option("flag_editar") });	
	let url 		=  "../q/index.php/api/usuario/miembro/format/json/";			
	request_enid("POST", data_send, url, function(data){
		response_actualizacion_usuario(data, data_send);		
	});	
	e.preventDefault();
}
let response_actualizacion_usuario = (data , data_send) => {

	render_enid(".place_correo_incorrecto" , "");		
	if (data_send.usuario_existente != "0") {
		render_enid(".place_correo_incorrecto" , "<span class='alerta_enid'>" + data.usuario_existente+ "</span>");
	}if (data.registro_usuario == true ){			
		render_enid(".place_status_registro", data);			
		$("#tab_productividad").tab("show");		
		$("#tab_equipo_enid_service").tab("show");	
			
	}if (data.modificacion_usuario ==  true) {
		render_enid(".place_status_registro", data);			
		$("#tab_productividad").tab("show");		
		$("#tab_equipo_enid_service").tab("show");	
	}	
}
let  carga_mapa_menu = () => {

	let url 		=  	"../q/index.php/api/recurso/mapa_perfiles_permisos/format/json/";	
	set_option("id_perfil" , $(".perfil_enid_service").val());  
	let data_send 	= 	{"id_perfil" : get_option("id_perfil") };						
	request_enid( "GET",  data_send, url, response_carga_mapa);
	
}
let response_carga_mapa = (data) => {
	render_enid(".place_perfilles_permisos" , data);		
	recorre(".tab-content");
	$(".perfil_recurso").click(modifica_accesos_usuario);
}
let modifica_accesos_usuario = function(e) {
	
	set_option("id_recurso", get_parameter_enid($(this) , "id"));	
	let url 		=  	"../q/index.php/api/perfil_recurso/permiso/format/json/";	
	let data_send 	= 	{"id_perfil" : get_option("id_perfil"),  "id_recurso" : get_option("id_recurso")};					
	request_enid( "PUT",  data_send, url , carga_mapa_menu );	
}
let  registra_recurso = (e) => {
	let data_send 	=  $(".form_recurso").serialize();	
	let url 		=  "../q/index.php/api/recurso/index/format/json/";	
	request_enid( "POST",  data_send, url, response_registro_recurso);
	e.preventDefault();
}
let  response_registro_recurso = (data) => {

	$(".place_recurso").empty();
	document.getElementById("form_recurso").reset();					
	$("#tab_productividad").tab("show");		
	$("#tab_perfiles").tab("show");	
	carga_mapa_menu();			
}