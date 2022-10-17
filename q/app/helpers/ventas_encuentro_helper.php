<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function format_linea_tiempo($data)
    {

        $response = [];
        if (es_data($data)) {

            sksort($data, "ventas_en_punto");
            $r = [];
            $z = [];
            $p = 0;
            foreach ($data as $row) {

                $ventas_pe = $row["ventas_en_punto"];
                $str = ($ventas_pe > 1) ? "entregas" : "entrega";
                $entrega = span($str, 'black text-uppercase');
                $str = text_icon("icon fa fa-space-shuttle black", a_enid(

                    h($row["nombre_punto_encuentro"], 3, "title") .
                    p(
                        span(
                            $ventas_pe,
                            "f2 strong rounded shadow rounded padding_10 border black top_20"
                        ) .
                        $entrega
                        , "description"
                    )
                    ,
                    "timeline-content custom_time_line"


                ));
                $z[] = d($str, "timeline");
                $p++;

            }
            $r[] = format_linea(get_resumen($data));
            $r[] = hr("mt-5");
            $r[] = _titulo("VENTAS POR ESTACIÓN ", 4, "text-left mt-5");
            $r[] = _titulo(add_text("ESTACIONES DE REPARTO: ", $p), 4, "text-left");
            $r[] = d($z, "main-timeline2");
            $response[] = d($r,10,1);
        }
        return append($response);
    }

    function format_linea($data)
    {

        $total = 0;
        $response = [];
        $b = 0;
        $reparto = 0;

        for ($a = 0; $a < count($data); $a++) {

            $nombre_linea = $data[$a]["nombre_linea"];
            $num = $data[$a]["num"];
            $total = $total + $num;
            $r = [];
            $reparto++;
            $text = [];
            if ($b < 1) {

                $text[] = btw(
                    h($nombre_linea, 9, "letter-spacing-1")
                    ,
                    p($num, "text-center strong underline f15")
                    ,
                    "timeline-content"
                );
                $text[] = border();
                $r[] = d(append($text), "col-lg-2 mt-5 text-center");
                $b = 1;

            } else {

                $b = 0;
                $text[] = border();
                $text[] = btw(
                    h($nombre_linea, 9, "letter-spacing-1"),
                    p($num, "text-center strong underline f15"),
                    "timeline-content"
                );

                $r[] = d(append($text), "col-lg-2 mt-5 text-center");
            }
            $response[] = append($r);
        }

        $x[] = h("VENTAS EN LÍNEAS DE METRO: " . $total, 4, "text-left");
        $x[] = h("LINEAS DE REPARTO: " . $reparto, 6, "text-left underline");
        $x[] = d(d($response, "main-timeline12 d-flex flex-wrap"), "col-md-12 bg-light padding_20 mb-5");
        return append($x);

    }

    function get_resumen($data)
    {

        $response = [];
        foreach ($data as $row) {

            $id_linea = $row["id_linea_metro"];
            $nombre = $row["nombre_linea"];

            if (!es_data($response)) {

                array_push($response,
                    [
                        "id_linea_metro" => $id_linea,
                        "num" => 1,
                        "nombre_linea" => $nombre
                    ]
                );

            } else {
                $response = search($response, $id_linea, $nombre);
            }
        }
        sksort($response, "num");
        return $response;
    }

    function search($response, $id_linea, $nombre_linea)
    {
        $b = 0;
        $index = search_bi_array($response, "id_linea_metro", $id_linea);
        if ($index !== false) {
            $response[$index]["num"] = $response[$index]["num"] + 1;
            $b++;
        }

        if ($b < 1) {
            array_push($response,
                [
                    "id_linea_metro" => $id_linea,
                    "num" => 1,
                    "nombre_linea" => $nombre_linea
                ]
            );
        }
        return $response;
    }

}
