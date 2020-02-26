let busqueda_ordenes_franja_horaria = (franja) => {

    modal('Busqueda', 1);
    let data_send = {"franja_horaria": franja, 'v': 1};
    let url = "../q/index.php/api/recibo/franja_horaria/format/json/";
    request_enid("GET", data_send, url, response_entregas_franja_horaria);

};
let response_entregas_franja_horaria = (data) => {

    modal(data);

};