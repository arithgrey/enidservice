<?php

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


function tab_activa($seccion, $activa, $considera_segundo = 0)
{

    return ($considera_segundo == 0) ? (($seccion == $activa) ? 1 : 0) : 1;
}

function remove_comma($text)
{

    return str_replace("'", '', (str_replace('"', '', $text)));
}

function es_local()
{

    return ($_SERVER['HTTP_HOST'] !== "localhost") ? 0 : 1;

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
function get_keys($array_keys)
{
    return implode(",", $array_keys);
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

function microtime_float()
{
    list($useg, $seg) = explode(" ", microtime());

    return ((float)$useg + (float)$seg);
}

function array_horarios($simple = 1)
{
    //[FIXME]
    if ($simple > 0) {

        return [
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
        ];

    } else {

        return [
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
    }


}

function horarios()
{

    $horarios = array_horarios(1);
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



function format_phone($number)
{
    $txt = preg_replace('/[\s\-|\.|\(|\)]/', '', $number);
    $format = '[$1?$1 :][$2?($2):x][$3: ]$4[$5: ]$6[$7? $7:]';
    if (preg_match('/^(.*)(\d{3})([^\d]*)(\d{3})([^\d]*)(\d{4})([^\d]{0,1}.*)$/', $txt,
        $matches)) {
        $result = $format;
        foreach ($matches as $k => $v) {
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

    return (is_array($data) && count($data) > 0 && array_key_exists(0, $data) && array_key_exists($index,
            $data[0])) ? $data[0][$index] : $def;
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


function is_mobile()
{

    return (dispositivo() === 1) ? 1 : 0;
}


function format_fecha($date, $horas = 0)
{

    $ext = ($horas > 0) ? 'H:i' : '';
    return format_time(date_format(date_create($date),
        _text_('d M Y ', $ext)));

}

function format_hora($date)
{

    return format_time(date_format(date_create($date), 'H:i'));

}


function money($num)
{
    
    return _text_(sprintf('%01.2f', $num), "MXN");    

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


function strip_tags_content($text, $tags = '', $invert = FALSE)
{

    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
    $tags = array_unique($tags[1]);

    if (is_array($tags) and count($tags) > 0) {
        if ($invert == FALSE) {
            return preg_replace('@<(?!(?:' . implode('|', $tags) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
        } else {
            return preg_replace('@<(' . implode('|', $tags) . ')\b.*?>.*?</\1>@si', '', $text);
        }
    } elseif ($invert == FALSE) {
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    $text = trim(strip_tags(str_replace("'", $text)));
    return $text;
}

function format_nombre($usuario)
{

    $response = "";
    $es_usuario = (is_array($usuario) && array_key_exists('nombre', $usuario));
    if ($es_usuario) {

        $nombre = $usuario['nombre'];
        $nombre = (is_null($nombre)) ? '' : $nombre;
        $apellido_paterno = $usuario['apellido_paterno'];
        $apellido_paterno = (is_null($apellido_paterno)) ? '' : $apellido_paterno;
        $response = _text_(
            $nombre,
            $apellido_paterno
        );
    } else {

        if (es_data($usuario)) {
            $nombre = pr($usuario, 'nombre');
            $nombre = is_null($nombre) ? '' : $nombre;
            $apellido_paterno = pr($usuario, 'apellido_paterno');
            $apellido_paterno = is_null($apellido_paterno) ? '' : $apellido_paterno;
            $response = _text_(
                $nombre,
                $apellido_paterno
            );
        }

    }
    return $response;

}


function phoneFormat($number)
{
    if (ctype_digit($number) && strlen($number) == 10) {
        $number = '(' . substr($number, 0, 2) . ') ' . substr($number, 2, 2) . '-' . substr($number, 4, 2) . '-' . substr($number, 6, 2) . '-' . substr($number, 8, 2);
    } else {
        if (ctype_digit($number) && strlen($number) == 7) {
            $number = substr($number, 0, 3) . '-' . substr($number, 3, 4);
        }
    }
    return $number;
}

function format_link_nombre($data, $nombre, $email = '')
{

    $email = es_data($nombre) ? prm_def($nombre, 'email') : $email;
    $link = path_enid('busqueda_usuario', $email);
    $response = es_data($nombre) ? format_nombre($nombre) : $nombre;

    if (es_administrador($data)) {

        $response = a_enid($response, ['href' => $link, 'class' => 'black underline']);
    }

    return $response;
}

function format_link_nombre_perfil($row)
{

    $id = prm_def($row, "id_usuario");
    $link = path_enid('usuario_contacto', $id);
    $formato_nombre = format_nombre($row);

    return a_enid($formato_nombre, ['href' => $link, 'class' => 'black underline']);

}


function bloque($text, $ext = '')
{
    return d($text, _text_("border border-secondary p-3 mt-3 mb-3 row borde_accion solid_bottom_2", $ext));
}

function valida_texto_maps($domicilio, $estilos = 1)
{
    $ubicacion_arreglo = explode(' ', $domicilio);
    $text = '';
    foreach ($ubicacion_arreglo as $row) {

        if (strpos($row, 'https') !== FALSE) {

            $config = [
                'href' => $row,
                'target' => '_blank',
                'style' => 'color:blue;',
                'class' => 'text-uppercase text-right mt-3'
            ];
            $configurador = [
                'href' => $row,
                'target' => '_blank',
                'class' => 'text-uppercase black mt-3 border border-info text-center'
            ];
            $conf = ($estilos < 0) ? $config : $configurador;
            if ($estilos < 1) {

                $text .= format_link('abrir en google maps', $conf);

            } else {
                $text .= a_enid('abrir en google maps', $conf);

            }


        } else {
            $text .= _text_($row);
        }
    }
    return $text;
}

function imagenes_orden_compra($productos_orden_compra)
{

    $imgs = array_column($productos_orden_compra, "url_img_servicio");
    $imagenes_orden_compra = "";
    foreach ($imgs as $row) {

        $seccion_imagen = img(
            [
                "src" => $row,
                "class" => "img_servicio_def p-2",
            ]
        );
        $imagenes_orden_compra = _text_($imagenes_orden_compra, $seccion_imagen);

    }
    return $imagenes_orden_compra;

}

function max_compra($es_servicio, $existencia)
{

    return ($es_servicio == 1) ? 100 : $existencia;

}

function eleccion($titulo, $a, $b, $ext = '')
{

    $response[] = _titulo($titulo, 3);
    $response[] = flex($a, $b, _text_('mt-5 justify-content-between ', $ext));
    return d($response, 'col-md-12 mt-5');
}

function get_orden()
{
    return [
        "ORDENAR POR",
        "LAS NOVEDADES PRIMERO",
        "LO MÁS VENDIDO",
        "LOS MÁS VOTADOS",
        "LOS MÁS POPULARES ",
        "PRECIO  [de mayor a menor]",
        "PRECIO  [de menor a mayor]",
        "NOMBRE DEL PRODUCTO [A-Z]",
        "NOMBRE DEL PRODUCTO [Z-A]",
        "SÓLO  SERVICIO",
        "SÓLO PRODUCTOS"
    ];

}

