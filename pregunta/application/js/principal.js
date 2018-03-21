$(document).ready(function(){
	/*Valores por default*/
	set_option("recomendaria", 3);
	set_option("calificacion", 5);
	$(".form_valoracion").submit(registra_valoracion);
	envio_pregunta =  $(".envio_pregunta").val();
	if (envio_pregunta !=1){
		bloquea_form(".form_valoracion");
		$(".contenedor_registro").show();
	}	
});
/**/
function registra_valoracion(e){

	flag =  valida_text_form("#pregunta" , ".place_area_pregunta" , 5 , "Pregunta" );
	if (flag == 1) {
		url ="../portafolio/index.php/api/valoracion/pregunta/format/json/";
		data_send =  $(".form_valoracion").serialize();	
				
			$.ajax({
					url : url , 
					type : "POST" , 
					data: data_send, 
					beforeSend : function(){						
						show_load_enid(".place_registro_valoracion" ,  "Validando datos " , 1 );						
						bloquea_form(".form_valoracion");
					}
			}).done(function(data){														
				if (data ==  1 ){
					$(".registro_pregunta").show();		
					$(".place_registro_valoracion").empty();


				}
				/**/
			}).fail(function(){							
				show_error_enid(".place_registro_valoracion" , "Error al iniciar sessión");				
			});		
	}
	e.preventDefault();
}
/**/
