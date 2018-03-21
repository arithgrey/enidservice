$(document).ready(function(){
	$(".btn-orden").click(genera_orden);	

});
/**/
function genera_orden(){

	info_orden_compra =  $(".info_orden_compra").html();	
	$(".contenido_print").val(info_orden_compra);
	$(".form_orden_compre").submit();
}
