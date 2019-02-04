"use strict";
let titulo_web = "";
let flag_titulo_web = 0;
let tarea = 0;
let tipo_negocio = 0;
let option = [];
$("footer").ready(function () {


    let in_session = get_parameter(".in_session");
    set_option("in_session", in_session);
    set_option("is_mobile", get_parameter(".es_movil"));
    $("#form_contacto").submit(envia_comentario);
    $(".menu_notificaciones_progreso_dia").click(metricas_perfil);
    metricas_perfil();
    set_titulo_web(get_parameter(".titulo_web"));
    $(".telefono_info_contacto").keyup(quita_espacios_input);
    $(".precio").keyup(quita_espacios_input_precio);


});
let  set_option =  function(key, value) {
    option[key] = value;
}
let get_option = function(key) {
    return option[key];
}

let show_confirm = function (text, text_complemento, text_continuar = 0, on_next = 0, on_cancel = 0) {

    if (on_next == 0) {
        on_next = function () {
        }
    }
    if (on_cancel == 0) {
        on_cancel = function () {
        }
    }
    if (text_continuar == 0) {
        text_continuar = "CONTINUAR Y MODIFICAR";
    }
    $.confirm({
        title: text,
        content: text_complemento,
        type: 'green',
        buttons: {
            ok: {
                text: text_continuar,
                btnClass: 'btn-primary',
                keys: ['enter'],
                action: on_next
            },
            cancel: on_cancel
        }
    });
};
let show_load_enid = function (place) {

    let bar = "Cargando ... ";
    bar += '<div class="progress progress-striped active page-progress-bar">';
    bar += '<div class="progress-bar" style="width: 100%;"></div> </div>';
    llenaelementoHTML(place, bar);
}
let show_response_ok_enid = function (place, msj) {

    $(place).show();
    llenaelementoHTML(place, "<span class='response_ok_enid'>" + msj + "</span>");

    setTimeout(function () {
        $(place).fadeOut(1500);
    }, 1500);
}
let selecciona_valor_select = function (opcion_a_seleccionar, posicion) {

    $(opcion_a_seleccionar + " option[value='" + posicion + "']").attr("selected", true);

}
let valida_text_form = function (input, place_msj, len, nom) {

    $(place_msj).show();
    let valor_registrado = $.trim(get_parameter(input));
    let mensaje_user = "";
    let flag = 1;
    if (valor_registrado.length < len) {
        mensaje_user = nom + " demasiado corto ";
        flag = 0;
    }
    /*Lanzamos mensaje y si es necesario mostramos border*/
    if (flag == 0) {
        $(input).css("border", "1px solid rgb(13, 62, 86)");
        flag = 0;
    }
    format_error(place_msj, mensaje_user);
    if (flag == 1) {
        $(place_msj).empty();

    }
    return flag;
}
let format_error = function (place_msj, msj) {

    llenaelementoHTML(place_msj, "<div class='col-lg-12 alerta_enid padding_5 top_10 bottom_10'>" + msj + "</div>");
}
let valida_email_form = function (input, place_msj) {

    display_elements([place_msj], 1);
    let valor_registrado = $(input).val();
    let mensaje_user = "";
    let flag = 1;
    if (valor_registrado.length < 8) {
        mensaje_user = "Correo electrónico demasiado corto";
        flag = 0;
    }
    if (valEmail(valor_registrado) == false) {
        mensaje_user = "Registre correo electrónico correcto";
        flag = 0;
    }
    let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    if (emailRegex.test(valor_registrado)) {
        flag = 1;
    } else {
        mensaje_user = "Registre correo electrónico correcto";
        flag = 0;
    }
    /*Lanzamos mensaje y si es necesario mostramos border*/
    if (flag == 0) {
        $(input).css("border", "1px solid rgb(13, 62, 86)");
    }

    format_error(place_msj, mensaje_user);
    return flag;
}
let valida_tel_form = function (input, place_msj) {

    display_elements([place_msj], 1);
    let valor_registrado = get_parameter(input);
    let mensaje_user = "";
    let flag = 1;
    if (valor_registrado.length < 8) {
        mensaje_user = "Número telefónico demasiado corto";
        flag = 0;
    }
    if (valor_registrado.length > 13) {
        mensaje_user = "Número telefónico demasiado largo";
        flag = 0;
    }
    if (isNaN(valor_registrado)) {
        mensaje_user = "Registre solo números telefónicos";
        flag = 0;
    }
    if (flag == 0) {
        $(input).css("border", "1px solid rgb(13, 62, 86)");
    }

    format_error(place_msj, mensaje_user);
    return flag;
}
let valEmail = function (valor) {

    let re = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/;
    let v = (!re.exec(valor)) ? false : true;
    return v;
}

function mostrar_img_upload(source, id_section) {

    let list = document.getElementById(id_section);
    $.removeData(list);
    let li = document.createElement('li');
    let img = document.createElement('img');
    img.setAttribute('width', '100%');
    img.setAttribute('height', '100%');
    img.src = source;
    li.appendChild(img);
    list.appendChild(li);
}

function response_mensaje_contacto(data) {

    show_response_ok_enid(".place_registro_contacto", "<div class='contacto_enviado'> Gracias por enviarnos tu mensaje, pronto sabrás de nosotros. ! </div>");
    document.getElementById("form_contacto").reset();
}

function set_places() {
    let place = [".place_mail_contacto", ".place_tel_contacto"];
    for (let x in place) {
        $(place[x]).empty();
    }
}

function showonehideone(elementomostrar, elementoocultar) {
    $(elementomostrar).show();
    $(elementoocultar).hide();
}

function selecciona_select(class_select, valor_a_seleccionar) {
    $(class_select + ' > option[value="' + valor_a_seleccionar + '"]').attr('selected', 'selected');
}

let metricas_perfil = function () {

    if (get_option("in_session") == 1) {

        let url = "../q/index.php/api/productividad/notificaciones/format/json/";
        let data_send = {"id_usuario": get_parameter(".id_usuario")};
        request_enid("GET", data_send, url, response_metricas_perfil);
    }
}

function response_metricas_perfil(data) {

    llenaelementoHTML(".num_tareas_dia_pendientes_usr", data.num_tareas_pendientes);
    llenaelementoHTML(".place_notificaciones_usuario", data.lista_pendientes);
    let num_pendientes = data.num_tareas_pendientes_text;
    set_option("num_pendientes", num_pendientes);
    $(document).on('visibilitychange', function () {
        notifica_usuario_pendientes(num_pendientes);
    });

    let ventas_pendientes = $(".ventas_pendientes").attr("id");
    ventas_pendientes = parseInt(ventas_pendientes);
    if (ventas_pendientes > 0) {
        llenaelementoHTML(".num_ventas_pendientes_dia", "<span class='alerta_notificacion_fail' >" + ventas_pendientes + "</span>");
    }

    let num_tareas_pendientes = data.num_tareas_pendientes_text;
    num_tareas_pendientes = parseInt(num_tareas_pendientes);
    if (num_tareas_pendientes > 1) {
        llenaelementoHTML(".tareas_pendientes_productividad", "<span class='alerta_notificacion_fail' >" + num_tareas_pendientes + "</span>");
    }
    let deuda_cliente = $(".saldo_pendiente_notificacion").attr("deuda_cliente");
    $(".place_num_pagos_por_realizar").empty();
    if (parseInt(deuda_cliente) > 0) {
        llenaelementoHTML(".place_num_pagos_por_realizar", "<span class='notificacion_enid'>" + deuda_cliente + "MXN</span>");
    }
}
let termina_session = function(){
    redirect('../login/index.php/startsession/logout/');
};
let  notifica_usuario_pendientes = function(num_pendientes) {
    if (document.visibilityState == 'hidden') {
        if (num_pendientes > 0) {

            set_option("flag_activa_notificaciones", 1);
            rotulo_title();
        }
    } else {

        set_option("flag_activa_notificaciones", 0);
        set_titulo_web(get_parameter(".titulo_web"));
    }
}

function rotulo_title() {

    let num_pendientes = get_option("num_pendientes");
    if (get_option("flag_activa_notificaciones") == 1) {
        if (flag_titulo_web == 0) {

            let nuevo_titulo = " Tienes " + num_pendientes + " pendientes!";
            set_titulo_web(nuevo_titulo);
            flag_titulo_web++;

        } else {
            let nuevo_titulo = "Hola tienes " + num_pendientes + " tareas pendientes!";
            set_titulo_web(nuevo_titulo);
            flag_titulo_web = 0;
        }
        let espera = 3000;
        setTimeout("rotulo_title()", espera);
    }
}

let set_titulo_web = function (n_titulo_web) {

    let titulo_web = n_titulo_web;
    set_option("titulo_web", n_titulo_web);
    document.title = titulo_web;
}
let registra_respuesta_pregunta = function (e) {

    let url = "../q/index.php/api/respuesta/index/format/json/";
    let data_send = $(".form_respuesta_ticket").serialize();
    let seccion = ".seccion_respuesta_" + get_option("tarea");
    set_option("seccion", seccion);
    request_enid("POST", data_send, url, carga_comentarios_terea_simple);
    e.preventDefault();
}

function quitar_espacios_numericos(nuevo_valor , texto = 0) {


    if(texto == 0){
        let valor_numerico = "";
        for (let a = 0; a < nuevo_valor.length; a++) {
            if (nuevo_valor[a] != " ") {

                let is_num = validar_si_numero(nuevo_valor[a]);
                if (is_num == true) {
                    if (a < 13) {
                        valor_numerico += nuevo_valor[a];
                    }
                }
            }
        }
        return valor_numerico;
    }else{

        let valor_numerico = "";
        for (let a = 0; a < nuevo_valor.length; a++) {
            if (nuevo_valor[a] != " ") {

                valor_numerico += nuevo_valor[a];
            }
        }
        return valor_numerico;
    }

}
let sin_espacios = function(input){

    let valor = get_parameter(input);
    let nuevo = quitar_espacios_numericos(valor , 1);
    set_parameter(input , nuevo);

}
let quita_espacios_input = function () {

    let valor = get_parameter(".telefono_info_contacto");
    let nuevo = quitar_espacios_numericos(valor);
    $(".telefono_info_contacto").val(nuevo);

}

let quita_espacios = function (input) {

    let valor = get_parameter(input);
    let nuevo = quitar_espacios_numericos(valor);
    $(input).val(nuevo);

}

function quita_espacios_input_precio() {

    let valor = get_parameter(".precio");
    let nuevo = quitar_espacios_numericos(valor);
    $(".precio").val(nuevo);

}

function validar_si_numero(numero) {

    return (!/^([0-9])*$/.test(numero)) ? false : true;
}

function quita_espacios_en_input_num(valor) {

    let nuevo = quitar_espacios_numericos(get_parameter(valor));
    $(this).val(nuevo);
}

function comparer(index) {
    return function (a, b) {
        let valA = getCellValue(a, index), valB = getCellValue(b, index);
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
    }
}

let getCellValue = function (row, index) {

    return $(row).children('td').eq(index).text()
}
let ordena_table_general = function () {

    let table = $(this).parents('table').eq(0);
    let rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
    this.asc = !this.asc;
    if (!this.asc) {
        rows = rows.reverse()
    }
    for (let i = 0; i < rows.length; i++) {
        table.append(rows[i])
    }
}

function minusculas(e) {
    e.value = e.value.toLowerCase();
}

function openNav() {
    document.getElementById("mySidenav").style.width = "70%";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.body.style.backgroundColor = "rgba(0,0,0,0)";
}

function reset_form(id) {
    document.getElementById(id).reset();
}

function array_key_exists(key, array) {

    let exists = array.hasOwnProperty(key);
    let second_exists = (key in array);
    if (exists == true && second_exists == true) {
        console.log("existe");
        return true;
    } else {
        return false;
    }
}

let isArray = function (param) {
    return Array.isArray(param);
}
let getObjkeys = function (param) {
    return Object.keys(param);
}

function getMaxOfArray(numArray) {
    return Math.max.apply(null, numArray);
}

function display_elements(array, tipo) {
    for (let x in array) {
        /*Cuando se muestra*/
        if (tipo == 1) {
            $(array[x]).css("display", "block");
        } else {
            /*Cuando se ocualtan*/
            $(array[x]).css("display", "none");
        }
    }
}

/*SE ELIMINAN EL CONTENIDO LOS ELEMENTOS*/
function empty_elements(array) {
    for (let x in array) {
        /*Cuando se muestra*/
        $(array[x]).empty();
    }
}
/*Regresa el valor que esta en el nodo html*/
let get_parameter_enid = function (element, param) {

    let val = element.attr(param);
    if (typeof val !== undefined) {
        return val;
    } else {
        console.log("No existe " + param + " el parametro en el nodo");
        return false;
    }
}
/*ingresa valor al input*/
function set_parameter(element, valor) {
    $(element).val(valor);
}

/*El dispositivo en el que se accede es telefono?*/
function is_mobile() {

    return get_option("is_mobile");
}

function llenaelementoHTML(idelement, data) {
    $(idelement).html(data);
}

function valorHTML(idelement, data) {
    $(idelement).val(data);
}

function redirect(url) {
    window.location.replace(url);
}

function showonehideone(elementomostrar, elementoocultar) {
    $(elementomostrar).show();
    $(elementoocultar).hide();
}

function get_attr(e, elemento) {
    return $(e).attr(elemento);
}

function request_enid(method, data_send, url, call_back, place_before_send = 0, before_send = 0, place_render = "") {
    if (before_send < 1) {
        if (place_before_send.length > 0) {
            let before_send = function () {
                show_load_enid(place_before_send, "", "");
            }
        } else {
            let before_send = function () {
            }
        }
    }
    if (call_back > 0) {
        var call_back = function (data) {
            llenaelementoHTML(place_render, data);
            $('th').click(ordena_table_general);
        }
    }
    $.ajax({
        url: url,
        data: data_send,
        type: method,
        beforeSend: before_send
    }).done(call_back);
}

function set_black(array) {
    for (let x in array) {
        set_parameter(array[x], "");
    }
}
let focus_input = function(input) {

    if (isArray(input)) {

        for (const i in input) {
            $(input[i]).css("border", "1px solid rgb(13, 62, 86)");
        }
    } else {
        $(input).css("border", "1px solid rgb(13, 62, 86)");
    }
};
/*Bloque todos los elementos del formulario*/
let bloquea_form = function (form) {

    $("*", form).prop('disabled', true);

};
let desbloqueda_form = function (form) {

    $("*", form).prop('disabled', false);

};
let flex = function (elemento) {

    $(elemento).css("display", "flex");
};
let get_valor_selected = function (select) {
    return get_parameter(select + " option:selected");
};

function randomString(len, charSet) {
    charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let randomString = '';
    for (let i = 0; i < len; i++) {
        let randomPoz = Math.floor(Math.random() * charSet.length);
        randomString += charSet.substring(randomPoz, randomPoz + 1);
    }
    return randomString;
}

/*Recorre a sección*/
let recorrepage = function (contenedor = 0) {

    if ($(contenedor).length > 2) {
        $('html, body').animate({scrollTop: $(contenedor).offset().top - 100}, 'slow');
    } else {
        $('html, body').animate({scrollTop: $("#flipkart-navbar").offset().top - 100}, 'slow');
    }
};
let transforma_mayusculas = function (x) {
    let text = x.value;
    text.trim();
    let text_mayusculas = text.toUpperCase();
    x.value = text_mayusculas;
};
let evita_basura = function () {

    let text = get_parameter(".input_busqueda_producto");
    text = text.replace(/["']/g, "");
    text = text.replace(/["?]/g, "");
    text = text.replace(/["=]/g, "");
    text = text.replace(/["|]/g, "");
    set_parameter(".input_busqueda_producto", text);
};
let reload_imgs = function (id, url) {

    if(document.location.hostname !=  "localhost"){
        document.getElementById(id).src = url;
        console.log(url);
    }
};
/*Regresa el valor que esta en el nodo html*/
let get_parameter = function (element) {
    let param = $(element).val();
    return param;
};
let reloload_img = function (id, url) {
    console.log(id);
    console.log(url);
    window.setInterval(reload_imgs(id, url), 40000);
};
let show_error_enid = function () {

    let url = "../bug/index.php/api/reportes/reporte_sistema/format/json/";
    let URLactual = window.location;
    let data_send = {"descripcion": mensaje_error};
    let mensaje = "Se presentó error en " + URLactual + "  URLactual";
    console.log(mensaje);
    request_enid("POST", data_send, url, function () {

    });
}
let envia_comentario = function (e) {

    let url = $("#form_contacto").attr("action");
    let f = valida_email_form("#emp_email", ".place_mail_contacto");
    if (f == 1) {
        set_places();

        f = valida_tel_form("#tel", ".place_tel_contacto");
        if (f == 1) {
            set_places();
            recorrepage("#btn_envio_mensaje");
            let id_empresa = 1;
            let data_send = $("#form_contacto").serialize() + "&" + $.param({"empresa": id_empresa, "tipo": 2});
            request_enid("POST", data_send, url, response_mensaje_contacto, ".place_registro_contacto");
        }
    }
    e.preventDefault();
}

let valida_num_form = function (input, place_msj) {

    $(place_msj).show();
    let valor_registrado = get_parameter(input);
    let mensaje_user = "";
    let f = 1;
    $(place_msj).empty();
    if (isNaN(valor_registrado)) {
        mensaje_user = "Registre sólo números ";
        f = 0;
    }

    if (f == 0) {
        $(input).css("border", "1px solid rgb(13, 62, 86)");
    }

    format_error(place_msj, mensaje_user);
    return f;
}
/*

let registra_lead = function (e) {

    let url = $(".form_enid_contacto").attr("action");
    let f = valida_email_form("#btn_cotizacion", ".place_mail_contacto");


    if (f == 1) {
        set_places();
        let flag = valida_text_form(".nombre_lead", ".place_nombre_lead", 5, "Nombre");
        if (flag == 1) {
            empty_elements([".place_nombre_lead"]);
            let flag = valida_text_form(".telefono_lead", ".place_telefono_lead", 5, "Teléfono");
            if (flag == 1) {
                $(".telefono_lead").empty();
                let data_send = $(".form_enid_contacto").serialize() + "&" + $.param({"empresa": 1});
                request_enid("POST", data_send, url, response_registro_lead, ".place_registro_contacto");
            }
        }
    }
    e.preventDefault();
}
function response_registro_lead(data) {
    empty_elements([".place_mail_contacto", ".place_registro_contacto"]);
    show_response_ok_enid(".place_registro_contacto", " Gracias por enviarnos tu mensaje, pronto sabrás de nosotros. !");
    document.getElementById("form_enid_contacto").reset();
    llenaelementoHTML(".place_registro_contacto", "Desde hoy recibirás nuestras ultimas noticias y promociones ");
}

function replace_val_text(input_val, label_place, valor, text) {
    llenaelementoHTML(label_place, text);
    valorHTML(input_val, valor);
    showonehideone(label_place, input_val);
}

function muestra_alert_segundos(seccion) {

    setTimeout(function () {
        $(seccion).fadeOut(1500);
    }, 1500);
}

function showhide(elementoenelquepasas, elementodinamico) {

    $(elementoenelquepasas).mouseover(function () {
        $(elementodinamico).show();
    }).mouseout(function () {
        $(elementodinamico).hide();
    });
}

function exporta_excel() {
    $("#datos_a_enviar").val($("<div>").append($("#print-section").eq(0).clone()).html());
    $("#FormularioExportacion").submit();
}

function reset_fields(fields) {
    for (let x in fields) {
        $(fields[x]).val("");
    }
}

function set_tarea(n_tarea) {
    let tarea = n_tarea;
}

function set_text_element(text_tag, texto) {
    $(text_tag).text(texto);
}

function muestra_campos_adicionales_lead() {
    $(".parte_oculta_lead").show();
}
function reset_checks(inputs) {
    for (let x in inputs) {
        document.getElementById(inputs[x]).checked = false;
    }
}
function valida_l_precio(input, l, place, mensaje_user) {

    let val = get_parameter(input);
    let val_length = val.length;
    let flag = 0;

    if (val_length <= l) {
        $(place).empty();
        return 1;
    } else {
        if (flag == 0) {
            $(input).css("border", "1px solid rgb(13, 62, 86)");
        }
        format_error(place, mensaje_user);
        return 0;
    }
}


function asigna_imagen_preview_user(id_usuario) {
    let usuario_ = "#usuario_" + id_usuario;
    $(usuario_).attr("src", "../img_tema/user/user.png");
}

function valida_url_form(place, input, msj) {

    let url = $.trim($(input).val());
    let RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    let response = (RegExp.test(url)) ? true : false;
    return response;
}

function  url_editar_user( url , text ){
	let url_next =  "<a href='"+url+"' style='color:white;'>"+ text+"<i class='fa fa-pencil-square-o'></i></a>";
	return  url_next;
}

function existeFecha2(fecha){
    let fechaf = fecha.split("-");
    let y = fechaf[0];
    let m = fechaf[1];
    let d = fechaf[2];
	return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
}
function validate_format_num_pass( input , place , num  ){

	let  valor_registrado 	=   get_parameter(input);
	let  text_registro 		=   $.trim(valor_registrado);
	let flag 				= 	0;
	if ( text_registro.length > num ) {
		flag =1;
	}
	let  mensaje_user =  "";
	if (flag == 0) {
		$(input).css("border" , "1px solid rgb(13, 62, 86)");
		flag  = 0;
		mensaje_user =  "Password demasiado corto";
	}
	format_error(place ,  mensaje_user);
	return flag;
}
*/