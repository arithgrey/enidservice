var id_usuario = 0;
var status_usuario  = 1; 
var id_usuario = 0;
var flag_editar = 0;
var perfil = 0;
var id_recurso = 0; 
var perfil = 0; 

$(document).ready(function(){	

	/*********************************/
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
	/*on Click carga miembros afiliados*/
	$(".tab_afiliados").click(function(){
		set_option("depto" , 8);
		set_option("estado_usuario" , 1);
		carga_usuarios();
	});	
	/**/
	$(".tab_equipo_enid_service").click(function(){				
		set_option("page" , 1);	
		set_option("depto" , 0);
		set_option("estado_usuario" , 1);
		carga_usuarios();
	});	
	/**/
	$(".equipo_enid_service").click(function(e){				


		set_option("page" , 1);	
		set_option("depto" , 0);
		set_option("estado_usuario" , e.target.id);
		carga_usuarios();
	});

});
/**/
function get_place_usuarios(){

	/**/
	nuevo_place ="";
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
/**/
function carga_usuarios(){

	/**/	
	place = get_place_usuarios();	
	url =  "../persona/index.php/api/equipo/miembros_activos/format/json/";	
	data_send = {"status":get_option("estado_usuario") , "id_departamento" : get_option("depto") , "page" : get_option("page") };					
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				//show_load_enid(place , "Cargando ... ", 1 );
			}
	}).done(function(data){		

		llenaelementoHTML(place , data);		
		$(".pagination > li > a, .pagination > li > span").click(function(e){				
				set_option("page", $(this).text());
				carga_usuarios();
				e.preventDefault();				
		});
		$(".pagination > li > a, .pagination > li > span").css("color" , "white");
		recorre_web_version_movil();
		$(".usuario_enid_service").click(carga_data_usuario);
		/**/
	}).fail(function(){			
		show_error_enid(place , "Error ... ");
	});	
}
/**/
function pre_nuevo_usuario(){
	
	get_puestos_por_cargo();
	$(".email").removeAttr("readonly");	
	set_flag_editar(0);
	/**/
	document.getElementById("form-miembro-enid-service").reset();	
	$(".place_correo_incorrecto").empty();

}
/**/
/**/
/*
function carga_usuarios(){

	url =  "../persona/index.php/api/equipo/miembros_activos/format/json/";	
	data_send = {"status":get_option("estado_usuario"),  "id_departamento" : 0 };								
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".usuarios_enid_service" , "Cargando ... ", 1 );
			}
	}).done(function(data){				
		
		llenaelementoHTML(".usuarios_enid_service" , data);		
		recorre_web_version_movil();
		$(".usuario_enid_service").click(carga_data_usuario);
		
	}).fail(function(){			
		show_error_enid(".usuarios_enid_service" , "Error ... ");
	});	
}
*/
/**/
function carga_data_usuario(e){

	document.getElementById("form-miembro-enid-service").reset();	
	$(".place_correo_incorrecto").empty();
	recorre_web_version_movil();
	set_id_usuario(e.target.id);
	set_flag_editar(1);

	url =  "../persona/index.php/api/equipo/miembro_form/format/json/";	
	data_send = {"id_usuario" : get_id_usuario()};					
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_config_usuario" , "Cargando ... ", 1 );
			}
	}).done(function(data){	


		$(".place_config_usuario").empty();
		info_usuario =  data[0];

		nombre = info_usuario.nombre; 		
		apellido_paterno = info_usuario.apellido_paterno 
		apellido_materno = info_usuario.apellido_materno 
		email =  info_usuario.email;
		id_departamento = info_usuario.id_departamento;		
		inicio_labor =  info_usuario.inicio_labor;
		fin_labor =  info_usuario.fin_labor;
		turno =  info_usuario.turno;
		sexo =  info_usuario.sexo;
		status =  info_usuario.status;

		set_perfil(info_usuario.idperfil);

		valorHTML(".form-miembro-enid-service .nombre" , nombre);
		valorHTML(".form-miembro-enid-service .apellido_paterno" , apellido_paterno);
		valorHTML(".form-miembro-enid-service .apellido_materno" , apellido_materno);
		valorHTML(".form-miembro-enid-service .email" , email);
		selecciona_select(".form-miembro-enid-service .depto" , id_departamento);

		
		
		/**/
		//selecciona_select(".form-miembro-enid-service .depto" , id_departamento);
		
		/**/
		
		selecciona_select(".form-miembro-enid-service .estado_usuario" , status);
		selecciona_select(".estado_usuario" , status);		
		selecciona_select(".form-miembro-enid-service .inicio_labor" , inicio_labor);
		selecciona_select(".form-miembro-enid-service .fin_labor" , fin_labor);
		selecciona_select(".form-miembro-enid-service .turno" , turno);
		selecciona_select(".form-miembro-enid-service .sexo" , sexo);

		/**/
		get_puestos_por_cargo();

		
		
		

	}).fail(function(){			
		//show_error_enid(".place_config_usuario" , "Error ... ");
	});	
}
/**/
function get_puestos_por_cargo(){


	url =  "../persona/index.php/api/equipo/puesto_cargo/format/json/";	
	depto =  $(".form-miembro-enid-service .depto" ).val();

	data_send = {id_departamento : depto};					
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_form_config_usuario" , "Cargando ... ", 1 );
			}
	}).done(function(data){	


		llenaelementoHTML(".place_puestos", data);

		/**/
		
		selecciona_select(".form-miembro-enid-service .puesto" , get_perfil());		

	}).fail(function(){			
		show_error_enid(".place_form_config_usuario" , "Error ... ");
	});		
}
/**/
function actualizacion_usuario(e){

	data_send =  $(".form-miembro-enid-service").serialize()+"&"+$.param({"id_usuario" : get_id_usuario(), "editar" : get_flag_editar() });	
	url =  "../persona/index.php/api/equipo/miembro/format/json/";			
	

	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_status_registro" , "Cargando ... ", 1 );
			}
	}).done(function(data){	

		
		llenaelementoHTML(".place_correo_incorrecto" , "");
		/**/
		if (data_send.usuario_existente != "0") {

			llenaelementoHTML(".place_correo_incorrecto" , "<span class='alerta_enid'>" + data.usuario_existente+ "</span>");

		}if (data.registro_usuario == true ){
			llenaelementoHTML(".place_status_registro", data);
			//carga_usuarios();
			/***/		
			$("#tab_productividad").tab("show");		
			$("#tab_equipo_enid_service").tab("show");	
		}if (data.modificacion_usuario ==  true) {

			llenaelementoHTML(".place_status_registro", data);
			//carga_usuarios();
			/***/		
			$("#tab_productividad").tab("show");		
			$("#tab_equipo_enid_service").tab("show");	
		}
		/**/		

	}).fail(function(){			
		show_error_enid(".place_status_registro" , "Error ... ");
	});

	e.preventDefault();
}
/**/
function recorre_web_version_movil(){
	//recorrepage(".tab-content");
}
/**/
function set_id_usuario(n_id_usuario){
	id_usuario = n_id_usuario; 
}
/**/
function get_id_usuario(){
	return id_usuario;
}
/**/
function get_flag_editar(){
	return flag_editar;
}
/**/
function set_flag_editar(n_flag_editar){
	flag_editar = n_flag_editar;
}
/**/
function get_perfil(){
	return perfil;
}
/**/
function  set_perfil(n_perfil){
	perfil =  n_perfil; 
}
/**/
function carga_mapa_menu(){

	set_id_perfil($(".perfil_enid_service").val());  
	url =  "../persona/index.php/api/equipo/mapa_perfiles_permisos/format/json/";	
	data_send = {"id_perfil" : get_id_perfil() };					
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_perfilles_permisos" , "Cargando ... ", 1 );
			}
	}).done(function(data){				
		
		llenaelementoHTML(".place_perfilles_permisos" , data);		
		recorre_web_version_movil();
		/**/
		$(".perfil_recurso").click(modifica_accesos_usuario);

	}).fail(function(){			
		show_error_enid(".place_perfilles_permisos" , "Error ... ");
	});	
}
/**/
function modifica_accesos_usuario(e){

	set_id_recurso(e.target.id);
	
	url =  "../persona/index.php/api/equipo/modifica_permisos/format/json/";	
	data_send = {"id_perfil" : get_id_perfil(),  "id_recurso" : get_id_recurso()};					
	$.ajax({
			url : url , 
			type: "PUT",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_perfilles_permiso_status" , "Cargando ... ", 1 );
			}
	}).done(function(data){				
		carga_mapa_menu();		
	}).fail(function(){			
		show_error_enid(".place_perfilles_permiso_status" , "Error ... ");
	});
}
/**/
function set_id_recurso(n_id_recurso){
	id_recurso =  n_id_recurso;
}
/**/
function get_id_recurso(){
	return id_recurso;
}
/**/
function set_id_perfil(n_id_perfil){
	id_perfil =  n_id_perfil;
}
/**/
function get_id_perfil(){
	return id_perfil;
}
/**/
function registra_recurso(e){

	data_send =  $(".form_recurso").serialize();	
	url =  "../persona/index.php/api/equipo/recurso/format/json/";	
	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_recurso" , "Cargando ... ", 1 );
			}
	}).done(function(data){				
		
	
		$(".place_recurso").empty();
		document.getElementById("form_recurso").reset();			
		/**/
		$("#tab_productividad").tab("show");		
		$("#tab_perfiles").tab("show");	
		carga_mapa_menu();		
		/**/

	}).fail(function(){			
		show_error_enid(".place_recurso" , "Error ... ");
	});

	e.preventDefault();
}
/*
//function carga_informe_afiliados_enid_service(){

	data_send =  $(".form_recurso").serialize();	
	url =  "../q/index.php/api/afiliacion/afiliados/format/json/";	
	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".usuarios_enid_service_afiliados" , "Cargando ... ", 1 );
			}
	}).done(function(data){						
		llenaelementoHTML(".usuarios_enid_service_afiliados" , data);
		
	}).fail(function(){			
		show_error_enid(".usuarios_enid_service_afiliados" , "Error ... ");
	});
}
*/