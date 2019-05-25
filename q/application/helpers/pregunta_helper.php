<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function get_format_respuesta_vendedor($email, $nombre, $id_servicio)
    {

        $asunto = "HOLA {$nombre} TIENES UNA NUEVA PREGUNTA SOBRE UNO DE TUS ARTÍCULOS EN VENTA";

        $text = "Que tal {$nombre} un nuevo cliente desea saber más sobre uno de tu artículos, puedes ver la pregunta que 
            te envió en tu !" . anchor_enid("buzón aquí", ["href" => "https://enidservice.com/inicio/login/"]);

        $img = get_img_servicio($id_servicio, 1);
        $cuerpo = append_data([

            img_enid([], 1, 1),
            heading_enid($text, 3),
            $img

        ]);

        $sender = get_request_email($email, $asunto, $cuerpo);
        return $sender;

    }

    function get_format_respuesta_cliente($email, $nombre, $id_servicio)
    {

        $asunto = "HOLA {$nombre} TIENES UNA NUEVA RESPUESTA EN TU BUZÓN";

        $text = "Que tal {$nombre} el vendedor a contestado tu pregunta, puedes ver la respuesta que 
            te envió en tu !" . anchor_enid("buzón aquí", ["href" => "https://enidservice.com/inicio/login/"]);

        $img = get_img_servicio($id_servicio, 1);
        $cuerpo = append_data([

            img_enid([], 1, 1),
            heading_enid($text, 3),
            $img

        ]);

        $sender = get_request_email($email, $asunto, $cuerpo);
        return $sender;

    }

    function get_notificacion_pregunta($usuario)
    {

        $nombre = $usuario[0]["nombre"];
        $email = $usuario[0]["email"];
        $asunto = "HOLA {$nombre} UN NUEVO CLIENTE ESTÁ INTERESADO EN UNO DE TUS ARTÍCULOS";
        $text = "Que tal {$nombre} un nuevo cliente desea saber más sobre uno de tu artículos, puedes ver la pregunta que 
            te envió en tu !" . anchor_enid("buzón aquí", ["href" => "https://enidservice.com/inicio/login/"]);
        $cuerpo = img_enid([], 1, 1) . heading_enid($text, 5);
        $sender = get_request_email($email, $asunto, $cuerpo);
        return $sender;

    }

    function get_titulo_modalidad($modalidad)
    {
        $texto = ($modalidad == 1) ? " LO QUE TE HAN PREGUNTADO" : "LO QUE PREGUNTASTÉ A VENDEDORES";
        return heading_enid($texto, 3);
    }

    function get_url_imagen_pregunta($modalidad, $param)
    {

        $id_usuario = ($modalidad == 0) ? $param["id_usuario_venta"] : $param["id_usuario"];
        $url_imagen = "../imgs/index.php/enid/imagen_usuario/" . $id_usuario;
        return $url_imagen;

    }

    function get_texto_sobre_el_producto($modalidad, $param)
    {


        $text = anchor_enid("Sobre -" . $param["nombre_servicio"],
            [
                "href" => path_enid("producto", $param["id_servicio"])
            ]
        );
        return $text;
    }

    function valida_respuestas_nuevas($modalidad, $param)
    {

        $text = ($modalidad == 0) ? carga_iconos_buzon_compras($param) : carga_iconos_buzon_ventas($param);
        return $text;
    }

    function carga_iconos_buzon_ventas($param)
    {


        $id_pregunta = $param["id_pregunta"];
        $pregunta = $param["pregunta"];
        $fecha_registro = $param["fecha_registro"];
        $id_usuario = $param["id_usuario"];
        $leido_vendedor = $param["leido_vendedor"];
        $respuestas = $param["respuestas"][0];
        $num = $respuestas["respuestas"];
        $nombre_servicio = $param["nombre_servicio"];
        $id_servicio = $param["id_servicio"];


        if ($leido_vendedor == 0) {

            $text = div("Nueva", [
                "class" => 'blue_enid_background white pregunta fa fa-envelope',
                "id" => $id_pregunta,
                "registro" => $fecha_registro,
                "usuario" => $id_usuario,
                "leido_vendedor" => $leido_vendedor,
                "nombre_servicio" => $nombre_servicio,
                "servicio" => $id_servicio
            ]);


        } else {
            if ($num < 1) {
                $num = "";
            }
            $text = div("Nueva", [
                "class" => 'pregunta fa fa-envelope',
                "id" => $id_pregunta,
                "pregunta" => $pregunta,
                "registro" => $fecha_registro,
                "usuario" => $id_usuario,
                "leido_vendedor" => $leido_vendedor,
                "nombre_servicio" => $nombre_servicio,
                "servicio" => $id_servicio
            ]);


        }
        return $text;
    }

    function carga_iconos_buzon_compras($param)
    {

        $id_pregunta = $param["id_pregunta"];
        $leido_cliente = $param["leido_cliente"];
        $respuestas = $param["respuestas"][0];
        $num = $respuestas["respuestas"];
        $text = "";
        $base_servicio = [
            "pregunta" => $param["pregunta"],
            "registro" => $param["fecha_registro"],
            "usuario" => $param["id_usuario"],
            "leido_vendedor" => $param["leido_vendedor"],
            "nombre_servicio" => $param["nombre_servicio"],
            "servicio" => $param["id_servicio"]
        ];


        if ($leido_cliente == 0 && $num > 0) {

            $base_servicio["class"] = 'blue_enid_background white pregunta fa fa-envelope';
            $base_servicio["id"] = $id_pregunta;
            $text = div("Nueva respuesta", $base_servicio);

        } else {

            if ($num > 0) {
                $base_servicio["class"] = 'white pregunta fa fa-envelope';
                $base_servicio["id"] = $id_pregunta;
                $text = div($num, $base_servicio);
            }
        }
        return $text;
    }
}