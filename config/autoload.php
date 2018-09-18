<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$autoload['packages'] 		= array(APPPATH.'third_party');
$autoload['libraries'] 		= ['user_agent' , '../../librerias/restclient'];
$autoload['helper'] 		= 
['html', 'url' , 'date', "../../helpers/enid" ,"form"];

$autoload['config'] 		= array();
$autoload['language'] 		= array();
$autoload['model'] 			= array();
