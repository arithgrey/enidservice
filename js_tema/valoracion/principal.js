"use strict";
$(document).ready(function(){

	set_option("recomendaria", 3);
	set_option("calificacion", 5);
	$(".recomendaria").click(configura_recomendaria);
	$(".estrella").click(configura_calificacion);
	$(".form_valoracion").submit(registra_valoracion);
	$("footer").ready(evalua_propietario);
	
});
let configura_recomendaria = function(e){

	let recomendaria =  get_parameter_enid($(this) , "id");
	set_option("recomendaria" , parseInt(recomendaria));

	$(".recomendaria").css("color" , "black");

	$(this).css("color" , "blue");
	$(".place_recomendaria").empty();
}
let configura_calificacion = function(e){
	let calificacion =  get_parameter_enid($(this) , "id");
	set_option("calificacion" , parseInt(calificacion));		
	
	/*DEJAMOS EN BLANCO TODAS PARA INICIAR*/
	for(let i = 1; i <= 5; i++) {
		
		let estrella_ = ".estrella_"+i;
	    //-webkit-text-stroke-color: #004afc;
		$(estrella_).css("-webkit-text-fill-color" ,"white");
		$(estrella_).css("-webkit-text-stroke-color" ,"#004afc");
		$(estrella_).css("-webkit-text-stroke-width" ,".5px");		
	}
	/*AHORA PINTAMOS HASTA DONDE SE SEÑALA*/
	for(let i = 1; i <= get_option("calificacion"); i++) {
		
		let estrella_ = ".estrella_"+i;
	    //-webkit-text-stroke-color: #004afc;
		$(estrella_).css("-webkit-text-fill-color" ,"#004afc");
		$(estrella_).css("-webkit-text-stroke-color" ,"#004afc");

	}	
}
let registra_valoracion = function(e){

	let recomendaria =  get_option("recomendaria");
	if (recomendaria == 3){
		/*Agregamos comentario para que seleccione opción*/
		llenaelementoHTML(".place_recomendaria" , "<span class='nota_recomendarias'>¿Recomendarías este artículo?</span>");				 				
	}else{

		$(".place_recomendaria").empty();
			
			let url ="../q/index.php/api/valoracion/index/format/json/";
			let data_send =  $(".form_valoracion").serialize()+"&"+$.param({"calificacion" : get_option("calificacion"), "recomendaria" : get_option("recomendaria") });	
			
			request_enid( "POST",  data_send, url, response_registro_valoracion,  0, before_registro_valoracion);
			
						
	}
		
	e.preventDefault();
}
let before_registro_valoracion = function(){
	show_load_enid(".place_registro_valoracion" ,  "Validando datos " , 1 );					
	bloquea_form(".form_valoracion");
}
let response_registro_valoracion = function(data){

	let url_producto = "../producto/?producto="+data.id_servicio+"&valoracion=1";
	let mira_tu_valoracion = "mira tu valoración <a class='blue_enid_background white'  href='"+url_producto+"' style='padding:5px;color:white!important;' > aquí </a>";
	let extra_invitacion_a_enid ="";
	if (data.existencia_usuario == 0){ 

		let url_registro ="../login/";
		extra_invitacion_a_enid = "<div><a href='"+url_registro+"' class='registro_cuenta'>Aún no tienes una cuenta, te invitamos a comprar y vender tus artículos y servicios, registra tu cuenta ahora!</a></div>";

	}	

	llenaelementoHTML(".place_registro_valoracion" , "Tu valoración quedó registrada!," + mira_tu_valoracion+extra_invitacion_a_enid);				
	if (data.existencia_usuario == 0){ 
		$(".registro_cuenta").css("font-size", "1.5em");					
		$(".registro_cuenta").css("color", "#0c4075");
		$(".registro_cuenta").css("font-weight", "bold");
		$(".registro_cuenta").css("text-decoration-line", "underline");
						
	}
	recorrepage(".place_registro_valoracion");
}
let evalua_propietario = function(){
	
	if (get_parameter(".propietario") == 1){		
		bloquea_form(".form_valoracion");
	}
}