<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function cancelacion_venta_vendedor($data)
    {


        $info = $data["info"];
        $r = [];
        if (es_data($info)) {

            $i = $info["usuario_notificado"];

            $text = _text(
                "Buen día ",
                pr($i, "nombre")

            );
            $r[] = d($text, ["style" => "margin-top: 20px;text-decoration: underline;"]);
            $r[] = _d(
                "Equipo Enid Service.",
                "Nos encanta que emplees Enid Service para comprar y vender productos y servicios en Internet, te informamos que de momento una de tus compras ha sido cancelada por el vendedor, ",
                strong("pero mantén la calma!"),
                ", tu saldo se encuentra seguro en tu cuenta de Enid service, ya sea que desees emplear este para comprar otros artículos o retirar el mismo de tu cuenta puedes hacerlo accediendo aquí.",
                "Si tienes alguna duda o algún comentario con gusto estamos para escucharte puedes contactarnos a través de alguno de los siguientes medios que se indican aquí!",
                "Si quisieras calificar al vendedor o agregar algún comentario respecto a tu experiencia en esta compra "
            );

            $r[] = a_enid(
                "puedes hacerlo aquí.",
                [
                    "style" => "background: blue;color: white;padding: 5px;",
                    "href" => _text("https://enidservices.com/",_web,"/valoracion/?servicio=" , $info["id_recibo"]),
                ]
            );
            $r[] = d("Estamos en contacto y no dudes en contactarnos para este u otro tema relacionado!");
            $r[] = a_enid(
                img(
                    [
                        "src" => path_enid('logo_enid'),
                        "width" => "300px",
                    ]
                ),
                [
                    "href" => path_enid('enid'),
                ]
            );

        }

        return append($r);


    }

    function evaluacion($data)
    {

        $url = $data["url_request"];

        $r[] = d(
            a_enid(img(
                [
                    "src" => '../img_tema/enid_service_logo.jpg'
                    ,
                    'width' => '100%',
                ]
            ),
                [
                    'href' => $url . "contact/#envio_msj",
                ]
            ), 4, 1);
        $r[] = d(
            h('RECIBIMOS TU NOTIFICACIÓN!', 3,
                [
                    "style" => "font-size: 2em;"
                ]
            ), 6,
            1);
        $r[] = hr();
        $ver_promos = add_element("Ver más promociones", "button", ["class" => "btn a_enid_black"]);
        $r[] = d(
            a_enid(
                $ver_promos,
                [
                    "href" => $url
                ]
            ), 6, 1
        );
        $r[] = d(a_enid("Anuncia tus artículos",
            ["href" => $url . "login", "class" => "anunciar_productos"]), 6, 1);

        return d(append($r), 6, 1);

    }

    function evaluacion_servicios($data)
    {
        $r[] = d("Primero que nada un cordial saludo ");
        $r[] = d("Equipo Enid Service.");
        $r[] = d("El motivo por el cual nos estamos poniendo en contacto con usted, es con la finalidad 
        de saber si hasta este momento el servicio que le hemos brindado, está satisfaciendo, simplificando o mejorando 
        sus labores, para nosotros es muy importante conocer su experiencia y entender a qué obstáculos se está enfrentando
        , con esto juntos podríamos idear una solución oportuna que satisfaga las dos partes. ");

        $r[] = d("No me queda más que pedirle que nos envíe sus comentarios o si así lo prefiere evalúe nuestros servicios ");
        $r[] = a_enid("en este enlace.",
            [
                "href" => "https://goo.gl/DTHQid",
                "style" => "background: blue;color: white;padding: 5px;",
            ]);

        $r[] = a_enid("Le recordamos que puede acceder a su cuenta Enid Service a través de este enlace",
            [
                "href" => _text("https://enidservices.com/",_web,"/login"),
                "style" => "background: blue;color: white;padding: 5px;",
            ]);

        return append($r);
    }

    function recordar_publicaciones($data)
    {


        $r[] = d("Hemos tenido pocas noticias sobre ti!, ");
        $r[] = d("Excelente día " . $data["nombre"] . "-" . $data["email"] . " hemos tenido pocas noticias sobre ti, ahora
         hay más personas que están vendiendo y comprando sus productos a través de Enid Service, la plataforma 
         de comercio electrónico de México, apresurate y anuncia tus artículos y servicios para llegas a más personas
          que están en busca de lo que ofreces! ");
        $r[] = a_enid("Puedes acceder a su cuenta Enid Service aquí!",
            [
                "href" => _text("https://enidservices.com/",_web,"/login"),
                "style" => "background: blue;color: white;padding: 5px;",
            ]);

        $r[] = a_enid(img([
            "src" => _text("https://enidservices.com/",_web,"/img_tema/enid_service_logo.jpg"),
            "width" => "300px",
        ]),
            [
                "href" => "https://enidservices.com/",
            ]);
        $r[] = hr();

        $r[] = a_enid(
            "YA NO QUIERO RECIBIR ESTE CORREO",
            [
                'href' => $data["url_cancelar_envio"],
                'style' => 'color:black;font-size:.9em;font-weight:bold',
            ]);

        return append($r);
    }

    function ticket_soporte($param)
    {


        $usuario = $param["usuario"];
        $ticket = $param["ticket"];
        $extra = $param["extra"];
        $r = [];
        if (es_data($usuario)) {

            $usuario = $usuario[0];
            $nombre_usuario =
                $usuario["name"] . " " .
                $usuario["apellido_paterno"] .
                $usuario["apellido_materno"] . " -  " .
                $usuario["email"];

            $lista_prioridades = ["", "Alta", "Media", "Baja"];
            $asunto = "";
            $mensaje = "";
            $prioridad = "";
            $nombre_departamento = "";

            foreach ($ticket as $row) {

                $asunto = $row["asunto"];
                $mensaje = $row["mensaje"];
                $prioridad = $row["prioridad"];
                $nombre_departamento = $row["nombre_departamento"];
            }

            $r[] = label("Nuevo ticket abierto" . $extra["ticket"]);
            $r[] = d("Cliente que solicita " . $nombre_usuario);

            $r[] = btw(
                strong("Prioridad:"),
                $lista_prioridades[$prioridad]
            );

            $r[] = btw(
                strong("Departamento a quien está dirigido:"),
                $nombre_departamento
            );

            $r[] = btw(
                strong(" Asunto:"),
                $asunto
            );
            $r[] = btw(
                strong("Reseña:"),
                $mensaje

            );

        }

        return append($r);
    }
}

