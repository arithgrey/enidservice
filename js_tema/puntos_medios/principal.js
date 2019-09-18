window.history.pushState({page: 1}, "", "");
window.history.pushState({page: 2}, "", "");
window.history.pushState({page: 3}, "", "");
window.history.pushState({page: 4}, "", "");
window.history.pushState({page: 5}, "", "");
window.onpopstate = function (event) {

    if (event) {

        valida_retorno();
    }
}

$(document).ready(() => {


    $(".botton_enviar_solicitud").click(()=>{


        despliega([".seccion_horarios_entrega"] , 0);
        despliega([".informacion_del_cliente"] ,1);
        add_class(".continuar", "mt-5");
        set_option("vista", 4);
    });


    $(".form_punto_encuentro").submit(registra_usuario);
    $(".form_punto_encuentro_horario").submit(notifica_punto_entrega);
    $(".link_acceso").click(set_link);

    $(".linea_metro").click(muestra_estaciones);
    set_option(["vista", 1, "punto_encuentro_previo", 0]);

    $("#nombre").focus(function () {
        $('#nombre').next('label').addClass('focused_input');
        $(this).addClass('input_focus');
    });
    $("#nombre").focusout(function () {
        if ($('#nombre').val() === '') {
            $('#nombre').next('label').removeClass('focused_input');
            $(this).removeClass('input_focus');
        }
    });

    $("#correo").focus(function () {
        $('#correo').next('label').addClass('focused_input');
        $(this).addClass('input_focus');
    });
    $("#correo").focusout(function () {
        if ($('#correo').val() === '') {
            $('#correo').next('label').removeClass('focused_input');
            $(this).removeClass('input_focus');
        }
    });


    $("#tel").focus(function () {
        $('#tel').next('label').addClass('focused_input');
        $(this).addClass('input_focus');
    });
    $("#tel").focusout(function () {
        if ($('#tel').val() === '') {
            $('#tel').next('label').removeClass('focused_input');
            $(this).removeClass('input_focus');
        }
    });

    $("#pw").focus(function () {
        $('#pw').next('label').addClass('focused_input');
        $(this).addClass('input_focus');
    });
    $("#pw").focusout(function () {
        if ($('#pw').val() === '') {
            $('#pw').next('label').removeClass('focused_input');
            $(this).removeClass('input_focus');
        }
    });


    $("#fecha").focus(function () {
        $('#fecha').next('label').addClass('focused_input');
        $(this).addClass('input_focus');

    });
    $("#fecha").focusout(function () {
        if ($('#fecha').val() === '') {
            $('#fecha').next('label').removeClass('focused_input');
            $(this).removeClass('input_focus');
        }
    });

    if(option["in_session"] < 1){

        if ($('#nombre').val().length > 0) {
            $('#nombre').next('label').addClass('focused_input');
        }
        if ($('#correo').val().length > 0) {
            $('#correo').next('label').addClass('focused_input');
        }
        if ($('#tel').val().length > 0) {
            $('#tel').next('label').addClass('focused_input');
        }
        if ($('#pw').val().length > 0) {
            $('#pw').next('label').addClass('focused_input');
        }


        despliega([".informacion_del_cliente",".seccion_horarios_entrega", ".desglose_estaciones", ".formulario_quien_recibe"], 0);
        rm_class(".desglose_estaciones", "d-lg-flex");
    }
    if ($('#fecha').val().length > 0) {
        $('#fecha').next('label').addClass('focused_input');
    }


    $(".form_punto_encuentro .nombre").keypress(valida_formato_nombre);
    $(".form_punto_encuentro .correo").keypress(valida_formato_correo);
    $(".telefono").keypress(valida_formato_telefono);




});
let muestra_estaciones = function () {

    let q = "";
    let contenedor = ".ksearch";
    if (typeof get_parameter(contenedor) !== undefined) {
        let simple = contenedor.substring(1, contenedor.length);
        let elementoIdW = document.getElementById(simple);
        let elementoClassW = document.getElementsByClassName(simple);
        if (elementoClassW != undefined || elementoClassW != null || elementoIdW != null || elementoIdW != undefined) {

            if ($(contenedor).val() !== undefined) {

                q = $(contenedor).val();
            }
        }
    }
    //rm_class(".seccion_lm", "bottom_100");

    let id = 0;
    let nombre_linea = "";
    if (get_option("id_linea") != undefined && get_option("id_linea") > 0) {

        id = get_option("id_linea");

    } else {

        id = get_parameter_enid($(this), "id");
        nombre_linea = get_parameter_enid($(this), "nombre_linea");
        set_option("nombre_linea", nombre_linea);
    }


    if (id > 0) {


        set_option("id_linea", id);
        if (get_parameter(".primer_registro") == 1) {

            let url = "../q/index.php/api/punto_encuentro/linea_metro/format/json/";
            let data_send = {
                "id": id,
                "v": 1,
                "servicio": get_parameter(".servicio"),
                "q": q
            };
            request_enid("GET", data_send, url, response_estaciones);

        } else {

            let url = "../q/index.php/api/punto_encuentro/linea_metro/format/json/";
            let data_send = {"id": id, "v": 2, "recibo": get_parameter(".recibo"), "q": q};
            request_enid("GET", data_send, url, response_estaciones);

        }

    }

};
let response_estaciones = (data) => {


    set_option("vista", 2);
    despliega([".place_lineas", ".contenedor_estaciones", ".text_seleccion_linea"],0);
    //despliega([".place_estaciones_metro",".ksearch", ".text_seleccion_estacion"],1);
    despliega([".seccion_horarios_entrega", ".desglose_estaciones", ".place_estaciones_metro", ".place_estaciones_metro", ".text_seleccion_estacion"], 1);
    add_class(".desglose_estaciones", "d-lg-flex");
    render_enid(".place_estaciones_metro", data);



    $(".punto_encuentro").click(muestra_horarios);
    $(".ksearch").keypress(function (e) {

        let code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {

            muestra_estaciones();
        }

    });


};
let muestra_horarios = function () {


    //despliega([".ksearch", ".titulo_punto_cercano"],0);
    let id = get_parameter_enid($(this), "id");

    if (id > 0) {
        set_option(["punto_encuentro_previo", id, "vista", 3, "id_punto_encuentro", id]);
        set_parameter(".punto_encuentro" , id);

        rm_class(".desglose_estaciones", "d-lg-flex");

        showonehideone(".formulario_quien_recibe", ".desglose_estaciones" );
    }

};

let registra_usuario = (e) => {

    let nombre = get_parameter(".form_punto_encuentro .nombre").length;
    let correo = get_parameter(".form_punto_encuentro .correo").length;
    let telefono = get_parameter(".form_punto_encuentro .telefono").length;
    let pwlength = get_parameter(".form_punto_encuentro .pw").length;

    if (nombre > 2 && correo > 5 && telefono > 7 && pwlength > 5) {


        let pw = get_parameter(".form_punto_encuentro #pw");
        let password = "" + CryptoJS.SHA1(pw);

        let data_send = $(".form_punto_encuentro").serialize() + "&" + $.param({
            "password": password,
            "id_servicio": get_parameter(".servicio")
        });
        let url = "../q/index.php/api/cobranza/primer_orden/format/json/";
        bloquea_form(".form_punto_encuentro");
        request_enid("POST", data_send, url, response_registro_usuario, ".place_notificacion_punto_encuentro_registro");


    } else {

        focus_inputs_form(nombre, correo, telefono, pwlength);

    }
    e.preventDefault();

}
let focus_inputs_form = (nombre, correo, telefono, pwlength) => {

    let clases = [".form_punto_encuentro .nombre", ".form_punto_encuentro .correo", ".form_punto_encuentro .telefono", ".form_punto_encuentro .pw"];
    for (var x in clases) {
        $(clases[x]).removeClass("focus_error");
    }

    if (nombre < 3) {
        $(".form_punto_encuentro .nombre").addClass("focus_error");
    }
    if (correo < 8) {

        $(".form_punto_encuentro .correo").addClass("focus_error");
    }
    if (telefono !=  8  ||  telefono !=  10) {

        $(".form_punto_encuentro .telefono").addClass("focus_error");
    }
    if (pwlength < 8) {

        $(".form_punto_encuentro .pw").addClass("focus_error");
    }

}
let response_registro_usuario = (data) => {


    if (data.usuario_existe > 0) {

        $(".text_usuario_registrado_pregunta").hide();
        despliega([".text_usuario_registrado"]);
        recorre(".text_usuario_registrado");

    } else {


        redirect("../area_cliente/?action=compras&ticket=" + data.id_recibo);
    }

};
let set_link = function () {

    let data_send = $.param({
        "id_servicio": get_parameter_enid($(this), "id_servicio"),
        "num_ciclos": get_parameter_enid($(this), "num_ciclos"),
        "punto_encuentro": get_option("punto_encuentro")
    });
    let url = "../login/index.php/api/sess/servicio/format/json/";
    request_enid("POST", data_send, url, go_login);

}

let notifica_punto_entrega = e => {


    let url = "../q/index.php/api/cobranza/solicitud_cambio_punto_entrega/format/json/";
    if (get_parameter(".primer_registro") > 0) {
        url = "../q/index.php/api/cobranza/solicitud_proceso_pago/format/json/";
    }
    let data_send = $(".form_punto_encuentro_horario").serialize() + "&" + $.param({"tipo_entrega": 1});
    bloquea_form(".form_punto_encuentro_horario");
    request_enid("POST", data_send, url, response_notificacion_punto_entrega, ".place_notificacion_punto_encuentro");
    e.preventDefault();
};
let response_notificacion_punto_entrega = (data) => {

    despliega([".place_notificacion_punto_encuentro", ".form_punto_encuentro_horario"], 0);
    let url = (get_parameter(".primer_registro") == 1) ?
        "../area_cliente/?action=compras&ticket=" + data.id_recibo :
        "../pedidos/?seguimiento=" + get_parameter(".recibo") + "&domicilio=1";

    redirect(url);

};
let agregar_nota = () => {

    recorre(".comentarios");
    showonehideone(".input_notas", ".text_agregar_nota");

}
let valida_retorno = function () {
    let v =  parseInt(get_option("vista"));

    switch (v) {
        case 1:

            break;
        case 2:

            despliega([".place_lineas", ".contenedor_estaciones", ".text_seleccion_linea"],1);
            despliega([".place_estaciones_metro", ".ksearch", ".text_seleccion_estacion"],0);
            break;
        case 3:

            set_option("vista", 2);
            add_class(".desglose_estaciones", "d-lg-flex");
            showonehideone(".contenedor_estaciones", ".formulario_quien_recibe");

            break;

        case 4:

            set_option("vista", 3);
            despliega([".seccion_horarios_entrega"] , 1);
            despliega([".informacion_del_cliente"] ,0);
            rm_class(".continuar", "mt-5");

            break;

        default:

            break;
    }
}

let horarios_disponibles = () => {

    let url = "../q/index.php/api/punto_encuentro/horario_disponible/format/json/";
    let data_send = {"dia": get_parameter(".fecha_entrega")};
    request_enid("GET", data_send, url, response_horario);

}
let response_horario = (data) => {

    if (!isArray(data)) {
        render_enid(".horario_entrega", data);
    }
}
