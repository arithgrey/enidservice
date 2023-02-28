<?php

class Home extends CI_Controller
{
    private $id_usuario;
    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
        $this->load->helper("deseos");
    }

    function index()
    {
        $data = $this->app->session();
        $in_session = $data['in_session'];
        $param = $this->input->get();

        $id_servicio = prm_def($param, "q");

        if ($in_session && $id_servicio > 0 || $in_session && str_len($id_servicio, 1)) {

            $this->app->acceso();
            $this->usuario_deseo($id_servicio);
            $this->load_lista_deseos($data);
        } else {

            if ($id_servicio > 0 || str_len($id_servicio, 1)) {

                $this->usuario_deseo_compra($id_servicio,  1);
            } else {

                redirect(path_enid("_login"));
            }
        }
    }
    private function usuario_deseo($id_servicio, $articulos = 1)
    {


        $array_servicios  = explode(',', $id_servicio);
        foreach ($array_servicios as $id_servicio) {
            $q  = [
                "servicio" =>  $id_servicio,
                "articulos" => $articulos,
                "id_recompensa" => 0,
                "id_usuario" => $this->id_usuario,
            ];

            $this->app->api("usuario_deseo/servicio", $q, "json", "POST");
        }
    }

    private function usuario_deseo_compra($id_servicio, $articulos = 1)
    {
        $ip = $this->input->ip_address();

        $array_servicios  = explode(',', $id_servicio);
        $a = 0;
        foreach ($array_servicios as $id_servicio) {
            $q  = [
                "id_servicio" =>  $id_servicio,
                "articulos" => $articulos,
                "id_recompensa" => 0,
                "ip" => $ip
            ];

            $this->app->api("usuario_deseo_compra/index", $q, "json", "POST");
            $a++;
        }

        if ($a > 1) {
            redirect(_text("../", path_enid('lista_deseos')));
        } else {
            redirect(_text("../", path_enid('producto', $id_servicio)));
        }
    }
    private function load_lista_deseos($data)
    {


        $lista = $this->get_lista_deseos($data["id_usuario"]);
        $lista_deseo = $lista["listado"];
        $data["recompensas"] = $lista["recompensas"];
        $data["ids_usuario_deseo"] = $lista["ids_usuario_deseo"];

        $data["productos_deseados"] = $this->add_imagenes($lista_deseo);
        if (es_data($data["productos_deseados"])) {


            $data = $this->app->cssJs($data, "automatizacion");
            $data["usuario"] = $this->app->usuario($data["id_usuario"]);
            $this->app->pagina($data, productos_deseados($data, $data["productos_deseados"]), 1);
        } else {

            $this->app->pagina($data, sin_productos(), 1);
        }
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

        return $this->app->api(
            "usuario_deseo/usuario",
            [
                "id_usuario" => $id_usuario,
                "c" => 1,
            ]
        );
    }
}
