<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {


    function render_historial($data)
    {

        $response = [];
        $actual = 1;
        foreach ($data as $row) {

            $tag = $row['tag'];
            $response[] = flex(_text_($actual, '.-'), $tag, _text_(_between,'mt-2'));
            $actual++;
        }
        return d($response);
    }
}
