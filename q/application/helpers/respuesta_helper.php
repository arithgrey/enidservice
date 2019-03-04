<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	function verifica_scroll_respuesta($num)
	{
		if ($num > 4) {
			return " scroll_chat_enid ";
		}
	}

	function carga_imagen_usuario_respuesta($id_usuario)
	{
		return "../imgs/index.php/enid/imagen_usuario/" . $id_usuario;
	}

}

