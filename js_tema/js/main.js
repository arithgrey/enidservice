var titulo_web = "";
var flag_titulo_web = 0;
var flag_activa_notificaciones = 0;
var tarea =0;
var flag_carga_preferencias =0;
var tipo_negocios_arr = [];
var tipo_negocio =0;
var option = [];
$("footer").ready(function(){

	var now 		= get_parameter(".now");
	var in_session 	= get_parameter(".in_session");		
	set_option("in_session" , in_session);
	set_option("is_mobile" , get_parameter(".es_movil") );
	$("#form_contacto").submit(envia_comentario);		
	$(".btn_enviar_email_prospecto").click(function(){
		$(".form_enid_contacto").submit();
	});
	$(".form_enid_contacto").submit(registra_lead);	
	$(".menu_notificaciones_progreso_dia").click(metricas_perfil);
	metricas_perfil();
	set_titulo_web(get_parameter(".titulo_web"));						
	$(".telefono_info_contacto").keyup(quita_espacios_input);
	$(".precio").keyup(quita_espacios_input_precio);	
	$(".correo_electrionico_lead").keyup(muestra_campos_adicionales_lead);
	$("footer").ready(valida_menu_superior);
	
});
/**/
function existeFecha2(fecha){
    var fechaf = fecha.split("-");
    var y = fechaf[0];
    var m = fechaf[1];
    var d = fechaf[2];   
	return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
}
/**/
function validate_format_num_pass( input , place , num  ){

	var  valor_registrado 	=   get_parameter(input);
	var  text_registro 		=   $.trim(valor_registrado);
	var flag 				= 	0;
	if ( text_registro.length > num ) {
		flag =1;
	}
	var  mensaje_user =  "";
	if (flag == 0) {
		$(input).css("border" , "1px solid rgb(13, 62, 86)");
		flag  = 0; 
		mensaje_user =  "Password demasiado corto"; 
	}	
	format_error(place ,  mensaje_user);
	return flag; 
}
/**/
function show_load_enid(place , texto , flag ){

	var bar = 	"<label>Cargando ... </label><br>";
	bar 	+=  '<div class="progress progress-striped active page-progress-bar">';
	bar 	+='<div class="progress-bar" style="width: 100%;"></div> </div>';       
	llenaelementoHTML(place , bar );
}
/**/
function show_response_ok_enid(place , msj ){

	$(place).show();
	llenaelementoHTML(place , "<span class='response_ok_enid'>" + msj + "</span>");
	muestra_alert_segundos(place);
}
/**/
function show_error_enid(){
	var  url 			=  "../bug/index.php/api/reportes/reporte_sistema/format/json/";
	var  URLactual 		= window.location;
	var  data_send 		= {"descripcion" :  mensaje_error };
	var  mensaje_error 	= "Se presentó error en " +URLactual + "  URLactual";
	request_enid( "POST",  data_send , url , function(){
		
	}); 	
}

/**/
function selecciona_valor_select(opcion_a_seleccionar ,  posicion){
	$(opcion_a_seleccionar+" option[value='"+posicion +"']").attr("selected", true);
}
/**/
function valida_text_form(input , place_msj , len , nom ){
		
	$(place_msj).show();
	var valor_registrado 	=   $.trim(get_parameter(input)); 	
	var mensaje_user 		=  	"";
	var flag = 1; 		
	if (valor_registrado.length < len ){
		mensaje_user =  nom + " demasiado corto "; 		
		flag = 0;  
	}	
	/*Lanzamos mensaje y si es necesario mostramos border*/
	if (flag == 0) {
		$(input).css("border" , "1px solid rgb(13, 62, 86)");
		flag  = 0; 
	}
	format_error(place_msj ,  mensaje_user);
	if (flag ==1 ) {
		$(place_msj).empty();

	}
	return flag; 
}
/**/
function valida_num_form(input , place_msj ){	

	$(place_msj).show();
	var  valor_registrado 	=   get_parameter(input);
	var  mensaje_user 		=  "";
	var  f 					= 1; 
	$(place_msj).empty();
	if ( isNaN(valor_registrado)){
		mensaje_user = "Registre sólo números "; 		
		f =0 ;  
	}	
	/*Lanzamos mensaje y si es necesario mostramos border*/
	if (f == 0) {$(input).css("border" , "1px solid rgb(13, 62, 86)");}
	format_error( place_msj, mensaje_user); 	
	return f; 
}
/**/
function format_error( place_msj, msj){
	llenaelementoHTML( place_msj ,  "<div class='row'><div class='col-lg-12 alerta_enid'>" + msj + "</div></div>");
}
/**/
function valida_url_form( place , input  ,  msj ){
	
	var url 		=  $.trim($(input).val());
	var RegExp 		= /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    var response 	=  (RegExp.test(url)) ? true : false;
    return response;
}	
/**/	
function valida_email_form(input ,  place_msj ){
	
	display_elements([place_msj] , 1  ); 
	var  valor_registrado 	=     $(input).val(); 
	var  mensaje_user 		=  "";
	var  flag = 1; 
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
	var  emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if (emailRegex.test(valor_registrado)) {
      flag =1;
    } else {
      mensaje_user =  "Registre correo electrónico correcto"; 		
      flag =0 ;  	
    }
	/*Lanzamos mensaje y si es necesario mostramos border*/
	if (flag == 0) {$(input).css("border" , "1px solid rgb(13, 62, 86)");}
	
	format_error(place_msj , mensaje_user );
	return flag; 
}	
/**/
function valida_tel_form(input ,  place_msj ){
	
	display_elements([place_msj] ,  1);
	var 	valor_registrado 	=  get_parameter(input);
	var  	mensaje_user 		=  "";
	var  	flag 				= 1; 
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
	
	format_error(place_msj ,  mensaje_user);
	return flag; 
}	
/**/
function valEmail(valor){
    var re 		=/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/
    var valor 	= (!re.exec(valor)) ? false  : true ; 
    return valor;
}
/**/
function valida_l_precio(input ,  l , place , mensaje_user ){

	var val 		=  	$(input).val();	
	var val_length  =  	val.length;
	var flag 		= 	0;
	
	if (val_length <=  l) {
		$(place).empty();
		return 1; 
	}else{
		if (flag == 0) {$(input).css("border" , "1px solid rgb(13, 62, 86)");}		
		format_error(place ,  mensaje_user);
		return 0;
	}
}
/**/
function show_section_dinamic_button(seccion){
	var  x =  ($(seccion).is(":visible")) ?  $(seccion).hide() :  $(seccion).show();	
}
/**/
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
/**/
function reset_checks(inputs){
  for(var x in inputs ){		
		document.getElementById(inputs[x]).checked = false;
	}
}
/**/
function muestra_alert_segundos(seccion){	
	setTimeout(function() {
        $(seccion).fadeOut(1500);
    }, 1500);
}
/*Para imagenes */
function mostrar_img_upload(source , id_section){
	
	var list 	= 	document.getElementById(id_section);
	$.removeData(list);
	li   		= document.createElement('li');
	img  		= document.createElement('img');
	img.setAttribute('width', '100%');
	img.setAttribute('height', '100%');        
	img.src 	= source;		
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
/**/
function envia_comentario(e){	
	
	var url =   $("#form_contacto").attr("action");
	var f 	= valida_email_form("#emp_email" , ".place_mail_contacto" ); 
		if (f ==  1 ) {
			set_places();

			f =  valida_tel_form("#tel" ,  ".place_tel_contacto" );
			if (f ==  1 ) {				
				set_places()
				recorrepage("#btn_envio_mensaje");
				var  id_empresa = 1;
				var  data_send =   $("#form_contacto").serialize()  + "&"+ $.param({"empresa" : id_empresa , "tipo" : 2 });
				request_enid( "POST",  data_send , url ,  response_mensaje_contacto , ".place_registro_contacto");					
			}
	}
	e.preventDefault();
}
/**/
function response_mensaje_contacto(data){

	show_response_ok_enid(".place_registro_contacto" , "<div class='contacto_enviado'> Gracias por enviarnos tu mensaje, pronto sabrás de nosotros. ! </div>");
	document.getElementById("form_contacto").reset();	
	//redirect("../");
}
/**/
function registra_lead(e){

	var  url 			=   $(".form_enid_contacto").attr("action");		
	var  f 				= valida_email_form("#btn_cotizacion" , ".place_mail_contacto" ); 
	var  tipo_prospecto = $("#tipo_prospecto").val();

		if (f ==  1 ) {
			set_places();
			var flag =  valida_text_form(".nombre_lead" , ".place_nombre_lead" , 5 , "Nombre" );
				if (flag==1) {
                    empty_elements([".place_nombre_lead"]);
					var flag =  valida_text_form(".telefono_lead" , ".place_telefono_lead"  , 5, "Teléfono" );					
					if (flag ==  1) {
							$(".telefono_lead").empty();
							var data_send =   $(".form_enid_contacto").serialize() + "&"+ $.param({"empresa" : 1 });
							request_enid( "POST",  data_send , url , response_registro_lead , ".place_registro_contacto");
				}
			}
	}
	e.preventDefault();
}
/**/
function  response_registro_lead(data){
    empty_elements([".place_mail_contacto" , ".place_registro_contacto"]);
    show_response_ok_enid(".place_registro_contacto" , " Gracias por enviarnos tu mensaje, pronto sabrás de nosotros. !");
    document.getElementById("form_enid_contacto").reset();
    llenaelementoHTML(".place_registro_contacto", "Desde hoy recibirás nuestras ultimas noticias y promociones ");
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
	
	if (get_option("in_session") ==  1) {
		var 	url 		=  "../q/index.php/api/productividad/notificaciones/format/json/";
		var  	data_send 	= {id_usuario : $(".id_usuario").val() };
		request_enid( "GET",  data_send , url , response_metricas_perfil);		
	}
}
/**/
function response_metricas_perfil(data){

	llenaelementoHTML(".num_tareas_dia_pendientes_usr" , data.num_tareas_pendientes);
	llenaelementoHTML(".place_notificaciones_usuario" , data.lista_pendientes);
	var  num_pendientes =  data.num_tareas_pendientes_text;  
	set_option("num_pendientes" , num_pendientes);		
	$(document).on('visibilitychange', function() {
		notifica_usuario_pendientes(num_pendientes);	
	});
				
	ventas_pendientes 		=  $(".ventas_pendientes").attr("id");  
	ventas_pendientes 		=  parseInt(ventas_pendientes);
	if(ventas_pendientes > 0 ){
		llenaelementoHTML(".num_ventas_pendientes_dia" , "<span class='alerta_notificacion_fail' >"+ ventas_pendientes+"</span>");
	}
			
	num_tareas_pendientes 	=  data.num_tareas_pendientes_text;
	num_tareas_pendientes 	=  parseInt(num_tareas_pendientes );
	if (num_tareas_pendientes > 1) {
		llenaelementoHTML(".tareas_pendientes_productividad" , "<span class='alerta_notificacion_fail' >"+ num_tareas_pendientes +"</span>");	
	}			
	deuda_cliente = $(".saldo_pendiente_notificacion").attr("deuda_cliente");
	$(".place_num_pagos_por_realizar").empty();
	if (parseInt(deuda_cliente)>0){
		llenaelementoHTML(".place_num_pagos_por_realizar" , "<span class='notificacion_enid'>"+deuda_cliente+"MXN</span>");
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
		set_titulo_web(get_parameter(".titulo_web"));					
	}
}
/**/
function rotulo_title(){

	var num_pendientes =  get_option("num_pendientes"); 
	if (get_flag_activa_notificaciones() == 1 ) {
		if (flag_titulo_web == 0 ) {

			var  nuevo_titulo =  " Tienes " + num_pendientes +" pendientes!"; 
			set_titulo_web(nuevo_titulo);
			flag_titulo_web ++; 

		}else{					
			var  nuevo_titulo =  "Hola tienes " + num_pendientes +" tareas pendientes!"; 
			set_titulo_web(nuevo_titulo);
			flag_titulo_web =0; 
		}
		var  espera =  3000;	
	    setTimeout("rotulo_title()",espera);   
    }
}
/**/
function set_titulo_web(n_titulo_web){
	var titulo_web =  n_titulo_web;
	set_option("titulo_web" , n_titulo_web);
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
function registra_respuesta_pregunta(e){
	var url 		=  "../portafolio/index.php/api/tickets/respuesta/format/json/";	
	var data_send 	=  $(".form_respuesta_ticket").serialize();				
	var seccion 	=".seccion_respuesta_"+get_tarea();
	request_enid( "POST",  data_send , url , function(){
		llenaelementoHTML(seccion , "Comentario enviado!");		
	} , seccion); 
	e.preventDefault();
}
/**/
function get_tarea(){
	return tarea;
}
/**/
function set_tarea(n_tarea){
	var  tarea = n_tarea; 
}
/**/
function quitar_espacios_numericos(nuevo_valor){
	/**/
	var valor_numerico  ="";
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
	var 	valor = 	get_parameter(".telefono_info_contacto");
	var  	nuevo =  	quitar_espacios_numericos(valor);
	$(".telefono_info_contacto").val(nuevo);	
	/**/	
}
function quita_espacios(input){		

	var valor =  get_parameter(input);	
	var nuevo =  quitar_espacios_numericos(valor);
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
   return  (!/^([0-9])*$/.test(numero)) ?  false :  true;     
}
/**/
function quita_espacios_en_input_num(valor){
	
	var nuevo 	=  quitar_espacios_numericos(get_parameter(valor));	
	$(this).val(nuevo);	
}
/**/
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
    }
}
function getCellValue(row, index){ 
	return $(row).children('td').eq(index).text() 
}
/**/
function ordena_table_general(){

	var table = $(this).parents('table').eq(0)
	var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
	this.asc = !this.asc
	if (!this.asc){rows = rows.reverse()}
	for (var i = 0; i < rows.length; i++){table.append(rows[i])}
}

function  muestra_campos_adicionales_lead(){
	$(".parte_oculta_lead").show();	
}
/**/
function asigna_imagen_preview_user(id_usuario){
	var usuario_ =  "#usuario_" + id_usuario;
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
		display_elements([".contenedor_busqueda_global_enid_service" ,  ".boton_vender_global"] ,  0);		
	}
}
/**/
function openNav() {
    document.getElementById("mySidenav").style.width = "70%";    
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}
/**/
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.body.style.backgroundColor = "rgba(0,0,0,0)";
}
/**/
function reset_form(id){
	document.getElementById(id).reset();	
}
/**/
function array_key_exists(key, array){
	
	var  exists 				=  	array.hasOwnProperty(key);
	var  second_exists			= 	(key in array);
	if (exists ==  true && second_exists ==  true ) {
		console.log("existe");
		return true;
	}else{
		return false;
	}
}
/**/
function isArray(param){
	return  Array.isArray(param); 
}
/**/
function getObjkeys(param){
	return 	Object.keys(param);		
}
/**/
function getMaxOfArray(numArray) {
  return Math.max.apply(null, numArray);
}
/**/
function display_elements(	array , tipo  ){
	for(var  x in array ){
		/*Cuando se muestra*/
		if (tipo ==  1) {
			$(array[x]).css("display" ,  "flex");
		}else{
		/*Cuando se ocualtan*/
			$(array[x]).css("display" ,  "none");
		}
	}
}
/*SE ELIMINAN EL CONTENIDO LOS ELEMENTOS*/
function empty_elements( array ){
	for(var  x in array ){
		/*Cuando se muestra*/
		$(array[x]).empty();
	}
}
/*Regresa el valor que esta en el nodo html*/
function get_parameter_enid(element , param){	 		
	var val = element.attr(param);
	if( typeof val !== undefined ) { 
		return val;
	}else{
		console.log("No existe "+param+" el parametro en el nodo");
		return false;
	}
}
/*Regresa el valor que esta en el nodo html*/
function get_parameter(element){	 		
	var param = $(element).val();
	return param;
}
/*ingresa valor al input*/
function set_parameter(element , valor ){	 		
	$(element).val(valor);	
}
/*Recorre a sección*/
function recorrepage(contenedor){		
	if( $(contenedor).length > 0 ) { 
		$('html, body').animate({scrollTop: $(contenedor).offset().top -100 }, 'slow');
	}
}
/*El dispositivo en el que se accede es telefono?*/
function is_mobile(){
	return get_option("is_mobile");	
}
/**/
function llenaelementoHTML(idelement , data ){	
	$(idelement).html(data);
} 
/**/
function valorHTML(idelement , data){
	$(idelement).val(data);
} 
/**/
function set_text_element(text_tag , texto ){
	$(text_tag).text(texto);
}
/**/
function redirect(url){
	window.location.replace(url);
}
/**/
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
function get_attr(e, elemento){
	return $(e).attr(elemento);
}
/**/
function request_enid( method,  data_send, url, call_back, place_before_send = 0, before_send = 0 , place_render ="" ){
	if (before_send ==  0) {
		if (place_before_send.length >  0){
			var  before_send 	= function(){show_load_enid(place_before_send , "" , "" );}  
		}else{
			var  before_send 	= function(){}  
		}
	}
	/**/
	if (call_back  == 1 ) {		
		var call_back  =  function(data){
			llenaelementoHTML(place_render , data );
		}
	}	
	/**/
	$.ajax({
		url : url , 
		data : data_send, 		
		type : method, 
		beforeSend :  before_send
	}).done(call_back);
}
/**/
function set_black(array){	
	for(var  x in array ){		
		set_parameter(array[x] , "");
	}
}