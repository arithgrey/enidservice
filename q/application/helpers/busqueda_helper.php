<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function conexiones($usuarios, $id_seguidor)
    {

        $response = [];
        if (count($usuarios) > 0) {

            $response[] = d(_titulo("descubre otras cuentas", 4),'titulo_otras_cuentas');
        }

        foreach ($usuarios as $row) {

            $id_vendedor = $row['idusuario'];
            if ($id_vendedor !== $id_seguidor){
                $nombre_vendedor = substr(format_nombre($row), 0, 17);
                $path_imagen = $row['path_imagen'];
                $seccion_nombre_vendedor = p($nombre_vendedor, 'black fp7');

                $seccion = [];

                $class = _text_(_eliminar_icon, 'mr-3 descarte');
                $atributos = ["id" => $id_vendedor];

                $seccion[] = d(icon($class, $atributos), 'text-right');
                $seccion[] = d(
                    a_enid(
                        img(
                            [
                                "src" => $path_imagen,
                                "onerror" => "this.src='../img_tema/user/user.png'",
                                'class' => 'mx-auto d-block rounded-circle mah_50'
                            ]
                        ), path_enid('usuario_contacto', $id_vendedor)
                    ), 'mt-4');

                $seccion[] = d($seccion_nombre_vendedor, 'text-center text-uppercase mt-4');
                $seguir = d("seguir", ['class' => 'strong black', "id" => $id_vendedor]);

                $atributos = [
                    "class" => 'text-center border border-info rounded_enid col-sm-6 col-sm-offset-3 cursor_pointer conexion',
                    "id" => $id_vendedor
                ];
                $seccion[] = d($seguir, $atributos);

                $response[] = d($seccion, 'col col-md-2 border d-flex flex-column justify-content-between h-100 p-3');

            }

        }

        return append($response);
    }



}
