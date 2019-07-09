"use strict";
let carga_buzon = () => {

    $(".contenedor_opciones_buzon").show();
    let url = "../q/index.php/api/pregunta/buzon/format/json/";
    let data_send = {"modalidad": get_option("modalidad_ventas")};
    request_enid("GET", data_send, url, response_buzon, ".place_buzon");
}
let response_buzon = data => {
    render_enid(".place_buzon", data);
    $(".pregunta").click(carga_respuestas);
}
let carga_respuestas = () => {

    let id_pregunta = parseInt(get_attr(this, "id"));
    if (id_pregunta > 0) {

        set_option("pregunta", id_pregunta);
        let data_send = {
            "id_pregunta": id_pregunta,
            "pregunta": get_attr(this, "pregunta"),
            "registro": get_attr(this, "registro"),
            "usuario_pregunta": get_attr(this, "usuario"),
            "modalidad": get_option("modalidad_ventas"),
            "nombre_servicio": get_attr(this, "nombre_servicio"),
            "id_servicio": get_attr(this, "servicio")
        };

        set_option("data_pregunta", data_send);
        carga_respuesta_complete();
    }

}
let carga_respuesta_complete = () => {

    let url = "../q/index.php/api/respuesta/respuesta_pregunta/format/json/";
    request_enid("GET", get_option("data_pregunta"), url, r_complete, ".place_buzon");

}
let r_complete = data => {

    $(".contenedor_opciones_buzon").hide();
    render_enid(".place_buzon", data);
    $(".form_valoracion_pregunta").submit(enviar_respuesta);

}
let enviar_respuesta = e => {

    let data_send = $(".form_valoracion_pregunta").serialize() + "&" + $.param({
        "pregunta": get_option("pregunta"),
        "modalidad": get_option("modalidad_ventas")
    });
    let url = "../q/index.php/api/respuesta/respuesta_pregunta/format/json/";
    request_enid("POST", data_send, url, carga_respuesta_complete);
    e.preventDefault();
}