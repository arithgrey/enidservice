<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mensajeria
{

	function notifica_agradecimiento_contacto($param)
	{

		$nombre = $param["nombre"];
		$email_contacto = $param["email"];
		$destinatario = "ventas@enidservices.com";
		$asunto = "Gracias por contactarte " . $nombre;
		$info = $this->get_mensaje_base_agradecimiento();

		$cuerpo = "<html>";
		$cuerpo .= "<meta charset='utf-8' >";
		$cuerpo .= d("Excelente día  " . $email_contacto . " - " . $nombre);
		$cuerpo .= d($info);
		$cuerpo .= "</html>";

		$headers = get_headers_e($email_contacto);
		mail($destinatario, '=?UTF-8?B?' . base64_encode($asunto) . '?=', $cuerpo, $headers);
		return $cuerpo;

	}

	function get_mensaje_base_agradecimiento()
	{

		$cuerpo = h("Gracias por contactarse!");
		$cuerpo .= h("A la brevedad nos pondremos en contacto", 2);
		return $cuerpo;
	}
}