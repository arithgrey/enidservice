<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render_historial($data)
    {
        $response = [];
        $actual = 1;
        foreach ($data as $row) {

            $tag = $row['tag'];
            $class = _text_(_between, 'mt-2', 'text-uppercase');
            $response[] = flex(_text_($actual, '.-'), $tag, $class);
            $actual++;
        }
        return d($response);
    }

    function form_articulos_interes($data)
    {
        $text = '¿Hay algún articulo adicional que le podría interesar?';
        $form[] = d(_titulo($text, 3), 'text-left');
        $si = format_link('SI', ['class' => 'agregar_nuevo_interes']);
        $aun_no = format_link('AÚN NO SÉ', ['class' => 'aun_no_se'], 0);
        $form[] = d(flex($si, $aun_no, _text_(_between, 'mt-5')), 'opciones_nuevo_articulo');
        $form[] = form_open('', ['class' => 'form_articulo_interes d-none mt-5']);
        $form[] = input_frm('', '¿Qué artículo?',
            [
                'class' => 'nuevo_articulo_interes',
                'id' => 'nuevo_articulo_interes',
                'name' => 'tag',
                'placeholder' => 'Ej. camisa',
                'type' => 'text',
                'required' => true
            ]
        );
        $form[] = hiddens(['name' => 'usuario', 'value' => $data['id_usuario']]);
        $form[] = hiddens(['name' => 'recibo', 'value' => $data['recibo']]);
        $form[] = hiddens(['name' => 'tipo', 'value' => 2]);
        $form[] = d(btn('Agregar'), 'mt-5');
        $form[] = form_close();
        return append($form);
    }
}
