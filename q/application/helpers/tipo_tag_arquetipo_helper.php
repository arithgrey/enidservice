<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function form_reventa($data)
    {

        $id_usuario = $data['id_usuario'];
        $id_recibo = $data['recibo'];
        $form[] = form_open("",
            [
                "class" => "form_reventa",
                "method" => "post"
            ]
        );
        $form[] = input_frm('', '¿Qué artículo le ofrecisté?',
            [
                'class' => 'reventa',
                'id' => 'reventa',
                'name' => 'tag',
                'required' => true
            ]
        );


        $form[] = hiddens(['name' => 'tipo', 'value' => 2]);
        $form[] = hiddens(['name' => 'recibo', 'value' => $id_recibo]);
        $form[] = hiddens(['name' => 'usuario', 'value' => $id_usuario]);
        $form[] = btn('Registrar', ['class' => 'mt-5']);
        $form[] = form_close();
        return append($form);
    }


}