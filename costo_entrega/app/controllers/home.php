<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    public $options;
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("search");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    function index()
    {

        $data = $this->app->session();
        $param  = $this->input->get();
        $es_administrador = es_administrador($data);
        
        $data["in_session"] = 1;
        $data["id_usuario"] = "";
        $data["nombre"] = "";
        $data["email"] = "";
        $data["telefono"] = "";
        $data["id_perfil"] = 0;
        $data["menu"] = "";
        $data["data_status_enid"] = "";
        $data["path_img_usuario"] = "";
        $data["meta_keywords"] = "";
        $data["url_img_post"] = "";
        $data["desc_web"] = "";
        $data["titulo"] = "";
        $data["clasificaciones_departamentos"] = "";
        $data["proceso_compra"] = "";
        $data["footer_visible"] = "";
        $data["costo_entrega"] = $this->codigo_postal($param);
        $data["alcaldias"] = $this->app->api("delegacion/cobertura");
        $data["es_administrador"] = $es_administrador;
        
        $data = $this->app->cssJs($data, "costo_entrega");
        $this->app->pagina($data, costos($param, $data), 1);
        
        
    }
    
    /*Busqueda por Codigo postal*/
    private function codigo_postal($param)
    {
        $q = prm_def($param, "q");

        $response  = [];
        if (str_len($q,2)) {
            
            $response =  $this->app->api(
                "codigo_postal/costo",
                [
                    "q" => $q
                ]
            );
        }
        return $response;
    }
}
