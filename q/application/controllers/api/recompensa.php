<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Recompensa extends REST_Controller
{
    public $option;
    private $id_usuario;
    function __construct()
    {
        parent::__construct();
        $this->load->model("recompensa_model");
        $this->load->helper("recompensas");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");

    }

    function visible_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {

            $response = $this->recompensa_model->visible($param["id_servicio"]);
            $response = $this->app->add_imgs_servicio($response);
            $response = $this->app->add_imgs_servicio($response, "id_servicio_conjunto", "url_img_servicio_conjunto");

        }
        $this->response($response);
    }

    function servicio_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {

            $response = $this->recompensa_model->servicio($param["id_servicio"]);
            $response = $this->app->add_imgs_servicio($response);
            $response = $this->app->add_imgs_servicio($response, "id_servicio_conjunto", "url_img_servicio_conjunto");

        }
        $this->response($response);
    }
    function id_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id")) {

            $response = $this->recompensa_model->id_recompensa($param["id"]);
            $response = $this->app->add_imgs_servicio($response);
            $response = $this->app->add_imgs_servicio($response, "id_servicio_conjunto", "url_img_servicio_conjunto");
            $response = editar_recompensas($response);

        }
        $this->response($response);
    }



    function index_POST(){

        $param = $this->post();
        $response = false;
        if (fx($param, "servicio,servicio_conjunto")) {

            $id_servicio = $param["servicio"];
            $id_servicio_conjunto = $param["servicio_conjunto"];

            $existentes = $this->recompensa_model->get([] , 
                [
                    "id_servicio" => $id_servicio, 
                    "id_servicio_conjunto" => $id_servicio_conjunto
                ]
            );  
            if (!es_data($existentes)) {


                $response = $this->recompensa_model->insert(
                    [
                        "id_servicio" =>  $id_servicio,
                        "id_servicio_conjunto" => $id_servicio_conjunto
                    ]
                );
                
            }
            

        }
        $this->response($response);   
    }

    function descuento_PUT(){

        $param = $this->put();
        $response = false;
        if (fx($param, "id,descuento")) {

            $id = $param["id"];
            $descuento = $param["descuento"];
            $response = $this->recompensa_model->q_up("descuento", $descuento, $id);
            

        }
        $this->response($response);   
    }
    function deseo_compra_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id,antecedente_compra")) {

            $id_recompensa = $param["id"];
            $recompensa = $this->recompensa_model->id_recompensa($id_recompensa);
            $antecedente_compra = $param["antecedente_compra"]; 

            if (es_data($recompensa)) {
            

                $id_servicio = pr($recompensa ,"id_servicio");       
                $id_servicio_conjunto = pr($recompensa ,"id_servicio_conjunto");       

                
                if ($antecedente_compra < 1 ) {
        
                    
                    $id_usuario_recompensa = $this->usuario_deseo_compra($id_recompensa, $id_servicio);            
                    $id_usuario_recompensa_complemento = $this->usuario_deseo_compra($id_recompensa, $id_servicio_conjunto);            

                    $response = ($id_usuario_recompensa > 0 && $id_usuario_recompensa_complemento > 0);


                }else{

                    $id_usuario_recompensa = $this->usuario_deseo($id_recompensa, $id_servicio);            
                    $id_usuario_recompensa_complemento = $this->usuario_deseo($id_recompensa, $id_servicio_conjunto);            

                    $response = ($id_usuario_recompensa > 0 && $id_usuario_recompensa_complemento > 0);


                }

            }
            

        }
        $this->response($response);
    }
    function ids_GET()
    {

        $param = $this->get();
        $in = get_keys($param['ids']);
        $response = $this->recompensa_model->get_in($in);
        $this->response($response);

    }
    private function usuario_deseo_compra($id_recompensa, $id_servicio, $articulos = 1)
    {   


        $q  = [
            "id_servicio" =>  $id_servicio,
            "articulos" => $articulos,            
            "id_recompensa" => $id_recompensa,
            "ip" => $this->input->ip_address()
        ];

        return $this->app->api("usuario_deseo_compra/index", $q, "json", "POST");

        
    }
    private function usuario_deseo($id_recompensa, $id_servicio, $articulos = 1)
    {   


        $q  = [
            "servicio" =>  $id_servicio,
            "articulos" => $articulos,            
            "id_recompensa" => $id_recompensa,            
            "id_usuario" => $this->id_usuario,
        ];

        return $this->app->api("usuario_deseo/servicio", $q, "json", "POST");

        
    }


}