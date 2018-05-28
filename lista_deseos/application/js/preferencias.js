$(document).ready(function(){	
	$(".item_preferencias").click(agrega_interes);
});
/**/
function agrega_interes(e){
	
	$(this).addClass("selected_clasificacion");	

	id_clasificacion =  e.target.id;
	url = "../tag/index.php/api/clasificacion/interes/format/json/";
	data_send = {id_clasificacion : id_clasificacion};
	$.ajax({
		url : url , 
		type: "PUT",
		data: data_send, 
		beforeSend: function(){
			show_load_enid(".place_resumen_servicio" , "Cargando ... ", 1 );
		}
	}).done(function(data){				

		
	}).fail(function(){});	
}