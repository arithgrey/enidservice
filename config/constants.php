<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);
define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');
define('version_enid', 'v=1.9.1' . rand());
define('ICONV_ENABLED', TRUE);

/**TEXTOS DE VALIDACIÓN*/
define('_text_pass', "Ingresa una contraseña de por lo menos 5 caracteres!");
define('_text_telefono', "Ingresa un teléfono de 8 o 10 caracteres!");
define('_text_horario_entrega', "¿En qué horario te gustaría recibir tu pedido?");
define('_text_correo', 'Hey! no tan rápido, valida tu correo!');
define('_text_cantidad', 'Ups! esta no es una cantidad correcta!');


/*bootstrap class*/
/*col*/

define('_8auto', "col-sm-8 col-sm-offset-2 p-0");
define('_10auto', "col-sm-10 col-sm-offset-1 p-0");

define('_6p', "col-sm-6 p-0");
define('_4p', "col-sm-4 p-0");
define('_12p', "col-sm-12 p-0");


define('_between', 'justify-content-between align-items-center w-100');
define('_between_md', 'justify-content-between align-items-center w-100 text-center');
define('_between_end', 'justify-content-between align-items-end w-100');

define('_mbt5', 'mt-5 mb-5');

/**/
define('_self_center', 'align-self-center');

/*botones*/
define('_registro', 'bg_black p-2 white w-100 text-uppercase cursor_pointer rounded-0 text-center format_action font-weight-bold');

/*textos*/
define('_strong', 'text-uppercase black font-weight-bold');
define('_t1', 'h3 text-uppercase black font-weight-bold');
define('_t2', 'h4 text-uppercase black font-weight-bold');
define('_t3', 'h4 text-uppercase black');
define('_t4', 'h5 text-uppercase black font-weight-bold');
define('_t5', 'h5 text-uppercase black ');


/*icon*/
define('_close_icon', 'fa fa-times');
define('_email_icon', 'fa fa-envelope');
define('_editar_icon', 'fa fa fa-pencil');
define('_tiempo_icon', 'fa fa-clock-o');



