<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_lista($data)
    {
        $b = 1;
        foreach ($data["recursos"] as $row) {

            $id_recurso = $row["id_recurso"];
            $tr = [];
            $tr[] = td($b . ".-");

            $conf = [
                "type" => 'checkbox',
                "class" => 'perfil_recurso',
                "id" => $id_recurso
            ];

            if ($row["idperfil"] > 0) {
                $conf += ["checked" => true];

            }

            $tr[] = td(input($conf));
            $tr[] = td($row["nombre"]);
            $tr[] = td(a_enid("Ver sitio",
                [
                    "href" => $row["urlpaginaweb"],
                    "class" => 'blue_enid_background white ',
                    "id" => $id_recurso,
                    "target" => '_black'
                ]));
            $l[] = tr(append($tr));
            $b++;
        }
        return tb(append($l));
    }
}