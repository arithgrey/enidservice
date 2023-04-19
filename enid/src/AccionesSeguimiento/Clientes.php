<?php

namespace Enid\AccionesSeguimiento;

class Clientes
{

    function __construct()
    {
    }
    function formato_eventos($acciones_seguimiento)
    {
        if (!es_data($acciones_seguimiento)) {
            return [];
        }

        $response = [];

        foreach ($acciones_seguimiento  as $row) {


            $id_usuario = $row["id_usuario"];
            $fecha_registro = $row["fecha_registro"];
            $comentario = $row["comentario"];
            $fecha_evento = $row["fecha_evento"];
            $url_img_usuario =  $row["url_img_usuario"];


            $fecha = horario_enid();
            $hoy = $fecha->format('Y-m-d');
            $dias = date_difference($hoy, $fecha_evento);

            $texto = ($dias > 1) ? _text_('Hace', $dias, 'días') : 'ayer';
            $texto_dias = ($dias < 1) ? "hoy" : $texto;


            $imagen = img(
                [
                    "src" => $url_img_usuario,
                    'class' => 'px-auto mt-4',
                    'onerror' => "this.src='../img_tema/user/user.png'",
                    "style" => "width: 40px!important;height: 35px!important;",
                ]
            );




            $imagen_usuario = a_enid(
                d($imagen),
                [
                    "href" => path_enid("usuario_contacto", $id_usuario),
                    "target" => "_black",
                    "class" => "black"
                ]
            );

            $textos_dias = flex("", $texto_dias, 'flex-column', "", "fp8 text-secondary");
            $imagen_nombre = flex($imagen_usuario, $textos_dias, "align-items-center ", "mr-5");

            $elemento = [];
            $elemento[] = $imagen_nombre;

            $estrella = d("", _text_(_estrellas_icon, "blue_enid"));
            $comentario_evento = a_enid(
                $comentario,
                [
                    "href" => path_enid("usuario_contacto", $id_usuario),
                    "class" => "black "
                ]
            );
            $elemento[] = flex($estrella, $comentario_evento, "border_black strong mt-3", "mr-4");
            $response[] = d($elemento, "mt-3 mb-3 border-bottom bg-white col-sm-12");
        }
        return d($response, "mt-5 bg-light ");
    }
    function formatoListado($acciones_seguimiento)
    {

        if (!es_data($acciones_seguimiento)) {
            return [];
        }
        $fichas = [];
        foreach ($acciones_seguimiento  as $row) {

            $id = $row["id"];
            $id_usuario = $row["id_usuario"];
            $id_accion_seguimiento = $row["id_accion_seguimiento"];
            $fecha_registro      = $row["fecha_registro"];
            $comentario = $row["comentario"];
            $status = $row["status"];
            $accion = $row["accion"];
            $ayuda_accion = $row["ayuda_accion"];
            $evento_pendiente =  $row["evento_pendiente"];
            $fecha_evento = $row["fecha_evento"];

            $tarjeta = [];

            if ($row["mostrar_ayuda"] > 0) {

                $texto_accion = flex(icon(_check_icon), $accion, '', 'mr-2');
                $tarjeta[] = d($texto_accion, 'mt-5 strong f11 col-xs-12');
                $tarjeta[] = d(span($ayuda_accion), "col-xs-12 mt-4 mb-4 ");
            }

            if (str_len($comentario, 2)) {

                $texto_accion = flex(icon(_mas_opciones_bajo_icon), "Comentario del cliente", '', 'mr-2');
                $tarjeta[] = d($texto_accion, 'mt-5 strong f11 col-xs-12');
                $tarjeta[] = d(d($comentario, 'bg_gray p-2'), ["class" => 'mt-4 col-xs-12']);
            }

            $tarjeta[] = d(span(format_fecha($fecha_registro, 1), 'fp9'), "col-xs-12 mt-4 mb-4 text-right");

            $tarjeta[] = $this->format_item_evento($id_accion_seguimiento, $evento_pendiente, $fecha_evento, $id);
            $fichas[] = d($tarjeta, 'mt-5 borde_black p-3 col-xs-12');
        }
        return d($fichas, 13);
    }
    function format_item_evento($id_accion_seguimiento, $evento_pendiente, $fecha_evento, $id)
    {


        $response = '';
        if (intval($id_accion_seguimiento) === 3) {


            $attr = [
                'class' => "evento_seguimiento_pendiente  p-2 strong white cursor_pointer red_enid_background",
                "id" => $id
            ];
            $nota_hecho = ($evento_pendiente > 0) ? d('Pendiente', $attr) : d(_text_(icon(_text_(_check_icon,'white')),'Realizado!'),["class" => "a_enid_black2"]);
            $status = d($nota_hecho, ' white p-2');
            $planeacion = _text_(icon('fa fa-clock-o'), 'Planeado para el día');
            $fecha = flex($planeacion, format_fecha($fecha_evento), 'strong', 'mr-2');
            $estado_evento = flex($status, $fecha, _between);
            $response = d($estado_evento, "col-xs-12 mt-1");
        }
        return $response;
    }
}
