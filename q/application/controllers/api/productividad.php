<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class productividad extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("q");
		$this->load->model("productividad_usuario_model");
		$this->load->library(lib_def());
	}

	function notificaciones_GET()
	{

		$param = $this->get();
		$id_usuario = $this->principal->get_session('idusuario');
		$param["id_perfil"] = $this->principal->getperfiles();
		$param["id_usuario"] = $id_usuario;
		$response["objetivos_perfil"] = $this->get_objetivos_perfil($param);
		$response["productos_anunciados"] = $this->valida_producto_anunciado($param);
		$response["flag_direccion"] = $this->verifica_direccion_registrada_usuario($param);
		$response["info_notificaciones"] = $this->get_notificaciones_usuario_perfil($param);
		$response["id_perfil"] = $param["id_perfil"];


		$id_perfil = $param["id_perfil"];
		$prm["modalidad"] = 1;
		$prm["id_usuario"] = $id_usuario;
		$response["id_usuario"] = $id_usuario;
		$response["info_notificaciones"]["numero_telefonico"] = $this->verifica_registro_telefono($prm);
		$response["preguntas"] =  $this->get_preguntas($id_usuario);
		$response["respuestas"] =  $this->get_respuestas($id_usuario);
        $response["compras_sin_cierre"] = $this->pendientes_ventas_usuario($id_usuario);
        $response["recibos_sin_costos_operacion"] = $this->get_scostos($id_usuario);
        $response["tareas"] = $this->get_tareas($id_usuario);


		switch ($id_perfil) {

			case 3:

				$response["recordatorios"] = $this->get_recordatorios($id_usuario);
				$response["ventas_enid_service"] = $this->get_ventas_enid_service();
				$response = get_tareas_pendienetes_usuario($response);

				break;

			case 20:

				$response = get_tareas_pendienetes_usuario_cliente($response);

				break;
			default:
				break;
		}

		$this->response($response);

	}
	private function get_respuestas($id_usuario){

		$q["id_usuario"] =  $id_usuario;
		$q["se_lee"] =  0;
		$q["se_ve_cliente"] = 0;
		$api = "pregunta/cliente/format/json/";
		return $this->principal->api($api, $q);

	}
	private function get_preguntas($id_vendedor){

		$q["id_vendedor"] =  $id_vendedor;
		$q["se_responde"] =  0;
		$api = "pregunta/vendedor/format/json/";
		return $this->principal->api($api, $q);

	}
	private function get_objetivos_perfil($q)
	{

		$api = "objetivos/perfil/format/json/";
		return $this->principal->api($api, $q);
	}

	private function valida_producto_anunciado($q)
	{
		$api = "servicio/num_anuncios/format/json/";
		return $this->principal->api($api, $q);
	}

	private function verifica_direccion_registrada_usuario($q)
	{

		$api = "usuario_direccion/num/format/json/";
		return $this->principal->api($api, $q);
	}

	function get_notificaciones_usuario_perfil($param)
	{

		$id_perfil = $param["id_perfil"];
		$data_complete["perfil"] = $id_perfil;
		$param["id_perfil"] = $id_perfil;

		$data_complete["id_usuario"] = $param["id_usuario"];
		$data_complete["adeudos_cliente"] = $this->get_adeudo_cliente($param);
		$data_complete["valoraciones_sin_leer"] = $this->get_num_lectura_valoraciones($param);
		$data_complete["id_perfil"] = $id_perfil;
		switch ($id_perfil) {
			case 3:


				$data_complete["email_enviados_enid_service"] = $this->email_enviados_enid_service();
				$data_complete["accesos_enid_service"] = $this->accesos_enid_service();
				$data_complete["tareas_enid_service"] = $this->tareas_enid_service()[0]["num_pendientes_desarrollo"];
				$data_complete["num_pendientes_direccion"] = $this->tareas_enid_service()[0]["num_pendientes_direccion"];

				break;

			case 4:

				$data_complete["email_enviados_enid_service"] = $this->email_enviados_enid_service();
				$data_complete["accesos_enid_service"] = $this->accesos_enid_service();
				$data_complete["tareas_enid_service"] = $this->tareas_enid_service()[0]["num_pendientes_desarrollo"];

				break;

			default:

				break;
		}
		return $data_complete;
	}

	private function get_adeudo_cliente($q)
	{
		$api = "recibo/deuda_cliente/format/json/";
		return $this->principal->api($api, $q);
	}

	private function get_num_lectura_valoraciones($q)
	{
		$api = "servicio/num_lectura_valoraciones/format/json/";
		return $this->principal->api($api, $q);
	}

	private function email_enviados_enid_service()
	{

		$q["info"] = 1;
		$api = "prospecto/dia/format/json/";
		return $this->principal->api($api, $q);

	}

	private function accesos_enid_service()
	{

		$q["info"] = 1;
		$api = "pagina_web/dia/format/json/";
		return $this->principal->api($api, $q);
	}

	private function tareas_enid_service()
	{

		$q["info"] = 1;
		$api = "tarea/tareas_enid_service/format/json/";
		return $this->principal->api($api, $q);
	}

	private function verifica_registro_telefono($q)
	{

		$api = "usuario/verifica_registro_telefono/format/json/";
		return $this->principal->api($api, $q);
	}

	function get_recordatorios($id_usuario)
	{

		$q["id_usuario"] = $id_usuario;
		$api = "recordatorio/usuario/format/json/";
		return $this->principal->api($api, $q);

	}

	private function pendientes_ventas_usuario($id_usuario)
	{
		$q["id_usuario"] = $id_usuario;
		$api = "recibo/pendientes_sin_cierre/format/json/";
		$response =   $this->principal->api($api, $q);
		$response =  $this->principal->get_imagenes_productos(0, 1 , 1 , 1, $response);
		return $response;

	}

	private function get_ventas_enid_service()
	{

		$q["fecha"] = 1;
		$api = "recibo/dia/format/json/";
		return $this->principal->api($api, $q);
	}

    private function get_scostos($id_usuario)
    {

        $q["id_usuario"] =  $id_usuario;
        $api = "costo_operacion/scostos/format/json/";
        return $this->principal->api($api, $q);

    }
    function  get_tareas($id_usuario){

        $q["id_usuario"] =  $id_usuario;
        $api = "tickets/pendientes/format/json/";
        return $this->principal->api($api, $q);
    }

}