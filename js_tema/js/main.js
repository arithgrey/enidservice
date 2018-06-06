var titulo_web = "";
var flag_titulo_web = 0;
var flag_activa_notificaciones = 0;
var tarea =0;
var flag_carga_preferencias =0;
var tipo_negocios_arr = [];
var tipo_negocio =0;
var option = [];
$("footer").ready(function(){
	now = $(".now").val();
	in_session =  $(".in_session").val();		
	$("#form_contacto").submit(envia_comentario);		
	$(".btn_enviar_email_prospecto").click(function(){
		$(".form_enid_contacto").submit();
	});
	$(".form_enid_contacto").submit(registra_lead);	
	/**/
	$(".menu_notificaciones_progreso_dia").click(metricas_perfil);
	metricas_perfil();
	set_titulo_web($(".titulo_web").val());					
	/**/
	$(".telefono_info_contacto").keyup(quita_espacios_input);
	$(".precio").keyup(quita_espacios_input_precio);
	/**/
	$(".correo_electrionico_lead").keyup(muestra_campos_adicionales_lead);
	$("footer").ready(valida_menu_superior);
});
function get_alerta_enid(place ,  msj ){
	llenaelementoHTML( place ,  "<span class='alerta_enid'>" + msj + "</span>");
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
}
/**/
function show_response_ok_enid(place , msj ){

	$(place).show();
	llenaelementoHTML(place , "<span class='response_ok_enid'>" + msj + "</span>");
	muestra_alert_segundos(place);
}
function show_error_enid(place , mjs){
	
	url =  "../bug/index.php/api/reportes/reporte_sistema/format/json/";
	URLactual = window.location;
	mensaje_error = "Se presentó el error --- " + mjs + " place --- "+ place  + " Url ----  "+  URLactual;


	$.ajax({
		url : url , 
		type: "POST" , 
		data: {"descripcion" :  mensaje_error }
	}).done(function(data){	
		
			
		console.log("Error db " + data);
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
function limpia_inputs(){
	$(".form-control").val("");
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
/*
function  suscribenewsletters(e) {
	
	EMAIL =  $("#mce-EMAIL").val();

		if (valEmail(EMAIL) ==  true ) {

				url = "../enid/index.php/api/newslettercontrolador/registrarCorreo/Format/json/";
				$.post(url , $("#subscribenow").serialize()).done(function(data){

					llenaelementoHTML("#mce-success-response" , genericresponse[1]);
					llenaelementoHTML("#mce-error-response", "");
				
				}).fail(function(){				
					
				});

		}else{

				llenaelementoHTML("#mce-error-response" , "Lo sentimos, ingresa un email correcto para completar la solicitud");
		}
	$(".progress").show();
	$(".progress-xs").show();
	return false;
}
*/
function show_section_dinamic_button(seccion){

	if ($(seccion).is(":visible")) {
		
		$(seccion).hide();
	}else{
		$(seccion).show();
	}	
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

function complete_alert(e){
	
	$(e).show();
	muestra_alert_segundos(e);
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
	img.setAttribute('width', '100%');
	img.setAttribute('height', '100%');        
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
function envia_comentario(e){	

	/**/
	url =   $("#form_contacto").attr("action");
	f = valida_email_form("#emp_email" , ".place_mail_contacto" ); 
		if (f ==  1 ) {
			set_places();

			f =  valida_tel_form("#tel" ,  ".place_tel_contacto" );
			if (f ==  1 ) {
				
					set_places()
					recorrepage("#btn_envio_mensaje");
					id_empresa = 1;
					data_send =   $("#form_contacto").serialize()  + "&"+ $.param({"empresa" : id_empresa , "tipo" : 2 });
					
					$.ajax({
						url : url , 
						type: "POST",
						data : data_send, 
						beforeSend: function(){
							show_load_enid(".place_registro_contacto" ,  "Enviando tu comentario... " ,  1 );			
						}
					}).done(function(data){
							
						
						show_response_ok_enid(".place_registro_contacto" , "<div class='contacto_enviado'> Gracias por enviarnos tu mensaje, pronto sabrás de nosotros. ! </div>");
						document.getElementById("form_contacto").reset();	
						redirect("../");				
						

					}).fail(function(){
						show_error_enid(".place_registro_contacto" , "Error cargar la galeria de imagenes.");		
					});

			}
	}
	e.preventDefault();
}
/**/
function registra_lead(e){

	url =   $(".form_enid_contacto").attr("action");		
	f = valida_email_form("#btn_cotizacion" , ".place_mail_contacto" ); 
	tipo_prospecto = $("#tipo_prospecto").val();



		if (f ==  1 ) {
			set_places();



				flag =  valida_text_form(".nombre_lead" , ".place_nombre_lead" , 5 , "Nombre" ); 
						
				if (flag==1) {
					$(".place_nombre_lead").empty();

						flag =  valida_text_form(".telefono_lead" , ".place_telefono_lead"  , 5, "Teléfono" );
					
						if (flag ==  1) {
							$(".telefono_lead").empty();
							data_send =   $(".form_enid_contacto").serialize() + "&"+ $.param({"empresa" : 1 });						

							$.ajax({
								url : url , 
								type: "POST",
								data : data_send, 
								beforeSend: function(){
									show_load_enid(".place_registro_contacto" ,  "Enviando tu comentario... " ,  1 );			
								}

							}).done(function(data){
													

								$(".place_mail_contacto").empty();
								$(".place_registro_contacto").empty();
								show_response_ok_enid(".place_registro_contacto" , "<div class='contacto_enviado'> Gracias por enviarnos tu mensaje, pronto sabrás de nosotros. ! </div>");
								document.getElementById("form_enid_contacto").reset();						

								if (tipo_prospecto ==  15) {
								llenaelementoHTML(".place_registro_contacto", "Desde hoy recibirás nuestras ultimas noticias y promociones ");
							}


							}).fail(function(){
								show_error_enid(".place_registro_contacto" , "Error cargar la galeria de imagenes.");		
							});
				}
			}
	}
	e.preventDefault();
}
/**/
function set_places(){
	var  place = [".place_mail_contacto" , ".place_tel_contacto"];
	for(var x in place){
		$(place[x]).empty();
	}
}
/**/
function showonehideone( elementomostrar , elementoocultar  ){
	$(elementomostrar).show();
	$(elementoocultar).hide();
}
/**/	
function selecciona_select(class_select , valor_a_seleccionar){
	$( class_select +' > option[value="'+ valor_a_seleccionar +'"]').attr('selected', 'selected');				
}
function metricas_perfil(){
	
	if (in_session ==  1) {
		url =  "../q/index.php/api/productividad/notificaciones/format/json/";	
		data_send = {id_usuario : $(".id_usuario").val() };
		$.ajax({
			url : url , 
			data : data_send, 		
			type : "GET", 
			beforeSend :  function(){}		
		}).done(function(data){		
			
			/**/
  			llenaelementoHTML(".num_tareas_dia_pendientes_usr" , data.num_tareas_pendientes);
			llenaelementoHTML(".place_notificaciones_usuario" , data.lista_pendientes);
			num_pendientes =  data.num_tareas_pendientes_text;  
			/**/
			$(document).on('visibilitychange', function() {
				notifica_usuario_pendientes(num_pendientes);	
			});
				

			ventas_pendientes=  $(".ventas_pendientes").attr("id");  
			ventas_pendientes =  parseInt(ventas_pendientes);
			if(ventas_pendientes > 0 ){
				llenaelementoHTML(".num_ventas_pendientes_dia" , "<span class='alerta_notificacion_fail' >"+ ventas_pendientes+"</span>");
			}
			/**/
			num_tareas_pendientes =  data.num_tareas_pendientes_text;
			num_tareas_pendientes =  parseInt(num_tareas_pendientes );
			if (num_tareas_pendientes > 1) {
				llenaelementoHTML(".tareas_pendientes_productividad" , "<span class='alerta_notificacion_fail' >"+ num_tareas_pendientes +"</span>");	
			}			
			deuda_cliente = $(".saldo_pendiente_notificacion").attr("deuda_cliente");
			$(".place_num_pagos_por_realizar").empty();
			if (parseInt(deuda_cliente)>0){
				llenaelementoHTML(".place_num_pagos_por_realizar" , "<span class='notificacion_enid'>"+deuda_cliente+"MXN</span>");
			}
		}).fail(function(){				
			show_error_enid(".place_notificaciones_usuario"  , "Error al cargar la sección de artistas"); 		
		});	
	}
}
/**/
function notifica_usuario_pendientes(num_pendientes){
	if(document.visibilityState == 'hidden'){
		if (num_pendientes > 0 ){			
			set_flag_activa_notificaciones(1);
			rotulo_title();			
		}
			        
	}else {
		set_flag_activa_notificaciones(0);
		set_titulo_web($(".titulo_web").val());					
	}
}
/**/
function rotulo_title(){
	
	if (get_flag_activa_notificaciones() == 1 ) {

		if (flag_titulo_web == 0 ) {
			nuevo_titulo =  " Tienes " + num_pendientes +" pendientes!"; 
			set_titulo_web(nuevo_titulo);
			flag_titulo_web ++; 
		}else{
			
			nuevo_titulo =  "Hola tienes " + num_pendientes +" tareas pendientes!"; 
			set_titulo_web(nuevo_titulo);
			flag_titulo_web =0; 
		}
		espera =  3000;	
	    setTimeout("rotulo_title()",espera);   
    }
}
/**/
function get_titulo_web(){
	return titulo_web;
}
/**/
function set_titulo_web(n_titulo_web){
	titulo_web =  n_titulo_web;
	document.title = titulo_web; 	
}
/**/
function set_flag_activa_notificaciones(n_flag_activa_notificaciones){
	flag_activa_notificaciones =  n_flag_activa_notificaciones;
}
/**/
function get_flag_activa_notificaciones(){
	return flag_activa_notificaciones;
}
/**/
/**/
function registra_respuesta_pregunta(e){

	url =  "../portafolio/index.php/api/tickets/respuesta/format/json/";	
	data_send =  $(".form_respuesta_ticket").serialize();				
	seccion =".seccion_respuesta_"+get_tarea();

	$.ajax({
			url : url , 
			type: "POST",
			data: data_send, 
			beforeSend: function(){
				show_load_enid(seccion , "Cargando ... ", 1 );
			}
	}).done(function(data){							
		
		llenaelementoHTML(seccion , "Comentario enviado!");		
		/**/
	}).fail(function(){			
		//show_error_enid(".place_proyectos" , "Error ... ");
	});			
	e.preventDefault();
}
/**/
/**/
function get_tarea(){
	return tarea;
}
/**/
function set_tarea(n_tarea){
	tarea = n_tarea; 
}
/**/
function quitar_espacios_numericos(nuevo_valor){
	/**/
	valor_numerico  ="";

		for(var a = 0; a < nuevo_valor.length; a++){		
			if(nuevo_valor[a] != " "){
				
				is_num=  validar_si_numero(nuevo_valor[a]);
				if (is_num ==  true) {
					if (a< 14) {
						valor_numerico += nuevo_valor[a]; 		
					}
				}
				
			}
		}
	return valor_numerico;	
}
/**/
function quita_espacios_input(){		

	valor = $(".telefono_info_contacto").val();
	nuevo =  quitar_espacios_numericos(valor);
	$(".telefono_info_contacto").val(nuevo);	
	/**/	
}
function quita_espacios(input){		

	valor = $(input).val();
	/**/
	nuevo =  quitar_espacios_numericos(valor);
	$(input).val(nuevo);	
	/**/	
}
/**/
function quita_espacios_input_precio(){		

	valor = $(".precio").val();
	/**/
	nuevo =  quitar_espacios_numericos(valor);
	$(".precio").val(nuevo);	
	/**/	
}

/**/
function validar_si_numero(numero){
   if (!/^([0-9])*$/.test(numero)){
   		return  false;
   }else{
   		return  true;
   }
    
}
/**/
function quita_espacios_en_input_num(){

	valor = $(this).val();
	nuevo =  quitar_espacios_numericos(valor);
	$(this).val(nuevo);	
}
/**/
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).text() 
}
/**/
function ordena_table_general(){

	var table = $(this).parents('table').eq(0)
	var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
	this.asc = !this.asc
	if (!this.asc){rows = rows.reverse()}
	for (var i = 0; i < rows.length; i++){table.append(rows[i])}
}
/**/
function  muestra_campos_adicionales_lead(){
	$(".parte_oculta_lead").show();	
}
/**/
function muestra_cargando_proceso_enid(){
	if($(".procesando_solicutud_enid_service").is(":visible")) {
		
		$(".procesando_solicutud_enid_service").hide();
	}else{
		$(".procesando_solicutud_enid_service").show();
	}	
}
/**/
function asigna_imagen_preview_user(id_usuario){

	usuario_ =  "#usuario_" + id_usuario;
	$(usuario_).attr( "src",  "../img_tema/user/user.png");
}
/**/
function minusculas(e){
    e.value = e.value.toLowerCase();
}
/**/
function set_option(key , value ){
	option[key] =  value;
}
/**/
function get_option(key){
	return option[key];
}
/*Bloque todos los elementos del formulario*/
function bloquea_form(form){
	$("*", form).prop('disabled',true);
}
/**/
function desbloqueda_form(form){
	$("*", form).prop('disabled',false);
}
/**/
function transforma_mayusculas(x){
	
	var text =  x.value; 
	text.trim();
	text_mayusculas =  text.toUpperCase();  	
	x.value =  text_mayusculas;
}
/****/
function valida_menu_superior(){
	width_dispositivo =  $(window).width();
	if (width_dispositivo< 800){
		$(".contenedor_busqueda_global_enid_service").hide();
		$(".boton_vender_global").hide();
	}
}
/**/
function openNav() {
    document.getElementById("mySidenav").style.width = "70%";    
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.body.style.backgroundColor = "rgba(0,0,0,0)";
}
/**/
function reset_form(id){
	document.getElementById(id).reset();	
}