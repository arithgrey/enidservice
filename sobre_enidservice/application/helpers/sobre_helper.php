<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_descripcion()
    {


        $r[] = img(["src" => "../img_tema/portafolio/bte.png" ,"class" => "mah_500"]) ;
        $x[] = heading_enid("¿Por qué Enid Service?",2,"strong text-uppercase top_30 bottom_30 text-center") ;

        $x[] =
            btw(
                div(heading_enid("Relaciones" ,3 , "strong"),1)
                ,
                div("Facilitamos la comunicación entre negocios y consumidores,  por lo tanto el éxito de las personas a quienes ayudamos, define nuestro propio éxito ",
                    "f16  top_10 letter-spacing-2 text-muted"
                    ,
                    1
                )
                ,
                "col-lg-4 padding_10   text-center top_50 border-bottom"
            )

        ;

        $x[] =

            btw(
                div(heading_enid("Conexiones " ,3 ,"strong"),1)
                ,
                div("Te Acompañamos directamente  en una de tus actividades claves vinculadas a generan valor y que resulta necesarias para establecer ventajas competitivas ",
                    "f16  top_10 letter-spacing-2 text-muted" ,
                    1)
                ,
                "col-lg-4 padding_10   text-center top_50 border-bottom"
            )

        ;

        $x[] =

            btw(
                div(heading_enid("Resultados " ,3 , "strong"),1)
                ,
                div("Te ayudamos a que crees planes y optimices tus estrategias de marketing para lograr resultados. ",
                    "f16  top_10 letter-spacing-2 text-muted" ,
                    1)
                ,
                "col-lg-4 padding_10   text-center top_50 border-bottom"
            );

        $r[] =  div(div(append($x),10,1), "row  topicos ");

        $r[] = img(["src" => "../img_tema/portafolio/ejemplo-personas.jpg" ,"class" => "mah_500 top_50" ] );
        $r[] = heading_enid("Comienza ahora",2,"text-uppercase top_30 text-center top_50 ") ;
        $r[] = div(guardar("Empieza a anunciarte ya mismo! ",[],1,1,0,path_enid("vender")), 4, 1);
        $r[] = br(5);


        return append($r);
    }

}
