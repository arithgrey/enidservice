<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function form_recuperacion($param, $tipificaciones)
    {


        $id_usuario = $param['id_usuario'];
        $id_recibo = $param['recibo'];
        $form[] = form_open('', ["class" => 'form_tipificacion_recuperacion']);
        $class = _text_(_strong, 'mb-5');
        $form[] = d(_titulo('¿Qué sucedió?', 2), $class);
        $form[] = create_select($tipificaciones,
            "tipificacion",
            "tipificacion form-control mb-4 ",
            "tipificacion",
            "nombre_tipificacion",
            "id_tipificacion",
            0,
            1,
            0,
            "-"
        );
        $form[] = hiddens(['name' => 'id_tipo_padre', 'value' => 11]);
        $form[] = hiddens(['name' => 'id_usuario', 'value' => $id_usuario]);
        $form[] = hiddens(['name' => 'recibo', 'value' => $id_recibo]);
        $form[] = btn('registrar');

        $form[] = form_close();
        return append($form);

    }

}