<?php

if (!function_exists('heading')) {
    function heading($data = '', $h = '1', $attributes = '')
    {
        return (is_string($attributes)) ?
            "<h" . $h . add_attributes(["class" => $attributes]) . ">" . $data . "</h" . $h . ">" :
            "<h" . $h . add_attributes($attributes) . ">" . $data . "</h" . $h . ">";

    }
}
if (!function_exists('ul')) {
    function ul($list, $attributes = [])
    {

        return _list('ul', $list, (is_string($attributes)) ? ["class" => $attributes] : $attributes);

    }
}
if (!function_exists('li')) {
    function li($info, $attributes = [], $row_12 = 0)
    {
        return add_element($info, "li", (is_string($attributes)) ? ["class" => $attributes] : $attributes, $row_12);
    }
}

if (!function_exists('check')) {
    function check($attributes = [])
    {
        return "<input " . add_attributes($attributes) . ">";
    }
}


if (!function_exists('span')) {
    function span($info, $attributes = [], $row = 0)
    {

        $attr = "";
        if (es_data($attributes)) {

            $attr = add_attributes($attributes);

        } else {

            if (is_string($attributes) && strlen(trim($attributes)) > 0) {
                $att = [];
                $att["class"] = $attributes;
                $attr = add_attributes($att);

            }

        }

        $base = "<span" . $attr . ">" . $info . "</span>";
        $e = ($row == 0) ? $base : addNrow($base);
        return $e;


    }
}
if (!function_exists('p')) {
    function p($str, $attributes = [], $row = 0)
    {

        $attributes = (is_string($attributes)) ? add_attributes(["class" => $attributes]) : add_attributes($attributes);
        $base = "<p " . $attributes . ">" . $str . "</p>";
        $e = ($row == 0) ? $base : addNRow($base);
        return $e;

    }
}
if (!function_exists('guardar')) {
    function guardar($info, $attributes = [], $row = 1, $type_button = 1, $submit = 1, $anchor = 0)
    {
        if ($submit == 1) {

            $attributes["type"] = "submit";
        }

        if ($type_button == 1) {

            $attributes["class"] = (array_key_exists("class", $attributes) ? 1 : 0 == 1) ? $attributes["class"] . " " . " a_enid_blue white completo btn_guardar" : "a_enid_blue white completo btn_guardar";
        }

        $attr = add_attributes($attributes);
        if ($row == 0) {

            return "<button " . $attr . ">" . $info . "</button>";

        } else {

            $b = ($anchor !== 0) ? "<a href='" . $anchor . "'> <button " . $attr . ">" . $info . "</button></a>" : "<button " . $attr . ">" . $info . "</button>";

            return div($b, 1);
        }
    }
}
if (!function_exists('add_element')) {
    function add_element($info, $type, $attributes = '', $row = 0)
    {

        $base = "<" . $type . " " . add_attributes($attributes) . " >" . $info . "</" . $type . ">";
        return ($row < 1) ? $base : addNRow($base);

    }
}
function sub_categorias_destacadas($param)
{

    $z = 0;
    $response = [];

    foreach ($param["clasificaciones"] as $row) {

        $primer_nivel = $row["primer_nivel"];

        $clasificacion = search_bi_array(
            $param["nombres_primer_nivel"],
            "id_clasificacion",
            $primer_nivel,
            "nombre_clasificacion",
            ""
        );

        $response[$z]["primer_nivel"] = $primer_nivel;
        $response[$z]["total"] = $row["total"];
        $response[$z]["nombre_clasificacion"] = $clasificacion;

        if ($z == 29) {
            break;
        }
        $z++;
    }
    return $response;

}
if (!function_exists('get_base_html')) {
    function get_base_html($tipo, $info, $attributes = [], $row = 0, $frow = 0)
    {

        if (is_numeric($attributes)) {

            switch ($attributes) {
                case 1:

                    return addNRow($info);

                    break;
                case 2:

                    $response = ($row > 0) ? "<{$tipo} class='col-lg-2 col-lg-offset-5'>" . $info . "</{$tipo}>" : "<{$tipo} class='col-lg-2'>" . $info . "</{$tipo}>";

                    break;
                case 3:
                    $response = "<{$tipo} class='col-lg-3'>" . $info . "</{$tipo}>";
                    break;
                case 4:
                    $response = ($row > 0) ? "<{$tipo} class='col-lg-4 col-lg-offset-4'>" . $info . "</{$tipo}>" : "<{$tipo} class='col-lg-4'>" . $info . "</{$tipo}>";
                    break;
                case 5:
                    $response = "<{$tipo} class='col-lg-5'>" . $info . "</{$tipo}>";
                    break;
                case 6:

                    $response = ($row > 0) ? "<{$tipo} class='col-lg-6 col-lg-offset-3'>" . $info . "</{$tipo}>" : "<{$tipo} class='col-lg-6'>" . $info . "</{$tipo}>";

                    break;

                case 7:

                    $response = "<{$tipo} class='col-lg-7'>" . $info . "</{$tipo}>";
                    break;


                case 8:

                    $response = ($row > 0) ? "<{$tipo} class='col-lg-8 col-lg-offset-2'>" . $info . "</{$tipo}>" : "<{$tipo} class='col-lg-8'>" . $info . "</{$tipo}>";

                    break;
                case 9:
                    $response = "<{$tipo} class='col-lg-9'>" . $info . "</{$tipo}>";
                    break;

                case 10:


                    $response = ($row > 0) ? "<{$tipo} class='col-lg-10 col-lg-offset-1'>" . $info . "</{$tipo}>" : "<{$tipo} class='col-lg-10'>" . $info . "</{$tipo}>";

                    break;

                case 11:
                    $response = "<{$tipo} class='col-lg-11'>" . $info . "</{$tipo}>";
                    break;


                case 12:


                    $response = "<{$tipo} class='col-lg-12'>" . $info . "</{$tipo}>";

                    break;

                case 13:

                    $response = "<{$tipo} class='row'>" . $info . "</{$tipo}>";

                    break;


            }

            if ($frow > 0) {
                $response = $tipo($response, 13);
            }
            return $response;

        } else {

            if (is_array($attributes)) {

                $base = "<{$tipo}" . add_attributes($attributes) . ">" . $info . "</{$tipo}>";
                $d = ($row > 0) ? addNRow($base) : $base;
                return $d;

            } else {

                $base = "<{$tipo} class='{$attributes}'>" . $info . "</{$tipo}>";
                $d = ($row > 0) ? addNRow($base) : $base;
                return $d;
            }


        }

    }
}



/*
if (!function_exists('get_base_html')) {
    function get_base_html($tipo, $info, $attributes = [], $row = 0, $frow = 0)
    {

        if (is_numeric($attributes)) {
            $response = "";
            switch ($attributes) {
                case 1:

                    return addNRow($info);

                    break;
                case 2:

                    $response = ($row > 0) ? "<{$tipo} class='col-lg-2 col-lg-offset-5'>" . $info . "</{$tipo}>" : "<{$tipo} class='col-lg-2'>" . $info . "</{$tipo}>";

                    break;
                case 3:

                    $response = "<{$tipo} class='col-lg-3'>" . $info . "</{$tipo}>";

                    break;

                case 4:

                    $response = ($row > 0) ? "<{$tipo} class='col-lg-4 col-lg-offset-4'>" . $info . "</{$tipo}>" : "<{$tipo} class='col-lg-4'>" . $info . "</{$tipo}>";
                    break;
                case 5:

                    $response = "<{$tipo} class='col-lg-5'>" . $info . "</{$tipo}>";
                    break;
                case 6:

                    $response = ($row > 0) ? "<{$tipo} class='col-lg-6 col-lg-offset-3'>" . $info . "</{$tipo}>" : "<{$tipo} class='col-lg-6'>" . $info . "</{$tipo}>";

                    break;

                case 7:

                    $response = "<{$tipo} class='col-lg-7'>" . $info . "</{$tipo}>";
                    break;


                case 8:

                    $response = ($row > 0) ? "<{$tipo} class='col-lg-8 col-lg-offset-2'>" . $info . "</{$tipo}>" : "<{$tipo} class='col-lg-8'>" . $info . "</{$tipo}>";

                    break;
                case 9:
                    $response = "<{$tipo} class='col-lg-9'>" . $info . "</{$tipo}>";
                    break;

                case 10:


                    $response = ($row > 0) ? "<{$tipo} class='col-lg-10 col-lg-offset-1'>" . $info . "</{$tipo}>" : "<{$tipo} class='col-lg-10'>" . $info . "</{$tipo}>";

                    break;

                case 11:
                    $response = "<{$tipo} class='col-lg-11'>" . $info . "</{$tipo}>";
                    break;


                case 12:


                    $response = "<{$tipo} class='col-lg-12'>" . $info . "</{$tipo}>";

                    break;

                case 13:

                    $response = "<{$tipo} class='row'>" . $info . "</{$tipo}>";

                    break;


            }

            return ($frow > 0) ? $tipo($response, 13) : "";

        } else {


            $base = (is_array($attributes)) ?
                "<{$tipo}" . add_attributes($attributes) . ">" . $info . "</{$tipo}>"
                :
                "<{$tipo} class='{$attributes}'>" . $info . "</{$tipo}>";


            return ($row > 0) ? addNRow($base) : $base;

        }

    }
}
*/

if (!function_exists('div')) {
    function div($info, $attributes = [], $row = 0, $frow = 0)
    {

        return get_base_html("div", $info, $attributes, $row, $frow);

    }
}

if (!function_exists('del')) {
    function del($info, $attributes = [], $row = 0, $frow = 0)
    {

        return get_base_html("del", $info, $attributes, $row, $frow);

    }
}

if (!function_exists('section')) {
    function section($info, $attributes = [], $row = 0, $frow = 0)
    {

        return get_base_html("section", $info, $attributes, $row, $frow);

    }
}

if (!function_exists('input')) {
    function input($attributes = [], $e = 0)
    {

        $attributes["class"] = (array_key_exists("class", $attributes)) ? ($attributes["class"] . " form-control ") : " form-control ";
        $attr = add_attributes($attributes);
        return ($e < 1) ? "<input " . $attr . " >" : addNRow("<input " . $attr . " >");

    }
}
if (!function_exists('input_hidden')) {
    function input_hidden($attributes = '', $e = 0)
    {

        $input = "<input type='hidden'  " . add_attributes($attributes) . " >";
        return ($e == 0) ? $input : addNRow($input);

    }
}
if (!function_exists('add_attributes')) {
    function add_attributes($attributes = '')
    {


        if (is_array($attributes)) {

            $callback = function ($carry, $key) use ($attributes) {
                return $carry . ' ' . $key . '="' . htmlspecialchars($attributes[$key]) . '"';
            };

            $response = array_reduce(array_keys($attributes), $callback, '');


        } else {

            $response = ($attributes != '') ? ' ' . $attributes : '';
        }

        return $response;

    }
}
if (!function_exists('add_fields')) {
    function add_fields($fields)
    {
        $r = [];
        if (es_data($fields)) {
            $b = 0;
            for ($i = 0; $i < count($fields); $i++) {
                $r[] = ($b == count($fields) - 1) ? $fields[$i] : $fields[$i] . ",";
                $b++;
            }

        }
        return append($r);
    }
}

if (!function_exists('end_row')) {
    function end_row()
    {
        return str_repeat("</div>", 2);
    }
}
if (!function_exists('n_row_12')) {
    function n_row_12($attributes = '')
    {

        return "<div class='row'><div class='col-lg-12' " . _parse_attributes($attributes) . ">";

    }
}
if (!function_exists('anchor_enid')) {
    function anchor_enid($title = '', $attributes = [], $row_12 = 0, $type_button = 0)
    {


        $base = "<a" .
            _parse_attributes((is_string($attributes)) ? ["href" => $attributes] : $attributes) . ">" .
            $title
            . "</a>";
        $e = ($row_12 == 0) ? $base : addNRow($base);
        return $e;

    }
}
if (!function_exists('get_td')) {
    function get_td($val = '', $attributes = [])
    {

        if (is_array($attributes)) {

            return "<td " . add_attributes($attributes) . " NOWRAP >" . $val . "</td>";

        } else {

            return (is_string($attributes) && strlen($attributes) > 0) ?
                "<td " . add_attributes(["class" => $attributes]) . " NOWRAP >" . $val . "</td>" :
                "<td " . add_attributes($attributes) . " NOWRAP >" . $val . "</td>";

        }

    }
}
if (!function_exists('get_th')) {
    function get_th($val = '', $attributes = '')
    {

        return "<th " . add_attributes($attributes) . " NOWRAP >" . $val . "</th>";
    }
}
if (!function_exists('select_enid')) {
    function select_enid($data, $text_option, $val, $attributes = '')
    {

        $select[] = "<select " . add_attributes($attributes) . "> ";
        foreach ($data as $row) {
            $select[] = "<option value='" . $row[$val] . "'>" . $row[$text_option] . " </option>";
        }
        $select[] = "</select>";
        return append($select);
    }
}
if (!function_exists('remove_comma')) {
    function remove_comma($text)
    {

        return str_replace("'", '', (str_replace('"', '', $text)));
    }
}
if (!function_exists('heading_enid')) {
    function heading_enid($data = '', $h = 1, $attributes = '', $row_12 = 0)
    {

        if (is_numeric($attributes) && $attributes > 0) {


            return addNRow("<h$h>" . $data . "</h$h>");

        } else {

            if (is_string($attributes)) {


                $label = "<h$h " . add_attributes(["class" => $attributes]) . ">" . $data . "</h$h>";
                return ($row_12 > 0) ? addNRow($label) : $label;


            } else {

                $label = "<h$h " . add_attributes($attributes) . ">" . $data . "</h$h>";
                return ($row_12 > 0) ? addNRow($label) : $label;

            }


        }


    }
}
if (!function_exists('get_url_request')) {

    function get_url_request($extra)
    {

        return "http://" . $_SERVER['HTTP_HOST'] . "/inicio/" . $extra;

    }

}
if (!function_exists('es_local')) {

    function es_local()
    {

        return ($_SERVER['HTTP_HOST'] !== "localhost") ? 0 : 1;

    }
}

if (!function_exists('icon')) {
    function icon($class, $attributes = '', $row_12 = 0, $extra_text = '')
    {

        $attr = add_attributes($attributes);
        $base = "<i class='fa " . $class . "'" . $attr . " ></i>";
        $base2 = span($extra_text, $attributes);
        return ($row_12 == 0) ? $base . $base2 : addNRow($base) . $base2;

    }
}
if (!function_exists('template_table_enid')) {
    function template_table_enid()
    {
        $template = array(
            'table_open' => '<table   class="table " >',
            'thead_open' => '<thead class="black_enid_background2 white ">',
            'thead_close' => '</thead>',
            'heading_row_start' => '<tr class="text-center">',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end' => '</th>',
            'tbody_open' => '<tbody>',
            'tbody_close' => '</tbody>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );
        return $template;
    }
}
if (!function_exists('create_tag')) {
    function create_tag($param, $class, $val_id, $text)
    {

        $tags = "";
        foreach ($param as $row) {


            $info = $row[$text];
            $id = $row[$val_id];
            $tags .= add_element(
                $info, "button",
                [
                    'class' => $class,
                    'id' => $id
                ]
            );
        }
        $new_tags = add_element($tags, "div", array('class' => 'tags'));
        return $new_tags;
    }
}
if (!function_exists('get_array_json')) {
    function get_array_json($val)
    {

        $response = [];
        if (strlen(trim($val)) > 1) {

            $response = json_decode($val, true);

        }
        return $response;
    }
}
if (!function_exists('get_json_array')) {
    function get_json_array($arr)
    {


        return (count($arr) > 0) ? json_encode($arr) : json_encode([]);

    }
}
if (!function_exists('push_element_json')) {
    function push_element_json($arr, $element)
    {

        $exists = 0;
        if (es_data($arr)) {

            if (in_array($element, $arr)) {
                $exists = 1;
            }
            if ($exists < 1) {
                array_push($arr, $element);
            }
            return $arr;
        }
    }
}
if (!function_exists('unset_element_array')) {
    function unset_element_array($array, $element)
    {

        $new_array = [];
        $b = 0;
        for ($a = 0; $a < count($array); $a++) {
            if ($array[$a] != $element) {
                $new_array[$b] = $array[$a];
                $b++;
            }
        }
        return $new_array;

    }
}
if (!function_exists('create_button_easy_select')) {
    function create_button_easy_select($arr, $attributes, $comparador = 1)
    {
        sort($arr);
        $easy_selet = "";
        if ($comparador == 1) {

            foreach ($arr as $row) {

                $text = $row[$attributes["text_button"]];
                $class =
                    ($row[$attributes["campo_comparacion"]] == $attributes["valor_esperado"]) ?
                        $attributes["class_selected"] : $attributes["class_disponible"];


                $extra = ($row[$attributes["campo_comparacion"]] ==
                    $attributes["valor_esperado"]) ? 1 : 0;

                $easy_selet .= add_element($text, "a",
                    [
                        'class' => $class,
                        'id' => $row[$attributes["valor_id"]],
                        "existencia" => $extra
                    ]
                );

            }


        } else {

            $extra = $attributes["extra"];
            $campo_id = $attributes["campo_id"];
            foreach ($arr as $row) {
                $attr = add_attributes($extra);
                $id = $row[$campo_id];
                $easy_selet .= "<a " . $attr . " id=" . $id . "  >" . $row["talla"] . "</a>";
            }

        }
        return $easy_selet;

    }
}
if (!function_exists('create_select')) {

    function create_select($data, $name, $class, $id, $text_option, $val, $row = 0, $def = 0, $valor = 0, $text_def = "")
    {

        $select[] = "<select name='" . $name . "'  class='" . $class . "'  id='" . $id . "'> ";

        if ($def == 1) {

            $select[] = "<option value='" . $valor . "'>" . strtoupper($text_def) . " </option>";
        }
        foreach ($data as $item) {

            $select[] = "<option value='" . $item[$val] . "'>" . strtoupper($item[$text_option]) . " </option>";
        }

        $select[] = "</select>";
        return ($row < 1) ? append($select) : addNRow(append($select));

    }
}
if (!function_exists('get_param_def')) {
    function get_param_def($data, $key, $val_def = 0, $valida_basura = 0)
    {

        $val = (is_array($data) && array_key_exists($key, $data) && $data[$key] !== null) ? $data[$key] : $val_def;

        if ($valida_basura > 0) {

            if ((is_array($data) && array_key_exists($key, $data))) {
                evita_basura($data[$key]);
            }
        }
        return $val;

    }
}

if (!function_exists('exists_array_def')) {
    function exists_array_def($data, $key, $exists = 1, $fail = 0)
    {
        return (is_array($data) && array_key_exists($key, $data)) ? $exists : $fail;

    }
}

if (!function_exists('label')) {
    function label($label_text = '', $attributes = '', $row = 0)
    {


        $base = (is_string($attributes)) ?
            "<label" . add_attributes(["class" => $attributes]) . ">" . $label_text . "</label>" :
            "<label" . add_attributes($attributes) . ">" . $label_text . "</label>";

        return ($row == 0) ? $base : addNRow($base);


    }
}
if (!function_exists('addNRow')) {
    function addNRow($e, $attributes = [])
    {

        return (is_string($attributes)) ?
            n_row_12(["class" => $attributes]) . $e . end_row() :
            n_row_12($attributes) . $e . end_row();


    }
}

if (!function_exists('place')) {
    function place($class, $attributes = [], $row = 1)
    {

        $attributes["class"] = $class;
        if (!array_key_exists("id", $attributes)) {
            $attributes["id"] = $class;
        }
        return div("", $attributes, $row);

    }
}
if (!function_exists('img_enid')) {
    function img_enid($extra = [], $row_12 = 0, $external = 0)
    {


        $conf["src"] = ($external == 0) ?
            "../img_tema/enid_service_logo.jpg" : "https://enidservice.com/inicio/img_tema/enid_service_logo.jpg";

        if (es_data($extra)) {
            $conf += $extra;
        }
        $img = img($conf);
        return ($row_12 == 0) ? $img : addNRow($img);
    }
}
if (!function_exists('url_recuperacion_password')) {

    function url_recuperacion_password()
    {

        return "../msj/index.php/api/mailrest/recupera_password/format/json/";
    }
}

if (!function_exists('get_dominio')) {
    function get_dominio($url)
    {
        $protocolos = ['http://', 'https://', 'ftp://', 'www.'];
        $url = explode('/', str_replace($protocolos, '', $url));
        return $url[0];
    }
}
if (!function_exists('mayus')) {
    function mayus($variable)
    {
        return strtr(strtoupper($variable), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");

    }
}
if (!function_exists('get_campo')) {
    function get_campo($param, $key, $label = "", $add_label = 0)
    {

        return ($add_label == 1) ? ($label . "  " . $param[0][$key]) : ((count($param) > 0) ? $param[0][$key] : "");

    }
}
if (!function_exists('get_random')) {
    function get_random()
    {
        return mt_rand();
    }
}
if (!function_exists('usuario')) {
    function usuario($q2)
    {
        $id_usuario_envio = 0;
        if (isset($q2) && $q2 != null) {
            $id_usuario_envio = $q2;
        }
        return $id_usuario_envio;
    }
}
if (!function_exists('now_enid')) {
    function now_enid()
    {
        return date('Y-m-d');
    }
}

if (!function_exists('porcentaje')) {
    function porcentaje($cantidad, $porciento, $decimales = 2, $numeric_format = 0)
    {
        if (is_numeric($cantidad) == is_numeric($porciento)) {

            return ($numeric_format == 1) ? (number_format($cantidad * $porciento / 100, $decimales)) : ($cantidad * $porciento / 100);

        }
    }
}
if (!function_exists('porcentaje_total')) {
    function porcentaje_total($cantidad, $total, $decimales = 2)
    {

        if ($total > 0) {

            return $cantidad * 100 / $total;
        }


    }
}

if (!function_exists('get_url_tumblr')) {
    function get_url_tumblr($url, $icon = 0)
    {

        $url_tumblr = "http://tumblr.com/widgets/share/tool?canonicalUrl=" . $url;
        if ($icon > 0) {
            return anchor_enid(icon('a fa-tumblr'),
                [
                    'target' => "_black",
                    'href' => $url_tumblr
                ]);
        }
        return $url_tumblr;
    }
}
if (!function_exists('get_url_pinterest')) {
    function get_url_pinterest($url, $icon = 0)
    {

        $url_pinterest = "https://www.pinterest.com/pin/create/button/?url=" . $url;
        if ($icon > 0) {
            return anchor_enid(icon('fa fa-pinterest-p'),
                [
                    'target' => "_black",
                    'href' => $url_pinterest
                ]);
        }

        return $url_pinterest;

    }
}
if (!function_exists('get_url_twitter')) {
    function get_url_twitter($url, $mensaje, $icon = 0)
    {

        $url_twitter = "https://twitter.com/intent/tweet?text=" . $mensaje . $url;
        if ($icon > 0) {
            return anchor_enid(icon('fa fa-twitter'),
                [
                    'target' => "_black",
                    'href' => $url_twitter
                ]);
        }
        return $url_twitter;
    }
}
if (!function_exists('get_url_facebook')) {
    function get_url_facebook($url, $icon = 0)
    {

        $url_facebook = "https://www.facebook.com/sharer/sharer.php?u=" . $url . ";src=sdkpreparse";
        if ($icon > 0) {
            return anchor_enid(icon('fa fa-facebook-square'),
                [
                    'target' => "_black",
                    'href' => $url_facebook
                ]);
        }
        return $url_facebook;
    }
}
if (!function_exists('get_url_tienda')) {
    function get_url_tienda($id_usuario)
    {

        return "http://" . $_SERVER['HTTP_HOST'] . "/inicio/search/?q3=" . $id_usuario;

    }
}

if (!function_exists('unique_multidim_array')) {
    function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
}
if (!function_exists('create_select_selected')) {
    function create_select_selected($data, $campo_val, $campo_text, $selected, $name, $class)
    {

        $select = "<select class='" . $class . "' name='" . $name . "'>";
        foreach ($data as $row) {
            $extra = ($row[$campo_val] == $selected) ? "selected" : "";
            $select .= "<option value='" . $row[$campo_val] . "' " . $extra . " > " . $row[$campo_text] . "</option>";
        }
        $select .= "</select>";
        return $select;
    }
}
if (!function_exists('get_keys')) {
    function get_keys($array_keys)
    {
        return implode(",", $array_keys);
    }
}

if (!function_exists('create_url_preview')) {
    function create_url_preview($img)
    {
        return base_url() . "../img_tema/portafolio/" . $img;
    }
}
if (!function_exists('lib_def')) {
    function lib_def()
    {
        return "../../librerias/app";
    }
}
if (!function_exists('valida_num')) {
    function valida_num($num)
    {
        return ($num > 0) ? $num : 0;
    }
}
if (!function_exists('valida_seccion_activa')) {
    function valida_seccion_activa($seccion, $activa)
    {
        return ($seccion == $activa) ? " active " : "";

    }
}
if (!function_exists('randomString')) {
    function randomString($length = 10, $uc = TRUE, $n = TRUE, $sc = FALSE)
    {

        $source = 'abcdefghijklmnopqrstuvwxyz';
        if ($uc == 1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($n == 1) $source .= '1234567890';
        if ($sc == 1) $source .= '|@#~$%()=^*+[]{}-_';
        if ($length > 0) {
            $rstr = "";
            $source = str_split($source, 1);
            for ($i = 1; $i <= $length; $i++) {
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1, count($source));
                $rstr .= $source[$num - 1];
            }
        }
        return $rstr;
    }
}
if (!function_exists('site_url')) {
    function site_url($uri = '')
    {
        $CI =& get_instance();
        return $CI->config->site_url($uri);
    }
}
if (!function_exists('get_drop')) {
    function get_drop($tmp_table)
    {
        return "DROP TABLE IF EXISTS " . $tmp_table . " ";
    }
}
if (!function_exists('valida_extension')) {
    function valida_extension($string, $num_ext, $strin_secundario)
    {

        return (strlen($string) > $num_ext) ? $string : $strin_secundario;

    }
}
if (!function_exists('link_imagen_servicio')) {
    function link_imagen_servicio($id)
    {

        return ($id > 0) ? "../imgs/index.php/enid/imagen_servicio/$id" : "";
    }
}
if (!function_exists('select_vertical')) {
    function select_vertical($data, $val, $text_option, $attributes = '')
    {

        $extra = add_attributes($attributes);
        $select = "<select " . $extra . " > ";
        foreach ($data as $row) {
            $select .= "<option value='" . $row[$val] . "'>" . $row[$text_option] . " </option>";
        }
        $select .= "</select>";
        return $select;

    }
}
if (!function_exists('small')) {
    function small($text, $attributes = [])
    {

        if (is_string($attributes)) {

            $att["class"] = $attributes;
            return "<small " . add_attributes($att) . " > " . $text . "</small>";

        } else {

            return "<small " . add_attributes($attributes) . " > " . $text . "</small>";

        }

    }
}

if (!function_exists('strong')) {
    function strong($text, $attributes = '', $row = 0)
    {

        if (is_string($attributes)) {

            $att["class"] = $attributes;
            $base = "<strong" . add_attributes($att) . ">" . $text . "</strong>";
            return ($row == 0) ? $base : addNRow($base);


        } else {

            $base = "<strong" . add_attributes($attributes) . ">" . $text . "</strong>";
            return ($row == 0) ? $base : addNRow($base);


        }


    }
}
if (!function_exists('hr')) {
    function hr($attributes = [], $row = 1)
    {

        if (is_string($attributes)) {

            $att["class"] = $attributes;
            $base = "<hr" . add_attributes($att) . ">";
            $e = ($row == 0) ? $base : addNRow($base);
            return $e;

        } else {

            $base = "<hr" . add_attributes($attributes) . ">";
            $e = ($row == 0) ? $base : addNRow($base);
            return $e;

        }


    }
}

if (!function_exists('debug')) {
    function debug($msg, $array = 0)
    {
        if (es_local() > 0) {

            $_date_fmt = 'Y-m-d H:i:s';
            $filepath = BASEPATH . "../debug/debug.log";
            $message = '';
            $fp = @fopen($filepath, FOPEN_WRITE_CREATE);

            if ($array == 0) {
                $message .=
                    'DEBUG' . ' -' . ' TYPE ' . gettype($msg) . ' ' . date($_date_fmt) . ' --> ' . $msg . "\n";
            } else {
                $message .=
                    'DEBUG' . ' -' . ' TYPE ' . gettype($msg) . ' ' . date($_date_fmt) . ' --> ' . print_r($msg, true) . "\n";
            }

            flock($fp, LOCK_EX);
            fwrite($fp, $message);
            flock($fp, LOCK_UN);
            fclose($fp);
            return TRUE;
        }

    }

    if (!function_exists('get_costo_envio')) {
        function get_costo_envio($param)
        {

            $gratis = $param["flag_envio_gratis"];
            $r = [];
            if ($gratis == 1) {

                $r["costo_envio_cliente"] = 0;
                $r["costo_envio_vendedor"] = 100;
                $r["text_envio"] = texto_costo_envio_info_publico($gratis, $r["costo_envio_cliente"], $r["costo_envio_vendedor"]);
            } else {
                $r["costo_envio_cliente"] = 100;
                $r["costo_envio_vendedor"] = 0;
                $r["text_envio"] = texto_costo_envio_info_publico($gratis, $r["costo_envio_cliente"], $r["costo_envio_vendedor"]);
            }
            return $r;
        }
    }
    if (!function_exists('if_ext')) {
        function if_ext($param, $k = '', $num = 0)
        {

            $keys = explode(",", $k);
            $z = 0;
            if (is_array($keys) && is_array($param)) {
                $z = 1;
                for ($a = 0; $a < count($keys); $a++) {

                    if ($keys[$a] != null) {


                        if (!array_key_exists(trim($keys[$a]), $param) || strlen(trim($param[$keys[$a]])) < $num) {
                            $z = 0;
                            debug("NO se recibió el parametro->" . $keys[$a]);
                            break;
                        }


                    } else {

                        debug("este parámetro está llegando nulo" . $keys[$a]);
                        break;
                    }


                }

            } else {

                if (!is_array($keys)) {
                    print_r("No es array ->  ", $keys);
                }
                if (!is_array($param)) {
                    print_r("No es array ->  ", $param);
                }

            }

            return $z;
        }
    }
}

if (!function_exists('textarea')) {
    function textarea($attributes = [], $row_12 = 0, $def = '')
    {

        $attributes["rows"] = "5";

        if (array_key_exists("class", $attributes)) {
            $attributes["class"] = $attributes["class"] . " form-control rounded-0";
        } else {
            $attributes["class"] = " form-control rounded-0";
        }
        $base = "<textarea " . add_attributes($attributes) . " ></textarea>";
        $e = ($row_12 == 0) ? $base : addNRow($base);
        return $e;

    }
}
if (!function_exists('iframe')) {
    function iframe($attributes = '', $row_12 = 0)
    {
        $base = "<iframe " . add_attributes($attributes) . " ></iframe>";
        return ($row_12 == 0) ? $base : addNRow($base);
    }
}
if (!function_exists('center')) {
    function center($attributes = '', $row_12 = 0)
    {

        $base = "<center " . add_attributes($attributes) . " ></center>";
        return ($row_12 == 0) ? $base : addNRow($base);

    }
}
/*Ordena el arreglo de a cuerdo al tipo de indice que se indique*/
if (!function_exists('sksort')) {
    function sksort(&$array, $subkey = "id", $sort_ascending = false)
    {
        if (count($array))
            $temp_array[key($array)] = array_shift($array);
        foreach ($array as $key => $val) {
            $offset = 0;
            $found = false;
            foreach ($temp_array as $tmp_key => $tmp_val) {
                if (!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey])) {
                    $temp_array = array_merge((array)array_slice($temp_array, 0, $offset),
                        array($key => $val),
                        array_slice($temp_array, $offset)
                    );
                    $found = true;
                }
                $offset++;
            }
            if (!$found) $temp_array = array_merge($temp_array, array($key => $val));
        }
        if ($sort_ascending) $array = array_reverse($temp_array);
        else $array = $temp_array;
    }
}
if (!function_exists('date_difference')) {
    function date_difference($date_1, $date_2, $differenceFormat = '%a')
    {
        $interval = date_diff(date_create($date_1), date_create($date_2));
        return $interval->format($differenceFormat);
    }
}
if (!function_exists('add_date')) {
    function add_date($inicio, $dias)
    {

        $fecha = date_create($inicio);
        date_add($fecha, date_interval_create_from_date_string($dias . ' days'));
        return date_format($fecha, 'Y-m-d');
    }
}
if (!function_exists('evita_basura')) {
    function evita_basura($text)
    {

        $basura = ["'", "?", "=", "|", "*"];
        $b = 0;
        for ($a = 0; $a < count($basura); $a++) {

            if (strpos($text, $basura[$a]) !== FALSE) {
                $b++;
            }
        }
        if ($b > 0) {
            redirect("https://www.google.com/", "refresh", 302);
        }
        return $b;
    }
}
if (!function_exists('add_hour')) {
    function add_hour($num_hours)
    {
        $nowtime = date("Y-m-d H:i:s");
        $num_hours = $num_hours * 60;
        $date = date('H:i:s', strtotime($nowtime . ' + ' . $num_hours . ' minute'));
        return $date;
    }
}
if (!function_exists('get_logo')) {
    function get_logo($is_mobile, $tipo = 0)
    {

        if ($is_mobile == 1) {

            $en_mobile = div("☰ ENID SERVICE", ["class" => "smallnav menu white", "onclick" => "openNav()"]);
            $class = "col-lg-12";
            switch ($tipo) {
                case 0:
                    $class = "col-lg-12";
                    break;
                case 1:
                    $class = "col-lg-3";
                    break;
                case 2:
                    $class = "col-lg-1";
                    break;
            }

            return div($en_mobile, ["class" => $class]);

        } else {

            $img_enid = img_enid(["style" => "width: 50px!important;"]);
            $en_pc = anchor_enid($img_enid, ["href" => "../"]);
            return div($en_pc, "padding_10");
        }

    }
}
if (!function_exists('get_img_usuario')) {
    function get_img_usuario($id_usuario)
    {
        $url_img = "../imgs/index.php/enid/imagen_usuario/" . $id_usuario;
        $img_conf = [
            "id" => "imagen_usuario",
            "class" => "imagen_usuario",
            "src" => $url_img,
            "onerror" => "this.src='../img_tema/user/user.png'",
            "style" => "width: 40px!important;height: 35px!important;"
        ];

        return img($img_conf);

    }
}
if (!function_exists('microtime_float')) {
    function microtime_float()
    {
        list($useg, $seg) = explode(" ", microtime());
        return ((float)$useg + (float)$seg);
    }
}
if (!function_exists('lista_horarios')) {
    function lista_horarios($dia_busqueda = 0)
    {

        $fecha = horario_enid();
        $hoy = $fecha->format('Y-m-d');
        $hora_actual = date_format($fecha, 'H');
        $minuto_actual = date_format($fecha, 'i');
        $hora_actual = intval($hora_actual);
        $minuto_actual = intval($minuto_actual);
        $nuevo_dia = 0;
        $base = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00"];
        $horarios = [];

        /*Dia distonto horario completo  */
        $hora_actual = ($dia_busqueda != 0 && $dia_busqueda != $hoy) ? 19 : $hora_actual;

        switch ($hora_actual) {

            case ($hora_actual < 9 || $hora_actual >= 18):

                $horarios = $base;
                $nuevo_dia = ($hora_actual > 18) ? ($nuevo_dia = $nuevo_dia + 1) : $nuevo_dia;

                break;

            case 17:

                if ($minuto_actual < 10) {

                    $horarios[] = "18:00";

                } else {

                    $horarios = $base;
                    $nuevo_dia = ($hora_actual > 18) ? ($nuevo_dia = $nuevo_dia + 1) : $nuevo_dia;
                }

                break;

            default:

                for ($a = 0; $a < count($base); $a++) {

                    $hora = intval(substr($base[$a], 0, 2));
                    if ($hora > $hora_actual) {

                        $horarios[] = $base[$a];

                    }
                }

                break;
        }

        $select = "<select name='horario_entrega' class='form-control input-sm horario_entrega'  > ";
        foreach ($horarios as $row) {

            $select .= "<option value='" . $row . "'>" . $row . "</option>";

        }

        $select .= "</select>";
        $response = [
            "select" => $select,
            "nuevo_dia" => $nuevo_dia
        ];

        return $response;

    }
}
if (!function_exists('get_url_servicio')) {
    function get_url_servicio($id_servicio, $n = 0)
    {

        return ($n > 0) ? "../img_tema/productos/" . $id_servicio : "../producto/?producto=" . $id_servicio;

    }
}
if (!function_exists('img_servicio')) {
    function img_servicio($id, $external = 0)
    {
        $url = ($external > 0) ? "http://enidservice.com/inicio/imgs/index.php/enid/imagen_servicio/" . $id : get_url_request("imgs/index.php/enid/imagen_servicio/" . $id);

        $img = [
            'src' => $url,
            'id' => "imagen_" . $id,
            'class' => 'imagen-producto'
        ];

        return img($img);

    }
}


if (!function_exists('append')) {

    function append($array, $col = 0, $num_col = 0)
    {
        if (is_array($array)) {

            if (es_local() > 0) {
                $f = 0;
                foreach ($array as $clave => $row) {

                    if ($row == null && $row != "" && $clave != 0) {
                        echo " la clave  " . $clave . " va  null \n";
                        $f++;
                    }
                }
                if ($f > 0) {
                    print_r($array);
                }

            }

            $callback = function ($a, $b) {
                if (!is_null($b)) {
                    return " " . $a . $b;
                }
            };


            $response = array_reduce($array, $callback, '');

            if ($col > 0) {

                $response = ($num_col > 0) ? div($response, $num_col) : div($response);
            }

            return $response;

        } else {

            echo "No es array -> " . print_r($array);
        }

    }
}


/*
if (!function_exists('append')) {

    function append($array, $col = 0, $num_col = 0)
    {

        if (is_array($array)) {

            $callback = function ($a, $b) {

                if (!is_null($b)) {
                    return " " . $a . $b;
                }

            };


            $response = array_reduce($array, $callback, '');

            if ($col > 0) {

                $response = ($num_col > 0) ? div($response, $num_col) : div($response);
            }

            return $response;

        } else {

            echo "No es array -> " . print_r($array);
        }

    }
}
*/
if (!function_exists('get_request_email')) {
    function get_request_email($email, $asunto, $cuerpo)
    {

        return [
            "para" => $email,
            "asunto" => $asunto,
            "cuerpo" => $cuerpo

        ];
    }
}
if (!function_exists('es_email_valido')) {

    function es_email_valido($email)
    {
        $f = 0;
        $b = 0;
        if (!is_null($email)) {
            $f++;
            for ($a = 0; $a < strlen($email); $a++) {
                if (ctype_digit($email[$a])) {
                    $b++;
                }
            }
        }
        $es_valido = ($b < 6 && $f > 0) ? 1 : 0;
        return $es_valido;


    }
}
if (!function_exists('get_menu_session')) {
    function get_menu_session($is_mobile, $in_session, $proceso_compra = 1)
    {

        if ($in_session < 1) {


            $text = btw(
                div("Vender", ["style" => "font-size:.8em;"]),
                icon("fa fa-shopping-cart", ["style" => "margin-left:5px;font-size:1.1em;"]),
                "display_flex_enid"

            );


            $vender = anchor_enid(
                $text,
                [
                    "href" => "../login/?action=nuevo",
                    "class" => ' white text-uppercase letter-spacing-15',

                ]
            );


            $text = btw(
                div(" Iniciar sesión ", ["style" => "font-size:.8em;"]),
                icon("fa fa-user", ["style" => "margin-left:5px;font-size:1.1em;"]),
                "display_flex_enid"

            );
            $l_session = anchor_enid(
                $text,
                [
                    "href" => "../login",
                    "class" => " white text-uppercase letter-spacing-15"
                ]
            );


            $type_display = ($is_mobile > 0) ? " d-flex flex-column justify-content-between " : " display_flex_enid ";
            $list = div(append([$vender, $l_session]), $type_display);

            if ($proceso_compra < 1) {
                return div(ul($list, "largenav "), "text-right");
            }


        }

    }
}
if (!function_exists('btw')) {
    function btw($a, $b, $class = '', $row = 0, $frow = 0)
    {


        if (is_numeric($class)) {

            $n = intval($class);
            $class = " col-lg-" . $n;
            if ($row > 0) {

                $offset = 0;


                switch ($n) {

                    case 2:
                        $offset = 5;
                        break;
                    case 4:
                        $offset = 4;
                        break;
                    case 6:
                        $offset = 3;
                        break;
                    case 8:
                        $offset = 2;
                        break;

                    case 10:
                        $offset = 1;
                        break;
                }
                $class = $class . " col-lg-offset-" . $offset;
            }

            $response = div(append([$a, $b]), ["class" => $class]);

            if ($frow > 0) {

                $response = div(div(append([$a, $b]), $class), 13);
            }


        } else {


            $response = ($row > 0) ? div(div(append([$a, $b]), $class), 1) : div(append([$a, $b]), $class);

        }

        return $response;
    }
}
if (!function_exists('get_format_fecha_busqueda')) {

    function get_format_fecha_busqueda($def_inicio = 0, $def_fin = 0)
    {

        $vinicio = ($def_inicio != 0) ? $def_inicio : date("Y-m-d");
        $vfin = ($def_fin != 0) ? $def_fin : date("Y-m-d");


        $r[] = btw(
            div("Inicio", 'strong top_30 '),
            div(input([
                "name" => 'fecha_inicio',
                "class" => "form-control input-sm top_30",
                "id" => 'datetimepicker4',
                "value" => $vinicio,
                "type" => "date"
            ])),
            'col-lg-4 d-flex align-items-center justify-content-between'
        );


        $r[] = btw(
            div("Fin", 'strong top_30'),
            div(input(
                [

                    "name" => 'fecha_termino',
                    "class" => "form-control input-sm top_30",
                    "id" => 'datetimepicker5',
                    "value" => $vfin,
                    "type" => "date"

                ]
            )),
            'col-lg-4 d-flex align-items-center justify-content-between '
        );

        $r[] = div(guardar(text_icon("fa fa-chevron-right", "Búsqueda ")), 'col-lg-4 top_30');

        return append($r);


    }
}
if (!function_exists('get_format_izquierdo')) {
    function get_format_izquierdo($categorias_publicas_venta = [], $categorias_temas_de_ayuda = [], $agregar_categoria = 0)
    {
        $r[] = anchor_enid(
            img(
                [
                    "src" => '../img_tema/enid_service_logo.jpg', 'width' => '100%'
                ]
            ),
            [
                'href' => "../contact/#envio_msj"
            ]
        );


        if ($agregar_categoria > 0) {


            $r[] = div(heading_enid("CATEGORIAS DESTACADAS", 3));
            $r[] = div(anchor_enid(heading_enid("Agregar", 5, "underline top_20"), ["href" => path_enid("nfaq"), "class" => "black"]));

        }


        if (es_data($categorias_publicas_venta) || es_data($categorias_temas_de_ayuda)) {

            $r[] = get_format_listado_categorias($categorias_publicas_venta, $categorias_temas_de_ayuda);
        }


        $r[] = div(append([
            heading_enid("¿TIENES ALGUNA DUDA?", 3),
            anchor_enid("ENVIA TU MENSAJE",
                [
                    "href" => "../contact/#envio_msj",
                    'style' => 'color:black!important;text-decoration:underline;'
                ])

        ]),
            [
                "style" => "background: #f2f2f2;padding: 10px;",
                "class" => "top_30"
            ]
        );

        return append($r);


    }

}

if (!function_exists('get_img_serv')) {
    function get_img_serv($img)
    {

        return (es_data($img)) ? get_url_servicio($img[0]["nombre_imagen"], 1) : "";
    }
}
function format_phone($number)
{
    $txt = preg_replace('/[\s\-|\.|\(|\)]/', '', $number);
    $format = '[$1?$1 :][$2?($2):x][$3: ]$4[$5: ]$6[$7? $7:]';
    if (preg_match('/^(.*)(\d{3})([^\d]*)(\d{3})([^\d]*)(\d{4})([^\d]{0,1}.*)$/', $txt, $matches)) {
        $result = $format;
        foreach ($matches AS $k => $v) {
            $str = preg_match('/\[\$' . $k . '\?(.*?)\:(.*?)\]|\[\$' . $k . '\:(.*?)\]|(\$' . $k . '){1}/', $format, $filterMatch);
            if ($filterMatch) {
                $result = str_replace($filterMatch[0], (!isset($filterMatch[3]) ? (strlen($v) ? str_replace('$' . $k, $v, $filterMatch[1]) : $filterMatch[2]) : (strlen($v) ? $v : (isset($filterMatch[4]) ? '' : (isset($filterMatch[3]) ? $filterMatch[3] : '')))), $result);
            }
        }
        return $result;
    }
    return $number;
}

function get_metodos_pago()
{

    $r[] = div(img([
        'class' => "logo_pago",
        'style' => 'width:95px!important',
        'src' => "../img_tema/bancos/masterDebito.png"]));

    $r[] = div(img([
        'class' => "logo_pago",
        'style' => 'width:65px!important',
        'src' => "../img_tema/bancos/paypal2.png"]));

    $r[] = div(img([
        'class' => "logo_pago",
        'style' => 'width:95px!important',
        'src' => "../img_tema/bancos/visaDebito.png"]));

    $r[] = div(img([
        'class' => "logo_pago",
        'style' => 'width:65px!important',
        'src' => "../img_tema/bancos/oxxo-logo.png"]));

    $r[] = div(img([
        'class' => "logo_pago",
        'style' => 'width:85px!important',
        'src' => "../img_tema/bancos/bancomer2.png"]));

    $r[] = div(img([
        'class' => "logo_pago",
        'style' => 'width:85px!important',
        'src' => "../img_tema/bancos/santander.png"]));


    $r[] = div(img([
        'class' => "logo_pago",
        'style' => 'width:95px!important',
        'src' => "../img_tema/bancos/banamex.png"]));


    $r[] = div(img([
        'class' => "logo_pago",
        'style' => 'width:65px!important',
        'src' => "../img_tema/bancos/fedex.png"]));

    $r[] = div(img(
        [
            'class' => "logo_pago",
            'style' => 'width:75px!important',
            'src' => "../img_tema/bancos/dhl2.png"
        ]));


    return div(div(append($r), "col-lg-12 d-flex flex-row justify-content-between"), "info_metodos_pago row");

}

function path_enid($pos, $extra = 0, $link_directo = 0)
{

    $base_url = [
        "url_home" => "../reporte_enid",
        "forma_pago" => "forma_pago/?info=1",
        "forma_pago_search" => "forma_pago/?recibo=",
        "nfaq" => "faq/?nueva=1",
        "editar_faq" => "faq/?faq=",
        "img_faq" => "img_tema/productos/",
        "faqs" => "faq",
        "login" => "login",
        "_login" => "../login",
        "vender" => "planes_servicios",
        "vender_nuevo" => "planes_servicios/?action=nuevo",
        "editar_producto" => "planes_servicios/?action=editar&servicio=",
        "sobre_enid" => "sobre_enidservice",
        "img_logo" => "img_tema/enid_service_logo.jpg",
        "pregunta" => "pregunta",
        "pregunta_search" => "pregunta/?tag=",
        "search" => "search",
        "search_q3" => "search/?q3=",
        "paypal_enid" => "https://www.paypal.me/eniservice/",
        "home" => "",
        "pedidos" => "pedidos",
        "pedido_seguimiento" => "pedidos/?seguimiento=",
        "producto" => "producto/?producto=",
        "pedidos_recibo" => "pedidos/?recibo=",
        "imagen_usuario" => "imgs/index.php/enid/imagen_usuario/",
        "youtube_embebed" => "https://www.youtube.com/embed/",
        "area_cliente_compras" => "area_cliente/?action=compras&ticket=",
        "area_cliente" => "area_cliente",
        "area_cliente_pregunta" => "area_cliente/?action=preguntas",
        "instagram" => "https://www.instagram.com/enid_service/",
        "twitter" => "https://twitter.com/enidservice",
        "facebook" => "https://www.facebook.com/enidservicemx/",
        "pinterest" => "https://es.pinterest.com/enid_service",
        "linkeding" => "https://www.linkedin.com/in/enid-service-433651138",
        "tumblr" => "https://enidservice.tumblr.com/",
        "administracion_cuenta" => "administracion_cuenta",
        "logout" => "login/index.php/startsession/logout",
        "nuevo_usuario" => "login/?action=nuevo",
        "lista_deseos" => "lista_deseos",
        "terminos-y-condiciones" => "terminos-y-condiciones",
        "contacto" => "contact/#envio_msj",
        "contact" => "contact/?ubicacion=1#direccion",
        "recomendacion" => "recomendacion/?q=",
        "compras" => "compras",
        "tiempo_venta" => "tiempo_venta",
        "ventas_encuentro" => "ventas_encuentro",
        "config_path" => "config/config.php",
        "config_mines" => "config/mimes.php",
        "config_db" => "db/database.php",
        "config_constants" => "config/constants.php",
        "desarrollo" => "desarrollo",
        "go_home" => "../",
        "valoracion_servicio" => "valoracion/?servicio="

    ];


    if (array_key_exists($pos, $base_url)) {

        $path = ($link_directo > 0) ? (($extra !== 0) ? $base_url[$pos] . $extra : $base_url[$pos]) : (($extra !== 0) ? "../" . $base_url[$pos] . $extra : "../" . $base_url[$pos]);

    } else {

        echo "NO EXISTE ->  " . $pos;
    }

    return $path;

}

function text_icon($class_icono, $text, $att = [], $left = 1)
{

    return ($left > 0) ? (icon($class_icono, $att) . " " . $text) : ($text . " " . icon($class_icono, $att));

}

function horario_enid()
{

    return new DateTime('now', new DateTimeZone(config_item('time_reference')));

}

function add_text($a, $b, $f = 0)
{

    return ($f > 0) ? $a . $b : $a . " " . $b;

}

function get_social($proceso_compra, $desc_web, $black = 1)
{

    $url_share = current_url() . '?' . $_SERVER['QUERY_STRING'];
    $url_facebook = get_url_facebook($url_share);
    $url_twitter = get_url_twitter($url_share, $desc_web);
    $url_pinterest = get_url_pinterest($url_share, $desc_web);
    $url_tumblr = get_url_tumblr($url_share, $desc_web);

    $color = ($black > 0) ? "black" : "white";

    $response = "";
    if ($proceso_compra < 1) {


        $r[] = anchor_enid("",
            [
                "href" => $url_facebook,
                "target" => "_black",
                "class" => "fa fa-facebook " . $color,

            ]);

        $r[] = anchor_enid("",
            [
                "href" => "https://www.instagram.com/enid_service/",
                "class" => "fa fa-instagram " . $color,
                "title" => "Tumblr",
                "target" => "_black",
            ]);

        $r[] = anchor_enid("",
            [
                "target" => "_black",
                "class" => "fa fa-twitter " . $color,
                "title" => "Tweet",
                "target" => "_black",
                "data-size" => "large",
                "href" => $url_twitter,
            ]);
        $r[] = anchor_enid("",
            [
                "href" => $url_pinterest,
                "target" => "_black",
                "class" => "fa fa-pinterest-p " . $color,
                "title" => "Pin it"
            ]);

        $r[] = anchor_enid("",
            [
                "href" => $url_tumblr,
                "class" => "fa fa-tumblr " . $color,
                "target" => "_black",
                "title" => "Tumblr"
            ]);

        $social = append($r);
        $response = div($social, "contenedor_social display_flex_enid mt-5");
    }
    return div($response, 1);

}

function es_data($e)
{

    return (is_array($e) && count($e) > 0) ? true : false;
}

function val_class($a, $b, $class, $def = "")
{

    return ($a == $b) ? $class : $def;
}

function menorque($a, $b, $menor = 1, $mayor = "")
{

    return ($a < $b) ? $menor : $mayor;
}

function mayorque($a, $b, $mayor = 1, $menor = "")
{

    return ($a > $b) ? $mayor : $menor;
}

function search_bi_array($array, $columna, $busqueda, $get = false, $si_false = "")
{

    $arr_col = array_column($array, $columna);
    $index = array_search($busqueda, $arr_col);
    $response = $index;

    if ($get != false) {

        $response = ($index != false) ? $array[$index][$get] : $si_false;
    }

    return $response;
}

function key_exists_bi($data, $k, $sk, $def = "")
{

    return (is_array($data) && array_key_exists($k, $data) && is_array($data[$k]) && array_key_exists($sk, $data[$k])) ? $data[$k][$sk] : $def;
}

function primer_elemento($data, $index, $def = false)
{

    return (is_array($data) && count($data) > 0 && array_key_exists($index, $data[0])) ? $data[0][$index] : $def;
}

function ajustar($a, $b, $horizontal = 1)
{

    $extra = (is_string($horizontal)) ? $horizontal : "";
    $class = ($horizontal > 0) ? "d-flex align-items-center justify-content-between " . $extra : "d-flex flex-column justify-content-between " . $extra;
    return div(div($a) . div($b), $class);

}

function es_null($data, $index, $def = "")
{

    return (is_array($data) && array_key_exists($index, $data) && $data[$index] != null) ? $data[$index] : $def;
}

function create_contenido_menu($data)
{

    $navegacion = get_param_def($data, "data_navegacion", []);
    $id_empresa = get_param_def($data, "idempresa");
    $menu = [];

    foreach ($navegacion as $row) {

        $menu[] = li(anchor_enid(icon($row["iconorecurso"]) . $row["nombre"],
            [
                "href" => ($row["idrecurso"] == 18) ? base_url($row["urlpaginaweb"]) . "/?q=" . $id_empresa : base_url($row["urlpaginaweb"]),
                "class" => 'black'
            ]));


    }
    return append($menu);
}


