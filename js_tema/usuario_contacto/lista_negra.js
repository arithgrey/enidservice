let envio_lista_negra = () => {
    
    let $id_usuario = $input_id_usuario.val();
    let text_confirmacion = '¿Realmente deseas mandar a lista negra a esta persona?';
    show_confirm(text_confirmacion, '', "SI", function () {
        let url = "../q/index.php/api/motivo_lista_negra/index/format/json/";
        let data_send = { 'v': 1, 'id_usuario': $id_usuario, 'tipo': 0 };
        request_enid("GET", data_send, url, response_motivos_lista_negra);
    });

};

let response_motivos_lista_negra = (data) => {
    modal(data);
    $(".input_enid_format :input").focus(next_label_input_focus);
    $(".input_enid_format :input").change(next_label_input_focus);
    $('.form_lista_negra').submit(agregar_lista_negra);
    $('.motivo').change(evalua_registro_motivo_lista_negra);
    
};
let evalua_registro_motivo_lista_negra = function () {

    let $motivo = parseInt(get_valor_selected('.motivo'));

    if (Number.isInteger($motivo)) {
        $('.agregar_botton_lista_negra').removeClass('d-none');
    } else {
        $('.agregar_botton_lista_negra').addClass('d-none');
    }

    if ($motivo === 0) {

        $('.input_agregar_motivo').removeClass('d-none');
        $('.motivo_lista_negra').attr('required', true);

    } else {

        $('.input_agregar_motivo').addClass('d-none');
        $('.motivo_lista_negra').attr('required', false);

    }

};
let agregar_lista_negra = (e) => {


    let $motivo = parseInt(get_valor_selected('.motivo'));
    if ($motivo >= 0) {

        let $telefono = $input_tel_contacto.val();
        let $orden_compra = $input_id_recibo.val();
        let data_send = $('.form_lista_negra').serialize() + "&" + $.param({
            'orden_compra': $orden_compra,
            'telefono': $telefono
        });
        let url = "../q/index.php/api/lista_negra/index/format/json/";
        $('.cargando_modal').removeClass('d-none');
        $('.motivo').prop('disabled', 'disabled');
        request_enid("POST", data_send, url, function (data) {
            
            redirect('');
        });
    }
    e.preventDefault();
}
