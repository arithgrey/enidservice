$(document).ready(function(){
	/*Valores por default*/
	set_option("recomendaria", 3);
	set_option("calificacion", 5);
	$(".recomendaria").click(configura_recomendaria);
	$(".estrella").click(configura_calificacion);	
	/*Se registra valoración*/
	$(".form_valoracion").submit(registra_valoracion);
	
});
/**/
function configura_recomendaria(e){	
	/**/
	recomendaria =  e.target.id;
	set_option("recomendaria" , parseInt(recomendaria));
	/*hacemos efecto selección*/
	$(".recomendaria").css("color" , "black");
	/*Pintamos el que se a seleccionado*/
	$(this).css("color" , "blue");
	$(".place_recomendaria").empty();
}
/**/
function configura_calificacion(e){
	calificacion =  e.target.id;
	set_option("calificacion" , parseInt(calificacion));		
	
	/*DEJAMOS EN BLANCO TODAS PARA INICIAR*/
	for(var i = 1; i <= 5; i++) {
		
		estrella_ = ".estrella_"+i;		
	    //-webkit-text-stroke-color: #004afc;
		$(estrella_).css("-webkit-text-fill-color" ,"white");
		$(estrella_).css("-webkit-text-stroke-color" ,"#004afc");
		$(estrella_).css("-webkit-text-stroke-width" ,".5px");		
	}
	/*AHORA PINTAMOS HASTA DONDE SE SEÑALA*/
	for(var i = 1; i <= get_option("calificacion"); i++) {
		
		estrella_ = ".estrella_"+i;		
	    //-webkit-text-stroke-color: #004afc;
		$(estrella_).css("-webkit-text-fill-color" ,"#004afc");
		$(estrella_).css("-webkit-text-stroke-color" ,"#004afc");
		//$(estrella_).css("-webkit-text-stroke-width" ,".5px");		
	}	
}
/**/
function registra_valoracion(e){

	recomendaria =  get_option("recomendaria");
	if (recomendaria == 3){
		/*Agregamos comentario para que seleccione opción*/
		llenaelementoHTML(".place_recomendaria" , "<span class='nota_recomendarias'>¿Recomendarías este artículo?</span>");				 				
	}else{
		/**/
		$(".place_recomendaria").empty();
			
			url ="../portafolio/index.php/api/valoracion/nueva/format/json/";
			data_send =  $(".form_valoracion").serialize()+"&"+$.param({"calificacion" : get_option("calificacion"), "recomendaria" : get_option("recomendaria") });	
			
			$.ajax({
				url : url , 
				type : "POST" , 
				data: data_send, 
				beforeSend : function(){						
					show_load_enid(".place_registro_valoracion" ,  "Validando datos " , 1 );
					
					bloquea_form(".form_valoracion");
				}
			}).done(function(data){														

				console.log(data);
				
				url_producto = "../producto/?producto="+data.id_servicio+"&valoracion=1";
				mira_tu_valoracion = "mira tu valoración <a class='blue_enid_background white'  href='"+url_producto+"' style='padding:5px;color:white!important;' > aquí </a>";
				extra_invitacion_a_enid ="";
				if (data.existencia_usuario == 0){ 

					url_registro ="../login/";
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
				/**/
			}).fail(function(){							
				show_error_enid(".place_registro_valoracion" , "Error al iniciar sessión");				
			});
						
	}
		
	e.preventDefault();
}