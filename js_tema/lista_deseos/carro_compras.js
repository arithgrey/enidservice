let cancela_productos = id => {

    let url = "../q/index.php/api/usuario_deseo/status/format/json/";
    let data_send = {"id": id, "status": 2};
    request_enid("PUT", data_send, url, response_carga_productos, ".place_resumen_servicio");

}

let response_carga_productos = (data) => redirect("");


