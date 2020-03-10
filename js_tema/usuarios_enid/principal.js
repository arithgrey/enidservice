"use strict";
let $nombre_recurso = $('#nombre_recurso');
let $link_recurso = $('#link_recurso');
let $form_recurso = $('.frm_recurso');
let $id_recurso = $('#id_recurso');
let $configurar_recurso = $('#configurar_recurso');
let $form = $('.form-miembro-enid-service');
let $nombre_usuario = $('.nombre_usuario');
let $input_nombre_registro = $form.find('.nombre');
let $input_apellido_paterno = $form.find('.apellido_paterno');
let $input_apellido_materno = $form.find('.apellido_materno');
let $input_email_registro = $form.find('.email');
let $input_telefono_registro = $form.find('.tel_contacto');

$(document).ready(function () {

    set_option("estado_usuario", 1);
    set_option("depto", 0);
    set_option("page", 1);
    $("footer").ready(carga_usuarios);
    $nombre_usuario.keypress(function (e) {

        let keycode = e.keyCode;
        if (keycode === 13) {
            carga_usuarios();
        }
    });
    $(".equipo_enid_service").click(carga_usuarios);
    $form.submit(actualizacion_usuario);
    $(".btn_nuevo_usuario").click(pre_nuevo_usuario);
    $(".form-miembro-enid-service .depto").change(get_puestos_por_cargo);
    $(".perfiles_permisos").click(carga_mapa_menu);
    $(".perfil_enid_service").change(carga_mapa_menu);
    $(".form_recurso").submit(registra_recurso);

    $(".tab_afiliados").click(function () {
        set_option("depto", 8);
        set_option("estado_usuario", 1);
        carga_usuarios();
    });
    $(".tab_equipo_enid_service").click(function () {
        set_option("page", 1);
        set_option("depto", 0);
        set_option("estado_usuario", 1);
        carga_usuarios();
    });
    $(".equipo_enid_service").click(function (e) {
        let estado_usuario = get_attr(this, "id");
        set_option("page", 1);
        set_option("depto", 0);
        set_option("estado_usuario", estado_usuario);
        carga_usuarios();
    });
    $(".form_categoria").submit(simula_envio_categoria);
    $(".form-tipo-talla").submit(carga_tipos_tallas);
    $("#agregar_tallas_menu").click(function () {
        $(".form-tipo-talla").submit();
    });

    $input_nombre_registro.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form);
    });
    $input_apellido_paterno.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form);
    });
    $input_apellido_materno.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form);
    });

    $input_email_registro.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form);
    });

    $input_telefono_registro.keyup(function (e) {
        $(this).next().next().addClass('d-none');
        escucha_submmit_selector(e, $form);
    });


});
let get_place_usuarios = () => {


    let nuevo_place = "";
    switch (parseFloat(get_option("depto"))) {
        case 0:
            nuevo_place = ".usuarios_enid_service";
            break;
        case 8:
            nuevo_place = ".usuarios_enid_service_afiliados";
            break;
        default:
    }
    return nuevo_place;
};
let carga_usuarios = () => {

    let place = get_place_usuarios();
    let $nombre_usuario = $('.nombre_usuario').val();
    let url = "../q/index.php/api/usuario/miembros_activos/format/json/";
    let data_send = {
            "status": get_option("estado_usuario"),
            "id_departamento": get_option("depto"),
            "page": get_option("page"),
            "q": $nombre_usuario,
        }
    ;
    request_enid("GET", data_send, url, response_carga_usuario);
};
let response_carga_usuario = (data) => {
    let place = get_place_usuarios();
    render_enid(place, data);
    $(".pagination > li > a, .pagination > li > span").click(function (e) {
        set_option("page", $(this).text());
        carga_usuarios();
        e.preventDefault();
    });
    $(".pagination > li > a, .pagination > li > span").css("color", "white");
    recorre(".tab-content");
    $(".usuario_enid_service").click(carga_data_usuario);
};
let pre_nuevo_usuario = () => {

    get_puestos_por_cargo();
    $(".email").removeAttr("readonly");
    set_option("flag_editar", 0);
    document.getElementById("form-miembro-enid-service").reset();
    $(".place_correo_incorrecto").empty();

};
let carga_data_usuario = (e) => {

    let id = e.target.id;
    if (parseInt(id) > 0) {
        document.getElementById("form-miembro-enid-service").reset();
        $(".place_correo_incorrecto").empty();
        recorre(".tab-content");
        set_option("flag_editar", 1);

        let url = "../q/index.php/api/usuario/miembro/format/json/";
        let data_send = {"id_usuario": id};
        request_enid("GET", data_send, url, response_carga_data_usuario);
    }

};
let response_carga_data_usuario = (data) => {

    $(".place_config_usuario").empty();
    data = data[0];
    let nombre = data.nombre;
    let apellido_paterno = data.apellido_paterno;
    let apellido_materno = data.apellido_materno;
    let email = data.email;
    let id_departamento = data.id_departamento;
    let inicio_labor = data.inicio_labor;
    let fin_labor = data.fin_labor;
    let turno = data.turno;
    let sexo = data.sexo;
    let status = data.status;
    let tel_contacto = data.tel_contacto;
    let id_perfil = data.idperfil;

    set_option("perfil", data.idperfil);
    set_option("id_usuario", data.idusuario);
    $form.find('.nombre').val(nombre);
    $form.find(".apellido_paterno").val(apellido_paterno);
    $form.find(".apellido_materno").val(apellido_materno);
    $form.find(".email").val(email);
    $form.find(".tel_contacto").val(tel_contacto);

    selecciona_select(".form-miembro-enid-service .perfil", id_perfil);
    selecciona_select(".form-miembro-enid-service .depto", id_departamento);
    selecciona_select(".form-miembro-enid-service .estado_usuario", status);
    selecciona_select(".estado_usuario", status);
    selecciona_select(".form-miembro-enid-service .inicio_labor", inicio_labor);
    selecciona_select(".form-miembro-enid-service .fin_labor", fin_labor);
    selecciona_select(".form-miembro-enid-service .turno", turno);
    selecciona_select(".form-miembro-enid-service .sexo", sexo);
    verifica_formato_default_inputs();

};
let get_puestos_por_cargo = () => {

    let url = "../q/index.php/api/perfiles/puesto_cargo/format/json/";
    let depto = $(".form-miembro-enid-service .depto").val();
    let data_send = {id_departamento: depto};
    request_enid("GET", data_send, url, response_puesto_por_cargo);
};
let response_puesto_por_cargo = (data) => {

    render_enid(".place_puestos", data);
    selecciona_select(".form-miembro-enid-service .puesto", get_option("perfil"));
};
let actualizacion_usuario = (e) => {

    let respuestas = [];
    respuestas.push(es_formato_nombre($input_nombre_registro));
    respuestas.push(es_formato_apellido($input_apellido_paterno));
    respuestas.push(es_formato_apellido($input_apellido_materno));
    respuestas.push(es_formato_telefono($input_telefono_registro));
    respuestas.push(es_formato_email($input_email_registro));
    let $es_formato = (!respuestas.includes(false));

    if ($es_formato) {

        let data_send = $form.serialize() + "&" + $.param({
            "id_usuario": get_option("id_usuario"),
            "editar": get_option("flag_editar")
        });
        let url = "../q/index.php/api/usuario/miembro/format/json/";
        bloquea_form('.form-miembro-enid-service');
        modal('Procesando...', 1);
        request_enid("POST", data_send, url, function (data) {
            redirect('');
        });
    }

    e.preventDefault();
};

let carga_mapa_menu = () => {

    let url = "../q/index.php/api/recurso/mapa_perfiles_permisos/format/json/";
    set_option("id_perfil", $(".perfil_enid_service").val());
    let data_send = {"id_perfil": get_option("id_perfil")};
    request_enid("GET", data_send, url, response_carga_mapa);

};
let response_carga_mapa = (data) => {
    render_enid(".place_perfilles_permisos", data);
    recorre(".tab-content");
    $(".perfil_recurso").click(modifica_accesos_usuario);
    $('.configurar_recurso').click(configurar_recurso);
    $('.baja_recurso').click(baja_recurso);

};
let configurar_recurso = function () {

    $configurar_recurso.show();
    let $selector = $(this);
    let id = $selector.attr('id');
    let path = $selector.attr('path');
    let nombre_recurso = $selector.attr('nombre_recurso');
    $nombre_recurso.val(nombre_recurso);
    $link_recurso.val(path);
    $id_recurso.val(id);

    verifica_formato_default_inputs();
    $form_recurso.submit(recurso);

}
let recurso = function (e) {

    e.preventDefault();
    let data_send = $form_recurso.serialize();
    let url = "../q/index.php/api/recurso/index/format/json/";
    request_enid("PUT", data_send, url, response_recurso);


}
let response_recurso = function () {
    $configurar_recurso.hide();
    show_tabs('#tab_perfiles_permisos', 1);

}
let modifica_accesos_usuario = function (e) {

    set_option("id_recurso", get_parameter_enid($(this), "id"));
    let url = "../q/index.php/api/perfil_recurso/permiso/format/json/";
    let data_send = {
        "id_perfil": get_option("id_perfil"),
        "id_recurso": get_option("id_recurso")
    };
    request_enid("PUT", data_send, url, carga_mapa_menu);
};
let registra_recurso = (e) => {
    let data_send = $(".form_recurso").serialize();
    let url = "../q/index.php/api/recurso/index/format/json/";
    request_enid("POST", data_send, url, response_registro_recurso);
    e.preventDefault();
};
let response_registro_recurso = (data) => {

    $(".place_recurso").empty();
    document.getElementById("form_recurso").reset();
    $("#tab_productividad").tab("show");
    $("#tab_perfiles").tab("show");
    carga_mapa_menu();
};
let baja_recurso = function (e) {

    let id = get_parameter_enid($(this), 'id');
    set_option('id', id);
    show_confirm('¿DESEAS DAR DE BAJA ESTE RECURSO?', 'Se eliminará este menú para todos los usuarios', 0, baja);
};
let baja = function () {

    let id = get_option('id');
    if (parseInt(id) > 0) {

        let data_send = $.param({'id': id});
        let url = "../q/index.php/api/recurso/index/format/json/";
        request_enid("DELETE", data_send, url, response_registro_recurso);
    }
};