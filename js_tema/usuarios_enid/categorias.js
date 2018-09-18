function  simula_envio_categoria(e) {
	
	valida_existencia_clasificacion();	
	e.preventDefault();
}
/**/
function valida_existencia_clasificacion(){
	
	var data_send 	=   $(".form_categoria").serialize();			
	var url 		=  "../q/index.php/api/clasificacion/existencia/format/json/";	
	$.ajax({
		url: url,
		type: "GET", 
		data: data_send ,
		beforeSend:function(){
		}
	}).done(next_step_add_clasificacion).fail(function(){});
}
/**/
function next_step_add_clasificacion(data){
	if (data.existencia == 0) {
		/**Se cargan los padres*/
		load_niveles();
	}else{
		
		llenaelementoHTML( ".msj_existencia" ,  "<span class='alerta_enid'>ÉSTA CATEGORÍA YA SE ENCUENTRA REGISTRADA</span>");
	}
}
/**/
function load_niveles(){
	
	$(".msj_existencia").empty();		
	$(".form_categoria").hide();
	es_servicio 	=  $(".servicio option:selected").val();		
	set_option("es_servicio" , es_servicio);
	nivel 			=	1;
    padre        	=  0;	

    data_send =  {es_servicio : es_servicio , nivel : nivel, padre : padre };	
	url =  "../q/index.php/api/clasificacion/nivel/format/json/";	
	$.ajax({
		url: url,
		type: "GET", 
		data: data_send
	}).done(muestra_sugerencias_primer_nivel).fail(function(){});

}
/**/
function muestra_sugerencias_primer_nivel(data){
	llenaelementoHTML( ".primer_nivel" ,  data);
	$(".primer_nivel .sugerencia_clasificacion option").click(muestra_mas_opciones);
}
/**/
function muestra_mas_opciones(e){

	clean_categorias(0);
	
	padre =  e.target.value;
	if (padre >0 ){		
		nivel 			=	2;
		es_servicio  	= 	get_option("es_servicio");
		data_send =  {es_servicio : es_servicio , nivel : nivel, padre : padre };	
		url =  "../q/index.php/api/clasificacion/nivel/format/json/";	
		$.ajax({
			url: url,
			type: "GET", 
			data: data_send
		}).done(muestra_sugerencias_segundo_nivel).fail(function(){});

	}
}
/**/
function muestra_sugerencias_segundo_nivel(data){

	
	llenaelementoHTML( ".segundo_nivel" ,  data);
	$(".seleccion_2").click(function(){

		add_categoria(2 , $(".primer_nivel option:selected").val() , $(".servicio option:selected").val());
	});
	$(".segundo_nivel .sugerencia_clasificacion option").click(muestra_mas_opciones_segundo);
}
/**/
function muestra_mas_opciones_segundo(e){
	
	clean_categorias(1);

	padre =  e.target.value;
	if (padre >0 ){		
		nivel 			=	 3;
		es_servicio  	= 	get_option("es_servicio");
		data_send =  {es_servicio : es_servicio , nivel : nivel, padre : padre };	
		url =  "../q/index.php/api/clasificacion/nivel/format/json/";	
		$.ajax({
			url: url,
			type: "GET", 
			data: data_send
		}).done(muestra_sugerencias_tercer_nivel).fail(function(){});

	}
}
/**/
function muestra_sugerencias_tercer_nivel(data){

	llenaelementoHTML( ".tercer_nivel" ,  data);
	$(".seleccion_3").click(function(){
		add_categoria(3 , $(".segundo_nivel option:selected").val() , $(".servicio option:selected").val());
	});

	$(".seleccion_2").hide();
	$(".tercer_nivel .sugerencia_clasificacion option").click(muestra_mas_opciones_tercer);
}
/**/
function muestra_mas_opciones_tercer(e){
	clean_categorias(2);
	padre =  e.target.value;
	if (padre >0 ){		
		nivel 			=	 4;
		es_servicio  	= 	get_option("es_servicio");
		data_send =  {es_servicio : es_servicio , nivel : nivel, padre : padre };	
		url =  "../q/index.php/api/clasificacion/nivel/format/json/";	
		$.ajax({
			url: url,
			type: "GET", 
			data: data_send
		}).done(muestra_sugerencias_cuarto).fail(function(){});

	}
}
/**/
function muestra_sugerencias_cuarto(data){
	llenaelementoHTML( ".cuarto_nivel" ,  data);
	$(".seleccion_4").click(function(){
		add_categoria(4 , $(".tercer_nivel option:selected").val() , $(".servicio option:selected").val());
	});

	$(".seleccion_3").hide();
	$(".cuarto_nivel .sugerencia_clasificacion option").click(muestra_mas_opciones_quinto);
}
/**/
function muestra_mas_opciones_quinto(e){
	clean_categorias(3);
	padre =  e.target.value;
	if (padre >0 ){		
		nivel 			=	 5;
		es_servicio  	= 	get_option("es_servicio");
		data_send =  {es_servicio : es_servicio , nivel : nivel, padre : padre };	
		url =  "../q/index.php/api/clasificacion/nivel/format/json/";	
		$.ajax({
			url: url,
			type: "GET", 
			data: data_send
		}).done(muestra_sugerencias_quinto).fail(function(){});

	}
}
/**/
function muestra_sugerencias_quinto(data){
	clean_categorias(4);
	$(".seleccion_4").hide();
	llenaelementoHTML( ".quinto_nivel" ,  data);	
	$(".seleccion_5").click(function(){		
		add_categoria(5 , $(".cuarto_nivel option:selected").val() , $(".servicio option:selected").val());
	});
}
/**/
function clean_categorias(inicio){

	var  categorias =  [".primer_nivel",
						".segundo_nivel",
						".tercer_nivel",
						".cuarto_nivel",
						".quinto_nivel"];

	for(var x in categorias ){		
		if (x > inicio) {
			$(categorias[x]).empty();
		}
	}					
}
/***/
function add_categoria(nivel , padre , tipo){
	
	
	clasificacion = $(".clasificacion").val();
	data_send =   {clasificacion:clasificacion , tipo : tipo , padre : padre , nivel:nivel};	
	url =  "../q/index.php/api/clasificacion/nivel/format/json/";	

	$.ajax({
			url: url,
			type: "POST", 
			data: data_send ,
			beforeSend:function(){
			}
	}).done(next_add).fail(function(){});	
}
/**/
function next_add(data){
	clean_categorias(-1);
	$(".form_categoria").show();	
	reset_form("form_categoria");
	llenaelementoHTML( ".msj_existencia" ,  "<a class='a_enid_black'>CATEGORÍA AGREGADA!</a>");
}