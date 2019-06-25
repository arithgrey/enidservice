<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class desarrollo extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("q");
		$this->load->model("desarrollomodel");
		$this->load->library(lib_def());
	}

	function num_tareas_pendientes_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_departamento,id_usuario")) {
			$num = $this->desarrollomodel->get_tareas_pendientes_usuario($param);


            switch ($num) {
                case ( $num >  5 ):

                    $response = span($num . " " . icon('fa fa-terminal'), 'alerta_pendientes' );

                    break;
                case 0:
                    $response = "";
                    break;

                default:

                    $response = span($num . icon('fa fa-terminal'), 'alerta_pendientes_blue' );
                    break;

            }

		}
		$this->response($response);
	}

	function global_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "fecha_inicio,fecha_termino")) {
			$data["info_global"] = $this->desarrollomodel->get_resumen_desarrollo($param);
			return $this->load->view("desarrollo/global", $data);
		}
		$this->response($response);
	}

	function global_calidad_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "fecha_inicio,fecha_termino")) {
			$data["info_global"] = $this->desarrollomodel->get_comparativa_desarrollo_calidad($param);
			return $this->load->view("desarrollo/global_calidad", $data);
		}
		$this->response($response);
	}

	function comparativas_GET()
	{

		$param = $this->get();
		$response = false;

		if (if_ext($param, "tiempo")) {
			$data["info_global"] = $this->desarrollomodel->get_comparativa_desarrollo($param);
			return $this->load->view("desarrollo/comparativa", $data);
		}
		$this->response($response);
	}

}