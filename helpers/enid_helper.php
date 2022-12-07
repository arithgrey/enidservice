<?php

use App\View\Components\titulo;

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
            (number_format($cantidad * $porciento / 100, $decimales)) : ($cantidad * $porciento / 100);
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
            mt_srand((float)microtime() * 1000000);
            $num = mt_rand(1, count($source));
            $rstr .= $source[$num - 1];
        }
    }

    return $rstr;
}


function site_url($uri = '')
{
    $CI = &get_instance();

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
                'DEBUG' . ' -' . ' TYPE ' . gettype($msg) . ' ' . date($_date_fmt) . ' --> ' . print_r(
                    $msg,
                    true
                ) . "\n";
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

                if (!array_key_exists(
                    trim($keys[$a]),
                    $param
                ) || strlen(trim($param[$keys[$a]])) < $num) {
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
                $temp_array = array_merge(
                    (array)array_slice($temp_array, 0, $offset),
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
    if (preg_match(
        '/^(.*)(\d{3})([^\d]*)(\d{3})([^\d]*)(\d{4})([^\d]{0,1}.*)$/',
        $txt,
        $matches
    )) {
        $result = $format;
        foreach ($matches as $k => $v) {
            $str = preg_match(
                '/\[\$' . $k . '\?(.*?)\:(.*?)\]|\[\$' . $k . '\:(.*?)\]|(\$' . $k . '){1}/',
                $format,
                $filterMatch
            );
            if ($filterMatch) {
                $result = str_replace(
                    $filterMatch[0],
                    (!isset($filterMatch[3]) ? (strlen($v) ? str_replace(
                        '$' . $k,
                        $v,
                        $filterMatch[1]
                    ) : $filterMatch[2]) : (strlen($v) ? $v : (isset($filterMatch[4]) ? '' : (isset($filterMatch[3]) ? $filterMatch[3] : '')))),
                    $result
                );
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
        array_key_exists($k, $data) && is_array($data[$k]) && array_key_exists(
            $sk,
            $data[$k]
        )) ? $data[$k][$sk] : $def;
}

function pr($data, $index, $def = false)
{

    return (is_array($data) && count($data) > 0 && array_key_exists(0, $data) && array_key_exists(
        $index,
        $data[0]
    )) ? $data[0][$index] : $def;
}

function es_null($data, $index, $def = "")
{

    return (is_array($data) && array_key_exists(
        $index,
        $data
    ) && $data[$index] != null) ? $data[$index] : $def;
}

function create_contenido_menu($data)
{

    $navegacion = prm_def($data, "data_navegacion", []);
    $id_empresa = prm_def($data, "id_empresa");
    $menu = [];

    foreach ($navegacion as $row) {

        $path = base_url($row["urlpaginaweb"]) . "/?q=" . $id_empresa;
        $path_web = base_url($row["urlpaginaweb"]);
        $menu[] =
            a_enid(
                icon($row["iconorecurso"]) . $row["nombre"],
                [
                    "href" => ($row["idrecurso"] == 18) ? $path : $path_web,
                    "class" => 'black border-bottom border-dark fp9',
                ]
            );
    }

    return append($menu);
}

function dispositivo()
{

    $tablet_browser = 0;
    $mobile_browser = 0;

    if (preg_match(
        '/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i',
        strtolower($_SERVER['HTTP_USER_AGENT'])
    )) {
        $tablet_browser++;
    }

    if (preg_match(
        '/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i',
        strtolower($_SERVER['HTTP_USER_AGENT'])
    )) {
        $mobile_browser++;
    }

    if ((strpos(
        strtolower($_SERVER['HTTP_ACCEPT']),
        'application/vnd.wap.xhtml+xml'
    ) > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
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
    return format_time(date_format(
        date_create($date),
        _text_('d M Y ', $ext)
    ));
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
        format_link(
            "",
            [
                'class' => _text("fa fa-times ", $ext),
                'id' => $id
            ]
        ),
        'col-xs-2 col-sm-1 ml-auto'
    );
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
    $es_usuario = (is_array($usuario) && array_key_exists('name', $usuario));
    if ($es_usuario) {

        $nombre = $usuario['name'];
        $nombre = (is_null($nombre)) ? '' : $nombre;
        $apellido_paterno = $usuario['apellido_paterno'];
        $apellido_paterno = (is_null($apellido_paterno)) ? '' : $apellido_paterno;
        $response = _text_(
            $nombre,
            $apellido_paterno
        );
    } else {

        if (es_data($usuario)) {
            $nombre = pr($usuario, 'name');
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
function penetracion_alcaldias($data)
{

    $ventas_mes_ubicaciones = $data["ventas_mes_ubicaciones"];
    $response[] = d(_titulo("Alcandías que son tendencia en ventas este mes", 4), 'mt-5 col-sm-12');
    foreach ($ventas_mes_ubicaciones  as $row) {

        $total =  $row["total"];
        $delegacion =  $row["delegacion"];

        $textos = flex($delegacion, $total, _text_(_between, 'border-bottom border-secondary'), "black", "strong f12");
        $response[] = d($textos, 'col-sm-12 mt-2');
    }

    return append($response);
}

function format_adicional_asentamiento_ubicaciones($row)
{

    return d(_text_(
        prm_def($row, 'delegacion', ''),
        prm_def($row, 'asentamiento', ''),
    ), 'strong  blue_enid mt-3 mb-5 col-lg-12 text-right');
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
function footer_opciones()
{

    $productos_footer[] = _titulo('Productos', 2,'border_b_green');

    $productos_footer[] = a_enid(
        'Descuentos',
        [
            'href' => path_enid('promociones'),
            'class' => 'black fp9'
        ]
    );

    $productos_footer[] = a_enid(
        'Novedades',
        [
            "href" => path_enid("search", "/?q2=0&q=&order=1"),
            'class' => 'black fp9'
        ]
    );

    $productos_footer[] = a_enid(
        'Populares',
        [
            "href" => path_enid("search", "/?q2=0&q=&order=2&order=4"),
            'class' => 'black fp9'
        ]
    );



    /*Asistencia*/
    $asistencia[] =  _titulo('Asistencia', 2,'border_b_green');

    $asistencia[] =  a_enid(
        '¿Necesitas ayuda?',
        [
            'href' => path_enid('whatsapp_ayuda', 0, 1),
            'class' => 'black fp9',
            'target' => '_black'
        ]
    );


    $asistencia[] =  a_enid(
        'Pago',
        [
            'href' => path_enid('forma_pago'),
            'class' => 'black fp9',
            'target' => '_black'
        ]
    );
    $asistencia[] =  a_enid(
        'Envío',
        [
            'href' => path_enid('envio'),
            'class' => 'black fp9',
            'target' => '_black'
        ]
    );


    $asistencia[] =  a_enid(
        'Clientes',
        [
            'href' => path_enid('clientes'),
            'class' => 'black fp9',
            'target' => '_black'
        ]
    );
    $asistencia[] =  a_enid(
        '¿Costo de entrega?',
        [
            'href' => path_enid('costo_entrega'),
            'class' => 'black fp9',
            'target' => '_black'
        ]
    );
    /**Oportunidades*/

  
    $oportunidades[] = _titulo('Oportunidades', 2,'border_b_green');
    
    $anuncio_mayorista[] = d('Mayoristas',"black strong");
    $oportunidades[] = a_enid(
        d($anuncio_mayorista),
        [            
            'class' => 'black fp9 borde_green mt-2 p-3 mayoristas_enid',
            "onclick" => "log_operaciones_externas(49)",
        ]
    );
    $oportunidades[] = a_enid(
        'Programa de afiliados',
        [
            'href' => path_enid('sobre_vender'),
            'class' => 'black fp9 mt-3 borde_black p-2 strong'
        ]
    );


    $oportunidades[] = a_enid(
        d("Calculador de ganancias"," strong"),
        [            
            'class' => 'black fp9 borde_amarillo mt-2 p-3 ',
            "href" => path_enid('simulador')
            
        ]
    );



    $anuncio[] = d('¿Vendes artículos?',"black strong");
    $anuncio[] = d('Anúnciate aquí!');
    
    $oportunidades[] = a_enid(
        d($anuncio),
        [            
            'class' => 'black fp9 borde_black mt-2 p-3 anuncio_negocio_enid_service',
            "onclick" => "log_operaciones_externas(49)",
        ]
    );

    $auto[]= d('¿Vendes tu auto?','strong black');
    $auto[]= d('Nosotros te ayudamos!');
    $oportunidades[] = a_enid(
        append($auto)
        ,
        [
            
            'class' => 'black fp9 mt-3 borde_green p-3 vende_tu_auto',
            "onclick" => "log_operaciones_externas(50)",
        ]
    );
   

    $oportunidades[] = a_enid(
        d('¿Necesitas una página web?','strong black'),
        [
            'href' => path_enid('sobre_pagina_web'),
            'class' => 'black fp9 borde_end mt-3',
            "onclick" => "log_operaciones_externas(47)",
        ]
    );
    
   
    



    $sociales[] = _titulo('SÍGUENOS', 2,'border_b_green');
    $sociales[] = a_enid(
        icon(_text_(_facebook_icon, 'fa-2x')),
        [
            'href' => path_enid('facebook', 0, 1),
            'target' => 'black',
            'class' => 'ml-5 click_facebook_clientes'
        ]
    );
    $sociales[] = a_enid(
        icon(_text_(_instagram_icon, 'fa-2x')),
        [
            'href' => path_enid('instagram', 0, 1),
            'target' => 'black',
            'class' => 'ml-5 mt-3 click_instagram_clientes'
        ]
    );

    $sociales[] = a_enid(
        icon(_text_(_pinterest_icon, 'fa-2x')),
        [
            'href' => path_enid('pinterest', 0, 1),
            'target' => 'black',
            'class' => 'ml-5 mt-3 click_pinterest_clientes'
        ]
    );


    $seccion_productos =  d($productos_footer, 3);
    $asistencia_seccion = d($asistencia, 3);
    $oportunidades_seccion = d($oportunidades, 3);
    $sociales_seccion = d($sociales, 3);

    return d([
        $oportunidades_seccion,
        $seccion_productos,
        $asistencia_seccion,        
        $sociales_seccion
    ], 8, 1);
}
function getRealIPAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function modal_prueba_en_casa()
{
    $contenido[] = d(_titulo('prueba en casa', 4),'borde_end_b ');
    $contenido[] = d('Así funciona:','mt-2 f12 black');


    $paso[]  = d('<svg xmlns="http://www.w3.org/2000/svg" 
    fill="none" 
    viewBox="0 0 24 24" 
    stroke-width="1.5" 
    stroke="currentColor" 
    class="w-6 h-6 black">
    <path stroke-linecap="round" 
    stroke-linejoin="round" 
    d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
  </svg>
  ');
    $paso[]  = d('1', 'strong f2');
    $paso[]  = d('Elige 3 artículos de tu interés', 'f11 black');

    $response[] = d($paso, 'col-xs-3 text-center mt-5');

    /**/
    $paso_2[]  = d('<svg xmlns="http://www.w3.org/2000/svg" 
    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 black">
    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
  </svg>  
  ');
    $paso_2[]  = d('2', 'strong f2');
    $paso_2[]  = d('Nos dices donde te los llevamos', 'f11 black');

    $response[] = d($paso_2, 'col-xs-3 text-center mt-5');

    /*----------- */

    $paso_3[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none"
      viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 black">
     <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
   </svg>
   
   ');
    $paso_3[]  = d('3', 'strong f2');
    $paso_3[]  = d('Te avisamos ya que estemos de camino', 'f11 black');

    $response[] = d($paso_3, 'col-xs-3 text-center mt-5');




    /**/

    $paso_4[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none" 
     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="black w-6 h-6">
     <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
   </svg>   
   ');
    $paso_4[]  = d('4', 'strong f2');
    $paso_4[]  = d('Elige si te quedas con 1, 2 o los 3!', 'f11 black');

    $response[] = d($paso_4, 'col-xs-3 text-center mt-5');

    $contenido[] =  d($response, 13);

    $link =  d(format_link("Checa nuestro catálogo",['href' => path_enid("search_q3")]),6,1);
    $contenido[] =  d($link, "row mt-5");

    return gb_modal($contenido, 'modal_prueba_en_casa');
}
function modal_anuncio_negocio()
{
    $contenido[] = d(_titulo('Anuncia tus artículos en Enid Service', 4),'borde_end_b ');
    $contenido[] = d('Así funciona:','mt-2 f12 black');

    $paso[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
  </svg>
  
  ');
    $paso[]  = d('1', 'strong f2');
    $paso[]  = d('Nos envías tu catálogo', 'f11 black');

    $response[] = d($paso, 'col-xs-3 text-center mt-5');

    /**/
    $paso_2[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
  </svg>
  
  ');
    $paso_2[]  = d('2', 'strong f2');
    $paso_2[]  = d('Aprobamos tu solicitud', 'f11 black');

    $response[] = d($paso_2, 'col-xs-3 text-center mt-5');

    /*----------- */

    $paso_3[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  
   
   ');
    $paso_3[]  = d('3', 'strong f2');
    $paso_3[]  = d('Encontramos al cliente ideal', 'f11 black');

    $response[] = d($paso_3, 'col-xs-3 text-center mt-5');

    /**/

    $paso_4[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  
   ');
    $paso_4[]  = d('4', 'strong f2');
    $paso_4[]  = d('Vendemos tus artículos por un 10% del total de la venta', 'f11 black');

    $response[] = d($paso_4, 'col-xs-3 text-center mt-5');

    $contenido[] =  d($response, 13);


    $link = format_link(
        "Envía tu catálogo",
        [
            "href" => path_enid('facebook_descuento', 0, 1),
            "class" => "white facebook_trigger p-2 borde_amarillo bg_black p-1  mt-3",
            "onclick" => "log_operaciones_externas(47)",
            "target" => "_black"
        ]
    );


    if(is_mobile()){

        $link =  format_link("Dime cual es tu catálogo",
        [
            'href' => path_enid("whatsapp_productos",0,1),
            "onclick" => "log_operaciones_externas(47)",
        ]);
    }

    $contenido[] =  d(d($link,6,1), "row mt-5");

    $contenido[] = d("Mándanos un WhatsApp:  +52 55 5296-7027",
    'mt-3 mb-3 text-center red_enid strong');

    return gb_modal($contenido, 'modal_anuncio_negocio');
}
function modal_mayoristas()
{
    $contenido[] = d(_titulo('¡Es momento de
    reinventarse y mejorar
    para no quedarse en el
    camino!', 4),'borde_end_b ');
    $contenido[] = d('¡Te ayudamos en tu proyecto!','mt-2 f12 black');

    $paso[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none" 
    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="black w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
  </svg>
  
  ');
    $paso[]  = d('1', 'strong f2');
    $paso[]  = d(_text_('Accede a un producto que',span('se vende sin importar el día del año','strong')), 'f11 black');

    $response[] = d($paso, 'col-xs-6 text-center mt-5');

    /**/
    $paso_2[]  = d('<svg xmlns="http://www.w3.org/2000/svg" 
    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
    class="black w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" 
    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
  </svg>  ');
    $paso_2[]  = d('2', 'strong f2');
    $paso_2[]  = d(
        _text_('¡Obtén ',span('margenes','strong'),'muy', span('atractivos','strong'),'de ganancia sobre tu inversión! ')
        , 'f11 black');

    $response[] = d($paso_2, 'col-xs-6 text-center mt-5');

    /*----------- */

    $paso_3[]  = d('<svg xmlns="http://www.w3.org/2000/svg" 
    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
    class="black w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
  </svg>
  
  
   
   ');
    $paso_3[]  = d('3', 'strong f2');
    $paso_3[]  = d(_text_('Accede a uno de los sectores de',span('mayor demanda','strong'), 'a partir del la pandemia de la COVID-19'), 'f11 black');

    $response[] = d($paso_3, 'col-xs-6 text-center mt-5');

    /**/

    $paso_4[]  = d('<svg xmlns="http://www.w3.org/2000/svg" 
    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
    class="black w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  
   ');
    $paso_4[]  = d('4', 'strong f2');
    $paso_4[]  = d(_text_('Ten la posibilidad de que te conectemos a',span('nuestra red de clientes','strong')), 'f11 black');

    $response[] = d($paso_4, 'col-xs-6 text-center mt-5');

    
    $contenido[] =  d($response, 13);


    $link = format_link(
        "Escríbenos! (55) 5296-7027",
        [
            "href" => path_enid('whatsapp_mayorista', 0, 1),
            "class" => "white facebook_trigger p-2 borde_amarillo bg_black p-1  mt-3",
            "onclick" => "log_operaciones_externas(51)",
            "target" => "_black"
        ]
    );

    if(is_mobile()){

        $link =  format_link("Escríbenos!",
        [
            'href' => path_enid("whatsapp_mayorista",0,1),
            "onclick" => "log_operaciones_externas(51)"
        ]);
    }

    $contenido[] =  d(d($link,6,1), "row mt-5");
    $contenido[] = d("Mándanos un WhatsApp:  +52 55 5296-7027",
    'mt-3 mb-3 f12 borde_end_b text-center red_enid strong');
    $contenido[] =  img(create_url_preview("back_experiencia.jpg"));
    return gb_modal($contenido, 'modal_mayoristas');
}



function modal_venta_auto()
{
    $contenido[] = d(_titulo('Vendemos tu auto en menos de 30 días', 4),'borde_end_b ');
    $contenido[] = d('Así funciona:','mt-2 f12 black');


    $paso[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
  </svg>
  
  ');
    $paso[]  = d('1', 'strong f2');
    $paso[]  = d('Nos Indicas las especificaciones de tu auto', 'f11 black');

    $response[] = d($paso, 'col-xs-3 text-center mt-5');

    /**/
    $paso_2[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.678 48.678 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
  </svg>
  
  ');
    $paso_2[]  = d('2', 'strong f2');
    $paso_2[]  = d('Aprobamos tu solicitud', 'f11 black');

    $response[] = d($paso_2, 'col-xs-3 text-center mt-5');

    /*----------- */

    $paso_3[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  
   
   ');
    $paso_3[]  = d('3', 'strong f2');
    $paso_3[]  = d('Encontramos al cliente ideal', 'f11 black');

    $response[] = d($paso_3, 'col-xs-3 text-center mt-5');




    /**/

    $paso_4[]  = d('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  
   ');
    $paso_4[]  = d('4', 'strong f2');
    $paso_4[]  = d('Vendemos tu auto! con todas las medidas de seguridad', 'f11 black');

    $response[] = d($paso_4, 'col-xs-3 text-center mt-5');

    $contenido[] =  d($response, 13);

    
    $link = format_link(
        "Dime cual es tu auto",
        [
            "href" => path_enid('facebook_descuento', 0, 1),
            "class" => "white facebook_trigger p-2 borde_amarillo bg_black p-1  mt-3",
            "onclick" => "log_operaciones_externas(47)",
            "target" => "_black"
        ]
    );
    if(is_mobile()){

        $link =  format_link("Dime cual es tu auto",
        [
            'href' => path_enid("whatsapp_autos",0,1),
            "onclick" => "log_operaciones_externas(47)"
        ]);

    }

    $contenido[] =  d(d($link,6,1), "row mt-5");
    $contenido[] = d("Mándanos un WhatsApp:  +52 55 5296-7027",
    'mt-3 mb-3 text-center red_enid strong');


    return gb_modal($contenido, 'modal_venta_auto');
}

