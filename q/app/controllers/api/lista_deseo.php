<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Lista_deseo extends REST_Controller
{
    function __construct()
    {
        parent::__construct();        
        $this->load->helper("lista_deseo");
        $this->load->library(lib_def());
    }

    function explora_deseo_GET($data)
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "ip")) {

            
            $lista_deseo = $this->app->api("usuario_deseo_compra/ip_carro/", ['ip' => $param["ip"]]);            
            $listado = prm_def($lista_deseo,"listado",[]);                                
            $response = productos($data,  $listado,1);
            
        }
        $this->response($response);

    }
    function explora_deseo_s_GET()
    {
        $param = $this->get();
        $response = false;
        $id_usuario = $this->app->get_session("id_usuario");
        if ($id_usuario > 0) {
            
            $lista = $this->get_lista_deseos($id_usuario);                
            $lista_deseo = $lista["listado"];            
            $data["productos_deseados"] = $this->add_imagenes($lista_deseo);

            if (es_data($data["productos_deseados"])) {
                
                $response = productos($data,  $data["productos_deseados"],1);

            }
        }
        $this->response($response);
    }
    private function add_imagenes($servicios)
    {
        $response = [];
        $a = 0;
        foreach ($servicios as $row) {

            $servicio = $row;
            $id_servicio = $servicios[$a]["id_servicio"];
            $servicio["url_img_servicio"] = $this->app->imgs_productos($id_servicio, 1, 1, 1);
            $a++;
            $response[] = $servicio;
        }
        return $response;

    }
    private function get_lista_deseos($id_usuario)
    {
    
        return $this->app->api("usuario_deseo/carro", 
            [
                "id_usuario" => $id_usuario,
                "c" => 1,
            ]
        );
    }


}