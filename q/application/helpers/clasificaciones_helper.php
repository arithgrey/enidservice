<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render_tallas($data)
    {


        $str = ($data["num_clasificaciones"] > 0) ? h(
            "CLASIFICACIONES AGREGADAS RECIENTEMENTE",
            5
            ,
            'titulo-tags-ingresos'
        ) : "";


        $r[] = d(
            append([

                    h(
                        prm_def($data["talla"], "tipo"),
                        2,
                        'info-tipo-talla'
                    )
                    , $str, $data["clasificaciones_existentes"]
                ]
            )
            ,
            "agregadas col-lg-9"
        );
        $r[] = btw(
            h("CLASIFICACIONES", 3),
            frm_clasificacion_talla(),
            " sugerencias col-lg-3"
        );
        return append($r);

    }

    function formatAgregar($param)
    {

        $btn = "<button class='button-op " . add_text("seleccion_" , $param["nivel"]) . "'>AGREGAR A LA LISTA</button>";
        return d($btn, "mas_" . $param["nivel"]);

    }

    function frm_clasificacion_talla()
    {

        $r[] = form_open("", ["class" => "form-agregar-clasificacion-talla"]);
        $r[] = input(
            [
                "type" => "text",
                "name" => "clasificacion",
                "placeholder" => "Busca por clasificación"
            ]
        );

        $r[] = form_close(place("info_tags"));
        return append($r);

    }

}
