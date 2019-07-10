<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render_tallas($data)
    {

        $talla = $data["talla"];
        $num_clasificaciones = $data["num_clasificaciones"];
        $clasificaciones_existentes = $data["clasificaciones_existentes"];
        $tipo = get_param_def($talla, "tipo");


        $str = ($num_clasificaciones > 0) ? heading_enid(
            "CLASIFICACIONES AGREGADAS RECIENTEMENTE",
            5
            ,
            'titulo-tags-ingresos'
        ) : "";


        $r[] = div(
            append([

                heading_enid(
                    $tipo,
                    2,
                    'info-tipo-talla'
                )
                , $str, $clasificaciones_existentes])
            ,
            "agregadas col-lg-9"
        );
        $r[] = btw(
            heading_enid("CLASIFICACIONES", 3),
            get_form_clasificacion_talla(),
            " sugerencias col-lg-3"
        );
        return append($r);

    }

    function formatAgregar($param)
    {
        $mas_nivel = "mas_" . $param["nivel"];
        $seleccion = "seleccion_" . $param["nivel"];
        $btn = "<button class='button-op " . $seleccion . "'>AGREGAR A LA LISTA</button>";
        return div($btn, $mas_nivel);

    }

    function get_form_clasificacion_talla()
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
