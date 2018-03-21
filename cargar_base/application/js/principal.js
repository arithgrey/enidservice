var red_social = 0;
var servicio =  0; 
var contador_mensaje =0;
var  tipo_negocio = 0;
var id_usuario = 0;
$(document).ready(function(){

	$("footer").ready(carga_info_registros);
	$("footer").ready(carga_comando_busqueda);	
	$(".btn_comandos_ayuda").click(cargar_comandos_ayuda);
	$(".form_comando").submit(registrar_comando);
	$(".form_up_correo").submit(registrar_actualizacion_correo);	
	$(".form_liberar_tipo_negocio").submit(liberar_tipo_negocio);
	$(".btn_refres_comando").click(carga_comando_busqueda);
	set_id_usuario($(".id_usuario").val());  

});
/**/
function carga_comando_busqueda(){
		

	url =  "../base/index.php/api/prospectos/comando_busqueda/format/json/";
	$.ajax({
			url : url , 
			type: "GET",
			data: {}, 
			beforeSend: function(){
				show_load_enid(".place_form_busqueda" , "Cargando ... ", 1 );
			}
	}).done(function(data){										
			

		llenaelementoHTML(".place_form_busqueda" , data);											
		$(".form_registro_contacto").submit(registra_contacto);	
		
	}).fail(function(){
			show_error_enid(".place_form_busqueda" , "Error ... al cargar portafolio.");
	});

}

function sustituir_caracteres(texto){	
	
  encontrar =["'" , ",","|",":","[", "]", '"', "*","!" , " ", "\n", "\r" , "á" , "é", "í", "ó", "ú" , "?" , "¿" , "/", ")" , "(" , "`" , "", "-" , ";", "%", "…" , "……" , "ã" , "(*)" , "<" , ">" , ".."];	 

  var cadena = '';
  var i      = 0;
  while(i<texto.length){

  	flag_caracter =0;
  	for(var b = 0; b < encontrar.length; b++){
  		
  		if(texto[i] == encontrar[b]){
  			flag_caracter ++;
  		}			
  	}	

     if(flag_caracter == 0){
      // si es diferente simplemente concatena el carácter original de la cadena original.
       cadena = cadena + texto[i];
     }else{
      // si no es diferente concatena el carácter que introdujiste a remplazar
       cadena = cadena + " ";
     }  
     i++;
  } // Fin del while
   return cadena;
}
/**/
function registra_contacto(e){
		
	url =  "../base/index.php/api/base/prospecto/format/json/";	
	var cadena =  $(".area_contenido").val();	
	nueva_cadena =  sustituir_caracteres(cadena);		
	data_send =  $(".form_registro_contacto").serialize()+"&"+$.param({"text_info":  nueva_cadena,  "id_usuario" : get_id_usuario()});
	
	$('.area_contenido').attr('disabled',true);
	$('.registrar_btn').attr('disabled',true);
	 
	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_test_contactos" , "Cargando ... ", 1 );								
			}
	}).done(function(data){										
			
		
			llenaelementoHTML(".place_test_contactos" , data );			
			llenaelementoHTML(".place_registro" , data );			
			document.getElementById("form_registro_contacto").reset();
			carga_info_registros();	
			carga_comando_busqueda();						
			$('.area_contenido').attr('disabled',false);
			$('.registrar_btn').attr('disabled',false);
	
		}).fail(function(){
			show_error_enid(".place_registro" , "Error ... al cargar portafolio.");
		});
	
	e.preventDefault();
}
/**/
function carga_info_registros(){

	url =  "../base/index.php/api/base/prospecto/format/json/";
	$.ajax({
			url : url , 
			type: "GET",
			data: {}, 
			beforeSend: function(){
				show_load_enid(".place_reporte_mail" , "Cargando ... ", 1 );
			}
	}).done(function(data){										

		llenaelementoHTML(".place_reporte_mail" , data);											
			
	}).fail(function(){
		show_error_enid(".place_reporte_mail" , "Error ... al cargar portafolio.");
	});
}
/**/

/**/
function cargar_comandos_ayuda(){

	url =  "../base/index.php/api/mensaje/comandos/format/json/";		
	$.ajax({
			url : url , 
			type: "GET",
			data: {}, 
			beforeSend: function(){
				show_load_enid(".place_comandos" , "Cargando ... ");
		}
	}).done(function(data){							

		llenaelementoHTML(".place_comandos", data);
	}).fail(function(){
		show_error_enid(".place_comandos" , "Error ... al cargar portafolio.");
	});	
}
/**/
function registrar_comando(e){

	url =  "../base/index.php/api/mensaje/comandos/format/json/";	
	data_send =  $(".form_comando").serialize();		
	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(".place_registro_comandos" , "Cargando ... ");
		}
	}).done(function(data){							

		/**/
			llenaelementoHTML(".place_registro_comandos", data);		
			document.getElementById("form_comando").reset(); 
			$("#registra_info_comando").modal("hide");
			cargar_comandos_ayuda();
		/**/

	}).fail(function(){
		show_error_enid(".place_registro_comandos" , "Error ... al cargar portafolio.");
	});	
	
	e.preventDefault();
}
/**/
function registrar_actualizacion_correo(e){
	
	url =  "../base/index.php/api/base/prospecto/format/json/";	
	data_send =  $("#form_up_correo").serialize();

	$.ajax({
			url : url , 
			type: "PUT",
			data: $("#form_up_correo").serialize(), 
			beforeSend: function(){
				show_load_enid(".place_registro" , "Cargando ... ", 1 );
			}
	}).done(function(data){										
			
			show_response_ok_enid(".place_registro" , "Correo actualizado");
			
		}).fail(function(){
			show_error_enid(".place_registro" , "Error ... al cargar portafolio.");
	});
	e.preventDefault();

}
/**/
function liberar_tipo_negocio(e){

	url =  "../msj/index.php/api/email/tipo_negocio/format/json/";	
	data_send =  $(".form_liberar_tipo_negocio").serialize();
	

	$.ajax({
			url : url , 
			type: "PUT",
			data: $(".form_liberar_tipo_negocio").serialize(), 
			beforeSend: function(){
				show_load_enid(".place_libera_tipo_negocio" , "Cargando ... ", 1 );
			}
	}).done(function(data){																
			show_response_ok_enid(".place_libera_tipo_negocio" , "Tipo de negocio liberado!");
			redirect("");			
		}).fail(function(){
			show_error_enid(".place_libera_tipo_negocio" , "Error ... al cargar portafolio.");
	});
	e.preventDefault();	
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