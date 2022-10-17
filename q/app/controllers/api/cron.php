<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Cron extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("correos");
        $this->load->library(lib_def());
    }

    function encuesta_evaluacion_servicios_GET()
    {

        /*
        $lista =  $this->get_usuarios_activos_perfil();
        $q = array('q' =>  1 );
        $api      = "cron/evaluacion_servicios";
        $response = $this->app->api( $api , $q  );

        $lista_email = $this->pagosmodel->get_lista_clientes_activos();
        $b = 0;
        foreach($lista_email as $row){

            $param["info_correo"] = $response;
            $nombre_cliente       =
            $row["nombre"] ." " .$row["apellido_paterno"] ." ".$row["apellido_materno"];
            $param["asunto"] =  "Buen día ".trim($nombre_cliente);
            $param["mensaje"] = $response;
            $correo_dirigido_a = $row["email"];
            $this->mensajeria_lead->notificacion_email($param , $correo_dirigido_a);
        }
        $this->response($response);
        */
        //$this->response($lista);
    }

    private function get_usuarios_sin_publicar_articulos($q)
    {
        $param["id_perfil"] = 20;
        $api = "usuario/sin_publicar_articulos/format/json/";
        return $this->app->api($api, $param);
    }

    function recordatorio_publicaciones_GET()
    {

        $param = $this->get();
        $response = $this->get_usuarios_sin_publicar_articulos($param);
        $a = 0;
        foreach ($response as $row) {


            $nombre = $row["nombre"];
            $email = $row["email"];
            $prm["nombre"] = $nombre;
            $prm["email"] = $email;
            $id = $row["id"];

            $url_cancelar_envio = "msj/index.php/api/emp/salir/format/html/?type=3&id=" . $id;
            $prm["url_cancelar_envio"] = get_url_request($url_cancelar_envio);
            $param["info_correo"] = $this->get_mensaje_recordatorio_publicacion($prm);
            $param["asunto"] = "Hemos tenido pocas noticias sobre ti " . $nombre;

            $a++;
        }
        $this->response($a);
    }

    private function get_mensaje_recordatorio_publicacion($param)
    {

        $this->app->api("cron/recordatorio_publicar_articulos", $param);
    }

    function recordatorio_publicar_articulos_GET()
    {

        $this->load->view(recordar_publicaciones($this->get()));
    }

    /*
    function base_promocion_GET()
    {
        $this->load->view("mensaje/mensaje_promocion");
    }
    */

    function evaluacion_servicios_GET()
    {

        $this->response(evaluacion_servicios($this->get()));

    }

    /*
    function notificacion_ganancias_afiliado_GET()
    {
        $param = $this->get();
        $data["info_usuario"] = $param;
        $this->load->view("mensaje/ganancias_afiliado", $data);
    }
    */

    function cancelacion_venta_GET()
    {

        $this->response(cancelacion_venta_vendedor(["info" => $this->get()]));
    }

    function ticket_soporte_GET()
    {
        $this->load->view(ticket_soporte($this->get()));
    }
}