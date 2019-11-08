<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_terminos($conceptos)
    {

        $r = [];
        foreach ($conceptos as $row) {
            foreach ($row["conceptos"] as $row2) {

                $config = [
                    "id" => $row2["id_privacidad"],
                    "class" => 'concepto_privacidad',
                    "termino_asociado" => 0,
                    "type" => 'checkbox'
                ];

                if (!is_null($row2["id_usuario"])) {

                    array_push($config, ['checked' => true]);
                    $config["termino_asociado"] = 1;
                    $config["checked"] = true;
                }

                $str = _text(
                    td(input($config)),
                    td(strtoupper($row2["privacidad"]))
                );
                $r[] = tr($str);
            }
        }

        return tb(append($r));

    }
}

