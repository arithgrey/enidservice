"use strict";
let titulo_web = "";
let flag_titulo_web = 0;
let tarea = 0;
let tipo_negocio = 0;
let option = [];
$("footer").ready(() => {

    set_option({
        "in_session": get_parameter(".in_session"),
        "is_mobile": get_parameter(".is_mobile"),
        "disparador_buscados": 0,
    });

    $("#form_contacto").submit(envia_comentario);
    $(".menu_notificaciones_progreso_dia").click(metricas_perfil);
    metricas_perfil();
    set_titulo_web(get_parameter(".titulo_web"));
    $(".precio").keyup(quita_espacios_input_precio);


    if ($(".input_busqueda_producto").length) {

        let $busqueda_producto = $(".input_busqueda_producto");
        $busqueda_producto.click(anima_busqueda);
        $busqueda_producto.blur(anima_busqueda);
        $busqueda_producto.keypress(valida_formato_search);
    }


    if ($(".telefono").length) {
        $telefono = $(".telefono");
        $telefono.keypress(valida_formato_telefono);
        $telefono.focus(valida_formato_telefono);
        $telefono.blur(valida_formato_telefono);
    }

    $(".validar_nombre").keypress(valida_formato_nombre);
    $(".correo").keypress(valida_formato_correo);


    if ($(".input_enid input")) {

        let input_enid = document.getElementsByClassName("input_enid_format");

        for (var i = 0; i < input_enid.length; i++) {

            let tag = input_enid[i].firstElementChild.tagName;
            if (tag == "INPUT") {
                if (input_enid[i].firstElementChild.value.length > 0) {
                    let next = input_enid[i].firstElementChild.nextElementSibling.className;
                    if (next.length > 1) {
                        let selector = '.input_enid_format .' + next;
                        $(selector).addClass('focused_input')
                    }
                }
            }
        }

    }

    if ($('.input_busqueda_inicio').length) {
        $('.input_busqueda_inicio').next('label').addClass('focused_input');
    }
    if ($('.input_busqueda_termino').length) {
        $('.input_busqueda_termino').next('label').addClass('focused_input');
    }


});
let set_option = (key, value = 0) => {


    if (isArray(key)) {

        for (var i = 0; i < key.length; i++) {
            let indice = key[i];
            i++;
            let valor = key[i];
            option[indice] = valor;
        }


    } else if (typeof key === 'string') {

        option[key] = value;

    } else {

        $.each(key, function (k, val) {
            option[k] = val;
        });
    }

};
let get_option = key => {

    return option[key];
};
let show_confirm = (text, text_complemento, text_continuar = 0, on_next = 0, on_cancel = 0) => {

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
let sload = place => {

    let bar = '<div class="progress progress-striped active page-progress-bar">';
    bar += '<div class="progress-bar" style="width: 100%;"></div> </div>';
    render_enid(place, bar);
};
let seccess_enid = (place, msj) => {

    $(place).show();
    render_enid(place, "<span class='response_ok_enid'>" + msj + "</span>");

    setTimeout(function () {
        $(place).fadeOut(1500);
    }, 1500);
};
let selecciona_valor_select = (opcion_a_seleccionar, posicion) => {

    $(opcion_a_seleccionar + " option[value='" + posicion + "']").attr("selected", true);

};
let val_text_form = (input, place_msj, len, nom) => {

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
};
let format_error = (place, str) => {

    render_enid(place, "<div class='col-lg-12 alerta_enid padding_5 top_10 bottom_10'>" + str + "</div>");

};
let valida_email_form = (input, place_msj) => {


    despliega([place_msj], 1);
    let valor_registrado = $(input).val();
    let mensaje_user = "";
    let flag = 1;
    if (valor_registrado.length < 8) {
        mensaje_user = "Correo electrónico demasiado corto";
        flag = 0;
    }
    if (!valEmail(valor_registrado)) {
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

};

let valida_tel_form = (input, place_msj) => {


    despliega([place_msj], 1);
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
};
let valEmail = valor => {

    let re = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/;
    return !re.exec(valor);

};

let mostrar_img_upload = (source, id_section) => {

    let list = document.getElementById(id_section);
    $.removeData(list);
    let li = document.createElement('li');
    let img = document.createElement('img');
    img.setAttribute('width', '100%');
    img.setAttribute('height', '100%');
    img.src = source;
    li.appendChild(img);
    list.appendChild(li);
};

let showonehideone = (show, hide) => {

    $(show).show();
    $(show).removeClass("d-none");
    $(hide).hide();
    $(hide).addClass("d-none");


};

let selecciona_select = (class_select, valor_a_seleccionar) => {

    $(class_select + ' > option[value="' + valor_a_seleccionar + '"]').attr('selected', 'selected');
};

let metricas_perfil = () => {


    if (get_option("in_session") == 1) {

        let url = "../q/index.php/api/productividad/notificaciones/format/json/";
        let data_send = {"id_usuario": get_parameter(".id_usuario")};
        request_enid("GET", data_send, url, response_metricas_perfil);
    }
};
let response_metricas_perfil = data => {

    render_enid(".num_tareas_dia_pendientes_usr", data.num_tareas_pendientes);
    render_enid(".place_notificaciones_usuario", data.lista_pendientes);
    let num_pendientes = data.num_tareas_pendientes_text;
    set_option("num_pendientes", num_pendientes);
    $(document).on('visibilitychange', function () {
        notifica_usuario_pendientes(num_pendientes);
    });

    let ventas_pendientes = $(".ventas_pendientes").attr("id");
    ventas_pendientes = parseInt(ventas_pendientes);
    if (ventas_pendientes > 0) {
        render_enid(".num_ventas_pendientes_dia", "<span class='alerta_notificacion_fail' >" + ventas_pendientes + "</span>");
    }

    let num_tareas_pendientes = data.num_tareas_pendientes_text;
    num_tareas_pendientes = parseInt(num_tareas_pendientes);
    if (num_tareas_pendientes > 1) {
        render_enid(".tareas_pendientes_productividad", "<span class='alerta_notificacion_fail' >" + num_tareas_pendientes + "</span>");
    }
    let deuda_cliente = $(".saldo_pendiente_notificacion").attr("deuda_cliente");
    $(".place_num_pagos_por_realizar").empty();
    if (parseInt(deuda_cliente) > 0) {
        render_enid(".place_num_pagos_por_realizar", "<span class='notificacion_enid'>" + deuda_cliente + "MXN</span>");
    }
};

let notifica_usuario_pendientes = num_pendientes => {

    if (document.visibilityState == 'hidden') {
        if (num_pendientes > 0) {

            set_option("flag_activa_notificaciones", 1);
            rotulo_title();
        }
    } else {

        set_option("flag_activa_notificaciones", 0);
        set_titulo_web(get_parameter(".titulo_web"));
    }
};
let rotulo_title = () => {

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
};

let set_titulo_web = str => {

    let titulo_web = str;
    set_option("titulo_web", str);
    document.title = titulo_web;
};
let registra_respuesta_pregunta = e => {

    let url = "../q/index.php/api/respuesta/index/format/json/";
    let data_send = $(".form_respuesta_ticket").serialize();
    let seccion = ".seccion_respuesta_" + get_option("tarea");
    set_option("seccion", seccion);
    request_enid("POST", data_send, url, carga_comentarios_terea_simple);
    e.preventDefault();
};
let quitar_espacios_numericos = (nuevo_valor, texto = 0) => {

    if (texto == 0) {
        let valor_numerico = "";
        for (let a = 0; a < nuevo_valor.length; a++) {
            if (nuevo_valor[a] != " ") {

                if (validar_si_numero(nuevo_valor[a]) == true) {
                    valor_numerico += nuevo_valor[a];
                }
            }
        }
        return valor_numerico;
    } else {

        let valor_numerico = "";
        for (let a = 0; a < nuevo_valor.length; a++) {
            if (nuevo_valor[a] != " ") {

                valor_numerico += nuevo_valor[a];
            }
        }
        return valor_numerico;
    }

};
let sin_espacios = (input, es_correo = 0) => {

    let valor = get_parameter(input);
    let nuevo = quitar_espacios_numericos(valor, 1);
    set_parameter(input, nuevo);
    if (es_correo > 0) {
        set_parameter(input, nuevo.toLocaleLowerCase());
        valida_email_form(input, "");
    }

};
let quita_espacios_input = () => {

    let valor = get_parameter(".telefono_info_contacto");
    let nuevo = quitar_espacios_numericos(valor);
    $(".telefono_info_contacto").val(nuevo);

};

let quita_espacios = input => {

    let valor = get_parameter(input);
    let nuevo = quitar_espacios_numericos(valor);
    $(input).val(nuevo);

};

let quita_espacios_input_precio = () => {

    let valor = get_parameter(".precio");
    let nuevo = quitar_espacios_numericos(valor);
    set_parameter(".precio", nuevo);

};

let comparer = index => {

    return function (a, b) {
        let valA = getCellValue(a, index), valB = getCellValue(b, index);
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
    }
};

let getCellValue = (row, index) => {

    return $(row).children('td').eq(index).text()

};
let ordena_tabla = function () {

    let table = $(this).parents('table').eq(0);
    let rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
    this.asc = !this.asc;
    if (!this.asc) {
        rows = rows.reverse()
    }
    for (let i = 0; i < rows.length; i++) {
        table.append(rows[i])
    }
};


let openNav = () => {

    document.getElementById("mySidenav").style.width = "100%";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";

};

let closeNav = () => {
    document.getElementById("mySidenav").style.width = "0";
    document.body.style.backgroundColor = "rgba(0,0,0,0)";
};

let array_key_exists = (key, array) => {

    let response = 0;
    if (array.hasOwnProperty(key)) {
        let second_exists = (key in array);
        if (second_exists == true) {
            console.log("existe");
            response = 1;
        }
    }
    return response;

};

let getMaxOfArray = numArray => {

    return Math.max.apply(null, numArray);

};

let despliega = (array, tipo = 1) => {


    if (isArray(array)) {

        array.forEach(function (element) {

            if ($(element)) {

                if (tipo > 0) {
                    $(element).show();

                } else {
                    $(element).hide();
                }

            } else {
                console.log("NO EXISTE ->" + element);
            }

        });

    } else {


        if ($(array)) {

            if (tipo > 0) {
                $(array).show();

            } else {
                $(array).hide();
            }
        } else {
            console.log("NO EXISTE ->" + array);
        }
    }

};

/*SE ELIMINAN EL CONTENIDO LOS ELEMENTOS*/
let empty_elements = (array) => {

    if (isArray(array)) {

        array.forEach(function (element) {
            if ($(element)) {
                $(element).empty();
            }
        });
    } else {
        if ($(array)) {
            $(array).empty();
        }
    }
};

/*Regresa el valor que esta en el nodo html*/
let get_parameter_enid = (element, param) => {

    let val = element.attr(param);
    if (typeof val !== undefined) {

        return val;

    } else {

        console.log("No existe " + param + " el parametro en el nodo");
        return false;
    }
};
let request_enid = (method, data_send, url, call_back, place_before_send = 0, before_send = 0, place_render = "") => {

    if (before_send < 1) {
        if (place_before_send.length > 0) {
            var before_send = function () {
                sload(place_before_send, "", "");
            }
        } else {
            var before_send = function () {
            }
        }
    }
    if (call_back > 0) {
        var call_back = function (data) {
            render_enid(place_render, data);
            $('th').click(ordena_tabla);
        }
    }
    $.ajax({
        url: url,
        data: data_send,
        type: method,
        beforeSend: before_send
    }).done(call_back);
};

let set_black = array => {

    for (let x in array) {

        set_parameter(array[x], "");
    }
};
let focus_input = input => {

    let base = "1px solid rgb(13, 62, 86)";
    if (isArray(input)) {

        for (const i in input) {

            $(input[i]).css("border", base);

        }

    } else {

        $(input).css("border", base);
    }
};
let randomString = (len, charSet) => {
    charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let randomString = '';
    for (let i = 0; i < len; i++) {
        let randomPoz = Math.floor(Math.random() * charSet.length);
        randomString += charSet.substring(randomPoz, randomPoz + 1);
    }
    return randomString;
};
/*Recorre a sección*/
let recorre = contenedor => {

    if (typeof get_parameter(contenedor) !== 'undefined') {
        let simple = contenedor.substring(1, contenedor.length);
        let elementoIdW = document.getElementById(simple);
        let elementoClassW = document.getElementsByClassName(simple);
        if (elementoClassW != undefined || elementoClassW != null || elementoIdW != null || elementoIdW != undefined) {

            if ($(contenedor).val() != undefined) {
                let l = contenedor.length;
                if (l > 2) {
                    $('html, body').animate({scrollTop: $(contenedor).offset().top - 100}, 'slow');
                } else {
                    $('html, body').animate({scrollTop: $("#flipkart-navbar").offset().top - 100}, 'slow');
                }
            } else {
                console.log("NO EXISTE -> " + contenedor);
            }
        } else {
            console.log("NO EXISTE -> " + contenedor);
        }
    }


};

let transforma_mayusculas = x => {
    let text = x.value;
    text.trim();
    let text_mayusculas = text.toUpperCase();
    x.value = text_mayusculas;
};
let reload_imgs = (id, url, flag = 0) => {

    if (document.location.hostname != "localhost" && flag > 0) {

        if (document.getElementById(id).src != null || document.getElementById(id).src != undefined) {
            document.getElementById(id).src = url;
            console.log(url);
        }
    }
};

let show_error_enid = () => {

    let url = "../bug/index.php/api/reportes/reporte_sistema/format/json/";
    let URLactual = window.location;
    let data_send = {"descripcion": mensaje_error};
    let mensaje = "Se presentó error en " + URLactual + "  URLactual";
    console.log(mensaje);
    request_enid("POST", data_send, url, function () {

    });
};

let valida_num_form = (input, place_msj) => {

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
};
let advierte = text => {

    $(".text-order-name-error").text(text);
    $("#modal-error-message").modal("show");

};
let div_enid = (id_padre, text, clase = '') => {

    var newDiv = document.createElement("div");
    var newContent = document.createTextNode(text);


    if (clase.length > 0) {

        let arrClass = clase.split(" ");
        for (var x in arrClass) {
            newDiv.className += arrClass[x] + " ";
        }


    }

    newDiv.appendChild(newContent);
    document.getElementById(id_padre).innerHTML = newDiv.outerHTML;


};

let reset_form = id => document.getElementById(id).reset();

let termina_session = () => redirect('../login/index.php/startsession/logout/');

let quita_espacios_en_input_num = v => $(this).val(quitar_espacios_numericos(get_parameter(v)));

let desbloqueda_form = form => $("*", form).prop('disabled', false);

let flex = elemento => $(elemento).css("display", "flex");

let validar_si_numero = numero => (!/^([0-9])*$/.test(numero)) ? false : true;

let set_parameter = (element, valor) => $(element).val(valor);

let bloquea_form = form => $("*", form).prop('disabled', true);

let is_mobile = () => get_option("is_mobile");

let isArray = (param) => param instanceof Array || Object.prototype.toString.call(param) === '[object Array]';
let isJson = (str) => {

    try {

        return (typeof JSON.parse(str) === 'object');

    } catch (e) {
        return false;
    }
};

/*Regresa el valor que esta en el nodo html*/
let get_parameter = (element, parse_int = 0) => (parse_int < 1) ? $(element).val() : parseInt($(element).val());

let getObjkeys = param => Object.keys(param);

let render_enid = (idelement, data) => $(idelement).html(data);

let get_valor_selected = select => get_parameter(select + " option:selected");

let redirect = url => window.location.replace(url);

let get_attr = (e, elemento) => $(e).attr(elemento);

/*PASAR ESTA PORQUERÍA A DONDE DEBE*/
let response_mensaje_contacto = data => {

    seccess_enid(".place_registro_contacto", "<div class='contacto_enviado'> Gracias por enviarnos tu mensaje, pronto sabrás de nosotros. ! </div>");
    document.getElementById("form_contacto").reset();
};
let envia_comentario = e => {

    let url = $("#form_contacto").attr("action");
    let f = valida_email_form("#emp_email", ".place_mail_contacto");
    if (f == 1) {
        set_places();

        f = valida_tel_form("#tel", ".place_tel_contacto");
        if (f == 1) {
            set_places();
            recorre("#btn_envio_mensaje");
            let id_empresa = 1;
            let data_send = $("#form_contacto").serialize() + "&" + $.param({
                "empresa": id_empresa,
                "tipo": 2
            });
            request_enid("POST", data_send, url, response_mensaje_contacto, ".place_registro_contacto");
        }
    }
    e.preventDefault();
};


let set_places = () => {

    let place = [".place_mail_contacto", ".place_tel_contacto"];
    place.map(empty_elements);

};
/*AQUÍ TERMINAN LAS PORQUERIAS*/
let submit_enid = (form) => {

    $(form).submit();
};
let show_tabs = (str, tipo = 1) => {

    let type = (tipo > 0) ? "show" : "hide";
    if (isArray(str)) {

        str.forEach(function (element) {
            $(element).tab(type);
        });

    } else {

        $(type).tab(type);
    }

};

let rm_class = (arr_class, class_rm) => {


    if (isArray(arr_class)) {

        arr_class.forEach(function (element) {
            $(element).removeClass(class_rm);
        });

    } else {

        $(arr_class).removeClass(class_rm);
    }

};
let add_class = (arr_class, class_add) => {


    if (isArray(arr_class)) {

        arr_class.forEach(function (element) {
            $(element).addClass(class_add);
        });

    } else {

        $(arr_class).addClass(class_add);
    }

};

let append_enid = (array) => {

    return array.join(",");
};
let minusculas = function (e) {
    e.value = e.value.toLowerCase()
};

let go_login = (data) => redirect("../login");
let up_page = (data) => redirect("");
let anima_busqueda = function (e) {

    alert();
    if (get_option("disparador_buscados") < 1) {

        $(".busqueda_izquierda").removeClass("col-lg-5").addClass("col-lg-3");
        $(".busqueda_derecho").removeClass("col-lg-5").addClass("col-lg-7");
        set_option("disparador_buscados", 1);

    } else {

        $(".busqueda_izquierda").removeClass("col-lg-3").addClass("col-lg-5");
        $(".busqueda_derecho").removeClass("col-lg-7").addClass("col-lg-5");
        set_option("disparador_buscados", 0);
    }
};
let valida_formato_nombre = function (e) {
    if (!/^[A-Za-záéíóúñ ]*$/.test(String.fromCharCode(e.keyCode))) {
        e.preventDefault();
    }
};

let valida_formato_search = function (e) {
    if (!/^[A-Za-záéíóúñ0-9 ]*$/.test(String.fromCharCode(e.keyCode))) {
        e.preventDefault();
    }
};
let valida_formato_correo = function (e) {

    let c = String.fromCharCode(e.keyCode);
    let format = /^([A-z0-9@._])*$/.test(c);
    let fn = (!format) ? e.preventDefault() : '';

    let $text = $(this).val();
    let formatStart = ($text.length < 1 && /^([@._])*$/.test(c)) ? e.preventDefault() : '';
    if (/^([@])*$/.test(c)) {
        let times = ($text.match(/@/g) || []).length;
        const formatTimes = (times > 0) ? e.preventDefault() : '';
    }

};
let valida_formato_telefono = function (e) {

    this.value = quitar_espacios_numericos(this.value);
    if (!/^([0-9])*$/.test(String.fromCharCode(e.keyCode))) {
        e.preventDefault();
    }
};

let paste_telefono = function () {

    event.preventDefault();
    if (event.clipboardData) {
        let str = event.clipboardData.getData("text/plain");
        event.target.value = quitar_espacios_numericos(str.trim());
    }
};
let paste_email = function () {

    event.preventDefault();
    if (event.clipboardData) {
        let str = event.clipboardData.getData("text/plain");
        let text = '';
        for (let x in str) {

            let format = /^([A-z0-9@._])*$/.test(str[x]);
            text += (!format) ? '' : str[x];

        }
        event.target.value = text;
    }
};
let paste_nombre = function () {

    event.preventDefault();
    if (event.clipboardData) {
        let str = event.clipboardData.getData("text/plain");
        let text = '';
        for (let x in str) {
            let format = /^[A-Za-záéíóúñ ]*$/.test(str[x]);
            text += (!format) ? '' : str[x];
        }
        event.target.value = text;
    }
};
let paste_search = function () {

    event.preventDefault();
    if (event.clipboardData) {
        let str = event.clipboardData.getData("text/plain");
        let text = '';
        for (let x in str) {

            let format = /^([A-z0-9ñ])*$/.test(str[x]);
            text += (!format) ? '' : str[x];

        }
        event.target.value = text;
    }
};





