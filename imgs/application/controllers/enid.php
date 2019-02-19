<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Enid extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("img_model");
		$this->load->library(lib_def());
	}

	function imagen($id_imagen)
	{

		$img = $this->get_img($id_imagen);
		if (count($img) > 0) {
			$this->get_img_contents($img[0]);
		}
	}

	function get_img_contents($data)
	{

		$path = "http://" . $_SERVER['HTTP_HOST'] . "/inicio/img_tema/productos/" . $data["nombre_imagen"];
		return $this->output->set_content_type('png')->set_output(file_get_contents($path));

	}

	function imagen_usuario($id_usuario)
	{

		return $this->construye_img_format($this->get_img_usuario($id_usuario));
	}

	function construye_img_format($response)
	{

		if (count($response) > 0) {

			$id_imagen = $response[0]["id_imagen"];
			$data = $this->costruye_imagen($id_imagen);
			return $this->get_img_contents($data);
		}
	}

	function costruye_imagen($id_imagen)
	{

		foreach ($this->get_img($id_imagen) as $row) {
			return $row;
		}
	}

	function imagen_servicio($id_servicio)
	{
		$imagen = $this->get_img_servicio($id_servicio);
		if (is_array($imagen) && count($imagen) > 0) {
			return $this->construye_img_format($imagen);
		}
	}

	function get_img($id_imagen)
	{

		return $this->img_model->q_get(["nombre_imagen"], $id_imagen);
	}

	function get_img_usuario($id_usuario)
	{

		$q["id_usuario"] = $id_usuario;
		$api = "imagen_usuario/usuario/format/json/";
		return $this->principal->api($api, $q);
	}

	function get_img_servicio($id_servicio)
	{

		$q["id_servicio"] = $id_servicio;
		$q["limit"] = 1;
		$api = "imagen_servicio/servicio/format/json/";
		return $this->principal->api($api, $q);
	}
}