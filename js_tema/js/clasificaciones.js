function carga_tipos_tallas(e){
	
	var  	data_send 	= $(".form-tipo-talla").serialize()+"&"+$.param({"v":1});
	var 	url			= "../q/index.php/api/tipo_talla/like_clasificacion/format/json/";
	request_enid( "GET",  data_send , url , muestra_tipo_tallas);
	e.preventDefault();
}
/**/
function muestra_tipo_tallas(data){
	
	llenaelementoHTML(".place_tallas", data);
	$(".configurar_talla").click(carga_tipo_talla);
}
/**/
function carga_tipo_talla(){
	var id 	=  get_attr(this, "id");	
	carga_tipo_talla_por_id(id);
}
/**/
function carga_tipo_talla_por_id(id){

	if (id>0) {
		set_option("id"  , id);
		var  	data_send 	= $.param({"id":id , "v": 1});
		var 	url			= "../q/index.php/api/clasificacion/tipo_talla/format/json/";
		request_enid( "GET",  data_send , url , muestra_tipo_talla );
	}	
}
/**/
function muestra_tipo_talla(data){
	llenaelementoHTML(".place_tallas", data);
	$(".form-agregar-clasificacion-talla").submit(muestra_clasificacion_tipo_talla_disponibles	);
}
/***/
function muestra_clasificacion_tipo_talla_disponibles(e){

	var  	data_send 	= $(".form-agregar-clasificacion-talla").serialize()+"&"+$.param({"id":get_option("id") , "v":1});
	var 	url			= "../q/index.php/api/clasificacion/tipo_talla_clasificacion/format/json/";
	request_enid( "GET",  data_send , url , muestra_clasificaciones_disponibles );
	e.preventDefault();
}
/**/
function muestra_clasificaciones_disponibles(data){
	llenaelementoHTML(".info_tags", data);
	$(".tag").click(agregar_clasificacion_tipo_talla);
}
/**/
function agregar_clasificacion_tipo_talla(){

	var  	id 			=   get_attr(this, "id"); 
	var  	data_send 	=	$.param({"id_clasificacion": id , "id": get_option("id")});
	var 	url			= 	"../q/index.php/api/clasificacion/tipo_talla_clasificacion/format/json/";
	request_enid( "POST",  data_send , url , muestra_estado_ingreso_tipo_talla );
	
}
/**/
function muestra_estado_ingreso_tipo_talla(data){
	console.log(data);
	id 		=  get_option("id"); 	
	carga_tipo_talla_por_id(id);
}