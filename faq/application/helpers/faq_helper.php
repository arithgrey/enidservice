<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	function valida_format_respuestas_menu($in_session, $lista_categorias){


		$response =  "";
		if ($in_session > 0){
			$response =  div(get_form_respuesta($lista_categorias) ,[ "class"=>"tab-pane fade" , "id"=>"tab2default"]);
		}
		return $response;

	}

    function get_format_faqs($flag_categoria , $flag_busqueda_q, $categorias_publicas_venta, $categorias_temas_de_ayuda, $faqs_categoria, $respuesta, $in_session, $perfil){


        $r = [];
        if ($flag_categoria < 1 && $flag_busqueda_q < 1) {

            $r[] =  get_format_listado_categorias($categorias_publicas_venta, $categorias_temas_de_ayuda);
        }
        if ($flag_categoria > 0) {
            $r[] =  get_format_faq_categorias($faqs_categoria);
        }
        if ($flag_busqueda_q > 0) {
            $r[] =  get_formar_respuesta($respuesta, $in_session, $perfil);
        }
        return append_data($r);

    }
    function get_format_listado_categorias($categorias_publicas_venta, $categorias_temas_de_ayuda){

        $r[] =  heading_enid("LO MÁS BUSCADO", 2);
        $r[] =  div(lista_categorias($categorias_publicas_venta));
        $r[] =  place("place_categorias_extras");
        $r[] =  div(lista_categorias($categorias_temas_de_ayuda));
        return append_data($r);

    }
    function get_form_respuesta($lista_categorias)
    {

        $r[] = form_open("", ["class" => "form_respuesta", "id" => 'form_respuesta']);
        $r[] = label("Categoria");
        $r[] = create_select($lista_categorias, "categoria", "form-control categoria", "categoria",
            "nombre_categoria", "id_categoria");;
        $r[] = label("Tipo");


        $r[] = '<select class="form-control tipo_respuesta" name = "status" >';
        $r[] = '<option value = "1" > Pública</option >
                <option value = "0" > Privada</option >
                <option value = "2" > Solo para labor de venta</option >
                <option value = "3" > Pos venta</option >
                </select >';

        $r[] = label("Pregunta frecuente");
        $r[] = input(["type" => "text", "name" => "titulo", "class" => 'form-control titulo', "required" => true]);
        $r[] = label("Respuesta");
        $r[] = div("-", ["id" => "summernote"]);
        $r[] = guardar("Registrar", ["class" => "btn", "type" => "submit"]);
        $r[] = form_close();
        $r[] = place("place_refitro_respuesta");

        return append_data($r);


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

            $x[] = div($z, ["class" => "day"]);
            $x[] = img($source);
            $x[] = heading($titulo);
            $text = ul(li(append_data($x)), ["class" => "event-list"]);
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
                    "id" => $id_faq]);
            }
            $response = div(div($btn_conf . $titulo), ["class" => "row"]);
            $r[] = $response;
            $r[] = $respuesta;

        }
        return div(append_data($r));

    }

    function get_format_menu($in_session, $perfil)
    {

        return ul([
            anchor_enid("CATEGORIAS", ["href" => "../faq", "class" => "text_categorias"]),

            anchor_enid(
                icon("fa fa-question-circle") .
                "PREGUNTAS FRECUENTES",
                [
                    "href" => "#tab1default",
                    "data-toggle" => "tab"
                ])
            ,
            get_btn_registro_faq($in_session, $perfil)
        ], ["class" => "nav nav-tabs"]

        );

    }

    function get_info_serviciosq($q)
    {
        $status = (isset($q) && strlen($q) > 0) ? 1 : 0;
        return $status;
    }

    function get_info_categoria($q)
    {

        $status = (isset($q) && strlen($q) > 0) ? 1 : 0;
        return $status;
    }

    function get_btn_registro_faq($in_session, $perfil)
    {

        $response = "";
        if ($in_session == 1) {

            if ($perfil != 20 && $perfil != 19 && $perfil != 17) {
                $response = anchor_enid(icon("fa fa-plus-circle") . "AGREGAR",
                    [
                        "href" => "#tab2default",
                        "id" => "enviados_a_validacion",
                        "data-toggle" => "tab",
                        "class" => "btn_registro_respuesta "
                    ]);

            }

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
            $link = anchor_enid(div($nombre_categoria . "(" . $faqs . ")"), ["href" => $href]);
            $l[] = div($link, ["class" => "col-lg-4"]);
        }
        return append_data($l);
    }
}