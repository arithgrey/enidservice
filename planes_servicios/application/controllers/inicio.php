<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("planes");
		$this->load->library(lib_def());
		$this->principal->acceso();
	}

	function index()
	{

		$param = $this->input->get();
		$data = $this->principal->val_session();
		$data["action"] = valida_action($param, "action");
		$data["considera_segundo"] = 0;
		$data["extra_servicio"] = 0;
		$data = $this->prevenir_acceso($param, $data);
		$id_usuario = $data["id_usuario"];

		$msj = get_param_def($param, "mensaje", "");
		$data["error_registro"] = valida_extension($msj, 5, "");
		$data["top_servicios"] = $this->get_top_servicios_usuario($id_usuario);
		$data["ciclo_facturacion"] = $this->create_ciclo_facturacion();
		$data["clasificaciones_departamentos"] = "";
		$data["is_mobile"] = ($this->agent->is_mobile() === FALSE) ? 0 : 1;


		$data = $this->principal->getCssJs($data, "planes_servicios");

		$data["list_orden"] = $this->get_orden();
        $data["id_perfil"] = $this->principal->getperfiles();
		$this->principal->show_data_page($data, 'home_enid');

	}
	private function prevenir_acceso($param, $data)
	{


		if ($data["action"] == 2) {

			$data["considera_segundo"] = 1;
			if (ctype_digit($param["servicio"]) && $data["in_session"] === 1 && $data["id_usuario"] > 0) {

				$param["id_usuario"] = $data["id_usuario"];
				$param["id_servicio"] = $param["servicio"];
				$es_usuario = $this->valida_servicio_usuario($param);
				if ($es_usuario != 1 ) {
				    if($data["id_perfil"] == 20 ){
                        $this->principal->logout();
                    }
				}
				$data["extra_servicio"] = $param["servicio"];
			} else {
				$this->principal->logout();
			}
		}
		return $data;
	}

	private function valida_servicio_usuario($q)
	{

		$api = "servicio/es_servicio_usuario/format/json/";
		return $this->principal->api($api, $q);
	}

	private function get_top_servicios_usuario($id_usuario)
	{

		$q["id_usuario"] = $id_usuario;
		$api = "servicio/top_semanal_vendedor/format/json/";
		return $this->principal->api($api, $q);
	}

	private function get_orden()
	{
		$response = ["Las novedades primero",
			"Lo     más vendido",
			"Los más votados",
			"Los más populares ",
			"Precio [de mayor a menor]",
			"Precio [de menor a mayor]",
			"Nombre del producto [A-Z]",
			"Nombre del producto [Z-A]",
			"Sólo servicios",
			"Sólo productos"
		];
		return $response;
	}

	private function create_ciclo_facturacion( $q = [] )
	{


		$api = "ciclo_facturacion/not_ciclo_facturacion/format/json/";
		return $this->principal->api($api, $q);
	}
}