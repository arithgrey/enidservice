<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['base_url']	= '';
$config['index_page'] = 'index.php';
$config['uri_protocol']	= 'AUTO';
$config['url_suffix'] = '';
$config['language']	= '';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['allow_get_array']		= TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger']	= 'c';
$config['function_trigger']		= 'm';
$config['directory_trigger']	= 'd'; // experimental not currently in use
$config['log_threshold'] = 0;
$config['log_path'] 	= "";
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['cache_path'] = '';
$config['encryption_key'] = 'abea8502f19f9d5859ba388f5660e548f1728105';

$config['sess_cookie_name']		= 'ci_session';
$config['sess_expiration']		= 7200;
$config['sess_expire_on_close']	= FALSE;
$config['sess_encrypt_cookie']	= FALSE;
$config['sess_use_database']	= TRUE;
$config['sess_table_name']		= 'ci_sessions';
$config['sess_match_ip']		= FALSE;
$config['sess_match_useragent']	= TRUE;
$config['sess_time_to_update']	= 3000;


$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';

$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;

$config['compress_output'] = FALSE;
$config['global_xss_filtering'] = TRUE;


$config['time_reference'] = 'America/Mexico_City';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';


/*Email*/
$config["senderEmail"] =    [
    'mailpath'     => '/usr/sbin/sendmail',
    'charset'      => 'utf-8',
    'wordwrap'     => TRUE,
    'protocol'     => 'smtp',
    'smtp_host'    => 'ssl://enidservice.com',
    'smtp_port'    => '465',
    'smtp_timeout' => '7',
    'smtp_user'    => 'hola@enidservice.com',
    'smtp_pass'    => 'C~Dz}#[~P*(0',
    'mailtype'     => 'html'

];
$config["barer"]    = "x=0.,!><!$#";