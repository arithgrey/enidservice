<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function format_descripcion()
    {


        $r[] = img(["src" => "../img_tema/portafolio/bte.png" ,"class" => "mah_500"]) ;
        $x[] = h("¿Por qué Enid Service?",2,"strong text-uppercase top_30 bottom_30 text-center") ;
        $x[] =
            btw(
                d(
                    h("Relaciones" ,3 , "strong"),1)
                ,
                d("Facilitamos la comunicación entre negocios y consumidores,  por lo tanto el éxito de las personas a quienes ayudamos, define nuestro propio éxito ",
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
                d(h("Conexiones " ,3 ,"strong"),1)
                ,
                d("Te Acompañamos directamente  en una de tus actividades claves vinculadas a generan valor y que resulta necesarias para establecer ventajas competitivas ",
                    "f16  top_10 letter-spacing-2 text-muted" ,
                    1)
                ,
                "col-lg-4 padding_10   text-center top_50 border-bottom"
            )

        ;

        $x[] =

            btw(
                d(h("Resultados " ,3 , "strong"),1)
                ,
                d("Te ayudamos a que crees planes y optimices tus estrategias de marketing para lograr resultados. ",
                    "f16  top_10 letter-spacing-2 text-muted" ,
                    1)
                ,
                "col-lg-4 padding_10   text-center top_50 border-bottom"
            );

        $r[] =  d(d(append($x),10,1), "row  topicos ");

        $r[] = img(["src" => "../img_tema/portafolio/ejemplo-personas.jpg" ,"class" => "mah_500 top_50" ] );
        $r[] = h("Comienza ahora",2,"text-uppercase top_30 text-center top_50 ") ;
        $r[] = d(btn("Empieza a anunciarte ya mismo! ",[],1,1,0,path_enid("vender")), 4, 1);
        return append($r);
    }

}
