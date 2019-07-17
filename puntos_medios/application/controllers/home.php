<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("puntoencuentro");
        $this->load->library(lib_def());
    }

    function index()
    {


        $data = $this->app->session();
        $param = $this->input->post();
        $data["proceso_compra"] = 1;


        $method_request = $this->input->server('REQUEST_METHOD');
        if (
            (
                $method_request === 'POST'
                &&
                prm_def($param, "servicio", 0, 1) > 0
            )

            ||

            (
                $method_request === 'POST'
                &&
                prm_def($param, "recibo", 0, 1) > 0
            )

        ) {

            $param = $this->input->post();
            $data["tipos_puntos_encuentro"] = $this->get_tipos_puntos_encuentro($param);
            $data["punto_encuentro"] = 0;

            $data = $this->app->cssJs($data, "puntos_medios");

            $primer_registro = (prm_def($param, "recibo") == 0) ? 1 : 0;
            $data["primer_registro"] = $primer_registro;

            if ($primer_registro > 0) {

                $data += [

                    "servicio" => $param["servicio"],
                    "num_ciclos" => $param["num_ciclos"],

                ];


            } else {

                $data["recibo"] = $param["recibo"];
            }

            $this->load_vistas_punto_encuentro($param, $data);

        } else {

            redirect("../../producto/?producto=" . $this->input->get("producto"));
        }
    }

    private function load_vistas_punto_encuentro($param, $data)
    {



        $data += [
            "carro_compras" => $param["carro_compras"],
            "id_carro_compras" => $param["id_carro_compras"],
            "leneas_metro" => $this->get_lineas_metro(1, $param),
        ];

        if (prm_def($param, "avanzado") > 0 && prm_def($param, "punto_encuentro") > 0 ) {

            /*solo tomamos la hora del pedido*/
            $this->app->pagina($data, get_format_pagina_form_horario($data["recibo"], $param["punto_encuentro"]), 1);

        } else {


            $this->app->pagina($data, render_pm($data),1);

        }
    }

    private function get_lineas_metro($tipo, $param)
    {


        $q = [
            "v" => 1,
            "tipo" => $tipo,
        ];
        $id_usuario =  $this->get_usuario_por_servicio($param["servicio"]);
        if ($id_usuario >0 ){

            $q["id_usuario"] =  $id_usuario;
        }
        return $this->app->api("linea_metro/index/format/json/", $q);

    }

    private function get_tipos_puntos_encuentro($q)
    {

        return $this->app->api("tipo_punto_encuentro/index/format/json/", $q);
    }
    private  function  get_usuario_por_servicio($id_servicio){

        $usuario =  $this->app->api("servicio/usuario_por_servicio/format/json/", ["id_servicio" => $id_servicio]);
        return pr($usuario, "id_usuario");
    }
}