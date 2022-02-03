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
function span($str, $attributes = [], $row = 0)
{

    return get_base_html("span", $str, $attributes, $row);
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
                $attributes["class"] = (array_key_exists("class",
                    $attributes)) ? ($attributes["class"] . " correo ") : " correo ";

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
)
{

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
function strong($text, $extra ='')
{


    return h($text, 3,  $extra);

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
            $attributes["class"], " form-control rounded-0");
    } else {

        $attributes["class"] = " form-control rounded-0";

    }
    $base = "<textarea " . add_attributes($attributes) . " >" . $def . "</textarea>";
    $e = ($row_12 == 0) ? $base : addNRow($base);

    return $e;

}
function append($array, $col = 0, $num_col = 0)
{
    $response = "";
    if (is_array($array)) {
    
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

function frm_fecha_busqueda($def_inicio = 0, $def_fin = 0, $base_inicio = 'col-sm-4 mt-5 p-0 p-md-1 ', $base_termino = 'col-sm-4 mt-5 p-0 p-md-1', $base_boton = 'col-lg-4 mt-5 p-0 p-0 align-self-end')
{

    $inicio = ($def_inicio != 0) ? $def_inicio : add_date(date("Y-m-d"), -1);
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


function text_icon($class_icono, $text, $att = [], $left = 1)
{

    $es_derecho = (!is_array($att) && $att == 0);
    $clase = "rounded-circle p-2 border border-secondary border-dark";
    $izquierdo = (flex(icon(_text_($clase, $class_icono), $att), $text, "", "mr-3"));
    $derecho = (flex($text, icon(_text_($class_icono, $clase), $att), "", "", "ml-3"));
    return ($left > 0 && !$es_derecho) ? $izquierdo : $derecho;

}

function _titulo($text, $extra = 'text-2xl')
{
    
    return h($text, 1,  $extra);

}
function _subtitulo($text,  $extra = 'text-xl')
{
    
    return h($text, 2,  $extra);

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
        icon(_text_(_eliminar_icon, 'cerrar_modal fa-2x'),
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
            "data-backdrop" => "static",
            "data-keyboard" => "false"
        ]
    );

    return d($modal, 13);

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

function format_link($str, $attributes, $primario = 1, $texto_strong = 1)
{


    $clase = ($primario > 0) ?
        "text-center borde_accion p-2 bg_black white  text-uppercase col " :
        "text-center bg-white borde_accion p-2 border_enid col black text-uppercase ";

    $clase .= ($texto_strong) ? ' font-weight-bold ' : '';

    $att = $attributes;


    $att["class"] = (array_key_exists("class",
        $attributes)) ? add_text($clase, $attributes["class"]) : $clase;

    return a_enid($str, $att);
}

function submit_format($str, $attributes = [], $primario = 1, $texto_strong = 1)
{


    $clase = ($primario > 0) ?
        "text-center borde_accion p-2 bg_black white  text-uppercase col " :
        "text-center bg-white borde_accion p-2 border_enid col black text-uppercase ";

    $clase .= ($texto_strong) ? ' font-weight-bold ' : '';

    $att = $attributes;


    $att["class"] = 
    (array_key_exists("class",$attributes)) ? add_text($clase, $attributes["class"]) : $clase;
    $att["type"] = "submit";
    $att["value"] = $str;

    return input($att);
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
function icon($class, $attributes = '', $row_12 = 0, $extra_text = '')
{

    $attr = add_attributes($attributes);
    $base = "<i class='fa black " . $class . "'" . $attr . " ></i>";
    $base2 = span($extra_text, $attributes);

    return ($row_12 == 0) ? $base . $base2 : addNRow($base) . $base2;

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
function posibles_valoraciones($calificacion)
    {
        $response = [];
        for ($x = 1; $x <= 5; $x++) {

            $id_input = "radio" . $x;
            $response[] = input(
                [
                    "id" => $id_input,
                    "value" => $x,
                    "class" => 'input-start f2',
                    "type" => "radio"
                ]
            );

            $response[] = label("★",
                [
                    "class" => 'estrella ' . " f2 estrella_" . $x,
                    "for" => "$id_input",
                    "id" => $x,
                    "title" => $x . " - " . $calificacion[$x]
                ]
            );

        }
        return append($response);
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
function es_data($e)
{

    return (is_array($e) && count($e) > 0) ? true : false;

}
function add_text($a, $b, $f = 0)
{

    if (is_string($f)) {

        return $a . $b . $f;

    } else {

        return ($f < 1) ? $a . $b : $a . " " . $b;
    }


}
function format_error($errors)
{
    
    $response = [];
    
    if ($errors->any()) {
            
        foreach($errors->all() as $error){

            $response[] = d($error,12);
        }
    }
   
    return append($response);
}
function format_error_campo($mensaje, $extra = '')
{
    
    return d($mensaje, _text_('formato_campo_error', $extra));    
    
}