<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function form()
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
        $r[] = d(_titulo("¿QUÉ ARTíCULO agendarás?",4),'w-100 mt-5 text-right');

        return d(d($r), 'col-md-6 mt-5 col-md-offset-3');


    }

}
