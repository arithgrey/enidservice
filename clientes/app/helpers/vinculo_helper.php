<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render($data)
    {
                
        $response[] = d(foto_link($data),12);
        $response[] = d(add_imgs_cliente_empresa($data),12);
        return d($response, "text-center");
    }

    function add_imgs_cliente_empresa($data)
    {

        $imagenes_clientes = $data["imagenes_clientes"];
        $response = [];
        foreach ($imagenes_clientes as $row) {

            $link = get_path($row["nombre_imagen"]);
            
            $valores = [4,6,8];
            $indice_aleatorio = mt_rand(0, count($valores) - 1);

            $valor_aleatorio = $valores[$indice_aleatorio];


            $response[] = d(img(["class" =>"img-zoom","src" => $link]),  $valor_aleatorio);
        }

        $texto_imagenes  = d(_text("#",count($imagenes_clientes)),'white');
        $contenido[] = d(d($texto_imagenes, 13), 12);
        $contenido[] = d(d($response, 13), 12);
        return append($contenido);
    }

    function foto_link($data)
    {
        $response = [];
        $es_administrador = es_administrador($data);
        if ($data["in_session"] > 0 && $es_administrador) {

            $response[] = format_link("Agrega foto", ["class" => "anexar_foto_link"]);
            $response[] = d("", "formulario_fotos_clientes ");
        }

        return append($response);
    }

    function get_path($nombre_imagen)
    {

        return _text("../img_tema/clientes/", $nombre_imagen);
    }
}
