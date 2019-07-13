<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Pagina_web extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model("pagina_web_model");
		$this->load->library('table');
		$this->load->library(lib_def());
		$this->id_usuario = $this->app->get_session("idusuario");
	}

	function index_POST()
	{

		$param = $this->post();
		$response = false;
		if (if_ext($param, "q,q2")) {

		    $params = $param["q"];
			if ($param["q2"]== 0) {
				$response = $this->pagina_web_model->insert($params, 1);
			} else {
				$response = $this->pagina_web_model->insert($params, 1, 0, "pagina_web_bot");
			}
		}
		$this->response($response);

	}

	function dia_GET()
	{

		$this->response($this->pagina_web_model->accesos_enid_service());
	}

	function productividad_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "fecha_inicio,fecha_termino")) {

			$fi = $param["fecha_inicio"];
			$ft = $param["fecha_termino"];

			$response  =  [
                "mobile" => $this->pagina_web_model->get_num_field($fi, $ft, "mobile"),
                "is_browser" => $this->pagina_web_model->get_num_field($fi, $ft, "is_browser"),
                "is_mobile" => $this->pagina_web_model->get_num_field($fi, $ft, "is_mobile"),
                "url" => $this->pagina_web_model->get_num_field($fi, $ft, "url"),
                "platform" => $this->pagina_web_model->get_num_field($fi, $ft, "platform"),
                "url_referencia" => $this->pagina_web_model->get_num_field($fi, $ft, "url_referencia")
            ];

			if ($param["v"] == 1) {
				$response = $this->genera_reporte($response);
			}
		}
		$this->response($response);
	}

	private function genera_reporte($param)
	{

		$search = ["mobile", "is_browser", "is_mobile", "url", "platform", "url_referencia"];
		$titulo = ["Movile", "Es browser", "Es mobile", "url", "plataforma", "URL Referencia"];
		$l = "";

		for ($a = 0; $a < count($search); $a++) {

			$this->table->set_heading('#', $titulo[$a]);
			$table = $this->table->generate($param[$search[$a]]);

			$l .= d($table, ["class" => "col-lg-4", "style" => "margin-top:50px!important;"]) . "<hr>";

		}
		return $l;

	}
}