$("footer").ready(function(){

	now = $(".now").val();
	in_session =  $("#in_session").val();

	$("#mc-embedded-subscribe").click(suscribenewsletters);
	genericresponse =["Ocurio un error al registrar, reporte al administrador del sistema" 
	, "Felicidades ahora estás suscrito !!", "Error al cargar los datos de las gráficas, reportar al administrador"
	, "Ocurio un error al intentar registrar cambio, reporte al administrador del sistema" ];

	key_enid =  "AIzaSyAVF0GA9R64Jnbd3ZX53TnLI-61vOqcq-4";
	$(".text-filtro-enid").click(show_fields_mov);
	$(".more-info-f").click(carga_contenido);
	$(".form-busqueda-general").submit(new_busqueda_general);
	$(".form-reservacion-evento").submit(evento_reservacion);
	$(".load_resumen_escenarios_event").click(carga_section_escenarios_public);
	$(".enlance_next").click(nuevo_enlace_view);
	/**/
	
	
});
function nuevo_enlace(e){
	url =  e.target.id; 

	if (url.length > 3 ) {
		window.open(url);	
	}
	
}
/**/
function nuevo_enlace_view(e){

	url =  e.target.id; 		
	redirect(url);	
	
	
}

function get_alerta_enid(place ,  msj ){
	llenaelementoHTML( place ,  "<span class='alerta_enid'>" + msj + "</span>");
}
/**/
function carga_section_escenarios_public(){
	
	url =  now  + "index.php/api/escenario/load/format/html/";		
	evento =  $(".evento_escenario").val(); 
	in_session =  $(".in_session").val();	
	$.ajax({
		url : url , 
		data :  {"evento_escenario" : evento ,  "enid_evento" : evento ,  "seccion_public" : 1 , "in_session" : in_session } , 		
		type :  "GET", 
		beforeSend :  function(){			
			show_load_enid(".place_escenarios_public" , "Cargando ... " , 1); 		
		}		
	}).done(function(data){		
		$(".place_escenarios_public").empty();
		llenaelementoHTML(".seccion_escenarios_public" , data);
	}).fail(function(){				
		show_error_enid(".place_escenarios_public"  , "Error al cargar la sección de artistas"); 		
	});
}


function carga_informacion_extra(){
	/**/	

	url = "../eventos/index.php/api/event/otros/format/json/";	
	id_empresa  =  $(".empresa").val();
	

	$.ajax({
		url : url , 
		type :  "GET",
		data:  {"id_evento" :  1  , "id_empresa" :  id_empresa }	,
		beforeSend : function(){			
			show_load_enid( ".place_bloque_extra" , "Cargando ...  " , 1 ); 				
		}
	}).done(function(data){		
		//alert(data);		
		$(".place_bloque_extra").empty();
		llenaelementoHTML(".bloque_extra" , data);
	}).fail(function(){		
		show_error_enid(".place_bloque_extra" , "Error al cargar otros eventos"); 
	});

}
/**/
function evento_reservacion(e){
	/**/	
	flag =  valida_email_form("#a_mail" ,  ".place_mail" );	
	if (flag ==  1){			   
		$(".place_mail").empty();
		flag = valida_tel_form("#a_telefono" , ".place_tel" );
		if (flag ==  1) {
			$(".place_tel").empty();			
				url =  now + "index.php/api/enid/evento_reservacion/format/json/";	
				id_evento =  $(".id_evento").val();
				id_empresa =  $(".id_empresa").val();
				data_send = $(".form-reservacion-evento").serialize()+"&"+ $.param({"id_evento" : id_evento , "id_empresa" :  id_empresa});
				console.log(data_send);
				$.ajax({
					url :  url ,  
					type : "POST" ,
					data :  data_send , 
					beforeSend :  function(){
						show_load_enid(".place_reservacion_evento" ,  "Registrando tu reservación" ,  1);
					}

				}).done(function(data){

					show_response_ok_enid(".place_reservacion_evento" ,  "Tu reservación ha sido registrada con éxito");						
					$('.seccion-reservacion-evento-form').find('input, textarea, button, select').attr('disabled','disabled');					
					$(".mensaje-reservacion").show();

				}).fail(function(){
					//show_error_enid(".place_reservacion_evento" ,  "Error al realizar la reservación, a la brevedad será corregido");
					 console.log("Error al realizar la reservación");
				});
		}		
	}
	e.preventDefault();
}
/**/
/**/
function new_busqueda_general(e){

	q =  $("#qeventoenid").val();
	next =  now + "index.php/eventos/busqueda/"+q;
	redirect(next);
	e.preventDefault();
}

function carga_num_asistentes(){


	id_evento =  $(".id_evento").val();
	url =  now + "index.php/api/event/asistentes/format/json/";
	//alert(id_evento);
	$.ajax({
		url :  url ,
		data : {evento :  id_evento},
		beforeSend: function(){
			show_load_enid(".place_estado_evento", "" , 1); 
		}
	}).done(function(data){
		llenaelementoHTML( ".place_asistentes" , data);
	}).fail(function(){
		show_error_enid(".place_estado_evento" , "Error al cargar el número de asistentes del evento, reporte al administrador ");   			
	});

}
/***/

/**/
function carga_asistencia_user(){

	id_evento =  $(".id_evento").val();
	url =  now + "index.php/api/event/asistente_user/format/json/";
	console.log("id evento" +  id_evento );
	$.ajax({
		url :  url ,
		type:  "GET",
		data : {evento :  id_evento},
		beforeSend: function(){
			show_load_enid(".place_asistencia_user", "Verificando tu asistencia ... " , 1); 
		}
	}).done(function(data){
		llenaelementoHTML( ".place_asistencia_user" , data);

	}).fail(function(){
		show_error_enid(".place_asistencia_user" , "Error al cargar tu asistencia, reportar al administrador ");   			
	});
	carga_num_asistentes();
}
/**/

/**/
function carga_data_empresa(){	
	url  =  now + "index.php/api/emp/nombre_empresa/format/json/";		
	id_empresa =  $(".id_empresa").val();
	$.ajax({

		url : url, 
		data : {"id_empresa" :  id_empresa },		
		beforeSend : function(){
			show_load_enid(".place_nombre_empresa", " ... " , 1); 
		}
	}).done(function(data){

		console.log(data);
		$(".place_nombre_empresa").empty();
		nombre_empresa= data[0].nombreempresa;
		llenaelementoHTML(".nombre_empresa" , nombre_empresa );

	}).fail(function(){
		show_error_enid(".place_nombre_empresa" , "Error al cargar, reporte al administrado.");   			
	});
}
/**/
function existeFecha2(fecha){
        var fechaf = fecha.split("-");
        var y = fechaf[0];
        console.log("----" + y); 
        var m = fechaf[1];
        console.log("----" + m); 

        var d = fechaf[2];
        console.log("----" + d); 

        return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
}

/**/
function valida_format_date(fecha_inicio , fecha_termino , place ,  mensaje ){

	fecha_inicio =  $(fecha_inicio).val();
	fecha_termino =  $(fecha_termino).val();
	var fecha_actual =  new Date();


	/**/
	año_inicio =  fecha_inicio.substring(0 ,4);
	año_inicio = parseInt(año_inicio);

	año_termino =  fecha_termino.substring(0 ,4);
	año_termino = parseInt(año_termino);

	mes_inicio  =  fecha_inicio.substring(5 ,7);
	mes_inicio = parseInt(mes_inicio);

	mes_termino  =  fecha_termino.substring(5 ,7);
	mes_termino = parseInt(mes_termino);


	dia_inicio =  fecha_inicio.substring(8, 10);
	dia_inicio = parseInt(dia_inicio);

	dia_termino =  fecha_termino.substring(8, 10);
	dia_termino = parseInt(dia_termino);


	dia  =  fecha_actual.getDate();	
	dia =  parseInt(dia);
	mes =  fecha_actual.getMonth() +1;
	mes =  parseInt(mes);
	año =  fecha_actual.getFullYear();
	año =  parseInt(año);

	/**/
	mensaje_cliente =  ""; 
	flag_fecha = 0; 
	flag2 = 0;

	/*Validamos año*/
	if (año_inicio >=  año &&  año_termino >= año){
		/*Validamos mes */
		if (mes_inicio >=  mes && mes_termino >= mes  ||   año_inicio < año_termino  ){
			/*Validamos día*/			
		}else{			
			flag_fecha  ++;  				
		}
	}else{
		flag_fecha  ++;  
		
	}
	/**/
	if (flag_fecha > 0 ){		
		llenaelementoHTML(place , "<span class='alerta_enid'>"+mensaje+"</span>");							
	}

	/**/
	if(existeFecha2(fecha_inicio) ==  true){		
	}else{
		flag_fecha ++;
		llenaelementoHTML(place , "<span class='alerta_enid'>Indique sólo fechas reales</span>");							
	}

	if(existeFecha2(fecha_termino) ==  true){		
	}else{
		flag_fecha ++;
		llenaelementoHTML(place , "<span class='alerta_enid'>Indique sólo fechas reales</span>");							
	}
	fecha_ini =  new Date(año_inicio , mes_inicio , dia_inicio);
	fecha_ter =  new Date(año_termino , mes_termino , dia_termino);
	if (fecha_ini> fecha_ter) {
		flag_fecha ++;
		llenaelementoHTML(place , "<span class='alerta_enid'>La fecha inicio no puede ser mayor a la de termino </span>");								
	}




	if (flag_fecha == 0 ) {
		$(place).empty();
	}
	return flag_fecha;

	
}
/**/
function validate_format_num_pass( input , place , num  ){

	valor_registrado =   $(input).val(); 
	text_registro =  $.trim(valor_registrado);  
	flag =0;
	if ( text_registro.length > num ) {
		flag =1;
	}

	mensaje_user =  ""; 
	if (flag == 0) {
		$(input).css("border" , "1px solid rgb(13, 62, 86)");
		flag  = 0; 
		mensaje_user =  "Password demasiado corto"; 
	}
	llenaelementoHTML( place ,  "<span class='alerta_enid'>" + mensaje_user + "</span>");
	return flag; 
}
/**/
function show_load_enid(place , texto , flag ){


    	bar = 	"<label>Cargando ... </label><br>";
    	bar +=  '<div class="progress progress-striped active page-progress-bar">';
            bar +='<div class="progress-bar" style="width: 100%;"></div> </div>';
        
        llenaelementoHTML(place , bar );
        

	/* 1 para imagenes cortas */		

	/*
	switch(flag) {
    case 1:

    	texto =  "<span class='text-load'> Cargando ... </span>";	
		url =  "../img_tema/loading3.gif";
		img =  "<img width='20px;' src='"+url+"'>";		
        llenaelementoHTML(place , img + " " + texto );
        break;
    case 2:
    	
    	bar = 	"<label>Cargando ... </label><br>";
    	bar +=  '<div class="progress progress-striped active page-progress-bar">';
            bar +='<div class="progress-bar" style="width: 100%;"></div> </div>';
        
        llenaelementoHTML(place , bar );
        break;

    default:
    	texto =  "<span class='text-load'> Cargando ... </span>";	
		url =  "../img_tema/loading3.gif";
		img =  "<img width='20px;' src='"+url+"'>";		
        llenaelementoHTML(place , img + " " + texto );
        
        break;
	}
	*/ 
}
/**/
function show_response_ok_enid(place , msj ){

	$(place).show();
	llenaelementoHTML(place , "<span class='response_ok_enid'>" + msj + "</span>");
	muestra_alert_segundos(place);
}
function show_error_enid(place , mjs){
	
	url =  "../soporte/index.php/api/reportes/reporte_sistema/format/json/";
	URLactual = window.location;
	mensaje_error = "Se presentó el error --- " + mjs + " place --- "+ place  + " Url ----  "+  URLactual;

	$.ajax({
		url : url , 
		type: "POST" , 
		data: {"descripcion" :  mensaje_error }
	}).done(function(data){	
		
		console.log("Error db " + data);
		$(place).empty();
	}).fail(function(){

		console.log("Error al regstrar error");		
	});
}
/**/

function valida_text_form(input , place_msj , len , nom ){
		
	$(place_msj).show();
	valor_registrado =   $.trim($(input).val()); 	

	mensaje_user =  "";
	flag = 1; 		
	if (valor_registrado.length < len ){
		mensaje_user =  nom + " demasiado corto "; 		
		flag = 0;  
	}	
	/*Lanzamos mensaje y si es necesario mostramos border*/
	if (flag == 0) {
		$(input).css("border" , "1px solid rgb(13, 62, 86)");
		flag  = 0; 

	}

	llenaelementoHTML( place_msj ,  "<span class='alerta_enid'>" + mensaje_user + "</span>");
	if (flag ==1 ) {
		$(place_msj).empty();
	}

	return flag; 
}
/**/
function valida_num_form(input , place_msj ){	
	$(place_msj).show();
	valor_registrado =   $(input).val(); 
	mensaje_user =  "";
	f = 1; 
	$(place_msj).empty();
	if ( isNaN(valor_registrado)){
		mensaje_user = "Registre sólo números "; 		
		f =0 ;  
	}	
	/*Lanzamos mensaje y si es necesario mostramos border*/
	if (f == 0) {$(input).css("border" , "1px solid rgb(13, 62, 86)");}
	llenaelementoHTML( place_msj ,  "<span class='alerta_enid'>" + mensaje_user + "</span>");
	return f; 
}
/**/
function valida_url_form( place , input  ,  msj ){

	//url =  $.trim($(input).val());
	url =  $.trim($(input).val());
	var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    if(RegExp.test(url)){
        return true;
    }else{
        return false;
    }
}
	
/**/	
function valida_email_form(input ,  place_msj ){

	$(place_msj).show();
	valor_registrado =   $(input).val(); 
	mensaje_user =  "";
	flag = 1; 
	if (valor_registrado.length < 8 ){
		mensaje_user =  "Correo electrónico demasiado corto"; 		
		flag =0 ;  
	}
	/**/
	
	if (valEmail(valor_registrado) ==  false) {
		mensaje_user =  "Registre correo electrónico correcto"; 		
		flag =0 ;  	
	}
	/**/
	emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

    if (emailRegex.test(valor_registrado)) {
      flag =1;
    } else {
      mensaje_user =  "Registre correo electrónico correcto"; 		
      flag =0 ;  	
    }



	/*Lanzamos mensaje y si es necesario mostramos border*/
	if (flag == 0) {$(input).css("border" , "1px solid rgb(13, 62, 86)");}
	llenaelementoHTML( place_msj , "<span class='alerta_enid'>" +  mensaje_user + "</span>");
	return flag; 
}	
/**/
function valida_tel_form(input ,  place_msj ){
	$(place_msj).show();	
	valor_registrado =   $(input).val(); 
	mensaje_user =  "";
	flag = 1; 
	if (valor_registrado.length < 8 ){
		mensaje_user =  "Número telefónico demasiado corto"; 		
		flag =0 ;  
	}
	if (valor_registrado.length >  13 ){
		mensaje_user =  "Número telefónico demasiado largo"; 		
		flag =0 ;  
	}
	/**/
	if (isNaN(valor_registrado)) {
		mensaje_user = "Registre solo números telefónicos";
		flag =0 ;  
	}
	/*Lanzamos mensaje y si es necesario mostramos border*/
	if (flag == 0) {$(input).css("border" , "1px solid rgb(13, 62, 86)");}
	llenaelementoHTML( place_msj ,  "<span class='alerta_enid'>" + mensaje_user + "</span>");
	return flag; 
}	
/**/

/**/
function limpia_inputs(){
	$(".form-control").val("");
}
function outsystem(){
	urlnext = $(".now").val()+"index.php/sessioncontroller/logout/";		
	redirect(urlnext);	
}
function llenaelementoHTML(idelement , data ){	
	$(idelement).html(data);
} 
function valorHTML(idelement , data){
	$(idelement).val(data);
} 
function set_text_element(text_tag , texto ){
	$(text_tag).text(texto);
}
function redirect(url){
	window.location.replace(url);
}
function recorrepage(idrecorrer){	
	$('html, body').animate({scrollTop: $(idrecorrer).offset().top -100 }, 'slow');
}
function get_td(val , extra ){ 
	return "<td>" + val + "</td>";
}
function showhide(elementoenelquepasas, elementodinamico ){

	$( elementoenelquepasas ).mouseover(function() {
			$(elementodinamico).show();
	}).mouseout(function() {
		$(elementodinamico).hide();
	});
}
/**/
function showonehideone( elementomostrar , elementoocultar  ){
	$(elementomostrar).show();
	$(elementoocultar).hide();
}
/*saca el id del elemento */
function getidstringanddinamicelement(completa, elementomostrar , elementoocultar){

	bandera =0; 
	id="";

	for(var x in completa){

			if (bandera>0) {
				id += completa[x];
			}

			if (completa[x] == "_") {
				bandera++;
			}


	}/*Termina el ciclo*/
	
	dinamicinput =  elementomostrar + id;
	dinamicpnombre =  elementoocultar+ id;
	showonehideone( dinamicinput , dinamicpnombre  );
	return id;
}
/*saca el id del elemento */
function getidstringcadena(completa){

	bandera =0; 
	id="";

	for(var x in completa){

			if (bandera>0) {
				id += completa[x];
			}

			if (completa[x] == "_") {
				bandera++;
			}
	}/*Termina el ciclo*/
	return id;
}
/**/
function valEmail(valor){
    re=/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/
    if(!re.exec(valor))    {
        return false;
    }else{
        return true;
    }
}
/**/
function valida_precio(input ,  num , place , mensaje_user ){

	val =  $(input).val();		
	flag =0;
	if (val >  num) {
		$(place).empty();
		return 1; 
	}else{
		if (flag == 0) {$(input).css("border" , "1px solid rgb(13, 62, 86)");}
		llenaelementoHTML( place ,  "<span class='alerta_enid'>" + mensaje_user + "</span>");
		return 0;
	}
}

/**/
function valida_l_precio(input ,  l , place , mensaje_user ){

	val =  $(input).val();	
	val_length  = val.length;
	flag =0;
	if (val_length <=  l) {
		$(place).empty();
		return 1; 
	}else{
		if (flag == 0) {$(input).css("border" , "1px solid rgb(13, 62, 86)");}
		llenaelementoHTML( place ,  "<span class='alerta_enid'>" + mensaje_user + "</span>");
		return 0;
	}
}
/**/
function  suscribenewsletters(e) {
	
	EMAIL =  $("#mce-EMAIL").val();
	/*Validamos que sea mail desde la vista */
		if (valEmail(EMAIL) ==  true ) {

				url = now + "index.php/api/newslettercontrolador/registrarCorreo/Format/json/";
				$.post(url , $("#subscribenow").serialize()).done(function(data){

					llenaelementoHTML("#mce-success-response" , genericresponse[1]);
					llenaelementoHTML("#mce-error-response", "");
				
				}).fail(function(){
						
					alert("#mce-error-response", genericresponse[0]);	
				
				});

		
		}else{

				llenaelementoHTML("#mce-error-response" , "Lo sentimos, ingresa un email correcto para completar la solicitud");
		}


	$(".progress").show();
	$(".progress-xs").show();
	return false;
}
function show_section_dinamic_button(seccion){

	if ($(seccion).is(":visible")) {
		
		$(seccion).hide();
	}else{
		$(seccion).show();
	}	
}
/**/
function show_section_dinamic_arrow(dinamic_section , id_section , new_class_up , new_class_down){

	if ($(dinamic_section).is(":visible")) {
		
		
		$(id_section).removeClass(new_class_down);		
		$(id_section).addClass(new_class_up);	
		
		
	
	}else{		
		
		
		$(id_section).removeClass(new_class_up);		
		$(id_section).addClass(new_class_down);		
	}
}
/**/
function show_section_dinamic_on_click(dinamic_section){


	if ($(dinamic_section).is(":visible")) {

		$(dinamic_section).hide();

	}else{

		$(dinamic_section).show();
	}

}
/**************************************************************************************/
function updates_send(url , data_send ){

	$.post(url , data_send ).done(function(data){

	}).fail(function(){
		alert("Falla al actualizar");
	});

}
/**************************************************************************************/
function updates_send_test(url , data_send ){

	$.post(url , data_send ).done(function(data){

		alert(data);
	}).fail(function(){
		alert("Falla al actualizar");
	});
}
/**/
function actualiza_data_test(url , data_send ){
	$.ajax({
	   url: url,
	   type: 'PUT',
	   data : data_send  }).done(function(data){
	   		alert(data);
	}).fail(function(){
	   		alert("falla al intentar actualizar");
	});
}
function actualiza_data(url , data_send ){
	$.ajax({
	   url: url,
	   type: 'PUT',
	   data : data_send  }).done(function(data){
	   		
	}).fail(function(){
	   		alert("falla al intentar actualizar");
	});
}
/**/
function registra_data(url , data_send ){

	$.post(url , data_send ).done(function(data){
		
	}).fail(function(){
		alert("Falla al registrar");
	});
}
/***/
function registra_data_test(url , data_send ){

	$.post(url , data_send ).done(function(data){
		alert(data);
	}).fail(function(){
		alert("Falla al registrar");
	});
}

/**/
function eliminar_data(url , data_send ){
	$.ajax({
	   url: url,
	   type: 'DELETE',
	   data : data_send }).done(function(data){
	   	
	}).fail(function(){
	   
	});
}
function eliminar_data_test(url , data_send ){
	$.ajax({
	   url: url,
	   type: 'DELETE',
	   data : data_send }).done(function(data){
	   	alert(data);
	}).fail(function(){
	   
	});
}

function exporta_excel(){
	
    $("#datos_a_enviar").val( $("<div>").append( $("#print-section").eq(0).clone()).html());
    $("#FormularioExportacion").submit();
}
/**/
function reset_fields(fields){

	for(var x in fields ){
		$(fields[x]).val("");
	}
}
function reset_checks(inputs){
  for(var x in inputs ){		
		document.getElementById(inputs[x]).checked = false;
	}
}


/**/
function ocualta_elementos_array(data){
		
	for(var x in data){		
		$(data[x]).hide();		
	}
}
/**/
function muestra_alert_segundos(seccion){	
	setTimeout(function() {
        $(seccion).fadeOut(1500);
    }, 1500);
}
/**/
function complete_alert_ok_modal(e,  f){

	$(f).modal('hide');
	$(e).show();
	muestra_alert_segundos(e);
	

}
function complete_alert(e){
	
	$(e).show();
	muestra_alert_segundos(e);
}

function resumen_event(muestra, botona , botonb ){

	$(muestra).show();
	showonehideone(botona , botonb);
}
function dinamic_section(){    
    $(".menos-info").show();
    showonehideone(".dinamic_campo_tb" , ".mas-info");
}
/******/
function dinamic_section_info(){
    $(".menos-info").hide();
    showonehideone(  ".mas-info" , ".dinamic_campo_tb");
}
/*Para imagenes */
function mostrar_img_upload(source , idsection){
		
	var list = document.getElementById(idsection);
	$.removeData(list);
	li   = document.createElement('li');
	img  = document.createElement('img');
	img.setAttribute('width', '50%');
	img.setAttribute('height', '50%');        
	img.src = source;		
	li.appendChild(img);
	list.appendChild(li);
}
/**/
function  url_editar_user( url , text ){
	url_next =  "<a href='"+url+"' style='color:white;'>"+ text+"<i class='fa fa-pencil-square-o'></i></a>";	
	return  url_next;
}
/**/
function replace_val_text(input_val , label_place , valor , text){
	llenaelementoHTML(label_place , text );
	valorHTML( input_val , valor);		
	showonehideone( label_place, input_val ); 
}
function dinamic_t(){


	if ($("#in_session").val() != 1 ) {

	

	  $(".left-side").getNiceScroll().hide();
       
       if ($('body').hasClass('left-side-collapsed')) {
           $(".left-side").getNiceScroll().hide();
       }
       var body = jQuery('body');
      var bodyposition = body.css('position');
      if(bodyposition != 'relative') {

         if(!body.hasClass('left-side-collapsed')) {
            body.addClass('left-side-collapsed');
            jQuery('.custom-nav ul').attr('style','');

            jQuery(this).addClass('menu-collapsed');

         } else {
            body.removeClass('left-side-collapsed chat-view');
            jQuery('.custom-nav li.active ul').css({display: 'block'});

            jQuery(this).removeClass('menu-collapsed');

         }
      }
    }  
}

/**/
function show_fields_mov(){	
	seccion =  ".hidden-field-mov";
	if ($(seccion).is(":visible")) {		
		$(seccion).hide();		
		$(".text-filtro-enid").text(" + Filtros");
	}else{
		$(seccion).show();
		$(".text-filtro-enid").text(" - Filtros");
	}	
}
/**/
function carga_contenido(){
	
	seccion =  ".show_descripcion";

	if ($(seccion).is(":visible")) {		
		$(".hiddden_descripcion").show();
		$(".more-info-f-up").show();
		$(".more-info-f-down").hide();
		$(".show_descripcion").hide();
	}else{
		
		$(".hiddden_descripcion").hide();
		$(".more-info-f-up").hide();
		$(".more-info-f-down").show();
		$(".show_descripcion").show();
	}
}
/**/
function valida_cadenas_iguales(input , input2 ,  place , mensaje_user  ){

	val = $(input).val();
	val2 = $(input2).val();


	if (val !=  val2 ) {		
		llenaelementoHTML( place ,  "<span class='alerta_enid'>" + mensaje_user + "</span>");
		return 0;		
	}else{

		$(place).empty();
		return 1;		
	}
}
