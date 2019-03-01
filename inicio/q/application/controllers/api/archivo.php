<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Archivo extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model("img_model");
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->library(lib_def());
		$this->id_usuario = $this->principal->get_session("idusuario");
	}

	function extension($str)
	{
		$str = implode("", explode("\\", $str));
		$str = explode(".", $str);
		$str = strtolower(end($str));
		return $str;
	}

	function imgs_POST()
	{
		$config['upload_path'] = APPPATH . '../../img_tema/productos/';
		$config['allowed_types'] = "*";
		$config['max_size'] = 3500;
		$config['max_width'] = 4024;
		$config['max_height'] = 7680;
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('imagen')) {

			$error['error'] = $this->upload->display_errors();
			$this->response($error);

		} else {
			$nombre_imagen = $this->upload->file_name;
			$upload_data = $this->upload->data();
			$image_width = $upload_data["image_width"];
			$image_height = $upload_data["image_height"];
			$nuevo_width = (int)porcentaje($image_width, 70, 0, 0);
			$nuevo_height = (int)porcentaje($image_height, 70, 0, 0);
			$source_image = $this->upload->upload_path . $nombre_imagen;


			$config_resizing['maintain_ratio'] = TRUE;
			$config_resizing['width'] = $nuevo_width;
			$config_resizing['height'] = $nuevo_height;


			$config_resizing['image_library'] = 'gd2';
			$config_resizing['source_image'] = $source_image;
			$this->image_lib->initialize($config_resizing);


			$param = $this->post();
			$param["nombre_archivo"] = $nombre_imagen;
			$param["extension"] = $upload_data["file_ext"];
			$param["imagenBinaria"] = $source_image;
			$response = $this->gestiona_imagenes($param);
			if (!$this->image_lib->resize()) {
				$response["error"] = $this->image_lib->display_errors('', '');
			}
			$this->response($response);
		}
	}

	function gestiona_imagenes($param)
	{

		$param["id_empresa"] = $this->principal->get_session("idempresa");
		$param["id_usuario"] = $this->id_usuario;
		$param["id_usuario"] = $this->id_usuario;


		switch ($param["q"]) {
			case 'faq':

				$response = $this->img_model->insert_img_faq($param);
				return $this->response_status_img($response);
				break;


			case 'perfil_usuario':

				return $this->create_perfil_usuario($param);
				break;

			case 'servicio':
				return $this->create_imagen_servicio($param);
				break;


			default:
				return "";
				break;
		}
	}

	function response_status_img($status)
	{
		$response = "Error al cargar la image";
		if ($status == 1) {
			$response = "Imagen guardada .!";
		}
		return $response;
	}

	function notifica_producto_imagen($q)
	{
		$api = "servicio/status_imagen/format/json/";
		return $this->principal->api($api, $q, "json", "PUT");
	}

	function insert_imagen_servicio($q)
	{

		$api = "imagen_servicio/index";
		return $this->principal->api($api, $q, "json", "POST");
	}

	function create_imagen_usuario($q)
	{

		$api = "imagen_usuario/index";
		return $this->principal->api($api, $q, "json", "POST");
	}

	private function create_perfil_usuario($param)
	{

		$id_imagen = $this->img_model->insert_img($param, 1);
		if ($id_imagen > 0 && $this->id_usuario > 0) {
			$prm["id_imagen"] = $id_imagen;
			$prm["id_usuario"] = $this->id_usuario;
			return $this->create_imagen_usuario($prm);
		}
	}

	private function create_imagen_servicio($param)
	{

		$response = [];
		if ($param["id_usuario"] > 0) {
			$existen = "nombre_archivo,id_usuario,id_empresa,imagenBinaria,extension,servicio";
			if (if_ext($param, $existen)) {
				$id_imagen = $this->img_model->insert_img($param, 1);

				if ($id_imagen > 0) {

					$prm["id_imagen"] = $id_imagen;
					$prm["id_servicio"] = $param["servicio"];
					$response["status_imagen_servicio"] = $this->insert_imagen_servicio($prm);
					if ($response["status_imagen_servicio"] == true) {
						$prm["existencia"] = 1;
						$response["status_notificacion"] = $this->notifica_producto_imagen($prm);
					}
					$response["status_notificacion"] = 2;
				}
				return $response;
			}
			$response["params_error"] = 1;
			return $response;
		}
		$response["session_exp"] = 1;
		return $response;
	}
	/*
	function imgs_POST(){

		$param          =   $this->post();
		$extensiones    =   ["jpg","jpeg","gif","png","bmp","image/jpg","image/jpeg","image/gif","image/png"];

		if($_FILES['imagen']['error'] === 4) {
			$this->response( false);

		}else if($_FILES['imagen']['error'] === 0 ){

			$this->proceso_registro_imagen($param, $extensiones);

		} else if($_FILES['imagen']['error'] === 1 ){
			$this->response(2);
		}
	}
	private function proceso_registro_imagen($param , $extensiones){

		$binario                =   addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
		$nombre                 =   $_FILES['imagen']['name'];
		$extension              =   $this->extension($nombre);

		if(!in_array($extension, $extensiones)) {
			$msj =  'Sólo se permiten archivos con las siguientes extensiones: ';
			$this->response( $msj.implode(', ', $extensiones) );
		}
		$param["imagenBinaria"]   =   $binario;
		$param["nombre_archivo"]  =   $nombre;
		$param["extension"]       =   $extension;
		$this->response($this->gestiona_imagenes($param));
	}
	*/

}