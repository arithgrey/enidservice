<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Mailrest extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(lib_def());
	}

	function recupera_password_POST()
	{

		$response = false;
		if ($this->input->is_ajax_request()) {
			$param = $this->post();
			if (if_ext($param, "mail")) {
				$param["type"] = 1;
				$response = $this->set_pass($param);

				if ($response["status_send"] == 1) {

					$param["new_pass"] = $response["new_pass"];
					$cuerpo = $this->get_cuerpo($param);
					$request = [
						"para" => $param["mail"],
						"asunto" => "Recuperación password - Enid Service",
						"cuerpo" => $cuerpo

					];
					$response = $this->principal->send_email_enid($request);
				}

			}
		}
		$this->response($response);
	}

	private function get_cuerpo($param)
	{

		$mail = $param["mail"];
		$new_pass = $param["new_pass"];
		$cuerpo = div("Solicitaste la recuperación de tu contraseña Enid Service");
		$cuerpo .= anchor_enid("ACCEDER AHORA", ["href" => 'http://enidservice.com/inicio/login/']);
		$cuerpo .= div("Usuario :  " . $mail);
		$cuerpo .= div("Nueva  password: " . trim($new_pass));
		$cuerpo .= div("Te recomendamos hacer el cambio de tu contraseña al ingresar ");
		return $cuerpo;
	}

	private function set_pass($q)
	{
		$api = "usuario/pass";
		return $this->principal->api($api, $q, 'json', 'PUT');
	}
}