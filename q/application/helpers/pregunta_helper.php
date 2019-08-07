<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function lista_respuestas($data)
    {

        $modalidad = $data["modalidad"];
        $r[] = titulo_modalidad($modalidad);

        foreach ($data["preguntas"] as $row) {

            $img = img(
                [
                'style' => 'width: 44px!important;',
                'src' => url_img_pregunta($modalidad, $row),
                'onerror' => "this.src='../img_tema/user/user.png'"

                ]
            );


            $r[] = d(btw(
                d(
                    append(
                        [
                            $img,
                            sobre_el_producto($modalidad, $row),
                            d($row["pregunta"]),
                            d($row["fecha_registro"])
                        ]
                    ), "popup-head-left pull-left"
                )
                ,
                val_respuestas($modalidad, $row)
                ,
                "popup-head"
            ),
                ["class" => "popup-box chat-popup", "id" => "qnimate", "style" => "margin-top: 4px;"]

            );
        }

        return append($r);

    }

    function frm_respuesta_vendedor($email, $nombre, $id_servicio)
    {

        $asunto = "HOLA {$nombre} TIENES UNA NUEVA PREGUNTA SOBRE UNO DE TUS ARTÍCULOS EN VENTA";
        $text = "Que tal {$nombre} un nuevo cliente desea saber más sobre uno de tu artículos, puedes ver la pregunta que 
            te envió en tu !" . a_enid("buzón aquí", ["href" => "https://enidservice.com/inicio/login/"]);

        $img = img_servicio($id_servicio, 1);
        $cuerpo = append(
            [
                img_enid([], 1, 1),
                h($text, 3),
                $img
            ]
        );

        return get_request_email($email, $asunto, $cuerpo);

    }

    function get_format_respuesta_cliente($email, $nombre, $id_servicio)
    {

        $asunto = "HOLA {$nombre} TIENES UNA NUEVA RESPUESTA EN TU BUZÓN";
        $text = "Que tal {$nombre} el vendedor a contestado tu pregunta, puedes ver la respuesta que 
            te envió en tu !" . a_enid("buzón aquí", "https://enidservice.com/inicio/login/");

        $img = img_servicio($id_servicio, 1);
        $cuerpo = append([

            img_enid([], 1, 1),
            h($text, 3),
            $img

        ]);

        return  get_request_email($email, $asunto, $cuerpo);

    }

    function get_notificacion_pregunta($usuario)
    {

        if (es_data($usuario)) {

            $usuario = $usuario[0];
            $nombre = $usuario["nombre"];


            $asunto = "HOLA {$nombre} UN NUEVO CLIENTE ESTÁ INTERESADO EN UNO DE TUS ARTÍCULOS";
            $text = "Que tal {$nombre} un nuevo cliente desea saber más sobre uno de tu artículos, puedes ver la pregunta que 
            te envió en tu !" . a_enid("buzón aquí", ["href" => "https://enidservice.com/inicio/login/"]);
            $cuerpo = img_enid([], 1, 1) . h($text, 5);
            return get_request_email($usuario["email"], $asunto, $cuerpo);

        }
    }

    function titulo_modalidad($modalidad)
    {

        $texto = ($modalidad == 1) ? " LO QUE TE HAN PREGUNTADO" : "LO QUE PREGUNTASTÉ A VENDEDORES";
        return h($texto, 3);
    }

    function url_img_pregunta($modalidad, $param)
    {

        $id_usuario = ($modalidad == 0) ? prm_def($param, "id_usuario_venta") : prm_def($param, "id_usuario");
        return "../imgs/index.php/enid/imagen_usuario/" . $id_usuario;

    }

    function sobre_el_producto($modalidad, $param)
    {


        $text = a_enid("Sobre -" . $param["nombre_servicio"],
             path_enid("producto", $param["id_servicio"])

        );

        return $text;
    }

    function val_respuestas($modalidad, $param)
    {

        return ($modalidad == 0) ? carga_iconos_buzon_compras($param) : carga_iconos_buzon_ventas($param);

    }

    function carga_iconos_buzon_ventas($param)
    {


        $id_pregunta = $param["id_pregunta"];

        $fecha_registro = $param["fecha_registro"];
        $id_usuario = $param["id_usuario"];
        $leido_vendedor = $param["leido_vendedor"];
        $nombre_servicio = $param["nombre_servicio"];
        $id_servicio = $param["id_servicio"];


        if ($leido_vendedor == 0) {

            $text = d("Nueva", [

                    "class" => 'blue_enid_background white pregunta fa fa-envelope',
                    "id" => $id_pregunta,
                    "registro" => $fecha_registro,
                    "usuario" => $id_usuario,
                    "leido_vendedor" => $leido_vendedor,
                    "nombre_servicio" => $nombre_servicio,
                    "servicio" => $id_servicio
                ]
            );


        } else {

            $text = d("Nueva", [

                    "class" => 'pregunta fa fa-envelope',
                    "id" => $id_pregunta,
                    "pregunta" => $param["pregunta"],
                    "registro" => $fecha_registro,
                    "usuario" => $id_usuario,
                    "leido_vendedor" => $leido_vendedor,
                    "nombre_servicio" => $nombre_servicio,
                    "servicio" => $id_servicio
                ]
            );


        }
        return $text;
    }

    function carga_iconos_buzon_compras($param)
    {

        $id_pregunta = $param["id_pregunta"];
        $num = (es_data($param["respuestas"])) ? pr($param["respuestas"], "respuestas") : 0;

        $text = "";
        $base_servicio = [
            "pregunta" => $param["pregunta"],
            "registro" => $param["fecha_registro"],
            "usuario" => $param["id_usuario"],
            "leido_vendedor" => $param["leido_vendedor"],
            "nombre_servicio" => $param["nombre_servicio"],
            "servicio" => $param["id_servicio"]
        ];


        if ($param["leido_cliente"] < 1 && $num > 0) {


            $base_servicio += [
                "class" => 'blue_enid_background white pregunta fa fa-envelope',
                "id" => $id_pregunta,
            ];

            $text = d("Nueva respuesta", $base_servicio);

        } else {

            if ($num > 0) {


                $base_servicio += [
                    "class" => 'white pregunta fa fa-envelope',
                    "id" => $id_pregunta,
                ];

                $text = d($num, $base_servicio);
            }
        }
        return $text;
    }
}