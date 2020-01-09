<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_lista($data)
    {
        $b = 1;
        $response = [];
        foreach ($data["recursos"] as $row) {

            $id_recurso = $row["id_recurso"];
            $tr = [];
            $tr[] = d(_text($b . ".-"));

            $conf = [
                "type" => 'checkbox',
                "class" => 'perfil_recurso',
                "id" => $id_recurso
            ];

            if ($row["idperfil"] > 0) {
                $conf += ["checked" => true];

            }

            $tr[] = d(input($conf));
            $tr[] = d(strip_tags($row["nombre"]),'text-uppercase ml-0 ml-md-2');
            $tr[] = format_link("Ver sitio",
                [
                    "href" => $row["urlpaginaweb"],
                    "class" => 'blue_enid_background white ml-auto col-md-2',
                    "id" => $id_recurso,
                    "target" => '_black'
                ]
            );

            $response[] = d($tr,'d-flex mt-3');
            $b++;
        }
        return append($response);
    }
}