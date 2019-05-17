<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("puntoencuentro");
		$this->load->library(lib_def());
	}

	function index()
	{


		$data = $this->principal->val_session("");
		$data["clasificaciones_departamentos"] = $this->principal->get_departamentos();
		$param = $this->input->post();
		$data["proceso_compra"] = 1;

		$method_request = $this->input->server('REQUEST_METHOD');
		if (
			($method_request == 'POST'
				&&
				get_param_def($param, "servicio", 0, 1) > 0
			)

			||

			($method_request == 'POST'
				&&
				get_param_def($param, "recibo", 0, 1) > 0
			)

		) {

			$param = $this->input->post();
			$data["tipos_puntos_encuentro"] = $this->get_tipos_puntos_encuentro($param);
			$data["punto_encuentro"] = 0;

			$data = $this->principal->getCSSJs($data, "puntos_medios");

			$primer_registro = (get_param_def($param, "recibo") == 0) ? 1 : 0;
			$data["primer_registro"] = $primer_registro;

			if ($primer_registro > 0) {

				$data["servicio"] = $param["servicio"];
				$data["num_ciclos"] = $param["num_ciclos"];

			} else {
				$data["recibo"] = $param["recibo"];
			}

			$this->load_vistas_punto_encuentro($param, $data);

		} else {

			redirect("../../producto/?producto=" . $this->input->get("producto"));
		}
	}

	private function load_vistas_punto_encuentro($param, $data)
	{

		$data["carro_compras"] =  $param["carro_compras"];
		$data["id_carro_compras"] =  $param["id_carro_compras"];
		$data["leneas_metro"] =  $this->get_lineas_metro( 1);

		if (get_param_def($param, "avanzado", 0, 1) > 0
			&& get_param_def($param, "punto_encuentro", 0, 1)) {

			/*solo tomamos la hora del pedido*/


			$this->principal->show_data_page(
			    $data,
                get_format_pagina_form_horario($data["recibo"], $param["punto_encuentro"]) ,
                1);

		} else {


			$this->principal->show_data_page($data, 'home');
		}
	}

	private function  get_lineas_metro( $tipo){

		$q =  [
			"v" => 1,
			"tipo" =>  $tipo
		];
		$api = "linea_metro/index/format/json/";
		return $this->principal->api($api, $q);

	}
	private function get_tipos_puntos_encuentro($q)
	{

		$api = "tipo_punto_encuentro/index/format/json/";
		return $this->principal->api($api, $q);
	}

}