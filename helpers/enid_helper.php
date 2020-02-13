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

function span($str, $attributes = [], $row = 0)
{

    return get_base_html("span", $str, $attributes, $row);
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

        $attributes["class"] = array_key_exists("class", $attributes) ?
            _text_($attributes["class"], _registro)
            : _registro;
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
                $response = ($row > 0) ? "<{$tipo} class=' col-sm-2 col-sm-offset-5'>" . $info . "</{$tipo}>" : "<{$tipo} class=' col-sm-2'>" . $info . "</{$tipo}>";
                break;
            case 3:
                $response = "<{$tipo} class=' col-sm-3'>" . $info . "</{$tipo}>";
                break;
            case 4:
                $response = ($row > 0) ? "<{$tipo} class=' col-sm-4 col-sm-offset-4'>" . $info . "</{$tipo}>" : "<{$tipo} class=' col-sm-4'>" . $info . "</{$tipo}>";
                break;
            case 5:
                $response = "<{$tipo} class='col-sm-5'>" . $info . "</{$tipo}>";
                break;
            case 6:
                $response = ($row > 0) ? "<{$tipo} class=' col-sm-6 col-sm-offset-3'>" . $info . "</{$tipo}>" : "<{$tipo} class=' col-sm-6'>" . $info . "</{$tipo}>";
                break;
            case 7:
                $response = "<{$tipo} class=' col-sm-7'>" . $info . "</{$tipo}>";
                break;
            case 8:
                $response = ($row > 0) ? "<{$tipo} class=' col-sm-8 col-sm-offset-2'>" . $info . "</{$tipo}>" : "<{$tipo} class=' col-sm-8'>" . $info . "</{$tipo}>";
                break;
            case 9:
                $response = "<{$tipo} class=' col-sm-9'>" . $info . "</{$tipo}>";
                break;
            case 10:
                $response = ($row > 0) ? "<{$tipo} class=' col-sm-10 col-sm-offset-1'>" . $info . "</{$tipo}>" : "<{$tipo} class=' col-sm-10'>" . $info . "</{$tipo}>";
                break;
            case 11:
                $response = "<{$tipo} class=' col-sm-11'>" . $info . "</{$tipo}>";
                break;
            case 12:
                $response = "<{$tipo} class=' col-sm-12'>" . $info . "</{$tipo}>";
                break;
            case 13:
                $response = "<{$tipo} class='row'>" . $info . "</{$tipo}>";
                break;
        }

        if ($frow > 0) {
            $response = d($response, 13);
        }

        return $response;

    } else {

        if (is_array($attributes)) {

            $base = "<{$tipo}" . add_attributes($attributes) . ">" . $info . "</{$tipo}>";
            return ($row > 0) ? addNRow($base) : $base;

        } else {

            $base = "<{$tipo} class='{$attributes}'>" . $info . "</{$tipo}>";
            return ($row > 0) ? addNRow($base) : $base;
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

function xmp($text)
{

    echo "<xmp>";
    echo print_r($text);
    echo "</xmp>";
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
        $attributes)) ? (_text_($attributes["class"], " ")) : "  ";

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
                $attributes["step"] = 'any';

                break;
            case "float":

                $attributes['onkeypress'] = "return (event.charCode >= 48 && event.charCode <= 57) ||  event.charCode == 46 || event.charCode == 0 ";
                $attributes['type'] = 'text';
                break;

            case "email":

                $attributes["required"] = "true";
                $attributes["pattern"] =
                    '[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)';
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
                    if (prm_def($attributes, 'no_validar') < 1) {
                        $attributes["class"] = (array_key_exists("class", $attributes)) ?
                            (_text_($attributes["class"], "validar_nombre ")) : " validar_nombre ";
                    }
                    $attributes["minlength"] = 3;
                }
                if (prm_def($attributes, 'uppercase', false)) {
                    $attributes['onkeyup'] = "this.value = this.value.toUpperCase();";
                }

                break;

            case "checkbox":

                $attributes["class"] = (array_key_exists("class",
                    $attributes)) ?
                    (
                    _text_($attributes["class"], "checkbox_enid border cursor_pointer rounded")
                    ) : " checkbox_enid border cursor_pointer rounded";
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

    return "<input type='hidden'  " . add_attributes($attributes) . " >";

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

        $class = (es_data($att) &&
            array_key_exists("class", $att)) ?
            _text_($att["class"], " d-block") : " d-block";

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

        $attributes["class"] = _text_($attributes["class"], "text-uppercase black ");

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

        $attributes["class"] = _text_($attributes["class"], "tab-pane");

    } else {

        $attributes["class"] = " tab-pane ";
    }
    if ($activo > 0) {

        $attributes["class"] =
            _text_($attributes["class"], "tab-pane active");
    }

    $attributes['role'] = "tabpanel";
    $attributes['id'] = $id_selector;
    return d($contenido, $attributes);

}

function tab_activa($seccion, $activa, $considera_segundo = 0)
{

    return ($considera_segundo == 0) ? (($seccion == $activa) ? 1 : 0) : 1;
}


function tab_content($array = [], $col = 0)
{

    $response = d($array, 'tab-content mt-sm-5');
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

function tr($val = '', $attributes = [])
{

    $str = is_array($val) ? append($val) : $val;
    return "<tr " . add_attributes($attributes) . " >" . $str . "</tr>";

}

function tb($val = '', $attributes = '')
{

    $str = is_array($val) ? append($val) : $val;
    return "<table " . add_attributes($attributes) . " >" . $str . "</table>";

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

    return _text("http://", $_SERVER['HTTP_HOST'], "/inicio/", $extra);

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
    return [
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
    ];

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

    return add_element($tags, "d", ['class' => 'tags']);

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

    $response = [];
    $b = 0;
    for ($a = 0; $a < count($array); $a++) {
        if ($array[$a] != $element) {
            $response[$b] = $array[$a];
            $b++;
        }
    }

    return $response;

}

function create_button_easy_select($arr, $attributes, $comparador = 1)
{
    sort($arr);
    $easy_select = "";
    if ($comparador == 1) {

        foreach ($arr as $row) {

            $text = $row[$attributes["text_button"]];
            $class =
                ($row[$attributes["campo_comparacion"]] == $attributes["valor_esperado"]) ?
                    $attributes["class_selected"] : $attributes["class_disponible"];


            $extra = ($row[$attributes["campo_comparacion"]] ==
                $attributes["valor_esperado"]) ? 1 : 0;

            $easy_select .= add_element($text, "a",
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
            $easy_select .=
                _text("<a ", $attr, " id=", $id, "  >", $row["talla"], "</a>");
        }

    }

    return $easy_select;

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
    $text_def = "",
    $menos = []
)
{

    $select[] = "<select name='" . $name . "'  class='" . $class . "'  id='" . $id . "'> ";

    if ($def == 1) {

        $select[] = "<option value='" . $valor . "'>" . strtoupper($text_def) . " </option>";
    }
    foreach ($data as $item) {

        if (!in_array($item[$val], $menos)) {

            $select[] = "<option value='" . $item[$val] . "'>" . strtoupper($item[$text_option]) . " </option>";
        }
    }

    $select[] = "</select>";

    return ($row < 1) ? append($select) : addNRow(append($select));

}

function prm_def($data, $key, $val_def = 0, $valida_basura = 0)
{

    $val = (is_array($data) &&
        array_key_exists($key, $data) && $data[$key] !== null) ? $data[$key] : $val_def;

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
        n_row_12(["class" => $attributes]) . $e . end_row()
        :
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
        "../img_tema/enid_service_logo.jpg" :
        "https://enidservices.com/inicio/img_tema/enid_service_logo.jpg";

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

function get_campo($param, $key, $label = "", $add_label = 0)
{

    return ($add_label > 0) ? ($label . "  " . $param[0][$key]) : ((count($param) > 0) ? $param[0][$key] : "");

}

function usuario($q2)
{
    $id = 0;
    if (isset($q2) && $q2 != null) {
        $id = $q2;
    }

    return $id;
}

function now_enid()
{

    return date('Y-m-d');

}

function porcentaje($cantidad, $porciento, $decimales = 2, $numeric_format = 0)
{
    $response = 0;
    if (is_numeric($cantidad) == is_numeric($porciento)) {

        $response = ($numeric_format == 1) ?
            (number_format($cantidad * $porciento / 100, $decimales)) :
            ($cantidad * $porciento / 100);

    }

    return $response;
}


function porcentaje_total($cantidad, $total)
{
    $response = 0;
    if ($total > 0) {

        $response = ($cantidad * 100 / $total);
    }

    return $response;

}


function get_url_pinterest($url, $icon = 0)
{

    $path = _text("https://www.pinterest.com/pin/create/button/?url=", $url);
    if ($icon > 0) {
        return a_enid(icon('fa fa-pinterest-p'),
            [
                'target' => "_black",
                'href' => $path,
                'class' => 'black',
            ]);
    }

    return $path;

}

function get_url_twitter($url, $mensaje, $icon = 0)
{

    $path = _text(
        "https://twitter.com/intent/tweet?text=", $mensaje, $url);
    if ($icon > 0) {
        return a_enid(
            icon('fa fa-twitter'),
            [
                'target' => "_black",
                'href' => $path,
            ]
        );
    }

    return $path;
}


function get_url_facebook($url, $icon = 0)
{

    $url_facebook = _text(
        "https://www.facebook.com/sharer/sharer.php?u=", $url, ";src=sdkpreparse");
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

    return _text(
        "http://", $_SERVER['HTTP_HOST'], "/inicio/search/?q3=", $id_usuario, '&tienda=1');

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

function pago_oxxo($url_request, $saldo, $id_recibo, $id_usuario)
{


    $url_request = (strlen($url_request) < 1) ? '../' : $url_request;
    return ($saldo > 0 && $id_recibo > 0 && $id_usuario > 0) ?
        (
        _text($url_request, "orden_pago_oxxo/?q=", $saldo, "&q2=", $id_recibo, "&q3=", $id_usuario)
        ) : "";

}

function create_select_selected($data, $campo_val, $campo_text, $selected, $name, $class, $valor = 0, $menos = [])
{

    $select = "<select class='" . $class . "' name='" . $name . "'>";
    $str = '';
    foreach ($data as $row) {

        $extra = ($row[$campo_val] == $selected) ? "selected" : "";
        if ($row[$campo_val] == $selected) {
            $str = $row[$campo_text];
        }
        if (!in_array($row[$campo_val], $menos)) {
            $select .= "<option value='" . $row[$campo_val] . "' " . $extra . " > " . $row[$campo_text] . "</option>";
        }
    }
    $select .= "</select>";
    return ($valor < 1) ? $select : $str;
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
    return _text_("DROP TABLE IF EXISTS ", $tmp_table);
}

function valida_extension($string, $num_ext, $str)
{

    return (strlen($string) > $num_ext) ? $string : $str;

}

function link_imagen_servicio($id)
{

    return ($id > 0) ? _text("../imgs/index.php/enid/imagen_servicio/", $id) : "";

}

function select_vertical($data, $val, $text_option, $attributes = '')
{

    $extra = add_attributes($attributes);
    $select = _text_("<select ", $extra, " > ");
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

        $att["class"] = _text_($attributes, _strong);
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

    return d("", _text_("border ", $extra));
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
    $flag_envio_gratis, $costo_envio_cliente,
    $costo_envio_vendedor, $tipo_entrega)
{

    $text_envio = [
        '',
        ' MXN DE TU ENTREGA',
        ' MXN DE ENVÍO',
        ''
    ];

    return ($flag_envio_gratis > 0) ?
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


    $attributes["rows"] = prm_def($attributes, 'rows', 2);

    if (array_key_exists("class", $attributes)) {
        $attributes["class"] = _text_(
            $attributes["class"], " form-control rounded-0");
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

function get_logo($is_mobile, $tipo = 0)
{

    if ($is_mobile == 1) {

        $en_mobile = d("☰ ENID SERVICE",
            [
                "class" => "smallnav menu white f12 mt-4 ",
                "onclick" => "openNav()"
            ]
        );
        $class = "col-lg-12";
        switch ($tipo) {

            case 1:
                $class = "col-lg-3";
                break;
            case 2:
                $class = "col-lg-1";
                break;
        }

        return d($en_mobile, $class);

    } else {

        $img_enid = img_enid(["style" => "width: 50px!important;"]);
        return a_enid($img_enid, ["href" => path_enid('home')]);

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
    return
        [
            "select" => $select,
            "nuevo_dia" => $nuevo_dia,
        ];


}


function get_url_servicio($id_servicio, $n = 0)
{

    return ($n > 0) ? "../img_tema/productos/" . $id_servicio : "../producto/?producto=" . $id_servicio;

}


function img_servicio($id, $external = 0)
{
    $url = ($external > 0) ?
        _text(
            "http://enidservices.com/inicio/imgs/index.php/enid/imagen_servicio/", $id
        ) :
        get_url_request(_text("imgs/index.php/enid/imagen_servicio/", $id));

    return [
        'src' => $url,
        'id' => "imagen_" . $id,
        'class' => 'imagen-producto',
    ];


}


function append($array, $col = 0, $num_col = 0)
{
    $response = "";
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

    return
        [
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

    return ($b < 6 && $f > 0) ? 1 : 0;

}

function get_menu_session($in_session, $proceso_compra = 1)
{

    $response = "";
    if ($in_session < 1) {

        $vender = a_enid(
            "vender",
            [
                "href" => "../login/?action=nuevo",
                "class" => ' white text-uppercase strong text_agilizar ',
            ], 0
        );
        $session = a_enid(
            text_icon("fa fa-user", " iniciar sesión",
                [],
                0
            )
            ,
            [
                "href" => path_enid('login'),
                "class" => "text-uppercase text_iniciar_session text-decoration-none mr-4 white",
            ]
        );


        if ($proceso_compra < 1) {

            $response = flex(
                $vender,
                $session,
                "d-none d-md-block d-md-flex justify-content-end mt-md-3 mb-md-3",
                "mr-3 ", '', ''
            );
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

function frm_fecha_busqueda($def_inicio = 0, $def_fin = 0, $base_inicio = 'col-sm-4 mt-5 p-0 p-md-1 ', $base_termino = 'col-sm-4 mt-5 p-0 p-md-1', $base_boton = 'col-lg-4 mt-5 p-0 p-0 align-self-end')
{

    $inicio = ($def_inicio != 0) ? $def_inicio : add_date(date("Y-m-d"),-9);
    $fin = ($def_fin != 0) ? $def_fin : date("Y-m-d");

    $r[] = input_frm($base_inicio, "Fecha inicio",
        [
            "name" => 'fecha_inicio',
            "class" => "input_busqueda_inicio",
            "id" => 'datetimepicker4',
            "value" => $inicio,
            "type" => "date",
        ]
    );

    $r[] = input_frm($base_termino, "Fecha término",
        [
            "name" => 'fecha_termino',
            "class" => "input_busqueda_termino",
            "id" => 'datetimepicker5',
            "value" => $fin,
            "type" => "date",
        ]

    );

    $r[] = d(btn(text_icon("fa fa-chevron-right", "Búsqueda")), $base_boton);

    return append($r);


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
    $r[] = hiddens(
        [
            "id" => "dtp_input1",
            "name" => "hora_fecha",
            "class" => "hora_fecha",
        ]
    );

    return d(
        $r,
        [
            "class" => "input-group date form_datetime ",
            "data-date-format" => "dd MM yyyy - HH:ii p",
            "data-link-field" => "dtp_input1",
        ]
    );

}

function faqs(
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
        path_enid('contact')
    );


    if (es_data($categorias_publicas_venta) ||
        es_data($categorias_temas_de_ayuda)) {

        $r[] = get_format_listado_categorias(
            $categorias_publicas_venta, $categorias_temas_de_ayuda);
    }

    if ($agregar_categoria > 0) {
        $r[] = format_link("Agregar",
            [
                "href" => path_enid("nfaq"),
                'class' => 'mt-5 w-50'
            ]
        );
    }

    $ayuda[] = _titulo("¿TIENES ALGUNA DUDA?");
    $ayuda[] = a_enid("ENVIA TU MENSAJE",
        [
            "href" => "../contact/#envio_msj",
            'class' => 'black underline mt-3',
        ]
    );

    $r[] = d($ayuda, 'mt-5');


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
        "_area_cliente" => "../area_cliente",
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

        $path = ($link_directo > 0) ?
            (($extra !== 0) ? $base_url[$pos] . $extra : $base_url[$pos]) : (($extra !== 0) ? "../" . $base_url[$pos] . $extra : "../" . $base_url[$pos]);

        if ($controlador > 0) {

            $path = _text("../", $path);
        }
    } else {

        echo "NO EXISTE ->  " . $pos;
    }

    return $path;

}

function text_icon($class_icono, $text, $att = [], $left = 1)
{

    return ($left > 0) ? (flex(icon($class_icono, $att), $text, _between)) : (flex($text, icon($class_icono, $att), _between));

}

function _titulo($text, $tipo = 0, $extra = '')
{

    $response = [];
    switch ($tipo) {

        case 0:
            $response[] = h($text, 1, _text_(_t1, $extra));

            break;

        case 2:
            $response[] = h($text, 2, _text_(_t2, $extra));

            break;

        case 3:
            $response[] = h($text, 3, _text_(_t3, $extra));

            break;

        case 4:
            $response[] = h($text, 4, _text_(_t4, $extra));

            break;
        case 5:
            $response[] = h($text, 5, _text_(_t5, $extra));

            break;

    }
    return append($response);

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
                    "class" => "w_15 border-0",
                    'style' => 'filter: hue-rotate(8deg) brightness(70%);'

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

            ]
        );

        $r[] = a_enid("",
            [
                "href" => "https://www.instagram.com/enid_service/",
                "class" => _text_("fa fa-instagram ", $color),
                "title" => "Tumblr",
                "target" => "_black",
            ]
        );

        $r[] = a_enid("",
            [
                "target" => "_black",
                "class" => _text_("fa fa-twitter ", $color),
                "title" => "Tweet",
                "data-size" => "large",
                "href" => $url_twitter,
            ]
        );

        $r[] = get_url_pinterest($url_share, 1);

    }

    return d($r, "d-flex align-items-center");

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

function search_bi_array($array, $columna, $busqueda, $get = FALSE, $si_false = "")
{

    $arr_col = array_column($array, $columna);
    $index = array_search($busqueda, $arr_col);
    $response = $index;

    if ($get !== FALSE) {

        $response = ($index !== FALSE) ? $array[$index][$get] : $si_false;
    }

    return $response;
}

function key_exists_bi($data, $k, $sk, $def = "")
{

    return (is_array($data) &&
        array_key_exists($k, $data) && is_array($data[$k]) && array_key_exists($sk,
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
            break;

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
            break;
    }

    return $response;

}

function dd_p($a, $b, $col = 0, $extra_left = '', $extra_right = '')
{
    switch ($col) {

        case 1:

            $response = d($a, " col-lg-1 " . $extra_left) . d($b,
                    " col-lg-11 " . $extra_right);
            break;

        case 2:

            $response = d($a, " col-lg-2 " . $extra_left) . d($b,
                    " col-lg-10 " . $extra_right);
            break;
        case 3:

            $response = d($a, " col-lg-3 " . $extra_left) . d($b,
                    " col-lg-9 " . $extra_right);
            break;

        case 4:

            $response = d($a, " col-lg-4 " . $extra_left) . d($b,
                    " col-lg-8 " . $extra_right);
            break;

        case 5:

            $response = d($a, " col-lg-5 " . $extra_left) . d($b,
                    " col-lg-7 " . $extra_right);
            break;

        case 6:

            $response = d($a, " col-lg-6 " . $extra_left) . d($b,
                    " col-lg-6 " . $extra_right);
            break;

        case 7:

            $response = d($a, " col-lg-7 " . $extra_left) . d($b,
                    " col-lg-5 " . $extra_right);
            break;

        case 8:

            $response = d($a, " col-lg-8 " . $extra_left) . d($b,
                    " col-lg-4 " . $extra_right);
            break;

        case 9:

            $response = d($a, " col-lg-9 " . $extra_left) . d($b,
                    " col-lg-3 " . $extra_right);

            break;

        case 10:

            $response = d($a, " col-lg-10 " . $extra_left) . d($b,
                    " col-lg-2 " . $extra_right);

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
    $class = ($horizontal > 0) ? "d-flex align-items-center justify-content-between mt-1 " . $extra : "d-flex flex-column justify-content-between " . $extra;

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

        $path = base_url($row["urlpaginaweb"]) . "/?q=" . $id_empresa;
        $path_web = base_url($row["urlpaginaweb"]);
        $menu[] =
            a_enid(
                icon($row["iconorecurso"]) . $row["nombre"],
                [
                    "href" => ($row["idrecurso"] == 18) ? $path : $path_web,
                    "class" => 'black text-uppercase mt-2 ',
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
        'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
        'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt',
        'inno', 'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g',
        'lge-', 'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp',
        'nec-', 'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
        'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
        'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
        'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
        'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-',
    );

    if (in_array($mobile_ua, $mobile_agents)) {
        $mobile_browser++;
    }
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera mini') > 0) {
        $mobile_browser++;
        $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
            $tablet_browser++;
        }
    }

    if ($tablet_browser > 0) {
        return 0;
    } elseif ($mobile_browser > 0) {
        return 1;
    } else {
        return 2;
    }
}

function gb_modal($modal_inicial = 1, $id_modal = "modal-error-message", $icono_carga = 1)
{
    $span = span('Loading', 'sr-only');
    $load = str_repeat(d($span,
        [
            'class' => "spinner-grow",
            'role' => "status"
        ]
    ), 5);
    $cargando = d($load, 'text-center cargando_modal d-none');
    $cargando = ($icono_carga > 0) ? $cargando : '';
    $text = span("", "text-order-name-error black");
    $mensaje_cotenidio = _text_(p($text, "font-weight-bold text-dark text-center"), $cargando);
    $mensaje_cotenidio = ($modal_inicial !== 1) ? $modal_inicial : $mensaje_cotenidio;
    $seccion = d($mensaje_cotenidio, "modal-body mt-5 mb-5");
    $cerrar = d(
        icon(_text_(_eliminar_icon, 'fa-2x'),
            [
                "data-dismiss" => "modal",
            ]
        ), 'ml-auto'
    );

    $cerrar = d($cerrar, "modal-header border-0");
    $seccion_contenido = d(_text_($cerrar, $seccion), "modal-content rounded-0");
    $contenido = d(
        $seccion_contenido
        ,
        [
            "class" => "modal-dialog",
            "role" => "document",
        ]
    );
    $modal = d(
        $contenido,
        [

            "class" => "modal",
            "tabindex" => "-1",
            "role" => "dialog",
            "id" => $id_modal,

        ]
    );

    return d($modal, 13);

}

function menu_session_mobil($in_session)
{

    $r[] = d(
        a_enid("×",
            [
                "href" => "javascript:void(0)",
                "class" => "closebtn closebtn_lateral p-3 font-weight-bold h1 black",
                "onclick" => "closeNav()",
            ]
        ), 'ml-auto mr-5 mt-5 '
    );

    $form[] = open_form(['action' => "../search"]);
    $form[] = flex(
        input(
            [
                "name" => "q",
                "placeholder" => "artículo",
                "class" => "input_search w-100",
                'style' => 'height: 41px!important;',
            ]
        ),
        btn("buscar",
            [
                'class' => 'boton-busqueda'
            ]
        ),
        "justify-content-between "
    );
    $form[] = form_close();


    $r[] = d($form);


    if ($in_session < 1) {


        $r[] = d(
            a_enid("accede a tu cuenta",
                [
                    "class" => "white font-weight-bold contenedor-lateral-menu w-100 text-uppercase text-right",
                    "href" => "../login",
                ]
            ), 'row w-100'
        );
    }


    $menu_lateral = d(
        flex($r, 'd-flex flex-column  align-items-center justify-content-between h-100'),
        [
            "id" => "mySidenav",
            "class" => "sidenav"
        ]
    );

    return addNRow($menu_lateral);

}

function tmp_menu($id_usuario, $menu)
{

    $contenido[] = d_row(d(place("place_notificaciones_usuario m-3"), 12));

    $seccion = append($contenido);
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
            $seccion
            ,
            "row dropdown-menu menu_dropdown_enid"
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

    $cerrar_menu = addNRow(terminar_dropdown('', 'p-0'));

    $link_tienda = a_enid(btn('Productos en venta'), get_url_tienda($id_usuario));


    $menu_usuario = [

        $menu,
        a_enid("Configuración",
            [
                "href" => path_enid("administracion_cuenta"),
                "class" => 'black text-uppercase mt-2',
            ]
        ),

        a_enid("salir",
            [
                "href" => path_enid("logout"),
                "class" => 'black text-uppercase mt-2',
            ]
        )
    ];

    $seccion_contenido[] = d_row(d($menu_usuario, 'col-sm-12 mt-3'));
    $opciones_menu = d($seccion_contenido, 'dropdown-menu mw_250 p-3');

    $extra_menu = [
        $imagen_usuario,
        $opciones_menu,
    ];
    $menu = d($extra_menu, 'dropdown dropleft');

    return flex($notificaciones, $menu, "mr-md-5 mt-3 mt-md-0");

}

function frm_search(
    $clasificaciones_departamentos,
    $in_session = 0,
    $id_usuario = 0,
    $menu = 0
)
{

    $r[] = '<form action="../search" class="search_principal_form d-none d-md-block d-md-flex mr-5">';
    $r[] = d($clasificaciones_departamentos, "d-none");
    $r[] = input(
        [
            "class" => "input_busqueda_producto col-lg-11",
            "type" => "text",
            "placeholder" => "Búsqueda",
            "name" => "q",
            "onpaste" => "paste_search();",
        ]
    );

    $r[] = btn(icon("fa fa-search "),
        [
            'style' => 'background: #007bff!important;'
        ]
    );
    $r[] = form_close();

    if (!$in_session) {

        $contenido = [

            a_enid(_titulo("tu carrito"),
                [
                    'class' => 'dropdown-item'
                ]
            )
        ];
        $r[] = d(
            dropdown(
                icon("fa fa-shopping-bag  white"),
                $contenido
            ), 'mr-5 mt-2'
        );
    }


    $response = [];
    if (!$in_session) {

        $response[] = d($r, 'd-md-flex justify-content-end mt-3');

    } else {

        $response[] = dd($r, tmp_menu($id_usuario, $menu));

    }

    return append($response);

}

function flex($d, $d1 = '', $ext = '', $ext_left = '', $ext_right = '', $att = 'd-flex ')
{

    if (is_array($d)) {


        $att .= (strlen($d1) > 0) ? $d1 : '';
        $response = d($d, $att);

    } else {


        if (is_array($ext)) {
            $att = $ext[0];
        } else {
            $att .= $ext;
        }

        $response = d(add_text(d($d, $ext_left), d($d1, $ext_right)), $att);
    }

    return $response;

}

function flex_md($d, $d1 = '', $ext = '', $ext_left = '', $ext_right = '', $att = 'd-md-flex ')
{

    if (is_array($d)) {


        $att .= (strlen($d1) > 0) ? $d1 : '';
        $response = d(append($d), $att);

    } else {


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

            $valoraciones .= label("★", ["class" => 'estrella black ', "id" => $a]);
        }
    }

    for ($a; $a <= 5; $a++) {

        $restantes .=
            label("★",
                [
                    "class" => 'estrella azul_estrella_simple  cursor_pointer ',
                    "id" => $a,
                ]
            );
    }

    return add_text($valoraciones, $restantes);
}

function input_frm($col, $text_label, $config_input = [], $text_place = '', $ext_label = '')
{

    $config_label = [];
    if (es_data($config_input)) {

        $config_label["for"] = $config_input["id"];
        $config_label["id"] = "label_" . $config_input["id"];
        $config_label["class"] = _text_(
            _text("cursor_pointer label_", $config_input["id"]),
            $ext_label
        );
    }


    $str = strlen($text_place) > 0 ? $text_place : "";
    $text = _text(
        input($config_input, 0, 0),
        label(
            $text_label
            ,
            $config_label
        )
        ,
        d(
            $str,
            add_text("mt-3 color_red d-none place_input_form_",
                $config_input["id"])
        )
    );
    $r[] = d($text, "input_enid_format w-100");
    if (is_numeric($col)) {

        return ($col > 0) ? d($r, $col) : append($r);

    } else {

        return d($r, $col);
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
    return format_time(date_format(date_create($date),
        _text_('d M Y ', $ext)));

}

function format_link($str, $attributes, $primario = 1, $texto_strong = 1)
{


    $clase = ($primario > 0) ?
        "text-center borde_accion p-2 bg_black white  text-uppercase col " :
        "text-center borde_accion p-2 border_enid col black text-uppercase ";

    $clase .= ($texto_strong) ? ' font-weight-bold ' : '';

    $att = $attributes;


    $att["class"] = (array_key_exists("class",
        $attributes)) ? add_text($clase, $attributes["class"]) : $clase;

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
                $extra = 'col-lg-12 ';
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

    $argumentos = func_get_args();
    $response = '';
    for ($i = 0; $i < func_num_args(); $i++) {
        $response .= $argumentos[$i];
    }
    return $response;

}

function _text_()
{

    $argumentos = func_get_args();
    $response = '';
    for ($i = 0; $i < func_num_args(); $i++) {
        $response .= ' ' . $argumentos[$i];
    }
    return $response;

}

function _d()
{

    $argumentos = func_get_args();
    $response = '';
    for ($i = 0; $i < func_num_args(); $i++) {
        $response .= d($argumentos[$i]);
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
                $response[] = hr('mb-4 border_big', 0);
                $response[] = flex('Subtotal', money($subtotal), $espacio, 'subtotal_text', 'subtotal_money');
                $response[] = flex($tipos_entrega[$tipo_entrega]['texto_envio'], $format_envio, $espacio, 'envio_text', 'envio_money text-uppercase');
                if ($es_abono) {
                    $response[] = flex($abono_format_text, $abono_format, $espacio, 'abono_text', 'abono_money');
                }
                $response[] = hr('mt-4 border_big', 0);
                $response[] = flex('Total', money($saldo_pendiente), 'justify-content-between', 'saldo_pendiente_text h3', 'h3 saldo_pendiente_money');
                $response[] = d_p($tipos_entrega[$tipo_entrega]['nombre_publico'], 'text-right h4 strong ');

                break;
            default:

                break;

        }

        $checkout =
            [
                'checkout' => d($response, 'checkout_resumen'),
                'saldo_pendiente' => $saldo_pendiente,
                'saldo_pendiente_pago_contra_entrega' => $saldo_pendiente_pago_contra_entrega,
                'tipo_entrega' => $entrega_tipo,
                'descuento_entrega' => $costo_envio_cliente

            ];

    }
    return $checkout;


}

function keys_en_arreglo($param, $keys = [])
{

    $response = true;
    if (es_data($param)) {

        for ($a = 0; $a < count($keys); $a++) {
            if (!in_array($keys[$a], $param)) {
                $response = false;
                break;
            }
        }
    }

    return $response;

}

function opciones_populares()
{

    $response[] = a_enid(
        "POPULARES",
        [
            "class" => "white f11 border-right frecuentes border-right-enid",
            "href" => path_enid("search", "/?q2=0&q=&order=2&order=1&order=4")
        ]
    );
    $response[] = a_enid(
        "NOVEDADES",
        [
            "class" => "white  f11 border-right frecuentes border-right-enid"
            ,
            "href" => path_enid("search", "/?q2=0&q=&order=2&order=1"
            )
        ]
    );

    $response[] = a_enid(
        "SERVICIOS",
        [
            "class" => "   white  f11  frecuentes",
            "href" => path_enid("search", "?q2=0&q=&order=2&order=1&order=9")
        ]
    );
    return flex($response);
}

function navegacion($in_session, $clasificaciones_departamentos, $proceso_compra, $id_usuario, $menu)
{

    $is_mobile = is_mobile();
    $frecuentes = opciones_populares();
    $response = [];

    if (!$in_session) {

        if (!$is_mobile) {

            $response[] = get_menu_session($in_session, $proceso_compra);
            $response[] = d([get_logo($is_mobile), $frecuentes], 'd-none d-md-block d-md-flex align-items-center col-md-5 mb-md-3');
            $response[] = frm_search($clasificaciones_departamentos, $in_session);
        } else {
            $response[] = get_logo($is_mobile, $in_session);
        }

    } else {

        if (!$is_mobile) {

            $response[] = flex(
                ajustar(get_logo($is_mobile), $frecuentes, 2),
                frm_search($clasificaciones_departamentos, $in_session, $id_usuario, $menu)
                ,
                "",
                "col-md-7 align-self-center mt-4 pupulares d-none d-md-block",
                "col-lg-5 align-items-center justify-content-between d-flex mt-4 "

            );

        } else {

            $response[] = ajustar(
                get_logo($is_mobile, $in_session),
                tmp_menu($id_usuario, $menu)
            );
        }


    }


    $navegacion = d(
        $response,
        [
            'id' => "flipkart-navbar",
            'class' => "mb-sm-4 mb-md-5 col-md-12"
        ]
    );

    return d($navegacion, 13);

}

function open_form($attr = [])
{
    return '<form ' . add_attributes($attr) . ' >';
}

function d_row($contenido)
{

    return d($contenido, 13);
}

function row_d($contenido)
{

    return d(d($contenido, 13), 12);
}

function d_c($items = [], $attr)
{

    $response = [];

    for ($x = 0; $x < count($items); $x++) {

        $response[] = d($items[$x], $attr);

    }
    return append($response);
}

function terminar($ext = '', $id = '')
{

    $cerrar = d(
        format_link("",
            [
                'class' => _text("fa fa-times ", $ext),
                'id' => $id
            ]
        ), 'col-xs-2 col-sm-1 ml-auto');
    return d($cerrar, 13);
}

function terminar_dropdown($ext = '', $extra_dropdown = '')
{

    return d(
        format_link("",
            [
                'class' => _text("fa fa-times ", $ext),
                'aria-expanded' => false,
                'aria-haspopup' => true

            ]
        ), _text_('col-xs-3 mt-2 col-sm-2 pull-right cerrar_dropdown', $extra_dropdown));

}

function dropdown($presentacion, $a_menu = [], $ext = '', $direccion = 'L')
{
    //dropdown-item
    $r[] = d(
        $presentacion,
        [
            'class' => 'dropdown-toggle',
            'data-toggle' => "dropdown",
            'aria-haspopup' => true,
            'aria-expanded' => "false"
        ]
    );


    $text_direccion = 'dropdown';
    switch ($direccion) {
        case 'L':
            $text_direccion = 'dropleft';
            break;
        case 'R':
            $text_direccion = 'dropright';
            break;
        default:
            break;
    }

    $r[] = d($a_menu, "dropdown-menu");
    return d($r, _text('position-absolute ', $ext, ' ', $text_direccion));

}

function strip_tags_content($text, $tags = '', $invert = FALSE)
{

    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
    $tags = array_unique($tags[1]);

    if (is_array($tags) AND count($tags) > 0) {
        if ($invert == FALSE) {
            return preg_replace('@<(?!(?:' . implode('|', $tags) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
        } else {
            return preg_replace('@<(' . implode('|', $tags) . ')\b.*?>.*?</\1>@si', '', $text);
        }
    } elseif ($invert == FALSE) {
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    return $text;
}


