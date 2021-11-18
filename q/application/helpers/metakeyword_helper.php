<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function create_arr_tags($data)
    {
        $tags = [];
        foreach ($data as $row) {

            $metakeyword = $row["metakeyword"];
            if (strlen($metakeyword) > 0) {
                $tags = json_decode(
                    $metakeyword, true
                );
                break;
            }
        }

        return $tags;
    }

    function catalogo_metakeyword($catalogo)
    {


        $response[] = '';
        foreach ($catalogo as $row) {

            $etiqueta = a_enid(
                flex(icon(_text_(_agregar_icon,'white')), $row,"","mr-2"),
                [
                    'class' => 'white tag_catalogo',
                    'id' => $row,
                ]
            );

            $etiqueta = d($etiqueta, 'col-md-3');
            array_push($response, $etiqueta);
        }

        $r[] = _titulo("Etiquetas recien utilizadas", 3, "mt-5");
        $r[] = d($response, 13);
        return append($r);
    }
}
