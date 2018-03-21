var existe_codigo_postal = 0;
var delegacion = 0;
var colonia =0;
var asentamiento = 0;
var id_municipio =0;
function auto_completa_direccion(){


	quita_espacios(".codigo_postal"); 	
	cp = $(".codigo_postal").val();

	numero_caracteres = cp.length; 
	if(numero_caracteres > 4 ) {

		url =  "../portafolio/index.php/api/portafolio/cp/format/json/";	
		
		data_send =  {"cp" : cp , "delegacion" : get_delegacion() };

		$.ajax({
				url : url , 
				type: "GET",
				data: data_send, 
				beforeSend: function(){
					//show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
				}
		}).done(function(data){										
			/**/
			if(data.resultados >0){
					
					console.log(data);
					llenaelementoHTML(".place_colonias_info" , data.colonias);				
					$(".parte_colonia_delegacion").show();			

					$(".delegacion_c").show();
					llenaelementoHTML(".place_delegaciones_info" , data.delegaciones);	

					$(".estado_c").show();
					llenaelementoHTML(".place_estado_info" , data.estados);

					$(".pais_c").show();
					llenaelementoHTML(".place_pais_info" , data.pais);					
					muestra_error_codigo(0);	
					set_existe_codigo_postal(1);
			}else{

				$(".delegacion").val("");
				$(".place_colonias_info").val("");
				$(".parte_colonia_delegacion").hide();
				set_existe_codigo_postal(0);
				muestra_error_codigo(1);	
			}
			

			
		}).fail(function(){			
			show_error_enid(".place_proyectos" , "Error ... ");
		});
	}


}
/**/
function muestra_error_codigo(flag_error){

	if (flag_error ==  1) {
		$(".codigo_postal").css("border" , "1px solid rgb(13, 62, 86)");			
		mensaje_user =  "Codigo postal invalido, verifique"; 		
		llenaelementoHTML( ".place_codigo_postal" ,  "<span class='alerta_enid'>" + mensaje_user + "</span>");
		recorrepage("#codigo_postal");

	}else{
		llenaelementoHTML( ".place_codigo_postal" ,  "");
	}
}

/**/
function registra_nueva_direccion(e){


	if(get_existe_codigo_postal() ==  1){
				
				url =  "../portafolio/index.php/api/portafolio/direccion_envio_pedido/format/json/";	
				data_send =  $(".form_direccion_envio").serialize();		
				asentamiento = $(".asentamiento").val();
				if (asentamiento != 0 ) {
					$.ajax({
							url : url , 
							type: "POST",
							data: data_send, 
							beforeSend: function(){
								//show_load_enid(".place_proyectos" , "Cargando ... ", 1 );
							}
					}).done(function(data){																	
						
			
						$(".seccion_saldo_pendiente").show();
						$(".form_direccion_envio").hide();			
						recorrepage(".seccion_saldo_pendiente");
						
						
					}).fail(function(){			
						show_error_enid(".place_proyectos" , "Error ... ");
					});		
					$(".place_asentamiento").empty();		
				}else{
					recorrepage("#asentamiento");										
					llenaelementoHTML( ".place_asentamiento" ,  "<span class='alerta_enid'>Seleccione</span>");
					

				}
		

	}else{
		muestra_error_codigo(1);
	}
	e.preventDefault();
}
/**/
function set_existe_codigo_postal(n_existe){
	existe_codigo_postal = n_existe;
}
/**/
function get_existe_codigo_postal(){
	return existe_codigo_postal;
}
/**/
function get_delegacion(){
	return delegacion;
}
/**/
function set_delegacion(n_delegacion){
	delegacion = n_delegacion;
}
/**/
function oculta_delegacion_estado_pais(flag){


	var elementos = [".delegacion_c" , ".estado_c" , ".pais_c" , ".button_c" , ".direccion_principal_c"];
	for(var x in elementos){


		if (flag ==  "1") {
			
			$(elementos[x]).hide();	
		}else{
			$(elementos[x]).show();
		}
		x ++;
	}
}
function carga_informacion_envio_complete(){

	url =  "../portafolio/index.php/api/portafolio/direccion_envio_pedido/format/json/";	
	data_send =  {id_recibo : get_option("recibo")};				
	
	place_info =".place_info";	
	if(get_option("interno") ==  1){
		place_info =".place_servicios_contratados";
	}

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(place_info , "Cargando ... ", 1 );
			}
	}).done(function(data){							
		/**/
		llenaelementoHTML(place_info , data);				
		$(".resumen_pagos_pendientes").click(cargar_info_resumen_pago_pendiente);
		
		$(".editar_envio_btn").click(function(){
			showonehideone(".contenedor_form_envio" ,  ".contenedor_form_envio_text" );
		});

		/**/
		$(".codigo_postal").keyup(auto_completa_direccion);
		
		$(".numero_exterior").keyup(function (){
			quita_espacios(".numero_exterior"); 	
		});
		$(".numero_interior").keyup(function (){
			quita_espacios(".numero_interior"); 
		});
		/**/
		$(".form_direccion_envio").submit(registra_nueva_direccion);
		/**/
		
		
		
	}).fail(function(){			
		show_error_enid(place_info , "Error ... ");
	});		
}
/**/
function informacion_envio_complete(){

	url =  "../portafolio/index.php/api/portafolio/direccion_envio_pedido/format/json/";	
	data_send =  {id_recibo : get_id_proyecto_persona_forma_pago()};				

	$.ajax({
			url : url , 
			type: "GET",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_direccion_envio" , "Cargando ... ", 1 );
			}
	}).done(function(data){							
		/**/
		llenaelementoHTML(".place_direccion_envio" , data);		
		/*		
		$(".resumen_pagos_pendientes").click(cargar_info_resumen_pago_pendiente);
		
		$(".editar_envio_btn").click(function(){
			showonehideone(".contenedor_form_envio" ,  ".contenedor_form_envio_text" );
		});
		
		$(".codigo_postal").keyup(auto_completa_direccion);
		
		$(".numero_exterior").keyup(function (){
			quita_espacios(".numero_exterior"); 	
		});
		$(".numero_interior").keyup(function (){
			quita_espacios(".numero_interior"); 
		});
		
		$(".form_direccion_envio").submit(registra_nueva_direccion);
		*/
		
		recorrepage("#tab_lugar_envio");
	}).fail(function(){			
		show_error_enid(".place_direccion_envio" , "Error ... ");
	});		




}
/**/

function get_colonia(){
	return colonia;
}
/**/
function set_colonia(n_colonia){
	colonia =  n_colonia;
}
/**/
function get_asentamiento(){
	return asentamiento;
}
/**/
function set_asentamiento(n_asentamiento){
	asentamiento = n_asentamiento;
}
/**/
function get_municipio(){
	return id_municipio;
}
/**/
function set_municipio(n_id_municipio){
	id_municipio =  n_id_municipio;
}