$(document).ready(function(){
	$(".order").change(filtro);
});
/**/
function filtro(){
	var url_actual 	= 	window.location;
	var order 		=  	get_parameter("#order option:selected");
	var new_url 	=  	url_actual+"&order="+order;
	redirect(new_url);
}