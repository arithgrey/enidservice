<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class usuario_deseo_compra extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("usuario_deseo_compra_model");
        $this->load->helper("usuario_deseo_compra");
        $this->load->library(lib_def());

    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, "id_servicio,articulos")) {

            $ip =  strlen(prm_def($param, "ip")) > 2 ? $param["ip"] :  $this->input->ip_address();
            $articulos = $param["articulos"];
            $id_recompensa = prm_def($param, "id_recompensa");
            $numero_boleto = prm_def($param, "numero_boleto");
            $paras = [
                "id_servicio" => $param["id_servicio"],
                "ip" => $ip,
                "articulos" => $articulos, 
                "id_recompensa" => $id_recompensa,
                "numero_boleto" => $numero_boleto
            ];

            $response = $this->usuario_deseo_compra_model->insert($paras, 1);

        }
        $this->response($response);


    }
    function index_DELETE()
    {

        $param = $this->delete();
        $response = false;

        if (fx($param, "id_servicio")) {

            $ip =  strlen(prm_def($param, "ip")) > 2 ? $param["ip"] : $this->input->ip_address();                    
            $where = ["id_servicio" => $param["id_servicio"],"ip" => $ip];

            $response = $this->usuario_deseo_compra_model->delete($where);

        }
        $this->response($response);


    }

    function agregados_GET()
    {

        $deseo_compra = $this->usuario_deseo_compra_model->get([],["status" => 0],1000, 'id_usuario_deseo_compra');
        $response = $this->app->add_imgs_servicio($deseo_compra);        
        $this->response(agregados($response));
    }   
    function en_registro_GET()
    {

        $param = $this->get();        
        $deseo_compra = $this->usuario_deseo_compra_model->get(
            [],["status" => 3],1000, 'id_usuario_deseo_compra');
        $response = $this->app->add_imgs_servicio($deseo_compra);        
        $this->response(en_registro($response));
    }

    function total_GET()
    {

        $ip = $this->input->ip_address();
        $response = $this->usuario_deseo_compra_model->total_ip($ip);
        $this->response($response);

    }

    function index_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "ip")) {

            $ip = $param["ip"];
            $lista_deseos = $this->usuario_deseo_compra_model->compra($ip);                    
            $listado = $this->app->add_imgs_servicio($lista_deseos);

            $ids = array_column($listado, "id_recompensa");
            $recompensa = [];
            if(es_data($ids)){

                $ids_recompensa = array_unique($ids);
                $recompensa = $this->recompensa_ids($ids_recompensa);

            }


            $response = [
                "listado" => $listado,
                "recompensas" => $recompensa
            ];
            
            

        }
        $this->response($response);

    }
    private function recompensa_ids($ids)
    {   

        return $this->app->api("recompensa/ids", ["ids" =>  $ids]);
        
    }

    function id_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id,status")) {

            $id = $param["id"];            
            $status = $param["status"];        
            $response =  $this->usuario_deseo_compra_model->q_up("status", $status, $id);
            if ($status == 2) {
            
                $deseo_compra = $this->usuario_deseo_compra_model->q_get([], $id);
                $ip = pr($deseo_compra, "ip");
                $id_recompensa = pr($deseo_compra, "id_recompensa");
                            
                if ($id_recompensa > 0 ) {

                    /*Se actualiza simple quitando los descuentos aplicados*/                    
                    $response = 
                    $this->usuario_deseo_compra_model->baja_recompensa($id, $ip , $id_recompensa);
                }
            }       
        }

        $this->response($response);
    }
    function ip_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "ip,status")) {

            $ip = $param["ip"];            
            $status = $param["status"];        
            
            $response =  $this->usuario_deseo_compra_model->update(
                ["status" => $status] , 
                ["ip" => $ip],
                10
            );
            
        }

        $this->response($response);
    }

    function envio_pago_PUT()
    {

        $param = $this->put();
        $ids = get_keys($param["ids"]);
        $response = $this->usuario_deseo_compra_model->envio_pago($ids);
        $this->response($response);
    }

    function envio_registro_PUT(){
        
        $param = $this->put();
        $ids = get_keys($param["ids"]);
        $response = $this->usuario_deseo_compra_model->envio_registro($ids);
        $this->response($response);


    }
    function envio_pago_GET()
    {

        $param = $this->get();
        $ids = get_keys($param["ids"]);
        $response = $this->usuario_deseo_compra_model->por_pago($ids);
        $this->response($response);
    }
    function cantidad_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id,cantidad")) {

            $response = $this->usuario_deseo_compra_model->q_up("articulos", $param["cantidad"], $param["id"]);

        }
        $this->response($response);
    }
}