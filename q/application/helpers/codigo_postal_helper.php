<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function create_select_colonia($data, $name, $class, $id, $text_option, $val)
    {
        $r[] = "<select name='" . $name . "'  class='" . $class . "'  id='" . $id . "'> ";
        $r[] = "<option value='0'>Seccione </option>";
        foreach ($data as $row) {
            $r[] = "<option value='" . $row[$val] . "'>" . $row[$text_option] . " </option>";
        }
        $r[] = "</select>";
        return append_data($r);
    }

}

