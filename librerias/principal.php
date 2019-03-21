<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class principal extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('../../librerias/sessionclass');
	}

	function api($api, $q = [], $format = 'json', $type = 'GET', $debug = 0, $externo = 0, $b = "")
	{

		if ($externo == 0) {
			$url = "q/index.php/api/";
		} else {
			$url = $b . "/index.php/api/";
		}

		$url_request = get_url_request($url);
		$this->restclient->set_option('base_url', $url_request);
		$this->restclient->set_option('format', $format);
		$result = "";
		switch ($type) {
			case 'GET':
				$result = $this->restclient->get($api, $q);
				break;
			case 'PUT':
				$result = $this->restclient->put($api, $q);
				break;
			case 'POST':
				$result = $this->restclient->post($api, $q);
				break;
			case 'DELETE':

				$result = $this->restclient->delete($api, $q);

				break;
			default:
				break;
		}


		if ($debug == 1) {
			debug($result->response, 1);
		}
		if ($format == "json") {
			$response = $result->response;
			return json_decode($response, true);
		}

		return $result->response;
	}

	function get_session($key)
	{
		return $this->sessionclass->get_session($key);
	}

	function logout()
	{
		$this->sessionclass->logout();
	}
	function get_imagenes_productos($id_servicio, $completo = 0 , $limit = 1 , $path=0, $data =[])
	{
		$response =  [];
		$a  = 0;
		if (count($data) > 0){

			foreach ($data as $row){

				$servicio       =  $row;
				$id             =  $data[$a]["id_servicio"];
				$servicio["url_img_servicio"]   =  $this->get_img($id, 1 , 1  , 1);
				$a ++;
				$response[]     =  $servicio;
			}

		}else{

			$response =  $this->get_img($id_servicio, $completo , $limit  , $path);

		}
		return $response;


	}
	private function get_img($id_servicio, $completo = 0 , $limit = 1 , $path=0){

		$q["id_servicio"] = $id_servicio;
		$q["c"] = $completo;
		$q["l"] = $limit;
		$api = "imagen_servicio/servicio/format/json/";
		$response  =  $this->api($api, $q);
		if ($path >  0 ) {
			$response =  get_img_serv($response);
		}

		return $response;
	}
	function get_departamentos($format_html = 1)
	{

		if ($format_html == 1) {
			$api = "clasificacion/primer_nivel/format/json/";
			return $this->api($api, [], "json");
		} else {
			$api = "clasificacion/primer_nivel/format/json/";
			return $this->api($api, [], "json");
		}

	}

	function calcula_costo_envio($q)
	{
		$api = "cobranza/calcula_costo_envio/format/json/";
		return $this->api($api, $q);
	}

	function send_email_enid($q, $test = 0)
	{

		$api = "sender/index";
		$q["test"] = $test;
		return $this->api($api, $q, 'json', "POST", 0, 1, "msj");
	}

	function get_info_usuario($id_usuario)
	{

		$q["id_usuario"] = $id_usuario;
		$api = "usuario/q/format/json/";
		return $this->api($api, $q);
	}

	function get_base_servicio($id_servicio)
	{
		$q["id_servicio"] = $id_servicio;
		$api = "servicio/base/format/json/";
		return $this->api($api, $q);
	}

	function create_pagination($q)
	{

		$api = "paginacion/create/format/json/";
		$paginacion = $this->api($api, $q);
		return $paginacion;
	}

	function crea_historico($tipo, $id_evento = 0, $id_usuario = 0, $id_empresa = 0, $id_servicio = 0)
	{
		/*
		$pagina_url 	=  	base_url(uri_string());         
		$ip 			= 	$this->input->ip_address();               
		$dispositivo  	= 	$this->agent->agent_string();        
		$browser 		= 	$this->agent->browser().' '.$this->agent->version();	        
		$robot 			= 	$this->agent->robot();
		$mobile 		= 	$this->agent->mobile();
		$platform 		=  	$this->agent->platform(); 
		$is_browser		=  	$this->agent->is_browser();
		$is_robot 		= 	$this->agent->is_robot();
		$is_mobile 		= 	$this->agent->is_mobile();
					
		$table 			=	"";
		$is_robot		=  	$this->get_valor_numerico_bool($is_robot);
		$is_mobile 		=  	$this->get_valor_numerico_bool($is_mobile);
		
		
		$url_referencia = "";	        
		if(isset( $_SERVER['HTTP_REFERER'] ) ){	            
			$url_referencia  = strtolower( $_SERVER['HTTP_REFERER'] ); 	           
		}
		$flag_enid 		= 1;
		$dominio 		=  get_dominio($pagina_url);
		
		if ($dominio != "enidservice.com"){
			$flag_enid 	=0;
		}	       

		
		$params["q"] =  [
			"url" 				=> $pagina_url,
			"ip"				=> $ip,
			"dispositivo"		=> $dispositivo,
			"tipo"				=> $tipo ,
			"id_evento"			=> $id_evento  ,
			"id_usuario"		=> $id_usuario,
			"id_empresa"		=> $id_empresa ,
			"url_referencia" 	=> $url_referencia,
			"dominio"			=> $dominio,
			"flag_enid"			=> $flag_enid,
			"browser"			=> $browser,
			"robot"				=> $robot,
			"mobile"			=> $mobile,
			"platform"			=> $platform,
			"is_browser"		=> $is_browser,
			"is_robot"			=> $is_robot,
			"is_mobile"			=> $is_mobile,
			"id_servicio"		=> $id_servicio
		];

		$params["q2"]=  ($is_robot ==  1)? 1 : 0;	        		        
		$api 		=  "pagina_web/index";
		$this->api($api, $params, 'json', $type='POST');
		*/

	}

	function validate_user_sesssion()
	{

		if ($this->sessionclass->is_logged_in() > 0) {
			redirect(url_home());
		}
	}

	function acceso()
	{

		if ($this->sessionclass->is_logged_in() != 1) {

			$this->logout();
		}
	}

	function is_logged_in()
	{

		return $this->sessionclass->is_logged_in();

	}

	function set_userdata($session_data)
	{

		$this->sessionclass->set_userdata($session_data);

	}

	function show_data_page($data, $center_page, $tema = 0)
	{
		$this->load->view("../../../view_tema/header_template", $data);
		$this->load->view($center_page, $data);
		$this->load->view("../../../view_tema/footer_template", $data);
	}

	function getperfiles()
	{
		return $this->sessionclass->getperfiles();
	}

	function val_session($titulo)
	{

		$data["is_mobile"] = ($this->agent->is_mobile() == FALSE) ? 0 : 1;
		$data["proceso_compra"] = 0;
		if ($this->sessionclass->is_logged_in() == 1) {

			$menu = $this->sessionclass->create_contenido_menu();
			$nombre = $this->get_session("nombre");
			$data['titulo'] = $titulo;
			$data["menu"] = $menu;
			$data["nombre"] = $nombre;
			$data["email"] = $this->get_session("email");
			$data["perfilactual"] = $this->sessionclass->get_nombre_perfil();
			$data["in_session"] = 1;
			$data["no_publics"] = 1;
			$data["meta_keywords"] = "";
			$data["url_img_post"] = "";
			$data["id_usuario"] = $this->get_session("idusuario");
			$data["id_empresa"] = $this->get_session("idempresa");
			$data["info_empresa"] = $this->get_session("info_empresa");
			$data["desc_web"] = "";

			return $data;

		} else {

			$data['titulo'] = $titulo;
			$data["in_session"] = 0;
			$data["id_usuario"] = "";
			$data["nombre"] = "";
			$data["email"] = "";
			$data["telefono"] = "";

			return $data;
		}
	}
}