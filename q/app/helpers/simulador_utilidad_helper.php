<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function simular($data)
    {

        $precio = $data["precio"];
        $costo = $data["costo"];
        $venta = $data["venta"];
        $entrega = $data["entrega"];
        $otro = $data["otro"];
        $cantidad_venta = $data["cantidad_venta"];

        $gastos =  $costo + $venta + $entrega + $otro ;
        $utilidad = ($precio - $gastos);

        $response[] =  flex(_titulo("Tus ganancias por cada artículo"), d(money($utilidad),"blue_enid display-5"), _text_(_between,'underline mt-2'));
        $response[] =  flex(d("Tú precio de venta",'f12 black'), d(money($precio),'f12 black'), _text_(_between,'mt-2'));
        $response[] =  flex(d("Gastos",'f12 black'), d(money($gastos),'f12 black'), _text_(_between,'mt-2'));
        $response[] =  flex(d("Artículos vendidos por día",'f12 black'), d($cantidad_venta,'f14 black'), _text_(_between,'mt-2'));


        $response[] =  d("Pronóstico ventas - ganancias", "display-6 mt-5 strong");

        $utilidad_venta = ($utilidad * $cantidad_venta );
        $metricas  = [];
        $metricas[] = d("1 día",4);
        $metricas[] = d(_text_("#Ventas", $cantidad_venta),"col-sm-4");
        $metricas[] = d(_text_("Utilidad", money(($utilidad_venta))),"col-sm-4 text-right");        
        $response[] = d($metricas, "row mt-3 border-bottom black");


        $metricas  = [];
        $metricas[] = d("5 días",4);
        $metricas[] = d(_text_("#Ventas", ( ($cantidad_venta * 5) )),"col-sm-4");
        $metricas[] = d(_text_("Utilidad", money(($utilidad_venta * 5))),"col-sm-4 text-right");        
        $response[] = d($metricas, "row mt-3 border-bottom black");

        $metricas  = [];
        $metricas[] = d("7 días",4);
        $metricas[] = d(_text_("#Ventas", ( ($cantidad_venta * 7) )),"col-sm-4");
        $metricas[] = d(_text_("Utilidad", money(($utilidad_venta * 7))),"col-sm-4 text-right");        
        $response[] = d($metricas, "row mt-3 border-bottom black");
        
        $metricas  = [];
        $metricas[] = d("15 días",4);
        $metricas[] = d(_text_("#Ventas", ( ($cantidad_venta * 15) )),"col-sm-4");
        $metricas[] = d(_text_("Utilidad", money(($utilidad_venta * 15))),"col-sm-4 text-right");        
        $response[] = d($metricas, "row mt-3 border-bottom black");


        $metricas  = [];
        $metricas[] = d("20 días",4);
        $metricas[] = d(_text_("#Ventas", ( ($cantidad_venta * 20) )),"col-sm-4");
        $metricas[] = d(_text_("Utilidad", money(($utilidad_venta * 20))),"col-sm-4 text-right");        
        $response[] = d($metricas, "row mt-3 border-bottom black");

        $metricas  = [];
        $metricas[] = d("22 días",4);
        $metricas[] = d(_text_("#Ventas", ( ($cantidad_venta * 22) )),"col-sm-4");
        $metricas[] = d(_text_("Utilidad", money(($utilidad_venta * 22))),"col-sm-4 text-right");        
        $response[] = d($metricas, "row mt-3 border-bottom black");



        $metricas  = [];
        $metricas[] = d("30 días",4);
        $metricas[] = d(_text_("#Ventas", ( ($cantidad_venta * 30) )),"col-sm-4");
        $metricas[] = d(_text_("Utilidad", money(($utilidad_venta * 30))),"col-sm-4 text-right");        
        $response[] = d($metricas, "row mt-3 border-bottom black");


        $metricas  = [];
        $metricas[] = d("1 año",4);
        $metricas[] = d(_text_("#Ventas", ( ($cantidad_venta * 365) )),"col-sm-4");
        $metricas[] = d(_text_("Utilidad", money(($utilidad_venta * 365))),"col-sm-4 text-right");        
        $response[] = d($metricas, "row mt-3 border-bottom black");




        
        return append($response);
        

    }

}