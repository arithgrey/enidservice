<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function producto_deseado($productos_deseados, $img)
    {

        $response = [];

        foreach ($productos_deseados as $row) {

            $id_producto = $row["id_servicio"];
            $precio = $row["precio"];
            $precio_alto = ($row["precio_alto"] > $precio ) ?  $row["precio_alto"] : ($precio + porcentaje($precio,16));
            
            $articulos = 1;

            $r = [];
            $url_servicio = get_url_servicio($id_producto);
            $config = ["href" => $url_servicio];

            $nombre_imagen = pr($img, "nombre_imagen");

            $imagen = a_enid(img(get_url_servicio($nombre_imagen, 1)), $config);
            $text_precio =  $precio * $articulos;
            $text_precio = porcentaje($text_precio, 10);
            $text_precio_alto = $precio_alto * $articulos;
            $text_precio_alto = porcentaje($text_precio_alto, 10);


            $seccion_imagen_seleccion_envio =
                flex("", $imagen, _between_start);
            $r[] = d($seccion_imagen_seleccion_envio, "col-xs-5 col-sm-3 p-0");
            $x = [];

            $nombre_servicio = $row["nombre_servicio"];
            $link = a_enid(
                $nombre_servicio,
                [
                    "href" => $url_servicio,
                    "class" => "black"
                ]
            );
            $x[] = h($link, 4, ["class" => "mb-5"]);


            $r[] = d($x, 'col-xs-5');
            $z = [];
            $z[] = h(money($text_precio), 2, 'strong');


            $z[] = h(del(money($text_precio)), 5, ' red_enid');

            if ($precio_alto > $precio) {
                $z[] = h(del(money($text_precio_alto)), 5, ' red_enid');
            }


            $r[] = d($z, 'col-sm-4 text-right d-md-block ');

            $response[] = d($r, 'col-md-12 mb-2');
        }


        return d($response, 13);
    }
    function render_producto_codigo($data)
    {

        $pagina[] =  d(d(
            "Logra tus objetivos ya!",
            "text-center color_grey display-6 mt-5"
        ), 12);
        $pagina[] =  d(d(
            "Aquí tienes un descuento",
            "text-center display-5 black mt-2 text-uppercase strong"
        ), 12);

        $pagina[] = d(d("", ["id" => "contador", "class" => "bg_black white text-center borde_amarillo p-3 display-6 strongs"]), 'col-xs-12 mt-3');

        $response_agendar[] = format_link(
            "Quiero la oferta!",
            [
                'class' => 'white cursor_pointer quiero_oferta',
            ],
            2
        );

        $pagina[] = d(producto_deseado($data["producto"], $data["img"]), 'col-xs-12 mt-5 mb-5');
        $pagina[] = d(append($response_agendar), 'col-xs-12 mb-4 cursor_pointerst');
        $pagina[] = d(d(span("Solo quedan 3 piezas disponibles", 'p-1 border_red_b strong')), 'col-xs-12 mb-5');

        $pagina[] = d(cargando(), 'text-center col-xs-12 mb-5');
        $pagina[] = d(
            "Pagas al recibir tus artículos en tu domicilio",
            'mt-3 col-xs-12 black mb-4'
        );

        $response[] = d(d($pagina, 13), 'col-lg-4 col-lg-offset-4 borde_black mt-5 contenedor_promocion');
        $response[] = form_lead();
        return append($response);
    }
    function form_lead()
    {

        $clase_paso = "black white bg_black round mr-3 rounded-circle  pr-3 pl-3 pt-1 pb-2";
        $clase_paso_faltante = "black white bg_gray round mr-3 rounded-circle  pr-3 pl-3 pt-1 pb-2";

        $paso[] = flex(
            "1",
            "CARRITO",
            "",
            $clase_paso,
            "mt-2 strong fp9"
        );

        $paso[] = flex(
            "2",
            "ENTREGA",
            "ml-4",
            "black white bg_gray round mr-3 rounded-circle  pr-3 pl-3 pt-1 pb-2 paso_2",
            "mt-2 strong fp9"
        );

        $paso[] = flex(
            "3",
            "ENVIADO",
            "ml-4",
            "black white bg_gray round mr-3 rounded-circle  pr-3 pl-3 pt-1 pb-2 paso_3",
            "mt-2 font-weight-bold color-secondary fp9"
        );



        $form[] = d(d($paso, 'mb-3 row'), 12);
        $form[] = d(d("", "border-bottom border-secondary mb-3 row "), 12);

        $attr = add_attributes(
            [
                "class" => "form_lead",
                "method" => "POST"
            ]
        );
        $form[] = "<form " . $attr . ">";
      
        $form[] = h('INFORMACIÓN DE ENTREGA', 2, 'text-uppercase strong');
        $form[] = d(
            flex(
                icon("fa black fa fa-truck"),
                "Solo usaremos estos datos para ayudarnos a entregar tu pedido",
                "mb-5",
                "mr-2"

            ),
            'black mb-3'

        );

        $form[] = d("¿Cual es tu nombre?", 'strong mb-2 input_nombre');
        $form[] = d(input(
            [
                "type" => "text",
                "name" => 'nombre',
                "id" => "nombre",
                "placeholder" => "Nombre",
                "class" => "nombre_registro input-field mh_50 border border-dark  solid_bottom_hover_3 form-control "

            ],
            _text_correo
        ), 'input_nombre');

        $form[] = d(d(_text_nombre, "mt-3 color_red d-none place_input_form_nombre"), 'input_nombre');


        $form[] = d("¿Cual es tu email?", 'strong mb-2 d-none input_email');
        $form[] = d(input(
            [
                "type" => "email",
                "name" => 'mail',
                "id" => "email_registro",
                "onkeypress" => "minusculas(this);",
                "placeholder" => "CORREO ELECTRÓNICO",
                "class" => "email_registro input-field mh_50 border border-dark  solid_bottom_hover_3 form-control "

            ],
            _text_correo
        ), 'd-none input_email');

        $form[] = d(d("Ingresa tu email", "mt-3 color_red d-none place_input_form_correo "), 'd-none input_email');

        $form[] = d("Registra una contraseña", 'strong mb-2 input_password d-none');
        $input_password = d(input(
            [
                "type" => "password",
                "placeholder" => "password",
                "name" => 'pw',
                "id" => "pw",
                "class" => "pw_registro input-field mh_50 border border-dark solid_bottom_hover_3 form-control "
            ],
            _text_password
        ), 'input_password d-none');


        $iconos = _text_(
            icon("fa fa-eye mostrar_password"),
            icon("fa fa-eye-slash ocultar_password d-none")
        );
        $form[] = flex(
            $input_password,
            $iconos,
            _text_(_between, 'mt-4'),
            "w-100",
            "border border-dark p-4 input_password d-none "
        );
        $form[] = d(d("Ingresa una contraseña", "mt-3 color_red d-none place_input_form_password "), 'input_password d-none');
        $form[] = btn("CONTINUAR", ["class" => "mt-5 accion_continuar_registro"]);

        
        $form[] = form_close();
        $form[] = cargando();



        $attr = add_attributes(
            [
                "class" => "form_ubicacion d-none",
                "method" => "POST"
            ]
        );

        $form[] = "<form " . $attr . ">";


        $form[] = d("¿Cual es la dirección de entrega?", 'strong mb-2 input_direccion');
        $form[] = d(input(
            [
                "type" => "text",
                "name" => 'ubicacion',
                "id" => "ubicacion",
                "placeholder" => "Dirección de entrega o link de google maps",
                "class" => "direccion_registro input-field mh_50 border border-dark solid_bottom_hover_3 form-control "

            ],
            _text_correo
        ), 'input_direccion');
        
        $form[] = d(d('¿Donde entregaremos tu kit?', "mt-3 color_red d-none place_input_form_ubicacion"));
        


        $form[] = d("¿En qué número telefónico podemos contactarte?", 'strong mb-2 mt-5 input_telefono');
        $form[] = d(input(
            [
                "type" => "tel",
                "name" => 'telefono',
                "id" => "telefono",
                "placeholder" => "Teléfono",
                "class" => "telefono_registro 
                input-field mh_50 border border-dark  solid_bottom_hover_3 form-control"

            ],
            _text_correo
        ), 'input_telefono');


        $form[] = d(d('¿En qué telefono te podemos contactar?', "mt-3 color_red d-none place_input_form_telefono"));

        $form[] = hiddens(["name" => "id", "class" =>"id_lead"]);
        
        $form[] = btn("Solicitar entrega", ["class" => "mt-5 accion_continuar_registro_ubicacion"]);
        $form[] = form_close();

        $form[] = d(d(format_link("Listo enviarémos tu kit a la brevedad!",
        [
            "href" => path_enid("kist-mas-vendidos"),
            
        ]),"envio row d-none"),12);
        return gb_modal(append($form), 'lead_modal');
    }
}
