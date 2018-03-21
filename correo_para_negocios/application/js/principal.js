var num_cuentas ="";
var texto_recomendacion = "";
var valor_temporal_plan = 0;
var valor_total =0;
$(document).ready(function(){
	/**/
	$(".btn_beneficios_basicos").click(function(){
		recorrepage("#desc_pagina_web_basica");
	});
	$(".b_sitios_basicos").click(function(){
		recorrepage("#desc_pagina_web_basica");
	});
	
	$(".b_sitios_avanzados").click(function(){		
		recorrepage("#desc_gestor_de_contenidos");
	});
	/**/
	$(".btn_beneficios_avanzados").click(function(){		
		recorrepage("#desc_gestor_de_contenidos");
	});

	carga_plan();
	
	$(".plan").change(carga_plan);
	$(".num_ciclos").change(calcula_valor_temporal);
});
/**/

/**/
function carga_plan(){
	
	num_cuentas =  $(".plan").val();
	
		url =  "../base/index.php/api/servicio/precio/format/json/";		
		data_send = {"servicio" : num_cuentas}

		$.ajax({
			url : url , 
			type : "GET" , 
			data: data_send, 
				beforeSend : function(){						
					///show_load_enid(".place_registro_afiliado" ,  "Validando datos " , 1 );
				} 					

			}).done(function(data){			
	
				
				set_texto_recomendacion(data.descripcion);
				set_valor_temporal_plan(data.precio);
		        calcula_valor_temporal();

			}).fail(function(){							
				show_error_enid(".place_registro_afiliado" , "Error al iniciar sessión");				
		});


}
/**/
function set_valor_temporal_plan(n_valor_temporal_plan){
	valor_temporal_plan =  n_valor_temporal_plan;
}
/**/
function  get_valor_temporal_plan(argument) {
	return valor_temporal_plan;
}
/**/
function calcula_valor_temporal(){
	
	num_ciclos = $(".num_ciclos").val();
	total_temporal =  num_ciclos * get_valor_temporal_plan();
	
	set_valor_total(total_temporal);
}
/**/
function  set_texto_recomendacion(n_texto){
	texto_recomendacion = n_texto;	
	llenaelementoHTML(".text_recomendacion" , texto_recomendacion);
}
/**/
function  get_text_recomendacion(){
	return texto_recomendacion;
}
/**/
function set_valor_total(n_valor_total){
	
	valor_total =  n_valor_total;	
	valor_extra_punto = cortar_cadena_punto(valor_total);
	valorHTML(".total" , valor_extra_punto);
}
/**/
function  get_valor_total(){
	return valor_total;
}
/**/
function cortar_cadena_punto(v){

	var valor_total =  v;
	valor_text =  valor_total.toString();

	nuevo_valor ="";
	z =0; 
	y =0;
	for (var i = 0; i < valor_text.length; i++) {
		
			
		if(valor_text[i] == "."){
			z ++; 
		}if(z > 0 ){
			y ++;
		}if(z < 1 ){
			nuevo_valor += valor_text[i]; 			
		}if (z > 0 && y < 4){
			nuevo_valor += valor_text[i]; 			
		}

		
	}
	return nuevo_valor;
	
}
/**/