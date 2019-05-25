<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Valoracion extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("valoracion");
        $this->load->model("valoracion_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->principal->get_session("idusuario");
    }

    function num_GET()
    {


        $param = $this->get();
        $response = false;

        if (if_ext($param, "id_usuario,id_servicio")) {


            $id_servicio = $param["id_servicio"];
            $id_usuario = $param["id_usuario"];

            $params = ["COUNT(0)num"];
            $params_where = ["id_servicio" => $id_servicio, "id_usuario" => $id_usuario];
            $response = $this->valoracion_model->get($params, $params_where)[0]["num"];

        }
        $this->response($response);
    }

    function lectura_PUT()
    {
        $param = $this->put();
        $response = false;
        if (if_ext($param, "id_usuario")) {
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
        $id_servicio = $param["id_servicio"];
        $servicio = $this->principal->get_base_servicio($id_servicio);
        $data["servicio"] = $servicio;
        $vendedor = $this->principal->get_info_usuario($servicio[0]["id_usuario"]);
        $propietario = ($servicio[0]["id_usuario"] != $id_servicio) ? 0 : 1;
        $response = get_form_pregunta_consumidor($id_servicio, $propietario, $vendedor, $servicio);
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
        $response = crea_resumen_valoracion_comentarios($comentarios["data"], "");

        if (count($comentarios["data"]) > 0) {

            $response = hr() . div("RESEÑAS HECHAS POR OTROS CLIENTES", ["class" => 'text_resumen']) . hr() . $response;
        }
        $this->response($response);
    }

    function resumen_valoraciones_periodo_GET()
    {

        $param = $this->get();
        $comentarios = $this->valoracion_model->get_desglose_valoraciones_periodo($param);
        $data_comentarios = crea_resumen_valoracion_comentarios($comentarios["data"], "");
        if (count($comentarios["data"]) > 0) {

            $data_comentarios = "<div class='col-lg-6 col-lg-offset-3'><hr><div class='text_resumen'> RESEÑAS HECHAS POR OTROS CLIENTES </div><hr>" . $data_comentarios . "</div>";
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
        $valoraciones = $this->valoracion_model->get_valoraciones_usuario($param);
        $response = [];
        if (count($valoraciones) > 0) {
            $info_valoraciones = crea_resumen_valoracion($valoraciones, 1);

            $data["info_valoraciones"] = $info_valoraciones;
            $data["data"] = $valoraciones;
            $response = $data;
        }
        $this->response($response);

    }

    function articulo_GET()
    {

        $param = $this->get();
        $valoraciones = $this->valoracion_model->get_valoraciones_articulo($param);
        $data["servicio"] = $param["id_servicio"];
        $usuario = $this->get_usuario_por_servicio($param);
        $id_usuario = $usuario[0]["id_usuario"];
        $data["id_usuario"] = $id_usuario;
        $data["comentarios"] = $this->valoracion_model->get_valoraciones($param);
        $data["numero_valoraciones"] = $valoraciones;
        $data["respuesta_valorada"] = $param["respuesta_valorada"];
        $this->load->view("valoraciones/articulo", $data);

    }

    function valoracion_form_GET()
    {

        $param = $this->get();
        $id_servicio = $param["id_servicio"];
        $servicio = $this->principal->get_base_servicio($id_servicio);
        $extra = $param;
        $response = get_form_valoracion($servicio, $extra, $id_servicio);
        $this->response($response);
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (if_ext($param, "id_servicio,calificacion,titulo,comentario,email,nombre")) {


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

    private function notifica_vendedor($id_servicio)
    {

        $usuario = $this->get_usuario_servicio($id_servicio);
        $sender = get_notificacion_valoracion($usuario, $id_servicio);
        $this->principal->send_email_enid($sender, 1);

    }

    private function get_usuario_servicio($id_servicio)
    {

        $q["id_servicio"] = $id_servicio;
        $api = "usuario/usuario_servicio/format/json/";
        return $this->principal->api($api, $q);
    }

    function valida_existencia_usuario($q)
    {
        $api = "usuario/usuario_existencia/format/json/";
        return $this->principal->api($api, $q);
    }

    private function get_usuario_por_servicio($q)
    {

        $api = "servicio/usuario_por_servicio/format/json/";
        return $this->principal->api($api, $q);
    }

    private function get_producto_por_id($q)
    {

        $api = "producto/producto_por_id/format/json/";
        return $this->principal->api($api, $q);
    }
    /*
    private function set_visto_pregunta($q)
    {
        $api = "pregunta/visto_pregunta";
        return $this->principal->api($api, $q, "json", "PUT");

    }

     function servicios_pregunta_sin_contestar_GET()
    {

        $param      = $this->get();

        $response   = $this->valoracion_model->get_servicios_pregunta_sin_contestar($param);
        $this->response($response);

    }

    /*
    function q_up($q, $q2, $id_usuario)
    {
        return $this->update("servicio", [$q => $q2], ["idusuario" => $id_usuario]);
    }
    */

    /*
    private function q_get($params = [], $id)
    {
        return $this->get("servicio", $params, ["id_servicio" => $id]);
    }*/

    /*
    function insert($params, $return_id = 0)
    {
        $insert = $this->db->insert($tabla, $params);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }
    */
    /*
    function registro_pregunta($q){
        $api = "pregunta/index";
        return $this->principal->api( $api , $q , "json" , "POST");
    }
    function pregunta_POST(){

        $param      =  $this->post();
        $response   =  $this->registro_pregunta($param);
        $respuesta_notificacion = "";
        if($response){
            $respuesta_notificacion = $this->envia_pregunta_a_vendedor($param);
        }
        $this->response($respuesta_notificacion);

    }
    */

    /*
    function registra_respuesta($param){

      $id_usuario     =  $param["id_usuario"];
      $id_pregunta    =  $param["pregunta"];
      $respuesta      =  $param["respuesta"];
      $params         =
      ["respuesta" => $respuesta,"id_pregunta" => $id_pregunta, "id_usuario" => $id_usuario];
      $this->insert("response", $params);
      return $this->actualiza_estado_pregunta($param);
    }


    */
    /*
      function gamificacion_deseo_PUT(){

        $param    =   $this->put();
        $valor    =   (array_key_exists("valor", $param) ) ? $param["valor"] :  1;
        $response =   $this->serviciosmodel->set_gamificacion_deseo($param , 1 , $valor);
        $this->response($response);
      }
      */


}