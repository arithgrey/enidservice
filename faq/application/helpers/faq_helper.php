<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_faqs($data)
    {

        $r[] = div(get_format_izquierdo($data["categorias_publicas_venta"], $data["categorias_temas_de_ayuda"] , 1 ), 3);
        $r[] = div(get_format_listado_fq($data),9);
        return div(append_data($r), 1);

    }
    function get_format_listado_fq($data){


        $response =  "";
        if ( array_key_exists("faqs_categoria" , $data) && $data["faqs_categoria"] >  0 ){

            $response  = get_lista_categoria($data["faqs_categoria"]);

        }else{

            if ( array_key_exists("respuesta" , $data) && $data["respuesta"] >  0 ){

                if(array_key_exists("param" , $data) && array_key_exists("config" , $data["param"] ) ){

                    $response =  get_form_respuesta($data,1);

                }else{

                    $response =  get_lista_faq($data["respuesta"], $data);
                }

            }else{

                if ($data["es_form"] >  0 ){

                    $response =  get_form_respuesta($data);

                }
            }
        }
        return $response;

    }
    function get_lista_categoria($faqs){

        $r      =   [];

        foreach ($faqs as $row ){


            $id_faq =  $row["id_faq"];
            $titulo =  $row["titulo"];
            $url_img =  $row["url_img"];


            $bloque  =  get_btw(
                div(
                    img(
                        [
                            "src"=> $url_img,
                            "class" => "mh_270"
                        ]
                    ),
                    3
                )
                ,
                div(heading_enid($titulo,4 , "black text-uppercase"), 9)
                ,
                "row mh_200 border top_30 "

            );

            $r[]  =  anchor_enid($bloque, "../faq/?faq=".$id_faq );

        }

        return append_data($r);

    }
    function get_lista_faq($respuestas, $data){

        $r      =   [];

        foreach ($respuestas as $row ){

            $id_faq =  $row["id_faq"];
            $titulo =  $row["titulo"];
            $respuesta =  $row["respuesta"];
            $fecha_registro=  $row["fecha_registro"];


            $extra = ( $data["in_session"] >  0 ) ? anchor_enid(icon("fa fa-cogs") , [ "href" => path_enid("editar_faq" , $id_faq."&config=1")])  : "";
            $x[]  = div( heading_enid($extra.$titulo,4 , "black text-uppercase underline"),1);
            $x[]  = div( p($respuesta, "black top_30"),1);
            $x[]  = div( p($fecha_registro , "top_30"),1);
            $response = append_data($x);


            $r[]  =  div(
                $response
                ,
                "col-lg-12 top_30 padding_10 "
            );

        }

        return append_data($r);
    }
    function valida_format_respuestas_menu($in_session, $lista_categorias)
    {
        $response = "";
        if ($in_session > 0) {
            $response = div(get_form_respuesta($lista_categorias), ["class" => "tab-pane fade", "id" => "tab2default"]);
        }
        return $response;

    }

    function get_format_fq($flag_categoria, $flag_busqueda_q, $faqs_categoria, $respuesta, $in_session, $perfil)
    {


        $r = [];
        if ($flag_categoria > 0) {

            $r[] = get_format_faq_categorias($faqs_categoria);

        }if ($flag_busqueda_q > 0) {

            $r[] = get_formar_respuesta($respuesta, $in_session, $perfil);
        }
        return append_data($r);

    }

    function get_format_listado_categorias($categorias_publicas_venta, $categorias_temas_de_ayuda)
    {

        $r[] = div(lista_categorias($categorias_publicas_venta));
        $r[] = div(place("place_categorias_extras"));
        $r[] = div(lista_categorias($categorias_temas_de_ayuda));
        return div(append_data($r), "categorias_frecuentes padding_10 shadow top_30 border ");

    }

    function get_form_respuesta($data, $editar = 0 )
    {

        $lista_categorias = $data["lista_categorias"];

        $id_faq   = 0;
        $respuesta      = "";
        $titulo =  "";
        $id_categoria = 0;
        $status = 0;
        if( $editar > 0 ){

            $res            = $data["respuesta"][0];
            $id_faq         = $res["id_faq"];
            $respuesta      = $res["respuesta"];
            $titulo         = $res["titulo"];
            $id_categoria   = $res["id_categoria"];
            $status   = $res["status"];

        }


        $r[] = form_open("", ["class" => "form_respuesta", "id" => 'form_respuesta']);
        $r[] = div("CATEGORÍA",3);

        if($editar >  0){

            $r[] = div(create_select_selected(
                $lista_categorias,
                "id_categoria",
                "nombre_categoria",
                $id_categoria,
                "categoria",
                "form-control categoria"

            ) , 9 );


        }else{
            $r[] = div(create_select(
                $lista_categorias,
                "categoria",
                "form-control categoria",
                "categoria",
                "nombre_categoria",
                "id_categoria"
            ) , 9 );

        }



        $r[] = div("TIPO","col-lg-3 top_20");


        $opt[] =  [
                "val" => 1,
                "text" => "Pública"
        ];
        $opt[] =  [
            "val" => 0,
            "text" => "Privada"
        ];
        $opt[] =  [
            "val" => 2,
            "text" => "Solo para labor de venta"
        ];
        $opt[] =  [
            "val" => 3,
            "text" => "Pos venta"
        ];



        if($editar >  0){

            $r[] = div(create_select_selected($opt , "val" , "text" ,$status ,"status", "form-control tipo_respuesta top_20" ), 9);

        }else{

            $r[] = div(create_select($opt , "status" , "form-control tipo_respuesta top_20" ,"tipo_respuesta" , "text" , "val"), 9);
        }


        $r[] = div("TITULO","col-lg-4 top_20");
        $r[] = div(input(["type" => "text", "name" => "titulo", "class" => 'form-control titulo  top_20', "required" => true , "value"=>  $titulo]) , 8);
        $r[] = div(place("", ["id" => "summernote" ]),"col-lg-12 top_40");




        $r[] = div(guardar("Registrar", ["class" => "btn", "type" => "submit"]),"col-lg-12 top_20");

        $r[] = input_hidden(["class"=> "id_faq" , "value"=> $id_faq , "name" => "id_faq"]);
        $r[] = input_hidden(["class"=> "erespuesta" , "value"=> $respuesta]);
        $r[] = input_hidden(["class"=> "editar_respuesta" , "value"=> $editar , "name" => "editar_respuesta"]);


        $r[] = form_close();
        $r[] = div(place("place_refitro_respuesta"),"col-lg-12 top_40");

        if ($editar > 0){

            $r[] = div(heading_enid("+ imagen",4, [ "class" => "cursor_pointer text_agregar_img", "onclick"=> "agrega_img_faq()"]),"col-lg-12 top_40");
            $r[] = div(div("", "place_load_img_faq"),"col-lg-12 top_40");

        }

        return div(div(append_data($r),8,1), "top_30");
    }

    function get_format_faq_categorias($faqs_categoria)
    {

        $r = [];
        $z = 1;
        foreach ($faqs_categoria as $row) {

            $titulo = $row["titulo"];
            $id_faq = $row["id_faq"];
            $href = "?faq=" . $id_faq;
            $source = "../imgs/index.php/enid/img_faq/" . $id_faq;

            $x[] = div($z, "day");
            $x[] = img($source);
            $x[] = heading($titulo);
            $text = ul(li(append_data($x)), "event-list");
            $r[] = anchor_enid($text, ["href" => $href]);
            $z++;
        }

        return div(append_data($r));
    }

    function get_formar_respuesta($respuesta, $in_session, $perfil)
    {

        $r = [];
        foreach ($respuesta as $row) {
            $titulo = $row["titulo"];
            $respuesta = $row["respuesta"];
            $id_faq = $row["id_faq"];

            $btn_conf = "";
            if ($in_session > 0 && $perfil != 20 && $perfil != 19 && $perfil != 17) {

                $btn_conf = anchor_enid("", [
                    "href" => '#tab2default',
                    "data-toggle" => 'tab',
                    "class" => 'btn_edicion_respuesta fa fa-cog',
                    "id" => $id_faq
                ]);
            }
            $response = div(div($btn_conf . $titulo), "row" );
            $r[] = $response;
            $r[] = $respuesta;

        }
        return div(append_data($r));

    }

    function get_format_menu($in_session, $perfil)
    {

        return ul([
            anchor_enid(
                icon("fa fa-question-circle") . "PREGUNTAS FRECUENTES",
                [
                    "href" => "#tab1default"
                ]
            )
        ]
            ,
            "nav nav-tabs"
        );
    }
    function get_btn_registro_faq($in_session, $perfil)
    {

        $response = "";

        if ($in_session == 1 && $perfil != 20 && $perfil != 19 && $perfil != 17) {
            $response = anchor_enid(icon("fa fa-plus-circle") . "AGREGAR",
                [
                    "href" => "#tab2default",
                    "id" => "enviados_a_validacion",
                    "class" => "btn_registro_respuesta "
                ]);

        }

        return $response;
    }

    function lista_categorias($categorias)
    {

        $l = [];
        foreach ($categorias as $row) {

            $id_categoria = $row["id_categoria"];
            $nombre_categoria = $row["nombre_categoria"];
            $faqs = $row["faqs"];
            $href = "?categoria=" . $id_categoria;

            $l[]  = div(anchor_enid(div($nombre_categoria . "(" . $faqs . ")"), ["href" => $href]));
        }
        return append_data($l);
    }
}