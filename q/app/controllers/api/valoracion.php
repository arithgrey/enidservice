<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';
use Faker\Factory;

class Valoracion extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("valoracion_model");
        $this->load->helper("valoracion");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    function id_PUT()
    {

        $param = $this->put();
        $response = false; 
        if (fx($param, "status")) {
            
            $response = $this->valoracion_model->q_up("status", $param["status"], $param["id"]);

        }
        $this->response($response);
    }
    function num_GET()
    {
        $param = $this->get();
        $response = false;

        if (fx($param, "id_usuario,id_servicio")) {

            $params = ["COUNT(0)num"];
            $params_where = ["id_servicio" => $param["id_servicio"], "id_usuario" => $param["id_usuario"]];
            $response = $this->valoracion_model->get($params, $params_where)[0]["num"];
        }
        $this->response($response);
    }

    function lectura_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->valoracion_model->lectura_usuario($param);
        }
        $this->response($response);
    }

    function gamificacion_negativa_PUT()
    {
        $param = $this->put();
        $this->valoracion_model->set_gamificacion($param, 0, 1);
    }

    function pregunta_consumudor_form_GET()
    {

        $param = $this->get();
        if (fx($param, "id_servicio")) {

            $id_servicio = $param["id_servicio"];
            $servicio = $this->app->servicio($id_servicio);
            $data["servicio"] = $servicio;
            $vendedor = $this->app->usuario($servicio[0]["id_usuario"]);
            $propietario = ($servicio[0]["id_usuario"] != $id_servicio) ? 0 : 1;
            $response = get_form_pregunta_consumidor($id_servicio, $propietario, $vendedor, $servicio);
        }
        $this->response($response);
    }

    function gamificacion_pregunta_PUT()
    {

        $param = $this->put();
        $response = $this->valoracion_model->update_gamificacion_pregunta($param);
        $this->response($response);
    }

    function resumen_valoraciones_vendedor_GET()
    {

        $param = $this->get();
        $comentarios = $this->valoracion_model->get_desglose_valoraciones_vendedor($param);
        $response = comentarios($comentarios["data"], "");

        if (es_data($comentarios["data"])) {

            $response = hr() . d("RESEÑAS HECHAS POR OTROS CLIENTES", ["class" => 'text_resumen']) . hr() . $response;
        }
        $this->response($response);
    }

    function resumen_valoraciones_periodo_GET()
    {

        $param = $this->get();
        $comentarios = $this->valoracion_model->get_desglose_valoraciones_periodo($param);
        $data_comentarios = comentarios($comentarios["data"], "");
        if (count($comentarios["data"]) > 0) {


            $r[] = hr();
            $r[] = d("RESEÑAS HECHAS POR OTROS CLIENTES", 'text_resumen');
            $r[] = hr();
            $r[] = $data_comentarios;
            $data_comentarios = d(append($r), 6, 1);
        }
        $this->response($data_comentarios);
    }

    function utilidad_PUT()
    {
        $param = $this->put();
        $response = $this->valoracion_model->utilidad($param);
        $this->response($response);
    }

    function resumen_valoraciones_periodo_servicios_GET()
    {

        $param = $this->get();
        $response = $this->valoracion_model->get_productos_distinctos_valorados($param);
        $data_complete = [];
        $a = 0;
        foreach ($response as $row) {

            $prm["id_servicio"] = $row["id_servicio"];
            $data_complete[$a] = $this->get_producto_por_id($prm)[0];
            $a++;
        }
        $data["servicios"] = $data_complete;
        $this->load->view("servicio/lista", $data);
    }

    function usuario_GET()
    {

        $param = $this->get();
        $response = [];
        $valoraciones = $this->valoracion_model->get_valoraciones_usuario($param);
        if (es_data($valoraciones)) {

            $response = [
                "info_valoraciones" => valorados($valoraciones, 1),
                "data" => $valoraciones
            ];
        }

        $this->response($response);
    }

    function articulo_GET()
    {

        $param = $this->get();
        $session = $this->app->session();
        $valoraciones = $this->valoracion_model->get_valoraciones_articulo($param);
        $usuario = $this->get_usuario_por_servicio($param);

        $resferencias_fotograficas = $this->referencias($param);
        $es_administrador = es_administrador($session);

        $data = [
            "servicio" => $param["id_servicio"],
            "id_usuario" => pr($usuario, "id_usuario"),
            "comentarios" => $this->valoracion_model->get_valoraciones($param),
            "numero_valoraciones" => $valoraciones,
            "respuesta_valorada" => $param["respuesta_valorada"],
            "referencia_fotografica" => $resferencias_fotograficas,
            "es_administrador" => $es_administrador,
        ];

        $data["valoraciones_fotograficas"]  =  render_articulo($data);
        $data["valoraciones_comentarios"] =  render_comentarios($data);
        $this->response($data);
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_servicio,calificacion,titulo,comentario,email,nombre")) {

            $id_servicio = $param["id_servicio"];
            $params = [
                "valoracion" => $param["calificacion"],
                "titulo" => $param["titulo"],
                "comentario" => $param["comentario"],
                "recomendaria" => $param["recomendaria"],
                "email" => $param["email"],
                "nombre" => $param["nombre"],
                "id_servicio" => $id_servicio
            ];

            if ($this->id_usuario > 0) {
                $params["id_usuario"] = $this->id_usuario;
            }

            $id_valoracion = $this->valoracion_model->insert($params, 1);
            $response["id_servicio"] = $id_servicio;
            $prm["key"] = "email";
            $prm["value"] = $param["email"];
            $response["existencia_usuario"] = $this->valida_existencia_usuario($prm);
            $this->notifica_vendedor($id_servicio);
        }
        $this->response($response);
    }
    function faker_POST(){

        $param = $this->post();
        $response = false;
        if (fx($param, "total,id_servicio")) {
            
            $response = [];

            $usuarios = $this->app->api("usuario/faker", ["total" => $param["total"]], "json", "POST");
            $experiencias_faker = $this->app->api("experiencia/index");  
            
            $total_experiencias = count($experiencias_faker);        
            $id_servicio = $param["id_servicio"];
            
            foreach($usuarios as $row){
                
                $id = $row["id"];
                $name = $row["name"];
                $email = $row["email"];

                $rand_experiencia = rand(1,($total_experiencias - 1));
                $params = [
                    "valoracion" => rand(4,5),
                    "titulo" => $experiencias_faker[$rand_experiencia]["titulo"],
                    "comentario" => $experiencias_faker[$rand_experiencia]["experiencia"],
                    "recomendaria" => 1,
                    "email" => $email,
                    "nombre" => $name,
                    "id_usuario" => $id,
                    "id_servicio" => $id_servicio
                ];
                
                $id_valoracion = $this->valoracion_model->insert($params, 1);

                if($id_valoracion > 0){
                    $params["id"] = $id_valoracion;
                    $response[] = $params;
                }                            
            }            
                
        }
        $this->response($response);

    }
    private function notifica_vendedor($id_servicio)
    {

        $sender = get_notificacion_valoracion($this->get_usuario_servicio($id_servicio), $id_servicio);
        $this->app->send_email($sender, 1);
    }

    private function referencias($param)
    {

        if (fx($param, "id_servicio")) {

            $id_servicio = $param["id_servicio"];
            return $this->app->api("referencia/servicio/", ["id_servicio" => $id_servicio]);
        }
    }

    private function get_usuario_servicio($id_servicio)
    {

        return $this->app->api("usuario/usuario_servicio", ["id_servicio" => $id_servicio]);
    }

    function valida_existencia_usuario($q)
    {

        return $this->app->api("usuario/usuario_existencia", $q);
    }

    private function get_usuario_por_servicio($q)
    {

        return $this->app->api("servicio/usuario_por_servicio", $q);
    }

    private function get_producto_por_id($q)
    {

        return $this->app->api("producto/producto_por_id", $q);
    }
}
