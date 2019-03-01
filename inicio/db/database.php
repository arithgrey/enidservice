<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'hostname' => 'backend_developer_db',
	'username' => 'root',
	'password' => 'mysql',
	'database' => 'enidserv_web',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => TRUE,
	'cache_on' => TRUE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
    'port' => 3306
);

