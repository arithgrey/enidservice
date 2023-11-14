<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function busqueda_pedido($param)
    {

        $q = prm_def($param, "q");
        $a = 0;
        if (str_len($q, 2)) {
            $info[] = d(h("Ups, no hay ningún resultado para " . '"' . prm_def($param, "q", "") . '" ', 4, "strong  borde_rojo p-2"));
            $textos[] =  append($info);
            $a++;
        }

        $textos[] = d(h(_text_(icon('fa fa-truck'), "Rastrea tu pedido"), 4, "strong fz_30 text-uppercase"));
        $extra = ($a > 0) ? 'borde_rojo' : '';
        $textos[] = d(
            d(
                _text_(
                    "Escribe tu",
                    _text_(
                        icon("fa fa-hashtag"),
                        "número de guía, también puedes consultar el estado de tu pedido al",
                    ),
                    icon('fa fa-phone'),
                    span("(55) 5296 - 7027", 'strong')
                ),
                _text_("mt-1 black mb-4 f12", $extra)
            )
        );

        



        $response[] = d($textos, 'col-sm-12 mt-5');
        $formulario[] = "<form action='../pedidos/' >";
        $formulario[] = d(
            add_text(
                "",
                input([
                    "class" => "input-field mh_50 border border-dark  solid_bottom_hover_3  ",
                    "placeholder" => "Escribe tu número de guía",
                    "name" => "seguimiento"
                ])
            )
        );

        $formulario[] = btn("Rastrea tu pedido", ["class" => "mt-4"]);
        $formulario[] = form_close();


        $response[] = d($formulario, "col-lg-12");

        $response[] = d(d(
            d(
                _text_(
                    "El tiempo de entrega en CDMX de 1 hora a",
                    "máximo 4 horas a partir de que nos envías tu pedido, 
                    envíos a otros estados de 1 a 2 días "
                )

            ),
            _text_("mt-1 mb-5 f13", $extra)
        ),"col-xs-12 mt-5 f1 bg_yellow black");

        $response[] = d(a_enid("Medidas de seguridad para pedidos contra entrega 🐀",
        [
            "class"=>'text-right black underline',
            "href"=> path_enid("distribuidores_autorizados")
        ]),"col-lg-12");

        return d(d($response, 13), 6, 1);
    }
}
