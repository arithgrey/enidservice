<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function format_linea_tiempo($data)
    {

        sksort($data, "ventas_en_punto");

        $response = [];
        $r = [];
        $puntos = 0;
        foreach ($data as $row) {

            $ventas_en_punto = $row["ventas_en_punto"];
            $nombre_punto_encuentro = $row["nombre_punto_encuentro"];
            $text_entrega = ($ventas_en_punto > 1) ? span("ENTREGAS", "black") : span("ENTREGA", "black");

            $r[] =
                div(
                    icon("icon fa fa-space-shuttle black")
                     .
                    anchor_enid(

                        heading_enid($nombre_punto_encuentro, 3, "title") .
                        p(
                            span($ventas_en_punto, "f2 strong rounded shadow rounded padding_10 border black top_20") .
                            $text_entrega


                            , "description"
                        )
                        ,
                        [
                            "class" => "timeline-content",
                            "style" => "background:#f5f5f5!important"
                        ]

                    )
                    ,
                    "timeline"

                );
            $puntos  ++;

        }


        $response[] = format_linea(get_resumen($data));
        $response[] = br(2).hr();
        $response[] = heading_enid("VENTAS POR ESTACIÓN ", 4 , "text-left");
        $response[] = heading_enid("ESTACIONES DE REPARTO: ".$puntos, 6 , "text-left underline");
        $response[] = div(div(div(append($r), "main-timeline2"), 12), 13);
        return  div(append($response), "container");

    }

    function format_linea($data)
    {

        $total  = 0;
        $r = [];
        $b = 0;
        $lineas_reparto  = 0;

        for ($a = 0; $a < count($data); $a++) {

            $nombre_linea =  $data[$a]["nombre_linea"];
            $num =  $data[$a]["num"];
            $total =  $total + $num;

            $lineas_reparto ++;
            if ( $b < 1) {

                $text = [];
                $text[] = btw(

                    heading_enid($nombre_linea, 9, "letter-spacing-1")
                    ,
                    p($num, "text-center strong underline f15")
                    ,
                    "timeline-content"

                );
                $text[] = div("", "border");
                $r[] = div(append($text), "col-lg-2  top_20 text-center");
                $b  = 1;

            }else{

                $b = 0;
                $text = [];
                $text[] = div("","border");
                $text[] = btw(
                    heading_enid($nombre_linea, 9,"letter-spacing-1" ),
                    p($num, "text-center strong underline f15"),
                    "timeline-content"
                );

                $r[] = div(append($text), "col-lg-2 top_20 text-center");
            }
        }

        $x[] = heading_enid("VENTAS EN LíNEAS DE METRO: ".$total, 4 , "text-left");
        $x[] = heading_enid("LINEAS DE REPARTO: ".$lineas_reparto, 6 , "text-left underline");
        $x[] = div(div(div(div(append($r), "main-timeline12"), "col-md-12 contenedor_general padding_20 "), "row"));
        return append($x);

    }

    function get_resumen($data)
    {

        $response = [];
        foreach ($data as $row) {

            $id_linea_metro = $row["id_linea_metro"];
            $nombre_linea = $row["nombre_linea"];

            if (!es_data($response)) {

                /*Primer elemento*/
                array_push($response, [
                    "id_linea_metro" => $id_linea_metro,
                    "num" => 1,
                    "nombre_linea" => $nombre_linea
                ]);

            } else {

                $response = search($response, $id_linea_metro, $nombre_linea);

            }

        }

        sksort($response, "num");
        return $response;
    }

    function search($response, $id_linea_metro, $nombre_linea)
    {

        $b = 0;
        $index =  search_bi_array($response, "id_linea_metro",  $id_linea_metro);
        if ($index !=  false ){
            $response[$index]["num"] = $response[$index]["num"] + 1;
            $b ++;
        }

        if ($b < 1) {

            array_push($response, [
                "id_linea_metro" => $id_linea_metro,
                "num" => 1,
                "nombre_linea" => $nombre_linea
            ]);

        }

        return $response;
    }

}