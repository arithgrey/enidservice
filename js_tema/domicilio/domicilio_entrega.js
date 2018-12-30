$(document).ready(function(){
	$(".agregar_direccion_pedido").click(agregar_direccion_pedido);
	$(".agregar_punto_encuentro_pedido").click(agregar_punto_encuentro_pedido);
	$(".establecer_direccion").click(asignar_direccion_existente_pedido);
	$(".establecer_punto_encuentro").click(asignar_punto_encuentro_existente_pedido);

});
var agregar_direccion_pedido = function(){	
	$(".form_registro_direccion").submit();
};
var agregar_punto_encuentro_pedido = function(){
	
	$(".form_puntos_medios").submit();
};
var asignar_direccion_existente_pedido = function(){
	
	var id_direccion =  get_parameter_enid($(this) , "id");	
	var id_recibo 	 =  get_parameter_enid($(this) , "id_recibo");	
	show_confirm("¿DESEAS ENVIAR A ESTA DIRECCIÓN TU PEDIDO?",  "" , "CONTINUAR" , function(){proceso_asignar_direccion(id_direccion , id_recibo)} );
};
var proceso_asignar_direccion = function(id_direccion , id_recibo){
		
	var url  		=  "../q/index.php/api/proyecto_persona_forma_pago_direccion/index/format/json/";
	var data_send 	= {"id_direccion" : id_direccion , "id_recibo":id_recibo , "asignacion" : 1};
	request_enid( "POST",  data_send, url, response_proceso_asignacion);

};
var response_proceso_asignacion = function(data){
	redirect("");
};
var asignar_punto_encuentro_existente_pedido= function(){

	var id_punto_encuentro =  get_parameter_enid($(this) , "id");
	var id_recibo 	 =  get_parameter_enid($(this) , "id_recibo");
	show_confirm("¿DESEAS QUE TU ENTREGA SEA EN ESTE PUNTO DE ENCUENTRO?",  "" , "CONTINUAR" , function(){proceso_asignar_punto_encuentro(id_punto_encuentro , id_recibo)} );
};

var proceso_asignar_punto_encuentro = function (id_punto_encuentro , id_recibo) {

	if (id_punto_encuentro > 0 ){
		set_parameter(".punto_encuentro_asignado" , id_punto_encuentro);
		$(".form_puntos_medios_avanzado").submit();
	}
};
