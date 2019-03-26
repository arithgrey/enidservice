<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
        $this->load->helper("deseos");
        $this->principal->acceso();
    }

    function index()
    {

        $data = $this->principal->val_session("");
        $data["meta_keywords"] = "";
        $data["desc_web"] = "";
        $data["url_img_post"] = "";
        $data["clasificaciones_departamentos"] = $this->principal->get_departamentos();
        $param = $this->input->get();

        if (get_param_def($param, "q") === "preferencias") {
            $this->load_preferencias($data);
        } else {
            $this->load_lista_deseos($data);
        }
    }

    private function load_preferencias($data)
    {

        $data["preferencias"] = $this->get_preferencias($data["id_usuario"]);
        $data["css"]    = ["preferencias.css"];
        $data["js"]     = ["lista_deseos/preferencias.js"];
        $data["tmp"]    = get_format_preferencias();
        $this->principal->show_data_page($data, 'home_preferencias');
    }

    private function load_lista_deseos($data)
    {

        $productos_deseados = $this->get_lista_deseos($data["id_usuario"]);
        $data["productos_deseados"]= $this->add_imagenes($productos_deseados);
        if (count($data["productos_deseados"]) > 0) {
            $data["css"] = array("lista_deseos.css");
	        $data["js"] = ["lista_deseos/carro_compras.js"];
            $this->principal->show_data_page($data, 'home');
        } else {
            $this->principal->show_data_page($data, 'home_sin_productos');
        }
    }
	private function add_imagenes($servicios)
	{
		$response =  [];
		$a  = 0;
		foreach ($servicios as $row){

			$servicio       =  $row;
			$id_servicio    =  $servicios[$a]["id_servicio"];
			$servicio["url_img_servicio"]   =  $this->principal->get_imagenes_productos($id_servicio, 1 , 1, 1);
			$a ++;
			$response[]     =  $servicio;
		}
		return $response;

	}
    private function get_lista_deseos($id_usuario)
    {
        $q["id_usuario"] = $id_usuario;
        $q["c"] = 1;
        $api = "usuario_deseo/usuario/format/json/";
        return $this->principal->api($api, $q);
    }

    private function get_preferencias($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        $api = "clasificacion/interes_usuario/format/json/";
        return $this->principal->api($api, $q);
    }
}