<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mensajeria_mail_marketing
{

	function envia_mail_marketing($param, $data)
	{

		$asunto = $param["asunto"];
		$mensaje = $param["mensaje"];
		$b = 0;
		$data_respuesta = ["Info_email"];
		foreach ($data as $row) {

			$prospecto = trim($row["email"]);
			$data_respuesta[$b]
				= $this->notifica_prospecto(trim($asunto), $mensaje, $prospecto);
			$b++;
		}
		return $data_respuesta;
	}

	function notifica_prospecto($asunto, $mensaje, $prospecto)
	{

		$url_mensaje_leido = "http://enidservice.com/inicio/msj/index.php/api/marketing/mensaje_leido/?email=" . $prospecto;
		$img_mensaje_leido = img([
			"style" => 'display:none;',
			"src" => $url_mensaje_leido
		]);

		$info = $mensaje;
		$info .= $img_mensaje_leido;
		$cuerpo = $info;
		$headers = get_headers_e();

		$estado_enviado = mail(trim($prospecto), '=?UTF-8?B?' . trim($asunto) . '?=', $cuerpo, $headers);

		$info_enviado = 0;
		if ($estado_enviado == true) {
			$info_enviado = 1;
		}

		$data["email_info"] = $info_enviado;
		$data["mensaje_enviado"] = $cuerpo;
		return $data;
	}

}