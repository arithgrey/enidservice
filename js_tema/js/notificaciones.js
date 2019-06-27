var depto =0;
function cargar_num_envios_a_validacion(){
	var url 		=  "../q/index.php/api/ventas_tel/num_agendados_validacion/format/json/";		
	var data_send 	=  {"id_usuario" : get_option("id_usuario")};				
	request_enid( "GET",  data_send , url , response_carga_numero_envios_a_validacion);
}
/**/
function response_carga_numero_envios_a_validacion(data){
	render_enid(".place_num_envios_a_validacion" , data);
	recorre_web_version_movil();
}
/**/
function  cargar_num_agendados(){
	var url 		=  "../q/index.php/api/ventas_tel/num_agendados/format/json/";		
	var	data_send 	=  {"id_usuario" : get_option("id_usuario") };	
	request_enid( "GET",  data_send , url , response_num_agendados , ".place_llamada_hecha");			
}
/**/
function response_num_agendados(data){
	render_enid(".place_num_agendados" , data.num_agendados_posibles_clientes);		
	render_enid(".place_num_tareas_pendientes" , data.num_tareas_pendientes);
}
/**/
function  cargar_num_clientes_restantes(){

	var url 		=  "../q/index.php/api/ventas_tel/num_clientes_restantes/format/json/";		
	var data_send 	=  {"id_usuario" : get_option("id_usuario")};				
	request_enid( "GET",  data_send , url , response_carga_num_clientes_restantes );
}
/**/
function response_carga_num_clientes_restantes(data){
	render_enid(".place_num_productividad" , data);
}
/**/
function num_pendientes(){

	var url	 		=  "../q/index.php/api/desarrollo/num_tareas_pendientes/format/json/";		
	var data_send 	=  {"id_usuario" : get_option("id_usuario") , "id_departamento" :  get_depto() };				
	request_enid( "GET",  data_send , url , response_num_pendientes);
}
/**/
function response_num_pendientes(data){
	render_enid(".place_tareas_pendientes" , data);
}
/**/
function set_depto(new_depto){
	depto = new_depto;
}
/**/
function get_depto(){
	return depto;
}
/**/