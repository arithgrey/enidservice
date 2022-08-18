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
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    function disponible_GET()
    {

        $param = $this->get();
        $recompensas = $this->disponibles($param["paginacion"]);
        $this->response($recompensas);
    }
    public function disponibles($paginacion, $populares = 0 )
    {

        $response = [];
        $data_complete = [];

        $response = $this->recompensa_model->disponibles($paginacion, $populares);
        $response = $this->app->add_imgs_servicio($response);
        $recompensa = $this->app->add_imgs_servicio($response, "id_servicio_conjunto", "url_img_servicio_conjunto");

        $a = 0;

        foreach ($recompensa as $row) {

            $data_complete[$a] = $row;
            $id_servicio  = $row["id_servicio"];
            $id_servicio_conjunto  = $row["id_servicio_conjunto"];
            $data_complete[$a]["servicio"] = $this->app->servicio($id_servicio);
            $data_complete[$a]["servicio_conjunto"] = $this->app->servicio($id_servicio_conjunto);
            $a++;
        }




        return $data_complete;
    }

    function total_disponible_GET()
    {

        $total =  $this->recompensa_model->total_disponibles();
        $this->response(pr($total, "total"));
    }


    function visible_GET()
    {

        $param = $this->get();
        $response = false;
        $data_complete = [];
        if (fx($param, "id_servicio")) {

            $response = $this->recompensa_model->visible($param["id_servicio"]);
            $response = $this->app->add_imgs_servicio($response);
            $recompensa = $this->app->add_imgs_servicio($response, "id_servicio_conjunto", "url_img_servicio_conjunto");

            $a = 0;

            foreach ($recompensa as $row) {

                $data_complete[$a] = $row;
                $id_servicio  = $row["id_servicio"];
                $id_servicio_conjunto  = $row["id_servicio_conjunto"];
                $data_complete[$a]["servicio"] = $this->app->servicio($id_servicio);
                $data_complete[$a]["servicio_conjunto"] = $this->app->servicio($id_servicio_conjunto);
                $a++;
            }
        }
        $this->response($data_complete);
    }

    function servicio_GET()
    {

        $param = $this->get();
        $response = false;
        $data_complete = [];
        if (fx($param, "id_servicio")) {

            $response = $this->recompensa_model->servicio($param["id_servicio"]);
            $response = $this->app->add_imgs_servicio($response);
            $recompensa = $this->app->add_imgs_servicio($response, "id_servicio_conjunto", "url_img_servicio_conjunto");

            $a = 0;

            foreach ($recompensa as $row) {

                $data_complete[$a] = $row;
                $id_servicio  = $row["id_servicio"];
                $id_servicio_conjunto  = $row["id_servicio_conjunto"];
                $data_complete[$a]["servicio"] = $this->app->servicio($id_servicio);
                $data_complete[$a]["servicio_conjunto"] = $this->app->servicio($id_servicio_conjunto);
                $a++;
            }
        }
        $this->response($data_complete);
    }
    function id_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id")) {

            $response = $this->recompensa_model->id_recompensa($param["id"]);
            $response = $this->app->add_imgs_servicio($response);
            $response = $this->app->add_imgs_servicio($response, "id_servicio_conjunto", "url_img_servicio_conjunto");

            $id_servicio  = pr($response, 'id_servicio');
            $id_servicio_conjunto  = pr($response, 'id_servicio_conjunto');
            $response[0]["servicio"] = $this->app->servicio($id_servicio);
            $response[0]["servicio_conjunto"] = $this->app->servicio($id_servicio_conjunto);
            $response = editar_recompensas($response);
        }
        $this->response($response);
    }



    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "servicio,servicio_conjunto")) {

            $id_servicio = $param["servicio"];
            $id_servicio_conjunto = $param["servicio_conjunto"];

            $existentes = $this->recompensa_model->get(
                [],
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

    function descuento_PUT()
    {

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

                $id_servicio = pr($recompensa, "id_servicio");
                $id_servicio_conjunto = pr($recompensa, "id_servicio_conjunto");


                if ($antecedente_compra < 1) {

                    $id_usuario_recompensa = $this->usuario_deseo_compra($id_recompensa, $id_servicio);
                    $id_usuario_recompensa_complemento = $this->usuario_deseo_compra($id_recompensa, $id_servicio_conjunto);

                    $response = ($id_usuario_recompensa > 0 && $id_usuario_recompensa_complemento > 0);
                } else {

                    $id_usuario_recompensa = $this->usuario_deseo($id_recompensa, $id_servicio);
                    $id_usuario_recompensa_complemento = $this->usuario_deseo($id_recompensa, $id_servicio_conjunto);

                    $response = ($id_usuario_recompensa > 0 && $id_usuario_recompensa_complemento > 0);
                }
                /*Gamifica compra*/
                $this->gamifica_recompesa($id_recompensa);
            }
        }
        $this->response($response);
    }
    private function gamifica_recompesa($id_recompensa){

        return $this->recompensa_model->gamifica_recompensa($id_recompensa);

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
    function ids_recibo_descuento_GET()
    {

        $param = $this->get();
        $ids = $param["ids"];
        $recibos_recompensas = $this->recompensa_model->in(get_keys($ids));

        $response = [];
        foreach ($ids as $row) {


            $response[] =
                [
                    "id_orden_compra" => $row,
                    "descuento" => $this->total_descuento_orden_compra($recibos_recompensas, $row),
                ];
        }

        $this->response($response);
    }


    function total_descuento_orden_compra($recibos_recompensas, $id_orden_compra_actual)
    {

        $descuento_total = 0;
        $recompensas = [];
        foreach ($recibos_recompensas as $row) {

            $id_orden_compra = $row["id_orden_compra"];
            $descuento = $row["descuento"];
            $id_recompensa = $row["id_recompensa"];
            if ($id_orden_compra ==  $id_orden_compra_actual) {
                if (!in_array($id_recompensa, $recompensas)) {

                    $descuento_total = $descuento_total + $descuento;
                    $recompensas[] = $id_recompensa;
                }
            }
        }
        return $descuento_total;
    }
    function sugeridos_GET()
    {
        $param = $this->get();
        /*Entrega promociones aleatorias*/

        $antecedente_compra = prm_def($param, "antecedente_compra");
        $numero_recompensas = $this->recompensa_model->total_disponibles()[0]["total"];
        $paginacion = intval($numero_recompensas) / 8;
        $random_paginador = rand(1, $paginacion);
        $paginador = $this->offset_paginador($random_paginador);
        $recompensas = sugerencias($this->disponibles($paginador), $antecedente_compra);

        $this->response($recompensas);
    }
    function populares_GET()
    {        
        /*Entrega TOP DE 8 populares*/
        $param = $this->get();        
        $antecedente_compra = prm_def($param, "antecedente_compra");        
        $popular = prm_def($param, "popular");        

        $paginador = $this->offset_paginador(1);
        $recompensas = sugerencias($this->disponibles($paginador , 1), $antecedente_compra, $popular);

        $this->response($recompensas);
    }

    function offset_paginador($page = 2)
    {

        $per_page = 8; //la cantidad de registros que desea mostrar        
        $offset = ($page - 1) * $per_page;
        
        return " LIMIT $offset , $per_page ";
    }
}
