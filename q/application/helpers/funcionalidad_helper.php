<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_terminos($conceptos)
    {

        $r = [];
        foreach ($conceptos as $row) {

            $r[] = "<table style='width:100%;margin-top:30px;' >";
            foreach ($row["conceptos"] as $row2) {


                $extra_seleccion = "";
                $termino_asociado = 0;
                if (!is_null($row2["id_usuario"])) {
                    $extra_seleccion = "checked";
                    $termino_asociado = 1;
                }

                $r[] = "<tr>";

                $attr = add_attributes(
                    [
                        "id" => $row2["id_privacidad"],
                        "class" => 'concepto_privacidad',
                        "termino_asociado" => $termino_asociado,
                        "type" => 'checkbox'
                    ]
                );
                $r[] = td("<input " . $attr . " " . $extra_seleccion . ">");
                $r[] = td(strtoupper($row2["privacidad"]));
                $r[] = "</tr>";

            }
            $r[] = "</table>";
        }

        return append($r);

    }

}

