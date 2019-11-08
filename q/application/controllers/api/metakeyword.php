<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Metakeyword extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->helper("metakeyword");
		$this->load->model("metakeyword_model");
		$this->load->library(lib_def());
		$this->id_usuario = $this->app->get_session("idusuario");
	}

	function gamificacion_search_POST()
	{

		$param = $this->post();
		$response = false;
		if (fx($param, "q,id_usuario")) {

			$params = ["keyword" => $param["q"], "id_usuario" => $param["id_usuario"]];
			$response = $this->metakeyword_model->insert($params);

		}
		$this->response($response);
	}

	function usuario_PUT()
	{

		$param = $this->put();
		$response = false;
		if (fx($param, "metakeyword_usuario,id_usuario")) {
			$response = $this->metakeyword_model->set_metakeyword_usuario($param);
		}
		$this->response($response);

	}

	function registro_POST()
	{

		$param = $this->post();
		$response = false;
		if (fx($param, "q,id_usuario")) {

			$params = [
				"keyword" => $param["q"],
				"id_usuario" => $param["id_usuario"]
			];
			$response = $this->metakeyword_model->insert($params);

		}
		$this->response($response);

	}

	function add_POST()
	{

		$param = $this->post();
		$metakeyword = $this->metakeyword_model->get_metakeyword_catalogo_usuario($param);
        $response =  false;
		if ( es_data($metakeyword) ) {
			$json_meta = $metakeyword[0]["metakeyword"];
			$arr_meta = json_decode($json_meta, true);

			if (!in_array($arr_meta, $param["metakeyword_usuario"])) {

                $e =  fx($param, "metakeyword_usuario,metakeyword,id_usuario");
                $response =  ($e) ? $this->add_metakeyword($param, $arr_meta) : "";

			}

		} else {

			$response =  $this->create($param);
		}

		$this->response($response);
	}

	function add_metakeyword($param, $arr_meta)
	{
        $arr_meta[] =  prm_def($param,"metakeyword_usuario", "");
		$param["metakeyword"] = json_encode($arr_meta);
		return $this->metakeyword_model->update(["metakeyword" => $param["metakeyword"]], ["id_usuario" => $param["id_usuario"]]);
	}

	public function metakeyword_catalogo_GET()
	{

		$param = $this->get();
		$param["id_usuario"] = $this->id_usuario;
		$response = $this->metakeyword_model->get_metakeyword_catalogo_usuario($param);
		if ($param["v"] == 1) {

			$response = catalogo_metakeyword(create_arr_tags($response));

		}
		$this->response($response);

	}

	private function create($param)
	{
		$response = false;
		if (fx($param, "metakeyword_usuario,id_usuario")) {

			$arr[] =  strtoupper($param["metakeyword_usuario"]);
			$meta = json_encode($arr);
			$params = ["metakeyword" => $meta, "id_usuario" => $param["id_usuario"]];
			$response = $this->metakeyword_model->insert($params);
		}
		return $response;
	}
}