<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render($data)
    {

        $response = $data["kits"];
        return d($response,10,1);
    }
    

    
}
