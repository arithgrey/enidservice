$(document).ready(() => {

    $(".form_ventas_encuentro").submit(busqueda);
});
let busqueda = (e) => {

    let url ="../q/index.php/api/ventas_encuentro/periodo/format/json/";
    let data_send =  $(".form_ventas_encuentro").serialize();
    request_enid( "GET",  data_send, url, response_ventas_encuentro);
    e.preventDefault();

};
let response_ventas_encuentro  =  (data) => render_enid(".time_line_ventas_puntos_encuentro", data);
