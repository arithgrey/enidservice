<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function recompensa($data)
    {

        $recompensa = $data["recompensa"];
        $response[] = nueva_promocion($data);

        if (es_data($recompensa)) {

            $texto = "Promociones similares";
            $response[] = d($texto, ["class" => "mt-5 h4 text-uppercase black font-weight-bold"]);

            foreach ($recompensa as $row) {

                $id_servicio = $row["id_servicio"];
                $id_servicio_conjunto = $row["id_servicio_conjunto"];
                $url_img_servicio = $row["url_img_servicio"];
                $url_img_servicio_conjunto = $row["url_img_servicio_conjunto"];                
                $id_recompensa = $row["id_recompensa"];


                $texto_totales = totales($row, $data);
                $imagen_servicio = servicio_dominante($url_img_servicio, $id_servicio);
                $imagen_servicio_conjunto = servicio_propuesta($url_img_servicio_conjunto, $id_servicio_conjunto);
                $editar_comprar = editar_comprar($data, $id_recompensa);


                $clase_imagen = 'col-xs-4';
                $promocion = [
                    d($imagen_servicio, $clase_imagen),
                    d("+"),
                    d($imagen_servicio_conjunto, $clase_imagen),
                    d($texto_totales, $clase_imagen)

                ];


                $seccion_fotos = d($promocion, _text_('d-flex', _between));
                $clase_flex = _text_(_between, "row");
                $clase_izquierda = "col-xs-9";
                $clase_derecha = "col-xs-3 p-0";
                $seccion_fotos_compra = flex(
                    $seccion_fotos, $editar_comprar, $clase_flex, $clase_izquierda, $clase_derecha);

                $extra = is_mobile() ? "border-bottom" : "";
                $response[] = d($seccion_fotos_compra, _text_("row mt-5", $extra));


            }

            $response[] = resumen_recompensa();
            
        }
        $response[] = modal_nueva_recompensa();
        $response[] = hiddens(["class"=>"servicio_dominante_recompensa", "value" => $data["id_servicio"]]);
        return d($response, 'col-xs-12 col-sm-12 col-md-8 col-md-offset-2');

    }

    function modal_nueva_recompensa(){
        
        $contenido[] = input_frm(12, 'Filtrar',
        [
            "id" => "textinput",
            "name" => "textinput",
            "placeholder" => "Nombre del producto o servicio",
            "class" => "q_recompensa",
            "onkeyup" => "onkeyup_colfield_check(event);"
        ]
    );
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

        $imagen = img(
            [
                'src' => $url_img_servicio,
                'class' => 'w-100',
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
        $imagen_servicio_conjunto = img(
            [
                'src' => $url_img_servicio_conjunto,
                'class' => 'w-100',
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

}
