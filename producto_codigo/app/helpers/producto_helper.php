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
            $text_precio = $precio * $articulos;
            $text_precio_alto = $precio_alto * $articulos;


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
            $z[] = h(money($text_precio - 150), 2, 'strong');


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
            "Aquí tienes un descuento de $150 pesos",
            "text-center display-5 black mt-2 text-uppercase strong"
        ), 12);

        $pagina[] = d(d("", ["id" => "contador", "class" => "bg_black white text-center borde_amarillo p-3 display-6 strongs"]), 'col-xs-12 mt-3     ');


        $id_servicio = $data["id_servicio"];


        $response_agendar[] = format_link(
            
                "Quiero la oferta!",

            [
                'class' => 'en_lista_deseos white cursor_pointer ',
                "onclick" => "agregar_deseos_sin_antecedente_promocional($id_servicio)"
            ],2
        );


        $pagina[] = d(select_cantidad_compra(0, 2, 1), 'd-none');
        $mirar_opciones = format_link(
            "ver más kits!",
            [
                "href" => path_enid("kist-mas-vendidos"),
                "class" => "cursor_pointer"
            ],
            0
        );

        $pagina[] = d(producto_deseado($data["producto"], $data["img"]), 'col-xs-12 mt-5 mb-5');
        $pagina[] = d(flex(append($response_agendar), $mirar_opciones, _text_(_between, 'selectores ')), 'col-xs-12 mb-2 cursor_pointerst');
        $pagina[] = d(d(span("Solo quedan 3 piezas disponibles",'p-1 border_red_b strong')),'col-xs-12 mb-5 mt-2');
        $pagina[] = d(cargando(), 'text-center col-xs-12 mb-3');

        $pagina[] = d(
            "Pagas al recibir tus artículos en tu domicilio",
            'mt-3 col-xs-12 black mb-4'
        );

        
        $response[] = d(d($pagina, 13), 'col-lg-4 col-lg-offset-4 borde_black mt-5 contenedor_promocion');
        $response[] = form_lead($id_servicio,$data["producto"]);
        return append($response);
    }
    function form_lead($id_servicio, $servicio)
    {

        if(es_data($servicio)){
            $servicio = $servicio[0];
        }
        $clase_paso = "black white bg_black round mr-3 rounded-circle  pr-3 pl-3 pt-1 pb-2";
        

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
        $form[] = d(input_enid(
            [
                "type" => "text",
                "name" => 'nombre',
                "id" => "nombre",
                "placeholder" => "Nombre",
                "class" => "nombre_registro input-field mh_50 border border-dark  solid_bottom_hover_3 form-control "

            ],
            _text_nombre
        ), 'input_nombre');

        
        $inicio = substr(sha1(mt_rand()), 1, 20);
        $fin = substr(sha1(mt_rand()), 1, 20);
        

        $form[] = d(hiddens(
            [
                
                "name" => 'id_servicio',
                "id" => "id_servicio",                                                
                "class" => "id_servicio_registro",
                "value" =>  $id_servicio,

            ]
        ), 'd-none input_email');


        $form[] = hiddens(
            [
                "class" => "id_ciclo_facturacion",
                "name" => "ciclo_facturacion",
                "value" => $servicio["id_ciclo_facturacion"],
            ]
        );
        $form[] = hiddens(
            [
                "class" => "num_ciclos",
                "name" => "num_ciclos",
                "value" => 1,
            ]
        );

        
        $form[] = hiddens(
            [
                "class" => "tipo_entrega",
                "name" => "tipo_entrega",
                "value" => 2,
            ]
        );
        $form[] = hiddens(
            [
                "class" => "id_carro_compras",
                "name" => "id_carro_compras",
                "value" => 0,
            ]
        );
        $form[] = hiddens(
            [
                "class" => "carro_compras",
                "name" => "carro_compras",
                "value" => "",
            ]
        );

        $form[] = hiddens([
                "name" => 'fecha_servicio',
                "class" => "fecha_servicio",
                "type" => 'date',
                "value" => date("Y-m-d"),
                "min" => date("Y-m-d"),
                "max" => add_date(date("Y-m-d"), 35),
                "id" => "fecha_servicio",
            ]);

        $config =
                [
                    "name" => "producto_carro_compra[]",                    
                    "type" => "checkbox",
                    "class" => _text("producto_", $id_servicio)
                ];
        $form[] = hiddens($config);
            

        $config =
            [
                "name" => "recompensas[]",
                "value" => 0,
                "type" => "checkbox",
                "class" => _text("recompensa_", 0)
            ];
        $form[] = hiddens($config);


        $form[] = hiddens(
            [
                
                "name" => 'mail',
                "id" => "email_registro",                                                
                "class" => "email_registro",
                "value" =>  _text($inicio, '@', $fin, '.com')

            ]
        );

        $form[] = hiddens(
            [
                "class" => "id_ciclo_facturacion",
                "name" => "ciclo_facturacion",
                "value" => $servicio["id_ciclo_facturacion"],
            ]
        );

        $input_password = d(input(
            [
                "type" => "password",
                "placeholder" => "password",
                "name" => 'pw',
                "value" => sha1(mt_rand()),
                "id" => "pw",
                "class" => "pw_registro input-field mh_50 border border-dark solid_bottom_hover_3 form-control "
            ],
            _text_password
        ), 'input_password d-none');


        $form[] = d(
            $input_password,
            " input_password d-none "
        );
        $form[] = d(d("Ingresa una contraseña", "mt-3 color_red d-none place_input_form_password "), 'input_password d-none');

        $form[] = d("¿En qué número telefónico podemos contactarte?", 'strong mb-2 mt-2 input_telefono d-none');
        $form[] = d(input_enid(
            [
                "type" => "tel",
                "name" => 'telefono',
                "maxlength" => 10,
                "minlength" => 8,
                "id" => "telefono",
                "placeholder" => "Teléfono (10 digitos)",
                "class" => "telefono_registro 
                input-field mh_50 border border-dark  solid_bottom_hover_3 form-control"

            ],
            _text_telefono
        ), 'input_telefono d-none');
        
        $form[] = btn("CONTINUAR", ["class" => "mt-5 accion_continuar_registro"]);        
        $form[] = form_close();
        

        return gb_modal(append($form), 'lead_modal');
    }

}
