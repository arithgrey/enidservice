<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function form_reventa($data)
    {

        $id_usuario = $data['id_usuario'];
        $id_orden_compra = $data['id_orden_compra'];
        $form[] = form_open("",
            [
                "class" => "form_reventa",
                "method" => "post"
            ]
        );

        $form[] = d(_titulo('¿Qué acción realizasté?', 3), 'acccion_realizada text-left');
        $accciones[] = ['text' => 'Mandé mensaje recordando su venta de hace tiempo y ofrecí nuevos artículos con la página web'];
        $accciones[] = ['text' => 'Le recordé que quería otro artículo y que tenemos pendiente su nueva entrega'];
        $accciones[] = ['text' => 'No tiene whatsApp debemos investigar otro medio de contacto'];
        $accciones[] = ['text' => 'Envié video sobre algún artículo nuevo'];

        $form[] = create_select($accciones,
            'accion_reventa',
            'accion_reventa form-control text-uppercase acccion_realizada_select text-uppercase',
            'accion_reventa',
            'text',
            'text', 0, 1, 0, '-'
        );


        $form[] = d('¿Hay algún artículo que le interese?', 'mt-5 d-none hay_interes text-left text-uppercase');

        $interes = format_link('SI', ['class' => 'interes_articulo']);
        $sin_interes = format_link('AUN NO SABEMOS', ['class' => 'sin_interes_articulo'], 0);
        $accciones_interes = flex($interes, $sin_interes, _text_(_between, 'mt-5'), 'aplica', 'no_aplica');
        $form[] = d($accciones_interes, 'hay_interes d-none');
        $form[] = d(
            input_frm('', '¿Qué artículo?',
                [
                    'class' => 'reventa for',
                    'id' => 'reventa',
                    'name' => 'tag',
                    'required' => true
                ]
            ), 'mt-5 d-none registro_articulo'
        );


        $form[] = hiddens(['name' => 'interes', 'value' => 0, 'class' => 'interes']);
        $form[] = hiddens(['name' => 'tipo', 'value' => 2]);
        $form[] = hiddens(['name' => 'orden_compra', 'value' => $id_orden_compra]);
        $form[] = hiddens(['name' => 'usuario', 'value' => $id_usuario]);
        $form[] = d(btn('Registrar', ['class' => 'mt-5']), 'd-none registro_articulo');
        $form[] = form_close();
        return append($form);
    }


}