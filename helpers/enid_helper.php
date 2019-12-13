<?php

function ul($list, $attributes = [])
{

    return _list('ul', $list, (
    is_string($attributes)) ? ["class" => $attributes] : $attributes);

}


function li($info, $attributes = [], $row_12 = 0)
{
    return add_element($info, "li", (
    is_string($attributes)) ? ["class" => $attributes] : $attributes, $row_12);
}


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


function p($str, $attributes = [], $row = 0)
{
    return get_base_html("p", $str, $attributes, $row);

}


function btn($info, $attributes = [], $row = 0, $type = 1, $submit = 1, $anchor = 0)
{

    if (is_string($attributes)) {
        $attributes = [];
        $attributes["class"] = $attributes;
    }
    if ($submit == 1) {

        $attributes["type"] = "submit";
    }

    if ($type == 1) {

        $attributes["class"] =
            (array_key_exists(
                "class", $attributes) ? 1 : 0 == 1) ? $attributes["class"]
                . " " . " a_enid_blue p-2 white w-100  strong cursor_pointer format_action" :
                "a_enid_blue white p-2 format_action cursor_pointer";
    }


    $attr = add_attributes($attributes);
    if ($row == 0) {

        return "<button " . $attr . ">" . $info . "</button>";

    } else {

        $b = ($anchor !== 0) ? "<a href='" . $anchor . "'> <button " . $attr . ">" . $info . "</button></a>" : "<button " . $attr . ">" . $info . "</button>";

        return d($b, 1);
    }
}


function add_element($info, $type, $attributes = '', $row = 0)
{

    $base = "<" . $type . " " . add_attributes($attributes) . " >" . $info . "</" . $type . ">";

    return ($row < 1) ? $base : addNRow($base);

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


function get_base_html($tipo, $info, $attributes = [], $row = 0, $frow = 0)
{
    $response = "";
    if (is_numeric($attributes)) {

        switch ($attributes) {
            case 1:

                return addNRow($info);

                break;
            case 2:

                $response = ($row > 0) ? "<{$tipo} class='p-0 col-lg-2 col-lg-offset-5'>" . $info . "</{$tipo}>" : "<{$tipo} class='p-0 col-lg-2'>" . $info . "</{$tipo}>";

                break;
            case 3:
                $response = "<{$tipo} class='p-0 col-lg-3'>" . $info . "</{$tipo}>";
                break;
            case 4:
                $response = ($row > 0) ? "<{$tipo} class='p-0 col-lg-4 col-lg-offset-4'>" . $info . "</{$tipo}>" : "<{$tipo} class='p-0 col-lg-4'>" . $info . "</{$tipo}>";
                break;
            case 5:
                $response = "<{$tipo} class='p-0 col-lg-5'>" . $info . "</{$tipo}>";
                break;
            case 6:

                $response = ($row > 0) ? "<{$tipo} class='p-0 col-lg-6 col-lg-offset-3'>" . $info . "</{$tipo}>" : "<{$tipo} class='p-0 col-lg-6'>" . $info . "</{$tipo}>";

                break;

            case 7:

                $response = "<{$tipo} class='p-0 col-lg-7'>" . $info . "</{$tipo}>";
                break;


            case 8:

                $response = ($row > 0) ? "<{$tipo} class='p-0 col-lg-8 col-lg-offset-2'>" . $info . "</{$tipo}>" : "<{$tipo} class='p-0 col-lg-8'>" . $info . "</{$tipo}>";

                break;
            case 9:
                $response = "<{$tipo} class='p-0 col-lg-9'>" . $info . "</{$tipo}>";
                break;

            case 10:


                $response = ($row > 0) ? "<{$tipo} class='p-0 col-lg-10 col-lg-offset-1'>" . $info . "</{$tipo}>" : "<{$tipo} class='p-0 col-lg-10'>" . $info . "</{$tipo}>";

                break;

            case 11:
                $response = "<{$tipo} class='p-0 col-lg-11'>" . $info . "</{$tipo}>";
                break;


            case 12:


                $response = "<{$tipo} class='p-0 col-lg-12'>" . $info . "</{$tipo}>";

                break;

            case 13:

                $response = "<{$tipo} class=' row '>" . $info . "</{$tipo}>";

                break;


        }

        if ($frow > 0) {
            $response = d($response, 13);
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


function d($text, $attributes = [], $row = 0, $frow = 0)
{


    if (is_array($text)) {
        $text = append($text);
    }

    return get_base_html("div", $text, $attributes, $row, $frow);


}

function d_p($info, $attributes = [], $row = 0, $frow = 0)
{

    return d(p($info), $attributes, $row, $frow);

}

function format_time($info, $attributes = [], $row = 0, $frow = 0)
{
    return get_base_html("time", $info, $attributes, $row, $frow);
}


function u($info, $attributes = [], $row = 0, $frow = 0)
{

    return get_base_html("u", $info, $attributes, $row, $frow);

}


function del($info, $attributes = [], $row = 0, $frow = 0)
{

    return get_base_html("del", $info, $attributes, $row, $frow);

}

function section($info, $attributes = [], $row = 0, $frow = 0)
{

    return get_base_html("section", $info, $attributes, $row, $frow);

}

function article($info, $attributes = [], $row = 0, $frow = 0)
{

    return get_base_html("article", $info, $attributes, $row, $frow);

}


function input($attributes = [], $e = 0, $bootstrap = 1)
{

    $attributes["class"] = (array_key_exists("class",
        $attributes)) ? ($attributes["class"] . " ") : "  ";


    if ($bootstrap) {

        $attributes["class"] = (array_key_exists("class", $attributes)) ? (
            $attributes["class"] . " form-control ") : " form-control ";
    }

    if (prm_def($attributes, "type") !== 0) {

        $type = $attributes["type"];

        switch ($type) {

            case "tel":

                $attributes["onpaste"] = "paste_telefono();";
                $attributes["class"] = (array_key_exists("class",
                    $attributes)) ? ($attributes["class"] . " telefono ") : " telefono ";
                $attributes["minlength"] = 8;
                $attributes["maxlength"] = 10;
                $attributes["required"] = true;

                break;


            case "number":

                $attributes["onpaste"] = "paste_telefono();";
                $attributes["minlength"] = 1;
                $attributes["maxlength"] = 3;
                $attributes["required"] = true;
                $attributes["min"] = 0;

                break;


            case "email":

                $attributes["required"] = "true";
                $attributes["pattern"] = '[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)';
                $attributes['title'] = "Verifica el formato de tu correo!";
                $attributes["onpaste"] = "paste_email();";
                $attributes["class"] = (array_key_exists("class",
                    $attributes)) ? ($attributes["class"] . " correo ") : " correo ";

                break;

            case "password":

                $attributes["required"] = "true";
                break;

            case "text":

                if (prm_def($attributes, "name") === "nombre") {
                    $attributes["onpaste"] = "paste_nombre();";
                    $attributes["class"] = (array_key_exists("class", $attributes)) ? (
                        $attributes["class"] . " validar_nombre ") : " validar_nombre ";
                    $attributes["minlength"] = 3;
                }
                break;

            case "checkbox":

                $attributes["class"] = (array_key_exists("class",
                    $attributes)) ? ($attributes["class"] . " checkbox_enid border cursor_pointer rounded") : " checkbox_enid border cursor_pointer rounded";

                break;


            default:

        }

    }

    $attributes["autocomplete"] = "off";
    $attr = add_attributes($attributes);

    return ($e < 1) ? "<input " . $attr . " >" : addNRow("<input " . $attr . " >");

}


function hiddens($attributes = '', $e = 0)
{

    $input = "<input type='hidden'  " . add_attributes($attributes) . " >";

    return ($e == 0) ? $input : addNRow($input);

}


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


function end_row()
{
    return str_repeat("</div>", 2);
}


function n_row_12($attributes = '')
{

    return "<div class='row'><div class='col-lg-12 ' " . _parse_attributes($attributes) . ">";

}


function a_enid($title = '', $attributes = [], $format_block = 1)
{

    $att = (is_string($attributes)) ? ["href" => $attributes] : $attributes;
    if ($format_block > 0) {


        $class = (es_data($att) && array_key_exists("class",
                $att)) ? add_text($att["class"], " d-block") : " d-block";

        if (is_array($attributes) && array_key_exists('rm_class', $attributes)) {
            $class = str_replace($attributes['rm_class'], ' ', $class);
        }

        $att["class"] = $class;
    }


    return get_base_html("a", $title, $att);

}

function tab($text, $accion, $attributes = [])
{

    $attributes["data-toggle"] = "tab";
    $attributes["href"] = $accion;
    if (array_key_exists("class", $attributes)) {
        $attributes["class"] = $attributes["class"] . " text-uppercase black ";
    } else {

        $attributes["class"] = " text-uppercase black";
    }

    return a_enid($text, $attributes);

}

function tab_seccion($contenido, $id_selector, $activo = 0, $attributes = [])
{

    if (is_array($contenido)) {
        $contenido = append($contenido);
    }
    if (array_key_exists("class", $attributes)) {
        $attributes["class"] = $attributes["class"] . "tab-pane  ";
    } else {
        $attributes["class"] = " tab-pane  ";
    }
    if ($activo > 0) {

        $attributes["class"] = $attributes["class"] . " tab-pane active ";
    }

    $attributes['role'] = "tabpanel";
    $attributes['id'] = $id_selector;
    return d($contenido, $attributes);

}

function tab_activa($seccion, $activa)
{
    return ($seccion == $activa) ? 1 : 0;

}


function tab_content($array = [], $col = 0)
{

    $response = d(append($array), 'tab-content');
    if ($col > 0) {
        $response = d($response, $col);
    }
    return $response;
}


function td($val = '', $attributes = [])
{

    if (is_array($attributes)) {

        return "<td " . add_attributes($attributes) . " NOWRAP >" . $val . "</td>";

    } else {

        return (is_string($attributes) && strlen($attributes) > 0) ?
            "<td " . add_attributes(["class" => $attributes]) . " NOWRAP >" . $val . "</td>" :
            "<td " . add_attributes($attributes) . " NOWRAP >" . $val . "</td>";

    }

}


function get_th($val = '', $attributes = '')
{

    return "<th " . add_attributes($attributes) . " NOWRAP >" . $val . "</th>";
}


function tr($val = '', $attributes = '')
{

    if (is_array($val)) {

        return "<tr " . add_attributes($attributes) . " >" . append($val) . "</tr>";

    } else {

        return "<tr " . add_attributes($attributes) . " >" . $val . "</tr>";
    }

}

function tb($val = '', $attributes = '')
{

    if (is_array($val)) {

        return "<table " . add_attributes($attributes) . " >" . append($val) . "</table>";

    } else {

        return "<table " . add_attributes($attributes) . " >" . $val . "</table>";
    }

}

function select_enid($data, $text_option, $val, $attributes = '')
{

    $select[] = "<select " . add_attributes($attributes) . "> ";
    foreach ($data as $row) {
        $select[] = "<option value='" . $row[$val] . "'>" . $row[$text_option] . " </option>";
    }
    $select[] = "</select>";

    return append($select);
}


function remove_comma($text)
{

    return str_replace("'", '', (str_replace('"', '', $text)));
}

function h($data = '', $h = 1, $attributes = '', $row_12 = 0)
{


    if (is_numeric($attributes) && $attributes > 0) {

        $response = addNRow("<h$h>" . $data . "</h$h>");

    } else {

        if (is_string($attributes)) {


            $label = "<h$h " . add_attributes(["class" => $attributes]) . ">" . $data . "</h$h>";
            $response = ($row_12 > 0) ? addNRow($label) : $label;


        } else {


            $label = "<h$h " . add_attributes($attributes) . ">" . $data . "</h$h>";
            $response = ($row_12 > 0) ? addNRow($label) : $label;

        }


    }

    return "<header>" . $response . "</header>";

}


function get_url_request($extra)
{

    return "http://" . $_SERVER['HTTP_HOST'] . "/inicio/" . $extra;

}


function es_local()
{

    return ($_SERVER['HTTP_HOST'] !== "localhost") ? 0 : 1;

}


function icon($class, $attributes = '', $row_12 = 0, $extra_text = '')
{

    $attr = add_attributes($attributes);
    $base = "<i class='fa " . $class . "'" . $attr . " ></i>";
    $base2 = span($extra_text, $attributes);

    return ($row_12 == 0) ? $base . $base2 : addNRow($base) . $base2;

}


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
        'table_close' => '</table>',
    );

    return $template;
}


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
                'id' => $id,
            ]
        );
    }
    $new_tags = add_element($tags, "d", array('class' => 'tags'));

    return $new_tags;
}


function get_array_json($val)
{

    $response = [];
    if (strlen(trim($val)) > 1) {

        $response = json_decode($val, true);

    }

    return $response;
}


function get_json_array($arr)
{


    return (count($arr) > 0) ? json_encode($arr) : json_encode([]);

}


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

    }

    return $arr;
}


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
                    "existencia" => $extra,
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


function create_select(
    $data,
    $name,
    $class,
    $id,
    $text_option,
    $val,
    $row = 0,
    $def = 0,
    $valor = 0,
    $text_def = ""
)
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


function prm_def($data, $key, $val_def = 0, $valida_basura = 0)
{

    $val = (is_array($data) && array_key_exists($key,
            $data) && $data[$key] !== null) ? $data[$key] : $val_def;

    if ($valida_basura > 0) {

        if ((is_array($data) && array_key_exists($key, $data))) {
            evita_basura($data[$key]);
        }
    }

    return $val;

}

function label($label_text = '', $attributes = [], $row = 0)
{


    $base = (is_string($attributes)) ?
        "<label" . add_attributes(["class" => $attributes]) . ">" . $label_text . "</label>" :
        "<label" . add_attributes($attributes) . ">" . $label_text . "</label>";

    return ($row == 0) ? $base : addNRow($base);


}


function addNRow($e, $attributes = [])
{

    return (is_string($attributes)) ?
        n_row_12(["class" => $attributes]) . $e . end_row() :
        n_row_12($attributes) . $e . end_row();


}


function place($class, $attributes = [], $row = 0)
{

    if (is_numeric($attributes) && $attributes > 0) {

        return d("", ["class" => $class]);

    } else {

        $attributes["class"] = $class;
        if (!array_key_exists("id", $attributes)) {
            $attributes["id"] = $class;
        }

        return d("", $attributes, $row);
    }

}


function img_enid($extra = [], $row_12 = 0, $external = 0)
{


    $conf["src"] = ($external == 0) ?
        "../img_tema/enid_service_logo.jpg" : "https://enidservices.com/inicio/img_tema/enid_service_logo.jpg";

    if (es_data($extra)) {
        $conf += $extra;
    }
    $img = img($conf);

    return ($row_12 == 0) ? $img : addNRow($img);
}


function url_recuperacion_password()
{

    return "../msj/index.php/api/mailrest/recupera_password/format/json/";
}


//function get_dominio($url)
//{
//    $protocolos = ['http://', 'https://', 'ftp://', 'www.'];
//    $url = explode('/', str_replace($protocolos, '', $url));
//
//    return $url[0];
//}

//function mayus($variable)
//{
//    return strtr(strtoupper($variable), "àèìòùáéíóúçñäëïöü", "ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
//
//}


function get_campo($param, $key, $label = "", $add_label = 0)
{

    return ($add_label > 0) ? ($label . "  " . $param[0][$key]) : ((count($param) > 0) ? $param[0][$key] : "");

}


function usuario($q2)
{
    $id_usuario_envio = 0;
    if (isset($q2) && $q2 != null) {
        $id_usuario_envio = $q2;
    }

    return $id_usuario_envio;
}


function now_enid()
{
    return date('Y-m-d');
}


function porcentaje($cantidad, $porciento, $decimales = 2, $numeric_format = 0)
{
    $response = 0;
    if (is_numeric($cantidad) == is_numeric($porciento)) {

        $response = ($numeric_format == 1) ? (number_format($cantidad * $porciento / 100,
            $decimales)) : ($cantidad * $porciento / 100);

    }

    return $response;
}


function porcentaje_total($cantidad, $total)
{
    $response = 0;
    if ($total > 0) {

        $response = $cantidad * 100 / $total;
    }

    return $response;

}


function get_url_pinterest($url, $icon = 0)
{

    $url_pinterest = "https://www.pinterest.com/pin/create/button/?url=" . $url;
    if ($icon > 0) {
        return a_enid(icon('fa fa-pinterest-p'),
            [
                'target' => "_black",
                'href' => $url_pinterest,
                'class' => 'black',
            ]);
    }

    return $url_pinterest;

}


function get_url_twitter($url, $mensaje, $icon = 0)
{

    $url_twitter = "https://twitter.com/intent/tweet?text=" . $mensaje . $url;
    if ($icon > 0) {
        return a_enid(icon('fa fa-twitter'),
            [
                'target' => "_black",
                'href' => $url_twitter,
            ]);
    }

    return $url_twitter;
}


function get_url_facebook($url, $icon = 0)
{

    $url_facebook = "https://www.facebook.com/sharer/sharer.php?u=" . $url . ";src=sdkpreparse";
    if ($icon > 0) {
        return a_enid(
            icon('fa fa-facebook-square'),
            [
                'target' => "_black",
                'href' => $url_facebook,
            ]
        );
    }

    return $url_facebook;

}

function get_url_tienda($id_usuario)
{

    return "http://" . $_SERVER['HTTP_HOST'] . "/inicio/search/?q3=" . $id_usuario;

}


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


function get_keys($array_keys)
{
    return implode(",", $array_keys);
}


function create_url_preview($img)
{
    return base_url() . "../img_tema/portafolio/" . $img;
}


function lib_def()
{
    return "../../librerias/app";
}


function valida_num($num)
{
    return ($num > 0) ? $num : 0;
}


function randomString($length = 10, $uc = true, $n = true, $sc = false)
{
    $rstr = "";
    $source = 'abcdefghijklmnopqrstuvwxyz';
    if ($uc == 1) {
        $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    if ($n == 1) {
        $source .= '1234567890';
    }
    if ($sc == 1) {
        $source .= '|@#~$%()=^*+[]{}-_';
    }
    if ($length > 0) {

        $source = str_split($source, 1);
        for ($i = 1; $i <= $length; $i++) {
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1, count($source));
            $rstr .= $source[$num - 1];
        }
    }

    return $rstr;
}


function site_url($uri = '')
{
    $CI =& get_instance();

    return $CI->config->site_url($uri);
}


function get_drop($tmp_table)
{
    return "DROP TABLE IF EXISTS " . $tmp_table . " ";

}

function valida_extension($string, $num_ext, $strin_secundario)
{

    return (strlen($string) > $num_ext) ? $string : $strin_secundario;

}


function link_imagen_servicio($id)
{

    return ($id > 0) ? "../imgs/index.php/enid/imagen_servicio/" . $id : "";
}


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

function small($text, $attributes = [])
{

    if (is_string($attributes)) {

        $att["class"] = $attributes;

        return "<small " . add_attributes($att) . " > " . $text . "</small>";

    } else {

        return "<small " . add_attributes($attributes) . " > " . $text . "</small>";

    }

}


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

function border($attributes = [])
{

    $extra = (is_string($attributes)) ? $attributes : add_attributes($attributes);

    return d("", "border " . $extra);
}


function debug($msg, $array = 0)
{
    $response = false;
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
                'DEBUG' . ' -' . ' TYPE ' . gettype($msg) . ' ' . date($_date_fmt) . ' --> ' . print_r($msg,
                    true) . "\n";
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $message);
        flock($fp, LOCK_UN);
        fclose($fp);

        $response = true;
    }

    return $response;

}


function get_costo_envio($param)
{


    $gratis = $param["flag_envio_gratis"];
    $tipo_entrega = $param['tipo_entrega'];
    $r = [];
    if ($gratis == 1) {

        $r["costo_envio_cliente"] = 0;
        $r["costo_envio_vendedor"] = 100;
        $r["text_envio"] = texto_costo_envio_info_publico(
            $gratis,
            $r["costo_envio_cliente"],
            $r["costo_envio_vendedor"],
            $tipo_entrega
        );
    } else {

        $r["costo_envio_cliente"] = 100;
        $r["costo_envio_vendedor"] = 0;
        $r["text_envio"] = texto_costo_envio_info_publico(
            $gratis,
            $r["costo_envio_cliente"],
            $r["costo_envio_vendedor"],
            $tipo_entrega
        );
    }

    return $r;
}

function texto_costo_envio_info_publico(
    $flag_envio_gratis,
    $costo_envio_cliente,
    $costo_envio_vendedor,
    $tipo_entrega
)
{

    $text_envio = ['', ' MXN DE TU ENTREGA', ' MXN DE ENVÍO', ''];
    $response = ($flag_envio_gratis > 0) ?
        [
            "cliente" => "ENTREGA GRATIS!",
            "cliente_solo_text" => "ENTREGA GRATIS!",
            "ventas_configuracion" => "TU PRECIO YA INCLUYE EL ENVÍO",
        ]
        :
        [

            "ventas_configuracion" => "EL CLIENTE PAGA SU ENVÍO, NO GASTA POR EL ENVÍO",
            "cliente_solo_text" => _text($costo_envio_cliente, $text_envio[$tipo_entrega]),
            "cliente" => _text($costo_envio_cliente, $text_envio[$tipo_entrega]),
        ];


    return $response;
}


function fx($param, $k = '', $num = 0)
{

    $keys = explode(",", $k);
    $z = 0;
    if (es_data($keys)) {
        $z = 1;
        for ($a = 0; $a < count($keys); $a++) {

            if ($keys[$a] != null) {


                if (!array_key_exists(trim($keys[$a]),
                        $param) || strlen(trim($param[$keys[$a]])) < $num) {
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


function textarea($attributes = [], $row_12 = 0, $def = '')
{

    $attributes["rows"] = "2";

    if (array_key_exists("class", $attributes)) {
        $attributes["class"] = $attributes["class"] . " form-control rounded-0";
    } else {
        $attributes["class"] = " form-control rounded-0";
    }
    $base = "<textarea " . add_attributes($attributes) . " >" . $def . "</textarea>";
    $e = ($row_12 == 0) ? $base : addNRow($base);

    return $e;

}


function iframe($attributes = '', $row_12 = 0)
{
    $base = "<iframe " . add_attributes($attributes) . " ></iframe>";

    return ($row_12 == 0) ? $base : addNRow($base);
}


//function center($attributes = '', $row_12 = 0)
//{
//
//    $base = "<center ".add_attributes($attributes)." ></center>";
//
//    return ($row_12 == 0) ? $base : addNRow($base);
//
//}

/*Ordena el arreglo de a cuerdo al tipo de indice que se indique*/

function sksort(&$array, $subkey = "id", $sort_ascending = false)
{
    if (count($array)) {
        $temp_array[key($array)] = array_shift($array);
    }
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
        if (!$found) {
            $temp_array = array_merge($temp_array, array($key => $val));
        }
    }
    if ($sort_ascending) {
        $array = array_reverse($temp_array);
    } else {
        $array = $temp_array;
    }
}


function date_difference($date_1, $date_2, $differenceFormat = '%a')
{
    $interval = date_diff(date_create($date_1), date_create($date_2));

    return $interval->format($differenceFormat);
}


function add_date($inicio, $dias)
{

    $fecha = date_create($inicio);
    date_add($fecha, date_interval_create_from_date_string($dias . ' days'));

    return date_format($fecha, 'Y-m-d');
}


function evita_basura($text)
{

    $basura = ["'", "?", "=", "|", "*"];
    $b = 0;
    for ($a = 0; $a < count($basura); $a++) {

        if (strpos($text, $basura[$a]) !== false) {
            $b++;
        }
    }
    if ($b > 0) {
        redirect("https://www.google.com/", "refresh", 302);
    }

    return $b;
}


//function add_hour($num_hours)
//{
//    $nowtime = date("Y-m-d H:i:s");
//    $num_hours = $num_hours * 60;
//    $date = date('H:i:s', strtotime($nowtime.' + '.$num_hours.' minute'));
//
//    return $date;
//
//}

function get_logo($is_mobile, $tipo = 0)
{

    if ($is_mobile == 1) {

        $en_mobile = d("☰ ENID SERVICE",
            ["class" => "smallnav menu white f12 ", "onclick" => "openNav()"]);
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

        return d($en_mobile, ["class" => $class]);

    } else {

        $img_enid = img_enid(["style" => "width: 50px!important;"]);
        $en_pc = a_enid($img_enid, ["href" => "../", "class" => "ml-5"]);

        return $en_pc;
    }

}


function get_img_usuario($id_usuario)
{
    $url_img = "../imgs/index.php/enid/imagen_usuario/" . $id_usuario;
    $img_conf = [
        "id" => "imagen_usuario",
        "class" => "imagen_usuario",
        "src" => $url_img,
        "onerror" => "this.src='../img_tema/user/user.png'",
        "style" => "width: 40px!important;height: 35px!important;",
    ];

    return img($img_conf);

}


function microtime_float()
{
    list($useg, $seg) = explode(" ", microtime());

    return ((float)$useg + (float)$seg);
}


function horarios()
{
    //[FIXME]
    $horarios = [
        "08:00",
        "08:30",
        "09:00",
        "09:30",
        "10:00",
        "10:30",
        "11:00",
        "11:30",
        "12:00",
        "12:30",
        "13:00",
        "13:30",
        "14:00",
        "14:30",
        "15:00",
        "15:30",
        "16:00",
        "16:30",
        "17:00",
        "17:30",
        "18:00",
        "18:30",
        "19:00",
        "19:30",
        "20:00",
        "20:30",
        "21:00",
        "21:30",
        "22:00",
        "22:30",
        "23:00",
        "23:30",
    ];

    $select = "<select name='horario_entrega' class='form-control  horario_entrega'  > ";
    foreach ($horarios as $row) {

        $select .= "<option value='" . $row . "'>" . $row . "</option>";

    }

    $select .= "</select>";

    return $select;
}

function lista_horarios($dia_busqueda = 0)
{


    $fecha = horario_enid();
    $hoy = $fecha->format('Y-m-d');
    $hora_actual = date_format($fecha, 'H');
    $minuto_actual = date_format($fecha, 'i');
    $hora_actual = intval($hora_actual);
    $minuto_actual = intval($minuto_actual);
    $nuevo_dia = 0;
    //[FIXME]
    $base = [
        "09:00",
        "09:30",
        "10:00",
        "10:30",
        "11:00",
        "11:30",
        "12:00",
        "12:30",
        "13:00",
        "13:30",
        "14:00",
        "14:30",
        "15:00",
        "15:30",
        "16:00",
        "16:30",
        "17:00",
        "17:30",
        "18:00",
    ];
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

    $select = "<select name='horario_entrega' class='form-control  horario_entrega'  > ";
    foreach ($horarios as $row) {

        $select .= "<option value='" . $row . "'>" . $row . "</option>";

    }

    $select .= "</select>";
    $response = [
        "select" => $select,
        "nuevo_dia" => $nuevo_dia,
    ];

    return $response;


}


function get_url_servicio($id_servicio, $n = 0)
{

    return ($n > 0) ? "../img_tema/productos/" . $id_servicio : "../producto/?producto=" . $id_servicio;

}


function img_servicio($id, $external = 0)
{
    $url = ($external > 0) ? "http://enidservices.com/inicio/imgs/index.php/enid/imagen_servicio/" . $id : get_url_request("imgs/index.php/enid/imagen_servicio/" . $id);

    $img = [
        'src' => $url,
        'id' => "imagen_" . $id,
        'class' => 'imagen-producto',
    ];

    return img($img);

}


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

            $response = ($num_col > 0) ? d($response, $num_col) : d($response);
        }


    } else {

        echo "No es array -> " . print_r($array);
    }

    return $response;
}

function m($str)
{
    return d($str, 'col-lg-12');
}

function get_request_email($email, $asunto, $cuerpo)
{

    return [
        "para" => $email,
        "asunto" => $asunto,
        "cuerpo" => $cuerpo,
    ];
}


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

function get_menu_session($in_session, $proceso_compra = 1)
{

    $response = "";
    if ($in_session < 1) {

        $vender = a_enid(
            "Agiliza tus ventas",
            [
                "href" => "../login/?action=nuevo",
                "class" => ' white text-uppercase strong text_agilizar',

            ]
        );


        $session = a_enid(
            text_icon("fa fa-user", " INICIAR SESIÓN ",
                [],
                0
            )
            ,
            [
                "href" => path_enid('login'),
                "class" => "text_iniciar_session text-decoration-none mr-4",
            ]
        );


        if ($proceso_compra < 1) {

            $response = flex($vender, $session,
                "d-flex justify-content-end bd-highlight-row-reverse bd-highlight",
                "mr-3 ");


        }

    }

    return $response;

}

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

        $response = d(append([$a, $b]), ["class" => $class]);

        if ($frow > 0) {

            $response = d(d(append([$a, $b]), $class), 13);
        }


    } else {

        $response = ($row > 0) ? d(d(append([$a, $b]), $class), 1) : d(append([$a, $b]),
            $class);
    }

    return $response;

}


function frm_fecha_busqueda($def_inicio = 0, $def_fin = 0)
{

    $inicio = ($def_inicio != 0) ? $def_inicio : date("Y-m-d");
    $fin = ($def_fin != 0) ? $def_fin : date("Y-m-d");

    $r[] = input_frm('col-lg-4 mt-5 p-0', "Fecha inicio",
        [
            "name" => 'fecha_inicio',
            "class" => "input_busqueda_inicio",
            "id" => 'datetimepicker4',
            "value" => $inicio,
            "type" => "date",
        ]
    );


    $r[] = input_frm('col-lg-4 mt-5 p-0', "Fecha término",
        [
            "name" => 'fecha_termino',
            "class" => "input_busqueda_termino",
            "id" => 'datetimepicker5',
            "value" => $fin,
            "type" => "date",
        ]

    );

    $r[] = d(btn(text_icon("fa fa-chevron-right", "Búsqueda")), 'col-lg-4 mt-5 p-0 p-0');

    return contaiter(append($r));


}


function input_hour_date()
{
    $r[] = input(
        [
            "class" => "form-control",
            "size" => "16",
            "type" => "text",
            "value" => "",
            "readonly" => true,
        ]
    );
    $r[] = span(span("", "fa fa-clock-o"), "input-group-addon");
    $r[] = hiddens([
        "id" => "dtp_input1",
        "name" => "hora_fecha",
        "class" => "hora_fecha",
    ]);

    return d(
        append($r),
        [
            "class" => "input-group date form_datetime ",
            "data-date-format" => "dd MM yyyy - HH:ii p",
            "data-link-field" => "dtp_input1",
        ]
    );

}

function get_format_izquierdo(
    $categorias_publicas_venta = [],
    $categorias_temas_de_ayuda = [],
    $agregar_categoria = 0
)
{
    $r[] = a_enid(
        img(
            [
                "src" => '../img_tema/enid_service_logo.jpg',
                'width' => '100%',
            ]
        ),
        [
            'href' => "../contact/#envio_msj",
        ]
    );


    if ($agregar_categoria > 0) {


        $r[] = d(h("CATEGORIAS DESTACADAS", 3));
        $r[] = d(a_enid(h("Agregar", 5, "underline top_20"),
            ["href" => path_enid("nfaq"), "class" => "black"]));

    }


    if (es_data($categorias_publicas_venta) || es_data($categorias_temas_de_ayuda)) {

        $r[] = get_format_listado_categorias($categorias_publicas_venta,
            $categorias_temas_de_ayuda);
    }


    $r[] = d(append([
        h("¿TIENES ALGUNA DUDA?", 3),
        a_enid("ENVIA TU MENSAJE",
            [
                "href" => "../contact/#envio_msj",
                'style' => 'color:black!important;text-decoration:underline;',
            ]),

    ]),
        [
            "style" => "background: #f2f2f2;padding: 10px;",
            "class" => "top_30",
        ]
    );

    return append($r);


}


function get_img_serv($img)
{

    return (es_data($img)) ? get_url_servicio($img[0]["nombre_imagen"], 1) : "";
}

function format_phone($number)
{
    $txt = preg_replace('/[\s\-|\.|\(|\)]/', '', $number);
    $format = '[$1?$1 :][$2?($2):x][$3: ]$4[$5: ]$6[$7? $7:]';
    if (preg_match('/^(.*)(\d{3})([^\d]*)(\d{3})([^\d]*)(\d{4})([^\d]{0,1}.*)$/', $txt,
        $matches)) {
        $result = $format;
        foreach ($matches AS $k => $v) {
            $str = preg_match('/\[\$' . $k . '\?(.*?)\:(.*?)\]|\[\$' . $k . '\:(.*?)\]|(\$' . $k . '){1}/',
                $format,
                $filterMatch);
            if ($filterMatch) {
                $result = str_replace($filterMatch[0],
                    (!isset($filterMatch[3]) ? (strlen($v) ? str_replace('$' . $k, $v,
                        $filterMatch[1]) : $filterMatch[2]) : (strlen($v) ? $v : (isset($filterMatch[4]) ? '' : (isset($filterMatch[3]) ? $filterMatch[3] : '')))),
                    $result);
            }
        }

        return $result;
    }

    return $number;
}


function path_enid($pos, $extra = 0, $link_directo = 0, $controlador = 0)
{

    $path = "";
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
        "lista_deseos_preferencias" => "lista_deseos/?q=preferencias",
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
        "valoracion_servicio" => "valoracion/?servicio=",
        "enid" => "https://enidservices.com",
        "enid_login" => "https://enidservices.com/inicio/login/",
        "logo_enid" => 'http://enidservices.com/inicio/img_tema/enid_service_logo.jpg',
        "logo_oxxo" => 'http://enidservices.com/inicio/img_tema/portafolio/oxxo-logo.png'
    ];


    if (array_key_exists($pos, $base_url)) {

        $path = ($link_directo > 0) ? (($extra !== 0) ? $base_url[$pos] . $extra : $base_url[$pos]) : (($extra !== 0) ? "../" . $base_url[$pos] . $extra : "../" . $base_url[$pos]);

        if ($controlador > 0) {

            $path = "../" . $path;
        }
    } else {

        echo "NO EXISTE ->  " . $pos;
    }

    return $path;

}

function text_icon($class_icono, $text, $att = [], $left = 1)
{

    return ($left > 0) ? (icon($class_icono,
            $att) . " " . $text) : ($text . " " . icon($class_icono, $att));

}

function _titulo($text, $tipo = 0, $extra = '')
{
    $tipo_titulo = ($tipo == 0) ? 'h3' : 'h4';
    return h($text, 1, $tipo_titulo . ' strong text-uppercase ' . $extra);

}


function horario_enid()
{

    return new DateTime('now', new DateTimeZone(config_item('time_reference')));

}

function add_text($a, $b, $f = 0)
{

    if (is_string($f)) {

        return $a . $b . $f;

    } else {

        return ($f < 1) ? $a . $b : $a . " " . $b;
    }


}

function social($proceso_compra, $desc_web, $black = 1)
{

    $url_share = current_url() . '?' . $_SERVER['QUERY_STRING'];
    $url_facebook = get_url_facebook($url_share);
    $url_twitter = get_url_twitter($url_share, $desc_web);


    $color = ($black > 0) ? "black" : "white";

    $r = [];
    if ($proceso_compra < 1) {


        $r[] = a_enid(
            img(
                [
                    "src" => "../img_tema/productos/messenger.png",
                    "class" => "w_15",
                ]
            ),
            [
                "href" => "https://www.m.me/enidservicemx",
                "target" => "_black",


            ]
        );

        $r[] = a_enid("",
            [
                "href" => $url_facebook,
                "target" => "_black",
                "class" => "fa fa-facebook " . $color,

            ]);

        $r[] = a_enid("",
            [
                "href" => "https://www.instagram.com/enid_service/",
                "class" => "fa fa-instagram " . $color,
                "title" => "Tumblr",
                "target" => "_black",
            ]);

        $r[] = a_enid("",
            [
                "target" => "_black",
                "class" => "fa fa-twitter " . $color,
                "title" => "Tweet",
                "data-size" => "large",
                "href" => $url_twitter,
            ]);
        $r[] = get_url_pinterest($url_share, 1);


    }

    return d(append($r), "d-flex align-items-center");

}

function es_data($e)
{

    return (is_array($e) && count($e) > 0) ? true : false;
}

function igual($a, $b, $str, $def = "")
{
    return ($a == $b) ? $str : $def;
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

    return (is_array($data) && array_key_exists($k,
            $data) && is_array($data[$k]) && array_key_exists($sk,
            $data[$k])) ? $data[$k][$sk] : $def;
}

function pr($data, $index, $def = false)
{

    return (is_array($data) && count($data) > 0 && array_key_exists($index,
            $data[0])) ? $data[0][$index] : $def;
}


function hrz($a, $b, $col = 0, $class = '')
{
    switch ($col) {

        case 1:

            $response = d(d($a, 1) . d($b, 11), $class);
            break;

        case 2:

            $response = d(d($a, 2) . d($b, 10), $class);

            break;
        case 3:

            $response = d(d($a, 3) . d($b, 9), $class);

            break;

        case 4:

            $response = d(d($a, 4) . d($b, 8), $class);

            break;

        case 5:

            $response = d(d($a, 5) . d($b, 7), $class);

            break;

        case 6:

            $response = d(d($a, 6) . d($b, 6), $class);

            break;

        case 7:

            $response = d(d($a, 7) . d($b, 5), $class);

            break;

        case 8:

            $response = d(d($a, 8) . d($b, 4), $class);

            break;

        case 9:

            $response = d(d($a, 9) . d($b, 3), $class);

            break;

        case 10:

            $response = d(d($a, 10) . d($b, 2), $class);

            break;


        default:

            $response = d(d($a) . d($b), $class);

    }

    return $response;

}

function dd($a, $b, $col = 0)
{
    switch ($col) {

        case 1:

            $response = d($a, 1) . d($b, 11);
            break;

        case 2:

            $response = d($a, 2) . d($b, 10);

            break;
        case 3:

            $response = d($a, 3) . d($b, 9);

            break;

        case 4:

            $response = d($a, 4) . d($b, 8);

            break;

        case 5:

            $response = d($a, 5) . d($b, 7);

            break;

        case 6:

            $response = d($a, 6) . d($b, 6);

            break;

        case 7:

            $response = d($a, 7) . d($b, 5);

            break;

        case 8:

            $response = d($a, 8) . d($b, 4);

            break;

        case 9:

            $response = d($a, 9) . d($b, 3);

            break;

        case 10:

            $response = d($a, 10) . d($b, 2);

            break;


        default:

            $response = d($a) . d($b);

    }

    return $response;

}

function dd_p($a, $b, $col = 0, $extra_left = '', $extra_right = '')
{
    switch ($col) {

        case 1:

            $response = d($a, "p-0 col-lg-1 " . $extra_left) . d($b,
                    "p-0 col-lg-11 " . $extra_right);
            break;

        case 2:

            $response = d($a, "p-0 col-lg-2 " . $extra_left) . d($b,
                    "p-0 col-lg-10 " . $extra_right);

            break;
        case 3:

            $response = d($a, "p-0 col-lg-3 " . $extra_left) . d($b,
                    "p-0 col-lg-9 " . $extra_right);

            break;

        case 4:

            $response = d($a, "p-0 col-lg-4 " . $extra_left) . d($b,
                    "p-0 col-lg-8 " . $extra_right);

            break;

        case 5:

            $response = d($a, "p-0 col-lg-5 " . $extra_left) . d($b,
                    "p-0 col-lg-7 " . $extra_right);

            break;

        case 6:

            $response = d($a, "p-0 col-lg-6 " . $extra_left) . d($b,
                    "p-0 col-lg-6 " . $extra_right);

            break;

        case 7:

            $response = d($a, "p-0 col-lg-7 " . $extra_left) . d($b,
                    "p-0 col-lg-5 " . $extra_right);

            break;

        case 8:

            $response = d($a, "p-0 col-lg-8 " . $extra_left) . d($b,
                    "p-0 col-lg-4 " . $extra_right);

            break;

        case 9:

            $response = d($a, "p-0 col-lg-9 " . $extra_left) . d($b,
                    "p-0 col-lg-3 " . $extra_right);

            break;

        case 10:

            $response = d($a, "p-0 col-lg-10 " . $extra_left) . d($b,
                    "p-0 col-lg-2 " . $extra_right);

            break;


        default:

            $response = d($a) . d($b);

    }

    return $response;

}


function ajustar($a, $b, $col = 0, $extra_class = '', $horizontal = 1, $sin_row = 1)
{

    $extra = (is_string($horizontal)) ? $horizontal : "";
    $srow = ($sin_row > 0) ? "" : " row ";

    $extra = ($horizontal == 1 && $col > 0) ? $extra . $srow : $extra;
    $extra = $extra . $extra_class;
    $class = ($horizontal > 0) ? "d-flex align-items-center justify-content-between " . $extra : "d-flex flex-column justify-content-between " . $extra;

    switch ($col) {

        case 0:

            $response = d(d($a) . d($b), $class);
            break;

        case 1:

            $response = d(d($a, 1) . d($b, 11), $class);
            break;

        case 2:

            $response = d(d($a, 2) . d($b, 10), $class);

            break;
        case 3:

            $response = d(d($a, 3) . d($b, 9), $class);

            break;

        case 4:

            $response = d(d($a, 4) . d($b, 8), $class);

            break;

        case 5:

            $response = d(d($a, 5) . d($b, 7), $class);

            break;

        case 6:

            $response = d(d($a, 6) . d($b, 6), $class);

            break;

        case 7:

            $response = d(d($a, 7) . d($b, 5), $class);

            break;

        case 8:

            $response = d(d($a, 8) . d($b, 4), $class);

            break;

        case 9:

            $response = d(d($a, 9) . d($b, 3), $class);

            break;

        case 10:

            $response = d(d($a, 10) . d($b, 2), $class);

            break;


        default:

            $response = d(d($a) . d($b), $class);

    }

    return $response;

}

function es_null($data, $index, $def = "")
{

    return (is_array($data) && array_key_exists($index,
            $data) && $data[$index] != null) ? $data[$index] : $def;
}

function create_contenido_menu($data)
{

    $navegacion = prm_def($data, "data_navegacion", []);
    $id_empresa = prm_def($data, "idempresa");
    $menu = [];

    foreach ($navegacion as $row) {

        $menu[] =
            a_enid(
                icon($row["iconorecurso"]) . $row["nombre"],
                [
                    "href" => ($row["idrecurso"] == 18) ? base_url($row["urlpaginaweb"]) . "/?q=" . $id_empresa : base_url($row["urlpaginaweb"]),
                    "class" => 'black text-capitalize',
                ]
            );


    }

    return append($menu);
}

function dispositivo()
{

    $tablet_browser = 0;
    $mobile_browser = 0;

    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i',
        strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $tablet_browser++;
    }

    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i',
        strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $mobile_browser++;
    }

    if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),
                'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
        $mobile_browser++;
    }

    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ',
        'acs-',
        'alav',
        'alca',
        'amoi',
        'audi',
        'avan',
        'benq',
        'bird',
        'blac',
        'blaz',
        'brew',
        'cell',
        'cldc',
        'cmd-',
        'dang',
        'doco',
        'eric',
        'hipt',
        'inno',
        'ipaq',
        'java',
        'jigs',
        'kddi',
        'keji',
        'leno',
        'lg-c',
        'lg-d',
        'lg-g',
        'lge-',
        'maui',
        'maxo',
        'midp',
        'mits',
        'mmef',
        'mobi',
        'mot-',
        'moto',
        'mwbp',
        'nec-',
        'newt',
        'noki',
        'palm',
        'pana',
        'pant',
        'phil',
        'play',
        'port',
        'prox',
        'qwap',
        'sage',
        'sams',
        'sany',
        'sch-',
        'sec-',
        'send',
        'seri',
        'sgh-',
        'shar',
        'sie-',
        'siem',
        'smal',
        'smar',
        'sony',
        'sph-',
        'symb',
        't-mo',
        'teli',
        'tim-',
        'tosh',
        'tsm-',
        'upg1',
        'upsi',
        'vk-v',
        'voda',
        'wap-',
        'wapa',
        'wapi',
        'wapp',
        'wapr',
        'webc',
        'winw',
        'winw',
        'xda ',
        'xda-',
    );

    if (in_array($mobile_ua, $mobile_agents)) {
        $mobile_browser++;
    }

    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera mini') > 0) {
        $mobile_browser++;
        //Check for tablets on opera mini alternative headers
        $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
            $tablet_browser++;
        }
    }

    if ($tablet_browser > 0) {
        // do something for tablet devices
        //print 'is tablet';
        return 0;
    } elseif ($mobile_browser > 0) {
        // do something for mobile devices
        return 1;
    } else {

        return 2;
    }
}

function gb_modal()
{


    $mod[] = d(
        p(
            span(
                "", "text-order-name-error"
            )
            , "font-weight-bold text-dark"
        ), "modal-body"
    );

    $mod[] = d(
        form_button(

            [
                "type" => "button",
                "class" => "btn btn-secondary",
                "data-dismiss" => "modal",
            ]
            ,
            "Cerrar"
        ), "modal-footer");


    $r[] = d(d(
        d(append($mod), "modal-content"),
        [
            "class" => "modal-dialog",
            "role" => "document",

        ]
    ), [

        "class" => "modal",
        "tabindex" => "-1",
        "role" => "dialog",
        "id" => "modal-error-message",

    ]);

    return append($r);

}

function menu_session_mobil($in_session)
{

    $b = a_enid("×",
        [
            "href" => "javascript:void(0)",
            "class" => "closebtn closebtn_lateral f15  white p-3 border",
            "onclick" => "closeNav()",
        ]);

    $r[] = d($b, "ml-auto");

    $form[] = '<form  action="../search">';
    $form[] = flex(

        input([
            "name" => "q",
            "placeholder" => "artículo",
            "class" => "input_search ",
            'style' => 'height: 41px!important;',
        ]),
        btn("BUSCAR", ['class' => 'boton-busqueda']),
        "justify-content-between ",
        "align-self-end"
    );
    $form[] = form_close();
    $r[] = d(append($form), "my-auto");


    if ($in_session < 1) {

        $r[] = d(
            a_enid("INICIAR SESSION",
                [
                    "class" => " white top_10 strong fp9",
                    "href" => "../login",
                ]
            ),


            "contenedor-lateral-menu "

        );
    }

    return d(d(append($r), "row col-lg-12 h-100"),
        ["id" => "mySidenav", "class" => "sidenav"]);

}

function tmp_menu($is_mobile, $id_usuario, $menu)
{


    $notificaciones = btw(


        a_enid(
            flex(
                icon("fa fa-bell white"),
                d("", "num_tareas_dia_pendientes_usr"),
                "",
                "align-self-center"
            )
            ,
            [
                "class" => "dropdown-toggle",
                "data-toggle" => "dropdown",
            ]
        )

        ,

        d(

            place("place_notificaciones_usuario m-3")
            ,
            "dropdown-menu menu_dropdown_enid"

        )
        ,
        "dropdown dropleft menu_notificaciones_progreso_dia mr-2 "
    );


    $imagen_usuario = a_enid(
        get_img_usuario($id_usuario),
        [
            "class" => "dropdown-toggle",
            "data-toggle" => "dropdown",
        ]
    );


    $menu_usuario = [
        $menu,
        a_enid("Mis reseñas y valoraciones", [

            "href" => path_enid("recomendacion", $id_usuario),
            "class" => "black",
        ]),
        a_enid("Configuración y privacidad", [
            "href" => path_enid("administracion_cuenta"),
            "class" => 'black',
        ]),
        a_enid("Cerrar sessión",
            [

                "href" => path_enid("logout"),
                "class" => 'black',
            ]
        ),
    ];
    $opciones_menu = d(append($menu_usuario), 'dropdown-menu mw_250 p-3');
    $extra_menu = [
        $imagen_usuario,

        $opciones_menu,
    ];
    $menu = d(append($extra_menu), 'dropdown dropleft');

    return flex($notificaciones, $menu, "mr-5");

}

function frm_search(
    $clasificaciones_departamentos,
    $in_session = 0,
    $is_mobile = 0,
    $id_usuario = 0,
    $menu = 0
)
{

    $r[] = '<form action="../search" class="search_principal_form d-flex">';
    $r[] = d($clasificaciones_departamentos, "d-none");
    $r[] = input(
        [
            "class" => "input_busqueda_producto",
            "type" => "text",
            "placeholder" => "Búsqueda",
            "name" => "q",
            "onpaste" => "paste_search();",

        ]

    );
    $r[] = btn(icon("fa fa-search "),
        [
            "class" => " button_busqueda_producto  flipkart-navbar-button",
        ]
    );
    $r[] = form_close();


    $carrito = btw(
        d(
            icon("fa fa-shopping-bag  white")
            ,
            [
                "class" => "dropdown-toggle",
                "data-toggle" => "dropdown",
            ]

        ),
        d(
            h("TU CARRITO", 4, "strong "),
            [

                "class" => "dropdown-menu mt-5 border-0  bg-white p-2 ",
            ]
        )

    );


    if ($in_session < 1) {


        return flex(append($r), $carrito, "d-flex justify-content-end mr-3", "", "ml-4 ");


    } else {

        return add_text(d(append($r)), d(tmp_menu($is_mobile, $id_usuario, $menu)));

    }


}

function flex($d, $d1 = '', $ext = '', $ext_left = '', $ext_right = '')
{
    $response = "";
    if (is_array($d)) {

        $clase_extra = 'd-flex ';
        $clase_extra .= (strlen($d1) > 0) ? $d1 : '';
        $response = d(append($d), $clase_extra);

    } else {

        $att = "d-flex ";
        if (is_array($ext)) {
            $att = $ext[0];
        } else {
            $att .= $ext;
        }

        $response = d(add_text(d($d, $ext_left), d($d1, $ext_right)), $att);
    }

    return $response;

}

function is_mobile()
{

    return (dispositivo() === 1) ? 1 : 0;
}

function crea_estrellas($calificacion, $sm = 0)
{
    $valoraciones = "";
    $restantes = "";
    $a = 1;
    if ($calificacion > 0) {

        for ($a; $a <= $calificacion; $a++) {
            $ext = ($sm > 0) ? "" : "";
            $valoraciones .= label("★", ["class" => 'estrella black ' . $ext, "id" => $a]);
        }
    }

    for ($a; $a <= 5; $a++) {
        $ext = ($sm > 0) ? "" : "";

        $restantes .=
            label("★",
                [
                    "class" => 'estrella azul_estrella_simple  cursor_pointer ' . $ext,
                    "id" => $a,
                ]
            );
    }

    return add_text($valoraciones, $restantes);
}

function input_frm($col, $text_label, $config_input = [], $text_place = "")
{

    $config_label = [];
    if (es_data($config_input)) {

        $config_label["for"] = $config_input["id"];
        $config_label["id"] = "label_" . $config_input["id"];
        $config_label["class"] = "cursor_pointer label_" . $config_input["id"];
    }


    $str = strlen($text_place) > 0 ? $text_place : "";
    $text = add_text(
        input($config_input, 0, 0),
        label(
            $text_label
            ,
            $config_label
        )
        ,
        d(
            $str,
            add_text("mt-3 color_red  d-none place_input_form_",
                $config_input["id"])
        )
    );
    $r[] = d($text, "input_enid_format w-100");
    if (is_numeric($col)) {

        return ($col > 0) ? d(append($r), $col) : append($r);

    } else {

        return d(append($r), $col);
    }


}

function contaiter($str, $attributes = [], $fluid = 1)
{

    $f = ($fluid > 0) ? "container-fluid" : 'container';
    $att = [];

    if (intval($attributes) && $attributes > 0) {

        $response = d(d(d($str, 12), 13), "container-fluid");

    } else {


        if (is_string($attributes)) {

            $att["class"] = add_text($attributes, $f, 1);

        } else {

            $att["class"] = (array_key_exists("class",
                $attributes)) ? add_text($attributes["class"], $f, 1) : $f;
        }

        $response = d(d($str, 13), $att);
    }


    return $response;
}

function format_fecha($date, $horas = 0)
{

    $ext = ($horas > 0) ? 'H:i' : '';

    return format_time(date_format(date_create($date), 'd M Y ' . $ext));

}

function format_link($str, $attributes, $primario = 1 , $texto_strong = 1 )
{


    $clase = ($primario > 0) ?
        "text-center borde_accion p-2 bg_black white  text-uppercase col " :
        "text-center borde_accion p-2 border_enid col black text-uppercase ";

    $clase .= ($texto_strong) ?  ' font-weight-bold ': '';

    $att = $attributes;


    $att["class"] = (array_key_exists("class",
        $attributes)) ? add_text( $clase , $attributes["class"]) : $clase;

    return a_enid($str, $att);
}

function format_link_primario($str, $attributes, $primario = 0)
{

    $f = ($primario > 0) ? " black " : " agregar_direccion_pedido border-0 bg_black white";
    $att = $attributes;
    $att["class"] = (array_key_exists("class",
        $attributes)) ? add_text($attributes["class"], $f) : $f;

    return a_enid($str, $att);
}


function formated_link($str, $primario = 1)
{

    $f = ($primario > 0) ? " p-3 bg_black white strong col" : " p-3 strong  border_enid col black";
    $att["class"] = $f;

    return d($str, $att);
}

function money($num)
{
    return add_text(money_format('%i', $num), " MXN");
}

function format_load($extra = '')
{

    if (is_numeric($extra)) {
        switch ($extra) {
            case 12:

                $extra = 'col-lg-12 p-0';

                break;
            case 13:

                $extra = 'row ';

                break;
            default:
        }
    }

    return d(
        d('', 'progress-bar mh_15 w-100'),
        "cargando_form progress progress-striped active 
            page-progress-bar mt-5 d-none " . $extra
    );
}

function _text()
{

    $lista_argumentos = func_get_args();
    $response = '';
    for ($i = 0; $i < func_num_args(); $i++) {
        $response .= $lista_argumentos[$i];
    }

    return $response;

}

function _d()
{

    $lista_argumentos = func_get_args();
    $response = '';
    for ($i = 0; $i < func_num_args(); $i++) {
        $response .= d($lista_argumentos[$i]);
    }

    return $response;

}

function ticket_pago($recibo, $tipos_entrega, $format = 1)
{

    $response = [];
    if (es_data($recibo)) {

        $r = $recibo[0];

        $monto = $r['monto_a_pagar'];
        $ciclos = $r['num_ciclos_contratados'];
        $abono = $r['saldo_cubierto'];
        $costo_envio_cliente = $r['costo_envio_cliente'];
        $entrega_tipo = $r['tipo_entrega'];
        $tipo_entrega = ($entrega_tipo - 1);
        $subtotal = ($monto * $ciclos);
        $format_envio = ($costo_envio_cliente > 0) ? money($costo_envio_cliente) : 'gratis!';
        $abono_format = ($abono > 0) ? _text('- ', money($abono)) : '';
        $abono_format_text = ($abono > 0) ? 'Abono' : '';
        $es_abono = ($abono > 0);
        $saldo_pendiente = ($subtotal - $abono) + $costo_envio_cliente;
        $saldo_pendiente_pago_contra_entrega = ($subtotal - $abono);


        switch ($format) {

            case 1:

                $espacio = 'justify-content-between mt-3 ';
                $response[] = hr('mb-4');
                $response[] = flex('Subtotal', money($subtotal), $espacio, 'subtotal_text', 'subtotal_money');
                $response[] = flex($tipos_entrega[$tipo_entrega]['texto_envio'], $format_envio, $espacio, 'envio_text', 'envio_money text-uppercase');
                if ($es_abono) {
                    $response[] = flex($abono_format_text, $abono_format, $espacio, 'abono_text', 'abono_money');
                }
                $response[] = hr('mt-4');
                $response[] = flex('Total', money($saldo_pendiente), 'justify-content-between', 'saldo_pendiente_text h3', 'h3 saldo_pendiente_money');
                $response[] = d_p($tipos_entrega[$tipo_entrega]['nombre_publico'], 'text-right h4 strong ');

                break;
            default:

                break;

        }


        $checkout = [
            'checkout' => d($response, 'checkout_resumen'),
            'saldo_pendiente' => $saldo_pendiente,
            'saldo_pendiente_pago_contra_entrega' => $saldo_pendiente_pago_contra_entrega,
            'tipo_entrega' => $entrega_tipo,
            'descuento_entrega' => $costo_envio_cliente

        ];

    }
    return $checkout;


}


//function exists_array_def($data, $key, $exists = 1, $fail = 0)
//{
//    return (is_array($data) && array_key_exists($key, $data)) ? $exists : $fail;
//
//}



