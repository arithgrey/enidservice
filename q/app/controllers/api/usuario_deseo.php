<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class usuario_deseo extends REST_Controller
{
    
    public $id_usuario;
    function __construct()
    {
        parent::__construct();
        $this->load->model("usuario_deseo_model");
        $this->load->helper("usuario_deseo");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
        
    }
    /*Ya se registro ahora le cobramos 4*/
    function envio_pago_PUT()
    {

        $param = $this->put();
        $ids = get_keys($param["ids"]);
        $response = $this->usuario_deseo_model->envio_pago($ids);
        $this->response($response);
    }
    /*Se notifica el cliente está por registrar sus datos de contacto status 3*/
    function envio_registro_PUT()
    {

        $param = $this->put();
        $ids = get_keys($param["ids"]);
        $response = $this->usuario_deseo_model->envio_registro($ids);
        $this->response($response);
    }

    function envio_pago_GET()
    {

        $param = $this->get();
        $ids = get_keys($param["ids"]);
        $envia_cliente = prm_def($param, "envia_cliente");
        $response = $this->usuario_deseo_model->por_pago($ids, $envia_cliente);
        $this->response($response);
    }
    function agregados_GET()
    {

        $param = $this->get();
        $deseo_compra = $this->usuario_deseo_model->get([], ["status" => 0], 1000, 'id');
        $deseo_compra_servicio = $this->app->add_imgs_servicio($deseo_compra);
        $response = $this->app->add_imgs_usuario($deseo_compra_servicio, 'id_usuario');


        $this->response(agregados($response));
    }
    function en_registro_GET()
    {

        $param = $this->get();
        $deseo_compra = $this->usuario_deseo_model->get([], ["status" => 3], 1000, 'id');
        $deseo_compra_servicio = $this->app->add_imgs_servicio($deseo_compra);
        $response = $this->app->add_imgs_usuario($deseo_compra_servicio, 'id_usuario');

        $this->response(en_registro($response));
    }
    function cantidad_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id,cantidad")) {


            $in_session = $this->app->session()["in_session"];
            if ($in_session > 0) {

                $response = $this->usuario_deseo_model->q_up("articulos", $param["cantidad"], $param["id"]);
            } else {

                $response = $this->cantidad_usuario_deseo($param);
            }
        }
        $this->response($response);
    }

    private function cantidad_usuario_deseo($param)
    {

        return $this->app->api("usuario_deseo_compra/cantidad", $param, "json", "PUT");
    }

    function deseos_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario,status")) {

            $response = $this->usuario_deseo_model->total_deseo($param["id_usuario"]);
        }

        $this->response($response);
    }

    private function get_num_deseo_servicio_usuario($param)
    {

        $response = false;
        if (fx($param, "id_usuario,id_servicio")) {
            $q = [
                "id_usuario" => $param["id_usuario"],
                "id_servicio" => $param["id_servicio"]
            ];
            $response = $this->usuario_deseo_model->get(["COUNT(0)num"], $q)[0]["num"];
        }

        return $response;
    }

    function num_deseo_servicio_usuario_GET($param)
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario,id_servicio")) {
            $response = $this->get_num_deseo_servicio_usuario($param);
        }
        $this->response($response);
    }

    function status_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "id")) {

            $id = $param["id"];
            $response = $this->usuario_deseo_model->q_up("status", 2, $param["id"]);
            $deseo_compra = $this->usuario_deseo_model->q_get([], $id);

            $id_recompensa = pr($deseo_compra, "id_recompensa");
            $id_usuario = pr($deseo_compra, "id_usuario");

            if ($id_recompensa > 0) {

                /*Se actualiza simple quitando los descuentos aplicados*/
                $response =
                    $this->usuario_deseo_model->baja_recompensa($id, $id_usuario, $id_recompensa);
            }
        }
        $this->response($response);
    }
    function servicio_DELETE()
    {
        $param = $this->delete();
        $response = false;
        if (fx($param, "id_servicio")) {


            $response = $this->usuario_deseo_model->delete(
                [
                    "id_servicio" => $param["id_servicio"],
                    "id_usuario" => $this->id_usuario
                ],
                1
            );
        }
        $this->response($response);
    }



    function add_lista_deseos_PUT()
    {
        $param = $this->put();
        $response = $this->procesa_deseo($param);
        $this->response($response);
    }

    function servicio_POST()
    {

        $param = $this->post();
        $response = false;
        $id = $this->id_usuario;
        $id_usuario = ($id > 0) ? $id : prm_def($param, "id_usuario");

        if (fx($param, "servicio") > 0 && $id_usuario > 0) {

            $id_recompensa = prm_def($param, "id_recompensa");
            $params = [
                "id_usuario" => $id_usuario,
                "id_servicio" => $param["servicio"],
                "id_recompensa" => $id_recompensa
            ];

            $response = $this->usuario_deseo_model->insert($params);
        }
        $this->response($response);
    }

    function status_POST()
    {

        $param = $this->post();
        if (fx($param, "servicio") > 0 && $this->id_usuario > 0) {

            $params = [
                "id_usuario" => $this->id_usuario,
                "id_servicio" => $param["servicio"]
            ];
            $response = $this->usuario_deseo_model->insert($params);
        }
        $this->response($response);
    }

    function procesa_deseo($param)
    {

        $response = false;
        if (fx($param, "id_usuario,id_servicio")) {
            $response = 0;

            $params = [
                "id_usuario" => $param["id_usuario"],
                "id_servicio" => $param["id_servicio"],
                "articulos" => $param["articulos"]
            ];

            $numero_boleto = prm_def($param,"numero_boleto");
            
            if($numero_boleto > 0){

                $params["numero_boleto"] = $numero_boleto;
            }

            $response = $this->usuario_deseo_model->insert($params);
        }
        return $response;
    }

    function agregan_lista_deseos_periodo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {
            $response = $this->usuario_deseo_model->agregan_lista_deseos_periodo($param);
        }
        $this->response($response);
    }

    function lista_deseos_PUT()
    {

        $param = $this->put();
        $param["id_usuario"] = $this->id_usuario;
        $this->procesa_deseo($param);
        $this->agrega_interes_usuario($param);
        $this->gamificacion_deseo($param);
        $this->deseo_compra($param);
        $this->response(true);
    }
    function lista_deseos_boleto_DELETE()
    {

        $param = $this->delete();
        $param["id_usuario"] = $this->id_usuario;
        
        $response = false;
        
        if (fx($param, "id_usuario,id_servicio,numero_boleto")) {
            $response = 0;

            $params = [
                "id_usuario" => $param["id_usuario"],
                "id_servicio" => $param["id_servicio"],
                "numero_boleto" => $param["numero_boleto"]
                
            ];
            
            $response = $this->usuario_deseo_model->delete($params);

        }
        return $response;

    }

    function deseo_compra($param)
    {
        $q = ["tipo" => 2, "id_servicio" =>  $param["id_servicio"]];
        return $this->app->api("intento_tipo_entrega/index", $q, "json", "POST");
    }

    function usuario_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $id_usuario = $param["id_usuario"];
            if (array_key_exists("c", $param) && $param["c"] > 0) {

                $listado = $this->usuario_deseo_model->get_usuario_deseo($id_usuario);
                $ids = array_column($listado, "id_recompensa");
                $ids_usuario_deseo = array_column($listado, "id");
                $recompensa = [];

                if (es_data($ids)) {

                    $ids_recompensa = array_unique($ids);
                    $recompensa = $this->recompensa_ids($ids_recompensa);
                }

                $response = [
                    "listado" => $listado,
                    "recompensas" => $recompensa,
                    "ids_usuario_deseo" => $ids_usuario_deseo
                ];
            } else {

                $response = $this->usuario_deseo_model->get([], ["id_usuario" => $id_usuario], 30, 'num_deseo');
            }
        }
        $this->response($response);
    }

    function carro_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $id_usuario = $param["id_usuario"];
            if (array_key_exists("c", $param) && $param["c"] > 0) {

                $listado = $this->usuario_deseo_model->get_usuario_deseo($id_usuario,1);
                $ids = array_column($listado, "id_recompensa");                
                $recompensa = [];

                if (es_data($ids)) {

                    $ids_recompensa = array_unique($ids);
                    $recompensa = $this->recompensa_ids($ids_recompensa);
                }

                $response = [
                    "listado" => $listado,
                    "recompensas" => $recompensa
                ];
            } else {

                $response = $this->usuario_deseo_model->get([], ["id_usuario" => $id_usuario], 30, 'num_deseo');
            }
        }
        $this->response($response);
    }

    private function recompensa_ids($ids)
    {

        return $this->app->api("recompensa/ids", ["ids" =>  $ids]);
    }

    private function agrega_interes_usuario($q)
    {

        return $this->app->api("usuario_clasificacion/interes", $q, "json", "POST");
    }

    private function gamificacion_deseo($q)
    {

        return $this->app->api("servicio/gamificacion_deseo", $q, "json", "PUT");
    }
}
