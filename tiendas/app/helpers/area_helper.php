<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('invierte_date_time')) {
    function render_user($data)
    {
        
        return d($data["cobro_compra"], 8,1);
    }
}
