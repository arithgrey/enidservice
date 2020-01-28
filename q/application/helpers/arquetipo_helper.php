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
            $class = _text_(_between, 'mt-2','text-uppercase');
            $response[] = flex(_text_($actual, '.-'), $tag, $class);
            $actual++;
        }
        return d($response);
    }
}
