<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Imagen_usuario extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("imagen_usuario_model");
		$this->load->library(lib_def());
	}

	function usuario_GET()
	{
		$param = $this->get();
		$response = false;
		if (fx($param, "id_usuario")) {
			$response = $this->imagen_usuario_model->get_img_usuario($param["id_usuario"]);
		}
		$this->response($response);
	}

	function index_POST()
	{

		$param = $this->post();
		$response = false;
		if (fx($param, "id_imagen,id_usuario")) {
			if ($this->delete_usuario($param) == 1) {

				$params = [
					"id_imagen" => $param["id_imagen"],
					"idusuario" => $param["id_usuario"]
				];
				$response = $this->imagen_usuario_model->insert($params);
			}
		}
		$this->response($response);
	}

	private function delete_usuario($param)
	{


	    if (es_data($param) && prm_def($param, "id_usuario") > 0 ){

            $in = ["id" => $param["id_usuario"]];
            $imagenes = $this->imagen_usuario_model->get(["id_imagen"], $in, 10);
            foreach ($imagenes as $row) {

                $this->imagen_usuario_model->delete($in, 10);
                $this->delete_imagen($row["id_imagen"]);
            }
        }

		return 1;
	}

	private function delete_imagen($id_imagen)
	{

		$q["id_imagen"] = $id_imagen;
		return $this->app->api("img/index", $q, "json", "DELETE");
	}

	function img_perfil_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "fecha_inicio,fecha_termino")) {
			$response = $this->imagen_usuario_model->img_perfil($param);
		}
		$this->response($response);
	}

}