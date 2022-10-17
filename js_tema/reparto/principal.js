let $efectivo_en_casa = $('.efectivo_en_casa');
let $efectivo_fuera = $('.efectivo_fuera');
$(document).ready(function () {

    $efectivo_en_casa.click(confirma_efectivo_en_casa);

});
let confirma_efectivo_en_casa = () => {


    let recibos = [];
    if ($efectivo_fuera.length) {
        for (let $x in $efectivo_fuera) {

            let $recibo = parseInt($efectivo_fuera[$x].id);
            if ($recibo > 0) {
                recibos.push($recibo)
            }
        }
    }

    let monto = $('.total_a_pago').text();
    let text = `¿Deseas marcar ${monto} como monto cobrado?`;
    show_confirm(text, '', `SI, recibí ${monto}`, function () {
        marcar_en_casa(recibos);
    });

};
let marcar_en_casa = function (recibos) {

    modal('REGISTRANDO!',1);
    let url = "../q/index.php/api/recibo/efectivo_en_casa/format/json/";
    let data_send = {"recibos": recibos, 'v': 1};
    request_enid("PUT", data_send, url, response_en_casa);

};
let response_en_casa = function (data) {

    redirect('');
};