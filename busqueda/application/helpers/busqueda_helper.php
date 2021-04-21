<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function form($data)
    {

        $z[] = "<form action='../search' class='mt-5'>";
        $input = input(
            [
                "class" => "input-field mh_50 border border-dark solid_bottom_hover_3 ",
                "placeholder" => "¿Qué artículo agendarás?",
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
        $r[] = d($z, _text("mt-5 " , $ext));


        $meta_semanal_comisionista = $data['meta_semanal_comisionista'];
        $total_ventas_semana = (es_data($data['ventas_semana'])) ? count($data['ventas_semana']) : 0;




        $restantes = ($meta_semanal_comisionista - $total_ventas_semana );
        $seccion_meta = flex('Meta semanal', $meta_semanal_comisionista, 'flex-column');
        $ventas_actuales = flex('Logros a la fecha', $total_ventas_semana, 'flex-column');
        $restantes = flex('Restantes', $restantes, 'flex-column strong black');



        $link_ventas = a_enid('Mis ventas',
            [
                'class' => 'underline text-center black',
                'href' => path_enid('pedidos')
            ]
        );

        $link_top_ventas = a_enid('Top ventas',
            [
                'class' => 'underline text-center black',
                'href' => path_enid('top_competencia')
            ]
        );

        $r[] = d(d_c(
            [
                $seccion_meta,
                $ventas_actuales,
                $restantes,
                $link_ventas,
                $link_top_ventas
            ],
            'col-lg-2 mx-auto text-center mt-5'),'row mt-5');



        return d(d($r), 'col-md-10 mt-5 col-md-offset-1');

    }

}
