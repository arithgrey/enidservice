<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$autoload['packages'] = array(APPPATH . 'third_party');
$autoload['libraries'] = [
    'user_agent',    
    '../../enid/src/Api/format'
];
$autoload['helper'] = [
    'html',
    'url',
    'date',
    "../../helpers/enid",
    "../../helpers/format_html",
    "../../helpers/costos_pagos",
    "../../helpers/url_personalizada",
    "../../helpers/usuarios_privilegios",
    "form"
];

$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array();
