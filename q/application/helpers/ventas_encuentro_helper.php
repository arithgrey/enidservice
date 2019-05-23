<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function format_linea_tiempo($data)
    {

        $response = [];
        $r = [];
        foreach ($data as $row) {

            $linea = $row["linea"];
            $id_servicio = $row["id_servicio"];
            $ventas_en_punto =$row["ventas_en_punto"];
            $id_punto_encuentro = $row["id_punto_encuentro"];
            $nombre_punto_encuentro = $row["nombre_punto_encuentro"];
            $id_linea_metro = $row["id_linea_metro"];
            $nombre_linea = $row["nombre_linea"];
            $text_entrega = ($ventas_en_punto >  1 ) ? span("ENTREGAS", "black") : span("ENTREGA", "black");


            $total_linea =  get_total_linea($id_linea_metro , $data);
            $r[] =
                div(
                    span("", ["class" => "icon fa fa-space-shuttle", "style" => "background:black!important;"]) .
                    anchor_enid(

                        heading_enid($nombre_punto_encuentro, 3, "title") .
                        p(br().span($ventas_en_punto  , "f2 strong rounded shadow rounded padding_10 border black") .
                            $text_entrega .
                            br(2).
                            div("EN LINEA ".$nombre_linea ." " . span($total_linea,"strong f15"),"letter-spacing-3 text-right")

                            , "description")
                        ,
                        ["class" => "timeline-content" , "style" => "background:#f5f5f5!important"]

                    )
                    ,
                    "timeline"

                );

        }

        $response[]  =  heading_enid("INTENCIDAD",4);
        $response[]  =  div(div(div(append_data($r),"main-timeline2"),12),13);
        return div(append_data($response),"container");

    }
    function get_total_linea($linea , $data){

        $total =  0;
        foreach ($data as $row) {

            $id_linea_metro = $row["id_linea_metro"];
            $ventas_en_punto =$row["ventas_en_punto"];

            if($linea ==  $id_linea_metro ){

                $total =  $total +  $ventas_en_punto;
            }
        }
        return $total;

    }




}