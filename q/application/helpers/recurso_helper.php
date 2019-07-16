<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_lista($data)
    {


        $b = 1;
        foreach ($data["recursos"] as $row) {


            $idperfil = $row["idperfil"];

            $id_recurso = $row["id_recurso"];


            $tr[] = get_td($b . ".-");

            if ($idperfil > 0) {
                $tr[] =
                    get_td(input(
                        [
                            "type" => 'checkbox',
                            "class" => 'perfil_recurso',
                            "id" => $id_recurso,
                            "checked" => true
                        ]));
            } else {
                $tr[] = get_td(
                    input([
                            "type" => 'checkbox',
                            "class" => 'perfil_recurso',
                            "id" => $id_recurso
                        ]
                    ));
            }

            $tr[] = get_td($row["nombre"]);
            $tr[] = get_td(anchor_enid("Ver sitio",
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

