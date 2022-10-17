<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function recompensa($data)
    {

        $recompensa = $data["recompensa"];
        $response = [];
        $html_paginador = $data["html_paginador"];

        $texto = _text_(
            d(_text_(span("5% de descuento",'strong white'),
            "al enviar mensaje", span("aquí!", 'bg_white black p-1 mt-1 borde_rojo font-weight-bold underline f12'))),
             
        );

        $mensaje_messenger = a_enid(
            $texto,
            [
                "href" => path_enid('facebook_descuento', 0, 1),
                "class" => "white facebook_trigger p-2 borde_amarillo bg_black p-1  mt-3 row",
                "target" => "_black"
            ]
            );

        $response[] = $mensaje_messenger;


        if (es_data($recompensa)) {
            
            foreach ($recompensa as $row) {

                $status = $row["servicio"][0]["status"];
                $id_servicio = $row["id_servicio"];
                $id_servicio_conjunto = $row["id_servicio_conjunto"];
                $url_img_servicio = $row["url_img_servicio"];
                $url_img_servicio_conjunto = $row["url_img_servicio_conjunto"];                
                $id_recompensa = $row["id_recompensa"];


                $texto_totales = totales($row, $data);
                $imagen_servicio = servicio_dominante($url_img_servicio, $id_servicio);
                $imagen_servicio_conjunto = servicio_propuesta($url_img_servicio_conjunto, $id_servicio_conjunto);
                $editar_comprar = editar_comprar($data, $id_recompensa);

                $extra = ($status < 1) ? 'border border-danger' : '';
                $clase_imagen = _text_('col-xs-3', $extra);
                $promocion = [
                    d($imagen_servicio, $clase_imagen),
                    d("+","f12 strong"),
                    d($imagen_servicio_conjunto, $clase_imagen),
                    d($texto_totales, "col-xs-4")

                ];


                $seccion_fotos = d($promocion, _text_('d-flex', _between));
                $clase_flex = _text_(_between, "row border-bottom border-secondary");
                $clase_izquierda = "col-xs-9 mb-5";
                $clase_derecha = "col-xs-3 p-0";
                $seccion_fotos_compra = flex(
                    $seccion_fotos, $editar_comprar, $clase_flex, $clase_izquierda, $clase_derecha);

                $extra = is_mobile() ? "border-bottom" : "";
                $response[] = d($seccion_fotos_compra, _text_("row mt-5", $extra));


            }
            $response[] =  d($html_paginador,  'mt-5');
            $interes = h("TAMBIÉN PODRÍA INTERESARTE", 2, "  h3 text-uppercase black font-weight-bold");
            $response[] = d($interes, "mt-5 text_sugerencias d-none ");
            $response[] = d("", "place_tambien_podria_interezar");

            $response[] = resumen_recompensa();
            
            
        }
        
        $response[] = modal_nueva_recompensa();      
        
        $response[] = botones_ver_mas();  
        return d($response, 'col-xs-12 col-sm-12 col-md-10 col-md-offset-1');

    }
    function botones_ver_mas()
    {

        $link_productos =  format_link("Ver más promociones", [
            "href" => path_enid("search", _text("/?q2=0&q=&order=", rand(0, 8),'&page=',rand(0, 5))),
            "class" => "border"
        ]);

        $link_facebook =  format_link("Facebook", [
            "href" => path_enid("facebook",0,1),
            "class" => "border mt-4",
            'target' => 'blank_'
        ],0);

        $link_instagram =  format_link("Instagram", [
            "href" => path_enid("fotos_clientes_instagram",0,1),
            "class" => "border mt-4",
            'target' => 'blank_'
        ],0);
        

        $response[] = d($link_productos, 4, 1);
        $response[] = d($link_facebook, 4, 1);
        $response[] = d($link_instagram, 4, 1);

        return d($response,'col-sm-12 mt-5');
    }
    function modal_nueva_recompensa(){

        
        $contenido[] = place("place_nueva_recompensa");          
        return gb_modal($contenido, 'modal_recompensa');
    }
    function nueva_promocion($data){
        
        $es_administrador = es_administrador($data);
        $response = "";
        if ($es_administrador) {
            
            $boton_promocion =
            format_link("Agregar promoción",["class"=> "agregar_promocion"]);
            $response =  d($boton_promocion);
        }
        return $response;
    }

    function editar_comprar($data, $id_recompensa)
    {

              
        $antecedentes = $data["in_session"];
        $es_administrador = es_administrador($data);
        $editar = icon(
            _text_(_editar_icon, "edicion_recompensa"), 
            [ 
                
                "id" => $id_recompensa
            ]
        );

        $editar = ($es_administrador) ? $editar : "";

        $agregar_a_carrito =  d("Agregar al carrito",
            [

                "class" => "cursor_pointer p-1 bottom_carro_compra_recompensa borde_accion text-uppercase font-weight-bold white border text-center",
                "id" => $id_recompensa, 
                "antecedente_compra" => $antecedentes
            ]
        );


        return flex($editar , $agregar_a_carrito, _text_("flex-column"));


    }

    function totales($row , $data)
    {

        $precio_servicio = $row["precio"];
        $precio_conjunto = $row["precio_conjunto"];
        $descuento = $row["descuento"];        
        $total = ($precio_conjunto + $precio_servicio) - $descuento;
        $total_sin_descuento = ($precio_conjunto + $precio_servicio);
        $total_sin_descuento = ($descuento > 0) ? del(money($total_sin_descuento)) : '';
        
        $por_cobrar = money($total);
        $texto_comisiones = ganancia_vendedor($data, $precio_servicio, $precio_conjunto , $descuento);        
        $utilidad = utilidad_venta_conjunta($data, $row,1);

        $elementos = [
            d("Total", 'strong'),
            d($total_sin_descuento),
            d($por_cobrar, 'red_enid'),
            d($texto_comisiones),
            d($utilidad),            
        ];

        return d($elementos, 'd-flex flex-column');

    }

    function servicio_dominante($url_img_servicio, $id_servicio)
    {
        $link_servicio = path_enid("producto", $id_servicio);
        $extra =  is_mobile() ? 'w-100' : 'mh_250 mh_230 mh_sm_310 mx-auto';
        $imagen = img(
            [
                'src' => $url_img_servicio,
                'class' => $extra,
                'href' => $link_servicio,
                'onClick'=>'log_operaciones_externas(22)'
            ]
        );
        return a_enid($imagen,
            [

                'href' => $link_servicio,
                "target" => "_blank"
            ]
        );


    }

    function servicio_propuesta($url_img_servicio_conjunto, $id_servicio_conjunto)
    {

        $link_servicio_conjunto = path_enid("producto", $id_servicio_conjunto);
        $extra =  is_mobile() ? 'w-100' : 'mh_250 mh_230 mh_sm_310 mx-auto';
        $imagen_servicio_conjunto = img(
            [
                'src' => $url_img_servicio_conjunto,
                'class' => $extra,
                'onClick'=>'log_operaciones_externas(22)'
            ]
        );
        return a_enid($imagen_servicio_conjunto,
            [
                "href" => $link_servicio_conjunto,
                "target" => "_blank"
            ]
        );


    }
    function resumen_recompensa()
    {
               
        $contenido[] = place("resumen_recompensa");                
        return gb_modal($contenido, 'modal_resumen_recompensa');

    }
    function configuracion_paginador($param, $numero_recompensas)
    {
        $page = prm_def($param, "page",1); /*Pagina actual*/        
        $per_page = prm_def($param, "rpg", 8); //la cantidad de registros que desea mostrar        
            
        $conf["page"] = $page;
        $conf["totales_elementos"] = $numero_recompensas;
        $conf["per_page"] = $per_page;
        $conf["q"] = "";
        $conf["q2"] = "";
        return $conf;

    }

}
