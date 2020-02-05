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
define('_text_pago', 'Ups! el monto no es correcto, la cantidad a pagar es');


/*bootstrap class*/
/*col*/
define('_4auto', "col-sm-4 col-sm-offset-4 row");
define('_6auto', "col-sm-6 col-sm-offset-3 row");
define('_8auto', "col-sm-8 col-sm-offset-2 row");
define('_10auto', "col-sm-10 col-sm-offset-1 row");

define('_6p', "col-sm-6 p-0");
define('_4p', "col-sm-4 p-0");
define('_5p', "col-sm-5 p-0");
define('_7p', "col-sm-7 p-0");
define('_8p', "col-sm-8 p-0");
define('_12p', "col-sm-12 p-0");

define('_2_12', "col-sm-12 col-md-2");
define('_10_12', "col-sm-12 col-md-10");

define('_4', "col-sm-4");
define('_6', "col-sm-6");
define('_8', "col-sm-8");
define('_12', "col-sm-12");


define('_between', 'justify-content-between align-items-center w-100');
define('_between_md', 'justify-content-between align-items-center w-100 text-center');
define('_between_end', 'justify-content-between align-items-end w-100');
define('_flex_right', 'justify-content-end');


define('_mbt5', 'mt-5 mb-5');
define('_mbt5_md', 'mt-5 mb-5 mt-md-0 mb-md-0');

/**/
define('_self_center', 'align-self-center');

/*botones*/
define('_registro', 'bg_black p-2 white w-100 text-uppercase cursor_pointer rounded-0 text-center format_action font-weight-bold');

/*textos*/
define('_strong', 'text-uppercase black font-weight-bold');
define('_t1', 'h3 text-uppercase black font-weight-bold');
define('_t2', 'h4 text-uppercase black font-weight-bold');
define('_t3', 'h4 text-uppercase black');
define('_t4', 'h4 text-uppercase black font-weight-bold');
define('_t5', 'h5 text-uppercase black ');


/*icon*/
define('_close_icon', 'fa fa-times');
define('_email_icon', 'fa fa-envelope');
define('_editar_icon', 'fa fa fa-pencil');
define('_money_icon', 'fa fa-money');
define('_historia_icon', 'fa fa-history');
define('_tiempo_icon', 'fa fa-clock-o');
define('_eliminar_icon', 'fa fa-times');
define('_delivery_icon', 'fa fa-fighter-jet');
define('_share_icon', 'fa fa-share');
define('_bomb_icon', 'fa fa-bomb');

