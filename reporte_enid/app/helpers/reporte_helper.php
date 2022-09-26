<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function render_reporte($data)
    {

        $response[] = tab_seccion(place("place_reporte"), 'reporte');
        $response[] = format_indicadores();
        $response[] = format_tipo_entrega();
        $response[] = format_actividad();
        $response[] = format_productos_solicitados();
        $response[] = format_accesos();
        $response[] = format_accesos_productos();
        $response[] = format_accesos_dominio();
        $response[] = format_accesos_franja_horaria();
        $response[] = format_accesos_time_line();
        
        $response[] = funnel_ventas();        
        $response[] = format_arquetipos($data);
        $response[] = format_comisionistas($data);
        $response[] = format_entregas();
        $response[] = format_tipificaciones();
        $response[] = format_motivos_cancelaciones();
        $response[] = format_evaluaciones();
        $response[] = format_top_ventas();
        $response[] = format_sin_ventas();


        $response[] = format_categorias($data);
        $res[] = d(menu(), "col-lg-2 contenedor_menu");
        $res[] = d(tab_content($response), "col-lg-7");
        $res[] = d(actualizaciones_del_dia($data), "col-lg-3 border-left");

        return d(append($res), "container-fluid");

    }
    function actualizaciones_del_dia($data){
        
        $totales_accesos[] = d(flex("Compras", place("numero_compras_efectivas_place"), _text_(_between, "strong f11")));      
        $totales_accesos[] = d(flex("Transacciones", place("numero_transacciones_place"), _text_(_between, "strong f11")));      
        $totales_accesos[] = d(flex("Cancelaciones", place("numero_cancelaciones_place"), _text_(_between, "f11 red_enid")));      
        $totales_accesos[] = d(flex("Personas que llegan externas", place("personas_trafico_place"), _between, "","strong f11"));    
        
        $totales_accesos[] = d(flex("Personas con iteracciones positivas", place("personas_interacciones_positivas_place"), _between, "","strong f11"));       
        $totales_accesos[] = d(flex("Personas con iteracciones negativas", place("personas_interacciones_negativas_place"), _text_(_between,"red_enid"), "","strong f11"));       
        
        $totales_accesos[] = d(flex("Iteracciones positivas en teléfono", place("personas_interacciones_positivas_telefono_place"), _between, "","strong f11"));       
        $totales_accesos[] = d(flex("Iteracciones positivas en desktop", place("personas_interacciones_positivas_dektop_place"), _between, "","strong f11"));       

        $totales_accesos[] = d(flex("Iteracciones negativas en teléfono", place("personas_interacciones_negativas_telefono_place"),  _text_(_between,"red_enid"), "","strong f11"));       
        $totales_accesos[] = d(flex("Iteracciones negativas en desktop", place("personas_interacciones_negativas_dektop_place"),  _text_(_between,"red_enid"), "","strong f11"));       



        $totales_accesos[] = d(flex("Vistas a productos", place("vista_a_producto"), _between, "","strong f11"));                
        $totales_accesos[] = d(flex("Ingreso a promociones", place("promociones_input"), _between, "","strong f11"));    
        /*6 lista de deseos*/
        $totales_accesos[] = d(flex("Lista de deseos", place("lista_deseos_place"), _between, "","strong f11"));           
        $totales_accesos[] = d(flex("Ingreso a procesar compra", place("procesar_compra_input"), _between, "","strong f11"));            
                
        /*17 click_whatsapp_input*/
        $totales_accesos[] = d(flex("Click en WhatsApp", place("click_whatsapp_place"), _text_(_between,"f12 black"), "","strong"));            
        /*43 click en trigger de facebook*/
        $totales_accesos[] = d(flex("Click en trigger de facebook", place("click_facebook_trigger_place"), _text_(_between,"f12 black"), "","strong"));            
        /*22 Click en producto recompensa*/
        $totales_accesos[] = d(flex("Click en producto recompensa", place("click_producto_recompensa_place"), _text_(_between,"f12 black"), "","strong f11"));            
        /*24  click_producto_recompensa_input*/
        $totales_accesos[] = d(flex("Ver fotos de clientes", place("click_en_ver_fotos_clientes_place"), _between, "","strong f11"));            

        /*25 click_en_formas_pago_input*/
        $totales_accesos[] = d(flex("Ver formas de pago", place("click_en_formas_pago_place"), _between, "","strong f11"));            
        /*26 Click en agregar carrito promoción desde el producto*/
        $totales_accesos[] = d(flex("Agregar carrito promoción", place("click_en_agregar_carrito_promocion_place"), _text_(_between,"f12 black"), "","strong f11"));            

        /*27 Click en agregar carrito desde el producto*/
        $totales_accesos[] = d(flex("Agregar carrito producto", place("click_en_agregar_carrito_place"), _text_(_between,"f12 black"), "","strong f11"));            

        
        

        $response[] = d($totales_accesos,"col-sm-12 border p-4");
        $response[] = d(place("funnel_ventas_hoy"),13);        
        $response[] = place("busquedas_productos");
        $response[] = place("dominios_que_apuntan_a_enid");
        $response[] = d(penetracion_alcaldias($data),13);        
        return append($response);
    }
    function format_categorias(array $data)
    {
        $r[] = h("CATEGORÍAS DESTACADAS", 3, "mb-5 h3 text-uppercase strong text-center");
        $r[] = crea_repo_categorias_destacadas(
            sub_categorias_destacadas($data["categorias_destacadas"]));

        return d(append($r),
            [
                "class" => "tab-pane",
                "id" => "tab_productos_publicos",
            ]
        );


    }

    function format_productos_solicitados()
    {
        $form = base_busqueda_form('PRODUCTOS MÁS BUSCADOS POR CLIENTES',
            'form_busqueda_productos_solicitados', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_busqueda_productos",
            ]
        );


    }
    function format_accesos()
    {
        $form = base_busqueda_form('ACCESOS POR PÁGINA',
            'form_busqueda_accesos_pagina', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_accesos_pagina",
            ]
        );


    }
    function format_accesos_productos()
    {
        $form = base_busqueda_form('ACCESOS POR ARTÍCULOS',
            'form_busqueda_accesos_pagina_productos', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_accesos_pagina_productos",
            ]
        );


    }
    function format_accesos_dominio()
    {
        $form = base_busqueda_form('ACCESOS POR DOMINIO',
            'form_busqueda_accesos_dominio', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_accesos_pagina_dominio",
            ]
        );


    }
    function format_accesos_franja_horaria()
    {
        $form = base_busqueda_form('ACCESOS POR FRANJA HORARIA',
            'form_busqueda_accesos_franja_horaria', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_accesos_franja_horaria",
            ]
        );
    }

    function format_accesos_time_line()
    {
        $form = base_busqueda_form('ACCESOS TIMELINE',
            'form_busqueda_accesos_time_line', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_accesos_time_line",
            ]
        );


    }

    function funnel_ventas()
    {
        $form = base_funnel('Funnel ventas','funnel_ventas');

        return d($form,
            [
                "class" => "tab-pane seccion_funnel_ventas",
                "id" => "tab_funnel_ventas",
            ]
        );


    }    
    
    

    function base_funnel($titulo_seccion,  $place){

        $r[] = h($titulo_seccion, 3, "mb-5 h3 text-uppercase strong");                
        $r[] = place(_text_($place, "mt-5"));

        return append($r);
    }
    function format_arquetipos($data)
    {
        $form = busqueda_arquetipo($data['tipo_tag_arquetipo'], 'HISTORIAS DE USUARIO (ARQUETIPOS)',
            'form_arquetipos', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_arquetipos",
            ]
        );
    }

    function format_comisionistas($data)
    {
        $form = base_busqueda_form('VENTAS POR COMISIONISTAS',
            'form_ventas_comisionistas', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_comisionistas",
            ]
        );

    }

    function format_entregas()
    {
        $form = base_busqueda_form('REPARTIDORES ENTREGAS',
            'form_entregas', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_entregas",
            ]
        );

    }


    function format_tipificaciones()
    {
        $form = base_busqueda_form('TIPIFICACIONES',
            'form_tipificaciones', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_tipificaciones",
            ]
        );


    }


    function format_evaluaciones()
    {

        $hoy = date_format(horario_enid(), 'Y-m-d');
        $ayer = add_date(date("Y-m-d"), -30);
        $form = base_busqueda_form('Evaluaciones',
            'form_evaluaciones', 'place_keywords', $ayer, $hoy);

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_evaluaciones",
            ]
        );
    }



    function format_sin_ventas()
    {

        $hoy = date_format(horario_enid(), 'Y-m-d');
        $ayer = add_date(date("Y-m-d"), -30);

        $form = base_busqueda_form('Articulos sin venta (requieren atención)',
            'form_sin_ventas', 'place_keywords', $ayer, $hoy );

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_sin_ventas",
            ]
        );
    }


    function format_top_ventas()
    {

        $hoy = date_format(horario_enid(), 'Y-m-d');
        $ayer = add_date(date("Y-m-d"), -30);

        $form = base_busqueda_form('Top artículos vendidos',
            'form_top_ventas', 'place_keywords', $ayer, $hoy);

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_top_ventas",
            ]
        );
    }

    function format_motivos_cancelaciones()
    {

        $form = base_busqueda_form('MOTIVOS CANCELACIONES',
            'form_motivos_cancelaciones', 'place_keywords');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => "tab_motivos_cancelaciones",
            ]
        );
    }

    function format_actividad()
    {

        $form = base_busqueda_form('USUARIOS',
            'f_actividad_productos_usuarios', 'repo_usabilidad');

        return d($form, [
                "class" => "tab-pane",
                "id" => 'tab_usuarios',
            ]
        );


    }

    function format_tipo_entrega()
    {

        $form = base_busqueda_form('TIPOS DE ENTREGAS', 'form_tipos_entregas',
            'place_tipos_entregas');

        return d($form,
            [
                "class" => "tab-pane",
                "id" => 'tab_tipos_entregas',
            ]
        );

    }

    function format_indicadores()
    {
        $form = base_busqueda_form(
            "indicadores", 'form_busqueda_global_enid', "place_usabilidad");

        return d($form,
            [
                "class" => "tab-pane active",
                "id" => 'tab_default_1',
            ]
        );

    }

    function base_busqueda_form(
        $titulo_seccion, $clase_form, $place, $fecha_inicio = 0, $fecha_termino = 0){


        $r[] = h($titulo_seccion, 3, "mb-5 h3 text-uppercase strong");
        $r[] = form_open("", ["class" => $clase_form]);
        $r[] = frm_fecha_busqueda($fecha_inicio, $fecha_termino);
        $r[] = form_close();
        $r[] = place(_text_($place, "mt-5"));

        return append($r);
    }

    function busqueda_arquetipo($tipo_tag_arquetipo, $titulo_seccion, $clase_form, $place)
    {


        $r[] = h($titulo_seccion, 3, "mb-5 h3 text-uppercase strong");
        $r[] = form_open("", ["class" => $clase_form]);
        $tipos = create_select(
            $tipo_tag_arquetipo, 'tipo_tag_arquetipo', 'tipo_tag_arquetipo',
            'tipo_tag_arquetipo', 'tipo', 'id_tipo_tag_arquetipo');
        $fechas = frm_fecha_busqueda();
        $r[] = flex_md($tipos, $fechas, _between, 4, 8);
        $r[] = form_close();
        $r[] = place(_text_($place, " mt-5"));

        return append($r);
    }


    function crea_repo_categorias_destacadas($param)
    {

        $r = [];
        foreach ($param as $row) {

            $total = p($row["total"], 'h4 strong');
            $href = path_enid("search", "/?q=&q2=" . $row["primer_nivel"]);
            $clasificacion = a_enid($row["nombre_clasificacion"],
                [
                    "href" => $href,
                    "class" => "black strong",
                ]
            );
            $r[] = d(flex($total, $clasificacion,
                'mt-2 justify-content-between align-items-center'), 4, 1);

        }

        return append($r);
    }


    function menu()
    {
        $link_accesos_pagina = tab(
            text_icon("fa-check-circle", "Accesos por página"),
            '#tab_accesos_pagina',
            [
                "class" => "btn_acceso_paginas"
            ]
        );

        $link_accesos_pagina_productos = tab(
            text_icon("fa-check-circle", "Accesos por productos"),
            '#tab_accesos_pagina_productos',
            [
                "class" => "btn_acceso_paginas_productos"
            ]
        );

        $link_accesos_pagina_web_dominio = tab(
            text_icon("fa-check-circle", "Accesos por dominio"),
            '#tab_accesos_pagina_dominio',
            [
                "class" => "btn_acceso_pagina_dominio"
            ]
        );

        $link_accesos_franja_horaria = tab(
            text_icon("fa-check-circle", "Accesos por franja horaria"),
            '#tab_accesos_franja_horaria',
            [
                "class" => "btn_acceso_franja_horaria"
            ]
        );

        $link_accesos_time_line = tab(
            text_icon("fa-check-circle", "Accesos Timeline"),
            '#tab_accesos_time_line',
            [
                "class" => "btn_acceso_time_line"
            ]
        );

        $link_indicadores = tab(
            text_icon('fa fa-globe', "indicadores"),
            '#tab_default_1',
            [
                "class" => 'text-uppercase text-uppercase btn_menu_tab cotizaciones black'
            ]
        );

        $link_productos_solicitados = tab(
            text_icon("fa fa-shopping-cart", "productos solicitados"),
            '#tab_busqueda_productos'
        );


        $link_tipos_entregas = tab(

            text_icon("fa fa-fighter-jet", "tipos entregas"),
            "#tab_tipos_entregas"

        );

        $link_usuarios = tab(
            text_icon("fa fa-user", "usuarios"),
            "#tab_usuarios",
            [
                "class" => "text-uppercase black btn_repo_afiliacion text-uppercase",
            ]
        );

        $link_ventas_categorias = tab(
            text_icon("fa-check-circle", "ventas por categorías"),
            "#tab_productos_publicos"
        );

        $link_motivos_cancelaciones = tab(
            text_icon("fa-check-circle", "motivos - cancelaciones"),
            "#tab_motivos_cancelaciones"
        );

        $link_evaluaciones = tab(
            text_icon("fa-check-circle", "Evaluaciones"),
            "#tab_evaluaciones"
        );

        $link_top_ventas = tab(
            text_icon("fa-check-circle", "Top artículos vendidos"),
            "#tab_top_ventas"
        );
        $text = text_icon("fa-check-circle", "Top comisionistas");
        $text_entrega = text_icon("fa-check-circle", "Top reparto");
        
        $text_estadisticas_comisionistas = text_icon("fa-check-circle", "Nuevos comisionistas");

        $link_sin_ventas = tab(
            text_icon("fa-check-circle", "artículos sin ventas"),
            "#tab_sin_ventas"
        );

        $link_vendedores = a_enid(
            $text,
            [
                "href" => path_enid("top_competencia"),
                "class" => 'text-uppercase black'
            ]
        );

        $link_reparto = a_enid(
            $text_entrega,
            [
                "href" => path_enid("top_competencia_entrega"),
                "class" => 'text-uppercase black'
            ]
        );

        $link_comisionistas = a_enid(
            $text_estadisticas_comisionistas,
            [
                "href" => path_enid("metricas_registros"),
                "class" => 'text-uppercase black'
            ]
        );


        $link_funnel = tab(
            text_icon("fa fa-shopping-cart", "Funnel ventas"),
            '#tab_funnel_ventas',
            [
                "class" => "funnel"
            ]
        );
        

        $list = [
            a_enid(text_icon(_money_icon, "Noticas"),
                [
                    
                    "href" => path_enid("busqueda"),
                    "class" => "text-uppercase black",                    
                ]
            ),
            a_enid(text_icon(_money_icon, "Puntos de ventas clientes"),
                [
                    
                    "href" => "https://www.google.com/maps/d/viewer?mid=1d8Y5RvysKd3rjpCBWk-w5JPvNrCDn5Hc&usp=sharing",
                    "class" => "text-uppercase black",
                    "target" => "_blank"
                ]
            ),            
            a_enid(text_icon(_money_icon, "Ventas por alcaldías"),
            [
                
                "href" => path_enid('indicadores_ubicaciones',0,1),
                "class" => "text-uppercase black",
                "target" => "_blank"
            ]
            ),
            
            a_enid(text_icon(_money_icon, "Próximas entregas"),
                [
                    
                    "href" => path_enid("entregas"),
                    "class" => "text-uppercase black",
                    "target" => "_blank"
                ]
            ),            
            tab(
                text_icon(_mas_opciones_icon, "Comisiones"),
                '#tab_comisionistas'
            ),
            tab(
                text_icon(_entregas_icon, "Repartidores"),
                '#tab_entregas'
            )
            ,
            tab(
                text_icon(_historia_icon, "Arquetipos"),
                '#tab_arquetipos'
            )
            ,
            a_enid(text_icon(_money_icon, "pedidos"),
                [
                    "id" => "btn_servicios",
                    "href" => path_enid("pedidos"),
                    "class" => "text-uppercase black   dispositivos",
                ]
            )

            ,
            a_enid(text_icon("fa-shopping-bag", "compras"),
                [
                    "id" => "btn_servicios",
                    "href" => path_enid("compras"),
                    "class" => "text-uppercase black dispositivos",
                ]
            )
            ,
            $link_indicadores
            ,
            a_enid(text_icon('fa fa-clock-o', "tiempo de venta"),
                [
                    "href" => path_enid("tiempo_venta"),
                    "class" => 'text-uppercase black',
                ]
            )
            ,

            $link_productos_solicitados
            ,
            $link_tipos_entregas
            ,
            $link_usuarios
            ,
            $link_ventas_categorias
            ,
            $link_motivos_cancelaciones
            ,
            $link_evaluaciones
            ,
            $link_top_ventas
            ,
            $link_sin_ventas
            ,
            $link_vendedores
            ,
            $link_reparto
            ,
            $link_comisionistas
            ,
            $link_accesos_pagina
            ,
            $link_accesos_pagina_productos
            ,
            $link_accesos_pagina_web_dominio
            ,
            $link_accesos_franja_horaria
            ,
            $link_accesos_time_line
            ,
            $link_funnel
            

        ];

        return append($list);
    }
}
