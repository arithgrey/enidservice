<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function form($data)
    {

        $z[] = "<form action='../search' class='mt-5'>";
        $input = input(
            [
                "class" => "input-field mh_50 border border-dark  solid_bottom_hover_3 ",
                "placeholder" => "buscar",
                "name" => "q"
            ]
        );
        $z[] = d(
            _text_(
                icon('fa fa-search icon'),
                $input
            )
            , "input-icons w-100");
        $z[] = form_close();
        $ext = (is_mobile() < 1) ? "" : "top_200";
        $r[] = d($z, "mt-5 " . $ext);
        $r[] = d(_titulo("¿QUÉ ARTíCULO agendarás?", 4), 'w-100 mt-5 text-right');

        $meta_semanal_comisionista = $data['meta_semanal_comisionista'];
        $total_ventas_semana = count($data['ventas_semana']);


        $restantes = ($meta_semanal_comisionista - $total_ventas_semana );
        $seccion_meta = flex('Meta semanal', $meta_semanal_comisionista, 'flex-column');
        $ventas_actuales = flex('Logros a la fecha', $total_ventas_semana, 'flex-column');
        $restantes = flex('Restantes', $restantes, 'flex-column strong');



        $r[] = d_c(
            [$seccion_meta, $ventas_actuales, $restantes],
            'col-lg-4 mx-auto text-right mt-5');
        $r[] = a_enid('Mis ventas',
            [
                'class' => 'underline text-right black',
                'href' => path_enid('pedidos')
            ]
        );


        return d(d($r), 'col-md-6 mt-5 col-md-offset-3');

    }

}
