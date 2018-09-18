function agregas_comentio_a_usuario(){
	
	var url 		=  "../msj/index.php/api/comentario/comentario_persona_usuario/format/json/";		
	var data_send 	=  $(".form_comentarios").serialize()+"&"+ $.param({"id_persona" : get_option("persona")});
	request_enid( "POST",  data_send , url , response_agregar_comentario_a_usuario , ".place_nuevo_comentario");	
}
/**/
function response_agregar_comentario_a_usuario(data){

	document.getElementById("form_comentarios").reset(); 
	show_response_ok_enid(".place_nuevo_comentario" , "Comentario registrado!");						
	$(".tab_ejemplos_disponibles").tab("show");
	$(".base_tab_clientes").tab("show");			
	carga_info_persona();
}
/**/
function carga_info_persona(){
	/**/
	oculta_formularios_busqueda();
	var url 		=  "../persona/index.php/api/clientes/persona/format/json/";	
	var data_send 	=  {"id_persona" : get_option("persona")};				
	request_enid( "GET",  data_send , url , response_carga_info_persona , ".place_info_posibles_clientes");
	
}
/**/
function response_carga_info_persona(data){
	
	recorre_web_version_movil();		
	llenaelementoHTML(".place_info_posibles_clientes" , data);
	llenaelementoHTML(".place_info_clientes" , data);	
	$(".btn_agendar_correo").hide();	
	$(".btn_agregar_comentario").click(function(){
		recorre_web_version_movil();
	});

	$(".btn_agendar_llamada").click(function(){
		recorre_web_version_movil();
	});
	$(".btn_convertir_persona").click(recorre_web_version_movil);
	$(".regresar_btn_posible_cliente").click(regresar_list_posible_cliente);
		
}
/**/
function oculta_formularios_busqueda(){
	$(".form_busqueda_clientes").hide();
	$(".form_busqueda_posibles_clientes").hide();
}
/**/
function muestra_formularios_busqueda(){
	$(".form_busqueda_clientes").show();
	$(".form_busqueda_posibles_clientes").show();
}
/**/
function recorre_web_version_movil(){
	recorrepage(".tab-content");
}
/**/
function convertir_cliente(e){
	
	if(get_flag_estoy_en_agendado() == 1){
		marca_llama_hecha_comentario();		
	}	

	var url 				=  "../persona/index.php/api/clientes/convertir/format/json/";	
	var data_send 			= $(".form_convertir_cliente").serialize()+"&"+$.param({"id_persona" : id_persona});									
	var valor_tipo_actual 	=  $('input:radio[name=tipo]:checked').val();
	request_enid( "PUT",  data_send , url , response_convertir_cliente , ".place_convertir_cliente");
	e.preventDefault();	
}
/**/
function response_convertir_cliente(data){
	if (valor_tipo_actual == 4 ) {
			
			llenaelementoHTML(".place_convertir_cliente" , "");
			/**/				
		}else{

			show_response_ok_enid(".place_convertir_cliente" , "Información actualizada!");										
			$(".base_tab_clientes").tab("show");
			$(".base_tab_posiblies_clientes").tab('show'); 					
			$(".form_busqueda_posibles_clientes").submit();
			recorre_web_version_movil();
		}
		/**/
		cargar_num_envios_a_validacion();

}
/**/
function verifica_tipo_negocio(e){

	var url 		=  "../q/index.php/api/ventas/negocio_q/format/json/";		
	var data_send 	= {"q" :  $(".tipo_negocio_b").val()};		
	request_enid( "GET",  data_send , url , response_verifica_tipo_negocio );
	e.preventDefault();
}
/**/
function response_verifica_tipo_negocio(){
	tipo_negocio =  data[0].idtipo_negocio;		
	set_option("tipo_negocio", tipo_negocio);					
	registrar_posiblie_cliente();
}
/**/
function carga_data_contactos_efectivos(e){
	/**/		
	var fecha_registro 	=  e.target.id;			
	var url 			=  "../persona/index.php/api/posiblesclientes/tipificacion/format/json/";		
	var data_send 		= {"fecha_registro" : fecha_registro ,  "tipificacion" :  get_tipificacion() , "id_usuario": get_id_usuario()}	
	request_enid( "GET",  data_send , url , response_carga_data_contactos_efectivos , ".place_info_posibles_clientes");
	e.preventDefault();	
}
/**/
function response_carga_data_contactos_efectivos(data){
	/**/																		
	llenaelementoHTML(".place_info_posibles_clientes" , data);
	$(".info_persona").click(function(e){
		id_persona =  e.target.id;
		set_option("id_persona",id_persona);
		carga_info_persona();	
	});			
	$(".btn_agendar_llamada").click(asigna_valor_persona_agendado);	
}
/**/
function set_id_tipo_registro(n_id_tipo_registro){
	var id_tipo_registro =  n_id_tipo_registro;
	if (n_id_tipo_registro ==  1 ) {
		$(".correo").attr("required", false);
	}else{
		$(".correo").attr("required", true);
	}
}
