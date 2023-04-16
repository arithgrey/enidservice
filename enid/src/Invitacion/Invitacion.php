<?php

namespace Enid\Invitacion;

class Invitacion
{

    function format()
    {

        $primer = flex("1", "er", '', 'bautizo', 'white font-weight-bold f12 ml-1 mt-2');
        $primer_a = flex($primer, span("año y bautizo", 'bautizo'), 'justify-content-center align-items-center', 'mr-2');
        $response[] = d(d($primer_a, 'col-xs-12 col-md-offset-4 col-md-4 text-uppercase '), 'col-xs-12 col-md-offset-4 col-md-4 top_40');
        $response[] = d(d("Triana Alexandra", 'text-center display-3 text-stroke black  text-uppercase strong'), 'col-xs-12 col-md-offset-4 col-md-4 mt-5');

        $response[] = d(d("acompañanos a celebrar este día tan especial ", 'text-uppercase strong  text-center mx-auto f14'), 'col-xs-12 col-md-offset-4 col-md-4 top_90');

        $dia = d("Sábado", 'text-uppercase strong text-stroke text-center black f18 border_black m-4');
        $response[] = d($dia, 'col-xs-12 col-md-offset-4 col-md-4 mt-5');

        $flex_col = flex("Junio", "3:30 PM", 'flex-column', 'f14 black text-uppercase ', 'f14 black text-uppercase');
        $flex = flex("10", $flex_col, _text_(_between, 'mt-3 text-stroke'), 'f25 black strong mr-1');
        $response[] = d(d($flex, 'col-xs-6 col-xs-offset-3'), 'col-xs-12 col-md-offset-4 col-md-4');




        $icono_confirmacion = icon(_text_(_check_icon, 'white fa-2x'));
        $texto_confirmacion_icono =  flex($icono_confirmacion, "Confirma tu asistencia", '', 'mr-3', 'mt-2 f12');
        $response[] = d(format_link(
            $texto_confirmacion_icono,
            [
                "class" => "white  btn-3d d-flex justify-content-center align-items-center accion_confirmar_asistencia"

            ],
            4
        ), 'col-xs-12 col-md-offset-4 col-md-4  mt-5');


        $icono_ubicacion = icon('fa fa-map-marker white fa-2x');
        $texto_ubicacion_icono =  flex($icono_ubicacion, "Ubicación", '', 'mr-4', 'f12');
        $path_maps = "https://goo.gl/maps/tcBWH6dNX1Pa31Su9";

        $response[] = d(format_link(
            $texto_ubicacion_icono,
            [
                "href" => $path_maps,
                "class" => "btn-3d d-flex justify-content-center align-items-center mt-2"
            ],
            4
        ), 'col-xs-12 col-md-offset-4 col-md-4 mt-2');

        $response[] = d(flex(
            icon('fa fa-sticky-note-o'),
            "Te sugerimos ser puntual!",
            'justify-content-center align-items-center black strong',
            'mr-2',
            'black'
        ), 'col-xs-12 col-md-offset-4 col-md-4 mt-3 text-center');


        $extra = is_mobile() ? 'col-xs-12' :'';
        $nombre_asistente = d(
            "",
            [
                "class" => _text_($extra,"nombre_asistente p-2 d-none white text-uppercase strong mt-3"),
                "id" => "nombre_asistente"
            ]
        );


        $extra = is_mobile() ? 'row text-center' :'text-center col-xs-12 col-md-offset-4 col-md-4';
        $response[] = d(
            $nombre_asistente,
            $extra
        );


        $response[] = $this->modal_asistencia();

        return d($response);
    }
    function modal_asistencia()
    {

        $icono_confirmacion = icon(_text_(_check_icon, ' fa-2x'));
        $texto_confirmacion_icono =  flex(
            $icono_confirmacion,
            "Confirma tu asistencia",
            'align-items-center',
            'mr-3',
            'mt-4 f16  strong text-uppercase'
        );

        $contenido[] =  d($texto_confirmacion_icono, 'col-xs-12 ');


        $form[] = form_open("", ["class" => "form_registro_asistencia mt-3 col-xs-12 "]);
        $form[] = input_enid(
            [
                "name" => "nombre",
                "class" => "nombre mt-3",
                "id" => "nombre",
                "type" => "text",
                "required" => true,
                "placeholder" => "¿Cual es tu nombre?"
            ],
            "Ups! parece que aun no pones tu nombre!"
        );

        $form[] = "<button class='pb-3 pt-3 p-2 strong col 
        text-uppercase  format_invitacion action_format_invitacion btn-3d white 
        d-flex justify-content-center 
        font-weight-bold borde_black
        align-items-center mt-4'>" . "Enviar" . "</button>";

        $form[] = form_close();

        $contenido[] = append($form);
        $response[] = d($contenido, "form_asistencia");



        $te_esperamos =  flex(
            icon("fa fa-star"),
            "Te esperamos!",
            'justify-content-center align-items-center f2',
            'mr-3',
            'mt-4 f16  strong text-uppercase'
        );
        $response[] = d($te_esperamos, 'te_esperamos col-xs-12  text-center d-none');
        $response[] = d("", 'te_esperamos_nombre text-uppercase te_esperamos col-xs-12  text-center d-none');

        return gb_modal(d($response, 'row mb-5'), 'modal_asistencia');
    }
}
