<?php
function ul($list, $attributes = [])
{

    return _list('ul', $list, (is_string($attributes)) ? ["class" => $attributes] : $attributes);
}

function li($info, $attributes = [], $row_12 = 0)
{
    return add_element($info, "li", (is_string($attributes)) ? ["class" => $attributes] : $attributes, $row_12);
}

function span($str, $attributes = [], $row = 0)
{

    return get_base_html("span", $str, $attributes, $row);
}

function p($str, $attributes = [], $row = 0)
{
    return get_base_html("p", $str, $attributes, $row);
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

    $attributes["class"] = (array_key_exists(
        "class",
        $attributes
    )) ? (_text_($attributes["class"], " ")) : "  ";

    if ($bootstrap) {

        $attributes["class"] = (array_key_exists("class", $attributes)) ? ($attributes["class"] . " form-control ") : " form-control ";
    }

    if (prm_def($attributes, "type") !== 0) {

        $type = $attributes["type"];

        switch ($type) {

            case "tel":

                $attributes["onpaste"] = "paste_telefono();";
                $attributes["class"] = (array_key_exists(
                    "class",
                    $attributes
                )) ? ($attributes["class"] . " telefono ") : " telefono ";
                $attributes["minlength"] = 8;
                $attributes["maxlength"] = 12;
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

                $attributes["required"] = true;
                $attributes["pattern"] =
                    '[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)';
                $attributes['title'] = "Verifica el formato de tu correo!";
                $attributes["onpaste"] = "paste_email();";
                $attributes["class"] = (array_key_exists(
                    "class",
                    $attributes
                )) ? ($attributes["class"] . " correo ") : " correo ";

                break;

            case "password":
                $attributes["required"] = true;
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

                $attributes["class"] = (array_key_exists(
                    "class",
                    $attributes
                )) ?
                    (_text_($attributes["class"], "checkbox_enid border cursor_pointer rounded")
                    ) : " checkbox_enid border cursor_pointer rounded";
                break;


            default:
        }
    }

    $attributes["autocomplete"] = "off";
    if (array_key_exists('required', $attributes)) {
        $attributes['required'] = true;
    }

    $attr = add_attributes($attributes);


    return ($e < 1) ? "<input  $attr>" : addNRow("<input " . $attr . " >");
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


function xmp($text)
{

    echo "<xmp>";
    echo print_r($text);
    echo "</xmp>";
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

function a_texto($title = '', $attributes = [], $format_block = 1)
{

    $clases_base = "enid_link black underline text-capitalize";
    $class = (es_data($attributes) && array_key_exists("class", $attributes)) ?
        _text_($attributes["class"], $clases_base) : $clases_base;
    $attributes["class"] = $class;

    return a_enid($title, $attributes, $format_block);
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
function template_table_enid($extra_class = '')
{
    $class = _text_('table text-center', $extra_class);
    return [
        'table_open' => '<table   class="' . $class . '" >',
        'thead_open' => '<thead class="black_enid_background2 white">',
        'thead_close' => '</thead>',
        'heading_row_start' => '<tr class="text-center">',
        'heading_row_end' => '</tr>',
        'heading_cell_start' => '<th class="text-center">',
        'heading_cell_end' => '</th>',
        'tbody_open' => '<tbody>',
        'tbody_close' => '</tbody>',
        'row_start' => '<tr class="text-center">',
        'row_end' => '</tr>',
        'cell_start' => '<td class="text-center">',
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
            $info,
            "button",
            [
                'class' => $class,
                'id' => $id,
            ]
        );
    }

    return add_element($tags, "d", ['class' => 'tags']);
}

function create_solo_tag($param, $class, $val_id, $text)
{

    $tags = add_element(
        $param[$text],
        "button",
        [
            'class' => $class,
            'id' => $param[$val_id],
        ]
    );

    return add_element($tags, "d", ['class' => 'tags']);
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
    $menos = [],
    $mayusculas = 0
) {

    $select[] = "<select name='" . $name . "'  class='text-uppercase " . $class . "'  id='" . $id . "'> ";

    if ($def == 1) {

        $select[] = "<option value='" . $valor . "'>" . $text_def . " </option>";
    }
    foreach ($data as $item) {

        if (!in_array($item[$val], $menos)) {

            $texto = ($mayusculas > 0) ? strtoupper($item[$text_option]) : $item[$text_option];
            $select[] = "<option value='" . $item[$val] . "'>" . $texto . " </option>";
        }
    }

    $select[] = "</select>";

    return ($row < 1) ? append($select) : addNRow(append($select));
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
        _text("https://enidservices.com/", _web, "/img_tema/enid_service_logo.jpg");

    if (es_data($extra)) {
        $conf += $extra;
    }
    $img = img($conf);

    return ($row_12 == 0) ? $img : addNRow($img);
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

function textarea($attributes = [], $row_12 = 0, $def = '')
{


    $attributes["rows"] = prm_def($attributes, 'rows', 2);

    if (array_key_exists("class", $attributes)) {
        $attributes["class"] = _text_(
            $attributes["class"],
            " form-control rounded-0"
        );
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

function get_menu_session($in_session, $proceso_compra = 1)
{

    $response = "";
    if ($in_session < 1) {


        $session = a_enid(
            "Acceder",
            [
                "href" => path_enid('login'),
                "class" => "text-uppercase text_iniciar_session 
                text-decoration-none mr-4 
                white borde_amarillo iniciar_session_boton strong ml-3",
            ]
        );


        if ($proceso_compra < 1) {

            $response = flex(
                "",
                $session,
                "d-none d-md-block d-md-flex
                justify-content-end mt-md-3 mb-md-3"
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

        $response = ($row > 0) ? d(d(append([$a, $b]), $class), 1) : d(
            append([$a, $b]),
            $class
        );
    }

    return $response;
}

function frm_fecha_busqueda($def_inicio = 0, $def_fin = 0, $base_inicio = 'col-sm-4 mt-5 p-0 p-md-1 ', $base_termino = 'col-sm-4 mt-5 p-0 p-md-1', $base_boton = 'col-lg-4 mt-5 p-0 p-0 align-self-end')
{

    $inicio = ($def_inicio != 0) ? $def_inicio : add_date(date("Y-m-d"), -1);
    $fin = ($def_fin != 0) ? $def_fin : date("Y-m-d");

    $r[] = input_frm(
        $base_inicio,
        "Fecha inicio",
        [
            "name" => 'fecha_inicio',
            "class" => "input_busqueda_inicio",
            "id" => 'datetimepicker4',
            "value" => $inicio,
            "type" => "date",
        ]
    );

    $r[] = input_frm(
        $base_termino,
        "Fecha término",
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


function text_icon($class_icono, $text, $att = [], $left = 1)
{

    $es_derecho = (!is_array($att) && $att == 0);
    $clase = "rounded-circle p-2 border border-secondary border-dark";
    $izquierdo = (flex(icon(_text_($clase, $class_icono), $att), $text, "", "mr-3"));
    $derecho = (flex($text, icon(_text_($class_icono, $clase), $att), "", "", "ml-3"));
    return ($left > 0 && !$es_derecho) ? $izquierdo : $derecho;
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

        $r[] = a_enid(
            "",
            [
                "href" => $url_facebook,
                "target" => "_black",
                "class" => "fa fa-facebook " . $color,

            ]
        );

        $r[] = a_enid(
            "",
            [
                "href" => "https://www.instagram.com/enid_service/",
                "class" => _text_("fa fa-instagram ", $color),
                "title" => "Tumblr",
                "target" => "_black",
            ]
        );

        $r[] = a_enid(
            "",
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

            $response = d($a, " col-lg-1 " . $extra_left) . d(
                $b,
                " col-lg-11 " . $extra_right
            );
            break;

        case 2:

            $response = d($a, " col-lg-2 " . $extra_left) . d(
                $b,
                " col-lg-10 " . $extra_right
            );
            break;
        case 3:

            $response = d($a, " col-lg-3 " . $extra_left) . d(
                $b,
                " col-lg-9 " . $extra_right
            );
            break;

        case 4:

            $response = d($a, " col-lg-4 " . $extra_left) . d(
                $b,
                " col-lg-8 " . $extra_right
            );
            break;

        case 5:

            $response = d($a, " col-lg-5 " . $extra_left) . d(
                $b,
                " col-lg-7 " . $extra_right
            );
            break;

        case 6:

            $response = d($a, " col-lg-6 " . $extra_left) . d(
                $b,
                " col-lg-6 " . $extra_right
            );
            break;

        case 7:

            $response = d($a, " col-lg-7 " . $extra_left) . d(
                $b,
                " col-lg-5 " . $extra_right
            );
            break;

        case 8:

            $response = d($a, " col-lg-8 " . $extra_left) . d(
                $b,
                " col-lg-4 " . $extra_right
            );
            break;

        case 9:

            $response = d($a, " col-lg-9 " . $extra_left) . d(
                $b,
                " col-lg-3 " . $extra_right
            );

            break;

        case 10:

            $response = d($a, " col-lg-10 " . $extra_left) . d(
                $b,
                " col-lg-2 " . $extra_right
            );

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

function gb_modal($modal_inicial = 1, $id_modal = "modal-error-message", $icono_carga = 1)
{
    $span = span('Loading', 'sr-only');
    $load = str_repeat(d(
        $span,
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
        icon(
            _text_(_eliminar_icon, 'cerrar_modal fa-2x'),
            [
                "data-dismiss" => "modal",
            ]
        ),
        'ml-auto'
    );

    $cerrar = d($cerrar, "modal-header border-0");
    $seccion_contenido = d(_text_($cerrar, $seccion), "modal-content rounded-0");
    $contenido = d(
        $seccion_contenido,
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
            "data-backdrop" => "static",
            "data-keyboard" => "false"
        ]
    );

    return d($modal, 13);
}

function menu_session_mobil($in_session)
{

    $cerrar_opciones = d(
        a_enid(
            d("×", "borde_amarillo"),
            [
                "href" => "javascript:void(0)",
                "class" => "closebtn closebtn_lateral p-3 font-weight-bold h1 black f13 ",
                "onclick" => "closeNav()",
            ]
        ),
        'ml-auto mr-5 top_70'
    );

    $form_busqueda = form_busqueda_productos();
    $opciones_acceso = opciones_acceso($in_session);

    $clases_columnas = "d-flex flex-column align-items-center justify-content-between h-100'";
    $columna = d([$cerrar_opciones, $form_busqueda, $opciones_acceso], $clases_columnas);

    $menu_lateral = d(

        $columna,
        [
            "id" => "mySidenav",
            "class" => "sidenav mb-5"
        ]
    );

    return addNRow($menu_lateral);
}

function form_busqueda_productos()
{
    $form[] = open_form(['action' => "../search"]);
    $form[] = d("¿Qué estás buscando?", 'strong mb-2');
    $form[] = flex(
        input(
            [
                "name" => "q",
                "placeholder" => "artículo",
                "class" => "input_search w-100",
                'style' => 'height: 41px!important;',
            ]
        ),
        btn(
            "buscar",
            [
                'class' => 'boton-busqueda'
            ]
        ),
        _between,
        "col-sm-10 p-0",
        "col-sm-2 p-0"
    );
    $form[] = form_close();
    return d($form, 'my-auto col-sm-12');
}

function opciones_acceso($in_session)
{
    $response = "";
    if ($in_session < 1) {

        $redes[] = a_enid(
            icon(_text_(_facebook_icon,'fa-2x white')),
            [
                'href' => path_enid('facebook', 0, 1),
                'target' => 'black', 
                'class' => 'click_facebook_clientes'
            ]
        );
        $redes[] = a_enid(
            icon(_text_(_instagram_icon,'fa-2x white')),
            [
                'href' => path_enid('instagram', 0, 1),
                'target' => 'black',
                'class' => 'ml-3 click_instagram_clientes'
            ]
        );
    
        $redes[] = a_enid(
            icon(_text_(_pinterest_icon,'fa-2x white')),
            [
                'href' => path_enid('pinterest', 0, 1),
                'target' => 'black',
                'class' => 'ml-3 '
            ]
        );
    
    
        $texto = _text_(
            d(_text_(span("5% de descuento",'f12 strong white'),
            "en tu primer compra al enviar", span(" WhatsApp aquí!", 'strong white f12'))),
             
        );

        $whatsApp = a_enid(
            $texto,
            [
                "href" => path_enid('whatsapp_descuento', 0, 1),
                "class" => "white whatsapp_trigger borde_amarillo mb-2 mt-2",
                "target" => "_black"
            ]
            );

        $response = d(
            flex(
                $whatsApp,
                d($redes,'d-flex'),                
                _text_(_between, 'contenedor-lateral-menu acceder_vender fixed-bottom mt-1'),
                
                "col-xs-9 fp9",
                "mx-auto white fp7 col-xs-3 p-0 text-uppercase",

            ),
            "d-block d-md-none"
        );
    }
    return append($response);
}


function tmp_menu($path_img_usuario, $id_usuario, $menu)
{


    $contenido[] = d_row(d(place("place_notificaciones_usuario m-3"), 12));
    $seccion = append($contenido);
    $icono_compras = icon(_text_(_compras_icon, 'mr-2 white'));
    $place_compras = d('', 'place_numero_deseo');
    $deseos = flex($icono_compras, $place_compras, 'borde_amarillo white');
    $deseo_pedido = a_enid($deseos, ['href' => path_enid('lista_deseos'), 'class' => 'white']);

    if (is_mobile()) {
        $notificaciones[] = d(icon(_text_(_busqueda_icon, "white mr-2"), ["onclick" => "openNav()"]), "borde_amarillo mr-2");
    }

    $notificaciones[] = d($deseo_pedido, 'd-none white numero_deseo mr-2 strong');
    $notificaciones[] = flex(
        a_enid(
            flex(
                icon("fa fa-bell white mr-2"),
                d("", "num_tareas_dia_pendientes_usr"),
                "",
                "align-self-center"
            ),
            [
                "class" => "dropdown-toggle",
                "data-toggle" => "dropdown",
            ]
        ),
        d(
            $seccion,
            "row dropdown-menu menu_dropdown_enid"
        ),
        "dropdown dropleft menu_notificaciones_progreso_dia mr-2 borde_amarillo"
    );


    $imagen_usuario = a_enid(
        get_img_usuario($path_img_usuario),
        [
            "class" => "dropdown-toggle",
            "data-toggle" => "dropdown",
        ]
    );


    $menu_usuario = [
        a_enid(
            "Perfil",
            [
                "href" => path_enid('usuario_contacto', $id_usuario),
                "class" => 'black fp9 border-bottom border-dark',
            ]
        ),
        $menu,
        a_enid(
            "Configuración",
            [
                "href" => path_enid("administracion_cuenta"),
                "class" => 'black fp9 border-bottom border-dark',
            ]
        ),

        a_enid(
            "Salir",
            [
                "href" => path_enid("logout"),
                "class" => 'black fp9 border-bottom border-dark',
            ]
        )
    ];

    $seccion_contenido[] = d_row(d($menu_usuario, 'col-sm-12 mt-3'));
    $opciones_menu = d($seccion_contenido, 'dropdown-menu mw_250 p-3');

    $extra_menu = [
        $imagen_usuario,
        $opciones_menu,
    ];
    $menu = d($extra_menu, 'dropdown dropleft drop-left-enid');

    return flex(d($notificaciones, 'd-flex align-items-center'), $menu, "mr-5 align-items-center");
}

function frm_search(
    $proceso_compra,
    $path_img_usuario,
    $clasificaciones_departamentos,
    $in_session = 0,
    $id_usuario = 0,
    $menu = 0


) {

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

    $r[] = btn(
        icon("fa fa-search "),
        [
            'style' => 'background: #007bff!important;'
        ]
    );
    $r[] = form_close();

    if (!$in_session) {

        $notificacion_deseo_compra = flex(
            d('', 'place_resumen_deseo_compra white strong'),
            icon("fa fa-shopping-bag  white"),
            _between
        );
        $r[] = a_enid($notificacion_deseo_compra, ['class' => 'icono_compras_pendientes']);
    }
    $r[] = get_menu_session($in_session, $proceso_compra);

    $response = [];
    if (!$in_session) {

        $response[] = d($r, 'd-md-flex justify-content-end align-items-center');
    } else {

        $response[] = dd($r, tmp_menu($path_img_usuario, $id_usuario, $menu));
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
            label(
                "★",
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
            $text_label,
            $config_label
        ),
        d(
            $str,
            add_text(
                "mt-3 color_red d-none place_input_form_",
                $config_input["id"]
            )
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

            $att["class"] = (array_key_exists(
                "class",
                $attributes
            )) ? add_text($attributes["class"], $f, 1) : $f;
        }

        $response = d(d($str, 13), $att);
    }


    return $response;
}

function format_link($str, $attributes, $primario = 1, $texto_strong = 1)
{


    $clase = ($primario > 0) ?
        "text-center borde_accion p-2 bg_black white  text-uppercase col " :
        "text-center bg-white borde_accion p-2 border_enid col black text-uppercase ";

    $clase .= ($texto_strong) ? ' font-weight-bold ' : '';

    $att = $attributes;


    $att["class"] = (array_key_exists(
        "class",
        $attributes
    )) ? add_text($clase, $attributes["class"]) : $clase;

    return a_enid($str, $att);
}


function formated_link($str, $primario = 1)
{

    $f = ($primario > 0) ? " p-3 bg_black white strong col" : " p-3 strong  border_enid col black";
    $att["class"] = $f;

    return d($str, $att);
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

function opciones_populares()
{

    $response[] = a_enid(
        "POPULARES",
        [
            "class" => "white fp8 border-right frecuentes border-right-enid",
            "href" => path_enid("search", "/?q2=0&q=&order=2&order=4")
        ]
    );
    $response[] = a_enid(
        "NOVEDADES",
        [
            "class" => "white  fp8 border-right frecuentes border-right-enid",
            "href" => path_enid(
                "search",
                "/?q2=0&q=&order=1"
            )
        ]
    );

    $response[] = a_enid(
        "PROMOCIONES",
        [
            "class" => "white  fp8  border-right frecuentes border-right-enid",
            "href" => path_enid("promociones")
        ]
    );

    $response[] = a_enid(
        "CLIENTES",
        [
            "class" => "white  fp8  border-right frecuentes border-right-enid",
            "href" => path_enid("clientes")
        ]
    );


    $response[] = a_enid(
        "AFILIADOS",
        [
            "class" => "white  fp8 frecuentes",
            "href" => path_enid("sobre_vender")
        ]
    );


    $response[] = a_enid(
        icon(_text_(_facebook_icon,'white')),
        [
            'href' => path_enid('facebook', 0, 1),
            'target' => 'black',
            'class' => 'ml-5 white  mt-1 click_facebook_clientes'
        ]
    );
    $response[] = a_enid(
        icon(_text_(_instagram_icon,'white')),
        [
            'href' => path_enid('instagram', 0, 1),
            'target' => 'black',
            'class' => 'ml-5 white mt-1 click_instagram_clientes'
        ]
    );

    $response[] = a_enid(
        icon(_text_(_pinterest_icon,'white')),
        [
            'href' => path_enid('pinterest', 0, 1),
            'target' => 'black',
            'class' => 'ml-5 white mt-1'
        ]
    );


    return flex($response);
}

function opciones_adicionales_navegacion()
{

    $response[] = d(d("Agenda tu pedido y paga hasta tu entrega!",'col-xs-12 white fp7 ml-3 text-uppercase'),["class"=> 'row bg_black white mb-2' ]);    
    $opciones[] = d(
        a_enid("POPULARES", [
            "href" => path_enid("search", "/?q2=0&q=&order=2&order=4"),
            "class" => "black"
        ]),
        "text-capitalize col-xs-4 "
    );
    $opciones[] = d(a_enid("NOVEDADES", [
        "href" => path_enid("search","/?q2=0&q=&order=1"),
        "class" => "black"
    ]), "text-capitalize col-xs-4 text-center");
    
    $opciones[] = d(a_enid("PROMOCIONES", [
        "href" => path_enid("promociones"),
        "class" => "black"
    ]), "text-capitalize  col-xs-4 text-center");


   
    $opciones[] = d(a_enid("ÚLTIMOS CLIENTES", [
        "href" => path_enid("clientes"),
        "class" => "black"
    ]), "text-capitalize  col-xs-6");

    $opciones[] = d(a_enid("FORMAS DE PAGO", [
        "href" => path_enid("forma_pago"),
        "class" => "black"
    ]), "text-capitalize  col-xs-6");
    


    $response[] = d(d($opciones, _text_("row d-flex fp8 p-2", _between)), 'col-xs-12 bg-light border-bottom ');
    return append($response);
}
function navegacion($path_img_usuario, $in_session, $clasificaciones_departamentos, $proceso_compra, $id_usuario, $menu)
{

    $is_mobile = is_mobile();
    $frecuentes = opciones_populares();
    $response = [];

    if (!$in_session) {

        if (!$is_mobile) {

            $busqueda = frm_search($proceso_compra, $path_img_usuario, $clasificaciones_departamentos, $in_session);
            $frecuentes_busqueda = flex($frecuentes, $busqueda, _text_(_between));
            $response[] = d(p(_text_('Agenda tu pedido y paga hasta tu entrega! en CDMX' ), 'white'), 'd-md-flex justify-content-end mr-5');                        
            $response[] = d([get_logo(), $frecuentes_busqueda], 'd-none d-md-block d-md-flex p-2');
        } else {
            $response[] = get_logo($in_session);
            $response[] = opciones_adicionales_navegacion();
            
        }
    } else {

        if (!$is_mobile) {

            $response[] = flex(
                ajustar(get_logo(), $frecuentes, 2),
                frm_search($proceso_compra, $path_img_usuario, $clasificaciones_departamentos, $in_session, $id_usuario, $menu),
                "p-3",
                "col-md-7 align-self-center pupulares d-none d-md-block",
                "col-lg-5 align-items-center justify-content-between d-flex"

            );
        } else {

            $response[] = ajustar(
                get_logo($in_session),
                tmp_menu($path_img_usuario, $id_usuario, $menu)
            );
            $response[] = opciones_adicionales_navegacion();

        }
    }

    $navegacion[] = d(
        $response,
        [
            'id' => "flipkart-navbar",
            'class' => "col-md-12"
        ]
    );
    

    return d($navegacion, "row fixed-top");
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

function list_orden($list_orden, $default)
{

    $r[] = '<select class="form-control" name="orden" id="orden">';
    $a = 0;
    foreach ($list_orden as $row) {

        $selected = ($a == $default) ? "selected" : "";
        $r[] = _text("<option value='", $a, "' ", $selected, ">");
        $r[] = $row;
        $r[] = '</option>';
        $a++;
    }
    $r[] = '</select>';

    return append($r);
}
function gb_modal_costos($precio, $costo, $id_servicio)
{

    $form[] = d(_titulo('¿Precios y costos?'), 'mb-5');
    $form[] = form_open(
        "",
        [
            "class" => "form_precio",
            "method" => "post"
        ]
    );

    $form[] = input_frm(
        '',
        '¿Precio?',
        [
            'class' => 'precio_servicio',
            'id' => 'precio',
            'name' => 'precio',
            'value' => $precio,
            'required' => true
        ]
    );

    $form[] = hiddens(['name' => 'id_servicio', 'class' => 'id_servicio', 'value' => $id_servicio]);
    $form[] = form_close();



    $form[] = form_open(
        "",
        [
            "class" => "form_costo",
            "method" => "post"
        ]
    );

    $form[] = input_frm(
        'mt-5',
        '¿Costo?',
        [
            'class' => 'costo_servicio',
            'id' => 'costo',
            'name' => 'costo',
            'value' => $costo,
            'required' => true
        ]
    );
    $form[] = hiddens(['name' => 'id_servicio', 'class' => 'id_servicio', 'value' => $id_servicio]);
    $form[] = form_close();
    return gb_modal(append($form), 'gb_costos_precios');
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
function icon($class, $attributes = '', $row_12 = 0, $extra_text = '')
{

    $attr = add_attributes($attributes);
    $base = "<i class='fa black " . $class . "'" . $attr . " ></i>";
    $base2 = span($extra_text, $attributes);

    return ($row_12 == 0) ? $base . $base2 : addNRow($base) . $base2;
}

function get_url_pinterest($url, $icon = 0)
{

    $path = _text("https://www.pinterest.com/pin/create/button/?url=", $url);
    if ($icon > 0) {
        return a_enid(
            icon('fa fa-pinterest-p'),
            [
                'target' => "_black",
                'href' => $path,
                'class' => 'black',
            ]
        );
    }

    return $path;
}

function get_url_twitter($url, $mensaje, $icon = 0)
{

    $path = _text(
        "https://twitter.com/intent/tweet?text=",
        $mensaje,
        $url
    );
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
        "https://www.facebook.com/sharer/sharer.php?u=",
        $url,
        ";src=sdkpreparse"
    );
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
function get_logo($session = 0)
{

    if (is_mobile()) {

        $path = path_enid("search_q3");
        $texto = d("<a href='" . $path . "' class='white'><strong class='white'>Enid</strong> Service</a>", ["class" => "titulo_enid_service"]);
        $notificacion_deseo_compra = flex(
            d('', 'place_resumen_deseo_compra white strong'),
            icon("fa fa-shopping-bag  white"),
            _between
        );

        $icono_busqueda = icon(_text_(_busqueda_icon, "white mr-2"), ["onclick" => "openNav()"]);
        $carro = a_enid($notificacion_deseo_compra, ['class' => 'icono_compras_pendientes mr-3 ml-2 borde_amarillo']);
        $icono_busqueda_carro = flex($icono_busqueda, $carro, _between, "borde_amarillo");

        $acceder = a_enid(
            "acceder",
            [
                "href" => path_enid('login'),
                "class" => "white borde_amarillo d-xs-block d-md-none mr-3 text-uppercase fp9 strong"
            ]
        );

        $acceder  = ($session < 1) ? $acceder : "";
        $icono_busqueda_carro_session = flex($icono_busqueda_carro, $acceder, _between);


        $carro_logo = flex($texto, $icono_busqueda_carro_session, _between);
        $carro_logo = ($session > 0) ? $texto : $carro_logo;
        $en_mobile = d(
            $carro_logo,
            "smallnav menu white f12 mt-4 "
        );
        $class = "col-lg-12";
        switch ($session) {

            case 1:
                $class = "col-lg-3";
                break;
            case 2:
                $class = "col-lg-1";
                break;
        }

        $response[] =  d($en_mobile, $class);
        return append($response);
    } else {

        $img_enid = img_enid(["style" => "width: 50px!important;"]);
        return a_enid($img_enid, ["href" => path_enid('home')]);
    }
}

function img_servicio($id, $external = 0)
{
    $url = ($external > 0) ?
        _text(
            "http://enidservices.com/",
            _web,
            "/imgs/index.php/enid/imagen_servicio/",
            $id
        ) :
        get_url_request(_text("imgs/index.php/enid/imagen_servicio/", $id));

    return [
        'src' => $url,
        'id' => "imagen_" . $id,
        'class' => 'imagen-producto',
    ];
}

function select_cantidad_compra($es_servicio, $existencia, $valor_seleccionado = 1, $clase_extra = '', $identificador = 0)
{

    $config = [
        "name" => "num_ciclos",
        "class" => _text_("telefono_info_contacto select_cantidad form-control ", $clase_extra),
        "id" => "num_ciclos",
        "identificador" => $identificador
    ];

    $select[] = "<select " . add_attributes($config) . ">";
    for ($a = 1; $a < max_compra($es_servicio, $existencia); $a++) {

        if ($a == $valor_seleccionado) {
            $select[] = "<option selected value=" . $a . ">" . _text_("Cantidad", $a) . "</option>";
        } else {
            $select[] = "<option value=" . $a . ">" . _text_("Cantidad", $a) . "</option>";
        }
    }
    $select[] = "</select>";
    return append($select);
}

function get_img_usuario($path_img_usuario, $extra_class = '')
{


    $img_conf = [
        "id" => "imagen_usuario",
        "class" => _text_("imagen_usuario", $extra_class),
        "src" => $path_img_usuario,
        "onerror" => "this.src='../img_tema/user/user.png'",
        "style" => "width: 40px!important;height: 35px!important;",
    ];

    return img($img_conf);
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

            $easy_select .= add_element(
                $text,
                "a",
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
