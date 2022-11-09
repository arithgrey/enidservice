<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function formato_fecha_promesa($data)
    {

        $response = [];

        foreach ($data as $row) {

            $fecha_registro = $row["fecha_registro"];
            $fecha_promesa = $row["fecha_promesa"];
            
            $meta = $row["meta"];
            $totales_fechas_ventas =  $row["totales_fechas_ventas"];
            $totales_fechas_ventas_leads  = $row["totales_fechas_ventas_leads"];

            $imagenes = d(img($row["url_img_servicio"]), "w_50");
            $imagenes = a_enid(
                $imagenes,
                [
                    "href" => path_enid("producto", $row["id_servicio"]),
                    "target" => "_black",
                ]
            );


            $vetas_fechas_totales  = metricas_compras_caida(
                $fecha_registro, 
                $fecha_promesa,
                $totales_fechas_ventas,
                $meta,
                $totales_fechas_ventas_leads);

            $logros = $vetas_fechas_totales["ventas"];
            $dias = $vetas_fechas_totales["dias"];
            $restantes = $meta - $logros;
            
            $promedio_venta = $meta / $dias;
            $totales_textos  = d(_text_($logros, "de", $meta, "faltan", $restantes,'ventas, la cantidadde ventas promedio por día para lograr el objetivo son',$promedio_venta),'black  strong borde_end_b');
            $texto_meta =  d(
                _text_(   
                    "Meta del"                 ,
                    format_fecha($fecha_registro),
                    'al',
                    format_fecha($fecha_promesa)
                ),'black fp9'
            );


            $imagen_totales = d([
                d($imagenes ,'strong black f14'), 
                d($totales_textos,'mt-2'),
                d($texto_meta,'mt-2'),
                d($vetas_fechas_totales["html"])
            ],' flex-row');
            $response[] = d(d($imagen_totales,'border border-secondary p-5 row mt-4'),12);

            
            
            
            
        }


        return append($response);
    }
    function metricas_compras_caida($fecha_registro, $fecha_promesa, $totales_fechas_ventas, $meta, $totales_fechas_ventas_leads){

        $begin = new DateTime($fecha_registro);
        $end = new DateTime($fecha_promesa);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $response = [];
        $logros = 0;
        $dias = 1;        
        foreach ($period as $dt) {$dias ++;}
        $promedio_dia = $meta / $dias;

        foreach ($period as $dt) {
            
            $fecha_entrega = $dt->format("Y-m-d");
            $ventas = busqueda_en_ventas($fecha_entrega ,$totales_fechas_ventas);
            $leads = busqueda_en_ventas($fecha_entrega ,$totales_fechas_ventas_leads);            

            $logros = $logros + $ventas;
            $extra  = ($ventas < $promedio_dia ) ? 'border-danger border': 'borde_end';
            $fecha_venta =  d([ 
                d($ventas ,'strong black f14'), 
                d(_text_('Leads',$leads) ,'black fp9'), 
                d($fecha_entrega)
            ], _text_('text-center p-2 flex-row mt-3', $extra));
            $response[] = d($fecha_venta, 'col-sm-2');
            
        }

        return [
            "html" => d($response,13),
            "ventas" => $logros,
            "dias" => $dias,

        ];

    }
    function busqueda_en_ventas($fecha_entrega_actual , $totales_fechas_ventas){
        
        $total = 0; 
        foreach($totales_fechas_ventas as $row){

            
            $fecha_entrega = $row["fecha_entrega"];
            
            if($fecha_entrega_actual == $fecha_entrega){
                $total = $row["total"];
            }
        }
        return $total;
    }

}
