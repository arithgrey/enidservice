var num_cuentas ="";
var busqueda =0; 
var clasificacion =0;
var servicio = 0;
$(document).ready(function(){
	/**/	
	$("footer").ready(function(){
		set_busqueda(1);
		$(".search_articulo").submit();			
	});
	$("footer").ready(menu_categorias);
	$(".search_articulo").submit(q);
	/**/	
});
/**/
function q(e){	
	/**/
	url =  "../tag/index.php/api/producto/q/format/json/";		
	campos_busqueda = $.param({busqueda:get_busqueda(), clasificacion : get_clasificacion()});
	data_send = $(".search_articulo").serialize()+"&"+campos_busqueda;	
	
	$.ajax({
		url : url , 
		type : "GET" , 
		data: data_send, 
			beforeSend : function(){
				muestra_cargando_proceso_enid();
		}
		}).done(function(data){						
			llenaelementoHTML(".resultados" , data);
			/**/
			$(".info_producto").click(function(e){
				servicio =  e.target.id; 
				if(servicio > 0 ){
					set_servicio(servicio);						
				}
				/**/
				
			});
			muestra_cargando_proceso_enid();			
		}).fail(function(){				
			show_error_enid(".place_registro_afiliado" , "Error al iniciar sessión");				
		});
	e.preventDefault();
}
/**/
function set_busqueda(n_ingreso){
	busqueda = n_ingreso;

}
/**/
function get_busqueda(){
	return busqueda; 
}
/**/
function get_clasificacion(){
	return clasificacion;
}
/**/
function set_clasificacion(n_clasificacion){
	clasificacion = n_clasificacion;
}
/**/
function set_servicio(n_servicio){
	servicio =  n_servicio;
}
/**/
function get_servicio(){
	return servicio;
}
/***/
function menu_categorias(){
	/**/
	url =  "../tag/index.php/api/producto/posibles_busquedas/format/json/";			
	data_send = $(".search_articulo").serialize();	
	
	$.ajax({
		url : url , 
		type : "GET" , 
		data: data_send, 
			beforeSend : function(){			
		}
		}).done(function(data){									
			/**/
			llenaelementoHTML(".place_menu_productos", data);
		}).fail(function(){				
			show_error_enid(".place_registro_afiliado" , "Error al iniciar sessión");				
		});
	e.preventDefault();
}
