<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function val_principal_img($q)
    {
        $response = (strlen(trim($q)) == 0) ? place("contenedor_img_principal") : "";
        return $response;

    }

    function get_format_listado_productos($lista_productos)
    {


        $flag = 0;
        $extra = "";
        $b = 0;
        $response = [];
        foreach ($lista_productos as $row) {
            if ($b > 0) {
                $extra = "margin-top:30px;";
            }
            $response[] = div(div(div($row, ["class" => 'row'])), ["class" => 'col-lg-3', "style" => $extra]);
            $flag++;
            if ($flag == 4) {
                $flag = 0;
                $response[] = hr();
                $b++;
            }
        }
        return append_data($response);


    }

    function get_format_filtro($filtros, $order)
    {

        $r[] = '<select class="form-control order" name="order" id="order">';
        $a = 0;
        foreach ($filtros as $row):
            if ($a == $order):

                $r[] = '<option value="' . $a . '" selected>';
                $r[] = $row;
                $r[] = '</option>';
            else:
                $r[] = '<option value="' . $a . '" selected>';
                $r[] = $row;
                $r[] = '</option>';

            endif;
            $a++;
        endforeach;
        $r[] = '</select>';

        return append_data($r);

    }

    function get_format_menu_categorias_destacadas($es_movil, $categorias_destacadas)
    {

        $r = [];
        if ($es_movil < 1) {

            foreach (crea_menu_principal_web($categorias_destacadas) as $row):

                $r[] =
                    anchor_enid(mayus($row["nombre_clasificacion"]),
                        [
                            "href" => "?q=&q2=" . $row['primer_nivel'],
                            "class" => 'categorias_mas_vistas'
                        ]);
            endforeach;

        }
        return append_data($r);


    }

    function get_formar_menu_sugerencias($es_movil, $bloque_busqueda, $busqueda)
    {

        $response = "";
        if ($es_movil < 1) {

            $primer_nivel = $bloque_busqueda["primer_nivel"];
            $segundo_nivel = $bloque_busqueda["segundo_nivel"];
            $tercer_nivel = $bloque_busqueda["tercer_nivel"];
            $cuarto_nivel = $bloque_busqueda["cuarto_nivel"];
            $quinto_nivel = $bloque_busqueda["quinto_nivel"];

            $bloque_primer_nivel = crea_seccion_de_busqueda_extra($primer_nivel, $busqueda);
            $bloque_segundo_nivel = crea_seccion_de_busqueda_extra($segundo_nivel, $busqueda);
            $bloque_tercer_nivel = crea_seccion_de_busqueda_extra($tercer_nivel, $busqueda);
            $bloque_cuarto_nivel = crea_seccion_de_busqueda_extra($cuarto_nivel, $busqueda);
            $bloque_quinto_nivel = crea_seccion_de_busqueda_extra($quinto_nivel, $busqueda);

            $r = [];
            if ($bloque_primer_nivel["num_categorias"] > 0) {
                $r[] = $bloque_primer_nivel["html"];
            }
            if ($bloque_segundo_nivel["num_categorias"] > 0) {
                $r[] = hr();
                $r[] = $bloque_segundo_nivel["html"];
            }
            if ($bloque_tercer_nivel["num_categorias"] > 0) {
                $r[] = hr();
                $r[] = $bloque_tercer_nivel["html"];
            }
            if ($bloque_cuarto_nivel["num_categorias"] > 0) {
                $r[] = hr();
                $r[] = $bloque_cuarto_nivel["html"];
            }
            if ($bloque_quinto_nivel["num_categorias"] > 0) {
                $r[] = hr();
                $r[] = $bloque_quinto_nivel["html"];
            }
            $response = div(append_data($r), ["class" => "contenedor_sub_categorias"]);

        }
        return $response;
    }

    function crea_sub_menu_categorias_destacadas($param)
    {
        $z = 0;
        $response = [];
        foreach ($param as $row) {

            $nombre_clasificacion = $row["nombre_clasificacion"];

            if ($z == 0) {
                $response [] = "<ul class='clasificaciones_sub_menu_ul'>";
            }
            $href = "?q=&q2=" . $row["primer_nivel"];
            $response [] = li(anchor_enid($nombre_clasificacion, ["href" => $href, "class" => 'text_categoria_sub_menu']));
            $z++;
            if ($z == 5) {
                $z = 0;
                $response [] = "</ul>";
            }
        }
        return append_data($response);
    }

    function crea_menu_principal_web($param)
    {


        $z = 0;
        $data_complete = [];

        foreach ($param["clasificaciones"] as $row) {

            $primer_nivel = $row["primer_nivel"];
            $total = $row["total"];
            $nombre_clasificacion = "";
            foreach ($param["nombres_primer_nivel"] as $row2) {

                $id_clasificacion = $row2["id_clasificacion"];
                if ($primer_nivel == $id_clasificacion) {
                    $nombre_clasificacion = $row2["nombre_clasificacion"];
                    break;
                }


            }
            $data_complete[$z]["primer_nivel"] = $primer_nivel;
            $data_complete[$z]["total"] = $total;
            $data_complete[$z]["nombre_clasificacion"] = $nombre_clasificacion;

            if ($z == 4) {
                break;
            }
            $z++;

        }
        return $data_complete;
    }

    function crea_seccion_de_busqueda_extra($info, $busqueda)
    {

        if (is_array($info)) {

            $seccion = "";
            $flag = 0;

            $lista = [];
            for ($z = 0; $z < count($info); $z++) {
                $data = $info[$z];
                foreach ($data as $row) {

                    $id_clasificacion = $row["id_clasificacion"];
                    $nombre_clasificacion = $row["nombre_clasificacion"];

                    $url = "../search/?q=" . $busqueda . "&q2=" . $id_clasificacion;
                    $lista[] =
                        anchor_enid($nombre_clasificacion, ["href" => $url, "class" => 'categoria_text black']);

                    $flag++;
                }
            }

            $info_seccion["html"] = ul($lista);
            $info_seccion["num_categorias"] = $flag;
            return $info_seccion;

        }

    }


}